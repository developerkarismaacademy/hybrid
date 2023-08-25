<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TransaksiModel extends CI_Model
{
	/**
	 * TransaksiModel constructor.
	 */
	public function __construct()
	{
		parent::__construct();
	}

	public function getPaging(int $limit, int $start, string $search, string $order, string $order_option, int $status = -1)
	{
		$query = $this->db->select('transaksi.*,user.nama_user,user.email_user,user.telepon_user')
			->from('transaksi')
			->join('user', 'id_user = transaksi.user_id');

		if ($status != -1) {
			$query = $query->where('status', $status);
		}


		if ($search != "") {
			$query = $query->group_start()
				->where('user.nama_user like', "%{$search}%")
				->or_where('user.email_user like', "%{$search}%")
				->group_end();
		}

		$order = "(case when status = 1 then 1
        			   when status = 2 then 2
        			   else 3 
        			end) ASC,tanggal_bayar DESC";

		$query = $query->order_by($order);

		$count_all_result = count($query->get()->result_array());

		$query = $this->db->select('transaksi.*,user.nama_user,user.email_user,user.telepon_user')
			->from('transaksi')
			->join('user', 'id_user = transaksi.user_id');

		if ($status != -1) {
			$query = $query->where('status', $status);
		}


		if ($search != "") {
			$query = $query->group_start()
				->where('user.nama_user like', "%{$search}%")
				->or_where('user.email_user like', "%{$search}%")
				->group_end();
		}

		$query = $query->order_by($order);

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

	function getById(int $id)
	{
		$query = $this->db->select('transaksi.*,user.nama_user,user.email_user,user.telepon_user')
			->from('transaksi')
			->join('user', 'id_user = transaksi.user_id')
			->where('id_transaksi', $id)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getAllByTransaksi($column = "", $id = "")
	{
		$query = $this->db->select("*")
			->from('transaksi')
			->join('detail_transaksi', "transaksi.id_transaksi = detail_transaksi.transaksi_id");

		if ($column != "" and $id != "") {
			if (is_array($column) && is_array($id)) {
				foreach ($column as $key => $val) {
					$query = $query->where($column[$key], $id[$key]);
				}
			} else {
				$query = $query->where($column, $id);
			}
		}


		$query = $query->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getAllByDetail($column = "", $id = "")
	{
		$query = $this->db->select("*")
			->from('detail_transaksi')
			->join('transaksi', "detail_transaksi.transaksi_id = transaksi.id_transaksi");

		if ($column != "" and $id != "") {
			if (is_array($column) && is_array($id)) {
				foreach ($column as $key => $val) {
					$query = $query->where($column[$key], $id[$key]);
				}
			} else {
				$query = $query->where($column, $id);
			}
		}


		$query = $query->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}


	function getDetailById(int $id, int $id_user)
	{
		$query = $this->db->select('*')
			->from('detail_transaksi')
			->join('mapel', 'id_mapel = detail_transaksi.mapel_id')
			->join('user', 'id_user = detail_transaksi.user_id')
			->where('transaksi_id', $id)
			->where('user_id', $id_user)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	function getDetailByIdTransaksi(int $id)
	{
		$query = $this->db->select('*')
			->from('detail_transaksi')
			->join('mapel', 'id_mapel = detail_transaksi.mapel_id')
			->join('user', 'id_user = detail_transaksi.user_id')
			->where('transaksi_id', $id)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	function getAllKonfirmasiAndBelumBayar()
	{
		$query = $this->db->select('transaksi.*,user.nama_user,user.email_user,user.telepon_user,user.nama_user,user.id_user,user.gambar_user')
			->from('transaksi')
			->join('user', 'id_user = transaksi.user_id');

		$query = $query->where('status <> 0');

		$query = $query->order_by("status ASC,tanggal_bayar DESC");

		$query = $query->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);

	}

	function simpanOne($data)
	{
		$this->db->trans_begin();

		$idTransaksi = -1;
		$dataInsert['detail_transaksi'] = false;

		$dataDetailTransaksi = $this->BackTransaksiModel->getAllByDetail(
			array("detail_transaksi.user_id", "detail_transaksi.mapel_id"),
			array(
				$data['detail_transaksi']["user_id"],
				$data['detail_transaksi']["mapel_id"]
			)
		);


		if ($dataDetailTransaksi['total'] > 0) {
			$dataDetailTransaksi = $dataDetailTransaksi["data"][0];

			$idDetailTransaksi = $dataDetailTransaksi['id_detail_transaksi'];

			//set ID Transaksi that need to be updated
			$idTransaksi = $dataDetailTransaksi["transaksi_id"];

			//UPDATE QUERY
			$this->db->where("id_detail_transaksi = {$idDetailTransaksi}")->update('detail_transaksi', $data['detail_transaksi']);
		} else {
			//NEED GET LAST TRANSAKSI ID
			// PERINTAH DI SETELAH INSERT TRANSAKSI
			// FLAG
			$dataInsert['detail_transaksi'] = true;
		}

		$dataTransaksi = $this->BackTransaksiModel->getAllByTransaksi("id_transaksi", $idTransaksi);
		if ($dataTransaksi['total'] > 0) {
			//UPDATE QUERY
			$this->db->where("id_transaksi = {$idTransaksi}")->update('transaksi', $data['transaksi']);
		} else {
			$this->db->insert('transaksi', $data['transaksi']);
			$idTransaksi = $this->db->insert_id();
		}

		if ($dataInsert["detail_transaksi"]) {
			$data['detail_transaksi']['transaksi_id'] = $idTransaksi;
			//INSERT QUERY
			$this->db->insert('detail_transaksi', $data['detail_transaksi']);

			$idDetailTransaksi = $this->db->insert_id();
            $package_rand = rand(1,3);
            $this->db->insert('randomize', ['id_package' => $package_rand,'id_detail_transaksi' => $idDetailTransaksi]);
        }

		//Check data User Mapel
		$dataUserMapel = $this->UniversalModel->getOneData("user_mapel", "user_id = {$data['user_mapel']["user_id"]} AND mapel_id = {$data['user_mapel']["mapel_id"]}");
		$data['user_mapel']['transaksi_id'] = $idTransaksi;
		$data['user_mapel']['detail_transaksi_id'] = $idDetailTransaksi;

		if ($dataUserMapel['total'] > 0) {
			$dataUserMapel = $dataUserMapel["data"];
			$idUserMapel = $dataUserMapel['id_user_mapel'];

			//UPDATE QUERY
			$this->db->where("id_user_mapel = {$idUserMapel}")->update('user_mapel', $data['user_mapel']);

		} else {
			//INSERT QUERY
			//WHAT IF STATUS BELI IMPLEMENTED
			$this->db->insert('user_mapel', $data['user_mapel']);
		}


		if ($this->db->trans_status() === FALSE) {
			return $this->db->trans_rollback();
		} else {
			return $this->db->trans_commit();
		}

	}
}
