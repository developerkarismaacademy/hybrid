<?php
class Dashboard extends CI_Controller {
	public function index()
	{
		return $this->t->load('back-v2/app', 'back-v2/test');
	}
}
