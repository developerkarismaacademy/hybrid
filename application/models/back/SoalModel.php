<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SoalModel extends CI_Model
{

    public function getById($id)
    {
        $query = $this->db->select("*")
            ->from('soal')
            ->join('jawaban', 'soal_id = soal.id_soal')
            ->join('materi', 'id_materi = soal.materi_id')
            ->join('bab', 'id_bab = materi.bab_id')
            ->join('mapel', 'id_mapel = bab.mapel_id')
            ->join('kelas', 'id_kelas = mapel.kelas_id')
            ->where('id_soal', $id)
            ->get()
            ->result_array();

        return ([
            "data"  => $query,
            "total" => count($query),
        ]);
    }

    public function deleteData($id)
    {
        $delete = $this->db->where('id_soal', $id)->delete('soal');
        $delete = $delete && $this->db->where('soal_id', $id)->delete('jawaban');

        return $delete;
    }

    public function saveData($data)
    {
        return ['success' => $this->db->insert('soal', $data), "id" => $insert_id = $this->db->insert_id()];
    }

    public function saveDataJawaban($data)
    {
        return $this->db->insert('jawaban', $data);
    }

    public function updateData($id, $data)
    {
        $this->db->where('id_soal', $id);
        return $this->db->update('soal', $data);
    }

    public function updateDataJawaban($id, $data)
    {
        $this->db->where('soal_id', $id);
        return $this->db->update('jawaban', $data);
    }

    public function getPaging(int $limit, int $start, string $search, string $order, string $order_option, int $idMateri = 0,int $paketSoal)
    {
        $query = $this->db->select("")
            ->from('soal')
            ->join('jawaban', 'soal_id = soal.id_soal')
            ->join('materi', 'id_materi = soal.materi_id')
            ->join('bab', 'id_bab = materi.bab_id')
            ->join('mapel', 'id_mapel = bab.mapel_id')
            ->join('kelas', 'id_kelas = mapel.kelas_id');

        if ($idMateri != 0) {
            $query = $query->where(['soal.materi_id' => $idMateri, 'soal.paket' => $paketSoal]);
        }

        if ($search != "") {
            $query = $query->group_start()
                ->where("isi_soal like", "%{$search}%")
                ->group_end();
        }

        $query = $query->order_by($order, $order_option);

        $count_all_result = count($query->get()->result_array());

        $query = $this->db->select("*")
            ->from('soal')
            ->join('jawaban', 'soal_id = soal.id_soal')
            ->join('materi', 'id_materi = soal.materi_id')
            ->join('bab', 'id_bab = materi.bab_id')
            ->join('mapel', 'id_mapel = bab.mapel_id')
            ->join('kelas', 'id_kelas = mapel.kelas_id');


        if ($idMateri != 0) {
            $query = $query->where(['soal.materi_id' => $idMateri, 'soal.paket' => $paketSoal]);
        }

        if ($search != "") {
            $query = $query->group_start()
                ->where("isi_soal like", "%{$search}%")
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


}
