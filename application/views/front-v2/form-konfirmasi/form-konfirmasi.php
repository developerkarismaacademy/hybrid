<!--MINI NAVIGASI-->
<div class="container">
	<div class="row navigate-text pb-0">
		<div class="col-0 ml-3 position-absolute float-left" style="z-index:2;">
			<a href="<?= base_url() ?>">
				<i class="fa fa-arrow-left text-warning"></i> Kembali
			</a>
		</div>
		<div class="col-12 text-center">
			Upload Bukti Pembayaran
		</div>
	</div>
</div>

<div class="fill bg-ka-grey mx-auto align-items-center justify-content-center">
	<section id="konfirmasi">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="card">
						<div class="card-body">
							<?php

							$potongan = 0;

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
								}
							}
							?>
							<div class="card-text">
								<div class="row">
									<div class="col-12 col-lg-6 col-12 order-2 order-lg-1">
										<form action="<?= base_url("simpan-konfirmasi/" . $pembelian["id_transaksi"] . "/" . $mapel["id_mapel"]) ?>"
											  method="post" enctype="multipart/form-data">

											<input type="hidden" name="kode_voucher" id="kode_voucher" value="">
											<div class="form-group">
												<label for="bank_anda">Bank Yang Anda Gunakan</label>
												<input type="text" name="bank_anda"
													   value="<?= $pembelian["bank_user"] ?>" class="form-control"
													   id="bank_anda" placeholder="Ex. (BRI/BCA/MANDIRI/BNI)"
													   required="">
											</div>
											<div class="form-group">
												<label for="no_rekening">No. Rekening</label>
												<input type="text" name="no_rekening"
													   value="<?= $pembelian["no_rek_user"] ?>" class="form-control"
													   id="no_rekening" placeholder="00000000" required="">
											</div>
											<div class="form-group">
												<label for="atas_nama">Nama Pemilik Rekening</label>
												<input type="text" name="atas_nama"
													   value="<?= $pembelian["atas_nama"] ?>" class="form-control"
													   id="atas_nama" placeholder="Nama" required="">
											</div>
											<input type="hidden" name="jumlah_bayar"
												   value="<?= $mapel["harga_basic"] - $potongan ?>">
											<div class="form-group">
												<label for="bank_tujuan">Bank Tujuan</label>
												<select onchange="ganti_bank(this.value)" class="form-control input-sm"
														name="bank_tujuan" required="">
													<option value="" selected="" disabled="" hidden="">
														-Pilih Bank-
													</option>

													<?php foreach (bank as $key => $value) {
														?>
														<option <?= $key == strtolower($pembelian["bank_karisma"]) ? " SELECTED " : "" ?>
																value="<?= $value["nama"] ?>">
															<?= $value["nama"] ?> a/n <?= $value["atasNama"] ?>
														</option>
														<?php
													} ?>
												</select>
											</div>
											<?php foreach (bank as $key => $value) {
												?>
												<div id="bank-<?= $key ?>" class="col-md-12 col-sm-12 mt-3 d-none">
													<div class="row mt-3 align-items-center">
														<div class="col-md-6">
															<img class="w-100"
																 src="<?= base_url("assets/front/v2/img/brand/bank-" . $key . ".png") ?>">
														</div>
														<div class="col-md-6 text-center">
															<div class=" text-gray-2 min-height-20">
																<h4><?= $value["rekening"] ?></h4>
																<h4 style="margin-top: -8px;">
																	a/n <?= $value["atasNama"] ?>
																</h4>
															</div>
														</div>
													</div>
												</div>
												<?php
											} ?>


											<div class="form-group row">
												<div class="col-md-12 col-sm-12 ">
													<label for="bukti_pembayaran">Bukti Transfer</label>
													<br>
													<?php if ($pembelian["status"] != "2") { ?>
														<input type="file" name="bukti_pembayaran" accept="image/*"
															   required="">
													<?php } ?>
													<img alt="Bukti Transfer"
														 src="<?= $pembelian["bukti_transfer"] == "" ? base_url("assets/front/v2/img/no-image-box.png") : base_url("upload/transaksi/{$pembelian["bukti_transfer"]}") ?>"
														 class="img d-none" style="margin-top: 20px; width: 90%;"
														 id="preview_bukti">
												</div>


											</div>
											<?php if ($pembelian["status"] != "2") { ?>
												<button type="submit" class="btn btn-primary w-100"
														style="font-size: 12pt;" value="167" name="submitbtn">
													Kirim Bukti Pembayaran
												</button>
											<?php } ?>
										</form>
									</div>
									<div class="col-12 col-lg-6 col-12 order-1 order-lg-2">
										<div class="row">
											<div class="col-12 col-md-4 order-2 order-md-1">
												<iframe src="https://www.youtube.com/embed/<?= $mapel["intro_video"] ?>"
														frameborder="0"
														allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
														allowfullscreen class="w-100"></iframe>
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
													<div class="col-6 harga-asli small">
														<?php
														$harga_basic = $mapel["harga_basic"];
														$diskon = $mapel["diskon_basic"];
														$decoy = hargaDiskon($harga_basic, $diskon);
														?>
														<span class="badge badge-pill badge-danger">
                                                            <?= $diskon . "%" ?>
                                                        </span>
														<span class="text-line-through">
                                                            <?= rupiahTanpa0($decoy) ?>
                                                        </span>
													</div>
													<div class="col-6 harga-diskon text-warning h4 text-right">
														<b>
															<?= rupiahTanpa0($harga_basic) ?>
														</b>
													</div>
												</div>
											</div>
										</div>
										<div class="row mt-3">
											<div class="col offset-md-4 h3 font-weight-bold header-title">
												Total Harga
											</div>
											<div class="col text-right">
												<h4 class="harga-diskon">
													<b>
														<?= rupiahTanpa0($mapel["harga_basic"]) ?>
													</b>
												</h4>
											</div>
										</div>
										<?php

										if (isset($voucher) && count($voucher) > 0 && $mapel["harga_basic"] >= $voucher["minimal_transaksi"]) {
											?>


											<div class="row">
												<div class="col h5 font-weight-bold header-title text-danger">
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
												<div class="col h3 font-weight-bold header-title">
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
										<?php } ?>

									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
