<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Siswa extends CI_Controller
{
	private $data;

	public function __construct()
	{
		parent::__construct();

		$this->load->model('back/SiswaModel', 'BackSiswaModel', true);
		$this->data['menu'] = "siswa";
		$this->FrontAuthModel->isLoggedInAdmin();
	}

	public function index()
	{
		$this->data['title'] = "Siswa";
		$this->data['content'] = "siswa.list";

		$this->load->view('back/main', $this->data);
	}

	public function detail($idUser = 0)
	{
		$dataSiswa = $this->BackSiswaModel->getById($idUser);

		if ($dataSiswa["total"] >= 1) {

			$this->data['title'] = "Siswa";
			$this->data['content'] = "siswa.detail";
			$this->data['id'] = $dataSiswa['data'][0]['id_user'];
			$this->data['id_user'] = $dataSiswa['data'][0]['id_user'];
			$this->data['siswa'] = $dataSiswa['data'][0];
			$this->data['mapel'] = $this->BackSiswaModel->getAllMapelByUser($idUser);

			$this->load->view('back/main', $this->data);
		} else {
			redirect(base_url('back/not-found'));
		}
	}



//    public function setMeta()
//    {
//        $dataBab = $this->BackSiswaModel->getAll();
//        $simpan = true;
//        foreach ($dataBab['data'] as $key => $value) {
//            $data = [
//                "meta_link_materi" => $this->UniversalModel->getMetaLink("kelas", $value['nama_kelas']),

//            ];
//
//            $simpan = $simpan && $this->BackSiswaModel->updateData($value["id_kelas"], $data);
//        }
//    }
}
