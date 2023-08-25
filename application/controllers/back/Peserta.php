<?php defined('BASEPATH') or exit('No direct script access allowed');

class Peserta extends CI_Controller
{

	private $data;

	public function __construct()
	{
		parent::__construct();
		$this->data['menu'] = "peserta";
		$this->load->model(['back/PesertaModel' => 'pm']);
		$this->FrontAuthModel->isLoggedInAdmin();
	}

	public function index()
	{
		$this->data['title'] = "Peserta";
		$this->data['content'] = "peserta.list";

		$this->data['peserta'] = $this->pm->getPeserta();
		$this->data['mapel'] = $this->pm->getMapel();

		if ($this->input->get('mapel') !== null) {
			$slug = $this->input->get('mapel');
			$this->data['peserta'] = $this->pm->getPeserta($slug);
		}

		$this->load->view('back/main', $this->data);
	}

	public function import()
	{
		$this->load->library('csvimport');
		$file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
		foreach ($file_data as $data) {
			$redeem_data = $this->db->get_where('redeem', ['redeem_code' => $data['﻿code_redeem']])->row_array();
			$userId = $redeem_data['user_id'];

			$this->db->where('id_user', $userId);
			$this->db->update('user', ['nama_user' => $data['name']]);
		}
		redirect('back/peserta');
	}
}
