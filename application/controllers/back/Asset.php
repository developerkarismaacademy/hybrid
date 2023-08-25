<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Asset extends CI_Controller
{
	private $data;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('back/AssetModel', 'BackAssetModel', true);
		$this->load->model('back/MapelModel', 'BackMapelModel', true);
		$this->load->model('back/KelasModel', 'BackKelasModel', true);
		$this->load->model('back/BabModel', 'BackBabModel', true);
		$this->load->model('back/MateriModel', 'BackMateriModel', true);
		$this->load->model('back/SoalModel', 'BackSoalModel', true);
		$this->data['menu'] = "Asset";
		$this->FrontAuthModel->isLoggedInAdmin();
	}

	public function index($id)
	{

		$dataMateri = $this->BackMateriModel->getById($id);

		if ($dataMateri['total'] >= 1) {
			$dataBab = $this->BackBabModel->getById($dataMateri['data'][0]['bab_id']);

			if ($dataBab['total'] >= 1) {
				$dataMapel = $this->BackMapelModel->getById($dataBab['data'][0]['mapel_id']);

				if ($dataMapel['total'] >= 1) {

					$dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

					if ($dataKelas['total'] >= 1) {
						$this->data['title'] = " Daftar Asset Materi " . $dataMateri['data'][0]['nama_materi'];
						$this->data['content'] = "asset.list";
						$this->data['kelas'] = $dataKelas['data'][0];
						$this->data['mapel'] = $dataMapel['data'][0];
						$this->data['bab'] = $dataBab['data'][0];
						$this->data['materi'] = $dataMateri['data'][0];
						$this->data['id'] = $dataMateri['data'][0]['id_materi'];

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


	public function tambah($id)
	{

		$dataMateri = $this->BackMateriModel->getById($id);

		if ($dataMateri['total'] >= 1) {
			$dataBab = $this->BackBabModel->getById($dataMateri['data'][0]['bab_id']);

			if ($dataBab['total'] >= 1) {
				$dataMapel = $this->BackMapelModel->getById($dataBab['data'][0]['mapel_id']);

				if ($dataMapel['total'] >= 1) {

					$dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

					if ($dataKelas['total'] >= 1) {
						$this->data['title'] = " Tambah Asset Materi " . $dataMateri['data'][0]['nama_materi'];
						$this->data['content'] = "asset.form-insert";
						$this->data['kelas'] = $dataKelas['data'][0];
						$this->data['mapel'] = $dataMapel['data'][0];
						$this->data['bab'] = $dataBab['data'][0];
						$this->data['materi'] = $dataMateri['data'][0];
						$this->data['id'] = $dataMateri['data'][0]['id_materi'];

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


?>

