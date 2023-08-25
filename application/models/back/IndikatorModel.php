<?php
defined('BASEPATH') or exit('No direct script access allowed');

class IndikatorModel extends CI_Model
{
	public function getPaging(int $limit, int $start, string $search, string $order, string $order_option, int $idKompetensi, int $idIndikatorInduk)
	{
		$query = $this->db->select("*")
			->from('indikator')
			->join('kompetensi', 'id_kompetensi = indikator.kompetensi_id')
			->join('indikator_induk', 'id_indikator_induk = indikator.indikator_induk_id')
			->join('mapel', 'id_mapel = kompetensi.mapel_id')
			->join('kelas', 'id_kelas = mapel.kelas_id');

		if ($idKompetensi != 0) {
			$query = $query->where('indikator.kompetensi_id', $idKompetensi);
		}

		if ($idIndikatorInduk != 0) {
			$query = $query->where('indikator.indikator_induk_id', $idIndikatorInduk);
		}

		if ($search != "") {
			$query = $query->group_start()
				->where("indikator like", "%{$search}%")
				->group_end();
		}

		$query = $query->order_by($order, $order_option);

		$count_all_result = count($query->get()->result_array());

		$query = $this->db->select("*")
			->from('indikator')
			->join('kompetensi', 'id_kompetensi = indikator.kompetensi_id')
			->join('indikator_induk', 'id_indikator_induk = indikator.indikator_induk_id')
			->join('mapel', 'id_mapel = kompetensi.mapel_id')
			->join('kelas', 'id_kelas = mapel.kelas_id');

		if ($idKompetensi != 0) {
			$query = $query->where('indikator.kompetensi_id', $idKompetensi);
		}

		if ($idIndikatorInduk != 0) {
			$query = $query->where('indikator.indikator_induk_id', $idIndikatorInduk);
		}

		if ($search != "") {
			$query = $query->group_start()
				->where("indikator like", "%{$search}%")
				->group_end();
		}

		$query = $query->order_by($order, $order_option);

		$queryLimit = $query->limit($limit, $start)
			->get()
			->result_array();

		return ([
			"total"         => $count_all_result,
			"data"          => $queryLimit,
			"total_in_page" => count($queryLimit),
			"total_page"    => ceil($count_all_result / $limit),
		]);
	}

	public function getById($id)
	{
		$query = $this->db->select("*")
			->from('indikator')
			->where('id_indikator', $id)
			->join('kompetensi', 'id_kompetensi = indikator.kompetensi_id')
			->join('indikator_induk', 'id_indikator_induk = indikator.indikator_induk_id')
			->join('mapel', 'id_mapel = kompetensi.mapel_id')
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getByMeta($meta)
	{
		$query = $this->db->select("*")
			->from('indikator')
			->where('meta_link_indikator', $meta)
			->join('kompetensi', 'id_kompetensi = indikator.kompetensi_id')
			->join('indikator_induk', 'id_indikator_induk = indikator.indikator_induk_id')
			->join('mapel', 'id_mapel = kompetensi.mapel_id')
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function saveData($data)
	{
		return $this->db->insert('indikator', $data);
	}

	public function updateData($id, $data)
	{
		$this->db->where('id_indikator', $id);

		return $this->db->update('indikator', $data);
	}

	public function deleteData($id)
	{
		$this->db->where('id_indikator', $id);

		return $this->db->delete('indikator');
	}

	public function getAll()
	{
		$query = $this->db->select("*")
			->from('indikator')
			->order_by('indikator', "DESC")
			->join('kompetensi', 'id_kompetensi = indikator.kompetensi_id')
			->join('indikator_induk', 'id_indikator_induk = indikator.indikator_induk_id')
			->join('mapel', 'id_mapel = kompetensi.mapel_id')
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}


	public function getAllByKompetensiAndIndikatorInduk($idKompetensi = 0, $idIndikatorInduk = 0)
	{
		$query = $this->db->select("*")
			->from('indikator')
			->order_by('indikator', "DESC")
			->join('kompetensi', 'id_kompetensi = indikator.kompetensi_id')
			->join('indikator_induk', 'id_indikator_induk = indikator.indikator_induk_id')
			->join('mapel', 'id_mapel = kompetensi.mapel_id')
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->where('kompetensi.id_kompetensi', $idKompetensi)
			->where('indikator_induk.id_indikator_induk', $idIndikatorInduk)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getAllJoinJawabanByKompetensiAndIndikatorInduk($idKompetensi = 0, $idIndikatorInduk = 0, $idUser = 0)
	{
		$query = $this->db->select("*")
			->from('indikator')
			->order_by('indikator', "ASC")
			->join('kompetensi', 'id_kompetensi = indikator.kompetensi_id')
			->join('indikator_induk', 'id_indikator_induk = indikator.indikator_induk_id')
			->join('mapel', 'id_mapel = kompetensi.mapel_id')
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->join("nilai_indikator", 'indikator.id_indikator = nilai_indikator.indikator_id AND nilai_indikator.user_id = ' . $idUser, 'left outer')
			->where('kompetensi.id_kompetensi', $idKompetensi)
			->where('indikator_induk.id_indikator_induk', $idIndikatorInduk)
			->group_by('indikator.id_indikator')
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}
}
