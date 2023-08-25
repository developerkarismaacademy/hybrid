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
						<form action="<?= base_url('back/peserta') ?>" method="get">
							<div class="mb-3 form-group">
								<label>Pelatihan</label>
								<select class="js-example-disabled-results" name="mapel" id="mapel">
									<option value="null">- Semua -</option>
									<?php foreach ($mapel as $m) : ?>
										<option value="<?= $m['meta_link_mapel'] ?>">(<?= $m['id_mapel'] ?>
											) <?= $m['nama_mapel'] ?></option>
									<?php endforeach ?>
								</select>
							</div>
							<div class="mb-3 form-group">
								<button type="submit" class="btn btn-primary btn-block">Filter</button>
							</div>
						</form>
						<table id="example" class="display mb-3" style="width:100%;">
							<thead>
							<tr>
								<th>#</th>
								<th>Kode Redeem</th>
								<th>Nama</th>
								<th>Email</th>
								<th>Pelatihan</th>
							</tr>
							</thead>
							<tbody>
							<?php $no = 1;
							foreach ($peserta as $data): ?>
								<tr>
									<td><?= $no ?></td>
									<td><?= $data['redeem_code'] ?></td>
									<td><?= $data['nama_user'] ?></td>
									<td><?= $data['email_user'] ?></td>
									<td><?= $data['nama_mapel'] ?></td>
								</tr>
								<?php $no++; endforeach; ?>
							</tbody>
						</table>
						<form action="<?= base_url('back/peserta/import') ?>" method="post"
							  enctype="multipart/form-data">
							<div class="mb-3 form-group">
								<label>CSV File</label>
								<input type="file" class="form-control" name="csv_file" accept=".csv">
							</div>
							<div class="mb-3 form-group">
								<button type="submit" class="btn btn-primary btn-block">Import</button>
							</div>
						</form>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
