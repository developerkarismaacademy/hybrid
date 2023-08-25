<!--KURSUS HEAD-->
<div class="fill bg-ka-dark" id="kursus-container">
	<!--MINI NAVIGASI-->
	<section id="mini-navigasi">
		<div class="container">
			<div class="row navigate-text">
				<div class="col-12">
					<form id="form-search">
						<div class="input-group mb-3">
							<input id="search" name="kursus-cari-input" type="text" class="form-control"
								   placeholder="Cari Kursus Online. . ." aria-label="Cari Kursus Online. . ."
								   aria-describedby="kursus-cari-input">
							<div class="input-group-append">
								<button class="btn btn-warning font-weight-bold" type="submit"><i
											class="fa fa-search"></i> CARI
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
	<!--KURSUS PILIH-->
	<section id="kursus-pilih" data-kursus="semua">
		<?php
		$this->load->view("front-v2/kelas/kategori");
		?>
	</section>
	<!--KURSUS LIST-->
	<section id="kursus-list" data-kursus="semua">
		<?php
		$this->load->view("front-v2/layout/kelas-ajax");
		?>
	</section>

	<section id="kursus-none" class="d-none text-center p-5">
		<h3>Daftar Materi Tidak Ditemukan</h3>
		<a href="<?= base_url() ?>" class="btn btn-success mt-3"><i class="fa fa-home"></i> Kembali ke Halaman Utama</a>
		<a href="javascript:$('#search').focus();" class="btn btn-warning mt-3"><i class="fa fa-search"></i> Cari dengan
			Kata Kunci Lain</a>
	</section>
</div>
