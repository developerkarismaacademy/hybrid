<?php
defined('BASEPATH') or exit('No direct script access allowed');

class InstrukturApi extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('back/InstrukturModel', 'BackInstrukturModel', true);
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

    $dataInstruktur = $this->BackInstrukturModel->getPaging($limit, $start, $search, $order, $order_option);
    $dataInstruktur = obj_to_arr($dataInstruktur);

    $params = "";
    if (isset($_GET) && count($_GET) > 0) {
      foreach ($_GET as $name => $value) {
        if ($name != "page") {
          $params .= "&{$name}={$value}";
        }
      }
    }

    $first_page = $dataInstruktur['total_page'] == 1 || $page == 1 ? "#" : base_url("api/v1/InstrukturApi/jsondata") . "?page=1" . $params;
    $last_page = $dataInstruktur['total_page'] == 1 || $page == $dataInstruktur['total_page'] ? "#" : base_url("api/v1/InstrukturApi/jsondata") . "?page={$dataInstruktur['total_page']}" . $params;

    if (($page + 1) <= $dataInstruktur['total_page']) {
      $next_page = base_url("api/v1/InstrukturApi/jsondata") . "?page=" . ($page + 1) . $params;
    } else {
      $next_page = "#";
    }

    if (($page - 1) >= 1) {
      $prev_page = base_url("api/v1/InstrukturApi/jsondata") . "?page=" . ($page - 1) . $params;
    } else {
      $prev_page = "#";
    }

    $dataInstruktur['current_page'] = $page;
    $dataInstruktur['start'] = $start;
    $dataInstruktur['end'] = $start + count($dataInstruktur['data']);
    $dataInstruktur['url_first_page'] = $first_page;
    $dataInstruktur['url_next_page'] = $next_page;
    $dataInstruktur['url_prev_page'] = $prev_page;
    $dataInstruktur['url_last_page'] = $last_page;

    return $this->output
      ->set_content_type('application/json')
      ->set_status_header(200)
      ->set_output(json_encode($dataInstruktur));
  }

  public function simpan()
  {
    $this->load->library(['form_validation', 'upload']);

    $data = [
      "nama_user"  => $_POST['nama_user'],
      "email_user" => $_POST['email_user'],
      "username"   => $_POST['username'],
      "password"   => crypt(crypt($this->input->post('password'), garem), garem),
      "jk_user"    => $_POST['jk_user'],
      "level_user" => "instruktur",
      "biodata"    => $_POST['biodata'],
    ];

    $error = [];

    if (!isset($_FILES['gambar_user']['name']) || $_FILES['gambar_user']['name'] == "") {
      $nama_file = "";
    } else {
      $config['upload_path'] = './upload/instruktur';
      $config['allowed_types'] = 'gif|jpg|png';
      $config['encrypt_name'] = true;
      $this->upload->initialize($config);
      if (!$this->upload->do_upload('gambar_user')) {
        $error['image'] = $this->upload->display_errors();
        $nama_file = "";
      } else {
        $nama_file = $this->upload->data('file_name');
      }
    }
    $data['gambar_user'] = $nama_file;
    if (!isset($_FILES['gambar_tanda_tangan']['name']) || $_FILES['gambar_tanda_tangan']['name'] == "") {
      $nama_file = "";
    } else {
      $config['upload_path'] = './upload/tanda_tangan';
      $config['allowed_types'] = 'gif|jpg|png';
      $config['encrypt_name'] = true;
      $this->upload->initialize($config);
      if (!$this->upload->do_upload('gambar_tanda_tangan')) {
        $error['image'] = $this->upload->display_errors();
        $nama_file = "";
      } else {
        $nama_file = $this->upload->data('file_name');
      }
    }
    $data['tanda_tangan'] = $nama_file;
    $this->form_validation->set_data($data);

    $this->form_validation->set_rules('nama_user', 'Nama Instruktur', 'required');
    $this->form_validation->set_rules('email_user', 'Email Instruktur', 'required|is_unique[user.email_user]');
    $this->form_validation->set_rules('username', 'Username Instruktur', 'required|is_unique[user.username]');
    $this->form_validation->set_rules('password', 'Password', 'required');
    $this->form_validation->set_rules('jk_user', 'Jenis Kelamin', 'required');
    $this->form_validation->set_rules('biodata', 'Biodata', 'required');

    if ($this->form_validation->run() == false) {
      $return = $error;
      $code = 422;
      $return['form'] = $this->form_validation->error_array();
      $return['success'] = false;
      $return['message'] = "Data Tidak Valid";

      if ($data['gambar_user'] != "") {
        unlink('./upload/instruktur/' . $data['gambar_user']);
      }

      if (isset($error['image']) && $error['image'] != "") {
        $return['form']['gambar_user'] = $error['image'];
      }
    } elseif (isset($error['image']) && $error['image'] != "") {
      $return = $error;
      $code = 422;
      $return['form'] = $this->form_validation->error_array();
      $return['form']['gambar_user'] = $error['image'];
      $return['success'] = false;
      $return['message'] = "Data Tidak Valid";
    } else {
      $simpan = $this->BackInstrukturModel->saveData($data);
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

  public function detail($id)
  {
    $dataInstruktur = $this->BackInstrukturModel->getById($id);
    $dataMapelAmpuInstruktur = $this->BackInstrukturModel->getAllMapelByInstruktur($id);

    if ($dataInstruktur['total'] >= 1) {
      $code = 200;
      $return['message'] = "Data Di temukan";
      $return['success'] = false;
      $return['data'] = $dataInstruktur['data'][0];
      $return['data']["mapel_ampu"] = $dataMapelAmpuInstruktur;
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

  public function update()
  {
    $id = $_POST['id_instruktur'] ?? 0;
    $dataInstruktur = $this->BackInstrukturModel->getById($id);

    if ($dataInstruktur['total'] >= 1) {
      $this->load->library(['form_validation', 'upload']);

      $error = [];
      $data = [
        "nama_user"  => $_POST['nama_user'],
        "email_user" => $_POST['email_user'],
        "username"   => $_POST['username'],
        "jk_user"    => $_POST['jk_user'],
        "level_user" => "instruktur",
        "biodata"    => $_POST['biodata'],
      ];

      if (isset($_POST["password"]) and $_POST["password"] != "") {
        $data["password"] = crypt(crypt($this->input->post('password'), garem), garem);
      }

      $checkEmail = $this->BasicModel->getArrayData("user", "email_user = '{$_POST['email_user']}' AND id_user <> {$id}");

      if (!empty($checkEmail)) {
        $error['email_user'] = "Email Instruktur Sudah Terpakai";
        $return['form']['email_user'] = "Email Instruktur Sudah Terpakai";
      }

      $checkUsername = $this->BasicModel->getArrayData("user", "username = '{$_POST['username']}' AND id_user <> {$id}");

      if (!empty($checkUsername)) {
        $error['username'] = "Username Instruktur Sudah Terpakai";
        $return['form']['username'] = "Username Instruktur Sudah Terpakai";
      }


      if (!isset($_FILES['gambar_user']['name']) || $_FILES['gambar_user']['name'] == "") {
        $nama_file = $dataInstruktur['data'][0]['gambar_user'];
      } else {
        $config['upload_path'] = './upload/instruktur';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['encrypt_name'] = true;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('gambar_user')) {
          $error['image'] = $this->upload->display_errors();
          $nama_file = $dataInstruktur['data'][0]['gambar_user'];
        } else {
          if ($dataInstruktur['data'][0]['gambar_user'] != "") {
            unlink('./upload/instruktur/' . $dataInstruktur['data'][0]['gambar_user']);
          }
          $nama_file = $this->upload->data('file_name');
        }
      }
      $data['gambar_user'] = $nama_file;

      if (!isset($_FILES['gambar_tanda_tangan']['name']) || $_FILES['gambar_tanda_tangan']['name'] == "") {
        $nama_file = $dataInstruktur['data'][0]['tanda_tangan'];
      } else {
        $config['upload_path'] = './upload/tanda_tangan';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['encrypt_name'] = true;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('gambar_tanda_tangan')) {
          $error['image'] = $this->upload->display_errors();
          $nama_file = $dataInstruktur['data'][0]['tanda_tangan'];
        } else {
          if ($dataInstruktur['data'][0]['tanda_tangan'] != "") {
            unlink('./upload/tanda_tangan/' . $dataInstruktur['data'][0]['tanda_tangan']);
          }
          $nama_file = $this->upload->data('file_name');
        }
      }
      $data['tanda_tangan'] = $nama_file;
      $this->form_validation->set_data($data);
      $this->form_validation->set_rules('nama_user', 'Nama Instruktur', 'required');
      $this->form_validation->set_rules('email_user', 'Email Instruktur', 'required');
      $this->form_validation->set_rules('username', 'Username Instruktur', 'required');
      $this->form_validation->set_rules('jk_user', 'Jenis Kelamin', 'required');
      $this->form_validation->set_rules('biodata', 'Biodata', 'required');

      if ($this->form_validation->run() == false) {
        $return = $error;
        $code = 422;
        $return['form'] = $this->form_validation->error_array();
        $return['success'] = false;
        $return['message'] = "Data Tidak Valid";
        if ($data['gambar_user'] != "" and $data['gambar_user'] != "default.png") {
          unlink('./upload/instruktur/' . $data['gambar_user']);
        }

        if (isset($error['image']) && $error['image'] != "") {
          $return['form']['gambar_user'] = $error['image'];
        }
      } elseif (isset($error['image']) && $error['image'] != "") {
        $return = $error;
        $code = 422;
        $return['form'] = $this->form_validation->error_array();
        $return['form']['gambar_user'] = $error['image'];
        $return['success'] = false;
        $return['message'] = "Data Tidak Valid";
      } elseif (!empty($checkUsername) or !empty($checkEmail)) {
        $return = $error;
        $code = 422;
        $return['form'] = $this->form_validation->error_array();
        if (isset($error['image']) && $error['image'] != "") {
          $return['form']['gambar_user'] = $error['image'];
        }
        if (isset($error['email_user']) && $error['email_user'] != "") {
          $return['form']['email_user'] = $error['email_user'];
        }
        if (isset($error['username']) && $error['username'] != "") {
          $return['form']['username'] = $error['username'];
        }
        $return['success'] = false;
        $return['message'] = "Data Tidak Valid";
      } else {
        $simpan = $this->BackInstrukturModel->updateData($id, $data);

        if (isset($_POST["mapel_id"]) and $_POST["mapel_id"] != "") {
          $mapelId = explode(",", $_POST["mapel_id"]);

          $simpan = $simpan && $this->BackInstrukturModel->deleteMapelByInstruktur($id);

          foreach ($mapelId as $keyMapel => $valueMapel) {
            $dataInsertMapel = [
              "user_id"  => $id,
              "mapel_id" => $valueMapel
            ];

            $simpan = $simpan && $this->BackInstrukturModel->insertMapelByInstruktur($dataInsertMapel);
          }
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
    $dataInstruktur = $this->BackInstrukturModel->getById($id);

    if ($dataInstruktur['total'] >= 1) {
      $simpan = $this->BackInstrukturModel->deleteData($id);
      $hapusInstrukturMapel = $this->BackInstrukturModel->deleteIntrukturMapel($id);

      if ($simpan && $hapusInstrukturMapel) {
        if ($dataInstruktur['data'][0]['gambar_user'] != "default.png" && $dataInstruktur['data'][0]['gambar_user'] != "") {
          unlink('./upload/instruktur/' . $dataInstruktur['data'][0]['gambar_user']);
        }
        if ($dataInstruktur['data'][0]['tanda_tangan'] != "default.png" && $dataInstruktur['data'][0]['tanda_tangan'] != "") {
          unlink('./upload/tanda_tangan/' . $dataInstruktur['data'][0]['tanda_tangan']);
        }
        $code = 200;
        $return['message'] = "Berhasil Menghapus " . $dataInstruktur['data'][0]['nama_user'];
        $return['success'] = true;
      } else {
        $code = 500;
        $return['message'] = "Gagal Menyimpan " . $dataInstruktur['data'][0]['nama_user'];
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
