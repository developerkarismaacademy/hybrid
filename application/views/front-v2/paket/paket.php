<!--IMG NAVIGASI-->
<section id="img-navigasi" class="bg-overlay-2"
		 style="background-image: url(<?= base_url() ?>assets/front/v2/img/bg-paket.jpg);">
	<div class="container text-white">
		<div class="row navigate-text py-0">
			<div class="col-12 py-0 mx-0 mx-md-3" style="z-index:2;">
				<a href="<?= base_url() ?>">
					<i class="fa fa-arrow-left text-warning"></i> Kembali
				</a>
			</div>
		</div>
		<div class="row">
			<div class="col-12 mx-0 mx-md-3">
				<h2>Mahir Desain Grafis & Motion Grafis (4 Kelas)</h2>
				<span class="text-warning">Paket Profesional</span>
			</div>
		</div>
	</div>
</section>

<section id="paket-deskripsi" class="bg-ka-grey">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-lg-10">
				<div class="card">
					<div class="card-body p-md-3">
						<div class="row align-items-center mb-3">
							<div class="col-12 col-lg-3">
								<h4>
									<b>
										Deskripsi
										<span class="text-warning d-lg-block">Paket</span>
									</b>
								</h4>
							</div>
							<div class="col">
								<?= "Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui molestiae laboriosam, reiciendis rerum similique culpa ratione unde, cupiditate, voluptas blanditiis in eius eligendi repellat eveniet? Deserunt quos ab facilis enim tempora blanditiis? Dolor, maxime veritatis. Excepturi rem repellendus enim. Deserunt, iure similique! Nihil sequi officiis explicabo! Iusto ab officia soluta molestias sunt! Mollitia velit aliquid culpa consequatur eligendi ad nulla nostrum exercitationem consequuntur iure quis, explicabo corrupti ea ab possimus non commodi hic aperiam atque reprehenderit. Quisquam recusandae, officia reprehenderit voluptatum assumenda adipisci nam similique, quo eos voluptas officiis placeat quae aut quos ipsa deleniti eaque ea. Dolore, praesentium quia?" ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="bg-ka-dark">
	<div class="container">
		<div class="row p-0">
			<div class="col h4 text-center">
				Kelas - Kelas Yang Akan Diikuti dalam Pelatihan Ini
			</div>
		</div>
		<div class="row justify-content-center">
			<?php
			for ($i = 0; $i < 5; $i++) {
				?>
				<div class="col-12 col-lg-10">
					<div class="card my-4">
						<div class="card-body p-3">
							<div class="container-fluid">
								<div class="row">
									<div class="col-12 col-lg-3 img-bg-fill"
										 style="background-image:url('<?= base_url() ?>assets/front/v2/img/bg-paket.jpg');">
									</div>
									<div class="col-12 col-lg mt-3 mt-lg-0">
										<div class="text-truncate mb-3"
											 title="Menjadi Drafter Arsitektur & Sipil Handal dengan AutoCAD">
											<b>Menjadi Drafter Arsitektur & Sipil Handal dengan
												AutoCAD</b>
										</div>
										<small>
											<div class="row mb-5">
												<div class="col-12">
													<div class="card-deskripsi line-limit-3">
														AutoCAD merupakan Lorem ipsum dolor sit amet, consectetur
														adipisicing elit. In, tenetur laborum quidem distinctio magnam
														aspernatur dolores illum consequuntur dignissimos tempore
														repellendus sed quod laudantium modi eaque voluptate asperiores
														architecto similique.
													</div>
												</div>
											</div>
											<div class="row align-items-center">
												<div class="col-5">
													by Zahidan Aan<br><small>Owner Gaskuen</small>
												</div>
												<div class="col-2 p-0">
												<span class="score">
													<div class="score-wrap">
														<span class="stars-active"
															  style="width:<?= (4.4 + 0.05) / 5 * 100 ?>%">
															<i class="fa fa-star" aria-hidden="true"></i>
															<i class="fa fa-star" aria-hidden="true"></i>
															<i class="fa fa-star" aria-hidden="true"></i>
															<i class="fa fa-star" aria-hidden="true"></i>
															<i class="fa fa-star" aria-hidden="true"></i>
														</span>
														<span class="stars-inactive">
															<i class="fa fa-star-o" aria-hidden="true"></i>
															<i class="fa fa-star-o" aria-hidden="true"></i>
															<i class="fa fa-star-o" aria-hidden="true"></i>
															<i class="fa fa-star-o" aria-hidden="true"></i>
															<i class="fa fa-star-o" aria-hidden="true"></i>
														</span>
													</div>
												</span>
												</div>
												<div class="col">
													<?= "4.4" ?> (<?= "4444" ?> Rating)
												</div>
											</div>
										</small>
									</div>
									<div class="col-12 px-0 mt-lg-0 mt-3 offset-lg-1 col-lg-2 align-self-center">
										<div class="row">
											<div class="col-4 col-lg-12">
												<div class="mb-3 text-right text-lg-center">
													<div class="harga-asli small">
													<span class="badge badge-pill badge-danger">
														10%
													</span>
														<span class="text-line-through">
														Rp 220.000
													</span>
													</div>
													<div class="harga-diskon">
														Rp 200.000
													</div>
												</div>
											</div>
											<div class="col col-lg-12">
												<a class="btn btn-success btn-block w-100"
												   href="<?= base_url("kelas") ?>">
													LIHAT KELAS
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>

		</div>
	</div>

</section>

<section id="paket" class="bg-ka-grey">
	<div class="container my-5">
		<div class="row">
			<h4><b>Rekomendasi</b> Paket Kelas Lainnya</h4>
		</div>
		<div class="row">
			<?php
			if ($dataPaket["total"] > 0) {
				foreach ($dataPaket["data"] as $keyPaket => $valuePaket) {
					?>
					<div class="col-lg-4 col-md-12 mb-3 mb-lg-0  align-items-stretch">
						<div class="card bg-overlay-2 h-100">
							<div class="card-body d-flex flex-column">
								<div class="card-title">
									<div class="title-main">
										<?php
										$nama_paket = explode(" ", $valuePaket['nama_paket']);
										foreach ($nama_paket as $k => $v) {
											echo "<span class=";
											if ($k > 0 == count($nama_paket)) {
												echo "text-" . $valuePaket["color_paket"];
											}
											echo ">" . $v;
											echo "</span> ";
											//var_dump($v);

										}
										?>
										<!-- Paket
										<p class="text-warning">Professional</p> -->
									</div>
									<div class="title-sub">
										<!-- Mahir Desain Grafis dan Motion Graphic
										<br>
										( 4 Kelas ) -->
										<?php
										echo $valuePaket['deskripsi_singkat']
										?>
									</div>
								</div>
								<p class="card-text">
									<!-- Kupas tuntas cara membuat digital manipulation, desain layout, corporate identity,
									illustration, dan membuat video explainer menggunakan motion graphic -->
									<?php
									echo $valuePaket['deskripsi']
									?>
								</p>
								<div class="mb-3"></div>
								<div class="btn btn-danger w-100 text-uppercase mt-auto">
									Beli Paket Kelas Sekarang
								</div>
							</div>
						</div>
					</div>
					<?php
				}
			}
			?>
		</div>
	</div>

</section>
