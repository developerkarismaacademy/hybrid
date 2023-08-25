var FormAsset = function () {

	//INIT LOADING
	var loading = false;
	var loadingFormElement = $('.loading-form');

	//INIT FORM
	var formAssetElement = $('#form-asset');
	var tipeElement = $("#tipe");

	var urlSimpanApi = base_url_api + "/AssetApi/simpan";
	var idMateri = $('#materi_id').val();

	console.log(idMateri);
	var initValidation = function () {
		formAssetElement.validate({
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
			rules:
				{
					'nama': {
						required: true,
					}
				},
			messages: {
				'nama': {
					required: 'Nama Harus Di isi',
				}
			}
		});
	};

	formAssetElement.submit(function (event) {
		event.preventDefault();
		// for (instance in CKEDITOR.instances) {
		// 	CKEDITOR.instances['deskripsi'].updateElement();
		// }

		var valid = formAssetElement.valid();

		if (!loading) {
			loading = true;
			if (valid) {
				loadingFormElement.show();

				var formData = new FormData(formAssetElement[0]);
				var request = $.ajax({
					url: urlSimpanApi,
					data: formData,
					type: 'POST',
					contentType: false,
					processData: false
				});

				console.log(urlSimpanApi);

				request.done(function (xhr, status, error) {
					resetForm();
					if (xhr.success) {
						toastr["success"]("Sukses", "Berhasil Menyimpan Data");
						setTimeout(function () {
							$.redirect(base_url + 'back/asset/' + idMateri, null, 'GET');
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
		formAssetElement[0].reset();

	};

	tipeElement.change(function () {
		$(".file-asset").hide();
		$(".link-asset").hide();
		$("." + tipeElement.val() + "-asset").show();
	});

	return {
		init: function () {
			//CKEDITOR.replace('deskripsi');
			$('.selectpicker').selectpicker();
			$(":file").filestyle({input: false});
			initValidation();
			loadingFormElement.hide();
			$(".link-asset").hide();
		}
	}

}();

// Initialize when page loads
jQuery(function () {
	FormAsset.init();
});

