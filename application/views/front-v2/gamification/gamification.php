<div class="fill bg-light" id="profil">
  <section>

      <style>

          .list-group-item.active{
              background-color: #FFD100 !important;
              border-radius: 10px;
              color: black !important;
          }

          .list-group-item{
              background-color: rgba(240, 248, 255, 0) !important;
              border-color: rgba(240, 248, 255, 0) !important;
              font-weight: bold;
              color: white;
              border-radius: 10px;
          }

          .list-group-item-action:focus, .list-group-item-action:hover{
              background-color: #ffee3230 !important;
              color: #FFEE32;
              border-radius: 10px;
              transition-duration: 0.9s !important;
          }

      </style>

    <div class="container-fluid">
      <div class="row">
          <div class="container-fluid jumbotron jumbotron-fluid m-0" style="background: url('/assets/front/images/bgoren.png');
        background-size: cover;">
              <div class="title d-flex justify-content-center align-items-center">
                  <img src="/assets/front/images/KarismaGold.png" style="width: 30%;" alt="karisma gold">
              </div>

              <div class="col-12 col-md-7 px-4 list-group d-flex my-3 mx-auto w-75" id="profil-kelas-filter" role="tablist" style="flex-direction: row">
<!--                  <div class="list-group-item list-group-nav list-group-item-action w-50">-->
<!--                      <a href="http://localhost:8002/kursusonline/profil">-->
<!--                          <i class="fa fa-arrow-left text-warning"></i> Kembali-->
<!--                      </a>-->
<!--                  </div>-->
<!--                  <a class="list-group-item list-group-nav list-group-item-action active w-50" data-toggle="tab" href="#tukarkan-poin" role="tab" aria-controls="tukarkan-poin" aria-selected="false">-->
<!--                      <i class="fa fa-rouble"></i>-->
<!--                      Tukarkan Poin-->
<!--                  </a>-->
<!--                  <a class="list-group-item list-group-nav list-group-item-action  w-50" data-toggle="tab" href="#dapatkan-poin" role="tab" aria-controls="dapatkan-poin" aria-selected="true">-->
<!--                      <i class="fa fa-credit-card"></i>-->
<!--                      Dapatkan Poin-->
<!--                  </a>-->
<!--                  <a class="list-group-item list-group-nav list-group-item-action w-50" data-toggle="list" href="#history-poin" role="tab" aria-controls="history-poin" aria-selected="false">-->
<!--                      <i class="fa fa-file-text-o"></i>-->
<!--                      History-->
<!--                  </a>-->

                  <a class="list-group-item list-group-nav list-group-item-action d-flex align-items-center active"data-toggle="tab" href="#tukarkan-poin" role="tab" aria-controls="tukarkan-poin" aria-selected="false">
                      <img class="mx-2" src="/assets/front/images/bag-w.png" width="20" alt="bag"  >
                      Klaim Bonus
                  </a>
                  <a class="list-group-item list-group-nav list-group-item-action d-flex align-items-center " data-toggle="tab" href="#dapatkan-poin" role="tab" aria-controls="dapatkan-poin" aria-selected="true">
                      <img class="mx-2" src="/assets/front/images/coin-w.png" width="20" alt="coin"  >
                      Dapatkan Gold
                  </a>
                  <a class="list-group-item list-group-nav list-group-item-action d-flex align-items-center" data-toggle="list" href="#history-poin" role="tab" aria-controls="history-poin" aria-selected="false">
                      <img class="mx-2" src="/assets/front/images/history-w.png" width="20" alt="history">
                      History
                  </a>

              </div>

              <div class="container-fluid py-4 tab-pane active show fade" id="tukarkan-poin" role="tabpanel" aria-labelledby="tukarkan-poin" aria-selected="false">
                  <h1 class="display-4"></h1>
                  <p class="lead">
                  <div class="card mx-auto w-50" >
                      <h5 class="card-header bg-white" >
                          <div class="row">
                              <div class="col-12">
<!--                                  <img class="w-100" src="/assets/front/images/coin.png" width="50">-->
                                  <div class="d-flex align-items-center">
<!--                                      <i class="fa fa-credit-card mx-2 pb-1" style="color: #FFA737"></i>-->
<!--                                      <h4 class="text-warning ">0</h4>-->
                                      <img class="mx-3" src="/assets/front/images/Frame.png" alt="karisma gold" width="75">
                                      <div class="text">
                                          <p class="font-weight-bold"> 0</p>
                                          <p>Gold Kamu</p>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </h5>
                      <div class="card-body bg-white">
                          <div class="row">
                              <div class="col-6 d-flex">
                                  <img class="mx-3" src="/assets/front/images/image1.png" alt="karisma gold" width="75">
                                  <div class="text">
                                      <h5 class="card-title">0</h5>
                                      <p class="card-text">Misi selesai.</p>
                                  </div>
                              </div>
                              <div class="col-6 d-flex">
                                  <img class="mx-3" src="/assets/front/images/koin1.png" alt="karisma gold" width="75">
                                  <div class="text">
                                      <h5 class="card-title"><i class="fa fa-credit-card"></i> <?= 0 ?></h5>
                                      <p class="card-text">Gold yang telah ditukar.</p>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  </p>
                  <div class="row mt-5 d-flex justify-content-center" id="pilihpoin">
                      <div class="col-12 d-flex justify-content-center my-3">
                          <h2 class="text-white font-weight-bold ">Tukarkan Goldmu</h2>
                      </div>
                      <div class="col-3">
                          <div class="card bg-white py-3 text-center" style="border-radius: 15px;">
                              <div class="card-body d-flex justify-content-around align-items-center">
                                  <h5 class="card-title">Rp.225.000</h5>
                                  <a href="https://hybrid.karismaacademy.com/profil/gamification">
                                    <div class=" btn btn-primary disabled px-4" style="cursor: not-allowed; caret-color: red;"><img src="/assets/front/images/Frame.png" width="20" alt=""> 1500</div>
                                  </a>
                              </div>
                          </div>
                      </div>
                      <div class="col-3">
                          <div class="card bg-white py-3 text-center" style="border-radius: 15px;">
                              <div class="card-body d-flex justify-content-around align-items-center">
                                  <h5 class="card-title">Rp.600.000</h5>
                                  <a href="https://hybrid.karismaacademy.com/profil/gamification">
                                    <div class=" btn btn-primary disabled px-4" style="cursor: not-allowed; caret-color: red;"><img src="/assets/front/images/Frame.png" width="20" alt=""> 3000</div>
                                  </a>
                              </div>
                          </div>
                      </div>

                  </div>

              </div>
              <div class="col-12 col-md-10 tab-pane fade  py-5 show mx-auto" id="dapatkan-poin" role="tabpanel" aria-labelledby="tukarkan-poin" aria-selected="true">
                  <div class="container py-0">
                      <div class="row">
                          <div class="col-md-9 mx-auto">
                              <div class="card">
                                  <div class="card-body">
                                      <div class="row">
                                          <div class="col-12 col-md tab-content">
                                              <div class="row mb-3 border-bottom border-ka-light no-gutters">
                                                  <div class="col-12">
                                                      <ul class="nav profil-tab nav-fill" id="profil-tab" role="tablist">
                                                          <li class="nav-item">
                                                              <a class="nav-link py-2 text-warning active" id="sub-semua-1-list"   data-toggle="tab" href="#sub-semua-1" role="tab" aria-controls="sub-semua-1" aria-selected="false">Semua</a>
                                                          </li>
                                                      </ul>
                                                  </div>
                                              </div>
                                              <div class="tab-pane fade show active" id="sub-semua-1" role="tabpanel" aria-labelledby="sub-semua-1">

                                                  <div class="card card-light my-4">
                                                      <div class="card-body p-3">
                                                          <div class="container-fluid">
<!--                                                              <form action="--><?//= base_url() ?><!--front-v2/Gamification/dapatkan" method="post" id="form-dapatkan">-->
                                                                  <div class="form__group field mb-3">
                                                                      <input type="input" class="form__field text-dark  " placeholder="Invoice" name="invoice" id='invoice' required />
                                                                      <label for="invoice" class="form__label  ">Invoice</label>
                                                                  </div>
                                                                  <a href="<?php echo base_url('profil/gamification');?>">
                                                                    <button type="submit" class="btn btn-warning btn-block rounded-pill disable" id="btn-dapatkan" style="cursor: not-allowed;">Dapatkan</button>
                                                                  </a>
                                                                      <!--</form>-->
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
              </div>
              <div class="col-12 col-md-10 tab-pane fade py-5 mx-auto" id="history-poin" role="tabpanel" aria-labelledby="history-poin" aria-selected="false">
                  <div class="container py-0">
                      <div class="row">
                          <div class="col-md-9 mx-auto">
                              <div class="card">
                                  <div class="card-body">
                                      <div class="row">
                                          <div class="col-12 col-md tab-content">
                                              <div class="row mb-3 border-bottom border-ka-light no-gutters">
                                                  <div class="col-12">
                                                      <ul class="nav profil-tab nav-fill" id="profil-sertifikat-filter" role="tablist">

                                                          <li class="nav-item">
                                                              <a class="nav-link py-2 active" id="sub-history-dapatkan-list" data-toggle="list" href="#sub-history-dapatkan" role="tab" aria-controls="history-dapatkan">
                                                                  Poin Didapatkan
                                                              </a>
                                                          </li>
                                                          <li class="nav-item">
                                                              <a class="nav-link py-2" id="sub-history-tukar-list" data-toggle="list" href="#sub-history-tukar" role="tab" aria-controls="history-tukar">
                                                                  Poin Ditukarkan
                                                              </a>
                                                          </li>
                                                      </ul>
                                                  </div>
                                              </div>

                                              <div class="col-12 mt-4 col-md tab-content px-0" id="profil-sertifikat-list">
                                                  <div class="tab-pane fade show active" id="sub-history-dapatkan" role="tabpanel" aria-labelledby="sub-history-dapatkan">
                                                      <div class="row">
                                                          <div class="card my-4 card-light">
<!--                                                              --><?php //foreach ($log_dapat as $ld) : ?>
<!--                                                                  <div class="card-body p-3 mb-3">-->
<!--                                                                      <div class="container-fluid">-->
<!--                                                                          <div class="row">-->
<!--                                                                              <div class="col-12 col-lg d-flex flex-column">-->
<!--                                                                                  <div class="row mb-auto">-->
<!--                                                                                      <div class="col">-->
<!--                                                                                          <div class="text-truncate" title="--><?//= $ld['nama_mapel'] ?><!--">-->
<!--                                                                                              <b>--><?//= $ld['nama_mapel'] ?><!--</b>-->
<!--                                                                                          </div>-->
<!--                                                                                          <div class="small">-->
<!--                                                                                              --><?//= $ld['invoice'] ?>
<!--                                                                                          </div>-->
<!--                                                                                          <div class="small">-->
<!--                                                                                              <i class="fa fa-credit-card"></i> --><?//= $ld['coin'] ?>
<!--                                                                                          </div>-->
<!--                                                                                      </div>-->
<!--                                                                                  </div>-->
<!--                                                                              </div>-->
<!--                                                                              <div class="col-12 mt-lg-0 mt-3 col-lg-4">-->
<!--                                                                                  <div class="row">-->
<!---->
<!--                                                                                      <a href="#" class="col-12 btn btn-success btn-rounded btn-block w-100 align-self-end small">-->
<!--                                                                                          --><?//= $ld['status_log'] ?>
<!--                                                                                      </a>-->
<!--                                                                                  </div>-->
<!--                                                                              </div>-->
<!--                                                                          </div>-->
<!--                                                                      </div>-->
<!--                                                                  </div>-->
<!--                                                              --><?php //endforeach; ?>
<!--                                                          </div>-->
                                                      </div>
                                                  </div>
                                                  <div class="tab-pane fade" id="sub-history-tukar" role="tabpanel" aria-labelledby="sub-history-dapatkan">
                                                           <div class="card my-4 card-light">
<!--                                                              --><?php //foreach ($log_tukar as $lt) : ?>
<!--                                                                  <div class="card-body p-3">-->
<!--                                                                      <div class="container-fluid">-->
<!--                                                                          <div class="row">-->
<!--                                                                              <div class="col-12 col-lg d-flex flex-column">-->
<!--                                                                                  <div class="row mb-auto">-->
<!--                                                                                      <div class="col">-->
<!--                                                                                          <div class="text-truncate">-->
<!--                                                                                              <b>--><?//= "Rp " . number_format($lt['uang'], 2, ',', '.'); ?><!--</b>-->
<!--                                                                                          </div>-->
<!--                                                                                          <div class="small">-->
<!--                                                                                              <i class="fa fa-credit-card"></i> --><?//= $lt['coin'] ?>
<!--                                                                                          </div>-->
<!--                                                                                      </div>-->
<!--                                                                                  </div>-->
<!--                                                                              </div>-->
<!--                                                                              <div class="col-12 mt-lg-0 mt-3 col-lg-4">-->
<!--                                                                                  <div class="row">-->
<!--                                                                                      <a class="col-12 btn --><?//= ($lt['status'] == 'pending') ? 'btn-warning' : 'btn-success' ?><!-- btn-rounded btn-block w-100 align-self-end small">-->
<!--                                                                                          --><?//= $lt['status'] ?>
<!--                                                                                      </a>-->
<!--                                                                                  </div>-->
<!--                                                                              </div>-->
<!--                                                                          </div>-->
<!--                                                                      </div>-->
<!--                                                                  </div>-->
<!--                                                              --><?php //endforeach ?>
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
          </div>


          <div class="container-fluid py-4 w-100 " style="background: url('/assets/front/images/bgwhite.png'); background-size: cover;">
              <div class="card shadow w-50 mx-auto my-5 border-light">
                  <h4 class="text-center font-weight-bold mt-4"> Selesaikan misinya, klaim poinnya!</h4>
                  <div class="card-body w-100">
                      <!-- <h5 class="card-title">Light card title</h5> -->
                      <div class="d-flex align-items-center my-3">
                          <h3 class="font-mons text-warning mx-4">01</h3>
                          <p class="card-text">Beli kelas di Karisma Academy! Semakin tinggi harga kelas yang dibeli, semakin banyak poin yang kamu dapatkan.</p>
                      </div>
                      <div class="d-flex align-items-center my-3">
                          <h3 class="font-mons text-warning mx-4">02</h3>
                          <p class="card-text">Selesaikan kelas hingga 100%.</p>
                      </div>
                      <div class="d-flex align-items-center my-3">
                          <h3 class="font-mons text-warning mx-4">03</h3>
                          <p class="card-text"> Daftar & Ikuti Career Mentoring untuk untuk klaim bonusnya.</p>
                      </div>
                  </div>
                  <a class="px-4 mx-auto my-4 w-75" href="<?php echo base_url('kelas');?>">
                      <button class="btn btn-warning w-100 rounded-pill font-weight-bold">Mulai Misi</button>
                  </a>
              </div>

              <div class="card shadow w-50 mx-auto my-5 border-light">
                  <h4 class="font-weight-bold text-center mt-4">Skema Poin</h4>
                  <div class="card-body px-5 w-100 mx-auto">
                      <table class="table table-bordered">
                          <thead>
                          <tr>
                              <th scope="col">Harga Kelas</th>
                              <th scope="col">Gold yang kamu dapatkan</th>

                          </tr>
                          </thead>
                          <tbody>
                          <tr>
                              <td>Rp.1.375.000 - Rp.1.999.999</td>
                              <td>1500</td>

                          </tr>
                          <tr>
                              <td>Rp.2.000.000 - Rp.2.499.000</td>
                              <td>2500</td>
                          </tr>
                          <tr>
                              <td>@Rp.2.500.000</td>
                              <td>3500</td>
                          </tr>
                          </tbody>
                      </table>
                  </div>
                  <a class="px-4 mx-auto my-4 w-75" href="<?php echo base_url('kelas');?>">
                    <div class="btn btn-warning  w-100 rounded-pill">Lihat Kelas</div>
                  </a>
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
                                  <ul class="">
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

          <?php
          // Height add
          ?>

      </div>
  </section>
</div>
