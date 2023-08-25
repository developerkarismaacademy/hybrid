<div class="content-page">
	<div class="content">
		<div class="container">

			<!-- start row -->

			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
						<h4 class="page-title">
							<?php
							//ID
							if (isset($materi_id)) { ?>
								<input type="hidden" name="materi_id" id="idMateri" value="<?= $materi_id ?>">
								<input type="hidden" name="meta_materi" id="metaMateri" value="<?= $meta_materi ?>">
								<?php
							}
							if (isset($bab_id)) { ?>
								<input type="hidden" name="bab_id" id="idBab" value="<?= $bab_id ?>">
								<input type="hidden" name="meta_bab" id="metaBab" value="<?= $meta_bab ?>">

								<?php
							}
							if (isset($mapel_id)) { ?>
								<input type="hidden" name="mapel_id" id="idMapel" value="<?= $mapel_id ?>">
								<input type="hidden" name="meta_mapel" id="metaMapel" value="<?= $meta_mapel ?>">

								<?php
							}
							if (isset($kelas_id)) { ?>
								<input type="hidden" name="kelas_id" id="idKelas" value="<?= $kelas_id ?>">
								<input type="hidden" name="meta_kelas" id="metaKelas" value="<?= $meta_kelas ?>">

								<?php
							}

							//Button
							if (isset($bab_id)) { ?>
								<a data-toggle="tooltip" data-placement="top" title="" class="text-danger"
								   data-original-title="Daftar Materi"
								   href="<?= base_url('back/materi/' . $meta_bab) ?>">
									<i class="fa fa-arrow-left"></i>
								</a>
								<?php
							} else if (isset($mapel_id)) { ?>
								<a data-toggle="tooltip" data-placement="top" title="" class="text-info"
								   data-original-title="Daftar Mapel"
								   href="<?= base_url('back/mapel/' . $meta_kelas) ?>">
									<i class="fa fa-arrow-left"></i>
								</a>
								<?php
							} ?>

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
						<h4 class="m-t-0 header-title"><b>Daftar Diskusi</b></h4>
						<button data-toggle="tooltip" data-placement="top" title="" data-original-title="Refresh Data"
								onclick="ListDiskusi.refresh()"
								class="btn btn-icon waves-effect waves-light btn-primary">
							<i class="fa fa-refresh"></i>
						</button>
						<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Diskusi"
						   href="javascript:ListDiskusi.tambahDiskusi(0)"
						   class="btn btn-icon waves-effect waves-light btn-success">
							<i class="fa fa-plus"></i>&nbsp;<i class="mdi mdi-comment-processing-outline"></i>
						</a>
						<div class="btn-limit">
							<select onchange="ListDiskusi.limitChange()" class="selectpicker"
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
									<col class="col-sm-1">
									<col class="col-sm-3">
									<col class="col-sm-2">
									<col class="col-sm-1">
									<col class="col-sm-1">
									<col class="col-sm-2 text-center">
									<col class="col-sm-2 text-right">
								</colgroup>
								<thead>
								<tr>
									<th id="th-id">ID</th>
									<th id="th-isi">Isi</th>
									<th id="th-nama">Nama</th>
									<th id="th-tipe">Tipe</th>
									<th id="th-lokasi">Lokasi</th>
									<th id="th-deleted">Dihapus?</th>
									<th class="text-right">ACTION</th>
								</tr>
								</thead>
								<tbody id="loading">
								<tr>
									<th colspan="7" class="text-center">
										<i class="fa fa-spin fa-circle-o-notch fa-4x"></i>
										<br>
										<br>
										Loading Data
									</th>
								</tr>
								</tbody>
								<tbody id="table-data">
								<tr id="clone-data" class="clone-data">
									<td class="id"> {{diskusi.id}}</td>
									<td>
										<div class="isi line-limit-1">{{diskusi.isi}}</div>
									</td>
									<td class="nama"> {{diskusi.nama}}</td>
									<td class="tipe"> {{diskusi.tipe}}</td>
									<td class="lokasi"> {{diskusi.lokasi}}</td>
									<td class="deleted"> {{diskusi.deleted}}</td>
									<td class="text-right">
										<a class="btn waves-effect waves-light btn-warning link-ubah"
										   data-toggle="tooltip" data-placement="top" title="Ubah"
										   href="#"
										   data-original-title="">
											<i class="fa fa-pencil"></i>
										</a>
										<a class="btn waves-effect waves-light btn-purple link-reply"
										   data-toggle="tooltip" data-placement="top" title="Balas"
										   href="#"
										   data-original-title="">
											<i class="mdi mdi-reply"></i>
										</a>
										<a class="btn waves-effect waves-light btn-danger link-hapus"
										   data-toggle="tooltip" data-placement="top" title="Hapus"
										   href="#" data-original-title="">
											<i class="fa fa-trash"></i>
										</a>
									</td>
								</tr>
								</tbody>
							</table>
						</div>
						<div class="pagination-box text-center m-t-15 m-b-5" id="paging-container">
							<p class="text-center font-weight-normal" id="paging-detail">
								Menampilkan ({awal} - {akhir} Dari {total} Data) <br>
								Halaman {current_page}, Total {total_page} Halaman
							</p>
							<ul class="pagination justify-content-center">
								<li class="page-item" id="btn-page-previous">
									<a class="page-link" href="#">Previous</a>
								</li>
								<li id="btn-page" class="page-item page-number hide"><a class="page-link"
																						href="#">1</a>
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

<div id="modal-modif" class="modal-demo">

	<h4 class="custom-modal-title" id="modif-diskusi-title"></h4>
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
				<tr id="balas-view" class="d-none">
					<td>Topik</td>
					<td id="isi-topik-modif">Topik</td>
				</tr>
				<tr id="ubah-view" class="d-none">
					<td>Sebelum diubah</td>
					<td id="isi-modif"></td>
				</tr>
				<tr>
					<td>Isikan diskusi</td>
					<td id="form-modif"></td>
				</tr>
				</tbody>
			</table>
			<a id="modal-submit"
			   class="btn btn-icon waves-effect waves-light btn-warning pull-right m-t-10 m-l-5"><i
						class="fa fa-pencil"></i> Submit
			</a>
			<button onclick="ListDiskusi.modalClose();"
					class="btn btn-icon waves-effect waves-light btn-danger pull-right m-t-10"><i
						class="fa fa-remove"></i> Batalkan
			</button>
		</div>
	</div>
</div>
