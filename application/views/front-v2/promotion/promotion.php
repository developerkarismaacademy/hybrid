<!doctype html>
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
    <title>Karisma Coin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('assets/front/js/wow/') ?>css/libs/animate.css">
    <link rel="stylesheet" href="<?= base_url('assets/front/') ?>css/promotion.css?v=<?= time() ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <link rel="stylesheet" href="<?= base_url('assets/front/') ?>css/slick-1.8.1/slick/slick.css">
    <link rel="stylesheet" href="<?= base_url('assets/front/') ?>css/slick-1.8.1/slick/slick-theme.css">

    <style>
         html,
        body {
            margin: 0;
            padding: 0;
        }

        * {
            box-sizing: border-box;
        }

        .slider {
            width: 50%;
            margin: 100px auto;
        }

        .slick-slide {
            margin: 0px 20px;
        }

        .slick-slide img {
            width: 100%;
        }

        .slick-prev:before,
        .slick-next:before {
            color: black;
        }


        .slick-slide {
            transition: all ease-in-out .3s;
            opacity: 1 !important;
        }

        .slick-active {
            opacity: .5;
        }

        .slick-current {
            opacity: 1;
        }
    </style>
</head>
<body>
    <main>
        <nav class="navbar navbar-expand-lg bg-ka-darker d-block navbar-inverse fixed-top">
            <div class="container py-0">
                <a class="navbar-brand" href="<?= base_url() ?>">
                    <img src="<?= base_url('assets/front/') ?>img/logo.png" height="60" alt="" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </button>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupported




                Content">
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
                                <a class="nav-link text-white btn btn-warning font-weight-normal" href="<?= base_url("login") ?>"
                                   id="navbarDropdown">
                                    DAFTAR/MASUK
                                </a>

                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>

<!--		<section class="section-1">-->
<!--			<div class="container">-->
<!--				<div class="img-section">-->
<!--					<img src="https://hybrid.karismaacademy.com/assets/front/img/Group 42.png" class="img-fluid" alt="">-->
<!--				</div>-->
<!--				<div class="content-section">-->
<!--					<h1 class="wow fadeIn" data-wow-duration="2s" style="visibility: visible; animation-duration: 2s; animation-name: fadeIn;">Gold Apresiasi Unjuk Keterampilan Terbaik dan Bimbingan Karier </h1>-->
<!--					<p class="wow fadeInUp" data-wow-duration="1.8s" style="visibility: visible; animation-duration: 1.8s; animation-name: fadeInUp;">-->
<!--						Gunakan &amp; Segera Habiskan Saldo Bantuan Pelatihan Kartu Prakerja sebelum batas akhir pembelian Pelatihan .-->
<!--					</p>-->
<!--					<p class="wow fadeInUp" data-wow-duration="1.8s" data-wow-delay="0.5s" style="visibility: visible; animation-duration: 1.8s; animation-delay: 0.5s; animation-name: fadeInUp;">Dapatkan Modal Penunjang Karir Hingga Rp. 600.000 dalam Program Karisma GOLD</p>-->
<!--					<a href="#" class="btn btn-new animate__animated animate__pulse animate__infinite infinite">Mulai Sekarang</a>-->
<!--				</div>-->
<!--			</div>-->
<!--		</section>-->

        <section class="section-banner">
            <div class="container my-5 pt-5">
                <div id="carouselWeb  " class="carousel slide d-md-block d-none" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselWeb" data-slide-to="0" class="active"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="" src="<?= base_url('assets/front/img/').'1150.png'?>"
                                class="d-block w-100" alt="<?= base_url('assets/front/img/').'1150.png'?>">
                        </div>

                    </div>
                    <button class="carousel-control-prev" type="button" data-target="#carouselWeb"
                        data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-target="#carouselWeb"
                        data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </button>
                </div>
                <div id="carouselMobile" class="carousel slide d-block d-md-none" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselMobile" data-slide-to="0" class="active"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img style="width: 100%" class="" src="<?= base_url('assets/front/img/').'HPmode.jpg'?>"
                                 class="d-md-block" alt="<?= base_url('assets/front/img/').'HPmode.png'?>">
                        </div>
                        <div class="carousel-item ">
                            <img style="width: 100%" class="" src="<?= base_url('assets/front/img/').'HPmode2.jpg'?>"
                                 class="d-md-block" alt="<?= base_url('assets/front/img/').'HPmode2.png'?>">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-target="#carouselMobile"
                        data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-target="#carouselMobile"
                        data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </button>
                </div>
            </div>
        </section>
        <section class="section-tentang">
            <div class="container">
                <div class="title-box">
                    <h1>Tentang Program</h1>
                </div>
                <div class="row content">
                    <div class="col-12 col-lg-7 pr-5 ">
                        <div class="content-desc wow fadeInLeft" data-wow-duration="2s" data-wow-delay="0.5s">
                            <p>
                                Program Karisma Gold merupakan program apresiasi Unjuk Keterampilan terbaik dan Bonus
                                Ecourse Tips And Trick
                                For Career Preparation setelah mengikuti dan menyelesaikan kelas Prakerja di LKP Karisma
                                Academy
                            </p>
                        </div>
                        <div class="content-slogan">
                            <!--                            <b>Selesaikan misi, klaim goldnya!</b>-->
                        </div>
                    </div>
                    <div class="col-12 col-lg-5 d-none d-md-block img-content">
                        <img src="<?= base_url('assets/front/') ?>img/Group 45.png" class="img-fluid wow fadeInRight"
                            data-wow-duration="1s" data-wow-delay="1s"
                            alt="<?= base_url('assets/front/') ?>img/Group 45.png">
                    </div>
                </div>
                <section class="section-content">
                    <div class="card p-2 mt-5">
                        <div class="card-body">
                            <h1 class="mb-2">Modal Penjunjang Karir</h1>
                            <p>Selesaikan misi, klaim tambahan modalnya!</p>
                            <table class="non-table">
                                <tbody>
                                    <tr>
                                        <td class="number wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">01
                                        </td>
                                        <td class="description wow fadeInUp" data-wow-duration="1s"
                                            data-wow-delay="0.4s">Beli Minimal 2 Kelas Prakerja di Karisma Academy dan
                                            dapatkan 600 Gold!!</td>
                                    </tr>
                                    <tr>
                                        <td class="number wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">02
                                        </td>
                                        <td class="description wow fadeInUp" data-wow-duration="1s"
                                            data-wow-delay="0.6s">Selesaikan kelasmu hingga 100%</td>
                                    </tr>
                                    <tr>
                                        <td class="number wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">03
                                        </td>
                                        <td class="description wow fadeInUp" data-wow-duration="1s"
                                            data-wow-delay="0.8s">Tukarkan 600 Gold untuk mendapatkan E-course Tips And
                                            Trick For Career Preparation!</td>
                                    </tr>
                                    <tr>
                                        <td class="number wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">04
                                        </td>
                                        <td class="description wow fadeInUp" data-wow-duration="1s" data-wow-delay="1s">
                                            Selesaikan E-course dan Upload Unjuk Keterampilan Terbaik Kamu!</td>
                                    </tr>
                                    <tr>
                                        <td class="number wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">05
                                        </td>
                                        <td class="description wow fadeInUp" data-wow-duration="1s"
                                            data-wow-delay="1.2s">Berikan ulasan dan dapatkan tambahan modal senilai
                                            600.000!</td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="https://app.karier.mu/mitra/lkp-karisma-academy" target="_blank"
                                class="btn btn-card" style="border-radius: 7px; border: 4px solid #ffffff; box-shadow:  0px 0px 5px
                               rgba(0, 0, 0, 0.3), 0 6px 20px 0 rgba(0, 0, 0, 0.19)">Mulai Misi</a>
                        </div>
                    </div>
                </section>
            </div>
        </section>
        <section class="section-kelas">
            <div class="container">
                <div class="title-box">
                    <h1>Kelas Pelatihan</h1>
                </div>

                <div class="row content  m-3 responsive">
                    <div class="col-lg-4 px-0" style="width: 190px !important;">
                        <div class="card px-0">
                            <img src="<?= base_url('assets/front/') ?>img/LKPKarismaAcademy_MembuatDesainMediaPromosiUntukDesainerPemulaMenggunakanAdobePhotoshop (2).png"
                                class="card-img-top"
                                alt="./img/LKPKarismaAcademy_MembuatDesainMediaPromosiUntukDesainerPemulaMenggunakanAdobePhotoshop (2).png">
                            <div class="card-body px-0">
                                <h5 class="card-title">Adobe Photoshop</h5>
                                <p class="card-text d-flex mb-2 align-items-center"><img
                                        src="<?= base_url('assets/front/') ?>img/sell.png" class="mx-1"
                                        style="width: 20px; height: 20px"> Rp 1.500.0000</p>
                                <p class="card-text">Membuat Desain Media Promosi Adobe Photoshop untuk Desainer Grafis
                                    Pemula</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 px-0">
                        <div class="card px-0">
                            <img src="<?= base_url('assets/front/') ?>img/thumbnail karier.png" class="card-img-top"
                                alt="./img/thumbnail karier.png">
                            <div class="card-body px-0">
                                <h5 class="card-title">Digital Marketing</h5>
                                <p class="card-text d-flex mb-2 align-items-center"><img
                                        src="<?= base_url('assets/front/') ?>img/sell.png" class="mx-1"
                                        style="width: 20px; height: 20px">Rp 1.500.0000</p>
                                <p class="card-text">Merancang Strategi Iklan Digital untuk menjadi Profesional
                                    Periklanan & Pemasaran</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 px-0">
                        <div class="card px-0">
                            <img src="<?= base_url('assets/front/') ?>img/thumbnail karier (1).png" class="card-img-top"
                                alt="img/thumbnail karier (1).png">
                            <div class="card-body px-0">
                                <h5 class="card-title">Adobe Illustrator</h5>
                                <p class="card-text d-flex mb-2 align-items-center"><img
                                        src="<?= base_url('assets/front/') ?>img/sell.png" class="mx-1"
                                        style="width: 20px; height: 20px">Rp 1.500.0000</p>
                                <p class="card-text">Membuat Desain Branding Produk Dengan Adobe Illustrator untuk
                                    Desain Grafis </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-tentang">
            <div class="container pt-4">
                <section class="section-content">
                    <div class="row career">
                        <div class="col-12 col-lg-4 col-sm-12">
                            <img src="<?= base_url('assets/front/img/') ?>budi.png" alt="budi"
                                class="img-fluid career-img wow fadeIn" data-wow-duration="2s">
                        </div>
                        <div class="col-12 col-lg-8 col-sm-12 career-content">
                            <h1 class="py-3">Tips And Trick For<br>Career Preparation</h1>
                            <p>Pemateri : Budi Santoso</p>
                            <p>Senior HR Manager & Country Learning Manager Rentokil Initial Indonesia</p>
                            <p>Professional Certified Trainer & Business Coach</p>
                            <p>Founder Exora Learning</p>
                        </div>
                    </div>
                </section>
            </div>
        </section>
        <section class="section-skema">
            <div class="container">
                <h1 class=" wow fadeIn" data-wow-duration="2s">Skema Gold</h1>
                <p class=" wow fadeIn" data-wow-duration="2s">Cek skema perolehan gold berdasarkan harga kelas yang kamu
                    beli :</p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" width="50%">Harga Kelas</th>
                            <th scope="col" width="50%">Gold yang kamu dapatkan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="wow fadeIn" data-wow-duration="2s">Rp. 1.500.000</td>
                            <td class="wow fadeIn" data-wow-duration="2s" data-wow-delay="0.5s">
                                <img src="<?= base_url('assets/front/') ?>img/Group.png" alt="./img/Group.png"
                                    width="30" height="30"> 300
                            </td>
                        </tr>
                        <tr>
                            <td class="wow fadeIn" data-wow-duration="2s">Rp. 3.000.000</td>
                            <td class="wow fadeIn" data-wow-duration="2s" data-wow-delay="1s">
                                <img src="<?= base_url('assets/front/') ?>img/Group.png" alt="./img/Group.png"
                                    width="30" height="30"> 600
                            </td>
                        </tr>
                    </tbody>
                </table>
                <h4 class="wow fadeIn" data-wow-duration="2s" data-wow-delay="1s">Miliki kelas dan kumpulkan goldnya !
                </h4>
                <div class="btn w-50 btn-table">Cek Kelas Sekarang</div>
            </div>
        </section>
        <section class="section-syarat">
            <div class="container">
                <h1>Syarat dan Ketentuan</h1>

                <div class="number mx-3">01</div>
                <div class="text wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">Periode Program akan
                    berlangsung dari tanggal 1 Juni 2023 sampai dengan tanggal 30 Agustus 2023 (Periode Program).
                </div>
                <div class="clear"></div>

                <div class="number mx-3">02</div>
                <div class="text px-3 wow fadeInUp d-block" data-wow-duration="1s" data-wow-delay="0.4s">
                    Peserta yang melakukan pembelian Kelas Prakerja di Plaftorm Karisma Academy & Karier.mu dengan
                    metode pembayaran Kartu Prakerja berhak mengikuti tahapan misi untuk mendapatkan koin, yang kemudian
                    dapat ditukarkan dengan uang tunai untuk usaha pengembangan Karier dan Bisnis Peserta.
                    Misi-misi tersebut antara lain :
                    <ul class="ml-md-5">

                        <li class="">
                            Beli Minimal 2 Kelas Prakerja di Karisma Academy dan dapatkan 600 Gold!! ,
                        </li>
                        <li class="">
                            Selesaikan kelasmu hingga 100% ,

                        </li>
                        <li class="">
                            Tukarkan 600 Gold untuk mendapatkan E-course Tips And Trick For Career Preparation! ,

                        </li>
                        <li class="">
                            Selesaikan E-course dan Upload Unjuk Keterampilan Terbaik Kamu! ,

                        </li>
                        <li class="">
                            Berikan ulasan dan dapatkan tambahan modal senilai 600.000!.

                        </li>
                    </ul>
                </div>
                <div class="clear"></div>

                <div class="number mx-3">03</div>
                <div class="text wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.6s">
                    Jika Peserta telah memberi 2 (dua) kelas Webinar senilai Minimal Rp. 3.000.000 (tiga juta rupiah),
                    Peserta berhak mendapatkan 600 gold yang bisa
                    ditukarkan dengan uang tunai sebagai penunjang karir sebesar Rp. 600.000 (enam ratus ribu rupiah)
                    setelah memenuhi syarat yang berlaku.
                </div>
                <div class="clear"></div>

                <div class="number mx-3">04</div>
                <div class="text wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.8s">Peserta wajib
                    menyelesaikan materi Ecourse Tips And Trick For Career Preparation yang dapat diakses pada website
                    hybrid.karismaacademy.com</div>
                <div class="clear"></div>

                <div class="number mx-3">05</div>
                <div class="text wow fadeInUp" data-wow-duration="1s" data-wow-delay="1s">Peserta wajib kirim hasil
                    unjuk keterampilan terbaik (point minimal 80) untuk mendapatkan Karisma Gold.</div>
                <div class="clear"></div>

                <div class="number mx-3">06</div>
                <div class="text wow fadeInUp" data-wow-duration="1s" data-wow-delay="1.2s">Karisma Gold yang
                    diperoleh peserta wajib ditukarkan pelatihan pengembangan karir (Career Preparation).</div>
                <div class="clear"></div>

                <div class="number mx-3">07</div>
                <div class="text wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">Peserta menyelesaikan
                    pelatihan minimal 2 pelatihan dan mendapat sertifikat.</div>
                <div class="clear"></div>


                <div class="number mx-3">08</div>
                <div class="text wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.4s">Hadiah berlaku untuk
                    2.000 orang pemenang yang ditetapkan dalam program Karisma Gold dengan Ikut Kelas Webinar selama 5
                    Hari.</div>
                <div class="clear"></div>

                <div class="number mx-3">09</div>
                <div class="text wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.6s">Bonus Gold dapat
                    dikirim ke saldo E-Wallet OVO, Dana, atau Gopay. Pastikan nomor yang terdaftar adalah nomor aktif
                    pada akun E-Wallet. </div>
                <div class="clear"></div>

                <div class="number mx-3">10</div>
                <div class="text wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.8s">Daftar pemenang program
                    akan dilaporkan kepada PMO.</div>
                <div class="clear"></div>

                <div class="number mx-3">11</div>
                <div class="text wow fadeInUp" data-wow-duration="1s" data-wow-delay="1s">Hadiah akan dikirimkan ke
                    nomor Handphone yang terdaftar paling lambat 7(tujyh) hari kerja setelah periode konfirmasi
                    dilakukan.</div>
                <div class="clear"></div>

                <div class="number mx-3">12</div>
                <div class="text wow fadeInUp d-block" data-wow-duration="1s" data-wow-delay="1.2s">
                    Program ini dikhususkan bagi peserta Kartu Prakerja Skema Normal yang terdaftar di website milik LKP
                    Karisma Academy.

                </div>
                <div class="clear"></div>

                <h4 class="font-weight-bold text-uppercase text-center mt-4 wow fadeInUp" data-wow-duration="1s">
                    Keputusan bersifat MUTLAK tidak dapat diganggu gugat !</h4>

            </div>
        </section>
        <section class="section-keuntungan">
            <div class="container my-5 pb-5">
                <div class="title-box">
                    <h1>Keuntungan Program</h1>
                </div>
                <div class="content-desc">
                    <p class="wow fadeInUp" data-wow-duration="1s" data-wow-delay="2.3s">
                        Program Karisma Gold akan membantu kamu mencapai keterampilan terbaik penunjang karir. </p>
                </div>
                <div class="row">
                    <div class="col-12 col-md-7">
                        <ul class=" wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1s">
                            <li class="m-0 mb-4">Peserta berhak mendapat modal penunjang karir senilai 600.000 setelah menyelesaikan
                                kelas dan career preparation. </li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-5 d-none d-md-block wow fadeInUp" data-wow-duration="1s"
                        data-wow-delay="1s">
                        <img src="<?= base_url('assets/front/') ?>img/robot11.png" width="100" alt="">
                    </div>
                </div>
            </div>

            <div class="ask pt-5">
                <div class="text">
                    <p class="wow fadeIn p-3" data-wow-duration="1s" data-wow-delay="1s">Jadi tunggu apalagi? Bergabunglah
                        dengan Karisma Gold sekarang dan raih kesempatan untuk meningkatkan Keterampilan Terbaik bersama
                        Karisma Academy. Kunjungi situs web kami untuk melihat kursus yang tersedia dan mulai belajar
                        hari ini !
                        <br>
                    </p>
                    <a target="_blank" href="https://app.karier.mu/mitra/lkp-karisma-academy"
                        class="btn btn-gabung animate__animated animate__pulse animate__infinite infinite" style="border-radius: 7px; border: 4px solid #ffffff; box-shadow:  0px 0px 5px
                               rgba(0, 0, 0, 0.3), 0 6px 20px 0 rgba(0, 0, 0, 0.19)">Gabung
                        Sekarang !</a>

                </div>
            </div>

        </section>
        <div id="footer" class="bg-ka-darker bg-footer py-5 mt-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-12 mb-lg-0 mb-3">
                        <div class="row justify-content-center">
                            <div
                                class="col-md-12 d-flex align-items-center justify-content-center justify-content-lg-start mb-4">
                                <span class="brand"></span>
                            </div>
                            <div class="col-12 text-center text-lg-left">
                                <span><small>&copy; Copyright Karisma Academy
                                        <?= date('Y') ?>
                                    </small></span>
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
                            <div
                                class="offset-3 offset-md-0 col-9 col-md-3 col-sm-6 mb-3 mb-md-0 offset-3 offset-md-0 footer-link">
                                <div class="font-weight-bold mb-3">TENTANG</div>
                                <ul class="m-0 p-0">
                                    <li><a href="<?= base_url("tentang#tentang-1") ?>">Tentang Kami</a></li>
                                    <li><a href="<?= base_url("tentang#tentang-2") ?>">Contact</a></li>
                                    <li><a href="<?= base_url("tentang") ?>">Terms & Conditions</a></li>
                                </ul>
                            </div>
                            <div
                                class=" offset-3 offset-md-0 col-9 col-md-5 mb-3 mb-md-0 offset-3 offset-md-0 footer-social">
                                <div class="font-weight-bold mb-3">OFFICE</div>
                                <ul class="m-0 p-0">
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

    </main>

    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/front/') ?>css/slick-1.8.1/slick/slick.min.js"></script>

    <script type="text/javascript">
        $('.responsive').slick({
            infinite: false,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 4,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: false
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: true
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });

    </script>
    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/front/js/wow/') ?>dist/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>
</body>

</html>
