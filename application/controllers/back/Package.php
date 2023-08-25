<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Package extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['menu'] = "paket";
        $this->FrontAuthModel->isLoggedInAdmin();
    }

    public function index($meta = null)
    {

        $this->data['title'] = "Paket";

        $this->data['content'] = "package.list";

        $materi = $this->db->get_where('materi', ['meta_link_materi' => $meta])->row_array();
        if ($materi) {
            $this->db->select('paket');
            $this->db->group_by('paket');
            $materi_id = $materi['id_materi'];
            $this->data['package_materi'] = $this->db->get_where('soal', ['materi_id' => $materi_id])->result_array();

            $bab = $this->db->get_where('bab', ['id_bab' => $materi['bab_id']])->row_array();
            $this->data['meta_link_bab'] = $bab['meta_link_bab'];
            $this->data['meta_link_materi'] = $meta;

            $this->data['package'] = $this->db->query("SELECT package.id,package, (SELECT COUNT(*) FROM soal WHERE soal.paket = package.id and materi_id = $materi_id) AS package_count FROM package")->result_array();
            $this->load->view('back/main', $this->data);
        } else {
            redirect(base_url('back/not-found'));
        }
    }

    public function soal($meta = null, $paket = null)
    {
        $this->data['title'] = 'Paket ' . $paket;
        $this->data['content'] = 'package.soal.list';

        $materi = $this->db->get_where('materi', ['meta_link_materi' => $meta])->row_array();

        if ($materi) {
            $this->db->join('jawaban', 'soal.id_soal = jawaban.soal_id');
            $soal = $this->db->get_where('soal', ['materi_id' => $materi['id_materi'], 'paket' => $paket])->result_array();
            $this->data['meta_link_bab'] = $meta;
            $this->data['soal'] = $soal;
            $this->load->view('back/main', $this->data);
        } else {
            echo 'materi kosong';
        }
    }
}
