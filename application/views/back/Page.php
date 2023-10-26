<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Page extends CI_Controller
{

	private $data;

	public function __construct()
	{
		parent::__construct();
		$this->data['page'] = "home";

		$this->load->model("front-v2/KelasModel", "FrontKelasModel");
		$this->load->model("front-v2/PaketModel", "FrontPaketModel");
		$this->load->model("front-v2/MapelModel", "FrontMapelModel");
		$this->load->model("front-v2/BabModel", "FrontBabModel");
		$this->load->model("front-v2/MateriModel", "FrontMateriModel");
		$this->load->model("front-v2/UlasanModel", "FrontUlasanModel");
	}

	public function logout()
	{
		$this->session->unset_userdata('siswaData');
		unset($_SESSION["raporIdUser"]);
		unset($_SESSION["idMapelBeli"]);

		redirect(base_url());
	}

	public function index()
	{
		$this->data['title'] = "Home";
		$this->data['content'] = "dashboard";

		$getAllKelas = $this->FrontKelasModel->getAllKelas();

		if ($getAllKelas["total"] > 0) {
			foreach ($getAllKelas["data"] as $keyKelas => $valueKelas) {
				$getAllMapel = $this->FrontMapelModel->getAllMapel("mapel.kelas_id = {$valueKelas["id_kelas"]}", "rating_rata", "DESC", 40);
				$getAllKelas["data"][$keyKelas]["mapel"] = $getAllMapel;
			}
		}

		$this->data['dataKelas'] = $getAllKelas;

		$getAllPaket = $this->FrontPaketModel->getPaket();

		$this->data['dataPaket'] = $getAllPaket;

		//		$getAllMapel = $this->FrontMapelModel->getAllMapel("", "rating_rata", "DESC", 12);
		//
		//		$this->data['dataMapel'] = $getAllMapel;

		$getAllMapelPrakerja = $this->FrontMapelModel->getAllMapelPrakerja("mapel.prakerja = 1", "rating_rata", "DESC", 12);

		$this->data['dataMapelPrakerja'] = $getAllMapelPrakerja;

		$this->data['dataTestimoni'] = $this->FrontUlasanModel->getAllTestimoni(3)["data"];

		$this->load->view("front-v2/main", $this->data);
	}

	public function tentang()
	{

		$this->data['title'] = "Tentang";
		$this->data['content'] = "tentang";

		$this->load->view("front-v2/main", $this->data);
	}

	public function profil($aksi = "")
	{

		$this->data['title'] = "Profil";
		$this->data['content'] = "profil";
		if ($aksi != "") {
			$this->data['content'] = "profil.profil-" . $aksi;
		}

		$this->load->view("front-v2/main", $this->data);
	}

	public function kursus($jenis = "list", $meta_link_mapel = "")
	{
		$this->data['title'] = "Kursus " . $jenis;
		$this->data['content'] = "kursus.kursus-" . $jenis;

		$this->data = $this->cariKursus();

		if ($jenis == "detail") {
			$where = "meta_link_mapel = '$meta_link_mapel'";

			$mapelQuery = $this->FrontMapelModel->getAllMapel($where);
			$getMapelSatuan = $mapelQuery["data"][0];
			if ($meta_link_mapel == "" || $mapelQuery["total"] == 0) {
				redirect(base_url());
			}
			$where = "id_kelas = " . $getMapelSatuan["kelas_id"];
			$getKelasSatuan = $this->FrontKelasModel->getAllKelas($where)["data"][0];

			$this->data["valueMapel"] = $getMapelSatuan;
			foreach ($getKelasSatuan as $key => $val) {
				$this->data["valueMapel"][$key] = $val;
			}
			$this->data['title'] .= " " . $this->data["valueMapel"]["nama_mapel"];
			// dataMapel
		}
		$this->load->view("front-v2/main", $this->data);
	}


	public function paket($meta_link = "")
	{
		$this->data['title'] = "Paket ";
		$this->data['content'] = "paket";

		$getAllPaket = $this->FrontPaketModel->getPaket();

		$this->data['dataPaket'] = $getAllPaket;
		// if ($meta_link == "") {
		// 	redirect(base_url() . "v2");
		// }
		$this->load->view("front-v2/main", $this->data);
	}

	public function kelas()
	{
		$this->data['title'] = "Daftar Kelas";
		$this->data['content'] = "kelas";

		$this->data["dataKelas"] = $this->FrontKelasModel->getAllKelas();
		$this->data["dataMapel"] = $this->FrontMapelModel->getAllMapel("", "rating_rata", "DESC", 1);

		$this->load->view("front-v2/main", $this->data);
	}


	public function materi($jenis = "teks")
	{

		$this->data['title'] = "Materi";
		$this->data['content'] = "materi.materi-" . $jenis;

		$this->load->view("front-v2/main", $this->data);
	}


	public function keranjang()
	{

		$this->data['title'] = "Keranjang";
		$this->data['content'] = "keranjang";

		$this->load->view("front-v2/main", $this->data);
	}


	public function konfirmasi()
	{

		$this->data['title'] = "Konfirmasi";
		$this->data['content'] = "konfirmasi";

		$this->load->view("front-v2/main", $this->data);
	}


	public function sertifikatDownload($meta_link_mapel = "")
	{
		$where = "meta_link_mapel = '{$meta_link_mapel}'";

		$dataMapel = $this->FrontMapelModel->getAllMapel($where);

		if ($dataMapel["total"] > 0) {
			$mapel = $dataMapel["data"][0];

			$id_mapel = $mapel["id_mapel"];
			$meta_link_mapel = $mapel["meta_link_mapel"];
			$id_user = $_SESSION['siswaData']['id_user'];

			$this->data["mapel"] = $mapel;

			$dataUlasan = $this->FrontUlasanModel->getByUlasan($id_user, $id_mapel);
			if ($dataUlasan["total"] > 0) {
				try {

					$namaMurid = $_SESSION['siswaData']['nama_user'];
					$lengthNamaMurid = strlen($namaMurid);
					$fontsizeNamaMurid = 20;
					$namaMuridArray = [];
					if ($lengthNamaMurid > 32) {
						$sisa = $lengthNamaMurid - 32;

						if ($sisa > 6) {
							$namaMuridArray = str_split($namaMurid, 32);
						} else {
							$fontsizeNamaMurid -= 4;
						}
					}

					$namaInstruktur = $mapel["nama_instruktur"];
					$lengthNamaInstruktur = strlen($namaInstruktur);
					$fontsizeNamaInstruktur = 20;
					$namaInstrukturArray = [];
					if ($lengthNamaInstruktur > 20) {
						$sisa = $lengthNamaInstruktur - 20;

						if ($sisa > 6) {
							$namaInstrukturArray = str_split($namaInstruktur, 20);
						} else {
							$fontsizeNamaInstruktur -= 4;
						}
					}

					$namaOwner = "Nizar Luthfiansyah";
					$lengthNamaOwner = strlen($namaOwner);
					$fontsizeNamaOwner = 16;
					$namaOwnerArray = [];
					if ($lengthNamaOwner > 20) {
						$sisa = $lengthNamaOwner - 20;

						if ($sisa > 6) {
							$namaOwnerArray = str_split($namaOwner, 20);
						} else {
							$fontsizeNamaOwner -= 4;
						}
					}

					$namaMapel = $mapel["nama_mapel"];

					$lengthNamaMapel = strlen($namaMapel);

					$fontsizeNamaMapel = 20;
					$namaMapelArray = [];
					if ($lengthNamaMapel > 32) {
						$sisa = $lengthNamaMapel - 32;

						if ($sisa > 6) {
							$namaMapelArray = str_split($namaMapel, 32);
						} else {
							$fontsizeNamaMapel -= 4;
						}
					}


				// 	$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
				// 	$fontData = $defaultFontConfig['fontdata'];

				// 	$fontData = $fontData + [
				// 		"bebasneue" => [
				// 			"R" => "BebasNeue-Regular.ttf"
				// 		],
				// 		"opensans"  => [
				// 			"R" => "OpenSans-Regular.ttf",
				// 			"I" => "OpenSans-Italic.ttf",
				// 			"B" => "OpenSans-Bold.ttf"
				// 		]
				// 	];

				// 	$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L', "fontdata" => $fontData, 'default_font' => 'bebasneue']);

				// 	$mpdf->setTitle($mapel["nama_mapel"]);


				// 	$pageCount = $mpdf->setSourceFile("./upload/Sertifikat-09.pdf");
				// 	$tplId = $mpdf->importPage($pageCount);
				// 	$mpdf->SetPageTemplate($tplId);
				// 	$mpdf->AddFontDirectory("../assets/front/v2/fonts");

				    $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
                    $fontDirs = $defaultConfig['fontDir'];

                    $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
                    $fontData = $defaultFontConfig['fontdata'];

                    $mpdf = new \Mpdf\Mpdf([
                        'fontDir'      => array_merge($fontDirs, [
                            __DIR__ . '/vendor/mpdf/mpdf/ttfonts',
                        ]),
                        'fontdata'     => $fontData + [
                                'bebasneue' => [
                                    'R' => '-Regular.ttf',
                                ],
                                "opensans"  => [
        							"R" => "OpenSans-Regular.ttf",
        							"I" => "OpenSans-Italic.ttf",
        							"B" => "OpenSans-Bold.ttf"
        						]
                            ],
                        'default_font' => 'merriweather'
                    ]);

                    $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L', "fontdata" => $fontData, 'default_font' => 'bebasneue']);

					$mpdf->setTitle($mapel["nama_mapel"]);

					$pageCount = $mpdf->setSourceFile("./upload/Sertifikat-09.pdf");
					$tplId = $mpdf->importPage($pageCount);
					$mpdf->SetPageTemplate($tplId);

					$mpdf->WriteFixedPosHTML("
                        <h1 style='font-family: bebasneue;color: #f5b21b;font-size: 45px;font-weight: 100'>CERTIFICATE OF ACHIEVEMENT</h1>
                    ", 36, 15, 200, 50);

					//PRINT NAMA

					$awal = 69;
					if (count($namaMuridArray) > 0) {
						foreach ($namaMuridArray as $key => $value) {
							$mpdf->WriteFixedPosHTML("
                        <h1 style='font-family: opensans;color: #f5b21b;font-size: {$fontsizeNamaMurid}px;font-weight: bold'>{$value}</h1>
                    ", 37, $awal, 200, 50);
							$awal += 8;
						}
					} else {
						$awal += 4;
						$mpdf->WriteFixedPosHTML("
                        <h1 style='font-family: opensans;color: #f5b21b;font-size: {$fontsizeNamaMurid}px;font-weight: bold'>{$namaMurid}</h1>
                    ", 37, $awal, 200, 50);
					}


					//PRINT NAMA MATA PELAJARAN

					$awal = 92;
					if (count($namaMapelArray) > 0) {
						foreach ($namaMapelArray as $key => $value) {
							$mpdf->WriteFixedPosHTML("
                        <h1 style='font-family: opensans;color: #f5b21b;font-size: {$fontsizeNamaMapel}px;font-weight: bold'>{$value}</h1>
                    ", 37, $awal, 200, 50);
							$awal += 8;
						}
					} else {
						$awal += 4;
						$mpdf->WriteFixedPosHTML("
                        <h1 style='font-family: opensans;color: #f5b21b;font-size: {$fontsizeNamaMapel}px;font-weight: bold'>{$namaMapel}</h1>
                    ", 37, $awal, 200, 50);
					}

					$mpdf->Image('upload/tanda_tangan/' . $mapel["tanda_tangan_instruktur"], 37, 140, 40, 40, 'jpg', '', true, false);
					$mpdf->Image('upload/tanda_tangan/nizar.png', 105, 140, 40, 40, 'jpg', '', true, false);


					if (count($namaInstrukturArray) > 0) {
						$awal = 164;
						foreach ($namaInstrukturArray as $key => $value) {
							$mpdf->WriteFixedPosHTML("
                        <h1 style='font-family: opensans;color: #fff;font-size: {$fontsizeNamaInstruktur}px;font-weight: bold'>{$value}</h1>
                    ", 37, $awal, 200, 50);
							$awal += 8;
						}
					} else {
						$mpdf->WriteFixedPosHTML("
                        <h1 style='font-family: opensans;color: #fff;font-size: {$fontsizeNamaInstruktur}px;font-weight: bold'>{$namaInstruktur}</h1>
                    ", 37, 172, 200, 50);
					}

					if (count($namaOwnerArray) > 0) {
						$awal = 164;
						foreach ($namaOwnerArray as $key => $value) {
							$mpdf->WriteFixedPosHTML("
                        <h1 style='font-family: opensans;color: #fff;font-size: {$fontsizeNamaOwner}px;font-weight: bold'>{$value}</h1>
                    ", 105, $awal, 200, 50);
							$awal += 8;
						}
					} else {
						$mpdf->WriteFixedPosHTML("
                        <h1 style='font-family: opensans;color: #fff;font-size: {$fontsizeNamaOwner}px;font-weight: bold'>{$namaOwner}</h1>
                    ", 105, 172, 200, 50);
					}

					$mpdf->Output();
				} catch (\Mpdf\MpdfException $e) {
					echo $e->getMessage();
				}
			} else {
				if ($mapel["progress"] >= 100) {
					alert("danger", "Anda belum mengulas", "Sebelum mengakses sertifikat, isi terlebih dahulu ulasan");
				}
				redirect(base_url("ulasan/" . $meta_link_mapel));
			}
		} else {
			$this->data["title"] = "Kursus Tidak Di Temukan";
			$this->data["content"] = "404";
			$this->load->view("front-v2/main", $this->data);
		}
	}

	public function portofolio()
	{
		$this->data['title'] = "Portofolio";
		$this->data['content'] = "portofolio";

		$this->load->view("front-v2/main", $this->data);
	}

	public function detailPortofolio()
	{
		$this->data['title'] = "Detail Portofolio";
		$this->data['content'] = "portofolio.detail";

		$this->load->view("front-v2/main", $this->data);
	}

	public function prakerja()
	{
		$getAllMapelPrakerja = $this->FrontMapelModel->getAllMapelPrakerja("mapel.prakerja = 1", "rating_rata", "DESC", 12);

		$this->data['dataMapelPrakerja'] = $getAllMapelPrakerja;

		$this->data['title'] = "Prakerja";
		$this->data['content'] = "prakerja";

		$this->load->view("front-v2/main", $this->data);
	}

    public function voucher()
    {
//        $getAllMapelPrakerja = $this->FrontMapelModel->getAllMapelPrakerja("mapel.prakerja = 1", "rating_rata", "DESC", 12);
//
//        $this->data['dataMapelPrakerja'] = $getAllMapelPrakerja;

        $this->data['title'] = "Claim Voucher";
        $this->data['content'] = "voucher";

        $this->load->view("front-v2/main", $this->data);
    }

	public function gamification()
	{
//		$getAllMapelPrakerja = $this->FrontMapelModel->getAllMapelPrakerja("mapel.prakerja = 1", "rating_rata", "DESC", 12);
//		$this->data['dataMapelPrakerja'] = $getAllMapelPrakerja;

		$this->data['title'] = "Karisma Gold";
		$this->data['content'] = "gamification";

		$this->load->view("front-v2/main", $this->data);
	}
}
