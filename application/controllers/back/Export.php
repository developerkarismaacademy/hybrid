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


		if ($date1 == '' || $date2 == '') {
			$siswa = $this->db->query("SELECT t1.posttest, t2.pretest, `user`.id_user, `mapel`.meta_link_mapel, `transaksi`.id_transaksi, `transaksi`.kode_voucher, `user`.nama_user, `user`.email_user, `user`.telepon_user, `redeem`.redeem_code, `transaksi`.tanggal AS tanggal_pembelian, `redeem`.TIMESTAMP AS tanggal_redeem, `user_mapel_progress`.progress, `user_mapel_progress`.updated_at AS tanggal_pengerjaan FROM `user` LEFT JOIN (SELECT log_ujian.nilai AS posttest, log_ujian.user_id FROM mapel JOIN bab ON mapel.id_mapel = bab.mapel_id JOIN materi ON materi.bab_id = bab.id_bab JOIN log_ujian ON materi.id_materi = log_ujian.materi_id WHERE posttest_status = 1 GROUP BY log_ujian.user_id ORDER BY log_ujian.id_log_ujian DESC) t1 ON user.id_user = t1.user_id LEFT JOIN (SELECT log_ujian.nilai AS pretest, log_ujian.user_id FROM mapel JOIN bab ON mapel.id_mapel = bab.mapel_id JOIN materi ON materi.bab_id = bab.id_bab JOIN log_ujian ON materi.id_materi = log_ujian.materi_id WHERE pretest_status = 1 GROUP BY log_ujian.user_id ORDER BY log_ujian.id_log_ujian DESC) t2 ON user.id_user = t2.user_id INNER JOIN transaksi ON `user`.id_user = transaksi.user_id INNER JOIN `detail_transaksi` ON `user`.id_user = `detail_transaksi`.user_id AND `transaksi`.id_transaksi = `detail_transaksi`.transaksi_id INNER JOIN `mapel` ON `detail_transaksi`.mapel_id = `mapel`.id_mapel LEFT JOIN `redeem` ON `redeem`.user_id = `user`.id_user LEFT JOIN `user_mapel_progress` ON `user_mapel_progress`.mapel_id = `mapel`.id_mapel AND `user_mapel_progress`.user_id = `user`.id_user WHERE mapel.meta_link_mapel = '$meta_mapel' LIMIT $limit")->result_array();
		} else {
			$date1 = date('Y-m-d H:i:s', strtotime($date1));
			$date2 = date('Y-m-d H:i:s', strtotime($date2));
			$siswa = $this->db->query("SELECT t1.posttest, t2.pretest, `user`.id_user, `mapel`.meta_link_mapel, `transaksi`.id_transaksi, `transaksi`.kode_voucher, `user`.nama_user, `user`.email_user, `user`.telepon_user, `redeem`.redeem_code, `transaksi`.tanggal AS tanggal_pembelian, `redeem`.TIMESTAMP AS tanggal_redeem, `user_mapel_progress`.progress, `user_mapel_progress`.updated_at AS tanggal_pengerjaan FROM `user` LEFT JOIN (SELECT log_ujian.nilai AS posttest, log_ujian.user_id FROM mapel JOIN bab ON mapel.id_mapel = bab.mapel_id JOIN materi ON materi.bab_id = bab.id_bab JOIN log_ujian ON materi.id_materi = log_ujian.materi_id WHERE posttest_status = 1 GROUP BY log_ujian.user_id ORDER BY log_ujian.id_log_ujian DESC) t1 ON user.id_user = t1.user_id LEFT JOIN (SELECT log_ujian.nilai AS pretest, log_ujian.user_id FROM mapel JOIN bab ON mapel.id_mapel = bab.mapel_id JOIN materi ON materi.bab_id = bab.id_bab JOIN log_ujian ON materi.id_materi = log_ujian.materi_id WHERE pretest_status = 1 GROUP BY log_ujian.user_id ORDER BY log_ujian.id_log_ujian DESC) t2 ON user.id_user = t2.user_id INNER JOIN transaksi ON `user`.id_user = transaksi.user_id INNER JOIN `detail_transaksi` ON `user`.id_user = `detail_transaksi`.user_id AND `transaksi`.id_transaksi = `detail_transaksi`.transaksi_id INNER JOIN `mapel` ON `detail_transaksi`.mapel_id = `mapel`.id_mapel LEFT JOIN `redeem` ON `redeem`.user_id = `user`.id_user LEFT JOIN `user_mapel_progress` ON `user_mapel_progress`.mapel_id = `mapel`.id_mapel AND `user_mapel_progress`.user_id = `user`.id_user WHERE mapel.meta_link_mapel = '$meta_mapel' AND transaksi.tanggal BETWEEN '$date1' AND '$date2' LIMIT $limit")->result_array();
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
}

/* End of file Export.php */
