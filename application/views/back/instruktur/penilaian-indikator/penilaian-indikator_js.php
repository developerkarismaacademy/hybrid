<script>

	var loading = false;
	var loadingFormElement = $('.loading-form');
	var urlSimpanIndikatorApi = base_url_api + "/ProgressApi/simpanNilaiIndikator";

	loadingFormElement.hide();


	function simpanNilaiIndikator(id, nilai) {
		var request = $.ajax({
			url: urlSimpanIndikatorApi,
			data: {
				user_id: <?= $siswa["id_user"] ?>,
				indikator_id: id,
				nilai: nilai,
			},
			type: 'POST',
		});

		request.done(function (xhr, status, error) {
			if (xhr.success) {
				toastr["success"]("Sukses", "Berhasil Menyimpan Data");

			} else {
				toastr["error"]("Gagal", "Gagal Menyimpan Data");
			}
		});

		request.always(function (xhr, status, error) {
			loading = false;
			loadingFormElement.hide();
		});

		request.fail(function (xhr, status, error) {

			if (xhr.status != 422) {
				if (!xhr.success) {
					toastr['error']('Server Error', xhr.message);
				} else {
					toastr['error']('Server Bermasalah', 'Terjadi Kesalahan Jaringan');
				}
			}

		});
	}


</script>
