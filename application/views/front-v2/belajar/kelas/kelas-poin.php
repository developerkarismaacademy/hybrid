<div id="kelas-poin" aria-labelledby="kelas-poin-list" aria-selected="false" class="tab-pane fade" role="tabpanel">
	<div class="container-fluid">
		<?php
		for ($i = 1; $i <= 3; $i++) {
			?>
			<div class="row d-flex align-items-center py-3 border-bottom border-ka-light">
				<div class="col-1">
					<h3><b><?= $i ?></b></h3>
				</div>
				<div class="col-3 col-lg-1">
					<img class="mr-3 img-fluid rounded-circle"
						 src="<?= base_url() ?>assets/front/v2/img/foto-instruktur.png" alt="Gambar">
				</div>
				<div class="col">
					<p class="font-weight-bold">Fizi Azmi</p>
					<p class="text-warning small  font-weight-bold"><?= 2001 - $i ?> Poin</p>
				</div>
				<div class="col-12 col-lg-2 mt-3 mt-lg-0">
					<a href="<?= base_url("profil") ?>"
					   class="text-roboto font-weight-light btn btn-outline-ka-dark btn-block">
						Lihat Profil
					</a>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</div>
