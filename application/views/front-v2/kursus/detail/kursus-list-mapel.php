<section id="kursus-list">


	<div class="container-fluid" style=" background: #300741; ">

		<?php
		if ($listhasil['total'] > 0) {
			?>
			<div class="container">
				<div class="jumbotron jumbotron-fluid jresult px-5 py-5 col-12 " style="margin-top: -200px;">
					<div class="container">
						<h3 class="display-5 mb-4 text-center"><b>Hasil dari Belajar<br>'<?= $mapel["nama_mapel"] ?>
								'</b></h3>
						<div class="list-result row display-7 h6"
							 style="list-style-image:  url('<?= base_url() ?>assets/front/images/Group 1817.png') ">
							<?php
							foreach ($listhasil['data'] as $listitem) {
								?>
								<li class="col-12 col-md-6"><?= $listitem['deskripsi_mapel_listhasil'] ?></li>
								<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		?>

		<div class="row" style="color:white">
			<div class=" col-12 h4 mb-5 mt-5 text-center">
				<b>Lihat Video Previewnya</b>
			</div>

			<div class="container col-6 col-lg-6 mb-3" style="margin-left: 34%; ">
				<div class="kursus-banner-vid mb-5" data-toggle="modal" data-target="#vidModal"
					 style="background-image:url('<?= base_url() ?>upload/banner_mapel/<?= $mapel["banner_mapel"] ?>')">
					<div class="banner-overlay">
						<span class="fa fa-circle-o fa-stack-2x fa-marg"></span>
						<span class="fa fa-play fa-stack-2x fa-marg"></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">

			<div class="col-12 mt-5 mb-5">
				<div class="row p-0">
					<div class="col h4 p-0 mb-5 text-center">
						<b>Kurikulum Materi</b>
					</div>
				</div>
				<div class="row" id="parent-materi-kelas-list">
					<div class="col">
						<div class="row heading-materi-kelas-list pt-3 pb-3 ">
							<div class="col-12 col-md-6">
								Judul Materi
							</div>
							<div class="col-0 col-md-3 text-left d-none d-md-block">
								Isi Materi
							</div>
							<div class="col-0 col-md-3 text-left d-none d-md-block">
								Durasi
							</div>
						</div>

						<?php

						if ($bab["total"] > 0) {
							$i = 0;
							foreach ($bab["data"] as $keyBab => $valueBab) {
								?>
								<div class="row <?= ($i == 0) ? '' : 'collapsed' ?>" data-toggle="collapse"
									 data-target="#collapse-<?= $i ?>"
									 aria-expanded="<?= ($i == 0) ? 'true' : 'false' ?>"
									 aria-controls="collapse-<?= $i ?>">
									<div class="col col-md-6 pt-1 pb-1  text-truncate">
										<i class="fa fa-fw <?= ($i == 0) ? 'fa-chevron-down' : 'fa-chevron-right' ?> collapse-control mr-3"
										   aria-controls="collapse-<?= $i ?>"></i>
										<?= $valueBab["nama_bab"] ?>
									</div>
									<div class="col-3  d-none d-md-block text-left">
										<?= $valueBab["materi"]["total"] ?> Materi
									</div>
									<div class="col-3 text-left">
										<?php

										if ($valueBab["jml_durasi"] > 0) {

											echo '<img width="20" class="d-inline" src="' . base_url("assets/back/images/icons/clock.svg") . '" alt=""> ' . ((int)$valueBab["jml_durasi"]) . " menit";
										}
										?>
									</div>
								</div>

								<div id="collapse-<?= $i ?>" class="row p-0 collapse <?= ($i == 0) ? 'show' : '' ?>"
									 aria-labelledby="heading-<?= $i ?>" data-parent="#parent-materi-kelas-list"
									 href="#">
									<div class="col">
										<?php
										if ($valueBab["materi"]["total"] > 0) {
											foreach ($valueBab["materi"]["data"] as $keyMateri => $valueMateri) {

												if (isset($_SESSION["idMapelBeli"])) {
													if (in_array($mapel["id_mapel"], $_SESSION["idMapelBeli"]) == false) {
														$link = "javascript:void();";
													} else {
														$link = base_url("belajar/{$mapel["meta_link_mapel"]}");
													}
												} else {
													$link = "javascript:void();";
												}


												?>
												<a href="<?= $link ?>" class="subchild-materi-kelas-list">
													<div class="row py-3" title="<?= $valueMateri["nama_materi"] ?>">
														<div class="col-12 col-md-6 text-truncate">
															<i class="fa fa-fw mr-3"></i>
															<?= ($keyMateri + 1) . ". " . $valueMateri["nama_materi"] ?>

														</div>
														<div class="col-3 d-none d-md-block text-left">
															<img width="20" class="d-inline"
																 src="<?= base_url(iconMateriColor[$valueMateri["tipe"]]) ?>"
																 alt="">
															<?= jenisMateri[$valueMateri["tipe"]] ?>
														</div>
														<div class="col-3  d-none d-md-block text-left">
															<?php if (in_array($valueMateri["tipe"], ["pilihan", "teks", "pdf"])) {
																echo '<img width="20" class="d-inline" src="' . base_url("assets/back/images/icons/survey.svg") . '"
																 alt="">  ' . ((int)$valueMateri["jml_soal"]) . " " . satuanMateri[$valueMateri["tipe"]];
															} else if (in_array($valueMateri["tipe"], ["praktek"])) {
																echo '<img width="20" class="d-inline" src="' . base_url("assets/back/images/icons/survey.svg") . '"
																 alt=""> ' . ((int)$valueMateri["durasi"]) . " " . satuanMateri[$valueMateri["tipe"]];
															} else {
																echo '<img width="20" class="d-inline" src="' . base_url("assets/back/images/icons/clock.svg") . '"
																 alt=""> ' . ((int)$valueMateri["durasi"]) . " " . satuanMateri[$valueMateri["tipe"]];
															} ?>
														</div>
													</div>
												</a>


												<?php
											}
										} ?>
									</div>
								</div>
								<?php
								$i++;
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
<!--	<div class="container-fluid  bg-ka-darker">-->
<!--		<div class="container">-->
<!--			<div id="jumbotron jumbotron-fluid justify-content-center">-->
<!--				<center>-->
<!--					<h1 class="display-5 mt-5 mb-5"><b>Preview Materi</b></h1>-->
<!--				</center>-->
<!--			</div>-->
<!--			<div class="row justify-content-center">-->
<!--				--><?php
//				if ($previewMateri['total'] > 0) {
//					foreach ($previewMateri['data'] as $item) {
//						?>
<!--						<div class="col-6 col-md-3">-->
<!--							<div class="kursus-banner mb-5"-->
<!--  							</div> -->
<!-- 						</div> -->
<!--                    --><?php
//					}
//					?>
<!--					--><?php
//				} else {
//					for ($i = 1; $i <= 8; $i++) {
//						?>
<!--						<div class="col-6 col-md-3">-->
<!--							<div class="kursus-banner mb-5"-->
<!--  -->
<!-- 							</div> -->
<!-- 						</div> -->
<!-- 						 --><?php
//					}
//				}
//				?>
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->

<!--	<div class="container-fluid  bg-ka-dark">-->
<!---->
<!--		<div class="container ">-->
<!---->
<!--			<div id="jumbotron jumbotron-fluid justify-content-center">-->
<!--				<center>-->
<!--					<h1 class="display-5 mt-5 mb-5"><b>Apa yang bisa dibuat setelahnya</b></h1>-->
<!--				</center>-->
<!--			</div>-->
<!--			<div class="row justify-content-center">-->
<!--				--><?php
//				if ($portofolioMateri['total'] > 0) {
//					foreach ($portofolioMateri['data'] as $item) {
//						?>
<!---->
<!--						<div class="col-6 col-md-3">-->
<!--							<div class="kursus-banner mb-5"-->
<!-- 							</div>-->
<!--						</div>-->
<!--						--><?php
//					}
//				} else {
//					for ($i = 1; $i <= 4; $i++) {
//						?>
<!--						<div class="col-6 col-md-3">-->
<!--							<div class="kursus-banner mb-5"-->
<!-- 							</div>-->
<!--						</div>-->
<!--						--><?php
//					}
//				}
//				?>
<!--			</div>-->
<!---->
<!--		</div>-->
<!---->
<!--	</div>-->

	<div class="container-fluid bgf">
		<div class="container py-5 mt-5">
			<h2 class="text-center"><b>Kenapa Harus di Kursus Online?</b></h2>
			<div class="row my-3">
				<div class="jumbotron jumbotron-fluid jumbotron-reason py-0 py-md-3 mb-0 mb-md-5">
					<div class="row align-items-center">
						<div class="col-12 col-md-8 px-5 order-2 order-md-1">
							<div class="mb-4">
								<h2 class="text-center text-md-left"><b>Kelas Live Mentoring</b></h2>
							</div>
							<div class="pr-5 px-2">
								<h6 class="text-justify"> Nantinya anda akan di bimbing,
									di mentorin, dan menrima pembelajaran secara live melalui aplikasi
									zoom dengan fleksibel dan dapat di akses dimana saja</h6>
							</div>
						</div>
						<div class="col-12 col-md-4 img-box-jumbotron2 text-center order-1 order-md-2">
							<img class="img-fluid" alt="Why 1"
								 src="<?= base_url() ?>assets/front/images/detailclass/why-1.gif"/>
						</div>
					</div>
				</div>

				<div class="jumbotron jumbotron-fluid jumbotron-reason py-0 py-md-3 mb-0 mb-md-5">
					<div class="row align-items-center">
						<div class="col-12 col-md-4  img-box-jumbotron2 text-center">
							<img class="img-fluid" alt="Why 2"
								 src="<?= base_url() ?>assets/front/images/detailclass/why-2.gif"/>

						</div>
						<div class="col-12 col-md-8 px-5">
							<div class="mb-4">
								<h2 class="text-center text-md-left"><b>Kelas Video Based Learning</b></h2>
							</div>
							<div class="pr-5 px-2">
								<h6 class="text-justify"> Anda akan menerima ecourse tambahan
									seperti PDF, free video recording pembelajaran,
									serta akses materi selamanya dan sertifikat yang berlisensi</h6>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-12 col-lg mb-3 mb-lg-0">
						<div id="carouselScreenshot" class="carousel slide carousel-fade px-0" data-ride="carousel">
							<div class="carousel-inner">
								<div class="device-wrapper">
									<div class="device" data-device="Macbook" data-orientation="portrait"
										 data-color="black">
										<?php
										$jumlahScreenshot = 4;
										for ($i = 1; $i <= $jumlahScreenshot; $i++):
											?>
											<div class="screen carousel-item <?= $i == 1 ? 'active' : '' ?>"
												 style="background-image:url('<?= base_url() ?>assets/front/images/screenshot/screenshot-<?= $i ?>.png'); background-position:center;">
											</div>
										<?php
										endfor;
										?>
									</div>
								</div>
							</div>
						</div>
						<!-- <img class="img-fluid" src="<?= base_url() ?>assets/front/images/Group 1816.png"> -->
					</div>
					<div class="col-12 col-lg">
						<div class="textweb2 px-3 mb-4" style="margin-top:  1%;">
							<h2 class="text-center text-lg-left"><b>Platform Pintar Kursus
									Online International</b></h2>
						</div>
						<div class="pr-5">
							<h3 class=" " style="font-size: 1rem;">
								<ul class="ml-4"
									style="list-style-image: url('<?= base_url() ?>assets/front/images/Polygon1.png') ; padding-left : 5%;">
									<p class="text-md-left mt-3">
									<li>Free akses online semua materi dan tugas</li>
									</p>
									<p class="text-md-left mt-2">
									<li>7 modul khusus dan mentoring.</li>
									</p>
									<p class="text-md-left mt-2">
									<li>Group yang berisi peserta belajar beserta praktisi.</li>
									</p>
									<p class="text-md-left mt-2">
									<li>Dapat di akses dengan device apapun laptop atau handphone.</li>
									</p>
									<p class="text-md-left mt-2">
									<li>Pemutaran video dengan super cepat.</li>
									</p>
									<p class="text-md-left mt-2">
									<li>Mendapatkan sertifikat yang sudah berlisensi.</li>
									</p>
								</ul>

							</h3>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid" style="background-color: #300741;  ">
		<div class="container position-relative" style="color: white;">
			<div class=" row mb-5">
				<div class="col-12 col-lg-6 px-5 mt-5 mb-5">
					<p>Kursus & Workshop</p>
					<div class=" py-1 mb-4" style="color:#FFA737;">
						<h2>"<?= $mapel["nama_mapel"] ?>"</h2>
					</div>
					<div class="pr-5">
						<?php
						if ($mapel['materi_mapel'] != "") {
							$materi = " dan <b>dapatkan pengetahuan dan pengalaman nyata dalam: </b>" . $mapel['materi_mapel'];
						} else {
							$materi = " untuk mendapatkan <b>penawaran terbaik.</b>";
						}
						?>
						<p>
							Mampu membantu mengembangkan karir dan bisnis anda.<br>
							Daftar sekarang<?= $materi ?>
						</p>
					</div>
				</div>
				<div class="col-12 col-lg-6 my-5">
					<div class="sertifikat"
						 style="background-image: url('<?= base_url("upload/gambar-sertifikat/{$mapel["gambar_sertifikat"]}'") ?>)">
					</div>
				</div>
			</div>
		</div>
	</div>

<!--	<div class="container bg-white">-->
<!---->
<!--		<div class="container ">-->
<!---->
<!--			<div id="jumbotron jumbotron-fluid justify-content-center">-->
<!--				<center>-->
<!--					<h1 class="display-5 mt-5 mb-5"><b>Siapa yang cocok ikut kelas ini?</b></h1>-->
<!--				</center>-->
<!--			</div>-->
<!--			--><?php
//			if ($targetMateri['total'] <= 0) {
//				$targetMateri['data'] = [
//						"entrepreneur-lama" => [
//								"title_target" => "Entrepreneur Lama",
//								"list"         => [
//										"Membangun Brand Anda di Media Sosial, sehingga Anda bisa keluar dari perang
//							harga",
//										"Membuat Brand Anda lebih dikenal, sehingga Produk / Jasa Anda lebih mudah dijual
//							oleh Tim Sales Anda.",
//										"Membuat Brand Anda lebih familiar di mata calon konsumen, sehingga dapat
//							menurunkan Budget Marketing.",
//										"Membuat Anda mengetahui, apa yang harus Anda lakukan & mendapatkan orang yang
//							tepat ketika ingin.",
//										"Hiring Tim Sosial Media In-House / Hiring Social Media Agency untuk Sosial Media
//							Anda.",
//								]
//						],
//
//						"entrepreneur-baru" => [
//								"title_target" => "Entrepreneur Baru",
//								"list"         => [
//										"Membangun Brand Anda di Media Sosial, sehingga Anda bisa keluar dari perang
//							harga",
//										"Membuat Brand Anda lebih dikenal, sehingga Produk / Jasa Anda lebih mudah dijual
//							oleh Tim Sales Anda.",
//										"Membuat Brand Anda lebih familiar di mata calon konsumen, sehingga dapat
//							menurunkan Budget Marketing.",
//										"Membuat Anda mengetahui, apa yang harus Anda lakukan & mendapatkan orang yang
//							tepat ketika ingin.",
//										"Hiring Tim Sosial Media In-House / Hiring Social Media Agency untuk Sosial Media
//							Anda.",
//								]
//						],
//						"profesional"       => [
//								"title_target" => "Profesional",
//								"list"         => [
//										"Membangun Brand Anda di Media Sosial, sehingga Anda bisa keluar dari perang
//							harga",
//										"Membuat Brand Anda lebih dikenal, sehingga Produk / Jasa Anda lebih mudah dijual
//							oleh Tim Sales Anda.",
//										"Membuat Brand Anda lebih familiar di mata calon konsumen, sehingga dapat
//							menurunkan Budget Marketing.",
//										"Membuat Anda mengetahui, apa yang harus Anda lakukan & mendapatkan orang yang
//							tepat ketika ingin.",
//										"Hiring Tim Sosial Media In-House / Hiring Social Media Agency untuk Sosial Media
//							Anda.",
//								]
//
//						],
//				];
//			}
//			?>
<!--			<div class="row">-->
<!--				--><?php
//				foreach ($targetMateri['data'] as $key => $item) { ?>
<!--					<div class="col-12 mb-3">-->
<!--						<div class="row justify-content-center align-items-center no-gutters">-->
<!--							<div class="col-12 col-md-4 mt-3  text-center">-->
<!--								<img-->
<!--										src="--><?//= base_url() ?><!--assets/front/images/target/--><?//= $key ?><!--.png"-->
<!--										class="img-fluid" alt="...">-->
<!--							</div>-->
<!--							<div class="col-12 col-md-5">-->
<!--								<h4 class="card-title mt-4"><b>--><?//= $item['title_target'] ?><!--</b></h4>-->
<!--								<p class="text-md-left ml-2 mt-4">Untuk --><?//= strtolower($item['title_target']) ?><!--, kursus-->
<!--									ini akan berguna untuk</p>-->
<!--								<ul class="ml-4" style="list-style-type:disc;">-->
<!--									--><?php
//									foreach ($item['list'] as $list) { ?>
<!--										<li class="mt-3">--><?//= $list ?><!--</li>-->
<!--										--><?php
//									}
//									?>
<!--								</ul>-->
<!--							</div>-->
<!--						</div>-->
<!--					</div>-->
<!--					--><?php
//				}
//				?>
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->

</section>









