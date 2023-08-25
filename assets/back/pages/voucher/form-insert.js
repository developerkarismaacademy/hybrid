var FormVoucher = function () {

	//INIT LOADING
	var loading = false;
	var loadingFormElement = $('.loading-form');

	//INIT FORM
	var formVoucherElement = $('#form-voucher');
	var bannerVoucherElement = $('#gambar_voucher');
	var imgBannerVoucherElement = $('img-gambar-voucher');
	var urlSimpanApi = base_url_api + "/VoucherApi/simpan";


	var initValidation = function () {
		formVoucherElement.validate({
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
				'kode_voucher': {
					required: true,
				}
			},
			messages: {
				'kode_voucher': {
					required: 'kode voucher Harus Di Isi',
				}
			}
		});
	};

	formVoucherElement.submit(function (event) {
		event.preventDefault();
		// for (instance in CKEDITOR.instances) {
		// 	CKEDITOR.instances['deskripsi'].updateElement();
		// }

		var valid = formVoucherElement.valid();

		if (!loading) {
			loading = true;
			if (valid) {
				loadingFormElement.show();

				var formData = new FormData(formVoucherElement[0]);
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
							$.redirect(base_url + 'back/voucher', null, 'GET');
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
		formVoucherElement[0].reset();
		imgBannerVoucherElement.attr('src', base_url + "/upload/voucher/default.jpg");
		// for (instance in CKEDITOR.instances) {
		// 	CKEDITOR.instances['deskripsi'].updateElement();
		// }
	};

	bannerVoucherElement.change(function () {
		bannerPaketChange(this);
	});

	var bannerPaketChange = function (input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				imgBannerVoucherElement.attr('src', e.target.result);
			};
			reader.readAsDataURL(input.files[0]);
		}
	}
	return {
		init: function () {
			//CKEDITOR.replace('deskripsi');
			$('.selectpicker').selectpicker();
			$(":file").filestyle({input: false});
			initValidation();
			loadingFormElement.hide();
		}
	}

}();

// Initialize when page loads
jQuery(function () {
	FormVoucher.init();
});

