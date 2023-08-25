<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Karisma
 * Date: 23/09/2019
 * Time: 10:50
 */
class TransaksiPrakerja extends CI_Controller
{

	private $data;

	public function __construct()
	{
		parent::__construct();
		$this->data['menu'] = "transaksi-prakerja";
		$this->load->library('csvimport');
		$this->FrontAuthModel->isLoggedInAdmin();
	}

	public function index()
	{
		$this->data['title'] = "Transaksi Prakerja";
		$this->data['content'] = "transaksi-prakerja.list";

		$this->data['mapel'] = $this->db->query("SELECT t1.*, t2.total FROM `mapel` t1 LEFT JOIN (SELECT mapel_id, COUNT(*) as total FROM user_mapel GROUP BY mapel_id) t2 ON t1.id_mapel = t2.mapel_id WHERE t1.prakerja = 1")->result_array();

		$this->load->view('back/main', $this->data);
	}

	public function list($metaLink)
	{
		$this->data['title'] = "List Transaksi";
		$this->data['content'] = "transaksi-prakerja.list-transaksi";

		$this->load->view('back/main', $this->data);
	}
}
