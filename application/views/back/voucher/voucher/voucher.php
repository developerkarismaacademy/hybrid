
<div class="content-page">
	<div class="content">
		<div class="container">

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
						<h4 class="m-t-0 header-title"><b>Daftar Voucher</b></h4>
						<button data-toggle="tooltip" data-placement="top" title="" data-original-title="Refresh Data"
								onclick="ListKelas.refresh()"
								class="btn btn-icon waves-effect waves-light btn-primary">
							<i class="fa fa-refresh"></i>
						</button>

							<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Kelas"
							   href="<?= base_url('back/voucher/save') ?>"
							   class="btn btn-icon waves-effect waves-light btn-success">
								<i class="fa fa-plus"></i>
							</a>

						<div class="btn-limit">
							<select onchange="ListKelas.limitChange()" class="selectpicker"
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
									<col class="col-sm-6">
									<col class="col-sm-6 text-right">
								</colgroup>
								<thead>
								<tr>
									<th id="th-jumlah">#</th>
									<th id="th-nama">Kode Voucher</th>
									<th class="th-nama">Mapel</th>
									<th class="th-nama">Status</th>
								</tr>
								</thead>
<!--								<tbody id="loading">-->
<!--								<tr>-->
<!--									<th colspan="3" class="text-center">-->
<!--										<i class="fa fa-spin fa-circle-o-notch fa-4x"></i>-->
<!--										<br>-->
<!--										<br>-->
<!--										Loading Data-->
<!--									</th>-->
<!--								</tr>-->
<!--								</tbody>-->
								<tbody id="table-data">
									<tr id="clone-data" class="clone-data">
										<?php $no = 1;
										foreach ($voucher as $v) : ?>
									<tr>
										<td ><?= $no ?></td>
										<td><?= $v['kode_voucher'] ?></td>
										<td><?= $v['nama_mapel'] ?></td>
										<td><?= ($v['status'] == '1') ? 'Active' : 'Expired' ?></td>
									</tr>
									<?php $no++;
									endforeach; ?>

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

		</div>
	</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<script>
	function _(el) {
		return document.getElementById(el)
	}
	_('label').innerHTML = 'Kode Voucher'
</script>
