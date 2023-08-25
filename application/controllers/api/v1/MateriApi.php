<?php
defined('BASEPATH') or exit('No direct script access allowed');


class MateriApi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('back/BabModel', 'BackBabModel', true);
		$this->load->model('back/MateriModel', 'BackMateriModel', true);
		$this->load->model('back/SoalModel', 'BackSoalModel', true);
	}

	public function jsondata()
	{
		$limit = $_GET['limit'] ?? 10;
		$page = $_GET['page'] ?? 1;
		$search = $_GET['search'] ?? "";
		$order = $_GET['order'] ?? "urutan_materi|ASC";
		$idBab = $_GET['idBab'] ?? 0;

		$start = ($page > 1) ? ($page * $limit) - $limit : 0;
		$order_option = explode("|", $order)[1];
		$order = explode("|", $order)[0];

		$dataMateri = $this->BackMateriModel->getPaging($limit, $start, $search, $order, $order_option, $idBab);
		$dataMateri = obj_to_arr($dataMateri);

		$params = "";
		if (isset($_GET) && count($_GET) > 0) {
			foreach ($_GET as $name => $value) {
				if ($name != "page") {
					$params .= "&{$name}={$value}";
				}
			}
		}

		$first_page = $dataMateri['total_page'] == 1 || $page == 1 ? "#" : base_url("api/v1/BabApi/jsondata") . "?page=1" . $params;
		$last_page = $dataMateri['total_page'] == 1 || $page == $dataMateri['total_page'] ? "#" : base_url("api/v1/BabApi/jsondata") . "?page={$dataMateri['total_page']}" . $params;

		if (($page + 1) <= $dataMateri['total_page']) {
			$next_page = base_url("api/v1/BabApi/jsondata") . "?page=" . ($page + 1) . $params;
		} else {
			$next_page = "#";
		}

		if (($page - 1) >= 1) {
			$prev_page = base_url("api/v1/BabApi/jsondata") . "?page=" . ($page - 1) . $params;
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

	public function jsondatasoal()
	{
		$limit = $_GET['limit'] ?? 10;
		$page = $_GET['page'] ?? 1;
		$search = $_GET['search'] ?? "";
		$order = $_GET['order'] ?? "id_soal|ASC";
		$idMateri = $_GET['idMateri'] ?? 0;
		$paketSoal = $_GET['paketSoal'] ?? 1;
		$start = ($page > 1) ? ($page * $limit) - $limit : 0;
		$order_option = explode("|", $order)[1];
		$order = explode("|", $order)[0];

		$dataMateri = $this->BackSoalModel->getPaging($limit, $start, $search, $order, $order_option, $idMateri, $paketSoal);
		$dataMateri = obj_to_arr($dataMateri);

		for ($i = 0; $i < count($dataMateri['data']); $i++) {
			$dataMateri['data'][$i]['isi_soal'] = strip_tags($dataMateri['data'][$i]['isi_soal']);
			$dataMateri['data'][$i]['isi_soal'] = substr($dataMateri['data'][$i]['isi_soal'], 0, 100);
		}

		$params = "";
		if (isset($_GET) && count($_GET) > 0) {
			foreach ($_GET as $name => $value) {
				if ($name != "page") {
					$params .= "&{$name}={$value}";
				}
			}
		}

		$first_page = $dataMateri['total_page'] == 1 || $page == 1 ? "#" : base_url("api/v1/MateriApi/jsondatasoal") . "?page=1" . $params;
		$last_page = $dataMateri['total_page'] == 1 || $page == $dataMateri['total_page'] ? "#" : base_url("api/v1/MateriApi/jsondatasoal") . "?page={$dataMateri['total_page']}" . $params;

		if (($page + 1) <= $dataMateri['total_page']) {
			$next_page = base_url("api/v1/MateriApi/jsondatasoal") . "?page=" . ($page + 1) . $params;
		} else {
			$next_page = "#";
		}

		if (($page - 1) >= 1) {
			$prev_page = base_url("api/v1/MateriApi/jsondatasoal") . "?page=" . ($page - 1) . $params;
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

	public function detail($id)
	{
		$dataMateri = $this->BackMateriModel->getById($id);

		if ($dataMateri['total'] >= 1) {
			$code = 200;
			$return['message'] = "Data Di temukan";
			$return['success'] = false;
			$return['data'] = $dataMateri['data'][0];
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
		$urutanTerakhir = $this->BackMateriModel->getLastUrutanByBab($_POST['mapel_id']);
		$data = [
			"nama_bab" => $_POST['nama_bab'],
			"deskripsi_bab" => $_POST['deskripsi_bab'],
			"pretest_status" => isset($_POST['pretest_status']) ? $_POST['pretest_status'] : 0,
			"mapel_id" => $_POST['mapel_id'],
			"meta_link_bab" => $this->BackMateriModel->getMetaLink($_POST['nama_bab']),
			"urutan_materi" => ($urutanTerakhir + 1),
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
			$simpan = $this->BackMateriModel->saveData($data);
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
		$dataMateri = $this->BackMateriModel->getById($id);

		if ($dataMateri['total'] >= 1) {
			$this->load->library(['form_validation', 'upload']);

			$data = [
				"nama_bab" => $_POST['nama_bab'],
				"deskripsi_bab" => $_POST['deskripsi_bab'],
				"pretest_status" => isset($_POST['pretest_status']) ? $_POST['pretest_status'] : 0,
				"mapel_id" => $_POST['mapel_id'],
				"meta_link_bab" => ($_POST['nama_bab'] != $dataMateri['data'][0]['nama_bab'] ? $this->BackMateriModel->getMetaLink($_POST['nama_bab'], $id) : $dataMateri['data'][0]['meta_link_bab']),
			];

			$error = [];

			if (!isset($_FILES['gambar_bab']['name']) || $_FILES['gambar_bab']['name'] == "") {
				$nama_file = $dataMateri['data'][0]['gambar_bab'];
			} else {
				$config['upload_path'] = './upload/bab';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['encrypt_name'] = true;
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('gambar_bab')) {
					$error['image'] = $this->upload->display_errors();
					$nama_file = $dataMateri['data'][0]['gambar_bab'];
				} else {
					if ($dataMateri['data'][0]['gambar_bab'] != "") {
						unlink('./upload/bab/' . $dataMateri['data'][0]['gambar_bab']);
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
				$simpan = $this->BackMateriModel->updateData($id, $data);
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
		$dataMateri = $this->BackMateriModel->getById($id);

		if ($dataMateri['total'] >= 1) {
			$simpan = $this->BackMateriModel->deleteData($id);
			if ($simpan) {
				if ($dataMateri['data'][0]['gambar_bab'] != "") {
					unlink('./upload/bab/' . $dataMateri['data'][0]['gambar_bab']);
				}

				if ($dataMateri['data'][0]['tipe'] != "latihan" && is_dir('upload/materi/' . $dataMateri['data'][0]['tipe'] . '/' . $dataMateri['data'][0]['meta_link_materi'] . "/")) {
					delete_files('upload/materi/' . $dataMateri['data'][0]['tipe'] . '/' . $dataMateri['data'][0]['meta_link_materi'] . "/");
				} else {
					delete_files('upload/materi/latihan/' . $dataMateri['data'][0]['id_materi'] . "/");
				}

				if ($dataMateri['data'][0]['tipe'] == "pdf" && $dataMateri['data'][0]['pdf_file'] != "") {
					unlink('./upload/materi-pdf/' . $dataMateri['data'][0]['pdf_file']);
				}

				$code = 200;
				$return['message'] = "Berhasil Menghapus " . $dataMateri['data'][0]['nama_bab'];
				$return['success'] = true;
			} else {
				$code = 500;
				$return['message'] = "Gagal Menyimpan " . $dataMateri['data'][0]['nama_bab'];
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

	public function getAllByBab($idMapel)
	{
		$data = $this->BackMateriModel->getAllByBab($idMapel);


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
				"urutan_materi" => $i,
			];

			$simpan = $simpan && $this->BackMateriModel->updateData($value["id"], $data);

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

	public function simpanVideo()
	{
		$metalink = $this->BackMateriModel->getMetaLink($_POST['nama_materi']);


		$this->load->library(['form_validation', 'upload']);
		$urutanTerakhir = $this->BackMateriModel->getLastUrutanByBab($_POST['bab_id']);
		$data = [
			"bab_id" => $_POST['bab_id'],
			"nama_materi" => $_POST['nama_materi'],
			"deskripsi_materi" => $_POST['deskripsi_materi'],
			"url_video" => $_POST['url_video'],
			"durasi" => implode(".", $_POST['durasi_materi']),
			"isi_materi" => $_POST['isi_materi'],
			"tipe" => "video",
			"meta_link_materi" => $this->BackMateriModel->getMetaLink($_POST['nama_materi']),
			"urutan_materi" => ($urutanTerakhir + 1),
		];
		$error = [];


		$this->form_validation->set_data($data);

		$this->form_validation->set_rules('nama_materi', 'Nama Bab', 'required');
		$this->form_validation->set_rules('bab_id', 'Bab', 'required');
		$this->form_validation->set_rules('url_video', 'ID Youtube Video', 'required');
		$this->form_validation->set_rules('durasi', 'Durasi Video', 'required');

		if ($this->form_validation->run() == false) {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";
		} elseif (isset($error['image']) && $error['image'] != "") {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";
		} else {
			$data['isi_materi'] = convert_base64_to_image($_POST['isi_materi'], 'upload/materi/video/' . $metalink . "/");
			$simpan = $this->BackMateriModel->saveData($data);
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


	public function ubahVideo()
	{
		$id = $_POST['id_materi'] ?? 0;
		$dataMateri = $this->BackMateriModel->getById($id);
		if ($dataMateri['total'] >= 1) {
			$metalink = $dataMateri['data'][0]['meta_link_materi'];
			if ($_POST['nama_materi'] != $dataMateri['data'][0]['nama_materi']) {
				$metalink = $this->BackMateriModel->getMetaLink($_POST['nama_materi'], $id);
				$oldDir = 'upload/materi/video/' . $dataMateri[0]['meta_link_materi'];
				$newDir = 'upload/materi/video/' . $metalink;

				rename($oldDir, $newDir);
			}

			$materi = convert_base64_to_image($_POST['isi_materi'], 'upload/materi/video/' . $metalink . "/");

			$this->load->library(['form_validation', 'upload']);
			$data = [
				"bab_id" => $_POST['bab_id'],
				"nama_materi" => $_POST['nama_materi'],
				"deskripsi_materi" => $_POST['deskripsi_materi'],
				"url_video" => $_POST['url_video'],
				"durasi" => implode(".", $_POST['durasi_materi']),
				"isi_materi" => $materi,
				"tipe" => "video",
				"meta_link_materi" => $metalink,
			];

			$error = [];

			$this->form_validation->set_data($data);

			$this->form_validation->set_rules('nama_materi', 'Nama Bab', 'required');
			$this->form_validation->set_rules('bab_id', 'Bab', 'required');
			$this->form_validation->set_rules('url_video', 'ID Youtube Video', 'required');
			$this->form_validation->set_rules('durasi', 'Durasi Video', 'required');

			if ($this->form_validation->run() == false) {
				$return = $error;
				$code = 422;
				$return['form'] = $this->form_validation->error_array();
				$return['success'] = false;
				$return['message'] = "Data Tidak Valid";
			} elseif (isset($error['image']) && $error['image'] != "") {
				$return = $error;
				$code = 422;

				$return['form'] = $this->form_validation->error_array();
				$return['success'] = false;
				$return['message'] = "Data Tidak Valid";
			} else {
				$simpan = $this->BackMateriModel->updateData($id, $data);
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

	public function simpanTeks()
	{
		$metalink = $this->BackMateriModel->getMetaLink($_POST['nama_materi']);

		$this->load->library(['form_validation', 'upload']);
		$urutanTerakhir = $this->BackMateriModel->getLastUrutanByBab($_POST['bab_id']);
		$data = [
			"bab_id" => $_POST['bab_id'],
			"nama_materi" => $_POST['nama_materi'],
			"deskripsi_materi" => $_POST['deskripsi_materi'],
			"isi_materi" => $_POST['isi_materi'],
			"tipe" => "teks",
			"meta_link_materi" => $metalink,
			"urutan_materi" => ($urutanTerakhir + 1),
		];

		$error = [];


		$this->form_validation->set_data($data);

		$this->form_validation->set_rules('nama_materi', 'Nama Bab', 'required');
		$this->form_validation->set_rules('bab_id', 'Bab', 'required');
		$this->form_validation->set_rules('isi_materi', 'Isi Materi', 'required');

		if ($this->form_validation->run() == false) {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";
		} elseif (isset($error['image']) && $error['image'] != "") {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";
		} else {
			$data['isi_materi'] = convert_base64_to_image($_POST['isi_materi'], 'upload/materi/video/' . $metalink . "/");
			$simpan = $this->BackMateriModel->saveData($data);
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

	public function ubahTeks()
	{
		$id = $_POST['id_materi'] ?? 0;
		$dataMateri = $this->BackMateriModel->getById($id);
		if ($dataMateri['total'] >= 1) {
			$metalink = $dataMateri['data'][0]['meta_link_materi'];
			if ($_POST['nama_materi'] != $dataMateri['data'][0]['nama_materi']) {
				$metalink = $this->BackMateriModel->getMetaLink($_POST['nama_materi'], $id);
				$oldDir = 'upload/materi/teks/' . $dataMateri[0]['meta_link_materi'];
				$newDir = 'upload/materi/teks/' . $metalink;

				rename($oldDir, $newDir);
			}

			$materi = convert_base64_to_image($_POST['isi_materi'], 'upload/materi/teks/' . $metalink . "/");

			$this->load->library(['form_validation', 'upload']);
			$data = [
				"bab_id" => $_POST['bab_id'],
				"nama_materi" => $_POST['nama_materi'],
				"deskripsi_materi" => $_POST['deskripsi_materi'],
				"isi_materi" => $materi,
				"tipe" => "teks",
				"meta_link_materi" => $metalink,
			];

			$error = [];


			$this->form_validation->set_data($data);

			$this->form_validation->set_rules('nama_materi', 'Nama Bab', 'required');
			$this->form_validation->set_rules('bab_id', 'Bab', 'required');
			$this->form_validation->set_rules('isi_materi', 'Isi Materi', 'required');

			if ($this->form_validation->run() == false) {
				$return = $error;
				$code = 422;
				$return['form'] = $this->form_validation->error_array();
				$return['success'] = false;
				$return['message'] = "Data Tidak Valid";
			} elseif (isset($error['image']) && $error['image'] != "") {
				$return = $error;
				$code = 422;
				$return['form'] = $this->form_validation->error_array();
				$return['success'] = false;
				$return['message'] = "Data Tidak Valid";
			} else {
				$simpan = $this->BackMateriModel->updateData($id, $data);
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

	public function simpanPraktek()
	{
		$metalink = $this->BackMateriModel->getMetaLink($_POST['nama_materi']);

		$this->load->library(['form_validation', 'upload']);
		$urutanTerakhir = $this->BackMateriModel->getLastUrutanByBab($_POST['bab_id']);
		$data = [
			"bab_id" => $_POST['bab_id'],
			"nama_materi" => $_POST['nama_materi'],
			"deskripsi_materi" => $_POST['deskripsi_materi'],
			"isi_materi" => $_POST['isi_materi'],
			"durasi" => $_POST['durasi'],
			"tipe" => "praktek",
			"meta_link_materi" => $metalink,
			"urutan_materi" => ($urutanTerakhir + 1),
		];

		$error = [];


		$this->form_validation->set_data($data);

		$this->form_validation->set_rules('nama_materi', 'Nama Bab', 'required');
		$this->form_validation->set_rules('bab_id', 'Bab', 'required');
		$this->form_validation->set_rules('isi_materi', 'Tugas Praktek', 'required');

		if ($this->form_validation->run() == false) {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";
		} elseif (isset($error['image']) && $error['image'] != "") {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";
		} else {
			$data['isi_materi'] = convert_base64_to_image($_POST['isi_materi'], 'upload/materi/video/' . $metalink . "/");

			$simpan = $this->BackMateriModel->saveData($data);
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

	public function ubahPraktek()
	{
		$id = $_POST['id_materi'] ?? 0;
		$dataMateri = $this->BackMateriModel->getById($id);
		if ($dataMateri['total'] >= 1) {
			$metalink = $dataMateri['data'][0]['meta_link_materi'];
			if ($_POST['nama_materi'] != $dataMateri['data'][0]['nama_materi']) {
				$metalink = $this->BackMateriModel->getMetaLink($_POST['nama_materi'], $id);
				$oldDir = 'upload/materi/praktek/' . $dataMateri[0]['meta_link_materi'];
				$newDir = 'upload/materi/praktek/' . $metalink;

				rename($oldDir, $newDir);
			}

			$materi = convert_base64_to_image($_POST['isi_materi'], 'upload/materi/praktek/' . $metalink . "/");

			$this->load->library(['form_validation', 'upload']);
			$data = [
				"bab_id" => $_POST['bab_id'],
				"nama_materi" => $_POST['nama_materi'],
				"durasi" => $_POST['durasi'],
				"deskripsi_materi" => $_POST['deskripsi_materi'],
				"isi_materi" => $materi,
				"tipe" => "praktek",
				"meta_link_materi" => $metalink,
			];

			$error = [];


			$this->form_validation->set_data($data);

			$this->form_validation->set_rules('nama_materi', 'Nama Bab', 'required');
			$this->form_validation->set_rules('bab_id', 'Bab', 'required');
			$this->form_validation->set_rules('isi_materi', 'Tugas Praktek', 'required');

			if ($this->form_validation->run() == false) {
				$return = $error;
				$code = 422;
				$return['form'] = $this->form_validation->error_array();
				$return['success'] = false;
				$return['message'] = "Data Tidak Valid";
			} elseif (isset($error['image']) && $error['image'] != "") {
				$return = $error;
				$code = 422;
				$return['form'] = $this->form_validation->error_array();
				$return['success'] = false;
				$return['message'] = "Data Tidak Valid";
			} else {
				$simpan = $this->BackMateriModel->updateData($id, $data);
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

	public function simpanLatihan()
	{
		$metalink = $this->BackMateriModel->getMetaLink($_POST['nama_materi']);

		$this->load->library(['form_validation', 'upload']);
		$urutanTerakhir = $this->BackMateriModel->getLastUrutanByBab($_POST['bab_id']);
		$data = [
			"bab_id" => $_POST['bab_id'],
			"nama_materi" => $_POST['nama_materi'],
			"deskripsi_materi" => $_POST['deskripsi_materi'],
			"durasi" => $_POST['durasi'],
			"tipe" => "pilihan",
			"meta_link_materi" => $metalink,
			"urutan_materi" => ($urutanTerakhir + 1),
		];

		$error = [];


		$this->form_validation->set_data($data);

		$this->form_validation->set_rules('nama_materi', 'Nama Bab', 'required');
		$this->form_validation->set_rules('bab_id', 'Bab', 'required');

		if ($this->form_validation->run() == false) {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";
		} elseif (isset($error['image']) && $error['image'] != "") {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";
		} else {
			$simpan = $this->BackMateriModel->saveData($data);
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

	public function ubahLatihan()
	{
		$id = $_POST['id_materi'] ?? 0;
		$dataMateri = $this->BackMateriModel->getById($id);
		if ($dataMateri['total'] >= 1) {
			$metalink = $dataMateri['data'][0]['meta_link_materi'];
			if ($_POST['nama_materi'] != $dataMateri['data'][0]['nama_materi']) {
				$metalink = $this->BackMateriModel->getMetaLink($_POST['nama_materi'], $id);
			}


			$this->load->library(['form_validation', 'upload']);
			$data = [
				"bab_id" => $_POST['bab_id'],
				"nama_materi" => $_POST['nama_materi'],
				"deskripsi_materi" => $_POST['deskripsi_materi'],
				"durasi" => $_POST['durasi'],
				"tipe" => "pilihan",
				"meta_link_materi" => $metalink,
			];

			$error = [];


			$this->form_validation->set_data($data);

			$this->form_validation->set_rules('nama_materi', 'Nama Bab', 'required');
			$this->form_validation->set_rules('bab_id', 'Bab', 'required');

			if ($this->form_validation->run() == false) {
				$return = $error;
				$code = 422;
				$return['form'] = $this->form_validation->error_array();
				$return['success'] = false;
				$return['message'] = "Data Tidak Valid";
			} elseif (isset($error['image']) && $error['image'] != "") {
				$return = $error;
				$code = 422;
				$return['form'] = $this->form_validation->error_array();
				$return['success'] = false;
				$return['message'] = "Data Tidak Valid";
			} else {
				$simpan = $this->BackMateriModel->updateData($id, $data);
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

	public function simpanBatch()
	{
		$this->load->library(['form_validation', 'upload']);
		$id = $_POST['id_materi'] ?? 0;
		$dataMateri = $this->BackMateriModel->getById($id);
		if ($dataMateri['total'] >= 1) {
			$this->form_validation->set_rules('isi_materi', 'Isi Mater', 'required');
			$isi_materi = $_POST['isi_materi'];


			$isi = remove_unsusedp($isi_materi);
			$document = new DOMDocument();
			libxml_use_internal_errors(true);
			$document->loadHTML(mb_convert_encoding($isi, 'HTML-ENTITIES', 'UTF-8'));
			$tags = $document->getElementsByTagName('td');
			$data = [];
			$tidy = new tidy();

			$error = [];
			foreach ($tags as $tag) {
				$t = DOMinnerHTML($tag);
				$w = explode("KUNCI:", $t);
				$pertanyaan = remove_unsusedp(remove_unsusedhtml($tidy->repairString($w[0])));
				$w = explode("PEMBAHASAN:", $w[1]);
				$pembahasan = remove_unsusedp(remove_unsusedhtml($tidy->repairString($w[1])));
				$w = explode("PILIHAN:", $w[0]);
				$kunci = strip_tags(remove_unsusedp(remove_unsusedhtml($tidy->repairString($w[0]))));
				$kunci = trim(preg_replace('/\W/', '', $kunci));
				$pilihan = remove_unsusedp(remove_unsusedhtml($tidy->repairString($w[1])));
				$doc2 = new DOMDocument();
				libxml_use_internal_errors(true);
				$doc2->loadHTML(mb_convert_encoding($pilihan, 'HTML-ENTITIES', 'UTF-8'));
				$pils = $doc2->getElementsByTagName('p');
				$datapil = [];
				$i = 1;
				$alpha = "A";
				foreach ($pils as $pil) {
					$pil = DOMinnerHTML($pil);
					$pil = trim(preg_replace('/\W([ABCDE])\W./', '', $pil, 1));
					$datapil['jawab_' . $i] = $pil;
					$i++;
					$alpha++;
				}
				$data['data'][] = [
					"pertanyaan" => $pertanyaan,
					"pembahasan" => $pembahasan,
					"kunci" => $kunci,
					"pilihan" => $datapil,
				];
			}


			if ($this->form_validation->run() == false) {
				$return = $error;
				$code = 422;
				$return['form'] = $this->form_validation->error_array();
				$return['success'] = false;
				$return['message'] = "Data Tidak Valid";
			} elseif (isset($error['image']) && $error['image'] != "") {
				$return = $error;
				$code = 422;
				$return['form'] = $this->form_validation->error_array();
				$return['success'] = false;
				$return['message'] = "Data Tidak Valid";
			} else {
				//				$simpan = $this->BackMateriModel->updateData($id, $data);
				//				if ($simpan) {
				$code = 200;
				$return['message'] = "Berhasil Menyimpan Data";
				$return['success'] = true;
				$return['data'] = $data['data'];
				//					$return['data'] = $data;
				//				} else {
				//					$code = 500;
				//					$return['message'] = "Gagal Menyimpan Data";
				//					$return['success'] = false;
				//					$return['data'] = $data;
				//				}
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

	public function simpanDataSoal()
	{
		$soal = json_decode($_POST['soal'], true);
		$id_materi = $_POST['id_materi'];

		$idSoals = [];
		$dataError = [];
		for ($i = 0; $i < count($soal); $i++) {
			$dirName = generateRandomString(10) . date('YmdHis');
			$dir = "upload/materi/latihan/" . $id_materi . "/soal/" . $dirName;
			$pertanyaan = convert_base64_to_image($soal[$i]['pertanyaan'], $dir . "/pertanyaan/");
			$pembahasan = convert_base64_to_image($soal[$i]['pembahasan'], $dir . "/pembahasan/");
			$jawab_1 = convert_base64_to_image($soal[$i]['pilihan']['jawab_1'], $dir . "/jawab_1/");
			$jawab_2 = convert_base64_to_image($soal[$i]['pilihan']['jawab_2'], $dir . "/jawab_2/");
			$jawab_3 = convert_base64_to_image($soal[$i]['pilihan']['jawab_3'], $dir . "/jawab_3/");
			$jawab_4 = convert_base64_to_image($soal[$i]['pilihan']['jawab_4'], $dir . "/jawab_4/");
			$jawab_5 = isset($soal[$i]['pilihan']['jawab_5']) ? convert_base64_to_image($soal[$i]['pilihan']['jawab_5'], $dir . "/jawab_5/") : "";


			switch ($soal[$i]['kunci']) {
				case "A":
					$kunci_jawaban = 1;
					break;
				case "B":
					$kunci_jawaban = 2;
					break;
				case "C":
					$kunci_jawaban = 3;
					break;
				case "D":
					$kunci_jawaban = 4;
					break;
				case "E":
					$kunci_jawaban = 5;
					break;
				default:
					$kunci_jawaban = 1;
					break;
			}

			$dataSoal = [
				'isi_soal' => $pertanyaan,
				'materi_id' => $id_materi,
				"dir" => $dir,
				"paket" => $_POST['paket']
			];

			$insert = $this->BackSoalModel->saveData($dataSoal);

			if ($insert['success']) {
				$idSoal = $insert['id'];
				$idSoals[] = $idSoal;
				$dataJawaban = [
					"jawab_1" => $jawab_1,
					"jawab_2" => $jawab_2,
					"jawab_3" => $jawab_3,
					"jawab_4" => $jawab_4,
					"jawab_5" => $jawab_5,
					"kunci_jawaban" => $kunci_jawaban,
					"pembahasan" => $pembahasan,
					"soal_id" => $idSoal,
				];

				$insertJawaban = $this->BackSoalModel->saveDataJawaban($dataJawaban);

				if (!$insertJawaban) {
					$dataError[] = "Soal Nomor " . ($i + 1) . "Gagal Di Input";
				}
			} else {
				$dataError[] = "Soal Nomor " . ($i + 1) . "Gagal Di Input";
			}
		}

		if (count($dataError) >= 1) {
			$code = 422;
			$return['form'] = $dataError;
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";
		} else {
			$code = 200;
			$return['message'] = "Berhasil Menyimpan Data";
			$return['success'] = true;
		}

		return $this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output(json_encode($return));
	}

	public function deleteDataSoal($id)
	{
		$id = $id ?? 0;
		$dataSoal = $this->BackSoalModel->getById($id);

		if ($dataSoal['total'] >= 1) {
			$simpan = $this->BackSoalModel->deleteData($id);
			if ($simpan) {

				delete_files($dataSoal['data'][0]['dir'] . "/");

				$code = 200;
				$return['message'] = "Berhasil Menghapus Soal";
				$return['success'] = true;
			} else {
				$code = 500;
				$return['message'] = "Gagal Menyimpan Menghapus";
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

	public function simpanSoal()
	{
		$dirName = generateRandomString(10) . date('YmdHis');
		$dir = "upload/materi/latihan/" . $_POST['id_materi'] . "/soal/" . $dirName;

		$this->load->library(['form_validation', 'upload']);

		$id_materi = $_POST['id_materi'];
		$pertanyaan = convert_base64_to_image($_POST['pertanyaan'], $dir . "/pertanyaan/");
		$pembahasan = convert_base64_to_image($_POST['pembahasan'], $dir . "/pembahasan/");
		$jawab_1 = convert_base64_to_image($_POST['jawaban_1'], $dir . "/jawab_1/");
		$jawab_2 = convert_base64_to_image($_POST['jawaban_2'], $dir . "/jawab_2/");
		$jawab_3 = convert_base64_to_image($_POST['jawaban_3'], $dir . "/jawab_3/");
		$jawab_4 = convert_base64_to_image($_POST['jawaban_4'], $dir . "/jawab_4/");
		if (isset($_POST['jawaban_5']))
			$jawab_5 = convert_base64_to_image($_POST['jawaban_5'], $dir . "/jawab_5/");
		else {
			$jawab_5 = "";
		}
		switch ($_POST['kunci']) {
			case "A":
				$kunci_jawaban = 1;
				break;
			case "B":
				$kunci_jawaban = 2;
				break;
			case "C":
				$kunci_jawaban = 3;
				break;
			case "D":
				$kunci_jawaban = 4;
				break;
			case "E":
				$kunci_jawaban = 5;
				break;
			default:
				$kunci_jawaban = 1;
				break;
		}

		$data = [
			'isi_soal' => $pertanyaan,
			'materi_id' => $id_materi,
			"dir" => $dir,
			'pembahasan' => $pembahasan,
			'jawab_1' => $jawab_1,
			'jawab_2' => $jawab_2,
			'jawab_3' => $jawab_3,
			'jawab_4' => $jawab_4,
			'jawab_5' => $jawab_5,
			'kunci' => $kunci_jawaban,
		];


		$error = [];


		$this->form_validation->set_data($data);

		$this->form_validation->set_rules('isi_soal', 'Pertanyaan', 'required');
		$this->form_validation->set_rules('materi_id', 'Materi', 'required');
		$this->form_validation->set_rules('jawab_1', 'Jawaban 1', 'required');
		$this->form_validation->set_rules('jawab_2', 'Jawaban 2', 'required');
		$this->form_validation->set_rules('jawab_3', 'Jawaban 3', 'required');
		$this->form_validation->set_rules('jawab_4', 'Jawaban 4', 'required');
		$this->form_validation->set_rules('kunci', 'Kunci Jawaban', 'required');

		if ($this->form_validation->run() == false) {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";
		} elseif (isset($error['image']) && $error['image'] != "") {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";
		} else {
			$dataSoal = [
				'isi_soal' => $pertanyaan,
				'materi_id' => $id_materi,
				"dir" => $dir,
				"paket" => $_POST['paket_soal'],

			];

			$insert = $this->BackSoalModel->saveData($dataSoal);

			if ($insert['success']) {
				$idSoal = $insert['id'];
				$idSoals[] = $idSoal;
				$dataJawaban = [
					"jawab_1" => $jawab_1,
					"jawab_2" => $jawab_2,
					"jawab_3" => $jawab_3,
					"jawab_4" => $jawab_4,
					"jawab_5" => $jawab_5,
					"kunci_jawaban" => $kunci_jawaban,
					"pembahasan" => $pembahasan,
					"soal_id" => $idSoal,
				];
				$insertJawaban = $this->BackSoalModel->saveDataJawaban($dataJawaban);
				if ($insertJawaban) {
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

	public function ubahSoal()
	{
		$id = $_POST['id_soal'];
		$dataSoal = $this->BackSoalModel->getById($id);

		if ($dataSoal['total'] >= 1) {
			$dir = $dataSoal['data'][0]['dir'];
			if ($dir == "") {
				$dirName = generateRandomString(10) . date('YmdHis');
				$dir = "upload/materi/latihan/" . $id . "/soal/" . $dirName;
			}

			$this->load->library(['form_validation', 'upload']);

			$id_materi = $_POST['id_materi'];
			$pertanyaan = convert_base64_to_image($_POST['pertanyaan'], $dir . "/pertanyaan/");
			$pembahasan = convert_base64_to_image($_POST['pembahasan'], $dir . "/pembahasan/");
			$jawab_1 = convert_base64_to_image($_POST['jawaban_1'], $dir . "/jawab_1/");
			$jawab_2 = convert_base64_to_image($_POST['jawaban_2'], $dir . "/jawab_2/");
			$jawab_3 = convert_base64_to_image($_POST['jawaban_3'], $dir . "/jawab_3/");
			$jawab_4 = convert_base64_to_image($_POST['jawaban_4'], $dir . "/jawab_4/");
			if (isset($_POST['jawaban_5'])) {
				$jawab_5 = convert_base64_to_image($_POST['jawaban_5'], $dir . "/jawab_5/");
			} else {
				$jawab_5 = "";
			}

			switch ($_POST['kunci']) {
				case "A":
					$kunci_jawaban = 1;
					break;
				case "B":
					$kunci_jawaban = 2;
					break;
				case "C":
					$kunci_jawaban = 3;
					break;
				case "D":
					$kunci_jawaban = 4;
					break;
				case "E":
					$kunci_jawaban = 5;
					break;
				default:
					$kunci_jawaban = 1;
					break;
			}

			$data = [
				'isi_soal' => $pertanyaan,
				'materi_id' => $id_materi,
				"dir" => $dir,
				'pembahasan' => $pembahasan,
				'jawab_1' => $jawab_1,
				'jawab_2' => $jawab_2,
				'jawab_3' => $jawab_3,
				'jawab_4' => $jawab_4,
				'jawab_5' => $jawab_5,
				'kunci' => $kunci_jawaban,
			];


			$error = [];


			$this->form_validation->set_data($data);

			$this->form_validation->set_rules('isi_soal', 'Pertanyaan', 'required');
			$this->form_validation->set_rules('materi_id', 'Materi', 'required');
			$this->form_validation->set_rules('jawab_1', 'Jawaban 1', 'required');
			$this->form_validation->set_rules('jawab_2', 'Jawaban 2', 'required');
			$this->form_validation->set_rules('jawab_3', 'Jawaban 3', 'required');
			$this->form_validation->set_rules('jawab_4', 'Jawaban 4', 'required');
			$this->form_validation->set_rules('kunci', 'Kunci Jawaban', 'required');

			if ($this->form_validation->run() == false) {
				$return = $error;
				$code = 422;
				$return['form'] = $this->form_validation->error_array();
				$return['success'] = false;
				$return['message'] = "Data Tidak Valid";
			} elseif (isset($error['image']) && $error['image'] != "") {
				$return = $error;
				$code = 422;
				$return['form'] = $this->form_validation->error_array();
				$return['success'] = false;
				$return['message'] = "Data Tidak Valid";
			} else {
				$dataSoal = [
					'isi_soal' => $pertanyaan,
					'materi_id' => $id_materi,
					"dir" => $dir,

				];

				$insert = $this->BackSoalModel->updateData($id, $dataSoal);

				if ($insert) {
					$idSoal = $id;
					$idSoals[] = $idSoal;
					$dataJawaban = [
						"jawab_1" => $jawab_1,
						"jawab_2" => $jawab_2,
						"jawab_3" => $jawab_3,
						"jawab_4" => $jawab_4,
						"jawab_5" => $jawab_5,
						"kunci_jawaban" => $kunci_jawaban,
						"pembahasan" => $pembahasan,
						"soal_id" => $idSoal,
					];
					$insertJawaban = $this->BackSoalModel->updateDataJawaban($id, $dataJawaban);
					if ($insertJawaban) {
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

	public function detailSoal($id)
	{
		$dataSoal = $this->BackSoalModel->getById($id);

		if ($dataSoal['total'] >= 1) {
			$code = 200;
			$return['message'] = "Data Di temukan";
			$return['success'] = false;
			$return['data'] = $dataSoal['data'][0];
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

	public function setUrutan()
	{
		$bab = $this->BackBabModel->getAll();

		foreach ($bab['data'] as $key => $data) {
			$materi = $this->BackMateriModel->getAllByBab($data['id_bab']);
			$i = 1;
			foreach ($materi['data'] as $key2 => $data2) {
				$dataMateri = [
					'urutan_materi' => $i
				];
				$insert = $this->BackMateriModel->updateData($data2['id_materi'], $dataMateri);
				$i++;
			}
		}
	}

	public function simpanPdf()
	{
		$metalink = $this->BackMateriModel->getMetaLink($_POST['nama_materi']);


		$this->load->library(['form_validation', 'upload']);

		$urutanTerakhir = $this->BackMateriModel->getLastUrutanByBab($_POST['bab_id']);

		$data = [
			"bab_id" => $_POST['bab_id'],
			"nama_materi" => $_POST['nama_materi'],
			"deskripsi_materi" => $_POST['deskripsi_materi'],
			"isi_materi" => $_POST['isi_materi'],
			"tipe" => "pdf",
			"meta_link_materi" => $this->BackMateriModel->getMetaLink($_POST['nama_materi']),
			"urutan_materi" => ($urutanTerakhir + 1),
			"webinar_status" => $_POST['webinar_status']
		];

		$error = [];


		if (!isset($_FILES['pdf_file']['name']) || $_FILES['pdf_file']['name'] == "") {
			$error['pdf_file'] = "PDF File Harus Di Pilih";
		} else {
			$config['upload_path'] = './upload/materi-pdf';
			$config['allowed_types'] = 'pdf';
			$config['encrypt_name'] = true;
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('pdf_file')) {
				$error['pdf_file'] = $this->upload->display_errors();
				$nama_file = "";
			} else {
				$nama_file = $this->upload->data('file_name');
			}
		}

		$data['pdf_file'] = $nama_file;

		$this->form_validation->set_data($data);

		$this->form_validation->set_rules('nama_materi', 'Nama Bab', 'required');
		$this->form_validation->set_rules('bab_id', 'Bab', 'required');

		if ($this->form_validation->run() == false) {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";
		} elseif (isset($error['pdf_file']) && $error['pdf_file'] != "") {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['form']['pdf_file'] = $error['pdf_file'];
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";
		} else {
			$data['isi_materi'] = convert_base64_to_image($_POST['isi_materi'], 'upload/materi/video/' . $metalink . "/");
			$simpan = $this->BackMateriModel->saveData($data);
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

	public function base64($id_materi)
	{
		$materi = $this->UniversalModel->getOneData("materi", "id_materi = {$id_materi}");

		if ($materi["total"] > 0) {
			$materi = $materi["data"];
			if ($materi["tipe"] == "pdf") {
				$this->data["base64"] = chunk_split(base64_encode(file_get_contents(base_url("upload/materi-pdf/{$materi["pdf_file"]}"))));
			}

			$this->data["materi"] = $materi;

			$code = 200;
			$return['message'] = "Data Di temukan";
			$return['success'] = false;
			$return['data'] = $this->data;

		} else {
			$code = 200;
			$return["success"] = false;
			$return["message"] = "Data tidak di temukan";
		}
		return $this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output(json_encode($return));

	}

	public function getMateri($mapelId)
	{
		$materi = $this->db->query("SELECT materi.nama_materi, materi.id_materi FROM mapel JOIN bab ON mapel.id_mapel = bab.mapel_id JOIN materi ON bab.id_bab = materi.bab_id WHERE mapel.id_mapel = '$mapelId' AND materi.webinar_status = 1");
		if ($materi->num_rows() > 0) {
			$code = 200;
			$return['success'] = true;
			$return['data'] = $materi->result_array();
		} else {
			$code = 200;
			$return['success'] = false;
			$return['message'] = 'Data tidak ditemukan!';
		}

		return $this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output(json_encode($return));
	}
}
