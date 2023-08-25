<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DiskusiModel extends CI_Model
{
	public function getPaging(int $limit, int $start, string $search, string $order, string $order_option, $id)
	{
		$columnDiskusi = $this->db->list_fields('diskusi');
		foreach ($columnDiskusi as &$v) {
			$v = "diskusi." . $v;
		}
		$columnDiskusi = implode(", ", $columnDiskusi);
		$columnUser = ", user.nama_user, user.gambar_user, user.level_user";

		$equalUser = "";
		if (isset($_SESSION['siswaData']['id_user'])) {
			$equalUser = ", (CASE WHEN diskusi.user_id = {$_SESSION['siswaData']['id_user']} THEN 1 ELSE 0 END) AS is_user";
		}
		/*-------------------*/
		$query = $this->db->select($columnDiskusi . $columnUser . $equalUser)
			->from('diskusi')
			->join("bab", "diskusi.bab_id = bab.id_bab", "left")
			->join("materi", "diskusi.materi_id = materi.id_materi", "left")
			->join('mapel', 'diskusi.mapel_id = mapel.id_mapel')
			->join('user', 'diskusi.user_id = user.id_user');

		foreach ($id as $key => $val) {
			if ($val != "" && $val != 0)
				$query = $query->where('diskusi.' . $key, $val);
		}

		$query = $query->order_by("tipe", "ASC")
			->order_by("diskusi_id", "ASC");

		$count_all_result = count($query->get()->result_array());

		$query = $this->db->select($columnDiskusi . $columnUser . $equalUser)
			->from('diskusi')
			->join("bab", "diskusi.bab_id = bab.id_bab", "left")
			->join("materi", "diskusi.materi_id = materi.id_materi", "left")
			->join('mapel', 'diskusi.mapel_id = mapel.id_mapel')
			->join('user', 'diskusi.user_id = user.id_user');
		foreach ($id as $key => $val) {
			if ($val != "" && $val != 0)
				$query = $query->where('diskusi.' . $key, $val);
		}


		$query = $query->order_by("tipe", "ASC")
			->order_by("diskusi_id", "ASC");

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
		$columnDiskusi = $this->db->list_fields('diskusi');
		foreach ($columnDiskusi as &$v) {
			$v = "diskusi." . $v;
		}
		$columnDiskusi = implode(", ", $columnDiskusi);
		$columnUser = ", user.nama_user, user.gambar_user, user.level_user";

		$equalUser = "";
		if (isset($_SESSION['siswaData']['id_user'])) {
			$equalUser = ", (CASE WHEN diskusi.user_id = {$_SESSION['siswaData']['id_user']} THEN 1 ELSE 0 END) AS is_user";
		}
		/*-------------------*/
		$query = $this->db->select($columnDiskusi . $columnUser . $equalUser)
			->from('diskusi')
			->join("bab", "diskusi.bab_id = bab.id_bab", "left")
			->join("materi", "diskusi.materi_id = materi.id_materi", "left")
			->join('mapel', 'diskusi.mapel_id = mapel.id_mapel')
			->join('user', 'diskusi.user_id = user.id_user');
		if (is_array($id)) {
			foreach ($id as $key => $val) {
				$query = $query->where('diskusi.' . $key, $val);
			}
		} else {
			$query = $query->where('diskusi.id_diskusi', $id);
		}

		$query = $query->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function saveData($data)
	{
		return $this->db->insert('diskusi', $data);
	}

	public function updateData($id, $data)
	{
		$this->db->where('id_diskusi', $id);

		return $this->db->update('diskusi', $data);
	}

	public function deleteData($id)
	{
		$query = $this->db->select("is_deleted")
			->from('diskusi')
			->where('id_diskusi', $id)
			->get()
			->result_array();

		$data["is_deleted"] = ($query[0]['is_deleted'] != 1) ? 1 : 0;
		$this->db->where('id_diskusi', $id);

		return $this->db->update('diskusi', $data);
	}

}
