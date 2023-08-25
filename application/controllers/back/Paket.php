<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 */
class Paket extends CI_Controller
{
	private $data;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('back/PaketModel', 'BackPaketModel', true);
		$this->data['menu'] = "paket";
		$this->FrontAuthModel->isLoggedInAdmin();
	}

	public function index()
	{
		$this->data['title'] = "Paket";
		$this->data['content'] = "paket.list";
		$this->load->view('back/main', $this->data);
	}

	public function tambah()
	{
		$this->data['title'] = "Tambah Paket";
		$this->data['content'] = "paket.form-insert";
		$this->load->view('back/main', $this->data);
	}

	public function ubah($metaPaket = "")
	{
		$dataPaket = $this->BackPaketModel->getByMeta($metaPaket);

		if ($dataPaket['total'] >= 1) {
			$this->data['title'] = "Ubah Paket " . $dataPaket['data'][0]['nama_paket'];
			$this->data['content'] = "paket.form-update";
			$this->data['id'] = $dataPaket['data'][0]['id_paket'];

			$this->load->view('back/main', $this->data);
		} else {
			redirect(base_url('back/not-found'));
		}

	}
}

?>
