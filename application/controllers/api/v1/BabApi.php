<?php
defined('BASEPATH') or exit('No direct script access allowed');


class BabApi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('back/BabModel', 'BackBabModel', true);
	}

	public function jsondata()
	{
		$limit = $_GET['limit'] ?? 10;
		$page = $_GET['page'] ?? 1;
		$search = $_GET['search'] ?? "";
		$order = $_GET['order'] ?? "urutan_bab|ASC";
		$idMapel = $_GET['idMapel'] ?? 0;

		$start = ($page > 1) ? ($page * $limit) - $limit : 0;
		$order_option = explode("|", $order)[1];
		$order = explode("|", $order)[0];

		$dataBab = $this->BackBabModel->getPaging($limit, $start, $search, $order, $order_option, $idMapel);
		$dataBab = obj_to_arr($dataBab);

		$params = "";
		if (isset($_GET) && count($_GET) > 0) {
			foreach ($_GET as $name => $value) {
				if ($name != "page") {
					$params .= "&{$name}={$value}";
				}
			}
		}

		$first_page = $dataBab['total_page'] == 1 || $page == 1 ? "#" : base_url("api/v1/BabApi/jsondata") . "?page=1" . $params;
		$last_page = $dataBab['total_page'] == 1 || $page == $dataBab['total_page'] ? "#" : base_url("api/v1/BabApi/jsondata") . "?page={$dataBab['total_page']}" . $params;

		if (($page + 1) <= $dataBab['total_page']) {
			$next_page = base_url("api/v1/BabApi/jsondata") . "?page=" . ($page + 1) . $params;
		} else {
			$next_page = "#";
		}

		if (($page - 1) >= 1) {
			$prev_page = base_url("api/v1/BabApi/jsondata") . "?page=" . ($page - 1) . $params;
		} else {
			$prev_page = "#";
		}

		$dataBab['current_page'] = $page;
		$dataBab['start'] = $start;
		$dataBab['end'] = $start + count($dataBab['data']);
		$dataBab['url_first_page'] = $first_page;
		$dataBab['url_next_page'] = $next_page;
		$dataBab['url_prev_page'] = $prev_page;
		$dataBab['url_last_page'] = $last_page;

		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($dataBab));
	}


	public function detail($id)
	{
		$dataBab = $this->BackBabModel->getById($id);

		if ($dataBab['total'] >= 1) {
			$code = 200;
			$return['message'] = "Data Di temukan";
			$return['success'] = false;
			$return['data'] = $dataBab['data'][0];
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
		$urutanTerakhir = $this->BackBabModel->getLastUrutanByMapel($_POST['mapel_id']);
		$data = [
			"nama_bab"       => $_POST['nama_bab'],
			"deskripsi_bab"  => $_POST['deskripsi_bab'],
			"pretest_status" => isset($_POST['pretest_status']) ? $_POST['pretest_status'] : 0,
			"posttest_status" => isset($_POST['posttest_status']) ? $_POST['posttest_status'] : 0,
			"mapel_id"       => $_POST['mapel_id'],
			"meta_link_bab"  => $this->BackBabModel->getMetaLink($_POST['nama_bab']),
			"urutan_bab"     => ($urutanTerakhir + 1),
		];

		$error = [];

		if (!isset($_FILES['gambar_bab']['name']) || $_FILES['gambar_bab']['name'] == "") {
			$nama_file = "";
		} else {
			$config['upload_path'] = './upload/bab';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['encrypt_name'] = true;
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('gambar_bab')) {
				$error['image'] = $this->upload->display_errors();
				$nama_file = "";
			} else {
				$nama_file = $this->upload->data('file_name');
			}
		}
		$data['gambar_bab'] = $nama_file;


		$this->form_validation->set_data($data);

		$this->form_validation->set_rules('nama_bab', 'Nama Bab', 'required');
		$this->form_validation->set_rules('mapel_id', 'Mata Pelajaran', 'required');

		if ($this->form_validation->run() == false) {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";

			if ($data['gambar_bab'] != "") {
				unlink('./upload/bab/' . $data['gambar_bab']);
			}

			if (isset($error['image']) && $error['image'] != "") {
				$return['form']['gambar_bab'] = $error['image'];
			}
		} elseif (isset($error['image']) && $error['image'] != "") {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['form']['gambar_bab'] = $error['image'];
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";
		} else {
			$simpan = $this->BackBabModel->saveData($data);
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
		$id = $_POST['id_bab'] ?? 0;
		$dataBab = $this->BackBabModel->getById($id);

		if ($dataBab['total'] >= 1) {
			$this->load->library(['form_validation', 'upload']);

			$data = [
				"nama_bab"       => $_POST['nama_bab'],
				"deskripsi_bab"  => $_POST['deskripsi_bab'],
				"pretest_status" => isset($_POST['pretest_status']) ? $_POST['pretest_status'] : 0,
				"posttest_status" => isset($_POST['posttest_status']) ? $_POST['posttest_status'] : 0,
				"mapel_id"       => $_POST['mapel_id'],
				"meta_link_bab"  => ($_POST['nama_bab'] != $dataBab['data'][0]['nama_bab'] ? $this->BackBabModel->getMetaLink($_POST['nama_bab'], $id) : $dataBab['data'][0]['meta_link_bab']),
			];

			$error = [];

			if (!isset($_FILES['gambar_bab']['name']) || $_FILES['gambar_bab']['name'] == "") {
				$nama_file = $dataBab['data'][0]['gambar_bab'];
			} else {
				$config['upload_path'] = './upload/bab';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['encrypt_name'] = true;
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('gambar_bab')) {
					$error['image'] = $this->upload->display_errors();
					$nama_file = $dataBab['data'][0]['gambar_bab'];
				} else {
					if ($dataBab['data'][0]['gambar_bab'] != "") {
						unlink('./upload/bab/' . $dataBab['data'][0]['gambar_bab']);
					}
					$nama_file = $this->upload->data('file_name');
				}
			}
			$data['gambar_bab'] = $nama_file;


			$this->form_validation->set_data($data);

			$this->form_validation->set_rules('nama_bab', 'Nama Bab', 'required');
			$this->form_validation->set_rules('mapel_id', 'Mata Pelajaran', 'required');

			if ($this->form_validation->run() == false) {
				$return = $error;
				$code = 422;
				$return['form'] = $this->form_validation->error_array();
				$return['success'] = false;
				$return['message'] = "Data Tidak Valid";

				if ($data['gambar_bab'] != "") {
					unlink('./upload/bab/' . $data['gambar_bab']);
				}

				if (isset($error['image']) && $error['image'] != "") {
					$return['form']['gambar_bab'] = $error['image'];
				}
			} elseif (isset($error['image']) && $error['image'] != "") {
				$return = $error;
				$code = 422;
				$return['form'] = $this->form_validation->error_array();
				$return['form']['gambar_bab'] = $error['image'];
				$return['success'] = false;
				$return['message'] = "Data Tidak Valid";
			} else {
				$simpan = $this->BackBabModel->updateData($id, $data);
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
		$dataBab = $this->BackBabModel->getById($id);

		if ($dataBab['total'] >= 1) {
			$simpan = $this->BackBabModel->deleteData($id);
			if ($simpan) {
				if ($dataBab['data'][0]['gambar_bab'] != "") {
					unlink('./upload/bab/' . $dataBab['data'][0]['gambar_bab']);
				}
				$code = 200;
				$return['message'] = "Berhasil Menghapus " . $dataBab['data'][0]['nama_bab'];
				$return['success'] = true;
			} else {
				$code = 500;
				$return['message'] = "Gagal Menyimpan " . $dataBab['data'][0]['nama_bab'];
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

	public function getAllByMapel($idMapel = 0)
	{
		$data = $this->BackBabModel->getAllByMapel($idMapel);


		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function simpanUrutan()
	{
		$i = 1;
		$simpan = true;
		foreach ($_POST['data'] as $key => $value) {

			$data = [
				"urutan_bab" => $i,
			];

			$simpan = $simpan && $this->BackBabModel->updateData($value["id"], $data);

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
