<?php
defined('BASEPATH') or exit('No direct script access allowed');


class IndikatorInduk extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('back/MapelModel', 'BackMapelModel', true);
		$this->load->model('back/KompetensiModel', 'BackKompetensiModel', true);
		$this->load->model('back/KelasModel', 'BackKelasModel', true);
		$this->load->model('back/IndikatorIndukModel', 'BackIndikatorIndukModel', true);
		$this->data['menu'] = "kelas";
		$this->FrontAuthModel->isLoggedInAdmin();
	}

	public function index($idKompetensi = 0)
	{

		$dataKompetensi = $this->BackKompetensiModel->getById($idKompetensi);

		if ($dataKompetensi['total'] >= 1) {

			$dataMapel = $this->BackMapelModel->getById($dataKompetensi["data"][0]["mapel_id"]);

			if ($dataMapel['total'] >= 1) {

				$dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

				if ($dataKelas['total'] >= 1) {
					$this->data['title'] = "Indikator Induk " . $dataKompetensi['data'][0]['kompetensi'];
					$this->data['content'] = "indikator-induk.list";
					$this->data['kelas'] = $dataKelas['data'][0];
					$this->data['mapel'] = $dataMapel['data'][0];
					$this->data['kompetensi'] = $dataKompetensi['data'][0];
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

	public function tambah($idKompetensi = 0)
	{
		$dataKompetensi = $this->BackKompetensiModel->getById($idKompetensi);

		if ($dataKompetensi['total'] >= 1) {

			$dataMapel = $this->BackMapelModel->getById($dataKompetensi["data"][0]["mapel_id"]);

			if ($dataMapel['total'] >= 1) {

				$dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

				if ($dataKelas['total'] >= 1) {
					$this->data['title'] = " Tambah Indikator Induk " . $dataKompetensi['data'][0]['kompetensi'];
					$this->data['content'] = "indikator-induk.form-insert";
					$this->data['kelas'] = $dataKelas['data'][0];
					$this->data['mapel'] = $dataMapel['data'][0];
					$this->data['kompetensi'] = $dataKompetensi['data'][0];

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

	public function ubah($idKompetensi = 0, $idIndikatorInduk = 0)
	{
		$dataIndikatorInduk = $this->BackIndikatorIndukModel->getById($idIndikatorInduk);

		if ($dataIndikatorInduk['total'] >= 1) {
			$dataKompetensi = $this->BackKompetensiModel->getById($idKompetensi);

			if ($dataKompetensi['total'] >= 1) {

				$dataMapel = $this->BackMapelModel->getById($dataKompetensi["data"][0]["mapel_id"]);

				if ($dataMapel['total'] >= 1) {

					$dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

					if ($dataKelas['total'] >= 1) {
						$this->data['title'] = "Ubah Indikator Induk " . $dataIndikatorInduk['data'][0]['kompetensi'];
						$this->data['content'] = "indikator-induk.form-update";
						$this->data['kelas'] = $dataKelas['data'][0];
						$this->data['mapel'] = $dataMapel['data'][0];
						$this->data['kompetensi'] = $dataKompetensi['data'][0];
						$this->data['id'] = $dataIndikatorInduk['data'][0]['id_indikator_induk'];

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
		} else {
			redirect(base_url('back/not-found'));
		}

	}
}
