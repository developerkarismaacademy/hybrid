<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8"/>
	<title>Log In | Karisma Academy</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="A fully responsive admin theme which can be used to build CRM, CMS,ERP etc." name="description"/>
	<meta content="Techzaa" name="author"/>

	<!-- App favicon -->
	<link rel="shortcut icon" href="<?= base_url('assets/back-v2/') ?>assets/images/favicon.ico">

	<!-- Theme Config Js -->
	<script src="<?= base_url('assets/back-v2/') ?>assets/js/config.js"></script>

	<!-- App css -->
	<link href="<?= base_url('assets/back-v2/') ?>assets/css/app.min.css" rel="stylesheet" type="text/css"
		  id="app-style"/>

	<!-- Icons css -->
	<link href="<?= base_url('assets/back-v2/') ?>assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
</head>

<body class="authentication-bg position-relative">
<div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-xxl-8 col-lg-10">
				<div class="card overflow-hidden">
					<div class="row g-0">
						<div class="col-lg-6 d-none d-lg-block p-2">
							<img src="<?= base_url('assets/back-v2/') ?>assets/images/auth-img.jpg" alt=""
								 class="img-fluid rounded h-100">
						</div>
						<div class="col-lg-6">
							<div class="d-flex flex-column h-100">
								<div class="auth-brand p-4">
									<a href="<?= base_url('back-v2') ?>" class="logo-light">
										<img src="<?= base_url('assets/back-v2/') ?>assets/images/logo.png" alt="logo"
											 height="22">
									</a>
									<a href="<?= base_url('back-v2') ?>" class="logo-dark">
										<img src="<?= base_url('assets/back-v2/') ?>assets/images/logo-dark.png"
											 alt="dark logo" height="22">
									</a>
								</div>
								<div class="p-4">
								<?php if ($this->session->flashdata('error')): ?>
										<div class="alert alert-danger" role="alert">
											<?= $this->session->flashdata('error') ?>
										</div>
								<?php endif ?>
								<?php if ($this->session->flashdata('success')): ?>
										<div class="alert alert-success" role="alert">
											<?= $this->session->flashdata('success') ?>
										</div>
								<?php endif ?>
									<h4 class="fs-20">Sign In</h4>
									<p class="text-muted mb-3">Enter your email address and password to access
										account.
									</p>

									<!-- form -->
									<form action="<?= base_url('back-v2/login') ?>" method="POST">
										<div class="mb-3">
											<label for="emailaddress" class="form-label">Email address</label>
											<input class="form-control" type="email" id="emailaddress"
												   placeholder="Enter your email" name="email"
												   value="<?= set_value('email') ?>">
											<small class="text-danger"><?= form_error('email') ?></small>
										</div>
										<div class="mb-3">
											<label for="password" class="form-label">Password</label>
											<input class="form-control" type="password" id="password"
												   placeholder="Enter your password" name="password"
												   value="<?= set_value('password') ?>">
											<small class="text-danger"><?= form_error('password') ?></small>
										</div>
										<div class="mb-0 text-start">
											<button class="btn btn-soft-primary w-100" type="submit"><i
													class="ri-login-circle-fill me-1"></i> <span class="fw-bold">Log
                                                        In</span></button>
										</div>
									</form>
									<!-- end form-->
								</div>
							</div>
						</div> <!-- end col -->
					</div>
				</div>
			</div>
			<!-- end row -->
		</div>
		<!-- end row -->
	</div>
	<!-- end container -->
</div>
<!-- end page -->

<footer class="footer footer-alt fw-medium">
        <span class="text-dark">
            <script>document.write(new Date().getFullYear())</script> © Velonic - Theme by Techzaa
        </span>
</footer>
<!-- Vendor js -->
<script src="<?= base_url('assets/back-v2/') ?>assets/js/vendor.min.js"></script>

<!-- App js -->
<script src="<?= base_url('assets/back-v2/') ?>assets/js/app.min.js"></script>

</body>

</html>
