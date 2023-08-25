<!--DETAIL PRAKTEK-->
<div class="fill bg-ka-dark">
	<section id="kelas-detail">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-12">
					<div class="card">
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
									<div class="bg-ka-grey">
										<div class="container" id="materi-kuis-isi">
											<?php $this->load->view("front-v2/materi/materi-praktek/praktek-aktif") ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="row mb-3">
								<div class="col h4">
									<b> <?= $materiActive["nama_materi"]; ?></b>
									<span class="small text-secondary"> (Praktek)</span>
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
