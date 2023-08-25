<div class="content-page">
	<div class="content">
		<div class="container">

			<!-- start row -->

			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
                    <h4 class="page-title">
							<a data-toggle="tooltip" data-placement="top" title=""
							   data-original-title="Daftar Mata Pelajaran <?= $kelas['nama_kelas'] ?>"
							   href="<?= base_url('back/mapel/' . $kelas['meta_link_kelas']) ?>">
								<i class="fa fa-arrow-left"></i>
							</a>
							<span title="<?= $title ?>"><?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?>
							</span>
						</h4>
						<ol class="breadcrumb p-0 m-0">
							<li>
								<a title="Daftar Mata Pelajaran <?= $kelas['nama_kelas'] ?>"
								   href="<?= base_url('back/mapel/' . $kelas['meta_link_kelas']) ?>">
									<?= (strlen("Daftar Mata Pelajaran " . $kelas['nama_kelas']) > 16 ? substr("Daftar Mata Pelajaran " . $kelas['nama_kelas'], 0, 16) . "..." : "Daftar Mata Pelajaran " . $kelas['nama_kelas']) ?>
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

			<input type="hidden" id="idMapel" value="<?= $mapel['id_mapel'] ?>">
			<input type="hidden" id="metaMapel" value="<?= $mapel['meta_link_mapel'] ?>">
			<input type="hidden" id="metaKelas" value="<?= $kelas['meta_link_kelas'] ?>">

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
						<?php
						// $section on controller Mapel.php/detail
						foreach($section as $item){
							$this->load->view("back/mapel/tampilan-detail/section-".$item);
						}
						?>
					</div>
				</div>
			</div>
			<!-- end row -->
		</div>
	</div>
</div>
