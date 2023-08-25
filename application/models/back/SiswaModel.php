<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SiswaModel extends CI_Model
{
	public function getPagingByMapel(int $limit, int $start, string $search, string $order, string $order_option, int $idMapel)
	{
		$query = $this->db->select("*")
			->from("user_mapel")
			->join("user", "id_user = user_mapel.user_id")
			->join("user_mapel_progress", "user.id_user = user_mapel_progress.user_id")
			->group_by('user.id_user')
			->where("user_mapel.mapel_id = {$idMapel}");

		if ($search != "") {
			$query = $query->group_start()
				->where("username like", "%{$search}%")
				->or_where("nama_user like", "%{$search}%")
				->or_where("email_user like", "%{$search}%")
				->group_end();
		}

		// ->from("user_mapel_progress")
		// ->join("user_mapel", "user_mapel.user_id = user_mapel_progress.user_id")
		// ->join("user", "user.id_user = user_mapel_progress.user_id")
		// ->group_by('id_user')
		// ->where("user_mapel_progress.mapel_id = {$idMapel}");

		$query = $query->order_by($order, $order_option);

		$count_all_result = count($query->get()->result_array());

		$query = $this->db->select("*")
			->from("user_mapel")
			->join("user", "id_user = user_mapel.user_id")
			->join("user_mapel_progress", "user.id_user = user_mapel_progress.user_id")
			->group_by('user.id_user')
			->where("user_mapel.mapel_id = {$idMapel}");

		if ($search != "") {
			$query = $query->group_start()
				->where("username like", "%{$search}%")
				->or_where("nama_user like", "%{$search}%")
				->or_where("email_user like", "%{$search}%")
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

	public function getPaging(int $limit, int $start, string $search, string $order, string $order_option)
	{
		$query = $this->db->select("*")
			->from('user')
			->where("level_user", "siswa");

		if ($search != "") {
			$query = $query->group_start()
				->where("username like", "%{$search}%")
				->or_where("nama_user like", "%{$search}%")
				->or_where("email_user like", "%{$search}%")
				->group_end();
		}

		$query = $query->order_by($order, $order_option);

		$count_all_result = count($query->get()->result_array());

		$query = $this->db->select("*")
			->from('user')
			->where("level_user", "siswa");


		if ($search != "") {
			$query = $query->group_start()
				->where("username like", "%{$search}%")
				->or_where("nama_user like", "%{$search}%")
				->or_where("email_user like", "%{$search}%")
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
			->from('user')
			->where("level_user", "siswa")
			->where("id_user", $id)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function saveData($data)
	{
		return $this->db->insert('user', $data);
	}

	public function updateData($id, $data)
	{
		$this->db->where('id_user', $id);

		return $this->db->update('user', $data);
	}

	public function deleteData($id)
	{
		$this->db->where('id_user', $id);

		return $this->db->delete('user');
	}

	public function getAll()
	{
		$query = $this->db->select("*")
			->from('user')
			->where("level_user", "siswa")
			->order_by('nama_user', "ASC")
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getAllMapelByUser($idUser)
	{
		$query = $this->db->select("*")
			->from('user_mapel')
			->join("mapel", "id_mapel = user_mapel.mapel_id")
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->where("user_id = {$idUser}")
			->order_by('user_mapel.created_at', "DESC")
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getAllSiswaByMapelIN($idMapel)
	{
		$query = $this->db->select("*")
			->from('user_mapel')
			->join("user", "id_user = user_mapel.user_id")
			->join("mapel", "id_mapel = user_mapel.mapel_id")
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->where("mapel_id IN ({$idMapel})")
			->order_by('user_mapel.created_at', "DESC")
			->group_by('user_mapel.user_id')
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}
}
