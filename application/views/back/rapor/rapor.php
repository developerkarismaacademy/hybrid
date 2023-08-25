
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
    <title>
    <?php 
    //$title 
    ?> 
    Kursus Online | Karisma Academy</title>

	<!--  Font-->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
	<!-- App css -->
	<link rel="stylesheet" type="text/css"
		  href="<?= base_url(); ?>assets/front/plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css"
		  href="<?= base_url(); ?>assets/front/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" type="text/css"
		  href="<?= base_url(); ?>assets/front/plugins/themify-icons/themify-icons.css">

	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/front/css/custom.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/front/css/style.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/front/css/responsive.css">

	<!-- jQuery  -->
	<script type="text/javascript" src="<?= base_url(); ?>assets/front/plugins/jquery.min.js"></script>

    <!-- <style>
       @page{
        size: 8.5in 11in; /* <length>{1,2} | auto | portrait | landscape */
	      /* 'em' 'ex' and % are not allowed; length values are width height */
	margin: 10%; /* <any of the usual CSS values for margins> */
	             /*(% of page-box width for LR, of height for TB) */
	margin-header: 5mm; /* <any of the usual CSS values for margins> */
	margin-footer: 5mm; /* <any of the usual CSS values for margins> */
	marks: /*crop | cross | none*/
	header: html_myHTMLHeaderOdd;
	footer: html_myHTMLFooterOdd;
       }
    </style>
  -->
</head>

<?php
$nilai = 80;
$kompetensi = null;
if ($kompetensi > 0) {
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
        <div class="col text-right">
            <p>Tgl Uji Kompetensi</p>
            <p><b>12 / 06 / 2020</b></p>
            
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
						<div class="progress-bar praktik" role="progressbar" style="width: 75%"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-md-3">Nilai Akhir Kompetensi</div>
				<div class="p-0 col">
					<div class="progress">
						<div class="progress-bar akhir" role="progressbar" style="width: 95%"></div>
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
                //manggil data
				$nilai = 70;
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

                <tr>
                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</td>
                    <td>87</td>
                </tr>
                <tr>
                    <td>Nulla eget ex et massa accumsan pharetra.</td>
                    <td>75</td>
                </tr>
              
                <tr>
                    <td>Donec dapibus diam nec nibh iaculis molestie.</td>
                    <td>95</td>
                </tr>
                <tr>
                    <td>Fusce et augue aliquet, molestie turpis nec, ultricies nisl.</td>
                    <td>65</td>
                </tr>
                <tr>
                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</td>
                    <td>87</td>
                </tr>
                <tr>
                    <td>Nulla eget ex et massa accumsan pharetra.</td>
                    <td>75</td>
                </tr>
              
                <tr>
                    <td>Donec dapibus diam nec nibh iaculis molestie.</td>
                    <td>95</td>
                </tr>
          

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
				<h2>85</h2>
			</div>
			<div class="nilai-akhir">
				Nilai Akhir
				<h2>90</h2>
			</div>
		</div>
	</div>

</div>

<div class="footer container">
<div class="container">
  <div class="row">
    <div class="col-8">
    <table>
        <tr><td><img src="<?= base_url();?>\assets\back\images\LogoBaru-06b.png" width="350px" height="100px"></td></tr>
        <tr><td>Jl. Watu Gong No.18 Kota Malang 03412995599 <br> www.karismaacademy.com</td></tr>
    </table>
    </div>
    <div class="col-4 text-right">
        <!-- <h5 class="float-left mt-4"><b>DINAS PENDIDIKAN<br>PEMERINTAH KOTA MALANG</b></h5>
        <img width="70px" height="70px" src="https://upload.wikimedia.org/wikipedia/commons/e/ef/Logo_Kota_Malang_color.png"> -->
        <table>
            <tr>
                <td><h5 class="float-left mt-4 mr-2"><b>DINAS PENDIDIKAN<br>PEMERINTAH KOTA MALANG</b></h5></td>
                <td><img width="70px" height="70px" src="https://upload.wikimedia.org/wikipedia/commons/e/ef/Logo_Kota_Malang_color.png"></td>
            </tr>
        </table>
    </div>
  </div>
</div>
		
</div>


<!-- App js -->


</body>

</html>
