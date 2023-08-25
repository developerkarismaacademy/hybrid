<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Karisma
 * Date: 23/09/2019
 * Time: 10:50
 */
class Transaksi extends CI_Controller
{


	/**
	 * Transaksi constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('back/TransaksiModel', 'BackTransaksiModel');
		$this->data['menu'] = "pembelian";
		$this->FrontAuthModel->isLoggedInAdmin();
	}

	public function index()
	{
		$this->data['title'] = "Pembelian";
		$this->data['content'] = "transaksi.list";

		$this->load->view('back/main', $this->data);
	}

	public function detail($idTransaksi = 0)
	{
		//$idTransaksi = sprintf("%c", $idTransaksi);
		$dataTransaksi = $this->BackTransaksiModel->getById((int)$idTransaksi);

		if ($dataTransaksi['total'] >= 1) {
			$this->data['title'] = "Invoice " . sprintf("%08d", $idTransaksi);
			$this->data['content'] = "transaksi.detail";
			$this->data['id'] = $dataTransaksi['data'][0]['id_transaksi'];
			$this->data['id_user'] = $dataTransaksi['data'][0]['user_id'];

			$this->load->view('back/main', $this->data);
		} else {
			redirect(base_url('back/not-found'));
		}
	}


	public function tambah()
	{
		$this->data['title'] = "Beli untuk Siswa";
		$this->data['content'] = "transaksi.form-insert";
		$this->data['menu'] = $this->data['content'];


		$this->load->view('back/main', $this->data);
	}
}
