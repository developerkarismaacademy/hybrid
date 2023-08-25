<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TestimoniApi extends CI_Controller
{
	public function __construct()
	{
		parent:: __construct();
		$this->load->model('back/TestimoniModel', 'BackTestimoniModel');
	}

	public function jsondata()
	{
		$limit = $_GET['limit'] ?? 10;
		$page = $_GET['page'] ?? 1;
		$search = $_GET['search'] ?? "";
		$paket = $_GET['paket'] ?? "rating|ASC";
		$idMapel = $_GET['idMapel'] ?? 0;
		$start = ($page > 1) ? ($page * $limit) - $limit : 0;
		$paket_option = explode("|", $paket)[1];
		$paket = explode("|", $paket)[0];

		$dataPaket = $this->BackTestimoniModel->getPaging($limit, $start, $search, $paket, $paket_option, $idMapel);
		$dataPaket = obj_to_arr($dataPaket);

		$params = "";
		if (isset($_GET) && count($_GET) > 0) {
			foreach ($_GET as $name => $value) {
				if ($name != "page") {
					$params .= "&{$name}={$value}";
				}
			}
		}

		$first_page = $dataPaket['total_page'] == 1 || $page == 1 ? "#" : base_url("api/v1/TestimoniApi/jsondata") . "?page=1" . $params;
		$last_page = $dataPaket['total_page'] == 1 || $page == $dataPaket['total_page'] ? "#" : base_url("api/v1/TestimoniApi/jsondata") . "?page={$dataPaket['total_page']}" . $params;

		if (($page + 1) <= $dataPaket['total_page']) {
			$next_page = base_url("api/v1/TestimoniApi/jsondata") . "?page=" . ($page + 1) . $params;
		} else {
			$next_page = "#";
		}

		if (($page - 1) >= 1) {
			$prev_page = base_url("api/v1/TestimoniApi/jsondata") . "?page=" . ($page - 1) . $params;
		} else {
			$prev_page = "#";
		}

		$dataPaket['current_page'] = $page;
		$dataPaket['start'] = $start;
		$dataPaket['end'] = $start + count($dataPaket['data']);
		$dataPaket['url_first_page'] = $first_page;
		$dataPaket['url_next_page'] = $next_page;
		$dataPaket['url_prev_page'] = $prev_page;
		$dataPaket['url_last_page'] = $last_page;

		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($dataPaket));
	}


	public function detail($id)
	{
		$dataTestimoni = $this->BackTestimoniModel->getById($id);
		if ($dataTestimoni['total'] >= 1) {
			$code = 200;
			$return['message'] = "Data Di Temukan";
			$return['success'] = true;
			$return['data'] = $dataTestimoni['data'][0];
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

?>
