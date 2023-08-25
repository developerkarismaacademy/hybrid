<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
	<meta name="author" content="Coderthemes">

	<!-- App favicon -->
	<link rel="shortcut icon" href="<?= base_url(); ?>assets/front/v2/img/favicon-2.svg">
	<!-- App title -->
	<title> LOGIN - Admin Kursusonline</title>
	<!-- App css -->
	<link href="<?= base_url() ?>/assets/back/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?= base_url() ?>/assets/back/css/core.css" rel="stylesheet" type="text/css"/>
	<link href="<?= base_url() ?>/assets/back/css/components.css" rel="stylesheet" type="text/css"/>
	<link href="<?= base_url() ?>/assets/back/css/icons.css" rel="stylesheet" type="text/css"/>
	<link href="<?= base_url() ?>/assets/back/css/pages.css" rel="stylesheet" type="text/css"/>
	<link href="<?= base_url() ?>/assets/back/css/menu.css" rel="stylesheet" type="text/css"/>
	<link href="<?= base_url() ?>/assets/back/css/responsive.css" rel="stylesheet" type="text/css"/>

	<!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

	<script src="<?= base_url() ?>/assets/back/js/modernizr.min.js"></script>

</head>


<body>

<!-- Loader -->
<div id="preloader">
	<div id="status">
		<div class="spinner">
			<div class="spinner-wrapper">
				<div class="rotator">
					<div class="inner-spin"></div>
					<div class="inner-spin"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- HOME -->
<section>
	<div class="container-alt">
		<div class="row">
			<div class="col-sm-12">

				<div class="wrapper-page">

					<div class="m-t-40 account-pages">
						<div class="text-center account-logo-box">
							<h2 class="text-uppercase">
								<a href="#" class="text-success">
									<span><img src="<?= base_url() ?>/assets/front/v2/img/kursusonline-logo.svg" alt=""
											   height="36"></span>
								</a>
							</h2>
							<!--<h4 class="text-uppercase font-bold m-b-0">Sign In</h4>-->
						</div>


						<div class="account-content">
							<form class="form-horizontal" action="<?= base_url("back/submit-login") ?>" method="post">
								<?= $this->session->flashdata('alert') ?>
								<div class="form-group ">
									<div class="col-xs-12">
										<input class="form-control" name="username" type="text" required=""
											   placeholder="Username">
									</div>
								</div>

								<div class="form-group">
									<div class="col-xs-12">
										<input class="form-control" name="password" type="password" required=""
											   placeholder="Password">
									</div>
								</div>

								<div class="form-group account-btn text-center m-t-10">
									<div class="col-xs-12">
										<button class="btn w-md btn-bordered btn-danger waves-effect waves-light"
												type="submit">Log In
										</button>
									</div>
								</div>

							</form>

							<div class="clearfix"></div>

						</div>
					</div>
					<!-- end card-box-->


				</div>
				<!-- end wrapper -->

			</div>
		</div>
	</div>
</section>
<!-- END HOME -->

<script>
	var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="<?= base_url() ?>/assets/back/js/jquery.min.js"></script>
<script src="<?= base_url() ?>/assets/back/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>/assets/back/js/detect.js"></script>
<script src="<?= base_url() ?>/assets/back/js/fastclick.js"></script>
<script src="<?= base_url() ?>/assets/back/js/jquery.blockUI.js"></script>
<script src="<?= base_url() ?>/assets/back/js/waves.js"></script>
<script src="<?= base_url() ?>/assets/back/js/jquery.slimscroll.js"></script>
<script src="<?= base_url() ?>/assets/back/js/jquery.scrollTo.min.js"></script>

<!-- App js -->
<script src="<?= base_url() ?>/assets/back/js/jquery.core.js"></script>
<script src="<?= base_url() ?>/assets/back/js/jquery.app.js"></script>

</body>
</html>
