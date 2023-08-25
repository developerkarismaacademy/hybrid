var FormInsertVideo = function () {

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
	var paket_soal = $('#paket_soal').val();

	//INIT FORM
	var formLatihanSoalElement = $('#form-latihan-soal');
	var kunciElement = $('#kunci');
	var urlSimpanApi = base_url_api + "/MateriApi/simpanSoal";
	var urlDetailApi = base_url_api + "/MateriApi/detail";

	//INIT DETAIL
	var namaMateriDetailElement = $('#nama-materi-detail');
	var namaMapelDetailElement = $('#nama-mapel-detail');
	var namaKelasDetailElement = $('#nama-kelas-detail');
	var namaBabDetailElement = $('#nama-bab-detail');
	var deskripsiMateriDetailElement = $('#deskripsi-materi-detail');
	var tipeMateriDetailElement = $('#tipe-materi-detail');
	var metaMateriElement = $('#meta_materi');

	var namaMateri, namaMapel, namaKelas, namaBab, deskripsiMateri, tipeMateri, metaMateri;

	var initValidation = function () {
		formLatihanSoalElement.validate({
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
				'pertanyaan': {
					required: true
				},
				'kunci': {
					required: true
				},
				'jawaban_1': {
					required: true
				},
				'jawaban_2': {
					required: true
				},
				'jawaban_3': {
					required: true
				},
				'jawaban_4': {
					required: true
				},

			},
			messages: {
				'pertanyaan': {
					required: "Pertanyaan Harus Di Isi"
				},
				'kunci': {
					required: "Kunci Harus Di Pilih"
				},
				'jawaban_1': {
					required: "Jawaban 1 Harus Di Isi"
				},
				'jawaban_2': {
					required: "Jawaban 2 Harus Di Isi"
				},
				'jawaban_3': {
					required: "Jawaban 3 Harus Di Isi"
				},
				'jawaban_4': {
					required: "Jawaban 4 Harus Di Isi"
				},

			}
		});
	};

	formLatihanSoalElement.submit(function (event) {
		event.preventDefault();
		for (instance in CKEDITOR.instances) {
			CKEDITOR.instances['pertanyaan'].updateElement();
			CKEDITOR.instances['jawaban_1'].updateElement();
			CKEDITOR.instances['jawaban_2'].updateElement();
			CKEDITOR.instances['jawaban_3'].updateElement();
			CKEDITOR.instances['jawaban_4'].updateElement();
			CKEDITOR.instances['jawaban_5'].updateElement();
			CKEDITOR.instances['pembahasan'].updateElement();
		}

		var valid = formLatihanSoalElement.valid();

		if (!loading) {
			loading = true;

			if (valid) {
				loadingFormElement.show();

				var formData = new FormData(formLatihanSoalElement[0]);
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
							$.redirect(base_url + 'back/materi/' + metaMateri + '/soal/latihan?paket='+paket_soal, null, 'GET');
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
		formLatihanSoalElement[0].reset();
		kunciElement.val("").change();
		for (instance in CKEDITOR.instances) {
			CKEDITOR.instances['pertanyaan'].updateElement();
			CKEDITOR.instances['jawaban_1'].updateElement();
			CKEDITOR.instances['jawaban_2'].updateElement();
			CKEDITOR.instances['jawaban_3'].updateElement();
			CKEDITOR.instances['jawaban_4'].updateElement();
			CKEDITOR.instances['jawaban_5'].updateElement();
			CKEDITOR.instances['pembahasan'].updateElement();
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
				loading = false;
				loadingFormElement.hide();
			});

			request.done(function (xhr, status, error) {

				namaMateri = xhr.data.nama_materi;
				namaMapel = xhr.data.nama_mapel;
				namaKelas = xhr.data.nama_kelas;
				namaBab = xhr.data.nama_bab;
				deskripsiMateri = xhr.data.deskripsi_materi;
				tipeMateri = xhr.data.tipe;
				metaMateri = xhr.data.meta_link_materi;

				namaMateriDetailElement.html(namaMateri);
				namaMapelDetailElement.html(namaMapel);
				namaKelasDetailElement.html(namaKelas);
				namaBabDetailElement.html(namaBab);
				deskripsiMateriDetailElement.html(deskripsiMateri);
				if (tipeMateri == "pilihan") {
					tipeMateriDetailElement.html('<span class="label label-info">Ujian/Test</span>');
				}
				metaMateriElement.val(metaMateri);

				loading = false;

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
			CKEDITOR.replace('pertanyaan');
			CKEDITOR.replace('jawaban_1');
			CKEDITOR.replace('jawaban_2');
			CKEDITOR.replace('jawaban_3');
			CKEDITOR.replace('jawaban_4');
			CKEDITOR.replace('jawaban_5');
			CKEDITOR.replace('pembahasan');
			$(":file").filestyle({ input: false });
			initValidation();
			$(".select2").select2();
			loadingFormElement.hide();
			detailOpen();
		},
	}

}();

// Initialize when page loads
jQuery(function () {
	FormInsertVideo.init();
});

