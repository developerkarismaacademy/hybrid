<div class="fill bg-ka-dark" id="profil">
	<section>
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-4 list-group" id="profil-kelas-filter" role="tablist">
					<div class="list-group-item list-group-nav list-group-item-action">
						<div class="row text-center">
							<div class="col-12 pb-4 text-center mx-auto">
								<img src="<?= is_file_return('user', base_url('/upload/profile-picture/' . $this->session->siswaData["gambar_user"])) ?>" alt="" class="rounded-circle object-cover" width="100px" height="100px">
							</div>
							<div class="col-12 pb-4">
								<h5 class="mt-0" style="text-transform: capitalize"><?= $this->session->siswaData["nama_user"] ?? "" ?></h5>
								<a class="mb-0" href="<?= base_url("profil/edit") ?>">Edit Profil <i class="fa fa-pencil text-warning"></i></a>
							</div>
						</div>
					</div>

					<a class="list-group-item list-group-nav list-group-item-action active" id="kelas-saya-list" data-toggle="tab" href="#kelas-saya" role="tab" aria-controls="kelas-saya" aria-selected="true">
						Kelas Saya
					</a>
					<a class="list-group-item list-group-nav list-group-item-action" id="daftar-pembelian-list" data-toggle="tab" href="#daftar-pembelian" role="tab" aria-controls="daftar-pembelian" aria-selected="false">
						Daftar Pembelian
					</a>

					<a class="list-group-item list-group-nav list-group-item-action" id="daftar-sertifikat-list" data-toggle="list" href="#daftar-sertifikat" role="tab" aria-controls="daftar-sertifikat" aria-selected="false">
						Daftar Sertifikat
					</a>

					<a class="list-group-item list-group-nav list-group-item-action" id="daftar-sertifikat-list" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap" href="#voucher" role="tab" aria-controls="daftar-sertifikat" aria-selected="false">
						Tukar Voucher
					</a>
					<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title text-dark" id="exampleModalLabel">Voucher</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<div class="form-group">
										<label for="recipient-name" class="col-form-label text-dark">
											Claim Voucher anda
										</label>

										<form action="<?= base_url('voucher/tukar') ?>" method="post">
											<input placeholder="AU23900001F" type="text" class="form-control" name="kode_voucher" required>
											<div class="modal-footer">
												<button type="submit" class="btn btn-success">Submit</button>
											</div>
										</form>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
				<?php $this->load->view("front-v2/profil/detail/detail-kelas.php") ?>
				<?php $this->load->view("front-v2/profil/detail/detail-pembelian.php") ?>
				<?php $this->load->view("front-v2/profil/detail/detail-sertifikat.php") ?>

			</div>
		</div>
	</section>
</div>