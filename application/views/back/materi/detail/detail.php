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
			<input type="hidden" id="id_materi" value="<?= $id ?>">


			<!-- start row -->
			<div class="row">
				<div class="col-sm-12">
					<div class="card-box">
						<div class="navigation-materi m-b-15 d-flex justify-content-between align-items-center">
							<?php
							if ($materiAwal) { ?>
								<a class="btn btn-inverse"
								   href="<?= base_url("back/bab/{$bab['meta_link_mapel']}/") ?>"><i
											class="fa fa-th-list"></i> Bab
								</a>
								<?php
							} else { ?>
								<a class="btn btn-danger" href="<?= $linkSebelumnya ?>">Prev <i
											class="fa fa-chevron-left"></i></a>
								<?php
							} ?>
							<h4><?= "BAB " . $bab['urutan_bab'] . ". " . $bab['nama_bab'] ?></h4>
							<?php
							if ($materiAkhir) { ?>
								<a class="btn btn-inverse"
								   href="<?= base_url("back/bab/{$bab['meta_link_mapel']}/") ?>">Bab <i
											class="fa fa-th-list"></i>
								</a>
								<?php
							} else { ?>
								<a class="btn btn-warning" href="<?= $linkSelanjutnya ?>">Next <i
											class="fa fa-chevron-right"></i></a>
								<?php
							} ?>
						</div>

						<table class="table table-bordered m-0">
							<colgroup>
								<col class="col-sm-4">
								<col class="col-sm-8">
							</colgroup>
							<tbody>
							<tr>
								<td>Nama Materi</td>
								<td id="nama-materi-detail">Otto</td>
							</tr>
							<tr>
								<td>Mata Pelajaran</td>
								<td id="nama-mapel-detail">Otto</td>
							</tr>
							<tr>
								<td>Kelas</td>
								<td id="nama-kelas-detail">Otto</td>
							</tr>
							<tr>
								<td>Bab</td>
								<td id="nama-bab-detail">Otto</td>
							</tr>
							<tr>
								<td>Deskripsi</td>
								<td id="deskripsi-materi-detail">Thornton</td>
							</tr>
							</tr>
							<tr>
								<td>Durasi</td>
								<td id="durasi-materi-detail">00.00</td>
							</tr>
							<tr>
								<td>Tipe</td>
								<td id="tipe-materi-detail">Thornton</td>
							</tr>
							<tr>
								<td rowspan = 3>Link Video</td>
								<td id="video-materi-detail-container">https://youtu.be/<span class="video-materi-detail"></span></td>
							</tr>
							<tr>
								<td id="video-materi-detail-container">https://youtube.com/embed/<span class="video-materi-detail d-none"></span></td>
							</tr>
							</tbody>
						</table>
					</div>

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

						<div id="isi-materi">

						</div>

						<canvas id="pdf-container">

						</canvas>

						<div class="row mb-3 mt-3" >
							<div class="col-12 my-2">
								<h4 class="text-center" style="color: #000" id="total-halaman">
									<span id="page_num"></span> / <span id="page_count"></span>
								</h4>
							</div>
							<div class="col-12" id="kuis-navigasi">
								<a class="btn btn-ka-blue" id="prev">
									<i class="fa fa-chevron-left"></i>
								</a>
								<a href="javascript:void(0);" class="btn btn-nav btn-ka-blue"
								   id="next">
									<i class="fa fa-chevron-right"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- end row -->
		</div>
	</div>
</div>
