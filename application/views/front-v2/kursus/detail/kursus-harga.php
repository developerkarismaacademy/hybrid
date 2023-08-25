<?php
// INIT

// HARGA
$hargaAsli = $mapel["harga_basic"];
$diskon = $mapel["diskon_basic"];
// BUTTON
$status = "BELI KELAS";
$statusBtn = "success";
$link = base_url("login");
$linkUser = base_url("beli/{$mapel["meta_link_mapel"]}");
$linkLanjut = base_url("belajar/" . $mapel["meta_link_mapel"]);

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
	if (in_array($mapel["id_mapel"], $_SESSION["idMapelBeli"]) == true) {
		$status = "LANJUTKAN";
		$statusBtn = "warning";
		$linkUser = $link = $linkLanjut;
	}
}
?>
<section id="harga" class="py-0 pt-2 d-md-none d-block">
	<div class="container py-0">
		<div class="row align-items-center">
			<div class="col-3 col-lg-2 d-none">
				<div class="btn btn-outline-light">
					<i class="fa fa-heart" style="font-size:12px;"></i>
				</div>
			</div>
			<div class="d-none d-lg-block col-lg-3"></div>
			<div class="col col-lg-5 harga">
				<div class="row">
					<div class="col font-weight-bold">
						<div class="row align-items-center">
							<div class="col-5 col-md-6 col-xl-8 text-left text-lg-right">
								Total Harga
							</div>
							<div class="col harga text-right">
								<div class="col-12">
									<div class="harga-asli small">
										<div class="row no-gutter d-flex align-items-center"> 
											<span class="text-line-through mr-2">
												<span class="badge badge-pill badge-danger">
													<?= $diskon . "%" ?>
												</span>
												<?= rupiahTanpa0($decoy) ?>
											</span>
											<span class="h6 m-0 font-weight-bold ">
												<?= $hargaAsli ?>
											</span>
										</div>  
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-lg-2 my-3"> 
				<a class="btn btn-light text-dark btn-block btn-bought" href="<?= $link ?>">
					<b><?= $status ?></b>
				</a>
			</div>
		</div>
	</div>
</section>
