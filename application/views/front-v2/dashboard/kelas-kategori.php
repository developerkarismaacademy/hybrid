<!--PILIH KELAS-->
<section id="pilih-kelas" class="bg-ka-dark kelas-parent py-5">
	<div class="container">
		<div class="row p-0">
			<div class="col h4 text-center text-md-left">
				<b>Pilih</b> kelas favoritmu sekarang juga!
			</div>
		</div>


		<?php
		if ($dataKelas["total"] > 0) {
			foreach ($dataKelas["data"] as $keyKelas => $valueKelas) {
				if ($valueKelas["prakerja"] == 0) {
					$jumlahMapel = $this->FrontMapelModel->getTotalMapel($valueKelas["id_kelas"]);
		?>
					<div class="row">
						<div class="col-lg-3 col-md-12 mb-4 pr-1 mb-lg-0 d-flex align-items-stretch">
							<div class="card w-100 " style="margin-top: 3px; height:293px;">
								<div class="card-body">
									<div class="card-title">
										<div class=" d-flex title-sub mb-2">
											Temukan Kelas
											<span class="btn d-flex btn-no-hover border-ka-orange btn-rounded px-3 ml-auto btn-small text-white 0">
												<?= ($jumlahMapel > 3) ? ($jumlahMapel - 1) . "+" : $jumlahMapel ?> Kelas
											</span>
										</div>
										<div class="title-main">
											Kursus online
											<p class="text-<?= $valueKelas["color_kelas"] ?>"><?= $valueKelas["nama_kelas"] ?></p>
										</div>
									</div>

									<div class="card-text">
										<div class="row list-kelas">
											<div class="col">
												<div class="line-limit-3 mb-1 ">
													<?= $valueKelas["deskripsi_singkat"] ?>
												</div>
												<div class="row d-flex mt-5 pb-5 justify-content-center">
													<div class="col-12 col-lg-12 ">
														<a class="btn btn-all-class btn-outline-warning text-white" href="<?= base_url("kelas") ?>">Lihat Lebih
															Banyak </a>
													</div>
												</div>
											</div>
										</div>

										<!-- <div class="row mt-3">
                                        <div class="col">
                                            <span class="btn btn-no-hover border-ka-light btn-rounded px-5 btn-small text-white w-100">
                                                <?= ($jumlahMapel > 3) ? ($jumlahMapel - 1) . "+" : $jumlahMapel ?> Kelas
                                            </span>
                                        </div>
                                    </div> -->

									</div>
								</div>
							</div>
						</div>

						<div class="kelas-list col-lg-9 col-12">
							<?php
							$dataMapel = $valueKelas["mapel"];
							if ($dataMapel["total"] > 0) {
								$data["idClone"] = "1";
								foreach ($dataMapel["data"] as $keyMapel => $valueMapel) {
									$data["keyMapel"] = $keyMapel;
									$data["valueMapel"] = $valueMapel;
									$this->load->view("front-v2/layout/kelas", $data);
								}
							}
							?>
						</div>
					</div>
		<?php
				}
			}
		}

		?>


	</div>
</section>