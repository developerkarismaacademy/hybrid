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
										<div class="container" id="materi-teks-isi">
											<?= $materiActive["isi_materi"]; ?>
										</div>
										<div class="container">
											<div class="row mb-3 mt-3">
												<div class="col-12 my-2">
													<h4 class="text-center" style="color: #000" id="total-halaman">
														0/0
													</h4>
												</div>
												<div class="col-12" id="kuis-navigasi">
													<a class="btn btn-ka-blue" id="page-nav-prev"><i
																class="fa fa-chevron-left"></i>
													</a>
													<a href="javascript:selesai();" class="btn btn-danger"
													   id="page-end"><i class="fa fa-check"></i> Selesai
													</a>
													<a href="javascript:void(0);" class="btn btn-nav btn-ka-blue"
													   id="page-nav-next"><i
																class="fa fa-chevron-right"></i></a>
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
									<b> <?= $materiActive["nama_materi"]; ?></b>
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
