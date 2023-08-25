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
							<a href="<?= base_url('back/materi/').$meta_link_bab?>">
								<i class="fa fa-arrow-left"></i>
							</a>
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
						<table id="example" class="display" style="width:100%">
							<thead>
								<tr>
									<th>#</th>
									<th>Package Name</th>
									<th>Count</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($package as $p) : ?>
									<tr>
										<td><?= $no; ?></td>
										<td><?= $p['package'] ?></td>
										<td><?= $p['package_count'] ?></td>
										<td>
											<a href="<?= base_url('back/materi/').$meta_link_materi.'/soal/latihan?paket='.$p['id'] ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Daftar Soal"><i class="fa fa-list-ol"></i></a>
										</td>
									</tr>
								<?php $no++;
								endforeach; ?>
							</tbody>
							<tfoot>
								<tr>
									<th>#</th>
									<th>Package Name</th>
									<th>Count</th>
									<th>Action</th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
				<!-- end row -->
			</div>
		</div>
	</div>
	<!-- container -->