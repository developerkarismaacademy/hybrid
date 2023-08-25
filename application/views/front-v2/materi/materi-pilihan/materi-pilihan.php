<?php
if ($logUjian["total"] > 0) {
	$data["jumlahRetake"] = $logUjian["data"]["retake_log_ujian"];

	// retake_log_ujian ditambah satu jika user sudah memilih untuk retake
	$data["allowRetake"] = $data["jumlahRetake"] >= 0 && $data["jumlahRetake"] <= 1;
	$data["retaken"] = true;

	// allowed when
// retake 0-1

	// retaken when
// retake 1-2
	$data["idle"] = $logUjian["data"]["start_time"] == null && $logUjian["data"]["estimasi_time"] == null && $logUjian["data"]["end_time"] == null;
	$data["progress"] = $logUjian["data"]["start_time"] != null && $logUjian["data"]["estimasi_time"] != null && $logUjian["data"]["end_time"] == null;
	$data["done"] = $logUjian["data"]["start_time"] != null && $logUjian["data"]["estimasi_time"] != null && $logUjian["data"]["end_time"] != null;
} else {
	$data = [
		"jumlahRetake" => 0,
		"allowRetake" => true,
		"retaken" => false,
		"idle" => true,
		"progress" => false,
		"done" => false,
	];
}
?>

<!--DETAIL KUIS-->
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
									<div class="bg-white">
										<div class="container font-mons font-weight-bolder" id="materi-kuis-isi">
											<?php
											if ($data["idle"] && !$data["done"]) {
												$this->load->view("front-v2/materi/materi-pilihan/kuis-mulai", $data);
											} else if ($data["progress"] && !$data["done"]) {
												$this->load->view("front-v2/materi/materi-pilihan/kuis-lanjut", $data);
											} else {
												$this->load->view("front-v2/materi/materi-pilihan/kuis-selesai", $data);
											}

											if (!$data["done"]) {
												$this->load->view("front-v2/materi/materi-pilihan/kuis-aktif", $data);
											}
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="row mb-3">
								<div class="col h4">
									<b>
										<?= $materiActive["nama_materi"]; ?>
									</b>
								</div>
							</div>
							<div class="row mb-3">
								<div class="col">
									<?= ($materiActive["deskripsi_materi"] != "") ? $materiActive["deskripsi_materi"] : "Berikut materi " . $materiActive["tipe"] . " untuk " . $materiActive["nama_materi"]; ?>
								</div>
							</div>
							<?php $this->load->view("front-v2/materi/materi-asset"); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
