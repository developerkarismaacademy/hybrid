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
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Toaster -->
    <link href="<?= base_url() ?>/assets/front/v2/plugins/toastr/css/toastr.min.css" media="none" rel="stylesheet"
        onload="if(media!='all')media='all'">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/front/') ?>css/gamification.css?v=2" />
    <title>
        <?= $title ?? "" ?> - Kursus Online
    </title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <img src="<?= base_url('assets/front/') ?>img/logo.png" height="60" alt="" />
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
                                        data-namakursus="<?= $val['meta_link_kelas'] ?>" value="<?= $val['id_kelas'] ?>"><?= $val['nama_kelas'] ?></a>
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
                                            src="<?= base_url('assets/front/') ?>img/ic-bonus.svg" alt=""> Klaim
                                        Bonus</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" href="#" id="dapatkan-tab" data-toggle="tab"
                                        data-target="#dapatkan" type="button" role="tab" aria-controls="dapatkan"
                                        aria-selected="true"><img class="icon"
                                            src="<?= base_url('assets/front/') ?>img/ic-dapatkan.svg" alt="">
                                        Dapatkan Gold</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" href="#" id="history-tab" data-toggle="tab"
                                        data-target="#history" type="button" role="tab" aria-controls="history"
                                        aria-selected="true"><img class="icon"
                                            src="<?= base_url('assets/front/') ?>img/ic-history.svg" alt="">History</a>
                                </li>
                                <div class="panel rounded"></div>
                            </ul>
                        </div>
                        <div class="d-block d-lg-none d-md-none">
                            <nav class="nav nav-pills flex-column flex-sm-row custom-tabs" id="myTab" role="tablist">
                                <a class="flex-sm-fill text-sm-center nav-link active" href="#" id="klaim-tab"
                                    data-toggle="tab" data-target="#klaim" type="button" role="tab"
                                    aria-controls="klaim" aria-selected="true"><img class="icon"
                                        src="<?= base_url('assets/front/') ?>img/ic-bonus.svg" alt=""> Klaim Bonus</a>
                                <a class="flex-sm-fill text-sm-center nav-link" href="#" id="dapatkan-tab"
                                    data-toggle="tab" data-target="#dapatkan" type="button" role="tab"
                                    aria-controls="dapatkan" aria-selected="true"><img class="icon"
                                        src="<?= base_url('assets/front/') ?>img/ic-dapatkan.svg" alt=""> Dapatkan
                                    Gold</a>
                                <a class="flex-sm-fill text-sm-center nav-link" href="#" id="history-tab"
                                    data-toggle="tab" data-target="#history" type="button" role="tab"
                                    aria-controls="history" aria-selected="true"><img class="icon"
                                        src="<?= base_url('assets/front/') ?>img/ic-history.svg" alt=""> History</a>
                            </nav>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane active klaim" id="klaim" role="tabpanel" aria-labelledby="klaim-tab">
                                <div class="header row">
                                    <div class="col-10">
                                        <div class="gold-info">
                                            <div class="float-left">
                                                <img src="<?= base_url('assets/front/') ?>img/ic-coin.png" alt="">
                                            </div>
                                            <div class="float-left ml-3">
                                                <h1>
                                                    <?= isset($gamification['coin']) ? $gamification['coin'] : 0 ?>
                                                </h1>
                                                <p>Gold Kamu</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-1"><i class="fa fa-question-circle fa-2x" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-none d-lg-block d-md-block">
                                    <div class="footer row">

                                        <div class="col-6 col-md-5 col-lg-6">
                                            <div class="float-left">
                                                <img src="<?= base_url('assets/front/') ?>img/ic-misi.png" alt="">
                                            </div>
                                            <div class="float-left pl-2">
                                                <h1>
                                                    <?= (count($log_dapat)) ? count($log_dapat) : 0 ?>
                                                </h1>
                                                <p>Misi telah selesai</p>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-7 col-lg-6">
                                            <div class="float-left">
                                                <img src="<?= base_url('assets/front/') ?>img/ic-coin-tukar.png" alt="">
                                            </div>
                                            <div class="float-left pl-2">
                                                <h1>
                                                    <?= isset($total_coin) ? $total_coin : 0 ?>
                                                </h1>
                                                <p>Gold yang telah ditukar</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer d-block d-lg-none d-md-none">
                                    <div class="row">
                                        <div class="col-3">
                                            <img src="<?= base_url('assets/front/') ?>img/ic-misi.png" alt="">
                                        </div>
                                        <div class="col-9">
                                            <h1>
                                                <?= (count($log_dapat)) ? count($log_dapat) : 0 ?>
                                            </h1>
                                            <p>Misi telah selesai</p>
                                        </div>
                                        <div class="col-3">
                                            <img src="<?= base_url('assets/front/') ?>img/ic-coin-tukar.png" alt="">
                                        </div>
                                        <div class="col-9">
                                            <h1>
                                                <?= isset($total_coin) ? $total_coin : 0 ?>
                                            </h1>
                                            <p>Gold yang telah ditukar</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane dapatkan" id="dapatkan" role="tabpanel" aria-labelledby="dapatkan-tab">
                                <div class="content">
                                    <h1>Dapatkan Gold</h1>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua.</p>
                                    <form action="<?= base_url() ?>front-v2/Gamification/dapatkan" method="post"
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
                                        <?php foreach ($log_dapat as $ld): ?>
                                            <?php
                                            $date = strtotime($ld['created_at']);
                                            ?>
                                            <div class="row mb-3">
                                                <div class="col-12 col-lg-3 col-md-3">
                                                    <img src="<?= base_url('upload/banner_mapel/') ?><?= $ld['gambar_mapel'] ?>.png"
                                                        alt="" class="img-fluid">
                                                </div>
                                                <div class="col-12 col-lg-9 col-md-9 row">
                                                    <div class="col-12 col-sm-12 col-lg-7 col-md-7 text-left">
                                                        <h6>
                                                            <?= $ld['nama_mapel'] ?>
                                                        </h6>
                                                        <p><img src="<?= base_url('assets/front/') ?>img/ic-coin.png"
                                                                alt="coin">300</p>
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

                                        <?php foreach ($log_tukar as $lt): ?>
                                            <?php
                                            $date = strtotime($lt['created_at']);
                                            ?>
                                            <div class="row mb-3">
                                                <div class="col-12 row">
                                                    <div class="col-12 col-sm-12 col-lg-7 col-md-7 text-left">
                                                        <h6>Price : Rp
                                                            <?= number_format($lt['uang'], 2, ',', '.') ?>
                                                        </h6>
                                                        <p><img src="<?= base_url('assets/front/') ?>img/ic-coin.png"
                                                                alt="coin">500</p>
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
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="content-tukar">
                            <h1>Tukarkan Goldmu</h1>
                            <div class="col-12 row text-center mx-auto">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body text-left tukar">
                                            <h1 class="d-inline uang">Rp 225.000</h1>
                                            <button class="btn btn-primary d-inline btn-tukar"><img
                                                    src="<?= base_url('assets/front/') ?>img/ic-coin-btn.png" alt="">
                                                150</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body text-left tukar">
                                            <h1 class="d-inline uang">Rp 600.000</h1>
                                            <button class="btn btn-primary d-inline btn-tukar"><img
                                                    src="<?= base_url('assets/front/') ?>img/ic-coin-btn.png" alt="">
                                                300</button>
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
                        <h1>Selesaikan misi, klaim goldnya!</h1>
                        <table class="non-table">
                            <tbody>
                                <tr>
                                    <td class="number">01</td>
                                    <td class="description">Beli kelas di Karisma Academy sekarang! Semakin tinggi harga
                                        kelas yang dibeli,
                                        semakin banyak gold yang kamu dapatkan.</td>
                                </tr>
                                <tr>
                                    <td class="number">02</td>
                                    <td class="description">Selesaikan kelasmu hingga 100%</td>
                                </tr>
                                <tr>
                                    <td class="number">03</td>
                                    <td class="description">Daftar & Ikuti Career Mentoring untuk klaim bonus kamu!</td>
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
                                    <td><img src="<?= base_url('assets/front/') ?>img/ic-coin.png" alt="coin">150</td>
                                </tr>
                                <tr>
                                    <td>Rp. 3.000.000</td>
                                    <td><img src="<?= base_url('assets/front/') ?>img/ic-coin.png" alt="coin">300</td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="https://app.karier.mu/mitra/lkp-karisma-academy" target="_blank"
                            class="btn btn-card">Cek Kelas
                            Sekarang</a>
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
    </script>
    <script src="<?= base_url('assets/front/') ?>js/gamification.js"></script>
</body>

</html>