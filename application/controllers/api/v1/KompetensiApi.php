<?php
defined('BASEPATH') or exit('No direct script access allowed');


class KompetensiApi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('back/KompetensiModel', 'BackKompetensiModel', true);
    }

    public function jsondata()
    {
        $limit = $_GET['limit'] ?? 10;
        $page = $_GET['page'] ?? 1;
        $search = $_GET['search'] ?? "";
        $order = $_GET['order'] ?? "urutan_kompetensi|ASC";
        $idMapel = $_GET['idMapel'] ?? 0;

        $start = ($page > 1) ? ($page * $limit) - $limit : 0;
        $order_option = explode("|", $order)[1];
        $order = explode("|", $order)[0];

        $dataKompetensi = $this->BackKompetensiModel->getPaging($limit, $start, $search, $order, $order_option, $idMapel);
        $dataKompetensi = obj_to_arr($dataKompetensi);

        $params = "";
        if (isset($_GET) && count($_GET) > 0) {
            foreach ($_GET as $name => $value) {
                if ($name != "page") {
                    $params .= "&{$name}={$value}";
                }
            }
        }

        $first_page = $dataKompetensi['total_page'] == 1 || $page == 1 ? "#" : base_url("api/v1/KompetensiApi/jsondata") . "?page=1" . $params;
        $last_page = $dataKompetensi['total_page'] == 1 || $page == $dataKompetensi['total_page'] ? "#" : base_url("api/v1/KompetensiApi/jsondata") . "?page={$dataKompetensi['total_page']}" . $params;

        if (($page + 1) <= $dataKompetensi['total_page']) {
            $next_page = base_url("api/v1/KompetensiApi/jsondata") . "?page=" . ($page + 1) . $params;
        } else {
            $next_page = "#";
        }

        if (($page - 1) >= 1) {
            $prev_page = base_url("api/v1/KompetensiApi/jsondata") . "?page=" . ($page - 1) . $params;
        } else {
            $prev_page = "#";
        }

        $dataKompetensi['current_page'] = $page;
        $dataKompetensi['start'] = $start;
        $dataKompetensi['end'] = $start + count($dataKompetensi['data']);
        $dataKompetensi['url_first_page'] = $first_page;
        $dataKompetensi['url_next_page'] = $next_page;
        $dataKompetensi['url_prev_page'] = $prev_page;
        $dataKompetensi['url_last_page'] = $last_page;

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($dataKompetensi));
    }

    public function getAll()
    {
        $dataKompetensi = $this->BackKompetensiModel->getAll();

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($dataKompetensi));
    }

    public function getAllByMapel($idMapel = 0)
    {
        $dataKompetensi = $this->BackKompetensiModel->getAllByMapel($idMapel);

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($dataKompetensi));
    }


    public function detail($id)
    {
        $dataKompetensi = $this->BackKompetensiModel->getById($id);

        if ($dataKompetensi['total'] >= 1) {
            $code = 200;
            $return['message'] = "Data Di temukan";
            $return['success'] = false;
            $return['data'] = $dataKompetensi['data'][0];
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
            "kompetensi" => $_POST['kompetensi'],
            "mapel_id"   => $_POST['mapel_id'],
            "bab_id"     => (isset($_POST['bab_id'])) ? $_POST['bab_id'] : null,
        ];

        $error = [];

        $this->form_validation->set_data($data);

        $this->form_validation->set_rules('kompetensi', 'Kompetensi', 'required');
        $this->form_validation->set_rules('mapel_id', 'Mata Pelajaran', 'required');

        if ($this->form_validation->run() == false) {
            $return = $error;
            $code = 422;
            $return['form'] = $this->form_validation->error_array();
            $return['success'] = false;
            $return['message'] = "Data Tidak Valid";
        } else {
            $simpan = $this->BackKompetensiModel->saveData($data);
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
        $id = $_POST['id_kompetensi'] ?? 0;
        $dataKompetensi = $this->BackKompetensiModel->getById($id);

        if ($dataKompetensi['total'] >= 1) {
            $this->load->library(['form_validation', 'upload']);

            $data = [
                "kompetensi" => $_POST['kompetensi'],
                "mapel_id"   => $_POST['mapel_id'],
                "bab_id"     => $_POST['bab_id'],
            ];

            $error = [];

            $this->form_validation->set_data($data);
            $this->form_validation->set_rules('kompetensi', 'Kompetensi', 'required');
            $this->form_validation->set_rules('mapel_id', 'Mata Pelajaran', 'required');
            $this->form_validation->set_rules('bab_id', 'Bab', 'required');

            if ($this->form_validation->run() == false) {
                $return = $error;
                $code = 422;
                $return['form'] = $this->form_validation->error_array();
                $return['success'] = false;
                $return['message'] = "Data Tidak Valid";

            } else {
                $simpan = $this->BackKompetensiModel->updateData($id, $data);
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
        $dataKompetensi = $this->BackKompetensiModel->getById($id);

        if ($dataKompetensi['total'] >= 1) {
            $simpan = $this->BackKompetensiModel->deleteData($id);
            if ($simpan) {
                $code = 200;
                $return['message'] = "Berhasil Menghapus " . $dataKompetensi['data'][0]['kompetensi'];
                $return['success'] = true;
            } else {
                $code = 500;
                $return['message'] = "Gagal Menyimpan " . $dataKompetensi['data'][0]['kompetensi'];
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


    public function simpanUrutan()
    {
        $i = 1;
        $simpan = true;
        foreach ($_POST['data'] as $key => $value) {

            $data = [
                "urutan_kompetensi" => $i,
            ];

            $simpan = $simpan && $this->BackKompetensiModel->updateData($value["id"], $data);

            $i++;

        }

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

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output(json_encode($return));
    }
}
