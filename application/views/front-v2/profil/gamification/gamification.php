<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description"
          content="Kursus online untuk keahlian Web, Office, Sipil, dan lain lain! Khusus di Karisma Academy">
    <meta name="author" content="Karisma Academy">
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>/assets/back/images/favicon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
          integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"/>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
          integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <!-- Toaster -->
    <link href="<?= base_url() ?>/assets/front/v2/plugins/toastr/css/toastr.min.css" media="none" rel="stylesheet"
          onload="if(media!='all')media='all'">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/front/') ?>css/gamification.css?v=<?= time() ?>"/>
    <title>
        <?= $title ?? "" ?> - Kursus Online
    </title>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-custom fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url() ?>">
            <img src="<?= base_url('assets/front/') ?>img/logo.png" height="60" alt=""/>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </button>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mr-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url("tentang") ?>">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url("kelas") ?>">Cari</a>
                </li>
                <li class="nav-item dropdown" id="kursus-list">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Kursus
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <?php
                        $navbarKelas = $this->FrontKelasModel->getAllKelas();
                        if ($navbarKelas["total"] > 0) {
                            foreach ($navbarKelas["data"] as $val) {
                                ?>
                                <a class="dropdown-item" href="<?= base_url("kelas#{$val['meta_link_kelas']}") ?>"
                                   data-namakursus="<?= $val['meta_link_kelas'] ?>"
                                   value="<?= $val['id_kelas'] ?>"><?= $val['nama_kelas'] ?></a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('prakerja') ?>">Prakerja</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>profil/gamification">Tukar Poin</a>
                </li>

                <?php if ($this->session->userdata("siswaData")) { ?>

                    <li class="nav-item dropdown">
                        <div class="nav-link dropdown-toggle btn btn-warning font-weight-normal" href="#"
                             id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                             aria-expanded="false">
                            <i class="fa fa-user"></i>
                            <?= $this->session->siswaData["nama_depan"] ?? "" ?>
                        </div>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?= base_url("keranjang") ?>">Keranjang</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url("profil") ?>">Profil</a>
                            <a class="dropdown-item" href="<?= base_url("logout") ?>">Logout</a>
                        </div>
                    </li>

                <?php } else { ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link  btn btn-warning font-weight-normal" href="<?= base_url("login") ?>"
                           id="navbarDropdown">
                            DAFTAR/MASUK
                        </a>

                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
<main>
    <section class="section-banner">
        <div class="container">
            <div class="row text-center">
                <div class="col-12 ">
                    <a href="<?= base_url('profil') ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                        Kembali</a>
                </div>
                <div class="col-12 ">
                    <img src="<?= base_url('assets/front/') ?>img/banner.png"
                         alt="<?= base_url('assets/front/') ?>img/banner.png" class="img-fluid img-banner">
                </div>
                <div class="col-12">
                    <p class="desc">Selesaikan Misinya, Tukarkan Gold untuk Upgrade Kompetensimu!</p>
                </div>
                <div class="col-12">
                    <div class="d-none d-lg-block d-md-block">
                        <ul class="nav nav-pills nav-fill custom-tabs" id="myTab" role="tablist">
                            <li class="nav-item " role="presentation">
                                <a class="nav-link active" href="#" id="klaim-tab" data-toggle="tab"
                                   data-target="#klaim" type="button" role="tab" aria-controls="klaim"
                                   aria-selected="true"><img class="icon"
                                                             src="<?= base_url('assets/front/') ?>img/ic-bonus.svg"
                                                             alt=""> Klaim
                                    Bonus</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="#" id="dapatkan-tab" data-toggle="tab"
                                   data-target="#dapatkan" type="button" role="tab" aria-controls="dapatkan"
                                   aria-selected="true"><img class="icon"
                                                             src="<?= base_url('assets/front/') ?>img/ic-dapatkan.svg"
                                                             alt="">
                                    Dapatkan Gold</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="#" id="history-tab" data-toggle="tab"
                                   data-target="#history" type="button" role="tab" aria-controls="history"
                                   aria-selected="true"><img class="icon"
                                                             src="<?= base_url('assets/front/') ?>img/ic-history.svg"
                                                             alt="">History</a>
                            </li>
                            <div class="panel rounded"></div>
                        </ul>
                    </div>
                    <div class="d-block d-lg-none d-md-none">
                        <nav class="nav nav-pills flex-column flex-sm-row custom-tabs" id="myTab" role="tablist">
                            <a class="flex-sm-fill text-sm-center nav-link active" href="#" id="klaim-tab"
                               data-toggle="tab" data-target="#klaim" type="button" role="tab"
                               aria-controls="klaim" aria-selected="true"><img class="icon"
                                                                               src="<?= base_url('assets/front/') ?>img/ic-bonus.svg"
                                                                               alt=""> Klaim Bonus</a>
                            <a class="flex-sm-fill text-sm-center nav-link" href="#" id="dapatkan-tab"
                               data-toggle="tab" data-target="#dapatkan" type="button" role="tab"
                               aria-controls="dapatkan" aria-selected="true"><img class="icon"
                                                                                  src="<?= base_url('assets/front/') ?>img/ic-dapatkan.svg"
                                                                                  alt=""> Dapatkan
                                Gold</a>
                            <a class="flex-sm-fill text-sm-center nav-link" href="#" id="history-tab"
                               data-toggle="tab" data-target="#history" type="button" role="tab"
                               aria-controls="history" aria-selected="true"><img class="icon"
                                                                                 src="<?= base_url('assets/front/') ?>img/ic-history.svg"
                                                                                 alt=""> History</a>
                        </nav>
                    </div>
                    <div class="tab-content " id="myTabContent">
                        <div class="tab-pane active klaim tab-slide" id="klaim" role="tabpanel"
                             aria-labelledby="klaim-tab">
                            <div class="header row">
                                <div class="col-12 col-lg-7 col-md-6 col-xl-7">
                                    <div class="gold-info">
                                        <div class="float-left">
                                            <img class="info-img"
                                                 src="<?= base_url('assets/front/') ?>img/ic-coin.png" alt="">
                                        </div>
                                        <div class="float-left">
                                            <h1>
                                                <?= isset($coin['coin']) ? $coin['coin'] : 0 ?>
                                            </h1>
                                            <p>Gold Kamu</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-5 col-md-6 col-xl-5">
                                    <div class="info-misi">
                                        <div class="float-left">
                                            <img class="info-img"
                                                 src="<?= base_url('assets/front/') ?>img/ic-misi.png" alt="">
                                        </div>
                                        <div class="float-left pl-2">
                                            <h1>
                                                <?= $mission ?>
                                            </h1>
                                            <p>Misi telah selesai</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-none d-lg-block d-md-block">
                                <div class="footer row">

                                    <div class="col-6 col-md-7 col-lg-7">
                                        <div class="float-left">
                                            <img class="info-img"
                                                 src="<?= base_url('assets/front/') ?>img/ic-coin-tukar.png" alt="">
                                        </div>
                                        <?php
                                        $amount = isset($balance) ? $balance['balance'] : 0;
                                        $amount_formatted = number_format($amount, 0, ',', '.');
                                        ?>
                                        <div class="float-left pl-2">
                                            <h1>
                                                <?= 'Rp ' . $amount_formatted; ?>
                                            </h1>
                                            <p>Saldo Kamu</p>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-5 col-lg-5 text-right">
                                        <button type="button" class="btn btn-success btn-block btn-custom"
                                                data-toggle="modal" data-target="#tarik-saldo ">
                                            Tarik Saldo
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="tarik-saldo" tabindex="-1"
                                             aria-labelledby="tarik-saldo-label" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="tarik-saldo-label">Tarik Saldo PC
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-left">
                                                        <form
                                                                action="<?= base_url('front-v2/Gamification/exchange_balance') ?>"
                                                                method="post">

                                                            <div class="form-group text-left">
                                                                <label
                                                                        for="exampleFormControlSelect1">eWallet</label>
                                                                <select class="form-control"
                                                                        id="exampleFormControlSelect1" name="bank-type"
                                                                        required>
                                                                    <option value="ovo">Ovo</option>
                                                                    <option value="dana">Dana</option>
                                                                    <option value="gopay">Gopay</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Phone Number</label>
                                                                <input type="text" class="form-control" id=""
                                                                       placeholder="12345678" name="bank-number"
                                                                       onkeypress="return onlyNumberKey(event)"
                                                                       value="<?= $this->session->siswaData["telepon_user"] ?? "" ?>"
                                                                       required>
                                                            </div>
                                                            <button
                                                                    class="btn btn-success btn-block">Submit
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="footer d-block d-lg-none d-md-none">
                                <div class="row">
                                    <div class="col-3">
                                        <img src="<?= base_url('assets/front/') ?>img/ic-coin-tukar.png" alt="">
                                    </div>
                                    <div class="col-9">

                                        <h1>
                                            <?= 'Rp ' . $amount_formatted; ?>
                                        </h1>
                                        <p>Saldo Kamu</p>
                                    </div>
                                    <div class="col-12 text-center">
<!--                                         btn beta-->
<!--                                        <button type="button" class="btn btn-success btn-block btn-custom"-->
<!--                                                data-toggle="modal" data-target="#tarik-saldo ">-->
<!--                                            Tarik Saldo Mobile-->
<!--                                        </button>-->

                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-success w-50" data-toggle="modal" data-target="#tarik-saldo-mobile">
                                            Tarik Saldo
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="tarik-saldo-mobile" tabindex="-1"
                                             aria-labelledby="tarik-saldo-label" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Tarik Saldo</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form
                                                                action="<?= base_url('front-v2/Gamification/exchange_balance') ?>"
                                                                method="post">

                                                            <div class="form-group text-left">
                                                                <label
                                                                        for="exampleFormControlSelect1">eWallet</label>
                                                                <select class="form-control"
                                                                        id="exampleFormControlSelect1" name="bank-type"
                                                                        required>
                                                                    <option value="ovo">Ovo</option>
                                                                    <option value="dana">Dana</option>
                                                                    <option value="gopay">Gopay</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Phone Number</label>
                                                                <input type="text" class="form-control" id=""
                                                                       placeholder="12345678" name="bank-number"
                                                                       onkeypress="return onlyNumberKey(event)"
                                                                       value="<?= $this->session->siswaData["telepon_user"] ?? "" ?>"
                                                                       required>
                                                            </div>
                                                            <button
                                                                    class="btn btn-success btn-block">Submit
                                                            </button>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane dapatkan" id="dapatkan" role="tabpanel" aria-labelledby="dapatkan-tab">
                            <div class="content">
                                <h1>Dapatkan Gold</h1>
                                <p>Tukarkan kode invoice pembelian pelatihan prakerja kamu dan raih 300 gold.</p>
                                <form action="<?= base_url() ?>front-v2/Gamification/exchange_invoice" method="post"
                                      id="form-dapatkan">
                                    <div class="mb-3">
                                        <input type="text" class="form-control"
                                               placeholder="Masukkan Kode Invoice  . . ." name="invoice" id='invoice'
                                               required>
                                    </div>
                                    <div class="mb-1">
                                        <button type="submit" class="btn btn-primary">Redeem Code</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane history" id="history" role="tabpanel" aria-labelledby="history-tab">
                            <nav class="nav nav-pills flex-column flex-sm-row" id="historyTab" role="tablist">
                                <a class="flex-sm-fill text-sm-center nav-link active" href="#" id="gold-dapat-tab"
                                   data-toggle="tab" data-target="#gold-dapat" type="button" role="tab"
                                   aria-controls="gold-dapat" aria-selected="true">Gold Didapatkan</a>
                                <a class="flex-sm-fill text-sm-center nav-link" href="#" id="gold-tukar-tab"
                                   data-toggle="tab" data-target="#gold-tukar" type="button" role="tab"
                                   aria-controls="gold-tukar" aria-selected="true">Gold Ditukarkan</a>
                            </nav>
                            <div class="tab-content" id="historyTabContent">
                                <div class="tab-pane active gold-dapat" id="gold-dapat" role="tabpanel"
                                     aria-labelledby="gold-dapat-tab">
                                    <?php foreach ($user_invoice_prakerja as $uip): ?>
                                        <?php
                                        $date = strtotime($uip['created_at']);
                                        ?>
                                        <div class="row mb-5">
                                            <div class="col-12 col-lg-3 col-md-3">
                                                <img src="<?= base_url('upload/mapel/') ?><?= $uip['gambar_mapel'] ?>"
                                                     alt="" class="img-fluid">
                                            </div>
                                            <div class="col-12 col-lg-9 col-md-9 row">
                                                <div class="col-12 col-sm-12 col-lg-7 col-md-7 text-left">
                                                    <h6>
                                                        <?= $uip['nama_mapel'] ?>
                                                    </h6>
                                                    <p><img src="<?= base_url('assets/front/') ?>img/ic-coin.png"
                                                            alt="coin"><?= $uip['coin'] ?></p>
                                                </div>
                                                <div class="col-12 col-sm-12 col-lg-5 col-md-5 text-right mb-3">
                                                    <h6>Tanggal Penukaran</h6>
                                                    <p>
                                                        <?= date('d F Y', $date) ?>
                                                    </p>
                                                    <p>
                                                        <?= date('H:i:s', $date) ?>
                                                    </p>
                                                </div>
                                                <div class="col-12">
                                                    <button class="btn btn-success btn-block btn-sm">Success</button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="tab-pane gold-tukar" id="gold-tukar" role="tabpanel"
                                     aria-labelledby="gold-tukar-tab">

                                    <?php $index = 1; ?>
                                    <?php foreach ($gamification_transaction as $gt): ?>
                                        <?php
                                        $date = strtotime($gt['created_at']);
                                        ?>
                                        <div class="row mb-5">
                                            <div class="col-12 col-lg-3 col-md-3">
                                                <img src="<?= base_url('upload/mapel/') ?><?= $gt['gambar_mapel'] ?>"
                                                     alt="" class="img-fluid">
                                            </div>
                                            <div class="col-12 col-lg-9 col-md-9 row">
                                                <div class="col-12 col-sm-12 col-lg-7 col-md-7 text-left">
                                                    <h6>
                                                        <?= $gt['nama_mapel'] ?>
                                                    </h6>
                                                    <p><img src="<?= base_url('assets/front/') ?>img/ic-coin-tukar.png"
                                                            alt="coin"><?= 'Rp ' . number_format($gt['balance'], 0, ',', '.') ?>
                                                    </p>
                                                </div>
                                                <div class="col-12 col-sm-12 col-lg-5 col-md-5 text-right mb-3">
                                                    <h6>Tanggal Penukaran</h6>
                                                    <p>
                                                        <?= date('d F Y', $date) ?>
                                                    </p>
                                                    <p>
                                                        <?= date('H:i:s', $date) ?>
                                                    </p>
                                                    <h6>Status</h6>
                                                    <span
                                                            class="badge badge-pill badge-<?= ($gt['status'] === 'success') ? 'success' : 'warning'; ?>"><?= ($gt['status'] === 'success') ? 'success' : 'pending'; ?></span>
                                                </div>
                                                <?php if ($gt['status'] != 'success'): ?>
                                                    <div class="col-12">
                                                        <button type="button" class="btn btn-sm btn-info btn-block"
                                                                data-toggle="modal"
                                                                data-target="#update-payment-<?= $index ?> ">Update
                                                            Payment
                                                        </button>
                                                        <div class="modal fade" id="update-payment-<?= $index ?>"
                                                             tabindex="-1"
                                                             aria-labelledby="update-payment-<?= $index ?>-label"
                                                             aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="tarik-saldo-label">
                                                                            Update Payment
                                                                        </h5>
                                                                        <button type="button" class="close"
                                                                                data-dismiss="modal"
                                                                                aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body text-left">
                                                                        <form
                                                                                action="<?= base_url('profil/gamification/update_payment/' . $gt['id']) ?>"
                                                                                method="post">

                                                                            <div class="form-group text-left">
                                                                                <label
                                                                                        for="exampleFormControlSelect1">eWallet</label>
                                                                                <select class="form-control"
                                                                                        id="exampleFormControlSelect1"
                                                                                        name="bank-type" required>
                                                                                    <option
                                                                                            value="ovo" <?= ($gt['bank_type'] == 'ovo') ? 'selected' : '' ?>>
                                                                                        Ovo
                                                                                    </option>
                                                                                    <option
                                                                                            value="dana" <?= ($gt['bank_type'] == 'dana') ? 'selected' : '' ?> >
                                                                                        Dana
                                                                                    </option>
                                                                                    <option
                                                                                            value="gopay" <?= ($gt['bank_type'] == 'gopay') ? 'selected' : '' ?> >
                                                                                        Gopay
                                                                                    </option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="">Phone Number</label>
                                                                                <input type="text" class="form-control"
                                                                                       id=""
                                                                                       placeholder="12345678"
                                                                                       name="bank-number"
                                                                                       onkeypress="return onlyNumberKey(event)"
                                                                                       value="<?= $this->session->siswaData["telepon_user"] ?? "" ?>"
                                                                                       required>
                                                                            </div>
                                                                            <button
                                                                                    class="btn btn-success btn-block">Submit
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                        <?php $index++; ?>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="content-tukar">
                        <h1>Dapatkan Pelatihan</h1>
                        <div class="card mb-3">
                            <div class="row no-gutters">
                                <div class="col-md-4">
                                    <img src="<?= base_url('upload/banner_mapel/') . $mapel['banner_mapel'] ?>"
                                         alt="<?= $mapel['banner_mapel'] ?>" class="img-fluid img-rounded">
                                </div>
                                <div class="col-md-8 text-left">
                                    <div class="card-body">
                                        <h1 class="card-title">
                                            <?= $mapel['nama_mapel'] ?>
                                        </h1>
                                        <p class="card-text">
                                            <?= shortDescription($mapel['deskripsi_mapel'], 12) ?>
                                        </p>

                                        <a href="<?= base_url('kursus/detail/') . $mapel['meta_link_mapel'] ?>"
                                           class="btn btn-primary d-inline"><img
                                                    src="<?= base_url('assets/front/') ?>img/ic-coin-btn.png" alt="">
                                            600</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-content">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h1>Selesaikan misi, klaim tambahan modalnya!</h1>
                    <table class="non-table">
                        <tbody>
                        <tr>
                            <td class="number">01</td>
                            <td class="description">Beli Minimal 2 Kelas Prakerja di Karisma Academy dan dapatkan 600
                                Gold!!
                            </td>
                        </tr>
                        <tr>
                            <td class="number">02</td>
                            <td class="description">Selesaikan kelasmu hingga 100%</td>
                        </tr>
                        <tr>
                            <td class="number">03</td>
                            <td class="description">Tukarkan 600 Gold untuk mendapatkan E-course Tips And Trick For
                                Career Preparation!
                            </td>
                        </tr>
                        <tr>
                            <td class="number">04</td>
                            <td class="description">Selesaikan E-course dan Upload Unjuk Keterampilan Terbaik Kamu!</td>
                        </tr>
                        <tr>
                            <td class="number">05</td>
                            <td class="description">Berikan ulasan dan dapatkan tambahan modal senilai 600.000!</td>
                        </tr>
                        </tbody>
                    </table>
                    <a href="https://app.karier.mu/mitra/lkp-karisma-academy" target="_blank"
                       class="btn btn-card">Mulai Misi</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h1>Skema Gold</h1>
                    <p>Cek skema perolehan gold berdasarkan harga kelas yang kamu beli:</p>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Harga Kelas</th>
                            <th>Gold yang kamu dapatkan</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Rp. 1.500.000</td>
                            <td><img src="<?= base_url('assets/front/') ?>img/ic-coin.png" alt="coin">300
                            </td>
                        </tr>
                        <tr>
                            <td>Rp. 3.000.000</td>
                            <td><img src="<?= base_url('assets/front/') ?>img/ic-coin.png" alt="coin">600
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <a href="https://app.karier.mu/mitra/lkp-karisma-academy" target="_blank"
                       class="btn btn-card">Cek Kelas
                        Sekarang</a>
                </div>
            </div>

        </div>
        <div id="footer" class="bg-ka-darker">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-12 mb-lg-0 mb-3">
                        <div class="row justify-content-center">
                            <div class="col-md-12 d-flex align-items-center justify-content-center justify-content-lg-start mb-4">
                                <span class="brand"></span>
                            </div>
                            <div class="col-12 text-center text-lg-left">
                                <span><small>&copy; Copyright Karisma Academy <?= date('Y') ?></small></span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="offset-3 offset-md-0 col-9 col-md-4 col-sm-6 mb-3 mb-md-0 footer-social">
                                <div class="font-weight-bold mb-3">SOCIAL MEDIA</div>
                                <a class="icon-footer icon-footer-big d-inline-block if-fb"
                                   href="https://www.facebook.com/karismaacademy" target="_blank">
                                    &nbsp;
                                </a>
                                <a class="icon-footer icon-footer-big d-inline-block if-ig" target="_blank">
                                    &nbsp;
                                </a>
                            </div>
                            <div class="offset-3 offset-md-0 col-9 col-md-3 col-sm-6 mb-3 mb-md-0 offset-3 offset-md-0 footer-link">
                                <div class="font-weight-bold mb-3">TENTANG</div>
                                <ul class="">
                                    <li><a href="<?= base_url("tentang#tentang-1") ?>">Tentang Kami</a></li>
                                    <li><a href="<?= base_url("tentang#tentang-2") ?>">Contact</a></li>
                                    <li><a href="<?= base_url("tentang") ?>">Terms & Conditions</a></li>
                                </ul>
                            </div>
                            <div class=" offset-3 offset-md-0 col-9 col-md-5 mb-3 mb-md-0 offset-3 offset-md-0 footer-social">
                                <div class="font-weight-bold mb-3">OFFICE</div>
                                <ul class="p-0">
                                    <a href="https://goo.gl/maps/L62a8Sps2YLnvFyJA" target="_blank">
                                        <li>Jl. Watu Gong No. 18 Kota Malang</li>
                                    </a>
                                    <a href="https://wa.me/6282131740701" target="_blank">
                                        <li class="icon-footer if-wa">
                                            0821 3174 0701 <span class="text-secondary">(08:30 - 17:00)</span>
                                        </li>
                                    </a>
                                    <a href="tel:03412995599" target="_blank">
                                        <li class="icon-footer if-call">
                                            (0341) 299 55 99
                                        </li>
                                    </a>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</main>
<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/front/v2/plugins/toastr/js/toastr.min.js"></script>
<script>
    function onlyNumberKey(evt) {

        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }
</script>
<script>
    const BASE_URL = '<?= base_url() ?>'
    toastr.options = {
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "500",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    <?php if ($this->session->flashdata('danger')): ?>
    toastr.error("<?= $this->session->flashdata('danger') ?>");
    <?php endif ?>
    <?php if ($this->session->flashdata('success')): ?>
    console.log("<?= $this->session->flashdata('success') ?>");
    toastr.success("<?= $this->session->flashdata('success') ?>");
    <?php endif ?>
    <?php
    if (isset($_SESSION['alert'])) {
    if (count($_SESSION['alert']) > 0) {
    ?>

    <?php
    foreach ($_SESSION['alert'] as $key => $item) {
        echo $item;
    }
    ?>

    <?php
    $_SESSION['alert'] = NULL;
    }
    }
    ?>
</script>
<script src="<?= base_url('assets/front/') ?>js/gamification.js"></script>
</body>

</html>
