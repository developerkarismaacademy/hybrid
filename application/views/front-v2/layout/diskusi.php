<div class="container-fluid px-0">
	<div id="diskusi-container" aria-labelledby="diskusi-container-list">
		<div class="container-fluid d-flex flex-column">
			<?php
			if (!isset($idMateri)) { ?>
				<div class="row card diskusi-new">
					<div class="col card-body py-0">
						<div class="row justify-content-center">
							<div class="col-2 col-lg-1 diskusi-photo-container">
								<img class="mr-3 img-fluid rounded-circle"
									 src="<?= base_url('upload/profile-picture/' . $this->session->siswaData["gambar_user"]) ?>"
									 alt="Gambar">
							</div>
							<div class="col col-lg diskusi-form-container">
								<form method="POST" enctype="multipart/form-data" id="form-diskusi">
									<input type="hidden" readonly id="id-mapel" name="mapel_id"
										   value="<?= (isset($id['mapel'])) ? $id['mapel'] : '' ?>">
									<input type="hidden" readonly id="id-bab" name="bab_id"
										   value="<?= (isset($id['bab'])) ? $id['bab'] : '' ?>">
									<input type="hidden" readonly id="id-materi" name="materi_id"
										   value="<?= (isset($id['materi'])) ? $id['materi'] : '' ?>">
									<div class="row">
										<div class="col-12 mb-3">
                                        <textarea class="diskusi-input" id="diskusi-input-0" name="isi">
                                        </textarea>
										</div>
										<div class="col-12 text-right">
											<button type="reset"
													onClick="CKEDITOR.instances['diskusi-input-0'].setData( '', function() { this.updateElement(); } )"
													class="btn text-white px-4">BATAL
											</button>
											<button type="submit" class="btn btn-success px-4">KIRIM</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			$img = base_url('assets/front/v2/img/foto-instruktur.png');
			?>
			<div class="container-fluid" id="diskusi-container">
				<div class="row mt-lg-2 mb-2 pt-4 d-none" data-name="diskusi-lain" id="clone-data">
					<div class="col-2 col-lg-1">
						<img class="mr-3 rounded-circle diskusi-foto-user object-cover" style="width:60px;height:60px"
							 src="<?= $img ?>" alt="Gambar">
					</div>
					<div class="col">
						<div class="row">
							<div class="col mb-lg-0">
								<b class="diskusi-nama-user">{Nama User}</b> <small class="text-secondary"><span
											class="diskusi-time ">{time}</span> <?php //<span class="diskusi-modified"></span> ?>
								</small>
								<span class="diskusi-menu btn-group dropup ml-1"></span>
								<div class="diskusi-teks">
								</div>
								<div class="diskusi-action row mt-3 mb-2">
									<div class="reply-action col-offset-3 col">
										<a href='#' class="reply-btn btn btn-no-hover-color btn-outline-success">
											<i class="reply-icon text-success fa fa-reply mr-2"></i>
											<span class="text-white text-roboto font-weight-light"> Balas </span>
										</a>
									</div>
									<?php //<div class="edit-action col"></div> ?>
								</div>

								<div class="reply-container row mt-lg-2 mb-2 pt-4 border-top border-ka-light d-none">
								</div>
							</div>
						</div>
						<div id="jawaban-container" style="display:none;">
							<div data-name="jawaban-lain" class="row mt-lg-2 mb-2 pt-4 border-top border-ka-light"
								 id="clone-sub-data">
								<div class="col-2 col-lg-1">
									<img class="rounded-circle jawaban-foto-user object-cover"
										 style="width:40px;height:40px" src="<?= $img ?>" alt="Gambar">
								</div>
								<div class="col">
									<div class="row">
										<div class="col">
											<b class="jawaban-nama-user">{Nama User}</b> <small
													class="text-secondary"><span
														class="jawaban-time ">{time}</span> <?php //<span class="jawaban-modified"></span>?>
											</small>
											<span class="jawaban-menu btn-group dropup ml-1">
                                            </span>
											<div class="jawaban-jawabanke mb-2"></div>
											<div class="jawaban-teks">

											</div>
											<div class="jawaban-action row mt-3">
												<?php //<div class="edit-action col"></div> ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row diskusi-notif">
				<div class="col-12 text-center diskusi-loading">
					<i class="fa fa-spinner fa-spin fa-4x"></i>
					<h2>Mohon Tunggu</h2>
				</div>
				<div class="col-12 text-center diskusi-zero d-none">

					<p class="h5 font-weight-lighter">Kolom diskusi masih kosong. Jadilah pertama yang memulai</p>
				</div>
			</div>
		</div>
	</div>
</div>
