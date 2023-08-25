<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MapelModel extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function getAllMapel($where = "", string $order_column = "created_at", string $order_mode = "DESC", int $limit = 0, int $start = 0)
	{
		$select = "";
		if ($this->session->userdata("siswaData") != NULL) {
			$select = ", (SELECT progress from user_mapel_progress WHERE user_id = {$_SESSION['siswaData']['id_user']} AND mapel_id = id_mapel) as progress";
		}

		$query = $this->db->select("kelas.nama_kelas,kelas.meta_link_kelas, 
									mapel.*,user.nama_user as nama_instruktur,user.tanda_tangan as tanda_tangan_instruktur,
									user.gambar_user, 
                                    user.biodata
                                    {$select}")
			->from('mapel')
			->join("instruktur_mapel", "mapel_id = id_mapel", 'left')
			->join("user", "user_id = id_user", "left")
			->join('kelas', 'id_kelas = mapel.kelas_id');

		if ($where != "") {
			if (is_array($where)) {
				if ($where["LIKE"])
					$query = $query->like($where["LIKE"]["col"], $where["LIKE"]["val"], 'both');
			} else {
				$query = $query->where($where);
			}
		}

		$query = $query->where("status = 1");

		if ($order_column != "" && $order_mode == "") {
			$query = $query->order_by($order_column);
		} elseif ($order_column != "" && $order_mode != "") {
			$query = $query->order_by($order_column, $order_mode);
		}

		$query = $query->group_by("mapel_id");

		if ($limit > 0 && $start <= 0) {
			$query = $query->limit($limit);
		} elseif ($limit > 0 && $start > 0) {
			$query = $query->limit($limit, $start);
		}

		$query = $query->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getAllMapelPrakerja($where = "", string $order_column = "created_at", string $order_mode = "DESC", int $limit = 0, int $start = 0)
	{
		$select = "";
		if ($this->session->userdata("siswaData") != NULL) {
			$select = ", (SELECT progress from user_mapel_progress WHERE user_id = {$_SESSION['siswaData']['id_user']} AND mapel_id = id_mapel) as progress";
		}

		$query = $this->db->select("kelas.nama_kelas,kelas.meta_link_kelas, 
									mapel.*
                                    {$select}")
			->from('mapel')
			->join('kelas', 'id_kelas = mapel.kelas_id');

		if ($where != "") {
			if (is_array($where)) {
				if ($where["LIKE"])
					$query = $query->like($where["LIKE"]["col"], $where["LIKE"]["val"], 'both');
			} else {
				$query = $query->where($where);
			}
		}

		$query = $query->where("status = 1");

		if ($order_column != "" && $order_mode == "") {
			$query = $query->order_by($order_column);
		} elseif ($order_column != "" && $order_mode != "") {
			$query = $query->order_by($order_column, $order_mode);
		}


		if ($limit > 0 && $start <= 0) {
			$query = $query->limit($limit);
		} elseif ($limit > 0 && $start > 0) {
			$query = $query->limit($limit, $start);
		}

		$query = $query->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getTotalMapel($id_kelas)
	{
		$this->db->where('kelas_id', $id_kelas);
		$this->db->from('mapel');
		$count = $this->db->count_all_results();

		return $count;
	}

	public function getPagingUlasan(string $where = "", string $order_column = "created_at", string $order_mode = "DESC", int $limit = 5, int $start = 0)
	{
		$query = $this->db->select("*")
			->from('rating')
			->join("user", "id_user = user_id")
			->join("mapel", "id_mapel = mapel_id");

		if ($where != "") {
			$query = $query->where($where);
		}

		if ($limit > 0 && $start <= 0) {
			$query = $query->limit($limit);
		} elseif ($limit > 0 && $start > 0) {
			$query = $query->limit($limit, $start);
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

	public function getAllUlasan(string $where = "", string $order_column = "rating.created_at", string $order_mode = "ASC")
	{
		$query = $this->db->select("*")
			->from('rating')
			->join("user", "id_user = user_id")
			->join("mapel", "id_mapel = mapel_id");

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

	public function likeMapel($keyword, $where = "")
	{
		$query = $this->db->select("*")
			->from('mapel')
			->like('nama_mapel', $keyword)
			->get()
			->result_array();
		if ($where != "") {
			$query = $this->db->where($where);
		}

		return ([
			"data"  => $query,
			"total" => count($query),
		]);

	}

	public function getMapel()
	{
		$query = $this->db->select("*")
			->from('mapel')
			->get()
			->result_array();
		return ([
			"data"  => $query,
			"total" => count($query),
		]);

	}

	public function updateProgress($idMapel = 0, $progress = 0)
	{
		$query = $this->db->select("*")
			->from('user_mapel_progress')
			->where("user_id = {$_SESSION['siswaData']['id_user']} AND mapel_id = {$idMapel}")
			->get()
			->result_array();

		if (count($query) > 0) {
			$this->db->where("user_id = {$_SESSION['siswaData']['id_user']} AND mapel_id = {$idMapel}");

			return $this->db->update('user_mapel_progress', ["progress" => $progress]);
		} else {
			return $this->db->insert('user_mapel_progress', ["user_id" => $_SESSION['siswaData']['id_user'], "mapel_id" => $idMapel, "progress" => $progress]);
		}
	}


	public function getAllKompetensiByMapelId($mapel_id = 0)
	{
		$query = $this->db->select("*")
			->from('mapel')
			->where("mapel_id", $mapel_id)
			->get()
			->result_array();
		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}
}
