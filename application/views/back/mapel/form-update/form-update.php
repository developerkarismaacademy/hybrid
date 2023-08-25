<div class="content-page">
	<div class="content">
		<div class="container">

			<!-- start row -->

			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
						<h4 class="page-title">
							<a data-toggle="tooltip" data-placement="top" title=""
							   data-original-title="Daftar Mata Pelajaran <?= $kelas['nama_kelas'] ?>"
							   href="<?= base_url('back/mapel/' . $kelas['meta_link_kelas']) ?>">
								<i class="fa fa-arrow-left"></i>
							</a>
							<span
									title="<?= $title ?>"><?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?>
							</span>
						</h4>
						<ol class="breadcrumb p-0 m-0">
							<li>
								<a title="Daftar Mata Pelajaran <?= $kelas['nama_kelas'] ?>"
								   href="<?= base_url('back/mapel/' . $kelas['meta_link_kelas']) ?>">
									<?= (strlen("Daftar Mata Pelajaran " . $kelas['nama_kelas']) > 16 ? substr("Daftar Mata Pelajaran " . $kelas['nama_kelas'], 0, 16) . "..." : "Daftar Mata Pelajaran " . $kelas['nama_kelas']) ?>
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
						<form method="POST" id="form-mapel" enctype="multipart/form-data">
							<input type="hidden" id="id_mapel" name="id_mapel" value="<?= $id ?>"/>

							<h4 class="m-t-0 header-title"><b><?= $title ?></b></h4>
							<div class="pull-right">
								<a href="<?= base_url('back/mapel/' . $kelas['meta_link_kelas']) ?>"
								   class="btn btn-danger btn-bordered waves-effect">Back
								</a>
								<button type="button" onclick="FormMapel.reset();"
										class="btn btn-default btn-bordered waves-effect">Reset
								</button>
								<button type="submit"
										class="btn btn-info btn-bordered waves-effect">Simpan
								</button>
							</div>
							<div class="m-t-10 clearfix">
								<div class="form-group">
									<label class="control-label">Nama Mata Pelajaran</label>
									<input type="text" id="nama_mapel" name="nama_mapel"
										   placeholder="Nama Mata Pelajaran . . ."
										   class="form-control">
								</div>

								<div class="form-group">
									<label class="control-label">Kelas Mata Pelajaran</label>
									<select class="select2 form-control" name="kelas_id"
											id="kelas_id" data-placeholder="Pilih Kelas ...">
									</select>
								</div>

								<div class="form-group">
									<label class="control-label">Status Webinar</label>
									<br>
									<input type="checkbox" id="status_webinar" name="status_webinar" value="1"
										   class="form-control" switch="none"/>
									<label for="status_webinar" data-on-label="Webinar"
										   data-off-label="Bukan Webinar"></label>
								</div>
								<div class="form-group">
									<label class="control-label">Deskripsi Ringkas Mata Pelajaran</label>
									<input class="form-control" id="shortdesc_mapel" name="shortdesc_mapel" type="text" maxlength="255">
								</div>
								<div class="form-group">
									<label class="control-label">Deskripsi Detail Mata Pelajaran</label>
									<textarea id="deskripsi_mapel" name="deskripsi_mapel"></textarea>
								</div>
								<div class="form-group">
									<label class="control-label">Status Gratis</label>
									<br>
									<input type="checkbox" id="status_gratis" name="status_gratis" value="1"
										   class="form-control" switch="none"/>
									<label for="status_gratis" data-on-label="Gratis"
										   data-off-label="Berbayar"></label>
								</div>
								<table class="table m-0 table-colored-bordered table-bordered-teal">
									<thead>
									<tr>
										<th colspan="3" class="text-center">Harga</th>
									</tr>
									</thead>
									<tbody>
									<tr>
										<td>
											<div class="form-group">
												<label class="control-label">Harga Basic</label>
												<input type="text" id="harga_basic" name="harga_basic"
													   placeholder="Harga Basic . . ."
													   class="form-control">
											</div>
										</td>
										<td>
											<div class="form-group">
												<label class="control-label">Harga Silver</label>
												<input type="text" id="harga_silver" name="harga_silver"
													   placeholder="Harga Silver . . ."
													   class="form-control">
											</div>
										</td>
										<td>
											<div class="form-group">
												<label class="control-label">Harga Gold</label>
												<input type="text" id="harga_gold" name="harga_gold"
													   placeholder="Harga Gold . . ."
													   class="form-control">
											</div>
										</td>

									</tr>
									</tbody>
								</table>

								<table class="table m-0 table-colored-bordered table-bordered-danger">
									<thead>
									<tr>
										<th colspan="3" class="text-center">Diskon</th>
									</tr>
									</thead>
									<tbody>
									<tr>
										<td>
											<div class="form-group">
												<label class="control-label">Diskon Basic</label>
												<input type="number" id="diskon_basic" min="10" max="90"
													   name="diskon_basic" step="0.1"
													   placeholder="Diskon (Basic) . . ."
													   class="form-control">
											</div>
										</td>
										<td>
											<div class="form-group">
												<label class="control-label">Diskon Silver</label>
												<input type="number" id="diskon_silver" min="10" max="90"
													   name="diskon_silver" step="0.1"
													   placeholder="Diskon (Silver) . . ."
													   class="form-control">
											</div>
										</td>
										<td>
											<div class="form-group">
												<label class="control-label">Diskon Gold</label>
												<input type="number" id="diskon_gold" min="10" max="90"
													   name="diskon_gold" step="0.1"
													   placeholder="Diskon (Gold) . . ."
													   class="form-control">
											</div>
										</td>

									</tr>
									</tbody>
								</table>

								<div class="form-group m-t-20">
									<label class="control-label">Warna Alert</label>
									<select class="selectpicker m-b-0" name="alert_class" id="alert_class"
											data-style="btn-default">
										<option value="primary" data-icon="glyphicon-font text-primary">Primary</option>
										<option value="danger" data-icon="glyphicon-font text-danger">Danger</option>
										<option value="success" data-icon="glyphicon-font text-success">Success</option>
										<option value="warning" data-icon="glyphicon-font text-warning">Warning</option>
										<option value="info" data-icon="glyphicon-font text-info">Info</option>
									</select>
								</div>

								<div class="form-group">
									<label class="control-label">Tag Mata Pelajaran</label>
									<div class="tags-default">
										<input type="text" value=""
											   data-role="tagsinput" placeholder="add tags"/>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label">Teks Alert</label>
									<input type="text" id="alert_text" name="alert_text"
										   placeholder="Teks Alert . . ."
										   class="form-control">

								</div>
								<div class="form-group">
									<label class="control-label">Intro VIdeo</label>
									<input type="text" id="intro_video" name="intro_video"
										   placeholder="Youtube ID (dQw4w9WgXcQ)"
										   class="form-control">
									<a href="#" target="_blank" class="btn btn-success btn-bordered waves-effect"
									   id="intro_video_link">Cek Video</a>
								</div>

								<div class="form-group m-t-5">
									<label class="control-label">Gambar Mata Pelajaran</label>
									<br>
									<img src="<?= base_url() ?>/assets/back/images/no-image.jpg" id="img-gambar-mapel"
										 width="200">
									<br>
									<br>
									<input type="file" accept="image/*" class="filestyle" id="gambar_mapel"
										   name="gambar_mapel"
										   ref="file">
								</div>
								<div class="form-group m-t-5">
									<label class="control-label">Banner Mata Pelajaran</label>
									<br>
									<img src="<?= base_url() ?>/upload/banner_mapel/default.jpg" id="img-banner-mapel"
										 width="400">
									<br>
									<br>
									<input type="file" accept="image/*" class="filestyle" id="banner_mapel"
										   name="banner_mapel"
										   ref="file">
								</div>
								<div class="pull-right">
									<a href="<?= base_url('back/mapel/' . $kelas['meta_link_kelas']) ?>"
									   class="btn btn-danger btn-bordered waves-effect">Back
									</a>
									<button type="button" onclick="FormMapel.reset();"
											class="btn btn-default btn-bordered waves-effect">Reset
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
