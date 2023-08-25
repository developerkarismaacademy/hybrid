<div class="content-page">
	<div class="content">
		<div class="container">

			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
						<h4 class="page-title">
							<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Absen"
							   href="<?= base_url('back/absen') ?>">
								<i class="fa fa-arrow-left"></i>
							</a>
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
					<form action="<?= base_url('back/absen/murid/' . $idAbsen . '/simpan') ?>" method="POST"
						  class="card-box">
						<div class="card-box">
							<table id="example" class="display" style="width:100%;">
								<thead>
								<tr>
									<th>#</th>
									<th>Nama Murid</th>
									<th>Status</th>
								</tr>
								</thead>
								<tbody>
								<?php $no = 1;
								foreach ($murid as $item) : ?>
									<tr>
										<td><?= $no ?></td>
										<td><?= $item['nama_user'] ?></td>
										<td><?= $item['status'] == 1 ? '<span class="badge badge-success">Hadir</span>' : '<span class="badge badge-danger">Tidak Hadir</span>' ?></td>
									</tr>
									<?php $no++;
								endforeach; ?>
								</tbody>
							</table>
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>
</div>
