<script type="text/javascript">
	<?php
	// BUTTON
	$sesi = 0;
	if ($this->session->userdata("siswaData")) {
		$sesi = 1;

		$sesiMapel = $_SESSION["idMapelBeli"];
	}
	?>
	var activeMapel = [<?=(isset($sesiMapel) ? join(", ", $sesiMapel) : "''")?>], sesi = <?=$sesi?>;

</script>

<script src="<?= base_url(); ?>/assets/front/v2/pages/kategori/kategori.js" type="text/javascript">
</script>
