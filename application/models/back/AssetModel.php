<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AssetModel extends CI_Model
{

	public function getPaging(int $limit, int $start, string $search, string $order, string $order_option, int $idMateri = 0)
	{
		$query = $this->db->select("*")
			->from('asset');


		if ($idMateri != 0) {
			$query = $query->where('materi_id', $idMateri);
		}


		if ($search != "") {
			$query = $query->group_start()
				->where("nama_materi like", "%{$search}%")
				->or_where("nama_kelas like", "%{$search}%")
				->or_where("nama_bab like", "%{$search}%")
				->group_end();
		}

		$query = $query->order_by($order, $order_option);

		$count_all_result = count($query->get()->result_array());

		$query = $this->db->select("*")
			->from('asset');


		if ($idMateri != 0) {
			$query = $query->where('materi_id', $idMateri);
		}

		if ($search != "") {
			$query = $query->group_start()
				->where("nama_materi like", "%{$search}%")
				->or_where("nama_kelas like", "%{$search}%")
				->or_where("nama_bab like", "%{$search}%")
				->group_end();
		}

		$query = $query->order_by($order, $order_option);

		$queryLimit = $query->limit($limit, $start)
			->get()
			->result_array();

		return ([
			"total"         => $count_all_result,
			"data"          => $queryLimit,
			"total_in_page" => count($queryLimit),
			"total_page"    => ceil($count_all_result / $limit)
		]);
	}


	public function getById($id)
	{
		$query = $this->db->select("*")
			->from('asset')
			->where('materi_id', $id)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getByIdAsset($id)
	{
		$query = $this->db->select("*")
			->from('asset')
			->where('id_asset', $id)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getNameMateri($id)
	{
		$query = $this->db->select('*')
			->from('materi')
			->where('id_materi', $id)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getIdByAsset($id)
	{
		$query = $this->db->select('*')
			->from('bab')
			->where('id_bab', $id)
			->get()
			->result_array();
		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function saveData($data)
	{
		return $this->db->insert('asset', $data);
	}

	public function deleteData($id)
	{
		$this->db->where('id_asset', $id);

		return $this->db->delete('asset');
	}
}

?>
