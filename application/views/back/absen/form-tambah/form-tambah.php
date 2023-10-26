<div class="content-page">
	<div class="content">
		<div class="container">

			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
						<h4 class="page-title">
							<a data-toggle="tooltip" data-placement="top" title=""
							   data-original-title="List Kode Absen"
							   href="<?= base_url('back/absen') ?>">
								<i class="fa fa-arrow-left"></i>
							</a>
							<span
								title="<?= $title ?>"><?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?>
                            </span>
						</h4>
						<ol class="breadcrumb p-0 m-0">
							<li class="active">
								<span
									title="<?= $title ?>"><?= (strlen($title) > 18 ? substr($title, 0, 18) . "..." : $title) ?></span>
							</li>
						</ol>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="card-box">
						<form action="<?= base_url('back/absen/tambah') ?>" method="post">
							<div class="mb-3 form-group">
								<label for="" class="control-label">Mapel</label>
								<select class="js-example-disabled-results" name="mapel_id" id="mapel-id">
									<?php foreach ($mapel as $m) : ?>
										<option value="<?= $m->id_mapel ?>">(<?= $m->id_mapel ?>
											) <?= $m->nama_mapel ?></option>
									<?php endforeach ?>
								</select>
							</div>
							<div class="mb-3 form-group">
								<label id="label" for="" class="form-label">Date</label>
								<input type="datetime-local" class="form-control" name="expired_date" required>
							</div>
							<button type="submit" class="btn btn-primary">Submit</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
				integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
				crossorigin="anonymous"></script>
	</div>
</div>
