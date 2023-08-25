<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Progress extends CI_Controller
{

	private $data;

	public function __construct()
	{
		parent::__construct();

		$this->load->model('back/InstrukturModel', 'BackInstrukturModel', true);
		$this->load->model('back/MapelModel', 'BackMapelModel', true);
		$this->load->model('back/KelasModel', 'BackKelasModel', true);
		$this->load->model('back/SiswaModel', 'BackSiswaModel', true);
		$this->load->model('back/BabModel', 'BackBabModel', true);
		$this->load->model('back/MateriModel', 'BackMateriModel', true);
		$this->load->model('back/KompetensiModel', 'BackKompetensiModel', true);
		$this->load->model('back/IndikatorIndukModel', 'BackIndikatorIndukModel', true);
		$this->load->model('back/IndikatorModel', 'BackIndikatorModel', true);
		$this->data['menu'] = "progress";
		$this->FrontAuthModel->isLoggedInAdmin();
	}

	public function mapelDiAmpu()
	{
		$this->data['title'] = "Daftar Mata Pelajaran yang Di Ampu";
		$this->data['content'] = "instruktur.mapel-ampu";

		$this->load->view('back/main', $this->data);
	}

	public function siswaAmpu($metaMapel = "")
	{

		$dataMapel = $this->BackMapelModel->getByMeta($metaMapel);

		if ($dataMapel['total'] >= 1) {

			$dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

			if ($dataKelas['total'] >= 1) {
				$this->data['title'] = "Bab " . $dataMapel['data'][0]['nama_mapel'];
				$this->data['content'] = "instruktur.list-siswa";
				$this->data['kelas'] = $dataKelas['data'][0];
				$this->data['mapel'] = $dataMapel['data'][0];
				$this->data['id'] = $dataMapel['data'][0]['id_mapel'];

				$this->load->view('back/main', $this->data);
			} else {
				redirect(base_url('back/not-found'));
			}
		} else {
			redirect(base_url('back/not-found'));
		}
	}

	public function progressSiswa($metaMapel = "", $idUser = 0)
	{
		$dataSiswa = $this->BackSiswaModel->getById($idUser);
		$materiPertama = 0;
		$babPertama = 0;
		if ($dataSiswa["total"] >= 1) {
			$dataMapel = $this->BackMapelModel->getByMeta($metaMapel);

			if ($dataMapel['total'] >= 1) {

				$dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

				if ($dataKelas['total'] >= 1) {
					$this->data['title'] = "Progress Siswa {$dataSiswa["data"][0]["nama_user"]} " . $dataMapel['data'][0]['nama_mapel'];
					$this->data['content'] = "instruktur.progress-siswa";
					$this->data['kelas'] = $dataKelas['data'][0];
					$this->data['mapel'] = $dataMapel['data'][0];
					$this->data['siswa'] = $dataSiswa['data'][0];
					$this->data['id'] = $dataSiswa['data'][0]['id_user'];

					$allBab = $this->BackBabModel->getAllByMapel($dataMapel["data"][0]["id_mapel"]);

					$jmlMateri = 0;
					$jmlMateriSelesai = 0;


					if ($allBab["total"] > 0) {
						foreach ($allBab["data"] as $keyBab => $valueBab) {

							$materiSelesaiPerBab = 0;
							$belumDiNilai = 0;

							$allMateri = $this->BackMateriModel->getAllByBab($valueBab["id_bab"]);

							if ($allMateri["total"] > 0) {
								foreach ($allMateri["data"] as $keyMateri => $valueMateri) {
									if ($keyBab == 0 && $keyMateri == 0) {
										$materiPertama = $valueMateri["id_materi"];
										$babPertama = $valueMateri["bab_id"];
									}
									if ($valueMateri["tipe"] == "video") {
										$logVideo = $this->UniversalModel->getOneData("log_video", "user_id = {$idUser} AND materi_id = {$valueMateri["id_materi"]}");

										$allMateri["data"][$keyMateri]["log"] = $logVideo;
									} elseif ($valueMateri["tipe"] == "teks") {
										$logBaca = $this->UniversalModel->getOneData("log_baca", "user_id = {$idUser} AND materi_id = {$valueMateri["id_materi"]}");

										$allMateri["data"][$keyMateri]["log"] = $logBaca;
									} elseif ($valueMateri["tipe"] == "praktek") {
										$logPraktek = $this->UniversalModel->getAllData("log_praktek", "user_id = {$idUser} AND materi_id = {$valueMateri["id_materi"]}");

										$allMateri["data"][$keyMateri]["log"] = $logPraktek;

										if ($logPraktek["total"] > 0) {
											if ($logPraktek["data"][0]["status_baca_instruktur"] == 0) {
												$belumDiNilai++;
											}
										}
									} elseif ($valueMateri["tipe"] == "pilihan") {
										$logUjian = $this->UniversalModel->getAllData("log_ujian", "user_id = {$idUser} AND materi_id = {$valueMateri["id_materi"]}");

										if ($logUjian["total"] > 0) {
											$jawabanSiswa = $this->BackMateriModel->getAllJawabanLogUjian($valueMateri["id_materi"], $logUjian["data"][0]["id_log_ujian"]);
											$logUjian["data"][0]["jawaban"] = $jawabanSiswa;
										}

										$allMateri["data"][$keyMateri]["log"] = $logUjian;
									} else {
										$allMateri["data"][$keyMateri]["log"]["total"] = 0;
										$allMateri["data"][$keyMateri]["log"]["data"] = [];
									}

									if ($allMateri["data"][$keyMateri]["log"]["total"] > 0) {
										$jmlMateriSelesai++;
										$materiSelesaiPerBab++;
									}

									$jmlMateri++;
								}
							}

							$allBab["data"][$keyBab]["persentase"] = $allMateri["total"] > 0 ? ceil(($materiSelesaiPerBab / $allMateri["total"]) * 100) : 0;
							$allBab["data"][$keyBab]["belumDiNilai"] = $belumDiNilai;
							$allBab["data"][$keyBab]["materi"] = $allMateri;
						}
					}

					$persentase = ceil(($jmlMateriSelesai / $jmlMateri) * 100);

					$this->data["persentase"] = $persentase;
					$this->data["materi"] = $allBab;
					$this->data["materiPertama"] = $materiPertama;
					$this->data["babPertama"] = $babPertama;
					$this->data["raporAllowed"] = $this->UniversalModel->getOneData("user_mapel_progress", "user_id = {$idUser} AND mapel_id = {$this->data['mapel']['id_mapel']}")["data"]["raport_allowed"];

					//INDIKATOR
					$dataKompetensi = $this->BackKompetensiModel->getAllByMapel($dataMapel["data"][0]["id_mapel"]);
					$kompetensi = [];

					if ($dataKompetensi["total"] > 0) {
						$keyKompetensi_urutan = 0;
						foreach ($dataKompetensi["data"] as $keyKompetensi => $valueKompetensi) {
							$indikatorInduk = $this->BackIndikatorIndukModel->getAllByKompetensi($valueKompetensi["id_kompetensi"]);

							if ($indikatorInduk["total"] > 0) {
								foreach ($indikatorInduk["data"] as $keyIndikatorInduk => $valueIndikatorInduk) {
									$indikator = $this->BackIndikatorModel->getAllJoinJawabanByKompetensiAndIndikatorInduk($valueKompetensi["id_kompetensi"], $valueIndikatorInduk["id_indikator_induk"], $idUser);

									$indikatorInduk["data"][$keyIndikatorInduk]["indikator"] = $indikator;
								}
								// Set based on urutannya atau based on bab
								// Karena beberapa indikator lama tidak menyertakan bab per indikator
								if ($valueKompetensi["bab_id"] == "") {
									$indeksKompetensi = $keyKompetensi_urutan;
								} else {
									$indeksKompetensi = $valueKompetensi["bab_id"];
								}

								$kompetensi["data"][$indeksKompetensi]["indikatorInduk"] = $indikatorInduk;
								$keyKompetensi_urutan++;
							}
						}
					}

					$this->data["kompetensi"] = $kompetensi;


					// return $this->output
					// ->set_content_type('application/json')
					// ->set_status_header(200)
					// ->set_output(json_encode($this->data));

					$this->load->view('back/main', $this->data);
				} else {
					redirect(base_url('back/not-found'));
				}
			} else {
				redirect(base_url('back/not-found'));
			}
		} else {
			redirect(base_url('back/not-found'));
		}
	}

	public function indikatorSiswa($metaMapel = "", $idUser = 0)
	{
		$dataSiswa = $this->BackSiswaModel->getById($idUser);
		$materiPertama = 0;
		$babPertama = 0;
		if ($dataSiswa["total"] >= 1) {
			$dataMapel = $this->BackMapelModel->getByMeta($metaMapel);

			if ($dataMapel['total'] >= 1) {

				$dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

				if ($dataKelas['total'] >= 1) {
					$this->data['title'] = "Penilaian Indikator Siswa {$dataSiswa["data"][0]["nama_user"]} " . $dataMapel['data'][0]['nama_mapel'];
					$this->data['content'] = "instruktur.penilaian-indikator";
					$this->data['kelas'] = $dataKelas['data'][0];
					$this->data['mapel'] = $dataMapel['data'][0];
					$this->data['siswa'] = $dataSiswa['data'][0];
					$this->data['id'] = $dataSiswa['data'][0]['id_user'];

					$kompetensi = $this->BackKompetensiModel->getAllByMapel($dataMapel["data"][0]["id_mapel"]);

					if ($kompetensi["total"] > 0) {
						foreach ($kompetensi["data"] as $keyKompetensi => $valueKompetensi) {
							$indikatorInduk = $this->BackIndikatorIndukModel->getAllByKompetensi($valueKompetensi["id_kompetensi"]);

							if ($indikatorInduk["total"] > 0) {
								foreach ($indikatorInduk["data"] as $keyIndikatorInduk => $valueIndikatorInduk) {
									$indikator = $this->BackIndikatorModel->getAllJoinJawabanByKompetensiAndIndikatorInduk($valueKompetensi["id_kompetensi"], $valueIndikatorInduk["id_indikator_induk"], $idUser);

									$indikatorInduk["data"][$keyIndikatorInduk]["indikator"] = $indikator;
								}
							}

							$kompetensi["data"][$valueKompetensi["bab_id"]]["indikatorInduk"] = $indikatorInduk;
						}
					}


					$this->data["kompetensi"] = $kompetensi;

					$this->load->view('back/main', $this->data);
				} else {
					redirect(base_url('back/not-found'));
				}
			} else {
				redirect(base_url('back/not-found'));
			}
		} else {
			redirect(base_url('back/not-found'));
		}
	}

	public function raportSiswa($metaMapel = "", $idUser = 0)
	{
		$dataSiswa = $this->BackSiswaModel->getById($idUser);
		$materiPertama = 0;
		$babPertama = 0;
		if ($dataSiswa["total"] >= 1) {
			$dataMapel = $this->BackMapelModel->getByMeta($metaMapel);

			if ($dataMapel['total'] >= 1) {

				$dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

				if ($dataKelas['total'] >= 1) {

					$this->data['title'] = "Raport Siswa {$dataSiswa["data"][0]["nama_user"]} " . $dataMapel['data'][0]['nama_mapel'];
					$this->data['kelas'] = $dataKelas['data'][0];
					$this->data['mapel'] = $dataMapel['data'][0];
					$this->data['siswa'] = $dataSiswa['data'][0];
					$this->data['id'] = $dataSiswa['data'][0]['id_user'];

					$kompetensi = $this->BackKompetensiModel->getAllByMapel($dataMapel["data"][0]["id_mapel"]);

					if ($kompetensi["total"] > 0) {
						foreach ($kompetensi["data"] as $keyKompetensi => $valueKompetensi) {

							$nilaiMaks = 0;
							$nilaiKompetensi = 0;
							$indikatorInduk = $this->BackIndikatorIndukModel->getAllByKompetensi($valueKompetensi["id_kompetensi"]);

							if ($indikatorInduk["total"] > 0) {
								foreach ($indikatorInduk["data"] as $keyIndikatorInduk => $valueIndikatorInduk) {
									$indikator = $this->BackIndikatorModel->getAllJoinJawabanByKompetensiAndIndikatorInduk($valueKompetensi["id_kompetensi"], $valueIndikatorInduk["id_indikator_induk"], $idUser);

									if ($indikator["total"] > 0) {
										foreach ($indikator["data"] as $keyIndikator => $valueIndikator) {
											$nilaiKompetensi += $valueIndikator["nilai"];
											$nilaiMaks += 10;
										}
									}

									$indikatorInduk["data"][$keyIndikatorInduk]["indikator"] = $indikator;
								}
							}

							$kompetensi["data"][$keyKompetensi]["nilaiMaks"] = $nilaiMaks;
							$kompetensi["data"][$keyKompetensi]["nilaiUser"] = $nilaiKompetensi;
							$kompetensi["data"][$keyKompetensi]["nilai"] = $nilaiMaks == 0 ? 0 : ceil($nilaiKompetensi / $nilaiMaks * 100);

							$kompetensi["data"][$keyKompetensi]["indikatorInduk"] = $indikatorInduk;
						}
					}


					$allBab = $this->BackBabModel->getAllByMapel($dataMapel["data"][0]["id_mapel"]);

					$jmlMateri = 0;
					$jmlMateriSelesai = 0;


					if ($allBab["total"] > 0) {
						foreach ($allBab["data"] as $keyBab => $valueBab) {

							$materiSelesaiPerBab = 0;
							$belumDiNilai = 0;

							$allMateri = $this->BackMateriModel->getAllByBab($valueBab["id_bab"]);

							if ($allMateri["total"] > 0) {
								foreach ($allMateri["data"] as $keyMateri => $valueMateri) {
									if ($keyBab == 0 && $keyMateri == 0) {
										$materiPertama = $valueMateri["id_materi"];
										$babPertama = $valueMateri["bab_id"];
									}
									if ($valueMateri["tipe"] == "video") {
										$logVideo = $this->UniversalModel->getOneData("log_video", "user_id = {$idUser} AND materi_id = {$valueMateri["id_materi"]}");

										$allMateri["data"][$keyMateri]["log"] = $logVideo;
									} elseif ($valueMateri["tipe"] == "teks") {
										$logBaca = $this->UniversalModel->getOneData("log_baca", "user_id = {$idUser} AND materi_id = {$valueMateri["id_materi"]}");

										$allMateri["data"][$keyMateri]["log"] = $logBaca;
									} elseif ($valueMateri["tipe"] == "praktek") {
										$logPraktek = $this->UniversalModel->getAllData("log_praktek", "user_id = {$idUser} AND materi_id = {$valueMateri["id_materi"]}");

										$allMateri["data"][$keyMateri]["log"] = $logPraktek;

										if ($logPraktek["total"] > 0) {
											if ($logPraktek["data"][0]["status_baca_instruktur"] == 0) {
												$belumDiNilai++;
											}
										}
									} elseif ($valueMateri["tipe"] == "pilihan") {
										$logUjian = $this->UniversalModel->getAllData("log_ujian", "user_id = {$idUser} AND materi_id = {$valueMateri["id_materi"]}");

										if ($logUjian["total"] > 0) {
											$jawabanSiswa = $this->BackMateriModel->getAllJawabanLogUjian($valueMateri["id_materi"], $logUjian["data"][0]["id_log_ujian"]);
											$logUjian["data"][0]["jawaban"] = $jawabanSiswa;
										}

										$allMateri["data"][$keyMateri]["log"] = $logUjian;
									} else {
										$allMateri["data"][$keyMateri]["log"]["total"] = 0;
										$allMateri["data"][$keyMateri]["log"]["data"] = [];
									}

									if ($allMateri["data"][$keyMateri]["log"]["total"] > 0) {
										$jmlMateriSelesai++;
										$materiSelesaiPerBab++;
									}

									$jmlMateri++;
								}
							}

							$allBab["data"][$keyBab]["persentase"] = $allMateri["total"] > 0 ? ceil(($materiSelesaiPerBab / $allMateri["total"]) * 100) : 0;
							$allBab["data"][$keyBab]["belumDiNilai"] = $belumDiNilai;
							$allBab["data"][$keyBab]["materi"] = $allMateri;
						}
					}

					$persentase = ceil(($jmlMateriSelesai / $jmlMateri) * 100);

					$this->data["persentase"] = $persentase;
					$this->data["materi"] = $allBab;
					$this->data["materiPertama"] = $materiPertama;
					$this->data["babPertama"] = $babPertama;


					$this->data["kompetensi"] = $kompetensi;

					// return $this->output
					//			->set_content_type('application/json')
					//			->set_status_header(200)
					//			->set_output(json_encode($this->data));

					$this->load->view('back/instruktur/raport-siswa/raport-siswa', $this->data);
				} else {
					redirect(base_url('back/not-found'));
				}
			} else {
				redirect(base_url('back/not-found'));
			}
		} else {
			redirect(base_url('back/not-found'));
		}
	}
}
