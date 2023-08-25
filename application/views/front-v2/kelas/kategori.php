<div class="container pb-0 pt-0">
	<div class="row d-flex justify-content-center no-gutters">
		<div class="col-12  col-lg mb-lg-0 mb-3 text-center text-lg-left">
			<span class="h6 mr-3">PILIH KATEGORI</span>
		</div>
		<div class="col-12 col-lg-10">
			<div class="btn-group-toggle" data-toggle="buttons" id="kategori-elemen">
				<label class="kursus-pilih-btn btn btn-outline-ka-blue mb-3 mr-2">
					<input type="radio" name="kategori" id="option-undefined" autocomplete="off" value="0"> Semua
				</label>
				<?php
				foreach ($dataKelas["data"] as $val) { ?>
					<label class="kursus-pilih-btn btn btn-outline-ka-blue mb-3 mr-2" for="option-<?= $val["meta_link_kelas"] ?>">
						<input type="radio" name="kategori" id="option-<?= $val["meta_link_kelas"] ?>"
							data-namakursus="<?= $val["meta_link_kelas"] ?>" autocomplete="off"
							value="<?= $val["id_kelas"] ?>">
						<?= $val["nama_kelas"] ?>
					</label>
				<?php
				}
				?>
			</div>
		</div>
	</div>
</div>
