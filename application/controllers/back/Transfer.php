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

        $this->data['transfers'] = $this->db->query("SELECT t3.nama_mapel, t1.id,t2.nama_user, t2.email_user, t1.bank_number, t1.bank_type, t1.`status`, t1.created_at FROM gamification_transaction t1 JOIN `user` t2 ON t1.user_id = t2.id_user JOIN mapel t3 ON t1.mapel_id = t3.id_mapel")->result_array();
        $this->load->view('back/main', $this->data);
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('status', 'Status', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->data['title'] = "Edit Data Transfer";
            $this->data['content'] = "transfer.edit";

            $transferData = $this->db->query("SELECT t1.id, t2.id_user ,t2.nama_user, t2.email_user, t1.bank_number, t1.bank_type, t1.`status`, t1.created_at FROM gamification_transaction t1 JOIN `user` t2 ON t1.user_id = t2.id_user WHERE t1.id = $id;")->row_array();
			$this->data['transfer'] = $transferData;

			$emailUser = $transferData['email_user'];

			$this->db->select('invoice_prakerja.invoice, user.nama_user, user_invoice_prakerja.coin, user_invoice_prakerja.status, mapel.nama_mapel');
			$this->db->join('user_invoice_prakerja', 'user_invoice_prakerja.user_id = user.id_user');
			$this->db->join('invoice_prakerja', 'invoice_prakerja.id = user_invoice_prakerja.invoice_prakerja_id');
			$this->db->join('mapel', 'mapel.id_mapel = invoice_prakerja.mapel_id');
			$this->db->where('email_user', $emailUser);
			$invoice = $this->db->get('user')->result_array();
			$this->data['invoice'] = $invoice;
			
            $this->load->view('back/main', $this->data);
        } else {
            $this->db->where('id', $id);
            $this->db->update('gamification_transaction', ['status' => $this->input->post('status')]);
            redirect('back/transfer', 'refresh');

        }
    }

}

/* End of file Invoice.php */
