<?php
defined('BASEPATH') or exit('No direct script access allowed');


class XenditApi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('back/TransaksiModel', 'BackTransaksiModel', true);
	}

	public function saveInvoice()
	{
		if ($_SERVER["REQUEST_METHOD"] === "POST") {
			$data = file_get_contents("php://input");
			$data = json_decode($data, true);

			$dataString = json_encode($data, JSON_FORCE_OBJECT);


			$dataTransaksi = [
				"xendit_after_payment" => $dataString,
				"status"               => 0
			];

			if ($data["status"] == "PAID") {
				$dataTransaksi["status"] = 2;
			}

			$id = (int)filter_var($data["external_id"], FILTER_SANITIZE_NUMBER_INT);
			echo $id;
			$update = $this->UniversalModel->update("transaksi", "id_transaksi = {$id}", $dataTransaksi);

			$this->load->helper('file');

			if (!write_file('test.txt', $dataString)) {
				echo 'Unable to write the file';
			}


			if (!write_file('test_id.txt', $id)) {
				echo 'Unable to write the file';
			}

			$dataDetailTransaksi = $this->BackTransaksiModel->getDetailByIdTransaksi($id);
			if ($dataDetailTransaksi["total"] > 0) {
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
			}

		} else {
			print_r("Cannot " . $_SERVER["REQUEST_METHOD"] . " " . $_SERVER["SCRIPT_NAME"]);
		}

	}
}
