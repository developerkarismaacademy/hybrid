<!--DETAIL KELAS-->
<div class="fill bg-ka-dark">
	<section id="kelas-detail">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-12">
					<div class="card">
						<div class="card-img-top" id="konten">
							<div class="row no-gutter">
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
								<div class="col-12">
									<div id="player" data-plyr-provider="youtube"
										 data-plyr-embed-id="<?= $materiActive["url_video"]; ?>">

									</div>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="row mb-3">
								<div class="col h4">
									<b> <?= $materiActive["nama_materi"]; ?></b>
									<span class="small text-secondary"
										  id="duration">(<?= $this->FrontMateriModel->convertDurasi("toHMS", $materiActive["durasi"]); ?>)</span>
								</div>
							</div>
							<div class="row mb-3">
								<div class="col">
									<?= ($materiActive["isi_materi"] != "") ? $materiActive["isi_materi"] : "Berikut materi " . $materiActive["tipe"] . " untuk " . $materiActive["nama_materi"]; ?>
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


<div class="modal show" tabindex="-1" role="dialog" id="kuis-modal-end">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header border-0">
				<h5 class="modal-title mx-auto text-secondary">Melanjutkan Ke Materi Selanjutnya ?</h5>
			</div>

			<div class="modal-body text-center font-weight-bolder h6">
				<button type="button" class="btn btn-secondary mx-2" data-dismiss="modal" id="kuis-modal-end-tidak">
					Tidak
				</button>
				<a href="<?= $materiAkhir ? "javascript:void(0);" : $linkSelanjutnya ?>" class="btn btn-success mx-2"
				   id="kuis-modal-end-ya">Lanjutkan</a>
			</div>
		</div>
	</div>
</div>
