<!--SISTEM-->

<section id="sistem">

	<div class="container-fluid bg-warning d-flex align-items-center">
		<div class="container">
			<div class="display-6 w-50 ">
				<b>Pilihan Paket Kelas</b>
				<span>
					<button class="btn btn-paket-kelas btn-danger rounded-pill w-25 ml-2"> Lihat Semua </button>
				</span>
			</div>
		</div>
	</div>
	<div class="container-fluid " style="background: #F6FBFF;">

		<div class="container">

			<div class="row ">

				<div class="col-1">
				</div>

				<div class="col-12 h4 text-md-left mt-5">
					<b>Lihat</b> semua kelas
				</div>
			</div>

			<!-- <div class='row d-flex justify-content-center '> -->
			<!-- <?php
			if ($dataMapel["total"] > 0) {
				$data["idClone"] = "2";
				foreach ($dataMapel["data"] as $keyMapel => $valueMapel) {
					?>
					<div class="col-lg-3 col-md-6 mb-4">
						<?php
					$data["keyMapel"] = $keyMapel;
					$data["valueMapel"] = $valueMapel;
					// $this->load->view("front-v2/layout/kelas", $data);
					?>
					</div>
			<?php
				}
			}
			?>
			</div> -->
			<div class="row d-flex justify-content-center ">

				<?php
				if ($dataMapelPrakerja["total"] > 0) {
					$data["idClone"] = "1";
					foreach ($dataMapelPrakerja["data"] as $keyMapel => $valueMapel) {
						$data["keyMapel"] = $keyMapel;
						$data["valueMapel"] = $valueMapel;
						?>
						<div class="col-9 col-md-4 col-lg-3 mt-4">
							<div class="card card-white-shadow ">
								<a href="">
									<img
											src="<?= base_url("upload/banner_mapel/{$valueMapel["banner_mapel"]}") ?>"
											class="card-img-top"
											alt="...">
								</a>
								<div class="card-body d-flex justify-content-center ">
									<div class="kelas-title font-weight-bold line-limit-3">
										<a href="<?= base_url("kursus/detail/{$valueMapel["meta_link_mapel"]}") ?>"
										   class="nama-mapel">
											<?= $valueMapel["nama_mapel"] ?>
										</a>
									</div>
								</div>
							</div>
						</div>
						<?php
					}
				}
				?>

			</div>


			<div class="row d-flex mt-5 pb-5 justify-content-center">
				<div class="col-10 col-lg-4 text-center">
					<a class="btn btn-more-member btn-outline-warning text-white"
					   href="<?= base_url("kelas") ?>#prakerja">Lihat
						Lebih
						Banyak </a>
				</div>
			</div>


		</div>
	</div>
	<!-- <div class="container-fluid">
		<div class="container">
			<div class="row mb-5 pb-5">
				<div class="col-12 col-lg-12 d-flex justify-content-center text-center mt-5 ">
				</div>
				<div class="col-12 col-lg-5 d-flex justify-content-end mb-3 pt-5">
					<img class="mx-auto mx-lg-0 img-fluid " style="width:80%; height:90%" src="<?= base_url('assets/front/v2/img/Illustrasi/dashboard-2.png') ?>">
				</div>
				<div class="col-12 col-lg-7 d-flex flex-column justify-content-center">
					<h3 class="heading-main mt-1">
					  <b>Sistem i-Karismax</b>  
	</h3>
	<div class="row ">
	  <p class="heading-sub"></p> 

		<div class="col-lg-12 col-12 col-md-12 pl-4 ">

			<p style="font-size: medium; line-height:1.6" class="lead animate__animated animate__fadeInRight animate__delay-1s mt-3">
				  Belajar online dengan metode paling beda. Siswa akan belajar dengan metode blended learning, dimulai dengan belajar melalui video dengan metode e-learning, menyelesaikan kuis, ujian, dan mengerjakan project portfolio sesuai standar industri masa kini. 
	Belajar online dengan metode paling beda. Siswa akan belajar dengan metode blended learning, dimulai dengan belajar melalui video dengan metode e-learning, menyelesaikan kuis, ujian, dan mengerjakan project portfolio sesuai standar industri masa kini.
	<br><br>
	Instruktur akan membantu siswa melalui sesi konsultasi melalui video conference atau siswa datang ke kelas untuk berdiskusi tentang materi maupun kendala lain. Siswa akan mendapatkan 3 kali sesi konsultasi dengan durasi masing-masing 1 jam yang bisa digunakan kapan saja, tergantung ketersediaan slot.
	</p>
	</div>


	</div>
	</div>

	</div>
	</div>
	</div> -->
	<div class="container-fluid" style="background: #F6FBFF;">
		<div class="container">
			<div class="row mb-5 pb-5">
				<div class="col-12 col-lg-12 d-flex justify-content-center text-center my-5 ">
					<label>
						<h4 class="display-5 "><b>Biaya Hemat, Kualitas Hebat.</b></h4>
					</label>
				</div>
				<div class="col-12 col-md-12 col-lg-5 d-flex text-center ">
					<img class="mx-auto mx-lg-0 img-fluid img-float-pc "
						 src="<?= base_url('upload/banner_mapel/img-float-pc.png') ?>">
					<img class=" img-fluid img-float-cs" src="<?= base_url('upload/banner_mapel/img-float-cs.png') ?>">
					<img class="mx-auto mx-lg-0 align-items-center img-fluid mt-md-3" style="width:100%; height:280px"
						 src="<?= base_url('assets/front/v2/img/Illustrasi/dashboard-2.png') ?>">
				</div>

				<div class="col-12 col-lg-7 d-flex flex-column justify-content-center  ">
					<!-- <h3 class="heading-main mt-1">
						<b>Sistem i-Karismax</b>
					</h3> -->
					<div class="row ">
						<div class="col-lg-2 col-3 col-md-2 mt-5 pt-4">
							<img class="mx-auto pl-md-3 pr-2 mx-lg-0 img-fluid"
								 src="<?= base_url('upload/banner_mapel/server.png') ?>" width=90;>
						</div>
						<!-- <p class="heading-sub"></p> -->

						<div class="col-lg-10 col-9 col-md-10 pl-4 mt-5">
							<b>Kurikulum Berstandar Industri & Sesuai Dunia Kerja
							</b>
							<p style="font-size: smaller; line-height:1.6"
							   class="lead animate__animated animate__fadeInRight animate__delay-1s mt-3">
								<!-- Belajar online dengan metode paling beda. Siswa akan belajar dengan metode blended learning, dimulai dengan belajar melalui video dengan metode e-learning, menyelesaikan kuis, ujian, dan mengerjakan project portfolio sesuai standar industri masa kini. -->

								Sajian materi e-learning berkualitas sebanding dengan pertemuan tatap muka. Kurikulum
								yang digunakan adalah berstandar dunia industri dan usaha terbaru.
							</p>
						</div>

						<div class="col-lg-2 col-3 col-md-2 mt-5 ">
							<img class="mx-auto mx-lg-0 img-fluid pl-md-3 pr-1"
								 src="<?= base_url('upload/banner_mapel/server2.png') ?>" width=90;>
						</div>
						<div class="col-lg-10 col-9 col-md-10 my-4 pl-md-4">
							<b>Seluruh Instruktur Praktisi
							</b>
							<p style="font-size: smaller; line-height:1.6"
							   class="lead animate__animated animate__fadeInRight animate__delay-1s mt-3">

								Kamu tidak akan merasa jenuh belajar online, karena kamu akan didampingi oleh instruktur
								hebat untuk berbagi dan berdiskusi mengenai materi yang kamu pelajari.
							</p>
						</div>
						<br>
						<div class="col-lg-2 col-3 col-md-2 mt-3 justify-content-center">
							<img class="mx-auto mx-lg-0 img-fluid pl-md-3 pr-1"
								 src="<?= base_url('upload/banner_mapel/server3.png') ?>" width=85;>
						</div>
						<div class="col-lg-10 col-9 col-md-10 pl-md-4 ">
							<b>Dapatkan 2 Sertifikat Belajar
							</b>
							<p style="font-size: smaller; line-height:1.6"
							   class="lead animate__animated animate__fadeInRight animate__delay-1s mt-3">
								Sertifikat yang kamu dapatkan adalah berdasarkan nilai ujian setiap menyelesaikan
								materi. Serta penilaian dari portfolio yang kamu kerjakan yang dinilai dan diulas secara
								langsung oleh para instruktur.
							</p>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<div class="container pb-5">
		<div class="col-12 d-flex justify-content-center text-center mt-5">
			<label>
				<h4 class="display-5"><b>Prioritas Kecepatan dan Keamanan
					</b></h4>
			</label>
		</div>
		<div class="row d-flex flex-wrap-reverse">
			<div class="col-12 col-lg-7 d-flex justify-content-end mb-3">
				<h3 class="heading-main  ">
					<!-- <b>Sistem i-Karismax</b> -->
				</h3>
				<div class="row ">
					<div class="col-lg-2 col-md-2 col-3 mt-5">
						<img class="mx-lg-0 pr-5 img-fluid" src="<?= base_url('upload/banner_mapel/live-logo.png') ?>"
							 style="width:8em;">
					</div>
					<!-- <p class="heading-sub"></p> -->

					<div class="col-lg-9 col-md-10 col-9 pl-md-4 mt-3 ">
						<h5><b>Live Instruktur</b></h5>
						<p style="font-size: small; line-height:1.6"
						   class="lead animate__animated animate__fadeInRight animate__delay-1s mt-3">
							<!-- Belajar online dengan metode paling beda. Siswa akan belajar dengan metode blended learning, dimulai dengan belajar melalui video dengan metode e-learning, menyelesaikan kuis, ujian, dan mengerjakan project portfolio sesuai standar industri masa kini. -->

							Instruktur akan membantu siswa melalui sesi konsultasi melalui video conference atau siswa
							datang ke kelas untuk berdiskusi tentang materi maupun kendala lain. Siswa akan mendapatkan
							3 kali sesi konsultasi dengan durasi masing-masing 1 jam yang bisa digunakan kapan saja,
							tergantung ketersediaan slot.
						</p>
					</div>

					<div class="col-lg-2 col-md-2 col-3 my-5 ">
						<img class="mx-lg-0 pr-5 img-fluid" src="<?= base_url('upload/banner_mapel/platform.png') ?>"
							 style="width:8em;">
					</div>
					<div class="col-lg-9 col-md-10 col-9 my-4 pl-md-4">
						<h5><b>Platform Belajar & E-Course</b></h5>

						<p style="font-size: small; line-height:1.6"
						   class="lead animate__animated animate__fadeInRight animate__delay-1s mt-3">
							Belajar online dengan metode paling beda. Siswa akan belajar dengan metode blended learning,
							dimulai dengan belajar melalui video dengan metode e-learning, menyelesaikan kuis, ujian,
							dan mengerjakan project portfolio sesuai standar industri masa kini.
						</p>
					</div>
					<br>
					<div class="col-lg-2 col-0 mt-3 justify-content-center">

					</div>
					<!-- <div class="col-lg-7 col-12 mt-4 pl-4 ">
							<a class="btn btn-more-member btn-outline-warning text-white" href="<?= base_url("kelas") ?>">Lihat Selengkapnya </a>
						</div> -->
				</div>
			</div>
			<div class="col-12 col-lg-5 d-flex flex-column justify-content-center mb-4">
				<img class="mx-auto mx-lg-0 img-fluid " style="width:80%;  "
					 src="<?= base_url('assets/front/v2/img/Illustrasi/robot.png') ?>">
			</div>

		</div>
	</div>

</section>
