var ListSiswa = function () {

	//INIT URL
	var urlGetApi = base_url_api + "/SiswaApi/jsondatamapel";
	var urlDetailApi = base_url_api + "/SiswaApi/detail/";
	var noImage = base_url + "/assets/back/images/no-image.jpg";

	//INIT PAGING AND SEARCH
	var page = 1;
	var limit = 10;
	var limitElement = $('#limit');
	var formSearchElement = $('#form-search');
	var searchElement = $('#search');
	var search = "";
	var idKelas = $("#idKelas").val();
	var idMapel = $("#idMapel").val();
	var metaMapel = $("#metaMapel").val();

	var btnPagePreviousElement = $('#btn-page-previous');
	var btnPageCloneElement = $('#btn-page');
	var btnPageNextElement = $('#btn-page-next');
	var pagingContainerElement = $('#paging-container');
	var pagingDetailElement = $('#paging-detail');


	//INIT LOADING
	var loading = false;
	var loadingElement = $('#loading');

	//INIT GET DATA
	var dataSiswa = [];
	var totalData = 0;
	var totalDataInPage = 0;
	var totalPage = 0;
	var cloneDataElement = $('#clone-data');
	var tableDateElement = $('#table-data');


	var requestSiswa = function (url) {
		if (!loading) {
			loading = true;
			url = url + "?page=" + page;
			url = url + "&search=" + search;
			url = url + "&limit=" + limit;
			url = url + "&idMapel=" + idMapel;

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
				dataSiswa = xhr.data;
				totalData = xhr.total;
				totalDataInPage = xhr.total_in_page;
				totalPage = xhr.total_page;
				totalData = xhr.total;
				setUpPagination(xhr);
				updateListSiswa();
			});

			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				loadingElement.hide();
			});


		}
	};

	var updateListSiswa = function () {
		$('.data-kelas').remove();
		$.each(dataSiswa, function (index, value) {
			var clone = cloneDataElement.clone();

			clone.addClass("data-kelas");
			clone.prop('id', 'data' + (index + 1));

			clone.removeClass("clone-data");

			clone.find('.nama-siswa').html(value.nama_user);
			clone.find('.email-siswa').html(value.email_user);
			clone.find('.username-siswa').html(value.username);
			prog = value.progress;
			if (value.progress >= 90) {
				prog = "<span class='badge badge-success'>" + value.progress + "</span>";
			} else if (value.progress < 90 && value.progress > 50) {
				prog = "<span class='badge badge-warning'>" + value.progress + "</span>";
			} else {
				prog = "<span class='badge badge-danger'>" + value.progress + "</span>";
			}
			clone.find('.progress-siswa').html(prog);

			if (value.raport_allowed == 1) {
				clone.find('.raport-siswa input').prop('checked', "checked");
			}


			clone.find('.raport-siswa input').attr('data-user', value.user_id);
			clone.find('.raport-siswa input').attr('data-mapel', value.mapel_id);
			clone.find('.raport-siswa input').attr('onchange', "changeRaportAllowed(this);");

			clone.find('.link-detail').prop('href', base_url + 'back/progress-siswa/' + metaMapel + "/" + value.id_user);
			clone.find('.link-indikator').prop('href', base_url + 'back/indikator-siswa/' + metaMapel + "/" + value.id_user);
			clone.find('.link-raport').prop('href', base_url + 'back/raport-siswa/' + metaMapel + "/" + value.id_user);


			if (index <= 0) {
				clone.insertAfter(cloneDataElement);
			} else {
				clone.insertAfter($('#data' + (index)));
			}
		});
		cloneDataElement.hide();
		$('.data-kelas').show();
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
			btnPagePreviousElement.find('.page-link').prop('href', 'javascript:ListSiswa.changePage(' + (page - 1) + ')');
			btnPagePreviousElement.removeClass('disabled');
		}

		if ((page + 1) > totalPage) {

			btnPageNextElement.find('.page-link').prop('href', 'javascript:;');
			btnPageNextElement.addClass('disabled');
		} else {
			btnPageNextElement.find('.page-link').prop('href', 'javascript:ListSiswa.changePage(' + (page + 1) + ')');
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
			cloneBtnPage.find('.page-link').prop('href', 'javascript:ListSiswa.changePage(1)');
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
			// cloneBtnPage.addClass('active');

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
				cloneBtnPage.find('.page-link').prop('href', 'javascript:ListSiswa.changePage(' + i + ')');
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
			// cloneBtnPage.addClass('active');

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
				cloneBtnPage.find('.page-link').prop('href', 'javascript:ListSiswa.changePage(' + totalPage + ')');
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

	formSearchElement.submit(function (event) {
		event.preventDefault();
		search = searchElement.val();
		page = 1;
		limit = 10;
		limitElement.val(limit).change();
		requestSiswa(urlGetApi);
	});


	return {
		init: function () {
			requestSiswa(urlGetApi)
		},
		refresh: function () {
			page = 1;
			search = "";
			searchElement.val("");
			requestSiswa(urlGetApi);
		},
		limitChange() {
			limit = limitElement.val();
			page = 1;
			requestSiswa(urlGetApi);
		}, changePage: function (i) {
			page = i;
			requestSiswa(urlGetApi);
		},


	}

	// $P$BUY2k0V11xY6TFLLwphDTOcikzwrTf0

}();

// Initialize when page loads
jQuery(function () {
	ListSiswa.init();
});

function changeRaportAllowed(el, idUser, idMapel) {
	var urlRaporApi = base_url_api + "/ProgressApi/updateRaport";
	var idUser = el.getAttribute("data-user");
	var idMapel = el.getAttribute("data-mapel");
	var raport_allowed = el.checked ? 1 : 0;
	var request = $.ajax({
		url: urlRaporApi,
		data: {
			user: idUser,
			raport: raport_allowed,
			mapel: idMapel,
		},
		type: 'POST',
	});

	request.done(function (xhr, status, error) {
		if (xhr.success) {
			toastr["success"]("Sukses", "Berhasil Mengubah Data");

		} else {
			toastr["error"]("Gagal", "Gagal Mengubah Data");
		}
	});

	request.always(function (xhr, status, error) {
	});

	request.fail(function (xhr, status, error) {

		if (xhr.status != 422) {
			if (!xhr.success) {
				toastr['error']('Server Error', xhr.message);
			} else {
				toastr['error']('Server Bermasalah', 'Terjadi Kesalahan Jaringan');
			}
		}

	});
}
