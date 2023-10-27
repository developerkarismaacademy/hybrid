<div class="col-12 col-md tab-pane fade show active" id="kelas-saya" role="tabpanel" aria-labelledby="daftar-pembelian"
	 aria-selected="true">
	<div class="container py-0">
		<div class="row">
			<div class="col">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-12 col-md tab-content">
								<div class="row mb-3 border-bottom border-ka-light no-gutters">
									<div class="col-12">
										<ul class="nav profil-tab nav-fill" id="profil-tab" role="tablist">
											<li class="nav-item">
												<a class="nav-link py-2 active" id="sub-semua-1-list" data-toggle="tab"
												   href="#sub-semua-1" role="tab" aria-controls="sub-semua-1"
												   aria-selected="false">Semua</a>
											</li>

											<?php if (isset($this->db->dev)) { ?>
												<li class="nav-item">
													<a class="nav-link py-2" id="sub-progress-1-list" data-toggle="tab"
													   href="#sub-progress-1" role="tab" aria-controls="sub-progress-1"
													   aria-selected="false">Dalam
														Progress</a>
												</li>
												<li class="nav-item">
													<a class="nav-link py-2" id="sub-selesai-1-list" data-toggle="tab"
													   href="#sub-selesai-1" role="tab"
													   aria-controls="sub-selesai-1-materi" aria-selected="false">Selesai
														Seluruh
														Materi</a>
												</li>
												<li class="nav-item">
													<a class="nav-link py-2" id="sub-exam-1-list" data-toggle="tab"
													   href="#sub-exam-1" role="tab" aria-controls="sub-exam-1"
													   aria-selected="false">Exam</a>
												</li>
											<?php } ?>
										</ul>
									</div>
								</div>
								<div class="tab-pane fade show active" id="sub-semua-1" role="tabpanel"
									 aria-labelledby="sub-semua-1">

									<?php if (isset($mapel) && $mapel["total"] > 0) {
										foreach ($mapel["data"] as $keyMapel => $valueMapel) {
											$user = $this->FrontAuthModel->getUserLoggedIn();
											$done = $valueMapel["progress"] >= 100 ? true : false;
											$prakerjaStatus = $valueMapel['prakerja'] == 1 ? true : false;
											$statusRedeem = true;
											if ($prakerjaStatus) {
												$redeemData = $this->db->get_where('redeem', ['user_id' => $user['data']['id_user'], 'mapel_id' => $valueMapel['id_mapel']]);
												if ($redeemData->num_rows() > 0) {
													$statusRedeem = true;
												} else {
													$statusRedeem = false;
												}
											}
											$urlBelajar = ($statusRedeem) ? base_url("belajar/{$valueMapel["meta_link_mapel"]}") : '#';
											?>
											<div class="card card-light my-4">
												<div class="card-body p-3">
													<div class="container-fluid">
														<div class="row">
															<div class="col-12 col-lg-3 p-0"
																 style="text-align:center;position: relative;<?= ($prakerjaStatus && !$statusRedeem) ? 'background: rgba(0, 0, 0);' : '' ?>">
																<?php if (file_exists(FCPATH . "upload/banner_mapel/" . $valueMapel["banner_mapel"])) : ?>
																	<img
																		src="<?= base_url() ?>upload/banner_mapel/<?= $valueMapel["banner_mapel"] ?>"
																		class=""
																		style="width:100%;height:100%;object-fit: cover;<?= ($prakerjaStatus && !$statusRedeem) ? 'opacity: 0.3;' : '' ?>"
																		alt="">
																<?php endif ?>
																<?php if ($prakerjaStatus && !$statusRedeem) : ?>
																	<div class="text-thumnail-image"
																		 style="text-transform:uppercase; position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);font-weight:bold">
																		BELUM REDEEM
																	</div>
																<?php endif ?>
															</div>
															<div class="col-12 col-lg">
																<div class="text-truncate"
																	 title="<?= $valueMapel["nama_mapel"] ?>">
																	<b><?= $valueMapel["nama_mapel"] ?></b>
																</div>
																<?php if (isset($this->db->dev)) { ?>
																<small>
																	<div>
																		Nilai Exam <span
																			class="badge badge-danger">60.0</span>
																	</div>
																	<?php
																	}

																	$progressAktivitas = $valueMapel["progress"] ?? round(0, 1);

																	$this->db->where('user_id', $user['data']['id_user']);
																	$this->db->where('mapel_id', $valueMapel['id_mapel']);
																	$this->db->where('status', 1);
																	$this->db->from('user_absen');
																	$totalKehadiran = $this->db->count_all_results();
																	$progressKehadiran = 100 / 5 * $totalKehadiran;
																	$progressKehadiran = ($progressKehadiran >= 100) ? 100 : $progressKehadiran;
																	?>
																	<div class="my-3">
																		Total Aktivitas <span
																			class="ml-3"><b><?= $progressAktivitas ?>%</b></span>
																	</div>

																	<div class="progress">
																		<div class="progress-bar" role="progressbar"
																			 style="width: <?= $progressAktivitas ?>%"
																			 aria-valuenow="<?= $progressAktivitas ?>"
																			 aria-valuemin="0" aria-valuemax="100">
																		</div>
																	</div>
																</small>
															</div>
															<div
																class="col-12 px-0 mt-lg-0 mt-3 col-lg-3 align-self-center">
																<div class="row">
																	<div
																		class="<?= ($done) ? 'col-6  pr-2' : 'col-12' ?> ">
																		<a class="btn btn-warning btn-block" <?= (!$statusRedeem) ? 'data-toggle="modal" data-target="#redeem-' . $valueMapel['id_mapel'] . '"' : '' ?>
																		   href="<?= $urlBelajar ?>">
																			<i class="fa fa-arrow-right"></i>
																		</a>
																		<!-- Modal Redeem -->
																		<div class="modal fade"
																			 id="redeem-<?= $valueMapel['id_mapel'] ?>"
																			 tabindex="-1" aria-labelledby="redeemLabel"
																			 aria-hidden="true">
																			<div class="modal-dialog">
																				<div class="modal-content">
																					<div class="modal-header">
																						<h5 class="modal-title text-dark"
																							id="redeemLabel">Redeem
																							Voucher</h5>
																						<button type="button"
																								class="close"
																								data-dismiss="modal"
																								aria-label="Close">
																							<span aria-hidden="true">&times;</span>
																						</button>
																					</div>
																					<div class="modal-body">
																						<div class="form-group">
																							<label for="recipient-name"
																								   class="col-form-label text-dark">
																								Pakai kupon prakerja
																								Anda.
																							</label>

																							<?php if (isset($status)) : ?>
																								<p><?= $redeem_code ?></p>
																								<p><?= $course_code ?></p>
																								<p>
																									<?= ($status == 1 ? 'Sudah di redeem' : 'Belum di redeem') ?>
																								</p>
																							<?php endif ?>

																							<form
																								action="<?= base_url('redeem-code') ?>"
																								method="post">
																								<input type="hidden"
																									   name="mapel_id"
																									   value="<?= $valueMapel['id_mapel'] ?>">
																								<input type="text"
																									   class="form-control"
																									   name="commit"
																									   placeholder="Code Redeem.."
																									   required>
																								<div
																									class="modal-footer">
																									<button
																										type="submit"
																										class="btn btn-success">
																										Submit
																									</button>
																								</div>
																							</form>

																						</div>
																					</div>

																				</div>
																			</div>
																		</div>
																	</div>
																	<?php
																	if ($done) {
																		?>
																		<div class="col-6 pl-2">
																			<a class="btn btn-info btn-block"
																			   href="<?= base_url("ulasan/{$valueMapel["meta_link_mapel"]}") ?>"
																			   data-toggle="tooltip"
																			   data-placement="top" title="Ulas">
																				<i class="fa fa-star"></i>
																			</a>
																		</div>
																		<?php
																	}
																	?>
																	<?php if ($prakerjaStatus && $statusRedeem) : ?>

																	<?php endif ?>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<?php
										}
									} else { ?>
										<div class="card card-light mt-4">
											<div class="card-body p-3">
												<div class="container-fluid">
													<div class="row">
														<div class="col-12 img-bg-fill text-center">
															Anda belum membeli dan membaca kelas sama sekali
															<br>
															Silahkan menuju ke <a href="<?= base_url("#pilih-kelas") ?>"
																				  class="text-warning">daftar
																kelas</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<?php
									} ?>
								</div>

								<?php if (isset($this->db->dev)) { ?>
									<div class="tab-pane fade" id="sub-progress-1" role="tabpanel"
										 aria-labelledby="sub-progress-1">
										<?php
										for ($i = 0; $i < 5; $i++) {
											?>
											<div class="card card-light my-4">
												<div class="card-body p-3">
													<div class="container-fluid">
														<div class="row">
															<div class="col-12 col-lg-2 img-bg-fill"
																 style="background-image:url('<?= base_url() ?>assets/front/v2/img/bg-paket.jpg');">
															</div>
															<div class="col-12 col-lg">
																<div class="text-truncate"
																	 title="Menjadi Drafter Arsitektur & Sipil Handal dengan AutoCAD">
																	<b>Menjadi Drafter Arsitektur & Sipil
																		Handal dengan
																		AutoCAD</b>
																</div>
																<small>
																	<div>
																		Nilai Exam <span
																			class="badge badge-danger">60.0</span>
																	</div>
																	<?php
																	$dummyprogress = 60
																	?>
																	<div class="my-3">
																		Progress Kelas <span
																			class="ml-3"><b><?= $dummyprogress ?>%</b></span>
																	</div>

																	<div class="progress">
																		<div class="progress-bar" role="progressbar"
																			 style="width: <?= $dummyprogress ?>%"
																			 aria-valuenow="<?= $dummyprogress ?>"
																			 aria-valuemin="0" aria-valuemax="100">
																		</div>
																	</div>
																</small>
															</div>
															<div
																class="col-12 px-0 mt-lg-0 mt-3 col-lg-3  align-self-center">
																<div class="row">
																	<div class="col-lg-12 pr-2">
																		<a class="btn btn-warning btn-block" href="#">
																			<i class="fa fa-arrow-right"></i>
																		</a>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										<?php } ?>
									</div>
									<div class="tab-pane fade" id="sub-selesai-1" role="tabpanel"
										 aria-labelledby="sub-selesai-1">
										<?php
										for ($i = 0; $i < 5; $i++) {
											?>
											<div class="card card-light my-4">
												<div class="card-body p-3">
													<div class="container-fluid">
														<div class="row">
															<div class="col-12 col-lg-2 img-bg-fill"
																 style="background-image:url('<?= base_url() ?>assets/front/v2/img/bg-paket.jpg');">
															</div>
															<div class="col-12 col-lg">
																<div class="text-truncate"
																	 title="Menjadi Drafter Arsitektur & Sipil Handal dengan AutoCAD">
																	<b>Menjadi Drafter Arsitektur & Sipil
																		Handal dengan
																		AutoCAD</b>
																</div>
																<small>
																	<div>
																		Nilai Exam <span
																			class="badge badge-danger">60.0</span>
																	</div>
																	<?php
																	$dummyprogress = 100
																	?>
																	<div class="my-3">
																		Progress Kelas <span
																			class="ml-3"><b><?= $dummyprogress ?>%</b></span>
																	</div>

																	<div class="progress">
																		<div class="progress-bar" role="progressbar"
																			 style="width: <?= $dummyprogress ?>%"
																			 aria-valuenow="<?= $dummyprogress ?>"
																			 aria-valuemin="0" aria-valuemax="100">
																		</div>
																	</div>
																</small>
															</div>
															<div
																class="col-12 px-0 mt-lg-0 mt-3 col-lg-3 align-self-center">
																<div class="row">
																	<div class="col-lg-6 pr-2">
																		<a class="btn btn-warning btn-block" href="#">
																			<i class="fa fa-arrow-right"></i>
																		</a>
																	</div>

																	<div class="col-lg-6 pl-2">
																		<a class="btn btn-info btn-block" href="#"
																		   data-toggle="tooltip" data-placement="top"
																		   title="Ulas">
																			<i class="fa fa-star"></i>
																		</a>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										<?php } ?>
									</div>
									<div class="tab-pane fade" id="sub-exam-1" role="tabpanel"
										 aria-labelledby="sub-exam-1">
										<?php
										for ($i = 0; $i < 5; $i++) {
											?>
											<div class="card card-light my-4">
												<div class="card-body p-3">
													<div class="container-fluid">
														<div class="row">
															<div class="col-12 col-lg-2 img-bg-fill"
																 style="background-image:url('<?= base_url() ?>assets/front/v2/img/bg-paket.jpg');">
															</div>
															<div class="col-12 col-lg">
																<div class="text-truncate"
																	 title="Menjadi Drafter Arsitektur & Sipil Handal dengan AutoCAD">
																	<b>Menjadi Drafter Arsitektur & Sipil
																		Handal dengan
																		AutoCAD</b>
																</div>
																<small>
																	<div>
																		Nilai Exam <span
																			class="badge badge-danger">60.0</span>
																	</div>
																	<?php
																	$dummyprogress = 60
																	?>
																	<div class="my-3">
																		Progress Kelas <span
																			class="ml-3"><b><?= $dummyprogress ?>%</b></span>
																	</div>

																	<div class="progress">
																		<div class="progress-bar" role="progressbar"
																			 style="width: <?= $dummyprogress ?>%"
																			 aria-valuenow="<?= $dummyprogress ?>"
																			 aria-valuemin="0" aria-valuemax="100">
																		</div>
																	</div>
																</small>
															</div>
															<div
																class="col-12 px-0 mt-lg-0 mt-3 col-lg-3 align-self-center">
																<div class="row">
																	<div class="col-lg-6 pr-2">
																		<a class="btn btn-warning btn-block" href="#">
																			<i class="fa fa-arrow-right"></i>
																		</a>
																	</div>

																	<div class="col-lg-6 pl-2">
																		<a class="btn btn-info btn-block" href="#"
																		   data-toggle="tooltip" data-placement="top"
																		   title="Ulas">
																			<i class="fa fa-star"></i>
																		</a>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										<?php } ?>
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
