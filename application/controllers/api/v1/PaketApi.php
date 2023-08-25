<?php
defined('BASEPATH') or exit('No direct script access allowed');


class PaketApi extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('back/PaketModel', 'BackPaketModel', true);
	}

	public function jsondata()
	{
		$limit = $_GET['limit'] ?? 10;
		$page = $_GET['page'] ?? 1;
		$search = $_GET['search'] ?? "";
		$paket = $_GET['paket'] ?? "nama_paket|ASC";

		$start = ($page > 1) ? ($page * $limit) - $limit : 0;
		$paket_option = explode("|", $paket)[1];
		$paket = explode("|", $paket)[0];

		$dataPaket = $this->BackPaketModel->getPaging($limit, $start, $search, $paket, $paket_option);
		$dataPaket = obj_to_arr($dataPaket);

		$params = "";
		if (isset($_GET) && count($_GET) > 0) {
			foreach ($_GET as $name => $value) {
				if ($name != "page") {
					$params .= "&{$name}={$value}";
				}
			}
		}

		$first_page = $dataPaket['total_page'] == 1 || $page == 1 ? "#" : base_url("api/v1/PaketApi/jsondata") . "?page=1" . $params;
		$last_page = $dataPaket['total_page'] == 1 || $page == $dataPaket['total_page'] ? "#" : base_url("api/v1/PaketApi/jsondata") . "?page={$dataPaket['total_page']}" . $params;

		if (($page + 1) <= $dataPaket['total_page']) {
			$next_page = base_url("api/v1/PaketApi/jsondata") . "?page=" . ($page + 1) . $params;
		} else {
			$next_page = "#";
		}

		if (($page - 1) >= 1) {
			$prev_page = base_url("api/v1/PaketApi/jsondata") . "?page=" . ($page - 1) . $params;
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
		$dataPaket = $this->BackPaketModel->getById($id);

		if ($dataPaket['total'] >= 1) {
			$code = 200;
			$return['message'] = "Data Di temukan";
			$return['success'] = false;
			$return['data'] = $dataPaket['data'][0];
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
			"nama_paket"        => $_POST['nama_paket'],
			"deskripsi"         => $_POST['deskripsi'],
			"deskripsi_singkat" => $_POST['deskripsi_singkat'],
			"harga_basic"       => $_POST['harga_basic'],
			"harga_gold"        => $_POST['harga_gold'],
			"color_paket"       => $_POST['color_paket'],
			"meta_link_paket"   => $this->UniversalModel->getMetaLink("paket", $_POST['nama_paket'])
		];

		$error = [];

		if (!isset($_FILES['banner_paket']['name']) || $_FILES['banner_paket']['name'] == "") {
			$nama_file = "";
		} else {
			$config['upload_path'] = './upload/baner-paket';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['encrypt_name'] = true;
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('banner_paket')) {
				$error['image'] = $this->upload->display_errors();
				$nama_file = "";
			} else {
				$nama_file = $this->upload->data('file_name');
			}
		}
		$data['banner_paket'] = $nama_file;


		$this->form_validation->set_data($data);

		$this->form_validation->set_rules('nama_paket', 'Nama Paket', 'required');
		$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
		$this->form_validation->set_rules('deskripsi_singkat', 'Deskripsi Singkat', 'required');
		$this->form_validation->set_rules('harga_basic', 'Harga Basic', 'required');
		$this->form_validation->set_rules('harga_gold', 'Harga Gold', 'required');
		$this->form_validation->set_rules('color_paket', 'Color Paket', 'required');


		if ($this->form_validation->run() == false) {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";

			if ($data['banner_paket'] != "") {
				unlink('./upload/baner-paket/' . $data['banner_paket']);
			}

			if (isset($error['image']) && $error['image'] != "") {
				$return['form']['banner_paket'] = $error['image'];
			}
		} elseif (isset($error['image']) && $error['image'] != "") {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['form']['banner_paket'] = $error['image'];
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";
		} else {
			$simpan = $this->BackPaketModel->saveData($data);
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
		$dataPaket = $this->BackPaketModel->getById($id);
		if ($dataPaket['total'] >= 1) {
			$simpan = $this->BackPaketModel->deleteData($id);
			if ($simpan) {
				$code = 200;
				$return['message'] = "Berhasil Menghapus " . $dataPaket['data'][0]['nama_paket'];
				$return['success'] = true;
			} else {
				$code = 500;
				$return['message'] = "Gagal Menyimpan " . $dataPaket['data'][0]['nama_paket'];
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

	// public function update()
	// {
	// 	$id = $_POST['id_paket'] ?? 0;
	// 	$dataPaket = $this->BackPaketModel->getById($id);

	// 	if ($dataPaket['total'] >= 1) {
	// 		$this->load->library(['form_validation', 'upload']);

	// 		$data = [
	// 			"nama_paket" => $_POST['nama_paket'],
	// 			"deskripsi" => $_POST['deskripsi'],
	// 			"deskripsi_singkat" => $_POST['deskripsi_singkat'],
	// 			"harga_basic" => $_POST['harga_basic'],
	// 			"harga_gold" => $_POST['harga_gold'],
	// 			"color_paket" => $_POST['color_paket'],
	// 			"meta_link_paket" => ($_POST['nama_paket'] != $dataPaket['data'][0]['nama_paket'] ? $this->UniversalModel->getMetaLink("paket", $_POST['nama_paket']) : $dataPaket['data'][0]['meta_link_paket']),
	// 		];

	// 		$error = [];
	// 		$this->form_validation->set_data($data);
	// 		$this->form_validation->set_rules('nama_paket','Nama Paket', 'required');
	// 		$this->form_validation->set_rules('deskripsi','Deskripsi', 'required');
	// 		$this->form_validation->set_rules('deskripsi_singkat','Deskripsi Singkat', 'required');
	// 		$this->form_validation->set_rules('harga_basic', 'Harga Basic', 'required');
	// 		$this->form_validation->set_rules('harga_gold', 'Harga Gold', 'required');
	// 		$this->form_validation->set_rules('color_paket', 'Color Paket', 'required');


	// 		if ($this->form_validation->run() == false) {
	// 			$return = $error;
	// 			$code = 422;
	// 			$return['form'] = $this->form_validation->error_array();
	// 			$return['success'] = false;
	// 			$return['message'] = "Data Tidak Valid";
	// 		} else {
	// 			$simpan = $this->BackPaketModel->updateData($id, $data);
	// 			if ($simpan) {
	// 				$code = 200;
	// 				$return['message'] = "Berhasil Menyimpan Data";
	// 				$return['success'] = true;
	// 				$return['data'] = $data;
	// 			} else {
	// 				$code = 500;
	// 				$return['message'] = "Gagal Menyimpan Data";
	// 				$return['success'] = false;
	// 				$return['data'] = $data;
	// 			}
	// 		}
	// 	} else {
	// 		$code = 404;
	// 		$return['message'] = "Data Tidak Di Temukan";
	// 		$return['success'] = false;
	// 	}


	// 	return $this->output
	// 		->set_content_type('application/json')
	// 		->set_status_header($code)
	// 		->set_output(json_encode($return));
	// }

	public function update()
	{
		$id = $_POST['id_paket'] ?? 0;
		$dataPaket = $this->BackPaketModel->getById($id);

		if ($dataPaket['total'] >= 1) {
			$this->load->library(['form_validation', 'upload']);

			$data = [
				"nama_paket"        => $_POST['nama_paket'],
				"deskripsi"         => $_POST['deskripsi'],
				"deskripsi_singkat" => $_POST['deskripsi_singkat'],
				"harga_basic"       => $_POST['harga_basic'],
				"harga_gold"        => $_POST['harga_gold'],
				"color_paket"       => $_POST['color_paket'],
				"meta_link_paket"   => ($_POST['nama_paket'] != $dataPaket['data'][0]['nama_paket'] ? $this->UniversalModel->getMetaLink("paket", $_POST['nama_paket']) : $dataPaket['data'][0]['meta_link_paket'])

			];

			$error = [];

			if (!isset($_FILES['banner_paket']['name']) || $_FILES['banner_paket']['name'] == "") {
				$nama_file = $dataPaket['data'][0]['banner_paket'];
			} else {
				$config['upload_path'] = './upload/baner-paket';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['encrypt_name'] = true;
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('banner_paket')) {
					$error['image'] = $this->upload->display_errors();
					$nama_file = $dataPaket['data'][0]['banner_paket'];
				} else {
					if ($dataPaket['data'][0]['banner_paket'] != "") {
						unlink('./upload/baner-paket/' . $dataPaket['data'][0]['banner_paket']);
					}
					$nama_file = $this->upload->data('file_name');
				}
			}
			$data['banner_paket'] = $nama_file;

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules('nama_paket', 'Nama Paket', 'required');
			$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
			$this->form_validation->set_rules('deskripsi_singkat', 'Deskripsi Singkat', 'required');
			$this->form_validation->set_rules('harga_basic', 'Harga Basic', 'required');
			$this->form_validation->set_rules('harga_gold', 'Harga Gold', 'required');
			$this->form_validation->set_rules('color_paket', 'Color Paket', 'required');

			if ($this->form_validation->run() == false) {
				$return = $error;
				$code = 422;
				$return['form'] = $this->form_validation->error_array();
				$return['success'] = false;
				$return['message'] = "Data Tidak Valid";
				if ($data['banner_paket'] != "") {
					unlink('./upload/baner-paket/' . $data['banner_paket']);
				}

				if (isset($error['image']) && $error['image'] != "") {
					$return['form']['banner_paket'] = $error['image'];
				}
			} elseif (isset($error['image']) && $error['image'] != "") {
				$return = $error;
				$code = 422;
				$return['form'] = $this->form_validation->error_array();
				$return['form']['banner_paket'] = $error['image'];
				$return['success'] = false;
				$return['message'] = "Data Tidak Valid";
			} else {
				$simpan = $this->BackPaketModel->updateData($id, $data);
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
}

?>
