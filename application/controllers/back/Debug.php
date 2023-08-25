<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Debug extends CI_Controller
{
	private $data;

	public function __construct()
	{
		parent::__construct();
		$this->data['menu'] = "Debug";
		$this->FrontAuthModel->isLoggedInAdmin();
		$this->load->model("front-v2/KelasModel", "FrontKelasModel");

		$this->load->model("front-v2/PaketModel", "FrontPaketModel");

		$this->load->model("front-v2/MapelModel", "FrontMapelModel");

		$this->load->model("front-v2/BabModel", "FrontBabModel");

		$this->load->model("front-v2/MateriModel", "FrontMateriModel");

		$this->load->model("front-v2/UlasanModel", "FrontUlasanModel");
	}

	public function index()
	{
		if ($this->db->dev) {
			$this->data['content'] = "debug";
			$this->data['link'] = $this->UniversalModel->getMetaLink("bab", "coba coba");

			$this->load->view('back/main', $this->data);
		} else {
			redirect(base_url("back"));
		}

	}

	public function sertifikat($meta_link_mapel = "", $id_user = "")
	{
		$uri_string = base_url() . $this->uri->uri_string();
		$user = $this->db->get_where('user', ['id_user' => $id_user])->row_array();



		$where = "meta_link_mapel = '{$meta_link_mapel}'";
		$dataMapel = $this->FrontMapelModel->getAllMapel($where);
		$mapel = $dataMapel["data"][0];
		$id_mapel = $mapel["id_mapel"];
		$id_kelas = $mapel["kelas_id"];
		$meta_link_mapel = $mapel["meta_link_mapel"];
		$randomcode = $id_mapel . $id_kelas . $id_user;
		$this->data["mapel"] = $mapel;
		$dataUlasan = $this->FrontUlasanModel->getByUlasan($id_user, $id_mapel);
		$namaMurid = $user['nama_user'];
		$namaInstruktur = $mapel["nama_instruktur"];
		$namaMapel = $mapel["nama_mapel"];
		$tanda_tangan = $mapel["tanda_tangan_instruktur"];
		try {
			setlocale(LC_TIME, 'id_ID');
			$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
			$fontDirs = $defaultConfig['fontDir'];
			$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
			$fontData = $defaultFontConfig['fontdata'];
			$mpdf = new \Mpdf\Mpdf([
				'fontDir' => array_merge($fontDirs, [

					__DIR__ . '/vendor/mpdf/mpdf/ttfonts',

				]),

				'fontdata' => $fontData + [

						"opensans" => [

							"R" => "OpenSans-Regular.ttf",

							"I" => "OpenSans-Italic.ttf",

							"B" => "OpenSans-Bold.ttf",

							"BI" => "OpenSans-BoldItalic.ttf",

							"SM" => "OpenSans-Semibold.ttf"

						]

					],

				'default_font' => 'merriweather'

			]);
			$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L', "fontdata" => $fontData, 'default_font' => 'bebasneue']);
			$mpdf->setTitle($mapel['nama_mapel']);
			$pdfFile = 'upload/Sertifikat-prakerj.pdf';
			$pageCount = $mpdf->SetSourceFile($pdfFile);

			$materi = $this->db->query("SELECT MAX( t1.urutan_bab ) AS urutan_bab, t1.id_materi FROM(SELECT t2.id_bab, t2.urutan_bab, t3.id_materi FROM mapel t1 JOIN bab t2 ON t1.id_mapel = t2.mapel_id JOIN materi t3 ON t3.bab_id = t2.id_bab WHERE t1.id_mapel = $id_mapel AND t3.tipe = 'praktek') t1")->row_array();

			$materi_id = $materi['id_materi'];
			$log_praktek = $this->db->query("SELECT t1.id_log_praktek,t1.materi_id,t1.user_id,t1.file,MAX(t1.nilai) AS nilai,t1.tipe FROM log_praktek t1 WHERE t1.user_id = $id_user AND t1.materi_id = $materi_id")->result_array();

			$nilai = $log_praktek['nilai'] ?? 0;

			$penyelesaian = true;


			if($penyelesaian){
				$templateId1 = $mpdf->ImportPage(3);
				$mpdf->UseTemplate($templateId1);
				//Nama Murid
				$mpdf->WriteFixedPosHTML("<h1 style='text-transform:capitalize;font-family: opensans; color: #232b39;font-size: 32;font-weight: bold;text-align:left;'>{$namaMurid}</h1>", 122, 50, 162, 50);
				//Judul Pelatihan
				$mpdf->WriteFixedPosHTML("<h1 style='font-family: opensans; color: #576270;font-size: 20;font-weight: bold;font-style:italic;text-align:left;padding-right:100px'>{$namaMapel}</h1>", 122, 86, 162, 50);
				//Durasi Belajar
				$mpdf->WriteFixedPosHTML("<h1 style='font-family: opensans; color: #136bb4;font-size: 18;font-weight: bold;text-align:left;text-transform:uppercase'>15 jam 00 menit</h1>", 187, 114, 162, 50);
			} else {
				$templateId1 = $mpdf->ImportPage(1);
				$mpdf->UseTemplate($templateId1);
				// Judul Pelatihan
				$mpdf->WriteFixedPosHTML("<h1 style='font-family: opensans; color: #576270;font-size: 20;font-weight: bold;font-style:italic;text-align:left;padding-right:100px'>{$namaMapel}</h1>", 122, 45, 162, 50);
				// Nama Peserta
				$mpdf->WriteFixedPosHTML("<h1 style='text-transform:capitalize;font-family: opensans; color: #232b39;font-size: 30;font-weight: bold;text-align:left;'>{$namaMurid}</h1>", 122, 82, 162, 50);
				// Waktu Penyelesaian
				$mpdf->WriteFixedPosHTML("<p style='font-family: opensans; color: #576270;font-size: 15;font-weight: bold;text-align:left;'>15 jam 0 menit</p>", 213.5, 103.3, 162, 50);
				// Predikat
				$mpdf->WriteFixedPosHTML("<h1 style='font-family: opensans; color: #136bb4;font-size: 18;font-weight: bold;text-align:left;text-transform:uppercase'>Sangat Baik</h1>", 195, 114, 162, 50);
			}
			// Waktu Cetak
			$mpdf->WriteFixedPosHTML("<p style='font-family: opensans; color: #000;font-size: 13;font-weight: regular ;text-align:left;'>" . date('d F Y', strtotime($dataUlasan["data"][0]['created_at'])) . "</p>", 199, 138.3, 162, 50);
			// Tenaga Pelatih
			$mpdf->WriteFixedPosHTML("<p style='text-transform:capitalize;font-family: opensans; color: #000;font-size: 11;font-weight: regular;text-align:center;'>{$namaInstruktur}</p>", 181, 179.7, 162, 50);
			// Barcode
			$this->load->library('ciqrcode');
			$link = $uri_string;
			$params['data'] = $link;
			$params['level'] = 'H';
			$params['size'] = 10;
			$params['savename'] = FCPATH . 'upload/qr-code/' . $id_user . $meta_link_mapel . '.png';
			$this->ciqrcode->generate($params);
			$mpdf->Image(base_url() . 'upload/qr-code/' . $id_user . $meta_link_mapel . '.png', 120, 152, 30, 30, 'jpg', '', true, false);
			// Random Code
			$mpdf->WriteFixedPosHTML("<p style='text-transform:capitalize;font-family: opensans; color: #000;font-size: 12;font-weight: regular;text-align:left;'>{$randomcode}</p>", 127, 182.3, 162, 50);
			// Tanda Tangan
			$imagePath = base_url() . "upload/tanda_tangan/" . $tanda_tangan;
			$mpdf->Image('upload/tanda_tangan/' . $tanda_tangan, 250, 160, 20, 20, 'jpg', '', true, false);

			//Start Unit Kompetensi
			$this->db->join('mapel_unit_kompetensi', 'mapel_unit_kompetensi.unit_kompetensi_id = unit_kompetensi.id');
			$this->db->join('skkni', 'unit_kompetensi.skkni_id = skkni.id');
			$data = $this->db->get_where('unit_kompetensi', ['mapel_id' => $id_mapel])->result_array();
			$unit_kompetensi = [];
			$index = 0;
			$page = 1;
			$unit = 1;
			foreach ($data as $d) {
				if ($unit >= 4) {
					$unit = 1;
					$page++;
				}
				$unit_kompetensi[$page]['skkni_id'][$d['skkni_id']] = $d['skkni_id'];
				$unit_kompetensi[$page][$d['skkni_id']][$index] = [
					'page' => $page,
					'kode_unit' => $d['kode_unit'],
					'judul_unit' => $d['judul_unit']
				];
				$unit++;
				$index++;
			}
			$totalPage = ceil(count($data) / 3);
			$templateId2 = $mpdf->ImportPage(2);
			$htmlArray = [];
			for ($i = 1; $i <= $totalPage; $i++) {
				$skkni_id = $unit_kompetensi[$i]['skkni_id'];
				foreach ($skkni_id as $si) {
					$skkni = $this->db->get_where('skkni', ['id' => $si])->row_array();
					$unit_skkni = $unit_kompetensi[$i][$skkni['id']];
					$html = '';
					$html .= '<h3 style="text-align:center;padding:0 60px;font-weight:regular;">' . $skkni['name'] . '</h3>';
					$html .= '<table border="1" style=" font-family: opensans;border-collapse: collapse;width:100%;table-layout:auto;text-align:center;margin-top:15rem">
					  <tr>
					  <th style="font-weight:regular; padding:10px">No</th>
					  <th style="font-weight:regular; padding:10px">Kode Unit</th>
					  <th style="font-weight:regular; padding:10px">Judul Unit Kompetensi</th>
					  </tr>';
					$no = 1;
					foreach ($unit_skkni as $us) {
						$html .= '<tr>
						  <td style="padding:10px 25px">' . $no . '</td>
						  <td style="padding:10px 25px">' . $us['kode_unit'] . '</td>
						  <td style="padding:10px 25px">' . $us['judul_unit'] . '</td>
						  </tr>';
						$no++;
					}
					$html .= '</table>';
					$htmlArray[$i][] = $html;
				}
			}
			for ($i = 1; $i <= $totalPage; $i++) {
				$html = '';
				foreach ($htmlArray[$i] as $item) {
					$html .= $item;
				}
				$mpdf->AddPage('L', 'A4');
				$mpdf->UseTemplate($templateId2);
				$mpdf->WriteFixedPosHTML($html, 122, 80, 162, 50);
			}
			//End Unit Kompetensi
			$mpdf->Output("{$mapel['nama_mapel']}.pdf", 'I');
		} catch (\Mpdf\MpdfException $e) {
			echo $e->getMessage();
		}

	}

}


?>

