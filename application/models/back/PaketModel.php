<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PaketModel extends CI_Model
{

	public function getPaging(int $limit, int $start, string $search, string $order, string $order_option)
	{
		$query = $this->db->select("*")
			->from('paket');

		if ($search != "") {
			$query = $query->group_start()
				->where("nama_paket like", "%{$search}%")
				->or_where("deskripsi_singkat like", "%{$search}%")
				->or_where("harga_basic like", "%{$search}%")
				->or_where("harga_gold like", "%{$search}%")
				->group_end();
		}

		$query = $query->order_by($order, $order_option);

		$count_all_result = count($query->get()->result_array());

		$query = $this->db->select("*")
			->from('paket');


		if ($search != "") {
			$query = $query->group_start()
				->where("nama_paket like", "%{$search}%")
				->or_where("deskripsi_singkat like", "%{$search}%")
				->or_where("harga_basic like", "%{$search}%")
				->or_where("harga_gold like", "%{$search}%")
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
			"total_page"    => ceil($count_all_result / $limit),
		]);
	}

	public function getById($id)
	{
		$query = $this->db->select("*")
			->from('paket')
			->where('id_paket', $id)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function saveData($data)
	{
		return $this->db->insert('paket', $data);
	}

	/**
	 * @param string $title
	 * @return mixed|string
	 */
	public function getMetaLink(string $title)
	{
		$slug = preg_replace("/-$/", "", preg_replace('/[^a-z0-9]+/i', "-", strtolower($title)));

		$query = $this->db
			->where("meta_link_paket like", "{$slug}%")
			->get('paket')
			->result_array();

		$numHits = count($query);

		return ($numHits > 0) ? ($slug . '-' . $numHits) : $slug;
	}

	public function getByMeta($meta)
	{
		$query = $this->db->select("*")
			->from('paket')
			->where('meta_link_paket', $meta)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function deleteData($id)
	{
		$this->db->where('id_paket', $id);

		return $this->db->delete('paket');
	}

	public function updateData($id, $data)
	{
		$this->db->where('id_paket', $id);
		return $this->db->update('paket', $data);
	}

}

?>
