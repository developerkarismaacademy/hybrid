<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SiswaApi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('back/SiswaModel', 'BackSiswaModel', true);
		$this->load->model('back/PesertaModel', 'BackPesertaModel', true);
	}

	public function jsondata()
	{
		$limit = $_GET['limit'] ?? 10;
		$page = $_GET['page'] ?? 1;
		$search = $_GET['search'] ?? "";
		$order = $_GET['order'] ?? "nama_user|ASC";

		$start = ($page > 1) ? ($page * $limit) - $limit : 0;
		$order_option = explode("|", $order)[1];
		$order = explode("|", $order)[0];

		$dataSiswa = $this->BackSiswaModel->getPaging($limit, $start, $search, $order, $order_option);
		$dataSiswa = obj_to_arr($dataSiswa);

		$params = "";
		if (isset($_GET) && count($_GET) > 0) {
			foreach ($_GET as $name => $value) {
				if ($name != "page") {
					$params .= "&{$name}={$value}";
				}
			}
		}

		$first_page = $dataSiswa['total_page'] == 1 || $page == 1 ? "#" : base_url("api/v1/SiswaApi/jsondata") . "?page=1" . $params;
		$last_page = $dataSiswa['total_page'] == 1 || $page == $dataSiswa['total_page'] ? "#" : base_url("api/v1/SiswaApi/jsondata") . "?page={$dataSiswa['total_page']}" . $params;

		if (($page + 1) <= $dataSiswa['total_page']) {
			$next_page = base_url("api/v1/SiswaApi/jsondata") . "?page=" . ($page + 1) . $params;
		} else {
			$next_page = "#";
		}

		if (($page - 1) >= 1) {
			$prev_page = base_url("api/v1/SiswaApi/jsondata") . "?page=" . ($page - 1) . $params;
		} else {
			$prev_page = "#";
		}

		$dataSiswa['current_page'] = $page;
		$dataSiswa['start'] = $start;
		$dataSiswa['end'] = $start + count($dataSiswa['data']);
		$dataSiswa['url_first_page'] = $first_page;
		$dataSiswa['url_next_page'] = $next_page;
		$dataSiswa['url_prev_page'] = $prev_page;
		$dataSiswa['url_last_page'] = $last_page;

		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($dataSiswa));
	}

	public function jsondatamapel()
	{
		$limit = $_GET['limit'] ?? 10;
		$page = $_GET['page'] ?? 1;
		$search = $_GET['search'] ?? "";
		$order = $_GET['order'] ?? "nama_user|ASC";
		$idMapel = $_GET['idMapel'] ?? 0;

		$start = ($page > 1) ? ($page * $limit) - $limit : 0;
		$order_option = explode("|", $order)[1];
		$order = explode("|", $order)[0];

		$dataSiswa = $this->BackSiswaModel->getPagingByMapel($limit, $start, $search, $order, $order_option, $idMapel);
		$dataSiswa = obj_to_arr($dataSiswa);

		$params = "";
		if (isset($_GET) && count($_GET) > 0) {
			foreach ($_GET as $name => $value) {
				if ($name != "page") {
					$params .= "&{$name}={$value}";
				}
			}
		}

		$first_page = $dataSiswa['total_page'] == 1 || $page == 1 ? "#" : base_url("api/v1/SiswaApi/jsondatamapel") . "?page=1" . $params;
		$last_page = $dataSiswa['total_page'] == 1 || $page == $dataSiswa['total_page'] ? "#" : base_url("api/v1/SiswaApi/jsondatamapel") . "?page={$dataSiswa['total_page']}" . $params;

		if (($page + 1) <= $dataSiswa['total_page']) {
			$next_page = base_url("api/v1/SiswaApi/jsondatamapel") . "?page=" . ($page + 1) . $params;
		} else {
			$next_page = "#";
		}

		if (($page - 1) >= 1) {
			$prev_page = base_url("api/v1/SiswaApi/jsondatamapel") . "?page=" . ($page - 1) . $params;
		} else {
			$prev_page = "#";
		}

		$dataSiswa['current_page'] = $page;
		$dataSiswa['start'] = $start;
		$dataSiswa['end'] = $start + count($dataSiswa['data']);
		$dataSiswa['url_first_page'] = $first_page;
		$dataSiswa['url_next_page'] = $next_page;
		$dataSiswa['url_prev_page'] = $prev_page;
		$dataSiswa['url_last_page'] = $last_page;

		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($dataSiswa));
	}

	public function getAll()
	{
		$dataSiswa = $this->BackSiswaModel->getAll();

		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($dataSiswa));
	}

	public function detail($id)
	{
		$dataSiswa = $this->BackSiswaModel->getById($id);
		if ($dataSiswa['total'] >= 1) {
			$code = 200;
			$return['message'] = "Data Di Temukan";
			$return['success'] = false;
			$return['data'] = $dataSiswa['data'][0];
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

	public function resetpass($id)
	{

		$dataSiswa = $this->BackSiswaModel->getById($id);
		if ($dataSiswa['total'] >= 1) {
			$data = [
				"password" => crypt(crypt("123456", garem), garem),
			];
			$simpan = $this->BackSiswaModel->updateData($id, $data);
			if ($simpan) {
				$code = 200;
				$return['message'] = "Berhasil Mereset Password (123456)";
				$return['success'] = true;
				$return['data'] = $data;
			} else {
				$code = 500;
				$return['message'] = "Gagal Mereset Password";
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


	public function peserta()
	{
		$user = $this->BackPesertaModel->getSiswaByMapel(122139);
		foreach ($user as &$data) {
			$data->sertifikat = $data->progress == 100 ? base_url('download-sertifikat/' . $data->meta_link_mapel . '/' . $data->id_user) : null;
		}
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode(
				[
					'status' => 'success',
					'data' => $user
				]
			));
	}

}
