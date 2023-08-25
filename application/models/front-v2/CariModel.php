<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CariModel extends CI_Model
{
	public function getPaging(int $limit, int $start, string $search, string $order, string $order_option, int $idKelas = 0)
	{
		$select = "";
		if ($this->session->siswaData["id_user"] != NULL) {
			$select = ", (SELECT progress from user_mapel_progress WHERE user_id = {$_SESSION['siswaData']['id_user']} AND mapel_id = id_mapel) as progress";
		}
		$query = $this->db->select("kelas.nama_kelas,kelas.meta_link_kelas, 
									mapel.*,user.nama_user as nama_instruktur, 
									user.gambar_user, 
									user.biodata" . $select)
			->from('mapel')
			->join("instruktur_mapel", "mapel_id = id_mapel")
			->join("user", "user_id = id_user")
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->group_by('id_mapel')
			->where("status = 1");

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


		$select = "";
		if ($this->session->userdata("id_user")) {
			$select = ", (SELECT progress from user_mapel_progress WHERE user_id = {$_SESSION['siswaData']['id_user']} AND mapel_id = id_mapel) as progress";
		}
		$query = $this->db->select("kelas.nama_kelas,kelas.meta_link_kelas, 
									mapel.*,user.nama_user as nama_instruktur,
									user.gambar_user, 
									user.biodata" . $select)
			->from('mapel')
			->join("instruktur_mapel", "mapel_id = id_mapel")
			->join("user", "user_id = id_user")
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->group_by('id_mapel')
			->where("status = 1");

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

}
