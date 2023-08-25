<section id="login" class="bg-ka-dark">
	<div class="container">
		<div class="row login-row">
			<div class="col-lg-6 col-md-12 login-main text-dark order-2 order-lg-1">
				<div class="tab-content tab-animation tab-left mt-3" id="pills-tabContent">
					<div class="tab-pane fade show active" id="pills-ulasan" role="tabpanel"
						 aria-labelledby="pills-ulasan-tab">
						<form method="post" id="form-ulasan">
							<div class="row text-center text-warning">
								<div class="col-12">
									<h5 class="testimoni-title font-weight-bold">Isikan ulasan tentang materi
										<br><br><br></h5>
								</div>
							</div>
							<hr>
							<input type="hidden" id="mapel-id" class="mapel-id" name="mapel_id" readonly>
							<label for="rating">Rating</label>
							<div class="rating-container d-flex justify-content-center flex-row-reverse">
								<input type="radio" id="star5" name="rating" value="5" checked/><label for="star5"
																									   title="5 star"></label>
								<input type="radio" id="star4" name="rating" value="4"/><label for="star4"
																							   title="4 star"></label>
								<input type="radio" id="star3" name="rating" value="3"/><label for="star3"
																							   title="3 star"></label>
								<input type="radio" id="star2" name="rating" value="2"/><label for="star2"
																							   title="2 star"></label>
								<input type="radio" id="star1" name="rating" value="1"/><label for="star1"
																							   title="1 star"></label>
							</div>
							<div class="text-center">Silahkan klik pada bintang</div>
							<div class="form-group">
								<label for="ulasan">Ulasan</label>
								<textarea class="form-control ulasan"
										  id="ulasan" name="ulasan"
										  aria-describedby="text" placeholder="Isi ulasan disini" required></textarea>
							</div>
							<button type="submit"
									class="btn btn-success btn-lg rounded-custom btn-block submit-ulasan"
									id="submit-ulasan">Submit Ulasan
								<i class="fa fa-plus"></i></button>
						</form>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-12 login-banner order-1 order-lg-2">
				<div class="container-fluid">
					<div class="login-brand mb-0 mb-md-3">
						<div class="brand m-auto"></div>
					</div>
					<div class="login-welcome text-warning mb-2">Setelah mengisi, anda akan mendapatkan:</div>

					<div class="login-fitur pt-3 font-mons">
						<?php
						$dummyfitur = [
								"asset-3" => "Sertifikat resmi",
								"asset-2" => "Akses materi ulang",
						];
						foreach ($dummyfitur as $k => $v) {
							?>
							<div class="text-left fitur-child text-truncate">
								<span class="fitur-icon fitur-<?= $k ?>"
									  style="background-image:url('<?= base_url() ?>assets/front/v2/img/<?= $k ?>.png');"></span>
								<span><?= $v ?></span>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Foot Start -->
