<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Penukaran extends CI_Controller
{

  private $data;
  public function __construct()
  {
    parent::__construct();
    $this->data['menu'] = "penukaran";
    $this->FrontAuthModel->isLoggedInAdmin();
  }
  public function index()
  {
    $this->data['title'] = "Penukaran";
    $this->data['content'] = "penukaran.list";

    $this->load->view('back/main', $this->data);
  }

  public function getData()
  {
    $data = $this->db->get('log_gamification')->result_array();
    return $this->output
      ->set_content_type('application/json')
      ->set_status_header(200)
      ->set_output(json_encode($data));
  }
}

/* End of file Penukaran.php */
