<?php

defined('BASEPATH') or exit('No direct script access allowed');

class TukarVoucher extends CI_Controller
{

	public function index()
	{
		$this->load->view('prakerja/prakerja');
	}

	public function tukar()
	{
		$time     = date('Y-m-d H:i:s', time());
		$voucher  = $this->db->get_where('voucher_prakerja', ['kode_voucher' => $this->input->post('kode_voucher')])->row_array();
		if ($voucher) {
			if ($voucher['status'] != 0) {
				$this->db->update('voucher_prakerja', array('status' => 0), array('kode_voucher' => $voucher['kode_voucher']));
				$data_transaksi     = array(
					"user_id"         => 1,
					"tanggal"         => $time,
					"tanggal_bayar"   => $time,
					"jumlah"          => 1,
					"jumlah_bayar"    => 0,
					"bank_user"       => "",
					"bank_karisma"    => "",
					"no_rek_user"     => "",
					"atas_nama"       => "",
					"bukti_transfer"  => "",
					"status"          => 2,
					"created_at"      => $time,
					"kode_voucher"    => $this->input->post('kode_voucher'),
					"total_potongan"  => 0,
					"total_beli"      => 0,
				);

				$this->db->insert('transaksi', $data_transaksi);
				$this->db->select_max('id_transaksi');

				$transaksi              = $this->db->get('transaksi')->row_array();
				$data_detail_transaksi  = array(
					"mapel_id"      => $voucher['mapel_id'],
					"user_id"       => 1,
					"transaksi_id"  => $transaksi['id_transaksi'],
					"level_mapel"   => 1,
					"created_at"    => $time
				);

				$this->db->insert('detail_transaksi', $data_detail_transaksi);
			} else {
				echo 'Voucher tidak berlaku';
			}
		} else {
			echo 'errro';
		}
	}
}

/* End of file TukarVoucher.php */
