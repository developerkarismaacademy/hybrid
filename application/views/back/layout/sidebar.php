<?php
$adminkah = $this->session->backData["level_user"] == "administrasi";
$instrukturkah = $this->session->backData["level_user"] == "instruktur";
?>
<div class="left side-menu">
	<div class="sidebar-inner slimscrollleft">

		<!--- Sidemenu -->
		<div id="sidebar-menu">

			<!--User Sidebar-->
			<div class="user-details">
				<div class="overlay"></div>
				<div class="text-center">
					<img src="<?= base_url(); ?>upload/instruktur/<?= $this->session->backData["gambar_user"] ?>" alt=""
						 class="thumb-md img-circle">
				</div>
				<div class="user-info">
					<div>
						<a href="#setting-dropdown" class="dropdown-toggle" data-toggle="dropdown"
						   aria-expanded="false">
							<?= $this->session->backData["nama_user"] ?> <span class="mdi mdi-menu-down"></span>
						</a>
					</div>
				</div>
			</div>

			<div class="dropdown" id="setting-dropdown">
				<ul class="dropdown-menu">
					<li><a href="javascript:void(0)"><i class="mdi mdi-face-profile m-r-5"></i> Profile</a></li>
					</li>
					<li><a href="<?= base_url("back/logout") ?>"><i class="mdi mdi-logout m-r-5"></i> Logout</a></li>
				</ul>
			</div>

			<ul>
				<li class="menu-title">Navigation</li>

				<!--Menu Sidebar-->
				<li>
					<a href="<?= base_url('back') ?>" class="waves-effect">
						<i><img class="icon-colored sidebar" src="<?= base_url(); ?>assets/back/images/icons/home.svg"
								title="Dashboard"></i>
						<span> Dashboard </span>
					</a>
				</li>

				<?php if ($this->session->backData["level_user"] == "administrasi" || $this->session->backData["level_user"] == "instruktur") { ?>
					<li class="<?= $menu == "kelas" ? "active" : "" ?>">
						<a href="<?= base_url('back/kelas') ?>"
						   class="waves-effect <?= $menu == "kelas" ? "active" : "" ?>">
							<i><img class="icon-colored sidebar"
									src="<?= base_url(); ?>assets/back/images/icons/<?= ($this->session->backData["level_user"] == "instruktur") ? "comments" : "conference_call" ?>.svg"
									title="Kelas"></i>
							<span> Kelas
                                <?= ($this->session->backData['level_user'] == "instruktur") ? "(Komentar)" : "" ?>
                            </span>
						</a>
					</li>
				<?php } ?>


				<?php if ($this->session->backData["level_user"] == "administrasi") { ?>
				<li class="<?= $menu == "siswa" ? "active" : "" ?>">
					<a href="<?= base_url('back/siswa') ?>"
					   class="waves-effect <?= $menu == "siswa" ? "active" : "" ?>">

						<i>
							<img class="icon-colored sidebar"
								 src="<?= base_url(); ?>assets/back/images/icons/reading_ebook.svg" title="Siswa">
						</i>

						<span> Siswa</span>
					</a>
				</li>
				<li class="<?= $menu == "instruktur" ? "active" : "" ?>">
					<a href="<?= base_url('back/instruktur') ?>"
					   class="waves-effect <?= $menu == "instruktur" ? "active" : "" ?>">

						<i>
							<img class="icon-colored sidebar"
								 src="<?= base_url(); ?>assets/back/images/icons/reading.svg" title="Instruktur">
						</i>

						<span> Instruktur</span>
					</a>
				</li>
				<li class="<?= $menu == "paket" ? "active" : "" ?>">
					<a href="<?= base_url('back/paket') ?>"
					   class="waves-effect <?= $menu == "paket" ? "active" : "" ?>">
						<i><img class="icon-colored sidebar"
								src="<?= base_url(); ?>assets/back/images/icons/deployment.svg" title="deployment.svg"></i>
						<span> Paket</span>
					</a>
				</li>

				<!-- <li class="<?= $menu == "testimoniMapel" ? "active" : "" ?>">
                        <a href="<?= base_url('back/testimoniMapel') ?>"
                           class="waves-effect <?= $menu == "testimoniMapel" ? "active" : "" ?>">
                            <i><img class="icon-colored sidebar"
                                    src="<?= base_url(); ?>assets/back/images/icons/currency_exchange.svg"
                                    title="currency_exchange.svg"></i>
                            <span>Testimoni</span>
                        </a>
                    </li> -->

				<li class="<?= $menu == "pembelian" ? "active" : "" ?>">
					<a href="<?= base_url('back/pembelian') ?>"
					   class="waves-effect <?= $menu == "pembelian" ? "active" : "" ?>">
						<i><img class="icon-colored sidebar" src="<?= base_url(); ?>assets/back/images/icons/paid.svg"
								title="paid.svg"></i>
						<span> Pembelian</span>
					</a>
				</li>

				<li class="<?= $menu == "pembelian.form-insert" ? "active" : "" ?>">
					<a href="<?= base_url('back/pembelian/tambah') ?>"
					   class="waves-effect <?= $menu == "pembelian.form-insert" ? "active" : "" ?>">
						<i><img class="icon-colored sidebar" src="<?= base_url(); ?>assets/back/images/icons/invite.svg"
								title="invite.svg"></i>
						<span> Beli untuk siswa</span>
					</a>
				</li>

				<li class="<?= $menu == "voucher" ? "active" : "" ?>">
					<a href="<?= base_url('back/voucher') ?>"
					   class="waves-effect <?= $menu == "voucher" ? "active" : "" ?>">
						<i><img class="icon-colored sidebar"
								src="<?= base_url(); ?>assets/back/images/icons/money_transfer.svg"
								title="money_transfer.svg"></i>
						<span> Voucher</span>
					</a>
				</li>


			</ul>
			<ul>
				<li class="menu-title">Prakerja</li>

				<li class="<?= $menu == "invoice" ? "active" : "" ?>">
					<a href="<?= base_url('back/invoice') ?>"
					   class="waves-effect <?= $menu == "invoice" ? "active" : "" ?>">
						<i><img class="icon-colored sidebar" src="<?= base_url(); ?>assets/back/images/icons/invite.svg"
								title="invite.svg"></i>
						<span>Data Invoice</span>
					</a>
				</li>
				<li class="<?= $menu == "transfer" ? "active" : "" ?>">
					<a href="<?= base_url('back/transfer') ?>"
					   class="waves-effect <?= $menu == "transfer" ? "active" : "" ?>">
						<i><img class="icon-colored sidebar"
								src="<?= base_url(); ?>assets/back/images/icons/money_transfer.svg"
								title="money_transfer.svg"></i>
						<span> Transfer</span>
					</a>
				</li>
				<li class="<?= $menu == "absen" ? "active" : "" ?>">
					<a href="<?= base_url('back/absen') ?>"
					   class="waves-effect <?= $menu == "absen" ? "active" : "" ?>">
						<i>
							<img class="icon-colored sidebar"
								 src="<?= base_url(); ?>assets/back/images/icons/reading_ebook.svg" title="Absen">
						</i>
						<span>Absen</span>
					</a>
				</li>
				<li class="<?= $menu == "peserta" ? "active" : "" ?>">
					<a href="<?= base_url('back/peserta') ?>"
					   class="waves-effect <?= $menu == "peserta" ? "active" : "" ?>">

						<i>
							<img class="icon-colored sidebar"
								 src="<?= base_url(); ?>assets/back/images/icons/reading_ebook.svg" title="Peserta">
						</i>

						<span>Peserta</span>
					</a>
				</li>
			</ul>
			<ul>
				<li class="menu-title">Tombol</li>

				<li class="<?= $menu == "rating" ? "active" : "" ?>">
					<a href="<?= base_url('back/rating') ?>"
					   class="waves-effect <?= $menu == "rating" ? "active" : "" ?>">
						<i><img class="icon-colored sidebar"
								src="<?= base_url(); ?>assets/back/images/icons/portrait_mode.svg"
								title="currency_exchange.svg"></i>
						<span>Rating Generator</span>
					</a>
				</li>
				<li class="<?= $menu == "skkni" ? "active" : "" ?>">
					<a href="<?= base_url('back/skkni') ?>"
					   class="waves-effect <?= $menu == "skkni" ? "active" : "" ?>">
						<i><img class="icon-colored sidebar"
								src="<?= base_url(); ?>assets/back/images/icons/deployment.svg" title="deployment.svg"></i>
						<span> SKKNI</span>
					</a>
				</li>
			</ul>


			<?php } elseif ($this->session->backData["level_user"] == "instruktur") { ?>
				<li class="<?= $menu == "progress" ? "active" : "" ?>">
					<a href="<?= base_url('back/mapel-ampu') ?>"
					   class="waves-effect <?= $menu == "progress" ? "active" : "" ?>">
						<i><img class="icon-colored sidebar"
								src="<?= base_url(); ?>/assets/back/images/icons/positive_dynamic.svg"
								title="positive_dynamic.svg"></i>
						<span> Progress Siswa</span>
					</a>
				</li>
			<?php } ?>
			</ul>
		</div>
		<!-- Sidebar -->
		<div class="clearfix"></div>


	</div>
	<!-- Sidebar -left -->

</div>
