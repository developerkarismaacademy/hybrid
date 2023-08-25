<?php
if (isset($mapel)) { ?>
	<script type="text/javascript">

		$("#keranjang-left [id^=collapse-]").on('hidden.bs.collapse', function () {
			id = $(this).attr("id");
			$("i[aria-controls='" + id + "'").removeClass("fa-minus").addClass("fa-plus");
		})
		$("#keranjang-left [id^=collapse-]").on('show.bs.collapse', function () {
			id = $(this).attr("id");
			$("i[aria-controls='" + id + "'").removeClass("fa-plus").addClass("fa-minus");
		})

		function pilihBank(bank) {
			$("#btnCheckout").attr("href", "<?= base_url("front-v2/Beli/SimpanBeli/{$mapel["meta_link_mapel"]}") ?>?bank=" + bank + "&voucher=<?= $_GET["voucher"] ?? "" ?>");
		}

		function alertTransaksi() {
			toastr["error"]("Pilih Bank Terlebih Dahulu");
		}

	</script>
	<?php
}
?>
