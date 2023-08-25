<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DiskusiModel extends CI_Model
{
    public function getPaging(int $limit, int $start, string $search, string $order, string $order_option, $id)
    {
        $columnDiskusi = $this->db->list_fields('diskusi');
        foreach ($columnDiskusi as &$v) {
            $v = "diskusi." . $v;
        }
        $columnDiskusi = implode(", ", $columnDiskusi);
        $columnUser = "user.nama_user, user.gambar_user";
        $columnBab = "bab.nama_bab, bab.id_bab";
        $columnMateri = "materi.meta_link_materi, materi.meta_link_materi";
        /*-------------------*/
        $query = $this->db->select($columnDiskusi . ", " . $columnUser . ", " . $columnBab . ", " . $columnMateri)
            ->from('diskusi')
            ->join("bab", "diskusi.bab_id = bab.id_bab", "left")
            ->join("materi", "diskusi.materi_id = materi.id_materi", "left")
            ->join('mapel', 'diskusi.mapel_id = mapel.id_mapel')
            ->join('user', 'diskusi.user_id = user.id_user');
        foreach ($id as $key => $val) {
            if ($val != "" && $val != 0)
                $query = $query->where('diskusi.' . $key, $val);
        }


        if ($search != "") {
            $query = $query->group_start()
                ->where("isi like", "%{$search}%")
                ->group_end();
        }

        $query = $query->order_by($order, $order_option);

        $count_all_result = count($query->get()->result_array());

        $query = $this->db->select($columnDiskusi . ", " . $columnUser . ", " . $columnBab . ", " . $columnMateri)
            ->from('diskusi')
            ->join("bab", "diskusi.bab_id = bab.id_bab", "left")
            ->join("materi", "diskusi.materi_id = materi.id_materi", "left")
            ->join('mapel', 'diskusi.mapel_id = mapel.id_mapel')
            ->join('user', 'diskusi.user_id = user.id_user');
        foreach ($id as $key => $val) {
            if ($val != "" && $val != 0)
                $query = $query->where('diskusi.' . $key, $val);
        }


        if ($search != "") {
            $query = $query->group_start()
                ->where("isi like", "%{$search}%")
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
            "total_page"    => ceil($count_all_result / $limit)
        ]);
    }

    public function getById($id)
    {
        //id = array
        $query = $this->db->select("*")
            ->from('diskusi')
            ->join("bab", "diskusi.bab_id = bab.id_bab", "left")
            ->join("materi", "diskusi.materi_id = materi.id_materi", "left")
            ->join('mapel', 'diskusi.mapel_id = mapel.id_mapel')
            ->join('user', 'diskusi.user_id = user.id_user');

        if (isarray($id)) {
            foreach ($id as $key => $val) {
                $query = $query->where('diskusi.' . $key, $val);
            }
        } else {
            $query = $query->where('diskusi.id_diskusi', $val);
        }

        $query = $query->get()
            ->result_array();

        return ([
            "data"  => $query,
            "total" => count($query),
        ]);
    }


    public function getAll()
    {
        $query = $this->db->select("*")
            ->from('mapel')
            ->join('kelas', 'id_kelas = mapel.kelas_id')
            ->order_by('nama_kelas', "DESC")
            ->get()
            ->result_array();

        return ([
            "data"  => $query,
            "total" => count($query),
        ]);
    }


    public function saveData($data)
    {
        return $this->db->insert('mapel', $data);
    }

    public function updateData($id, $data)
    {
        $this->db->where('id_mapel', $id);
        return $this->db->update('mapel', $data);
    }

    public function deleteData($id)
    {
        $this->db->where('id_mapel', $id);
        return $this->db->delete('mapel');
    }


}
