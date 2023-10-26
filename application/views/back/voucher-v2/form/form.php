<div class="content-page">
    <div class="content">
        <div class="container">

            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">
                            <span title="<?= $title ?>"><?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?>
                            </span>
                        </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li class="active">
                                <span title="<?= $title ?>"><?= (strlen($title) > 18 ? substr($title, 0, 18) . "..." : $title) ?></span>
                            </li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                        <form action="<?= base_url('voucher/save') ?>" method="post">
                            <div class="mb-3 form-group">
                                <label id="label" for="" class="form-label">Kode Voucher</label>
                                <input type="text" class="form-control" id="" name="kode_voucher">
                            </div>
                            <div class="mb-3 form-group">
                                <label for="" class="control-label">Mapel</label>
                                <select class="js-example-disabled-results" name="mapel_id">
                                    <?php foreach ($mapel as $m) : ?>
                                        <option value="<?= $m->id_mapel ?>">(<?= $m->id_mapel ?>) <?= $m->nama_mapel ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="mb-3 form-group">
                                <label for="" class="form-label">Banyak Voucher</label>
                                <input type="number" min="1" class="form-control" name="qty">
                            </div>
                            <div class="mb-3 form-check">
								<input class="form-check-input" name="live_access" type="checkbox" value="1" id="flexCheckDefault">
								<label class="form-check-label" for="flexCheckDefault">
									Live Access
								</label>
							</div>
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
							<button type="submit" class="btn btn-primary" name="submit_and_create_another">Submit And Create Another</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </div>
</div>
<script>
    function _(el) {
        return document.getElementById(el)
    }
    _('label').innerHTML = 'Kode Voucher'
</script>