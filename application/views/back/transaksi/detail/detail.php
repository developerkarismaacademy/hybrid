<div class="content-page">
	<div class="content">
		<div class="container">

			<!-- start row -->

			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
						<h4 class="page-title">
							<a data-toggle="tooltip" data-placement="top" title="Daftar Pembelian"
							   href="<?= base_url('back/pembelian') ?>"
							   data-original-title="Daftar Pembelian">
								<i class="fa fa-arrow-left"></i>
							</a>
							<span class="title-page" title="">
							</span>
						</h4>
						<ol class="breadcrumb p-0 m-0">
							<li>
								<a title="Daftar Pembelian"
								   href="<?= base_url('back/pembelian') ?>">
									Daftar Pembelian
								</a>
							</li>
							<li class="active">
								<span class="title-page" title=""></span>
							</li>
						</ol>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<!-- end row -->

			<input type="hidden" id="idTransaksi" value="<?= $id ?>">
			<input type="hidden" id="idUser" value="<?= $id_user ?>">

			<!-- start row -->
			<div class="row">
				<div class="col-sm-12">
					<div class="card-box">
						<h4 class="m-t-0 header-title"><b>Data User</b></h4>
						<table class="table table-bordered m-0">
							<colgroup>
								<col class="col-sm-4">
								<col class="col-sm-8">
							</colgroup>
							<tbody>
							<tr>
								<td>Nama</td>
								<td id="nama-user">Otto</td>
							</tr>
							<tr>
								<td>Email</td>
								<td id="email-user">Otto</td>
							</tr>
							<tr>
								<td>No. TELP</td>
								<td id="no-telp-user">Otto</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-md-12">
					<div class="panel panel-default">
						<!-- <div class="panel-heading">a
							<h4>Invoice</h4>
						</div> -->
						<div class="panel-body">
							<div class="clearfix">

								<div class="pull-right">
									<h4>
										Invoice #<?= sprintf("%08d", $id) ?>
									</h4>
								</div>
							</div>
							<hr class="m-t-0 m-b-0">
							<div class="row">
								<div class="col-md-12">

									<div class="pull-left m-t-10">
										<address>
											<strong>Karisma Academy</strong><br>
											Jl. Watu Gong No.18, Ketawanggede,<br>
											Kec. Lowokwaru, Kota Malang,<br>
											Jawa Timur 65145<br>
											<abbr title="Phone">P:</abbr> (0341) 2995599
										</address>
									</div>
									<div class="pull-right m-t-10">
										<strong>Order Date: </strong> <span id="tanggal"></span><br>
										<strong>Order Status: </strong> <span id="status-order"></span><br>
									</div>
								</div><!-- end col -->
							</div>
							<!-- end row -->

							<div class="m-h-50"></div>

							<div class="row">
								<div class="col-md-12">
									<div class="table-responsive">
										<table class="table m-t-30 table-colored table-info">
											<colgroup>
												<col class="col-sm-4">
												<col class="col-sm-2 text-right">
												<col class="col-sm-6 text-right">
											</colgroup>
											<thead>
											<tr>
												<th id="th-mapel">Mata Pelajaran</th>
												<th id="th-paket" class="text-center">Paket</th>
												<th id="th-harga" class="text-right"> Harga</th>
											</tr>
											</thead>
											<tbody id="loading">
											<tr>
												<th colspan="5" class="text-center">
													<i class="fa fa-spin fa-circle-o-notch fa-4x"></i>
													<br>
													<br>
													Loading Data
												</th>
											</tr>
											</tbody>
											<tbody id="table-data">
											<tr id="clone-data" class="clone-data">
												<td class="nama-mapel"> {{mapel.nama}}</td>
												<td class="level-mapel text-center"> {{transaksi.paket_mapel}}</td>
												<td class="harga-mapel text-right"> {{transaksi.harga}}</td>
											</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6">

								</div>
								<div class="col-md-3 col-sm-6 col-xs-6 col-md-offset-3">
									<hr>
									<h3 class="text-right" id="total">USD 2930.00</h3>
								</div>
							</div>
							<hr>
							<div class="hidden-print">
								<div class="pull-right">
									<a href="javascript:window.print()"
									   class="btn btn-inverse waves-effect waves-light"><i class="fa fa-print"></i></a>
									<button id="confirm-button"
											class="btn btn-primary waves-effect waves-light">
										Submit
									</button>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
			<!-- end row -->


			<!-- start row -->
			<div class="row">


				<div class="col-sm-12">
					<div class="card-box">
						<h4 class="m-t-0 header-title"><b>Detail Pembayaran</b></h4>
						<table class="table table-bordered m-0">
							<colgroup>
								<col class="col-sm-4">
								<col class="col-sm-8">
							</colgroup>
							<tbody>
							<tr>
								<td>Rekening Bank Pembeli</td>
								<td id="bank-user">Otto</td>
							</tr>
							<tr>
								<td>Rekening Bank Karisma</td>
								<td id="bank-karisma">Otto</td>
							</tr>
							<tr>
								<td>No. Rekening User</td>
								<td id="no-rek-user">Otto</td>
							</tr>
							<tr>
								<td>Atas Nama Pembayaran</td>
								<td id="atas-nama">Otto</td>
							</tr>
							<tr>
								<td>Total Transfer</td>
								<td id="total-bayar-transaksi">Thornton</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="col-sm-12">
					<div class="card-box text-center">
						<h4 class="m-t-0 header-title"><b>Bukti Pembayaran</b></h4>

						<img src="" width="200" id="bukti-transfer">

					</div>
				</div>


			</div>


			<!-- end row -->
		</div>
	</div>
</div>
