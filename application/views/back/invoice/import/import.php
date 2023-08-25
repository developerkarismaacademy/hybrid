<?php
$adminkah = $this->session->backData["level_user"] == "administrasi";
$instrukturkah = $this->session->backData["level_user"] == "instruktur";
?>
<div class="content-page">
	<div class="content">
		<div class="container">

			<!-- start row -->

			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
						<h4 class="page-title">
							<span title="<?= $title ?>"><?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?>
							</span>
						</h4>
						<ol class="breadcrumb p-0 m-0">
							<li>
								<a title="Daftar Mata Pelajaran " href="">

								</a>
							</li>
							<li class="active">
								<span title="<?= $title ?>"><?= (strlen($title) > 18 ? substr($title, 0, 18) . "..." : $title) ?></span>
							</li>
						</ol>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<!-- end row -->

			<!-- start row -->
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-icon alert-danger alert-dismissible fade in error-alert hidden" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<div class="error-alert-container">

						</div>
					</div>
					<div class="card-box">
						<form id="form-import" action="" method="post" enctype="multipart/form-data">
							<div class="mb-3 form-group">
								<label for="" class="control-label">Mapel</label>
								<select class="js-example-disabled-results" name="mapel_id">
									<?php foreach ($mapel as $m) : ?>
										<option value="<?= $m->id_mapel ?>">(<?= $m->id_mapel ?>) <?= $m->nama_mapel ?></option>
									<?php endforeach ?>
								</select>
							</div>
							<div class="form-group">
								<label for="" class="form-label">File</label>
								<input type="file" class="form-control" name="csv_file">
							</div>
							<button type="submit" class="btn btn-primary" id="submit-import">Cek</button>
						</form>
					</div>
				</div>
				<!-- end row -->
			</div>
		</div>
	</div>
	<!-- container -->