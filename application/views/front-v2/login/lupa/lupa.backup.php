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
						<a class="nav-link" id="pills-lupa2-tab" data-toggle="pill"
						   href="#pills-lupa2"
						   role="tab"
						   aria-controls="pills-login" aria-selected="true">Verifikasi</a>
						<a class="nav-link" id="pills-lupa3-tab" data-toggle="pill"
						   href="#pills-lupa3"
						   role="tab"
						   aria-controls="pills-login" aria-selected="true">Ubah</a>
					</li>
				</ul>
				<div class="tab-content tab-animation tab-left" id="pills-tabContent">
					<div class="tab-pane fade show active" id="pills-lupa1" role="tabpanel"
						 aria-labelledby="pills-lupa1-tab">
						<form action="<?= base_url("login/lupa") ?>" method="post" class="form-custom">
							<div class="form-group">
								<label for="username">Email/Username akun anda</label>
								<input type="text"
									   class="form-control <?= (form_error('username_lupa') != "") ? " is-invalid " : "" ?>"
									   id="username_lupa" name="username_lupa" value="<?= $username_lupa ?? "" ?>"
									   aria-describedby="email" placeholder="sample@email.com">

								<?php if (form_error('username_lupa') != ""): ?>
									<div class="invalid-feedback mt-2">
										<?php echo form_error('username_lupa'); ?>
									</div>
								<?php endif; ?>
							</div>

							<button type="button" class="btn btn-warning btn-lg rounded-custom btn-block"
									data-target="#pills-lupa2-tab">Kirim Request
							</button>
						</form>

						<div class="mini-navigasi mt-3">
							<a href="<?= base_url("login") ?>">
								<i class="fa fa-arrow-left text-warning"></i> Kembali
							</a>
						</div>
					</div>
					<div class="tab-pane fade" id="pills-lupa2" role="tabpanel"
						 aria-labelledby="pills-lupa2-tab">
						<form action="<?= base_url("login/lupa") ?>" method="post">
							<p>Kode berhasil dikirim, silahkan isikan dengan kode verifikasi yang anda terima</p>
							<div class="code-lupa py-3">
								<input type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}"
									   id="code-lupa1" name="code-lupa1"/>
								<input type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}"
									   id="code-lupa2" name="code-lupa2"/>
								<input type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}"
									   id="code-lupa3" name="code-lupa3"/>
								<input type="text" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}"
									   id="code-lupa4" name="code-lupa4"/>
							</div>

							<button type="button" class="btn btn-warning btn-lg rounded-custom btn-block"
									data-target="#pills-lupa3-tab">
								Verifikasi Kode
							</button>
						</form>

						<div class="mini-navigasi mt-3">
							<a href="<?= base_url("login") ?>">
								<i class="fa fa-arrow-left text-warning"></i> Kembali
							</a>
						</div>
					</div>
					<div class="tab-pane fade" id="pills-lupa3" role="tabpanel"
						 aria-labelledby="pills-lupa3-tab">
						<form action="<?= base_url("login/lupa") ?>" method="post">


							<div class="form-group">
								<label for="password">Password</label>
								<div class="input-group">
									<input type="password"
										   class="form-control password-field <?= (form_error('password') != "") ? " is-invalid " : "" ?>"
										   id="password_ubah"
										   name="password"
										   placeholder="Ubah Password">
									<span class="icon-inside">
										<i class="fa fa-eye-slash"></i>
									</span>

									<?php if (form_error('password') != ""): ?>
										<div class="invalid-feedback mt-2">
											<?php echo form_error('password'); ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
							<div class="form-group">
								<label for="konfirmasi_password">Konfirmasi Password</label>
								<div class="input-group">
									<input type="password"
										   class="form-control password-field <?= (form_error('konfirmasi_password_ubah') != "") ? " is-invalid " : "" ?>"
										   id="konfirmasi_password_ubah"
										   name="konfirmasi_password_ubah"
										   placeholder="Konfirmasi Password">
									<span class="icon-inside">
										<i class="fa fa-eye-slash"></i>
									</span>

									<?php if (form_error('konfirmasi_password_ubah') != ""): ?>
										<div class="invalid-feedback mt-2">
											<?php echo form_error('konfirmasi_password_ubah'); ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
							<button type="submit" class="btn btn-warning btn-lg rounded-custom btn-block">
								Ubah Password
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
