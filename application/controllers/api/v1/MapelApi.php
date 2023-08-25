<?php
defined('BASEPATH') or exit('No direct script access allowed');


class MapelApi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('back/KelasModel', 'BackKelasModel', true);
		$this->load->model('back/MapelModel', 'BackMapelModel', true);
		$this->load->model('back/MateriModel', 'BackMateriModel', true);
		$this->load->model('back/ListhasilModel', 'BackListhasilModel', true);
		$this->load->model('back/BabModel', 'BackBabModel', true);

	}

	public function jsondata()
	{
		$limit = $_GET['limit'] ?? 10;
		$page = $_GET['page'] ?? 1;
		$search = $_GET['search'] ?? "";
		$order = $_GET['order'] ?? "nama_mapel|DESC";
		$idKelas = $_GET['idKelas'] ?? 0;

		$start = ($page > 1) ? ($page * $limit) - $limit : 0;
		$order_option = explode("|", $order)[1];
		$order = explode("|", $order)[0];

		$dataMapel = $this->BackMapelModel->getPaging($limit, $start, $search, $order, $order_option, $idKelas);
		$dataMapel = obj_to_arr($dataMapel);

		$params = "";
		if (isset($_GET) && count($_GET) > 0) {
			foreach ($_GET as $name => $value) {
				if ($name != "page") {
					$params .= "&{$name}={$value}";
				}
			}
		}

		$first_page = $dataMapel['total_page'] == 1 || $page == 1 ? "#" : base_url("api/v1/MapelApi/jsondata") . "?page=1" . $params;
		$last_page = $dataMapel['total_page'] == 1 || $page == $dataMapel['total_page'] ? "#" : base_url("api/v1/MapelApi/jsondata") . "?page={$dataMapel['total_page']}" . $params;

		if (($page + 1) <= $dataMapel['total_page']) {
			$next_page = base_url("api/v1/MapelApi/jsondata") . "?page=" . ($page + 1) . $params;
		} else {
			$next_page = "#";
		}

		if (($page - 1) >= 1) {
			$prev_page = base_url("api/v1/MapelApi/jsondata") . "?page=" . ($page - 1) . $params;
		} else {
			$prev_page = "#";
		}

		$dataMapel['current_page'] = $page;
		$dataMapel['start'] = $start;
		$dataMapel['end'] = $start + count($dataMapel['data']);
		$dataMapel['url_first_page'] = $first_page;
		$dataMapel['url_next_page'] = $next_page;
		$dataMapel['url_prev_page'] = $prev_page;
		$dataMapel['url_last_page'] = $last_page;

		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_header('Access-Control-Allow-Origin: *')
			->set_header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE")
			->set_header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With")
			->set_header('Content-Type: application/json')
			->set_output(json_encode($dataMapel));
	}

	public function getAllByKelas($idKelas)
	{
		$dataKelas = $this->BackMapelModel->getAllByKelas($idKelas);

		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($dataKelas));
	}

	public function detail($id)
	{
		$dataMapel = $this->BackMapelModel->getById($id);

		if ($dataMapel['total'] >= 1) {
			$code = 200;
			$return['message'] = "Data Di temukan";
			$return['success'] = false;
			$return['data'] = $dataMapel['data'][0];
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
			"nama_mapel"      => $_POST['nama_mapel'],
			"shortdesc_mapel" => $_POST['shortdesc_mapel'],
			"deskripsi_mapel" => $_POST['deskripsi_mapel'],
			"harga_basic"     => $_POST['harga_basic'],
			"harga_silver"    => $_POST['harga_silver'],
			"harga_gold"      => $_POST['harga_gold'],
			"kelas_id"        => $_POST['kelas_id'],
			"intro_video"     => $_POST['intro_video'],
			"alert_class"     => $_POST['alert_class'],
			"alert_text"      => $_POST['alert_text'],
			"status_webinar"  => isset($_POST['status_webinar']) ? $_POST['status_webinar'] : 0,
			"status_gratis"   => isset($_POST['status_gratis']) ? $_POST['status_gratis'] : 0,
			"meta_link_mapel" => $this->BackMapelModel->getMetaLink($_POST['nama_mapel']),
		];

		$error = [];

		if (!isset($_FILES['gambar_mapel']['name']) || $_FILES['gambar_mapel']['name'] == "") {
			$nama_file = "";
		} else {
			$config['upload_path'] = './upload/mapel';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['encrypt_name'] = true;
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('gambar_mapel')) {
				$error['image_gambar'] = $this->upload->display_errors();
				$nama_file = "";
			} else {
				$nama_file = $this->upload->data('file_name');
			}
		}

		$data['gambar_mapel'] = $nama_file;

		if (!isset($_FILES['banner_mapel']['name']) || $_FILES['banner_mapel']['name'] == "") {
			$nama_file = "default.jpg";
		} else {
			$config['upload_path'] = './upload/banner_mapel';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['encrypt_name'] = true;
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('banner_mapel')) {
				$error['image_banner'] = $this->upload->display_errors();
				$nama_file = "";
			} else {
				$nama_file = $this->upload->data('file_name');
			}
		}
		$data['banner_mapel'] = $nama_file;

		$this->form_validation->set_data($data);

		$this->form_validation->set_rules('nama_mapel', 'Nama Mata Pelajaran', 'required');
		$this->form_validation->set_rules('kelas_id', 'Kelas Mata Pelajaran', 'required');
		$this->form_validation->set_rules('harga_basic', 'Harga Basic Mata Pelajaran', 'required');
		$this->form_validation->set_rules('alert_text', 'Teks Alert', 'max_length[100]');

		if ($this->form_validation->run() == false) {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";

			if ($data['gambar_mapel'] != "") {
				unlink('./upload/mapel/' . $data['gambar_mapel']);
			}

			if ($data['banner_mapel'] != "default.jpg") {
				unlink('./upload/banner_mapel/' . $data['banner_mapel']);
			}

			if (isset($error['image_gambar']) && $error['image_gambar'] != "") {
				$return['form']['gambar_mapel'] = $error['image_gambar'];
			}

			if (isset($error['image_banner']) && $error['image_banner'] != "") {
				$return['form']['banner_mapel'] = $error['image_banner'];
			}
		} elseif (isset($error['image_gambar']) && $error['image_gambar'] != "") {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['form']['gambar_mapel'] = $error['image_gambar'];
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";
		} elseif (isset($error['image_banner']) && $error['image_banner'] != "") {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['form']['banner_mapel'] = $error['image_banner'];
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";
		} else {
			$simpan = $this->BackMapelModel->saveData($data);
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
		$id = $_POST['id_mapel'] ?? 0;
		$dataMapel = $this->BackMapelModel->getById($id);

		if ($dataMapel['total'] >= 1) {
			$this->load->library(['form_validation', 'upload']);

			$data = [
				"nama_mapel"      => $_POST['nama_mapel'],
				"shortdesc_mapel" => $_POST['shortdesc_mapel'],
				"deskripsi_mapel" => $_POST['deskripsi_mapel'],
				"harga_basic"     => $_POST['harga_basic'],
				"harga_silver"    => $_POST['harga_silver'],
				"harga_gold"      => $_POST['harga_gold'],
				"kelas_id"        => $_POST['kelas_id'],
				"intro_video"     => $_POST['intro_video'],
				"alert_class"     => $_POST['alert_class'],
				"alert_text"      => $_POST['alert_text'],
				"status_webinar"  => isset($_POST['status_webinar']) ? $_POST['status_webinar'] : 0,
				"status_gratis"   => isset($_POST['status_gratis']) ? $_POST['status_gratis'] : 0,
				"meta_link_mapel" => ($_POST['nama_mapel'] != $dataMapel['data'][0]['nama_mapel'] ? $this->BackMapelModel->getMetaLink($_POST['nama_mapel'], $id) : $dataMapel['data'][0]['meta_link_mapel']),
			];

			$error = [];

			if (!isset($_FILES['gambar_mapel']['name']) || $_FILES['gambar_mapel']['name'] == "") {
				$nama_file = $dataMapel['data'][0]['gambar_mapel'];
			} else {
				$config['upload_path'] = './upload/mapel';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['encrypt_name'] = true;
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('gambar_mapel')) {
					$error['image_gambar'] = $this->upload->display_errors();
					$nama_file = $dataMapel['data'][0]['gambar_mapel'];
				} else {
					if ($dataMapel['data'][0]['gambar_mapel'] != "" and $dataMapel['data'][0]['gambar_mapel'] != "default.png") {
						unlink('./upload/mapel/' . $dataMapel['data'][0]['gambar_mapel']);
					}
					$nama_file = $this->upload->data('file_name');
				}
			}

			$data['gambar_mapel'] = $nama_file;

			if (!isset($_FILES['banner_mapel']['name']) || $_FILES['banner_mapel']['name'] == "") {
				$nama_file = $dataMapel['data'][0]['banner_mapel'];
			} else {
				$config['upload_path'] = './upload/banner_mapel';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['encrypt_name'] = true;
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('banner_mapel')) {
					$error['image_banner'] = $this->upload->display_errors();
					$nama_file = $dataMapel['data'][0]['banner_mapel'];
				} else {
					if ($dataMapel['data'][0]['banner_mapel'] != "" and $dataMapel    ['data'][0]['banner_mapel'] != "default.jpg") {
						unlink('./upload/banner_mapel/' . $dataMapel['data'][0]['banner_mapel']);
					}
					$nama_file = $this->upload->data('file_name');
				}
			}
			$data['banner_mapel'] = $nama_file;


			$this->form_validation->set_data($data);

			$this->form_validation->set_rules('nama_mapel', 'Nama Mapel', 'required');
			$this->form_validation->set_rules('kelas_id', 'Kelas Mata Pelajaran', 'required');
			$this->form_validation->set_rules('harga_basic', 'Harga Basic Mata Pelajaran', 'required');
			$this->form_validation->set_rules('alert_text', 'Teks Alert', 'max_length[100]');

			if ($this->form_validation->run() == false) {
				$return = $error;
				$code = 422;
				$return['form'] = $this->form_validation->error_array();
				$return['success'] = false;
				$return['message'] = "Data Tidak Valid";

				if ($data['gambar_mapel'] != "" and $data['banner_mapel'] != "default.jpg") {
					unlink('./upload/mapel/' . $data['gambar_mapel']);
				}

				if ($data['banner_mapel'] != "" and $data['banner_mapel'] != "default.jpg") {
					unlink('./upload/banner_mapel/' . $data['banner_mapel']);
				}

				if (isset($error['image_gambar']) && $error['image_gambar'] != "") {
					$return['form']['gambar_mapel'] = $error['image_gambar'];
				}

				if (isset($error['image_banner']) && $error['image_banner'] != "") {
					$return['form']['banner_mapel'] = $error['image_banner'];
				}
			} elseif (isset($error['image_gambar']) && $error['image_gambar'] != "") {
				$return = $error;
				$code = 422;
				$return['form'] = $this->form_validation->error_array();
				$return['form']['gambar_mapel'] = $error['image'];
				$return['success'] = false;
				$return['message'] = "Data Tidak Valid";
			} elseif (isset($error['image_banner']) && $error['image_banner'] != "") {
				$return = $error;
				$code = 422;
				$return['form'] = $this->form_validation->error_array();
				$return['form']['banner_mapel'] = $error['image_banner'];
				$return['success'] = false;
				$return['message'] = "Data Tidak Valid";
			} else {
				$simpan = $this->BackMapelModel->updateData($id, $data);
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
		$dataMapel = $this->BackMapelModel->getById($id);

		if ($dataMapel['total'] >= 1) {
			$simpan = $this->BackMapelModel->deleteData($id);
			if ($simpan) {
				if ($dataMapel['data'][0]['gambar_mapel'] != "") {
					unlink('./upload/mapel/' . $dataMapel['data'][0]['gambar_mapel']);
				}
				$code = 200;
				$return['message'] = "Berhasil Menghapus " . $dataMapel['data'][0]['nama_mapel'];
				$return['success'] = true;
			} else {
				$code = 500;
				$return['message'] = "Gagal Menyimpan " . $dataMapel['data'][0]['nama_mapel'];
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

	public function getAllMapelGroupByKelas()
	{
		$dataKelas = $this->BackKelasModel->getAll();
		$dataMapel = $this->BackMapelModel->getAll();

		$dataKelasBaru = [];

		if ($dataKelas["total"] > 0) {
			foreach ($dataKelas["data"] as $keyKelas => $valueKelas) {
				$dataKelasBaru[$valueKelas["id_kelas"]] = $valueKelas;
			}

			if ($dataMapel["total"] > 0) {

				foreach ($dataMapel["data"] as $keyMapel => $valueMapel) {
					$dataKelasBaru[$valueMapel["kelas_id"]]["mapel"]["data"][] = $valueMapel;
				}

				$dataKelasBaru[$valueMapel["kelas_id"]]["mapel"]["total"] = count($dataKelasBaru[$valueMapel["kelas_id"]]["mapel"]["data"]);
			}
		}

		$dataKelasBaru = [
			"total" => count($dataKelasBaru),
			"data"  => $dataKelasBaru
		];


		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($dataKelasBaru));

	}


	public function resetvideo($idMapel)
	{
		$dataMapel = $this->BackMapelModel->getById($idMapel);
		if ($dataMapel['total'] >= 1) {
			$idMapel = $dataMapel["data"][0]["id_mapel"];
			$dataVideo = $this->BackMateriModel->getFirstVideoByMapel($idMapel);

			if ($dataVideo['total'] >= 1) {
				if (isset($dataVideo["data"][0]["url_video"])) {
					$introVideo = $dataVideo["data"][0]["url_video"];
				} else {
					$introVideo = "95q_npbZQ5o"; //Default Karisma Video
				}
			} else {
				$introVideo = "95q_npbZQ5o"; //Default Karisma Video
			}
			$data = [
				"intro_video" => $introVideo,
			];

			$simpan = $this->BackMapelModel->updateData($idMapel, $data);
			if ($simpan) {
				$code = 200;
				$return['message'] = "Intro Video '{$idMapel}' <br> Berhasil diubah menjadi <i>{$introVideo}</i>";
				$return['success'] = true;
			} else {
				$code = 500;
				$return['message'] = "Gagal Menyimpan Data";
				$return['success'] = false;
				$return['data'] = $data;
			}

		} else {
			$code = 404;
			$return['message'] = "Data tidak ditemukan";
			$return['success'] = false;
		}

		return $this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output(json_encode($return));

	}

	public function togglestatus($idMapel)
	{
		$dataMapel = $this->BackMapelModel->getById($idMapel);
		if ($dataMapel['total'] >= 1) {

			$idMapel = $dataMapel["data"][0]["id_mapel"];
			$data["status"] = $_POST["status"];
			$notif = $_POST["status"] == 1 ? "tampilkan" : "sembunyikan";

			$simpan = $this->BackMapelModel->updateData($idMapel, $data);

			if ($simpan) {
				$code = 200;
				$return['message'] = "Mapel '{$idMapel}' <br> Berhasil <i class='font-weight-bold'>di{$notif}</i>";
				$return['success'] = true;
				$return['status'] = $data["status"];
			} else {
				$code = 500;
				$return['message'] = "Gagal Menyimpan Data";
				$return['success'] = false;
				$return['data'] = $data;
				$return['status'] = -1;
			}

		} else {
			$code = 404;
			$return['message'] = "Data tidak ditemukan";
			$return['success'] = false;
			$return['status'] = -1;
		}

		return $this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output(json_encode($return));

	}

	public function toggleprakerja($idMapel)
	{
		$dataMapel = $this->BackMapelModel->getById($idMapel);
		if ($dataMapel['total'] >= 1) {

			$idMapel = $dataMapel["data"][0]["id_mapel"];
			$data["prakerja"] = $_POST["prakerja"];
			$notif = $_POST["prakerja"] == 1 ? "menambahkan ke" : "menghapus dari";

			$simpan = $this->BackMapelModel->updateData($idMapel, $data);

			if ($simpan) {
				$code = 200;
				$return['message'] = "Mapel '{$idMapel}' <br> Berhasil {$notif} kelas prakerja";
				$return['success'] = true;
				$return['prakerja'] = $data["prakerja"];
			} else {
				$code = 500;
				$return['message'] = "Gagal Menyimpan Data";
				$return['success'] = false;
				$return['data'] = $data;
				$return['status'] = -1;
			}

		} else {
			$code = 404;
			$return['message'] = "Data tidak ditemukan";
			$return['success'] = false;
			$return['status'] = -1;
		}

		return $this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output(json_encode($return));

	}

	public function copyMapel()
	{
		$idMapel = $_REQUEST["id_mapel"];

		$mapel = $this->UniversalModel->getOneData("mapel", "id_mapel = {$idMapel}");

		if ($mapel["total"] > 0) {
			$mapel = $mapel["data"];
			$metalink =

			$filegambar_mapel = "upload/mapel/{$mapel["gambar_mapel"]}";
			$newgambar_mapel = "upload/mapel/duplikat-{$mapel["gambar_mapel"]}";

			if (!copy($filegambar_mapel, $newgambar_mapel)) {
				echo "failed to copy";
			}

			$filebanner_mapel = "upload/banner_mapel/{$mapel["banner_mapel"]}";
			$newbanner_mapel = "upload/banner_mapel/duplikat-{$mapel["banner_mapel"]}";

			if (!copy($filebanner_mapel, $newbanner_mapel)) {
				echo "failed to copy";
			}

			$filegambar_sertifikat = "upload/gambar-sertifikat/{$mapel["gambar_sertifikat"]}";
			$newgambar_sertifikat = "upload/gambar-sertifikat/duplikat-{$mapel["gambar_sertifikat"]}";

			if (!copy($filegambar_sertifikat, $newgambar_sertifikat)) {
				echo "failed to copy";
			}

			$dataMapel = [
				"kelas_id"          => $mapel["kelas_id"],
				"nama_mapel"        => $mapel["nama_mapel"],
				"shortdesc_mapel"   => $mapel["shortdesc_mapel"],
				"deskripsi_mapel"   => $mapel["deskripsi_mapel"],
				"materi_mapel"      => $mapel["materi_mapel"],
				"gambar_mapel"      => "duplikat-{$mapel["gambar_mapel"]}",
				"created_at"        => $mapel["created_at"],
				"harga_basic"       => $mapel["harga_basic"],
				"harga_silver"      => $mapel["harga_silver"],
				"harga_gold"        => $mapel["harga_gold"],
				"meta_link_mapel"   => $this->BackMapelModel->getMetaLink("Duplikat " . $mapel["nama_mapel"]),
				"status"            => $mapel["status"],
				"status_gratis"     => $mapel["status_gratis"],
				"status_webinar"    => $mapel["status_webinar"],
				"banner_mapel"      => "duplikat-{$mapel["banner_mapel"]}",
				"alert_class"       => $mapel["alert_class"],
				"alert_text"        => $mapel["alert_text"],
				"intro_video"       => $mapel["intro_video"],
				"diskon_basic"      => $mapel["diskon_basic"],
				"diskon_silver"     => $mapel["diskon_silver"],
				"diskon_gold"       => $mapel["diskon_gold"],
				"rating_rata"       => $mapel["rating_rata"],
				"rating_jumlah"     => $mapel["rating_jumlah"],
				"prakerja"          => $mapel["prakerja"],
				"gambar_sertifikat" => "duplikat-{$mapel["gambar_sertifikat"]}",
			];

			$dataBab = $this->UniversalModel->getAllData("bab", "mapel_id = {$idMapel}");

			$dataBabInsert = [];

			if ($dataBab["total"] > 0) {
				foreach ($dataBab["data"] as $keybab => $valueBab) {

					$filegambar_bab = "upload/bab/{$valueBab["gambar_sertifikat"]}";
					$newgambar_bab = "upload/bab/duplikat-{$valueBab["gambar_sertifikat"]}";

					if (!copy($filegambar_bab, $newgambar_bab)) {
						echo "failed to copy";
					}

					$dataBabInsert[$valueBab["id_bab"]] = [
						"mapel_id"       => $valueBab["mapel_id"],
						"urutan_bab"     => $valueBab["urutan_bab"],
						"nama_bab"       => $valueBab["nama_bab"],
						"deskripsi_bab"  => $valueBab["deskripsi_bab"],
						"gambar_bab"     => "duplikat-{$valueBab["gambar_sertifikat"]}",
						"pretest_status" => $valueBab["pretest_status"],
						"level_bab"      => $valueBab["level_bab"],
						"created_at"     => $valueBab["created_at"],
						"meta_link_bab"  => $this->BackBabModel->getMetaLink($valueBab["nama_bab"]),
					];
				}


				$idBab = array_keys($dataBabInsert);
				$idBab = implode(",", $idBab);

				$dataMateri = $this->UniversalModel->getAllData("materi", "bab_id IN ({$idBab})");
				$dataMateriInsert = [];

				if ($dataMateri["total"] > 0) {
					foreach ($dataMateri["data"] as $keyMateri => $valueMateri) {
						$dataMateriInsert[$valueMateri["id_materi"]] = [

						];
					}
				}


			}


		}
	}
}


