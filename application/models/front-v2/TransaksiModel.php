<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TransaksiModel extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function getAllDetailTransaksi(string $where = "", string $order_column = "transaksi.created_at", string $order_mode = "DESC")
	{
		$query = $this->db
			->select("detail_transaksi.*,
					  transaksi.status as status_pembelian,
					  mapel.nama_mapel,
					  mapel.banner_mapel,
					  kelas.nama_kelas")
			->from("detail_transaksi")
			->join("transaksi", "id_transaksi = transaksi_id")
			->join("mapel", "id_mapel = mapel_id")
			->join("kelas", "id_kelas = kelas_id");

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

	public function beli($idmapel = 0)
	{

	}

}
