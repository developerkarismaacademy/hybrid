<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ListhasilModel extends CI_Model
{
	public function getById($id)
	{
		$query = $this->db->select("*")
			->from('mapel_listhasil')
			->where('id_mapel_listhasil', $id)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}
	
	public function insertData($data)
	{
		return $this->db->insert('mapel_listhasil', $data);
	}

	public function updateData($id, $data)
	{
		$this->db->where('id_mapel_listhasil', $id);
		return $this->db->update('mapel_listhasil', $data);
	}

	public function deleteData($id)
	{
		$this->db->where('id_mapel_listhasil', $id);
		return $this->db->delete('mapel_listhasil');
	}

}
