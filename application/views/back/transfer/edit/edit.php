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
						<div>
							<form action="<?= base_url('back/transfer/edit/') . $transfer['id'] ?>"
								method="post">
								<div class="form-group">
									<label class="control-label">Nama</label>
									<input type="text" id="nama_user" name="nama_user" placeholder="Nama User . . ."
										class="form-control" value="<?= $transfer['nama_user'] ?>" disabled>
								</div>
								<div class="form-group">
									<label class="control-label">Email</label>
									<input type="text" id="email" name="email"
										class="form-control" value="<?= $transfer['email_user'] ?>" disabled>
								</div>
								<div class="form-group">
									<label class="control-label">Bank Number</label>
									<input type="text" id="bank_number" name="bank_number"
										class="form-control" value="<?= $transfer['bank_number'] ?>" disabled>
								</div>
								<div class="form-group">
									<label class="control-label">Bank Type</label>
									<input type="text" id="bank_type" name="bank_type"
										class="form-control" value="<?= $transfer['bank_type'] ?>" disabled>
								</div>
								<div class="form-group">
									<label class="control-label">Status</label>
									<select class="js-example-disabled-results" name="status">
										<option value="success" <?= ($transfer['status'] == 'success') ? 'selected"' : '' ?>>
											Success</option>
										<option value="pending" <?= ($transfer['status'] == 'pending') ? 'selected"' : '' ?>>
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
						<div>
							<table class="table table-bordered" style="margin-top: 1rem">
								<thead>
								<tr>
									<th>Invoice</th>
									<th>Coin</th>
									<th>Status</th>
									<th>Pelatihan</th>
								</tr>
								</thead>
								<tbody>
								<?php foreach ($invoice as $data): ?>
									<tr>
										<td><?= $data['invoice'] ?></td>
										<td><?= $data['coin'] ?></td>
										<td><?= $data['status'] ?></td>
										<td><?= $data['nama_mapel'] ?></td>
									</tr>
								<?php endforeach; ?>
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
