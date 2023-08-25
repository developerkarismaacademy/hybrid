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
							<span title="<?= $title ?>"><?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?>
							</span>
						</h4>
						<ol class="breadcrumb p-0 m-0">
							<li>
								<a title="Daftar Mata Pelajaran " href="">

								</a>
							</li>
							<li class="active">
								<span title="<?= $title ?>"><?= (strlen($title) > 18 ? substr($title, 0, 18) . "..." : $title) ?></span>
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
					<div class="alert alert-icon alert-danger alert-dismissible fade in error-alert hidden" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<div class="error-alert-container">

						</div>
					</div>
					<div class="card-box">
						<!-- Trigger the modal with a button -->
						<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="margin-bottom: 10px;"><i class="fa fa-plus"></i> Tambah Data</button> -->
						<a href="<?= base_url('back/invoice/v_import') ?>" class="btn btn-primary" style="margin-bottom: 10px;"><i class="fa fa-plus"></i> Import Excel</a>

						<!-- Modal -->
						<div id="myModal" class="modal fade" role="dialog">
							<div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Tambah Invoice</h4>
									</div>
									<div class="modal-body">
										<div class="form-group">
											<label for="" class="form-label">Invoice</label>
											<textarea class="form-control" name="invoice" rows="5" id="invoice-value"></textarea>
										</div>
									</div>
									<div class="modal-footer">
										<button type="submit" class="btn btn-primary" id="cek-invoice">Simpan</button>
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>

							</div>
						</div>
						<div>
							<table id="example" class="display" style="width:100%;">
								<thead>
									<tr>
										<th>#</th>
										<th>Invoice</th>
										<th>Email</th>
										<th>Ponsel</th>
										<th>Partisipasi</th>
										<th>Pembelian</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody id="invoice-data">

								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- end row -->
			</div>
		</div>
	</div>
	<!-- container -->