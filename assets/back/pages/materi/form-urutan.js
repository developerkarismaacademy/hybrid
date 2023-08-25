var FormUrutanBab = function () {

	//INIT URL
	var urlSimpanApi = base_url_api + "/MateriApi/simpanUrutan";
	var id = $('#idKelas').val();
	var meta = $('#metaKelas').val();
	var idMapel = $('#idMapel').val();
	var metaMapel = $('#metaMapel').val();
	var idBab = $('#idBab').val();
	var metaBab = $('#metaBab').val();


	//INIT LOADING
	var loading = false;
	var loadingElement = $('.loading-form');

	//INIT ELEMETN
	var listbabElement = $('#list-bab');
	var formUrutanElement = $('#form-urutan');


	formUrutanElement.submit(function (event) {
		event.preventDefault();

		var dataUrutan = listbabElement.nestable('serialize');
		console.log(listbabElement.nestable('serialize'));
		if (!loading) {
			loading = true;
			loadingElement.show();

			var request = $.ajax({
				url: urlSimpanApi,
				data: {data: dataUrutan, bab_id: id},
				type: 'POST'
			});

			request.done(function (xhr, status, error) {
				if (xhr.success) {
					toastr["success"]("Sukses", "Berhasil Menyimpan Data");
					setTimeout(function () {
						$.redirect(base_url + 'back/materi/' + metaBab, null, 'GET');
					}, 1500);
				} else {
					toastr["error"]("Gagal", "Gagal Menyimpan Data");
				}
			});

			request.always(function (xhr, status, error) {
				loading = false;
				loadingElement.hide();
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

	});

	return {
		init: function () {
			listbabElement.nestable({maxDepth: 1});
			loadingElement.hide();
			console.log(loadingElement);
		}
	}

	// $P$BUY2k0V11xY6TFLLwphDTOcikzwrTf0

}();

// Initialize when page loads
jQuery(function () {
	FormUrutanBab.init();
});

