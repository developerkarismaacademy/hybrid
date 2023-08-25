<div class="content-page">
	<div class="content">
		<div class="container">

			<!-- start row -->

			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
						<h4 class="page-title">
							<a data-toggle="tooltip" data-placement="top" title=""
							   data-original-title="Daftar Kompetensi <?= $mapel['nama_mapel'] ?>"
							   href="<?= base_url('back/kompetensi/' . $mapel['meta_link_mapel']) ?>">
								<i class="fa fa-arrow-left"></i>
							</a>
							<span
									title="<?= $title ?>"><?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?>
							</span>
						</h4>
						<ol class="breadcrumb p-0 m-0">
							<li>
								<a title="Daftar Kompetensi <?= $mapel['nama_mapel'] ?>"
								   href="<?= base_url('back/kompetensi/' . $mapel['meta_link_mapel']) ?>">
									<?= (strlen("Daftar Kompetensi " . $mapel['nama_mapel']) > 16 ? substr("Daftar Kompetensi " . $mapel['nama_mapel'], 0, 16) . "..." : "Daftar Kompetensi " . $mapel['nama_mapel']) ?>
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

			<input type="hidden" id="idMapel" value="<?= $mapel['id_mapel'] ?>">
			<input type="hidden" id="metaMapel" value="<?= $mapel['meta_link_mapel'] ?>"

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
						<div class="loading-form">
							<i class="fa fa-spin fa-circle-o-notch fa-4x"></i>
							<br>
							<br>
							Loading Data
						</div>
						<form id="form-urutan" method="post">
							<div class="pull-right">
								<a href="<?= base_url('back/kompetensi/' . $mapel['meta_link_mapel']) ?>"
								   class="btn btn-danger btn-bordered waves-effect">Back
								</a>

								<button type="submit"
										class="btn btn-info btn-bordered waves-effect">Simpan
								</button>
							</div>
							<div class="m-t-10 clearfix">
								<div class="custom-dd-empty dd" id="list-kompetensi">
									<ol class="dd-list">
										<?php foreach ($kompetensi as $key => $value) { ?>
											<li class="dd-item dd3-item" data-id="<?= $value['id_kompetensi'] ?>">
												<div class="dd-handle dd3-handle"></div>
												<div class="dd3-content">
													<?= $value['kompetensi'] ?>
												</div>
											</li>
										<?php } ?>
									</ol>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- end row -->
		</div>
	</div>
</div>
<!-- container -->
