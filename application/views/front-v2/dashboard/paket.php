<!--PAKET PILIH-->
<section id="paket-pilih" class="bg-warning">
	<div class="container">
		<div class="row">
			<div class="col-12 text-center text-md-left">
				<span>Pilih Paket Kelas</span>
				<a class="btn btn-rounded btn-danger mx-2 px-5" href="<?= base_url("paket") ?>">Lihat Semua</a>
			</div>
		</div>
	</div>
</section>

<!--PAKET-->
<section id="paket" class="bg-ka-grey">
	<div class="container">
		<div class="row">
			<?php
			if ($dataPaket["total"] > 0) {
				foreach ($dataPaket["data"] as $keyPaket => $valuePaket) {
					?>
					<div class="col-lg-4 col-md-12 mb-3 mb-lg-0 align-items-stretch">
						<div class="card bg-overlay-2 lazy h-100 align-items-stretch"
							 data-src="<?= base_url("upload/baner-paket/{$valuePaket["banner_paket"]}") ?>">
							<div class="card-body ">
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
								<p class="card-text mb-3">
									<!-- Kupas tuntas cara membuat digital manipulation, desain layout, corporate identity,
									illustration, dan membuat video explainer menggunakan motion graphic -->
									<?php
									echo $valuePaket['deskripsi']
									?>
								</p>
							</div>

							<div class="card-footer mt-auto px-0 pb-0">
								<button class="btn btn-info w-100 text-uppercase mt-auto" href="#">
									Coming Soon
								</button>
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
