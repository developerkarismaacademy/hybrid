<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProgressApi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('back/ProgressModel', 'BackProgressModel', true);
		$this->load->model('back/MateriModel', 'BackMateriModel', true);
		$this->load->model('back/MapelModel', 'BackMapelModel', true);
	}

	public function jsondatamapel()
	{

		$limit = $_GET['limit'] ?? 10;
		$page = $_GET['page'] ?? 1;
		$search = $_GET['search'] ?? "";
		$order = $_GET['order'] ?? "jml_notif|DESC";
		$idInstruktur = $_GET['idInstruktur'] ?? 0;

		$start = ($page > 1) ? ($page * $limit) - $limit : 0;
		$order_option = explode("|", $order)[1];
		$order = explode("|", $order)[0];

		$dataMapel = $this->BackProgressModel->getMapelByInstruktur($limit, $start, $search, $order, $order_option, $idInstruktur);
		$dataMapel = obj_to_arr($dataMapel);

		$params = "";
		if (isset($_GET) && count($_GET) > 0) {
			foreach ($_GET as $name => $value) {
				if ($name != "page") {
					$params .= "&{$name}={$value}";
				}
			}
		}

		$first_page = $dataMapel['total_page'] == 1 || $page == 1 ? "#" : base_url("api/v1/ProgressApi/jsondatamapel") . "?page=1" . $params;
		$last_page = $dataMapel['total_page'] == 1 || $page == $dataMapel['total_page'] ? "#" : base_url("api/v1/ProgressApi/jsondatamapel") . "?page={$dataMapel['total_page']}" . $params;

		if (($page + 1) <= $dataMapel['total_page']) {
			$next_page = base_url("api/v1/ProgressApi/jsondatamapel") . "?page=" . ($page + 1) . $params;
		} else {
			$next_page = "#";
		}

		if (($page - 1) >= 1) {
			$prev_page = base_url("api/v1/ProgressApi/jsondatamapel") . "?page=" . ($page - 1) . $params;
		} else {
			$prev_page = "#";
		}

		$dataMapel['current_page'] = $page;
		$dataMapel['start'] = $start;
		$dataMapel['end'] = $start + count($dataMapel['data']);
		$dataMapel['url_first_page'] = $first_page;
		$dataMapel['url_next_page'] = $next_page;
		$dataMapel['url_prev_page'] = $prev_page;
		$dataMapel['url_last_page'] = $last_page;

		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($dataMapel));
	}

	public function simpanNilaiPraktek()
	{
		$this->load->library(['form_validation']);
		$error = [];

		$data = [
			"nilai"                  => $_POST["nilai"],
			"materi_id"              => $_POST["id_materi"],
			"user_id"                => $_POST["id_user"],
			"status_baca_instruktur" => 1
		];


		$this->form_validation->set_data($data);

		$this->form_validation->set_rules('nilai', 'Nilai', 'required');
		$this->form_validation->set_rules('materi_id', 'Materi', 'required');
		$this->form_validation->set_rules('user_id', 'User', 'required');

		if ($this->form_validation->run() == false) {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";
		} else {
			$materi = $this->BackMateriModel->getById($_POST["id_materi"]);

			$simpan = $this->UniversalModel->update("log_praktek", "materi_id = {$_POST["id_materi"]} AND user_id = {$_POST["id_user"]}", $data);
			if ($simpan["success"]) {
				$code = 200;
				$return['message'] = "Berhasil Menyimpan Data";
				$return['success'] = true;
				$return['data'] = $data;

				$_SESSION["terakhirAksesMateri"] = $materi["data"][0]["id_materi"];
				$_SESSION["terakhirAksesBab"] = $materi["data"][0]["bab_id"];


			} else {
				$code = 500;
				$return['message'] = "Gagal Menyimpan Data";
				$return['success'] = false;
				$return['data'] = $data;
			}
		}

		return $this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output(json_encode($return));
	}

	public function simpanNilaiIndikator()
	{
		$idInstruktur = $this->session->backData != NULL ? $this->session->backData["id_user"] : "";
		$this->load->library(['form_validation']);
		$error = [];

		$data = [
			"indikator_id" => $_POST["indikator_id"],
			"nilai"        => isset($_POST["nilai"]) ? $_POST["nilai"] : 0,
			"user_id"      => $_POST["user_id"],
		];

		$data_nilai = [
			"materi_id"              => $_POST["materi_id"],
			"user_id"                => $_POST["user_id"],
			"nilai"                  => $_POST["nilai_total"],
			"status_baca_instruktur" => 1,
			"instruktur_id"          => $idInstruktur,
		];

		$this->form_validation->set_data($data);

		$this->form_validation->set_rules('indikator_id', 'Indikator', 'required');
		$this->form_validation->set_rules('user_id', 'User', 'required');

		if ($this->form_validation->run() == false) {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";
		} else {
			$nilai = $this->UniversalModel->getOneData("nilai_indikator", "indikator_id = {$_POST["indikator_id"]} AND user_id = {$_POST["user_id"]}");

			if ($nilai["total"] > 0) {
				$simpan = $this->UniversalModel->update("nilai_indikator", "indikator_id = {$_POST["indikator_id"]} AND user_id = {$_POST["user_id"]}", $data);
			} else {
				$simpan = $this->UniversalModel->insert("nilai_indikator", $data);
			}

			if ($simpan["success"]) {
				$logPraktek = $this->UniversalModel->getOneData("log_praktek", "materi_id = {$_POST["materi_id"]} AND user_id = {$_POST["user_id"]}");
				if ($nilai["total"] > 0) {
					$simpan_nilai = $this->UniversalModel->update("log_praktek", "materi_id = {$_POST["materi_id"]} AND user_id = {$_POST["user_id"]}", $data_nilai);
				} else {
					$simpan_nilai = $this->UniversalModel->insert("log_praktek", $data_nilai);
				}
				if ($simpan_nilai["success"]) {
					$code = 200;
					$return['message'] = "Berhasil Menyimpan Data";
					$return['success'] = true;
					$return['data'] = $simpan_nilai;
				} else {
					$code = 500;
					$return['message'] = "Gagal Menyimpan Data";
					$return['success'] = false;
					$return['data'] = $data;
				}
			} else {
				$code = 500;
				$return['message'] = "Gagal Menyimpan Data";
				$return['success'] = false;
				$return['data'] = $data;
			}
		}

		return
			$this->output
				->set_content_type('application/json')
				->set_status_header($code)
				->set_output(json_encode($return));
	}

	public function updateRaport()
	{
		$mapel_id = $_POST['mapel'];

		$dataMapel = $this->BackMapelModel->getById($mapel_id);

		if ($dataMapel['total'] >= 1) {
			$user_id = $_POST['user'];
			$raport_allowed = ($_POST['raport'] == true) ? 1 : 0;

			$id = [
				"mapel_id" => $mapel_id,
				"user_id"  => $user_id,
			];
			$data = [
				"raport_allowed" => $raport_allowed,
			];
			$simpan = $this->BackProgressModel->updateRaportData($id, $data);
			if ($simpan) {
				$code = 200;
				$return['message'] = "Berhasil Update Data";
				$return['success'] = true;
				$return['data'] = $data;
			} else {
				$code = 500;
				$return['message'] = "Gagal Update Data";
				$return['success'] = false;
				$return['data'] = $data;
			}
		} else {
			$code = 404;
			$return['message'] = "Data Tidak Di Temukan";
			$return['success'] = false;
		}


		return $this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output(json_encode($return));
	}
}
