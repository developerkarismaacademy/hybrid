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
									<?= (strlen("Daftar Mata Pelajaran" . $kelas['nama_kelas']) > 18 ? substr("Daftar Mata Pelajaran " . $kelas['nama_kelas'], 0, 18) . "..." : "Daftar Mata Pelajaran " . $kelas['nama_kelas']) ?>
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
						<h4 class="m-t-0 header-title"><b><?= $title ?></b></h4>
						<button data-toggle="tooltip" data-placement="top" title="" data-original-title="Refresh Data"
								onclick="ListKompetensi.refresh()"
								class="btn btn-icon waves-effect waves-light btn-primary">
							<i class="fa fa-refresh"></i>
						</button>
						<a data-toggle="tooltip" data-placement="top" title=""
						   data-original-title="Tambah Kompetensi"
						   href="<?= base_url('back/kompetensi/' . $mapel['meta_link_mapel'] . '/tambah') ?>"
						   class="btn btn-icon waves-effect waves-light btn-success">
							<i class="fa fa-plus"></i>
						</a>
						<a data-toggle="tooltip" data-placement="top" title=""
						   data-original-title="Setting Urutan Kompetensi <?= $mapel['nama_mapel'] ?>"
						   href="<?= base_url('back/kompetensi/' . $mapel['meta_link_mapel'] . '/setting-urutan') ?>"
						   class="btn btn-icon waves-effect waves-light btn-warning">
							<i class="fa fa-list"></i>
						</a>
						<div class="btn-limit">
							<select onchange="ListKompetensi.limitChange()" class="selectpicker"
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
									<col class="col-sm-6 text-right">
								</colgroup>
								<thead>
								<tr>
									<th id="th-kompetensi">Kompetensi</th>
									<th id="th-bab">Bab</th>
									<th class="text-right">ACTION</th>
								</tr>
								</thead>
								<tbody id="loading">
								<tr>
									<th colspan="3" class="text-center">
										<i class="fa fa-spin fa-circle-o-notch fa-4x"></i>
										<br>
										<br>
										Loading Data
									</th>
								</tr>
								</tbody>
								<tbody id="table-data">
								<tr id="clone-data" class="clone-data">
									<td class="kompetensi"> {{kompetensi.kompetensi}}</td>
									<td class="bab"> {{bab.urutan_bab + bab.bab}}</td>
									<td class="text-right">
										<a href="#"
										   class="btn waves-effect waves-light btn-teal link-detail"
										   data-toggle="tooltip"
										   data-placement="top" title="" data-original-title="Detail Kompetensi">
											<i class="fa fa-eye"></i>
										</a>
										<a class="btn waves-effect waves-light btn-warning link-ubah"
										   data-toggle="tooltip" data-placement="top" title=""
										   href="#"
										   data-original-title="Ubah">
											<i class="fa fa-pencil"></i>
										</a>
										<a href="#"
										   class="btn waves-effect waves-light btn-primary link-indikator-induk"
										   data-toggle="tooltip"
										   data-placement="top" title="" data-original-title="Daftar Indikator Induk">
											<i class="fa fa-list"></i>
										</a>
										<a class="btn waves-effect waves-light btn-danger link-hapus"
										   data-toggle="tooltip" data-placement="top" title=""
										   href="#" data-original-title="Hapus">
											<i class="fa fa-trash"></i>
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

<!-- Modal -->
<div id="modal-detail" class="modal-demo">

	<h4 class="custom-modal-title" id="nama-kompetensi-detail-title">Detail Kompetensi</h4>
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
					<td style="width: 20%;">Kompetensi</td>
					<td style="width: 80%;" id="kompetensi-detail">Otto</td>
				</tr>

				</tbody>
			</table>
			<button onclick="ListKompetensi.modalClose();"
					class="btn btn-icon waves-effect waves-light btn-danger pull-right m-t-10"><i
						class="fa fa-remove"></i> Tutup
			</button>
		</div>
	</div>
</div>
