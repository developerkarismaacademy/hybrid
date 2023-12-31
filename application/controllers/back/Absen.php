<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Absen extends CI_Controller
{

	private $data;

	public function __construct()
	{
		parent::__construct();
		$this->data['menu'] = "absen";
		$this->load->model(['back/AbsenModel' => 'am']);
		$this->FrontAuthModel->isLoggedInAdmin();
	}

	public function index()
	{
		$this->data['title'] = "Absen";

		$this->data['content'] = "absen.list";
		$this->data['absen'] = $this->am->getAll();
		$this->load->view('back/main', $this->data);
	}

	public function create()
	{
		$validation = $this->form_validation;
		$validation->set_rules($this->am->rules());

		if ($this->form_validation->run() == FALSE) {
			$this->data['title'] = "Tambah Absen";
			$this->data['content'] = "absen.form-tambah";
			$this->data['mapel'] = $this->db->get_where('mapel', ['kelas_id' => 14, 'prakerja' => 1])->result();
			$this->load->view('back/main', $this->data);
		} else {
			$input = [
				'kode_absen' => $this->input->post('kode_absen'),
				'keterangan' => $this->input->post('keterangan'),
				'mapel_id' => $this->input->post('mapel_id'),
				'expired_date' => $this->input->post('expired_date'),
				'materi_id' => $this->input->post('materi_id')
			];
			$this->db->insert('absen', $input);

			redirect(base_url('back/absen'));
		}
	}

	public function delete($id)
	{
		$this->db->where('id_absen', $id);
		$this->db->delete('absen');
		redirect(base_url('back/absen'));
	}

	public function userAbsen($idAbsen)
	{
		$this->data['title'] = "List Siswa";
		$this->data['content'] = "absen.list-murid";
		$this->data['murid'] = $this->am->getUserAbsen($idAbsen);
		$this->data['idAbsen'] = $idAbsen;
		$this->load->view('back/main', $this->data);
	}

	function absenMurid($idAbsen)
	{
		$status = $this->input->post('status');
		foreach ($status as $id => $value) {
			$this->db->where('id_user_absen', $id);
			$this->db->update('user_absen', ['status' => $value]);
		}
	}
}

/* End of file Absen.php */
