<?php
$adminkah = $this->session->backData["level_user"] == "administrasi";
$instrukturkah = $this->session->backData["level_user"] == "instruktur";
?>
<div class="content-page">
    <div class="content">
        <div class="container">

            <!-- start row -->

            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">
                            <a data-toggle="tooltip" data-placement="top" title=""
                               data-original-title="Daftar Bab <?= $mapel['nama_mapel'] ?>"
                               href="<?= base_url('back/bab/' . $mapel['meta_link_mapel']) ?>">
                                <i class="fa fa-arrow-left"></i>
                            </a>
                            <span
                                    title="<?= $title ?>"><?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?>
					</span>
                        </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a title="Daftar Bab <?= $mapel['nama_mapel'] ?>"
                                   href="<?= base_url('back/mapel/' . $mapel['meta_link_mapel']) ?>">
                                    <?= (strlen("Daftar Bab " . $mapel['nama_mapel']) > 18 ? substr("Daftar Bab " . $mapel['nama_mapel'], 0, 18) . "..." : "Daftar Bab " . $mapel['nama_mapel']) ?>
                                </a>
                            </li>
                            <li class="active">
					<span
                            title="<?= $title ?>"><?= (strlen($title) > 18 ? substr($title, 0, 18) . "..." : $title) ?></span>
                            </li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <input type="hidden" id="idKelas" value="<?= $kelas['id_kelas'] ?>">
            <input type="hidden" id="idMapel" value="<?= $mapel['id_mapel'] ?>">
            <input type="hidden" id="idBab" value="<?= $bab['id_bab'] ?>">

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
                        <h4 class="m-t-0 header-title"><b><?= $title ?></b></h4>
                        <button data-toggle="tooltip" data-placement="top" title="" data-original-title="Refresh Data"
                                onclick="ListMateri.refresh()"
                                class="btn btn-icon waves-effect waves-light btn-primary">
                            <i class="fa fa-refresh"></i>
                        </button>
                        <?php
                        if ($adminkah) {
                            ?>
                            <a data-toggle="tooltip" data-placement="top" title=""
                               data-original-title="Tambah Ujian/Test"
                               href="<?= base_url('back/materi/' . $bab['meta_link_bab'] . '/tambah/latihan') ?>"
                               class="btn btn-icon waves-effect waves-light btn-success">
                                <i class="fa fa-wpforms"></i>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title=""
                               data-original-title="Tambah Ujian Praktek"
                               href="<?= base_url('back/materi/' . $bab['meta_link_bab'] . '/tambah/praktek') ?>"
                               class="btn btn-icon waves-effect waves-light btn-success">
                                <i class="fa fa-paint-brush"></i>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title=""
                               data-original-title="Tambah Materi Teks"
                               href="<?= base_url('back/materi/' . $bab['meta_link_bab'] . '/tambah/teks') ?>"
                               class="btn btn-icon waves-effect waves-light btn-success">
                                <i class="fa fa-leanpub"></i>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title=""
                               data-original-title="Tambah Materi Video"
                               href="<?= base_url('back/materi/' . $bab['meta_link_bab'] . '/tambah/video') ?>"
                               class="btn btn-icon waves-effect waves-light btn-success">
                                <i class="fa fa-youtube-play"></i>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title=""
                               data-original-title="Tambah Materi PDF"
                               href="<?= base_url('back/materi/' . $bab['meta_link_bab'] . '/tambah/pdf') ?>"
                               class="btn btn-icon waves-effect waves-light btn-success">
                                <i class="fa fa-file-pdf-o"></i>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title=""
                               data-original-title="Setting Urutan Materi"
                               href="<?= base_url('back/materi/' . $bab['meta_link_bab'] . '/setting-urutan') ?>"
                               class="btn btn-icon waves-effect waves-light btn-warning">
                                <i class="fa fa-list"></i>
                            </a>

                            <?php
                        }
                        ?>
                        <div class="btn-limit">
                            <select onchange="ListMateri.limitChange()" class="selectpicker"
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
                                    <col class="col-sm-4">
                                    <col class="col-sm-2">
                                    <col class="col-sm-6 text-right">
                                </colgroup>
                                <thead>
                                <tr>
                                    <th id="th-nama">Materi</th>
                                    <th id="th-pretest">Jenis</th>
                                    <th class="text-right">ACTION</th>
                                </tr>
                                </thead>
                                <tbody id="loading">
                                <tr>
                                    <th colspan="3" class="text-center">
                                        <i class="fa fa-spin fa-circle-o-notch fa-4x"></i>
                                        <br>
                                        <br>
                                        Loading Data
                                    </th>
                                </tr>
                                </tbody>
                                <tbody id="table-data">
                                <tr id="clone-data" class="clone-data">
                                    <td class="nama-materi"> {{materi.nama_materi}}</td>
                                    <td class="jenis-materi"> {{materi.jenis_materi}}</td>
                                    <td class="text-right">
                                        <?php
                                        if ($adminkah) {
                                            ?>
                                            <a href="#"
                                               class="btn waves-effect waves-light btn-inverse link-asset hidden"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="Asset">
                                                <i class="glyphicon glyphicon-folder-open"></i>
                                            </a>
                                            <a href="#"
                                               class="btn waves-effect waves-light btn-teal link-detail"
                                               data-toggle="tooltip"
                                               data-placement="top" title="" data-original-title="Detail Materi">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="#"
                                               class="btn waves-effect waves-light btn-info link-package hidden"
                                               data-toggle="tooltip"
                                               data-placement="top" title="" data-original-title="Package Soal">
                                                <i class="fa fa-list-ol"></i>
                                            </a>
                                            <a href="#"
                                               class="btn waves-effect waves-light btn-info link-batch hidden"
                                               data-toggle="tooltip"
                                               data-placement="top" title="" data-original-title="Batch Soal Latihan">
                                                <i class="fa fa-file-word-o"></i>
                                            </a>
                                            <a href="#"
                                               class="btn waves-effect waves-light btn-orange link-daftar hidden"
                                               data-toggle="tooltip"
                                               data-placement="top" title="" data-original-title="Daftar Soal">
                                                <i class="fa fa-list-ol"></i>
                                            </a>
                                            <?php
                                        }
                                        ?>
                                        <a href="#"
                                           class="btn waves-effect waves-light btn-purple link-diskusi"
                                           data-toggle="tooltip"
                                           data-placement="top" title="Daftar Diskusi">
                                            <i class="mdi mdi-comment-processing-outline"></i>
                                        </a>

                                        <?php
                                        if ($adminkah) {
                                            ?>
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
                                            <?php
                                        }
                                        ?>
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


