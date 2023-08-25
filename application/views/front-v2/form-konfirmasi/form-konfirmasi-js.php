<script type="text/javascript">
	function ganti_bank(value) {
		<?php
		foreach (bank as $key => $val) {
		?>
		$('#bank-<?= $key ?>').addClass("d-none");
		<?php } ?>
		$('#bank-' + value.toLowerCase()).removeClass("d-none");
	}

	ganti_bank('<?= strtolower($pembelian["bank_karisma"]) ?>');

	//read image
	var reader = new FileReader();
	reader.onload = function (e) {
		$('#preview_bukti').attr('src', e.target.result);
	}

	function readURL(input) {
		if (input.files && input.files[0]) {
			reader.readAsDataURL(input.files[0]);
			$("#preview_bukti").removeClass("d-none");
		}
	}

	$("input[name='bukti_pembayaran']").change(function () {
		readURL(this);
	});
</script>
