<div class="content-page">
	<div class="content">
		<div class="container">

			<!-- start row -->

			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
						<h4 class="page-title">
							<a data-toggle="tooltip" data-placement="top" title=""
							   data-original-title="Daftar Indikator <?= $kompetensi['kompetensi'] ?>"
							   href="<?= base_url('back/indikator/' . $indikatorInduk['id_indikator_induk']) ?>">
								<i class="fa fa-arrow-left"></i>
							</a>
							<span
									title="<?= $title ?>"><?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?>
							</span>
						</h4>
						<ol class="breadcrumb p-0 m-0">
							<li>
								<a title="Daftar Kompetensi <?= $kompetensi['kompetensi'] ?>"
								   href="<?= base_url('back/kompetensi/' . $mapel['meta_link_mapel']) ?>">
									<?= (strlen("Daftar Kompetensi" . $kompetensi['kompetensi']) > 18 ? substr("Daftar Kompetensi " . $kompetensi['kompetensi'], 0, 18) . "..." : "Daftar Kompetensi " . $kompetensi['kompetensi']) ?>
								</a>
							</li>
							<li>
								<a title="Indikator Induk <?= $kompetensi['kompetensi'] ?>"
								   href="<?= base_url('back/indikator-induk/' . $kompetensi['id_kompetensi']) ?>">
									<?= (strlen("Indikator Induk" . $kompetensi['kompetensi']) > 16 ? substr("Indikator Induk " . $kompetensi['kompetensi'], 0, 16) . "..." : "Daftar Indikator " . $kompetensi['kompetensi']) ?>
								</a>
							</li>
							<li class="active">
								<span
										title="<?= $title ?>"><?= (strlen($title) > 18 ? substr($title, 0, 18) . "..." : $title) ?></span>
							</li>
						</ol>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<!-- end row -->

			<input type="hidden" id="idKelas" value="<?= $kelas['id_kelas'] ?>">
			<input type="hidden" id="metaKelas" value="<?= $kelas['meta_link_kelas'] ?>">
			<input type="hidden" id="idMapel" value="<?= $mapel['id_mapel'] ?>">
			<input type="hidden" id="metaMapel" value="<?= $mapel['meta_link_mapel'] ?>">
			<input type="hidden" id="idKompetensi" value="<?= $kompetensi['id_kompetensi'] ?>">
			<input type="hidden" id="idIndikatorInduk" value="<?= $indikatorInduk['id_indikator_induk'] ?>">

			<!-- start row -->
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-icon alert-danger alert-dismissible fade in error-alert hidden"
						 role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<div class="error-alert-container">

						</div>
					</div>
					<div class="card-box">
						<div class="loading-form">
							<i class="fa fa-spin fa-circle-o-notch fa-4x"></i>
							<br>
							<br>
							Loading Data
						</div>
						<form method="POST" id="form-indikator-induk" enctype="multipart/form-data">
							<h4 class="m-t-0 header-title"><b><?= $title ?></b></h4>
							<div class="pull-right">
								<a href="<?= base_url('back/indikator/' . $indikatorInduk['id_indikator_induk']) ?>"
								   class="btn btn-danger btn-bordered waves-effect">Back
								</a>
								<button type="reset" class="btn btn-default btn-bordered waves-effect">Reset
								</button>
								<button type="submit"
										class="btn btn-info btn-bordered waves-effect">Simpan
								</button>
							</div>
							<div class="m-t-10 clearfix">

								<div class="form-group">
									<label class="control-label">Kelas </label>
									<select class="select2 form-control" name="kelas_id"
											id="kelas_id" data-placeholder="Pilih Kelas ...">
									</select>
								</div>
								<div class="form-group">
									<label class="control-label">Mata Pelajaran</label>
									<select class="select2 form-control" name="mapel_id"
											id="mapel_id" data-placeholder="Pilih Mata Pelajaran ...">
									</select>
								</div>

								<div class="form-group">
									<label class="control-label">Kompetensi</label>
									<select class="select2 form-control" name="kompetensi_id"
											id="kompetensi_id" data-placeholder="Pilih Kompetensi ...">
									</select>
								</div>

								<div class="form-group">
									<label class="control-label">Indikator Induk</label>
									<select class="select2 form-control" name="indikator_induk_id"
											id="indikator_induk_id" data-placeholder="Pilih Indikator Induk ...">
									</select>
								</div>

								<div class="form-group">
									<label class="control-label">Deskripsi Indikator</label>
									<textarea name="indikator" id="indikator" class="form-control"
											  rows="5"></textarea>
								</div>

								<div class="pull-right">
									<a href="<?= base_url('back/indikator/' . $indikatorInduk['id_indikator_induk']) ?>"
									   class="btn btn-danger btn-bordered waves-effect">Back
									</a>
									<button type="reset" class="btn btn-default btn-bordered waves-effect">Reset
									</button>
									<button type="submit"
											class="btn btn-info btn-bordered waves-effect">Simpan
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- end row -->
		</div>
	</div>
</div>
<!-- container -->
