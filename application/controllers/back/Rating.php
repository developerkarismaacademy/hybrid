<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Rating extends CI_Controller
{
	private $data;

	public function __construct()
	{
		parent::__construct();

		$this->load->model('back/SiswaModel', 'BackSiswaModel', true);
		$this->load->model('back/MapelModel', 'BackMapelModel', true);
		$this->data['menu'] = "rating";
		$this->FrontAuthModel->isLoggedInAdmin();
	}

	public function index()
	{
		$this->data['title'] = "Rating Generator";
		$this->data['content'] = "rating.generator";

		$this->data["user"] = $this->BackSiswaModel->getAll();
		$this->data["mapel"] = $this->BackMapelModel->getAll();

		$this->load->view('back/rating/generator/generator', $this->data);
	}

	public function generatorcsv()
	{
		$this->data['content'] = "rating.generatorcsv";

		$this->load->view('back/main', $this->data);
	}
}
