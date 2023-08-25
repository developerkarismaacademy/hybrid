<?php

if (isset($mapel)) {
	// INIT
	// HARGA
	$hargaAsli = $mapel["harga_basic"];
	$diskon = $mapel["diskon_basic"];

	$decoy = hargaDiskon($hargaAsli, $diskon);
	// HARGA
	if ($mapel["status_gratis"] == 0) {
		$hargaAsli = $hargaAsli;
	} else {
		$diskon = 100;
		$hargaAsli = 0;
	}


	$jmlTransaksi = 0;
	$total = 0;
	$potonganpembelian = 0;


	if (isset($voucher) && count($voucher) > 0 && $mapel["harga_basic"] >= $voucher["minimal_transaksi"]) {
		if ($voucher["jenis_voucher"] == "pembelian") {
			if ($voucher["jenis_potongan"] == "nominal") {
				$potonganpembelian = $voucher["jumlah_potongan"];
			} else {
				$potonganpembelian = $total * $voucher["jumlah_potongan"] / 100;
			}
		}
	}
}


?>

<div class="fill bg-ka-grey">
	<section id="keranjang">
		<div class="container pt-0">
			<!--MINI NAVIGASI-->
			<div class="row navigate-text">
				<div class="col-0 ml-3 position-absolute float-left" style="z-index:2;">
					<a href="<?= base_url() ?>">
						<i class="fa fa-arrow-left text-warning"></i> Kembali
					</a>
				</div>
			</div>
			<div class="row">
				<?php
				if (isset($mapel)) { ?>

					<div class="col-12 order-2 order-lg-1 col-lg-8" id="keranjang-left">

						<div class="card mt-4" id="cart-materi">
							<!--						<a href="#" class="cart-delete" data-target="cart-materi"></a>-->
							<a href="<?= base_url('kursus/detail/' . $mapel["meta_link_mapel"]) ?>">
								<div class="card-body">
									<div class="row p-3 pb-0">
										<div class="col-12 col-md-4 order-2 order-md-1"
											 style="background-image:url('<?= base_url('upload/banner_mapel/' . $mapel["banner_mapel"]) ?>'); height:150px;
													 background-size: contain;
													 background-repeat: no-repeat;
													 background-position: top;">
										</div>
										<div class="col-12 col-md-8 order-1 order-md-2 mb-2 mb-md-0">
											<div class="row d-flex">
												<div class="col">
													<h6 class="text-truncate" title="<?= $mapel["nama_mapel"] ?>">
														<b><?= $mapel["nama_mapel"] ?></b>
													</h6>
												</div>
											</div>
											<div class="row d-flex">
												<div class="col harga d-flex align-items-top">
													<div class="col-12 p-0">
														<span class="harga-asli small">
															<span class="badge badge-pill badge-danger">
																<?= $diskon . "%" ?>
															</span>
															<span class="text-line-through">
																<?= rupiahTanpa0($decoy) ?>
															</span>
														</span>
														<span class="px-2"></span>
														<span class="harga-diskon text-warning h4">
															<b>
																<?= rupiahTanpa0($hargaAsli) ?>
															</b>
														</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</a>
							<div class="card card-with-title">
								<div class="card-body">
									<div class="card-title">
										<b>Metode Pembayaran</b>
									</div>

									<div class="card-text">
										<?php foreach (metode_bayar as $keyBayar => $valueBayar) {
											?>
											<div class="container-fluid border my-3">
												<div class="row py-2 border-bottom">
													<div class="col text-md-left text-center">
														<b><?= $valueBayar ?></b>
													</div>
												</div>
												<div class="row text-center no-gutters" style="margin:0 -15px;">
													<?php foreach (payment[$keyBayar] as $keyPayment => $valuePayment) {
														?>
														<div onclick="pilihBank('<?= $keyPayment ?>')"
															 class="radio-hidden col-4">
															<input class="" type="radio" name="payment"
																   id="payment-<?= $keyPayment ?>"
																   value="payment-<?= $keyPayment ?>">
															<label class=" py-4 w-100"
																   for="payment-<?= $keyPayment ?>">
																<img src="<?= base_url() ?>assets/front/images/payment_icon/<?= $keyPayment ?>.png"
																	 alt="<?= $valuePayment ?>"
																	 class="img-fluid px-5">
															</label>
														</div>
														<?php
													} ?>
												</div>
											</div>


											<?php
										} ?>

<!--										<div class="row hidden">-->
<!--											<div class="col">-->
<!--												<p>-->
<!--													Untuk kemudahan dan mempercepat proses verifikasi pembayaran,-->
<!--													harap-->
<!--													lakukan-->
<!--													pembayaran dengan nominal unik tiga angka terakhir, misalnya Rp.-->
<!--													200.-->
<!--													468-->
<!--												</p>-->
<!--											</div>-->
<!--										</div>-->
									</div>
								</div>
							</div>
						</div>
						</a>
					</div>

					<div class="col-12 order-1 order-lg-2 col-lg-4 pb-4" id="keranjang-right">
						<div class="card mt-4">
							<div class="card-body">
								<div class="row">
									<div class="col h2 font-weight-bold">
										Ringkasan
										<div class="text-warning">Pembayaran</div>
									</div>
								</div>
								<div class="row">
									<!--								<div class="col small">-->
									<!--									Diskon-->
									<!--								</div>-->
									<div class="col text-right">
										<div class="harga-asli">
											<!--										<span class="badge badge-pill badge-danger">-->
											<!--											25%-->
											<!--										</span>-->
											<!--										<span class="text-line-through">-->
											<!--											Rp 275.000-->
											<!--										</span>-->
										</div>
									</div>
								</div>
								<!--							<div class="row">-->
								<!--								<div class="col small">-->
								<!--									Paket-->
								<!--								</div>-->
								<!--								<div class="col text-right">-->
								<!--									<div class="harga-paket">-->
								<!--										Rp 150.000-->
								<!--									</div>-->
								<!--								</div>-->
								<!--							</div>-->
								<div class="row">
									<div class="col small">
										Total Harga
									</div>
									<div class="col text-right">
										<h4 class="harga-diskon">
											<b>
												<?= rupiahTanpa0($hargaAsli) ?>
											</b>
										</h4>
									</div>
								</div>

								<?php
								if (isset($voucher) && count($voucher) > 0 && $mapel["harga_basic"] >= $voucher["minimal_transaksi"]) {
									$potongan = 0;

									if ($voucher["jenis_voucher"] == "item") {
										if ($voucher["jenis_item"] == "semua") {
											if ($mapel["harga_basic"] > $voucher["minimal_harga_item"]) {

												if ($voucher["jenis_potongan"] == "nominal") {
													$potongan = $voucher["jumlah_potongan"];
												} else {
													$potongan = $mapel["harga_basic"] * $voucher["jumlah_potongan"] / 100;
												}
											}
										} elseif ($voucher["jenis_item"] == "kategori") {
											$kategori = explode(",", $voucher["kategori_id"]);

											if (in_array($mapel["kelas_id"], $kategori)) {
												if ($mapel["harga_basic"] > $voucher["minimal_harga_item"]) {

													if ($voucher["jenis_potongan"] == "nominal") {
														$potongan = $voucher["jumlah_potongan"];
													} else {
														$potongan = $mapel["harga_basic"] * $voucher["jumlah_potongan"] / 100;
													}
												}
											}
										} elseif ($voucher["jenis_item"] == "item_tertentu") {
											$kategori = explode(",", $voucher["item_id"]);

											if (in_array($mapel["id_mapel"], $kategori)) {
												if ($mapel["harga_basic"] > $voucher["minimal_harga_item"]) {

													if ($voucher["jenis_potongan"] == "nominal") {
														$potongan = $voucher["jumlah_potongan"];
													} else {
														$potongan = $mapel["harga_basic"] * $voucher["jumlah_potongan"] / 100;
													}
												}


											}
										}

										?>
										<div class="row">
											<div class="col small">
												Potongan(<?= $voucher["kode_voucher"] ?>)
											</div>
											<div class="col text-right">
												<h4 class="harga-diskon text-danger">
													<b>
														- <?= rupiahTanpa0($potongan) ?>
													</b>
												</h4>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col small">
												Total Bayar
											</div>
											<div class="col text-right">
												<h4 class="harga-diskon">
													<b>
														<?= rupiahTanpa0($mapel["harga_basic"] - $potongan) ?>
													</b>
												</h4>
											</div>
										</div>
										<?php
									}
								}


								?>

								<div class="row">
									<div class="col-12">
										<a id="btnCheckout" class="btn btn-warning btn-block btn-rounded p-2"
										   href="javascript:alertTransaksi();">CHECKOUT</a>
									</div>
									<div class="col-12">
										<div class="small py-2">Punya Kode Promo?</div>
										<form>
											<div class="input-group" bis_skin_checked="1">
												<input name="voucher" id="voucher" type="text"
													   class="form-control form-rounded text-uppercase"
													   placeholder="Masukkan Kode Promo">
												<div class="input-group-prepend" bis_skin_checked="1">
													<input type="submit" class="form-control form-rounded btn btn-info"
														   value="Gunakan">
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>


					<?php
				} else { ?>
					<div class="col-12">
						<div class="card w-100 text-white bg-primary my-3">
							<div class="card-header">Perhatian</div>
							<div class="card-body">
								<h5 class="card-title">Anda belum membeli apapun!</h5>
								<p class="card-text">Silahkan cek <a class="font-weight-bold text-dark	"
																	 href="<?= base_url() ?>#pilih-kelas">halaman
										utama</a> untuk memilih kursus yang
									anda inginkan.</p>
							</div>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</section>
</div>
