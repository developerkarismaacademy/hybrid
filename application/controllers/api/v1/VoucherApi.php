<?php
defined('BASEPATH') or exit('No direct script access allowed');


class VoucherApi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('back/VoucherModel', 'BackVoucherModel', true);
		$this->load->model('back/MapelModel', 'BackMapelModel', true);
	}

	public function jsondata()
	{
		$limit = $_GET['limit'] ?? 10;
		$page = $_GET['page'] ?? 1;
		$search = $_GET['search'] ?? "";
		$order = $_GET['order'] ?? "kode_voucher|ASC";

		$start = ($page > 1) ? ($page * $limit) - $limit : 0;
		$order_option = explode("|", $order)[1];
		$order = explode("|", $order)[0];

		$dataVoucher = $this->BackVoucherModel->getPaging($limit, $start, $search, $order, $order_option);
		$dataVoucher = obj_to_arr($dataVoucher);

		$params = "";
		if (isset($_GET) && count($_GET) > 0) {
			foreach ($_GET as $name => $value) {
				if ($name != "page") {
					$params .= "&{$name}={$value}";
				}
			}
		}

		$first_page = $dataVoucher['total_page'] == 1 || $page == 1 ? "#" : base_url("api/v1/VoucherApi/jsondata") . "?page=1" . $params;
		$last_page = $dataVoucher['total_page'] == 1 || $page == $dataVoucher['total_page'] ? "#" : base_url("api/v1/VoucherApi/jsondata") . "?page={$dataVoucher['total_page']}" . $params;

		if (($page + 1) <= $dataVoucher['total_page']) {
			$next_page = base_url("api/v1/VoucherApi/jsondata") . "?page=" . ($page + 1) . $params;
		} else {
			$next_page = "#";
		}

		if (($page - 1) >= 1) {
			$prev_page = base_url("api/v1/VoucherApi/jsondata") . "?page=" . ($page - 1) . $params;
		} else {
			$prev_page = "#";
		}

		$dataVoucher['current_page'] = $page;
		$dataVoucher['start'] = $start;
		$dataVoucher['end'] = $start + count($dataVoucher['data']);
		$dataVoucher['url_first_page'] = $first_page;
		$dataVoucher['url_next_page'] = $next_page;
		$dataVoucher['url_prev_page'] = $prev_page;
		$dataVoucher['url_last_page'] = $last_page;

		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($dataVoucher));
	}

	public function getAll()
	{
		$dataVoucher = $this->BackVoucherModel->getAll();

		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($dataVoucher));
	}

	public function detail($id)
	{
		$dataVoucher = $this->BackVoucherModel->getById($id);

		if ($dataVoucher['total'] >= 1) {
			$code = 200;
			$return['message'] = "Data Di temukan";
			$return['success'] = false;
			$return['data'] = $dataVoucher['data'][0];
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
			"kode_voucher" => $_POST['kode_voucher'],
			"jenis_voucher" => $_POST['jenis_voucher'],
			"jenis_item" => $_POST['jenis_item'],
			"jenis_pembelian" => $_POST['jenis_pembelian'],
			"jenis_potongan" => $_POST['jenis_potongan'],
			"jumlah_potongan" => $_POST['jumlah_potongan'],
			"jenis_batas" => $_POST['jenis_batas'],
			"batas_kuota" => $_POST['batas_kuota'],
			"batas_waktu" => $_POST['batas_waktu'],
			"minimal_transaksi" => $_POST['minimal_transaksi'],
			"item_id" => $_POST['item_id'],
			"kategori_id" => $_POST['kategori_id'],
			"deskripsi_voucher" => $_POST['deskripsi_voucher'],
			"minimal_harga_item" => $_POST['minimal_harga_item'],
			"meta_link_voucher" => $this->UniversalModel->getMetaLink("voucher", $_POST['kode_voucher']),
		];

		$error = [];

		if (!isset($_FILES['gambar_voucher']['name']) || $_FILES['gambar_voucher']['name'] == "") {
			$nama_file = "";
		} else {
			$config['upload_path'] = './upload/voucher';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['encrypt_name'] = true;
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('gambar_voucher')) {
				$error['image'] = $this->upload->display_errors();
				$nama_file = "";
			} else {
				$nama_file = $this->upload->data('file_name');
			}
		}

		$data['gambar_voucher'] = $nama_file;

		$this->form_validation->set_data($data);

		$this->form_validation->set_rules('kode_voucher', 'Kode Voucher', 'required|max_length[50]|is_unique[voucher.kode_voucher]');
		$this->form_validation->set_rules('jenis_voucher', 'Jenis Voucher', 'required');
		$this->form_validation->set_rules('jenis_item', 'Jenis Item', 'required');
		$this->form_validation->set_rules('jenis_pembelian', 'Jenis Pembelian', 'required');
		$this->form_validation->set_rules('jenis_potongan', 'Jenis Potongan', 'required');
		$this->form_validation->set_rules('jumlah_potongan', 'jumlah Potongan', 'required');
		$this->form_validation->set_rules('jenis_batas', 'Jenis Batas', 'required');
		$this->form_validation->set_rules('batas_waktu', 'Batas @aktu', 'required');
		$this->form_validation->set_rules('batas_kuota', 'Batas Kuota', 'required');
		$this->form_validation->set_rules('minimal_transaksi', 'Minimal Transaksi', 'required');
		$this->form_validation->set_rules('item_id', 'Item', 'required');
		$this->form_validation->set_rules('deskripsi_voucher', 'Deskripsi Voucher', 'required');
		$this->form_validation->set_rules('kategori_id', 'Kategori', 'required');
		$this->form_validation->set_rules('minimal_harga_item', 'Minimal Harga', 'required');

		if ($this->form_validation->run() == false) {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";

			if ($data['gambar_voucher'] != "") {
				unlink('./upload/voucher/' . $data['gambar_voucher']);
			}

			if (isset($error['image']) && $error['image'] != "") {
				$return['form']['gambar_voucher'] = $error['image'];
			}
		} elseif (isset($error['image']) && $error['image'] != "") {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['form']['gambar_voucher'] = $error['image'];
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";
		} else {
			$simpan = $this->BackVoucherModel->saveData($data);
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
		$id = $_POST['id_voucher'] ?? 0;
		$dataVoucher = $this->BackVoucherModel->getById($id);

		if ($dataVoucher['total'] >= 1) {
			$this->load->library(['form_validation', 'upload']);

			$data = [
				"kode_voucher" => $_POST['kode_voucher'],
				"jenis_voucher" => $_POST['jenis_voucher'],
				"jenis_item" => $_POST['jenis_item'],
				"jenis_pembelian" => $_POST['jenis_pembelian'],
				"jenis_potongan" => $_POST['jenis_potongan'],
				"jumlah_potongan" => $_POST['jumlah_potongan'],
				"jenis_batas" => $_POST['jenis_batas'],
				"batas_kuota" => $_POST['batas_kuota'],
				"batas_waktu" => $_POST['batas_waktu'],
				"minimal_transaksi" => $_POST['minimal_transaksi'],
				"item_id" => $_POST['item_id'],
				"kategori_id" => $_POST['kategori_id'],
				"deskripsi_voucher" => $_POST['deskripsi_voucher'],
				"minimal_harga_item" => $_POST['minimal_harga_item'],
				"meta_link_voucher" => ($_POST['kode_voucher'] != $dataVoucher['data'][0]['kode_voucher'] ? $this->UniversalModel->getMetaLink("voucher", $_POST['kode_voucher']) : $dataVoucher['data'][0]['meta_link_voucher'])
			];

			$error = [];

			if (!isset($_FILES['gambar_voucher']['name']) || $_FILES['gambar_voucher']['name'] == "") {
				$nama_file = $dataVoucher['data'][0]['gambar_voucher'];
			} else {
				$config['upload_path'] = './upload/voucher';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['encrypt_name'] = true;
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('gambar_voucher')) {
					$error['image'] = $this->upload->display_errors();
					$nama_file = $dataVoucher['data'][0]['gambar_voucher'];
				} else {
					if ($dataVoucher['data'][0]['gambar_voucher'] != "") {
						unlink('./upload/voucher/' . $dataVoucher['data'][0]['gambar_voucher']);
					}
					$nama_file = $this->upload->data('file_name');
				}
			}

			$data['gambar_voucher'] = $nama_file;

			$this->form_validation->set_data($data);

			$this->form_validation->set_rules('kode_voucher', 'Kode Voucher', 'required|max_length[50]');
			$this->form_validation->set_rules('jenis_voucher', 'Jenis Voucher', 'required');
			$this->form_validation->set_rules('jenis_item', 'Jenis Item', 'required');
			$this->form_validation->set_rules('jenis_pembelian', 'Jenis Pembelian', 'required');
			$this->form_validation->set_rules('jenis_potongan', 'Jenis Potongan', 'required');
			$this->form_validation->set_rules('jumlah_potongan', 'jumlah Potongan', 'required');
			$this->form_validation->set_rules('jenis_batas', 'Jenis Batas', 'required');
			$this->form_validation->set_rules('batas_waktu', 'Batas @aktu', 'required');
			$this->form_validation->set_rules('batas_kuota', 'Batas Kuota', 'required');
			$this->form_validation->set_rules('minimal_transaksi', 'Minimal Transaksi', 'required');
			$this->form_validation->set_rules('item_id', 'Item', 'required');
			$this->form_validation->set_rules('deskripsi_voucher', 'Deskripsi Voucher', 'required');
			$this->form_validation->set_rules('kategori_id', 'Kategori', 'required');
			$this->form_validation->set_rules('minimal_harga_item', 'Minimal Harga', 'required');

			$checkVoucher = $this->UniversalModel->getAllData("voucher", "kode_voucher = '{$data['kode_voucher']}' AND id_voucher <> {$id}");

			if ($this->form_validation->run() == false) {
				$return = $error;
				$code = 422;
				$return['form'] = $this->form_validation->error_array();
				$return['success'] = false;
				$return['message'] = "Data Tidak Valid";
				if ($data['gambar_voucher'] != "") {
					unlink('./upload/voucher/' . $data['gambar_voucher']);
				}

				if (isset($error['image']) && $error['image'] != "") {
					$return['form']['gambar_voucher'] = $error['image'];
				}
			} elseif (isset($error['image']) && $error['image'] != "") {
				$return = $error;
				$code = 422;
				$return['form'] = $this->form_validation->error_array();
				$return['form']['gambar_voucher'] = $error['image'];
				$return['success'] = false;
				$return['message'] = "Data Tidak Valid";
			} elseif ($checkVoucher["total"] > 0) {
				$return = $error;
				$code = 422;
				$return['form']["kode_voucher"] = "Kode Voucher Sudah Terpakai.";
				$return['success'] = false;
				$return['message'] = "Data Tidak Valid";
			} else {
				$simpan = $this->BackVoucherModel->updateData($id, $data);
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
		$dataVoucher = $this->BackVoucherModel->getById($id);

		if ($dataVoucher['total'] >= 1) {
			$simpan = $this->BackVoucherModel->deleteData($id);
			if ($simpan) {

				if ($dataVoucher['data'][0]['gambar_voucher'] != "") {
					unlink('./upload/voucher/' . $dataVoucher['data'][0]['gambar_voucher']);
				}

				$code = 200;
				$return['message'] = "Berhasil Menghapus " . $dataVoucher['data'][0]['kode_voucher'];
				$return['success'] = true;
			} else {
				$code = 500;
				$return['message'] = "Gagal Menyimpan " . $dataVoucher['data'][0]['kode_voucher'];
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


	public function generateVoucher()
	{

	}

}
