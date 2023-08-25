<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description"
		  content="Kursus online untuk keahlian Web, Office, Sipil, dan lain lain! Khusus di Karisma Academy">
	<meta name="author" content="Karisma Academy">


	<meta property="fb:app_id" content="494119254101706"/>
	<meta property="fb:admins" content="karismaacademy"/>
	<!-- Google Login -->
	<meta name="google-signin-client_id"
		  content="128649138906-sjpv7krn52d6b2qrs9h4b2qpddns3nle.apps.googleusercontent.com">

	<!-- App favicon -->
	<link rel="shortcut icon" href="<?= base_url(); ?>assets/front/v2/img/favicon-2.svg">
	<!-- App title -->
	<title><?= $title ?> Kursus Online | Karisma Academy</title>

	<!--  Font-->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
	<!-- App css -->
	<link rel="stylesheet" type="text/css"
		  href="<?= base_url(); ?>assets/front/plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css"
		  href="<?= base_url(); ?>assets/front/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" type="text/css"
		  href="<?= base_url(); ?>assets/front/plugins/themify-icons/themify-icons.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/front/plugins/file-upload/file-upload.css">
	<link rel="stylesheet" type="text/css"
		  href="<?= base_url(); ?>assets/front/plugins/customscrollbar/css/jquery.mCustomScrollbar.min.css">
	<link href="<?= base_url(); ?>/assets/front/plugins/aos/aos.css" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/front/css/custom.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/front/css/style.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/front/css/responsive.css">

	<!-- jQuery  -->
	<script type="text/javascript" src="<?= base_url(); ?>assets/front/plugins/jquery.min.js"></script>

</head>

<?php
$nilai = 0;
if ($kompetensi["total"] > 0) {
	foreach ($kompetensi["data"] as $keyKompetensi => $valueKompetensi) {

		$nilai += $valueKompetensi["nilai"];
	}

	$nilai = ceil($nilai / 3);
}

?>

<body>
<!-- Begin page -->
<div id="fb-root"></div>
<script async defer crossorigin="anonymous"
		src="https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v4.0&appId=803352660059300&autoLogAppEvents=1"></script>
<div class="container hasil-akhir" style="margin-top: 0;">
	<div class="row">
		<div class="col-12 text-center">
			<h1>Form Transkip Nilai SKETCHUP</h1>
			<p>No. 421.9/4161/35.73.307/2013 - Karisma Academy Malang</p>
			<p>No. Sertifikat 101598618</p>
		</div>
	</div>

	<!-- Row one -->
	<div class="row wrap-biodata">
		<div class="col-9">
			<table class="w-100">
				<tbody>
				<tr>
					<td>No. Peserta</td>
					<td>351</td>
				</tr>
				<tr>
					<td>Nama Peserta</td>
					<td>Laras</td>
				</tr>
				<tr>
					<td>Tempat / Tanggal Lahir</td>
					<td>Malang, 22 April 2020</td>
				</tr>
				</tbody>
			</table>
		</div>
		<!--		<div class="col-3">-->
		<!--			Tgl Uji Kompetensi-->
		<!--			<b>03 / 02 / 2020</b>-->
		<!--		</div>-->
	</div>
	<!-- Row two -->
	<div class="row wrap-progress">
		<div class="col-12">
			<div class="row">
				<div class="col-12 col-md-3 mb-3 mb-md-0"><b>Nilai Kompetensi</b></div>
				<div class="col d-none d-sm-block p-0 text-right">10</div>
				<div class="col d-none d-sm-block p-0 text-right">20</div>
				<div class="col d-none d-sm-block p-0 text-right">30</div>
				<div class="col d-none d-sm-block p-0 text-right">40</div>
				<div class="col d-none d-sm-block p-0 text-right">50</div>
				<div class="col d-none d-sm-block p-0 text-right">60</div>
				<div class="col d-none d-sm-block p-0 text-right">70</div>
				<div class="col d-none d-sm-block p-0 text-right">80</div>
				<div class="col d-none d-sm-block p-0 text-right">90</div>
				<div class="col d-none d-sm-block p-0 text-right">100</div>
			</div>
			<div class="row">
				<div class="col-12 col-md-3">Uji Kompetensi Latihan</div>
				<div class="p-0 col">
					<div class="progress">
						<div class="progress-bar teori" role="progressbar" style="width: <?= $nilai ?>%"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-md-3">Uji Kompetensi Praktik</div>
				<div class="p-0 col">
					<div class="progress">
						<div class="progress-bar praktik" role="progressbar" style="width: 0%"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-md-3">Nilai Akhir Kompetensi</div>
				<div class="p-0 col">
					<div class="progress">
						<div class="progress-bar akhir" role="progressbar" style="width: 0%"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Row three -->
	<div class="row wrap-penjelasan">
		<div class="col-12 col-md-9">
			<b class="mb-3 d-block">Analisis Kompetensi</b>

			<table class="table table-striped">

				<tbody>
				<?php
				$nilai = 0;
				if ($kompetensi["total"] > 0) {
					foreach ($kompetensi["data"] as $keyKompetensi => $valueKompetensi) {
						?>
						<tr>
							<td><?= $valueKompetensi["kompetensi"] ?></td>
							<td><?= $valueKompetensi["nilai"] ?></td>
						</tr>
						<?php
					}

				}
				?>
				</tbody>
			</table>
		</div>
		<div class="col-12 col-md-3">
			<div class="nilai-teori ">
				Latihan
				<h2><?= $nilai ?></h2>
			</div>
			<div class="nilai-praktik">
				Praktik
				<h2>0</h2>
			</div>
			<div class="nilai-akhir">
				Nilai Akhir
				<h2>0</h2>
			</div>
		</div>
	</div>

</div>


<script>
	var resizefunc = [];
	var base_url = '<?= base_url(); ?>';
	var base_url_api = '<?= base_url('api/v1'); ?>';
</script>

<script type="text/javascript" src="<?= base_url(); ?>assets/front/plugins/popper.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/front/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/front/plugins/file-upload/file-upload.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/front/plugins/parallax/parallax.min.js"></script>
<script type="text/javascript"
		src="<?= base_url(); ?>assets/front/plugins/customscrollbar/js/jquery.mCustomScrollbar.min.js"></script>
<script src="<?= base_url() ?>/assets/front/plugins/aos/aos.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/front/js/myscript.js"></script>

<!-- App js -->


</body>

</html>
