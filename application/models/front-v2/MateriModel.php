<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MateriModel extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function getAllMateri(string $where = "", string $order_column = "urutan_materi", string $order_mode = "ASC")
	{
		$query = $this->db->select("*,(SELECT COUNT(*) FROM soal WHERE materi_id = id_materi) as jml_soal")
			->from('materi');

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

	public function getAllMateriWithLog(string $where = "", string $order_column = "urutan_materi", string $order_mode = "ASC", string $akses = "user")
	{
		//NEED DELETE NILAI UJIAN PRAKTEK AFTER ADDING COLUMN
		// Delete this note if already added
		$id_user = isset($_SESSION["raporIdUser"]) ? $_SESSION["raporIdUser"] : $_SESSION['siswaData']['id_user'];
		$query = $this->db->select("*,
		(SELECT COUNT(*) FROM soal WHERE materi_id = id_materi) as jml_soal,
		(SELECT COUNT(*) FROM log_baca WHERE materi_id = id_materi AND user_id = {$id_user} GROUP BY materi_id ORDER BY created_at DESC) as log_baca,
		(SELECT COUNT(*) FROM log_praktek WHERE materi_id = id_materi AND user_id = {$id_user} GROUP BY materi_id ORDER BY created_at DESC) as log_praktek,
		(SELECT COUNT(*) FROM log_ujian WHERE materi_id = id_materi AND user_id = {$id_user} AND (end_time IS NOT NULL OR retake_log_ujian > 0)  GROUP BY materi_id ORDER BY end_time DESC) as log_ujian,
        (SELECT nilai FROM log_ujian WHERE materi_id = id_materi AND user_id = {$id_user} AND end_time IS NOT NULL GROUP BY materi_id ORDER BY end_time DESC) as nilai_ujian,
        (SELECT nilai FROM log_praktek WHERE materi_id = id_materi AND user_id = {$id_user} GROUP BY materi_id) as nilai_ujian_praktek,
		(SELECT COUNT(*) FROM log_video WHERE materi_id = id_materi AND user_id = {$id_user} GROUP BY materi_id ORDER BY created_at DESC) as log_video,
		(SELECT created_at FROM log_baca WHERE materi_id = id_materi AND user_id = {$id_user} GROUP BY materi_id ORDER BY created_at DESC) as tanggal_baca,
		(SELECT created_at FROM log_praktek WHERE materi_id = id_materi AND user_id = {$id_user} GROUP BY materi_id ORDER BY created_at DESC) as tanggal_praktek,
		(SELECT end_time FROM log_ujian WHERE materi_id = id_materi AND user_id = {$id_user} AND end_time IS NOT NULL  GROUP BY materi_id ORDER BY end_time DESC) as tanggal_ujian,
		(SELECT created_at FROM log_video WHERE materi_id = id_materi AND user_id = {$id_user} GROUP BY materi_id ORDER BY created_at DESC) as tanggal_video")
			->from('materi');

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

	public function getLastMateriAkses($bab_id)
	{

		$sqlSelectKuis = "log_ujian.*,materi.id_materi,materi.nama_materi,materi.tipe,materi.urutan_materi";
		$sqlSelectBaca = "log_baca.*,materi.id_materi,materi.nama_materi,materi.tipe,materi.urutan_materi";
		$sqlSelectPraktek = "log_praktek.*,materi.id_materi,materi.nama_materi,materi.tipe,materi.urutan_materi";
		$sqlSelectVideo = "log_video.*,materi.id_materi,materi.nama_materi,materi.tipe,materi.urutan_materi";

		$queryKuis = $this->db->select($sqlSelectKuis)
			->from("log_ujian")
			->join("materi", "materi_id = id_materi")
			->where("materi.bab_id = {$bab_id} AND user_id = {$_SESSION['siswaData']['id_user']} AND end_time IS NOT NULL")
			->group_by("materi_id")
			->order_by("created_at DESC")
			->limit(1)
			->get()
			->result_array();

		$queryBaca = $this->db->select($sqlSelectBaca)
			->from("log_baca")
			->join("materi", "materi_id = id_materi")
			->where("materi.bab_id = {$bab_id} AND user_id = {$_SESSION['siswaData']['id_user']}")
			->group_by("materi_id")
			->order_by("created_at DESC")
			->limit(1)
			->get()
			->result_array();

		$queryPraktek = $this->db->select($sqlSelectPraktek)
			->from("log_praktek")
			->join("materi", "materi_id = id_materi")
			->where("materi.bab_id = {$bab_id} AND user_id = {$_SESSION['siswaData']['id_user']}")
			->group_by("materi_id")
			->order_by("created_at DESC")
			->limit(1)
			->get()
			->result_array();

		$queryVideo = $this->db->select($sqlSelectVideo)
			->from("log_video")
			->join("materi", "materi_id = id_materi")
			->where("materi.bab_id = {$bab_id} AND user_id = {$_SESSION['siswaData']['id_user']}")
			->group_by("materi_id")
			->order_by("created_at DESC")
			->limit(1)
			->get()
			->result_array();

		$arrayTanggal = [];

		if (count($queryKuis) > 0) {
			$arrayTanggal[] = [
				"id"   => $queryKuis[0]["materi_id"],
				"date" => $queryKuis[0]["created_at"]
			];
		}

		if (count($queryBaca) > 0) {
			$arrayTanggal[] = [
				"id"   => $queryBaca[0]["materi_id"],
				"date" => $queryBaca[0]["created_at"]
			];
		}

		if (count($queryPraktek) > 0) {
			$arrayTanggal[] = [
				"id"   => $queryPraktek[0]["materi_id"],
				"date" => $queryPraktek[0]["created_at"]
			];
		}

		if (count($queryVideo) > 0) {
			$arrayTanggal[] = [
				"id"   => $queryVideo[0]["materi_id"],
				"date" => $queryVideo[0]["created_at"]
			];
		}

		foreach ($arrayTanggal as $keyTanggal => $valueTanggal) {
			$tanggal[$keyTanggal] = strtotime($valueTanggal["date"]);
		}

		array_multisort($tanggal, SORT_DESC, $arrayTanggal);

		if (count($arrayTanggal) > 0) {
			$materi = $this->getAllMateri("id_materi = {$arrayTanggal[0]["id"]}");
		} else {
			$materi = [
				"total" => 0,
				"data"  => []
			];
		}

		return $materi;
	}

	public function getAllSoal($where = "")
	{
		$query = $this->db
			->select("*")
			->from("soal")
			->join("jawaban", "soal_id = id_soal")
			->order_by('id_soal', 'RANDOM');
		if ($where != "") {
			$query = $query->where($where);
		}

		$query = $query->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getAllAsset($where = "")
	{
		$query = $this->db
			->select("*")
			->from("asset");

		if ($where != "") {
			$query = $query->where($where);
		}

		$query = $query->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function lastLogUjian($idMateri = 0)
	{
		$query = $this->db
			->select("*")
			->from("log_ujian")
			->where("materi_id = {$idMateri} AND user_id = {$_SESSION['siswaData']['id_user']}");

		$query = $query->get()
			->result_array();

		return ([
			"data"  => count($query) >= 1 ? $query[0] : [],
			"total" => count($query),
		]);
	}

	public function getAllJawaban($idLogUjian = 0)
	{
		$query = $this->db
			->select("*")
			->from("jawaban_siswa")
			->join("jawaban", "jawaban_siswa.soal_id = jawaban.soal_id")
			->where("id_log_ujian = {$idLogUjian}");

		$query = $query->get()
			->result_array();

		$data = [];

		foreach ($query as $keyQ => $valueQ) {
			$data[$valueQ["soal_id"]] = $valueQ;
		}

		return ([
			"data"  => $data,
			"total" => count($data),
		]);
	}

	public function getAllLogPraktek($where = "")
	{
		$query = $this->db
			->select("*")
			->from("log_praktek");

		if ($where != "") {
			$query = $query->where($where);
		}

		$query = $query->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function convertDurasi(string $jenis, $time)
	{
		switch ($jenis) {
			case "toMS":
				$durasi = explode(":", $time);

				$durasiH = $durasi[0];
				$durasiM = $durasi[1] + ($durasiH * 60);
				$durasiS = substr("0" . intval(ceil(100 / 60 * $durasi[2])), -2, 2);

				$durasiPost = floatval($durasiM . "." . $durasiS);
				break;
			case "toHMS":
				$durasi = explode(".", $time);

				$durasiH = ($durasi[0] > 60) ? $durasi[0] / 60 : 0;
				$durasiM = $durasi[0] - ($durasiH * 60);
				$durasiS = floatval(0.06 * intval(str_pad($durasi[1], 2, '0', STR_PAD_RIGHT)));

				$durasiPost = substr("0" . $durasiH, -2, 2) . ":" . substr("0" . $durasiM, -2, 2) . ":" . substr("0" . $durasiS, -2, 2);
				break;
		}

		return $durasiPost;

	}

}
