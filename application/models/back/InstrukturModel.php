<?php
defined('BASEPATH') or exit('No direct script access allowed');

class InstrukturModel extends CI_Model
{


	public function getPaging(int $limit, int $start, string $search, string $order, string $order_option)
	{
		$query = $this->db->select("*")
			->from('user')
			->where("level_user", "instruktur");

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
			->where("level_user", "instruktur");


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

	public function getMapelByInstruktur(int $limit, int $start, string $search, string $order, string $order_option, int $idInstruktur)
	{
		$query = $this->db->select("*")
			->from('instruktur_mapel')
			->join('mapel', 'id_mapel = instruktur_mapel.mapel_id')
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->where("user_id", $idInstruktur);

		if ($search != "") {
			$query = $query->group_start()
				->where("nama_mapel like", "%{$search}%")
				->group_end();
		}

		$query = $query->order_by($order, $order_option);

		$count_all_result = count($query->get()->result_array());

		$query = $this->db->select("*")
			->from('instruktur_mapel')
			->join('mapel', 'id_mapel = instruktur_mapel.mapel_id')
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->where("user_id", $idInstruktur);


		if ($search != "") {
			$query = $query->group_start()
				->where("nama_mapel like", "%{$search}%")
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
			->where("level_user", "instruktur")
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

	public function deleteIntrukturMapel($id)
	{
		$this->db->where('user_id', $id);
		return $this->db->delete('instruktur_mapel');
	}

	public function getAll()
	{
		$query = $this->db->select("*")
			->from('user')
			->where("level_user", "instruktur")
			->order_by('nama_user', "DESC")
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getAllMapelByInstruktur($idInstruktur)
	{
		$query = $this->db->select("*")
			->from('instruktur_mapel')
			->join("mapel", "id_mapel = instruktur_mapel.mapel_id")
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->where("user_id = {$idInstruktur}")
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getAllKelasByInstruktur($idInstruktur)
	{
		$query = $this->db->select("*")
			->from('instruktur_mapel')
			->join("mapel", "id_mapel = instruktur_mapel.mapel_id")
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->where("user_id = {$idInstruktur}")
			->group_by("kelas_id")
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}


	public function deleteMapelByInstruktur($idInstruktur)
	{

		$this->db->where('user_id', $idInstruktur);

		return $this->db->delete('instruktur_mapel');
	}

	public function insertMapelByInstruktur($data)
	{

		return $this->db->insert('instruktur_mapel', $data);
	}


	public function getAllLogSiswa($idMapel)
	{

		$query = $this->db->select("*,log_praktek.created_at as waktu_upload, count(*) as jumlah_upload")
			->from('log_praktek')
			->join("materi", "id_materi = log_praktek.materi_id")
			->join("bab", "id_bab = materi.bab_id")
			->join("mapel", "id_mapel = bab.mapel_id")
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->join('user', 'id_user = log_praktek.user_id')
			->where("id_mapel IN ({$idMapel})")
			->where("status_baca_instruktur = 0")
			->order_by("log_praktek.created_at DESC")
			->group_by("materi_id,user_id")
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getAllMapel($idUser)
	{
		$query = $this->db->select("*")
			->from("instruktur_mapel")
			->join("mapel", "id_mapel = mapel_id")
			->where("user_id", $idUser)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}
}
