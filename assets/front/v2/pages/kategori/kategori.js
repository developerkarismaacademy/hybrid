var namaKursus = window.location.href.split('#')[1];

var ListMapel = function () {

	//INIT URL
	var urlGetApi = base_url_api + "/CariApi/jsondata";
	var noImage = base_url + "/assets/front/v2/img/no-image.jpg";
	var noImageMapel = base_url + "/upload/banner_mapel/default.jpg";
	var id = $("input[type=radio][name=kategori]:checked").val();

	//INIT PAGING AND SEARCH
	var page = 1;
	var limit = 12;
	var limitElement = $('#limit');
	var formSearchElement = $('#form-search');
	var searchElement = $('#search');
	var search = "";

	var kursusListElement = $('#kursus-ajax');
	var kursusPilihElement = $('#kursus-pilih');

	var btnPagePreviousElement = $('#btn-page-previous');
	var btnPageCloneElement = $('#btn-page');
	var btnPageNextElement = $('#btn-page-next');
	var pagingContainerElement = $('#paging-container');
	var pagingDetailElement = $('#paging-detail');

	//INIT LOADING
	var loading = false;
	var loadingElement = $('#loading');

	//INIT GET DATA
	var dataMapel = [];
	var totalData = 0;
	var totalPage = 0;
	var cloneDataElement = $('#clone-data');


	//INIT USER SESI
	var requestMapel = function (url) {
		if (!loading) {
			loading = true;
			url = url + "?page=" + page;
			url = url + "&search=" + search;
			url = url + "&limit=" + limit;
			url = url + "&idKelas=" + id;

			var request = jQuery.ajax({
				url: url,
				method: "GET",
				beforeSend: function (xhr) {
					loadingElement.show();
				}
			});

			request.always(function (xhr, status, error) {
			});

			request.done(function (xhr, status, error) {
				dataMapel = xhr.data;
				totalData = xhr.total;
				totalDataInPage = xhr.total_in_page;
				totalPage = xhr.total_page;
				setUpPagination(xhr);
				updateListMapel();
			});

			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				loadingElement.hide();
			});
		}
	};

	var updateListMapel = function () {
		$('.kelas-item').remove();
		if (totalData > 0) {
			kursusListElement.removeClass("d-none");
			kursusPilihElement.attr("data-kursus", namaKursus);
			$("#kursus-none").addClass("d-none");
			$.each(dataMapel, function (index, value) {
				var clone = cloneDataElement.clone();
				clone.addClass("kelas-item align-items-stretch col-lg-3 col-md-6 mb-4 px-3");
				clone.prop('id', 'data' + (index + 1));
				clone.removeClass("clone-data");

				var mapel = parseInt(value.id_mapel);
				var namaMapel = value.nama_mapel;

				var rating = (value.rating_rata != "") ? (value.rating_rata != null) ? value.rating_rata : (4 + (value.id_mapel[0] / 10)) : (4 + (value.id_mapel[0] / 10));
				var ratingPersen = parseFloat(rating) + 0.05;
				ratingPersen = parseFloat(ratingPersen) / 5 * 100;
				var jmlRating = (value.rating_jumlah != "") ? (value.rating_jumlah != null) ? value.rating_jumlah : 300 + parseInt(value.id_mapel.substr(0, 2)) : 300 + parseInt(value.id_mapel.substr(0, 2));

				var namaInstruktur = value.nama_instruktur;
				var diskon = parseFloat(value.diskon_basic);
				diskon = (diskon != "" && diskon != 0) ? diskon : 75;

				var hargaBasic = parseInt(value.harga_basic);
				var coin = 0;
				if (hargaBasic >= 1375000 && hargaBasic <= 1999999) {
					coin = 1500
				} else if (hargaBasic >= 2000000 && hargaBasic <= 2499000) {
					coin = 2500
				} else if (hargaBasic >= 2500000) {
					coin = 3500
				}
				hargaBasic = (hargaBasic != "" && hargaBasic != 0) ? hargaBasic : 500000;

				var hargaAsli = ListMapel.hargaCount(hargaBasic, diskon);

				hargaBasic = rupiah(hargaBasic);
				hargaAsli = rupiah(hargaAsli);

				var fotoInstruktur = (value.gambar_user != "") ? (value.gambar_user != "null") ? base_url + "upload/instruktur/" + value.gambar_user : noImage : noImage;

				var webinarHtml = (value.status_webinar == 1) ? "<div class='kelas-jenis badge badge-pill'>Webinar</div>" : "";
				var bannerMapel = (value.banner_mapel != "" || value.banner_mapel != "null") ? base_url + "upload/banner_mapel/" + value.banner_mapel : noImageMapel;
				// console.log(bannerMapel);
				bannerMapel = ListMapel.checkImage(bannerMapel) ? bannerMapel : noImageMapel;

				// console.log(ListMapel.checkImage(bannerMapel));
				// console.log(value.banner_mapel);

				if (value.alert_text != "" && value.alert_text != "null") {
					var alertValue = "<div class='card-alert bg-" + value.alert_class + " text-center'>" + value.alert_text + "</div>";

					clone.find('.alert-container').html(alertValue);
				}

				var linkLogin = base_url + "belajar/" + value.meta_link_mapel;
				var linkDetail = base_url + "kursus/detail/" + value.meta_link_mapel;
				var status = "BELI KELAS ONLINE";
				var statusBtn = "success";

				if (value.status_gratis == 1) {
					diskon = 100;
					hargaBasic = "Gratis!";

					statusBtn = "info";
					status = "AMBIL KELAS ONLINE";
				}
				if (sesi == 1) {
					if (activeMapel.includes(mapel)) {
						status = "LANJUTKAN";
						statusBtn = "warning";
						linkDetail = linkLogin;
					}
				}
				if (value.prakerja == "1") {

					clone.find('.kelas-coin').html('<i class="fa fa-credit-card"></i> ' + coin)
				}
				clone.find('.nama-mapel').html(namaMapel);
				clone.find('.nama-instruktur').html("by " + namaInstruktur);
				clone.find('.status-webinar').html(webinarHtml);
				clone.find('.rating').html("<b>" + rating + "</b> (" + jmlRating + " rating)");
				clone.find('.harga-asli .badge').html(parseInt(diskon) + "%");
				clone.find('.harga-asli .text-line-through').html(hargaAsli);
				clone.find('.harga-diskon').html(hargaBasic);

				clone.find('.link-login').text(status);
				clone.find('.link-login').removeClass('btn-success');
				clone.find('.link-login').addClass('btn-' + statusBtn);

				clone.find('.foto-instruktur').attr("src", fotoInstruktur);

				clone.find('.card-gambar').css("background-image", "url(" + bannerMapel + ")");
				clone.find('.stars-active').css("width", ratingPersen + "%")

				clone.find('.link-login').prop('href', linkLogin);
				clone.find('.link-detail').prop('href', linkDetail);

				if (index <= 0) {
					clone.insertAfter(cloneDataElement);
				} else {
					clone.insertAfter($('#data' + (index)));
				}

			});
			cloneDataElement.hide();
			$('.kelas-item').show();
		} else {
			kursusListElement.addClass("d-none");
			$("#kursus-none").removeClass("d-none");
		}

		loading = false;
		loadingElement.hide();

	};

	var setUpPagination = function (data) {
		//PAGING START

		page = parseInt(data.current_page);
		if ((page - 1) <= 0) {
			btnPagePreviousElement.find('.page-link').prop('href', 'javascript:;');
			btnPagePreviousElement.addClass('disabled');
		} else {
			btnPagePreviousElement.find('.page-link').prop('href', 'javascript:ListMapel.changePage(' + (page - 1) + ')');
			btnPagePreviousElement.removeClass('disabled');
		}

		if ((page + 1) > totalPage) {

			btnPageNextElement.find('.page-link').prop('href', 'javascript:;');
			btnPageNextElement.addClass('disabled');
		} else {
			btnPageNextElement.find('.page-link').prop('href', 'javascript:ListMapel.changePage(' + (page + 1) + ')');
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

		cloneBtnPage.removeClass("d-none");
		cloneBtnPage.addClass("page-number-dinamis");
		cloneBtnPage.prop('id', 'page-number-1');

		cloneBtnPage.find('.page-link').html('1');
		if (page == 1) {
			cloneBtnPage.find('.page-link').prop('href', 'javascript:;');
			cloneBtnPage.addClass('active');
		} else {
			cloneBtnPage.find('.page-link').prop('href', 'javascript:ListMapel.changePage(1)');
			cloneBtnPage.removeClass('disabled');
			cloneBtnPage.removeClass('active');
		}

		cloneBtnPage.insertAfter(btnPageCloneElement);

		if (start > 2) {
			cloneBtnPage = btnPageCloneElement.clone();

			cloneBtnPage.removeClass("d-none");
			cloneBtnPage.addClass("page-number-dinamis");
			cloneBtnPage.prop('id', 'page-number--1');
			cloneBtnPage.find('.page-link').html('...');
			cloneBtnPage.addClass('disabled');
			cloneBtnPage.find('.page-link').prop('href', 'javascript:;');
			cloneBtnPage.addClass('active');

			cloneBtnPage.insertAfter($('#page-number-1'));
		}
		var akhir = page;

		for (var i = start; i < totalPage; i++) {
			cloneBtnPage = btnPageCloneElement.clone();

			cloneBtnPage.removeClass("d-none");
			cloneBtnPage.addClass("page-number-dinamis");
			cloneBtnPage.prop('id', 'page-number-' + i);

			cloneBtnPage.find('.page-link').html(i);
			if (page == i) {
				cloneBtnPage.find('.page-link').prop('href', 'javascript:;');
				cloneBtnPage.addClass('active');

			} else {
				cloneBtnPage.find('.page-link').prop('href', 'javascript:ListMapel.changePage(' + i + ')');
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

			cloneBtnPage.removeClass("d-none");
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

			cloneBtnPage.removeClass("d-none");
			cloneBtnPage.addClass("page-number-dinamis");
			cloneBtnPage.prop('id', 'page-number-' + totalPage);

			cloneBtnPage.find('.page-link').html(totalPage);
			if (page == totalPage) {
				cloneBtnPage.find('.page-link').prop('href', 'javascript:;');
				cloneBtnPage.addClass('active');

			} else {
				cloneBtnPage.find('.page-link').prop('href', 'javascript:ListMapel.changePage(' + totalPage + ')');
				cloneBtnPage.removeClass('disabled');
				cloneBtnPage.removeClass('active');
			}
			cloneBtnPage.insertBefore(btnPageNextElement);
		}


		pagingDetailElement.html("Menampilkan  (<span class='font-weight-bold'>" + (data.start + 1) + "</span> - <span class='font-weight-bold'>" + data.end + "</span> Dari <span class='font-weight-bold'>" + totalData + "</span> Data) " +
			"<br><br> Halaman <span class='font-weight-bold'>" + page + "</span> Total <span class='font-weight-bold'>" + totalPage + "</span> Halaman");

	};


	formSearchElement.submit(function (event) {
		event.preventDefault();
		search = searchElement.val();
		page = 1;
		limit = 12;
		limitElement.val(limit).change();
		requestMapel(urlGetApi);
	});


	return {
		init: function () {
			requestMapel(urlGetApi);
		},
		refresh: function () {
			page = 1;
			search = "";
			searchElement.val("");
			requestMapel(urlGetApi);
		}, changePage: function (i) {
			page = i;
			requestMapel(urlGetApi);
		},
		kategoriChange(idParam) {
			page = 1;
			id = idParam;
			requestMapel(urlGetApi);
		},
		checkImage(src) {
			var http = new XMLHttpRequest();

			http.open('HEAD', src, false);
			http.send();

			return http.status != 404;
		},
		hargaCount(hargaBasic, diskon) {
			var hargaAsli = 100 / (100 - diskon) * (hargaBasic);
			hargaAsli = Math.ceil(parseFloat(hargaAsli));
			var hargaAsli_old = "'" + hargaAsli + "'";
			hargaAsli = hargaAsli_old;
			hargaAsli = hargaAsli.substr(1, 2);
			hargaAsli = parseInt(hargaAsli) * Math.pow(10, hargaAsli_old.length - 4);
			return hargaAsli;
		},
	}


}();


// Initialize when page loads
jQuery(function () {
	if (namaKursus && namaKursus != "semua") {
		$('#option-' + namaKursus)[0].click();
	} else {
		$('#option-undefined')[0].click();
	}
	ListMapel.init();
});


//FUNCTION

function rupiah(nStr) {
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + '.' + '$2');
	}
	return "Rp " + x1 + x2;
}


$('input[type=radio][name=kategori]').change(function () {
	getIdKursus($(this));
});
$("#kursus-list .dropdown-item").click(function () {
	getIdKursus($(this));
});

function getIdKursus(elem) {
	id = $(elem).attr("value");
	if ($(elem).data("namakursus")) {
		namaKursus = $(elem).data("namakursus");
		window.location.hash = $(elem).data("namakursus");
		$('#option-' + namaKursus)[0].click();
	} else {
		namaKursus = "";
		removeHash();
	}
	ListMapel.kategoriChange(id);
}

function removeHash() {
	var scrollV, scrollH, loc = window.location;
	if ("pushState" in history)
		history.pushState("", document.title, loc.pathname + loc.search);
	else {
		// Prevent scrolling by storing the page's current scroll offset
		scrollV = document.body.scrollTop;
		scrollH = document.body.scrollLeft;

		loc.hash = "";

		// Restore the scroll offset, should be flicker free
		document.body.scrollTop = scrollV;
		document.body.scrollLeft = scrollH;
	}
}
