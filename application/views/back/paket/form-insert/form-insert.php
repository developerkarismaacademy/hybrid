<div class="content-page">
	<div class="content">
		<div class="container">

			<!-- start row -->

			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
						<h4 class="page-title">
							<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Daftar Kelas"
							   href="<?= base_url('back/paket') ?>">
								<i class="fa fa-arrow-left"></i>
							</a>
							<span
								title="<?= $title ?>"><?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?></span>
						</h4>
						<ol class="breadcrumb p-0 m-0">
							<li><a href="<?= base_url('back/kelas') ?>">Daftar Paket</a></li>
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
						<form method="POST" id="form-paket" enctype="multipart/form-data">
							<h4 class="m-t-0 header-title"><b><?= $title ?></b></h4>
							<div class="pull-right">
								<a href="<?= base_url('back/paket') ?>"
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
									<label class="control-label">Nama Paket</label>
									<input type="text" id="nama_paket" name="nama_paket" placeholder="Nama paket . . ."
										   class="form-control">

								</div>
								<div class="form-group">
									<label class="control-label">Deskripsi Singkat</label>
									<textarea class="form-control" id="deskripsi_singkat"
											  name="deskripsi_singkat"></textarea>
								</div>
								<div class="form-group">
									<label class="control-label">Warna Font</label>
									<select class="selectpicker m-b-0" name="color_paket" id="color_paket"
											data-style="btn-default">
										<option value="primary" data-icon="glyphicon-font text-primary">Primary</option>
										<option value="danger" data-icon="glyphicon-font text-danger">Danger</option>
										<option value="success" data-icon="glyphicon-font text-success">Success</option>
										<option value="warning" data-icon="glyphicon-font text-warning">Warning</option>
										<option value="info" data-icon="glyphicon-font text-info">Info</option>
									</select>
								</div>
								<div class="form-group">
									<label class="control-label">Deskripsi Paket</label>
									<textarea id="deskripsi" name="deskripsi"></textarea>
								</div>

								<div class="form-group">
									<label class="control-label">Harga Basic</label>
									<input type="text" id="harga_basic" name="harga_basic" class="form-control" placeholder="Harga Basic">
								</div>
								<div class="form-group">
									<label class="control-label">Harga Gold</label>
									<input type="text" id="harga_gold" name="harga_gold" class="form-control" placeholder="Harga Basic">
								</div>
							
								<div class="form-group m-t-5">
									<label class="control-label">Banner Paket</label>
									<br>
									<img src="<?= base_url() ?>/upload/baner-paket/default.jpg"
										 id="img-banner-paket"
										 width="200">
									<br>
									<br>
									<input type="file" accept="image/*" class="filestyle" id="banner_paket"
										   name="banner_paket"
										   ref="file">
								</div>

								<div class="pull-right">
									<a href="<?= base_url('back/paket') ?>"
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
