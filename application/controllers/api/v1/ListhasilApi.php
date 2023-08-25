<?php
defined('BASEPATH') or exit('No direct script access allowed');


class LIsthasilApi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('back/ListhasilModel', 'BackListhasilModel', true);

	}

	public function simpanListhasil()
	{
		$i = 1;
		$simpan = true;
		foreach ($_POST['data'] as $key => $value) {
			$data = [
				"urutan_mapel_listhasil" => $i,
				"mapel_id"				=> $_POST['mapel_id'],
				"deskripsi_mapel_listhasil" => $value['deskripsi']
			];

			if(isset($value["id"])){
				$simpan = $simpan && $this->BackListhasilModel->updateData($value["id"], $data);
			}else{
				$simpan = $simpan && $this->BackListhasilModel->insertData($data);
			}

			$i++;
		}

		if ($simpan) {
			$code = 200;
			$return['message'] = "Berhasil Menyimpan Data";
			$return['success'] = true;
			$return['data'] = $data;
		} else {
			$code = 500;
			$return['message'] = "Gagal Menyimpan Data";
			$return['success'] = false;
			$return['data'] = $data;
		}

		return $this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output(json_encode($return));
	}

    
	public function delete($id)
	{
		$id = $id ?? 0;
		$dataMapel = $this->BackListhasilModel->getById($id);

		if ($dataMapel['total'] >= 1) {
			$simpan = $this->BackListhasilModel->deleteData($id);
			if ($simpan) {
				
				$code = 200;
				$return['message'] = "Berhasil Menghapus " . $dataMapel['data'][0]['deskripsi_mapel_listhasil'];
				$return['success'] = true;
			} else {
				$code = 500;
				$return['message'] = "Gagal Menyimpan " . $dataMapel['data'][0]['deskripsi_mapel_listhasil'];
				$return['success'] = false;
			}
		} else {
			$code = 404;
			$return['message'] = "Data Tidak Di Temukan";
			$return['success'] = false;
		}

		return $this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output(json_encode($return));
	}
}
?>