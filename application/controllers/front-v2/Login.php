<?php
defined('BASEPATH') or exit('No direct script access allowed');
require("vendor/autoload.php");

use google\apiclient;


class Login extends CI_Controller
{
	private $data;

	public function __construct()
	{
		parent::__construct();

		$this->data['page'] = "login";
	}

	public function index()
	{
		$this->data['title'] = "Login";
		$this->data['content'] = "login";

		$this->load->view("front-v2/main", $this->data);
	}


	public function registerform()
	{
		$this->data['title'] = "LoginPage";
		$this->data['content'] = "form";

		$this->load->view("front-v2/main", $this->data);
	}

	public function submit()
	{

		$this->data = [
			"username" => $_POST['username_login'] ?? "",
			"password" => $_POST["password_login"] ?? ""
		];

		$this->form_validation->set_rules('username_login', 'Username', 'required');
		$this->form_validation->set_rules('password_login', 'Password', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->data["username"] = $_POST['username_login'];
			$this->data["loginPage"] = "show active";
			$this->index();
		} else {
			$data["password"] = crypt(crypt($this->data["password"], garem), garem);

			$login = $this->FrontAuthModel->login($this->data["username"], $data["password"], "siswa");

			if ($login["total"] > 0) {
				unset($_SESSION["raporIdUser"]);

				$user = $login["data"];
				$user["nama_depan"] = explode(" ", $user["nama_user"])[0];

				$this->session->set_userdata(['siswaData' => $user]);

				$_SESSION["idMapelBeli"] = $this->FrontAuthModel->getMapelUser();

				redirect(base_url("profil"));
			} else {
				alert("warning", "Data Tidak Di Temukan", "Password Tidak Cocok");

				$this->data["username"] = $_POST['username_login'];
				$this->data["loginPage"] = "show active";
				$this->index();
			}
		}
	}

    public function lupa()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        if ($this->form_validation->run() == false) {
            $this->data['title'] = "Lupa password";
            $this->data['content'] = "login.lupa";
            $this->load->view("front-v2/main", $this->data);
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email_user' => $email])->row_array();

            if ($user) {
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token
                ];

                $this->db->insert('user_token', $user_token);
                $this->_sendEmail($token);
                alert('success', 'Berhasil', 'Silahkan cek email untuk melakukan reset password');
                redirect(base_url('login/lupa'));
            } else {
                alert('warning', 'Data tidak ditemukan', 'Email tidak terdaftar');
                redirect(base_url('login/lupa'));
            }
        }

    }

    public function resetpassword()
    {
        $email = $this->input->get('email');
        $user = $this->db->get_where('user', ['email_user' => $email])->row_array();

        if ($user) {
            $token = $this->input->get('token');
            $user_token = $this->db->get_where('user_token', ['token' => $token, 'email' => $email])->row_array();

            if ($user_token) {
                $this->session->set_userdata('reset_email', $email);
                $this->reset();
            } else {
                alert('danger', 'Data tidak ditemukan', 'Token tidak valid!');
                redirect(base_url('login'));
            }
        } else {
            alert('danger', 'Data tidak ditemukan', 'Email tidak terdaftar');
            redirect(base_url('login'));
        }
    }


    public function reset()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect(base_url('login'));
        }

        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|matches[confirm_password]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|min_length[8]|matches[password]');

        if ($this->form_validation->run() == false) {
            $this->data['title'] = "Reset password";
            $this->data['content'] = "login.resetpassword";
            $this->load->view("front-v2/main", $this->data);
        } else {
            $email = $this->session->userdata('reset_email');
            $password = crypt(crypt($this->input->post('password'), garem), garem);

            $this->db->set('password', $password);
            $this->db->where('email_user', $email);
            $this->db->update('user');

            $this->session->unset_userdata('reset_email');

            $this->db->delete('user_token', ['email' => $email]);

            alert('success', 'Reset Berhasil', 'Password berhasil direset silahkan login kembali');
            redirect(base_url('login'));
        }
    }

    public function _sendEmail($token)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'mail.karismaacademy.com',
            'smtp_user' => 'bariqfirjatullah1803@karismaacademy.com',
            'smtp_pass' => 'aku089619',
            'smtp_port' => 587,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];

        $this->email->initialize($config);

        $this->email->from('bariqfirjatullah1803@karismaacademy.com', 'Reset Password');
        $this->email->to($this->input->post('email'));

        $this->email->subject('Reset Password');
        $this->email->message('Silahkan click link ini untuk melakukan reset password : <a href="' . base_url() . 'login/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');

        if ($this->email->send()) {
            return true;
        } else {
            // echo $this->email->print_debugger();
            // die;
            alert('danger', 'Gagal Lupa Passsword', 'Harap menghubungi admin untuk lupa password');
            redirect(base_url('login'));
        }
    }

	public function daftar()
	{

		$data = [
			"nama_user"     => $_POST["nama_user"] ?? "",
			"username"      => $_POST["username"] ?? "",
			"email_user"    => $_POST["email_user"] ?? "",
			"telepon_user"  => $_POST["telepon_user"] ?? "",
			"password"      => $_POST["password"] ?? "",
			"jk_user"       => $_POST["jk_user"] ?? "Laki-laki",
			"tempat_lahir"  => $_POST["tempat_lahir"] ?? "-",
			"tanggal_lahir" => $_POST["tanggal_lahir"] ?? date("Y-m-d H:i:s", strtotime('-5 year', strtotime(date("Y-m-d H:i:s")))),
			"created_at"    => date("Y-m-d H:i:s"),
		];

		$this->form_validation->set_rules('nama_user', 'Nama Lengkap', 'required');
		$this->form_validation->set_rules('jk_user', 'Jenis Kelamin', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]');
		$this->form_validation->set_rules('email_user', 'Email', 'required|valid_email|is_unique[user.email_user]');
		$this->form_validation->set_rules('telepon_user', 'No. Handphone', 'required|numeric');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'required|matches[password]');
		$this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
		$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->data = array_merge($this->data, $data);
			$this->data["loginPage"] = "";
			$this->data["signupPage"] = "show active";
			$this->index();
		} else {
			$data["password"] = crypt(crypt($data["password"], garem), garem);
			$data["gambar_user"] = "default.png";
			$data["level_user"] = "siswa";
			$data["alamat_user"] = "-";

			$daftar = $this->UniversalModel->insert("user", $data);

			if ($daftar["success"]) {
				$cariUsername = $this->FrontAuthModel->cariUsername($_POST["username"], "siswa");
				if ($cariUsername["total"] > 0) {
					$login = $this->FrontAuthModel->login($data["username"], $data["password"], "siswa");

					if ($login["total"] > 0) {
						$user = $login["data"];

						$gender = ($user['jk_user'] == 'Laki-laki') ? 'male' : 'female';
						$dateBrith = ($data['tanggal_lahir'] == '0000-00-00') ? date('Y-m-d') : $data['tanggal_lahir'];
						$newUserInput = [
							'id' => $user['id_user'],
							'username' => $user['username'],
							'name' => $user['nama_user'],
							'gender' => $gender,
							'address' => $user['alamat_user'],
							'brith_date' => $dateBrith,
							'city' => $user['tempat_lahir'],
							'phone' => $user['telepon_user'],
							'email' => $user['email_user'],
							'image' => $user['gambar_user'],
							'password' => password_hash('123456',PASSWORD_DEFAULT)
						];
						$this->db->insert('users',$newUserInput);

						$modelHasRolesInput = [
							'role_id' => 3,
							'model_type' => 'App\Models\User',
							'model_id' => $this->db->insert_id()
						];
						$this->db->insert('model_has_roles',$modelHasRolesInput);

						$user["nama_depan"] = explode(" ", $user["nama_user"])[0];
						$this->session->set_userdata(['siswaData' => $user]);

						$_SESSION["idMapelBeli"] = $this->FrontAuthModel->getMapelUser();
						alert("success", "Login Berhasil", "Anda berhasil memiliki akses ke akun anda");


						redirect(base_url("profil"));
					} else {
						alert("warning", "Data Tidak Di Temukan", "Password Tidak Cocok");

						$this->data["username"] = $_POST["username"];
						$this->data["loginPage"] = "show active";
						$this->index();
					}

				} else {
					alert("warning", "Data Tidak Di Temukan", "Data Dengan Username <strong>{$_POST["username"]}</strong> Tidak Di Temukan");
					$this->data["username"] = $_POST["username"];
					$this->data["loginPage"] = "show active";
					$this->index();
				}
			} else {
				alert("danger", "Kesalahan Server", "Pendaftaran Tidak Berhasil");

				$this->data = array_merge($this->data, $data);
				$this->data["loginPage"] = "";
				$this->data["signupPage"] = "show active";
				$this->index();
			}

		}

	}

	public function gsignin()
	{
		$id_token = $this->input->post("idtoken");
		$CLIENT_ID = "128649138906-sjpv7krn52d6b2qrs9h4b2qpddns3nle.apps.googleusercontent.com";
		$client = new Google_Client(['client_id' => $CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
		$payload = $client->verifyIdToken($id_token);
		if ($payload) {
			$userid = $payload['sub'];
			$email = $payload['email'];

			$userData = $this->BasicModel->getData("user",
				[
					"token_gg"   => crypt(crypt($userid, garem), garem),
					"email_user" => $email
				]
			);
			if (!empty($userData)) {
				$sessionData = [
					"id"        => $userData->id_user,
					"logged_as" => $userData->level_user,
				];
				$this->session->set_userdata(['siswaData' => $sessionData]);

				$_SESSION["idMapelBeli"] = $this->FrontAuthModel->getMapelUser();
				echo base_url();
			} else {
				alert_error("Tidak terdaftar", "Silahkan daftarkan diri anda");
				$this->data["signupPage"] = "show active";
				echo base_url("login");
			}
		} else {
			alert_error("Tidak terdaftar", "Silahkan daftarkan diri anda");
			$this->data["signupPage"] = "show active";
			echo base_url("login");
		}
	}
}
