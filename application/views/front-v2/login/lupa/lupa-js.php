<script>
	// VERIFICATION CODE KETIK DAN JALAN
	$(function () {
		'use strict';

		var lupa2 = $('#pills-lupa2');

		function goToNextInput(e) {
			var key = e.which,
					t = $(e.target),
					sib = t.next('input');

			if (key != 9 && (key < 48 || key > 57)) {
				e.preventDefault();
				return false;
			}

			if (key === 9) {
				return true;
			}

			if (!sib || !sib.length) {
				sib = lupa2.find('input').eq(0);
			}
			sib.select().focus();
		}

		function onKeyDown(e) {
			var key = e.which;

			if (key === 9 || (key >= 48 && key <= 57)) {
				return true;
			}

			e.preventDefault();
			return false;
		}

		function onFocus(e) {
			$(e.target).select();
		}

		lupa2.on('keyup', 'input', goToNextInput);
		lupa2.on('keydown', 'input', onKeyDown);
		lupa2.on('click', 'input', onFocus);

	})
	$("button[data-pill-target]").click(function () {
		pills = $(this).attr("data-pill-target");
		$(pills).trigger("click");
	});
</script>
