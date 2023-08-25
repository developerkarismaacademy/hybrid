<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 */
class TestimoniMapel extends CI_Controller
{
	private $data;

	public function __construct()
	{
		parent::__construct();
		$this->data['menu'] = "testimoniMapel";
		$this->FrontAuthModel->isLoggedInAdmin();
	}

	public function index()
	{
		$this->data['title'] = "Testimoni";
		$this->data['content'] = "testimoniMapel.list";
		$this->load->view('back/main', $this->data);

	}
}

?>
