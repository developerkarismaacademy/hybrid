<?php

defined('BASEPATH') or exit('No direct script access allowed');

class UnitKompetensi extends CI_Controller
{
    private $data;
    private $id;
    public function __construct()
    {
        parent::__construct();
        $this->id = $this->data['id'] = $this->uri->segment(4);
        $this->data['menu'] = "unit kompetensi";
        $this->FrontAuthModel->isLoggedInAdmin();
    }
    public function list($id = '')
    {
        $cek = $this->db->get_where('skkni', ['id' => $id])->row_array();
        if (!$cek) {
            redirect('back/skkni');
        }
        $this->data['title'] = "Unit Kompetensi";
        $this->data['content'] = "unit_kompetensi.list";
        $this->data['unit_kompetensi'] = $this->db->get_where('unit_kompetensi', ['skkni_id' => $id])->result_array();
        $this->load->view('back/main', $this->data);
    }

    public function tambah($id = '')
    {
        $cek = $this->db->get_where('skkni', ['id' => $id])->row_array();
        if (!$cek) {
            redirect('back/skkni');
        }
        $this->form_validation->set_rules('kode_unit', 'Kode Unit', 'required');
        $this->form_validation->set_rules('judul_unit', 'Judul Unit', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->data['title'] = "Unit Kompetensi - Tambah";
            $this->data['content'] = "unit_kompetensi.tambah";
            $this->load->view('back/main', $this->data);
        } else {
            $kode_unit = $this->input->post('kode_unit');
            $judul_unit = $this->input->post('judul_unit');
            $data = [
                'kode_unit' => $kode_unit,
                'judul_unit' => $judul_unit,
                'skkni_id' => $id
            ];
            $this->db->insert('unit_kompetensi', $data);
            $this->session->set_flashdata('message', 'Data inserted successfully.');
            redirect(base_url('back/unitkompetensi/list/' . $id));
        }
    }
    public function ubah($skkni_id = '', $id = '')
    {
        $this->data['unit_kompetensi'] = $this->db->get_where('unit_kompetensi', ['id' => $id])->row_array();
        $this->form_validation->set_rules('kode_unit', 'Kode Unit', 'required');
        $this->form_validation->set_rules('judul_unit', 'Judul Unit', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->data['title'] = "Unit Kompetensi - Ubah";
            $this->data['content'] = "unit_kompetensi.ubah";
            $this->load->view('back/main', $this->data);
        } else {
            $name = $this->input->post('name');
            $kode_unit = $this->input->post('kode_unit');
            $judul_unit = $this->input->post('judul_unit');
            $data = [
                'kode_unit' => $kode_unit,
                'judul_unit' => $judul_unit,
            ];
            $this->db->where('id', $id);
            $this->db->update('unit_kompetensi', $data);

            redirect(base_url('back/unitkompetensi/list/' . $skkni_id));
        }
    }
    public function hapus($skkni_id = '', $id = '')
    {
        $this->db->delete('unit_kompetensi', ['id' => $id]);
        redirect(base_url('back/unitkompetensi/list/' . $skkni_id));
    }
}

/* End of file UnitKompetensi.php */
