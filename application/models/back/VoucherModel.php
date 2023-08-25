<?php
defined('BASEPATH') or exit('No direct script access allowed');

class VoucherModel extends CI_Model
{
	public function getPaging(int $limit, int $start, string $search, string $order, string $order_option)
	{
		$query = $this->db->select("*")
			->from('voucher');

		if ($search != "") {
			$query = $query->group_start()
				->where("kode_voucher like", "%{$search}%")
				->group_end();
		}

		$query = $query->order_by($order, $order_option);

		$count_all_result = count($query->get()->result_array());

		$query = $this->db->select("*")
			->from('voucher');


		if ($search != "") {
			$query = $query->group_start()
				->where("kode_voucher like", "%{$search}%")
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
			->from('voucher')
			->where('id_voucher', $id)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getByMeta($meta)
	{
		$query = $this->db->select("*")
			->from('voucher')
			->where('meta_link_voucher', $meta)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function saveData($data)
	{
		return $this->db->insert('voucher', $data);
	}

	public function updateData($id, $data)
	{
		$this->db->where('id_voucher', $id);

		return $this->db->update('voucher', $data);
	}

	public function deleteData($id)
	{
		$this->db->where('id_voucher', $id);

		return $this->db->delete('voucher');
	}

	public function getAll()
	{
		$query = $this->db->select("*")
			->from('voucher')
			->order_by('nama_voucher', "DESC")
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getMetaLink($title)
	{
		$slug = preg_replace("/-$/", "", preg_replace('/[^a-z0-9]+/i', "-", strtolower($title)));

		$query = $this->db
			->where("meta_link_voucher like", "{$slug}%")
			->get('voucher')
			->result_array();

		$numHits = count($query);

		return ($numHits > 0) ? ($slug . '-' . $numHits) : $slug;
	}

}
