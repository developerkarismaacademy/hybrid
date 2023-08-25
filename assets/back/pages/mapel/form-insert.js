var FormMapel = function () {

	//INIT LOADING
	var loading = false;
	var loadingFormElement = $('.loading-form');
	var id = $('#idKelas').val();
	var meta = $('#metaKelas').val();

	//INIT FORM
	var formMapelElement = $('#form-mapel');
	var gambarMapelElement = $('#gambar_mapel');
	var introVideoElement = $('#intro_video');
	var introVideoLinkElement = $('#intro_video_link');
	var bannerMapelElement = $('#banner_mapel');
	var kelasElement = $('#kelas_id');
	var imgGambarMapelElement = $('#img-gambar-mapel');
	var imgBannerMapelElement = $('#img-banner-mapel');
	var urlSimpanApi = base_url_api + "/MapelApi/simpan";
	var urlGetKelasApi = base_url_api + "/KelasApi/getAll";

	var initValidation = function () {
		formMapelElement.validate({
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
				'nama_mapel': {
					required: true,
				},
				'kelas_id': {
					required: true,
				},
				'harga_basic': {
					required: true,
				},
				'alert_text': {
					maxlength: 100,
				}
			},
			messages: {
				'nama_mapel': {
					required: 'Nama Mapel Harus Di Isi',
				},
				'kelas_id': {
					required: 'Kelas Harus Di Pilih',
				},
				'harga_basic': {
					required: 'Harga Basic Harus Di Isi',
				},
				'alert_text': {
					maxlength: 'Maksimal Teks 100 Karakter',
				}
			}
		});
	};

	formMapelElement.submit(function (event) {
		event.preventDefault();
		for (instance in CKEDITOR.instances) {
			CKEDITOR.instances['deskripsi_mapel'].updateElement();
		}

		var valid = formMapelElement.valid();

		if (!loading) {
			loading = true;
			if (valid) {
				loadingFormElement.show();

				var formData = new FormData(formMapelElement[0]);
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
							var meta_link = kelasElement.find(':selected').data('meta');
							$.redirect(base_url + 'back/mapel/' + meta_link, null, 'GET');
							resetForm();

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

	var resetForm = function () {
		initValidation();
		formMapelElement[0].reset();
		imgGambarMapelElement.attr('src', base_url + "/assets/back/images/no-image.jpg");
		for (instance in CKEDITOR.instances) {
			CKEDITOR.instances['deskripsi_mapel'].updateElement();
		}
	};

	gambarMapelElement.change(function () {
		gambarProductChange(this);
	});

	bannerMapelElement.change(function () {
		bannerProductChange(this);
	});

	introVideoElement.keyup(function () {
		introVideoLinkElement.prop("href", "https://www.youtube.com/embed/" + introVideoElement.val())
	});

	var gambarProductChange = function (input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				imgGambarMapelElement.attr('src', e.target.result);
			};
			reader.readAsDataURL(input.files[0]);
		}
	};

	var bannerProductChange = function (input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				imgBannerMapelElement.attr('src', e.target.result);
			};
			reader.readAsDataURL(input.files[0]);
		}
	};

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
				kelasElement.append(option).trigger('change');

				$.each(xhr.data, function (index, value) {

					let selected = false;
					if (value.id_kelas == id) {
						selected = true;
					}

					option = new Option(value.nama_kelas, value.id_kelas, selected, selected);
					option.setAttribute("data-meta", value.meta_link_kelas);
					kelasElement.append(option).trigger('change');
				});

				kelasElement.val(id).trigger('change');

			});
			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				loadingFormElement.hide();
			});
		}
	};

	return {
		init: function () {
			CKEDITOR.replace('deskripsi_mapel');
			$('.selectpicker').selectpicker();
			$(":file").filestyle({input: false});
			initValidation();
			$(".select2").select2();
			loadingFormElement.hide();
			requestGetKelas();
		}
	}

}();

// Initialize when page loads
jQuery(function () {
	FormMapel.init();
});

