<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BasicModel extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	//Create
	public function addData($table, $data)
	{
		return ($this->db->insert($table, $data)) ? true : false;
	}

	//Update
	public function updateData($table, $data, $where)
	{
		$this->db->where($where);
		return $this->db->update($table, $data);
	}

	//Delete
	public function deleteData($table, $where)
	{
		$this->db->where($where);
		return $this->db->delete($table);
	}

	//Read
	public function getData($tabel, $get = "", $column = "*", $order = "")
	{
		$this->db->select("$column");
		$this->db->from($tabel);

		if ($get != "")
			$this->db->where($get);

		if ($order != "") {
			foreach ($order as $key => $value) {
				$this->db->order_by($key, $value);
			}
		}

		$query = $this->db->get();
		$data = $query->row();
		return $data;
	}

	public function getArrayData($tabel, $where = "", $order = "", $column = "*")
	{
		$query = $this->db->select("$column")
			->from($tabel);


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

		if ($order != "") {
			foreach ($order as $key => $value) {
				$this->db->order_by($key, $value);
			}
		}

		$query = $this->db->get();
		$data = $query->result();
		return $data;
	}

	public function getArrayDataIn($tabel, $column, $arrayData, $order = "")
	{
		$this->db->select("*");
		$this->db->from($tabel);

		$this->db->where_in($column, $arrayData);

		if ($order != "") {
			foreach ($order as $key => $value) {
				if (is_array($value))
					$this->db->order_by("FIELD(" . $key . "," . implode(",", $value) . ")");
				else
					$this->db->order_by($key, $value);
			}
		}

		$query = $this->db->get();
		$data = $query->result();
		return $data;
	}

	public function getCountData($tabel, $get = "")
	{
		$this->db->select("*");
		$this->db->from($tabel);

		if ($get != "")
			$this->db->where($get);

		$query = $this->db->get();
		$data = $query->num_rows();
		return $data;
	}

}
