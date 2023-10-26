<div class="fill bg-ka-dark">
	<section id="profil-edit-navigasi" role="tabpanel" aria-labelledby="kelas-saya-list"
			 aria-selected="true">
		<div class="container py-0 py-md-4">
			<!--MINI NAVIGASI-->
			<div class="row navigate-text">
				<div class="col-0 ml-3 position-absolute float-left" style="z-index:2;">
					<a href="<?= base_url("profil") ?>">
						<i class="fa fa-arrow-left text-warning"></i> Kembali
					</a>
				</div>
				<div class="col-12 text-center">
					Edit Profil
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-md-4 px-0">
					<div class="list-group list-group-nav" id="profil-edit-filter" role="tablist">
						<a class="list-group-item list-group-item-action active" id="filter-profil-list"
						   data-toggle="list"
						   href="#filter-profil" role="tab" aria-controls="semua-1">
							Profil
						</a>
						<a class="list-group-item list-group-item-action" id="filter-password-list" data-toggle="list"
						   href="#filter-password" role="tab" aria-controls="password">
							Password
						</a>
					</div>
				</div>
				<div class="col-12 col-md">
					<div class="tab-content" id="profil-edit-list">
						<div class="tab-pane fade show active" id="filter-profil" role="tabpanel"
							 aria-labelledby="filter-profil">
							<form method="post" id="form-user" enctype="multipart/form-data">
								<div class="row d-flex align-items-stretch h-100 px-md-3 px-0">
									<div class="col-lg-6 col-md-12 edit-profil-banner d-flex flex-column">

										<div class=" m-auto">
											<div class="edit-profil-text">Ganti Foto Profil</div>
											<div class="edit-profil-picture my-3 mx-auto">
												<img src="<?= is_file_return('user', base_url('/upload/profile-picture/' . $this->session->siswaData["gambar_user"])) ?>"
													 alt=""
													 class="rounded-circle object-cover" id="gambar_user-container"
													 width="130px" height="130px">
											</div>
											<label class="btn btn-warning btn-rounded btn-block">
												<span>
													<i class="fa fa-arrow-up"></i><span class="ml-2">Unggah Foto</span>
												</span>

												<input type="file" class="" accept="image/*" name="gambar_user"
													   id="gambar_user" hidden>
												</input>
											</label>
											<div class="text-center <?= (form_error('gambar_user') != "") ? " is-invalid " : "" ?>">
												<?php if (form_error('gambar_user') != ""): ?>
													<div class="invalid-feedback mt-2">
														<?= form_error('gambar_user'); ?>
													</div>
												<?php endif; ?>
											</div>
										</div>
									</div>
									<div class="col-lg-6 col-md-12 edit-profil-main bg-white py-3">
										<div class="form-dark form-radius">
											<div class="form-group">
												<label for="nama_user">Nama Lengkap</label>
												<input type="text"
													   class="form-control <?= (form_error('nama_user') != "") ? " is-invalid " : "" ?>"
													   id="nama_user" name="nama_user"
													   value="<?= $nama_user ?>"
													   aria-describedby="nama_user"
													   placeholder="Nama User Lengkap . . .">

												<?php if (form_error('nama_user') != ""): ?>
													<div class="invalid-feedback mt-2">
														<?php echo form_error('nama_user'); ?>
													</div>
												<?php endif; ?>
											</div>
											<div class="form-group">
												<label for="username">Username</label>
												<input type="text"
													   class="form-control <?= (form_error('username') != "") ? " is-invalid " : "" ?>"
													   id="username" name="username"
													   value="<?= $username ?>"
													   aria-describedby="username" placeholder="Username . . ." style="text-transform: lowercase">

												<?php if (form_error('username') != ""): ?>
													<div class="invalid-feedback mt-2">
														<?php echo form_error('username'); ?>
													</div>
												<?php endif; ?>
											</div>
											<div class="form-group">
												<label for="email_user">Email</label>
												<input type="email_user"
													   class="form-control <?= (form_error('email_user') != "") ? " is-invalid " : "" ?>"
													   id="email_user" name="email_user"
													   value="<?= $email_user ?>"
													   aria-describedby="email_user" placeholder="Email . . ." style="text-transform: lowercase">

												<?php if (form_error('email_user') != ""): ?>
													<div class="invalid-feedback mt-2">
														<?php echo form_error('email_user'); ?>
													</div>
												<?php endif; ?>
											</div>
											<div class="form-group">
												<label for="editNo">No. Handphone</label>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text" id="editNo">+62</span>
													</div>


													<input type="text"
														   class="form-control <?= (form_error('telepon_user') != "") ? " is-invalid " : "" ?>"
														   id="telepon_user" name="telepon_user"
														   value="<?= substr($telepon_user, 1, strlen($telepon_user)) ?>"
														   aria-describedby="telepon_user" placeholder="No. Handphone">

													<?php if (form_error('telepon_user') != ""): ?>
														<div class="invalid-feedback mt-2">
															<?php echo form_error('telepon_user'); ?>
														</div>
													<?php endif; ?>
												</div>
											</div>
											<div class="form-group">
												<label for="jk_user">Jenis Kelamin</label>
												<div class="container-fluid">
													<div class="row">
														<div class="custom-control custom-radio col-6">
															<input type="radio" class="custom-control-input"
																   id="jk_user1"
																   name="jk_user" <?= $jk_user == "Laki-laki" ? " CHECKED " : "" ?>
																   value="Laki-laki">
															<label class="custom-control-label"
																   for="jk_user1">Laki-laki</label>
														</div>
														<div class="custom-control custom-radio col-6">
															<input type="radio" class="custom-control-input"
																   id="jk_user2"
																   name="jk_user" <?= $jk_user == "Perempuan" ? " CHECKED " : "" ?>
																   value="Perempuan">
															<label class="custom-control-label"
																   for="jk_user2">Perempuan</label>
														</div>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label for="tempat_lahir">Tempat Lahir</label>
												<input type="text"
													   class="form-control <?= (form_error('tempat_lahir') != "") ? " is-invalid " : "" ?>"
													   id="tempat_lahir" name="tempat_lahir"
													   value="<?= $tempat_lahir ?>"
													   aria-describedby="tempat_lahir" placeholder="Kota . . .">

												<?php if (form_error('tempat_lahir') != ""): ?>
													<div class="invalid-feedback mt-2">
														<?php echo form_error('tempat_lahir'); ?>
													</div>
												<?php endif; ?>
											</div>
											<div class="form-group">
												<label for="editTanggal">Tanggal Lahir</label>
												<div class="container-fluid">
													<div class="row">
														<div class="col-3 pl-0 pr-2">
															<select name="tanggal" class="form-control">
																<?php

																$tanggal = date("j", strtotime($tanggal_lahir));
																$bulan = date("n", strtotime($tanggal_lahir));
																$tahun = date("Y", strtotime($tanggal_lahir));

																for ($i = 1; $i <= 31; $i++) {
																	?>
																	<option <?= $i == $tanggal ? "selected" : "" ?>
																			value="<?= $i ?>"><?= $i ?></option>
																	<?php
																} ?>
															</select>
														</div>
														<div class="col px-2">
															<select name="bulan" class="form-control">
																<?php
																foreach (bulan as $key => $value) {
																	if ($key != 0) {
																		?>
																		<option <?= $key == $bulan ? "selected" : "" ?>
																				value="<?= $key ?>"><?= $value ?></option>
																		<?php
																	}
																} ?>
															</select>
														</div>
														<div class="col pl-2 pr-0">
															<select name="tahun" class="form-control">
																<?php
																for ($i = 1950; $i <= date('Y'); $i++) {
																	?>
																	<option <?= $i == $tahun ? "selected" : "" ?>
																			value="<?= $i ?>"><?= $i ?></option>
																	<?php
																} ?>
															</select>
														</div>
													</div>
												</div>
											</div>
											<div class="text-center">
												<button type="submit" class="btn btn-warning btn-rounded btn-block">
													<b>SIMPAN PERUBAHAN</b>
												</button>
											</div>
										</div>
									</div>
								</div>
							</form>

						</div>
						<div class="tab-pane fade" id="filter-password" role="tabpanel"
							 aria-labelledby="filter-password">
							<div class="row d-flex align-items-stretch h-100 px-md-3 px-0">
								<div class="col-lg-6 col-md-12 edit-profil-main bg-white py-3">
									<form method="post" class="form-dark">
										<div class="form-group">
											<label for="editPasswordLama">Password Lama</label>
											<div class="input-group input-group-custom">
												<input type="password" class="form-control password-field "
													   id="editPasswordLama"
													   name="editPasswordLama"
													   placeholder="Password Lama">
												<span class="icon-inside">
													<i class="fa fa-eye-slash"></i>
												</span>
											</div>
										</div>
										<div class="form-group">
											<label for="editPassword1">Password Baru</label>
											<div class="input-group input-group-custom">
												<input type="password" class="form-control password-field "
													   id="editPassword1"
													   name="editPassword1"
													   placeholder="Password Baru">
												<span class="icon-inside">
													<i class="fa fa-eye-slash"></i>
												</span>
											</div>
										</div>
										<div class="form-group">
											<label for="editpassword2">Konfirmasi Password</label>
											<div class="input-group input-group-custom">
												<input type="password" class="form-control password-field "
													   id="editPassword2"
													   name="editPassword2"
													   placeholder="Konfirmasi Password">
												<span class="icon-inside">
													<i class="fa fa-eye-slash"></i>
												</span>
											</div>
										</div>
										<div class="text-center">
											<button type="submit" class="btn btn-warning btn-rounded btn-block">
												<b>SIMPAN PERUBAHAN</b>
											</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
