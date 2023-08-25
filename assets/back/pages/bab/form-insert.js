var FormBab = function () {

	//INIT LOADING
	var loading = false;
	var loadingFormElement = $('.loading-form');
	var id = $('#idKelas').val();
	var meta = $('#metaKelas').val();
	var idMapel = $('#idMapel').val();
	var metaMapel = $('#metaMapel').val();

	//INIT FORM
	var formBabElement = $('#form-bab');
	var gambarBabElement = $('#gambar_bab');
	var kelasElement = $('#kelas_id');
	var mapelElement = $('#mapel_id');
	var imgGambarBabElement = $('#img-gambar-bab');
	var urlSimpanApi = base_url_api + "/BabApi/simpan";
	var urlGetKelasApi = base_url_api + "/KelasApi/getAll";
	var urlGetMapelApi = base_url_api + "/MapelApi/getAllByKelas";

	var initValidation = function () {
		formBabElement.validate({
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
				'nama_bab': {
					required: true,
				},
				'kelas_id': {
					required: true,
				},
				'mapel_id': {
					required: true,
				}
			},
			messages: {
				'nama_bab': {
					required: 'Nama Bab Harus Di Isi',
				},
				'kelas_id': {
					required: 'Kelas Harus Di Pilih',
				},
				'mapel_id': {
					required: 'Mata Pelajaran Harus Di Pilih',
				}
			}
		});
	};
	$('#pretest_status').change(function () {
		if (this.checked) {
			$(this).prop("checked", true);
			$('#posttest_status').prop("checked", false);
		}
	});
	$('#posttest_status').change(function () {
		if (this.checked) {
			$(this).prop("checked", true);
			$('#pretest_status').prop("checked", false);
		}
	});

	formBabElement.submit(function (event) {
		event.preventDefault();
		for (instance in CKEDITOR.instances) {
			CKEDITOR.instances['deskripsi_bab'].updateElement();
		}

		var valid = formBabElement.valid();

		if (!loading) {
			loading = true;
			if (valid) {
				loadingFormElement.show();

				var formData = new FormData(formBabElement[0]);
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
							$.redirect(base_url + 'back/bab/' + meta_link, null, 'GET');
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
		formBabElement[0].reset();
		imgGambarBabElement.attr('src', base_url + "/assets/back/images/no-image.jpg");
		for (instance in CKEDITOR.instances) {
			CKEDITOR.instances['deskripsi_bab'].updateElement();
		}
	};

	gambarBabElement.change(function () {
		gambarProductChange(this);
	});

	var gambarProductChange = function (input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				imgGambarBabElement.attr('src', e.target.result);
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
			CKEDITOR.replace('deskripsi_bab');
			$(":file").filestyle({ input: false });
			initValidation();
			$(".select2").select2();
			loadingFormElement.hide();
			requestGetKelas();
		}
	}

}();

// Initialize when page loads
jQuery(function () {
	FormBab.init();
});

