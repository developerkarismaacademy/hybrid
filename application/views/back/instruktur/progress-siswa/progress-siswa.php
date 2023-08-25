<div class="content-page">
	<div class="content">
		<div class="container">

			<!-- start row -->

			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
						<h4 class="page-title">
							<a data-toggle="tooltip" data-placement="top" title=""
							   data-original-title="Daftar Siswa <?= $mapel["nama_mapel"] ?>"
							   href="<?= base_url('back/siswa-ampu/' . $mapel["meta_link_mapel"]) ?>">
								<i class="fa fa-arrow-left"></i>
							</a>
							<span title="<?= $title ?>"><?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?>
			  </span>
						</h4>
						<ol class="breadcrumb p-0 m-0">
							<li>
								<a title="Daftar Mata Pelajaran Yang Di Ampu"
								   href="<<?= base_url('back/siswa-ampu/' . $mapel["meta_link_mapel"]) ?>">
									<?= (strlen("Daftar Siswa " . $mapel["nama_mapel"]) > 18 ? substr("Daftar Siswa " . $mapel["nama_mapel"], 0, 18) . "..." : "Daftar Siswa " . $mapel["nama_mapel"]) ?>
								</a>
							</li>
							<li class="active">
								<span title="<?= $title ?>"><?= (strlen($title) > 18 ? substr($title, 0, 18) . "..." : $title) ?></span>
							</li>
						</ol>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<!-- end row -->
			<input type="hidden" id="idKelas" value="<?= $kelas['id_kelas'] ?>">
			<input type="hidden" id="idMapel" value="<?= $mapel['id_mapel'] ?>">
			<input type="hidden" id="idSiswa" value="<?= $siswa['id_user'] ?>">
			<input type="hidden" id="metaMapel" value="<?= $mapel['meta_link_mapel'] ?>">

			<div class="alert alert-icon alert-danger alert-dismissible fade in error-alert hidden" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<div class="error-alert-container">

				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<div class="card-box text-center">
						<img height="250" src="<?= base_url() ?>/upload/profile-picture/<?= $siswa["gambar_user"] ?>"/>
					</div>
				</div>
				<div class="col-sm-8">
					<div class="card-box">
						<h4 class="m-t-0 header-title"><b>Data Siswa</b></h4>
						<table class="table table-bordered m-0">
							<colgroup>
								<col class="col-sm-4">
								<col class="col-sm-8">
							</colgroup>
							<tbody>
							<tr>
								<td>UID</td>
								<td id="id-user"><?= $siswa["id_user"] ?></td>
							</tr>
							<tr>
								<td>Nama</td>
								<td id="nama-user"><?= $siswa["nama_user"] ?></td>
							</tr>
							<tr>
								<td>Username</td>
								<td id="username-user"><?= $siswa["username"] ?></td>
							</tr>
							<tr>
								<td>Email</td>
								<td id="email-user"><?= $siswa["email_user"] ?></td>
							</tr>
							<tr>
								<td>No. TELP</td>
								<td id="no-telp-user"><?= $siswa["telepon_user"] ?></td>
							</tr>
							<tr>
								<td>Alamat</td>
								<td id="alamat-user"><?= $siswa["alamat_user"] ?></td>
							</tr>
							<tr>
								<td>TTL</td>
								<td id="ttl-user">
									<?= $siswa["tempat_lahir"] ?>, <?= formatTanggal2($siswa["tanggal_lahir"]) ?>
								</td>
							</tr>
							<tr>
								<td>Jenis Kelamin</td>
								<td id="ttl-user"><?= $siswa["jk_user"] ?></td>
							</tr>
							<tr>
								<td>Boleh Unduh Raport?</td>
								<td id="raport-user">
									<input type="checkbox" id="raport_allowed" name="raport_allowed" value="1"
										   class="form-control raport_allowed"
										   switch="none" <?= ($raporAllowed == 1) ? "checked" : "" ?> />
									<label for="raport_allowed" data-on-label="Boleh"
										   data-off-label="Tidak Boleh"></label>
								</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>

			</div>

			<div class="card-box">
				<div class="progress progress-lg m-b-5">
					<div class="progress-bar progress-bar-purple" role="progressbar" aria-valuenow="<?= $persentase ?>"
						 aria-valuemin="0" aria-valuemax="100" style="width: <?= $persentase ?>%;">
						<?= $persentase ?>%
					</div>
				</div>
			</div>

			<!-- start row -->
			<div class="row">

				<div class="col-md-4 col-sm-12">
					<div class="card-box" id="panel-bab">
						<div class="loading-form">
							<i class="fa fa-spin fa-circle-o-notch fa-4x"></i>
							<br>
							<br>
							Loading Data
						</div>
						<div class="panel-group m-b-0 data-materi" id="accordion" role="tablist"
							 aria-multiselectable="true">
							<?php
							if ($materi["total"] > 0) {
								foreach ($materi["data"] as $keyBab => $valueBab) {
									$nilai_teori = 0.0;
									$nilai_praktek = 0.0;
									if ($valueBab["materi"]["total"] > 0) {
										foreach ($valueBab["materi"]["data"] as $keyMateri => $valueMateri) {
											foreach ($valueMateri["log"]["data"] as $keyLog => $valueLog) {
												if (isset($valueLog["id_log_ujian"])) {
													$nilai_teori = intval($valueLog['nilai']);
												} else if (isset($valueLog["id_log_praktek"])) {
													$nilai_praktek = intval($valueLog['nilai']);
												}
											}
										}
									}
									?>
									<div class="panel panel-<?= ($valueBab["pretest_status"] == 1 || $keyBab == count($materi["data"]) - 1) ? "warning" : "info" ?> panel-color bx-shadow-none">
										<div class="panel-heading m-b-0 p-t-10 p-b-10" role="tab"
											 id="bab-<?= $valueBab["id_bab"] ?>">
											<a role="button" data-toggle="collapse"
											   title="<?= ($valueBab["nama_bab"]) ?>" data-parent="#accordion"
											   href="#materi-<?= $valueBab["id_bab"] ?>"
											   aria-expanded="<?= (isset($_SESSION["terakhirAksesBab"]) and $_SESSION["terakhirAksesBab"] == $valueBab["id_bab"]) ? "true" : $keyBab == 0 ? "true" : "false" ?>"
											   aria-controls="materi-<?= $valueBab["id_bab"] ?>">
												<div class="panel-title row no-gutters" style="font-size: 20px;">
													<div class="col-xs-1">
														<span class="badge bg-dark badge-pill"><?= sprintf("%02d", $keyBab + 1) ?></span>
													</div>
													<div class="col-xs-5">
														<h5 class="text-white line-limit-1">
															<?= (strlen($valueBab["nama_bab"]) > 20 ? substr($valueBab["nama_bab"], 0, 20) . "..." : $valueBab["nama_bab"]) ?>
														</h5>
													</div>
													<div class="col-xs-4 text-right">
														<?php if ($valueBab["belumDiNilai"] > 0) { ?>
															<span class="badge up bg-danger badge-notif-<?= $valueBab["id_bab"] ?>">new</span>
														<?php } ?>
														<span class="badge bg-primary text-white nilai-teori-<?= $valueBab["id_bab"] ?>">
							  <?= $nilai_teori ?>
							</span>
														<span class="badge bg-orange text-white nilai-praktek-<?= $valueBab["id_bab"] ?>">
							  <?= $nilai_praktek ?>
							</span>
													</div>
													<div class="col-xs-2">
														<?= $valueBab["persentase"] ?>%
													</div>
												</div>
											</a>
										</div>
										<div id="materi-<?= $valueBab["id_bab"] ?>"
											 class="panel-collapse collapse <?= (isset($_SESSION["terakhirAksesBab"]) and $_SESSION["terakhirAksesBab"] == $valueBab["id_bab"]) ? "in" : ($keyBab == 0 ? "in" : "") ?>"
											 role="tabpanel" aria-labelledby="bab-<?= $valueBab["id_bab"] ?>">
											<div class="panel-body p-0">
												<div class="list-group p-0 m-b-0 m-t-10 container">
													<?php
													if ($valueBab["materi"]["total"] > 0) {
														foreach ($valueBab["materi"]["data"] as $keyMateri => $valueMateri) {
															$status = $valueMateri["log"]["total"] > 0 ? "text-success" : "";
															$suffix = "";
															$icon = $valueMateri["log"]["total"] > 0 ? "fa-check-circle text-success" : "fa-fw";

															if ($valueMateri["tipe"] == "praktek") {
																if ($valueMateri["log"]["total"] > 0) {
																	if ($valueMateri["log"]["data"][0]["status_baca_instruktur"] == 0) {
																		$status = "text-danger";
																		$icon = "fa-exclamation-circle text-danger";
																	}
																}
															}

															if ($valueMateri["tipe"] == "video") {
																$iconMateri = "fa-youtube-play";
															} elseif ($valueMateri["tipe"] == "teks") {
																$iconMateri = "fa-file-text";
															} elseif ($valueMateri["tipe"] == "pilihan") {
																$iconMateri = "fa-pencil-square-o";
																$suffix = "(Teori)";
															} else {
																$iconMateri = "fa-object-group";
																$suffix = "(Praktek)";
															}

															if ($valueMateri["tipe"] == "video" || $valueMateri["tipe"] == "teks") {
																$link = "javascript:;";
															} else {
																$link = "javascript:showPenilaian(" . $valueMateri["id_materi"] . ", " . $valueMateri["bab_id"] . ", '" . $valueMateri["tipe"] . "');";
															}
															?>
															<a href="<?= $link ?>"
															   id="item-materi-<?= $valueMateri["id_materi"] ?>">
																<div class="row m-0 list-group-item"
																	 style="vertical-align:middle;">
																	<div class="col-xs-10">
																		<h4 class="list-group-item-heading <?= $status ?> line-limit-1 m-b-0">
																			<i class="fa <?= $iconMateri ?>"></i>
																			<?= $valueMateri["nama_materi"] . " " . $suffix ?>
																		</h4>
																	</div>
																	<div class="col-xs-2">
																		<?php
																		if ($icon != "") {
																			?>
																			<i class="fa <?= $icon ?> pull-right"
																			   style="font-size:20px;"></i>
																			<?php
																		}
																		?>
																	</div>
																</div>
															</a>
															<?php
														}
													}
													?>
												</div>
											</div>
										</div>
									</div>
									<?php
								}
							}

							?>


						</div>
					</div>
				</div>

				<div class="col-md-8 col-sm-12">
					<div class="card-box">
						<div class="loading-form">
							<i class="fa fa-spin fa-circle-o-notch fa-4x"></i>
							<br>
							<br>
							Loading Data
						</div>
						<?php
						$keyKompetensi_urutan = 0;
						if ($materi["total"] > 0) {
							foreach ($materi["data"] as $keyBab => $valueBab) {
								if ($valueBab["materi"]["total"] > 0) {
									foreach ($valueBab["materi"]["data"] as $keyMateri => $valueMateri) { ?>
										<div class="konten-materi" id="konten-materi-<?= $valueMateri["id_materi"] ?>">
											<?php
											if ($valueMateri["tipe"] == "pilihan") {
												?>
												<h3 class="m-t-0">
													<b><?= $valueMateri["nama_materi"] ?></b>
												</h3>
												<?php
												if ($valueMateri["log"]["total"] > 0) {
													$log = $valueMateri["log"]["data"][0];
													?>
													<h2 class="pull-right">
														Nilai Skor Siswa : <span
																class="nilai-teori-<?= $valueMateri['bab_id'] ?>"><?= $log["nilai"] ?></span>
													</h2>
													<div class="clearfix"></div>
												<?php } ?>

												<div id="detail-konten" style="padding-right: 10px;">
													<?php if ($valueMateri["log"]["total"] > 0) {
														$log = $valueMateri["log"]["data"][0];
														if ($log["jawaban"]["total"] > 0) {
															foreach ($log["jawaban"]["data"] as $keySoal => $valueSoal) {
																?>
																<div class="table-responsive m-t-20 m-b-20">
																	<table class="table m-0 table-colored-bordered table-bordered-<?= $valueSoal["jawaban"] == $valueSoal["kunci_jawaban"] ? "info" : "danger" ?> table-bordered">
																		<thead>
																		<tr>
																			<th colspan="2">
																				Soal <?= $keySoal + 1 ?></th>
																		</tr>
																		</thead>
																		<tbody>
																		<tr>
																			<td colspan="2">
																				Pertanyaan :
																				<?= $valueSoal["isi_soal"] ?>
																			</td>
																		</tr>
																		<tr>
																			<td colspan="2">
																				Jawaban Benar :

																				<?php

																				switch ($valueSoal["kunci_jawaban"]):
																					case 1:
																						echo $valueSoal["jawab_1"];
																						break;
																					case 2:
																						echo $valueSoal["jawab_2"];
																						break;
																					case 3:
																						echo $valueSoal["jawab_3"];
																						break;
																					case 4:
																						echo $valueSoal["jawab_4"];
																						break;
																					case 5:
																						echo $valueSoal["jawab_5"];
																						break;
																					default:
																						echo "Error";
																						break;
																				endswitch;
																				?>
																			</td>
																		</tr>
																		<tr>
																			<td colspan="2">
																				Jawaban Siswa :

																				<?php
																				if ($valueSoal["jawaban"] != null) {
																					switch ($valueSoal["jawaban"]):
																						case 1:
																							echo $valueSoal["jawab_1"];
																							break;
																						case 2:
																							echo $valueSoal["jawab_2"];
																							break;
																						case 3:
																							echo $valueSoal["jawab_3"];
																							break;
																						case 4:
																							echo $valueSoal["jawab_4"];
																							break;
																						case 5:
																							echo $valueSoal["jawab_5"];
																							break;
																						default:
																							echo "Error";
																							break;
																					endswitch;
																				} else {
																					echo "Tidak menjawab";
																				} ?>
																			</td>
																		</tr>
																		</tbody>
																	</table>
																</div>

															<?php }
														}
													} ?>
												</div>
												<?php
											} elseif ($valueMateri["tipe"] == "praktek") {
												?>
												<h3 class="m-t-0">
													<b><?= $valueMateri["nama_materi"] ?></b>
												</h3>
												<div class="table-responsive m-t-20 m-b-20">
													<table class="table m-0 table-colored-bordered table-bordered-info">
														<thead>
														<tr>
															<th colspan="2">File Upload</th>
														</tr>
														</thead>
														<tbody>

														<?php if ($valueMateri["log"]["total"] > 0) {
															foreach ($valueMateri["log"]["data"] as $keyLog => $valueLog) {
																if ($valueLog["tipe"] == "link") {
																	$file = $valueLog["file"];
																	$link = $file;
																} else {
																	$link = base_url() . "upload/praktek/" . $siswa["id_user"] . "/" . $valueMateri["id_materi"] . "/" . $valueLog["file"];

																	$file = strtolower(getFileExtension($valueLog["file"]));
																	$file = array_key_exists($file, knownType) ? knownType[$file] : 'EKSTENSI TIDAK DI KETAHUI';
																	$file = "FILE " . $file;
																}

																$tipeIcon = "fa-question";
																switch ($valueLog["tipe"]) {
																	case "dokumen":
																		$tipeIcon = "fa-file-o";
																		break;
																	case "lampiran":
																		$tipeIcon = "fa-paperclip";
																		break;
																	case "gambar":
																		$tipeIcon = "fa-file-image-o";
																		break;
																	case "link":
																		$tipeIcon = "fa-link";
																		break;
																}
																?>

																<tr>
																	<td>
																		<div class="row p-2">
																			<div class="col-2 col-sm-2 col-md-2">
																				<h1><i class="fa <?= $tipeIcon ?>"></i>
																				</h1>
																			</div>
																			<div class="col-10 col-sm-10 col-md-10">
																				<h3 class="card-title"><?= strtoupper($valueLog["tipe"]) ?> <?= $valueLog["nama"] ?></h3>
																				<p class="card-text"><?= $file ?></p>
																			</div>

																		</div>

																	</td>
																	<td style="vertical-align: middle; text-align:center;">
																		<a href="<?= $link ?>"
																		   class="btn waves-effect waves-light btn-primary link-detail"
																		   target="_blank" data-toggle="tooltip"
																		   data-placement="top" title=""
																		   data-original-title="Lihat <?= $valueLog["nama"] ?>">
																			Lihat <i class="fa fa-arrow-right"></i>
																		</a>
																	</td>
																</tr>
															<?php }
														} ?>

														</tbody>
													</table>
												</div>
												<?php
												// INDIKATOR
												// Get based on urutannya atau based on bab
												// Karena beberapa indikator lama tidak menyertakan bab per indikator
												if (isset($kompetensi["data"][0])) {
													$keyKompetensi = $keyKompetensi_urutan;
												} else {
													$keyKompetensi = $valueMateri["bab_id"];
												}
												$keyKompetensi_urutan++;

												$valueKompetensi = isset($kompetensi["data"][$keyKompetensi]) ? $kompetensi["data"][$keyKompetensi] : "";
												if ($valueKompetensi != "") {
													$nilaiIndikatorPraktek = 0; ?>
													<div class="panel panel-color panel-primary" id="panel-bab">
														<div class="panel-heading">
															<h3 class="panel-title text-center">Penilaian Indikator</h3>
														</div>
														<div class="loading-form">
															<i class="fa fa-spin fa-circle-o-notch fa-4x"></i>
															<br>
															<br>
															Loading Data
														</div>
														<div class="panel-body">
															<div class="loading-form">
																<i class="fa fa-spin fa-circle-o-notch fa-4x"></i>
																<br>
																<br>
																Loading Data
															</div>

															<h2 class="text-right">
																Nilai Skor Siswa : <span
																		class="nilai-praktek-<?= $valueMateri["bab_id"] ?>"><?= $nilaiIndikatorPraktek ?></span>
															</h2>
															<div class="table-responsive">
																<table class="table m-0 table-colored-bordered table-bordered-info table-bordered">
																	<?php
																	if ($valueKompetensi["indikatorInduk"]["total"] > 0) {
																		foreach ($valueKompetensi["indikatorInduk"]["data"] as $keyIndikatorInduk => $valueIndikatorInduk) {
																			?>
																			<thead>
																			<tr>
																				<th colspan="2"
																					style="font-size: 20px;"><?= $valueIndikatorInduk["indikator_induk"] ?></th>
																			</tr>
																			</thead>
																			<tbody>
																			<?php
																			if ($valueIndikatorInduk["indikator"]["total"] > 0) {
																				foreach ($valueIndikatorInduk["indikator"]["data"] as $keyIndikator => $valueIndikator) {
																					?>
																					<tr>
																						<?php //<td> $valueIndikator["id_indikator"] </td>
																						?>
																						<td style="width: 75%;font-size: 18px;"><?= $valueIndikator["indikator"] ?></td>
																						<td style="width: 25%;">
																							<div class="form-group">
																								<div class="col-sm-12">
																									<input type="text"
																										   onchange="simpanNilaiIndikator(<?= $valueIndikator['id_indikator'] ?>,this.value, <?= $valueMateri['id_materi'] ?>, <?= $valueMateri['bab_id'] ?>)"
																										   name="input-indikator-<?= $valueIndikator['id_indikator'] ?>"
																										   value="<?= isset($valueIndikator['nilai']) ? $valueIndikator['nilai'] : '' ?>"
																										   class="form-control input-lg text-center input-indikator-<?= $valueMateri['id_materi'] ?>"
																										   placeholder="1 - 10">
																								</div>
																							</div>
																						</td>
																					</tr>
																					<?php
																				}
																			}
																			?>
																			</tbody>
																			<?php
																		}
																	}
																	?>
																</table>
															</div>
														</div>
													</div>
													<?php
												} else { ?>

													<div class="panel panel-color panel-primary" id="panel-bab">
														<div class="panel-heading">
															<h3 class="panel-title text-center">Indikator tidak
																ditentukan</h3>
														</div>
														<div class="panel-body">
															<h5 class="text-center">
																Mohon hubungi admin
															</h5>
														</div>
													</div>

													<?php
												}
											}
											?>
										</div>
										<?php
									}
								}
							}
						}
						?>
					</div>
				</div>
			</div>
			<!-- end row -->
		</div>
	</div>
</div>
<!-- container -->
