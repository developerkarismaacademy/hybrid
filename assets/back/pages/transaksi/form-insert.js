var FormBeli = function () {

	//INIT LOADING
	var loading = false;
	var loadingFormElement = $('.loading-form');

	//INIT FORM
	var formBeliElement = $('#form-beli');
	var imgBuktiElement = $('#img-bukti-transfer');
	var siswaElement = $('#siswa_id');
	var kelasElement = $('#kelas_id');
	var mapelElement = $('#mapel_id');
	var jumlahBayarElement = $('#jumlah_bayar');
	var levelElement = $('#level_mapel');
	var siswaLink = $('#siswa-link');
	var kelasLink = $('#kelas-link');
	var mapelLink = $('#mapel-link');
	var buktiElement = $('#bukti_transfer');
	var urlSimpanApi = base_url_api + "/TransaksiApi/simpan";
	var urlGetSiswaApi = base_url_api + "/SiswaApi/getAll";

	var urlGetKelasApi = base_url_api + "/KelasApi/getAll";
	var urlGetMapelApi = base_url_api + "/MapelApi/getAllByKelas";

	var initValidation = function () {
		formBeliElement.validate({
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
				'siswa_id': {
					required: true,
				},
				'kelas_id': {
					required: true,
				},
				'mapel_id': {
					required: true,
				},
				'level_mapel': {
					required: true,
				},
				'bukti_transfer': {
					required: true
				}
			},
			messages: {
				'siswa_id': {
					required: 'Siswa Harus Di Pilih',
				},
				'kelas_id': {
					required: 'Kelas Harus Di Pilih',
				},
				'mapel_id': {
					required: 'Mata Pelajaran Harus Di Pilih',
				},
				'level_mapel': {
					required: 'Level Harus Di Pilih'
				},
				'bukti_transfer': {
					required: 'Bukti Transfer Harus Di Pilih'
				}
			}
		});
	};

	formBeliElement.submit(function (event) {
		event.preventDefault();


		var valid = formBeliElement.valid();

		if (!loading) {
			loading = true;
			if (valid) {
				loadingFormElement.show();

				var formData = new FormData(formBeliElement[0]);
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
							$.redirect(base_url + 'back/pembelian', null, 'GET');
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
		formBeliElement[0].reset();
	};

	var requestGetSiswa = function () {
		var request = jQuery.ajax({
			url: urlGetSiswaApi,
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
			let option = new Option('Pilih Siswa', '', false, false);
			siswaElement.append(option);

			$.each(xhr.data, function (index, value) {

				let selected = false;

				option = new Option("(" + value.id_user + ") " + value.nama_user, value.id_user, selected, selected);
				option.setAttribute("data-idsiswa", value.id_user);
				siswaElement.append(option);
			});

			requestGetKelas();
		});

		request.fail(function (jqXHR, textStatus) {
			toastr["error"]("Terjadi Kesalahan");
			loadingFormElement.hide();
		});
	};

	var requestGetKelas = function () {
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

				option = new Option(value.nama_kelas, value.id_kelas, selected, selected);
				option.setAttribute("data-meta", value.meta_link_kelas);
				kelasElement.append(option);
			});

			loading = false;
		});

		request.fail(function (jqXHR, textStatus) {
			loading = false;
			toastr["error"]("Terjadi Kesalahan");
			loadingFormElement.hide();
		});
	};

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

					option = new Option(value.nama_mapel, value.id_mapel, selected, selected);
					option.setAttribute("data-meta", value.meta_link_mapel);
					option.setAttribute("data-level1", value.harga_basic);
					option.setAttribute("data-level2", value.harga_silver);
					option.setAttribute("data-level3", value.harga_gold);
					mapelElement.append(option);
				});
			});
			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				loadingFormElement.hide();
			});
		}
	};

	siswaElement.change(function () {
		if (siswaElement.val() != "") {
			idSiswa = siswaElement.find(":selected").data("idsiswa");
			siswaLink.show();
			siswaLink.attr("href", base_url + "back/siswa/detail/" + idSiswa);
		}
	});

	kelasElement.change(function () {
		if (kelasElement.val() != "") {
			metaKelas = kelasElement.find(":selected").data("meta");
			kelasLink.show();
			kelasLink.attr("href", base_url + "back/mapel/" + metaKelas);
			requestGetMapel();
		}
	});

	mapelElement.change(function () {
		if (mapelElement.val() != "") {
			metaMapel = mapelElement.find(":selected").data("meta");
			mapelLink.show();
			mapelLink.attr("href", base_url + "back/bab/" + metaMapel);
			levelElement.trigger("change");
		}
	});

	levelElement.change(function () {
		if (mapelElement.val() != "") {
			levelMapel = levelElement.val();
			hargaMapel = mapelElement.find(":selected").data("level" + levelMapel);
			jumlahBayarElement.val(hargaMapel);
		}
	});


	buktiElement.change(function () {
		if (buktiElement.val() != "") {
			imgBuktiElement.attr("src", base_url + "upload/transaksi/" + buktiElement.val());
		}
	});

	return {
		init: function () {
			initValidation();
			$(".select2").select2();
			loadingFormElement.hide();
			requestGetSiswa();
		},
		resetForm: function () {
			resetForm();
		},
	}

}();

// Initialize when page loads
jQuery(function () {
	FormBeli.init();
});

