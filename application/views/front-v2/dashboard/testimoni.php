<!--TESTIMONI-->
<section id="testimoni" class="bg-white">
	<div class="container">
		<div class="row">
			<div class="col-12 text-center mt-5">
				<h3 class="heading-main"><b>Apa Kata Mereka Tentang Kursus Online</b></h3>
				<p class="heading-sub">Dengarkan pengalaman mereka belajar online di Karisma Academy</p>
			</div>
		</div>
		<div class="row justify-content-center">
			<?php
			$limit = 3;
			foreach ($dataTestimoni as $kTesti => $vTesti) {
				if ($limit > 0) {
					?>
					<div class="col-lg-4 col-md-6 col-sm-12 d-flex align-items-stretch  mb-lg-0">
						<div class="card w-100 ">
							<div class="card-body ">
								<div class="card-text  d-flex flex-column " style="height:100%;">
									<!-- <div class="row">
										<div class="col">
											<div class="title-main">Kursus online
												<div class="text-<?= ($vTesti["color_kelas"] != null) ? $vTesti["color_kelas"] : "warning" ?>">
													<?php
									$kelas_testimoni = $vTesti["kelas_testimoni"];
									$kelas_array = explode(" ", $kelas_testimoni);
									foreach ($kelas_array as $kkelas => $vkelas) {
										echo $vkelas . " ";
										if ($kkelas == 0) {
											echo "<br class='d-none d-md-block'>";
										}
									}
									?>
												</div>
											</div>
										</div>
									</div> -->
									<div class="row ">
										<div class="col">
											<div class="title-main">
												<div class="kursus-banner-testi mx-auto mb-1 d-flex align-items-center"
													 data-toggle="modal" data-target="#vidModal"
													 style=" background-image:url('upload/banner_mapel/BapakAlpha.jpeg')">
													<div class="banner-overlay  mx-auto">
														<span class="fa-stack ">
															<span class="fa fa-circle fa-circle-testi fa-stack-2x"></span>
															<span class=" fa fa-play fa-play-testi fa-stack-1x"></span>
														</span>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col testimoni-isi">
											<?= $vTesti["isi_testimoni"] ?>
										</div>
									</div>
									<div class="row mt-auto">
										<div class="col">
											<div class="testimoni-user media align-items-center">
												<div class="media-body">
													<p class="user-nama mb-2 line-limit-1"><?= $vTesti["nama_testimoni"] ?></p>
													<p class="user-job  line-limit-1 small"><?= $vTesti["pekerjaan"] ?></p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
					$limit--;
				}
			}
			?>
		</div>
	</div>


	<!-- <section class="bg-white">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

		</head>

		<div class="container">
			<div class="row mb-5">
				<div class="col-sm-12 mb-5 ">
					<h2 class="my-5"><b>
							<center>Apa kata mereka</center>
						</b> </h2>
					<div id="myCarousel" class="carousel slide " data-ride="carousel">
						Carousel indicators
						<ol class="carousel-indicators">
						<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
						<li data-target="#myCarousel" data-slide-to="1"></li>
						<li data-target="#myCarousel" data-slide-to="2"></li>
					</ol>
						Wrapper for carousel items
						<div class="carousel-inner">
							<div class="item active">
								<div class="row d-flex justify-content-center">
									<?php
	foreach ($dataTestimoni as $kTesti => $vTesti) {
		?>

										<div class="col-md-6 col-lg-4 col-12">
											<div class="testimonial-wrapper mt-4">

												<div class="media">
													<div class="media-left d-flex mr-3">
														<img src="<?= $vTesti['gambar_testimoni'] ?>" alt="ft-tes" width="50px" height="50px" class="rounded-circle object-cover">
													</div>
													<div class="media-body">
														<div class="overvie">
															<div class="name-testimonial"><b><?= $vTesti["nama_testimoni"] ?></b></div>
															<div class="star-rating mt-3">
																<ul class="list-inline  d-flex justify-content-center">
																	<li class="list-inline-item"><i class="fa fa-star"></i></li>
																	<li class="list-inline-item"><i class="fa fa-star"></i></li>
																	<li class="list-inline-item"><i class="fa fa-star"></i></li>
																	<li class="list-inline-item"><i class="fa fa-star"></i></li>
																	<li class="list-inline-item"><i class="fa fa-star"></i></li>
																</ul>
															</div>
														</div>
													</div>
												</div>
												<div class="testimonial mt-4"><?= $vTesti["isi_testimoni"] ?>.</div>
											</div>
										</div>

									<?php
	} ?>


								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div> 
	</section> -->

	<div class="jumbotron jumbotron-fluid jumbotron-creation mb-0">
		<div class="container d-flex align-items-center h-100 " style="color: white;">
			<div class="row justify-content-center">
				<div class="col-12 col-lg-12">
					<h2 class="display-5"><b>Penasaran dengan karya <br>
							para member?</b></h2>
				</div>
				<div class="col-12 col-lg-12">

					<p class="lead px-3 mt-4">Yuk, main ke website Student Showcase kami, disana kamu bisa lihat
						karya-karya
						terpilih dari para member yang lolos seleksi setelah mengikuti kelasnya. Kedepannya jumlah karya
						akan selalu diupdate secara bertahap ya.</p>
				</div>
				<div class="col-10 col-md-5 col-lg-4">
					<a href="<?= base_url('portofolio') ?>"
					   class="btn btn-more-member btn-warning btn-rounded my-5 mb-sm-0">
						Karya Member <i class="fa fa-play"></i>
					</a>
				</div>
			</div>
		</div>
	</div>


	<!-- </section> -->
