<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Instruktur extends CI_Controller
{
	private $data;

	public function __construct()
	{
		parent::__construct();

		$this->load->model('back/InstrukturModel', 'BackInstrukturModel', true);
		$this->data['menu'] = "instruktur";
		$this->FrontAuthModel->isLoggedInAdmin();
	}

	public function index()
	{
		$this->data['title'] = "Instruktur";
		$this->data['content'] = "instruktur.list";

		$this->load->view('back/main', $this->data);
	}

	public function tambah()
	{
		$this->data['title'] = "Tambah Instruktur";
		$this->data['content'] = "instruktur.form-insert";

		$this->load->view('back/main', $this->data);
	}

	public function detail($idUser = 0)
	{
		$dataInstruktur = $this->BackInstrukturModel->getById($idUser);

		$dataMapel = $this->BackInstrukturModel->getAllMapel($idUser);

		if ($dataInstruktur["total"] >= 1) {

			$this->data['title'] = "Instruktur";
			$this->data['content'] = "instruktur.detail";
			$this->data['mapel'] = $dataMapel;
			$this->data['id'] = $dataInstruktur['data'][0]['id_user'];
			$this->data['id_user'] = $dataInstruktur['data'][0]['id_user'];
			$this->data['instruktur'] = $dataInstruktur['data'][0];

			$this->load->view('back/main', $this->data);
		} else {
			redirect(base_url('back/not-found'));
		}
	}

	public function ubah($idInstruktur = "")
	{
		$dataInstruktur = $this->BackInstrukturModel->getById($idInstruktur);

		if ($dataInstruktur['total'] >= 1) {
			$this->data['title'] = "Ubah Instruktur " . $dataInstruktur['data'][0]['nama_user'];
			$this->data['content'] = "instruktur.form-update";
			$this->data['id'] = $dataInstruktur['data'][0]['id_user'];

			$this->load->view('back/main', $this->data);
		} else {
			redirect(base_url('back/not-found'));
		}

	}


}
