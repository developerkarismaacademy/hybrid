<!-- Top Bar End -->
<section id="login" class="bg-ka-dark">
	<div class="container">
		<div class="row login-row">
			<div class="col-lg-6 col-md-12 login-banner">
				<div class="container-fluid">
					<div class="login-welcome text-warning mb-2">Selamat Datang di</div>
					<div class="login-brand mb-0 mb-md-3">
						<div class="brand m-auto"></div>
					</div>

					<div class="login-fitur pt-3 font-mons d-none d-md-block">
						<?php
						$dummyfitur = [
							1 => "Akses materi selamanya",
							2 => "Tatap muka dengan instruktur",
							3 => "Sertifikat terdaftar",

						];
						foreach ($dummyfitur as $k => $v) {
							?>
							<div class="text-left fitur-child text-truncate">
								<span class="fitur-icon fitur-<?= $k ?>"
									  style="background-image:url('<?= base_url() ?>assets/front/v2/img/fitur.png');"></span>
								<span><?= $v ?></span>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-12 login-main text-dark">
				<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="pills-lupa1-tab" data-toggle="pill"
						   href="#pills-lupa1"
						   role="tab"
						   aria-controls="pills-lupa1" aria-selected="true">Kirim Email</a>
					</li>
				</ul>
				<div class="tab-content tab-animation tab-left" id="pills-tabContent">
					<div class="tab-pane fade show active" id="pills-lupa1" role="tabpanel"
						 aria-labelledby="pills-lupa1-tab">
						<form action="<?= base_url("login/lupa") ?>" method="post" class="form-custom">
							<div class="form-group">
								<label for="username">Email akun anda</label>
								<input type="email"
									   class="form-control text-lowercase <?= (form_error('email') != "") ? " is-invalid " : "" ?>"
									   id="username_lupa" name="email" value="<?= $username_lupa ?? "" ?>"
									   aria-describedby="email" placeholder="sample@email.com">

								<?php if (form_error('email') != ""): ?>
									<div class="invalid-feedback mt-2">
										<?php echo form_error('email'); ?>
									</div>
								<?php endif; ?>
							</div>

							<button type="submit" class="btn btn-warning btn-lg rounded-custom btn-block">Kirim Request
							</button>
						</form>

						<div class="mini-navigasi mt-3">
							<a href="<?= base_url("login") ?>">
								<i class="fa fa-arrow-left text-warning"></i> Kembali
							</a>
						</div>
					</div>
				</div>


			</div>
		</div>
	</div>
</section>
<!-- Foot Start -->
