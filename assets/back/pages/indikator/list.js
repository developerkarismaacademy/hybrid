var ListIndikator = function () {

	//INIT URL
	var urlGetApi = base_url_api + "/IndikatorApi/jsondata";
	var urlDetailApi = base_url_api + "/IndikatorApi/detail/";
	var urlDeleteApi = base_url_api + "/IndikatorApi/delete/";

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
	var idKelas = $("#idKelas").val();
	var idMapel = $("#idMapel").val();
	var idKompetensi = $("#idKompetensi").val();
	var idIndikatorInduk = $("#idIndikatorInduk").val();
	var metaMapel = $("#metaMapel").val();
	var dataIndikator = [];
	var totalData = 0;
	var totalDataInPage = 0;
	var totalPage = 0;
	var cloneDataElement = $('#clone-data');
	var tableDateElement = $('#table-data');

	//MODAL
	var modal = new Custombox.modal({
		content: {
			effect: 'blur',
			target: '#modal-detail'
		},
		overlay: {
			color: "#36404a"
		}
	});
	var loadingModalElement = $('#loading-modal');
	var modalContainerElement = $('#modal-container');
	var kompetensiDetailElement = $('#kompetensi-detail');
	var indikatorIndukDetailElement = $('#indikator-induk-detail');
	var indikatorDetailElement = $('#indikator-detail');

	var requestIndikator = function (url) {
		if (!loading) {
			loading = true;
			url = url + "?page=" + page;
			url = url + "&search=" + search;
			url = url + "&limit=" + limit;
			url = url + "&idKompetensi=" + idKompetensi;
			url = url + "&idIndikatorInduk=" + idIndikatorInduk;

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
				dataIndikator = xhr.data;
				totalData = xhr.total;
				totalDataInPage = xhr.total_in_page;
				totalPage = xhr.total_page;
				totalData = xhr.total;
				setUpPagination(xhr);
				updateListIndikator();
			});

			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				loadingElement.hide();
			});


		}
	};

	var updateListIndikator = function () {
		$('.data-indikator').remove();
		$.each(dataIndikator, function (index, value) {
			var clone = cloneDataElement.clone();

			clone.addClass("data-indikator");
			clone.prop('id', 'data' + (index + 1));
			clone.removeClass("clone-data");

			var indikator_induk = value.indikator_induk.length > 60 ? (value.indikator_induk.substr(0, 60) + " ...") : value.indikator_induk;

			if (value.indikator_induk.length > 60) {
				indikator_induk = "<span title='" + value.indikator_induk + "'>" + indikator_induk + "</span>";
			}
			var indikator = value.indikator.length > 60 ? (value.indikator.substr(0, 60) + " ...") : value.indikator;

			if (value.indikator.length > 60) {
				indikator = "<span title='" + value.indikator + "'>" + indikator + "</span>";
			}

			clone.find('.indikator-induk').html(indikator_induk);
			clone.find('.indikator').html(indikator);

			clone.find('.link-detail').prop('href', 'javascript:ListIndikator.detailIndikator(' + value.id_indikator + ');');
			clone.find('.link-hapus').prop('href', 'javascript:ListIndikator.deleteIndikator(' + value.id_indikator + ');');
			clone.find('.link-ubah').prop('href', base_url + "back/indikator/" + idIndikatorInduk + "/ubah/" + value.id_indikator);

			if (index <= 0) {
				clone.insertAfter(cloneDataElement);
			} else {
				clone.insertAfter($('#data' + (index)));
			}
		});
		cloneDataElement.hide();
		$('.data-indikator').show();
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
			btnPagePreviousElement.find('.page-link').prop('href', 'javascript:ListIndikator.changePage(' + (page - 1) + ')');
			btnPagePreviousElement.removeClass('disabled');
		}

		if ((page + 1) > totalPage) {

			btnPageNextElement.find('.page-link').prop('href', 'javascript:;');
			btnPageNextElement.addClass('disabled');
		} else {
			btnPageNextElement.find('.page-link').prop('href', 'javascript:ListIndikator.changePage(' + (page + 1) + ')');
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
			cloneBtnPage.find('.page-link').prop('href', 'javascript:ListIndikator.changePage(1)');
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
				cloneBtnPage.find('.page-link').prop('href', 'javascript:ListIndikator.changePage(' + i + ')');
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
				cloneBtnPage.find('.page-link').prop('href', 'javascript:ListIndikator.changePage(' + totalPage + ')');
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

	var deleteIndikator = function (id) {
		if (!loading) {
			loadingElement.show();
			tableDateElement.hide();
			loading = true;
			jQuery.getJSON(urlDetailApi + id, result => {
				var form = result.data;
				var nama = form.indikator_induk;
				loadingElement.hide();
				tableDateElement.show();
				loading = false;
				swal({
					title: "Apa Anda Yakin Ingin Menghapus Indikator " + nama + "?",
					text: "Semua Data Indikator Induk Akan Terhapus Dan Tidak Bisa Di Kembalikan",
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
				requestIndikator(urlGetApi);
			})
		}
	};

	formSearchElement.submit(function (event) {
		event.preventDefault();
		search = searchElement.val();
		page = 1;
		limit = 10;
		limitElement.val(limit).change();
		requestIndikator(urlGetApi);
	});

	var detailOpen = function (id) {
		modal.open();

		if (!loading) {
			loading = true;

			var request = jQuery.ajax({
				url: urlDetailApi + id,
				method: "GET",
				beforeSend: function (xhr) {
					loadingElement.show();
					tableDateElement.hide();
					loadingModalElement.show();
					modalContainerElement.hide();
				}
			});

			request.always(function (xhr, status, error) {
				loading = false;
				loadingElement.hide();
				tableDateElement.show();
				loadingModalElement.hide();
				modalContainerElement.show();
			});

			request.done(function (xhr, status, error) {
				kompetensiDetailElement.html(xhr.data.kompetensi);
				indikatorIndukDetailElement.html(xhr.data.indikator_induk);
				indikatorDetailElement.html(xhr.data.indikator);
			});

			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				loadingElement.hide();
			});


		}
	};

	return {
		init: function () {
			requestIndikator(urlGetApi)
		},
		refresh: function () {
			page = 1;
			search = "";
			searchElement.val("");
			requestIndikator(urlGetApi);
		},
		limitChange() {
			limit = limitElement.val();
			page = 1;
			requestIndikator(urlGetApi);
		}, changePage: function (i) {
			page = i;
			requestIndikator(urlGetApi);
		},
		detailIndikator(id) {
			detailOpen(id);
		},
		deleteIndikator(id) {
			deleteIndikator(id);
		},
		modalClose() {
			Custombox.modal.close();
		}
	}

	// $P$BUY2k0V11xY6TFLLwphDTOcikzwrTf0

}();

// Initialize when page loads
jQuery(function () {
	ListIndikator.init();
});

