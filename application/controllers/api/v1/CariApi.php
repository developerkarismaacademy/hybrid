<?php
defined('BASEPATH') or exit('No direct script access allowed');


class CariApi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('front-v2/CariModel', 'FrontCariModel', true);
        $this->load->model('front-v2/MapelModel', 'FrontMapelModel', true);
    }

    public function jsondata()
    {
        $limit = $_GET['limit'] ?? 10;
        $page = $_GET['page'] ?? 1;
        $search = $_GET['search'] ?? "";
        $order = $_GET['order'] ?? "rating_rata|DESC";
        $idKelas = $_GET['idKelas'] ?? 0;

        $start = ($page > 1) ? ($page * $limit) - $limit : 0;
        $order_option = explode("|", $order)[1];
        $order = explode("|", $order)[0];

        $dataMapel = $this->FrontCariModel->getPaging($limit, $start, $search, $order, $order_option, $idKelas);
        $dataMapel = obj_to_arr($dataMapel);

        $params = "";
        if (isset($_GET) && count($_GET) > 0) {
            foreach ($_GET as $name => $value) {
                if ($name != "page") {
                    $params .= "&{$name}={$value}";
                }
            }
        }

        $first_page = $dataMapel['total_page'] == 1 || $page == 1 ? "#" : base_url("api/v1/CariApi/jsondata") . "?page=1" . $params;
        $last_page = $dataMapel['total_page'] == 1 || $page == $dataMapel['total_page'] ? "#" : base_url("api/v1/CariApi/jsondata") . "?page={$dataMapel['total_page']}" . $params;

        if (($page + 1) <= $dataMapel['total_page']) {
            $next_page = base_url("api/v1/CariApi/jsondata") . "?page=" . ($page + 1) . $params;
        } else {
            $next_page = "#";
        }

        if (($page - 1) >= 1) {
            $prev_page = base_url("api/v1/CariApi/jsondata") . "?page=" . ($page - 1) . $params;
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

    public function getHarga($harga = 500000, $diskon = 80)
    {
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode(hargaDiskon($harga, $diskon)));
    }
}
