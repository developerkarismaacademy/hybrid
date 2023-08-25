<div class="fill bg-light" id="profil">
    <section>

        <style>
            .list-group-item.active {
                background-color: #FFA737;
                border-color: #FFA737;
            }
        </style>

        <div class="container-fluid">
            <div class="row">

                <div class="container-fluid jumbotron jumbotron-fluid"
                    style="background: url('/assets/front/images/Group4.png'),
      linear-gradient(90deg, rgba(116,168,243,0.4408613787311799) 0%, rgba(30,145,255,0.6201330874146533) 46%, rgba(0,212,255,0.4492647400757178) 100%); background-size: cover; height: 71vh; ">
                    <div class="col-12 col-md-8 list-group d-flex mx-auto w-50" id="profil-kelas-filter" role="tablist"
                        style="flex-direction: row">
                        <div class="list-group-item list-group-nav list-group-item-action w-50">
                            <a href="http://localhost:8002/kursusonline/profil">
                                <i class="fa fa-arrow-left text-warning"></i> Kembali
                            </a>
                        </div>
                        <a class="list-group-item list-group-nav list-group-item-action active w-50" data-toggle="tab"
                            href="#tukarkan-poin" role="tab" aria-controls="tukarkan-poin" aria-selected="false">
                            <i class="fa fa-rouble"></i>
                            Tukarkan Poin
                        </a>
                        <a class="list-group-item list-group-nav list-group-item-action  w-50" data-toggle="tab"
                            href="#dapatkan-poin" role="tab" aria-controls="dapatkan-poin" aria-selected="true">
                            <i class="fa fa-credit-card"></i>
                            Dapatkan Poin
                        </a>
                        <a class="list-group-item list-group-nav list-group-item-action w-50" data-toggle="list"
                            href="#history-poin" role="tab" aria-controls="history-poin" aria-selected="false">
                            <i class="fa fa-file-text-o"></i>
                            History
                        </a>

                    </div>

                    <div class="container w-75 py-4 tab-pane active show fade" id="tukarkan-poin" role="tabpanel"
                        aria-labelledby="tukarkan-poin" aria-selected="false">
                        <h1 class="display-4"></h1>
                        <p class="lead">
                        <div class="card w-75 mx-auto">
                            <h5 class="card-header bg-white">
                                <div class="row">
                                    <div class="col-9">
                                        <!--                                  <img class="w-100" src="/assets/front/images/coin.png" width="50">-->
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-credit-card mx-2 pb-1" style="color: #FFA737"></i>
                                            <!--                                      <h4 class="text-warning ">0</h4>-->
                                            </i>
                                            <?= (isset($gamification['coin'])) ? $gamification['coin'] : '0' ?>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="btn btn-warning px-4 rounded-pill" href="#pilihpoin">Tukar Poin
                                        </div>
                                    </div>
                                </div>
                            </h5>
                            <div class="card-body bg-white">
                                <div class="row">
                                    <div class="col-6 d-flex">
                                        <div class="par">
                                            <h5 class="card-title">Special title treatment</h5>
                                            <p class="card-text ">With supporting text below as a natural lead-in to
                                                additional content.</p>
                                        </div>
                                        <i class="fa fa-angle-right"></i>
                                    </div>
                                    <div class="col-6 d-flex">
                                        <div class="par">
                                            <h5 class="card-title">Special title treatment</h5>
                                            <p class="card-text ">With supporting text below as a natural lead-in to
                                                additional content.</p>
                                        </div>
                                        <i class="fa fa-angle-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </p>
                        <div class="row mt-5 d-flex justify-content-center" id="pilihpoin">
                            <div class="col-6">
                                <div class="card bg-white py-3 text-center" style="border-radius: 15px;">
                                    <div class="card-body ">
                                        <h5 class="card-title font-weight-bold my-3 uang" data-uang="225000">Rp.225.000
                                        </h5>
                                        <a class="btn btn-warning mx-auto text-white w-50 btn-block tukar rounded-pill"
                                            data-value="1500"
                                            onclick="return confirm('Apakah anda yakin ingin menukar ?');"><i
                                                class="fa fa-credit-card"></i> 1500</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card bg-white py-3 text-center" style="border-radius: 15px;">
                                    <div class="card-body ">
                                        <h5 class="card-title font-weight-bold my-3 uang" data-uang="600000">Rp.600.000
                                        </h5>
                                        <a class="btn btn-warning mx-auto text-white w-50 btn-block tukar rounded-pill"
                                            data-value="3000"
                                            onclick="return confirm('Apakah anda yakin ingin menukar ?');"><i
                                                class="fa fa-credit-card"></i> 3000</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-md-10 tab-pane fade  py-5 show mx-auto" id="dapatkan-poin" role="tabpanel"
                        aria-labelledby="tukarkan-poin" aria-selected="true">
                        <div class="container py-0">
                            <div class="row">
                                <div class="col-md-9 mx-auto">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 col-md tab-content">
                                                    <div class="row mb-3 border-bottom border-ka-light no-gutters">
                                                        <div class="col-12">
                                                            <ul class="nav profil-tab nav-fill" id="profil-tab"
                                                                role="tablist">
                                                                <li class="nav-item">
                                                                    <a class="nav-link py-2 text-warning active"
                                                                        id="sub-semua-1-list" data-toggle="tab"
                                                                        href="#sub-semua-1" role="tab"
                                                                        aria-controls="sub-semua-1"
                                                                        aria-selected="false">Semua</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade show active" id="sub-semua-1"
                                                        role="tabpanel" aria-labelledby="sub-semua-1">

                                                        <div class="card card-light my-4">
                                                            <div class="card-body p-3">
                                                                <div class="container-fluid">
                                                                    <form
                                                                        action="<?= base_url() ?>front-v2/Gamification/dapatkan"
                                                                        method="post" id="form-dapatkan">
                                                                        <div class="form__group field mb-3">
                                                                            <input type="input" class="form__field  "
                                                                                placeholder="Invoice" name="invoice"
                                                                                id='invoice' required />
                                                                            <label for="invoice"
                                                                                class="form__label  ">Invoice</label>
                                                                        </div>
                                                                        <button type="submit"
                                                                            class="btn btn-warning btn-block rounded-pill"
                                                                            id="btn-dapatkan">Dapatkan</button>
                                                                    </form>
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
                    <div class="col-12 col-md-10 tab-pane fade py-5 mx-auto" id="history-poin" role="tabpanel"
                        aria-labelledby="history-poin" aria-selected="false">
                        <div class="container py-0">
                            <div class="row">
                                <div class="col-md-9 mx-auto">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 col-md tab-content">
                                                    <div class="row mb-3 border-bottom border-ka-light no-gutters">
                                                        <div class="col-12">
                                                            <ul class="nav profil-tab nav-fill"
                                                                id="profil-sertifikat-filter" role="tablist">

                                                                <li class="nav-item">
                                                                    <a class="nav-link py-2 active"
                                                                        id="sub-history-dapatkan-list"
                                                                        data-toggle="list" href="#sub-history-dapatkan"
                                                                        role="tab" aria-controls="history-dapatkan">
                                                                        Poin Didapatkan
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link py-2" id="sub-history-tukar-list"
                                                                        data-toggle="list" href="#sub-history-tukar"
                                                                        role="tab" aria-controls="history-tukar">
                                                                        Poin Ditukarkan
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 mt-4 col-md tab-content px-0"
                                                        id="profil-sertifikat-list">
                                                        <div class="tab-pane fade show active" id="sub-history-dapatkan"
                                                            role="tabpanel" aria-labelledby="sub-history-dapatkan">
                                                            <div class="row">
                                                                <div class="card my-4 card-light">
                                                                    <?php foreach ($log_dapat as $ld): ?>
                                                                        <div class="card-body p-3 mb-3">
                                                                            <div class="container-fluid">
                                                                                <div class="row">
                                                                                    <div
                                                                                        class="col-12 col-lg d-flex flex-column">
                                                                                        <div class="row mb-auto">
                                                                                            <div class="col">
                                                                                                <div class="text-truncate"
                                                                                                    title="<?= $ld['nama_mapel'] ?>">
                                                                                                    <b>
                                                                                                        <?= $ld['nama_mapel'] ?>
                                                                                                    </b>
                                                                                                </div>
                                                                                                <div class="small">
                                                                                                    <?= $ld['invoice'] ?>
                                                                                                </div>
                                                                                                <div class="small">
                                                                                                    <i
                                                                                                        class="fa fa-credit-card"></i>
                                                                                                    <?= $ld['coin'] ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div
                                                                                        class="col-12 mt-lg-0 mt-3 col-lg-4">
                                                                                        <div class="row">

                                                                                            <a href="#"
                                                                                                class="col-12 btn <?= ($ld['status_log'] == 'pending') ? 'btn-warning' : 'btn-success' ?> btn-rounded btn-block w-100 align-self-end small">
                                                                                                <?= $ld['status_log'] ?>
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="sub-history-tukar"
                                                            role="tabpanel" aria-labelledby="sub-history-dapatkan">
                                                            <div class="card my-4 card-light">
                                                                <?php foreach ($log_tukar as $lt): ?>
                                                                    <div class="card-body p-3">
                                                                        <div class="container-fluid">
                                                                            <div class="row">
                                                                                <div
                                                                                    class="col-12 col-lg d-flex flex-column">
                                                                                    <div class="row mb-auto">
                                                                                        <div class="col">
                                                                                            <div class="text-truncate">
                                                                                                <b>
                                                                                                    <?= "Rp " . number_format($lt['uang'], 2, ',', '.'); ?>
                                                                                                </b>
                                                                                            </div>
                                                                                            <div class="small">
                                                                                                <i
                                                                                                    class="fa fa-credit-card"></i>
                                                                                                <?= $lt['coin'] ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12 mt-lg-0 mt-3 col-lg-4">
                                                                                    <div class="row">
                                                                                        <a
                                                                                            class="col-12 btn <?= ($lt['status'] == 'pending') ? 'btn-warning' : 'btn-success' ?> btn-rounded btn-block w-100 align-self-end small">
                                                                                            <?= $lt['status'] ?>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php endforeach ?>
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

                <!--          <div class="container-fluid " style="background: url('/assets/front/images/Group4.png');-->
                <!--        background-size: cover;  ">-->
                <!--              <div class="card shadow w-50 mx-auto  border-light mb-3" >-->
                <!--                  <div class="card-header text-center bg-white font-weight-bold">Selesaikan misinya, klaim koinnya!</div>-->
                <!--                  <div class="card-body w-100">-->
                <!--                     <h5 class="card-title">Light card title</h5> -->
                <!--                      <p class="card-text">Beli kelas di Karisma Academy! Semakin tinggi harga kelas yang dibeli, semakin banyak koin yang kamu dapatkan.</p>-->
                <!--                      <p class="card-text">Selesaikan kelas hingga 100%.</p>-->
                <!--                      <p class="card-text"> Daftar & Ikuti Career Mentoring untuk untuk klaim bonusnya.</p>-->
                <!--                  </div>-->
                <!--                  <div class="btn btn-warning px-4 mx-auto my-4 w-50">Mulai Misi</div>-->
                <!--              </div>-->
                <!--          </div>-->

                <div class="container-fluid mt-5" style="background: url('/assets/front/images/Group4.png');
        background-size: cover; height: 55vh; ">
                    <div class="card  shadow w-50 mx-auto  border-light ">
                        <div class="card-header text-center bg-white font-weight-bold my-2"> Selesaikan misinya, klaim
                            poinnya!</div>
                        <div class="card-body w-100">
                            <!-- <h5 class="card-title">Light card title</h5> -->
                            <div class="d-flex align-items-center my-3">
                                <h3 class="font-mons text-warning mx-4">01</h3>
                                <p class="card-text">Beli kelas di Karisma Academy! Semakin tinggi harga kelas yang
                                    dibeli, semakin banyak poin yang kamu dapatkan.</p>
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
                        <button class="btn btn-warning px-4 mx-auto my-4 w-50 rounded-pill"
                            href="https://hybrid.karismaacademy.com/prakerja">Mulai Misi</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>