<?php


defined('BASEPATH') or exit('No direct script access allowed');

class AbsenModel extends CI_Model
{
    public function rules()
	{
		return [
			[
				'field' => 'expired_date',
				'label' => 'Expired Date',
				'rules' => 'trim|required'
			],
		];
	}

    public function getAll()
    {
        $query = $this->db->query('SELECT mapel.nama_mapel,materi.nama_materi,absen.*, COUNT( user_absen.id_user_absen ) AS total_murid FROM absen INNER JOIN mapel ON absen.mapel_id = mapel.id_mapel INNER JOIN materi ON absen.materi_id = materi.id_materi LEFT JOIN user_absen ON absen.id_absen = user_absen.absen_id GROUP BY absen.id_absen ORDER BY absen.created_at DESC');;
        return $query->result_array();
    }

    public function getUserAbsen($idAbsen)
    {
        $query = $this->db->query('SELECT user_absen.id_user_absen,user_absen.status,user.nama_user,user_absen.created_at FROM user_absen JOIN user ON user_absen.user_id = user.id_user WHERE user_absen.absen_id = ' . $idAbsen . ' ORDER BY user_absen.created_at DESC');
        return $query->result_array();
    }
    
    public function getMateriWebinar($idMapel)
	{
		$this->db->select('materi.id_materi');
		$this->db->join('bab', 'bab.mapel_id = mapel.id_mapel');
		$this->db->join('materi', 'materi.bab_id = bab.id_bab');
		$this->db->where('materi.webinar_status', 1);
		$this->db->where('mapel.id_mapel', $idMapel);
		return $this->db->get('mapel')->result_array();
	}
}

/* End of file AbsenModel.php */
