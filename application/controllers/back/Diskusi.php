<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Diskusi extends CI_Controller
{
	private $data;

	public function __construct()
	{
		parent::__construct();

		$this->load->model('back/MapelModel', 'BackMapelModel', true);
		$this->load->model('back/KelasModel', 'BackKelasModel', true);
		$this->load->model('back/BabModel', 'BackBabModel', true);
		$this->load->model('back/MateriModel', 'BackMateriModel', true);
		$this->load->model('back/DiskusiModel', 'BackDiskusiModel', true);
		$this->data['menu'] = "kelas";
		$this->FrontAuthModel->isLoggedInAdmin();
	}

	public function index($meta = "")
	{
		$this->data['tipe'] = "";
		$this->data['title'] = " Daftar Diskusi ";

		$uriArray = $this->uri->segment_array();
		if (in_array("bab", $uriArray)) {
			$this->data['tipe'] = "bab";
		} else if (in_array("materi", $uriArray)) {
			$this->data['tipe'] = "materi";
		}


		$success = false;
		$dataTipe = $this->BackMateriModel->getByMeta($meta);
		switch ($this->data['tipe']):
			case "bab":
				$dataTipe = $this->BackMapelModel->getByMeta($meta);

				if ($dataTipe['total'] >= 1) {
					$this->data['mapel_id'] = $dataTipe['data'][0]['id_mapel'];
					$this->data['title'] .= "Mata Pelajaran " . $dataTipe['data'][0]['nama_mapel'];

					$success = true;
				} else {
					redirect(base_url('back/not-found'));
				}
				break;

			case "materi":
				$dataTipe = $this->BackMateriModel->getByMeta($meta);

				if ($dataTipe['total'] >= 1) {
					$this->data['mapel_id'] = $dataTipe['data'][0]['mapel_id'];
					$this->data['materi_id'] = $dataTipe['data'][0]['id_materi'];
					$this->data['meta_materi'] = $dataTipe['data'][0]['meta_link_materi'];
					$this->data['bab_id'] = $dataTipe['data'][0]['bab_id'];
					$this->data['title'] .= "Materi " . $dataTipe['data'][0]['nama_materi'];


					$dataBab = $this->BackBabModel->getById($this->data['bab_id']);

					if ($dataBab['total'] >= 1) {
						$this->data['meta_bab'] = $dataTipe['data'][0]['meta_link_bab'];

						$success = true;
					} else {
						redirect(base_url('back/not-found'));
					}
				} else {
					redirect(base_url('back/not-found'));
				}
				break;

			default:
				$idKelas = 0;
				break;
		endswitch;

		if ($success) {
			$this->data['meta_mapel'] = $dataTipe['data'][0]['meta_link_mapel'];
			$this->data['kelas_id'] = $dataTipe['data'][0]['id_kelas'];
			$this->data['meta_kelas'] = $dataTipe['data'][0]['meta_link_kelas'];
			$dataKelas = $this->BackKelasModel->getById($this->data['kelas_id']);

			if ($dataKelas['total'] >= 1) {
				$this->data['meta_kelas'] = $dataTipe['data'][0]['meta_link_kelas'];
				$this->data['kelas_id'] = $dataTipe['data'][0]['kelas_id'];

				$this->data['content'] = "diskusi.list";

				$this->load->view('back/main', $this->data);
			} else {
				redirect(base_url('back/not-found'));
			}
		} else {
			redirect(base_url('back/not-found'));
		}
	}

}
