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
							<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Daftar Kelas"
							   href="<?= base_url('back/kelas') ?>">
								<i class="fa fa-arrow-left"></i>
							</a>
							<span
									title="<?= $title ?>"><?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?>
							</span>
						</h4>
						<ol class="breadcrumb p-0 m-0">
							<li><a href="<?= base_url('back/kelas') ?>">Daftar Kelas</a></li>
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
						<h4 class="m-t-0 header-title"><b><?= $title ?></b></h4>
						<button data-toggle="tooltip" data-placement="top" title="" data-original-title="Refresh Data"
								onclick="ListMapel.refresh()"
								class="btn btn-icon waves-effect waves-light btn-primary">
							<i class="fa fa-refresh"></i>
						</button>
						<?php
						if ($adminkah) {
							?>
							<a data-toggle="tooltip" data-placement="top" title=""
							   data-original-title="Tambah Mata Pelajaran"
							   href="<?= base_url('back/mapel/' . $kelas['meta_link_kelas'] . '/tambah') ?>"
							   class="btn btn-icon waves-effect waves-light btn-success">
								<i class="fa fa-plus"></i>
							</a>

							<?php
						}
						?>
						<div class="btn-limit">
							<select onchange="ListMapel.limitChange()" class="selectpicker"
									id="limit" data-style="btn-default">
								<option>10</option>
								<option>25</option>
								<option>50</option>
								<option>100</option>
							</select>
						</div>
						<div class="search-box pull-right">
							<form id="form-search">
								<div class="input-group">
								<span class="input-group-btn">
									<button type="submit"
											class="btn waves-effect waves-light btn-primary">
										<i class="fa fa-search"></i>
									</button>
								</span>
									<input type="text"
										   id="search" name="search" class="form-control"
										   placeholder="Search">
								</div>
							</form>
						</div>
						<div class="table-responsive m-t-10">
							<table
									class="table m-0 table-colored table-striped table-hover table-colored-bordered table-info table-bordered-info">
								<colgroup>
									<col class="col-sm-4">
									<col class="col-sm-2">
									<col class="col-sm-2">
									<col class="col-sm-6 text-right">
								</colgroup>
								<thead>
								<tr>
									<th id="th-nama">Mata Pelajaran</th>
									<th id="th-prakerja" class="text-center">Prakerja</th>
									<th id="th-sembunyikan" class="text-center">Tampilkan</th>
									<th class="text-right">ACTION</th>
								</tr>
								</thead>
								<tbody id="loading">
								<tr>
									<th colspan="4" class="text-center">
										<i class="fa fa-spin fa-circle-o-notch fa-4x"></i>
										<br>
										<br>
										Loading Data
									</th>
								</tr>
								</tbody>
								<tbody id="table-data">
								<tr id="clone-data" class="clone-data">
									<td class="nama-mapel"> {{mapel.nama_mapel}}</td>
									<td class="prakerja-mapel text-center">
										<div class="form-group">
											<div class="checkbox checkbox-primary checkbox-prakerja">
												<input class="checkbox-element" id="checkbox1" type="checkbox">
												<label class="checkbox-label" for="checkbox1">

												</label>
											</div>
										</div>
									</td>
									<td class="tampilkan-mapel text-center">
										<div class="form-group">
											<div class="checkbox checkbox-primary checkbox-tampilkan">
												<input class="checkbox-element" id="checkbox1" type="checkbox">
												<label class="checkbox-label" for="checkbox1">

												</label>
											</div>
										</div>
									</td>
									<td class="text-right">
										<?php
										if ($adminkah) {
											?>
											<div class="btn-group">
												<button type="button"
														class="btn btn-primary dropdown-toggle waves-effect waves-light "
														data-toggle="dropdown" aria-expanded="false"
														data-toggle="tooltip"
														data-placement="top" title
														data-original-title="Detail / Daftar">
													<i class="fa fa-list-alt"></i> <span class="caret"></span>
												</button>
												<ul class="dropdown-menu">
													<li>
														<a href="#"
														   class="link-daftartestimoni">
															<i class="glyphicon glyphicon-star"></i> List Testimoni
														</a>
													</li>
													<li>
														<a href="#"
														   class="link-siswa">
															<i class="fa fa-user"></i> Daftar Siswa
														</a>
													</li>
													<li>

														<a href="#"
														   class="link-kompetensi">
															<i class="fa fa-list"></i> Daftar Kompetensi
														</a>
													</li>
												</ul>
											</div>
											<div class="btn-group">
												<button type="button"
														class="btn btn-warning dropdown-toggle waves-effect waves-light"
														data-toggle="dropdown" aria-expanded="false" title
														data-original-title="Update"><i
															class="fa fa-pencil-square-o"></i><span
															class="caret"></span></button>
												<ul class="dropdown-menu">
													<li>
														<a class="link-ubah">
															<i class="fa fa-pencil"></i> Ubah Mapel
														</a>
													</li><li>
														<a class="link-ubah-detail">
															<i class="fa fa-pencil"></i> Ubah Detail Mapel
														</a>
													</li>
													<li>
														<a href="#" class="link-upload">
															<i class="fa fa-upload"></i> Upload Bab
														</a>
													</li>
													<li>
														<a href="#" class="link-detailclass">
															<i class="fa fa-info-circle"></i> Tampilan Detail
														</a>
													</li>
													<li>
														<a href="#" class="link-resetvideo">
															<i class="fa fa-youtube"></i> Reset Video
														</a>
													</li>
													<li>
														<a href="#" class="link-hapus text-danger">
															<i class="fa fa-trash"></i> Hapus
														</a>
													</li>
												</ul>
											</div>
											<?php
										}
										?>
										<a href="#"
										   class="btn waves-effect waves-light btn-teal link-detail"
										   data-toggle="tooltip"
										   data-placement="top" title="" data-original-title="Detail Mata Pelajaran">
											<i class="fa fa-eye"></i>
										</a>
										<a href="#"
										   class="btn waves-effect waves-light btn-info link-daftar"
										   data-toggle="tooltip"
										   data-placement="top" title="" data-original-title="Daftar Bab">
											<i class="fa fa-arrow-right"></i>
										</a>

										<a href="#"
										   class="btn waves-effect waves-light btn-purple link-diskusi"
										   data-toggle="tooltip"
										   data-placement="top" title="Daftar Diskusi">
											<i class="mdi mdi-comment-processing-outline"></i>
										</a>
									</td>
								</tr>
								</tbody>
							</table>
						</div>
						<div class="pagination-box text-center  m-t-15 m-b-5" id="paging-container">
							<p class="text-center font-weight-normal" id="paging-detail">
								Menampilkan ({awal} - {akhir} Dari {total} Data) <br>
								Halaman {current_page}, Total {total_page} Halaman
							</p>
							<ul class="pagination justify-content-center">
								<li class="page-item" id="btn-page-previous">
									<a class="page-link" href="#">Previous</a>
								</li>
								<li id="btn-page" class="page-item page-number hide">
									<a class="page-link" href="#">1</a>
								</li>
								<li class="page-item" id="btn-page-next">
									<a class="page-link" href="#">Next</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- end row -->
		</div>
	</div>
</div>
<!-- container -->

<!-- Modal -->
<div id="modal-detail" class="modal-demo">

	<h4 class="custom-modal-title" id="nama-mapel-detail-title">Detail Mata Pelajaran</h4>
	<div id="loading-modal" style="text-align: center;">
		<i class="fa fa-spin fa-circle-o-notch fa-4x"></i>
		<br>
		<br>
		Loading Data
	</div>
	<div id="modal-container" class="custom-modal-text">
		<div class="table-responsive">
			<table class="table table-bordered m-0">
				<tbody>
				<tr>
					<td>Nama Mata Pelajaran</td>
					<td id="nama-mapel-detail">Otto</td>
				</tr>
				<tr>
					<td>Kelas</td>
					<td id="nama-kelas-detail">Otto</td>
				</tr>
				<tr>
					<td>Deskripsi Ringkas</td>
					<td id="shortdesc-mapel-detail"></td>
				</tr>
				<tr>
					<td>Deskripsi Detail</td>
					<td id="deskripsi-mapel-detail">Thornton</td>
				</tr>
				<tr>
					<td>Gambar</td>
					<td>
						<img src="<?= base_url() ?>/assets/back/images/no-image.jpg" id="img-gambar-mapel-detail"
							 width="200">
					</td>
				</tr>
				</tr>
				<tr>
					<td>Status Gratis</td>
					<td id="status-gratis-mapel-detail">Thornton</td>
				</tr>
				</tbody>
			</table>
			<table class="table m-0 table-colored-bordered table-bordered-teal">
				<thead>
				<tr>
					<th colspan="3" class="text-center">Harga</th>
				</tr>
				<tr>
					<th class="text-center">Harga Basic</th>
					<th class="text-center">Harga Silver</th>
					<th class="text-center">Harga Gold</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td class="text-center" id="harga-basic-detail"></td>
					<td class="text-center" id="harga-silver-detail"></td>
					<td class="text-center" id="harga-gold-detail"></td>

				</tr>
				</tbody>
			</table>
			<button onclick="ListMapel.modalClose();"
					class="btn btn-icon waves-effect waves-light btn-danger pull-right m-t-10"><i
						class="fa fa-remove"></i> Tutup
			</button>
		</div>
	</div>
</div>

<div id="modal-upload" class="modal-demo">

	<h4 class="custom-modal-title" id="nama-mapel-detail-title">Upload Bab Mata Pelajaran</h4>
	<div id="loading-modal-upload" style="text-align: center;">
		<i class="fa fa-spin fa-circle-o-notch fa-4x"></i>
		<br>
		<br>
		Loading Data
	</div>
	<div id="modal-container-upload" class="custom-modal-text">
		<div class="table-responsive">
			<table class="table table-bordered m-0">
				<tbody>
				<tr>
					<td>Nama Mata Pelajaran</td>
					<td id="nama-mapel-upload">Otto</td>
				</tr>
				<tr>
					<td>Kelas</td>
					<td id="nama-kelas-upload">Otto</td>
				</tr>
				</tbody>
			</table>

			<form method="post" id="form-mapel-upload" action="<?= base_url("back/simpan-excel-mapel/") ?>"
				  enctype="multipart/form-data">
				<div class="m-t-10 clearfix">
					<div class="form-group m-t-5">
						<input type="hidden" id="id_mapel" name="id" value="0"/>
						<label class="control-label">Upload Mata Pelajaran</label>
						<input type="file"
							   class="filestyle" id="gambar_mapel"
							   name="excel"
							   ref="file">
					</div>
				</div>
				<button type="submit"
						class="btn btn-info btn-bordered waves-effect">Simpan
				</button>
				<button onclick="ListMapel.modalClose();"
						class="btn btn-icon waves-effect waves-light btn-danger pull-right m-t-10"><i
							class="fa fa-remove"></i> Tutup
				</button>

			</form>
		</div>
	</div>
</div>
