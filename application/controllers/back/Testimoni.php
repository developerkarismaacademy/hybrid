<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 */
class Testimoni extends CI_Controller
{
	private $data;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('back/TestimoniModel', 'BackTestimoniModel', true);
		$this->data['menu'] = "testimoni";
		$this->FrontAuthModel->isLoggedInAdmin();

	}

	public function index($id)
	{

		$dataMapel = $this->BackTestimoniModel->getByIdMapel($id);
		//print_r(json_encode($dataMapel));
		if ($dataMapel['total'] >= 1) {

			$namaMapel = $this->BackTestimoniModel->getNameMapel($dataMapel['data'][0]['mapel_id']);
			$metaKelas = $this->BackTestimoniModel->getMetaKelas($namaMapel['data'][0]['kelas_id']);
			// print_r(json_encode($metaKelas));
			if ($namaMapel['total'] && $metaKelas['total'] >= 1) {
				$this->data['title'] = "Mata Pelajaran " . $namaMapel['data'][0]['nama_mapel'];
				$this->data['mapel'] = $dataMapel['data'][0];
				$this->data['nama_mapel'] = $namaMapel['data'][0];
				$this->data['meta_kelas'] = $metaKelas['data'][0];
				$this->data['id'] = $dataMapel['data'][0];
				$this->data['content'] = "testimoni.list";
				$this->load->view('back/main', $this->data);
			}

		} else {

			redirect(base_url('back/not-found'));
		}

	}
}

?>
