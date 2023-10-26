<div class="col-12 col-md tab-pane fade" id="daftar-sertifikat" role="tabpanel" aria-labelledby="daftar-sertifikat" aria-selected="false">
    <div class="container py-0">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md tab-content">
                                <div class="row mb-3 border-bottom border-ka-light no-gutters">
                                    <div class="col-12">
                                        <ul class="nav profil-tab nav-fill" id="profil-sertifikat-filter" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link py-2 active" id="sub-selesai-2-list" data-toggle="list" href="#sub-selesai-2" role="tab" aria-controls="selesai">
                                                    Sertifikat
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-12 mt-4 col-md tab-content px-0" id="profil-sertifikat-list">
                                    <div class="tab-pane fade show active" id="sub-selesai-2" role="tabpanel" aria-labelledby="sub-selesai-2">
                                        <div class="row">

                                            <?php if (isset($mapel) && $mapel["total"] > 0) {
                                                foreach ($mapel["data"] as $keyMapel => $valueMapel) {
                                                    $done = $valueMapel["progress"] >= 100 ? true : false;
                                                    if ($done) {
                                                        // $salt = 'karismaacademy';
                                                        // $input_string = $_SESSION['siswaData']['id_user'];
                                                        // $salt_string = $salt . $input_string . $salt;
                                                        // $encoded_string = base64_encode($salt_string);
                                                        ?>
                                                        <div class="col-12 col-md-4 mb-3">
                                                            <a href="<?= base_url("download-sertifikat/{$valueMapel["meta_link_mapel"]}/{$_SESSION['siswaData']['id_user']}") ?>">
                                                                <div class="card card-light">
                                                                    <div class="position-relative">
                                                                        <div class="card-img-top img-bg-fill lazy" data-src="<?= base_url() ?>upload/banner_mapel/<?= $valueMapel["banner_mapel"] ?>" style="height: 130px;">
                                                                        </div>
                                                                        <div class="card-alert text-center small bg-success">
                                                                            <b>Sertifikat Selesai Seluruh Materi</b>
                                                                        </div>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="card-text">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="row mb-4">
                                                                                        <div class="col-12">
                                                                                            <div class="text-truncate small" title="<?= $valueMapel["nama_mapel"] ?>">
                                                                                                <b><?= $valueMapel["nama_mapel"] ?></b>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- <div class="col-12 small">
                                                                                  <div>
                                                                                    <b>Tanggal diperoleh:</b>
                                                                                  </div>
                                                                                  <div class="text-warning">
                                                                                    Selasa 26/05/2020
                                                                                  </div>
                                                                                </div> -->
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            } else { ?>
                                                <div class="card card-light w-100">
                                                    <div class="card-body p-3">
                                                        <div class="container-fluid">
                                                            <div class="row">
                                                                <div class="col-12 img-bg-fill text-center">
                                                                    Anda belum menyelesaikan kelas sama sekali
                                                                    <br>
                                                                    Silahkan menuju ke <a href="<?= base_url("profil") ?>" class="text-warning">daftar
                                                                        kelas saya</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="sub-lulus" role="tabpanel" aria-labelledby="sub-selesai-2">
                                        <div class="row">
                                            <?php if (isset($mapel) && $mapel["total"] > 0) {
                                                foreach ($mapel["data"] as $keyMapel => $valueMapel) {
                                                    $done = $valueMapel["progress"] >= 100 ? true : false;
                                                    if ($done) {
                                                        ?>
                                                        <div class="col-12 col-md-4 mb-3">
                                                            <a href="<?= base_url("raport/{$valueMapel["meta_link_mapel"]}") ?>">
                                                                <div class="card card-light">
                                                                    <div class="position-relative">
                                                                        <div class="card-img-top img-bg-fill lazy" data-src="<?= base_url() ?>upload/banner_mapel/<?= $valueMapel["banner_mapel"] ?>" style="height: 130px;">
                                                                        </div>
                                                                        <div class="card-alert text-center small bg-success">
                                                                            <b>Raport</b>
                                                                        </div>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="card-text">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="row mb-4">
                                                                                        <div class="col-12">
                                                                                            <div class="text-truncate small" title="<?= $valueMapel["nama_mapel"] ?>">
                                                                                                <b><?= $valueMapel["nama_mapel"] ?></b>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12 small">
                                                                                    <div>
                                                                                        <b>Tanggal diperoleh:</b>
                                                                                    </div>
                                                                                    <div class="text-warning">
                                                                                        Selasa 26/05/2020
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            } else { ?>
                                                <div class="card card-light w-100">
                                                    <div class="card-body p-3">
                                                        <div class="container-fluid">
                                                            <div class="row">
                                                                <div class="col-12 img-bg-fill text-center">
                                                                    Anda belum menyelesaikan kelas sama sekali
                                                                    <br>
                                                                    Silahkan menuju ke <a href="<?= base_url("profil") ?>" class="text-warning">daftar
                                                                        kelas saya</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
