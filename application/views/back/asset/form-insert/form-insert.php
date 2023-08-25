<div class="content-page">
	<div class="content">
		<div class="container">

			<!-- start row -->

			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
						<h4 class="page-title">
							<a data-toggle="tooltip" data-placement="top" title=""
							   data-original-title="Daftar Materi <?= $materi['nama_materi'] ?>"
							   href="<?= base_url('back/asset') ?>">
								<i class="fa fa-arrow-left"></i>
							</a>
							<span
									title="<?= $title ?>"><?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?></span>
						</h4>
						<ol class="breadcrumb p-0 m-0">
							<li><a href="<?= base_url('back/voucher') ?>">Daftar Kelas</a></li>
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
						<form method="POST" id="form-asset" enctype="multipart/form-data">
							<h4 class="m-t-0 header-title"><b><?= $title ?></b></h4>
							<div class="pull-right">
								<a href="<?= base_url('back/asset/' . $materi['id_materi']) ?>"
								   class="btn btn-danger btn-bordered waves-effect">Back
								</a>
								<button type="reset" class="btn btn-default btn-bordered waves-effect">Reset
								</button>
								<button type="submit"
										class="btn btn-info btn-bordered waves-effect">Simpan
								</button>
							</div>
							<div class="m-t-10 clearfix">
								<input type="hidden" id="materi_id" name="materi_id"
									   value="<?= $materi['id_materi'] ?>">

								<div class="clearfix"></div>
								<div class="form-group link-asset">
									<label class="control-label">Link Asset</label>
									<input type="text" id="link" name="link" placeholder="link Asset . . ."
										   class="form-control">
								</div>
								<div class="form-group file-asset">
									<label class="control-label">File Asset</label>
									<small>Jika File Lebih Dari 20mb pilih tipe asset link dan upload di google
										drive</small>
									<input type="file" class="filestyle" id="file"
										   name="file" ref="file">
								</div>
								<div class="form-group">
									<label class="control-label">Tipe Asset</label>
									<select class="form-control" name="tipe" id="tipe"
											data-style="btn-default">
										<option value="file">File</option>
										<option value="link">Link</option>
									</select>
								</div>
								<div class="form-group">
									<label class="control-label">Nama Asset</label>
									<input type="text" id="nama" name="nama" placeholder="Nama Asset . . ."
										   class="form-control">
								</div>

								<div class="pull-right">
									<a href="<?= base_url('back/asset/' . $materi['id_materi']) ?>"
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
