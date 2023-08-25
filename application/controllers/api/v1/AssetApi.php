<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AssetApi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('back/AssetModel', 'BackAssetModel', true);
	}

	public function jsondata()
	{
		$limit = $_GET['limit'] ?? 10;
		$page = $_GET['page'] ?? 1;
		$search = $_GET['search'] ?? "";
		$order = $_GET['order'] ?? "link|ASC";
		$idMateri = $_GET['idMateri'] ?? 0;
		$start = ($page > 1) ? ($page * $limit) - $limit : 0;
		$order_option = explode("|", $order)[1];
		$order = explode("|", $order)[0];

		$dataMateri = $this->BackAssetModel->getPaging($limit, $start, $search, $order, $order_option, $idMateri);
		$dataMateri = obj_to_arr($dataMateri);

		$params = "";
		if (isset($_GET) && count($_GET) > 0) {
			foreach ($_GET as $name => $value) {
				if ($name != "page") {
					$params .= "&{$name}={$value}";
				}
			}
		}

		$first_page = $dataMateri['total_page'] == 1 || $page == 1 ? "#" : base_url("api/v1/AssetApi/jsondata") . "?page=1" . $params;
		$last_page = $dataMateri['total_page'] == 1 || $page == $dataMateri['total_page'] ? "#" : base_url("api/v1/AssetApi/jsondata") . "?page={$dataMateri['total_page']}" . $params;

		if (($page + 1) <= $dataMateri['total_page']) {
			$next_page = base_url("api/v1/AssetApi/jsondata") . "?page=" . ($page + 1) . $params;
		} else {
			$next_page = "#";
		}

		if (($page - 1) >= 1) {
			$prev_page = base_url("api/v1/AssetApi/jsondata") . "?page=" . ($page - 1) . $params;
		} else {
			$prev_page = "#";
		}

		$dataMateri['current_page'] = $page;
		$dataMateri['start'] = $start;
		$dataMateri['end'] = $start + count($dataMateri['data']);
		$dataMateri['url_first_page'] = $first_page;
		$dataMateri['url_next_page'] = $next_page;
		$dataMateri['url_prev_page'] = $prev_page;
		$dataMateri['url_last_page'] = $last_page;

		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($dataMateri));
	}


	public function simpan()
	{
		$this->load->library(['form_validation', 'upload']);

		$data = [
			"materi_id" => $_POST['materi_id'],
			"tipe"      => $_POST['tipe'],
			"link"      => $_POST['link'] ?? "",
			"nama"      => $_POST['nama'] ?? "",
		];

		$error = [];

		if ($data["tipe"] == "file") {

			if (!isset($_FILES['file']['name']) || $_FILES['file']['name'] == "") {
				$nama_file = "";
			} else {
				$config['upload_path'] = './upload/asset';
				$config['allowed_types'] = '*';
				$config['encrypt_name'] = true;
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('file')) {
					$error['file'] = $this->upload->display_errors();
					$nama_file = "";
				} else {
					$nama_file = $this->upload->data('file_name');
				}
			}

			$data['link'] = $nama_file;

		}

		$this->form_validation->set_data($data);

		$this->form_validation->set_rules('materi_id', 'materi_id', 'required');
		$this->form_validation->set_rules('tipe', 'tipe', 'required');

		if ($this->form_validation->run() == false) {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";
		} elseif (isset($error['file']) && $error['file'] != "") {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['form']['file'] = $error['file'];
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";
		} else {
			$simpan = $this->BackAssetModel->saveData($data);
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

	public function delete($id)
	{
		$id = $id ?? 0;
		$dataMateri = $this->BackAssetModel->getByIdAsset($id);

		if ($dataMateri['total'] >= 1) {
			$simpan = $this->BackAssetModel->deleteData($id);
			if ($simpan) {
				$code = 200;
				$return['message'] = "Berhasil Menghapus Asset ID" . $dataMateri['data'][0]['id_asset'];
				$return['success'] = true;
			} else {
				$code = 500;
				$return['message'] = "Gagal Menyimpan " . $dataMateri['data'][0]['id_asset'];
				$return['success'] = false; # code...
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

	public function detail($id)
	{
		$dataAsset = $this->BackAssetModel->getByIdAsset($id);

		if ($dataAsset['total'] >= 1) {
			$code = 200;
			$return['message'] = "Data Di temukan";
			$return['success'] = false;
			$return['data'] = $dataAsset['data'][0];
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
