<?php
// INIT

// HARGA
$hargaAsli = $valueMapel["harga_basic"];
$diskon = $valueMapel["diskon_basic"] ? $valueMapel["diskon_basic"] : 75;
// BUTTON
$status = "BELI KELAS ONLINE";
$statusBtn = "success";
$link = base_url("login");
$linkDetail = base_url("kursus/detail/" . $valueMapel["meta_link_mapel"]);
$linkBeli = $valueMapel["status_gratis"] == 1 ? base_url("beli-gratis/" . $valueMapel["meta_link_mapel"]) : base_url("beli/" . $valueMapel["meta_link_mapel"]);
$linkLogin = base_url("belajar/" . $valueMapel["meta_link_mapel"]);

$decoy = hargaDiskon($hargaAsli, $diskon);

//Jika rating kosong
$uniqueNumberMapel = $valueMapel["id_mapel"];
$valueMapel["rating_rata"] = isset($valueMapel["rating_rata"]) ? $valueMapel["rating_rata"] : 4 + ($valueMapel["id_mapel"][0] / 10);
$valueMapel["rating_jumlah"] = isset($valueMapel["rating_jumlah"]) ? $valueMapel["rating_jumlah"] : 300 + (int)substr($uniqueNumberMapel, 0, 2);

// HARGA
if ($valueMapel["status_gratis"] == 0) {
	$hargaAsli = rupiahTanpa0($hargaAsli);
} else {
	$diskon = 100;
	$hargaAsli = "Gratis!";
	$statusBtn = "info";
	$status = "AMBIL KELAS ONLINE";
}

// BUTTON
//Bedakan antara Siswa dan Admin
if ($this->session->userdata("siswaData")) {
	$link = $linkBeli;
	if (in_array($valueMapel["id_mapel"], $_SESSION["idMapelBeli"]) == true) {
		$status = "LANJUTKAN";
		$statusBtn = "warning";
		$linkDetail = $link = $linkLogin;
	}
}
?>

<div class="kelas-item align-items-stretch col clone-data" id="clone-data-<?= $idClone ?>">
	<div class="card w-100">
		<a href=" <?= $linkDetail ?>" class="link-detail">
			<div class="card-gambar lazy" data-src="<?= base_url("upload/banner_mapel/{$valueMapel["banner_mapel"]}") ?>" style="height: 260px; background-image:url(<?= base_url("upload/banner_mapel/{$valueMapel["banner_mapel"]}") ?>);">
				<div class="row px-3">
					<div class="col p-1 status-webinar">
						<?php
						if ($valueMapel["status_webinar"] == 1) { ?>
							<div class="kelas-jenis badge badge-pill">Webinar</div>
						<?php } ?>
					</div>
				</div>

				<div class="alert-container">
					<?php
					if ($valueMapel["alert_text"] != "") { ?>
						<div class="card-alert bg-<?= $valueMapel["alert_class"] ?> text-center">
							<?= $valueMapel["alert_text"] ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</a>
		<div class="card-body">
			<div class="card-text d-flex flex-column">
				<div class="row mb-0">
					<div class="col">
						<div class="kelas-title font-weight-bold line-limit-3">
							<a href="<?= $linkDetail ?>" class="nama-mapel">
								<?= $valueMapel["nama_mapel"] ?>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>