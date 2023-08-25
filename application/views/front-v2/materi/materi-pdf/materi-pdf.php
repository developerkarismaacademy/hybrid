<!--DETAIL KELAS-->
<div class="fill bg-ka-dark">
	<section id="kelas-detail">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-12">
					<div class="card" id="konten">
						<div class="card-img-top">
							<div class="row">
								<div class="col-12">
									<!--MINI NAVIGASI-->
									<?php
									$this->load->view("front-v2/materi/materi-navigasi");
									?>
								</div>
								<div class="col-12">
									<?php
									$this->load->view("front-v2/materi/materi-progress");
									?>
								</div>
								<div class="col">
									<div class="bg-light">
										<canvas id="pdf-container" style="width: 100%">

										</canvas>
										<div class="container">
											<div class="row mb-3 mt-3">
												<div class="col-12 my-2">
													<h4 class="text-center" style="color: #000" id="total-halaman">
														<span id="page_num"></span> / <span id="page_count"></span>
													</h4>
												</div>
												<div class="col-12" id="kuis-navigasi">
													<a class="btn btn-ka-blue" id="prev">
														<i class="fa fa-chevron-left"></i>
													</a>
													<?php if ($materiActive['webinar_status'] == 1): ?>
														<?php
														$userId = $_SESSION['siswaData']['id_user'];
														$mapelId = $mapel['id_mapel'];
														$materiId = $materiActive['id_materi'];
														$userAbsen = $this->db->query("SELECT * FROM user_absen WHERE user_id = $userId AND mapel_id = $mapelId AND materi_id = $materiId");
														?>
														<?php if ($userAbsen->num_rows() > 0): ?>
															<a href="javascript:selesai();" class="btn btn-danger"
															   id="page-end">
																<i class="fa fa-check"></i> Selesai
															</a>
														<?php else: ?>
															<a class="btn btn-danger" href="#" id="absen-list"
															   data-toggle="modal"
															   data-target="#absenModal"
															   href="#" title="Absen">
																<i class="fa fa-check"></i> Selesai
															</a>
														<?php endif; ?>
													<?php else: ?>
														<a href="javascript:selesai();" class="btn btn-danger"
														   id="page-end">
															<i class="fa fa-check"></i> Selesai
														</a>
													<?php endif; ?>
													<a href="javascript:void(0);" class="btn btn-nav btn-ka-blue"
													   id="next">
														<i class="fa fa-chevron-right"></i>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="row mb-3">
								<div class="col h4">
									<b id="judulMateri"> <?= $materiActive["nama_materi"]; ?></b>
									<button id="fileRequest" class="btn btn-primary"
											value="<?= $materiActive['pdf_file'] ?>">Download PDF
									</button>
									<?php if ($materiActive['webinar_status'] == 1): ?>
										<div class="modal fade" id="absenModal"
											 tabindex="-1"
											 aria-labelledby="absenModalLabel"
											 aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title text-dark"
															id="absenModalLabel">
															Absen</h5>
														<button type="button" class="close" data-dismiss="modal"
																aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														<div class="form-group">
															<form
																action="<?= base_url('absen/') . $mapel["id_mapel"] . '/' . $materiActive['id_materi'] ?>"
																method="post">
																<label class="col-form-label text-dark">
																	Kode Absen
																</label>
																<input type="text" class="form-control"
																	   name="kode_absen" required>
																<div class="modal-footer">
																	<button type="submit" class="btn btn-success">
																		Submit
																	</button>
																</div>
															</form>
														</div>
													</div>

												</div>
											</div>
										</div>
									<?php endif ?>
								</div>
							</div>
							<div class="row mb-3">
								<div class="col">
									<?= ($materiActive["deskripsi_materi"] != "") ? $materiActive["deskripsi_materi"] : "Berikut materi " . $materiActive["tipe"] . " untuk " . $materiActive["nama_materi"]; ?>
								</div>
							</div>
							<?php $this->load->view("front-v2/materi/materi-asset"); ?>

							<div class="row mb-3">
								<div class="col">
									<div class="border-top border-warning pt-3">
										<div class="h4 font-weight-bolder">
											Forum Diskusi
										</div>
									</div>
								</div>
							</div>
							<?php
							$this->load->view("front-v2/layout/diskusi");
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<div class="modal" tabindex="-1" role="dialog" id="kuis-modal-end">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Melanjutkan Ke Materi Selanjutnya ?</h5>
			</div>
			<div class="modal-body">
				<p>Anda yakin telah selesai mempelajari materi ini?</p>
			</div>
			<div class="modal-footer">
				<a href="<?= $materiAkhir ? "javascript:void(0);" : $linkSelanjutnya ?>" class="btn btn-warning"
				   id="kuis-modal-end-ya">Ya</a>
				<button type="button" class="btn btn-secondary" data-dismiss="modal" id="kuis-modal-end-tidak">Tidak
				</button>
			</div>
		</div>
	</div>
</div>
