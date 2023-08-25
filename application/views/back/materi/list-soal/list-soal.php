<div class="content-page">
    <div class="content">
        <div class="container">

            <!-- start row -->

            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">
                            <a data-toggle="tooltip" data-placement="top" title=""
                               data-original-title="Daftar Materi <?= $bab['nama_bab'] ?>"
                               href="<?= base_url('back/materi/' . $bab['meta_link_bab']) ?>">
                                <i class="fa fa-arrow-left"></i>
                            </a>
                            <span
                                    title="<?= $title ?>"><?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?>
							</span>
                        </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a title="Daftar Materi <?= $bab['nama_bab'] ?>"
                                   href="<?= base_url('back/materi/' . $bab['meta_link_bab']) ?>">
                                    <?= (strlen("Daftar Materi " . $bab['nama_bab']) > 16 ? substr("Daftar Materi " . $bab['nama_bab'], 0, 16) . "..." : "Daftar Materi " . $bab['nama_bab']) ?>
                                </a>
                            </li>
                            <li class="active">
                                <span title="<?= $title ?>"><?= (strlen($title) > 18 ? substr($title, 0, 18) . "..." : $title) ?></span>
                            </li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <input type="hidden" id="idKelas" value="<?= $kelas['id_kelas'] ?>">
            <input type="hidden" id="metaKelas" value="<?= $kelas['meta_link_kelas'] ?>">
            <input type="hidden" id="idMapel" value="<?= $mapel['id_mapel'] ?>">
            <input type="hidden" id="metaMapel" value="<?= $mapel['meta_link_mapel'] ?>">
            <input type="hidden" id="idBab" value="<?= $bab['id_bab'] ?>">
            <input type="hidden" id="metaBab" value="<?= $bab['meta_link_bab'] ?>">
            <input type="hidden" id="idMateri" value="<?= $materi['id_materi'] ?>">
            <input type="hidden" id="paketSoal" value="<?= $paket ?>">
            <input type="hidden" id="metaMateri" value="<?= $materi['meta_link_materi'] ?>">

            <!-- start row -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-icon alert-danger alert-dismissible fade in error-alert hidden"
                         role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <div class="error-alert-container">

                        </div>
                    </div>
                    <div class="card-box">
                        <div class="navigation-materi m-b-15 d-flex justify-content-between align-items-center">
                            <?php
                            if($materiAwal){ ?>
                                <a class="btn btn-inverse" href="<?= base_url("back/bab/{$bab['meta_link_mapel']}/") ?>"><i class="fa fa-th-list"></i> Bab
                                </a>
                                <?php
                            }else{ ?>
                                <a class="btn btn-danger" href="<?=$linkSebelumnya?>">Prev <i class="fa fa-chevron-left"></i></a>
                                <?php
                            }?>
                            <h4><?="BAB ".$bab['urutan_bab'].". ".$bab['nama_bab']?></h4>
                            <?php
                            if($materiAkhir){ ?>
                                <a class="btn btn-inverse" href="<?= base_url("back/bab/{$bab['meta_link_mapel']}/") ?>">Bab <i class="fa fa-th-list"></i>
                                </a>
                                <?php
                            }else{ ?>
                                <a class="btn btn-warning" href="<?=$linkSelanjutnya?>">Next <i class="fa fa-chevron-right"></i></a>
                                <?php
                            }?>
                        </div>

                        <h4 class="m-t-0 header-title"><b><?= $title ?></b></h4>
                        <button data-toggle="tooltip" data-placement="top" title="" data-original-title="Refresh Data"
                                onclick="ListSoal.refresh()"
                                class="btn btn-icon waves-effect waves-light btn-primary">
                            <i class="fa fa-refresh"></i>
                        </button>
                        <a data-toggle="tooltip" data-placement="top" title=""
                           data-original-title="Tambah Soal"
                           href="<?= base_url('back/materi/' . $materi['meta_link_materi'] . '/tambah-soal/latihan?paket='.$paket) ?>"
                           class="btn btn-icon waves-effect waves-light btn-success">
                            <i class="fa fa-wpforms"></i>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title=""
                           data-original-title="Tambah Batch Soal"
                           href="<?= base_url("back/materi/" . $materi['meta_link_materi'] . "/batch/latihan?paket=".$paket) ?>"
                           class="btn btn-icon waves-effect waves-light btn-success">
                            <i class="fa fa-file-word-o"></i>
                        </a>
                        <div class="btn-limit">
                            <select onchange="ListSoal.limitChange()" class="selectpicker"
                                    id="limit" data-style="btn-default">
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                                <option>100</option>
                            </select>
                        </div>
                        <div class="search-box pull-right">
                            <form id="form-search">
                                <div class="input-group">
								<span class="input-group-btn">
									<button type="submit"
                                            class="btn waves-effect waves-light btn-primary">
										<i class="fa fa-search"></i>
									</button>
								</span>
                                    <input type="text"
                                           id="search" name="search" class="form-control"
                                           placeholder="Search">
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive m-t-10">
                            <table
                                    class="table m-0 table-colored table-striped table-hover table-colored-bordered table-info table-bordered-info">
                                <colgroup>
                                    <col class="col-sm-7">
                                    <col class="col-sm-1">
                                    <col class="col-sm-4 text-right">
                                </colgroup>
                                <thead>
                                <tr>
                                    <th id="th-soal">Soal</th>
                                    <th id="th-kunci">Kunci</th>
                                    <th class="text-right">ACTION</th>
                                </tr>
                                </thead>
                                <tbody id="loading">
                                <tr>
                                    <th colspan="99" class="text-center">
                                        <i class="fa fa-spin fa-circle-o-notch fa-4x"></i>
                                        <br>
                                        <br>
                                        Loading Data
                                    </th>
                                </tr>
                                </tbody>
                                <tbody id="table-data">
                                <tr id="clone-data" class="clone-data">
                                    <td class="isi-soal"> {{soal.isi_soal}}</td>
                                    <td class="kunci-jawaban"> {{soal.kunci_jawaban}}</td>
                                    <td class="text-right">
                                        <a href="#"
                                           class="btn waves-effect waves-light btn-teal link-detail"
                                           data-toggle="tooltip"
                                           data-placement="top" title="" data-original-title="Detail Soal">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <a class="btn waves-effect waves-light btn-warning link-ubah"
                                           data-toggle="tooltip" data-placement="top" title=""
                                           href="#"
                                           data-original-title="Ubah">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="btn waves-effect waves-light btn-danger link-hapus"
                                           data-toggle="tooltip" data-placement="top" title=""
                                           href="#" data-original-title="Hapus">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination-box text-center  m-t-15 m-b-5" id="paging-container">
                            <p class="text-center font-weight-normal" id="paging-detail">
                                Menampilkan ({awal} - {akhir} Dari {total} Data) <br>
                                Halaman {current_page}, Total {total_page} Halaman
                            </p>
                            <ul class="pagination justify-content-center">
                                <li class="page-item" id="btn-page-previous">
                                    <a class="page-link" href="#">Previous</a>
                                </li>
                                <li id="btn-page" class="page-item page-number hide"><a class="page-link"
                                                                                        href="#">1</a>
                                </li>
                                <li class="page-item" id="btn-page-next">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
    </div>
</div>
<!-- container -->
