<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KelasModel extends CI_Model
{
	public function getPaging(int $limit, int $start, string $search, string $order, string $order_option)
	{
		$query = $this->db->select("*")
			->from('kelas');

		if ($search != "") {
			$query = $query->group_start()
				->where("nama_kelas like", "%{$search}%")
				->group_end();
		}

		$query = $query->order_by($order, $order_option);

		$count_all_result = count($query->get()->result_array());

		$query = $this->db->select("*")
			->from('kelas');


		if ($search != "") {
			$query = $query->group_start()
				->where("nama_kelas like", "%{$search}%")
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
			->from('kelas')
			->where('id_kelas', $id)
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
			->from('kelas')
			->where('meta_link_kelas', $meta)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function saveData($data)
	{
		return $this->db->insert('kelas', $data);
	}

	public function updateData($id, $data)
	{
		$this->db->where('id_kelas', $id);

		return $this->db->update('kelas', $data);
	}

	public function deleteData($id)
	{
		$this->db->where('id_kelas', $id);

		return $this->db->delete('kelas');
	}

	public function getAll()
	{
		$query = $this->db->select("*")
			->from('kelas')
			->order_by('nama_kelas', "DESC")
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getMetaLink(string $title, $id = null)
	{
		$slug = url_title($title);
		$slug = strtolower($slug);
		$i = 0;
		$params = array();
		$params["meta_link_kelas"] = $slug;

		if ($id) {
			$params["id_kelas !="] = $id;
		}

		while ($this->db->where($params)->get('kelas')->num_rows()) {
			if (!preg_match('/-{1}[0-9]+$/', $slug)) {
				$slug .= '-' . ++$i;
			} else {
				$slug = preg_replace('/[0-9]+$/', ++$i, $slug);
			}
			$params["meta_link_kelas"] = $slug;
		}

		return $slug;
	}

}
