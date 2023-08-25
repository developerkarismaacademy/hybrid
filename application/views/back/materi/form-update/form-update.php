<div class="content-page">
	<div class="content">
		<div class="container">

			<!-- start row -->

			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
						<h4 class="page-title">
							<a data-toggle="tooltip" data-placement="top" title=""
							   data-original-title="Daftar Bab"
							   href="<?= base_url('back/bab/' . $mapel['meta_link_mapel']) ?>">
								<i class="fa fa-arrow-left"></i>
							</a>
							<span
								title="<?= $title ?>"><?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?>
							</span>
						</h4>
						<ol class="breadcrumb p-0 m-0">
							<li>
								<a title="Bab <?= $mapel['nama_mapel'] ?>"
								   href="<?= base_url('back/bab/' . $mapel['meta_link_mapel']) ?>">
									Bab <?= (strlen($mapel['nama_mapel']) > 8 ? substr($mapel['nama_mapel'], 0, 8) . "..." : $mapel['nama_mapel']) ?>
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
						<form method="POST" id="form-bab" enctype="multipart/form-data">
							<input type="hidden" id="id_bab" name="id_bab" value="<?= $id ?>"/>
							<h4 class="m-t-0 header-title"><b><?= $title ?></b></h4>
							<div class="pull-right">
								<a href="<?= base_url('back/mapel/' . $mapel['meta_link_mapel']) ?>"
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
									<label class="control-label">Nama Bab</label>
									<input type="text" id="nama_bab" name="nama_bab"
										   placeholder="Nama Bab . . ."
										   class="form-control">

								</div>
								<div class="form-group">
									<label class="control-label">Kelas </label>
									<select class="select2 form-control" name="kelas_id"
											id="kelas_id" data-placeholder="Pilih Kelas ...">
									</select>
								</div>
								<div class="form-group">
									<label class="control-label">Mata Pelajaran</label>
									<select class="select2 form-control" name="mapel_id"
											id="mapel_id" data-placeholder="Pilih Bab ...">
									</select>
								</div>
								<div class="form-group">
									<label class="control-label">Deskripsi Bab</label>
									<textarea id="deskripsi_bab" name="deskripsi_bab"></textarea>
								</div>
								<div class="form-group">
									<label class="control-label">Status</label>
									<br>
									<input type="checkbox" id="pretest_status" name="pretest_status" value="1"
										   class="form-control" switch="none"/>
									<label for="pretest_status" data-on-label="Pretest"
										   data-off-label="Premium"></label>
								</div>


								<div class="form-group m-t-5">
									<label class="control-label">Gambar Bab</label>
									<br>
									<img src="<?= base_url() ?>/assets/back/images/no-image.jpg" id="img-gambar -bab"
										 width="200">
									<br>
									<br>
									<input type="file" accept="image/*" class="filestyle" id="gambar_bab"
										   name="gambar_bab"
										   ref="file">
								</div>
								<div class="pull-right">
									<a href="<?= base_url('back/bab/' . $mapel['meta_link_mapel']) ?>"
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
