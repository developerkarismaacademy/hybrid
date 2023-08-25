<?php
defined('BASEPATH') or exit('No direct script access allowed');


class KelasApi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('back/KelasModel', 'BackKelasModel', true);
    }

    public function jsondata()
    {
        $limit = $_GET['limit'] ?? 10;
        $page = $_GET['page'] ?? 1;
        $search = $_GET['search'] ?? "";
        $order = $_GET['order'] ?? "nama_kelas|ASC";

        $start = ($page > 1) ? ($page * $limit) - $limit : 0;
        $order_option = explode("|", $order)[1];
        $order = explode("|", $order)[0];

        $dataKelas = $this->BackKelasModel->getPaging($limit, $start, $search, $order, $order_option);
        $dataKelas = obj_to_arr($dataKelas);

        $params = "";
        if (isset($_GET) && count($_GET) > 0) {
            foreach ($_GET as $name => $value) {
                if ($name != "page") {
                    $params .= "&{$name}={$value}";
                }
            }
        }

        $first_page = $dataKelas['total_page'] == 1 || $page == 1 ? "#" : base_url("api/v1/KelasApi/jsondata") . "?page=1" . $params;
        $last_page = $dataKelas['total_page'] == 1 || $page == $dataKelas['total_page'] ? "#" : base_url("api/v1/KelasApi/jsondata") . "?page={$dataKelas['total_page']}" . $params;

        if (($page + 1) <= $dataKelas['total_page']) {
            $next_page = base_url("api/v1/KelasApi/jsondata") . "?page=" . ($page + 1) . $params;
        } else {
            $next_page = "#";
        }

        if (($page - 1) >= 1) {
            $prev_page = base_url("api/v1/KelasApi/jsondata") . "?page=" . ($page - 1) . $params;
        } else {
            $prev_page = "#";
        }

        $dataKelas['current_page'] = $page;
        $dataKelas['start'] = $start;
        $dataKelas['end'] = $start + count($dataKelas['data']);
        $dataKelas['url_first_page'] = $first_page;
        $dataKelas['url_next_page'] = $next_page;
        $dataKelas['url_prev_page'] = $prev_page;
        $dataKelas['url_last_page'] = $last_page;

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($dataKelas));
    }

    public function getAll()
    {
        $dataKelas = $this->BackKelasModel->getAll();

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($dataKelas));
    }

    public function detail($id)
    {
        $dataKelas = $this->BackKelasModel->getById($id);

        if ($dataKelas['total'] >= 1) {
            $code = 200;
            $return['message'] = "Data Di temukan";
            $return['success'] = false;
            $return['data'] = $dataKelas['data'][0];
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
            "nama_kelas"        => $_POST['nama_kelas'],
            "deskripsi_kelas"   => $_POST['deskripsi_kelas'],
            "color_kelas"       => $_POST['color_kelas'],
            "deskripsi_singkat" => $_POST['deskripsi_singkat'],
            "meta_link_kelas"   => $this->BackKelasModel->getMetaLink($_POST['nama_kelas'])
        ];

        $error = [];

        if (!isset($_FILES['gambar_kelas']['name']) || $_FILES['gambar_kelas']['name'] == "") {
            $nama_file = "";
        } else {
            $config['upload_path'] = './upload/kelas';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['encrypt_name'] = true;
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('gambar_kelas')) {
                $error['image'] = $this->upload->display_errors();
                $nama_file = "";
            } else {
                $nama_file = $this->upload->data('file_name');
            }
        }
        $data['gambar_kelas'] = $nama_file;


        $this->form_validation->set_data($data);

        $this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'required|max_length[50]');

        if ($this->form_validation->run() == false) {
            $return = $error;
            $code = 422;
            $return['form'] = $this->form_validation->error_array();
            $return['success'] = false;
            $return['message'] = "Data Tidak Valid";

            if ($data['gambar_kelas'] != "") {
                unlink('./upload/kelas/' . $data['gambar_kelas']);
            }

            if (isset($error['image']) && $error['image'] != "") {
                $return['form']['gambar_kelas'] = $error['image'];
            }
        } elseif (isset($error['image']) && $error['image'] != "") {
            $return = $error;
            $code = 422;
            $return['form'] = $this->form_validation->error_array();
            $return['form']['gambar_kelas'] = $error['image'];
            $return['success'] = false;
            $return['message'] = "Data Tidak Valid";
        } else {
            $simpan = $this->BackKelasModel->saveData($data);
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
        $id = $_POST['id_kelas'] ?? 0;
        $dataKelas = $this->BackKelasModel->getById($id);

        if ($dataKelas['total'] >= 1) {
            $this->load->library(['form_validation', 'upload']);

            $data = [
                "nama_kelas"        => $_POST['nama_kelas'],
                "deskripsi_kelas"   => $_POST['deskripsi_kelas'],
                "color_kelas"       => $_POST['color_kelas'],
                "deskripsi_singkat" => $_POST['deskripsi_singkat'],
                "meta_link_kelas"   => ($_POST['nama_kelas'] != $dataKelas['data'][0]['nama_kelas'] ? $this->BackKelasModel->getMetaLink($_POST['nama_kelas'], $id) : $dataKelas['data'][0]['meta_link_kelas'])

            ];

            $error = [];

            if (!isset($_FILES['gambar_kelas']['name']) || $_FILES['gambar_kelas']['name'] == "") {
                $nama_file = $dataKelas['data'][0]['gambar_kelas'];
            } else {
                $config['upload_path'] = './upload/kelas';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['encrypt_name'] = true;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('gambar_kelas')) {
                    $error['image'] = $this->upload->display_errors();
                    $nama_file = $dataKelas['data'][0]['gambar_kelas'];
                } else {
                    if ($dataKelas['data'][0]['gambar_kelas'] != "") {
                        unlink('./upload/kelas/' . $dataKelas['data'][0]['gambar_kelas']);
                    }
                    $nama_file = $this->upload->data('file_name');
                }
            }
            $data['gambar_kelas'] = $nama_file;

            $this->form_validation->set_data($data);
            $this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'required|max_length[50]');

            if ($this->form_validation->run() == false) {
                $return = $error;
                $code = 422;
                $return['form'] = $this->form_validation->error_array();
                $return['success'] = false;
                $return['message'] = "Data Tidak Valid";
                if ($data['gambar_kelas'] != "") {
                    unlink('./upload/kelas/' . $data['gambar_kelas']);
                }

                if (isset($error['image']) && $error['image'] != "") {
                    $return['form']['gambar_kelas'] = $error['image'];
                }
            } elseif (isset($error['image']) && $error['image'] != "") {
                $return = $error;
                $code = 422;
                $return['form'] = $this->form_validation->error_array();
                $return['form']['gambar_kelas'] = $error['image'];
                $return['success'] = false;
                $return['message'] = "Data Tidak Valid";
            } else {
                $simpan = $this->BackKelasModel->updateData($id, $data);
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
        $dataKelas = $this->BackKelasModel->getById($id);

        if ($dataKelas['total'] >= 1) {

            $simpan = $this->BackKelasModel->deleteData($id);

            if ($simpan) {

                if ($dataKelas['data'][0]['gambar_kelas'] != "") {
                    unlink('./upload/kelas/' . $dataKelas['data'][0]['gambar_kelas']);
                }

                $code = 200;
                $return['message'] = "Berhasil Menghapus " . $dataKelas['data'][0]['nama_kelas'];
                $return['success'] = true;
            } else {
                $code = 500;
                $return['message'] = "Gagal Menyimpan " . $dataKelas['data'][0]['nama_kelas'];
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
