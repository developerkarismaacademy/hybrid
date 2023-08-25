var ListDiskusi = function () {

	//INIT URL
	var urlGetApi = base_url_api + "/DiskusiApi/jsondata";
	var urlSimpanApi = base_url_api + "/DiskusiApi/simpan/";
	var urlDetailApi = base_url_api + "/DiskusiApi/detail/";
	var urlUpdateApi = base_url_api + "/DiskusiApi/update/";
	var urlDeleteApi = base_url_api + "/DiskusiApi/delete/";
	var noImage = base_url + "/assets/back/images/no-image.jpg";
	var idMapel = $('#idMapel').val();
	var idBab = $('#idBab').val();
	var idMateri = $('#idMateri').val();
	if (idMateri == undefined) {
		idBab = "";
		idMateri = "";
	}

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

	//MODAL
	var modal = new Custombox.modal({
		content: {
			effect: 'blur',
			target: '#modal-modif',
			close: false,
		},
		overlay: {
			color: "#36404a",
			close: false,
		},
	});
	var loadingModalElement = $('#loading-modal');
	var modalContainerElement = $('#modal-container');
	var modalSubmitElement = $('#modal-submit');
	var titleModifElement = $('#modif-diskusi-title');
	var namaModifElement = $('#nama_user-modif');
	var tipeModifElement = $('#tipe-modif');
	var isiModifElement = $('#isi-modif');
	var formModifElement = $('#form-modif');
	var ubahViewElement = $("#ubah-view");
	var balasViewElement = $("#balas-view");
	var isiTopikElement = $("#isi-topik-modif");


	var requestMateri = function (url) {
		if (!loading) {
			loading = true;
			url = url + "?page=" + page;
			url = url + "&search=" + search;
			url = url + "&limit=" + limit;
			url = url + "&idMapel=" + idMapel;
			if (idBab != "") {
				url = url + "&idBab=" + idBab;
			}
			if (idMateri != "") {
				url = url + "&idMateri=" + idMateri;
			}

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
				updateListDiskusi();
			});

			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				loadingElement.hide();
			});


		}
	};

	var updateListDiskusi = function () {
		$('.data-diskusi').remove();
		$.each(dataMateri, function (index, value) {
			var clone = cloneDataElement.clone();

			clone.addClass("data-diskusi");
			clone.addClass("data-diskusi-" + value.id_diskusi);
			clone.prop('id', 'data' + (index + 1));
			clone.removeClass("clone-data");

			clone.find('.id').html(value.id_diskusi);
			clone.find('.nama').html(value.nama_user);
			clone.find('.isi').html(value.isi);

			if (value.is_deleted == 1) {
				clone.find('.deleted').html('<span class="label label-danger">Dihapus</span>');
			} else {
				clone.find('.deleted').html('<span class="label label-success">Tampil</span>');
			}

			var tipeHTML = value.tipe.toLowerCase().replace(/(?<= )[^\s]|^./g, a => a.toUpperCase());
			if (value.tipe == "jawaban") {
				tipeHTML += " untuk Topik " + value.diskusi_id;
				clone.addClass("bg-primary");

				clone.find('.link-reply').prop('href', '#');
				clone.find('.link-reply').removeClass("btn-purple");
				clone.find('.link-reply').addClass("btn-inverse");
				clone.find('.link-reply').addClass("disabled");
				clone.find('.link-reply').prop("disabled", "disabled");
			} else {
				clone.find('.link-reply').prop('href', 'javascript:ListDiskusi.tambahDiskusi(' + value.id_diskusi + ');');
			}

			clone.find('.tipe').html(tipeHTML);

			if (value.bab_id != 0 && value.bab_id != null) {
				clone.find('.lokasi').html(value.bab_id + " (" + value.materi_id + ")");
			} else {
				clone.find('.lokasi').html("Mapel Utama");
			}

			clone.find('.link-hapus').prop('href', 'javascript:ListDiskusi.deleteDiskusi(' + value.id_diskusi + ');');
			if (value.nama_user == namaUser) {
				clone.find('.link-ubah').prop('href', 'javascript:ListDiskusi.ubahDiskusi(' + value.id_diskusi + ');');
			} else {
				clone.find('.link-ubah').prop('href', '#');
				clone.find('.link-ubah').removeClass("btn-yellow");
				clone.find('.link-ubah').addClass("btn-inverse");
				clone.find('.link-ubah').addClass("disabled");
				clone.find('.link-ubah').prop("disabled", "disabled");
			}

			if (index <= 0) {
				clone.insertAfter(cloneDataElement);
			} else {
				if (value.tipe == "jawaban") {
					clone.insertAfter($('.data-diskusi-' + value.diskusi_id));
				} else {
					clone.insertAfter($('#data' + (index)));
				}
			}
		});
		cloneDataElement.hide();
		$('.data-diskusi').show();
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
			btnPagePreviousElement.find('.page-link').prop('href', 'javascript:ListDiskusi.changePage(' + (page - 1) + ')');
			btnPagePreviousElement.removeClass('disabled');
		}

		if ((page + 1) > totalPage) {
			btnPageNextElement.find('.page-link').prop('href', 'javascript:;');
			btnPageNextElement.addClass('disabled');
		} else {
			btnPageNextElement.find('.page-link').prop('href', 'javascript:ListDiskusi.changePage(' + (page + 1) + ')');
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
			cloneBtnPage.find('.page-link').prop('href', 'javascript:ListDiskusi.changePage(1)');
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
				cloneBtnPage.find('.page-link').prop('href', 'javascript:ListDiskusi.changePage(' + i + ')');
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
				cloneBtnPage.find('.page-link').prop('href', 'javascript:ListDiskusi.changePage(' + totalPage + ')');
				cloneBtnPage.removeClass('disabled');
				cloneBtnPage.removeClass('active');
			}
			cloneBtnPage.insertBefore(btnPageNextElement);
		}


		pagingDetailElement.html("Menampilkan  (<span class='font-weight-bold'>" + (data.start + 1) + "</span> - <span class='font-weight-bold'>" + data.end + "</span> Dari <span class='font-weight-bold'>" + totalData + "</span> Data) " +
			"<br> Halaman <span class='font-weight-bold'>" + page + "</span> , Total <span class='font-weight-bold'>" + totalPage + "</span> Halaman");

	};

	var deleteDiskusi = function (id) {
		if (!loading) {
			loadingElement.show();
			tableDateElement.hide();
			loading = true;
			jQuery.getJSON(urlDetailApi + id, result => {
				var form = result.data;
				var id = form.id_diskusi;
				loadingElement.hide();
				tableDateElement.show();
				loading = false;
				swal({
					title: "Apa Anda Yakin Ingin Menghapus Diskusi " + id + "?",
					text: "Diskusi yang Dihapus Tidak Dapat Dikembalikan",
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

	var tambahDiskusi = function (id) {
		CKEDITOR.replace("form-modif", {
			height: 96,
		});

		modal.open();

		ubahViewElement.hide();
		balasViewElement.hide();

		modalSubmitElement.prop('href', 'javascript:ListDiskusi.tambahServer(' + id + ');');

		titleModifElement.html("Tambah Komentar ");
		tipeModifElement.html("Topik");
		if (id != 0) {
			titleModifElement.html("Tambah Balasan untuk " + id);

			balasViewElement.show();

			request = jQuery.ajax({
				url: urlDetailApi + id,
				method: "GET",
				beforeSend: function (xhr) {
				}
			});

			request.always(function (xhr, status, error) {
			});

			request.done(function (xhr, status, error) {
				balasViewElement.show();
				isiTopikElement.html(xhr.data.isi);
			});

			request.fail(function (jqXHR, textStatus) {
			});

		}
		namaModifElement.html(namaUser);

		loadingModalElement.hide();
	}

	var tambahServer = function (id) {
		var success = true;
		loading = true;

		for (instance in CKEDITOR.instances) {
			CKEDITOR.instances['form-modif'].updateElement();
		}

		var formData = new FormData();
		formData.append("isi", formModifElement.html());

		formData.append("mapel_id", idMapel);
		if (idMateri != "") {
			formData.append("materi_id", idMateri);
			formData.append("bab_id", idBab);
		}

		//If Reply
		if (id != 0) {
			formData.append("diskusi_id", id);
		}

		if (success) {
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
					formModifElement.html("");
				} else {
					toastr["error"]("Gagal", "Gagal Menyimpan Data");
				}
			});

			request.always(function (xhr, status, error) {
				ListDiskusi.modalClose();
				loading = false;
				loadingElement.hide();
				tableDateElement.show();
				loadingModalElement.hide();
				modalContainerElement.show();
				balasViewElement.hide();

				isiTopikElement.html("");

				page = 1;
				limit = 10;
				limitElement.val(limit).change();
				requestMateri(urlGetApi);
			});

			request.fail(function (xhr, status, error) {
				if (!xhr.success) {
					toastr['error']('Server Error', xhr.message);
				} else {
					toastr['error']('Server Bermasalah', 'Terjadi Kesalahan Jaringan');
				}
			});
		}
	};

	var ubahDiskusi = function (id) {
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
				modalSubmitElement.prop('href', 'javascript:ListDiskusi.ubahServer(' + xhr.data.id_diskusi + ');');

				ubahViewElement.show();
				balasViewElement.hide();

				titleModifElement.html("Ubah Komentar " + xhr.data.id_diskusi);
				namaModifElement.html(xhr.data.nama_user);
				isiModifElement.html(xhr.data.isi);
				formModifElement.html(xhr.data.isi);
				if (xhr.data.diskusi_id == null || xhr.data.diskusi_id == "") {
					tipeModifElement.html("Topik");
				} else {
					tipeModifElement.html("Jawaban untuk Topik " + xhr.data.diskusi_id);
				}


				CKEDITOR.replace("form-modif", {
					height: 96,
				});
			});

			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				loadingElement.hide();
			});
		}
	};

	var ubahServer = function (id) {
		for (instance in CKEDITOR.instances) {
			CKEDITOR.instances['form-modif'].updateElement();
		}

		loading = true;

		var formData = new FormData();
		formData.append("id_diskusi", id);
		formData.append("isi", formModifElement.html());
		var request = $.ajax({
			url: urlUpdateApi,
			data: formData,
			type: 'POST',
			contentType: false,
			processData: false
		});

		request.done(function (xhr, status, error) {
			if (xhr.success) {
				toastr["success"]("Sukses", "Berhasil Menyimpan Data");
			} else {
				toastr["error"]("Gagal", "Gagal Menyimpan Data");
			}
		});

		request.always(function (xhr, status, error) {
			ListDiskusi.modalClose();
			loading = false;
			loadingElement.hide();
			tableDateElement.show();
			loadingModalElement.hide();
			modalContainerElement.show();

			formModifElement.html("");

			page = 1;
			limit = 10;
			limitElement.val(limit).change();
			requestMateri(urlGetApi);
		});

		request.fail(function (xhr, status, error) {
			if (!xhr.success) {
				toastr['error']('Server Error', xhr.message);
			} else {
				toastr['error']('Server Bermasalah', 'Terjadi Kesalahan Jaringan');
			}
		});
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
		deleteDiskusi(id) {
			deleteDiskusi(id);
		},
		ubahDiskusi(id) {
			ubahDiskusi(id);
		},
		ubahServer(id) {
			ubahServer(id);
		},
		tambahDiskusi(id) {
			tambahDiskusi(id);
		},
		tambahServer(id) {
			tambahServer(id);
		},
		modalClose() {
			CKEDITOR.instances['form-modif'].destroy();
			modalSubmitElement.prop('href', '');
			formModifElement.html("");

			Custombox.modal.close();
		}
	}

	// $P$BUY2k0V11xY6TFLLwphDTOcikzwrTf0

}();

// Initialize when page loads
jQuery(function () {
	ListDiskusi.init();
});
