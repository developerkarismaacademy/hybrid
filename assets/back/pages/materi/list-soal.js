var ListSoal = function () {

	//INIT URL
	var urlGetApi = base_url_api + "/MateriApi/jsondatasoal";
	var urlDetailApi = base_url_api + "/MateriApi/detailSoal/";
	var urlDeleteApi = base_url_api + "/MateriApi/deleteDataSoal/";
	var noImage = base_url + "/assets/back/images/no-image.jpg";
	var id = $('#idKelas').val();
	var meta = $('#metaKelas').val();
	var idMapel = $('#idMapel').val();
	var metaMapel = $('#metaMapel').val();
	var idBab = $('#idBab').val();
	var metaBab = $('#metaBab').val();
	var idMateri = $('#idMateri').val();
	var metaMateri = $('#metaMateri').val();
	var paketSoal = $('#paketSoal').val();

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
			url = url + "&idMateri=" + idMateri;
			url = url + "&paketSoal=" + paketSoal;

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
				updateListSoal();
			});

			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				loadingElement.hide();
			});


		}
	};

	var updateListSoal = function () {
		$('.data-materi').remove();
		$.each(dataMateri, function (index, value) {
			var clone = cloneDataElement.clone();

			clone.addClass("data-materi");
			clone.prop('id', 'data' + (index + 1));
			clone.removeClass("clone-data");

			clone.find('.isi-soal').html(value.isi_soal + (value.isi_soal.length >= 100 ? " . . ." : ""));
			clone.find('.kunci-jawaban').html(value.kunci_jawaban);

			clone.find('.link-hapus').prop('href', 'javascript:ListSoal.deleteSoal(' + value.id_soal + ');');
			clone.find('.link-ubah').prop('href', base_url + "back/materi/" + value.meta_link_materi + "/ubah-soal/latihan/" + value.id_soal);
			clone.find('.link-detail').prop('href', base_url + "back/materi/" + value.meta_link_materi + "/detail-soal/latihan/" + value.id_soal);

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
			btnPagePreviousElement.find('.page-link').prop('href', 'javascript:ListSoal.changePage(' + (page - 1) + ')');
			btnPagePreviousElement.removeClass('disabled');
		}

		if ((page + 1) > totalPage) {

			btnPageNextElement.find('.page-link').prop('href', 'javascript:;');
			btnPageNextElement.addClass('disabled');
		} else {
			btnPageNextElement.find('.page-link').prop('href', 'javascript:ListSoal.changePage(' + (page + 1) + ')');
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
			cloneBtnPage.find('.page-link').prop('href', 'javascript:ListSoal.changePage(1)');
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
				cloneBtnPage.find('.page-link').prop('href', 'javascript:ListSoal.changePage(' + i + ')');
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
				cloneBtnPage.find('.page-link').prop('href', 'javascript:ListSoal.changePage(' + totalPage + ')');
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

	var deleteSoal = function (id) {
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
					title: "Apa Anda Yakin Ingin Menghapus Soal ?",
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
		deleteSoal(id) {
			deleteSoal(id);
		},
		modalClose() {
			Custombox.modal.close();
		}
	}

	// $P$BUY2k0V11xY6TFLLwphDTOcikzwrTf0

}();

// Initialize when page loads
jQuery(function () {
	ListSoal.init();
});
