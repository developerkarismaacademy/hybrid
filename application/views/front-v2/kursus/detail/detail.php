<!--KURSUS-DETAIL-->
<?php
$this->load->view("front-v2/kursus/detail/kursus-deskripsi");
?>
<!--KURSUS-LIST-->
<?php
$this->load->view("front-v2/kursus/detail/kursus-list-mapel");
?>
</section>
<!--ULASAN-->
<?php
if ($total_bintang > 0) {
	$this->load->view("front-v2/kursus/detail/kursus-ulasan");
}
?>
<!--REKOMENDASI-->
<?php
$this->load->view("front-v2/kursus/detail/kursus-rekomendasi");
?>
<!--KURSUS-HARGA-->
<?php
$this->load->view("front-v2/kursus/detail/kursus-harga");
?>

<div class="modal" tabindex="-1" role="dialog" id="vidModal">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="row">
					<div class="col" id="intro">
						<div id="player" data-plyr-provider="youtube"
							 data-plyr-embed-id="<?= $mapel["intro_video"]; ?>">
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
</div>
