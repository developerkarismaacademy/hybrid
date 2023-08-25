<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="description"
		  content="Kursus online untuk keahlian Web, Office, Sipil, dan lain lain! Khusus di Karisma Academy">
	<meta name="author" content="Karisma Academy">
	<!-- App favicon -->
	<link rel="shortcut icon" href="<?= base_url() ?>/assets/back/images/favicon.png">


	<title> <?= $title ?? "" ?> - Kursus Online</title>

	<!--  Font-->
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&family=Open+Sans:wght@400;500;700;800&family=Raleway:wght@500;700;800&family=Roboto+Slab:wght@500;700&family=Roboto:wght@300;500;800&display=swap"
		  rel="stylesheet" media="none" onload="if(media!='all')media='all'">

	<!-- App css -->
	<link href="<?= base_url() ?>/assets/front/v2/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"
		  type="text/css" media="none" onload="if(media!='all')media='all'">
	<link href="<?= base_url() ?>/assets/front/v2/plugins/fontawesome/css/font-awesome.min.css" rel="stylesheet"
		  media="none" onload="if(media!='all')media='all'">
	<link href="<?= base_url() ?>/assets/front/v2/plugins/fontawesome/css/font-awesome-animation.min.css"
		  rel="stylesheet" media="none" onload="if(media!='all')media='all'">

	<link href="<?= base_url() ?>/assets/front/v2/plugins/aos/aos.css" rel="stylesheet" media="none"
		  onload="if(media!='all')media='all'">
	<link href="<?= base_url() ?>/assets/front/v2/plugins/slick/slick.css" rel="stylesheet" type="text/css" media="none"
		  onload="if(media!='all')media='all'">
	<link href="<?= base_url() ?>/assets/front/v2/plugins/slick/slick-theme.css" rel="stylesheet" type="text/css"
		  media="none" onload="if(media!='all')media='all'">
	<link href="<?= base_url() ?>/assets/front/v2/plugins/placeholder-loading/placeholder-loading.min.css"
		  rel="stylesheet" media="none" onload="if(media!='all')media='all'">
	<link href="<?= base_url() ?>/assets/front/v2/plugins/toastr/css/toastr.min.css" media="none" rel="stylesheet"
		  onload="if(media!='all')media='all'">

	<link href="<?= base_url(); ?>assets/front/plugins/swal2/sweetalert2.min.css" rel="stylesheet" type="text/css"
		  media="none" onload="if(media!='all')media='all'">

	<!-- CSS Mockup Device -->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/front/plugins/devicemockup/dist/device-mockups.css">

	<!-- Main CSS -->
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/front/v2/css/style.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/front/v2/css/responsive.css">

	<!-- Footer Special CSS -->
	<style>
		.icon-footer.if-fb {
			background-image: url("<?= base_url() ?>assets/front/v2/img/icon/footer-icon/fb.png");
		}

		.icon-footer.if-ig {
			background-image: url("<?= base_url() ?>assets/front/v2/img/icon/footer-icon/ig.png");
		}

		.icon-footer.if-wa {
			background-image: url("<?= base_url() ?>assets/front/v2/img/icon/footer-icon/wa.png");
		}

		.icon-footer.if-call {
			background-image: url("<?= base_url() ?>assets/front/v2/img/icon/footer-icon/call.png");
		}

		/*icon-materi*/
		<?php
        $materiStatus = ['', 'active', 'done'];
        foreach (iconMateri as $v1) {
            foreach ($materiStatus as $v2) {
                echo ".icon-materi.im-" . $v1;
                if ($v2 != "") {
                    echo "." . $v2;
                }
                echo "{background-image: url('" . base_url() . "assets/front/v2/img/icon/" . $v1;
                if ($v2 != "") {
                    echo "_" . $v2;
                }
                echo ".png');}";
            }
        }
        ?>.icon-materi.im-mlock {
			background-image: url("<?= base_url() ?>assets/front/v2/img/icon/materi_lock.png");
		}


		/*icon-jawab*/
		.icon-jawab.danger {
			background-image: url("<?= base_url() ?>assets/front/v2/img/icon/jawab_0.png");
		}

		.icon-jawab.success {
			background-image: url("<?= base_url() ?>assets/front/v2/img/icon/jawab_1.png");
		}


		/*icon-info*/
		.icon-info.ii-video {
			background-image: url("<?= base_url() ?>assets/front/v2/img/icon/info_video.png");
		}

		.icon-info.ii-video.active {
			background-image: url("<?= base_url() ?>assets/front/v2/img/icon/info_video_active.png");
		}

		.icon-info.ii-kuis {
			background-image: url("<?= base_url() ?>assets/front/v2/img/icon/info_kuis.png");
		}

		.icon-info.ii-kuis.active {
			background-image: url("<?= base_url() ?>assets/front/v2/img/icon/info_kuis_active.png");
		}

		.icon-info.ii-ujian {
			background-image: url("<?= base_url() ?>assets/front/v2/img/icon/info_ujian.png");
		}

		.icon-info.ii-ujian.active {
			background-image: url("<?= base_url() ?>assets/front/v2/img/icon/info_ujian_active.png");
		}

		.icon-info.ii-sertifikat {
			background-image: url("<?= base_url() ?>assets/front/v2/img/icon/info_sertifikat.png");
		}

		.icon-info.ii-sertifikat.active {
			background-image: url("<?= base_url() ?>assets/front/v2/img/icon/info_sertifikat_active.png");
		}
	</style>

	<!-- jQuery  -->
	<script type="text/javascript" src="<?= base_url() ?>/assets/front/v2/plugins/jquery.min.js"></script>

	<?php
	//OVERIDE MAIN CSS
	$lastfile = explode(".", $content);
	$lastfile = $lastfile[count($lastfile) - 1];

	$content_file = str_replace(".", "/", $content);

	if (file_exists('./application/views/front-v2/' . $content_file . '/' . $lastfile . '-css.php')) {
		$this->load->view('front-v2/' . $content_file . '/' . $lastfile . '-css');
	}

	?>


	<?php if (isset($_SESSION['siswaData']['id_user'])) {
		$_SESSION["idMapelBeli"] = $this->FrontAuthModel->getMapelUser();
	} ?>

</head>

<body class="disable-scroll">
<div id="loading">
	<div class="d-flex align-items-center justify-content-center" style="height:100%">
	<!-- <div class="loading-teks"> -->
		<!-- <i class="fa fa-spinner fa-pulse fa-4x"></i> -->
		<img class="loading-teks img-flip" src="<?php echo base_url()?>/assets/front/v2/img/logo.png" alt="" srcset="">
	<!-- </div> -->
	</div>
</div>
<?php if (isset($page) && $page != "login") : ?>
	<?php $this->load->view("front-v2/layout/navbar") ?>
<?php endif; ?>
<!-- Start content -->
<?php $this->load->view('front-v2' . "/" . $content_file . '/' . $lastfile) ?>
<!-- End content -->

<?php if (isset($page) && $page != "login") : ?>
	<?php $this->load->view("front-v2/layout/footer") ?>
<?php endif; ?>

<script>
	var resizefunc = [];
	var base_url = '<?= base_url(); ?>';
	var base_url_api = '<?= base_url('api/v1'); ?>';
</script>


<!-- App JS-->
<script type="text/javascript" src="<?= base_url() ?>/assets/front/v2/plugins/popper.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/front/v2/js/jquery.blockUI.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/front/v2/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/front/v2/plugins/slick/slick.min.js"></script>
<script type="text/javascript"
		src="<?= base_url() ?>/assets/front/v2/plugins/circle-progress/circle-progress.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/front/v2/plugins/loading/loadingoverlay.min.js"></script>
<script type="text/javascript"
		src="<?= base_url() ?>/assets/front/v2/plugins/jquery.lazy-master/jquery.lazy.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/front/v2/plugins/toastr/js/toastr.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/front/v2/plugins/ckeditor/ckeditor.js"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script> -->
<script src="<?= base_url(); ?>assets/front/plugins/swal2/sweetalert2.min.js"></script>
<script src="<?= base_url(); ?>assets/front/plugins/swal2/sweetalert2.all.min.js"></script>


<script>
	//INIT LOADING
	var loading = false;
	var loadingElement = $('#loading');

	//ANIMATE FLIP
	function loop(){
    $('.img-flip').animate({ textIndent: "+=360" },1, function(){
        $('.img-flip').animate({ textIndent: 0 }, {
          step: function(now,fx) {
            $(this).css('-webkit-transform','rotateY('+now+'deg)'); 
          },
            duration: 1000
        },'linear');
        loop()
    })
  }
  loop()

	// ALERT TOASTR
	toastr.options = {
		"debug": false,
		"newestOnTop": true,
		"progressBar": true,
		"positionClass": "toast-top-right",
		"preventDuplicates": true,
		"onclick": null,
		"showDuration": "300",
		"hideDuration": "500",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}

	//	Swal Bootstrap
	const swalBootstrap = Swal.mixin({
		customClass: {
			confirmButton: 'btn btn-success mx-2',
			cancelButton: 'btn btn-danger mx-2'
		},
		buttonsStyling: false
	});

	$(function () {
		navbarFixed();
		$('.lazy').Lazy();

		$('[data-toggle="tooltip"]').tooltip();

		classBg = $("body > *[class*='bg-ka-']:not(.navbar)").css("background-color")
		$("body").css("background-color", classBg)

		$('.circle-progress').each(function () {
			if ($(this).text().indexOf("100%") > -1) {
				$(this).addClass("text-white")
			} else {
				$(this).addClass("text-warning")
			}
		});

		$(".password-field+span").on('click', function (event) {
			event.preventDefault();
			iconElement = $(this).find("i");
			inputElement = $(this).prev();
			if (inputElement.attr("type") == "text") {
				inputElement.attr('type', 'password');
				iconElement.addClass("fa-eye-slash");
				iconElement.removeClass("fa-eye text-danger");
			} else if (inputElement.attr("type") == "password") {
				inputElement.attr('type', 'text');
				iconElement.removeClass("fa-eye-slash");
				iconElement.addClass("fa-eye text-danger");
			}
		});

		$(document).ajaxComplete(function () {
			$('#loading').delay(500).fadeOut();
		});
		$('#loading').delay(500).fadeOut();

		loading = false;

		$('body').removeClass("disable-scroll");
	});

	$(document).scroll(function () {
		navbarFixed();
	});
	$(document).resize(function () {
		navbarFixed();
	});

	$('.kelas-list').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		// speed: 10,
		adaptiveHeight: true,
		autoplay: true,
		autoplaySpeed: 20000,
		responsive: [{
			breakpoint: 960,
			settings: {
				speed: 300,
				slidesToShow: 2,
				slidesToScroll: 2
			}
		},
			{
				breakpoint: 768,
				settings: {
					speed: 300,
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}
		]
	});

	$(".cart-delete").on('click', function () {
		id = $(this).attr("data-target");
		$("#" + id).addClass("d-none");
	});

	$('.circle-progress').circleProgress({
		startAngle: -Math.PI / 4 * 2,
		lineCap: 'round',
		emptyFill: "#475774",
		size: 40,
		fill: "rgb(255,167,55)",
	}).on("circle-animation-progress",
			function (event, animationProgress, stepValue) {
				var instance = $(this).data("circle-progress");
				if (stepValue >= 0.9) {
					$(this).find("canvas").css({
						"border-radius": "100%",
						"box-shadow": "0 0 15px #FFA737"
					})
					$(this).find(".circle-progress-text").html("<i class='fa fa-check text-success' style='font-size:15px'></i>");
				}
			}
	);


	// FUNCTION
	$.blockUI.defaults.css = {};

	function navbarFixed() {
		if ($("nav.navbar").length) {
			heightNav = $("nav.navbar").height();
			if ($(window).scrollTop() > heightNav) {
				$("body>nav").addClass("fixed-top");
				$("body").css("margin-top", heightNav + "px");
			} else {
				$("body>nav").removeClass("fixed-top");
				$("body").css("margin-top", '');
			}
		}
	}

	function startLoadingElement(id = "", pesan = "<i class='fa fa-spinner fa-pulse'></i>") {
		if (id != "") {
			$(id).block({
				message: "<h1>" + pesan + "</h1>",
				css: {
					padding: "10px",
					textAlign: "center",
					color: "white"
				},
			});
		} else {
			$.blockUI({
				message: "<h1>" + pesan + "</h1>",
				css: {
					padding: "10px",
					color: "white"
				},
			});
		}
	}

	function stopLoadingElement(id = "") {
		if (id != "") {
			$(id).unblock();
		} else {
			$.unblockUI();
		}
	}

	function fancyTimeFormat(seconds) {
		const format = val => `0${Math.floor(val)}`.slice(-2)
		const hours = seconds / 3600
		const minutes = (seconds % 3600) / 60

		return [hours, minutes, seconds % 60].map(format).join(':')
	}

	function dateDifferent(start) {
		start = new Date(start);
		var end = new Date();
		var diff = new Date(end - start);

		var satuan = "hari yang lalu"

		// get days
		var days = diff / 1000 / 60 / 60 / 24;
		hasil = Math.floor(days) + " " + satuan
		if (days < 1) {
			days *= 24;
			satuan = "jam yang lalu"
			hasil = Math.floor(days) + " " + satuan

			if (days < 1) {
				days *= 60
				satuan = "menit yang lalu"
				hasil = Math.floor(days) + " " + satuan

				if (days < 1) {
					days = ""
					satuan = "Baru saja"
					hasil = satuan
				}
			}
		}
		return hasil;
	}

	function checkFile(src) {
		ext = src.substr((src.lastIndexOf('.') + 1));
		if (ext.length > 4) {
			return false;
		} else {
			return true;
		}
	}

	<?php $this->load->view("front-v2/layout/alert") ?>
</script>


<!-- Custom JS-->
<script type="text/javascript" src="<?= base_url() ?>/assets/front/v2/js/custom.js"></script>

<?php
if (file_exists('./application/views/front-v2/' . $content_file . '/' . $lastfile . '-js.php')) {
	$this->load->view('front-v2/' . $content_file . '/' . $lastfile . '-js');
}
?>

</body>

</html>
