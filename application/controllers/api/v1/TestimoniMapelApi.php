<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TestimoniMapelApi extends CI_Controller
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
		$paket = $_GET['paket'] ?? "nama_mapel|ASC";

		$start = ($page > 1) ? ($page * $limit) - $limit : 0;
		$paket_option = explode("|", $paket)[1];
		$paket = explode("|", $paket)[0];

		$dataPaket = $this->BackTestimoniModel->getPagingMapel($limit, $start, $search, $paket, $paket_option);
		$dataPaket = obj_to_arr($dataPaket);

		$params = "";
		if (isset($_GET) && count($_GET) > 0) {
			foreach ($_GET as $name => $value) {
				if ($name != "page") {
					$params .= "&{$name}={$value}";
				}
			}
		}

		$first_page = $dataPaket['total_page'] == 1 || $page == 1 ? "#" : base_url("api/v1/TestimoniMapelApi/jsondata") . "?page=1" . $params;
		$last_page = $dataPaket['total_page'] == 1 || $page == $dataPaket['total_page'] ? "#" : base_url("api/v1/TestimoniMapelApi/jsondata") . "?page={$dataPaket['total_page']}" . $params;

		if (($page + 1) <= $dataPaket['total_page']) {
			$next_page = base_url("api/v1/TestimoniMapelApi/jsondata") . "?page=" . ($page + 1) . $params;
		} else {
			$next_page = "#";
		}

		if (($page - 1) >= 1) {
			$prev_page = base_url("api/v1/TestimoniMapelApi/jsondata") . "?page=" . ($page - 1) . $params;
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

}
