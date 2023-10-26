<!--prakerja page-->

<section id="prakerja_page my-5">

    <style>

        nav {
            margin: auto;
            text-align: center;
            width: 100%;
        }

        nav ul ul {
            display: none;
        }

        nav ul li:hover > ul {
            display: block;
            width: 170px;
            cursor: pointer;

        }

        nav ul {
            padding: 0 20px;
            list-style: none;
            position: relative;
            display: inline-table;
            width: 100%;
        }

        nav ul:after {
            content: "";
            clear: both;
            display: block;
        }

        nav ul li {
            float: left;
        }

        nav ul li:hover {
            cursor: pointer;

        }

        nav ul li:hover a {
            cursor: pointer;
            color: #fff;
        }

        nav ul li a {
            display: block;
            padding: 25px;
            color: #fff;
            text-decoration: none;
        }

        nav ul ul {
            border-radius: 0px;
            padding: 0;
            position: absolute;
            top: 2%;
            margin-left: -12%;
        }

        nav ul ul li {
            float: none;
            position: relative;
        }

        nav ul ul li a {
            padding: 15px 40px;
            color: #fff;
        }

        nav ul ul li a:hover {
            background-color: #666;
            cursor: pointer;
        }

        nav ul ul ul {
            position: absolute;
            left: 50%;
            top: 0;
        }
    </style>
    <a href="<?php echo base_url('gamification'); ?>">
        <nav>
            <ul class="fixed-bottom mr-5 mb-5 d-flex w-100">
                <li class="ml-auto"><img class=" faa-pulse animated-hover" src="/assets/front/images/Frame.png"
                                         alt="karisma gold" width="75">
                    <!--                    <ul>-->
                    <!--                        <li>-->
                    <!--                            <p class="text-center" style="width: 100%; font-weight: bold; border-radius: 10px;   padding: 12px 0; padding-left: 2%; margin-left: 3%; background-color: #FFD100; color: white;">Selesaikan Misi, Tukarkan Goldnya!</p>-->
                    <!--                        </li>-->
                    <!--                    </ul>-->
                </li>
            </ul>
        </nav>
    </a>
    <div class="jumbotron jumbotron-fluid bg-prakerja-page">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6  text-darkest">
                    <h1 class="font-weight-bold font-bg-prakerja">
                        Panduan Menggunakan Kupon Prakerja di Karisma Academy
                    </h1>
                    <a href="" class="btn btn-warning w-50 mt-5 py-sm-3 py-2 font-weight-bold rounded-pill">
                        <i class="fa fa-play mr-2"></i> Lihat Video
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card text-white">
                    <div class="container d-flex">
                        <div class="card-body bg-prakerja py-4  px-lg-5 ">
                            <h5 class="card-title my-lg-3 font-bg-coupon"> <span class="font-weight-bold">Redeem code </span>Pelatihan Prakerja anda</h5>
                            <div class="d-flex justify-content-center justify-content-md-start"> -->

    <?php if (isset($status)): ?>
        <!-- <p><?= $redeem_code ?></p>
                                    <p><?= $course_code ?></p> -->
        <p>
            <?= ($status == 1 ? 'Sudah di redeem' : 'Belum di redeem') ?>
        </p>
    <?php endif ?>

    <!--<form action="<?= base_url('redeem-code') ?>" class="row w-100 mb-md-3" method="post">
                                    <div class="d-flex align-items-center col-12 col-md-9">
                                        <input class="form-control mr-md-1" type="text" name="commit" placeholder="Code Redeem.." required>
                                        <button type="submit" class="btn btn-warning btn-use-coupon rounded-pill fs-6 ml-2 px-md-5">Submit</button>
                                    </div>
                                </form> -->
    <!-- <form action="<?= base_url('redeem/status') ?>" method="post">
                                <label for="status">Cek Status</label>
                                    <input type="text" name="status" placeholder="Code Redeem" required>
                                    <button type="submit">Submit</button>
                                </form> -->

    <!--              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card text-white">
                    <div class="container d-flex">
                        <div class="card-body bg-prakerja px-lg-5">
                            <h5 class="card-title  font-bg-coupon">Punya kupon <span class="font-weight-bold"> Pelatihan
                                    Prakerja</span>? Pakai kuponnya atau cek sertifikat prakerja Anda.</h5>
                            <div class="d-flex justify-content-around justify-content-lg-start my-md-3">
                                <a href="<?= base_url('profil') ?>"
                                   class="btn btn-warning btn-use-coupon d-flex pl-0  mr-lg-3">
                                    <img class="img-fluid pr-0"
                                         src="<?= base_url('assets/front/v2/img/use-coupon.png') ?>" alt="">Gunakan
                                    Kupon
                                </a>
                                <a href="" class="btn btn-light btn-check-coupon d-flex pl-0">
                                    <img class="img-fluid pr-0"
                                         src="<?= base_url('assets/front/v2/img/check-serti.png') ?>" alt="">Cek
                                    Sertifikat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid " style="background: #F6FBFF;">

        <div class="container">

            <div class="row d-flex align-items-center">
                <div class="col-5 p-0 h2 mt-5">
                    <img src="<?php echo base_url('upload/kariermu-logo.png') ?>" class="w-100" alt="">
                </div>
                <div class="col-7 p-0 text-right text-warning ">
                    <p class="font-weight-bold mt-5">
                        <a class=" " href="<?= base_url("kelas") ?>#prakerja">
                            Lihat lebih banyak <i class="fa fa-angle-right pl-1"></i>
                        </a>
                    </p>
                </div>
            </div>

            <div class="row d-flex justify-content-center mb-5">
                <?php foreach ($dataMapelPrakerja as $mapelPrakerja) : ?>
                    <div class="col-9 col-md-4 col-lg-3 mt-4">
                        <div class="card card-white-shadow">
                            <a href="<?= base_url("kursus/detail/{$mapelPrakerja["meta_link_mapel"]}") ?>">
                                <img src="<?= base_url("upload/banner_mapel/{$mapelPrakerja["banner_mapel"]}") ?>"
                                     class="card-img-top" alt="...">
                            </a>
                            <div class="card-body d-flex justify-content-center ">
                                <div class="kelas-title font-weight-bold line-limit-3">
                                    <a href="<?= base_url("kursus/detail/{$mapelPrakerja["meta_link_mapel"]}") ?>"
                                       class="nama-mapel">
                                        <?= $mapelPrakerja["nama_mapel"] ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- <div class="row d-flex justify-content-center ">
                <div class="kelas-list col-12 col-lg-12 ">
                    <div class="kelas-item align-items-stretch ">
                        <div class="card  shadow w-75">
                            <img src="<?= base_url("upload/example1.jpg") ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h6 class="card-title font-weight-bold">Membuat desain kemasan dengan Adobe Illustrator</h6>

                                <div class="d-flex align-items-center">
                                    <img src="upload/banner_mapel/BapakAlpha.jpeg" class="rounded-circle img-fluid img-instructor mr-2 " alt=""><span class="card-text"> by Zahian Aan.</span>
                                </div>

                                <div class="d-flex ">
                                    <h6 class="font-weight-bold mt-3">Rp. 250.000</h6>
                                </div>

                                <a href="#" class="btn btn-success text-center w-100">Beli kelas online</a>
                            </div>
                        </div>
                    </div>
                    <div class="kelas-item align-items-stretch ">
                        <div class="card  shadow w-75">
                            <img src="<?= base_url("upload/example2.jpg") ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h6 class="card-title font-weight-bold">Membuat desain kemasan dengan Adobe Illustrator</h6>

                                <div class="d-flex align-items-center">
                                    <img src="upload/banner_mapel/BapakAlpha.jpeg" class="rounded-circle img-fluid img-instructor mr-2 " alt=""><span class="card-text"> by Zahian Aan.</span>
                                </div>
                                <div class="d-flex ">
                                    <h6 class="font-weight-bold mt-3">Rp. 250.000</h6>
                                </div>

                                <a href="#" class="btn btn-success text-center w-100">Beli kelas online</a>
                            </div>
                        </div>
                    </div>
                    <div class="kelas-item align-items-stretch ">
                        <div class="card  shadow w-75">
                            <img src="<?= base_url("upload/example3.jpg") ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h6 class="card-title font-weight-bold">Membuat desain kemasan dengan Adobe Illustrator</h6>

                                <div class="d-flex align-items-center">
                                    <img src="upload/banner_mapel/BapakAlpha.jpeg" class="rounded-circle img-fluid img-instructor mr-2 " alt=""><span class="card-text"> by Zahian Aan.</span>
                                </div>
                                <div class="d-flex ">
                                    <h6 class="font-weight-bold mt-3">Rp. 250.000</h6>
                                </div>

                                <a href="#" class="btn btn-success text-center w-100">Beli kelas online</a>
                            </div>
                        </div>
                    </div>
                    <div class="kelas-item align-items-stretch ">
                        <div class="card  shadow w-75">
                            <img src="<?= base_url("upload/example4.jpg") ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h6 class="card-title font-weight-bold">Membuat desain kemasan dengan Adobe Illustrator</h6>

                                <div class="d-flex align-items-center">
                                    <img src="upload/banner_mapel/BapakAlpha.jpeg" class="rounded-circle img-fluid img-instructor mr-2 " alt=""><span class="card-text"> by Zahian Aan.</span>
                                </div>
                                <div class="d-flex ">
                                    <h6 class="font-weight-bold mt-3">Rp. 250.000</h6>
                                </div>

                                <a href="#" class="btn btn-success text-center w-100">Beli kelas online</a>
                            </div>
                        </div>
                    </div>

                </div>

            </div> -->


        </div>

    </div>

    <!-- <div class="container-fluid " style="background: #F6FBFF;">

        <div class="container">

            <div class="row d-flex align-items-center">
                <div class="col-7 h2 my-5">
                    <img src="<?php echo base_url('assets/front/v2/img/bukalapak.png') ?>" class="w-50" alt="">
                </div>
                <div class="col-5 h5 text-right text-warning ">
                    <p class="font-weight-bold"> Lihat lebih banyak >></p>
                </div>
            </div>

            <div class="row d-flex justify-content-center ">

                <div class="kelas-list col-12 col-lg-12 ">
                    <div class="kelas-item align-items-stretch ">
                        <div class=" card shadow w-75">
                            <img src="<?= base_url("upload/example4.jpg") ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h6 class="card-title font-weight-bold">Membuat desain kemasan dengan Adobe Illustrator</h6>

                                <div class="d-flex align-items-center">
                                    <img src="upload/banner_mapel/BapakAlpha.jpeg" class="rounded-circle img-fluid img-instructor mr-2 " alt=""><span class="card-text"> by Zahian Aan.</span>
                                </div>
                                <div class="d-flex ">
                                    <h6 class="font-weight-bold mt-3">Rp. 250.000</h6>
                                </div>

                                <a href="#" class="btn btn-success text-center w-100">Beli kelas online</a>
                            </div>
                        </div>
                    </div>
                    <div class="kelas-item align-items-stretch ">
                        <div class="card  shadow w-75">
                            <img src="<?= base_url("upload/example3.jpg") ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h6 class="card-title font-weight-bold">Membuat desain kemasan dengan Adobe Illustrator</h6>

                                <div class="d-flex align-items-center">
                                    <img src="upload/banner_mapel/BapakAlpha.jpeg" class="rounded-circle img-fluid img-instructor mr-2 " alt=""><span class="card-text"> by Zahian Aan.</span>
                                </div>
                                <div class="d-flex ">
                                    <h6 class="font-weight-bold mt-3">Rp. 250.000</h6>
                                </div>

                                <a href="#" class="btn btn-success text-center w-100">Beli kelas online</a>
                            </div>
                        </div>
                    </div>
                    <div class="kelas-item align-items-stretch ">
                        <div class="card  shadow w-75">
                            <img src="<?= base_url("upload/example2.jpg") ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h6 class="card-title font-weight-bold">Membuat desain kemasan dengan Adobe Illustrator</h6>

                                <div class="d-flex align-items-center">
                                    <img src="upload/banner_mapel/BapakAlpha.jpeg" class="rounded-circle img-fluid img-instructor mr-2 " alt=""><span class="card-text"> by Zahian Aan.</span>
                                </div>
                                <div class="d-flex ">
                                    <h6 class="font-weight-bold mt-3">Rp. 250.000</h6>
                                </div>

                                <a href="#" class="btn btn-success text-center w-100">Beli kelas online</a>
                            </div>
                        </div>
                    </div>
                    <div class="kelas-item align-items-stretch ">
                        <div class="card  shadow w-75">
                            <img src="<?= base_url("upload/example1.jpg") ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h6 class="card-title font-weight-bold">Membuat desain kemasan dengan Adobe Illustrator</h6>

                                <div class="d-flex align-items-center">
                                    <img src="upload/banner_mapel/BapakAlpha.jpeg" class="rounded-circle img-fluid img-instructor mr-2 " alt=""><span class="card-text"> by Zahian Aan.</span>
                                </div>
                                <div class="d-flex ">
                                    <h6 class="font-weight-bold mt-3">Rp. 250.000</h6>
                                </div>

                                <a href="#" class="btn btn-success text-center w-100">Beli kelas online</a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>


        </div>

    </div> -->

    <div class="container-fluid my-5">
        <div class="container">
            <div class="row">
                <div class="col-12 my-1">
                    <h6 class="font-weight-bold">Buat yang belum tau</h6>
                    <h4>Apa itu <b>Kartu Prakerja?</b></h4>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="d-flex my-3">
                        <i class="fa fa-play text-warning ml-2 mr-2"> </i>
                        <p>
                            <b>Kartu Prakerja</b> adalah program pengembangan kompetensi kerja yang diadakan pemerintah.
                            Program ini ditujukan untuk para pencari
                            kerja yang terkena pemutusan hubungan kerja dan membutuhkan peningkatan kompetensi.
                        </p>
                    </div>
                    <div class="d-flex my-3">
                        <i class="fa fa-play text-warning ml-2 mr-2"> </i>
                        <p>Diberikan untuk Warga Negara Indonesia (WNI), berusia di atas 18 tahun, dan sedang tidak
                            menempuh pendidikan formal. </p>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="d-flex my-3">
                        <i class="fa fa-play text-warning ml-2 mr-2"> </i>
                        <p>Bantuan subsidi non tunai sebesar Rp1juta yang digunakan untuk mengikuti pelatihan.</p>
                    </div>
                    <div class="d-flex my-3">
                        <i class="fa fa-play text-warning ml-2 mr-2"> </i>
                        <p>Peserta Kartu Prakerja akan mendapatkan sertifikat dan insentif langsung sebesar Rp600
                            ribu/bulan selama 4 bulan jika telah berhasil
                            menyelesaikan pelatihan dan Rp150 ribu untuk pengisian survey.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid my-5">
        <div class="container">

            <div class="row">
                <div class="col-12 my-1">
                    <h6 class="font-weight-bold">Lalu, apa saja</h6>
                    <h4>Syarat mendaftar <b>Kartu Prakerja?</b></h4>
                </div>
                <div class="col-12 col-lg-6 ">
                    <div class="d-flex my-3">
                        <i class="fa fa-play text-warning ml-2 mr-2">
                        </i>
                        <p><b>WNI</b> berusia 18 tahun ke atas.</p>
                    </div>
                    <div class="d-flex my-3">
                        <i class="fa fa-play text-warning ml-2 mr-2"></i>
                        <p> Tidak sedang menempuh pendidikan formal. </p>
                    </div>
                    <div class="d-flex my-3">
                        <i class="fa fa-play text-warning ml-2 mr-2"></i>
                        <p>
                            Sedang mencari kerja, pekerja/buruh yang terkena PHK, atau pekerja/buruh yang membutuhkan
                            peningkatan kompetensi kerja,
                            seperti pekerja/buruh yang dirumahkan dan pekerja bukan penerima upah, termasuk pelaku usaha
                            mikro & kecil.
                        </p>
                    </div>
                </div>
                <div class="col-12 col-lg-6 ">
                    <div class="d-flex my-3">
                        <i class="fa fa-play text-warning ml-2 mr-2">
                        </i>
                        <p>Bukan penerima bantuan sosial lainnya selama pandemi COVID-19.</p>
                    </div>
                    <div class="d-flex my-3">
                        <i class="fa fa-play text-warning ml-2 mr-2"></i>
                        <p> Bukan Pejabat Negara, Pimpinan dan Anggota DPRD, ASN, Prajurit TNI, Anggota Polri, Kepala
                            Desa dan perangkat desa dan
                            Direksi/Komisaris/Dewan Pengawas pada BUMN atau BUMD.
                        </p>
                    </div>
                    <div class="d-flex my-3">
                        <i class="fa fa-play text-warning ml-2 mr-2"></i>
                        <p> Maksimal 2 NIK dalam 1 KK yang menjadi Penerima Kartu Prakerja. w</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="background: #f2f7ff;">
        <div class="container">
            <div class="row justify-content-center my-5">

                <div class="col-12 my-4">
                    <h6 class="font-weight-bold">Bagaimana Cara Mengikuti</h6>
                    <h4><b>Program Pelatihan Prakerja ??</b></h4>
                </div>

                <div class="col-12 col-lg-4 p-3 d-flex">
                    <div class="bg-white w-100 p-4">
                        <h2 class="font-mons text-warning">01</h2>
                        <p class="my-3"><b>Pendaftaran Online </b>
                        </p>
                        <p class="my-3">
                            Daftarkan diri kamu di
                            <a class="text-primary" href="https://www.prakerja.go.id"> www.prakerja.go.id</a>
                        </p>
                    </div>
                </div>
                <div class="col-12 col-lg-4 p-3 d-flex">
                    <div class="bg-white w-100 p-4">
                        <h2 class="font-mons text-warning">02</h2>
                        <p class="my-3 font-weight-bold">
                            Verifikasi Pendaftaran
                        </p>
                        <p class="my-3">
                            Tunggu verifikasi pendaftaranmu
                        </p>
                        <p class="my-3">
                            Maksimal 2 NIK dalam 1 KK yang menjadi Penerima Kartu Prakerja.
                        </p>
                    </div>
                </div>
                <div class="col-12 col-lg-4 p-3 d-flex">
                    <div class="bg-white w-100 p-4">
                        <h2 class="font-mons text-warning">03</h2>

                        <p class="my-3 font-weight-bold">
                            Pilih Kelas
                        </p>
                        <p class="my-3">
                            Pilih kelas di
                            <a class="text-primary text-break " href="https://hybrid.karismaacademy.com/prakerja">
                                hybrid.karismaacademy.com/prakerja </a> lalu klik Ambil Kelas
                        </p>
                        <p class="my-3">
                            Maksimal 2 NIK dalam 1 KK yang menjadi Penerima Kartu Prakerja.
                        </p>
                    </div>
                </div>
                <div class="col-12 col-lg-4 p-3 d-flex">
                    <div class="bg-white w-100 p-4">
                        <h2 class="font-mons text-warning">04</h2>
                        <p class="my-3 font-weight-bold">
                            Pilih Mitra Platform
                        </p>
                        <p class="my-3">
                            Pilih Mitra Platform Prakerja yang tersedia
                        </p>
                    </div>
                </div>

                <div class="col-12 col-lg-4 p-3 d-flex">
                    <div class="bg-white w-100 p-4">
                        <h2 class="font-mons text-warning">05</h2>
                        <p class="my-3 font-weight-bold">
                            Selesaikan Transaksi
                        </p>
                        <p class="my-3">
                            Selesaikan transaksi di Mitra Platform Digital Prakerja untuk mendapatkan voucher Karisma
                            untuk kelas yang dipilih
                        </p>
                    </div>
                </div>

                <div class="col-12 col-lg-4 p-3 d-flex">
                    <div class="bg-white w-100 p-4">
                        <h2 class="font-mons text-warning">06</h2>
                        <p class="my-3 font-weight-bold">
                            Kembali ke hybrid.karismaacademy.com
                        </p>
                        <p class="my-3">
                            Kembali ke <a class="text-primary text-break"
                                          href="https://hybrid.karismaacademy.com/prakerja">hybrid.karismaacademy.com/prakerja</a>,
                            lalu pilih kelas yang kamu ambil dan tukarkan kode vouchermu di kolom yang tersedia
                        </p>
                    </div>
                </div>

                <div class="col-12 col-lg-4 p-3 d-flex">
                    <div class="bg-white w-100 p-4">
                        <h2 class="font-mons text-warning">07</h2>
                        <p class="my-3 font-weight-bold">
                            Menyelesaikan Pelatihan
                        </p>
                        <p class="my-3">
                            Setelah itu, kamu harus menyelesaikan pelatihan dan lulus tes akhir
                        </p>
                    </div>
                </div>

                <div class="col-12 col-lg-4 p-3 d-flex">
                    <div class="bg-white w-100 p-4">
                        <h2 class="font-mons text-warning">08</h2>
                        <p class="my-3 font-weight-bold">
                            Berikan Rating & Ulasan
                        </p>
                        <p class="my-3">
                            Berikan rating dan ulasan di website prakerja
                        </p>
                    </div>
                </div>

                <div class="col-12 col-lg-4 p-3 d-flex">
                    <div class="bg-white w-100 p-4">
                        <h2 class="font-mons text-warning">09</h2>

                        <p class="my-3 font-weight-bold">
                            Dapatkan Pembayaran Insentifmu
                        </p>
                        <p class="my-3">
                            Tunggu dan dapatkan pembayaran insentifmu.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="container py-sm-5">
            <div class="card my-5">
                <div class="card-body bg-prakerja-guide text-white">
                    <div class="row">
                        <div class="col-12 col-lg-7 mt-lg-5  pt-2 pl-sm-5">
                            <h3 class="card-title font-guide font-weight-bold pl-lg-5">
                                Panduan Lengkap dan Tanya Jawab Seputar Prakerja
                            </h3>
                            <a href="" class="btn btn-warning btn-use-coupon w-50 rounded-pill mt-lg-2 ml-lg-5">
                                <b>Lihat Sekarang</b>
                                <i class="fa fa-play ml-1"></i>
                            </a>
                        </div>
                        <div class="col-5 col-lg-5 d-lg-block d-none ">
                            <img class="img-fluid img-robo" src="<?= base_url('assets/front/v2/img/robo-ico.png') ?>"
                                 alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>
