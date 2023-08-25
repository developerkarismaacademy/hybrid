<?php defined('BASEPATH') or exit('No direct script access allowed');

class SiswaApi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(['back/PesertaModel' => 'pm']);
	}

	public function index()
	{
		$user = $this->pm->getSiswaByMapel(122139);
		foreach ($user as &$data) {
			$data->sertifikat = $data->progress == 100 ? base_url('download-sertifikat/' . $data->meta_link_mapel . '/' . $data->id_user) : null;
		}
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode(
				[
					'status' => 'success',
					'data' => $user
				]
			));
	}
}
