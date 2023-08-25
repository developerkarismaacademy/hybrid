<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FrontKelasModel extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function getAllKelas(string $where = "", string $order_column = "urutan_kelas", string $order_mode = "ASC")
	{
		$query = $this->db->select("*")
			->from('kelas');

		if ($where != "") {
			if (is_array($where)) {
				if ($where["LIKE"]) {
					foreach ($where["LIKE"] as $key => $value) {
						$query = $query->like($key, $value);
					}
				} else {
					foreach ($where as $key => $value) {
						$query = $query->where($key, $value);
					}
				}
			} else {
				$query = $query->where($where);
			}
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

	public function getKelasByInstruktur(string $where = "", string $order_column = "urutan_kelas", string $order_mode = "ASC")
	{
		$query = $this->db->select("*")
			->from("instruktur_mapel")
			->join("mapel as mp", 'mp.id_mapel = instruktur_mapel.mapel_id')
			->join("kelas as k", 'k.id_kelas = mp.kelas_id');

		if ($where != "") {
			if (is_array($where)) {
				if ($where["LIKE"]) {
					foreach ($where["LIKE"] as $key => $value) {
						$query = $query->like($key, $value);
					}
				} else {
					foreach ($where as $key => $value) {
						$query = $query->where($key, $value);
					}
				}
			} else {
				$query = $query->where($where);
			}
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
