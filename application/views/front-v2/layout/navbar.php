<nav class="navbar navbar-expand-lg bg-ka-darker navbar-inverse">

	<div class="container py-0">

		<a class="navbar-brand" href="<?= base_url() ?>">

			<div class="row">

				<div class="col">

					<div class="brand"></div>

				</div>

			</div>

		</a>



		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarKarismaOnline"

			aria-controls="navbarKarismaOnline" aria-expanded="false" aria-label="Toggle navigation">

			<span class="navbar-toggler-icon">

				<i class="fa fa-bars fa-lg h-100 align-items-center text-white" aria-hidden="true"

					title="Toggle navigation"></i>

				<span class="sr-only">Toggle navigation</span>

			</span>

		</button>



		<div class="collapse navbar-collapse " id="navbarKarismaOnline">

			<ul class="navbar-nav pr-0 justify-content-end align-items-lg-center">

				<li class="nav-item">

					<a class="nav-link" href="<?= base_url() ?>">Beranda</a>

				</li>

				<li class="nav-item">

					<a class="nav-link" href="<?= base_url("tentang") ?>">Tentang Kami</a>

				</li>

				<li class="nav-item">

					<a class="nav-link" href="<?= base_url("kelas") ?>">Cari</a>

				</li>

				<li class="nav-item dropdown" id="kursus-list">

					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"

						aria-haspopup="true" aria-expanded="false">

						Kursus

					</a>

					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

						<?php

						$navbarKelas = $this->FrontKelasModel->getAllKelas();

						if ($navbarKelas["total"] > 0) {

							foreach ($navbarKelas["data"] as $val) {

								?>

								<a class="dropdown-item" href="<?= base_url("kelas#{$val['meta_link_kelas']}") ?>"

									data-namakursus="<?= $val['meta_link_kelas'] ?>" value="<?= $val['id_kelas'] ?>"><?= $val['nama_kelas'] ?></a>

								<?php

							}

						}

						?>

					</div>

				</li>



				<li class="nav-item">

					<a class="nav-link" href="<?= base_url('prakerja') ?>">Prakerja</a>

				</li>

				<li class="nav-item">
					<a class="nav-link" href="<?= base_url('promotion') ?>">Promosi</a>
				</li>



<!--				<li class="nav-item">-->

<!--					<a class="nav-link" href="--><?//= base_url() ?><!--profil/gamification">Tukar Poin</a>-->

<!--				</li>-->



<!--				<li class="nav-item">-->

<!--					<a class="nav-link" href="--><?//= base_url() ?><!--profil/gamification"></a>-->

<!--				</li>-->



				<?php if ($this->session->userdata("siswaData")) { ?>



					<li class="nav-item dropdown">

						<div class="nav-link dropdown-toggle btn btn-warning font-weight-normal" href="#" id="navbarDropdown"

							role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

							<i class="fa fa-user"></i>

							<?= $this->session->siswaData["nama_depan"] ?? "" ?>

						</div>

						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

							<a class="dropdown-item" href="<?= base_url("keranjang") ?>">Keranjang</a>

							<div class="dropdown-divider"></div>

							<a class="dropdown-item" href="<?= base_url("profil") ?>">Profil</a>

<!--							<a class="dropdown-item" href="--><?//= base_url("prakerja/voucher") ?><!--">Tukar Voucher</a>-->

							<a class="dropdown-item" href="<?= base_url("logout") ?>">Logout</a>

						</div>

					</li>



				<?php } else { ?>



					<li class="nav-item dropdown">

						<a class="nav-link  btn btn-warning font-weight-normal" href="<?= base_url("login") ?>" id="navbarDropdown">

							DAFTAR/MASUK

						</a>



					</li>

				<?php } ?>

			</ul>

		</div>

	</div>

</nav>

