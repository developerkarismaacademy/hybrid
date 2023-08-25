<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Voucher extends CI_Controller
{
    private $data;
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['back/Model_voucher' => 'mv']);
        $this->data['menu'] = "voucher";
        $this->FrontAuthModel->isLoggedInAdmin();
    }

    public function index()
    {
        $this->data['title'] = "Voucher";

        $this->data['content'] = "voucher-v2.voucher";
        $this->data['voucher'] = $this->mv->getAll();
        $this->load->view('back/main', $this->data);
    }

    public function detail($mapel_id = '')
    {
        $this->data['title'] = "Data Voucher";

        $this->data['content'] = "voucher-v2.list-voucher-mapel";
        $this->data['voucher'] = $this->mv->getAllByMapel($mapel_id);
        $this->load->view('back/main', $this->data);
    }

    public function save()
    {
        $this->data['title'] = "Tambah Voucher";

        $this->data['content'] = "voucher-v2.form";

        $validation = $this->form_validation;
        $validation->set_rules($this->mv->rules());

        if ($this->form_validation->run() == false) {
            $this->data['mapel'] = $this->db->get_where('mapel', ['prakerja' => 1])->result();


            $this->load->view('back/main', $this->data);
        } else {
            $qty = $this->input->post('qty');
            $kode = $this->input->post('kode_voucher');
            $mapel_id = $this->input->post('mapel_id');
            for ($i = 0; $i < $qty; $i++) {
                $voucher = randomVoucher(10, 'voucher_prakerja', 'kode_voucher', $kode);
                $data = [
                    "kode_voucher" => $voucher,
                    "mapel_id" => $mapel_id,
					"live_access" => 0
                ];
                $this->db->insert('voucher_prakerja', $data);
            }

            return redirect('back/voucher');
        }
    }
    public function delete($mapel_id = '', $voucher_id = '')
    {
        $this->db->where('id_voucher', $voucher_id);
        $this->db->delete('voucher_prakerja');
        if (count($this->mv->getAllByMapel($mapel_id)) > 0) {
            return redirect('back/voucher/detail/' . $mapel_id);
        } else {
            return redirect('back/voucher');
        }
    }
}
