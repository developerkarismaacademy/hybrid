<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Materi extends CI_Controller
{
    private $data;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('back/MapelModel', 'BackMapelModel', true);
        $this->load->model('back/KelasModel', 'BackKelasModel', true);
        $this->load->model('back/BabModel', 'BackBabModel', true);
        $this->load->model('back/MateriModel', 'BackMateriModel', true);
        $this->load->model('back/SoalModel', 'BackSoalModel', true);

        $this->data['menu'] = "kelas";
        $this->FrontAuthModel->isLoggedInAdmin();
    }

    public function index($metaBab = "")
    {
        $dataBab = $this->BackBabModel->getByMeta($metaBab);

        if ($dataBab['total'] >= 1) {
            $dataMapel = $this->BackMapelModel->getById($dataBab['data'][0]['mapel_id']);

            if ($dataMapel['total'] >= 1) {

                $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

                if ($dataKelas['total'] >= 1) {
                    $this->data['title'] = " Materi " . $dataBab['data'][0]['nama_bab'];
                    $this->data['content'] = "materi.list";
                    $this->data['kelas'] = $dataKelas['data'][0];
                    $this->data['mapel'] = $dataMapel['data'][0];
                    $this->data['bab'] = $dataBab['data'][0];
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

    public function setUrutan($metaBab = "")
    {

        $dataBab = $this->BackBabModel->getByMeta($metaBab);

        if ($dataBab['total'] >= 1) {
            $dataMapel = $this->BackMapelModel->getById($dataBab['data'][0]['mapel_id']);

            if ($dataMapel['total'] >= 1) {
                $dataMateri = $this->BackMateriModel->getAllByBab($dataBab['data'][0]['id_bab']);

                $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

                if ($dataKelas['total'] >= 1) {
                    $this->data['title'] = "Setting Urutan Bab " . $dataMapel['data'][0]['nama_mapel'];
                    $this->data['content'] = "materi.form-urutan";
                    $this->data['kelas'] = $dataKelas['data'][0];
                    $this->data['mapel'] = $dataMapel['data'][0];
                    $this->data['bab'] = $dataBab['data'][0];
                    $this->data['materi'] = $dataMateri['data'];
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


    public function tambahPdf($metaBab = "")
    {
        $dataBab = $this->BackBabModel->getByMeta($metaBab);

        if ($dataBab['total'] >= 1) {
            $dataMapel = $this->BackMapelModel->getById($dataBab['data'][0]['mapel_id']);

            if ($dataMapel['total'] >= 1) {

                $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

                if ($dataKelas['total'] >= 1) {
                    $this->data['title'] = " Tambah Materi PDF " . $dataBab['data'][0]['nama_bab'];
                    $this->data['content'] = "materi.form-insert-pdf";
                    $this->data['kelas'] = $dataKelas['data'][0];
                    $this->data['mapel'] = $dataMapel['data'][0];
                    $this->data['bab'] = $dataBab['data'][0];

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

    public function editPdf($metaMateri = "")
    {
        $dataMateri = $this->BackMateriModel->getByMeta($metaMateri);
        $this->form_validation->set_rules('nama_materi', 'Nama Materi', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            if ($dataMateri['total'] >= 1) {
                $dataBab = $this->BackBabModel->getById($dataMateri['data'][0]['bab_id']);
                if ($dataBab['total'] >= 1) {

                    $this->data['title'] = " Edit Materi PDF " . $dataMateri['data'][0]['nama_materi'];
                    $this->data['content'] = "materi.form-update-pdf";
                    $this->data['materi'] = $dataMateri['data'][0];
                    $this->data['bab'] = $dataBab['data'][0];
                    $this->load->view('back/main', $this->data);
                } else {
                    redirect(base_url('back/not-found'));
                }
            } else {
                redirect(base_url('back/not-found'));
            }
        } else {
            $nama_materi = $this->input->post('nama_materi');
			$webinar_status = $this->input->post('webinar_status');
            $dataBab = $this->BackBabModel->getById($dataMateri['data'][0]['bab_id']);
            $metaBab = $dataBab['data'][0]['meta_link_bab'];
            $config['upload_path'] = './upload/materi-pdf';
            $config['allowed_types'] = 'pdf';
            $config['encrypt_name'] = true;
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('pdf_file')) {
                $error['pdf_file'] = $this->upload->display_errors();
                $pdf_file = $dataMateri['data'][0]['pdf_file'];
            } else {
                $pdf_file = $this->upload->data('file_name');
                if (file_exists('upload/materi-pdf/' . $dataMateri['data'][0]['pdf_file'])) {
                    unlink('upload/materi-pdf/' . $dataMateri['data'][0]['pdf_file']);
                }
            }
            $data = [
                'nama_materi' => $nama_materi,
                'pdf_file' => $pdf_file,
				'webinar_status' => $webinar_status,
            ];
            $this->db->where('meta_link_materi', $metaMateri);
            $this->db->update('materi', $data);
            redirect(base_url('back/materi/' . $metaBab));
        }
    }
    public function tambahVideo($metaBab = "")
    {
        $dataBab = $this->BackBabModel->getByMeta($metaBab);

        if ($dataBab['total'] >= 1) {
            $dataMapel = $this->BackMapelModel->getById($dataBab['data'][0]['mapel_id']);

            if ($dataMapel['total'] >= 1) {

                $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

                if ($dataKelas['total'] >= 1) {
                    $this->data['title'] = " Tambah Materi Video " . $dataBab['data'][0]['nama_bab'];
                    $this->data['content'] = "materi.form-insert-video";
                    $this->data['kelas'] = $dataKelas['data'][0];
                    $this->data['mapel'] = $dataMapel['data'][0];
                    $this->data['bab'] = $dataBab['data'][0];

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

    public function tambahTeks($metaBab = "")
    {
        $dataBab = $this->BackBabModel->getByMeta($metaBab);

        if ($dataBab['total'] >= 1) {
            $dataMapel = $this->BackMapelModel->getById($dataBab['data'][0]['mapel_id']);

            if ($dataMapel['total'] >= 1) {

                $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

                if ($dataKelas['total'] >= 1) {
                    $this->data['title'] = " Tambah Materi Teks " . $dataBab['data'][0]['nama_bab'];
                    $this->data['content'] = "materi.form-insert-teks";
                    $this->data['kelas'] = $dataKelas['data'][0];
                    $this->data['mapel'] = $dataMapel['data'][0];
                    $this->data['bab'] = $dataBab['data'][0];

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

    public function tambahLatihan($metaBab = "")
    {
        $dataBab = $this->BackBabModel->getByMeta($metaBab);

        if ($dataBab['total'] >= 1) {
            $dataMapel = $this->BackMapelModel->getById($dataBab['data'][0]['mapel_id']);

            if ($dataMapel['total'] >= 1) {

                $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

                if ($dataKelas['total'] >= 1) {
                    $this->data['title'] = " Tambah Materi Latihan " . $dataBab['data'][0]['nama_bab'];
                    $this->data['content'] = "materi.form-insert-latihan";
                    $this->data['kelas'] = $dataKelas['data'][0];
                    $this->data['mapel'] = $dataMapel['data'][0];
                    $this->data['bab'] = $dataBab['data'][0];

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

    public function tambahPraktek($metaBab = "")
    {
        $dataBab = $this->BackBabModel->getByMeta($metaBab);

        if ($dataBab['total'] >= 1) {
            $dataMapel = $this->BackMapelModel->getById($dataBab['data'][0]['mapel_id']);

            if ($dataMapel['total'] >= 1) {

                $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

                if ($dataKelas['total'] >= 1) {
                    $this->data['title'] = " Tambah Materi Praktek " . $dataBab['data'][0]['nama_bab'];
                    $this->data['content'] = "materi.form-insert-praktek";
                    $this->data['kelas'] = $dataKelas['data'][0];
                    $this->data['mapel'] = $dataMapel['data'][0];
                    $this->data['bab'] = $dataBab['data'][0];

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

    public function ubahVideo($metaMateri = "")
    {
        $dataMateri = $this->BackMateriModel->getByMeta($metaMateri);

        if ($dataMateri['total'] >= 1) {
            $dataBab = $this->BackBabModel->getById($dataMateri['data'][0]['bab_id']);

            if ($dataBab['total'] >= 1) {
                $dataMapel = $this->BackMapelModel->getById($dataBab['data'][0]['mapel_id']);

                if ($dataMapel['total'] >= 1) {

                    $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

                    if ($dataKelas['total'] >= 1) {
                        $this->data['title'] = " Ubah Materi Video " . $dataMateri['data'][0]['nama_materi'];
                        $this->data['content'] = "materi.form-update-video";
                        $this->data['kelas'] = $dataKelas['data'][0];
                        $this->data['mapel'] = $dataMapel['data'][0];
                        $this->data['bab'] = $dataBab['data'][0];
                        $this->data['id'] = $dataMateri['data'][0]['id_materi'];

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
        } else {
            redirect(base_url('back/not-found'));
        }
    }

    public function ubahTeks($metaMateri = "")
    {
        $dataMateri = $this->BackMateriModel->getByMeta($metaMateri);

        if ($dataMateri['total'] >= 1) {
            $dataBab = $this->BackBabModel->getById($dataMateri['data'][0]['bab_id']);

            if ($dataBab['total'] >= 1) {
                $dataMapel = $this->BackMapelModel->getById($dataBab['data'][0]['mapel_id']);

                if ($dataMapel['total'] >= 1) {

                    $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

                    if ($dataKelas['total'] >= 1) {
                        $this->data['title'] = " Ubah Materi Teks " . $dataMateri['data'][0]['nama_materi'];
                        $this->data['content'] = "materi.form-update-teks";
                        $this->data['kelas'] = $dataKelas['data'][0];
                        $this->data['mapel'] = $dataMapel['data'][0];
                        $this->data['bab'] = $dataBab['data'][0];
                        $this->data['id'] = $dataMateri['data'][0]['id_materi'];

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
        } else {
            redirect(base_url('back/not-found'));
        }
    }

    public function detail($metaMateri = "")
    {
        $dataMateri = $this->BackMateriModel->getByMeta($metaMateri);

        if ($dataMateri['total'] >= 1) {
            $dataBab = $this->BackBabModel->getById($dataMateri['data'][0]['bab_id']);

            if ($dataBab['total'] >= 1) {
                $dataMapel = $this->BackMapelModel->getById($dataBab['data'][0]['mapel_id']);

                if ($dataMapel['total'] >= 1) {

                    $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

                    if ($dataKelas['total'] >= 1) {
                        $this->data['title'] = " Detail Materi " . $dataMateri['data'][0]['nama_materi'];
                        $this->data['content'] = "materi.detail";
                        $this->data['kelas'] = $dataKelas['data'][0];
                        $this->data['mapel'] = $dataMapel['data'][0];
                        $this->data['bab'] = $dataBab['data'][0];
                        $this->data['id'] = $dataMateri['data'][0]['id_materi'];
                        $this->data['materi'] = $dataMateri['data'][0];

                        /*
                        -----
                        NAVIGATION
                        -----
                        */
                        $urutan_materi = $this->data['materi']['urutan_materi'];
                        $urutan_bab = $this->data['bab']['urutan_bab'];

                        $this->data["materiAwal"] = true;
                        $meta_link_materi['prev'] = $this->data['materi']['meta_link_materi'];
                        $tipe['prev'] = $this->data['materi']['tipe'];
                        $prefix['prev'] = "detail";

                        //prev materi or bab
                        $prevMateri = $this->BackMateriModel->getAllBy(
                            [
                                "urutan_materi" => $urutan_materi - 1,
                                "bab_id" => $this->data['bab']['id_bab']
                            ],
                            [1, 0],
                            ["urutan_materi" => "ASC"]
                        );
                        if ($prevMateri['total'] > 0) {
                            $this->data["materiAwal"] = false;

                            $prevMateri = $prevMateri['data'][0];
                            $meta_link_materi['prev'] = $prevMateri['meta_link_materi'];
                            $tipe['prev'] = $prevMateri['tipe'];

                            if ($tipe['prev'] == 'pilihan') {
                                $prefix['prev'] = "soal";
                                $tipe['prev'] = "latihan";
                            }
                        } else {
                            $prevBab = $this->BackMateriModel->getAllBy(
                                [
                                    "urutan_bab" => $urutan_bab - 1,
                                    "mapel_id" => $this->data['mapel']['id_mapel']
                                ],
                                [1, 0],
                                ["urutan_materi" => "DESC"]
                            );
                            if ($prevBab["total"] > 0) {
                                $this->data["materiAwal"] = false;

                                $prevBab = $prevBab['data'][0];
                                $meta_link_materi['prev'] = $prevBab['meta_link_materi'];
                                $tipe['prev'] = $prevBab['tipe'];

                                if ($tipe['prev'] == 'pilihan') {
                                    $prefix['prev'] = "soal";
                                    $tipe['prev'] = "latihan";
                                }
                            }
                        }


                        //next materi or bab
                        $this->data["materiAkhir"] = true;
                        $meta_link_materi['next'] = $this->data['materi']['meta_link_materi'];
                        $tipe['next'] = $this->data['materi']['tipe'];
                        $prefix['next'] = "detail";

                        $nextMateri = $this->BackMateriModel->getAllBy(
                            [
                                "urutan_materi" => $urutan_materi + 1,
                                "bab_id" => $this->data['bab']['id_bab']
                            ],
                            [1, 0],
                            ["urutan_materi" => "ASC"]
                        );
                        if ($nextMateri['total'] > 0) {
                            $this->data["materiAkhir"] = false;

                            $nextMateri = $nextMateri['data'][0];
                            $meta_link_materi['next'] = $nextMateri['meta_link_materi'];
                            $tipe['next'] = $nextMateri['tipe'];

                            if ($tipe['next'] == 'pilihan') {
                                $prefix['next'] = "soal";
                                $tipe['next'] = "latihan";
                            }
                        } else {
                            $nextBab = $this->BackMateriModel->getAllBy(
                                [
                                    "urutan_bab" => $urutan_bab + 1,
                                    "mapel_id" => $this->data['mapel']['id_mapel']
                                ],
                                [1, 0],
                                ["urutan_materi" => "ASC"]
                            );
                            if ($nextBab["total"] > 0) {
                                $this->data["materiAkhir"] = false;

                                $nextBab = $nextBab['data'][0];
                                $meta_link_materi['next'] = $nextBab['meta_link_materi'];
                                $tipe['next'] = $nextBab['tipe'];

                                if ($tipe['next'] == 'pilihan') {
                                    $prefix['next'] = "soal";
                                    $tipe['next'] = "latihan";
                                }
                            }
                        }

                        $this->data["linkSelanjutnya"] = base_url("back/materi/{$meta_link_materi['next']}/{$prefix['next']}/{$tipe['next']}");
                        $this->data["linkSebelumnya"] = base_url("back/materi/{$meta_link_materi['prev']}/{$prefix['prev']}/{$tipe['prev']}");


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
        } else {
            redirect(base_url('back/not-found'));
        }
    }


    public function ubahLatihan($metaMateri = "")
    {
        $dataMateri = $this->BackMateriModel->getByMeta($metaMateri);

        if ($dataMateri['total'] >= 1) {
            $dataBab = $this->BackBabModel->getById($dataMateri['data'][0]['bab_id']);

            if ($dataBab['total'] >= 1) {
                $dataMapel = $this->BackMapelModel->getById($dataBab['data'][0]['mapel_id']);

                if ($dataMapel['total'] >= 1) {

                    $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

                    if ($dataKelas['total'] >= 1) {
                        $this->data['title'] = " Ubah Materi Latihan " . $dataMateri['data'][0]['nama_materi'];
                        $this->data['content'] = "materi.form-update-latihan";
                        $this->data['kelas'] = $dataKelas['data'][0];
                        $this->data['mapel'] = $dataMapel['data'][0];
                        $this->data['bab'] = $dataBab['data'][0];
                        $this->data['id'] = $dataMateri['data'][0]['id_materi'];

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
        } else {
            redirect(base_url('back/not-found'));
        }
    }

    public function ubahPraktek($metaMateri = "")
    {
        $dataMateri = $this->BackMateriModel->getByMeta($metaMateri);

        if ($dataMateri['total'] >= 1) {
            $dataBab = $this->BackBabModel->getById($dataMateri['data'][0]['bab_id']);

            if ($dataBab['total'] >= 1) {
                $dataMapel = $this->BackMapelModel->getById($dataBab['data'][0]['mapel_id']);

                if ($dataMapel['total'] >= 1) {

                    $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

                    if ($dataKelas['total'] >= 1) {
                        $this->data['title'] = " Ubah Materi Praktek " . $dataMateri['data'][0]['nama_materi'];
                        $this->data['content'] = "materi.form-update-praktek";
                        $this->data['kelas'] = $dataKelas['data'][0];
                        $this->data['mapel'] = $dataMapel['data'][0];
                        $this->data['bab'] = $dataBab['data'][0];
                        $this->data['id'] = $dataMateri['data'][0]['id_materi'];

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
        } else {
            redirect(base_url('back/not-found'));
        }
    }

    public function pasteFromWord($metaMateri = "")
    {
        $dataMateri = $this->BackMateriModel->getByMeta($metaMateri);

        if ($dataMateri['total'] >= 1) {
            $dataBab = $this->BackBabModel->getById($dataMateri['data'][0]['bab_id']);

            if ($dataBab['total'] >= 1) {
                $dataMapel = $this->BackMapelModel->getById($dataBab['data'][0]['mapel_id']);

                if ($dataMapel['total'] >= 1) {

                    $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

                    if ($dataKelas['total'] >= 1) {
                        $this->data['title'] = "Tambah Batch Soal " . $dataMateri['data'][0]['nama_materi'];
                        $this->data['content'] = "materi.form-batch-latihan";
                        $this->data['kelas'] = $dataKelas['data'][0];
                        $this->data['mapel'] = $dataMapel['data'][0];
                        $this->data['bab'] = $dataBab['data'][0];
                        $this->data['materi'] = $dataMateri['data'][0];
                        $this->data['id'] = $dataMateri['data'][0]['id_materi'];

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
        } else {
            redirect(base_url('back/not-found'));
        }
    }

    public function DaftarSoal($metaMateri = "")
    {
        $dataMateri = $this->BackMateriModel->getByMeta($metaMateri);

        if ($dataMateri['total'] >= 1) {
            $dataBab = $this->BackBabModel->getById($dataMateri['data'][0]['bab_id']);

            if ($dataBab['total'] >= 1) {
                $dataMapel = $this->BackMapelModel->getById($dataBab['data'][0]['mapel_id']);

                if ($dataMapel['total'] >= 1) {

                    $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

                    if ($dataKelas['total'] >= 1) {
                        $paket = $_GET['paket'] ?? 1;
                        $this->data['paket'] = $paket;
                        $this->data['title'] = "Daftar Soal Latihan " . $dataMateri['data'][0]['nama_materi'] . "( Paket $paket)";
                        $this->data['content'] = "materi.list-soal";
                        $this->data['kelas'] = $dataKelas['data'][0];
                        $this->data['mapel'] = $dataMapel['data'][0];
                        $this->data['bab'] = $dataBab['data'][0];
                        $this->data['materi'] = $dataMateri['data'][0];


                        $this->data['paket'] = $_GET['paket'] ?? 1;
                        /*
                        -----
                        NAVIGATION
                        -----
                        */
                        $urutan_materi = $this->data['materi']['urutan_materi'];
                        $urutan_bab = $this->data['bab']['urutan_bab'];

                        $this->data["materiAwal"] = true;
                        $meta_link_materi['prev'] = $this->data['materi']['meta_link_materi'];
                        $tipe['prev'] = $this->data['materi']['tipe'];
                        $prefix['prev'] = "detail";

                        //prev materi or bab
                        $prevMateri = $this->BackMateriModel->getAllBy(
                            [
                                "urutan_materi" => $urutan_materi - 1,
                                "bab_id" => $this->data['bab']['id_bab']
                            ],
                            [1, 0],
                            ["urutan_materi" => "ASC"]
                        );
                        if ($prevMateri['total'] > 0) {
                            $this->data["materiAwal"] = false;

                            $prevMateri = $prevMateri['data'][0];
                            $meta_link_materi['prev'] = $prevMateri['meta_link_materi'];
                            $tipe['prev'] = $prevMateri['tipe'];

                            if ($tipe['prev'] == 'pilihan') {
                                $prefix['prev'] = "soal";
                                $tipe['prev'] = "latihan";
                            }
                        } else {
                            $prevBab = $this->BackMateriModel->getAllBy(
                                [
                                    "urutan_bab" => $urutan_bab - 1,
                                    "mapel_id" => $this->data['mapel']['id_mapel']
                                ],
                                [1, 0],
                                ["urutan_materi" => "DESC"]
                            );
                            if ($prevBab["total"] > 0) {
                                $this->data["materiAwal"] = false;

                                $prevBab = $prevBab['data'][0];
                                $meta_link_materi['prev'] = $prevBab['meta_link_materi'];
                                $tipe['prev'] = $prevBab['tipe'];

                                if ($tipe['prev'] == 'pilihan') {
                                    $prefix['prev'] = "soal";
                                    $tipe['prev'] = "latihan";
                                }
                            }
                        }


                        //next materi or bab
                        $this->data["materiAkhir"] = true;
                        $meta_link_materi['next'] = $this->data['materi']['meta_link_materi'];
                        $tipe['next'] = $this->data['materi']['tipe'];
                        $prefix['next'] = "detail";

                        $nextMateri = $this->BackMateriModel->getAllBy(
                            [
                                "urutan_materi" => $urutan_materi + 1,
                                "bab_id" => $this->data['bab']['id_bab']
                            ],
                            [1, 0],
                            ["urutan_materi" => "ASC"]
                        );
                        if ($nextMateri['total'] > 0) {
                            $this->data["materiAkhir"] = false;

                            $nextMateri = $nextMateri['data'][0];
                            $meta_link_materi['next'] = $nextMateri['meta_link_materi'];
                            $tipe['next'] = $nextMateri['tipe'];

                            if ($tipe['next'] == 'pilihan') {
                                $prefix['next'] = "soal";
                                $tipe['next'] = "latihan";
                            }
                        } else {
                            $nextBab = $this->BackMateriModel->getAllBy(
                                [
                                    "urutan_bab" => $urutan_bab + 1,
                                    "mapel_id" => $this->data['mapel']['id_mapel']
                                ],
                                [1, 0],
                                ["urutan_materi" => "ASC"]
                            );
                            if ($nextBab["total"] > 0) {
                                $this->data["materiAkhir"] = false;

                                $nextBab = $nextBab['data'][0];
                                $meta_link_materi['next'] = $nextBab['meta_link_materi'];
                                $tipe['next'] = $nextBab['tipe'];

                                if ($tipe['next'] == 'pilihan') {
                                    $prefix['next'] = "soal";
                                    $tipe['next'] = "latihan";
                                }
                            }
                        }

                        $this->data["linkSelanjutnya"] = base_url("back/materi/{$meta_link_materi['next']}/{$prefix['next']}/{$tipe['next']}");
                        $this->data["linkSebelumnya"] = base_url("back/materi/{$meta_link_materi['prev']}/{$prefix['prev']}/{$tipe['prev']}");

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
        } else {
            redirect(base_url('back/not-found'));
        }
    }

    public function tambahSoal($metaMateri = "")
    {
        $dataMateri = $this->BackMateriModel->getByMeta($metaMateri);

        if ($dataMateri['total'] >= 1) {
            $dataBab = $this->BackBabModel->getById($dataMateri['data'][0]['bab_id']);

            if ($dataBab['total'] >= 1) {
                $dataMapel = $this->BackMapelModel->getById($dataBab['data'][0]['mapel_id']);

                if ($dataMapel['total'] >= 1) {

                    $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

                    if ($dataKelas['total'] >= 1) {
                        $this->data['title'] = "Tambah Soal Latihan " . $dataMateri['data'][0]['nama_materi'];
                        $this->data['content'] = "materi.form-insert-soal";
                        $this->data['kelas'] = $dataKelas['data'][0];
                        $this->data['mapel'] = $dataMapel['data'][0];
                        $this->data['bab'] = $dataBab['data'][0];
                        $this->data['materi'] = $dataMateri['data'][0];
                        $this->data['id'] = $dataMateri['data'][0]['id_materi'];

                        $this->data['paket_soal'] = $_GET['paket'] ?? 1;
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
        } else {
            redirect(base_url('back/not-found'));
        }
    }

    public function ubahSoal($metaMateri = "", $idSoal = 0)
    {
        $dataMateri = $this->BackMateriModel->getByMeta($metaMateri);
        $dataSoal = $this->BackSoalModel->getById($idSoal);

        if ($dataMateri['total'] >= 1 && $dataSoal['total'] >= 1) {
            $dataBab = $this->BackBabModel->getById($dataMateri['data'][0]['bab_id']);

            if ($dataBab['total'] >= 1) {
                $dataMapel = $this->BackMapelModel->getById($dataBab['data'][0]['mapel_id']);

                if ($dataMapel['total'] >= 1) {

                    $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

                    if ($dataKelas['total'] >= 1) {
                        $this->data['title'] = "Ubah Soal Latihan " . $dataMateri['data'][0]['nama_materi'];
                        $this->data['content'] = "materi.form-update-soal";
                        $this->data['kelas'] = $dataKelas['data'][0];
                        $this->data['mapel'] = $dataMapel['data'][0];
                        $this->data['bab'] = $dataBab['data'][0];
                        $this->data['materi'] = $dataMateri['data'][0];
                        $this->data['id'] = $dataSoal['data'][0]['id_soal'];

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
        } else {
            redirect(base_url('back/not-found'));
        }
    }

    public function detailSoal($metaMateri = "", $idSoal = 0)
    {
        $dataMateri = $this->BackMateriModel->getByMeta($metaMateri);
        $dataSoal = $this->BackSoalModel->getById($idSoal);

        if ($dataMateri['total'] >= 1 && $dataSoal['total'] >= 1) {
            $dataBab = $this->BackBabModel->getById($dataMateri['data'][0]['bab_id']);

            if ($dataBab['total'] >= 1) {
                $dataMapel = $this->BackMapelModel->getById($dataBab['data'][0]['mapel_id']);

                if ($dataMapel['total'] >= 1) {

                    $dataKelas = $this->BackKelasModel->getById($dataMapel['data'][0]['kelas_id']);

                    if ($dataKelas['total'] >= 1) {
                        $this->data['title'] = "Detail Soal Latihan " . $dataMateri['data'][0]['nama_materi'];
                        $this->data['content'] = "materi.detail-soal";
                        $this->data['kelas'] = $dataKelas['data'][0];
                        $this->data['mapel'] = $dataMapel['data'][0];
                        $this->data['bab'] = $dataBab['data'][0];
                        $this->data['materi'] = $dataMateri['data'][0];
                        $this->data['id'] = $dataSoal['data'][0]['id_soal'];

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
        } else {
            redirect(base_url('back/not-found'));
        }
    }
}
