var ListMateri = function () {

	//INIT URL
	var urlGetApi = base_url_api + "/MateriApi/jsondata";
	var urlDetailApi = base_url_api + "/MateriApi/detail/";
	var urlDeleteApi = base_url_api + "/MateriApi/delete/";
	var noImage = base_url + "/assets/back/images/no-image.jpg";
	var id = $('#idMapel').val();
	var idKelas = $('#idKelas').val();
	var idBab = $('#idBab').val();

	//INIT PAGING AND SEARCH
	var page = 1;
	var limit = 10;
	var limitElement = $('#limit');
	var formSearchElement = $('#form-search');
	var searchElement = $('#search');
	var search = "";

	var btnPagePreviousElement = $('#btn-page-previous');
	var btnPageCloneElement = $('#btn-page');
	var btnPageNextElement = $('#btn-page-next');
	var pagingContainerElement = $('#paging-container');
	var pagingDetailElement = $('#paging-detail');

	//INIT LOADING
	var loading = false;
	var loadingElement = $('#loading');

	//INIT GET DATA
	var dataMateri = [];
	var totalData = 0;
	var totalDataInPage = 0;
	var totalPage = 0;
	var cloneDataElement = $('#clone-data');
	var tableDateElement = $('#table-data');


	var requestMateri = function (url) {
		if (!loading) {
			loading = true;
			url = url + "?page=" + page;
			url = url + "&search=" + search;
			url = url + "&limit=" + limit;
			url = url + "&idBab=" + idBab;

			var request = jQuery.ajax({
				url: url,
				method: "GET",
				beforeSend: function (xhr) {
					loadingElement.show();
					tableDateElement.hide();
				}
			});

			request.always(function (xhr, status, error) {
			});

			request.done(function (xhr, status, error) {
				dataMateri = xhr.data;
				totalData = xhr.total;
				totalDataInPage = xhr.total_in_page;
				totalPage = xhr.total_page;
				totalData = xhr.total;
				setUpPagination(xhr);
				updateListMateri();
			});

			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				loadingElement.hide();
			});


		}
	};

	var updateListMateri = function () {
		// console.log(dataMateri)
		$('.data-materi').remove();
		$.each(dataMateri, function (index, value) {
			var clone = cloneDataElement.clone();

			clone.addClass("data-materi");
			clone.prop('id', 'data' + (index + 1));
			clone.removeClass("clone-data");

			clone.find('.nama-materi').html(value.nama_materi);
			console.log(value.tipe);
			if (value.tipe == "pilihan") {
				clone.find('.jenis-materi').html('<span class="label label-info">Ujian/Test</span>');
				if (value.pretest_status == 1 || value.posttest_status == 1) {
					clone.find('.link-package').removeClass('hidden')

				} else {
					clone.find('.link-daftar').removeClass("hidden");
					clone.find('.link-batch').removeClass("hidden");

				}
				clone.find('.link-detail').addClass("hidden");

			} else if (value.tipe == "teks") {
				clone.find('.jenis-materi').html('<span class="label label-primary">Materi Teks</span>');
				clone.find('.link-asset').removeClass("hidden");
				clone.find('.link-asset').prop('href', base_url + "back/asset/" + value.id_materi);
			} else if (value.tipe == "praktek") {
				clone.find('.jenis-materi').html('<span class="label label-info">Praktek</span>');
				clone.find('.link-asset').removeClass("hidden");
				clone.find('.link-asset').prop('href', base_url + "back/asset/" + value.id_materi);
			} else if (value.tipe == "pdf") {
				clone.find('.jenis-materi').html('<span class="label label-info">Materi PDF</span>');
				clone.find('.link-asset').removeClass("hidden");
				clone.find('.link-asset').prop('href', base_url + "back/asset/" + value.id_materi);
			} else {
				clone.find('.jenis-materi').html('<span class="label label-default">Materi Video</span>');
				clone.find('.link-asset').removeClass("hidden");
				clone.find('.link-asset').prop('href', base_url + "back/asset/" + value.id_materi);
			}


			var tipe;
			if (value.tipe == "pilihan") {
				tipe = "latihan";

				clone.find('.link-diskusi').remove();
			} else {
				tipe = value.tipe;

				clone.find('.link-diskusi').prop('href', base_url + "back/materi/" + value.meta_link_materi + "/diskusi/");
			}
			clone.find('.link-detail').prop('href', base_url + "back/materi/" + value.meta_link_materi + "/detail/" + tipe);
			clone.find('.link-hapus').prop('href', 'javascript:ListMateri.deleteMateri(' + value.id_materi + ');');
			clone.find('.link-ubah').prop('href', base_url + "back/materi/" + value.meta_link_materi + "/ubah/" + tipe);
			clone.find('.link-daftar').prop('href', base_url + "back/materi/" + value.meta_link_materi + "/soal/" + tipe);
			clone.find('.link-batch').prop('href', base_url + "back/materi/" + value.meta_link_materi + "/batch/" + tipe);
			if (value.pretest_status == 1 || value.posttest_status == 1) {
				clone.find('.link-package').prop('href', base_url + 'back/materi/package/' + value.meta_link_materi)
			}
			if (index <= 0) {
				clone.insertAfter(cloneDataElement);
			} else {
				clone.insertAfter($('#data' + (index)));
			}
		});
		cloneDataElement.hide();
		$('.data-materi').show();
		loading = false;
		loadingElement.hide();
		tableDateElement.show();
	};

	var setUpPagination = function (data) {
		//PAGING START

		page = parseInt(data.current_page);
		if ((page - 1) <= 0) {
			btnPagePreviousElement.find('.page-link').prop('href', 'javascript:;');
			btnPagePreviousElement.addClass('disabled');
		} else {
			btnPagePreviousElement.find('.page-link').prop('href', 'javascript:ListMateri.changePage(' + (page - 1) + ')');
			btnPagePreviousElement.removeClass('disabled');
		}

		if ((page + 1) > totalPage) {

			btnPageNextElement.find('.page-link').prop('href', 'javascript:;');
			btnPageNextElement.addClass('disabled');
		} else {
			btnPageNextElement.find('.page-link').prop('href', 'javascript:ListMateri.changePage(' + (page + 1) + ')');
			btnPageNextElement.removeClass('disabled');
		}
		$('.page-number-dinamis').remove();

		var start = page - 1;

		if (totalPage < 6) {
			start = 2;
		} else if (page < 3) {
			start = 2;
		} else if (page > totalPage - 3) {
			start = totalPage - 3;
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
			cloneBtnPage.find('.page-link').prop('href', 'javascript:ListMateri.changePage(1)');
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
			cloneBtnPage.addClass('active');

			cloneBtnPage.insertAfter($('#page-number-1'));

		}
		// console.log(start);
		var akhir = page;

		for (var i = start; i < totalPage; i++) {
			cloneBtnPage = btnPageCloneElement.clone();

			cloneBtnPage.removeClass("hide");
			cloneBtnPage.addClass("page-number-dinamis");
			cloneBtnPage.prop('id', 'page-number-' + i);

			cloneBtnPage.find('.page-link').html(i);
			if (page == i) {
				cloneBtnPage.find('.page-link').prop('href', 'javascript:;');
				cloneBtnPage.addClass('active');

			} else {
				cloneBtnPage.find('.page-link').prop('href', 'javascript:ListMateri.changePage(' + i + ')');
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

		if (start < (totalPage - 3)) {
			cloneBtnPage = btnPageCloneElement.clone();

			cloneBtnPage.removeClass("hide");
			cloneBtnPage.addClass("page-number-dinamis");
			cloneBtnPage.prop('id', 'page-number--2');
			cloneBtnPage.find('.page-link').html('...');
			cloneBtnPage.addClass('disabled');
			cloneBtnPage.find('.page-link').prop('href', 'javascript:;');
			cloneBtnPage.addClass('active');

			cloneBtnPage.insertAfter($('#page-number-' + akhir));
		}

		if (totalPage > 1) {
			cloneBtnPage = btnPageCloneElement.clone();

			cloneBtnPage.removeClass("hide");
			cloneBtnPage.addClass("page-number-dinamis");
			cloneBtnPage.prop('id', 'page-number-' + totalPage);

			cloneBtnPage.find('.page-link').html(totalPage);
			if (page == totalPage) {
				cloneBtnPage.find('.page-link').prop('href', 'javascript:;');
				cloneBtnPage.addClass('active');

			} else {
				cloneBtnPage.find('.page-link').prop('href', 'javascript:ListMateri.changePage(' + totalPage + ')');
				cloneBtnPage.removeClass('disabled');
				cloneBtnPage.removeClass('active');
			}
			cloneBtnPage.insertBefore(btnPageNextElement);
			// if (start < (totalPage - 3)) {
			//     console.log('#page-number--2');
			//     cloneBtnPage.insertAfter($('#page-number--2'));
			// } else {
			//     console.log(('#page-number-' + akhir));
			//     cloneBtnPage.insertAfter($('#page-number-' + akhir));
			// }
		}


		pagingDetailElement.html("Menampilkan  (<span class='font-weight-bold'>" + (data.start + 1) + "</span> - <span class='font-weight-bold'>" + data.end + "</span> Dari <span class='font-weight-bold'>" + totalData + "</span> Data) " +
			"<br> Halaman <span class='font-weight-bold'>" + page + "</span> , Total <span class='font-weight-bold'>" + totalPage + "</span> Halaman");

	};

	var deleteMateri = function (id) {
		if (!loading) {
			loadingElement.show();
			tableDateElement.hide();
			loading = true;
			jQuery.getJSON(urlDetailApi + id, result => {
				var form = result.data;
				var nama = form.nama_bab;
				loadingElement.hide();
				tableDateElement.show();
				loading = false;
				swal({
					title: "Apa Anda Yakin Ingin Menghapus Materi " + nama + "?",
					text: "Semua Data Materi Akan Terhapus Dan Tidak Bisa Di Kembalikan",
					type: "error",
					showCancelButton: true,
					confirmButtonClass: 'btn-danger',
					confirmButtonText: "Ya, Hapus!",
					cancelButtonText: "Batal",
					closeOnConfirm: true,
					closeOnCancel: true
				}, function (isConfirm) {
					if (isConfirm) {
						deleteServer(id);
					}
				});
			}).fail(error => {
				loading = false;
			});
		}
	};

	var deleteServer = function (id) {
		if (!loading) {
			loadingElement.show();
			tableDateElement.hide();
			loading = true;
			jQuery.getJSON(urlDeleteApi + id, result => {
				loading = false;
			}).fail(error => {
				loading = false;
			}).done(data => {
				toastr['success']('', data.message);
				loading = false;
				loadingElement.hide();
				tableDateElement.show();
				requestMateri(urlGetApi);
			})
		}
	};

	formSearchElement.submit(function (event) {
		event.preventDefault();
		search = searchElement.val();
		page = 1;
		limit = 10;
		limitElement.val(limit).change();
		requestMateri(urlGetApi);
	});


	return {
		init: function () {
			requestMateri(urlGetApi)
		},
		refresh: function () {
			page = 1;
			search = "";
			searchElement.val("");
			requestMateri(urlGetApi);
		},
		limitChange() {
			limit = limitElement.val();
			page = 1;
			requestMateri(urlGetApi);
		}, changePage: function (i) {
			page = i;
			requestMateri(urlGetApi);
		},
		deleteMateri(id) {
			deleteMateri(id);
		},
		modalClose() {
			Custombox.modal.close();
		}
	}

	// $P$BUY2k0V11xY6TFLLwphDTOcikzwrTf0

}();

// Initialize when page loads
jQuery(function () {
	ListMateri.init();
});
