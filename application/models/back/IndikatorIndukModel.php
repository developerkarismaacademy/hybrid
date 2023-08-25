<?php
defined('BASEPATH') or exit('No direct script access allowed');

class IndikatorIndukModel extends CI_Model
{
	public function getPaging(int $limit, int $start, string $search, string $order, string $order_option, int $idKompetensi)
	{
		$query = $this->db->select("*")
			->from('indikator_induk')
			->join('kompetensi', 'id_kompetensi = indikator_induk.kompetensi_id')
			->join('mapel', 'id_mapel = kompetensi.mapel_id')
			->join('kelas', 'id_kelas = mapel.kelas_id');

		if ($idKompetensi != 0) {
			$query = $query->where('indikator_induk.kompetensi_id', $idKompetensi);
		}

		if ($search != "") {
			$query = $query->group_start()
				->where("indikator_induk like", "%{$search}%")
				->group_end();
		}

		$query = $query->order_by($order, $order_option);

		$count_all_result = count($query->get()->result_array());

		$query = $this->db->select("*")
			->from('indikator_induk')
			->join('kompetensi', 'id_kompetensi = indikator_induk.kompetensi_id')
			->join('mapel', 'id_mapel = kompetensi.mapel_id')
			->join('kelas', 'id_kelas = mapel.kelas_id');

		if ($idKompetensi != 0) {
			$query = $query->where('indikator_induk.kompetensi_id', $idKompetensi);
		}

		if ($search != "") {
			$query = $query->group_start()
				->where("indikator_induk like", "%{$search}%")
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
			->from('indikator_induk')
			->where('id_indikator_induk', $id)
			->join('kompetensi', 'id_kompetensi = indikator_induk.kompetensi_id')
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
			->from('indikator_induk')
			->where('meta_link_indikator_induk', $meta)
			->join('kompetensi', 'id_kompetensi = indikator_induk.kompetensi_id')
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
		return $this->db->insert('indikator_induk', $data);
	}

	public function updateData($id, $data)
	{
		$this->db->where('id_indikator_induk', $id);

		return $this->db->update('indikator_induk', $data);
	}

	public function deleteData($id)
	{
		$this->db->where('id_indikator_induk', $id);

		return $this->db->delete('indikator_induk');
	}

	public function getAll()
	{
		$query = $this->db->select("*")
			->from('indikator_induk')
			->order_by('indikator_induk', "DESC")
			->join('kompetensi', 'id_kompetensi = indikator_induk.kompetensi_id')
			->join('mapel', 'id_mapel = kompetensi.mapel_id')
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getAllByKompetensi($idKompetensi = 0)
	{
		$query = $this->db->select("*")
			->from('indikator_induk')
			->order_by('indikator_induk', "ASC")
			->join('kompetensi', 'id_kompetensi = indikator_induk.kompetensi_id')
			->join('mapel', 'id_mapel = kompetensi.mapel_id')
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->where('kompetensi.id_kompetensi', $idKompetensi)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}
}
