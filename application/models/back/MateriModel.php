<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MateriModel extends CI_Model
{
	public function getPaging(int $limit, int $start, string $search, string $order, string $order_option, int $idBab = 0)
	{
		$query = $this->db->select("*")
			->from('materi')
			->join('bab', 'id_bab = materi.bab_id')
			->join('mapel', 'id_mapel = bab.mapel_id')
			->join('kelas', 'id_kelas = mapel.kelas_id');

		if ($idBab != 0) {
			$query = $query->where('materi.bab_id', $idBab);
		}

		if ($search != "") {
			$query = $query->group_start()
				->where("nama_materi like", "%{$search}%")
				->or_where("nama_kelas like", "%{$search}%")
				->or_where("nama_bab like", "%{$search}%")
				->group_end();
		}

		$query = $query->order_by($order, $order_option);

		$count_all_result = count($query->get()->result_array());

		$query = $this->db->select("*")
			->from('materi')
			->join('bab', 'id_bab = materi.bab_id')
			->join('mapel', 'id_mapel = bab.mapel_id')
			->join('kelas', 'id_kelas = mapel.kelas_id');


		if ($idBab != 0) {
			$query = $query->where('materi.bab_id', $idBab);
		}

		if ($search != "") {
			$query = $query->group_start()
				->where("nama_materi like", "%{$search}%")
				->or_where("nama_kelas like", "%{$search}%")
				->or_where("nama_bab like", "%{$search}%")
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
			->from('materi')
			// ->join('konten_materi', 'materi_id = materi.id_materi')
			->join('bab', 'id_bab = materi.bab_id')
			->join('mapel', 'id_mapel = bab.mapel_id')
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->where('id_materi', $id)
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
			->from('materi')
			->join('bab', 'id_bab = materi.bab_id')
			->join('mapel', 'id_mapel = bab.mapel_id')
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->where('meta_link_materi', $meta)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function saveData($data)
	{
		return $this->db->insert('materi', $data);
	}

	public function updateData($id, $data)
	{
		$this->db->where('id_materi', $id);
		return $this->db->update('materi', $data);
	}

	public function deleteData($id)
	{
		$this->db->where('id_materi', $id);
		return $this->db->delete('materi');
	}

	public function getMetaLink($title, $id = null)
	{
		$slug = url_title($title);
		$slug = strtolower($slug);
		$i = 0;
		$params = array();
		$params["meta_link_materi"] = $slug;

		if ($id) {
			$params["id_materi !="] = $id;
		}

		while ($this->db->where($params)->get('materi')->num_rows()) {
			if (!preg_match('/-{1}[0-9]+$/', $slug)) {
				$slug .= '-' . ++$i;
			} else {
				$slug = preg_replace('/[0-9]+$/', ++$i, $slug);
			}
			$params["meta_link_materi"] = $slug;
		}

		return $slug;
	}

	public function getLastUrutanByBab($idBab)
	{
		$query = $this->db->select("*")
			->from('materi')
			->join('bab', 'id_bab = materi.bab_id')
			->join('mapel', 'id_mapel = bab.mapel_id')
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->where('materi.bab_id', $idBab)
			->order_by('urutan_materi', "DESC")
			->limit(1)
			->get()
			->row_array();

		return (isset($query) && count($query) > 1 ? $query['urutan_materi'] : 0);
	}


	public function getFirstUrutanByBab($idBab)
	{
		$query = $this->db->select("*")
			->from('materi')
			->join('bab', 'id_bab = materi.bab_id')
			->join('mapel', 'id_mapel = bab.mapel_id')
			->join('kelas', 'id_kelas = mapel.kelas_id')
			->where('materi.bab_id', $idBab)
			->order_by('urutan_materi', "ASC")
			->limit(1)
			->get()
			->row_array();

		return (isset($query) && count($query) > 1 ? $query['urutan_materi'] : 0);
	}

	public function getAll()
	{
		$query = $this->db->select("*")
			->from('materi')
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getAllBy($where = "", $limit = "", $order = "")
	{
		$query = $this->db->select("*")
			->from('materi')
			->join('bab', 'id_bab = materi.bab_id')
			->join('mapel', 'id_mapel = bab.mapel_id')
			->join('kelas', 'id_kelas = mapel.kelas_id');
		if ($order != "") {
			if (is_array($order)) {
				foreach ($order as $key => $value) {
					$query = $query->order_by($key, $value);
				}
			}
		}

		if ($where != "") {
			if (is_array($where)) {
				if (isset($where["LIKE"])) {
					foreach ($where["LIKE"] as $key => $value) {
						$query = $query->like($key, $value);
					}
				} else {
					foreach ($where as $key => $value) {
						$query = $query->where($key, $value);
					}
				}
			} else {
				$query = $query->where($where);
			}
		}

		if ($limit != "") {
			if (is_array($where)) {
				$query = $query->limit($limit[0], $limit[1]);
			}
		}

		$query = $query->get()->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getAllByBab($idBab)
	{
		$query = $this->db->select("*")
			->from('materi')
			->where('materi.bab_id', $idBab)
			->order_by('urutan_materi', "ASC")
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getFirstVideoByMapel($idMapel)
	{
		$query = $this->db->select("materi.url_video")
			->from('materi')
			->join('bab', 'id_bab = materi.bab_id')
			->join('mapel', 'id_mapel = bab.mapel_id')
			->where('mapel.id_mapel', $idMapel)
			->where('materi.url_video IS NOT NULL')
			->where('materi.url_video !=', '')
			->limit(1)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getAllJawabanLogUjian($id_materi, $idLogUjian)
	{
		$this->db->select("soal.materi_id,soal.isi_soal,soal.id_soal,soal.dir,
		jawaban.soal_id,jawaban.jawab_1,jawaban.jawab_2,jawaban.jawab_3,jawaban.jawab_4,jawaban.jawab_5,jawaban.kunci_jawaban,
		jawaban.pembahasan,jawaban.pembahasan_video,jawaban.bobot,jawaban_siswa.jawaban");

		$this->db->from("soal");
		$this->db->join("jawaban", 'soal.id_soal = jawaban.soal_id');
		$this->db->join("jawaban_siswa", 'soal.id_soal = jawaban_siswa.soal_id AND jawaban_siswa.id_log_ujian = ' . $idLogUjian, 'left outer');
		$this->db->where("soal.materi_id", $id_materi);

		$this->db->order_by("soal.id_soal", "ASC");

		$query = $this->db->get()->result_array();

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
