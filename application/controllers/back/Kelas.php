<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Kelas extends CI_Controller
{
	private $data;

	public function __construct()
	{
		parent::__construct();

		$this->load->model('back/KelasModel', 'BackKelasModel', true);
		$this->data['menu'] = "kelas";
		$this->FrontAuthModel->isLoggedInAdmin();
	}

	public function index()
	{
		$this->data['title'] = "Kelas";
		$this->data['content'] = "kelas.list";

		$this->load->view('back/main', $this->data);
	}

	public function tambah()
	{
		$this->data['title'] = "Tambah Kelas";
		$this->data['content'] = "kelas.form-insert";

		$this->load->view('back/main', $this->data);
	}

	public function ubah($metaKelas = "")
	{
		$dataKelas = $this->BackKelasModel->getByMeta($metaKelas);

		if ($dataKelas['total'] >= 1) {
			$this->data['title'] = "Ubah Kelas " . $dataKelas['data'][0]['nama_kelas'];
			$this->data['content'] = "kelas.form-update";
			$this->data['id'] = $dataKelas['data'][0]['id_kelas'];

			$this->load->view('back/main', $this->data);
		} else {
			redirect(base_url('back/not-found'));
		}

	}

//    public function setMeta()
//    {
//        $dataBab = $this->BackKelasModel->getAll();
//        $simpan = true;
//        foreach ($dataBab['data'] as $key => $value) {
//            $data = [
//                "meta_link_materi" => $this->UniversalModel->getMetaLink("kelas", $_POST['nama_kelas']),
//            ];
//
//            $simpan = $simpan && $this->BackKelasModel->updateData($value["id_kelas"], $data);
//        }
//    }
}
