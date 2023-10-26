<?php
class Dashboard extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('instruktur')){
            redirect('back-v2/login');
        }
    }

    public function index()
	{
		return $this->t->load('back-v2/app', 'back-v2/test');
	}
}
