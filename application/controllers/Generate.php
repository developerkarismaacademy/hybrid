<?php defined('BASEPATH') or exit('No direct script access allowed');

class Generate extends CI_Controller
{
	public function ulasan()
	{
		$now = date('Y-m-d');
		$user_progress = $this->db->query("SELECT t1.* FROM user_mapel_progress t1 LEFT JOIN rating t2 ON t1.mapel_id = t2.mapel_id AND t1.user_id = t2.user_id WHERE t1.progress = 100 AND t2.rating is NUll")->result_array();

		$ulasan = [
			'Sangat bagus dan bermanfaat',
			'Sangat baik',
			'Pelatihannya seru karena selalu ada mini games di awal sebelum memulai kegiatan. Mentor dan admin ramah serta materi yang diberikan maupun video tutorial tugas pun lengkap.',
			'Materi nya sangat mudah dipahami walaupun agak rumit,, penjelasan intruktur nya mudah dimengerti',
			'Sangat bagus dan bermanfaat sekali',
		];


		$rand_key_ulasan = array_rand($ulasan, 1);

		foreach ($user_progress as $item) {
			$data = [
				'user_id' => $item['user_id'],
				'mapel_id' => $item['mapel_id'],
				'rating' => 5,
				'ulasan' => $ulasan[$rand_key_ulasan],
			];
			$this->db->insert('rating', $data);
		}

		echo '<pre>';
		var_dump($user_progress);
		die();

	}

	public function nilai($mapel_id)
	{
		$user_id = [
			'3662',
			'3792',
			'3862',
			'3919',
			'4097',
			'4098',
			'4134',
			'4466',
			'4682',
			'4936',
			'4944',
			'4945',
			'4946',
			'4947',
			'4980',
			'4982',
			'5032',
			'5248',
			'5288',
			'5542',
			'5558',
			'5649',
			'5654',
			'5663',
			'6120',
			'6123',
			'6138',
			'6160',
			'6336',
			'6346',
			'6364'
		];

		$materi = $this->db->query("SELECT id_materi FROM materi WHERE bab_id IN (SELECT id_bab FROM (SELECT * FROM bab WHERE mapel_id = $mapel_id) t1 WHERE t1.pretest_status = 1 OR t1.posttest_status = 1)")->result_array();

		foreach ($user_id as $id) {
			foreach ($materi as $item) {
				if ($this->db->get_where('log_ujian', ['user_id' => $id, 'materi_id' => $item['id_materi']])->num_rows() < 1) {
					$this->db->insert('log_ujian', [
						'user_id' => $id,
						'materi_id' => $item['id_materi'],
						'start_time' => date('Y-m-d H:i:s'),
						'estimasi_time' => date('Y-m-d H:i:s'),
						'end_time' => date('Y-m-d H:i:s'),
						'benar' => 15,
						'salah' => 5,
						'jumlah_soal' => 20,
						'nilai' => 75.00,
						'retake_log_ujian' => 0,
					]);
				}
			}
		}

		var_dump($materi);
		die();
	}

	public function progress()
	{
		$user_id = [
			'3662',
			'4097',
			'4134',
			'4466',
			'4944',
			'4945',
			'4946',
			'4947',
			'4982'
		];

		foreach ($user_id as $id) {
			$this->db->insert('user_mapel_progress', [
				'user_id' => $id,
				'mapel_id' => 122138,
				'progress' => 100.0,
				'raport_allowed' => 0
			]);
		}
	}
}
