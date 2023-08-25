<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProgressModel extends CI_Model
{

	public function getMapelByInstruktur(int $limit, int $start, string $search, string $order, string $order_option, int $idInstruktur)
	{
		$query = $this->db->select("*,
									id_mapel AS mapel_id_utama,
									(
									SELECT
										COUNT(*) 
									FROM
										log_praktek,
										materi,
										bab,
										mapel 
									WHERE
										id_mapel = mapel_id_utama 
										AND mapel_id = mapel_id_utama 
										AND materi_id = id_materi 
										AND bab_id = id_bab 
										AND status_baca_instruktur = 0 
									GROUP BY
											mapel_id 
									) AS jml_notif ")
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

		$query = $this->db->select("*,
									id_mapel AS mapel_id_utama,
									(
									SELECT
										COUNT(*) 
									FROM
										log_praktek,
										materi,
										bab,
										mapel 
									WHERE
										id_mapel = mapel_id_utama 
										AND mapel_id = mapel_id_utama 
										AND materi_id = id_materi 
										AND bab_id = id_bab 
										AND status_baca_instruktur = 0 
									GROUP BY
											mapel_id 
									) AS jml_notif ")
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


	public function updateRaportData($id, $data)
	{
		$this->db->where($id);
		return $this->db->update('user_mapel_progress', $data);
	}


}
