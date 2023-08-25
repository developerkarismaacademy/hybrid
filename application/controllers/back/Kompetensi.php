<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Kompetensi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('back/MapelModel', 'BackMapelModel', true);
		$this->load->model('back/KelasModel', 'BackKelasModel', true);
		$this->load->model('back/KompetensiModel', 'BackKompetensiModel', true);
		$this->data['menu'] = "kelas";
		$this->FrontAuthModel->isLoggedInAdmin();
	}

	public function index($metaMapel = "")
	{

		$dataMapel = $this->BackMapelModel->getByMeta($metaMapel);

		if ($dataMapel['total'] >= 1) {

			$dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

			if ($dataKelas['total'] >= 1) {
				$this->data['title'] = "Kompetensi " . $dataMapel['data'][0]['nama_mapel'];
				$this->data['content'] = "kompetensi.list";
				$this->data['kelas'] = $dataKelas['data'][0];
				$this->data['mapel'] = $dataMapel['data'][0];
				$this->data['id'] = $dataMapel['data'][0]['id_mapel'];

				$this->load->view('back/main', $this->data);
			} else {
				redirect(base_url('back/not-found'));
			}

		} else {
			redirect(base_url('back/not-found'));
		}


	}

	public function tambah($metaMapel = "")
	{
		$dataMapel = $this->BackMapelModel->getByMeta($metaMapel);

		if ($dataMapel['total'] >= 1) {

			$dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

			if ($dataKelas['total'] >= 1) {
				$this->data['title'] = " Tambah Kompetensi " . $dataMapel['data'][0]['nama_mapel'];
				$this->data['content'] = "kompetensi.form-insert";
				$this->data['kelas'] = $dataKelas['data'][0];
				$this->data['mapel'] = $dataMapel['data'][0];

				$this->load->view('back/main', $this->data);
			} else {
				redirect(base_url('back/not-found'));
			}

		} else {
			redirect(base_url('back/not-found'));
		}

	}

	public function ubah($metaMapel = "", $idKompetensi = "")
	{
		$dataKompetensi = $this->BackKompetensiModel->getById($idKompetensi);

		if ($dataKompetensi['total'] >= 1) {
			$dataMapel = $this->BackMapelModel->getById($dataKompetensi['data'][0]['mapel_id']);

			if ($dataMapel['total'] >= 1) {

				$dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

				if ($dataKelas['total'] >= 1) {
					$this->data['title'] = "Ubah Kompetensi " . $dataKompetensi['data'][0]['kompetensi'];
					$this->data['content'] = "kompetensi.form-update";
					$this->data['kelas'] = $dataKelas['data'][0];
					$this->data['mapel'] = $dataMapel['data'][0];
					$this->data['id'] = $dataKompetensi['data'][0]['id_kompetensi'];

					$this->load->view('back/main', $this->data);
				} else {
					redirect(base_url('back/not-found'));
				}

			} else {
				redirect(base_url('back/not-found'));
			}
		} else {
			redirect(base_url('back/not-found'));
		}

	}


	public function setUrutan($metaMapel = "")
	{

		$dataMapel = $this->BackMapelModel->getByMeta($metaMapel);

		if ($dataMapel['total'] >= 1) {
			$dataKompetensi = $this->BackKompetensiModel->getAllByMapel($dataMapel["data"][0]["id_mapel"]);
			$this->data['title'] = "Setting Urutan Kompetensi " . $dataMapel['data'][0]['nama_mapel'];
			$this->data['content'] = "kompetensi.form-urutan";
			$this->data['mapel'] = $dataMapel['data'][0];
			$this->data['kompetensi'] = $dataKompetensi['data'];
			$this->data['id'] = $dataMapel['data'][0]['id_mapel'];

			$this->load->view('back/main', $this->data);
		} else {
			redirect(base_url('back/not-found'));
		}
	}
}
