<section id="prakerja_page my-5">

    <div class="container-fluid bg-prakerja-page">
        <div class="row h-100 pt-1 align-items-center">
            <div class="col-12 col-md-6">
                <div class="card bg-transparent text-white">
                    <div class="container d-flex">
                        <div class="card-body bg-prakerja px-lg-5 py-lg-4">
                            <h5 class="card-title my-lg-3 font-bg-coupon">Punya kupon <span class="font-weight-bold"> Pelatihan Prakerja</span>? Pakai kupon prakerja Anda.</h5>
                            <form action="<?= base_url('voucher/tukar')?>" method="post">
                                <div class="d-flex justify-content-center align-items-center justify-content-lg-start">
                                    <input placeholder="AU23900001F" class="form-control w-75  mr-3" type="text" name="kode_voucher">
                                    <button type="submit" class="btn btn-warning btn-use-coupon d-flex mr-lg-3">
                                        <img class="img-fluid pr-0" src="<?= base_url('assets/front/v2/img/use-coupon.png') ?>" alt="">
                                        <p> Claim</p>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
