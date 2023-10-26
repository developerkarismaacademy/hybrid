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
									  style="background-image:url('<?= base_url() ?>assets/front/v2/img/asset-<?= $k ?>.png');"></span>
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
						<a class="nav-link <?= $loginPage ?? "active" ?>" id="pills-login-tab" data-toggle="pill"
						   href="#pills-login"
						   role="tab"
						   aria-controls="pills-login" aria-selected="true">Masuk </a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?= $signupPage ?? "" ?>" id="pills-signup-tab" data-toggle="pill"
						   href="#pills-signup" role="tab"
						   aria-controls="pills-signup" aria-selected="false">Daftar</a>
					</li>
				</ul>
				<div class="tab-content tab-animation tab-left" id="pills-tabContent">
					<?php
					//LOGIN
					?>
					<div class="tab-pane fade <?= $loginPage ?? "show active" ?>" id="pills-login" role="tabpanel"
						 aria-labelledby="pills-login-tab">
						<form action="<?= base_url("login") ?>" method="post" class="form-custom">
							<div class="form-group">
								<label for="username_login">Email/Username</label>
								<input type="text"
									   class="form-control <?= (form_error('username_login') != "") ? " is-invalid " : "" ?>"
									   id="username_login" name="username_login" value="<?= $username ?? "" ?>"
									   aria-describedby="email" placeholder="sample@email.com" style="text-transform: lowercase">

								<?php if (form_error('username_login') != ""): ?>
									<div class="invalid-feedback mt-2">
										<?php echo form_error('username_login'); ?>
									</div>
								<?php endif; ?>
							</div>
							<div class="form-group">
								<label for="password_login">Password</label>
								<div class="input-group">
									<input type="password"
										   class="form-control password-field <?= (form_error('password_login') != "") ? " is-invalid " : "" ?> "
										   id="password_login"
										   name="password_login"
										   placeholder="Password">
									<span class="icon-inside">
											<i class="fa fa-eye-slash"></i>
										</span>
									<?php if (form_error('password_login') != ""): ?>
										<div class="invalid-feedback mt-2">
											<?php echo form_error('password_login'); ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
							<div class="text-right">
								Lupa password? Klik <a href="<?= base_url('login/lupa')?>" class="text-info"><u><b>disini</b></u></a>
							</div>
							<div class="text-center">
								<button type="submit" class="btn btn-warning btn-lg rounded-custom btn-block">Login
								</button>
								<?php
								// 	<div class="form-text">Atau masuk dengan</div>
								// 	<div class="login-social">
								// 		<span class="login-social-item login-social-f">
								// 			<i class="fa fa-facebook-f fa-fw"></i>
								// 		</span>
								// 		<span class="login-social-item login-social-g">
								// 			<i class="fa fa-google fa-fw"></i>
								// 		</span>
								// 	</div>
								?>
							</div>
						</form>
					</div>

					<?php
					//SIGNUP
					?>
					<div class="tab-pane fade <?= $signupPage ?? "" ?>" id="pills-signup" role="tabpanel"
						 aria-labelledby="pills-signup-tab">
						<form action="<?= base_url("daftar") ?>" method="post" class="form-custom">
							<div class="form-group">
								<label for="nama_user">Nama Lengkap</label>
								<input type="text"
									   class="form-control <?= (form_error('nama_user') != "") ? " is-invalid " : "" ?>"
									   id="nama_user" name="nama_user" value="<?= $nama_user ?? "" ?>"
									   aria-describedby="nama_user" placeholder="Nama Lengkap">

								<?php if (form_error('nama_user') != ""): ?>
									<div class="invalid-feedback mt-2">
										<?php echo form_error('nama_user'); ?>
									</div>
								<?php endif; ?>
							</div>
							<div class="form-group">
								<label for="jk_user">Jenis Kelamin</label>
								<div class="input-group">
									<select name="jk_user"
											id="jk_user"
											class="form-control <?= (form_error('nama_user') != "") ? " is-invalid " : "" ?>">
										<option value="Laki-laki">Laki-laki</option>
										<option value="Perempuan">Perempuan</option>
									</select>
									<?php if (form_error('jk_user') != ""): ?>
										<div class="invalid-feedback mt-2">
											<?php echo form_error('jk_user'); ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
							<div class="form-group">
								<label for="username">Username</label>
								<input type="text"
									   class="form-control <?= (form_error('username') != "") ? " is-invalid " : "" ?>"
									   id="username_signup" name="username" value="<?= $username ?? "" ?>"
									   aria-describedby="daftarEmail" placeholder="Username" style="text-transform: lowercase">

								<?php if (form_error('username') != ""): ?>
									<div class="invalid-feedback mt-2">
										<?php echo form_error('username'); ?>
									</div>
								<?php endif; ?>
							</div>

							<div class="form-group">
								<label for="email_user">Email</label>
								<input type="email"
									   class="form-control <?= (form_error('email_user') != "") ? " is-invalid " : "" ?>"
									   id="email_user" name="email_user" value="<?= $email_user ?? "" ?>"
									   aria-describedby="daftarEmail" placeholder="Email" style="text-transform: lowercase">

								<?php if (form_error('email_user') != ""): ?>
									<div class="invalid-feedback mt-2">
										<?php echo form_error('email_user'); ?>
									</div>
								<?php endif; ?>
							</div>
							<div class="form-group">
								<label for="telepon_user">No. Handphone</label>
								<input type="text"
									   class="form-control <?= (form_error('telepon_user') != "") ? " is-invalid " : "" ?>"
									   id="telepon_user" name="telepon_user" value="<?= $telepon_user ?? "" ?>"
									   aria-describedby="telepon_user" placeholder="081-222-xxx-xxx">

								<?php if (form_error('telepon_user') != ""): ?>
									<div class="invalid-feedback mt-2">
										<?php echo form_error('telepon_user'); ?>
									</div>
								<?php endif; ?>
							</div>

							<div class="form-group">
								<label for="password">Password</label>
								<div class="input-group">
									<input type="password"
										   class="form-control password-field <?= (form_error('password') != "") ? " is-invalid " : "" ?>"
										   id="password_signup"
										   name="password"
										   placeholder="Password">
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
										   class="form-control password-field <?= (form_error('konfirmasi_password') != "") ? " is-invalid " : "" ?>"
										   id="konfirmasi_password"
										   name="konfirmasi_password"
										   placeholder="Konfirmasi Password">
									<span class="icon-inside">
										<i class="fa fa-eye-slash"></i>
									</span>

									<?php if (form_error('konfirmasi_password') != ""): ?>
										<div class="invalid-feedback mt-2">
											<?php echo form_error('konfirmasi_password'); ?>
										</div>
									<?php endif; ?>
								</div>
							</div>

							<div class="form-group">
								<label for="tempat_lahir">Tempat Lahir</label>
								<div class="input-group">
									<input type="text"
										   class="form-control <?= (form_error('tempat_lahir') != "") ? " is-invalid " : "" ?>"
										   id="tempat_lahir"
										   name="tempat_lahir"
										   placeholder="Isikan kota/kabupaten lahir" maxlength="100">
									<?php if (form_error('tempat_lahir') != ""): ?>
										<div class="invalid-feedback mt-2">
											<?php echo form_error('tempat_lahir'); ?>
										</div>
									<?php endif; ?>
								</div>
							</div>

							<div class="form-group">
								<label for="tempat_lahir">Tanggal Lahir</label>
								<div class="input-group">
									<input type="date"
										   class="form-control <?= (form_error('tanggal_lahir') != "") ? " is-invalid " : "" ?>"
										   id="tanggal_lahir"
										   name="tanggal_lahir" max="<?= date('Y') - 5 ?>-12-31"
										   min="<?= date('Y') - 90 ?>-01-01" value="<?= date('Y') - 5 ?>-12-31">


									<?php if (form_error('tanggal_lahir') != ""): ?>
										<div class="invalid-feedback mt-2">
											<?php echo form_error('tanggal_lahir'); ?>
										</div>
									<?php endif; ?>
								</div>
							</div>

							<div class="text-center">
								<div class="form-text">Dengan mendaftar anda telah menyetujui Syarat dan Ketentuan serta
									Kebijakan Privasi
								</div>
								<button type="submit" class="btn btn-warning rounded-custom btn-lg btn-block">Daftar
								</button>
								<?php
								// <div class="form-text">Atau masuk dengan</div>
								// <div class="login-social">
								// 	<span class="login-social-item login-social-f">
								// 		<i class="fa fa-facebook-f fa-fw"></i>
								// 	</span>
								// 	<span class="login-social-item login-social-g">
								// 		<i class="fa fa-google fa-fw"></i>
								// 	</span>
								// </div>
								?>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Foot Start -->
