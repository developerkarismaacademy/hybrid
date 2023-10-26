<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Gamification extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->FrontAuthModel->isLoggedIn();

	}

	public function get_course()
	{
		$user = $this->FrontAuthModel->getUserLoggedIn();
		$userId = $user['data']['id_user'];

		$time = date('Y-m-d H:i:s', time());

		$mapelId = 122171;

		$userMapelQuery = $this->db->get_where('user_mapel', ['mapel_id' => $mapelId, 'user_id' => $userId]);
		$userMapelData = $userMapelQuery->row_array();

		$mapelData = $this->db->get_where('mapel', ['id_mapel' => $mapelId])->row_array();
		$linkMapel = $mapelData['meta_link_mapel'];

		if ($userMapelQuery->num_rows() > 0) {
			alert("danger", "", "<strong>Pelatihan sudah ada</strong>");
			redirect('kursus/detail/' . $linkMapel, 'refresh');
		}

		$coinQuery = $this->db->get_where('coins', ['user_id' => $userId]);
		$coinData = $coinQuery->row_array();
		$coin = 0;

		if ($coinQuery->num_rows() > 0) {
			$coin = $coinData['coin'];
		}

		if ($coin < 600) {
			alert("danger", "", "<strong>Gold tidak mencukupi!</strong>");
			redirect('profil/gamification', 'refresh');
		}

		$transaksiData = array(
			"user_id" => $userId,
			"tanggal" => $time,
			"tanggal_bayar" => $time,
			"jumlah" => 1,
			"jumlah_bayar" => 0,
			"bank_user" => "",
			"bank_karisma" => "",
			"no_rek_user" => "",
			"atas_nama" => "",
			"bukti_transfer" => "",
			"status" => 2,
			"created_at" => $time,
			"total_potongan" => 0,
			"total_beli" => 0,
		);
		$this->db->insert('transaksi', $transaksiData);
		$transaksiId = $this->db->insert_id();

		$detailTransaksiData = array(
			"mapel_id" => $mapelId,
			"user_id" => $userId,
			"transaksi_id" => $transaksiId,
			"level_mapel" => 1,
			"created_at" => $time
		);
		$this->db->insert('detail_transaksi', $detailTransaksiData);
		$detailTransaksiId = $this->db->insert_id();

		$userMapelData = array(
			'mapel_id' => $mapelId,
			'user_id' => $userId,
			'transaksi_id' => $transaksiId,
			'detail_transaksi_id' => $detailTransaksiId,
			'level_mapel' => 1
		);
		$this->db->insert('user_mapel', $userMapelData);

		$data_user_mapel_progress = [
			'user_id' => $userId,
			'mapel_id' => $mapelId,
			'progress' => 0,
			'raport_allowed' => 0,
		];
		$this->db->insert('user_mapel_progress', $data_user_mapel_progress);

		$coin -= 600;
		$coinsData = [
			'coin' => $coin
		];
		$this->db->where('user_id', $userId);
		$this->db->update('coins', $coinsData);

		alert("success", "", "<strong>Pelatihan di dapatkan!</strong>");
		redirect('belajar/' . $linkMapel, 'refresh');
	}

	public function exchange_balance()
	{
		$user = $this->FrontAuthModel->getUserLoggedIn();
		$userId = $user['data']['id_user'];

		$mapelId = 122171;

		$balancesQuery = $this->db->get_where('balances', ['user_id' => $userId]);
		$balance = 0;
		if ($balancesQuery->num_rows() > 0) {
			$balancesData = $balancesQuery->row_array();
			$balance = $balancesData['balance'];
		}

		if ($balance <= 0) {
			$this->session->set_flashdata("danger", "<strong>Saldo tidak cukup!</strong>");
			redirect('profil/gamification', 'refresh');
		}

		$gamificationTransactionData = [
			'status' => 'pending',
			'balance' => $balance,
			'user_id' => $userId,
			'mapel_id' => $mapelId,
			'bank_type' => $this->input->post('bank-type'),
			'bank_number' => $this->input->post('bank-number')
		];
		$this->db->insert('gamification_transaction', $gamificationTransactionData);

		$balanceData = [
			'balance' => 0
		];
		$this->db->where('user_id', $userId);
		$this->db->update('balances', $balanceData);

		$this->session->set_flashdata("success", "<strong>Coin berhasil di tukar silahkan di tunggu 1 x 24 jam !</strong>");
		redirect('profil/gamification', 'refresh');

	}

	public function exchange_invoice()
	{
		$user = $this->FrontAuthModel->getUserLoggedIn();
		$userId = $user['data']['id_user'];

		$time = date('Y-m-d H:i:s', time());

		$invoice = $this->input->post('invoice');
		$invoiceQuery = $this->db->get_where('invoice_prakerja', ['invoice' => $invoice]);
		if ($invoiceQuery->num_rows() == 0) {
			$invoice = (int)preg_replace('/\D/', '', $invoice);
			$transaksiQuery = $this->db->query("SELECT * FROM transaksi WHERE id_transaksi = $invoice");
			if ($transaksiQuery->num_rows() > 0) {
				$transaksiData = $transaksiQuery->row_array();
				$transaksiId = $transaksiData['id_transaksi'];

				$detailTransaksiData = $this->db->query("SELECT * FROM detail_transaksi WHERE transaksi_id = $transaksiId")->row_array();
				$mapelId = $detailTransaksiData['mapel_id'];

				$userMapelProgressData = $this->db->query("SELECT * FROM user_mapel_progress WHERE mapel_id = $mapelId AND user_id = $userId")->row_array();
				$progress = $userMapelProgressData['progress'] ?? 0.00;

				$invoice = sprintf("INV-%08d", $invoice);
				$invoicePrakerjaQuery = $this->db->query("SELECT * FROM invoice_prakerja WHERE invoice = '$invoice'");
				if ($invoicePrakerjaQuery->num_rows() == 0) {
					$invoicePrakerjaInput = [
						'invoice' => $invoice,
						'email' => $user['data']['email_user'],
						'no_ponsel' => $user['data']['telepon_user'],
						'partisipasi' => $progress . '%',
						'pembelian' => 'Hybrid',
						'mapel_id' => $mapelId,
						'status' => 1
					];
					$this->db->insert('invoice_prakerja', $invoicePrakerjaInput);
				}
			} else {
				$this->session->set_flashdata("danger", "<strong>Invoice tidak ada !</strong>");
				redirect('profil/gamification', 'refresh');
			}
		}
		$invoiceQuery = $this->db->get_where('invoice_prakerja', ['invoice' => $invoice]);
		if (!$invoiceQuery->num_rows() > 0) {
			$this->session->set_flashdata("danger", "<strong>Invoice tidak ada !</strong>");
			redirect('profil/gamification', 'refresh');
		}

		$invoiceData = $invoiceQuery->row_array();

		if ($invoiceData['email'] != $user['data']['email_user']) {
			$this->session->set_flashdata("danger", "<strong>Email tidak sesuai dengan data invoice !</strong>");
			redirect('profil/gamification', 'refresh');
		}

		if ($invoiceData['no_ponsel'] != $user['data']['telepon_user']) {
			$this->session->set_flashdata("danger", "<strong>No telepon tidak sesuai dengan data invoice !</strong>");
			redirect('profil/gamification', 'refresh');
		}

		if ($invoiceData['status'] == 0) {
			$this->session->set_flashdata("danger", "<strong>Invoice sudah di gunakan !</strong>");
			redirect('profil/gamification', 'refresh');
		}

		if ((int)$invoiceData['partisipasi'] < 100) {
			$this->session->set_flashdata("danger", "<strong>Pelatihan belum selesai !</strong>");
			redirect('profil/gamification', 'refresh');
		}

		$coin = 300;
		$userInvoicePrakerjaData = [
			'user_id' => $userId,
			'invoice_prakerja_id' => $invoiceData['id'],
			'status' => 'success',
			'coin' => $coin
		];
		$this->db->insert('user_invoice_prakerja', $userInvoicePrakerjaData);

		$this->db->where('invoice', $invoice);
		$this->db->update('invoice_prakerja', ['status' => 0]);

		$coinQuery = $this->db->get_where('coins', ['user_id' => $userId]);
		if ($coinQuery->num_rows() > 0) {
			$coinData = $coinQuery->row_array();
			$coin += $coinData['coin'];
			$coinsData = [
				'coin' => $coin
			];
			$this->db->where('user_id', $userId);
			$this->db->update('coins', $coinsData);
		} else {
			$coinData = [
				'user_id' => $userId,
				'coin' => $coin
			];
			$this->db->insert('coins', $coinData);
		}
		$this->session->set_flashdata("success", "<strong>Gold berhasil didapatkan !</strong>");
		redirect('profil/gamification', 'refresh');
	}

    public function update_payment($id)
    {
        $data = [
            'bank_type' => $this->input->post('bank-type'),
            'bank_number' => $this->input->post('bank-number')
        ];

        $this->db->where('id', $id);
        $this->db->update('gamification_transaction', $data);
        $this->session->set_flashdata('success', '<strong>Payment berhasil dirubah</strong>');
        redirect('profil/gamification', 'refresh');
    }
}
/* End of file Gamification.php */
