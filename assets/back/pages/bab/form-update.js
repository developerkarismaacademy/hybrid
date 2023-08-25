var FormBab = function () {

	//INIT LOADING
	var loading = false;
	var loadingFormElement = $('.loading-form');
	var id = $('#idKelas').val();
	var meta = $('#metaKelas').val();
	var idMapel = $('#idMapel').val();
	var metaMapel = $('#metaMapel').val();
	var idBab = $('#id_bab').val();

	//INIT FORM
	var formBabElement = $('#form-bab');
	var gambarBabElement = $('#gambar_bab');
	var kelasElement = $('#kelas_id');
	var mapelElement = $('#mapel_id');
	var imgGambarBabElement = $('#img-gambar-bab');
	var namaBabElement = $('#nama_bab');
	var deskripsiBabElement = $('#deskripsi_bab');
	;

	var nama_bab, kelas_id, mapel_id, deskripsi_bab, gambar_bab, pretest_status, posttest_status;

	var urlSimpanApi = base_url_api + "/BabApi/update";
	var urlGetKelasApi = base_url_api + "/KelasApi/getAll";
	var urlGetMapelApi = base_url_api + "/MapelApi/getAllByKelas";
	var urlDetailApi = base_url_api + "/BabApi/detail/";

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
				loading = false;

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
				url: urlDetailApi + idBab,
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
				nama_bab = xhr.data.nama_bab;
				kelas_id = xhr.data.kelas_id;
				mapel_id = xhr.data.mapel_id;
				deskripsi_bab = xhr.data.deskripsi_bab;
				gambar_bab = xhr.data.gambar_bab;
				pretest_status = xhr.data.pretest_status;
				posttest_status = xhr.data.posttest_status;

				namaBabElement.val(nama_bab);


				setTimeout(function () {
					deskripsiBabElement.html(deskripsi_bab);
					CKEDITOR.instances['deskripsi_bab'].setData(deskripsi_bab);
				}, 500);

				kelasElement.val(kelas_id).trigger('change');
				mapelElement.val(mapel_id).trigger('change');
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
				if (pretest_status == 1) {
					$('#pretest_status').prop("checked", true);
				} else {
					$('#pretest_status').prop("checked", false);
				}

				if (posttest_status == 1) {
					$('#posttest_status').prop("checked", true);
				} else {
					$('#posttest_status').prop("checked", false);
				}

				if (xhr.data.gambar_bab != "") {
					console.log(xhr.data.gambar_bab);
					imgGambarBabElement.attr('src', base_url + "/upload/bab/" + xhr.data.gambar_bab);
					img = base_url + "/upload/mapel/" + xhr.data.gambar_bab;
				} else {
					imgGambarBabElement.attr('src', base_url + "/assets/back/images/no-image.jpg");
					img = base_url + "/assets/back/images/no-image.jpg";
				}
				loading = false;
				requestGetKelas();


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
		imgGambarBabElement.attr('src', img);
		namaBabElement.val(nama_bab);
		hargaBasicElement.val(harga_basic);
		hargaGoldElement.val(harga_gold);
		hargaSilverElement.val(harga_silver);
		deskripsiBabElement.html(deskripsi_bab);
		kelasElement.val(kelas_id).trigger('change');
		CKEDITOR.instances['deskripsi_bab'].setData(deskripsi_bab);
	};

	return {
		init: function () {
			CKEDITOR.replace('deskripsi_bab');
			$(":file").filestyle({ input: false });
			initValidation();
			$(".select2").select2();
			loadingFormElement.hide();
			detailOpen();
		}, reset: function () {
			resetForm();
		}
	}

}();

// Initialize when page loads
jQuery(function () {
	FormBab.init();
});

