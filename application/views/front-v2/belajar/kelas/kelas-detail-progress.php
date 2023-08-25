<?php
$materiVideo = 0;
$materiKuis = 0;
if ($bab["total"] > 0) {
	$i = 0;
	foreach ($bab["data"] as $keyBab => $valueBab) {
		if ($valueBab["materi"]["total"] > 0) {
			foreach ($valueBab["materi"]["data"] as $keyMateri => $valueMateri) {

				if ($valueMateri["tipe"] == "video") {
					$materiVideo++;
				} elseif ($valueMateri["tipe"] == "pilihan" || $valueMateri["tipe"] == "praktek") {
					$materiKuis++;
				}
			}
		}
		$i++;
	}
}
?>

<section id="kelas-detail">
	<div class="container py-3">
		<div class="row justify-content-center">
			<div class="col-12">
				<div class="card">
					<!--MINI NAVIGASI-->
					<?php
					$this->load->view("front-v2/belajar/kelas/kelas-mini-navigasi")
					?>
					<div class="card-img-top">
						<div class="row no-gutter">
							<div class="col" id="intro">
								<div id="player" data-plyr-provider="youtube"
									 data-plyr-embed-id="<?= $mapel["intro_video"] ? $mapel["intro_video"] : "8o2rCqOxpHY" ?>">
								</div>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="row no-gutters kelas-jenis  text-center mb-3">
							<div class="btn btn-outline-ka-dark btn-no-hover btn-rounded">
								<span class="icon-info ii-video"></span>
								<?= $materiVideo ?> Video
							</div>
							<div class="btn btn-outline-ka-dark btn-no-hover btn-rounded">
								<span class="icon-info ii-kuis"></span>
								Sertifikat
							</div>
							<div class="btn btn-outline-ka-dark btn-no-hover btn-rounded">
								<span class="icon-info ii-ujian"></span>
								<?= $materiKuis ?> Kuis
							</div>
							<div class="btn btn-outline-ka-dark btn-no-hover btn-rounded">
								<span class="icon-info ii-sertifikat"></span>
								Ujian
							</div>
						</div>
						<div class="row mb-3 card-title">
							<div class="col">
								<h4 class="card-title"><b><?= $mapel["nama_mapel"] ?></b></h4>
								<div class="small">oleh <span
											class="text-warning"><?= $mapel["nama_instruktur"] ?></span></div>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col">
								<?= $mapel["nama_mapel"] ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section id="kelas-progress">
	<div class="container py-3">
		<div class="row justify-content-center">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="row mb-3">
							<div class="col">
								<?php
								$dummyprogress = $mapel["progress"] != "" ? $mapel["progress"] : 0;
								?>
								<div class="mb-3">
									Progress Materi <span
											class="float-right h5"><b><?= $dummyprogress ?>%</b></span>
								</div>

								<div class="progress">
									<div class="progress-bar bg-warning" role="progressbar"
										 style="width: <?= $dummyprogress ?>%" aria-valuenow="<?= $dummyprogress ?>"
										 aria-valuemin="0" aria-valuemax="100">
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
