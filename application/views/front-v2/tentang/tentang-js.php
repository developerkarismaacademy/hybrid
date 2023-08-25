<script>
	$("document").ready(function () {
		hashchanged();
	});
	//Prevent when choose kursus dropdown from same page
	$(window).on('hashchange', function (e) {
		hashchanged();
	});

	function hashchanged() {
		var hash = window.location.hash.substr(1);
		if (hash != "") {
			setTimeout(function () {
				$("#" + hash + "-list").trigger('click');
			}, 10);
		}
	}
</script>
