<?php

$jmlSelesaiPerBab = [];

if ($bab["total"] > 0) {
    $i = 0;
    foreach ($bab["data"] as $keyBab => $valueBab) {
        if ($valueBab["materi"]["total"] > 0) {
            foreach ($valueBab["materi"]["data"] as $keyMateri => $valueMateri) {
                if ($keyMateri <= 0) {
                    $jmlSelesaiPerBab[$valueBab["id_bab"]] = 0;
                }

                if ($valueMateri["log_baca"] > 0 || $valueMateri["log_video"] > 0 || $valueMateri["log_ujian"] > 0 || $valueMateri["log_praktek"] > 0) {
                    $jmlSelesaiPerBab[$valueBab["id_bab"]]++;
                }
            }
        }
        $i++;
    }
}
?>
<div id="kelas-materi" aria-labelledby="kelas-materi-list" aria-selected="show" class="tab-pane fade show active"
     role="tabpanel">
    <div class="row mb-3">
        <div class="col">

            <?php
            $sebelum = "active";

            if ($bab["total"] > 0) {
                $i = 0;
                foreach ($bab["data"] as $keyBab => $valueBab) {
                    ?>

                    <ul class="materi-list">
                        <li>
                            <div class="container py-2">
                                <div class="row align-content-stretch">
                                    <div class="col-2 col-md-1 border-0">
                                        <?php
                                        $progressmateri = isset($jmlSelesaiPerBab[$valueBab["id_bab"]]) && $jmlSelesaiPerBab[$valueBab["id_bab"]] <= 0 || $valueBab["materi"]["total"] <= 0 ? 0 : $jmlSelesaiPerBab[$valueBab["id_bab"]] / $valueBab["materi"]["total"] * 100;
                                        ?>
                                        <span class="circle-progress" data-value="<?= $progressmateri / 100 ?>">
											<span class="circle-progress-text">
												<?= round($progressmateri, 1) ?>%
											</span>
										</span>
                                    </div>
                                    <div class="col pl-4 pl-md-0 align-items-center d-flex">
										<span class="h6 font-weight-light">
											<?= $valueBab["nama_bab"] ?>
										</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <ul>
                                <?php
                                if ($valueBab["materi"]["total"] > 0) {
                                    foreach ($valueBab["materi"]["data"] as $keyMateri => $valueMateri) {
                                        $active = "";
                                        $activeBtn = "ka-dark";

                                        if ($valueMateri["log_baca"] > 0 || $valueMateri["log_video"] > 0 || $valueMateri["log_ujian"] > 0 || $valueMateri["log_praktek"] > 0) {
                                            $active = "active";
                                            $activeBtn = "warning";
                                        }

                                        if ($keyBab == 0 && $keyMateri == 0) {
                                            $active = "active";
                                            $activeBtn = "warning";
                                        }
                                        ?>
                                        <li class="offset-0 offset-md-1">
                                            <div class="container py-0">
                                                <div class="row no-gutters align-content-stretch">
                                                    <div class="icon-materi-container pr-5 pr-md-3">
                                                        <div
                                                                class="icon-materi im-<?= $sebelum == "active" ? iconMateri[$valueMateri["tipe"]] : "mlock" ?> <?= $sebelum == "active" ? "active" : $active ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-0">
                                                        <b>
                                                            <?= $keyMateri + 1 ?>.
                                                        </b> &nbsp;
                                                    </div>
                                                    <div class="col">
                                                        <b>
                                                            <?= $valueMateri["nama_materi"] ?>
                                                        </b>
                                                        <br>
                                                        <small class="text-secondary">
                                                            <?php if ($valueMateri["tipe"] == "pilihan") {
                                                                $id_user = $_SESSION['siswaData']['id_user'];
                                                                $id_mapel = $valueBab['mapel_id'];
                                                                $id_materi = $valueMateri['id_materi'];
                                                                $countSoal = $this->db->query("SELECT COUNT(id_soal) as jumlah_soal FROM detail_transaksi INNER JOIN randomize ON detail_transaksi.id_detail_transaksi = randomize.id_detail_transaksi INNER JOIN bab ON detail_transaksi.mapel_id = bab.mapel_id INNER JOIN materi ON bab.id_bab = materi.bab_id INNER JOIN soal ON materi.id_materi = soal.materi_id AND randomize.id_package = soal.paket WHERE user_id = {$id_user} AND detail_transaksi.mapel_id = {$id_mapel} AND soal.materi_id = {$id_materi}")->row_array();
                                                                if (((int)$countSoal['jumlah_soal']) > 1) {
                                                                    echo ((int)$countSoal["jumlah_soal"]) . " " . satuanMateri[$valueMateri["tipe"]];
                                                                } else {
                                                                    echo ((int)$valueMateri['jml_soal']) . " " . satuanMateri[$valueMateri["tipe"]];
                                                                }
                                                            } else if ($valueMateri["tipe"] == "praktek") {
                                                                echo satuanMateri[$valueMateri["tipe"]];
                                                            } else {
                                                                echo ((int)$valueMateri["durasi"]) . " " . satuanMateri[$valueMateri["tipe"]];
                                                            } ?>
                                                        </small>
                                                    </div>
                                                    <div class="col-12 col-md-3 mt-md-0 mt-3 text-right">
                                                        <a href="<?= $sebelum == "active" || $keyBab == 0 && $keyMateri == 0 ? base_url("belajar/{$mapel["meta_link_mapel"]}/{$valueBab["meta_link_bab"]}/{$valueMateri["urutan_materi"]}") : "javascript:void();" ?>"
                                                           class="btn btn-outline-<?= $sebelum == "active" ? "warning" : "ka-dark" ?> btn-block">
                                                            <?= $sebelum == "active" ? "Pelajari" : "<i class='fa fa-lock'></i>" ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <?php
//										if ($active == "active") {
//											if ($keyBab == 0 && $keyMateri == 0) {
//												if ($valueMateri["log_baca"] > 0 || $valueMateri["log_video"] > 0 || $valueMateri["log_ujian"] > 0 || $valueMateri["log_praktek"] > 0) {
//													$sebelum = "active";
//												} else {
//													$sebelum = "belum";
//												}
//											} else {
//												$active = "belum";
//												if ($valueMateri["log_ujian"] > 0) {
//													$id_user = $_SESSION['siswaData']['id_user'];
//													$nilai = $this->db->get_where('log_ujian', ['materi_id' => $valueMateri['id_materi'], 'user_id' => $id_user])->row_array();
//													if ($valueBab["pretest_status"] == 0) {
//														if ($nilai['nilai'] >= 80.00) {
//															$sebelum = "active";
//														} else {
//															$sebelum = "belum";
//															$active = '';
//															$activeBtn = 'ka-dark';
//														}
//													}
//												}
//												if ($valueMateri["tipe"] == "pdf" && $valueMateri['webinar_status'] == 1) {
//													$userId = $_SESSION['siswaData']['id_user'];
//													$materiId = $valueMateri['id_materi'];
//													$userAbsen = $this->db->query("SELECT * FROM user_absen WHERE user_id = $userId AND materi_id = $materiId");
//													if ($userAbsen->num_rows() > 0) {
//														$sebelum = "active";
//													} else {
//														$sebelum = "belum";
//													}
//												}
//											}
//										} else {
//											$sebelum = "belum";
//										}

                                        if ($active != "active") {
                                            $sebelum = "belum";
                                        }
                                        if ($valueMateri["log_ujian"] > 0) {
                                            if ($valueBab["pretest_status"] == 0) {
                                                $id_user = $_SESSION['siswaData']['id_user'];
                                                $nilai = $this->db->get_where('log_ujian', ['materi_id' => $valueMateri['id_materi'], 'user_id' => $id_user])->row_array();
                                                if ($nilai['nilai'] < 80.00) {
                                                    $sebelum = "belum";
                                                }
                                            }
                                        }
                                        if ($valueMateri["log_baca"] > 0) {
                                            if ($valueMateri["tipe"] == "pdf" && $valueMateri['webinar_status'] == 1) {
                                                $userId = $_SESSION['siswaData']['id_user'];
                                                $materiId = $valueMateri['id_materi'];
                                                $userAbsen = $this->db->query("SELECT * FROM user_absen WHERE user_id = $userId AND materi_id = $materiId");
                                                if ($userAbsen->num_rows() == 0) {
                                                    $sebelum = "belum";
                                                }
                                            }
                                        }
//										if ($valueMateri["log_baca"] > 0) {
//											if ($valueMateri["tipe"] == "pdf" && $valueMateri['webinar_status'] == 1) {
//												$userId = $_SESSION['siswaData']['id_user'];
//												$materiId = $valueMateri['id_materi'];
//												$userAbsen = $this->db->query("SELECT * FROM user_absen WHERE user_id = $userId AND materi_id = $materiId");
//												if ($userAbsen->num_rows() == 0) {
//													$sebelum = "belum";
//												}
//											}
//										}
                                    }
                                } ?>
                            </ul>
                        </li>
                    </ul>
                    <?php
                    $i++;
                }
            }
            ?>
        </div>
    </div>
</div>

