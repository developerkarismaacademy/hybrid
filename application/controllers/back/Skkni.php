<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Skkni extends CI_Controller
{

    private $data;

    public function __construct()
    {
        parent::__construct();
        $this->data['menu'] = "skkni";
        $this->FrontAuthModel->isLoggedInAdmin();
    }
    public function index()
    {
        $this->data['title'] = "SKKNI";
        $this->data['content'] = "skkni.list";

        $this->data['skkni'] = $this->db->query("SELECT skkni.id,skkni.name,(SELECT COUNT(*) FROM unit_kompetensi WHERE skkni.id = unit_kompetensi.skkni_id) as unit_count FROM skkni ORDER BY skkni.name ASC ")->result_array();
        $this->load->view('back/main', $this->data);
    }
    public function tambah()
    {
        $this->form_validation->set_rules('name', 'Nama Skkni', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->data['title'] = "SKKNI - Tambah";
            $this->data['content'] = "skkni.tambah";
            $this->load->view('back/main', $this->data);
        } else {
            $name = $this->input->post('name');
            $data = [
                'name' => $name
            ];
            $this->db->insert('skkni', $data);
            $this->session->set_flashdata('message', 'Data inserted successfully.');
            redirect('back/skkni');
        }
    }
    public function ubah($id)
    {
        $this->data['skkni'] = $this->db->get_where('skkni', ['id' => $id])->row_array();
        $this->form_validation->set_rules('name', 'Nama SKKNI', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->data['title'] = "SKKNI - Ubah";
            $this->data['content'] = "skkni.ubah";
            $this->load->view('back/main', $this->data);
        } else {
            $name = $this->input->post('name');
            $data = [
                'name' => $name
            ];
            $this->db->where('id', $id);
            $this->db->update('skkni', $data);

            redirect('back/skkni');
        }
    }
    public function hapus($id)
    {
        $this->db->delete('skkni', ['id' => $id]);
        redirect('back/skkni');
    }
}

/* End of file Skkni.php */
