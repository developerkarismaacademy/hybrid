<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuthModel extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function garem()
	{
		return "itsKarismaOnline";
	}

	public function login($useremail, $password, $level)
	{
		$query = $this->db->select("*")
			->from("user")
			->group_start()
			->where("username", "{$useremail}")
			->or_where("email_user", "{$useremail}")
			->group_end()
			->where("password", $password)
			->where("level_user", $level)
			->get()
			->result_array();

		return ([
			"data"  => count($query) >= 1 ? $query[0] : [],
			"total" => count($query),
		]);
	}

	public function getUserLoggedIn()
	{
		$query = $this->db->select("*")
			->from("user")
			->where("id_user", $_SESSION['siswaData']['id_user'])
			->get()
			->result_array();

		return ([
			"data"  => count($query) >= 1 ? $query[0] : [],
			"total" => count($query),
		]);
	}

	public function cariUsernamev2($username)
	{
		$query = $this->db->select("*")
			->from("user")
			->where("username", $username)
			->get()
			->result_array();

		return ([
			"data"  => count($query) >= 1 ? $query[0] : [],
			"total" => count($query),
		]);
	}

	public function cariEmailv2($email)
	{
		$query = $this->db->select("*")
			->from("user")
			->where("email", $email)
			->get()
			->result_array();

		return ([
			"data"  => count($query) >= 1 ? $query[0] : [],
			"total" => count($query),
		]);
	}

	public function cariUsername($useremail, $level)
	{

		$query = $this->db->select("*")
			->from("user")
			->group_start()
			->where("username", "{$useremail}")
			->or_where("email_user", "{$useremail}")
			->group_end()
			->where("level_user", $level)
			->get()
			->result_array();

		return ([
			"data"  => count($query) >= 1 ? $query[0] : [],
			"total" => count($query),
		]);

	}

	public function getLogin($get)
	{
		$this->db->select("*");
		$this->db->from("user");
		$this->db->where("(username = '" . $get['username'] . "' OR email_user = '" . $get['username'] . "')");
		$this->db->where('password', $get['password']);
		$this->db->where('level_user', $get['level_user']);
		$query = $this->db->get();
		$data = $query->row();

		return $data;
	}

	public function getLoginWithoutLevel($get)
	{
		$this->db->select("*");
		$this->db->from("user");
		$this->db->where("(username = '" . $get['username'] . "' OR email_user = '" . $get['username'] . "')");
		$this->db->where('password', $get['password']);
		$query = $this->db->get();
		$data = $query->row();

		return $data;
	}

	public function isNotLoggedIn()
	{
		if ($this->session->siswaData != NULL) {
			alert("danger", "Aksed Di Tolak", "Anda Sudah Login");
			redirect(base_url() . "profil");
		}
	}

	public function isLoggedIn($page = 'login')
	{
		if ($this->session->siswaData == NULL) {
			if ($page != 'login') {
				alert("warning", "Hanya untuk murid terdaftar", "Silahkan daftar terlebih dahulu untuk menerima layanan pretest");
			}
			redirect(base_url() . $page);
		}
	}

	public function isLoggedInAdmin()
	{
		if ($this->session->backData == NULL) {
			redirect(base_url() . "back/login");
		}
	}


	public function isNotLoggedInAdmin()
	{
		if ($this->session->backData != NULL) {
			alert("danger", "Aksed Di Tolak", "Anda Sudah Login");
			redirect(base_url() . "profil");
		}
	}

	public function getMapelUser()
	{
		$dataMapel = $this->db
			->select("*")
			->from("user_mapel")
			->where("user_id", $_SESSION['siswaData']['id_user'])
			->get()
			->result_array();

		if (count($dataMapel) > 0) {
			$dataId = [];
			foreach ($dataMapel as $keyMapel => $valueMapel) {
				$dataId[] = $valueMapel["mapel_id"];
			}

			$_SESSION["idMapelBeli"] = $dataId;

			return $dataId;
		} else {
			return [];
		}
	}

	public function getMapelBeliUser()
	{
		$query = $this->db
			->select("detail_transaksi.*,
					  transaksi.status as status_pembelian,
					  mapel.nama_mapel,
					  mapel.banner_mapel,
					  kelas.nama_kelas")
			->from("detail_transaksi")
			->join("transaksi", "id_transaksi = transaksi_id")
			->join("mapel", "id_mapel = mapel_id")
			->join("kelas", "id_kelas = kelas_id");


		$query = $query->get()
			->result_array();

		if (count($query) > 0) {
			$dataMapel = [];

			foreach ($query as $keyQuery => $valueQuery) {
				if ($valueQuery["status_pembelian"] == 0) {
					$dataMapel["konfirmasi"][] = $valueQuery["mapel_id"];
				} elseif ($valueQuery["status_pembelian"] == 1) {
					$dataMapel["konfirmasi"][] = $valueQuery["mapel_id"];
				}
			}

			return $dataMapel;
		} else {
			return [];
		}
	}

}
