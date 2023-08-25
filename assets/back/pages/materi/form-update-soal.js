var FormUpdateSoal = function () {

	//INIT LOADING
	var loading = false;
	var loadingFormElement = $('.loading-form');
	var id = $('#idKelas').val();
	var meta = $('#metaKelas').val();
	var idMapel = $('#idMapel').val();
	var metaMapel = $('#metaMapel').val();
	var idBab = $('#idBab').val();
	var metaBab = $('#metaBab').val();
	var idMateri = $('#idMateri').val();
	var metaMateri = $('#metaMateri').val();
	var idSoal = $('#id_soal').val();

	//INIT FORM
	var formLatihanSoalElement = $('#form-latihan-soal');
	var kunciElement = $('#kunci');
	var pertanyaanElement = $('#pertanyaan');
	var jawaban1Element = $('#jawaban_1');
	var jawaban2Element = $('#jawaban_2');
	var jawaban3Element = $('#jawaban_3');
	var jawaban4Element = $('#jawaban_4');
	var jawaban5Element = $('#jawaban_5');
	var pembahasanElement = $('#pembahasan');
	var urlSimpanApi = base_url_api + "/MateriApi/ubahSoal";
	var urlDetailApi = base_url_api + "/MateriApi/detailSoal";

	//INIT DETAIL
	var namaMateriDetailElement = $('#nama-materi-detail');
	var namaMapelDetailElement = $('#nama-mapel-detail');
	var namaKelasDetailElement = $('#nama-kelas-detail');
	var namaBabDetailElement = $('#nama-bab-detail');
	var deskripsiMateriDetailElement = $('#deskripsi-materi-detail');
	var tipeMateriDetailElement = $('#tipe-materi-detail');
	var metaMateriElement = $('#meta_materi');


	var namaMateri, namaMapel, namaKelas, namaBab, deskripsiMateri, tipeMateri;
	var pertanyaan, kunci, jawaban_1, jawaban_2, jawaban_3, jawaban_4, jawaban_5, pembahasan;

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
							$.redirect(base_url + 'back/materi/' + metaMateri + '/soal/latihan', null, 'POST');
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
		loadingFormElement.show();
		initValidation();
		formLatihanSoalElement[0].reset();
		kunciElement.val(kunci).trigger('change');

		setTimeout(function () {
			pertanyaanElement.html(pertanyaan);
			CKEDITOR.instances['pertanyaan'].setData(pertanyaan);
			jawaban1Element.html(jawaban_1);
			CKEDITOR.instances['jawaban_1'].setData(jawaban_1);
			jawaban2Element.html(jawaban_2);
			CKEDITOR.instances['jawaban_2'].setData(jawaban_2);
			jawaban3Element.html(jawaban_3);
			CKEDITOR.instances['jawaban_3'].setData(jawaban_3);
			jawaban4Element.html(jawaban_4);
			CKEDITOR.instances['jawaban_4'].setData(jawaban_4);
			jawaban5Element.html(jawaban_5);
			CKEDITOR.instances['jawaban_5'].setData(jawaban_5);
			pembahasanElement.html(pembahasan);
			CKEDITOR.instances['pembahasan'].setData(pembahasan);
			loadingFormElement.hide();
		}, 2000);
	};


	var detailOpen = function () {

		if (!loading) {
			loading = true;

			var request = jQuery.ajax({
				url: urlDetailApi + "/" + idSoal,
				method: "GET",
				beforeSend: function (xhr) {
					loadingFormElement.show();
				}
			});

			request.always(function (xhr, status, error) {
				loading = false;
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
				pertanyaan = xhr.data.isi_soal;

				switch (parseInt(xhr.data.kunci_jawaban)) {
					case 1:
						kunci = "A";
						break;
					case 2:
						kunci = "B";
						break;
					case 3:
						kunci = "C";
						break;
					case 4:
						kunci = "D";
						break;
					case 5:
						kunci = "E";
						break;
					default:
						kunci = "A";
						break;
				}

				jawaban_1 = xhr.data.jawab_1;
				jawaban_2 = xhr.data.jawab_2;
				jawaban_3 = xhr.data.jawab_3;
				jawaban_4 = xhr.data.jawab_4;
				jawaban_5 = xhr.data.jawab_5;
				pembahasan = xhr.data.pembahasan;

				kunciElement.val(kunci).trigger('change');

				setTimeout(function () {
					pertanyaanElement.html(pertanyaan);
					CKEDITOR.instances['pertanyaan'].setData(pertanyaan);
					jawaban1Element.html(jawaban_1);
					CKEDITOR.instances['jawaban_1'].setData(jawaban_1);
					jawaban2Element.html(jawaban_2);
					CKEDITOR.instances['jawaban_2'].setData(jawaban_2);
					jawaban3Element.html(jawaban_3);
					CKEDITOR.instances['jawaban_3'].setData(jawaban_3);
					jawaban4Element.html(jawaban_4);
					CKEDITOR.instances['jawaban_4'].setData(jawaban_4);
					jawaban5Element.html(jawaban_5);
					CKEDITOR.instances['jawaban_5'].setData(jawaban_5);
					pembahasanElement.html(pembahasan);
					CKEDITOR.instances['pembahasan'].setData(pembahasan);
					loadingFormElement.hide();
				}, 2000);


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
			$(":file").filestyle({input: false});
			initValidation();
			$(".select2").select2();
			loadingFormElement.hide();
			detailOpen();
		},
		resetForm: function () {
			resetForm();
		}
	}

}();

// Initialize when page loads
jQuery(function () {
	FormUpdateSoal.init();
});

