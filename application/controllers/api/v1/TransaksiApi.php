<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Karisma
 * Date: 23/09/2019
 * Time: 11:02
 */
class TransaksiApi extends CI_Controller
{

	/**
	 * TransaksiApi constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('back/TransaksiModel', 'BackTransaksiModel', true);
	}

	public function jsondata()
	{
		$limit = $_GET['limit'] ?? 10;
		$page = $_GET['page'] ?? 1;
		$search = $_GET['search'] ?? "";
		$order = $_GET['order'] ?? "created_at|DESC";
		$status = $_GET['status'] ?? -1;

		$start = ($page > 1) ? ($page * $limit) - $limit : 0;
		$order_option = explode("|", $order)[1];
		$order = explode("|", $order)[0];


		$dataTransaksi = $this->BackTransaksiModel->getPaging($limit, $start, $search, $order, $order_option, $status);
		$dataTransaksi = obj_to_arr($dataTransaksi);

		$params = "";

		if (isset($_GET) && count($_GET) > 0) {
			foreach ($_GET as $name => $value) {
				if ($name != "page") {
					$params .= "&{$name}={$value}";
				}
			}
		}

		$first_page = $dataTransaksi['total_page'] == 1 || $page == 1 ? "#" : base_url("api/v1/TransaksiApi/jsondata") . "?page=1" . $params;
		$last_page = $dataTransaksi['total_page'] == 1 || $page == $dataTransaksi['total_page'] ? "#" : base_url("api/v1/TransaksiApi/jsondata") . "?page={$dataTransaksi['total_page']}" . $params;

		if (($page + 1) <= $dataTransaksi['total_page']) {
			$next_page = base_url("api/v1/TransaksiApi/jsondata") . "?page=" . ($page + 1) . $params;
		} else {
			$next_page = "#";
		}

		if (($page - 1) >= 1) {
			$prev_page = base_url("api/v1/TransaksiApi/jsondata") . "?page=" . ($page - 1) . $params;
		} else {
			$prev_page = "#";
		}

		$dataTransaksi['current_page'] = $page;
		$dataTransaksi['start'] = $start;
		$dataTransaksi['end'] = $start + count($dataTransaksi['data']);
		$dataTransaksi['url_first_page'] = $first_page;
		$dataTransaksi['url_next_page'] = $next_page;
		$dataTransaksi['url_prev_page'] = $prev_page;
		$dataTransaksi['url_last_page'] = $last_page;

		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($dataTransaksi));
	}

	public function detail($id, $idUser)
	{
		$dataTransaksi = $this->BackTransaksiModel->getById($id);

		if ($dataTransaksi['total'] >= 1) {

			$dataDetailTransaksi = $this->BackTransaksiModel->getDetailById($id, $idUser);

			if ($dataDetailTransaksi['total'] >= 1) {
				$code = 200;
				$return['message'] = "Data Di temukan";
				$return['success'] = false;
				$return['data'] = $dataTransaksi['data'][0];
				$return['detail'] = $dataDetailTransaksi;
				$return['data']["tanggal"] = formatTanggal2($return["data"]["created_at"]);
			} else {
				$code = 404;
				$return['message'] = "Data Tidak Di Temukan";
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

	public function simpan()
	{
		$statusPost = $_POST['status'];

		//STILL DUMMY
		$data['transaksi'] = [
			"user_id"        => $_POST['siswa_id'],
			"bank_user"      => $_POST['bank_user'],
			"no_rek_user"    => $_POST['no_rek_user'],
			"atas_nama"      => $_POST['atas_nama'],
			"tanggal"        => date("Y-m-d H:i:s"),
			"tanggal_bayar"  => date("Y-m-d H:i:s"),
			"bukti_transfer" => $_POST['bukti_transfer'], //dropdown value default, not uploading

			//WHAT IF BATCH BELI?
			"jumlah_bayar"   => $_POST['jumlah_bayar'],
			"jumlah"         => 1,
			"total_potongan" => null,
			"kode_voucher"   => null,
			"total_beli"     => null,

			//STATUS VALUE ALWAYS 2 (Accepted)
			"status"         => $statusPost,
		];


		//STILL DUMMY
		//WHAT IF BATCH BELI?
		$data['detail_transaksi'] = [
			"mapel_id"    => $_POST['mapel_id'],
			"user_id"     => $_POST['siswa_id'],
			"level_mapel" => $_POST['level_mapel'],
		];

		//STILL DUMMY
		//WHAT IF BATCH BELI?
		$data['user_mapel'] = [
			"mapel_id"    => $_POST['mapel_id'],
			"user_id"     => $_POST['siswa_id'],
			"level_mapel" => $_POST['level_mapel'],
		];

		$simpan = $this->BackTransaksiModel->simpanOne($data);

		if ($simpan) {
			$code = 200;
			$return['message'] = "Data Berhasil Disimpan";
			$return['success'] = true;
		} else {
			$code = 400;
			$return['message'] = "Data Gagal Disimpan";
			$return['success'] = false;
			$return['data'] = "Error Data";
		}

		return $this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output(json_encode($return));


	}

	public function confirm($id, $idUser)
	{
		$dataTransaksi = $this->BackTransaksiModel->getById($id);

		if ($dataTransaksi['total'] >= 1) {

			$dataDetailTransaksi = $this->BackTransaksiModel->getDetailById($id, $idUser);

			if ($dataDetailTransaksi['total'] >= 1) {
				$dataUpdateTransaksi = [
					"status" => 2,
				];

				$whereUpdateTransaksi = "id_transaksi = {$id}";

				$updateTransaksi = $this->BasicModel->updateData("transaksi", $dataUpdateTransaksi, $whereUpdateTransaksi);

				$insertDetailTransaksiStatus = true;

				if ($updateTransaksi) {
					foreach ($dataDetailTransaksi["data"] as $keyDetailTransaksi => $valueDetailTransaksi) {
						$dataInsertDetailTransaksi = [
							"mapel_id"            => $valueDetailTransaksi["mapel_id"],
							"user_id"             => $valueDetailTransaksi["user_id"],
							"transaksi_id"        => $id,
							"detail_transaksi_id" => 0,
							"level_mapel"         => $valueDetailTransaksi["level_mapel"],
							"created_at"          => $valueDetailTransaksi["created_at"],
						];

						$insertDetailTransaksi = $this->BasicModel->addData("user_mapel", $dataInsertDetailTransaksi);
						$insertDetailTransaksiStatus = $insertDetailTransaksiStatus && $insertDetailTransaksi;
					}

					if ($insertDetailTransaksiStatus) {
						$code = 200;
						$return['message'] = "Berhasil Menyimpan Data";
						$return['success'] = true;
					} else {
						$code = 500;
						$return['message'] = "Gagal Merubah Data";
						$return['success'] = false;
					}
				} else {
					$code = 500;
					$return['message'] = "Gagal Merubah Data";
					$return['success'] = false;
				}

			} else {
				$code = 404;
				$return['message'] = "Data Tidak Di Temukan";
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
