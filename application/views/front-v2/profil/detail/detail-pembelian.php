<div class="col-12 col-md tab-pane fade" id="daftar-pembelian" role="tabpanel"
     aria-labelledby="daftar-pembelian" aria-selected="false">
    <div class="container py-0">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md tab-content">
                                <div class="row mb-3 border-bottom border-ka-light no-gutters">
                                    <div class="col-12">
                                        <ul class="nav profil-tab nav-fill" id="profil-tab"
                                            role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link py-2 active" id="sub-semua-2-list"
                                                   data-toggle="list"
                                                   href="#sub-semua-2" role="tab"
                                                   aria-controls="sub-semua-2">Semua</a>
                                            </li>

                                            <?php if (isset($this->db->dev)) { ?>
                                                <li class="nav-item">
                                                    <a class="nav-link py-2" id="sub-pembayaran-list"
                                                       data-toggle="list"
                                                       href="#sub-menunggu-2" role="tab"
                                                       aria-controls="sub-menunggu-2">
                                                        Menunggu Pembayaran
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link py-2" id="sub-lunas-list"
                                                       data-toggle="list" href="#sub-lunas"
                                                       role="tab" aria-controls="sub-lunas">
                                                        Lunas
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link py-2" id="sub-dibatalkan-list"
                                                       data-toggle="list"
                                                       href="#sub-dibatalkan" role="tab"
                                                       aria-controls="sub-dibatalkan">
                                                        Dibatalkan
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane fade show active" id="sub-semua-2" role="tablist"
                                     aria-labelledby="sub-semua-2">
                                    <?php
                                    if ($pembelian["total"] > 0) {
                                        foreach ($pembelian["data"] as $keyPembelian => $valuePembelian) {
                                            ?>
                                            <div class="card my-4 card-light">
                                                <div class="card-body p-3">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-12 col-lg-2 img-bg-fill lazy"
                                                                 data-src="<?= base_url() ?>upload/banner_mapel/<?= $valuePembelian["banner_mapel"] ?>">
                                                            </div>
                                                            <div class="col-12 col-lg d-flex flex-column">
                                                                <div class="row mb-auto">
                                                                    <div class="col">
                                                                        <div class="text-truncate"
                                                                             title="Menjadi Drafter Arsitektur & Sipil Handal dengan AutoCAD">
                                                                            <b><?= $valuePembelian["nama_mapel"] ?></b>
                                                                        </div>
                                                                        <div class="small">
                                                                            Kategori > <a
                                                                                    class="text-warning"
                                                                                    href="#"><?= $valuePembelian["nama_kelas"] ?></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <div class="small">
                                                                            No. Invoice
                                                                            <br>
                                                                            INV-<?= sprintf("%08d", $valuePembelian["transaksi_id"]) ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mt-lg-0 mt-3 col-lg-4">
                                                                <div class="row">
                                                                    <div class="col-12 text-lg-right text-center pb-3">
                                                                        <div>
                                                                            <b>Tanggal Pembelian</b>
                                                                        </div>
                                                                        <div class="text-secondary">
                                                                            <?= hari[date("w", strtotime($valuePembelian["created_at"]))] ?> <?= date("d/m/Y", strtotime($valuePembelian["created_at"])) ?>
                                                                        </div>
                                                                        <div class="text-secondary">
                                                                            <?= date("H:i", strtotime($valuePembelian["created_at"])) ?>
                                                                            WIB
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                    if ($valuePembelian["status_pembelian"] == 2) { ?>
                                                                        <a href="<?= base_url("konfirmasi/") . sprintf("%08d", $valuePembelian["transaksi_id"]) ?>"
                                                                           class="col-12 btn btn-success btn-rounded btn-block w-100 align-self-end small">
                                                                            LUNAS
                                                                        </a>
                                                                        <?php
                                                                    } else if ($valuePembelian["status_pembelian"] == 0) { ?>
                                                                        <a href="<?= base_url("konfirmasi/") . sprintf("%08d", $valuePembelian["transaksi_id"]) ?>"
                                                                           class="col-12 btn btn-danger btn-rounded btn-block w-100 align-self-end small">
                                                                            BELUM DIBAYAR
                                                                        </a>
                                                                        <?php
                                                                    } else if ($valuePembelian["status_pembelian"] == 1) { ?>
                                                                        <a href="<?= base_url("konfirmasi/") . sprintf("%08d", $valuePembelian["transaksi_id"]) ?>"
                                                                           class="col-12 btn btn-warning btn-rounded btn-block w-100 align-self-end small">
                                                                            TUNGGU
                                                                        </a>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }
                                    } else { ?>
                                        <div class="card card-light mt-4">
                                            <div class="card-body p-3">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-12 img-bg-fill text-center">
                                                            Anda belum membeli kelas sama sekali
                                                            <br>
                                                            Silahkan menuju ke <a
                                                                    href="<?= base_url("#pilih-kelas") ?>"
                                                                    class="text-warning">daftar
                                                                kelas</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>

                                <?php if (isset($this->db->dev)) { ?>
                                    <div class="tab-pane fade" id="sub-menunggu-2" role="tabpanel"
                                         aria-labelledby="sub-menunggu-2">
                                        <?php
                                        for ($i = 0; $i < 5; $i++) {
                                            ?>
                                            <div class="card my-4 card-light">
                                                <div class="card-body p-3">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-12 col-lg-2 img-bg-fill"
                                                                 style="background-image:url('<?= base_url() ?>assets/front/v2/img/bg-paket.jpg');">
                                                            </div>
                                                            <div class="col-12 col-lg d-flex flex-column">
                                                                <div class="row mb-auto">
                                                                    <div class="col">
                                                                        <div class="text-truncate"
                                                                             title="Menjadi Drafter Arsitektur & Sipil Handal dengan AutoCAD">
                                                                            <b>Menjadi Drafter Arsitektur &
                                                                                Sipil Handal
                                                                                dengan AutoCAD</b>
                                                                        </div>
                                                                        <div class="small">
                                                                            Kategori > <a
                                                                                    class="text-warning"
                                                                                    href="#">Sipil dan
                                                                                Arsitektur
                                                                                Digital</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <div class="small">
                                                                            No. Invoice
                                                                            <br>
                                                                            INV-KHJSNDKNUGHND
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mt-lg-0 mt-3 col-lg-4">
                                                                <div class="row">
                                                                    <div class="col-12 text-lg-right text-center pb-3">
                                                                        <div>
                                                                            <b>Tanggal Pembelian</b>
                                                                        </div>
                                                                        <div class="text-secondary">
                                                                            Selasa 26/05/2020
                                                                        </div>
                                                                        <div class="text-secondary">
                                                                            10:45 WIB
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                            class="col-12 btn btn-danger btn-rounded btn-block w-100 align-self-end small">
                                                                        BELUM DIBAYAR
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <div class="tab-pane fade" id="sub-konfirmasi-2" role="tabpanel"
                                         aria-labelledby="sub-konfirmasi">
                                        <?php
                                        for ($i = 0; $i < 5; $i++) {
                                            ?>
                                            <div class="card my-4 card-light">
                                                <div class="card-body p-3">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-12 col-lg-2 img-bg-fill"
                                                                 style="background-image:url('<?= base_url() ?>assets/front/v2/img/bg-paket.jpg');">
                                                            </div>
                                                            <div class="col-12 col-lg d-flex flex-column">
                                                                <div class="row mb-auto">
                                                                    <div class="col">
                                                                        <div class="text-truncate"
                                                                             title="Menjadi Drafter Arsitektur & Sipil Handal dengan AutoCAD">
                                                                            <b>Menjadi Drafter Arsitektur &
                                                                                Sipil Handal
                                                                                dengan AutoCAD</b>
                                                                        </div>
                                                                        <div class="small">
                                                                            Kategori > <a
                                                                                    class="text-warning"
                                                                                    href="#">Sipil dan
                                                                                Arsitektur
                                                                                Digital</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <div class="small">
                                                                            No. Invoice
                                                                            <br>
                                                                            INV-KHJSNDKNUGHND
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mt-lg-0 mt-3 col-lg-4">
                                                                <div class="row">
                                                                    <div class="col-12 text-lg-right text-center pb-3">
                                                                        <div>
                                                                            <b>Tanggal Pembelian</b>
                                                                        </div>
                                                                        <div class="text-secondary">
                                                                            Selasa 26/05/2020
                                                                        </div>
                                                                        <div class="text-secondary">
                                                                            10:45 WIB
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                            class="col-12 btn btn-warning btn-rounded btn-block w-100 align-self-end small">
                                                                        TUNGGU
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <div class="tab-pane fade" id="sub-lunas" role="tabpanel"
                                         aria-labelledby="sub-lunas">
                                        <?php
                                        for ($i = 0; $i < 5; $i++) {
                                            ?>
                                            <div class="card my-4 card-light">
                                                <div class="card-body p-3">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-12 col-lg-2 img-bg-fill"
                                                                 style="background-image:url('<?= base_url() ?>assets/front/v2/img/bg-paket.jpg');">
                                                            </div>
                                                            <div class="col-12 col-lg d-flex flex-column">
                                                                <div class="row mb-auto">
                                                                    <div class="col">
                                                                        <div class="text-truncate"
                                                                             title="Menjadi Drafter Arsitektur & Sipil Handal dengan AutoCAD">
                                                                            <b>Menjadi Drafter Arsitektur &
                                                                                Sipil Handal
                                                                                dengan AutoCAD</b>
                                                                        </div>
                                                                        <div class="small">
                                                                            Kategori > <a
                                                                                    class="text-warning"
                                                                                    href="#">Sipil dan
                                                                                Arsitektur
                                                                                Digital</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <div class="small">
                                                                            No. Invoice
                                                                            <br>
                                                                            INV-KHJSNDKNUGHND
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mt-lg-0 mt-3 col-lg-4">
                                                                <div class="row">
                                                                    <div class="col-12 text-lg-right text-center pb-3">
                                                                        <div>
                                                                            <b>Tanggal Pembelian</b>
                                                                        </div>
                                                                        <div class="text-secondary">
                                                                            Selasa 26/05/2020
                                                                        </div>
                                                                        <div class="text-secondary">
                                                                            10:45 WIB
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                            class="col-12 btn btn-success btn-rounded btn-block w-100 align-self-end small">
                                                                        LUNAS
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <div class="tab-pane fade" id="sub-dibatalkan" role="tabpanel"
                                         aria-labelledby="sub-dibatalkan">
                                        <?php
                                        for ($i = 0; $i < 5; $i++) {
                                            ?>
                                            <div class="card my-4 card-light">
                                                <div class="card-body p-3">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-12 col-lg-2 img-bg-fill"
                                                                 style="background-image:url('<?= base_url() ?>assets/front/v2/img/bg-paket.jpg');">
                                                            </div>
                                                            <div class="col-12 col-lg d-flex flex-column">
                                                                <div class="row mb-auto">
                                                                    <div class="col">
                                                                        <div class="text-truncate"
                                                                             title="Menjadi Drafter Arsitektur & Sipil Handal dengan AutoCAD">
                                                                            <b>Menjadi Drafter Arsitektur &
                                                                                Sipil Handal
                                                                                dengan AutoCAD</b>
                                                                        </div>
                                                                        <div class="small">
                                                                            Kategori > <a
                                                                                    class="text-warning"
                                                                                    href="#">Sipil dan
                                                                                Arsitektur
                                                                                Digital</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <div class="small">
                                                                            No. Invoice
                                                                            <br>
                                                                            INV-KHJSNDKNUGHND
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mt-lg-0 mt-3 col-lg-4">
                                                                <div class="row">
                                                                    <div class="col-12 text-lg-right text-center pb-3">
                                                                        <div>
                                                                            <b>Tanggal Pembelian</b>
                                                                        </div>
                                                                        <div class="text-secondary">
                                                                            Selasa 26/05/2020
                                                                        </div>
                                                                        <div class="text-secondary">
                                                                            10:45 WIB
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                            class="col-12 btn btn-danger btn-rounded btn-block w-100 align-self-end small">
                                                                        BATAL
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
