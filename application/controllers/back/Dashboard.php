<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Dashboard extends CI_Controller
{
	private $data;

	public function __construct()
	{
		parent::__construct();

		$this->load->model("back/TransaksiModel", "BackTransaksiModel");
		$this->load->model("back/SiswaModel", "BackSiswaModel");
		$this->load->model("back/MapelModel", "BackMapelModel");
		$this->load->model("back/KelasModel", "BackKelasModel");
		$this->load->model("back/InstrukturModel", "BackInstrukturModel");

		$this->data['menu'] = "dashboard";
	}

	public function index()
	{
		$this->FrontAuthModel->isLoggedInAdmin();

		$this->data['title'] = "Dashboard";
		$this->data['content'] = "dashboard";


		if ($this->session->backData['level_user'] == "administrasi") {
			$this->data["transaksi"] = $this->BackTransaksiModel->getAllKonfirmasiAndBelumBayar();
			$this->data["siswa"] = $this->BackSiswaModel->getAll();
			$this->data["mapel"] = $this->BackMapelModel->getAll();
			$this->data["kelas"] = $this->BackKelasModel->getAll();
		} elseif ($this->session->backData['level_user'] == "instruktur") {
			$this->data["mapel"] = $this->BackInstrukturModel->getAllMapelByInstruktur($this->session->backData['id']);
			$this->data["kelas"] = $this->BackInstrukturModel->getAllKelasByInstruktur($this->session->backData['id']);
			$idMapel = [];

			if ($this->data["mapel"]["total"] > 0) {
				foreach ($this->data["mapel"]["data"] as $KeyMapel => $valueMapel) {
					$idMapel[] = $valueMapel["id_mapel"];
				}

				$this->data["siswa"] = $this->BackSiswaModel->getAllSiswaByMapelIN(implode(",", $idMapel));
				$this->data["praktek"] = $this->BackInstrukturModel->getAllLogSiswa(implode(",", $idMapel));

			} else {
				$this->data["praktek"] = [
					"data"  => [],
					"total" => 0
				];

				$this->data["siswa"] = [
					"data"  => [],
					"total" => 0
				];
			}

		}

		//return $this->output
		//	->set_content_type('application/json')
		//	->set_status_header(200)
		//	->set_output(json_encode($this->data));
		$this->load->view('back/main', $this->data);
	}

	public function notFound404()
	{
		$this->data['title'] = "Halaman Tidak Di temukan";
		$this->data['content'] = "404";

		$this->load->view('back/main', $this->data);
	}

	public function notFound404Alt()
	{
		$this->load->view('back/404-alt/404-alt');
	}

	public function login()
	{
		$this->FrontAuthModel->isNotLoggedInAdmin();

		$this->load->view('back/login');
	}

	public function submitLogin()
	{
		$get = [
			"username" => $this->input->post('username'),
			"password" => crypt(crypt($this->input->post('password'), garem), garem),
		];

		$userData = $this->FrontAuthModel->getLoginWithoutLevel($get);

		if ($userData != NULL) {
			if ($userData->level_user == "administrasi" || $userData->level_user == "instruktur") {
				$sessionData = [
					"id"          => $userData->id_user,
					"id_user"     => $userData->id_user,
					"type"        => $userData->level_user,
					"level_user"  => $userData->level_user,
					"nama_user"   => $userData->nama_user,
					"email_user"  => $userData->email_user,
					"gambar_user" => $userData->gambar_user,
				];

				$this->session->set_userdata(['backData' => $sessionData]);


				redirect(base_url() . "back");
			} else {
				alert_error("Login salah", "Silahkan cek ulang login anda");
				redirect(base_url() . "back/login");
			}
		} else {
			alert_error("Login salah", "Silahkan cek ulang login anda");
			redirect(base_url() . "back/login");
		}
	}


	public function logout()
	{
		// Remove user data from session
		$this->session->unset_userdata('backData');
		unset($_SESSION["raporIdUser"]);
		// Redirect to login page

		redirect(base_url("back/login"));
	}
}
