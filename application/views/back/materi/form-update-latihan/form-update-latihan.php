<div class="content-page">
	<div class="content">
		<div class="container">

			<!-- start row -->

			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
						<h4 class="page-title">
							<a data-toggle="tooltip" data-placement="top" title=""
							   data-original-title="Daftar Materi <?= $bab['nama_bab'] ?>"
							   href="<?= base_url('back/materi/' . $bab['meta_link_bab']) ?>">
								<i class="fa fa-arrow-left"></i>
							</a>
							<span
								title="<?= $title ?>"><?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?>
							</span>
						</h4>
						<ol class="breadcrumb p-0 m-0">
							<li>
								<a title="Daftar Materi <?= $bab['nama_bab'] ?>"
								   href="<?= base_url('back/materi/' . $bab['meta_link_bab']) ?>">
									<?= (strlen("Daftar Materi " . $bab['nama_bab']) > 16 ? substr("Daftar Materi " . $bab['nama_bab'], 0, 16) . "..." : "Daftar Materi " . $bab['nama_bab']) ?>
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
			<input type="hidden" id="idBab" value="<?= $bab['id_bab'] ?>">
			<input type="hidden" id="metaBab" value="<?= $bab['meta_link_bab'] ?>">
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
						<form method="POST" id="form-materi" enctype="multipart/form-data">
							<input type="hidden" id="id_materi" name="id_materi" value="<?= $id ?>"/>
							<h4 class="m-t-0 header-title"><b><?= $title ?></b></h4>
							<div class="pull-right">
								<a href="<?= base_url('back/materi/' . $bab['meta_link_bab']) ?>"
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
									<label class="control-label">Nama Materi</label>
									<input type="text" id="nama_materi" name="nama_materi"
										   placeholder="Nama Materi . . ."
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
											id="mapel_id" data-placeholder="Pilih Mata Pelajaran ...">
									</select>
								</div>
								<div class="form-group">
									<label class="control-label">Bab</label>
									<select class="select2 form-control" name="bab_id"
											id="bab_id" data-placeholder="Pilih Bab ...">
									</select>
								</div>

								<div class="form-group">
									<label class="control-label">Deskripsi Materi</label>
									<textarea id="deskripsi_materi" name="deskripsi_materi"></textarea>
								</div>
								<div class="row">
									<div class="col-sm-12 col-md-4">
										<div class="form-group">
											<label class="control-label">Durasi (Menit)</label>
											<input id="durasi" class="form-control" name="durasi" type="number" placeholder="00.00">
										</div>
									</div>
								</div>

								<div class="pull-right">
									<a href="<?= base_url('back/materi/' . $bab['meta_link_bab']) ?>"
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
