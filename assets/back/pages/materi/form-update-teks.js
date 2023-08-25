var FormUpdateVideo = function () {

	//INIT LOADING
	var loading = false;
	var loadingFormElement = $('.loading-form');
	var id = $('#idKelas').val();
	var meta = $('#metaKelas').val();
	var idMapel = $('#idMapel').val();
	var metaMapel = $('#metaMapel').val();
	var idBab = $('#idBab').val();
	var metaBab = $('#metaBab').val();
	var idMateri = $('#id_materi').val();

	//INIT FORM
	var formMateriElement = $('#form-materi');
	var gambarMapelElement = $('#gambar_bab');
	var kelasElement = $('#kelas_id');
	var mapelElement = $('#mapel_id');
	var babElement = $('#bab_id');
	var namaMateriElement = $('#nama_materi');
	var isiMateriElement = $('#isi_materi');
	var deskripsiMateriElement = $('#deskripsi_materi');
	var urlSimpanApi = base_url_api + "/MateriApi/ubahTeks";
	var urlDetailApi = base_url_api + "/MateriApi/detail";
	var urlGetKelasApi = base_url_api + "/KelasApi/getAll";
	var urlGetMapelApi = base_url_api + "/MapelApi/getAllByKelas";
	var urlGetBabApi = base_url_api + "/BabApi/getAllByMapel";

	var nama_materi, kelas_id, mapel_id, bab_id, isi_materi, deskripsi_materi;


	var initValidation = function () {
		formMateriElement.validate({
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
				'nama_materi': {
					required: true,
				},
				'bab_id': {
					required: true,
				},
				'kelas_id': {
					required: true,
				},
				'mapel_id': {
					required: true,
				},
				'isi_materi': {
					required: true,
					// checkYoutubeVideo: true,
				}
			},
			messages: {
				'nama_bab': {
					required: 'Nama Bab Harus Di Isi',
				},
				'bab_id': {
					required: "Bab Harus Di Isi",
				},
				'kelas_id': {
					required: 'Kelas Harus Di Pilih',
				},
				'mapel_id': {
					required: 'Mata Pelajaran Harus Di Pilih',
				},
				'isi_materi': {
					required: 'isi Materi Harus Di Isi',
					// checkYoutubeVideo: 'Video Tidak Di Temukan',
				}
			}
		});
	};

	formMateriElement.submit(function (event) {
		event.preventDefault();
		for (instance in CKEDITOR.instances) {
			CKEDITOR.instances['isi_materi'].updateElement();
			CKEDITOR.instances['deskripsi_materi'].updateElement();
		}

		var valid = formMateriElement.valid();

		if (!loading) {
			loading = true;
			if (valid) {
				loadingFormElement.show();

				var formData = new FormData(formMateriElement[0]);
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
							var meta_link = babElement.find(':selected').data('meta');
							$.redirect(base_url + 'back/materi/' + meta_link, null, 'GET');
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

	};

	gambarMapelElement.change(function () {
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

	mapelElement.change(function () {
		if (mapelElement.val() != "") {
			requestGetBab();
		}
	});

	var requestGetBab = function () {
		if (!loading) {
			loading = true;

			var request = jQuery.ajax({
				url: urlGetBabApi + "/" + mapelElement.val(),
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
				babElement.empty();
				let option = new Option('Pilih Bab', '', false, false);
				babElement.append(option);

				$.each(xhr.data, function (index, value) {

					let selected = false;
					if (value.id_bab == idBab) {
						selected = true;
					}

					option = new Option(value.nama_bab, value.id_bab, selected, selected);
					option.setAttribute("data-meta", value.meta_link_bab);
					babElement.append(option);
				});

				babElement.val(idBab).trigger('change');

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
				url: urlDetailApi + "/" + idMateri,
				method: "GET",
				beforeSend: function (xhr) {
					loadingFormElement.show();
				}
			});

			request.always(function (xhr, status, error) {
				// loading = false;
				// loadingFormElement.hide();
			});

			request.done(function (xhr, status, error) {
				nama_materi = xhr.data.nama_materi;
				kelas_id = xhr.data.kelas_id;
				mapel_id = xhr.data.mapel_id;
				bab_id = xhr.data.bab_id;
				deskripsi_materi = xhr.data.deskripsi_materi;
				isi_materi = xhr.data.isi_materi;
				console.log(isi_materi);

				setTimeout(function () {
					isiMateriElement.html(isi_materi);
					CKEDITOR.instances['isi_materi'].setData(isi_materi);
					deskripsiMateriElement.html(deskripsi_materi);
					CKEDITOR.instances['deskripsi_materi'].setData(deskripsi_materi);

					namaMateriElement.val(nama_materi);
					kelasElement.val(kelas_id).trigger('change');
					mapelElement.val(mapel_id).trigger('change');
					babElement.val(bab_id).trigger('change');


					loading = false;
					requestGetKelas();
				}, 1500);


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
			CKEDITOR.replace('isi_materi');
			CKEDITOR.replace('deskripsi_materi');
			initValidation();
			$(".select2").select2();
			loadingFormElement.hide();
			detailOpen();
		},
		reset() {
			resetForm();
		}
	}

}();

// Initialize when page loads
jQuery(function () {
	FormUpdateVideo.init();
});

