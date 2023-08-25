<?php
defined('BASEPATH') or exit('No direct script access allowed');


class UlasanApi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('front-v2/UlasanModel', 'FrontUlasanModel', true);
		$this->load->model('front-v2/MapelModel', 'FrontMapelModel', true);
	}


	public function jsondata()
	{
		$meta_mapel = $_GET['meta'];
		$dataMapel = $this->FrontMapelModel->getByMeta($meta_mapel)["data"][0];
		$id_mapel = $dataMapel["id_mapel"];
		$nama_mapel = $dataMapel["nama_mapel"];

		$dataUlasan = $this->FrontUlasanModel->getByUlasan($_SESSION['siswaData']['id_user'], $id_mapel);
		$dataUlasan = obj_to_arr($dataUlasan);

		$dataUlasan["mapel_id"] = $id_mapel;
		$dataUlasan["mapel_nama"] = $nama_mapel;

		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($dataUlasan));
	}


	public function simpan()
	{
		$this->load->library(['form_validation', 'upload']);
		$data = [
			"user_id" => $_SESSION['siswaData']['id_user'],
			"mapel_id" => $_POST['mapel_id'],
			"rating" => $_POST['rating'],
			"ulasan" => $_POST['ulasan'],
			"created_at" => date('Y-m-d H:i:s'),
		];

		$this->form_validation->set_data($data);

		$this->form_validation->set_rules('mapel_id', 'ID Mapel', 'required');
		$this->form_validation->set_rules('rating', 'Rating', 'required');
		$this->form_validation->set_rules('ulasan', 'Ulasan', 'required');

		if ($this->form_validation->run() == false) {
			$return = $error;
			$code = 422;
			$return['form'] = $this->form_validation->error_array();
			$return['success'] = false;
			$return['message'] = "Data Tidak Valid";
		} else {
			$mapel_id = $this->input->post('mapel_id');
			$update = false;
			$insert = true;
			$user_id = $_SESSION['siswaData']['id_user'];
			$simpan = $this->FrontUlasanModel->saveData($data);
			if ($simpan) {
				$code = 200;
				$return['message'] = "Berhasil Menyimpan Data";
				$return['success'] = true;
				$return['data'] = $data;

				if ($mapel_id == 122171) {
					$gamificationTransactionQuery = $this->db->query("SELECT * FROM gamification_transaction WHERE user_id = '$user_id' AND mapel_id = '$mapel_id'");
					if ($gamificationTransactionQuery->num_rows() == 0) {
						$gamificationTransactionData = [
							'status' => 'pending',
							'balance' => 600000,
							'user_id' => $user_id,
							'mapel_id' => $mapel_id,
						];
						$this->db->insert('gamification_transaction', $gamificationTransactionData);

						$balances = $this->db->get_where('balances', ['user_id' => $user_id]);
						if ($balances->num_rows() > 0) {
							$balanceData = $balances->row_array();
							$balance = $balances['balance'];
							$balance += 600000;
							$balancesData = [
								'balance' => $balance,
							];
							$this->db->where('user_id', $user_id);
							$this->db->update('balances', $balancesData);
						} else {
							$balancesData = [
								'user_id' => $user_id,
								'balance' => 600000
							];
							$this->db->insert('balances', $balancesData);
						}
					}

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


	public function update()
	{
		$dataUlasan = $this->FrontUlasanModel->getById($id);

		if ($dataUlasan['total'] >= 1) {
			$this->load->library(['form_validation', 'upload']);

			$data = [
				"user_id" => $_SESSION['siswaData']['id_user'],
				"mapel_id" => $_POST['mapel_id'],
				"rating" => $_POST['rating'],
				"ulasan" => $_POST['ulasan'],
				"created_at" => date('Y-m-d H:i:s'),
			];

			$id = [
				$data["user_id"], $data["mapel_id"]
			];


			$this->form_validation->set_data($data);

			$this->form_validation->set_rules('mapel_id', 'ID Mapel', 'required');
			$this->form_validation->set_rules('rating', 'Rating', 'required');
			$this->form_validation->set_rules('ulasan', 'Ulasan', 'required');

			if ($this->form_validation->run() == false) {
				$return = $error;
				$code = 422;
				$return['form'] = $this->form_validation->error_array();
				$return['success'] = false;
				$return['message'] = "Data Tidak Valid";

			} else {
				$simpan = $this->FrontUlasanModel->updateData($id, $data);
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


	public function delete($user_id, $mapel_id)
	{
		$user_id = $user_id ?? $_SESSION['siswaData']['id_user'];
		$mapel_id = $mapel_id ?? 0;
		$dataUlasan = $this->FrontUlasanModel->getById($user_id, $mapel_id);

		if ($dataUlasan['total'] >= 1) {
			$simpan = $this->FrontUlasanModel->deleteData($id);
			if ($simpan) {
				$code = 200;
				$return['message'] = "Berhasil Menghapus Testimoni";
				$return['success'] = true;
			} else {
				$code = 500;
				$return['message'] = "Gagal Menghapus Testimoni";
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
		// $data = $this->FrontUlasanModel->getAllByMapel($idMapel);


		// return $this->output
		// 	->set_content_type('application/json')
		// 	->set_status_header(200)
		// 	->set_output(json_encode($data));
	}

}
