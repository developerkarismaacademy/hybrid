<?php
defined('BASEPATH') or exit('No direct script access allowed');


class IndikatorIndukApi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('back/IndikatorIndukModel', 'BackIndikatorIndukModel', true);
	}

	public function jsondata()
	{
		$limit = $_GET['limit'] ?? 10;
		$page = $_GET['page'] ?? 1;
		$search = $_GET['search'] ?? "";
		$order = $_GET['order'] ?? "id_indikator_induk|ASC";
		$idKompetensi = $_GET['idKompetensi'] ?? 0;

		$start = ($page > 1) ? ($page * $limit) - $limit : 0;
		$order_option = explode("|", $order)[1];
		$order = explode("|", $order)[0];

		$dataIndikatorInduk = $this->BackIndikatorIndukModel->getPaging($limit, $start, $search, $order, $order_option, $idKompetensi);
		$dataIndikatorInduk = obj_to_arr($dataIndikatorInduk);

		$params = "";
		if (isset($_GET) && count($_GET) > 0) {
			foreach ($_GET as $name => $value) {
				if ($name != "page") {
					$params .= "&{$name}={$value}";
				}
			}
		}

		$first_page = $dataIndikatorInduk['total_page'] == 1 || $page == 1 ? "#" : base_url("api/v1/IndikatorIndukApi/jsondata") . "?page=1" . $params;
		$last_page = $dataIndikatorInduk['total_page'] == 1 || $page == $dataIndikatorInduk['total_page'] ? "#" : base_url("api/v1/IndikatorIndukApi/jsondata") . "?page={$dataIndikatorInduk['total_page']}" . $params;

		if (($page + 1) <= $dataIndikatorInduk['total_page']) {
			$next_page = base_url("api/v1/IndikatorIndukApi/jsondata") . "?page=" . ($page + 1) . $params;
		} else {
			$next_page = "#";
		}

		if (($page - 1) >= 1) {
			$prev_page = base_url("api/v1/IndikatorIndukApi/jsondata") . "?page=" . ($page - 1) . $params;
		} else {
			$prev_page = "#";
		}

		$dataIndikatorInduk['current_page'] = $page;
		$dataIndikatorInduk['start'] = $start;
		$dataIndikatorInduk['end'] = $start + count($dataIndikatorInduk['data']);
		$dataIndikatorInduk['url_first_page'] = $first_page;
		$dataIndikatorInduk['url_next_page'] = $next_page;
		$dataIndikatorInduk['url_prev_page'] = $prev_page;
		$dataIndikatorInduk['url_last_page'] = $last_page;

		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($dataIndikatorInduk));
	}

	public function getAll()
	{
		$dataIndikatorInduk = $this->BackIndikatorIndukModel->getAll();

		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($dataIndikatorInduk));
	}

	public function getAllByKompetensi($idKompetensi = 0)
	{
		$dataIndikatorInduk = $this->BackIndikatorIndukModel->getAllByKompetensi($idKompetensi);

		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($dataIndikatorInduk));
	}


	public function detail($id)
	{
		$dataIndikatorInduk = $this->BackIndikatorIndukModel->getById($id);

		if ($dataIndikatorInduk['total'] >= 1) {
			$code = 200;
			$return['message'] = "Data Di temukan";
			$return['success'] = false;
			$return['data'] = $dataIndikatorInduk['data'][0];
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

	public function simpan()
	{
		$this->load->library(['form_validation', 'upload']);

		$data = [
			"indikator_induk" => $_POST['indikator_induk'],
			"kompetensi_id"   => $_POST['kompetensi_id'],
		];

		$error = [];

		$this->form_validation->set_data($data);

		$this->form_validation->set_rules('indikator_induk', 'IndikatorInduk', 'required');
		$this->form_validation->set_rules('kompetensi_id', 'Kompetensi', 'required');

		if ($this->form_validation->run() == false) {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";
		} else {
			$simpan = $this->BackIndikatorIndukModel->saveData($data);
			if ($simpan) {
				$code = 200;
				$return['message'] = "Berhasil Menyimpan Data";
				$return['success'] = true;
				$return['data'] = $data;
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


	public function update()
	{
		$id = $_POST['id_indikator_induk'] ?? 0;
		$dataIndikatorInduk = $this->BackIndikatorIndukModel->getById($id);

		if ($dataIndikatorInduk['total'] >= 1) {
			$this->load->library(['form_validation', 'upload']);

			$data = [
				"indikator_induk" => $_POST['indikator_induk'],
				"kompetensi_id"   => $_POST['kompetensi_id'],
			];

			$error = [];

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules('indikator_induk', 'IndikatorInduk', 'required');
			$this->form_validation->set_rules('kompetensi_id', 'Kompetensi', 'required');

			if ($this->form_validation->run() == false) {
				$return = $error;
				$code = 422;
				$return['form'] = $this->form_validation->error_array();
				$return['success'] = false;
				$return['message'] = "Data Tidak Valid";

			} else {
				$simpan = $this->BackIndikatorIndukModel->updateData($id, $data);
				if ($simpan) {
					$code = 200;
					$return['message'] = "Berhasil Menyimpan Data";
					$return['success'] = true;
					$return['data'] = $data;
				} else {
					$code = 500;
					$return['message'] = "Gagal Menyimpan Data";
					$return['success'] = false;
					$return['data'] = $data;
				}
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


	public function delete($id)
	{
		$id = $id ?? 0;
		$dataIndikatorInduk = $this->BackIndikatorIndukModel->getById($id);

		if ($dataIndikatorInduk['total'] >= 1) {
			$simpan = $this->BackIndikatorIndukModel->deleteData($id);
			if ($simpan) {
				$code = 200;
				$return['message'] = "Berhasil Menghapus " . $dataIndikatorInduk['data'][0]['indikator_induk'];
				$return['success'] = true;
			} else {
				$code = 500;
				$return['message'] = "Gagal Menyimpan " . $dataIndikatorInduk['data'][0]['indikator_induk'];
				$return['success'] = false;
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
