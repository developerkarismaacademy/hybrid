<div class="content-page">
	<div class="content">
		<div class="container">

			<!-- start row -->

			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
						<h4 class="page-title">
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
						<form method="POST" id="form-beli" enctype="multipart/form-data">
							<h4 class="m-t-0 header-title"><b><?= $title ?></b></h4>
							<div class="pull-right">
								<a href="<?= base_url('back/mapel/pembelian')?>"
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
									<label class="control-label">Siswa <a href="<?= base_url('back/siswa/'); ?>" style="display:none;" id="siswa-link" target="_blank">(lihat siswa)</a></label>
									<select id="siswa_id" name="siswa_id"
										   data-placeholder="Pilih Siswa ..."
										   class="select2 form-control">
									</select>
								</div>
								<div class="form-group">
									<label class="control-label">Kelas <a href="<?= base_url('back/mapel/'); ?>" style="display:none;" id="kelas-link" target="_blank">(menuju kelas)</a></label>
									<select id="kelas_id" name="kelas_id"
										   data-placeholder="Pilih Kelas yang Akan Dibeli ..."
										   class="select2 form-control">
									</select>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label class="control-label">Mapel <a href="<?= base_url('back/bab/'); ?>" style="display:none;" id="mapel-link" target="_blank">(menuju mapel)</a></label>
											<select id="mapel_id" name="mapel_id"
													data-placeholder="Pilih Mapel yang Akan Dibeli (Pilih Kelas Dahulu) ..."
													class="select2 form-control">
											</select>
										</div>
										<div class="col-md-6">
											<label class="control-label" for="level_mapel">Level</label>
											<select id="level_mapel" name="level_mapel"
													data-placeholder="Pilih Level ..."
													class="select2 form-control" required>
													<option value="1" selected>(1) Level Basic</option>
													<option value="2">(2) Level Silver</option>
													<option value="3">(3) Level Gold</option>
											</select>
										</div>
									</div>
								</div>
								<hr>
								<h4 class="header-title">Data Pembayaran</h4>
								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label class="control-label text-success">Jumlah / Total Bayar (Otomatis)</label>
											<input type="number" id="jumlah_bayar" name="jumlah_bayar" class="form-control disabled" readonly value="0">
										</div>
										<div class="col-md-6">
											<label class="control-label text-success">Status (Otomatis)</label>
											<input type="hidden" id="status" name="status" value="2">
											<select id="status_dummy" name="status_dummy"
													data-placeholder="Status pembayaran"
													class="select2 form-control" disabled required>
													<?php
													// <option value="0">(0) Belum dibayar</option>
													// <option value="1">(1) Tunggu Konfirmasi</option>
													?>
													<option value="2" selected>(2) Lunas</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label class="control-label">Bank User</label>
											<input type="text" name="bank_user" class="form-control" value="BCA">
										</div>
										<div class="col-md-6">
											<label class="control-label">Bank Karisma</label>
											<select id="bank_karisma" name="bank_karisma"
													data-placeholder="Bank Karisma pembayaran"
													class="select2 form-control" required>
													<?php
													foreach(bank as $key=>$value){ ?>
													<option value="<?=$value['nama']?>"><?=$value['nama']?> (<?=$value['rekening']?>)</option>
													<?php
													}
													?>
											</select>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label class="control-label">Nomor Rek. User</label>
											<input type="text" name="no_rek_user" class="form-control" value="000000">
										</div>
										<div class="col-md-6">
											<label class="control-label">Atas Nama</label>
											<input type="text" name="atas_nama" class="form-control" value="Admin">
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-6">
											<label class="control-label">Bukti Transfer</label>
											<select id="bukti_transfer" name="bukti_transfer"
													data-placeholder="Pilih Jenis Bukti ..."
													class="select2 form-control" required>
													<option value="default-developer.jpg">Developer</option>
													<option value="default-kursus-offline.jpg">Kursus Offline</option>
													<option value="default-manual.jpg">Lainnya (Manual)</option>
											</select>
											<img src="<?= base_url() ?>/upload/transaksi/default-developer.jpg" 			
											id="img-bukti-transfer"
											width="200" height="200" style="object-fit:cover;" class="m-t-25">
										</div>
									</div>
								</div>
								<div class="pull-right">
									<a href="<?= base_url('back/pembelian') ?>"
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
