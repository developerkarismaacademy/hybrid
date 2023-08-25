<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Transfer extends CI_Controller
{


  private $data;

  public function __construct()
  {
    parent::__construct();
    $this->data['menu'] = "transfer";
    $this->FrontAuthModel->isLoggedInAdmin();
  }
  public function index()
  {
    $this->data['title'] = "Data Transfer";
    $this->data['content'] = "transfer.list";

    $this->db->select('user.nama_user,user.id_user,log_gamification.*');
    $this->db->join('user', 'user.id_user = log_gamification.user_id');
    $this->db->order_by('status', 'asc');
    $this->db->order_by('log_gamification.created_at', 'desc');
    $this->data['log_gamification'] = $this->db->get('log_gamification')->result_array();
    $this->load->view('back/main', $this->data);
  }

  public function edit($id)
  {
    $this->form_validation->set_rules('status', 'Status', 'trim|required');

    if ($this->form_validation->run() == FALSE) {

    } else {
      $this->db->where('id', $id);
      $this->db->update('log_gamification', ['status' => $this->input->post('status')]);
      redirect('back/transfer', 'refresh');

    }

    $this->data['title'] = "Edit Data Transfer";
    $this->data['content'] = "transfer.edit";

    $this->db->select('user.nama_user,user.id_user,log_gamification.*');
    $this->db->join('user', 'user.id_user = log_gamification.user_id');
    $this->data['log_gamification'] = $this->db->get_where('log_gamification', ['id' => $id])->row_array();
    $this->load->view('back/main', $this->data);
  }
// public function getData()
// {
//   $query = $this->db->get('log_gamification');
//   if ($query->num_rows() > 0) {
//     $code = 200;
//     $data['message'] = 'Data berhasil di dapatkan !';
//     $data['success'] = true;
//     $data['status_code'] = $code;
//     $data['data'] = $query->result_array();
//   } else {
//     $code = 400;
//     $data['message'] = "Data gagal di dapatkan !";
//     $data['success'] = false;
//     $data['status_code'] = $code;
//     $data['data'] = '';
//   }
//   return $this->output
//     ->set_content_type('application/json')
//     ->set_status_header(200)
//     ->set_output(json_encode($data));
// }
}

/* End of file Invoice.php */