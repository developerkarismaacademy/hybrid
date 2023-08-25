<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UlasanModel extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function getAllUlasan(string $where = "", string $order_column = "created_at", string $order_mode = "ASC")
	{
		$query = $this->db->select("*")
			->join("user", "id_user = user_id")
			->from('rating');

		if ($where != "") {
			$query = $query->where($where);
		}

		if ($order_column != "" && $order_mode == "") {
			$query = $query->order_by($order_column);
		} elseif ($order_column != "" && $order_mode != "") {
			$query = $query->order_by($order_column, $order_mode);
		}

		$query = $query->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getAllTestimoni(int $limit = 3)
	{
		$where = "gambar_testimoni != '' AND LENGTH(isi_testimoni) <= 300";
		$query = $this->db->select("*")
			->from('testimoni')
			->join('kelas as k', 'testimoni.kelas_testimoni = k.nama_kelas', 'left')
			->order_by('id_testimoni', 'RANDOM')
			->where($where)
			->limit($limit, 0);

		$query = $query->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}


	public function getPaging(int $limit, int $start, string $search, string $order, string $order_option, int $idMapel = 0)
	{
		$query = $this->db->select("*")
			->from('rating')
			->join('user', "id_user = rating.user_id");

		if ($idMapel != 0) {
			$query = $query->where('rating.mapel_id', $idMapel);
		}

		if ($search != "") {
			$query = $query->group_start()
				->where("rating like", "%{$search}%")
				->or_where("ulasan like", "%{$search}%")
				->or_where("nama_user like", "%{$search}%")
				->group_end();
		}

		$query = $query->order_by($order, $order_option);

		$count_all_result = count($query->get()->result_array());

		$query = $this->db->select("*")
			->from('rating')
			->join('user', "id_user = rating.user_id");


		if ($idMapel != 0) {
			$query = $query->where('mapel_id', $idMapel);
		}


		if ($search != "") {
			$query = $query->group_start()
				->where("rating like", "%{$search}%")
				->or_where("ulasan like", "%{$search}%")
				->or_where("nama_user like", "%{$search}%")
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

	public function getById($user_id, $mapel_id)
	{
		$query = $this->db->select("*")
			->from('rating')
			->join('user', "id_user = rating.user_id")
			->where("user_id", $user_id)
			->where("mapel_id", $mapel_id)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getByIdMapel(int $id)
	{
		$query = $this->db->select("*")
			->from('rating')
			->join('user', "id_user = rating.user_id")
			->where("mapel_id", $id)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getByUlasan(int $user_id, int $mapel_id)
	{
		$query = $this->db->select("*")
			->from('rating')
			->where("user_id", $user_id)
			->where("mapel_id", $mapel_id)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}


	public function getMetaKelas(int $id)
	{
		$query = $this->db->select("*")
			->from('rating')
			->where('id_kelas', $id)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}


	public function saveData($data)
	{
		return $this->db->insert('rating', $data);
	}

	public function updateData($id, $data)
	{
		$this->db->where('user_id', $id[0]);
		$this->db->where('mapel_id', $id[1]);

		return $this->db->update('rating', $data);
	}

	public function deleteData($id)
	{
		$this->db->where('user_id', $id[0]);
		$this->db->where('mapel_id', $id[1]);

		return $this->db->delete('rating');
	}
}
