var FormBatchLatihan = function () {

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
	var paket = $('#paket').val();

	//INIT FORM
	var formBatchElement = $('#form-batch');
	var formPreviewElement = $('#form-preview');
	var formLatihanSoalElement = $('#form-latihan-soal');
	var formMateriElement = $('#form-materi');
	var kunciElement = $('#kunci');
	var urlSimpanApi = base_url_api + "/MateriApi/simpanBatch";
	var urlSimpanDataApi = base_url_api + "/MateriApi/simpanDataSoal";
	var urlDetailApi = base_url_api + "/MateriApi/detail";

	//INIT PAGING
	var page = 1;
	var btnPagePreviousElement = $('#btn-page-previous');
	var btnPageCloneElement = $('#btn-page');
	var btnPageNextElement = $('#btn-page-next');
	var pagingContainerElement = $('#paging-container');
	var pagingDetailElement = $('#paging-detail');


	//INIT DETAIL
	var namaMateriDetailElement = $('#nama-materi-detail');
	var namaMapelDetailElement = $('#nama-mapel-detail');
	var namaKelasDetailElement = $('#nama-kelas-detail');
	var namaBabDetailElement = $('#nama-bab-detail');
	var deskripsiMateriDetailElement = $('#deskripsi-materi-detail');
	var tipeMateriDetailElement = $('#tipe-materi-detail');
	var metaMateriElement = $('#meta_materi');

	var namaMateri, namaMapel, namaKelas, namaBab, deskripsiMateri, tipeMateri, metaMateri;

	var dataSoal, soal;
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
				'isi_materi': {
					required: true,
				}
			},
			messages: {
				'isi_materi': {
					required: 'Isi Materi Harus Di Isi',
				}
			}
		});

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
			CKEDITOR.instances['isi_materi'].updateElement();
			CKEDITOR.instances['pertanyaan'].updateElement();
			CKEDITOR.instances['jawaban_1'].updateElement();
			CKEDITOR.instances['jawaban_2'].updateElement();
			CKEDITOR.instances['jawaban_3'].updateElement();
			CKEDITOR.instances['jawaban_4'].updateElement();
			CKEDITOR.instances['jawaban_5'].updateElement();
			CKEDITOR.instances['pembahasan'].updateElement();
		}

		if (!loading) {
			loadingFormElement.show();
			loading = true;
			var json = JSON.stringify(dataSoal);

			var request = $.ajax({
				url: urlSimpanDataApi,
				type: 'post',
				data: {soal: json, id_materi: idMateri, paket: paket},
			});

			request.done(function (xhr, status, error) {
				console.log(xhr);
				if (xhr.success) {
					// page = 1;
					// loadDataSoal();
					toastr["success"]("Sukses", "Berhasil Menyimpan Data");
					setTimeout(function () {
						$.redirect(base_url + 'back/materi/' + metaMateri + '/soal/latihan?paket='+paket, null, 'GET');
						resetForm();

					}, 1000);
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
		}
	});

	formMateriElement.submit(function (event) {
		event.preventDefault();
		for (instance in CKEDITOR.instances) {
			CKEDITOR.instances['isi_materi'].updateElement();
			CKEDITOR.instances['pertanyaan'].updateElement();
			CKEDITOR.instances['jawaban_1'].updateElement();
			CKEDITOR.instances['jawaban_2'].updateElement();
			CKEDITOR.instances['jawaban_3'].updateElement();
			CKEDITOR.instances['jawaban_4'].updateElement();
			CKEDITOR.instances['jawaban_5'].updateElement();
			CKEDITOR.instances['pembahasan'].updateElement();
		}

		var valid = formMateriElement.valid();

		if (!loading) {
			loadingFormElement.show();
			loading = true;
			if (valid) {

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
						dataSoal = xhr.data;
						console.log(dataSoal);
						page = 1;
						loadDataSoal();
						// toastr["success"]("Sukses", "Berhasil Menyimpan Data");
						// setTimeout(function () {
						// 	var meta_link = metaMateri;
						// 	$.redirect(base_url + 'back/materi/' + meta_link + '/preview-batch', null, 'POST');
						// 	resetForm();
						//
						// }, 1500);
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

	var setUpPagination = function () {
		//PAGING START

		if ((page - 1) <= 0) {
			btnPagePreviousElement.find('.page-link').prop('href', 'javascript:;');
			btnPagePreviousElement.addClass('disabled');
		} else {
			btnPagePreviousElement.find('.page-link').prop('href', 'javascript:FormBatchLatihan.loadDataSoal(' + (page - 1) + ')');
			btnPagePreviousElement.removeClass('disabled');
		}

		if ((page + 1) > dataSoal.length) {

			btnPageNextElement.find('.page-link').prop('href', 'javascript:;');
			btnPageNextElement.addClass('disabled');
		} else {
			btnPageNextElement.find('.page-link').prop('href', 'javascript:FormBatchLatihan.loadDataSoal(' + (page + 1) + ')');
			btnPageNextElement.removeClass('disabled');
		}
		$('.page-number-dinamis').remove();

		var start = page - 1;

		if (dataSoal.length < 6) {
			start = 2;
		} else if (page < 3) {
			start = 2;
		} else if (page > dataSoal.length - 3) {
			start = dataSoal.length - 3;
		} else {
			start = page - 1;
		}

		//page number 1
		var cloneBtnPage = btnPageCloneElement.clone();

		cloneBtnPage.removeClass("hide");
		cloneBtnPage.addClass("page-number-dinamis");
		cloneBtnPage.prop('id', 'page-number-1');

		cloneBtnPage.find('.page-link').html('1');
		if (page == 1) {
			cloneBtnPage.find('.page-link').prop('href', 'javascript:;');
			cloneBtnPage.addClass('active');

		} else {
			cloneBtnPage.find('.page-link').prop('href', 'javascript:FormBatchLatihan.loadDataSoal(1)');
			cloneBtnPage.removeClass('disabled');
			cloneBtnPage.removeClass('active');
		}

		cloneBtnPage.insertAfter(btnPageCloneElement);


		if (start > 2) {
			cloneBtnPage = btnPageCloneElement.clone();

			cloneBtnPage.removeClass("hide");
			cloneBtnPage.addClass("page-number-dinamis");
			cloneBtnPage.prop('id', 'page-number--1');
			cloneBtnPage.find('.page-link').html('...');
			cloneBtnPage.addClass('disabled');
			cloneBtnPage.find('.page-link').prop('href', 'javascript:;');

			cloneBtnPage.insertAfter($('#page-number-1'));

		}
// console.log(start);
		var akhir = page;

		for (var i = start; i < dataSoal.length; i++) {
			cloneBtnPage = btnPageCloneElement.clone();

			cloneBtnPage.removeClass("hide");
			cloneBtnPage.addClass("page-number-dinamis");
			cloneBtnPage.prop('id', 'page-number-' + i);

			cloneBtnPage.find('.page-link').html(i);
			if (page == i) {
				cloneBtnPage.find('.page-link').prop('href', 'javascript:;');
				cloneBtnPage.addClass('active');

			} else {
				cloneBtnPage.find('.page-link').prop('href', 'javascript:FormBatchLatihan.loadDataSoal(' + i + ')');
				cloneBtnPage.removeClass('disabled');
				cloneBtnPage.removeClass('active');
			}

			if (start > 2 && i == start) {
				cloneBtnPage.insertAfter($('#page-number--1'));
			} else {
				cloneBtnPage.insertAfter($('#page-number-' + (i - 1)));
			}

			akhir = i;
			if (i > (start + 1)) {
				break;
			}
		}

		if (start < (dataSoal.length - 3)) {
			cloneBtnPage = btnPageCloneElement.clone();

			cloneBtnPage.removeClass("hide");
			cloneBtnPage.addClass("page-number-dinamis");
			cloneBtnPage.prop('id', 'page-number--2');
			cloneBtnPage.find('.page-link').html('...');
			cloneBtnPage.addClass('disabled');
			cloneBtnPage.find('.page-link').prop('href', 'javascript:;');

			cloneBtnPage.insertAfter($('#page-number-' + akhir));
		}

		if (dataSoal.length > 1) {
			cloneBtnPage = btnPageCloneElement.clone();

			cloneBtnPage.removeClass("hide");
			cloneBtnPage.addClass("page-number-dinamis");
			cloneBtnPage.prop('id', 'page-number-' + dataSoal.length);

			cloneBtnPage.find('.page-link').html(dataSoal.length);
			if (page == dataSoal.length) {
				cloneBtnPage.find('.page-link').prop('href', 'javascript:;');
				cloneBtnPage.addClass('active');

			} else {
				cloneBtnPage.find('.page-link').prop('href', 'javascript:FormBatchLatihan.loadDataSoal(' + dataSoal.length + ')');
				cloneBtnPage.removeClass('disabled');
				cloneBtnPage.removeClass('active');
			}
			cloneBtnPage.insertBefore(btnPageNextElement);
			// if (start < ( dataSoal.length - 3)) {
			//     console.log('#page-number--2');
			//     cloneBtnPage.insertAfter($('#page-number--2'));
			// } else {
			//     console.log(('#page-number-' + akhir));
			//     cloneBtnPage.insertAfter($('#page-number-' + akhir));
			// }
		}


	};

	var loadDataSoal = function () {

		setUpPagination();
		soal = dataSoal[(page - 1)];
		formBatchElement.hide();
		formPreviewElement.show();

		CKEDITOR.instances['pertanyaan'].setData(soal.pertanyaan);
		CKEDITOR.instances['jawaban_1'].setData(soal.pilihan.jawab_1);
		CKEDITOR.instances['jawaban_2'].setData(soal.pilihan.jawab_2);
		CKEDITOR.instances['jawaban_3'].setData(soal.pilihan.jawab_3);
		CKEDITOR.instances['jawaban_4'].setData(soal.pilihan.jawab_4);
		CKEDITOR.instances['jawaban_5'].setData(soal.pilihan.jawab_5);
		CKEDITOR.instances['pembahasan'].setData(soal.pembahasan);
		kunciElement.val(soal.kunci).change();
	};


	var resetData = function () {
		dataSoal = [];
		formBatchElement.show();
		formPreviewElement.hide();
		CKEDITOR.instances['pertanyaan'].setData("");
		CKEDITOR.instances['jawaban_1'].setData("");
		CKEDITOR.instances['jawaban_2'].setData("");
		CKEDITOR.instances['jawaban_3'].setData("");
		CKEDITOR.instances['jawaban_4'].setData("");
		CKEDITOR.instances['jawaban_5'].setData("");
		CKEDITOR.instances['pembahasan'].setData("");
		kunciElement.val("").change();
	};

	var simpanPerubahan = function () {
		for (instance in CKEDITOR.instances) {
			CKEDITOR.instances['pertanyaan'].updateElement();
			CKEDITOR.instances['jawaban_1'].updateElement();
			CKEDITOR.instances['jawaban_2'].updateElement();
			CKEDITOR.instances['jawaban_3'].updateElement();
			CKEDITOR.instances['jawaban_4'].updateElement();
			CKEDITOR.instances['jawaban_5'].updateElement();
			CKEDITOR.instances['pembahasan'].updateElement();
		}
		setTimeout(function () {
			if (!loading) {
				loading = true;
				var valid = formLatihanSoalElement.valid();
				if (valid) {
					loadingFormElement.show();
					setTimeout(function () {

						var soalPerubahan = {
							kunci: kunciElement.val(),
							pembahasan: $('#pembahasan').val(),
							pertanyaan: $('#pertanyaan').val(),
							pilihan: {
								jawab_1: $('#jawaban_1').val(),
								jawab_2: $('#jawaban_2').val(),
								jawab_3: $('#jawaban_3').val(),
								jawab_4: $('#jawaban_4').val(),
								jawab_5: $('#jawaban_5').val()
							}
						};

						dataSoal[(page - 1)] = soalPerubahan;

						loadingFormElement.hide();
						loading = false;
					}, 500);
				} else {
					loading = false;
				}
			}
		}, 500);
	};


	return {
		init: function () {
			formPreviewElement.hide();
			CKEDITOR.replace('isi_materi');
			CKEDITOR.replace('pertanyaan');
			CKEDITOR.replace('jawaban_1');
			CKEDITOR.replace('jawaban_2');
			CKEDITOR.replace('jawaban_3');
			CKEDITOR.replace('jawaban_4');
			CKEDITOR.replace('jawaban_5');
			CKEDITOR.replace('pembahasan');
			$('.select2').select2();
			initValidation();
			loadingFormElement.hide();
			detailOpen();
		},
		reset() {
			resetForm();
		},
		backBatch() {
			resetData();
		},
		loadDataSoal(i) {
			page = i;
			loadDataSoal();
		},
		changePilihan(i) {
			changePilihan(i);
		},
		simpanPerubahan() {
			simpanPerubahan();
		}
	}

}();

// Initialize when page loads
jQuery(function () {
	FormBatchLatihan.init();
});

