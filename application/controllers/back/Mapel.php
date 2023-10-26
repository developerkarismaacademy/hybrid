<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Mapel extends CI_Controller
{
    private $data;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('back/MapelModel', 'BackMapelModel', true);
        $this->load->model('back/KelasModel', 'BackKelasModel', true);
        $this->load->model('back/BabModel', 'BackBabModel', true);
        $this->load->model('back/MateriModel', 'BackMateriModel', true);
        $this->load->model('back/DiskusiModel', 'BackDiskusiModel', true);
        $this->data['menu'] = "kelas";
        $this->FrontAuthModel->isLoggedInAdmin();
    }

    public function index($metaKelas = "")
    {
        $dataKelas = $this->BackKelasModel->getByMeta($metaKelas);

        if ($dataKelas['total'] >= 1) {
            $this->data['title'] = "Mata Pelajaran " . $dataKelas['data'][0]['nama_kelas'];
            $this->data['kelas'] = $dataKelas['data'][0];
            $this->data['content'] = "mapel.list";

            $this->load->view('back/main', $this->data);
        } else {
            redirect(base_url('back/not-found'));
        }
    }

    public function tambah($metaKelas = "")
    {
        $dataKelas = $this->BackKelasModel->getByMeta($metaKelas);

        if ($dataKelas['total'] >= 1) {
            $this->data['title'] = "Tambah Mata Pelajaran " . $dataKelas['data'][0]['nama_kelas'];
            $this->data['kelas'] = $dataKelas['data'][0];
            $this->data['content'] = "mapel.form-insert";

            $this->load->view('back/main', $this->data);
        } else {
            redirect(base_url('back/not-found'));
        }
    }

    public function ubah($metaMapel = "")
    {
        $dataMapel = $this->BackMapelModel->getByMeta($metaMapel);

        if ($dataMapel['total'] >= 1) {

            $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

            if ($dataKelas['total'] >= 1) {
                $this->data['title'] = "Ubah Mata Pelajaran " . $dataMapel['data'][0]['nama_mapel'];
                $this->data['content'] = "mapel.form-update";
                $this->data['kelas'] = $dataKelas['data'][0];
                $this->data['id'] = $dataMapel['data'][0]['id_mapel'];

                $this->load->view('back/main', $this->data);
            } else {
                redirect(base_url('back/not-found'));
            }
        } else {
            redirect(base_url('back/not-found'));
        }
    }

    public function ubahDetail($metaMapel = "")
    {
        $dataMapel = $this->BackMapelModel->getByMeta($metaMapel);

        if ($dataMapel['total'] >= 1) {

            $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

            if ($dataKelas['total'] >= 1) {
                $this->data['title'] = "Ubah Detail Mata Pelajaran " . $dataMapel['data'][0]['nama_mapel'];
                $this->data['content'] = "mapel.form-update-detail";
                $this->data['kelas'] = $dataKelas['data'][0];
                $this->data['id'] = $dataMapel['data'][0]['id_mapel'];

                $this->load->view('back/main', $this->data);
            } else {
                redirect(base_url('back/not-found'));
            }
        } else {
            redirect(base_url('back/not-found'));
        }
    }


    public function siswa($metaMapel = "")
    {
        $dataMapel = $this->BackMapelModel->getByMeta($metaMapel);

        if ($dataMapel['total'] >= 1) {

            $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

            if ($dataKelas['total'] >= 1) {

                $this->data['title'] = "Daftar Siswa " . $dataMapel['data'][0]['nama_mapel'];
                $this->data['content'] = "mapel.list-siswa";
                $this->data['kelas'] = $dataKelas['data'][0];
                $this->data['mapel'] = $dataMapel['data'][0];
                $this->data['id'] = $dataMapel['data'][0]['id_mapel'];
                $this->data['meta_mapel'] = $metaMapel;

//				$this->data['siswa'] = $this->db->query("SELECT t1.posttest, t2.pretest, `user`.id_user, `mapel`.meta_link_mapel, `transaksi`.id_transaksi, `transaksi`.kode_voucher, `user`.nama_user, `user`.email_user, `user`.telepon_user, `redeem`.redeem_code, `transaksi`.tanggal AS tanggal_pembelian, `redeem`.TIMESTAMP AS tanggal_redeem, `user_mapel_progress`.progress, `user_mapel_progress`.updated_at AS tanggal_pengerjaan FROM `user` LEFT JOIN (SELECT log_ujian.nilai AS posttest, log_ujian.user_id FROM mapel JOIN bab ON mapel.id_mapel = bab.mapel_id JOIN materi ON materi.bab_id = bab.id_bab JOIN log_ujian ON materi.id_materi = log_ujian.materi_id WHERE posttest_status = 1 GROUP BY log_ujian.user_id ORDER BY log_ujian.id_log_ujian DESC) t1 ON user.id_user = t1.user_id LEFT JOIN (SELECT log_ujian.nilai AS pretest, log_ujian.user_id FROM mapel JOIN bab ON mapel.id_mapel = bab.mapel_id JOIN materi ON materi.bab_id = bab.id_bab JOIN log_ujian ON materi.id_materi = log_ujian.materi_id WHERE pretest_status = 1 GROUP BY log_ujian.user_id ORDER BY log_ujian.id_log_ujian DESC) t2 ON user.id_user = t2.user_id INNER JOIN transaksi ON `user`.id_user = transaksi.user_id INNER JOIN `detail_transaksi` ON `user`.id_user = `detail_transaksi`.user_id AND `transaksi`.id_transaksi = `detail_transaksi`.transaksi_id INNER JOIN `mapel` ON `detail_transaksi`.mapel_id = `mapel`.id_mapel LEFT JOIN `redeem` ON `redeem`.user_id = `user`.id_user LEFT JOIN `user_mapel_progress` ON `user_mapel_progress`.mapel_id = `mapel`.id_mapel AND `user_mapel_progress`.user_id = `user`.id_user WHERE mapel.meta_link_mapel = '$metaMapel' ORDER BY `transaksi`.tanggal DESC")->result_array();
                $this->data['siswa'] = $this->db->query("SELECT t1.id_transaksi, t4.nama_user, t4.email_user, t4.telepon_user, t1.kode_voucher, t1.tanggal_bayar AS tanggal_pembelian, t5.redeem_code, t5.`timestamp` AS tanggal_redeem, t7.nilai AS pretest, t8.nilai AS posttest, t6.progress, t6.updated_at AS tanggal_pengerjaan, t3.meta_link_mapel, t4.id_user, t9.rating, t9.ulasan FROM transaksi t1 JOIN detail_transaksi t2 ON t1.id_transaksi = t2.transaksi_id JOIN mapel t3 ON t2.mapel_id = t3.id_mapel JOIN `user` t4 ON t4.id_user = t2.user_id LEFT JOIN redeem t5 ON t5.user_id = t4.id_user AND t5.mapel_id = t3.id_mapel LEFT JOIN user_mapel_progress t6 ON t6.user_id = t4.id_user AND t6.mapel_id = t3.id_mapel LEFT JOIN (SELECT t1.id_mapel, t2.id_bab, t3.id_materi, t4.user_id, t4.nilai FROM mapel t1 JOIN bab t2 ON t2.mapel_id = t1.id_mapel JOIN materi t3 ON t3.bab_id = t2.id_bab JOIN log_ujian t4 ON t4.materi_id = t3.id_materi WHERE t2.pretest_status = 1 GROUP BY t4.user_id ORDER BY t4.id_log_ujian DESC ) t7 ON t7.user_id = t4.id_user AND t7.id_mapel = t3.id_mapel LEFT JOIN (SELECT t1.id_mapel, t2.id_bab, t3.id_materi, t4.user_id, t4.nilai FROM mapel t1 JOIN bab t2 ON t2.mapel_id = t1.id_mapel JOIN materi t3 ON t3.bab_id = t2.id_bab JOIN log_ujian t4 ON t4.materi_id = t3.id_materi WHERE t2.posttest_status = 1 GROUP BY t4.user_id ORDER BY t4.id_log_ujian DESC ) t8 ON t8.user_id = t4.id_user AND t8.id_mapel = t3.id_mapel LEFT JOIN rating t9 ON t9.user_id = t4.id_user AND t9.mapel_id = t3.id_mapel WHERE t3.meta_link_mapel = '$metaMapel' AND t1.`status` = 2 AND t1.kode_voucher != '' ORDER BY t1.tanggal DESC")->result_array();

                $this->load->view('back/main', $this->data);
            } else {
                redirect(base_url('back/not-found'));
            }
        } else {
            redirect(base_url('back/not-found'));
        }
    }

    public function excelLink()
    {
        $id = $_POST["id"];
        $this->load->library(['upload']);
        $new_name = time() . $_FILES["excel"]['name'];
        $config['file_name'] = $new_name;
        $config['upload_path'] = './upload/excel';
        $config['allowed_types'] = 'xls|xlsx';

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('excel')) {
            echo ul($this->upload->display_errors());
        } else {
            $nama_file = $this->upload->data('file_name');
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("upload/excel/" . $nama_file);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();
            $dataLink = [];
            $bab = -1;
            $idBab = 0;
            $urutanBab = 1;
            $urutanMateri = 1;
            for ($i = 2; $i <= count($data); $i++) {

                if ($sheet->getCell("C{$i}") == "" && $sheet->getCell("B{$i}") == "") {

                    $babJudul = $sheet->getCell("A{$i}")->getValue();
                    $metatitle = $this->BackBabModel->getMetaLink($babJudul);
                    $bab++;
                    $dataLink[$bab] = [
                        "nama_bab" => $babJudul,
                        "urutan_bab" => $urutanBab,
                        "mapel_id" => $id,
                        "meta_link_bab" => $metatitle
                    ];

                    $insertbab = $this->UniversalModel->insert("bab", $dataLink[$bab]);
                    $idBab = $insertbab["id"];
                    $urutanMateri = 1;
                    $urutanBab++;
                } else {
                    $materiJudul = $sheet->getCell("B{$i}")->getValue();
                    $materiId = $sheet->getCell("C{$i}")->getValue();
                    $durasi = $sheet->getCell("D{$i}")->getValue();
                    $metatitle = $this->BackMateriModel->getMetaLink($materiJudul);

                    $materi = [
                        "bab_id" => $idBab,
                        "nama_materi" => $materiJudul,
                        "url_video" => $materiId,
                        "urutan_materi" => $urutanMateri,
                        "tipe" => "video",
                        "meta_link_materi" => $metatitle,
                        "durasi" => $durasi,
                    ];

                    $dataLink[$bab]["materi"][] = $materi;
                    $insertmateri = $this->UniversalModel->insert("materi", $materi);

                    $urutanMateri++;
                }
            }

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($dataLink));
        }
    }

    public function diskusi($metaMapel = "")
    {
        $dataMapel = $this->BackMapelModel->getByMeta($metaMapel);

        if ($dataMapel['total'] >= 1) {
            $this->data['title'] = " Daftar Diskusi Mapel " . $dataMapel['data'][0]['nama_mapel'];
            $this->data['content'] = "diskusi.list";
            $this->data['mapel_id'] = $dataMapel['data'][0]['id_mapel'];
            $this->data['meta_mapel'] = $dataMapel['data'][0]['meta_link_mapel'];

            $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

            if ($dataKelas['total'] >= 1) {
                $this->data['kelas_id'] = $dataKelas['data'][0]['id_kelas'];
                $this->data['meta_kelas'] = $dataKelas['data'][0]['meta_link_kelas'];
            }

            $this->load->view('back/main', $this->data);
        } else {
            redirect(base_url('back/not-found'));
        }
    }


    // TAMPILAN DETAIL CLASS
    public function detail($metaMapel = "")
    {
        $dataMapel = $this->BackMapelModel->getByMeta($metaMapel);

        if ($dataMapel['total'] >= 1) {

            $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

            if ($dataKelas['total'] >= 1) {
                $this->data['title'] = "Tampilan Detail '" . $dataMapel['data'][0]['nama_mapel'] . "'";
                $this->data['content'] = "mapel.tampilan-detail";
                $this->data['kelas'] = $dataKelas['data'][0];
                $this->data['mapel'] = $dataMapel['data'][0];
                $this->data['id'] = $dataMapel['data'][0]['id_mapel'];

                //Bagian yang dinamis
                $this->data['section'] = ["video", "hasil", "preview", "portofolio", "sertifikat", "target"];

                $dataListhasil = $this->BackMapelModel->getListhasil($this->data['id']);

                if ($dataListhasil['total'] >= 1) {
                    $this->data['listhasil'] = $dataListhasil['data'];
                }

                $this->load->view('back/main', $this->data);
            }
        } else {
            redirect(base_url('back/not-found'));
        }
    }


    //    public function setMeta()
    //    {
    //        $dataBab = $this->BackMapelModel->getAll();
    //        $simpan = true;
    //        foreach ($dataBab['data'] as $key => $value) {
    //            $data = [
    //                "meta_link_materi" => $metatitle = $this->UniversalModel->getMetaLink("mapel", $value['nama_mapel']),
    //            ];
    //
    //            $simpan = $simpan && $this->BackMapelModel->updateData($value["id_mapel"], $data);
    //        }
    //    }
}
