<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Model_voucher extends CI_Model
{

    private $table = 'voucher_prakerja';
    public function rules()
    {
        return [
            [
                'field' => 'kode_voucher',
                'label' => 'Kode Voucher',
                'rules' => 'trim|required|is_unique[voucher_prakerja.kode_voucher]'
            ],
            [
                'field' => 'mapel_id',
                'label' => 'Mapel',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'qty',
                'label' => 'Jumlah',
                'rules' => 'trim|required'
            ]
        ];
    }

    public function getAll()
    {
        $this->db->select('id_voucher,kode_voucher,nama_mapel,voucher_prakerja.status,count(kode_voucher) as total,mapel_id');
        $this->db->from($this->table);
        $this->db->join('mapel', 'voucher_prakerja.mapel_id = mapel.id_mapel');
        $this->db->order_by("kode_voucher", "DESC");
        $this->db->group_by('mapel_id');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getAllByMapel($id_mapel = '')
    {
        $this->db->select('id_voucher,kode_voucher,nama_mapel,voucher_prakerja.status,mapel_id');
        $this->db->from($this->table);
        $this->db->join('mapel', 'voucher_prakerja.mapel_id = mapel.id_mapel');
        $this->db->order_by("kode_voucher", "ASC");
        $this->db->where('mapel_id', $id_mapel);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function save()
    {
        $kode               = $this->input->post('kode_voucher');
        $totalkode       = strlen($this->input->post('kode_voucher'));
        $totalmapel   = strlen($this->input->post('mapel_id'));
        $mapel_id         = $this->input->post('mapel_id');
        $like_kode         = $kode . $mapel_id;
        $voucher           = $this->db->query("SELECT kode_voucher FROM `voucher_prakerja` WHERE kode_voucher LIKE '%$like_kode%'")->row_array();
        $uniqVoucher  = (int) substr($voucher['kode_voucher'], $totalkode + $totalmapel, 6);
        $uniqVoucher++;

        $kode               = $this->input->post('kode_voucher') . $this->input->post('mapel_id') . sprintf("%06s", $uniqVoucher);
        $data               = array(

            "kode_voucher"  => $kode,
            "mapel_id"      => $this->input->post('mapel_id'),

        );

        return $this->db->insert($this->table, $data);
    }
}

/* End of file Model_coupon.php */
