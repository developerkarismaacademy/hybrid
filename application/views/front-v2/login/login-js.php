<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 6/9/2020
 * Time: 3:57 PM
 */

?>
<script src="<?= base_url() ?>assets/front/v2/plugins/customscrollbar/js/jquery.mCustomScrollbar.min.js">

</script>
<script type="text/javascript">

	(function ($) {
		$(window).on("load", function () {
			$(".login-main").mCustomScrollbar({
				theme: "dark"
			});
		});
	})(jQuery);

	$("#loginLupa").click(function () {
		swalBootstrap.fire({
			title: 'Hubungi Admin',
			text: 'Kontak admin untuk mereset password',
			icon: 'info',
			confirmButtonText: 'Baik, akan saya hubungi admin',
			closeOnConfirm: true,
		});
	});

</script>
