<div class="container">
	<!--MINI NAVIGASI-->
	<div class="row navigate-text">
		<div class="col-0 ml-3 position-absolute float-left" style="z-index:2;">
			<a href="<?= base_url() ?>">
				<i class="fa fa-arrow-left text-warning"></i> Kembali
			</a>
		</div>
	</div>
</div>
<div class="fill bg-ka-grey mx-auto d-flex justify-content-center">
	<section id="konfirmasi">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="card">
						<div class="card-body">
							<div class="card-title display-5">
								Terima Kasih Telah Melakukan Pemesanan
							</div>

							<?php
							$potongan = 0;
							if (isset($voucher) && count($voucher) > 0 && $mapel["harga_basic"] >= $voucher["minimal_transaksi"]) {

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
								}
							}

							?>

							<div class="card-text">
								<div class="bg-<?= statusBs[$pembelian["status"]][0] ?> text-white text-center">
									<h2><?= statusBs[$pembelian["status"]][1] ?></h2>
								</div>
								<div class="row mb-3">
									<div class="col font-weight-bold">
										Selamat pembelian kamu di platform Kursusonline.org telah berhasil. Untuk
										melanjutkan dan menyelesaikan pembelian, silahkan melakukan pembayaran senilai
										<div class="text-success text-center h2">
											<?= rupiahTanpa0($pembelian["total_beli"] - $potongan) ?>
										</div>
										<?php if ($pembelian["status"] == 0) { ?>
											<div class="row mb-3">
												<div class="col">
													<h5 class="text-center">METODE PEMBAYARAN</h5>
													<table class="table w-50 m-auto table-bordered">
														<tbody>
														<tr>
															<td style="width: 60%;" class="text-center">
																<img src="<?= base_url() ?>assets/front/images/payment_icon/<?= $pembelian["bank_karisma"] ?>.png"
																	 alt="<?= $pembelian["bank_karisma"] ?>"
																	 class="img-fluid px-5">
																<br>
															</td>
														</tr>
														<tr>
															<td style="" class="text-center">
																<a href="" class="text-primary"><u>GANTI</u></a>
															</td>
														</tr>
														</tbody>
													</table>
												</div>
											</div>


											<div class="text-center">
												<a href="<?= $pembelian["url_invoice"] == "" ? base_url("form-konfirmasi/" . $pembelian["id_transaksi"] . "/" . $mapel["id_mapel"]) : $pembelian["url_invoice"] ?>"
												   class="btn btn-danger" style="margin: 20px auto;font-size: 30px;">
													BAYAR
												</a>
											</div>
										<?php } elseif ($pembelian["status"] == 2) { ?>
											<div class="text-center">
												<a href="<?= base_url("belajar/" . $mapel["meta_link_mapel"]); ?>"
												   class="btn btn-danger" style="margin: 20px auto;font-size: 30px;">
													LIHAT MATERI
												</a>
											</div>
											<?php
										} ?>
									</div>
								</div>

								<?php if ($pembelian["status"] == 0) { ?>
									<div class="row mb-3">
										<div class="col">

											<?php

											$tanggalBeli = $detailTransaksi["created_at"];
											$akhirTanggal = date("Y-m-d", strtotime($tanggalBeli . '+1 day'));
											$akhirJam = date("H:i", strtotime($tanggalBeli . '+1 day'));

											?>
											<div class="p-3 border-danger border-dashed">
												Harap melakukan pembayaran paling lambat <b>1x24</b> jam dari sekarang,
												yaitu pada <b> <?= formatTanggal2($akhirTanggal) ?> <?= $akhirJam ?></b>.
												Apabila waktu sudah mencapai batas, status order akan <span
														class="text-danger font-weight-bold">EXPIRED</span> sehingga
												diperlukan order ulang.
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col font-weight-bold">
											<!--										<i class="fa fa-angle-right"></i> Setelah melakukan pembayaran, segera lakukan-->
											<!--										konfirmasi pembayaran melalui-->
											<!--										<a class="text-info"-->
											<!--										   href="-->
											<? //= base_url("form-konfirmasi/" . $pembelian["id_transaksi"] . "/" . $mapel["id_mapel"]) ?><!--"><u>"halaman-->
											<!--												konfirmasi"</u></a>-->
											<br>
											<i class="fa fa-angle-right"></i> Detail pembayaran juga dapat dilihat pada
											e-mail anda yang telah terdaftar.
											<br>
											<i class="fa fa-angle-right"></i> Informasi lebih lanjut mengenai transaksi,
											anda dapat menghubungi <a class="text-success"
																	  href="https://wa.me/6282131740701?text=Permisi%20Admin%20KARISMA%20ACADEMY.%0ASaya%20%27Nama%27%20telah%20melakukan%20pembayaran%20pada%20rekening%20%27BANK%27%20namun%20mengalami%20permasalahan."
																	  target="_blank">0821 3174 0701</a> (08:30 -
											17:00).
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
