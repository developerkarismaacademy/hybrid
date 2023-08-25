<div class="content-page">
	<div class="content">
		<div class="container">

			<!-- start row -->

			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
						<h4 class="page-title">
							<a data-toggle="tooltip" data-placement="top" title=""
							   data-original-title="Daftar Materi <?= $bab['nama_bab'] ?>"
							   href="<?= base_url('back/materi/' . $bab['meta_link_bab']) ?>">
								<i class="fa fa-arrow-left"></i>
							</a>
							<span
									title="<?= $title ?>"><?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?>
							</span>
						</h4>
						<ol class="breadcrumb p-0 m-0">
							<li>
								<a title="Daftar Materi <?= $bab['nama_bab'] ?>"
								   href="<?= base_url('back/materi/' . $bab['meta_link_bab']) ?>">
									<?= (strlen("Daftar Materi " . $bab['nama_bab']) > 16 ? substr("Daftar Materi " . $bab['nama_bab'], 0, 16) . "..." : "Daftar Materi " . $bab['nama_bab']) ?>
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
			<input type="hidden" id="metaKelas" value="<?= $kelas['meta_link_kelas'] ?>">
			<input type="hidden" id="idMapel" value="<?= $mapel['id_mapel'] ?>">
			<input type="hidden" id="metaMapel" value="<?= $mapel['meta_link_mapel'] ?>">
			<input type="hidden" id="idBab" value="<?= $bab['id_bab'] ?>">
			<input type="hidden" id="metaBab" value="<?= $bab['meta_link_bab'] ?>">

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
						<div class="loading-form">
							<i class="fa fa-spin fa-circle-o-notch fa-4x"></i>
							<br>
							<br>
							Loading Data
						</div>
						<form id="form-urutan" method="post">
							<div class="pull-right">
								<a href="<?= base_url('back/materi/' . $bab['meta_link_bab']) ?>"
								   class="btn btn-danger btn-bordered waves-effect">Back
								</a>

								<button type="submit"
										class="btn btn-info btn-bordered waves-effect">Simpan
								</button>
							</div>
							<div class="m-t-10 clearfix">
								<div class="custom-dd-empty dd" id="list-bab">
									<ol class="dd-list">
										<?php foreach ($materi as $key => $value) {

											$icon = 'wpforms';

											switch ($value["tipe"]) {

												case 'video':
													$icon = 'youtube-play';
													break;
												case 'teks':
													$icon = 'leanpub';
													break;
												case 'pilihan':
													$icon = 'wpforms';
													break;
												case 'praktek':
													$icon = 'paint-brush';
													break;
											}
											?>
											<li class="dd-item dd3-item" data-id="<?= $value['id_materi'] ?>">
												<div class="dd-handle dd3-handle"></div>
												<div class="dd3-content">
													<i class="fa fa-<?= $icon ?>"></i> <?= $value['nama_materi'] ?>
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
