<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Debug extends CI_Controller
{
	private $data;

	public function __construct()
	{
		parent::__construct();
		$this->data['menu'] = "Debug";
		$this->FrontAuthModel->isLoggedInAdmin();
	}

	public function index()
	{
		if ($this->db->dev) {
			$this->data['content'] = "debug";
			$this->data['link'] = $this->UniversalModel->getMetaLink("bab", "coba coba");

			$this->load->view('back/main', $this->data);
		} else {
			redirect(base_url("back"));
		}

	}


}


?>

