<?php


defined('BASEPATH') or exit('No direct script access allowed');

class MapelUnitKompetensi extends CI_Controller
{
  private $data;
  public function __construct()
  {
    parent::__construct();
    $this->data['menu'] = "mapel unit kompetensi";
    $this->FrontAuthModel->isLoggedInAdmin();
  }
  public function list($meta = '')
  {
    $this->db->join('kelas', 'mapel.kelas_id = kelas.id_kelas');
    $mapel = $this->db->get_where('mapel', ['meta_link_mapel' => $meta])->row_array();
    $this->data['unit_kompetensi'] = $this->db->get('unit_kompetensi')->result_array();
    $this->db->join('unit_kompetensi', 'unit_kompetensi.id = mapel_unit_kompetensi.unit_kompetensi_id');
    $this->data['mapel_unit_kompetensi'] = $this->db->get_where('mapel_unit_kompetensi', ['mapel_id' => $mapel['id_mapel']])->result_array();

    $this->data['meta_link'] = $meta;
    $this->data['meta'] = $mapel['meta_link_kelas'];
    $this->data['title'] = "Mapel Unit Kompetensi";
    $this->data['content'] = "mapel_unit_kompetensi.list";

    $this->load->view('back/main', $this->data);
  }
  public function tambah($meta = '')
  {
    $mapel = $this->data['mapel'] = $this->db->get_where('mapel', ['meta_link_mapel' => $meta])->row_array();
    $this->data['unit_kompetensi'] = $this->db->get('unit_kompetensi')->result_array();

    $this->form_validation->set_rules('unit[]', 'Unit Kompetensi', 'required');
    if ($this->form_validation->run() == FALSE) {
      $this->data['unit_kompetensi'] = $this->db->get('unit_kompetensi')->result_array();
      $this->data['title'] = "Mapel Unit Kompetensi";
      $this->data['content'] = "mapel_unit_kompetensi.tambah";
      $this->data['meta_link'] = $meta;
      $this->load->view('back/main', $this->data);
    } else {
      $unit = $this->input->post('unit');
      for ($i = 0; $i < count($unit); $i++) {
        $input[] = [
          'mapel_id' => $mapel['id_mapel'],
          'unit_kompetensi_id' => $unit[$i]
        ];
      }
      $this->db->insert_batch('mapel_unit_kompetensi', $input);
      redirect(base_url('back/mapelunitkompetensi/list/' . $meta));
    }
  }
  public function hapus($meta = '', $mapel_id, $unit_id)
  {
    $this->db->delete('mapel_unit_kompetensi', ['mapel_id' => $mapel_id, 'unit_kompetensi_id' => $unit_id]);
    redirect(base_url('back/mapelunitkompetensi/list/' . $meta));
  }
}

/* End of file MapelUnitKompetensi.php */
