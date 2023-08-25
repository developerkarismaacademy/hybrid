<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Profile extends CI_Controller
{

	private $data;

	public function __construct()
	{
		parent::__construct();
		$this->data['page'] = "home";

		$this->load->model("front-v2/KelasModel", "FrontKelasModel");
		$this->load->model("front-v2/MapelModel", "FrontMapelModel");
		$this->load->model("front-v2/PaketModel", "FrontPaketModel");
		$this->load->model("front-v2/TransaksiModel", "FrontTransaksiModel");

		$this->FrontAuthModel->isLoggedIn();
	}

	public function index()
	{
		$this->data['title'] = "Profile Anda";
		$this->data['content'] = "profil.detail";

		if (count($_SESSION["idMapelBeli"]) > 0) {
			$mapelId = implode(",", $_SESSION["idMapelBeli"]);
			$this->data["mapel"] = $this->FrontMapelModel->getAllMapel("id_mapel IN ({$mapelId})");
		}

		$pembelian = $this->FrontTransaksiModel->getAllDetailTransaksi("detail_transaksi.user_id = {$_SESSION['siswaData']['id_user']}");
		$this->data["pembelian"] = $pembelian;

		$this->load->view("front-v2/main", $this->data);
	}

	public function edit()
	{
		$this->data['title'] = "Profile Anda";
		$this->data['content'] = "profil.edit";


		if (!isset($this->data["nama_user"])) {
			$user = $this->FrontAuthModel->getUserLoggedIn();
			$this->data = array_merge($this->data, $user["data"]);
			$tanggal_split = explode("-", $user["data"]["tanggal_lahir"]);
			$this->data["tahun"] = $tanggal_split[0];
			$this->data["bulan"] = $tanggal_split[1];
			$this->data["tanggal"] = $tanggal_split[2];
		}
		unset($_POST);
		$this->load->view("front-v2/main", $this->data);
	}

	public function submitEdit()
	{
		if (isset($_POST)) {
			$user = $this->FrontAuthModel->getUserLoggedIn();
			if (isset($_POST["editPasswordLama"]) && isset($_POST["editPassword1"])) {
				$pwLama = $_POST["editPasswordLama"] ?? "";
				$pwBaru1 = $_POST["editPassword1"] ?? "";
				$pwBaru2 = $_POST["editPassword2"] ?? "";
				$pwLama = crypt(crypt($pwLama, garem), garem);
				if ($pwLama == $user["data"]["password"]) {
					if ($pwBaru1 == $pwBaru2) {
						$dataUser["password"] = $pwBaru1;
						$dataUser["password"] = crypt(crypt($dataUser["password"], garem), garem);
						$where = "id_user = {$user["data"]['id_user']}";
						$where .= " AND ";
						$where .= "level_user = 'siswa'";


						if ($this->UniversalModel->update("user", $where, $dataUser)) {
							// $login = $this->FrontAuthModel->login($user["data"]["username"], $dataUser["password"], "siswa");
							// $user = $login["data"];

							// //Update Session
							// $this->session->set_userdata(['siswaData' => $user]);
							// $_SESSION["idMapelBeli"] = $this->FrontAuthModel->getMapelUser();
							alert("warning", "Password telah diubah", "Silahkan login kembali");

							redirect(base_url("logout"));
						}
					} else {
						alert("danger", "Password tidak sesuai", "Silahkan cek kembali");
					}
					$this->edit();
				} else {
					alert("danger", "Password tidak sesuai", "Silahkan cek kembali");
					$this->edit();
				}
			} else {

				if (!isset($_FILES['gambar_user']['name']) || $_FILES['gambar_user']['name'] == "") {
					$nama_file = "";
				} else {
					$config['upload_path'] = './upload/profile-picture/';
					$config['allowed_types'] = 'gif|jpg|png|bmp';
					$config['encrypt_name'] = true;
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('gambar_user')) {
						$error['image'] = $this->upload->display_errors();
						$nama_file = "";
					} else {
						$nama_file = $this->upload->data('file_name');
					}
				}
				$data['gambar_user'] = $nama_file;

				$data['nama_user'] = $_POST["nama_user"] ?? "";
				$data['username'] = $_POST["username"] ?? "";
				$data['email_user'] = $_POST["email_user"] ?? "";
				$data['telepon_user'] = $_POST["telepon_user"] ?? "";
				$data['telepon_user'] = "0" . $data['telepon_user'];
				$data['tempat_lahir'] = $_POST["tempat_lahir"] ?? "";
				$data['jk_user'] = $_POST["jk_user"] ?? "";
				$data['tanggal_lahir'] = $_POST["tahun"] . "-" . (sprintf("%02d", "{$_POST["bulan"]}")) . "-" . (sprintf("%02d", "{$_POST["tanggal"]}"));

				$this->form_validation->set_rules('nama_user', 'Nama User', 'required');
				$this->form_validation->set_rules('telepon_user', 'Telepon', 'required');

				if ($data['username'] != $user["data"]["username"]) {
					$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]');
				} else {
					$this->form_validation->set_rules('username', 'Username', 'required');
				}

				if ($data['email_user'] != $user["data"]["email_user"]) {
					$this->form_validation->set_rules('email_user', 'Email', 'required|valid_email|is_unique[user.email_user]');
				} else {
					$this->form_validation->set_rules('email_user', 'Email', 'required|valid_email');
				}


				if ($this->form_validation->run() == FALSE) {
					if ($data['gambar_user'] != "") {
						unlink('./upload/profile-picture/' . $data['gambar_user']);
					}

					alert("warning", "Terdapat form yang tidak sesuai", "Silahkan cek kembali");
				} else {
					$this->data["kirim"] = true;

					$where = "id_user = {$user["data"]['id_user']}";
					$where .= " AND ";
					$where .= "level_user = 'siswa'";

					if ($this->UniversalModel->update("user", $where, $data)) {
						//Get data from current session
						$user = $this->FrontAuthModel->getUserLoggedIn();
						//Login from current change, except password
						$login = $this->FrontAuthModel->login($data["username"], $user["data"]["password"], "siswa");
						$user = $login["data"];
						$user["nama_depan"] = explode(" ", $user["nama_user"])[0];

						//Update Session
						$this->session->set_userdata(['siswaData' => $user]);
						$_SESSION["idMapelBeli"] = $this->FrontAuthModel->getMapelUser();
						alert("success", "Profil sukses diedit", "Silahkan kembali ke halaman utama");
					} else {
						alert("error", "Terdapat kesalahan server", "Silahkan coba lagi nanti");
					}
				}

				$this->edit();
			}
		}
	}

    public function gamification()
    {
        $user = $this->FrontAuthModel->getUserLoggedIn();
        $userId = $user['data']['id_user'];
        $userEmail = $user['data']['email_user'];
        $mapelId = 122171;
        $this->data['title'] = "Gamification";
        $this->data['content'] = "profil.gamification";
        $this->data['coin'] = $this->db->get_where('coins', ['user_id' => $userId])->row_array();
        $this->data['balance'] = $this->db->get_where('balances', ['user_id' => $userId])->row_array();

        $this->db->where('user_id', $userId);
        $this->db->where('mapel_id', $mapelId);
        $this->data['misi'] = $this->db->count_all_results('rating');

        $this->db->select('mapel.nama_mapel,mapel.gambar_mapel,user_invoice_prakerja.coin,user_invoice_prakerja.created_at');
        $this->db->join('invoice_prakerja', 'user_invoice_prakerja.invoice_prakerja_id = invoice_prakerja.id');
        $this->db->join('mapel', 'mapel.id_mapel = invoice_prakerja.mapel_id');
        $this->db->where('user_id', $userId);
        $this->data['user_invoice_prakerja'] = $this->db->get('user_invoice_prakerja')->result_array();

        $this->db->select('mapel.nama_mapel,mapel.gambar_mapel,gamification_transaction.balance,gamification_transaction.created_at,gamification_transaction.status');
        $this->db->join('mapel', 'mapel.id_mapel = gamification_transaction.mapel_id');
        $this->db->where('user_id', $userId);
        $this->data['gamification_transaction'] = $this->db->get_where('gamification_transaction', ['bank_type !=' => 'null', 'bank_number !=' => 'null'])->result_array();

        $mission = 0;
        $mission1 = $this->db->query("SELECT IF(COUNT(user_id) = 2, 1, 0) AS count FROM user_invoice_prakerja WHERE user_id = $userId")->row_array();
        $mission += $mission1['count'];
        $mission2 = $this->db->query("SELECT IF(COUNT(email) = 2, 1, 0) AS count FROM invoice_prakerja WHERE email = '$userEmail' AND partisipasi = 100.00")->row_array();
        $mission += $mission1['count'];
        $mission3 = $this->db->query("SELECT COUNT(user_id) AS count FROM user_mapel WHERE mapel_id = $mapelId AND user_id = $userId")->row_array();
        $mission += $mission1['count'];
        $mission4 = $this->db->query("SELECT COUNT(user_id) AS count FROM user_mapel_progress WHERE mapel_id = $mapelId AND user_id = $userId AND progress = 100.0")->row_array();
        $mission += $mission1['count'];
        $mission5 = $this->db->query("SELECT COUNT(user_id) AS count FROM rating WHERE mapel_id = $mapelId AND user_id = $userId")->row_array();
        $mission += $mission1['count'];
        $this->data['mission'] = $mission;

        $this->data['mapel'] = $this->db->get_where('mapel', ['id_mapel' => $mapelId])->row_array();

        $this->load->view("front-v2/profil/gamification/gamification", $this->data);
    }

}
