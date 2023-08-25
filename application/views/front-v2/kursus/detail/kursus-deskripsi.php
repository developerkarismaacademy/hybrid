<?php
//Jika rating kosong
$uniqueNumberMapel = $mapel["id_mapel"];
$mapel["rating_rata"] = isset($mapel["rating_rata"]) ? $mapel["rating_rata"] : 3 + $mapel["id_mapel"][0] / 10;
$mapel["rating_jumlah"] = isset($mapel["rating_jumlah"]) ? $mapel["rating_jumlah"] : 300 + (int) substr($uniqueNumberMapel, 0, 2);
?>

<?php
// INIT

// HARGA
$hargaAsli = $mapel["harga_basic"];
$diskon = $mapel["diskon_basic"];

$mapelIdPrakerja = 122171;

// BUTTON
$status = "BELI KELAS";
$statusBtn = "success";
$link = base_url("login");
$linkUser = base_url("beli/{$mapel["meta_link_mapel"]}");
$linkLanjut = base_url("belajar/" . $mapel["meta_link_mapel"]);
$linkGamification = base_url("gamification/beli-kelas");

// HARGA
if ($mapel["status_gratis"] == 0) {
	$decoy = hargaDiskon($hargaAsli, $diskon);

	$hargaAsli = rupiahTanpa0($hargaAsli);
} else {
	$decoy = hargaDiskon($hargaAsli, $diskon);
	$diskon = 100;
	$hargaAsli = "Gratis!";

	$statusBtn = "warning";
	$status = "AMBIL KELAS";
}
// BUTTON
if ($this->session->siswaData != NULL) {
	$link = $linkUser;
	if ($mapel['id_mapel'] == $mapelIdPrakerja) {
		$link = $linkGamification;
	}
	if (in_array($mapel["id_mapel"], $_SESSION["idMapelBeli"]) == true) {
		$status = "LANJUTKAN";
		$statusBtn = "warning";
		$linkUser = $link = $linkLanjut;
	}
}


?>

<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>
<!--KURSUS HEAD-->
<section id="kursus-head"
	style="background: url('<?= base_url("upload/mapel/" . $mapel["gambar_mapel"]) ?>');background-size: cover; background-position: center;">
	<div class="box">
		<div class="container h-100 d-flex align-items-center" style="color: white;">
			<!--MINI NAVIGASI-->
			<div class="col-12 col-md-9 order-1 order-md-2 mb-2 mb-md-0 ">
				<div class="row my-3 mt-5">
					<div class="col">
						<h1 class="" title="<?= $mapel["nama_mapel"] ?>">
							<strong><b>
									<?= $mapel["nama_mapel"] ?>
								</b></strong>
						</h1>
					</div>
				</div>
				<div class="row">
					<div class="col-10 col-md-11 mt-3" style="font-size: large;">
						<?php
						if (strlen($mapel["shortdesc_mapel"]) <= 0) {
							$mapel["shortdesc_mapel"] = "Materi \"{$mapel['nama_mapel']}\" ini terdiri dari {$bab['total']} sesi. Ikuti kelas {$mapel["nama_kelas"]} lainnya untuk melengkapi kemampuan anda!";
							$mapel["nama_kelas"];
						}
						?>
						<?= $mapel["shortdesc_mapel"] ?>
					</div>
					<div class="col-8 col-lg-4 mb-5 mt-5" data-toggle="modal" data-target="#vidModal">
						<ul>
							<li>
								<a class="nav-link btn btn-warning font-weight-large pt-2" style="border-radius: 0; ">
									<span class="fa fa-play fa-stack "></span>
									<span>Lihat Video</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>

</section>

<!--KURSUS DESKRIPSI-->

<?php
$fasilitas = [
	"video" => [
		0,
		"video.png",
		"Video",
	],
	"ebook" => [
		0,
		"ebook.png",
		"E-Book",
	],
	"kuis" => [
		0,
		"kuis-ujian.png",
		"Kuis",
	],
	"praktek" => [
		0,
		"praktek.png",
		"Penugasan Portofolio / Tugas Akhir",
	],
	// "Sertifikat" => "sertifikat.png",
];
if ($bab["total"] > 0) {
	$i = 0;
	foreach ($bab["data"] as $keyBab => $valueBab) {
		if ($valueBab["materi"]["total"] > 0) {
			foreach ($valueBab["materi"]["data"] as $keyMateri => $valueMateri) {
				if ($valueMateri["tipe"] == "video") {
					$fasilitas["video"][0]++;
				} elseif ($valueMateri["tipe"] == "pilihan") {
					$fasilitas["kuis"][0]++;
				} elseif ($valueMateri["tipe"] == "praktek") {
					$fasilitas["praktek"][0]++;
				} else {
					$fasilitas["ebook"][0]++;
				}
			}
		}
		$i++;
	}
}
?>
<section id="kursus-deskripsi" class=" bg-ka-grey">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-lg-12 mt-5" <?= $listhasil['total'] > 0 ? 'style="margin-bottom : 200px;"' : '' ?>>
				<div class="bg-ka-grey">
					<div class="p-3">
						<div class="row mb-0 mb-sm-3 ">
							<div class="col-12 col-lg-6">
								<?php
								if (strip_tags($mapel['deskripsi_mapel']) == "" || strip_tags($mapel['deskripsi_mapel']) == "-") {
									$mapel["deskripsi_mapel"] = "Materi \"{$mapel['nama_mapel']}\" ini terdiri dari {$bab['total']} sesi. Dengan beberapa Ikuti kelas {$mapel["nama_kelas"]} lainnya untuk melengkapi kemampuan anda!";
									$mapel["nama_kelas"];
								}
								?>
								<div class="mb-3">
									<h2 class="mb-3"><b>Kelas Apa Ini?</b></h2>
									<?= $mapel['deskripsi_mapel'] ?>
								</div>
								<div class="container-fluid d-block d-md-none ">
									<div class="row font-weight-light align-items-stretch h5 h-100">
										<?php
										foreach ($fasilitas as $key => $item) {
											if ($item[0] > 0) {
												?>
												<div class="col-6 col-xl-3 px-0 py-1 text-center ">
													<div class="box-class h-100">
														<div
															style="background-image: url('<?= base_url() ?>assets/front/v2/img/icon-detail/<?= $item[1] ?>')">
														</div>
														<h6 class="text-center mb-0">
															<?php
															echo $item[0] . " " . $item[2];
															?>
														</h6>
													</div>
												</div>
												<?php
											}
										}
										?>
									</div>
								</div>
							</div>

							<div class="col-6 col-lg-6 mb-5 pb-5">
								<div class="sticky-top d-none w-75 ml-auto px-3 d-md-flex" style="padding-top: 15vh">
									<div class="card py-0">
										<img class="card-img-top h-25"
											style="background: url('<?= base_url("upload/mapel/" . $mapel["gambar_mapel"]) ?>'); width: 100%; height: 100%; background-size: cover; background-position: center;">
										<div class="bg-white">
											<div class="card-body">
												<h5 class="my-3 card-title" title="<?= $mapel["nama_mapel"] ?>">
													<b>
														<?= $mapel["nama_mapel"] ?>
													</b>
												</h5>
												<?php if ($mapel['id_mapel'] != $mapelIdPrakerja): ?>
													<div class="">
														<div class=" mr-2">
															<span class="badge badge-pill badge-danger">
																<?= $diskon . "%" ?>
															</span>
															<span class="text-line-through">
																<?= rupiahTanpa0($decoy) ?>
															</span>
														</div>
														<div class="h6 m-0 font-weight-bold">
															<?= $hargaAsli ?>
														</div>
													</div>
												<?php else: ?>
													<div class="">
														<div class="h6 m-0 font-weight-bold">
															<img src="<?= base_url('assets/front/') ?>img/ic-coin.png"
																alt="Coin" width="30px" height="30px"> 600
														</div>
													</div>
												<?php endif; ?>
												<a class="btn btn-light text-dark btn-block btn-bought my-3 mx-auto w-100 rounded-pill bg-warning"
													href="<?= $link ?>">
													<b>
														<?= $status ?>
													</b>
												</a>
												<ul class="list-group list-group-flush">
													<h6>Program ini sudah termasuk</h6>
													<li class="list-group-item p-0 pl-2">
														<?php
														foreach ($fasilitas as $key => $item) {
															if ($item[0] > 0) {
																?>
																<div class="col-12 px-0 py-1">
																	<div class="box-class d-flex align-items-center h-100 m-0 p-0"
																		style="border: 0">
																		<div class="w-25 m-0"
																			style="background-size: 35%; background-image: url('<?= base_url() ?>assets/front/v2/img/icon-detail/<?= $item[1] ?>')">
																		</div>
																		<h6 class="mb-0">
																			<?php
																			echo $item[0] . " " . $item[2];
																			?>
																		</h6>
																	</div>
																</div>
																<?php
															}
														}
														?>
													</li>

												</ul>

											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>