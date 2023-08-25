<div class="content-page">
	<div class="content">
		<div class="container">

			<!-- start row -->

			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
						<h4 class="page-title">
							<a data-toggle="tooltip" data-placement="top" title=""
							   data-original-title="Daftar Siswa <?= $mapel["nama_mapel"] ?>"
							   href="<?= base_url('back/siswa-ampu/' . $mapel["meta_link_mapel"]) ?>">
								<i class="fa fa-arrow-left"></i>
							</a>
							<span
									title="<?= $title ?>"><?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?>
							</span>
						</h4>
						<ol class="breadcrumb p-0 m-0">
							<li>
								<a title="Daftar Mata Pelajaran Yang Di Ampu"
								   href="<<?= base_url('back/siswa-ampu/' . $mapel["meta_link_mapel"]) ?>">
									<?= (strlen("Daftar Siswa " . $mapel["nama_mapel"]) > 18 ? substr("Daftar Siswa " . $mapel["nama_mapel"], 0, 18) . "..." : "Daftar Siswa " . $mapel["nama_mapel"]) ?>
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
			<input type="hidden" id="idMapel" value="<?= $mapel['id_mapel'] ?>">
			<input type="hidden" id="idSiswa" value="<?= $siswa['id_user'] ?>">
			<input type="hidden" id="metaMapel" value="<?= $mapel['meta_link_mapel'] ?>">

			<div class="alert alert-icon alert-danger alert-dismissible fade in error-alert hidden"
				 role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<div class="error-alert-container">

				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<div class="card-box text-center">
						<img height="250"
							 src="<?= base_url() ?>/upload/profile-picture/<?= $siswa["gambar_user"] ?>"/>
					</div>
				</div>
				<div class="col-sm-8">
					<div class="card-box">
						<h4 class="m-t-0 header-title"><b>Data Siswa</b></h4>
						<table class="table table-bordered m-0">
							<colgroup>
								<col class="col-sm-4">
								<col class="col-sm-8">
							</colgroup>
							<tbody>
							<tr>
								<td>Nama</td>
								<td id="nama-user"><?= $siswa["nama_user"] ?></td>
							</tr>
							<tr>
								<td>Username</td>
								<td id="username-user"><?= $siswa["username"] ?></td>
							</tr>
							<tr>
								<td>Email</td>
								<td id="email-user"><?= $siswa["email_user"] ?></td>
							</tr>
							<tr>
								<td>No. TELP</td>
								<td id="no-telp-user"><?= $siswa["telepon_user"] ?></td>
							</tr>
							<tr>
								<td>Alamat</td>
								<td id="alamat-user"><?= $siswa["alamat_user"] ?></td>
							</tr>
							<tr>
								<td>TTL</td>
								<td id="ttl-user">
									<?= $siswa["tempat_lahir"] ?>, <?= formatTanggal2($siswa["tanggal_lahir"]) ?>
								</td>
							</tr>
							<tr>
								<td>Jenis Kelamin</td>
								<td id="ttl-user"><?= $siswa["jk_user"] ?></td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>

			</div>
			<!-- start row -->
			<div class="row">

				<div class="col-md-12 col-sm-12">


					<?php if ($kompetensi["total"] > 0) {
						foreach ($kompetensi["data"] as $keyKompetensi => $valueKompetensi) {
							?>
							<div class="card-box" id="panel-bab">
								<div class="loading-form">
									<i class="fa fa-spin fa-circle-o-notch fa-4x"></i>
									<br>
									<br>
									Loading Data
								</div>
								<h3> <?= $valueKompetensi["kompetensi"] ?></h3>
								<div class="table-responsive">
									<table class="table m-0 table-colored-bordered table-bordered-info table-bordered">

										<?php
										if ($valueKompetensi["indikatorInduk"]["total"] > 0) {
											foreach ($valueKompetensi["indikatorInduk"]["data"] as $keyIndikatorInduk => $valueIndikatorInduk) {
												?>
												<thead>
												<tr>
													<th colspan="2" class="text-center"
														style="font-size: 20px;"><?= $valueIndikatorInduk["indikator_induk"] ?></th>
												</tr>
												</thead>
												<tbody>
												<?php
												if ($valueIndikatorInduk["indikator"]["total"] > 0) {
													foreach ($valueIndikatorInduk["indikator"]["data"] as $keyIndikator => $valueIndikator) {
														?>
														<tr>
															<td style="width: 75%;font-size: 18px;"><?= $valueIndikator["indikator"] ?></td>
															<td style="width: 25%;">
																<div class="form-group">
																	<div class="col-sm-12">
																		<input type="text" id="example-input-large"
																			   onchange="simpanNilai(<?= $valueIndikator["id_indikator"] ?>,this.value)"
																			   name="example-input-large"

																			   value="<?= isset($valueIndikator["nilai"]) ? $valueIndikator["nilai"] : "" ?>"
																			   class="form-control input-lg text-center"
																			   placeholder=" 1 - 10">
																	</div>
																</div>
															</td>
														</tr>
														<?php
													}
												}
												?>
												</tbody>
												<?php
											}
										}
										?>

									</table>
								</div>
							</div>
							<?php
						}
					}
					?>

				</div>


			</div>
			<!-- end row -->
		</div>
	</div>
</div>
<!-- container -->
