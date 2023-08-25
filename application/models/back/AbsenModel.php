<?php


defined('BASEPATH') or exit('No direct script access allowed');

class AbsenModel extends CI_Model
{
    public function rules()
    {
        return [
            [
                'field' => 'kode_absen',
                'label' => 'Kode Absen',
                'rules' => 'trim|required|is_unique[absen.kode_absen]'
            ],
            [
                'field' => 'keterangan',
                'label' => 'Keterangan',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'expired_date',
                'label' => 'Expired Date',
                'rules' => 'trim|required'
            ],
        ];
    }

    public function getAll()
    {
        $query = $this->db->query('SELECT absen.*, COUNT( user_absen.id_user_absen ) AS total_murid FROM absen LEFT JOIN user_absen ON absen.id_absen = user_absen.absen_id GROUP BY absen.id_absen ORDER BY absen.created_at DESC');;
        return $query->result_array();
    }

    public function getUserAbsen($idAbsen)
    {
        $query = $this->db->query('SELECT user_absen.id_user_absen,user_absen.status,user.nama_user,user_absen.created_at FROM user_absen JOIN user ON user_absen.user_id = user.id_user WHERE user_absen.absen_id = ' . $idAbsen . ' ORDER BY user_absen.created_at DESC');
        return $query->result_array();
    }
}

/* End of file AbsenModel.php */
