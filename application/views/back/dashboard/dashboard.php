<div class="content-page">
	<div class="content">
		<div class="container">
			<!-- start row -->

			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
						<h4 class="page-title"><?= $title ?></h4>
						<ol class="breadcrumb p-0 m-0">
							<li class="active">
								<?= $title ?>
							</li>
						</ol>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<!-- end row -->
			<?php if ($this->session->backData["level_user"] == "administrasi") { ?>
				<!-- start row -->
				<div class="row">

					<div class="col-lg-4 col-md-6">
						<div class="card-box widget-box-two widget-two-success">
							<i class="mdi mdi-account-convert widget-two-icon"></i>
							<div class="wigdet-two-content text-white">
								<p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">
									Jumlah Siswa
								</p>
								<h2 class="text-white">
									<span data-plugin="counterup">
										<?= $siswa["total"] ?>
									</span>

								</h2>
								<p class="m-0">
									<b> - </b>
								</p>
							</div>
						</div>
					</div><!-- end col -->

					<div class="col-lg-4 col-md-6">
						<div class="card-box widget-box-two widget-two-warning">
							<i class="mdi mdi-layers widget-two-icon"></i>
							<div class="wigdet-two-content text-white">
								<p class="m-0 text-uppercase font-600 font-secondary text-overflow"
								   title="User This Month">
									Jumlah Kelas
								</p>
								<h2 class="text-white">
									<span data-plugin="counterup">
										<?= $kelas["total"] ?>
									</span>

								</h2>
								<p class="m-0">
									<b> - </b>
								</p>
							</div>
						</div>
					</div><!-- end col -->

					<div class="col-lg-4 col-md-6">
						<div class="card-box widget-box-two widget-two-info">
							<i class="mdi mdi-book-open-page-variant widget-two-icon"></i>
							<div class="wigdet-two-content text-white">
								<p class="m-0 text-uppercase font-600 font-secondary text-overflow"
								   title="Request Per Minute">
									Jumlah Mata Pelajaran
								</p>
								<h2 class="text-white">
									<span data-plugin="counterup">
										<?= $mapel["total"] ?>
									</span>

								</h2>
								<p class=" m-0">
									<b> - </b>
								</p>
							</div>
						</div>
					</div><!-- end col -->

				</div>
				<!-- end row -->

				<div class="row">
					<div class="col-md-12">
						<div class="card-box">
							<h4 class="m-t-0 m-b-20 header-title"><b>Transaksi Yang Belum Di Konfirmasi</b></h4>

							<div class="inbox-widget slimscroll-alt mx-box">


								<?php
								if ($transaksi["total"] > 0) {
									foreach ($transaksi["data"] as $keyTransaksi => $valueTransaksi) {
										if ($valueTransaksi["status"] == 1) {
											$jam = strtotime($valueTransaksi["tanggal_bayar"]);

											$jamBaru = getDateTimeDifferenceString($valueTransaksi["tanggal_bayar"]);

											?>
											<a href="<?= base_url("back/transaksi/detail/" . sprintf("%08d", $valueTransaksi["id_transaksi"])) ?>">
												<div class="inbox-item">
													<div class="inbox-item-img">
														<img
																src="<?= base_url() ?>/upload/profile-picture/<?= $valueTransaksi["gambar_user"] ?>"
																class="img-circle" alt=""></div>
													<p class="inbox-item-author"><?= $valueTransaksi["nama_user"] ?></p>
													<p class="inbox-item-text">Membayar Transaksi
														#<?= sprintf("%08d", $valueTransaksi["id_transaksi"]) ?>
														sebesar <b><?= rupiah($valueTransaksi["jumlah_bayar"]) ?></b>
														- </p>
													<p class="inbox-item-date"><?= $jamBaru ?></p>
												</div>
											</a>
											<?php


										}
									}
								}
								?>


							</div>
						</div>
					</div>
				</div>
				<!-- end row-->
			<?php } elseif ($this->session->backData["level_user"] == "instruktur") { ?>
				<!-- start row -->
				<div class="row">

					<div class="col-lg-4 col-md-6">
						<div class="card-box widget-box-two widget-two-primary">
							<i class="mdi mdi-layers widget-two-icon"></i>
							<div class="wigdet-two-content text-white">
								<p class="m-0 text-uppercase font-600 font-secondary text-overflow"
								   title="Jumlah Kelas">
									Jumlah Kelas
								</p>
								<h2 class="text-white">
									<span data-plugin="counterup">
										<?= $kelas["total"] ?>
									</span>
								</h2>
								<p class="m-0">
									<b> - </b>
								</p>
							</div>
						</div>
					</div><!-- end col -->

					<div class="col-lg-4 col-md-6">
						<div class="card-box widget-box-two widget-two-success">
							<i class="mdi mdi-book-open-page-variant widget-two-icon"></i>
							<div class="wigdet-two-content text-white">
								<p class="m-0 text-uppercase font-600 font-secondary text-overflow"
								   title="Jumlah Mata Pelajaran">
									Jumlah Mata Pelajaran
								</p>
								<h2 class="text-white">
									<span data-plugin="counterup">
										<?= $mapel["total"] ?>
									</span>
								</h2>
								<p class="m-0">
									<b> - </b>
								</p>
							</div>
						</div>
					</div><!-- end col -->

					<div class="col-lg-4 col-md-6">
						<div class="card-box widget-box-two widget-two-warning">
							<i class="mdi mdi-account widget-two-icon"></i>
							<div class="wigdet-two-content text-white">
								<p class="m-0 text-uppercase font-600 font-secondary text-overflow"
								   title="Jumlah Siswa">
									Jumlah Siswa
								</p>
								<h2 class="text-white">
									<span data-plugin="counterup">
										<?= $siswa["total"] ?>
									</span>
								</h2>
								<p class="m-0">
									<b> - </b>
								</p>
							</div>
						</div>
					</div><!-- end col -->


				</div>
				<!-- end row -->

				<div class="row">
					<div class="col-md-12">
						<div class="card-box">
							<h4 class="m-t-0 m-b-20 header-title"><b>Siswa Belum Di Nilai</b></h4>

							<div class="inbox-widget slimscroll-alt mx-box">


								<?php
								if ($praktek["total"] > 0) {
									foreach ($praktek["data"] as $keyPraktek => $valuePraktek) {

										$jam = strtotime($valuePraktek["waktu_upload"]);

										$jamBaru = getDateTimeDifferenceString($valuePraktek["waktu_upload"]);

										?>
										<a href="<?= base_url("back/progress-siswa/{$valuePraktek["meta_link_mapel"]}/{$valuePraktek["id_user"]}") ?>">
											<div class="inbox-item">
												<div class="inbox-item-img">
													<img
															src="<?= base_url() ?>/upload/profile-picture/<?= $valuePraktek["gambar_user"] ?>"
															class="img-circle" alt=""></div>
												<p class="inbox-item-author"><?= $valuePraktek["nama_user"] ?></p>
												<p class="inbox-item-text">Upload <?= $valuePraktek["jumlah_upload"] ?>
													file
													Untuk Materi <?= $valuePraktek["nama_materi"] ?>
													- <?= $valuePraktek["nama_mapel"] ?></p>
												<p class="inbox-item-date"><?= $jamBaru ?></p>
											</div>
										</a>
										<?php


									}
								}
								?>


							</div>
						</div>
					</div>
				</div>
				<!-- end row-->
			<?php } ?>


		</div>
	</div>
</div>

<!-- container -->
