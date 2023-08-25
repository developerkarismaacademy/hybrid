var FormInstruktur = function () {

	//INIT LOADING
	var loading = false;
	var loadingFormElement = $('.loading-form');

	//INIT FORM
	var formInstrukturElement = $('#form-instruktur');
	var gambarInstrukturElement = $('#gambar_user');
	var imgGambarInstrukturElement = $('#img-gambar-user');
	var gambarTandaTanganElement = $('#gambar_tanda_tangan');
	var imgGambarTandaTanganElement = $('#img-gambar-tanda-tangan');
	var urlSimpanApi = base_url_api + "/InstrukturApi/simpan";

	var initValidation = function () {
		formInstrukturElement.validate({
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
				'nama_user': {
					required: true,
				},
				'email_user': {
					required: true,
					email: true,
				},
				'username': {
					required: true,
				},
				'password': {
					required: true,
				},
				'confirm_password': {
					required: true,
					equalTo: "#password",
				},
				'jk_user': {
					required: true,
				},
			},
			messages: {
				'nama_user': {
					required: "Nama Instruktur Harus Di Isi",
				},
				'email_user': {
					required: "Email Instruktur Harus Di Isi",
					email: "Format Email Tidak Sah",
				},
				'username': {
					required: "Username Harus Di Isi",
				},
				'password': {
					required: "Password Harus Di isi",
				},
				'confirm_password': {
					required: "Konfirmasi Password Harus Di isi",
					equalTo: "Password Harus Sama",
				},
				'jk_user': {
					required: "Jenis Kelamin Harus Di Isi",
				},
				'biodata': {
					required: "Biodata Harus Di Isi",
				}
			}
		});
	};

	formInstrukturElement.submit(function (event) {
		event.preventDefault();

		var valid = formInstrukturElement.valid();

		if (!loading) {
			loading = true;
			if (valid) {
				loadingFormElement.show();

				var formData = new FormData(formInstrukturElement[0]);
				var request = $.ajax({
					url: urlSimpanApi,
					data: formData,
					type: 'POST',
					contentType: false,
					processData: false
				});

				request.done(function (xhr, status, error) {
					resetForm();
					if (xhr.success) {
						toastr["success"]("Sukses", "Berhasil Menyimpan Data");
						setTimeout(function () {
							$.redirect(base_url + 'back/instruktur', null, 'GET');
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
		formInstrukturElement[0].reset();
		imgGambarInstrukturElement.attr('src', base_url + "/upload/instruktur/default.png");
		imgGambarTandaTanganElement.attr('src', base_url + "/upload/instruktur/default.png");

	};

	gambarInstrukturElement.change(function () {
		gambarProductChange(this);
	});
	gambarTandaTanganElement.change(function () {
		gambarTandaTanganChange(this);
	});

	var gambarProductChange = function (input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				imgGambarInstrukturElement.attr('src', e.target.result);
			};
			reader.readAsDataURL(input.files[0]);
		}
	};
	var gambarTandaTanganChange = function (input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				imgGambarTandaTanganElement.attr('src', e.target.result);
			};
			reader.readAsDataURL(input.files[0]);
		}
	};


	return {
		init: function () {
			$(":file").filestyle({ input: false });
			initValidation();
			loadingFormElement.hide();
		}
	}

}();

// Initialize when page loads
jQuery(function () {
	FormInstruktur.init();
});

