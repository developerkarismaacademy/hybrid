<div class="text-center mx-auto" id="kuis-selesai">
	<div class="container-fluid">
		<div class="row d-flex justify-content-center">
			<div class="col-12 col-md-8 bg-ka-light p-5">
				<div class="row">
					<div class="col-12 mb-3">
						<div id="kuis-nilai-container">
							<span id="kuis-nilai">
								<?= number_format($logUjian["data"]["nilai"], 0) ?>
							</span>
							<img src="<?= base_url() ?>assets/front/v2/img/kuis/kuis-done.gif" class="lazy img-fluid"
								 alt="">
						</div>
					</div>
					<div class="col-12 font-mons font-weight-bold">
						<button onclick="retake()" class="btn btn-primary btn-lg px-4 mb-3 mb-lg-0" type="button">
							RETAKE KUIS
						</button>
						<?php $minNilai = 80; ?>
						<?php if ($bab['pretest_status'] == 1): ?>
							<?php $minNilai = 1; ?>
						<?php endif; ?>
						<?php if (number_format($logUjian["data"]["nilai"], 0) >= 80 || ($bab['pretest_status'] == 1 && number_format($logUjian["data"]["nilai"], 0) >= 1)): ?>
							<a class="btn btn-danger btn-lg px-4"
							   href="<?= $materiAkhir ? "javascript:void(0);" : $linkSelanjutnya ?>">MATERI
								SELANJUTNYA</a>
						<?php else: ?>
							<div class="mt-3 small">Minimal nilai <?= $minNilai?> untuk lanjut</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
