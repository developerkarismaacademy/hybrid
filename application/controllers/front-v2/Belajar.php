<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Belajar extends CI_Controller
{

	private $data;

	public function __construct()
	{
		parent::__construct();
		$this->data['page'] = "home";

		$this->load->model("front-v2/KelasModel", "FrontKelasModel");
		$this->load->model("front-v2/MapelModel", "FrontMapelModel");
		$this->load->model("front-v2/BabModel", "FrontBabModel");
		$this->load->model("front-v2/MateriModel", "FrontMateriModel");
		$this->load->model("front-v2/UlasanModel", "FrontUlasanModel");

		$this->FrontAuthModel->isLoggedIn();
	}

	public function daftarMateri($meta_link_mapel = "")
	{
		$where = "meta_link_mapel = '{$meta_link_mapel}'";

		$dataMapel = $this->FrontMapelModel->getAllMapel($where);
		$id_user = $_SESSION['siswaData']['id_user'];
		$prakerjaStatus = $dataMapel['data'][0]['prakerja'] == 1 ? true : false;
		if ($prakerjaStatus) {
			$redeemData = $this->db->get_where('redeem', ['user_id' => $id_user, 'mapel_id' => $dataMapel['data'][0]['id_mapel']]);
			if ($redeemData->num_rows() == 0) {
				redirect('profil');
			}
		}

		if ($dataMapel["total"] > 0) {
			$mapel = $dataMapel["data"][0];

			$id_mapel = $mapel["id_mapel"];

			$this->data["ulasan"] = false;
			if ($this->FrontUlasanModel->getByUlasan($id_user, $id_mapel)['total'] > 0) {
				$this->data["ulasan"] = true;
			}

			if (in_array($mapel["id_mapel"], $_SESSION["idMapelBeli"]) == false) {
				redirect(base_url() . "kursus/detail/{$meta_link_mapel}");
			}

			$allBab = $this->FrontBabModel->getAllBab("mapel_id = {$mapel["id_mapel"]}");

			if ($allBab["total"] > 0) {
				foreach ($allBab["data"] as $keyBab => $valueBab) {
					$allBab["data"][$keyBab]["materi"] = $this->FrontMateriModel->getAllMateriWithLog("bab_id = {$valueBab["id_bab"]}");
				}
			}

			$this->data['id'] = [
				"mapel" => $id_mapel,
			];

			$this->data["title"] = "Belajar Kelas {$mapel["nama_mapel"]}";
			$this->data["mapel"] = $mapel;
			$this->data["bab"] = $allBab;
			$this->data['content'] = "belajar.kelas";
		} else {
			$this->data["title"] = "Kursus Tidak Di Temukan";
			$this->data["content"] = "404";
		}

		$this->load->view("front-v2/main", $this->data);
	}

	public function materi($meta_link_mapel = "", $meta_link_bab = "", $urutan = 0)
	{


		$where = "meta_link_mapel = '{$meta_link_mapel}'";
		$dataMapel = $this->FrontMapelModel->getAllMapel($where);
		$user = $this->FrontAuthModel->getUserLoggedIn();
		$user_id = $user['data']['id_user'];
		$prakerjaStatus = $dataMapel['data'][0]['prakerja'] == 1 ? true : false;
		if ($prakerjaStatus) {
			$redeemData = $this->db->get_where('redeem', ['user_id' => $user_id, 'mapel_id' => $dataMapel['data'][0]['id_mapel']]);
			if ($redeemData->num_rows() == 0) {
				redirect('profil');
			}
		}

		if ($dataMapel["total"] > 0) {
			$mapel = $dataMapel["data"][0];

			if (in_array($mapel["id_mapel"], $_SESSION["idMapelBeli"]) == false) {
				redirect(base_url() . "kursus/detail/{$meta_link_mapel}");
			}

			$dataBab = $this->FrontBabModel->getAllBab("meta_link_bab = '{$meta_link_bab}'");

			if ($dataBab["total"] > 0) {
				if ($urutan == 0) {
					$this->data["materiActive"] = $this->FrontMateriModel->getLastMateriAkses();
				} else {
					$this->data["materiActive"] = $this->FrontMateriModel->getAllMateriWithLog("bab_id = {$dataBab["data"][0]["id_bab"]} AND urutan_materi = {$urutan}");
				}

				if ($this->data["materiActive"]["total"] > 0) {
					$this->data["title"] = "Belajar Kelas {$mapel["nama_mapel"]}";
					$this->data["mapel"] = $mapel;
					$this->data["bab"] = $dataBab["data"][0];
					$this->data["materi"] = $this->FrontMateriModel->getAllMateriWithLog("bab_id = {$dataBab["data"][0]["id_bab"]}");
					$this->data["materiActive"] = $this->data["materiActive"]["data"][0];

					// Tipe Pilihan
					if ($this->data["materiActive"]["tipe"] == "pilihan") {
						$this->data['tipe'] = 'KUIS';
						$this->data['paket'] = null;
						if ($dataBab['data'][0]['pretest_status'] == 1 || $dataBab['data'][0]['posttest_status'] == 1) {
							if ($dataBab['data'][0]['pretest_status'] == 1) {
								$this->data['tipe'] = 'Pre-test';
							} else {
								$this->data['tipe'] = 'Post-test';
							}
							$mapel_id = $mapel['id_mapel'];


							$this->db->where("user_id = $user_id AND mapel_id = $mapel_id");
							$detail_transaksi = $this->db->get('detail_transaksi')->row_array();

							$detail_transaksi_id = $detail_transaksi['id_detail_transaksi'];

							$this->db->where("id_detail_transaksi = $detail_transaksi_id");
							$randomize = $this->db->get('randomize')->row_array();
							if ($randomize) {
								$paket = $randomize['id_package'];
								$this->data["soal"] = $this->FrontMateriModel->getAllSoal("materi_id = {$this->data["materiActive"]["id_materi"]} AND paket = $paket");
								if ($dataBab['data'][0]['posttest_status'] == 1) {
									$this->data["soal"] = $this->FrontMateriModel->getAllSoal("materi_id = {$this->data["materiActive"]["id_materi"]} AND paket = $paket");
								}
								$this->data['paket'] = $paket;
							} else {

								$this->data["soal"] = $this->FrontMateriModel->getAllSoal("materi_id = {$this->data["materiActive"]["id_materi"]}");
							}
						} else {

							$this->data["soal"] = $this->FrontMateriModel->getAllSoal("materi_id = {$this->data["materiActive"]["id_materi"]}");
						}
						$this->data["logUjian"] = $this->FrontMateriModel->lastLogUjian($this->data["materiActive"]["id_materi"]);

						if ($this->data["logUjian"]["total"] > 0) {
							$this->data["jawaban"] = $this->FrontMateriModel->getAllJawaban($this->data["logUjian"]["data"]["id_log_ujian"]);
							$now = strtotime(date("Y-m-d H:i:s"));
							$est = strtotime($this->data["logUjian"]["data"]["estimasi_time"]);
							if ($now >= $est && ($this->data["logUjian"]["data"]["start_time"] != null || $this->data["logUjian"]["data"]["estimasi_time"] != null)) {
								//#BUG
								$data = ["end_time" => date("Y-m-d H:i:s")];

								$update = $this->UniversalModel->update("log_ujian", "id_log_ujian = {$this->data["logUjian"]["data"]["id_log_ujian"]}", $data);

								$this->data["logUjian"] = $this->FrontMateriModel->lastLogUjian($this->data["materiActive"]["id_materi"]);
							}
						}
					}


					$this->data["materiAkhir"] = false;
					$this->data["linkSelanjutnya"] = base_url("belajar/{$meta_link_mapel}/{$meta_link_bab}/" . ($urutan + 1));
					//next materi or bab
					if ($urutan == $this->data["materi"]["total"]) {
						$this->data["nextBab"] = $this->FrontBabModel->getAllBab("mapel_id = '{$mapel["id_mapel"]}' AND urutan_bab = " . ($dataBab["data"][0]["urutan_bab"] + 1));
						if ($this->data["nextBab"]["total"] <= 0) {
							$this->data["materiAkhir"] = true;
						} else {
							$this->data["materiAkhir"] = false;
							$this->data["linkSelanjutnya"] = base_url("belajar/{$meta_link_mapel}/{$this->data["nextBab"]["data"][0]["meta_link_bab"]}/1");
						}
					}

					$this->data["asset"] = $this->FrontMateriModel->getAllAsset("materi_id = {$this->data["materiActive"]["id_materi"]}");
					$this->data['content'] = "materi.materi-{$this->data["materiActive"]["tipe"]}";

					//LISTING ID
					$this->data['id'] = [
						"mapel" => $mapel["id_mapel"],
						"bab" => $dataBab["data"][0]["id_bab"],
						"materi" => $this->data["materiActive"]["id_materi"],
					];
				} else {
					$this->data["title"] = "Kursus Tidak Di Temukan";
					$this->data["content"] = "404";
				}
			} else {
				$this->data["title"] = "Kursus Tidak Di Temukan";
				$this->data["content"] = "404";
			}
		} else {
			$this->data["title"] = "Kursus Tidak Di Temukan";
			$this->data["content"] = "404";
		}

		$this->data["urutanCurrent"] = $urutan;

		$this->load->view("front-v2/main", $this->data);
	}

	public function selesai()
	{
		$idLogUjian = $_POST["idLogUjian"] ?? 0;
		$mapel_id = $_POST["idMapel"] ?? 0;

		$logUjian = $this->UniversalModel->getOneData("log_ujian", "id_log_ujian = {$idLogUjian}");

		if ($logUjian["total"] > 0) {
			$data = ["end_time" => date("Y-m-d H:i:s")];

			$simpan = $this->UniversalModel->update("log_ujian", "id_log_ujian = {$idLogUjian}", $data);
		}

		if ($simpan["success"]) {
			$code = 200;
			$return["success"] = true;
			$return["message"] = "Berhasil Di Simpan";

			$where = "id_mapel = {$mapel_id}";

			$dataMapel = $this->FrontMapelModel->getAllMapel($where);

			if ($dataMapel["total"] > 0) {
				$mapel = $dataMapel["data"][0];

				$allBab = $this->FrontBabModel->getAllBab("mapel_id = {$mapel["id_mapel"]}");

				$jmlBab = 0;
				$jmlSelesaiPerBab = 0;
				if ($allBab["total"] > 0) {
					foreach ($allBab["data"] as $keyBab => $valueBab) {
						$materi = $this->FrontMateriModel->getAllMateriWithLog("bab_id = {$valueBab["id_bab"]}");
						$jmlBab += $materi["total"];
						if ($materi["total"] > 0) {
							foreach ($materi["data"] as $keyMateri => $valueMateri) {
								if ($valueMateri["log_baca"] > 0 || $valueMateri["log_video"] > 0 || $valueMateri["log_ujian"] > 0 || $valueMateri["log_praktek"] > 0) {
									$jmlSelesaiPerBab++;
								}
							}
						}
					}
				}

				$progress = $jmlBab == 0 || $jmlSelesaiPerBab == 0 ? 0 : round($jmlSelesaiPerBab / $jmlBab * 100, 1);
				$progress = $progress >= 99.0 ? 100 : $progress;

				$this->FrontMapelModel->updateProgress($mapel["id_mapel"], $progress);
			}
		} else {
			$code = 200;
			$return["success"] = false;
			$return["message"] = "Gagal Di Simpan";
		}

		return $this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output(json_encode($return));
	}

	public function simpanLog()
	{
		$tipe = $_POST["tipe"] ?? "";
		$mapel_id = $_POST["idMapel"] ?? "";
		$idMateri = $_POST["idMateri"] ?? "";

		$simpan = $this->UniversalModel->insert("log_{$tipe}", ["user_id" => $_SESSION['siswaData']['id_user'], "materi_id" => $idMateri, "created_at" => date("Y-m-d H:i:s")]);

		if ($simpan["success"]) {
			$code = 200;

			$return["success"] = true;
			$return["message"] = "Berhasil";

			$where = "id_mapel = {$mapel_id}";

			$dataMapel = $this->FrontMapelModel->getAllMapel($where);

			if ($dataMapel["total"] > 0) {
				$mapel = $dataMapel["data"][0];

				$allBab = $this->FrontBabModel->getAllBab("mapel_id = {$mapel["id_mapel"]}");

				$jmlBab = 0;
				$jmlSelesaiPerBab = 0;
				if ($allBab["total"] > 0) {
					foreach ($allBab["data"] as $keyBab => $valueBab) {
						$materi = $this->FrontMateriModel->getAllMateriWithLog("bab_id = {$valueBab["id_bab"]}");
						$jmlBab += $materi["total"];
						if ($materi["total"] > 0) {
							foreach ($materi["data"] as $keyMateri => $valueMateri) {
								if ($valueMateri["log_baca"] > 0 || $valueMateri["log_video"] > 0 || $valueMateri["log_ujian"] > 0 || $valueMateri["log_praktek"] > 0) {
									$jmlSelesaiPerBab++;
								}
							}
						}
					}
				}

				$progress = $jmlBab == 0 || $jmlSelesaiPerBab == 0 ? 0 : round($jmlSelesaiPerBab / $jmlBab * 100, 1);
				$progress = $progress >= 99.0 ? 100 : $progress;

				$this->FrontMapelModel->updateProgress($mapel["id_mapel"], $progress);
			}
		} else {
			$code = 200;

			$return["success"] = false;
			$return["message"] = "Gagal";
		}

		return $this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output(json_encode($return));
	}

	//KUIS
	public function mulaiLog()
	{
		$idMateri = $_POST["idMateri"] ?? "";

		$lastLogUjian = $this->FrontMateriModel->lastLogUjian($idMateri);

		$materi = $this->FrontMateriModel->getAllMateriWithLog("id_materi = {$idMateri}");

		$intDurasi = (int)$materi["data"][0]["durasi"];

		$data = [
			"user_id" => $_SESSION['siswaData']['id_user'],
			"materi_id" => $idMateri,
			"start_time" => date("Y-m-d H:i:s"),
			"estimasi_time" => date("Y-m-d H:i:s", strtotime("+{$intDurasi} minute")),
			"benar" => 0,
			"salah" => 0,
			"jumlah_soal" => $materi["data"][0]["jml_soal"],
			"nilai" => 0,
			"created_at" => date("Y-m-d H:i:s"),
		];

		if ($lastLogUjian["total"] <= 0) {
			$simpanLog = $this->UniversalModel->insert("log_ujian", $data);
			if ($simpanLog["success"]) {
				$code = 200;
				$return["data"] = $this->UniversalModel->getOneData("log_ujian", "id_log_ujian = {$simpanLog["id"]}");
				$return["success"] = true;
				$return["message"] = "Berhasil Di Simpan";
			} else {

				$code = 200;
				$return["success"] = false;
				$return["message"] = "Gagal Di Simpan";
			}
		} else if ($lastLogUjian['data']['retake_log_ujian'] >= 1 && $lastLogUjian["data"]["start_time"] == null && $lastLogUjian["data"]["estimasi_time"] == null) {
			//#BUG
			$lastLogUjian = $lastLogUjian['data'];

			$simpanLog = $this->UniversalModel->update("log_ujian", "id_log_ujian = " . $lastLogUjian['id_log_ujian'], $data);
			if ($simpanLog["success"]) {
				$code = 200;
				$return["data"] = $this->UniversalModel->getOneData("log_ujian", "id_log_ujian = {$lastLogUjian["id_log_ujian"]}");
				$return["success"] = true;
				$return["message"] = "Berhasil Di Simpan";
			} else {

				$code = 200;
				$return["success"] = false;
				$return["message"] = "Gagal Di Simpan";
			}
		} else {
			$code = 200;
			$return["data"] = $lastLogUjian;
			$return["success"] = true;
			$return["message"] = "Berhasil Di Simpan";
		}

		return $this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output(json_encode($return));
	}

	public function retakeKuis()
	{
		$idMateri = $_POST["idMateri"] ?? "";

		$lastLogUjian = $this->FrontMateriModel->lastLogUjian($idMateri);

		$materi = $this->FrontMateriModel->getAllMateriWithLog("id_materi = {$idMateri}");

		$intDurasi = (int)$materi["data"][0]["durasi"];


		if ($lastLogUjian["total"] > 0) {
			$lastLogUjian = $lastLogUjian['data'];
			$intDurasi = (int)$materi["data"][0]["durasi"];

			$data = [
				"start_time" => null,
				"estimasi_time" => null,
				"end_time" => null,
				"benar" => 0,
				"salah" => 0,
				"jumlah_soal" => $materi["data"][0]["jml_soal"],
				"nilai" => 0,
				"updated_at" => date("Y-m-d H:i:s"),
				"retake_log_ujian" => $lastLogUjian['retake_log_ujian'] + 1,
			];


			$simpanLog = $this->UniversalModel->update("log_ujian", "id_log_ujian = " . $lastLogUjian['id_log_ujian'], $data);

			if ($simpanLog["success"]) {
				$deleteJawaban = $this->UniversalModel->delete("jawaban_siswa", "materi_id = {$idMateri} AND user_id = {$_SESSION['siswaData']['id_user']}");
				if ($deleteJawaban["success"]) {
					$code = 200;
					$return["success"] = true;
					$return["durasi"] = "+{$intDurasi} minute";
					$return["message"] = "Berhasil Di Update";
				} else {
					$code = 403;
					$return["success"] = false;
					$return["message"] = "Gagal Di Update";
				}
			} else {
				$code = 403;
				$return["success"] = false;
				$return["message"] = "Gagal Di Update";
			}
		} else {
			$code = 200;
			$return["data"] = $lastLogUjian;
			$return["success"] = true;
			$return["message"] = "Berhasil Di Simpan";
		}


		return $this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output(json_encode($return));
	}

	public function simpanJawaban()
	{
		$idSoal = $_POST["idSoal"] ?? "";
		$jawaban = $_POST["jawaban"] ?? "";
		$idMateri = $_POST["idMateri"] ?? 0;
		$idLogUjian = $_POST["idLogUjian"] ?? 0;
		$jmlSoal = $_POST["jmlSoal"] ?? 0;

		$dataJawaban = $this->UniversalModel->getOneData("jawaban_siswa", "id_log_ujian = {$idLogUjian} AND user_id = {$_SESSION['siswaData']['id_user']} AND soal_id = {$idSoal}");

		$data = [
			"id_log_ujian" => $idLogUjian,
			"user_id" => $_SESSION['siswaData']['id_user'],
			"soal_id" => $idSoal,
			"materi_id" => $idMateri,
			"jawaban" => $jawaban,
			"created_at" => date("Y-m-d H:i:s"),
		];

		if ($dataJawaban["total"] > 0) {
			$data["updated_at"] = date("Y-m-d H:i:s");
			$simpan = $this->UniversalModel->update("jawaban_siswa", "id_log_ujian = {$idLogUjian} AND user_id = {$_SESSION['siswaData']['id_user']} AND soal_id = {$idSoal}", $data);
		} else {
			$data["created_at"] = date("Y-m-d H:i:s");
			$simpan = $this->UniversalModel->insert("jawaban_siswa", $data);
		}

		$logUjian = $this->UniversalModel->getOneData("log_ujian", "id_log_ujian = {$idLogUjian}");

		if ($logUjian["total"] > 0) {
			$logUjian = $logUjian["data"];
			$jawaban = $this->FrontMateriModel->getAllJawaban($idLogUjian);
			$benar = 0;
			$salah = 0;
			if ($jawaban["total"] > 0) {
				foreach ($jawaban["data"] as $keyJawaban => $valueJawaban) {
					if ($valueJawaban["jawaban"] == $valueJawaban["kunci_jawaban"]) {
						$benar++;
					} else {
						$salah++;
					}
				}
			}
			$score = $benar / $jmlSoal * 100;
			$score = round($score, 2);

			$data = [
				"benar" => $benar,
				"salah" => $salah,
				"nilai" => $score,
			];

			$simpanLog = $this->UniversalModel->update("log_ujian", "id_log_ujian = {$idLogUjian}", $data);
		}

		if ($simpan["success"]) {
			$code = 200;
			$return["success"] = true;
			$return["message"] = "Berhasil Di Simpan";
		} else {
			$code = 200;
			$return["success"] = false;
			$return["message"] = "Gagal Di Simpan";
		}

		return $this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output(json_encode($return));
	}

	public function getAllLogPraktek()
	{
		$idMateri = $_POST["idMateri"] ?? 0;
		$mapel_id = $_POST["idMapel"] ?? 0;

		$logPraktek = $this->FrontMateriModel->getAllLogPraktek("user_id = {$_SESSION['siswaData']['id_user']} AND materi_id = {$idMateri}");

		$code = 200;
		$return["data"] = $logPraktek;
		$return["success"] = true;

		return $this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output(json_encode($return));
	}

	public function simpanLogPraktek()
	{
		$mapel_id = $_POST["idMapel"] ?? 0;
		$materi_id = $_POST["idMateri"] ?? 0;
		$tipe = $_POST["tipe"] ?? "";

		$dataPraktek = [];
		$error = [];

		switch ($tipe) {
			case "dokumen":
				$nama = $_POST["dokumen-subjek"] ?? 0;

				if (!isset($_FILES['dokumen-file']['name']) || $_FILES['dokumen-file']['name'] == "") {
					$nama_file = "";
					$error = 'Tidak boleh kosong';
				} else {
					$config['upload_path'] = "./upload/praktek/{$_SESSION['siswaData']['id_user']}/{$materi_id}";
					$config['allowed_types'] = '*';
					$config['encrypt_name'] = true;
					if (!is_dir($config['upload_path'])) {
						mkdir($config['upload_path'], 0755, true);
					}

					$this->upload->initialize($config);
					if (!$this->upload->do_upload('dokumen-file')) {
						$error = $this->upload->display_errors();
						$nama_file = "";
					} else {
						$nama_file = $this->upload->data('file_name');
					}
				}

				$dataPraktek = [
					"materi_id" => $materi_id,
					"user_id" => $_SESSION['siswaData']['id_user'],
					"file" => $nama_file,
					"nilai" => 0,
					"created_at" => date("Y-m-d H:i:s"),
					"status_baca_instruktur" => 0,
					"nama" => $nama,
					"tipe" => $tipe,
				];

				break;
			case "lampiran":
				$nama = $_POST["lampiran-subjek"] ?? 0;

				if (!isset($_FILES['lampiran-file']['name']) || $_FILES['lampiran-file']['name'] == "") {
					$nama_file = "";
					$error = 'Tidak boleh kosong';
				} else {
					$config['upload_path'] = "./upload/praktek/{$_SESSION['siswaData']['id_user']}/{$materi_id}";
					$config['allowed_types'] = '*';
					$config['encrypt_name'] = true;
					if (!is_dir($config['upload_path'])) {
						mkdir($config['upload_path'], 0755, true);
					}

					$this->upload->initialize($config);
					if (!$this->upload->do_upload('lampiran-file')) {
						$error = $this->upload->display_errors();
						$nama_file = "";
					} else {
						$nama_file = $this->upload->data('file_name');
					}
				}

				$dataPraktek = [
					"materi_id" => $materi_id,
					"user_id" => $_SESSION['siswaData']['id_user'],
					"file" => $nama_file,
					"nilai" => 0,
					"created_at" => date("Y-m-d H:i:s"),
					"status_baca_instruktur" => 0,
					"nama" => $nama,
					"tipe" => $tipe,
				];
				break;
			case "gambar":
				$nama = $_POST["gambar-subjek"] ?? 0;

				if (!isset($_FILES['gambar-file']['name']) || $_FILES['gambar-file']['name'] == "") {
					$nama_file = "";
					$error = 'Tidak boleh kosong';
				} else {
					$config['upload_path'] = "./upload/praktek/{$_SESSION['siswaData']['id_user']}/{$materi_id}";
					$config['allowed_types'] = '*';
					$config['encrypt_name'] = true;
					if (!is_dir($config['upload_path'])) {
						mkdir($config['upload_path'], 0755, true);
					}

					$this->upload->initialize($config);
					if (!$this->upload->do_upload('gambar-file')) {
						$error = $this->upload->display_errors();
						$nama_file = "";
					} else {
						$nama_file = $this->upload->data('file_name');
					}
				}

				$dataPraktek = [
					"materi_id" => $materi_id,
					"user_id" => $_SESSION['siswaData']['id_user'],
					"file" => $nama_file,
					"nilai" => 0,
					"created_at" => date("Y-m-d H:i:s"),
					"status_baca_instruktur" => 0,
					"nama" => $nama,
					"tipe" => $tipe,
				];
				break;
			case "link":
				if (!isset($_POST['link-link']) || $_POST['link-link'] == '') {
					$error = 'Tidak boleh kosong';
				}

				$nama = $_POST["link-subjek"] ?? 0;
				$link = $_POST["link-link"] ?? 0;
				$dataPraktek = [
					"materi_id" => $materi_id,
					"user_id" => $_SESSION['siswaData']['id_user'],
					"file" => $link,
					"nilai" => 0,
					"created_at" => date("Y-m-d H:i:s"),
					"status_baca_instruktur" => 0,
					"nama" => $nama,
					"tipe" => $tipe,
				];
				break;
		}

		if (empty($error)) {
			$simpanLog = $this->UniversalModel->insert("log_praktek", $dataPraktek);

			if ($simpanLog["success"]) {
				$code = 200;
				$return["success"] = true;
				$return["message"] = "Berhasil Di Simpan";
				$return["error"] = $error;

				$where = "id_mapel = {$mapel_id}";

				$dataMapel = $this->FrontMapelModel->getAllMapel($where);

				if ($dataMapel["total"] > 0) {
					$mapel = $dataMapel["data"][0];

					$allBab = $this->FrontBabModel->getAllBab("mapel_id = {$mapel["id_mapel"]}");

					$jmlBab = 0;
					$jmlSelesaiPerBab = 0;
					if ($allBab["total"] > 0) {
						foreach ($allBab["data"] as $keyBab => $valueBab) {
							$materi = $this->FrontMateriModel->getAllMateriWithLog("bab_id = {$valueBab["id_bab"]}");
							$jmlBab += $materi["total"];
							if ($materi["total"] > 0) {
								foreach ($materi["data"] as $keyMateri => $valueMateri) {
									if ($valueMateri["log_baca"] > 0 || $valueMateri["log_video"] > 0 || $valueMateri["log_ujian"] > 0 || $valueMateri["log_praktek"] > 0) {
										$jmlSelesaiPerBab++;
									}
								}
							}
						}
					}

					$progress = $jmlBab == 0 || $jmlSelesaiPerBab == 0 ? 0 : round($jmlSelesaiPerBab / $jmlBab * 100, 1);
					$progress = $progress >= 99.0 ? 100 : $progress;

					$this->FrontMapelModel->updateProgress($mapel["id_mapel"], $progress);
				}
			} else {
				$code = 200;
				$return["success"] = false;
				$return["message"] = "Gagal Di Simpan";
				$return["error"] = $error;
			}
		} else {
			$code = 200;
			$return["success"] = false;
			$return["message"] = "Gagal Di Simpan";
			$return["error"] = $error;
		}

		return $this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output(json_encode($return));
	}


	public function hapusLogPraktek()
	{
		$idLogUjian = $_POST["idLogUjian"] ?? 0;
		$mapel_id = $_POST["idMapel"] ?? 0;

		$getDataPraktek = $this->UniversalModel->getOneData("log_praktek", "id_log_praktek = {$idLogUjian}");
		if ($getDataPraktek["total"] >= 1) {
			$materi_id = $getDataPraktek["data"]["materi_id"];

			if ($getDataPraktek["data"]['file'] != "") {
				$filenya = './upload/praktek/' . $_SESSION['siswaData']['id_user'] . '/' . $materi_id . '/' . $getDataPraktek["data"]['file'];
				if ($getDataPraktek["data"]["tipe"] != "link") {
					if (file_exists($filenya)) {
						unlink($filenya);
					}
				}
			}

			$hapusLog = $this->UniversalModel->delete("log_praktek", "id_log_praktek = {$idLogUjian}");
			if ($hapusLog["success"]) {
				$code = 200;
				$return["success"] = true;
				$return["message"] = "Berhasil Di Hapus";

				$where = "id_mapel = {$mapel_id}";

				$dataMapel = $this->FrontMapelModel->getAllMapel($where);

				if ($dataMapel["total"] > 0) {
					$mapel = $dataMapel["data"][0];

					$allBab = $this->FrontBabModel->getAllBab("mapel_id = {$mapel["id_mapel"]}");

					$jmlBab = 0;
					$jmlSelesaiPerBab = 0;
					if ($allBab["total"] > 0) {
						foreach ($allBab["data"] as $keyBab => $valueBab) {
							$materi = $this->FrontMateriModel->getAllMateriWithLog("bab_id = {$valueBab["id_bab"]}");
							$jmlBab += $materi["total"];
							if ($materi["total"] > 0) {
								foreach ($materi["data"] as $keyMateri => $valueMateri) {
									if ($valueMateri["log_baca"] > 0 || $valueMateri["log_video"] > 0 || $valueMateri["log_ujian"] > 0 || $valueMateri["log_praktek"] > 0) {
										$jmlSelesaiPerBab++;
									}
								}
							}
						}
					}

					$progress = $jmlBab == 0 || $jmlSelesaiPerBab == 0 ? 0 : round($jmlSelesaiPerBab / $jmlBab * 100, 1);
					$progress = $progress >= 99.0 ? 100 : $progress;

					$this->FrontMapelModel->updateProgress($mapel["id_mapel"], $progress);
				}
			} else {
				$code = 200;
				$return["success"] = false;
				$return["message"] = "Gagal Di Hapus";
			}
		} else {
			$code = 200;
			$return["success"] = false;
			$return["message"] = "Gagal Di Hapus";
		}
		return $this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output(json_encode($return));
	}
}
