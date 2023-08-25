<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MapelModel extends CI_Model
{
	public function getPaging(int $limit, int $start, string $search, string $order, string $order_option, int $idKelas = 0)
	{
		$query = $this->db->select("*,mapel.prakerja as prakerja")
			->from('mapel')
			->join('kelas', 'id_kelas = mapel.kelas_id');

		if ($idKelas != 0) {
			$query = $query->where('mapel.kelas_id', $idKelas);
		}

		if ($search != "") {
			$query = $query->group_start()
				->where("nama_mapel like", "%{$search}%")
				->or_where("nama_kelas like", "%{$search}%")
				->group_end();
		}

		$query = $query->order_by($order, $order_option);

		$count_all_result = count($query->get()->result_array());

		$query = $this->db->select("*,mapel.prakerja as prakerja")
			->from('mapel')
			->join('kelas', 'id_kelas = mapel.kelas_id');


		if ($idKelas != 0) {
			$query = $query->where('mapel.kelas_id', $idKelas);
		}

		if ($search != "") {
			$query = $query->group_start()
				->where("nama_mapel like", "%{$search}%")
				->or_where("nama_kelas like", "%{$search}%")
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
			"total_page"    => ceil($count_all_result / $limit)
		]);
	}

	public function getById($id)
	{
		$query = $this->db->select("*")
			->from('mapel')
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->where('id_mapel', $id)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getAllByKelas($idKelas)
	{
		$query = $this->db->select("*")
			->from('mapel')
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->where('mapel.kelas_id', $idKelas)
			->order_by('nama_kelas', "DESC")
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getAll()
	{
		$query = $this->db->select("*")
			->from('mapel')
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->order_by('nama_kelas', "DESC")
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
			->from('mapel')
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->where('meta_link_mapel', $meta)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getListhasil($id = 0)
	{
		$query = $this->db->select("*")
			->from('mapel_listhasil')
			->where('mapel_id', $id)
			->order_by('urutan_mapel_listhasil', "DESC")
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function saveData($data)
	{
		return $this->db->insert('mapel', $data);
	}

	public function updateData($id, $data)
	{
		$this->db->where('id_mapel', $id);
		return $this->db->update('mapel', $data);
	}

	public function deleteData($id)
	{
		$this->db->where('id_mapel', $id);
		return $this->db->delete('mapel');
	}

	public function getMetaLink(string $title, $id = null)
	{
		$slug = url_title($title);
		$slug = strtolower($slug);
		$i = 0;
		$params = array();
		$params["meta_link_mapel"] = $slug;

		if ($id) {
			$params["id_mapel !="] = $id;
		}

		while ($this->db->where($params)->get('mapel')->num_rows()) {
			if (!preg_match('/-{1}[0-9]+$/', $slug)) {
				$slug .= '-' . ++$i;
			} else {
				$slug = preg_replace('/[0-9]+$/', ++$i, $slug);
			}
			$params["meta_link_mapel"] = $slug;
		}

		return $slug;
	}

	public function getMapelAmpu($idInstruktur)
	{
		$query = $this->db->select("*")
			->from('mapel')
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->order_by('nama_kelas', "DESC")
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

}
