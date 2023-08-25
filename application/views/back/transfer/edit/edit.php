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
					<div class="alert alert-icon alert-danger alert-dismissible fade in error-alert hidden"
						role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<div class="error-alert-container">

						</div>
					</div>
					<div class="card-box">
						<!-- Trigger the modal with a button -->
						<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="margin-bottom: 10px;"><i class="fa fa-plus"></i> Tambah Data</button> -->
						<!-- <a href="<?= base_url('back/invoice/v_import') ?>" class="btn btn-primary" style="margin-bottom: 10px;"><i class="fa fa-plus"></i> Import Excel</a> -->

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
											<textarea class="form-control" name="invoice" rows="5"
												id="invoice-value"></textarea>
										</div>
									</div>
									<div class="modal-footer">
										<button type="submit" class="btn btn-primary" id="cek-invoice">Simpan</button>
										<button type="button" class="btn btn-default"
											data-dismiss="modal">Close</button>
									</div>
								</div>

							</div>
						</div>
						<div>
							<form action="<?= base_url('back/transfer/edit/') . $log_gamification['id'] ?>"
								method="post">
								<div class="form-group">
									<label class="control-label">Nama User</label>
									<input type="text" id="nama_user" name="nama_user" placeholder="Nama User . . ."
										class="form-control" value="<?= $log_gamification['nama_user'] ?>" disabled>
								</div>
								<div class="form-group">
									<label class="control-label">Coin</label>
									<input type="text" id="nama_user" name="nama_user" placeholder="Nama User . . ."
										class="form-control" value="<?= $log_gamification['coin'] ?>" disabled>
								</div>
								<div class="form-group">
									<label class="control-label">Uang</label>
									<input type="text" id="nama_user" name="nama_user" placeholder="Nama User . . ."
										class="form-control"
										value="Rp <?= number_format($log_gamification['uang'], 2, ',', '.') ?>"
										disabled>
								</div>
								<div class="form-group">
									<label class="control-label">Status</label>
									<select class="js-example-disabled-results" name="status">
										<option value="success" <?= ($log_gamification['status'] == 'success') ? 'disabled="disabled"' : '' ?>>
											Success</option>
										<option value="pending" <?= ($log_gamification['status'] == 'pending') ? 'disabled="disabled"' : '' ?>>
											Pending</option>
									</select>
								</div>

								<a href="<?= base_url('back/transfer') ?>"
									class="btn btn-danger btn-bordered waves-effect">Back
								</a>
								<button type="submit" class="btn btn-info btn-bordered waves-effect">Simpan
								</button>
							</form>
						</div>
					</div>
				</div>
				<!-- end row -->
			</div>
		</div>
	</div>
	<!-- container -->