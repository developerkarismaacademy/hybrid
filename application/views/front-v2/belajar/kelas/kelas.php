<!--DETAIL KELAS-->
<div class="fill bg-ka-dark">
	<?php
	$this->load->view("front-v2/belajar/kelas/kelas-detail-progress")
	?>

	<section id="kelas-materi-main">
		<div class="container py-3">
			<div class="row justify-content-center">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="row mb-3 border-bottom border-ka-light no-gutters">
								<div class="col-12 col-md-6">
									<ul class="nav nav-fill kelas-materi-tab" id="kelas-materi-tab" role="tablist">
										<li class="nav-item">
											<a class="nav-link py-2 active" id="kelas-materi-list" data-toggle="tab"
											   href="#kelas-materi" role="tab"
											   aria-controls="kelas-materi" aria-selected="true">Materi Kelas</a>
										</li>
										<li class="nav-item">
											<a class="nav-link py-2" id="kelas-diskusi-list" data-toggle="tab"
											   href="#kelas-diskusi" role="tab"
											   aria-controls="kelas-diskusi" aria-selected="false">Forum Diskusi</a>
										</li>
										<?php
										if (isset($this->db->dev)) { ?>
											<li class="nav-item">
												<a class="nav-link py-2" id="kelas-poin-list" data-toggle="tab"
												   href="#kelas-poin" role="tab"
												   aria-controls="kelas-poin" aria-selected="false">Poin</a>
											</li>
											<?php
										}
										?>
									</ul>
								</div>
							</div>
							<?php
							$this->load->view("front-v2/belajar/kelas/kelas-materi")
							?>
							<?php
							$this->load->view("front-v2/belajar/kelas/kelas-diskusi")
							?>

							<?php
							if (isset($this->db->dev)) {
								$this->load->view("front-v2/belajar/kelas/kelas-poin");
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>


<?php
$this->load->view("front-v2/layout/diskusi-modal-hapus")
?>


<?php
if ($mapel["progress"] >= 100 && !$ulasan) {
	$this->load->view("front-v2/layout/modal-ulasan");
}
?>
