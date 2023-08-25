<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Raport extends CI_Controller
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
		$this->load->model('back/KompetensiModel', 'BackKompetensiModel', true);
		$this->load->model('back/IndikatorIndukModel', 'BackIndikatorIndukModel', true);
		$this->load->model('back/IndikatorModel', 'BackIndikatorModel', true);

		$this->FrontAuthModel->isLoggedIn();
	}

	public function index($meta_link_mapel = "", $idUser = "")
	{

		$where = "meta_link_mapel = '{$meta_link_mapel}'";

		$dataMapel = $this->FrontMapelModel->getAllMapel($where);

		if ($dataMapel["total"] > 0) {
			$idUser = $_SESSION['siswaData']['id_user'];
			$nama_user = $_SESSION['siswaData']['nama_user'];
			$tempat_lahir = $_SESSION['siswaData']['tempat_lahir'];
			$tanggal_lahir = $_SESSION['siswaData']['tanggal_lahir'];


			$mapel = $dataMapel["data"][0];

			$raport_allowed = $this->UniversalModel->getOneData("user_mapel_progress", "user_id = {$idUser} AND mapel_id = {$mapel['id_mapel']}")["data"]["raport_allowed"];

			if ($raport_allowed == 0) {
				alert("danger", "Instruktur belum memperbolehkan", "Silahkan kontak instruktur anda");
				redirect(base_url("profil"));
			} else {
				try {
					if (in_array($mapel["id_mapel"], $_SESSION["idMapelBeli"]) == false) {
						redirect("kursus/detail/{$meta_link_mapel}");
					}

					$allBab = $this->FrontBabModel->getAllBab("mapel_id = {$mapel["id_mapel"]}");

					$nilaiUjian_temp = 0;
					$nilaiPraktek_temp = 0;
					$nilaiBab_array = array();
					$nilaiUjian = 0;
					$nilaiPraktek = 0;
					$nilaiAkhir = 0;
					$jmlUjian = 0;
					$jmlPraktek = 0;

					$lastTanggal = date("Y-m-d");

					if ($allBab["total"] > 0) {
						foreach ($allBab["data"] as $keyBab => $valueBab) {
							$materi = $this->FrontMateriModel->getAllMateriWithLog("bab_id = {$valueBab["id_bab"]}");

							if ($materi["total"] > 0) {
								foreach ($materi["data"] as $keyMateri => $valueMateri) {
									$indeksKompetensi = $valueBab["urutan_bab"];
									if ($valueMateri["tipe"] == "pilihan") {

										$lastTanggal = $valueMateri["tanggal_ujian"];


										$nilaiUjian_temp = (float)$valueMateri["nilai_ujian"];
										$nilaiBab_array[$indeksKompetensi]["teori"] = $nilaiUjian_temp;
										if ($valueBab["pretest_status"] != 1) {
											$nilaiUjian += $nilaiUjian_temp;
											$jmlUjian++;
										}
									}
								}
							}
						}
					}


					$kompetensi = $this->BackKompetensiModel->getAllByMapel($mapel["id_mapel"]);
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

							$kompetensi["data"][$keyKompetensi]["indikatorInduk"] = $indikatorInduk;

							//Khusus praktek, penilaian ada di indikator
							$nilaiPraktek_temp = $nilaiMaks == 0 ? 0 : ceil($nilaiKompetensi / $nilaiMaks * 100);

							$kompetensi["data"][$keyKompetensi]["nilai"] = $nilaiPraktek_temp;
							$nilaiBab_array[$keyKompetensi + 1]["praktek"] = $nilaiPraktek_temp;

							if ($valueKompetensi["pretest_status"] != 1) {
								$nilaiPraktek += $nilaiPraktek_temp;
								$jmlPraktek++;
							}
						}
					}


					//TOTAL COUNT dan RATA-RATA
					$nilaiUjian /= $jmlUjian;
					$nilaiPraktek /= $jmlPraktek;

					$nilaiAkhir = ($nilaiUjian * 30 / 100) + ($nilaiPraktek * 70 / 100);

					// return $this->output
					//          ->set_content_type('application/json')
					//          ->set_status_header(200)
					//          ->set_output(json_encode($kompetensi));

					$defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
					$fontData = $defaultFontConfig['fontdata'];

					$mpdf = new \Mpdf\Mpdf(
						[
							'mode'         => 'utf-8',
							'format'       => 'A4-P',
							'fontdata'     => $fontData + [
									"bebasneue" => [
										"R" => "BebasNeue-Regular.ttf"
									],
									"opensans"  => [
										"R" => "OpenSans-Regular.ttf",
										"I" => "OpenSans-Italic.ttf",
										"B" => "OpenSans-Bold.ttf"
									],
								],
							'default_font' => 'bebasneue'
						]
					);

					$mpdf->setTitle($mapel["nama_mapel"]);

					$pageCount = $mpdf->setSourceFile("./upload/Raport-10.pdf");
					$tplId = $mpdf->importPage($pageCount);
					$mpdf->SetPageTemplate($tplId);
					$mpdf->AddFontDirectory("./assets/front/v2/fonts");

					//NOMOR PESERTA
					$mpdf->WriteFixedPosHTML("
                        <span style='font-family: opensans;font-size: 15px;'>No. Peserta</span>
                    ", 15, 45, 200, 50);
					$mpdf->WriteFixedPosHTML("
                        <span style='font-family: opensans;font-size: 15px;font-weight: bold'>:</span>
                    ", 58, 45, 200, 50);
					$mpdf->WriteFixedPosHTML("
                        <span style='font-family: opensans;font-size: 15px;font-weight: bold'>{$idUser}</span>
                    ", 62, 45, 200, 50);

					//Tanggal Uji Kompetensi
					$mpdf->WriteFixedPosHTML("
                        <span style='font-family: opensans;font-size: 15px;'>Tgl Uji Kompetensi</span>
                    ", 160, 52, 200, 50);
					$mpdf->WriteFixedPosHTML("
                        <span style='font-family: opensans;font-size: 15px;font-weight: bold'>" . formatTanggal2($lastTanggal) . "</span>
                    ", 162, 59, 200, 50);

					//NAMA PESERTA
					$mpdf->WriteFixedPosHTML("
                        <span style='font-family: opensans;font-size: 15px;'>Nama Peserta</span>
                    ", 15, 52, 200, 50);
					$mpdf->WriteFixedPosHTML("
                        <span style='font-family: opensans;font-size: 15px;font-weight: bold'>:</span>
                    ", 58, 52, 200, 50);
					$mpdf->WriteFixedPosHTML("
                        <span style='font-family: opensans;font-size: 15px;font-weight: bold'>{$nama_user}</span>
                    ", 62, 52, 200, 50);

					//NAMA PESERTA
					$mpdf->WriteFixedPosHTML("
                        <span style='font-family: opensans;font-size: 15px;'>Tempat, Tanggal Lahir</span>
                    ", 15, 59, 200, 50);
					$mpdf->WriteFixedPosHTML("
                        <span style='font-family: opensans;font-size: 15px;font-weight: bold'>:</span>
                    ", 58, 59, 200, 50);
					$mpdf->WriteFixedPosHTML("
                        <span style='font-family: opensans;font-size: 15px;font-weight: bold'>{$tempat_lahir}, " . formatTanggal2($tanggal_lahir) . "</span>
                    ", 62, 59, 200, 50);

					//NILAI KOMPETENSI
					$mpdf->WriteFixedPosHTML("
                        <span style='font-family: opensans;font-size: 15px;font-weight: bold'>Nilai Kompetensi</span>
                    ", 15, 75, 200, 50);


					$start = 58;

					for ($i = 0; $i <= 10; $i++) {
						$j = $i == 0 ? 0 : $i . "0";
						$mpdf->WriteFixedPosHTML("
                        <span style='font-family: opensans;font-size: 15px;'>{$j}</span>
                    ", $start, 75, 200, 50);
						$start += 13;
					}


					//Uji Kompetensi Teori
					$mpdf->WriteFixedPosHTML("
                        <span style='font-family: opensans;font-size: 15px;'>Uji Kompetensi Teori</span>
                    ", 15, 90, $start, 50);

					$lebar = 13.4 * (($nilaiUjian == 0 ? 0.1 : $nilaiUjian) / 10);
					$mpdf->WriteFixedPosHTML("
                    <div style='background-color: #2843A4;height: 25px;width:100%'></div>
                    ", 59, 90, $lebar, 50);


					//Uji Kompetensi Praktek
					$mpdf->WriteFixedPosHTML("
                        <span style='font-family: opensans;font-size: 15px;'>Uji Kompetensi Praktik</span>
                    ", 15, 100, $start, 50);

					$lebar = 13.4 * (($nilaiPraktek == 0 ? 0.1 : $nilaiPraktek) / 10);
					$mpdf->WriteFixedPosHTML("
                    <div style='background-color: #F35500;height: 25px;width:100%'></div>
                    ", 59, 100, $lebar, 50);


					//NIlai Akhir Kompetensi
					$mpdf->WriteFixedPosHTML("
                        <span style='font-family: opensans;font-size: 15px;'>Nilai Akhir Kompetensi</span>
                    ", 15, 110, $start, 50);

					$lebar = 13.4 * (($nilaiAkhir == 0 ? 0.1 : $nilaiAkhir) / 10);
					$mpdf->WriteFixedPosHTML("
                    <div style='background-color: #290567;height: 25px;width:100%'></div>
                    ", 59, 110, $lebar, 50);


					//Lingkaran Ujian Teori
					$nilaiUjian = round($nilaiUjian, 1);
					$mpdf->WriteFixedPosHTML("
                        <div style='font-family: roboto; width: 120px;  height: 100px;padding-top: 20px;   border-radius: 50%; font-size: 40px;   color: #fff;  text-align: center;  background: #2843A4' class='circle'>
                        <span style='font-size: 20px;'>Teori</span><br>{$nilaiUjian}
                        </div>
                    ", 160, 140, 134, 50);


					//Lingkaran Ujian Praktek
					$nilaiPraktek = round($nilaiPraktek, 1);
					$mpdf->WriteFixedPosHTML("
                        <div style='font-family: roboto; width: 120px;  height: 100px;padding-top: 20px;   border-radius: 50%; font-size: 40px;   color: #fff;  text-align: center;  background: #F35500' class='circle'>
                        <span style='font-size: 20px;'>Praktek</span><br>{$nilaiPraktek}
                        </div>
                    ", 160, 175, 134, 50);


					//Lingkaran  Akhir Kompetensi
					$nilaiAkhir = round($nilaiAkhir, 1);
					$mpdf->WriteFixedPosHTML("
                        <div style='font-family: roboto; width: 120px;  height: 100px;padding-top: 20px;   border-radius: 50%; font-size: 40px;   color: #fff;  text-align: center;  background: #290567' class='circle'>
                        <span style='font-size: 18px;'>Nilai Akhir</span><br>{$nilaiAkhir}
                        </div>
                    ", 160, 210, 134, 50);

					//HERE
					$urutan = 0;
					if ($kompetensi["total"] > 0) {
						$start = 120;

						$mpdf->WriteFixedPosHTML("
                        <span style='font-family: opensans;font-size: 15px;font-weight: bold'>Analisa Kompetensi</span>
                        ", 15, 125, $start, 50);
						$start += 10;

						$urutan++;
						$isiNilai = "
                        <table style='font-family: opensans;width:100%;'>
                        <tr>
                        <th>No.</th>
                        <th>Indikator</th>
                        <th>T</th>
                        <th>P</th>
                        <th>A</th>
                        </tr>";

						foreach ($kompetensi["data"] as $keyKompetensi => $valueKomptensi) {
							$singleNilai = false;

							$warna = ($urutan % 2) == 0 ? "#fff" : "#EAE9EB";

							$indeksKompetensi = $urutan;

							$isiNilai .= "<tr style='background-color: {$warna};'>";

							$isiNilai .= "<td style='padding:5px 0; text-align:center;'>{$urutan}.</td>";
							$isiNilai .= "<td>{$valueKomptensi["kompetensi"]}</td>";


							//Teori
							$isiNilai .= "<td style='font-size: 15px;font-weight: bold;text-align:center;'>";
							if (isset($nilaiBab_array[$indeksKompetensi]["teori"])) {
								$nilaiTeori_temp = $nilaiBab_array[$indeksKompetensi]["teori"];
								$isiNilai .= "{$nilaiTeori_temp}";
							} else {
								$nilaiTeori_temp = 0;
								$isiNilai .= "-";

								$singleNilai = true;
							}
							$isiNilai .= "</td>";

							//Praktek
							$isiNilai .= "<td style='font-size: 15px;font-weight: bold;text-align:center;'>";
							if (isset($nilaiBab_array[$indeksKompetensi]["praktek"])) {
								$nilaiPraktek_temp = $nilaiBab_array[$indeksKompetensi]["praktek"];
								$isiNilai .= "{$nilaiPraktek_temp}";
							} else {
								$nilaiPraktek_temp = 0;
								$isiNilai .= "-";

								$singleNilai = true;
							}
							$isiNilai .= "</td>";

							if (!$singleNilai) {
								$nilaiPraktek_temp = $nilaiPraktek_temp * 70 / 100;
								$nilaiTeori_temp = $nilaiTeori_temp * 30 / 100;
							}

							$nilaiAkhir_temp = $nilaiPraktek_temp + $nilaiTeori_temp;

							if ($nilaiAkhir_temp >= 100) {
								$nilaiAkhir_temp = 100;
							} else if ($nilaiAkhir_temp <= 0) {
								$nilaiAkhir_temp = 0;
							}

							$kompetensi["data"][$keyKompetensi]["nilai"] = $nilaiAkhir_temp;

							$isiNilai .= "<td style='font-size: 15px;font-weight: bold;text-align:center;'>{$nilaiAkhir_temp}</td>";

							$isiNilai .= "</tr>";

							$urutan++;
						}

						$isiNilai .= "</table>";
						$mpdf->WriteFixedPosHTML($isiNilai, 15, $start, 120, 70);

						$start += 10;
					}

					$mpdf->Output();
				} catch (\Mpdf\MpdfException $e) {
					echo $e->getMessage();
				}
			}
		} else {
			$this->data["title"] = "Kursus Tidak Di Temukan";
			$this->data["content"] = "404";
			$this->load->view("front-v2/main", $this->data);
		}
	}
}
