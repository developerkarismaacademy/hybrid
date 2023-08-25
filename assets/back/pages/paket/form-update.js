var FormPaket = function () {

	//INIT LOADING
	var loading = false;
	var loadingFormElement = $('.loading-form');
	var id = $('#id_paket').val();

	//INIT FORM
	var formPaketElement = $('#form-paket');
	var namaPaketElement = $("#nama_paket");
	var deskripsiPaketElement = $("#deskripsi");
	var deskripsiSingkatElement = $("#deskripsi_singkat");
	var colorPaketElement = $("#color_paket");
	var hargaBasicElement = $("#harga_basic");
	var hargaGoldElement = $("#harga_gold");
	var bannerPaketElement = $('#banner_paket');
	var imgBannerPaketElement = $('#img-banner-paket');
	var urlSimpanApi = base_url_api + "/PaketApi/update";
	var urlDetailApi = base_url_api + "/PaketApi/detail/";

	var deskripsi, nama, basic, gold;
	var initValidation = function () {
		formPaketElement.validate({
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
				'nama_paket': {
					required: true,
				}
			},
			messages: {
				'nama_paket': {
					required: 'Paket Harus Di Isi',
				}
			}
		});
	};


	formPaketElement.submit(function (event) {
		event.preventDefault();
		for (instance in CKEDITOR.instances) {
			CKEDITOR.instances['deskripsi'].updateElement();
		}

		var valid = formPaketElement.valid();

		if (!loading) {
			loading = true;
			if (valid) {
				loadingFormElement.show();

				var formData = new FormData(formPaketElement[0]);
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
							$.redirect(base_url + 'back/paket', null, 'GET');
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

	bannerPaketElement.change(function () {
		bannerPaketChange(this);
	});

	var bannerPaketChange = function (input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				imgBannerPaketElement.attr('src', e.target.result);
			};
			reader.readAsDataURL(input.files[0]);
		}
	}
	var detailOpen = function () {

		if (!loading) {
			loading = true;

			var request = jQuery.ajax({
				url: urlDetailApi + id,
				method: "GET",
				beforeSend: function (xhr) {
					loadingFormElement.show();
				}
			});

			request.always(function (xhr, status, error) {
				loading = false;
				loadingFormElement.hide();

				CKEDITOR.replace('deskripsi');
				deskripsiPaketElement.html(deskripsi);
				CKEDITOR.instances['deskripsi'].setData(deskripsi);
			});

			request.done(function (xhr, status, error) {
				CKEDITOR.replace('deskripsi');
				deskripsi = xhr.data.deskripsi;
				nama = xhr.data.nama_paket;
				basic = xhr.data.harga_basic;
				namaPaketElement.val(xhr.data.nama_paket);
				colorPaketElement.val(xhr.data.color_paket).trigger("change");
				deskripsiSingkatElement.html(xhr.data.deskripsi_singkat);
				hargaBasicElement.val(xhr.data.harga_basic);
				hargaGoldElement.val(xhr.data.harga_gold);

				setTimeout(function () {
					deskripsiPaketElement.html(deskripsi);
					CKEDITOR.instances['deskripsi'].setData(deskripsi);
				}, 500);


				if (xhr.data.banner_paket != "") {
					console.log("nama file : " + xhr.data.banner_paket);
					imgBannerPaketElement.attr('src', base_url + "/upload/baner-paket/" + xhr.data.banner_paket);
					img = base_url + "/upload/baner-paket/" + xhr.data.banner_paket;
					console.log("url 1 : " + img);
				} else {
					imgBannerPaketElement.attr('src', base_url + "/upload/baner-paket/default.jpg");
					img = base_url + "/upload/baner-paket/default.jpg";
					console.log
				}


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
		namaPaketElement.val(nama);
		deskripsiPaketElement.html(deskripsi);
		CKEDITOR.instances['deskripsi'].setData(deskripsi);
	};


	return {
		init: function () {
			CKEDITOR.replace('deskripsi');
			$('.selectpicker').selectpicker();
			$(":file").filestyle({input: false});
			initValidation();
			loadingFormElement.show();
			detailOpen();
		},
		reset: function () {
			resetForm();
		}
	}

}();

// Initialize when page loads
jQuery(function () {
	FormPaket.init();
});

