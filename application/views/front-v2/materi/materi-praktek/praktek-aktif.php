<?php
$user = $this->FrontAuthModel->getUserLoggedIn();
$user_id = $user['data']['id_user'];

$log_praktek = $this->db->get_where('log_praktek', ['materi_id' => $materiActive['id_materi'], 'user_id' => $user_id])->num_rows();
?>
<div class="mx-auto">
    <div class="container-fluid">
        <div class="row align-items-center mb-3">
            <div class="col-6 text-left d-flex align-items-center">
                <span class="h2">
                    <span class="badge badge-pill badge-ka-blue">SOAL PRAKTEK</span>
                </span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 bg-ka-light text-left p-4" id="kuis-soal">
                <?= $materiActive["isi_materi"]; ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 bg-ka-light p-4" id="kuis-jawaban">

                <table class="table table-bordered-info table-striped">
                    <thead>
                    <tr class="bg-primary text-white">
                        <th>NO</th>
                        <th>Subjek</th>
                        <th>Tipe</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody id="data-log">
                    <tr id="clone-data-praktik" class="d-none">
                        <th class="no">{no}</th>
                        <td class="subjek">{subjek}</td>
                        <td class="tipe">{tipe}</td>
                        <td class="link text-center">
                            <a target="_blank" class="link-download text-primary" style="font-size: 20px;"
                               href="javascript:void(0);">
                                <i class="fa fa-download"></i>
                            </a>
                            <a class="link-hapus text-danger" style="font-size: 20px;" href="javascript:void(0);">
                                <i class="fa fa-close"></i>
                            </a>
                        </td>
                    </tr>
                    <tr id="kosong" class="d-none">
                        <th colspan="4" class="text-center">Hasil Praktek Masih Kosong</th>
                    </tr>
                    </tbody>
                </table>


                <div data-kuis="kuis-container">
                    <div class="mb-3">
                        <p><b>Pilih Jenis File</b></p>
                    </div>
                    <div class="kuis-jenisfile">
                        <nav>
                            <div class="nav row no-gutters w-100" id="kuis-jenisfile-tab" role="tablist">
                                <a type="button"
                                   class="col-6 col-md btn btn-outline-ka-blue tipe-dokumen active"
                                   href="#file-dokumen" data-toggle="tab" role="tab" data-tipe="dokumen"
                                   aria-controls="file-dokumen" aria-selected="true">
                                    <i class="fa fa-file"></i> Dokumen
                                </a>
                                <a type="button" class="col-6 col-md btn btn-outline-ka-blue tipe-dokumen"
                                   href="#file-lampiran" data-toggle="tab" role="tab" data-tipe="lampiran"
                                   aria-controls="file-lampiran" aria-selected="false">
                                    <i class="fa fa-paperclip"></i> Lampiran
                                </a>
                                <a type="button" class="col-6 col-md btn btn-outline-ka-blue tipe-dokumen"
                                   href="#file-gambar" data-toggle="tab" role="tab" aria-controls="file-gambar"
                                   data-tipe="gambar" aria-selected="false">
                                    <i class="fa fa-image"></i> Gambar
                                </a>
                                <a type="button" class="col-6 col-md btn btn-outline-ka-blue tipe-dokumen"
                                   href="#file-link" data-tipe="link"
                                   data-toggle="tab" role="tab" aria-controls="file-link" aria-selected="false">
                                    <i class="fa fa-link"></i> Tautan / Link
                                </a>
                            </div>
                        </nav>
                    </div>
                    <div class="tab-content py-3" id="kuis-jenisfile-tabContent">
                        <div class="tab-pane fade show active" id="file-dokumen" role="tabpanel"
                             aria-labelledby="file-dokumen-tab">
                            <form id="form-dokumen" enctype="multipart/form-data">
                                <p class="mb-3">
                                    Silahkan lampirkan dokumen hasil praktek pada form di bawah
                                </p>
                                <input type="text" class="form-control mb-3"
                                       placeholder="Tambahkan subjek file . . ." name="dokumen-subjek">
                                <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" name="dokumen-file"
                                           accept=".doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                                    <label class="custom-file-label" for="dokumen-file-1">Pilih File...</label>
                                </div>
                                <p class="mb-3">
                                    Maksimal ukuran dokumen 20MB, gunakan Google Drive dan masukkan pada jenis
                                    "Link"
                                </p>

                            </form>
                            <button id="btn-dokumen" class="btn btn-danger">
                                SIMPAN
                            </button>
                            <?php if ($log_praktek > 0 && $materiAkhir === false) : ?>
                                <a href="<?= $linkSelanjutnya ?>" class="btn btn-danger px-5">MATERI SELANJUTNYA</a>
                            <?php endif; ?>
                        </div>
                        <div class="tab-pane fade" id="file-lampiran" role="tabpanel"
                             aria-labelledby="file-lampiran-tab">
                            <form id="form-lampiran" enctype="multipart/form-data">
                                <p class="mb-3">
                                    Silahkan lampirkan file hasil praktek pada form di bawah
                                </p>
                                <input type="text" class="form-control mb-3"
                                       placeholder="Tambahkan subjek file . . ." name="lampiran-subjek">
                                <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" name="lampiran-file">
                                    <label class="custom-file-label" for="lampiran-file-1">Pilih File...</label>
                                </div>
                                <p class="mb-3">
                                    Maksimal ukuran file 20MB, gunakan Google Drive dan masukkan pada jenis "Link"
                                </p>
                            </form>

                            <button id="btn-lampiran" class="d-block btn btn-danger w-25">
                                SIMPAN
                            </button>
                            <?php if ($log_praktek > 0 && $materiAkhir === false) : ?>
                                <a href="<?= $linkSelanjutnya ?>" class="btn btn-danger px-5">MATERI SELANJUTNYA</a>
                            <?php endif; ?>
                        </div>
                        <div class="tab-pane fade" id="file-gambar" role="tabpanel"
                             aria-labelledby="file-gambar-tab">
                            <form id="form-gambar" enctype="multipart/form-data">
                                <p class="mb-3">
                                    Silahkan lampirkan gambar hasil praktek pada form di bawah
                                </p>
                                <input type="text" class="form-control mb-3"
                                       placeholder="Tambahkan subjek file . . ." name="gambar-subjek">
                                <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" name="gambar-file"
                                           accept="image/*">
                                    <label class="custom-file-label" for="gambar-file-1">Pilih File...</label>
                                </div>
                                <p class="mb-3">
                                    Maksimal ukuran gambar 20MB, gunakan Google Drive dan masukkan pada jenis "Link"
                                </p>
                            </form>

                            <button id="btn-gambar" class="d-block btn btn-danger w-25">
                                SIMPAN
                            </button>
                            <?php if ($log_praktek > 0 && $materiAkhir === false) : ?>
                                <a href="<?= $linkSelanjutnya ?>" class="btn btn-danger px-5">MATERI SELANJUTNYA</a>
                            <?php endif; ?>
                        </div>
                        <div class="tab-pane fade" id="file-link" role="tabpanel"
                             aria-labelledby="file-link-tab">

                            <form id="form-link" enctype="multipart/form-data">
                                <p class="mb-3">
                                    Silahkan lampirkan tautan hasil praktek pada form di bawah
                                </p>
                                <input type="text" class="form-control mb-3"
                                       placeholder="Tambahkan subjek link . . ." name="link-subjek">
                                <input type="text" class="form-control mb-3"
                                       placeholder="Tambahkan link Google Drive . . ." name="link-link">
                                <p class="mb-3">
                                    Untuk petunjuk mendapatkan link yang di bagikan, klik <a href="#">di sini</a>
                                </p>

                                <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
                                    Link akan <strong>dicek kevalidannya!</strong> Mohon gunakan dengan bijak.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</ span>
                                    </button>
                                </div>
                            </form>

                            <button id="btn-link" class="d-block btn btn-danger w-25">
                                SIMPAN
                            </button>
                            <?php if ($log_praktek > 0 && $materiAkhir === false) : ?>
                                <a href="<?= $linkSelanjutnya ?>" class="btn btn-danger px-5">MATERI SELANJUTNYA</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
