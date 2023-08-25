<div class="fill bg-ka-dark">
	<section id="tentang">
		<div class="container">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-12 col-md tab-content">
							<div class="row mb-3 border-bottom border-ka-light no-gutters">
								<div class="col-12 col-md-8">
									<ul class="nav profil-tab nav-fill" id="profil-tab" role="tablist">
										<li class="nav-item">
											<a class="nav-link py-2 active" id="tentang-1-list" data-toggle="tab"
											   href="#tentang-1" role="tab" aria-controls="tentang-1"
											   aria-selected="false">Tentang Kami</a>
										</li>
										<li class="nav-item">
											<a class="nav-link py-2" id="tentang-2-list" data-toggle="tab"
											   href="#tentang-2" role="tab" aria-controls="tentang-2"
											   aria-selected="false">Kontak Kami</a>
										</li>
										<li class="nav-item">
											<a class="nav-link py-2" id="tentang-3-list" data-toggle="tab"
											   href="#tentang-3"
											   role="tab" aria-controls="tentang-3-materi"
											   aria-selected="false">Bantuan</a>
										</li>
									</ul>
								</div>
							</div>
							<?php
							$this->load->view("front-v2/tentang/tentang-kami");
							?>
							<?php
							$this->load->view("front-v2/tentang/kontak-kami");
							?>
							<?php
							$this->load->view("front-v2/tentang/bantuan");
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
