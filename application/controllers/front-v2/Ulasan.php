<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Ulasan extends CI_Controller
{

	private $data;

	public function __construct()
	{
		parent::__construct();
		$this->data['page'] = "ulasan";

		$this->load->model("front-v2/AuthModel", "FrontAuthModel");
		$this->load->model("front-v2/KelasModel", "FrontKelasModel");
		$this->load->model("front-v2/MapelModel", "FrontMapelModel");
		$this->load->model("front-v2/UlasanModel", "FrontUlasanModel");

		$this->FrontAuthModel->isLoggedIn();
	}


	public function index($meta_link_mapel = "")
	{
		$this->data['content'] = "ulasan";
		if ($meta_link_mapel == "")
			redirect(base_url());
		$where = "meta_link_mapel = '{$meta_link_mapel}'";
		$dataMapel = $this->FrontMapelModel->getAllMapel($where);
		if ($dataMapel["total"] > 0) {
			$mapel = $dataMapel["data"][0];
			$id_mapel = $mapel["id_mapel"];
			$id_user = $_SESSION['siswaData']['id_user'];
			$this->data["mapel"] = $mapel;

			if ($mapel["progress"] >= 100) {
				$this->data["title"] = "Beri Ulasan";
				if ($this->FrontUlasanModel->getByUlasan($id_user, $id_mapel)['total'] > 0) {
					alert("danger", "Anda sudah mengulas", "Apabila ingin melihat sertifikat / raport, cek pada halaman <a href='" . base_url("profil") . "'>profil</a>");
				}
			} else {
				alert("danger", "Anda belum selesai", "Materi belum selesai dipelajari, lanjutkan sebelum mengisi ulasan");
				redirect(base_url("belajar/{$meta_link_mapel}"));
			}
		} else {
			redirect(base_url("profil"));
		}

		$this->load->view("front-v2/main", $this->data);
	}


}
