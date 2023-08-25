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
			<!-- start row -->
			<div class="row">
				<div class="col-sm-12">
					<div class="card-box">
						<form action="<?= base_url() . 'back/materi/' . $materi['meta_link_materi'] . '/ubah/pdf' ?>"
							  method="POST" enctype="multipart/form-data">
							<h4 class="m-t-0 header-title"><b>
									<?= $title ?>
								</b></h4>
							<div class="pull-right">
								<a href="<?= base_url('back/materi/' . $bab['meta_link_bab']) ?>"
								   class="btn btn-danger btn-bordered waves-effect">Back
								</a>
								<button type="submit" class="btn btn-info btn-bordered waves-effect">Simpan
								</button>
							</div>
							<div class="m-t-10 clearfix">
								<div class="form-group">
									<label class="control-label">Nama Materi</label>
									<input type="text" id="nama_materi" name="nama_materi"
										   placeholder="Nama Materi . . ." class="form-control"
										   value="<?= $materi['nama_materi'] ?>">
								</div>
								<div class="form-group">
									<label class="control-label">PDF Materi</label>
									<input type="file" accept="application/pdf" name="pdf_file" class="form-control">
								</div>
								<div class="form-group">
									<label class="control-label">Status Webinar</label>
									<br>
									<input type="checkbox" id="webinar_status" name="webinar_status" value="1"
										   class="form-control"
										   switch="none" <?= $materi['webinar_status'] == 1 ? 'checked' : '' ?>/>
									<label for="webinar_status" data-on-label="Webinar"
										   data-off-label="Non Webinar"></label>
								</div>
								<br>
								<br>
								<div class="pull-right">
									<a href="<?= base_url('back/materi/' . $bab['meta_link_bab']) ?>"
									   class="btn btn-danger btn-bordered waves-effect">Back
									</a>
									<button type="submit" class="btn btn-info btn-bordered waves-effect">Simpan
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
