<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
	$(document).ready(function () {
		$('#example').DataTable({
			processing: true
		});

	});
	$(document).ready(function () {
		var $disabledResults = $(".js-example-disabled-results");
		$disabledResults.select2();
	});

	$(document).ready(function () {
		$('#mapel-id').change(function (e) {
			$('.materi-list').remove();
			const metaLinkMapel = $('#mapel-id').val();
			$.ajax({
				url: `<?= base_url('api/v1/MateriApi/getMateri/')?>${metaLinkMapel}`,
				method: 'GET',
				success: function (response) {
					if (response.success === true) {
						response.data.map(function (data) {
							const materiId = data.id_materi;
							const materiName = data.nama_materi;
							$('#materi-id').append(`<option class="materi-list" value="${materiId}">${materiName}</option>`)
						})
					}
				}
			})
		})
	})
</script>
