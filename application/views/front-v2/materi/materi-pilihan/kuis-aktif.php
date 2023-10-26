<div class="text-center mx-auto" id="kuis-aktif">
	<div class="container-fluid">
		<div class="row align-items-center mb-3 justify-content-between">
			<div class="col-12 col-md-8 d-flex align-items-center order-2 order-md-1 ">
				<div class="mx-auto ml-md-0">
					<span class="h2">
						<span class="badge badge-pill badge-ka-blue"><?= $tipe ?></span>
                        <?php if ($paket == null): ?>
                            <span class="h2">
								<span class="badge badge-pill badge-ka-blue"><?= $materiActive['nama_materi'] ?></span>
							</span>
                        <?php endif; ?>
					</span>
					<?php if ($paket != null) : ?>
						<span class="h2 ml-2">
							<span class="badge badge-pill badge-ka-blue">Paket <?= $paket ?></span>
						</span>
					<?php endif; ?>
					<span class="h2 mx-2">
						<span class="badge badge-pill badge-outline-ka-blue font-weight-normal">Soal <span id="kuis-info" class="font-weight-bold">1</span> dari <?= $soal["total"] ?></span>
					</span>
				</div>
			</div>
			<div class="col-12 col-md-3 order-1 order-md-2 mb-3 mb-md-0">
				<div class="h4 border border-dark mx-auto mr-md-0 ml-md-auto" id="kuis-detik">
					60
				</div>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-12 bg-ka-light text-left p-4" id="kuis-soal">
				<?php
				if ($soal["total"] > 0) {
					foreach ($soal["data"] as $keySoal => $valueSoal) {
				?>
						<div data-kuis="kuis-container-<?= $keySoal + 1 ?>" class="h5  <?= $keySoal > 0 ? "d-none" : "" ?>">
							<?= $valueSoal["isi_soal"] ?>
						</div>
				<?php
					}
				}
				?>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-12 bg-ka-light text-left p-4" id="kuis-jawaban">
				<form action="">
					<?php

					if ($soal["total"] > 0) {
						foreach ($soal["data"] as $keySoal => $valueSoal) {
							$jawabanSelected = "";
							if ($logUjian["total"] > 0) {
								$jawabanData = $this->UniversalModel->getOneData("jawaban_siswa", "user_id = {$_SESSION['siswaData']['id_user']} AND soal_id = {$valueSoal['id_soal']} AND id_log_ujian = {$logUjian['data']['id_log_ujian']}");
								if ($jawabanData['total'] > 0) {
									$jawabanSelected = $jawabanData["data"]["jawaban"];
								}
							}
					?>
							<div id="soal-<?= $keySoal + 1 ?>" class="list-group list-group-flush <?= $keySoal > 0 ? "d-none" : "" ?>" data-kuis="kuis-container-<?= $keySoal + 1 ?>">

								<?php
								$angka = 1;
								$abjad = str_split("ABCDE");
								for ($angka; $angka <= 5; $angka++) {
									if ($valueSoal["jawab_$angka"] != NULL && $valueSoal["jawab_$angka"] != "" && $valueSoal["jawab_$angka"] != " ") {
								?>
										<input type="radio" name="kuis<?= $keySoal + 1 ?>" value="<?= $angka ?>" id="Radio<?= $keySoal + 1 . "_$angka" ?>" <?= $jawabanSelected == $angka ? "checked" : "" ?> />
										<label class="list-group-item" for="Radio<?= $keySoal + 1 . "_$angka" ?>" onclick="simpanJawaban(<?= $valueSoal['id_soal'] ?>, <?= $angka ?>)">
											<div class="row">
												<div class="col-2 col-md-1">
													<span class="kuis-radio text-center"><?= $abjad[$angka - 1] ?>.</span>
												</div>
												<div class="col-10 col-md-11">
													<?= $valueSoal["jawab_$angka"] ?>
												</div>
											</div>
										</label>
								<?php
									}
								}
								?>


							</div>
					<?php
						}
					}
					?>
				</form>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-12" id="kuis-navigasi">
				<div class="row">
					<div class="col-12 mb-3 mb-md-0">
						<button class="btn btn-ka-blue disabled" id="kuis-nav-prev" data-nav="1">
							<i class="fa fa-chevron-left"></i> <span class="d-none d-md-inline">Prev</span>
						</button>
						<button class="btn btn-ka-blue" id="kuis-nav-next" data-nav="2">
							<span class="d-none d-md-inline">Next</span> <i class="fa fa-chevron-right"></i>
						</button>
					</div>
					<div class="col-12 text-center text-md-right">
						<button class="btn btn-danger ml-auto" id="kuis-end" data-toggle="modal" data-target="#kuis-modal-end">
							<i class="fa fa-check"></i> Selesai
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="kuis-modal-end">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Akhiri kuis?</h5>
			</div>
			<div class="modal-body">
				<p>Anda yakin telah selesai mengerjakan kuis?</p>
			</div>
			<div class="modal-footer">
				<a href="javascript:selesai()" class="btn btn-warning" id="kuis-modal-end-ya">Ya</a>
				<button type="button" class="btn btn-secondary" data-dismiss="modal" id="kuis-modal-end-tidak">Tidak
				</button>
			</div>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="kuis-modal-ya">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Kuis berakhir</h5>
			</div>
			<div class="modal-body">
				<p>Kuis telah berakhir, silahkan tunggu 3 detik untuk melihat hasil</p>
			</div>
		</div>
	</div>
</div>


<div class="modal" tabindex="-1" role="dialog" id="kuis-modal-end-2">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Melanjutkan Ke Materi Selanjutnya ?</h5>
			</div>

			<div class="modal-footer">
				<a href="<?= $materiAkhir ? "javascript:location.reload();" : $linkSelanjutnya ?>" class="btn btn-warning" id="kuis-modal-end-ya">Ya</a>
				<button type="button" class="btn btn-secondary" data-dismiss="modal" id="kuis-modal-end-tidak">Tidak
				</button>
			</div>
		</div>
	</div>
</div>