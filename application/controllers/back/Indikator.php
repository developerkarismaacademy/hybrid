<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Indikator extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('back/MapelModel', 'BackMapelModel', true);
		$this->load->model('back/KompetensiModel', 'BackKompetensiModel', true);
		$this->load->model('back/KelasModel', 'BackKelasModel', true);
		$this->load->model('back/IndikatorIndukModel', 'BackIndikatorIndukModel', true);
		$this->load->model('back/IndikatorModel', 'BackIndikatorModel', true);
		$this->data['menu'] = "kelas";
		$this->FrontAuthModel->isLoggedInAdmin();
	}

	public function index($idIndikatorInduk = 0)
	{

		$dataIndikatorInduk = $this->BackIndikatorIndukModel->getById($idIndikatorInduk);

		if ($dataIndikatorInduk['total'] >= 1) {

			$dataKompetensi = $this->BackKompetensiModel->getById($dataIndikatorInduk["data"][0]["kompetensi_id"]);

			if ($dataKompetensi['total'] >= 1) {

				$dataMapel = $this->BackMapelModel->getById($dataKompetensi["data"][0]["mapel_id"]);

				if ($dataMapel['total'] >= 1) {

					$dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

					if ($dataKelas['total'] >= 1) {
						$this->data['title'] = "Daftar Indikator '" . $dataIndikatorInduk['data'][0]['indikator_induk'] . "'";
						$this->data['content'] = "indikator.list";
						$this->data['kelas'] = $dataKelas['data'][0];
						$this->data['mapel'] = $dataMapel['data'][0];
						$this->data['kompetensi'] = $dataKompetensi['data'][0];
						$this->data['indikatorInduk'] = $dataIndikatorInduk['data'][0];
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

	public function tambah($idIndikatorInduk = 0)
	{

		$dataIndikatorInduk = $this->BackIndikatorIndukModel->getById($idIndikatorInduk);

		if ($dataIndikatorInduk['total'] >= 1) {

			$dataKompetensi = $this->BackKompetensiModel->getById($dataIndikatorInduk["data"][0]["kompetensi_id"]);

			if ($dataKompetensi['total'] >= 1) {

				$dataMapel = $this->BackMapelModel->getById($dataKompetensi["data"][0]["mapel_id"]);

				if ($dataMapel['total'] >= 1) {

					$dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

					if ($dataKelas['total'] >= 1) {
						$this->data['title'] = " Tambah Indikator '" . $dataKompetensi['data'][0]['kompetensi'] . "'";
						$this->data['content'] = "indikator.form-insert";
						$this->data['kelas'] = $dataKelas['data'][0];
						$this->data['mapel'] = $dataMapel['data'][0];
						$this->data['kompetensi'] = $dataKompetensi['data'][0];
						$this->data['indikatorInduk'] = $dataIndikatorInduk['data'][0];

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

	public function ubah($idIndikatorInduk = 0, $idIndikator = 0)
	{

		$dataIndikatorInduk = $this->BackIndikatorIndukModel->getById($idIndikatorInduk);
		if ($dataIndikatorInduk['total'] >= 1) {
			$dataIndikator = $this->BackIndikatorModel->getById($idIndikator);

			if ($dataIndikator['total'] >= 1) {
				$dataKompetensi = $this->BackKompetensiModel->getById($dataIndikatorInduk["data"][0]["kompetensi_id"]);

				$dataMapel = $this->BackMapelModel->getById($dataKompetensi["data"][0]["mapel_id"]);

				if ($dataMapel['total'] >= 1) {

					$dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

					if ($dataKelas['total'] >= 1) {
						$this->data['title'] = "Ubah Indikator '" . $dataIndikator['data'][0]['indikator'] . "'";
						$this->data['content'] = "indikator.form-update";
						$this->data['kelas'] = $dataKelas['data'][0];
						$this->data['mapel'] = $dataMapel['data'][0];
						$this->data['kompetensi'] = $dataKompetensi['data'][0];
						$this->data['indikatorInduk'] = $dataIndikatorInduk['data'][0];
						$this->data['id'] = $dataIndikator['data'][0]['id_indikator'];

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
