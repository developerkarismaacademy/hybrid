<?php

use Xendit\Xendit;

defined('BASEPATH') or exit('No direct script access allowed');


class Beli extends CI_Controller
{

	private $data;

	public function __construct()
	{
		parent::__construct();
		$this->data['page'] = "home";

		$this->load->model("front-v2/KelasModel", "FrontKelasModel");
		$this->load->model("front-v2/MapelModel", "FrontMapelModel");
		$this->load->model("front-v2/BabModel", "FrontBabModel");
		$this->load->model("front-v2/MateriModel", "FrontMateriModel");
		$this->load->model("front-v2/UlasanModel", "FrontUlasanModel");

		$this->FrontAuthModel->isLoggedIn();
	}

	public function beli($meta_link_mapel = "")
	{
		$mapel = $this->FrontMapelModel->getAllMapel("meta_link_mapel = '{$meta_link_mapel}'");

		if ($mapel["total"] > 0) {
			$voucher = $_GET["voucher"] ?? "";

			if ($voucher != "") {
				$dataVoucher = $this->UniversalModel->getOneData("voucher", "kode_voucher = '{$voucher}'");

				if ($dataVoucher["total"] > 0) {
					$this->data["voucher"] = $dataVoucher["data"];

					if (strtotime($this->data["voucher"]["batas_waktu"]) < strtotime('now')) {
						alert("warning", "Voucher Sudah Tidak Berlaku", "");
						unset($this->data["voucher"]);
					} else {
						alert("success", "Voucher Telah Di Aplikasikan", $this->data["voucher"]["deskripsi_voucher"]);
					}
				} else {
					alert("warning", "Voucher Tidak Di Temukan", "");
				}
			}

			$mapel = $mapel["data"][0];
			$this->data['title'] = "Beli {$mapel["nama_mapel"]}";
			$this->data['mapel'] = $mapel;
			$this->data['content'] = "keranjang";
		} else {
			$this->data["title"] = "Kursus Tidak Di Temukan";
			$this->data["content"] = "404";
		}

		$this->load->view("front-v2/main", $this->data);
	}

	public function simpanBeli($meta_link_mapel = "")
	{
		$mapel = $this->FrontMapelModel->getAllMapel("meta_link_mapel = '{$meta_link_mapel}'");

		if ($mapel["total"] > 0) {
			$voucher = $_GET["voucher"] ?? "";
			$mapel = $mapel["data"][0];

			$detailTransaksi = $this->UniversalModel->getOneData("detail_transaksi", "user_id = {$_SESSION['siswaData']['id_user']} AND mapel_id = {$mapel["id_mapel"]}");

			if ($detailTransaksi["total"] <= 0) {
				$dataVoucher = $this->UniversalModel->getOneData("voucher", "kode_voucher = '{$voucher}'");
				$potongan = 0;

				if ($dataVoucher["total"] > 0) {
					$dataVoucher = $dataVoucher["data"];
					if (isset($dataVoucher) && count($dataVoucher) > 0 && $mapel["harga_basic"] >= $dataVoucher["minimal_transaksi"]) {

						if ($dataVoucher["jenis_voucher"] == "item") {
							if ($dataVoucher["jenis_item"] == "semua") {
								if ($mapel["harga_basic"] > $dataVoucher["minimal_harga_item"]) {

									if ($voucher["jenis_potongan"] == "nominal") {
										$potongan = $dataVoucher["jumlah_potongan"];
									} else {
										$potongan = $mapel["harga_basic"] * $dataVoucher["jumlah_potongan"] / 100;
									}
								}
							} elseif ($dataVoucher["jenis_item"] == "kategori") {
								$kategori = explode(",", $dataVoucher["kategori_id"]);

								if (in_array($mapel["kelas_id"], $kategori)) {
									if ($mapel["harga_basic"] > $dataVoucher["minimal_harga_item"]) {

										if ($dataVoucher["jenis_potongan"] == "nominal") {
											$potongan = $dataVoucher["jumlah_potongan"];
										} else {
											$potongan = $mapel["harga_basic"] * $dataVoucher["jumlah_potongan"] / 100;
										}
									}
								}
							} elseif ($dataVoucher["jenis_item"] == "item_tertentu") {
								$kategori = explode(",", $dataVoucher["item_id"]);

								if (in_array($mapel["id_mapel"], $kategori)) {
									if ($mapel["harga_basic"] > $dataVoucher["minimal_harga_item"]) {

										if ($dataVoucher["jenis_potongan"] == "nominal") {
											$potongan = $dataVoucher["jumlah_potongan"];
										} else {
											$potongan = $mapel["harga_basic"] * $dataVoucher["jumlah_potongan"] / 100;
										}
									}


								}
							}
						}
					}
				}


				$dataTransaksi = [
					"status"         => 0,
					"user_id"        => $_SESSION['siswaData']['id_user'],
					"jumlah"         => 1,
					"jumlah_bayar"   => $mapel["harga_basic"] - $potongan,
					"bank_karisma"   => strtoupper($_GET["bank"]),
					"tanggal"        => date("Y-m-d H:i:s"),
					"total_beli"     => $mapel["harga_basic"],
					"total_potongan" => $potongan,
					"kode_voucher"   => $voucher,
				];


				$simpan = $this->UniversalModel->insert("transaksi", $dataTransaksi);

				Xendit::setApiKey(xnd_key);

				$params = [
					'external_id'          => "KARISMAACADEMY" . sprintf("%08d", $simpan["id"]),
					'payer_email'          => $_SESSION['siswaData']["email_user"],
					'description'          => 'Beli ' . $mapel["nama_mapel"] . ' Di Karisma Academy',
					'amount'               => $mapel["harga_basic"] - $potongan,
					'should_send_email'    => true,
					'success_redirect_url' => base_url("konfirmasi/{$simpan["id"]}"),
				];

				$createInvoice = \Xendit\Invoice::create($params);
				$createInvoiceString = json_encode($createInvoice, JSON_FORCE_OBJECT);

				$dataTransaksi = [
					"xendit_before_payment" => $createInvoiceString,
					"url_invoice"            => $createInvoice['invoice_url'] . "#" . strtoupper($_GET["bank"]),
				];

				$update = $this->UniversalModel->update("transaksi", "id_transaksi = {$simpan["id"]}", $dataTransaksi);

				$dataDetail = [
					"mapel_id"     => $mapel["id_mapel"],
					"user_id"      => $_SESSION['siswaData']['id_user'],
					"transaksi_id" => $simpan["id"],
					"level_mapel"  => 1,
					"created_at"   => date("Y-m-d H:i:s"),

				];

				$simpanDetail = $this->UniversalModel->insert("detail_transaksi", $dataDetail);

				echo "<script>document.location='" .base_url("konfirmasi/{$simpan["id"]}") . "'</script>";
			} else {

				$dataTransaksi = [
					"bank_karisma" => strtoupper($_GET["bank"]),
					"url_invoce"   => $detailTransaksi["data"]["url_invoce"] . "#" . strtoupper($_GET["bank"]),
				];

				$simpan = $this->UniversalModel->update("transaksi", "id_transaksi = {$detailTransaksi["data"]["transaksi_id"]}", $dataTransaksi);
				echo "<script>document.location='" . base_url("konfirmasi/{$detailTransaksi["data"]["transaksi_id"]}") . "'</script>";
			}

		} else {
			$this->data["title"] = "Kursus Tidak Di Temukan";
			$this->data["content"] = "404";
		}

	}

	public
	function konfirmasi($id = 0)
	{
		$pembelian = $this->UniversalModel->getOneData("transaksi", "id_transaksi = {$id}");

		if ($pembelian["total"] > 0) {

			$this->data["pembelian"] = $pembelian["data"];

			$detailTransaksi = $this->UniversalModel->getOneData("detail_transaksi", "transaksi_id = {$id}");
			if ($detailTransaksi["total"] > 0) {
				$this->data["detailTransaksi"] = $detailTransaksi["data"];

				$mapel = $this->FrontMapelModel->getAllMapel("id_mapel = '{$this->data["detailTransaksi"]["mapel_id"]}'");

				if ($mapel["total"] > 0) {

					$dataVoucher = $this->UniversalModel->getOneData("voucher", "kode_voucher = '{$this->data["pembelian"]["kode_voucher"]}'");
					if ($dataVoucher["total"] > 0) {
						$this->data["voucher"] = $dataVoucher["data"];
					}
					$mapel = $mapel["data"][0];
					$this->data['title'] = "Beli {$mapel["nama_mapel"]}";
					$this->data['mapel'] = $mapel;
					$this->data['content'] = "konfirmasi";
				} else {
					$this->data["title"] = "Kursus Tidak Di Temukan";
					$this->data["content"] = "404";
				}
			} else {
				$this->data["title"] = "Kursus Tidak Di Temukan";
				$this->data["content"] = "404";
			}
		} else {
			$this->data["title"] = "Kursus Tidak Di Temukan";
			$this->data["content"] = "404";
		}

//        return $this->output
//            ->set_content_type('application/json')
//            ->set_status_header(200)
//            ->set_output(json_encode($this->data));

		$this->load->view("front-v2/main", $this->data);
	}

	public
	function formKonfirmasi($id = 0, $id_mapel = 0)
	{
		$pembelian = $this->UniversalModel->getOneData("transaksi", "id_transaksi = {$id}");

		if ($pembelian["total"] > 0) {

			$this->data["pembelian"] = $pembelian["data"];

			$detailTransaksi = $this->UniversalModel->getOneData("detail_transaksi", "transaksi_id = {$id}");
			if ($detailTransaksi["total"] > 0) {
				$this->data["detailTransaksi"] = $detailTransaksi["data"];

				$mapel = $this->FrontMapelModel->getAllMapel("id_mapel = '{$id_mapel}'");

				if ($mapel["total"] > 0) {
					$dataVoucher = $this->UniversalModel->getOneData("voucher", "kode_voucher = '{$this->data["pembelian"]["kode_voucher"]}'");
					if ($dataVoucher["total"] > 0) {
						$this->data["voucher"] = $dataVoucher["data"];
					}
					$mapel = $mapel["data"][0];
					$this->data['title'] = "Beli {$mapel["nama_mapel"]}";
					$this->data['mapel'] = $mapel;
					$this->data['content'] = "form-konfirmasi";
				} else {
					$this->data["title"] = "Kursus Tidak Di Temukan";
					$this->data["content"] = "404";
				}
			} else {
				$this->data["title"] = "Kursus Tidak Di Temukan";
				$this->data["content"] = "404";
			}
		} else {
			$this->data["title"] = "Kursus Tidak Di Temukan";
			$this->data["content"] = "404";
		}

//		return $this->output
//			->set_content_type('application/json')
//			->set_status_header(200)
//			->set_output(json_encode($this->data));

		$this->load->view("front-v2/main", $this->data);
	}

	public function simpanKonfirmasi($id = 0, $id_mapel = 0)
	{
		$pembelian = $this->UniversalModel->getOneData("transaksi", "id_transaksi = {$id}");

		if ($pembelian["total"] > 0) {

			$this->data["pembelian"] = $pembelian["data"];

			$detailTransaksi = $this->UniversalModel->getOneData("detail_transaksi", "transaksi_id = {$id}");
			if ($detailTransaksi["total"] > 0) {
				$this->data["detailTransaksi"] = $detailTransaksi["data"];

				$mapel = $this->FrontMapelModel->getAllMapel("id_mapel = '{$id_mapel}'");

				if ($mapel["total"] > 0) {
					$this->load->library(['form_validation', 'upload']);

					$data = [
						"bank_user"     => $_POST['bank_anda'],
						"no_rek_user"   => $_POST['no_rekening'],
						"atas_nama"     => $_POST['atas_nama'],
						"jumlah_bayar"  => $_POST['jumlah_bayar'],
						"tanggal_bayar" => date("Y-m-d H:i:s"),
						"status"        => 1,
					];

					$error = [];

					if (!isset($_FILES['bukti_pembayaran']['name']) || $_FILES['bukti_pembayaran']['name'] == "") {
						$nama_file = "";
					} else {
						$config['upload_path'] = './upload/transaksi';
						$config['allowed_types'] = 'gif|jpg|png';
						$config['encrypt_name'] = true;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('bukti_pembayaran')) {
							$error['image'] = $this->upload->display_errors();
							$nama_file = "";
						} else {
							$nama_file = $this->upload->data('file_name');
						}
					}
					$data['bukti_transfer'] = $nama_file;


					$this->form_validation->set_data($data);

					$this->form_validation->set_rules('bank_user', 'Bank Yang Anda Gunakan', 'required');
					$this->form_validation->set_rules('no_rek_user', 'No. Rekening', 'required');
					$this->form_validation->set_rules('atas_nama', 'Nama Pemilik Rekening', 'required');

					if ($this->form_validation->run() == false) {
						$return = $error;
						$code = 422;
						$return['form'] = $this->form_validation->error_array();
						$return['success'] = false;
						$return['message'] = "Data Tidak Valid";

						if (isset($error['image']) && $error['image'] != "") {
							$return['form']['bukti_pembayaran'] = $error['image'];
						}
						alert("error", "Data Tidak Valid", ul($this->form_validation->error_array()));
					} elseif (isset($error['image']) && $error['image'] != "") {
						$return = $error;
						$code = 422;
						$return['form'] = $this->form_validation->error_array();
						$return['form']['bukti_pembayaran'] = $error['image'];
						$return['success'] = false;
						$return['message'] = "Data Tidak Valid";
						alert("error", "Data Tidak Valid", ul($this->form_validation->error_array()));
					} else {
						$simpan = $this->UniversalModel->update("transaksi", "id_transaksi = {$id}", $data);
						if ($simpan) {
							alert("success", "Berhasil Menyimpan Data", "Transaksi telah dikirimkan");
						} else {
							alert("error", "Gagal Menyimpan Data", "Ulangi kembali");
						}
					}

					return redirect(base_url("konfirmasi/" . $id));

				} else {
					$this->data["title"] = "Kursus Tidak Di Temukan";
					$this->data["content"] = "404";
				}
			} else {
				$this->data["title"] = "Kursus Tidak Di Temukan";
				$this->data["content"] = "404";
			}
		} else {
			$this->data["title"] = "Kursus Tidak Di Temukan";
			$this->data["content"] = "404";
		}


	}

	public function beliGratis($meta_link_mapel = "")
	{
		$mapel = $this->FrontMapelModel->getAllMapel("meta_link_mapel = '{$meta_link_mapel}'");

		if ($mapel["total"] > 0) {
			$mapel = $mapel["data"][0];

			if ($mapel["status_gratis"] == 1) {

				$dataTransaksi = [
					"status"         => 0,
					"user_id"        => $_SESSION['siswaData']['id_user'],
					"jumlah"         => 2,
					"jumlah_bayar"   => $mapel["harga_basic"],
					"bank_karisma"   => "BRI",
					"tanggal"        => date("Y-m-d H:i:s"),
					"total_beli"     => $mapel["harga_basic"],
					"total_potongan" => $mapel["harga_basic"],
					"kode_voucher"   => "GRTS00000",
					"bukti_transfer" => "default.png",
					"bank_user"      => "BRI",
					"no_rek_user"    => 222323,
					"atas_nama"      => $_SESSION['siswaData']['nama_user'],
					"tanggal_bayar"  => date("Y-m-d H:i:s"),
				];


				$simpan = $this->UniversalModel->insert("transaksi", $dataTransaksi);

				$dataDetail = [
					"mapel_id"     => $mapel["id_mapel"],
					"user_id"      => $_SESSION['siswaData']['id_user'],
					"transaksi_id" => $simpan["id"],
					"level_mapel"  => 1,
					"created_at"   => date("Y-m-d H:i:s"),
				];

				$simpanDetail = $this->UniversalModel->insert("detail_transaksi", $dataDetail);

				$dataInsertDetailTrasnsaksi = [
					"mapel_id"            => $mapel["id_mapel"],
					"user_id"             => $_SESSION['siswaData']['id_user'],
					"transaksi_id"        => $simpan["id"],
					"detail_transaksi_id" => 0,
					"level_mapel"         => 1,
					"created_at"          => date("Y-m-d H:i:s"),
				];

				$simpanDetail = $this->UniversalModel->insert("user_mapel", $dataInsertDetailTrasnsaksi);

				if ($simpanDetail["success"]) {
					redirect(base_url("belajar/" . $meta_link_mapel));
				} else {

					alert("danger", "Terjadi Kesalahan", "Gagal Membeli Kelas");

					redirect(base_url("profil"));
				}
			} else {

				alert("warning", "Maaf", "Kelas Tidak Tersedia");

				redirect(base_url("profil"));
			}

		} else {
			$this->data["title"] = "Kursus Tidak Di Temukan";
			$this->data["content"] = "404";
			$this->load->view("front-v2/main", $this->data);
		}

	}

}
