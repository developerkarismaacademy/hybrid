<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Bab extends CI_Controller
{
    private $data;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('back/MapelModel', 'BackMapelModel', true);
        $this->load->model('back/KelasModel', 'BackKelasModel', true);
        $this->load->model('back/BabModel', 'BackBabModel', true);
        $this->data['menu'] = "kelas";
        $this->FrontAuthModel->isLoggedInAdmin();
    }

    public function index($metaMapel = "")
    {

        $dataMapel = $this->BackMapelModel->getByMeta($metaMapel);

        if ($dataMapel['total'] >= 1) {

            $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

            if ($dataKelas['total'] >= 1) {
                $this->data['title'] = "Bab " . $dataMapel['data'][0]['nama_mapel'];
                $this->data['content'] = "bab.list";
                $this->data['kelas'] = $dataKelas['data'][0];
                $this->data['mapel'] = $dataMapel['data'][0];
                $this->data['id'] = $dataMapel['data'][0]['id_mapel'];

                $this->load->view('back/main', $this->data);
            } else {
                redirect(base_url('back/not-found'));
            }

        } else {
            redirect(base_url('back/not-found'));
        }


    }

    public function setUrutan($metaMapel = "")
    {

        $dataMapel = $this->BackMapelModel->getByMeta($metaMapel);

        if ($dataMapel['total'] >= 1) {
            $dataBab = $this->BackBabModel->getAllByMapel($dataMapel['data'][0]['id_mapel']);

            $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

            if ($dataKelas['total'] >= 1) {
                $this->data['title'] = "Setting Urutan Bab " . $dataMapel['data'][0]['nama_mapel'];
                $this->data['content'] = "bab.form-urutan";
                $this->data['kelas'] = $dataKelas['data'][0];
                $this->data['mapel'] = $dataMapel['data'][0];
                $this->data['bab'] = $dataBab['data'];
                $this->data['id'] = $dataMapel['data'][0]['id_mapel'];

                $this->load->view('back/main', $this->data);
            } else {
                redirect(base_url('back/not-found'));
            }

        } else {
            redirect(base_url('back/not-found'));
        }
    }

    public function tambah($metaMapel = "")
    {
        $dataMapel = $this->BackMapelModel->getByMeta($metaMapel);

        if ($dataMapel['total'] >= 1) {

            $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

            if ($dataKelas['total'] >= 1) {
                $this->data['title'] = " Tambah Bab " . $dataMapel['data'][0]['nama_mapel'];
                $this->data['content'] = "bab.form-insert";
                $this->data['kelas'] = $dataKelas['data'][0];
                $this->data['mapel'] = $dataMapel['data'][0];

                $this->load->view('back/main', $this->data);
            } else {
                redirect(base_url('back/not-found'));
            }

        } else {
            redirect(base_url('back/not-found'));
        }

    }

    public function ubah($metaBab = "")
    {
        $dataBab = $this->BackBabModel->getByMeta($metaBab);

        if ($dataBab['total'] >= 1) {
            $dataMapel = $this->BackMapelModel->getById($dataBab['data'][0]['mapel_id']);

            if ($dataMapel['total'] >= 1) {

                $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

                if ($dataKelas['total'] >= 1) {
                    $this->data['title'] = "Ubah Bab " . $dataBab['data'][0]['nama_bab'];
                    $this->data['content'] = "bab.form-update";
                    $this->data['kelas'] = $dataKelas['data'][0];
                    $this->data['mapel'] = $dataMapel['data'][0];
                    $this->data['id'] = $dataBab['data'][0]['id_bab'];

                    $this->load->view('back/main', $this->data);
                } else {
                    redirect(base_url('back/not-found'));
                }

            } else {
                redirect(base_url('back/not-found'));
            }
        } else {
            redirect(base_url('back/not-found'));
        }

    }

//    public function setMeta()
//    {
//        $dataBab = $this->BackBabModel->getAll();
//        $simpan = true;
//        foreach ($dataBab['data'] as $key => $value) {
//            $data = [
//                "meta_link_bab" => $this->UniversalModel->getMetaLink("bab", $_POST['nama_bab']),
//            ];
//
//            $simpan = $simpan && $this->BackBabModel->updateData($value["id_bab"], $data);
//        }
//    }

}
