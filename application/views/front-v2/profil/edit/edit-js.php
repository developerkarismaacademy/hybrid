<script>
	function readURL(input, element) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				element.attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]); // convert to base64 string
		}
	}

	$('a[data-toggle="list"]').on('shown.bs.tab', function (e) {
		$('input[type="password"]').val("")
	})

	$("#gambar_user").on('change', function () {
		readURL(this, $("#gambar_user-container"));
	})
</script>
