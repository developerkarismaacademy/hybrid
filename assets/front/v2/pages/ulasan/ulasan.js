var ListUlasan = function () {

	//INIT
	var loading = false;
	var loadingFormElement = $('#loading');

	//INIT URL
	var urlApi = base_url_api + "/UlasanApi";
	var urlGetApi = urlApi + "/jsondata";
	var urlAksiApi = "";
	var meta = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);

	//INIT GET DATA
	var dataUlasan = [];
	var totalData = 0;

	var formUlasanElement = $('#form-ulasan');

	var ulasan, rating, mapel_id, mapel_nama;


	var initValidation = function () {
		formUlasanElement.validate({
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
				'ulasan': {
					required: true,
				},
			},
			messages: {
				'ulasan': {
					required: 'Ulasan harus diisi',
				},
			}
		});
	};

	formUlasanElement.submit(function (event) {
		event.preventDefault();

		var valid = formUlasanElement.valid();

		if (!loading) {
			loadingFormElement.show()
			formUlasanElement.addClass("d-none");
			if (valid) {
				loadingFormElement.show()
				formUlasanElement.addClass("d-none");

				var formData = new FormData(formUlasanElement[0]);
				var request = $.ajax({
					url: urlAksiApi,
					data: formData,
					type: 'POST',
					contentType: false,
					processData: false
				});

				request.done(function (xhr, status, error) {
					if (xhr.success) {
						toastr["success"]("Sukses", "Berhasil Menyimpan Data");
						setTimeout(function () {
							window.location.href = base_url + "profil";
						}, 1500);
					} else {
						toastr["error"]("Gagal", "Gagal Menyimpan Data");
					}
				});

				request.always(function (xhr, status, error) {
					loadingFormElement.show()
					formUlasanElement.addClass("d-none");
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
				loadingFormElement.hide()
				formUlasanElement.removeClass("d-none");
			}
		}
	});

	var requestUlasan = function (url) {
		url = url + "?meta=" + meta;

		var request = jQuery.ajax({
			url: url,
			method: "GET",
			beforeSend: function (xhr) {
				loadingFormElement.show()
				formUlasanElement.addClass("d-none");
			}
		});

		request.always(function (xhr, status, error) {
			loadingFormElement.show()
			formUlasanElement.addClass("d-none");
		});

		request.done(function (xhr, status, error) {
			dataUlasan = xhr.data;
			totalData = xhr.total;

			mapel_id = xhr.mapel_id;
			mapel_nama = xhr.mapel_nama;
			formUlasanElement.find('.mapel-id').attr("value", mapel_id);
			formUlasanElement.find('.testimoni-title').html("Isikan ulasan tentang materi<br>" + mapel_nama);


			if (totalData > 0) {
				updateUlasan();
				urlAksiApi = urlApi + "/update";
			} else {
				urlAksiApi = urlApi + "/simpan";
			}
			loadingFormElement.hide()
			formUlasanElement.removeClass("d-none");
		});

		request.fail(function (jqXHR, textStatus) {
			toastr["error"]("Terjadi Kesalahan");
			loadingFormElement.hide()
			formUlasanElement.removeClass("d-none");
		});
	};

	var updateUlasan = function () {
		loadingFormElement.show()
		formUlasanElement.addClass("d-none");

		value = dataUlasan[0];

		ulasan = value.ulasan;
		rating = value.rating;


		formUlasanElement.find('.ulasan').html(ulasan);

		formUlasanElement.find('input[name=rating][value=' + rating + ']').trigger('click');

		formUlasanElement.find('.submit-ulasan').html("Ubah Ulasan <i class='fa fa-pencil'></i>");
		formUlasanElement.find('.submit-ulasan').removeClass('btn-success');
		formUlasanElement.find('.submit-ulasan').addClass('btn-warning');

		loadingFormElement.hide()
		formUlasanElement.removeClass("d-none");
	};


	return {
		init: function () {
			initValidation();
			requestUlasan(urlGetApi);
		},
	}

}();


// Initialize when page loads
jQuery(function () {
	ListUlasan.init();
});
