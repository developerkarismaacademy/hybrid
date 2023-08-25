<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Absen extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->FrontAuthModel->isLoggedIn();
	}

	public function index($mapelId, $materiId)
	{
		$user = $this->FrontAuthModel->getUserLoggedIn();
		$userId = $user['data']['id_user'];

		$kodeAbsen = $this->input->post('kode_absen');
		$absen = $this->db->get_where('absen', ['kode_absen' => $kodeAbsen, 'mapel_id' => $mapelId, 'materi_id' => $materiId]);

		$this->db->select('*');
		$this->db->join('bab', 'bab.id_bab = materi.bab_id');
		$this->db->join('mapel', 'mapel.id_mapel = bab.mapel_id');
		$this->db->where('id_materi', $materiId);
		$materi = $this->db->get('materi')->row_array();

		if ($absen->num_rows() > 0) {
			$absenData = $absen->row_array();
			$absenId = $absenData['id_absen'];

			$userAbsen = $this->db->get_where('user_absen', ['user_id' => $userId, 'absen_id' => $absenId]);

			if ($userAbsen->num_rows() > 0) {
				alert("warning", "", "<strong>Anda sudah pernah absen!</strong>");
				redirect(base_url('belajar/' . $materi['meta_link_mapel'] . '/' . $materi['meta_link_bab'] . '/' . $materi['urutan_materi']));
			} else {
				$dateNow = new DateTime();
				$expiredDate = new DateTime($absenData['expired_date']);

				if ($expiredDate > $dateNow) {
					$input = [
						'user_id' => $userId,
						'absen_id' => $absenId,
						'mapel_id' => $mapelId,
						'materi_id' => $materiId,
						'status' => 1
					];
				} else {
					$input = [
						'user_id' => $userId,
						'absen_id' => $absenId,
						'mapel_id' => $mapelId,
						'materi_id' => $materiId,
						'status' => 0
					];
				}
				$this->db->insert('user_absen', $input);
				alert("success", "", "<strong>Berhasil absen!</strong>");
				redirect(base_url('belajar/' . $materi['meta_link_mapel'] . '/' . $materi['meta_link_bab'] . '/' . $materi['urutan_materi']));
			}
		} else {
			alert("danger", "", "<strong>Kode absen tidak valid!</strong>");
			redirect(base_url('belajar/' . $materi['meta_link_mapel'] . '/' . $materi['meta_link_bab'] . '/' . $materi['urutan_materi']));
		}
	}
}

/* End of file Absen.php */
