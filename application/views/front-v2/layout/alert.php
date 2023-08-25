<?php
if (isset($_SESSION['alert'])) {
	if (count($_SESSION['alert']) > 0) {
		?>

		<?php
		foreach ($_SESSION['alert'] as $key => $item) {
			echo $item;
		}
		?>

		<?php
		$_SESSION['alert'] = NULL;
	}
}
?>


