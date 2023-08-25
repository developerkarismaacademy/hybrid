<section id="kursus-rekomendasi" class="bg-ka-dark kelas-parent">
	<div class="container">
		<div class="row p-0  my-5">
			<div class="col-12 h4">
				<b>Rekomendasi</b> Kelas Lainnya
			</div>
			<?php
			if ($mapelRekom["total"] > 0) {
				$data["idClone"] = "3";
				foreach ($mapelRekom["data"] as $keyMapel => $valueMapel) {
					?>
					<div class="col-lg-3 col-md-6 mb-4">
						<?php
						$data["keyMapel"] = $keyMapel;
						$data["valueMapel"] = $valueMapel;
						$this->load->view("front-v2/layout/kelas", $data);
						?>
					</div>
					<?php
				}
			}
			?>
		</div>
	</div>
</section>
