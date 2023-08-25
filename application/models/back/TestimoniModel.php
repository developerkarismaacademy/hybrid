<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TestimoniModel extends CI_Model
{

	/**
	 * @param int $limit
	 * @param int $start
	 * @param string $search
	 * @param string $order
	 * @param string $order_option
	 * @param int $idMapel
	 * @return array
	 */
	public function getPaging(int $limit, int $start, string $search, string $order, string $order_option, int $idMapel = 0)
	{
		$query = $this->db->select("*")
			->from('rating')
			->join('user', "id_user = rating.user_id");

		if ($idMapel != 0) {
			$query = $query->where('rating.mapel_id', $idMapel);
		}

		if ($search != "") {
			$query = $query->group_start()
				->where("rating like", "%{$search}%")
				->or_where("ulasan like", "%{$search}%")
				->or_where("nama_user like", "%{$search}%")
				->group_end();
		}

		$query = $query->order_by($order, $order_option);

		$count_all_result = count($query->get()->result_array());

		$query = $this->db->select("*")
			->from('rating')
			->join('user', "id_user = rating.user_id");


		if ($idMapel != 0) {
			$query = $query->where('mapel_id', $idMapel);
		}


		if ($search != "") {
			$query = $query->group_start()
				->where("rating like", "%{$search}%")
				->or_where("ulasan like", "%{$search}%")
				->or_where("nama_user like", "%{$search}%")
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

	public function getPagingMapel(int $limit, int $start, string $search, string $order, string $order_option)
	{
		$query = $this->db->select("*")
			->from('mapel');


		if ($search != "") {
			$query = $query->group_start()
				->where("nama_mapel like", "%{$search}%")
				->group_end();
		}

		$query = $query->order_by($order, $order_option);

		$count_all_result = count($query->get()->result_array());

		$query = $this->db->select("*")
			->from('mapel');


		if ($search != "") {
			$query = $query->group_start()
				->where("nama_mapel like", "%{$search}%")
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
			->from('rating')
			->join('user', "id_user = rating.user_id")
			->where("user_id", $id)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getByIdMapel(int $id)
	{
		$query = $this->db->select("*")
			->from('rating')
			->join('user', "id_user = rating.user_id")
			->where("mapel_id", $id)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getNameMapel(int $id)
	{
		$query = $this->db->select("*")
			->from('mapel')
			->where('id_mapel', $id)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}

	public function getMetaKelas(int $id)
	{
		$query = $this->db->select("*")
			->from('kelas')
			->where('id_kelas', $id)
			->get()
			->result_array();

		return ([
			"data"  => $query,
			"total" => count($query),
		]);
	}
}

?>
