<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KompetensiModel extends CI_Model
{
	public function getPaging(int $limit, int $start, string $search, string $order, string $order_option, int $idMapel)
	{
		$query = $this->db->select("*")
			->from('kompetensi')
			->join('mapel', 'id_mapel = kompetensi.mapel_id')
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->join('bab', 'bab_id = bab.id_bab', 'left');

		if ($idMapel != 0) {
			$query = $query->where('kompetensi.mapel_id', $idMapel);
		}

		if ($search != "") {
			$query = $query->group_start()
				->where("kompetensi like", "%{$search}%")
				->group_end();
		}

		$query = $query->order_by($order, $order_option);

		$count_all_result = count($query->get()->result_array());

		$query = $this->db->select("*")
			->from('kompetensi')
			->join('mapel', 'id_mapel = kompetensi.mapel_id')
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->join('bab', 'bab_id = bab.id_bab', 'left');

		if ($idMapel != 0) {
			$query = $query->where('kompetensi.mapel_id', $idMapel);
		}

		if ($search != "") {
			$query = $query->group_start()
				->where("kompetensi like", "%{$search}%")
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
			->from('kompetensi')
			->where('id_kompetensi', $id)
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
			->from('kompetensi')
			->where('meta_link_kompetensi', $meta)
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
		return $this->db->insert('kompetensi', $data);
	}

	public function updateData($id, $data)
	{
		$this->db->where('id_kompetensi', $id);

		return $this->db->update('kompetensi', $data);
	}

	public function deleteData($id)
	{
		$this->db->where('id_kompetensi', $id);

		return $this->db->delete('kompetensi');
	}

	public function getAll()
	{
		$query = $this->db->select("*")
			->from('kompetensi')
			->order_by('kompetensi', "DESC")
			->join('mapel', 'id_mapel = kompetensi.mapel_id')
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getAllByMapel($idMapel = 0)
	{
		$query = $this->db->select("*")
			->from('kompetensi')
			->order_by('urutan_kompetensi', "ASC")
			->join('mapel', 'id_mapel = kompetensi.mapel_id')
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->join('bab', 'bab.mapel_id = mapel.id_mapel')
			->group_by('kompetensi.id_kompetensi')
			->where('kompetensi.mapel_id', $idMapel)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}
}
