<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
	<meta name="author" content="Coderthemes">

	<!-- App favicon -->
	<link rel="shortcut icon" href="<?= base_url() ?>/assets/back/images/favicon.png">
	<!-- App title -->
	<title><?= $title ?> - Admin Kursusonline</title>

	<!-- CUSTOM CSS -->
	<link href="<?= base_url(); ?>assets/back/plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?= base_url(); ?>assets/back/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet"
		  type="text/css">

	<?php

	$lastfile = explode(".", $content);
	$lastfile = $lastfile[count($lastfile) - 1];

	$content_file = str_replace(".", "/", $content);

	if (file_exists('./application/views/back/' . $content_file . '/' . $lastfile . '_css.php')) {
		$this->load->view('back/' . $content_file . '/' . $lastfile . '_css');
	}
	?>

	<!-- App css -->
	<link href="<?= base_url(); ?>assets/back/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?= base_url(); ?>assets/back/css/core.css" rel="stylesheet" type="text/css"/>
	<link href="<?= base_url(); ?>assets/back/css/components.css" rel="stylesheet" type="text/css"/>
	<link href="<?= base_url(); ?>assets/back/css/icons.css" rel="stylesheet" type="text/css"/>
	<link href="<?= base_url(); ?>assets/back/css/pages.css" rel="stylesheet" type="text/css"/>
	<link href="<?= base_url(); ?>assets/back/css/menu.css" rel="stylesheet" type="text/css"/>
	<link href="<?= base_url(); ?>assets/back/css/responsive.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" href="<?= base_url(); ?>assets/back/plugins/switchery/switchery.min.css">
	<link href="<?= base_url(); ?>assets/back/css/custom.css" rel="stylesheet" type="text/css"/>


	<!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

	<script src="<?= base_url(); ?>assets/back/js/modernizr.min.js"></script>
	<style>
		.video-container {
			position: relative;
			padding-bottom: 56.25%;
			padding-top: 30px;
			height: 0;
			overflow: hidden;
		}

		.video-container iframe,
		.video-container object,
		.video-container embed {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
		}
	</style>

</head>


<body class="fixed-left" id="body">

<!-- Loader -->
<!-- <div id="preloader">
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
    </div> -->

<!-- Begin page -->
<div id="wrapper">

	<!-- Top Bar Start -->
	<?php $this->load->view('back/layout/header'); ?>
	<!-- Top Bar End -->


	<!-- Left Sidebar Start -->
	<?php $this->load->view('back/layout/sidebar'); ?>
	<!-- Left Sidebar End -->


	<!-- ============================================================== -->
	<!-- Start right Content here -->
	<!-- ============================================================== -->

	<!-- Start content -->

	<?php $this->load->view('back' . "/" . $content_file . '/' . $lastfile) ?>
	<!-- content -->


</div>
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->
<!-- <footer class="footer text-right">
				<?= date('Y') ?> © <?= $title ?> - Admin Kursusonline.
			</footer> -->
</div>
<!-- END wrapper -->


<script>
	var resizefunc = [];
	var base_url = '<?= base_url(); ?>';
	var base_url_api = '<?= base_url('api/v1'); ?>';
</script>

<!-- jQuery  -->
<script src="<?= base_url(); ?>assets/back/js/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/back/js/bootstrap.min.js"></script>
<script src="<?= base_url(); ?>assets/back/js/detect.js"></script>
<script src="<?= base_url(); ?>assets/back/js/fastclick.js"></script>
<script src="<?= base_url(); ?>assets/back/js/jquery.blockUI.js"></script>
<script src="<?= base_url(); ?>assets/back/js/waves.js"></script>
<script src="<?= base_url(); ?>assets/back/js/jquery.slimscroll.js"></script>
<script src="<?= base_url(); ?>assets/back/js/jquery.scrollTo.min.js"></script>
<script src="<?= base_url(); ?>assets/back/plugins//switchery/switchery.min.js"></script>


<!-- jQuery  -->
<script src="<?= base_url() ?>/assets/back/plugins/waypoints/jquery.waypoints.min.js"></script>
<script src="<?= base_url() ?>/assets/back/plugins/counterup/jquery.counterup.min.js"></script>

<!-- App js -->
<script src="<?= base_url(); ?>assets/back/js/jquery.core.js"></script>
<script src="<?= base_url(); ?>assets/back/js/jquery.app.js"></script>
<!--<script src="--><? //= base_url(); ?><!--assets/back/js/vue.js"></script>-->
<script src="<?= base_url(); ?>assets/back/plugins//toastr/toastr.min.js"></script>
<script src="<?= base_url(); ?>/assets/back/plugins/moment/moment.js"></script>
<script src="<?= base_url(); ?>/assets/back/plugins/jquery.redirect/jquery.redirect.js"></script>
<script src="<?= base_url(); ?>assets/back/plugins/bootstrap-sweetalert/sweet-alert.min.js"></script>

<script>
	toastr.options = {
		"closeButton": true,
		"debug": false,
		"newestOnTop": true,
		"progressBar": true,
		"positionClass": "toast-top-right",
		"preventDuplicates": false,
		"onclick": null,
		"showDuration": "300",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}
</script>

<script type="text/javascript" src="<?= base_url() ?>assets/back/js/custom.js"></script>

<?php
if (file_exists('./application/views/back/' . $content_file . '/' . $lastfile . '_js.php')) {
	$this->load->view('back/' . $content_file . '/' . $lastfile . '_js');
}
?>

</body>

</html>
