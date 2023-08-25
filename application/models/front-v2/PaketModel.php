<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PaketModel extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function getPaket()
	{
		$query = $this->db->select("*")
			->from('paket')
			->limit(3);

		$query = $query->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}
}
