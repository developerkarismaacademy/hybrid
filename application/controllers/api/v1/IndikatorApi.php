<?php
defined('BASEPATH') or exit('No direct script access allowed');


class IndikatorApi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('back/IndikatorModel', 'BackIndikatorModel', true);
    }

    public function jsondata()
    {
        $limit = $_GET['limit'] ?? 10;
        $page = $_GET['page'] ?? 1;
        $search = $_GET['search'] ?? "";
        $order = $_GET['order'] ?? "id_indikator_induk|ASC";
        $idKompetensi = $_GET['idKompetensi'] ?? 0;
        $idIndikatorInduk = $_GET['idIndikatorInduk'] ?? 0;

        $start = ($page > 1) ? ($page * $limit) - $limit : 0;
        $order_option = explode("|", $order)[1];
        $order = explode("|", $order)[0];

        $dataIndikator = $this->BackIndikatorModel->getPaging($limit, $start, $search, $order, $order_option, $idKompetensi, $idIndikatorInduk);
        $dataIndikator = obj_to_arr($dataIndikator);

        $params = "";
        if (isset($_GET) && count($_GET) > 0) {
            foreach ($_GET as $name => $value) {
                if ($name != "page") {
                    $params .= "&{$name}={$value}";
                }
            }
        }

        $first_page = $dataIndikator['total_page'] == 1 || $page == 1 ? "#" : base_url("api/v1/IndikatorApi/jsondata") . "?page=1" . $params;
        $last_page = $dataIndikator['total_page'] == 1 || $page == $dataIndikator['total_page'] ? "#" : base_url("api/v1/IndikatorApi/jsondata") . "?page={$dataIndikator['total_page']}" . $params;

        if (($page + 1) <= $dataIndikator['total_page']) {
            $next_page = base_url("api/v1/IndikatorApi/jsondata") . "?page=" . ($page + 1) . $params;
        } else {
            $next_page = "#";
        }

        if (($page - 1) >= 1) {
            $prev_page = base_url("api/v1/IndikatorApi/jsondata") . "?page=" . ($page - 1) . $params;
        } else {
            $prev_page = "#";
        }

        $dataIndikator['current_page'] = $page;
        $dataIndikator['start'] = $start;
        $dataIndikator['end'] = $start + count($dataIndikator['data']);
        $dataIndikator['url_first_page'] = $first_page;
        $dataIndikator['url_next_page'] = $next_page;
        $dataIndikator['url_prev_page'] = $prev_page;
        $dataIndikator['url_last_page'] = $last_page;

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($dataIndikator));
    }

    public function getAll()
    {
        $dataIndikator = $this->BackIndikatorModel->getAll();

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($dataIndikator));
    }


    public function detail($id)
    {
        $dataIndikator = $this->BackIndikatorModel->getById($id);

        if ($dataIndikator['total'] >= 1) {
            $code = 200;
            $return['message'] = "Data Di temukan";
            $return['success'] = false;
            $return['data'] = $dataIndikator['data'][0];
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
            "indikator_induk_id" => $_POST['indikator_induk_id'],
            "kompetensi_id"      => $_POST['kompetensi_id'],
            "indikator"          => $_POST['indikator'],
        ];

        $error = [];

        $this->form_validation->set_data($data);

        $this->form_validation->set_rules('indikator', 'Indikator', 'required');
        $this->form_validation->set_rules('indikator_induk_id', 'Indikator Induk', 'required');
        $this->form_validation->set_rules('kompetensi_id', 'Kompetensi', 'required');

        if ($this->form_validation->run() == false) {
            $return = $error;
            $code = 422;
            $return['form'] = $this->form_validation->error_array();
            $return['success'] = false;
            $return['message'] = "Data Tidak Valid";
        } else {
            $simpan = $this->BackIndikatorModel->saveData($data);
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
        $id = $_POST['id_indikator'] ?? 0;
        $dataIndikator = $this->BackIndikatorModel->getById($id);

        if ($dataIndikator['total'] >= 1) {
            $this->load->library(['form_validation', 'upload']);

            $data = [
                "indikator_induk_id" => $_POST['indikator_induk_id'],
                "kompetensi_id"      => $_POST['kompetensi_id'],
                "indikator"          => $_POST['indikator'],
            ];

            $error = [];

            $this->form_validation->set_data($data);
            $this->form_validation->set_rules('indikator', 'Indikator', 'required');
            $this->form_validation->set_rules('indikator_induk_id', 'Indikator Induk', 'required');
            $this->form_validation->set_rules('kompetensi_id', 'Kompetensi', 'required');

            if ($this->form_validation->run() == false) {
                $return = $error;
                $code = 422;
                $return['form'] = $this->form_validation->error_array();
                $return['success'] = false;
                $return['message'] = "Data Tidak Valid";

            } else {
                $simpan = $this->BackIndikatorModel->updateData($id, $data);
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
        $dataIndikator = $this->BackIndikatorModel->getById($id);

        if ($dataIndikator['total'] >= 1) {
            $simpan = $this->BackIndikatorModel->deleteData($id);
            if ($simpan) {
                $code = 200;
                $return['message'] = "Berhasil Menghapus " . $dataIndikator['data'][0]['indikator_induk'];
                $return['success'] = true;
            } else {
                $code = 500;
                $return['message'] = "Gagal Menyimpan " . $dataIndikator['data'][0]['indikator_induk'];
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


