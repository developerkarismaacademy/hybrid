<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Export extends CI_Controller
{

    public function index($meta_mapel = '')
	{
		$date1 = $this->input->post('tanggal_mulai');
		$date2 = $this->input->post('tanggal_akhir');
		$limit = $this->input->post('total_data');
	


		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$style_col = [
			'font' => ['bold' => true],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
			],
		];

		$style_row = [
			'alignment' => [
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
			],
		];

		$sheet->setCellValue('A1', "invoice");
		$sheet->setCellValue('B1', "nama");
		$sheet->setCellValue('C1', "email");
		$sheet->setCellValue('D1', "no_telpon");
		$sheet->setCellValue('E1', "tanggal_pembelian");
		$sheet->setCellValue('F1', "redeem_code");
		$sheet->setCellValue('G1', "kode_voucher");
		$sheet->setCellValue('H1', "tanggal_redeem");
		$sheet->setCellValue('I1', "progress");
		$sheet->setCellValue('J1', "tanggal_pengerjaan");
		$sheet->setCellValue('K1', "pre_test");
		$sheet->setCellValue('L1', "post_test");
		$sheet->setCellValue('M1', "link_sertifikat");
		$sheet->setCellValue('N1', "rating");
		$sheet->setCellValue('O1', "ulasan");
		$sheet->getStyle('A1')->applyFromArray($style_col);
		$sheet->getStyle('B1')->applyFromArray($style_col);
		$sheet->getStyle('C1')->applyFromArray($style_col);
		$sheet->getStyle('D1')->applyFromArray($style_col);
		$sheet->getStyle('E1')->applyFromArray($style_col);
		$sheet->getStyle('F1')->applyFromArray($style_col);
		$sheet->getStyle('G1')->applyFromArray($style_col);
		$sheet->getStyle('H1')->applyFromArray($style_col);
		$sheet->getStyle('I1')->applyFromArray($style_col);
		$sheet->getStyle('J1')->applyFromArray($style_col);
		$sheet->getStyle('K1')->applyFromArray($style_col);
		$sheet->getStyle('L1')->applyFromArray($style_col);
		$sheet->getStyle('M1')->applyFromArray($style_col);
		$sheet->getStyle('N1')->applyFromArray($style_col);
		$sheet->getStyle('O1')->applyFromArray($style_col);


        if ($date1 == '' || $date2 == '') {
			$siswa = $this->db->query("SELECT t1.id_transaksi, t4.nama_user, t4.email_user, t4.telepon_user, t1.kode_voucher, t1.tanggal_bayar AS tanggal_pembelian, t5.redeem_code, t5.`timestamp` AS tanggal_redeem, t7.nilai AS pretest, t8.nilai AS posttest, t6.progress, t6.updated_at AS tanggal_pengerjaan, t3.meta_link_mapel, t4.id_user, t9.rating, t9.ulasan FROM transaksi t1 JOIN detail_transaksi t2 ON t1.id_transaksi = t2.transaksi_id JOIN mapel t3 ON t2.mapel_id = t3.id_mapel JOIN `user` t4 ON t4.id_user = t2.user_id LEFT JOIN redeem t5 ON t5.user_id = t4.id_user AND t5.mapel_id = t3.id_mapel LEFT JOIN user_mapel_progress t6 ON t6.user_id = t4.id_user AND t6.mapel_id = t3.id_mapel LEFT JOIN (SELECT t1.id_mapel, t2.id_bab, t3.id_materi, t4.user_id, MAX(t4.nilai) AS nilai FROM mapel t1 JOIN bab t2 ON t2.mapel_id = t1.id_mapel JOIN materi t3 ON t3.bab_id = t2.id_bab JOIN log_ujian t4 ON t4.materi_id = t3.id_materi WHERE t2.pretest_status = 1) t7 ON t7.user_id = t4.id_user AND t7.id_mapel = t3.id_mapel LEFT JOIN (SELECT t1.id_mapel, t2.id_bab, t3.id_materi, t4.user_id, MAX(t4.nilai) AS nilai FROM mapel t1 JOIN bab t2 ON t2.mapel_id = t1.id_mapel JOIN materi t3 ON t3.bab_id = t2.id_bab JOIN log_ujian t4 ON t4.materi_id = t3.id_materi WHERE t2.posttest_status = 1) t8 ON t8.user_id = t4.id_user AND t8.id_mapel = t3.id_mapel LEFT JOIN rating t9 ON t9.user_id = t4.id_user AND t9.mapel_id = t3.id_mapel WHERE t3.meta_link_mapel = '$meta_mapel' AND t1.`status` = 2 AND t1.kode_voucher != '' LIMIT $limit")->result_array();
		} else {
			$date1 = date('Y-m-d H:i:s', strtotime($date1));
			$date2 = date('Y-m-d H:i:s', strtotime($date2));
			$siswa = $this->db->query("SELECT t1.id_transaksi, t4.nama_user, t4.email_user, t4.telepon_user, t1.kode_voucher, t1.tanggal_bayar AS tanggal_pembelian, t5.redeem_code, t5.`timestamp` AS tanggal_redeem, t7.nilai AS pretest, t8.nilai AS posttest, t6.progress, t6.updated_at AS tanggal_pengerjaan, t3.meta_link_mapel, t4.id_user, t9.rating, t9.ulasan FROM transaksi t1 JOIN detail_transaksi t2 ON t1.id_transaksi = t2.transaksi_id JOIN mapel t3 ON t2.mapel_id = t3.id_mapel JOIN `user` t4 ON t4.id_user = t2.user_id LEFT JOIN redeem t5 ON t5.user_id = t4.id_user AND t5.mapel_id = t3.id_mapel LEFT JOIN user_mapel_progress t6 ON t6.user_id = t4.id_user AND t6.mapel_id = t3.id_mapel LEFT JOIN (SELECT t1.id_mapel, t2.id_bab, t3.id_materi, t4.user_id, MAX(t4.nilai) AS nilai FROM mapel t1 JOIN bab t2 ON t2.mapel_id = t1.id_mapel JOIN materi t3 ON t3.bab_id = t2.id_bab JOIN log_ujian t4 ON t4.materi_id = t3.id_materi WHERE t2.pretest_status = 1 GROUP BY t4.user_id ORDER BY t4.id_log_ujian DESC ) t7 ON t7.user_id = t4.id_user AND t7.id_mapel = t3.id_mapel LEFT JOIN (SELECT t1.id_mapel, t2.id_bab, t3.id_materi, t4.user_id, MAX(t4.nilai) AS nilai FROM mapel t1 JOIN bab t2 ON t2.mapel_id = t1.id_mapel JOIN materi t3 ON t3.bab_id = t2.id_bab JOIN log_ujian t4 ON t4.materi_id = t3.id_materi WHERE t2.posttest_status = 1 GROUP BY t4.user_id ORDER BY t4.id_log_ujian DESC ) t8 ON t8.user_id = t4.id_user AND t8.id_mapel = t3.id_mapel LEFT JOIN rating t9 ON t9.user_id = t4.id_user AND t9.mapel_id = t3.id_mapel WHERE t3.meta_link_mapel = '$meta_mapel' AND t1.`status` = 2 AND t1.kode_voucher != '' AND t1.tanggal BETWEEN '$date1' AND '$date2' LIMIT $limit")->result_array();
		}

		$no = 1;
		$numrow = 2;
		foreach ($siswa as $data) {
			$linkSertifikat = ($data['progress'] == 100) ? base_url('download-sertifikat/' . $data['meta_link_mapel'] . '/' . $data['id_user']) : '-';

			$sheet->setCellValue('A' . $numrow, invoice($data['id_transaksi']) ?? '-');
			$sheet->setCellValue('B' . $numrow, $data['nama_user'] ?? '-');
			$sheet->setCellValue('C' . $numrow, $data['email_user'] ?? '-');
			$sheet->setCellValue('D' . $numrow, $data['telepon_user'] ?? '-');
			$sheet->setCellValue('E' . $numrow, $data['tanggal_pembelian'] ?? '-');
			$sheet->setCellValue('F' . $numrow, $data['redeem_code'] ?? '-');
			$sheet->setCellValue('G' . $numrow, $data['kode_voucher'] ?? '-');
			$sheet->setCellValue('H' . $numrow, date("Y-m-d H:i:s", $data['tanggal_redeem']) ?? '-');
			$sheet->setCellValue('I' . $numrow, $data['progress'] ?? '-');
			$sheet->setCellValue('J' . $numrow, $data['tanggal_pengerjaan'] ?? '-');
			$sheet->setCellValue('K' . $numrow, $data['pretest'] ?? '-');
			$sheet->setCellValue('L' . $numrow, $data['posttest'] ?? '-');
			$sheet->setCellValue('M' . $numrow, $linkSertifikat);
			$sheet->setCellValue('N' . $numrow, $data['rating'] ?? '-');
			$sheet->setCellValue('O' . $numrow, $data['ulasan'] ?? '-');

			$sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('H' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('I' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('J' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('K' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('L' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('M' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('N' . $numrow)->applyFromArray($style_row);
			$sheet->getStyle('O' . $numrow)->applyFromArray($style_row);

			$no++;
			$numrow++;
		}

		$sheet->getDefaultRowDimension()->setRowHeight(-1);

		$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

		$title = 'Data Siswa ' . date("Y-m-d");
		$sheet->setTitle($title);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . $title . '.xlsx"');
		header('Cache-Control: max-age=0');
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
	}

    public function siswa()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $style_col = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
        ];

        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
        ];

        $sheet->setCellValue('A1', "nama");
        $sheet->setCellValue('B1', "email");
        $sheet->setCellValue('C1', "username");
        $sheet->setCellValue('D1', "jenis_kelamin");
        $sheet->setCellValue('E1', "alamat");
        $sheet->setCellValue('F1', "kota");
        $sheet->setCellValue('G1', "tanggal_lahir");
        $sheet->setCellValue('H1', "no_telpon");
        $sheet->setCellValue('I1', "tanggal_daftar");

        $sheet->getStyle('A1')->applyFromArray($style_col);
        $sheet->getStyle('B1')->applyFromArray($style_col);
        $sheet->getStyle('C1')->applyFromArray($style_col);
        $sheet->getStyle('D1')->applyFromArray($style_col);
        $sheet->getStyle('E1')->applyFromArray($style_col);
        $sheet->getStyle('F1')->applyFromArray($style_col);
        $sheet->getStyle('G1')->applyFromArray($style_col);
        $sheet->getStyle('H1')->applyFromArray($style_col);
        $sheet->getStyle('I1')->applyFromArray($style_col);

        $datas = $this->db->get_where('user', ['level_user' => 'siswa'])->result_array();
        $numrow = 2;

        foreach ($datas as $data) {
            $sheet->setCellValue('A' . $numrow, $data['nama_user']);
            $sheet->setCellValue('B' . $numrow, $data['email_user']);
            $sheet->setCellValue('C' . $numrow, $data['username']);
            $sheet->setCellValue('D' . $numrow, $data['jk_user']);
            $sheet->setCellValue('E' . $numrow, $data['alamat_user']);
            $sheet->setCellValue('F' . $numrow, $data['tempat_lahir']);
            $sheet->setCellValue('G' . $numrow, $data['tanggal_lahir']);
            $sheet->setCellValue('H' . $numrow, $data['telepon_user']);
            $sheet->setCellValue('I' . $numrow, $data['created_at']);

            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('H' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('I' . $numrow)->applyFromArray($style_row);

            $numrow++;
        }

        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        $sheet->setTitle('Data Siswa Hybrid');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Siswa Hybrid.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}

/* End of file Export.php */