<?php
defined('BASEPATH') or exit('No direct script access allowed');


class DiskusiApi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('back/BabModel', 'BackBabModel', true);
        $this->load->model('back/MateriModel', 'BackMateriModel', true);
        $this->load->model('front-v2/DiskusiModel', 'FrontDiskusiModel', true);
        $this->load->model('back/DiskusiModel', 'BackDiskusiModel', true);
    }

    public function jsondata()
    {
        $limit = $_GET['limit'] ?? 10;
        $page = $_GET['page'] ?? 1;
        $search = $_GET['search'] ?? "";
        $order = $_GET['order'] ?? "diskusi.created_at|DESC";
        $id["mapel_id"] = $_GET['idMapel'] ?? "";
        $id["bab_id"] = $_GET['idBab'] ?? "";
        $id["materi_id"] = $_GET['idMateri'] ?? "";

        $start = ($page > 1) ? ($page * $limit) - $limit : 0;
        $order_option = explode("|", $order)[1];
        $order = explode("|", $order)[0];

        $dataDiskusi = $this->FrontDiskusiModel->getPaging($limit, $start, $search, $order, $order_option, $id);
        $dataDiskusi = obj_to_arr($dataDiskusi);

        $params = "";
        if (isset($_GET) && count($_GET) > 0) {
            foreach ($_GET as $name => $value) {
                if ($name != "page") {
                    $params .= "&{$name}={$value}";
                }
            }
        }

        $first_page = $dataDiskusi['total_page'] == 1 || $page == 1 ? "#" : base_url("api/v1/DiskusiApi/jsondata") . "?page=1" . $params;
        $last_page = $dataDiskusi['total_page'] == 1 || $page == $dataDiskusi['total_page'] ? "#" : base_url("api/v1/DiskusiApi/jsondata") . "?page={$dataDiskusi['total_page']}" . $params;

        if (($page + 1) <= $dataDiskusi['total_page']) {
            $next_page = base_url("api/v1/DiskusiApi/jsondata") . "?page=" . ($page + 1) . $params;
        } else {
            $next_page = "#";
        }

        if (($page - 1) >= 1) {
            $prev_page = base_url("api/v1/DiskusiApi/jsondata") . "?page=" . ($page - 1) . $params;
        } else {
            $prev_page = "#";
        }

        $dataDiskusi['current_page'] = $page;
        $dataDiskusi['start'] = $start;
        $dataDiskusi['end'] = $start + count($dataDiskusi['data']);
        $dataDiskusi['url_first_page'] = $first_page;
        $dataDiskusi['url_next_page'] = $next_page;
        $dataDiskusi['url_prev_page'] = $prev_page;
        $dataDiskusi['url_last_page'] = $last_page;

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($dataDiskusi));
    }

    public function detail($id)
    {
        $idArray["id_diskusi"] = $id;
        $dataDiskusi = $this->BackDiskusiModel->getById($id);

        if ($dataDiskusi['total'] >= 1) {
            $code = 200;
            $return['message'] = "Data Di temukan";
            $return['success'] = false;
            $return['data'] = $dataDiskusi['data'][0];
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
        if (!isset($_POST['materi_id']) || $_POST['materi_id'] == '') {
            $_POST['materi_id'] = 0;
        }
        if (!isset($_POST['bab_id']) || $_POST['bab_id'] == '') {
            $_POST['bab_id'] = 0;
        }
        $data = [
            "isi" => $_POST['isi'],

            "user_id"    => $_SESSION['siswaData']['id_user'],
            "created_at" => date('Y-m-d H:i:s'),
        ];

        if (isset($_POST['diskusi_id'])) {
            $data["diskusi_id"] = $_POST['diskusi_id'];
            $data["tipe"] = "jawaban";

            $dataDiskusi = $this->FrontDiskusiModel->getById($_POST['diskusi_id']);
            if ($dataDiskusi['total']) {
                $data["mapel_id"] = $dataDiskusi['data'][0]['mapel_id'];
                $data["materi_id"] = $dataDiskusi['data'][0]["materi_id"];
                $data["bab_id"] = $dataDiskusi['data'][0]['bab_id'];
            } else {
                $code = 500;
                $return['message'] = "Gagal Menyimpan Data";
                $return['success'] = false;
                $return['data'] = $data;
            }
        } else {
            $data["mapel_id"] = $_POST['mapel_id'];
            $data["materi_id"] = $_POST["materi_id"];
            $data["bab_id"] = $_POST['bab_id'];
        }

        $error = [];

        $simpan = $this->FrontDiskusiModel->saveData($data);
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

    public function update()
    {
        $id = $_POST['id_diskusi'] ?? 0;
        $dataDiskusi = $this->FrontDiskusiModel->getById($id);

        if ($dataDiskusi['total'] >= 1) {
            $data = [
                "isi"        => $_POST['isi'],
                "updated_at" => $this->datesql(),
            ];

            $simpan = $this->FrontDiskusiModel->updateData($id, $data);
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
        $dataDiskusi = $this->FrontDiskusiModel->getById($id);

        if ($dataDiskusi['total'] >= 1) {
            $simpan = $this->FrontDiskusiModel->deleteData($id);
            if ($simpan) {
                $code = 200;
                $return['message'] = "Berhasil Menghapus";
                $return['success'] = true;
            } else {
                $code = 500;
                $return['message'] = "Gagal Menyimpan";
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


    public function datesql()
    {
        return date('Y-m-d H:i:s');
    }


}
