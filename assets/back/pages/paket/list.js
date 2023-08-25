var ListPaket = function () {

	//INIT URL
	var urlGetApi = base_url_api + "/PaketApi/jsondata";
	var urlDetailApi = base_url_api + "/PaketApi/detail/";
	var urlDeleteApi = base_url_api + "/PaketApi/delete/";

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
	var imgBannerPaketElement = $('#img-banner-paket');

	//INIT LOADING
	var loading = false;
	var loadingElement = $('#loading');

	//INIT GET DATA
	var dataPaket = [];
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
	var namaPaketDetailElement = $('#nama-paket-detail');
	var deskripsiPaketDetailElement = $('#deskripsi-paket-detail');
	var deskripsiSingkat = $('#deskripsi-singkat');
	var hargaBasic = $('#harga-basic');
	var hargaGold = $('#harga-gold');

	var requestPaket = function (url) {
		if (!loading) {
			loading = true;
			url = url + "?page=" + page;
			url = url + "&search=" + search;
			url = url + "&limit=" + limit;

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
				dataPaket = xhr.data;
				totalData = xhr.total;
				totalDataInPage = xhr.total_in_page;
				totalPage = xhr.total_page;
				totalData = xhr.total;
				setUpPagination(xhr);
				updateListPaket();
			});

			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				loadingElement.hide();
			});


		}
	};

	var updateListPaket = function () {
		$('.data-paket').remove();
		$.each(dataPaket, function (index, value) {
			var clone = cloneDataElement.clone();

			clone.addClass("data-paket");
			clone.prop('id', 'data' + (index + 1));
			clone.removeClass("clone-data");

			clone.find('.nama-paket').html(value.nama_paket);
			clone.find('.deskripsi-singkat').html(value.deskripsi_singkat);
			clone.find('.harga_basic').html(value.harga_basic);
			// $('.harga_basic').autoNumeric('init');
			clone.find('.harga_gold').html(value.harga_gold);


			clone.find('.link-detail').prop('href', 'javascript:ListPaket.detailPaket(' + value.id_paket + ');');
			clone.find('.link-hapus').prop('href', 'javascript:ListPaket.deletePaket(' + value.id_paket + ');');
			clone.find('.link-ubah').prop('href', base_url + "back/paket/" + value.meta_link_paket + "/ubah");

			if (index <= 0) {
				clone.insertAfter(cloneDataElement);
			} else {
				clone.insertAfter($('#data' + (index)));
			}
		});
		cloneDataElement.hide();
		$('.data-paket').show();
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
			btnPagePreviousElement.find('.page-link').prop('href', 'javascript:ListPaket.changePage(' + (page - 1) + ')');
			btnPagePreviousElement.removeClass('disabled');
		}

		if ((page + 1) > totalPage) {

			btnPageNextElement.find('.page-link').prop('href', 'javascript:;');
			btnPageNextElement.addClass('disabled');
		} else {
			btnPageNextElement.find('.page-link').prop('href', 'javascript:ListPaket.changePage(' + (page + 1) + ')');
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
			cloneBtnPage.find('.page-link').prop('href', 'javascript:ListPaket.changePage(1)');
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
				cloneBtnPage.find('.page-link').prop('href', 'javascript:ListPaket.changePage(' + i + ')');
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
				cloneBtnPage.find('.page-link').prop('href', 'javascript:ListPaket.changePage(' + totalPage + ')');
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

	var deletePaket = function (id) {
		if (!loading) {
			loadingElement.show();
			tableDateElement.hide();
			loading = true;
			jQuery.getJSON(urlDetailApi + id, result => {
				var form = result.data;
				var nama = form.nama_paket;
				loadingElement.hide();
				tableDateElement.show();
				loading = false;
				swal({
					title: "Apa Anda Yakin Ingin Menghapus Paket " + nama + "?",
					text: "Semua Data Paket Akan Terhapus Dan Tidak Bisa Di Kembalikan",
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
						loadingElement.hide();
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
				requestPaket(urlGetApi);
			})
		}
	};

	formSearchElement.submit(function (event) {
		event.preventDefault();
		search = searchElement.val();
		page = 1;
		limit = 10;
		limitElement.val(limit).change();
		requestPaket(urlGetApi);
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
				namaPaketDetailElement.html(xhr.data.nama_paket);
				deskripsiPaketDetailElement.html(xhr.data.deskripsi);
				deskripsiSingkat.html(xhr.data.deskripsi_singkat);
				hargaBasic.html(xhr.data.harga_basic);
				hargaGold.html(xhr.data.harga_gold);
				console.log(xhr.data.banner_paket);
				if (xhr.data.banner_paket) {
					imgBannerPaketElement.attr('src', base_url + "/upload/baner-paket/" + xhr.data.banner_paket);
				} else {
					imgBannerPaketElement.attr('src', base_url + "/upload/baner-paket/default.jpg")
				}
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
			requestPaket(urlGetApi)
		},
		refresh: function () {
			page = 1;
			search = "";
			searchElement.val("");
			requestPaket(urlGetApi);
		},
		limitChange() {
			limit = limitElement.val();
			page = 1;
			requestPaket(urlGetApi);
		}, changePage: function (i) {
			page = i;
			requestPaket(urlGetApi);
		},
		detailPaket(id) {
			detailOpen(id);
		},
		deletePaket(id) {
			deletePaket(id);
		},
		modalClose() {
			Custombox.modal.close();
		}
	}

	// $P$BUY2k0V11xY6TFLLwphDTOcikzwrTf0

}();

// Initialize when page loads
jQuery(function () {
	ListPaket.init();
});

