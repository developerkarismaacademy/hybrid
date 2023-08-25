var FormInstruktur = function () {

	//INIT LOADING
	var loading = false;
	var loadingFormElement = $('.loading-form');
	var id = $('#idInstruktur').val();
	var idInstruktur = $('#id_instruktur').val();

	//INIT FORM
	var formInstrukturElement = $('#form-instruktur');
	var namaUserInstrukturElement = $('#nama_user');
	var emailUserInstrukturElement = $('#email_user');
	var usernameInstrukturElement = $('#username');
	var jkUserInstrukturElement = $('#jk_user');
	var mapelAmpuInstrukturELement = $("#mapel_ampu");
	var mapelIdInstrukturELement = $("#mapel_id");
	var biodataElement = $('#biodata');
	var gambarInstrukturElement = $('#gambar_user');
	var imgGambarInstrukturElement = $('#img-gambar-user');
	var gambarTandaTanganElement = $('#gambar_tanda_tangan');
	var imgGambarTandaTanganElement = $('#img-gambar-tanda-tangan');
	var urlSimpanApi = base_url_api + "/InstrukturApi/update";
	var urlDetailApi = base_url_api + "/InstrukturApi/detail/";
	var urlGetKelasApi = base_url_api + "/MapelApi/getAllMapelGroupByKelas";

	var nama_user, email_user, username, jk_user, gambar_user, gambar_tanda_tangan, mapel_id = [], biodata;

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
				'confirm_password': {

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
				'confirm_password': {
					equalTo: "Password Harus Sama",
				},
				'jk_user': {
					required: "Jenis Kelamin Harus Di Isi",
				},
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
		imgGambarInstrukturElement.attr('src', base_url + "/upload/instruktur/" + gambar_user);
		imgGambarTandaTanganElement.attr('src', base_url + "/upload/tanda_tangan/" + gambar_tanda_tangan);
		namaUserInstrukturElement.val(nama_user);
		biodataElement.val(biodata);
		emailUserInstrukturElement.val(email_user);
		usernameInstrukturElement.val(username);
		jkUserInstrukturElement.val(jk_user).change();
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

				let option;

				$.each(xhr.data, function (index, value) {
					var optGroupKelas = document.createElement("OPTGROUP");
					optGroupKelas.setAttribute("label", value.nama_kelas);

					mapelAmpuInstrukturELement.append(optGroupKelas);

					if (value.mapel !== undefined) {

						$.each(value.mapel.data, function (indexMapel, valueMapel) {

							let selected = false;
							if (mapel_id.indexOf(parseInt(valueMapel.id_mapel)) != -1) {
								selected = true;
							}

							option = new Option(valueMapel.nama_mapel, valueMapel.id_mapel, selected, selected);
							mapelAmpuInstrukturELement.append(option);
						});
					}
				});

				loading = false;
				mapelAmpuInstrukturELement.val(mapel_id).trigger('change');

			});

			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				loadingFormElement.hide();
			});
		}
	};

	mapelAmpuInstrukturELement.change(function () {
		mapel_id = [];
		console.log(mapelAmpuInstrukturELement.val());
		$.each(mapelAmpuInstrukturELement.val(), function (index, value) {
			mapel_id.push(parseInt(value));
		});

		mapelIdInstrukturELement.val(mapel_id);
	});

	var detailOpen = function () {

		if (!loading) {
			loading = true;

			var request = jQuery.ajax({
				url: urlDetailApi + idInstruktur,
				method: "GET",
				beforeSend: function (xhr) {
					loadingFormElement.show();
				}
			});

			request.always(function (xhr, status, error) {
				loading = false;
				loadingFormElement.hide();
				requestGetKelas();
			});

			request.done(function (xhr, status, error) {

				nama_user = xhr.data.nama_user;
				biodata = xhr.data.biodata;

				email_user = xhr.data.email_user;
				username = xhr.data.username;
				jk_user = xhr.data.jk_user;
				gambar_user = xhr.data.gambar_user;
				gambar_tanda_tangan = xhr.data.tanda_tangan;

				namaUserInstrukturElement.val(nama_user);
				biodataElement.val(biodata);
				emailUserInstrukturElement.val(email_user);
				usernameInstrukturElement.val(username);
				jkUserInstrukturElement.val(jk_user).change();


				if (xhr.data.mapel_ampu.total > 0) {
					$.each(xhr.data.mapel_ampu.data, function (index, value) {
						mapel_id.push(parseInt(value.mapel_id));
					});
				}

				console.log(mapel_id);

				mapelIdInstrukturELement.val(mapel_id.toString());

				if (xhr.data.gambar_user != "") {
					console.log(xhr.data.gambar_user);
					imgGambarInstrukturElement.attr('src', base_url + "/upload/instruktur/" + gambar_user);
					img = base_url + "/upload/instruktur/" + xhr.data.gambar_user;
				} else {
					imgGambarInstrukturElement.attr('src', base_url + "/upload/instruktur/default.png");
					img = base_url + "/upload/instruktur/default.png";
				}
				if (xhr.data.tanda_tangan != "") {
					console.log(xhr.data.tanda_tangan);
					imgGambarTandaTanganElement.attr('src', base_url + "/upload/tanda_tangan/" + tanda_tangan);
					img = base_url + "/upload/tanda_tangan/" + xhr.data.tanda_tangan;
				} else {
					imgGambarTandaTanganElement.attr('src', base_url + "/upload/tanda_tangan/default.png");
					img = base_url + "/upload/tanda_tangan/default.png";
				}


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
			$(":file").filestyle({ input: false });
			mapelAmpuInstrukturELement.select2();
			initValidation();
			detailOpen();
			loadingFormElement.hide();
		}
	}

}();

// Initialize when page loads
jQuery(function () {
	FormInstruktur.init();
});

