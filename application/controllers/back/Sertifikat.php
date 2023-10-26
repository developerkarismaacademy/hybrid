<?php

use phpDocumentor\Reflection\Types\Null_;

defined('BASEPATH') or exit('No direct script access allowed');
class Sertifikat extends CI_Controller
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

  public function index($meta_link_mapel = "", $id_user = "")
  {
    $uri_string = base_url() . $this->uri->uri_string();
    $user = $this->db->get_where('user', ['id_user' => $id_user])->row_array();

    // $salt = 'karismaacademy';

    // $decoded_string = base64_decode($encoded_string);
    // $id_user = str_replace($salt, '', $decoded_string);

    $where = "meta_link_mapel = '{$meta_link_mapel}'";

    $dataMapel = $this->FrontMapelModel->getAllMapel($where);

    if ($dataMapel["total"] > 0) {

      $mapel = $dataMapel["data"][0];



      $id_mapel = $mapel["id_mapel"];
      $cekUlasan = $this->db->get_where('rating', ['mapel_id' => $id_mapel, 'user_id' => $id_user]);
      if($cekUlasan->num_rows() == 0){
          alert("danger", "Anda belum mengulas", "Sebelum mengakses sertifikat, isi terlebih dahulu ulasan");
      }


      $id_kelas = $mapel["kelas_id"];

      $meta_link_mapel = $mapel["meta_link_mapel"];

      $randomcode = $id_mapel . $id_kelas . $id_user;



      $this->data["mapel"] = $mapel;

      $dataUlasan = $this->FrontUlasanModel->getByUlasan($id_user, $id_mapel);

      if ($dataUlasan["total"] > 0) {

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
    		if ($materi_id != null) {
				$log_praktek = $this->db->query("SELECT t1.id_log_praktek,t1.materi_id,t1.user_id,t1.file,MAX(t1.nilai) AS nilai,t1.tipe FROM log_praktek t1 WHERE t1.user_id = $id_user AND t1.materi_id = $materi_id")->row_array();

				$nilai = $log_praktek['nilai'];
				

				if ($nilai < 80) {
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
			}else{
				$templateId1 = $mpdf->ImportPage(3);
				$mpdf->UseTemplate($templateId1);
				//Nama Murid
				$mpdf->WriteFixedPosHTML("<h1 style='text-transform:capitalize;font-family: opensans; color: #232b39;font-size: 32;font-weight: bold;text-align:left;'>{$namaMurid}</h1>", 122, 50, 162, 50);
				//Judul Pelatihan
				$mpdf->WriteFixedPosHTML("<h1 style='font-family: opensans; color: #576270;font-size: 20;font-weight: bold;font-style:italic;text-align:left;padding-right:100px'>{$namaMapel}</h1>", 122, 86, 162, 50);
				//Durasi Belajar
				$mpdf->WriteFixedPosHTML("<h1 style='font-family: opensans; color: #136bb4;font-size: 18;font-weight: bold;text-align:left;text-transform:uppercase'>15 jam 00 menit</h1>", 187, 114, 162, 50);
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
    
    		if (count($data) > 0) {
    			foreach ($data as $d) {
    				$unit_kompetensi[$d['skkni_id']]['name'] = $d['name'];
    				$unit_kompetensi[$d['skkni_id']]['unit'][$index] = [
    					'page' => $page,
    					'kode_unit' => $d['kode_unit'],
    					'judul_unit' => $d['judul_unit']
    				];
    				$index++;
    			}
    
    			$html = '';
    			$html .= '<ol type="A" style="font-size: 1.25rem; line-height: 1.5rem">';
    			foreach ($unit_kompetensi as $uk) {
    				$html .= '<li style="font-weight: bold;">' .
    					$uk['name']
    					. '</li>';
    
    				$html .= '<li><ol type="1">';
    				foreach ($uk['unit'] as $unit) {
    					$html .= '<li>' . $unit['kode_unit'] . ' ' . $unit['judul_unit'] . '</li>';
    				}
    				$html .= '</ol></li>';
    			}
    			$html .= '</ol>';
    
    			$templateId2 = $mpdf->ImportPage(2);
    			$mpdf->AddPage('L', 'A4');
    			$mpdf->UseTemplate($templateId2);
    			$mpdf->WriteFixedPosHTML($html, 124, 70, 156, 50);
    		}
    		//End Unit Kompetensi
          $mpdf->Output("{$mapel['nama_mapel']}.pdf", 'I');
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
}



/* End of file Sertifikat.php */