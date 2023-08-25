var FormKompetensi = function () {

	//INIT LOADING
	var loading = false;
	var loadingFormElement = $('.loading-form');
	var id = $('#idKelas').val();
	var meta = $('#metaKelas').val();
	var idMapel = $('#idMapel').val();
	var metaMapel = $('#metaMapel').val();
	var idKompetensi = $('#idKompetensi').val();
	var idIndikatorInduk = $('#id_indikator_induk').val();

	//INIT FORM
	var formIndikatorIndukElement = $('#form-indikator-induk');
	var kelasElement = $('#kelas_id');
	var mapelElement = $('#mapel_id');
	var kompetensiElement = $('#kompetensi_id');
	var indikatorIndukElement = $('#indikator_induk');

	var kelas_id, mapel_id, kompetensi_id, indikatorInduk;

	var urlSimpanApi = base_url_api + "/IndikatorIndukApi/update";
	var urlGetKelasApi = base_url_api + "/KelasApi/getAll";
	var urlGetMapelApi = base_url_api + "/MapelApi/getAllByKelas";
	var urlGetKompetensiApi = base_url_api + "/KompetensiApi/getAllByMapel";
	var urlDetailApi = base_url_api + "/IndikatorIndukApi/detail/";

	var initValidation = function () {
		formIndikatorIndukElement.validate({
			errorClass: 'validation-message text-danger',
			errorElement: 'div',
			ignore: [],
			errorPlacement: function (error, e) {
				jQuery(e).parents('.form-group').append(error);
			},
			highlight: function (e) {
				jQuery(e).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			success: function (e) {
				jQuery(e).closest('.form-group').removeClass('has-error').addClass('has-success');
				jQuery(e).remove();
			},
			rules: {
				'indikator_induk': {
					required: true,
				},
				'kelas_id': {
					required: true,
				},
				'mapel_id': {
					required: true,
				},
				'kompetensi_id': {
					required: true,
				}
			},
			messages: {
				'indikator_induk': {
					required: 'Indikator Induk Harus Di Isi',
				},
				'kelas_id': {
					required: 'Kelas Harus Di Pilih',
				},
				'mapel_id': {
					required: 'Mata Pelajaran Harus Di Pilih',
				},
				'kompetensi_id': {
					required: 'Kompetensi Harus Di Pilih',
				}
			}
		});
	};

	formIndikatorIndukElement.submit(function (event) {
		event.preventDefault();
		var valid = formIndikatorIndukElement.valid();

		if (!loading) {
			loading = true;
			if (valid) {
				loadingFormElement.show();

				var formData = new FormData(formIndikatorIndukElement[0]);
				var request = $.ajax({
					url: urlSimpanApi,
					data: formData,
					type: 'POST',
					contentType: false,
					processData: false
				});

				request.done(function (xhr, status, error) {
					if (xhr.success) {
						toastr["success"]("Sukses", "Berhasil Menyimpan Data");
						setTimeout(function () {
							var meta_link = mapelElement.find(':selected').data('meta');
							$.redirect(base_url + 'back/indikator-induk/' + idKompetensi, null, 'GET');

						}, 1500);
					} else {
						toastr["error"]("Gagal", "Gagal Menyimpan Data");
					}
				});

				request.always(function (xhr, status, error) {
					loading = false;
					loadingFormElement.hide();
				});

				request.fail(function (xhr, status, error) {
					$('.validation-message').remove();
					var errorForm = [];

					if (xhr.status == 422) {
						var result = xhr.responseJSON;

						$.each(result.form, function (index, value) {
							errorForm.push(index);
							var e = $("#" + index);
							$(e).parents('.form-group').removeClass('has-success').addClass('has-error');
							var error = "<div class='validation-message text-danger'><i class=\"fa fa-close\"></i> " + value + "</div>";
							$(e).parents('.form-group').append(error);
						});

					}

					for (var pair of formData.entries()) {
						if (errorForm.indexOf(pair[0]) == -1) {
							$("#" + pair[0] + " + .form-control-feedback").remove();
							var e = $("#" + pair[0]);
							$(e).parents('.form-group').addClass('has-success').removeClass('has-error');
							var error = "<div class='validation-message text-success'><i class=\"fa fa-check\"></i> Valid</div>";
							$(e).parents('.form-group').append(error);
						}
					}

					if (xhr.status != 422) {
						if (!xhr.success) {
							toastr['error']('Server Error', xhr.message);
						} else {
							toastr['error']('Server Bermasalah', 'Terjadi Kesalahan Jaringan');
						}
					}

				});

			} else {
				loading = false;
			}
		}

	});

	var requestGetKelas = function () {
		if (!loading) {
			loading = true;

			var request = jQuery.ajax({
				url: urlGetKelasApi,
				method: "GET",
				beforeSend: function (xhr) {
					loadingFormElement.show()
				}
			});

			request.always(function (xhr, status, error) {
				loading = false;
				loadingFormElement.hide();
			});

			request.done(function (xhr, status, error) {

				let option = new Option('Pilih Kelas', '', false, false);
				kelasElement.append(option);

				$.each(xhr.data, function (index, value) {

					let selected = false;
					if (value.id_kelas == id) {
						selected = true;
					}

					option = new Option(value.nama_kelas, value.id_kelas, selected, selected);
					option.setAttribute("data-meta", value.meta_link_kelas);
					kelasElement.append(option);
				});

				loading = false;
				kelasElement.val(id).trigger('change');
				// requestGetMapel();

			});

			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				loadingFormElement.hide();
			});
		}
	};

	kelasElement.change(function () {
		if (kelasElement.val() != "") {
			requestGetMapel();
		}
	});

	var requestGetMapel = function () {
		if (!loading) {
			loading = true;

			var request = jQuery.ajax({
				url: urlGetMapelApi + "/" + kelasElement.val(),
				method: "GET",
				beforeSend: function (xhr) {
					loadingFormElement.show()
				}
			});

			request.always(function (xhr, status, error) {
				loading = false;
				loadingFormElement.hide();
			});

			request.done(function (xhr, status, error) {
				mapelElement.empty();
				let option = new Option('Pilih Mata Pelajaran', '', false, false);
				mapelElement.append(option);

				$.each(xhr.data, function (index, value) {

					let selected = false;
					if (value.id_mapel == idMapel) {
						selected = true;
					}

					option = new Option(value.nama_mapel, value.id_mapel, selected, selected);
					option.setAttribute("data-meta", value.meta_link_mapel);
					mapelElement.append(option);
				});

				mapelElement.val(idMapel).trigger('change');
				loading = false;

			});
			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				loadingFormElement.hide();
			});
		}
	};

	mapelElement.change(function () {
		if (mapelElement.val() != "") {
			requestGetKompetensi();
		}
	});

	var requestGetKompetensi = function () {
		if (!loading) {
			loading = true;

			var request = jQuery.ajax({
				url: urlGetKompetensiApi + "/" + idMapel,
				method: "GET",
				beforeSend: function (xhr) {
					loadingFormElement.show()
				}
			});

			request.always(function (xhr, status, error) {
				loading = false;
				loadingFormElement.hide();
			});

			request.done(function (xhr, status, error) {
				kompetensiElement.empty();
				let option = new Option('Pilih Kompetensi ', '', false, false);
				kompetensiElement.append(option);

				$.each(xhr.data, function (index, value) {

					let selected = false;
					if (value.id_kompetensi == idKompetensi) {
						selected = true;
					}

					option = new Option(value.kompetensi, value.id_kompetensi, selected, selected);
					kompetensiElement.append(option);
				});

				kompetensiElement.val(idKompetensi).trigger('change');

			});
			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				loadingFormElement.hide();
			});
		}
	};

	var detailOpen = function () {

		if (!loading) {
			loading = true;

			var request = jQuery.ajax({
				url: urlDetailApi + idIndikatorInduk,
				method: "GET",
				beforeSend: function (xhr) {
					loadingFormElement.show();
				}
			});

			request.always(function (xhr, status, error) {
				loading = false;
				loadingFormElement.hide();
			});

			request.done(function (xhr, status, error) {
				kompetensi = xhr.data.kompetensi;
				kelas_id = xhr.data.kelas_id;
				mapel_id = xhr.data.mapel_id;
				kompetensi_id = xhr.data.kompetensi_id;
				indikatorInduk = xhr.data.indikator_induk;

				indikatorIndukElement.html(indikatorInduk);

				kelasElement.val(kelas_id).trigger('change');
				mapelElement.val(mapel_id).trigger('change');
				kompetensiElement.val(kompetensi_id).trigger('change');

				loading = false;
				requestGetKelas();


			});

			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				loadingFormElement.hide();
			});


		}
	};

	var resetForm = function () {
		initValidation();
		// formKelasElement[0].reset();
		CKEDITOR.instances['deskripsi_kompetensi'].setData(deskripsi_kompetensi);
	};

	return {
		init: function () {
			initValidation();
			$(".select2").select2();
			loadingFormElement.hide();
			detailOpen();
		}, reset: function () {
			resetForm();
		}
	}

}();

// Initialize when page loads
jQuery(function () {
	FormKompetensi.init();
});

