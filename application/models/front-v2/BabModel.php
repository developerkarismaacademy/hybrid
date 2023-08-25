<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BabModel extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}


	public function getAllBab(string $where = "", string $order_column = "urutan_bab", string $order_mode = "ASC")
	{
		$query = $this->db->select("*, (SELECT SUM(durasi) FROM materi WHERE bab_id = id_bab AND tipe = 'video') as jml_durasi")
			->from('bab');

		if ($where != "") {
			$query = $query->where($where);
		}

		if ($order_column != "" && $order_mode == "") {
			$query = $query->order_by($order_column);
		} elseif ($order_column != "" && $order_mode != "") {
			$query = $query->order_by($order_column, $order_mode);
		}

		$query = $query->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}
}
