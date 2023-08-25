<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PackageApi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->FrontAuthModel->isLoggedInAdmin();
	}

	public function index($meta = null)
	{
		$materi = $this->db->get_where('materi', ['meta_link_materi' => $meta])->row_array();

		if ($materi) {
			$message = 'Successfuly Get Data';
			$code = 200;
			$data['materi'] = $materi;
			// $data['meta-link'] = $meta;

			$this->db->select('paket');
			$this->db->group_by('paket');
			$data['package'] = $this->db->get_where('soal', ['materi_id' => $materi['id_materi']])->result_array();
		} else {
			$code = 404;
			$message = 'Data Not Found';
			$data['package'] = null;
		}
		return $this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output(json_encode(['messages' => $message, 'data' => $data]));
	}

	public function detail($meta = null, $paket = null)
	{
		$materi = $this->db->get_where('materi', ['meta_link_materi' => $meta])->row_array();

		if ($materi) {

			$this->db->join('jawaban', 'soal.id_soal = jawaban.soal_id');
			$soal = $this->db->get_where('soal', ['materi_id' => $materi['id_materi'], 'paket' => $paket])->result_array();
			if ($soal) {
				$code         = 200;
				$message      = 'Successfuly Get Data';
				$data['soal'] = $soal;
			} else {
				$code         = 404;
				$message      = 'Data Not Found';
				$data['soal'] = null;
			}
		} else {
			$code          = 404;
			$message       = 'Data Not Found';
			$data['soal']  = null;
		}
		return $this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output(json_encode(['messages' => $message, 'data' => $data]));
	}

	public function save()
	{
		echo 'test';
	}
	public function update($id_soal)
	{
	}
}

/* End of file PaketApi.php */
