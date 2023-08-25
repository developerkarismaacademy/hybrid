<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Invoice extends CI_Controller
{


  private $data;

  public function __construct()
  {
    parent::__construct();
    $this->data['menu'] = "invoice";
    $this->load->library('csvimport');
    $this->FrontAuthModel->isLoggedInAdmin();
  }
  public function index()
  {
    $this->data['title'] = "Data Invoice";
    $this->data['content'] = "invoice.list";

    $this->load->view('back/main', $this->data);
  }
  public function tambah()
  {
    $invoice = $this->input->post('inv');
    $explode = explode("\n", $invoice);
    $data = [];
    $index = 0;
    foreach ($explode as $exp) {
      if ($exp == '') {
        $code = 500;
        $data[$index]['message'] = "[Baris " . ($index + 1) . "] Inputan tidak valid !";
        $data[$index]['success'] = false;
        $data[$index]['status_code'] = $code;
      } else {
        $this->db->where('invoice', $exp);
        $query = $this->db->get('invoice_prakerja');
        if ($query->num_rows() > 0) {
          // Record exists
          $code = 422;
          $data[$index]['message'] = "[$exp] Data sudah pernah di input !";
          $data[$index]['success'] = false;
          $data[$index]['status_code'] = $code;
        } else {
          // Record does not exist
          $code = 200;
          $input = array(
            'invoice' => $exp
          );
          $query = $this->db->insert('invoice_prakerja', $input);
          $data[$index]['message'] = "[$exp] Data berhasil di input !";
          $data[$index]['success'] = true;
          $data[$index]['status_code'] = $code;
          $data[$index]['data'] = $exp;
        }
      }
      $index++;
    }
    return $this->output
      ->set_content_type('application/json')
      ->set_status_header(200)
      ->set_output(json_encode($data));
  }
  public function getData()
  {
    $query = $this->db->get('invoice_prakerja');
    if ($query->num_rows() > 0) {
      $code = 200;
      $data['message'] = 'Data berhasil di dapatkan !';
      $data['success'] = true;
      $data['status_code'] = $code;
      $data['data'] = $query->result_array();
    } else {
      $code = 400;
      $data['message'] = "Data gagal di dapatkan !";
      $data['success'] = false;
      $data['status_code'] = $code;
      $data['data'] = '';
    }
    return $this->output
      ->set_content_type('application/json')
      ->set_status_header(200)
      ->set_output(json_encode($data));
  }
  public function import()
  {
    $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);

    $index = 0;
    foreach ($file_data as $fd) {
      $this->db->where('invoice', $fd['No. Invoice']);
      $exist = $this->db->get('invoice_prakerja');
      if (!$exist->num_rows() > 0) {
		  $input = [
			  'invoice' => $fd['No. Invoice'],
			  'email' => $fd['Email'],
			  'no_ponsel' => $fd['No.Ponsel'],
			  'partisipasi' => $fd['Partisipasi'],
			  'pembelian' => $fd['Pembelian'],
			  'mapel_id' => $this->input->post('mapel_id')
		  ];
		  $this->db->insert('invoice_prakerja', $input);
		  $code = 201;
		  $data[$index]['message'] = $fd['No. Invoice'] . " Data berhasil di input !";
		  $data[$index]['success'] = true;
		  $data[$index]['status_code'] = $code;
		  $data[$index]['data'] = $fd;
	  } else {
		  $code = 422;
		  $data[$index]['message'] = $fd['No. Invoice'] . " Data sudah pernah di input !";
		  $data[$index]['success'] = false;
		  $data[$index]['status_code'] = $code;
		  $this->db->set('partisipasi', $fd['Partisipasi']);
		  $this->db->where('invoice', $fd['No. Invoice']);
		  $this->db->update('invoice_prakerja');
		  $data[$index]['data'] = $exist->result_array();
	  }
      $index++;
    }
//    return $this->output
//      ->set_content_type('application/json')
//      ->set_status_header(200)
//      ->set_output(json_encode($data));
  }
  public function v_import()
  {
    $this->data['title'] = "Data Invoice";
    $this->data['content'] = "invoice.import";
    $this->data['mapel'] = $this->db->get('mapel')->result();
    $this->load->view('back/main', $this->data);
  }
  public function hapus($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('invoice_prakerja');
    redirect('back/invoice');
  }
}

/* End of file Invoice.php */
