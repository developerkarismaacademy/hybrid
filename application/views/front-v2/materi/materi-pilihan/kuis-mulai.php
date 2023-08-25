<div class="text-center mx-auto kuis-start">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-8 col-lg-8 bg-ka-light p-5">
                <div class="row py-5">
                    <div class="col-12 mb-3 position-relative">
                        <img src="<?= base_url() ?>assets/front/v2/img/kuis/kuis-mulai.gif" class="img-fluid"
                             id="kuis-mulai-statis">
                    </div>
                    <div class="col-12 font-mons font-weight-bold">
                        <button onclick="start()"
                                class="btn btn-lg btn-<?= $retaken ? "info" : "danger" ?> px-5"><?= $retaken ? "RETAKE" : "MULAI" ?>
                            QUIZ
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
