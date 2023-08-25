<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class BabModel
 */
class BabModel extends CI_Model
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
            ->from('bab')
            ->join('mapel', 'id_mapel = bab.mapel_id')
            ->join('kelas', 'id_kelas = mapel.kelas_id');

        if ($idMapel != 0) {
            $query = $query->where('bab.mapel_id', $idMapel);
        }

        if ($search != "") {
            $query = $query->group_start()
                ->where("nama_bab like", "%{$search}%")
                ->or_where("nama_kelas like", "%{$search}%")
                ->or_where("nama_mapel like", "%{$search}%")
                ->group_end();
        }

        $query = $query->order_by($order, $order_option);

        $count_all_result = count($query->get()->result_array());

        $query = $this->db->select("*")
            ->from('bab')
            ->join('mapel', 'id_mapel = bab.mapel_id')
            ->join('kelas', 'id_kelas = mapel.kelas_id');


        if ($idMapel != 0) {
            $query = $query->where('bab.mapel_id', $idMapel);
        }

        if ($search != "") {
            $query = $query->group_start()
                ->where("nama_bab like", "%{$search}%")
                ->or_where("nama_kelas like", "%{$search}%")
                ->or_where("nama_mapel like", "%{$search}%")
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


    /**
     * @param int $id
     * @return array
     */
    public function getById(int $id)
    {
        $query = $this->db->select("*")
            ->from('bab')
            ->join('mapel', 'id_mapel = bab.mapel_id')
            ->join('kelas', 'id_kelas = mapel.kelas_id')
            ->where('id_bab', $id)
            ->get()
            ->result_array();

        return ([
            "data"  => $query,
            "total" => count($query),
        ]);
    }


    /**
     * @param string $meta
     * @return array
     */
    public function getByMeta(string $meta)
    {
        $query = $this->db->select("*")
            ->from('bab')
            ->join('mapel', 'id_mapel = bab.mapel_id')
            ->join('kelas', 'id_kelas = mapel.kelas_id')
            ->where('meta_link_bab', $meta)
            ->get()
            ->result_array();

        return ([
            "data"  => $query,
            "total" => count($query),
        ]);
    }


    /**
     * @param array $data
     * @return mixed
     */
    public function saveData(array $data)
    {
        return $this->db->insert('bab', $data);
    }


    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function updateData(int $id, array $data)
    {
        $this->db->where('id_bab', $id);

        return $this->db->update('bab', $data);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function deleteData(int $id)
    {
        $this->db->where('id_bab', $id);

        return $this->db->delete('bab');
    }


    /**
     * @param string $title
     * @return mixed|string
     */
    public function getMetaLink(string $title, $id = null)
    {
        $slug = url_title($title);
        $slug = strtolower($slug);
        $i = 0;
        $params = array();
        $params["meta_link_bab"] = $slug;

        if ($id) {
            $params["id_bab !="] = $id;
        }

        while ($this->db->where($params)->get('bab')->num_rows()) {
            if (!preg_match('/-{1}[0-9]+$/', $slug)) {
                $slug .= '-' . ++$i;
            } else {
                $slug = preg_replace('/[0-9]+$/', ++$i, $slug);
            }
            $params["meta_link_bab"] = $slug;
        }

        return $slug;
    }


    /**
     * @param int $idMapel
     * @return int
     */
    public function getLastUrutanByMapel(int $idMapel)
    {
        $query = $this->db->select("*")
            ->from('bab')
            ->join('mapel', 'id_mapel = bab.mapel_id')
            ->join('kelas', 'id_kelas = mapel.kelas_id')
            ->where('bab.mapel_id', $idMapel)
            ->order_by('urutan_bab', "DESC")
            ->limit(1)
            ->get()
            ->row_array();

        return (isset($query) && count($query) > 1 ? $query['urutan_bab'] : 0);
    }


    /**
     * @return array
     */
    public function getAll()
    {
        $query = $this->db->select("*")
            ->from('bab')
            ->get()
            ->result_array();

        return ([
            "data"  => $query,
            "total" => count($query),
        ]);
    }

    public function getAllByMapel($idMapel = 0)
    {
        $query = $this->db->select("*")
            ->from('bab')
            ->where('bab.mapel_id', $idMapel)
            ->order_by('urutan_bab', "ASC")
            ->get()
            ->result_array();

        return ([
            "data"  => $query,
            "total" => count($query),
        ]);
    }


    public function getAllBab(string $where = "", string $order_column = "urutan_bab", string $order_mode = "ASC")
    {


        $query = $this->db->select("*")
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
