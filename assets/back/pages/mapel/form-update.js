var FormMapel = function () {

	//INIT LOADING
	var loading = false;
	var loadingFormElement = $('.loading-form');
	var id = $('#idKelas').val();
	var idMapel = $('#id_mapel').val();
	var meta = $('#metaKelas').val();

	//INIT FORM
	var formMapelElement = $('#form-mapel');
	var gambarMapelElement = $('#gambar_mapel');
	var bannerMapelElement = $('#banner_mapel');
	var kelasElement = $('#kelas_id');
	var statusWebinarElement = $('#status_webinar');
	var imgGambarMapelElement = $('#img-gambar-mapel');
	var imgBannerMapelElement = $('#img-banner-mapel');
	var namaMapelElement = $('#nama_mapel');
	var shortDescElement = $('#shortdesc_mapel');
	var deskripsiMapelElement = $('#deskripsi_mapel');
	var statusGratisElement = $('#status_gratis');
	var hargaBasicElement = $('#harga_basic');
	var hargaGoldElement = $('#harga_gold');
	var hargaSilverElement = $('#harga_silver');
	var diskonBasicElement = $('#diskon_basic');
	var diskonGoldElement = $('#diskon_gold');
	var diskonSilverElement = $('#diskon_silver');
	var alertClassElement = $('#alert_class');
	var alertTextElement = $('#alert_text');
	var introVideoElement = $('#intro_video');
	var introVideoLinkElement = $('#intro_video_link');

	var nama_mapel, kelas_id, status_webinar, shortdesc_mapel, deskripsi_mapel, status_gratis, harga_basic, harga_silver, harga_gold,
		gambar_mapel, banner_mapel,
		alert_class, alert_text;

	var urlSimpanApi = base_url_api + "/MapelApi/update";
	var urlGetKelasApi = base_url_api + "/KelasApi/getAll";
	var urlDetailApi = base_url_api + "/MapelApi/detail/";

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

	gambarMapelElement.change(function () {
		gambarProductChange(this);
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

	bannerMapelElement.change(function () {
		bannerProductChange(this);
	});

	introVideoElement.keyup(function () {
		introVideoLinkElement.prop("href", "https://www.youtube.com/embed/" + introVideoElement.val())
	});

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
				detailOpen();
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

	var detailOpen = function () {

		if (!loading) {
			loading = true;

			var request = jQuery.ajax({
				url: urlDetailApi + idMapel,
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
				nama_mapel = xhr.data.nama_mapel;
				kelas_id = xhr.data.kelas_id;
				status_webinar = xhr.data.status_webinar;
				shortdesc_mapel = xhr.data.shortdesc_mapel;
				deskripsi_mapel = xhr.data.deskripsi_mapel;
				status_gratis = xhr.data.status_gratis;
				harga_basic = xhr.data.harga_basic;
				harga_silver = xhr.data.harga_silver;
				harga_gold = xhr.data.harga_gold;
				diskon_basic = xhr.data.diskon_basic;
				diskon_silver = xhr.data.diskon_silver;
				diskon_gold = xhr.data.diskon_gold;
				gambar_mapel = xhr.data.gambar_mapel;
				banner_mapel = xhr.data.banner_mapel;
				alert_class = xhr.data.alert_class;
				alert_text = xhr.data.alert_text;
				intro_video = xhr.data.intro_video;
				namaMapelElement.val(nama_mapel);
				if (status_webinar == 1) {
					statusWebinarElement.prop("checked", true);
				} else {
					statusWebinarElement.prop("checked", false);
				}
				if (status_gratis == 1) {
					statusGratisElement.prop("checked", true);
				} else {
					statusGratisElement.prop("checked", false);
				}
				shortDescElement.val(shortdesc_mapel);
				hargaBasicElement.val(harga_basic);
				hargaGoldElement.val(harga_gold);
				hargaSilverElement.val(harga_silver);
				diskonBasicElement.val(diskon_basic);
				diskonGoldElement.val(diskon_gold);
				diskonSilverElement.val(diskon_silver);
				alertClassElement.val(alert_class).trigger('change');
				alertTextElement.val(alert_text);
				introVideoElement.val(intro_video);
				introVideoLinkElement.prop("href", "https://www.youtube.com/embed/" + intro_video)
				setTimeout(function () {
					deskripsiMapelElement.html(deskripsi_mapel);
					CKEDITOR.instances['deskripsi_mapel'].setData(deskripsi_mapel);
				}, 500);

				kelasElement.val(kelas_id).trigger('change');

				if (xhr.data.gambar_mapel != "") {
					img = base_url + "/upload/mapel/" + xhr.data.gambar_mapel;
					imgGambarMapelElement.attr('src', img);
				} else {
					img = base_url + "/assets/back/images/no-image.jpg";
					imgGambarMapelElement.attr('src', img);
				}

				if (xhr.data.banner_mapel != "") {
					imgBannerMapelElement.attr('src', base_url + "/upload/banner_mapel/" + xhr.data.banner_mapel);
				} else {
					imgBannerMapelElement.attr('src', base_url + "/upload/banner_mapel/default.png");
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
		imgGambarMapelElement.attr('src', img);
		namaMapelElement.val(nama_mapel);
		if (status_webinar == 1) {
			statusWebinarElement.prop("checked", true);
		} else {
			statusWebinarElement.prop("checked", false);
		}
		if (status_gratis == 1) {
			statusGratisElement.prop("checked", true);
		} else {
			statusGratisElement.prop("checked", false);
		}
		shortDescMapel.val(shortdesc_mapel);
		hargaBasicElement.val(harga_basic);
		hargaGoldElement.val(harga_gold);
		hargaSilverElement.val(harga_silver);
		deskripsiMapelElement.html(deskripsi_mapel);
		introVideoElement.val(intro_video);
		alertClassElement.val(alert_class).trigger('change');
		kelasElement.val(kelas_id).trigger('change');
		CKEDITOR.instances['deskripsi_mapel'].setData(deskripsi_mapel);
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
		}, reset: function () {
			resetForm();
		}
	}

}();

// Initialize when page loads
jQuery(function () {
	FormMapel.init();
});

