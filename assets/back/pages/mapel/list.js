var ListMapel = function () {

	//INIT URL
	var urlGetApi = base_url_api + "/MapelApi/jsondata";
	var urlDetailApi = base_url_api + "/MapelApi/detail/";
	var urlDeleteApi = base_url_api + "/MapelApi/delete/";
	var urlResetVideoApi = base_url_api + "/MapelApi/resetvideo/";
	var urlToggleStatusApi = base_url_api + "/MapelApi/togglestatus/";
	var urlTogglePrakerjaApi = base_url_api + "/MapelApi/toggleprakerja/";
	var noImage = base_url + "/assets/back/images/no-image.jpg";
	var urlExcelUpload = base_url + "back/simpan-excel-mapel/";
	var id = $('#idKelas').val();

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
	var dataMapel = [];
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

	var modalUpload = new Custombox.modal({
		content: {
			effect: 'blur',
			target: '#modal-upload'
		},
		overlay: {
			color: "#36404a"
		}
	});


	var loadingModalUploadElement = $('#loading-modal-upload');
	var modalContainerUploadElement = $('#modal-container-upload');
	var namaMapelUploadElement = $('#nama-mapel-upload');
	var kelasMapelUploadElement = $('#nama-kelas-upload');
	var idMapelUploadElement = $("#id_mapel");
	var formUploadElement = $('#form-mapel-upload');

	var loadingModalElement = $('#loading-modal');
	var modalContainerElement = $('#modal-container');
	var namaMapelDetailElement = $('#nama-mapel-detail');
	var kelasMapelDetailElement = $('#nama-kelas-detail');
	var statusGratisDetailElement = $('#status-gratis-mapel-detail');
	var shortDescMapelDetailElement = $('#shortdesc-mapel-detail');
	var deskripsiMapelDetailElement = $('#deskripsi-mapel-detail');
	var imgGambarMapelDetailElement = $('#img-gambar-mapel-detail');
	var hargaBasicDetailElement = $('#harga-basic-detail');
	var hargaSilverDetailElement = $('#harga-silver-detail');
	var hargaGoldDetailElement = $('#harga-gold-detail');

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
					tableDateElement.hide();
				}
			});

			request.always(function (xhr, status, error) {
			});

			request.done(function (xhr, status, error) {
				dataMapel = xhr.data;
				totalData = xhr.total;
				totalDataInPage = xhr.total_in_page;
				totalPage = xhr.total_page;
				totalData = xhr.total;
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
		$('.data-mapel').remove();
		$.each(dataMapel, function (index, value) {
			var clone = cloneDataElement.clone();

			clone.addClass("data-mapel");
			clone.prop('id', 'data' + (index + 1));
			clone.removeClass("clone-data");


			var namaMapel = value.nama_mapel.length > 60 ? (value.nama_mapel.substr(0, 60) + " ...") : value.nama_mapel;

			if (value.nama_mapel.length > 60) {
				namaMapel = "<span title='" + value.nama_mapel + "'>" + namaMapel + "</span>";
			}

			clone.find('.nama-mapel').html(namaMapel);
			clone.find('.link-detail').prop('href', 'javascript:ListMapel.detailMapel(' + value.id_mapel + ');');
			clone.find('.link-upload').prop('href', 'javascript:ListMapel.detailUpload(' + value.id_mapel + ');');
			clone.find('.link-ubah').prop('href', base_url + "back/mapel/" + value.meta_link_mapel + "/ubah");
			clone.find('.link-ubah-detail').prop('href', base_url + "back/mapel/" + value.meta_link_mapel + "/ubah-detail");
			clone.find('.link-daftar').prop('href', base_url + "back/bab/" + value.meta_link_mapel);
			clone.find('.link-detailclass').prop('href', base_url + "back/mapel/" + value.meta_link_mapel + "/detail");
			clone.find('.link-kompetensi').prop('href', base_url + "back/mapelunitkompetensi/list/" + value.meta_link_mapel);
			clone.find('.link-siswa').prop('href', base_url + "back/mapel/" + value.meta_link_mapel + "/siswa");
			clone.find('.link-resetvideo').prop('href', 'javascript:ListMapel.resetVideo("' + value.id_mapel + '");');
			clone.find('.link-diskusi').prop('href', base_url + 'back/bab/' + value.meta_link_mapel + '/diskusi');
			clone.find('.link-hapus').prop('href', 'javascript:ListMapel.deleteMapel(' + value.id_mapel + ');');
			clone.find('.link-daftartestimoni').prop('href', base_url + "back/testimoni/" + value.id_mapel);


			clone.find('.checkbox-prakerja').find('.checkbox-element').prop("id", "prakerja-" + value.id_mapel);
			clone.find('.checkbox-prakerja').find('.checkbox-element').attr("onclick", "ListMapel.togglePrakerja(" + value.id_mapel + ")");

			if (value.prakerja == 1) {
				clone.find('.checkbox-prakerja').find('.checkbox-element').prop("checked", "checked");
			} else {
				clone.find('.checkbox-prakerja').find('.checkbox-element').prop("checked", false);
			}

			clone.find('.checkbox-tampilkan').find('.checkbox-element').prop("id", "tampilkan-" + value.id_mapel);
			clone.find('.checkbox-tampilkan').find('.checkbox-element').attr("onclick", "ListMapel.toggleStatus(" + value.id_mapel + ")");

			if (value.status == 1) {
				clone.find('.checkbox-tampilkan').find('.checkbox-element').prop("checked", "checked");
			} else {
				clone.find('.checkbox-tampilkan').find('.checkbox-element').prop("checked", false);
			}

			statusIcon = 'fa fa-toggle-on';
			statusText = 'Hide Mapel';
			statusBtn = 'btn-brown';
			if (value.status == 0) {
				statusIcon = 'fa fa-toggle-off';
				statusBtn = 'btn-orange';
				statusText = 'Show Mapel';
			}
			clone.find('.link-togglestatus').attr('title', statusText);
			clone.find('.link-togglestatus').attr('data-original-title', statusText);
			clone.find('.link-togglestatus').removeClass('btn-brown');
			clone.find('.link-togglestatus').addClass(statusBtn);
			clone.find('.link-togglestatus i').attr('class', statusIcon);
			if (index <= 0) {
				clone.insertAfter(cloneDataElement);
			} else {
				clone.insertAfter($('#data' + (index)));
			}
		});
		cloneDataElement.hide();
		$('.data-mapel').show();
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

		cloneBtnPage.removeClass("hide");
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
				cloneBtnPage.find('.page-link').prop('href', 'javascript:ListMapel.changePage(' + totalPage + ')');
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

	var deleteMapel = function (id) {
		if (!loading) {
			loadingElement.show();
			tableDateElement.hide();
			loading = true;
			jQuery.getJSON(urlDetailApi + id, result => {
				var form = result.data;
				var nama = form.nama_mapel;
				loadingElement.hide();
				tableDateElement.show();
				loading = false;
				swal({
					title: "Apa Anda Yakin Ingin Menghapus mapel " + nama + "?",
					text: "Semua Data Mapel Akan Terhapus Dan Tidak Bisa Di Kembalikan",
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
				requestMapel(urlGetApi);
			})
		}
	};

	formSearchElement.submit(function (event) {
		event.preventDefault();
		search = searchElement.val();
		page = 1;
		limit = 10;
		limitElement.val(limit).change();
		requestMapel(urlGetApi);
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
				namaMapelDetailElement.html(xhr.data.nama_mapel);
				kelasMapelDetailElement.html(xhr.data.nama_kelas);
				shortDescMapelDetailElement.html(xhr.data.shortdesc_mapel);
				deskripsiMapelDetailElement.html(xhr.data.deskripsi_mapel);

				hargaBasicDetailElement.html(xhr.data.harga_basic);
				hargaSilverDetailElement.html(xhr.data.harga_silver);
				hargaGoldDetailElement.html(xhr.data.harga_gold);

				if (xhr.data.status_gratis == 0) {
					statusGratisDetailElement.html("Berbayar");
				} else {
					statusGratisDetailElement.html("Gratis");
				}

				if (xhr.data.gambar_mapel != "") {
					console.log(xhr.data.gambar_mapel);
					imgGambarMapelDetailElement.attr('src', base_url + "/upload/mapel/" + xhr.data.gambar_mapel);
				} else {
					imgGambarMapelDetailElement.attr('src', base_url + "/assets/back/images/no-image.jpg");
				}
			});

			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				loadingElement.hide();
			});


		}
	};

	var detailUpload = function (id) {
		modalUpload.open();

		if (!loading) {
			loading = true;

			var request = jQuery.ajax({
				url: urlDetailApi + id,
				method: "GET",
				beforeSend: function (xhr) {
					loadingElement.show();
					tableDateElement.hide();
					loadingModalUploadElement.show();
					modalContainerUploadElement.hide();
				}
			});

			request.always(function (xhr, status, error) {
				loading = false;
				loadingElement.hide();
				tableDateElement.show();
				loadingModalUploadElement.hide();
				modalContainerUploadElement.show();
			});

			request.done(function (xhr, status, error) {

				idMapelUploadElement.val(id);
				namaMapelUploadElement.html(xhr.data.nama_mapel);
				kelasMapelUploadElement.html(xhr.data.nama_kelas);
			});

			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				loadingElement.hide();
			});


		}
	};

	var resetVideo = function (id) {
		jQuery.getJSON(urlResetVideoApi + id, result => {
		}).fail(error => {
		}).done(data => {
			toastr['success']('', data.message);
		})
	};

	// var toggleStatus = function (id, element) {
	// 	jQuery.getJSON(urlToggleStatusApi + id, result => {
	// 	}).fail(error => {
	// 	}).done(data => {
	// 		toastr['success']("", data.message);
	// 		ListMapel.changePage(page);
	// 	})
	// };

	var toggleStatus = function (id) {
		if (!loading) {
			loading = true;

			var tampilkan = $("#tampilkan-" + id).is(":checked") ? 1 : 0;

			var request = jQuery.ajax({
				url: urlToggleStatusApi + "/" + id,
				data: {
					status: tampilkan,
					id_mapel: id
				},
				method: "POST",
				beforeSend: function (xhr) {
					loadingElement.show();
					tableDateElement.hide();
				}
			});

			request.always(function (xhr, status, error) {
				loading = false;
				requestMapel(urlGetApi);
			});

			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				loadingElement.hide();
			});
		}
	};

	var togglePrakerja = function (id) {
		if (!loading) {
			loading = true;

			var prakerja = $("#prakerja-" + id).is(":checked") ? 1 : 0;

			var request = jQuery.ajax({
				url: urlTogglePrakerjaApi + "/" + id,
				data: {
					prakerja: prakerja,
					id_mapel: id
				},
				method: "POST",
				beforeSend: function (xhr) {
					loadingElement.show();
					tableDateElement.hide();
				}
			});

			request.always(function (xhr, status, error) {
				loading = false;
				requestMapel(urlGetApi);
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
			requestMapel(urlGetApi);
			$(":file").filestyle({input: false});
		},
		refresh: function () {
			page = 1;
			search = "";
			searchElement.val("");
			requestMapel(urlGetApi);
		},
		limitChange() {
			limit = limitElement.val();
			page = 1;
			requestMapel(urlGetApi);
		},
		changePage: function (i) {
			page = i;
			requestMapel(urlGetApi);
		},
		detailMapel(id) {
			detailOpen(id);
		},
		detailUpload(id) {
			detailUpload(id);
		},
		deleteMapel(id) {
			deleteMapel(id);
		},
		resetVideo(id) {
			resetVideo(id);
		},
		toggleStatus(id, element) {
			toggleStatus(id, element);
		},
		togglePrakerja(id) {
			togglePrakerja(id);
		},
		modalClose() {
			Custombox.modal.close();
		}
	}

	// $P$BUY2k0V11xY6TFLLwphDTOcikzwrTf0

}();

// Initialize when page loads
jQuery(function () {
	ListMapel.init();
});


// Vue.use(CKEditor);
// new Vue({
// 	el: '#wrapper',
// 	data: {
// 		limit: 10,
// 		search: '',
// 		idMapel: 0,
// 		errorMapel: [],
// 		editor: ClassicEditor,
// 		loading: false,
// 		loadingForm: false,
// 		showForm: false,
// 		url: base_url_api + "/MapelApi/jsondata?page=1",
// 		urlDetail: base_url_api + "/MapelApi/detail/",
// 		urlDelete: base_url_api + "/MapelApi/delete/",
// 		urlSave: base_url_api + "/MapelApi/simpan",
// 		urlUpdate: base_url_api + "/MapelApi/update",
// 		urlGetMapel: base_url_api + "/MapelApi/getAll",
// 		urlPost: '',
// 		mapels: [],
// 		showFormDisplay: "none",
// 		file: '',
// 		paging: {
// 			firstStatus: false,
// 			prevStatus: false,
// 			nextStatus: false,
// 			lastStatus: false,
// 			firstUrl: "#",
// 			prevUrl: "#",
// 			nextUrl: "#",
// 			lastUrl: "#",
// 			currentPage: 0,
// 			totalPage: 0
// 		},
// 		form: {
// 			method: "",
// 			nama_mapel: "",
// 			deskripi_mapel: "",
// 			gambar_mapel: "",
// 			id: 0,
// 			fileGambar: '',
// 			id_mapel: 0
//
// 		}, optionsMapel: []
// 	},
// 	methods: {
// 		reset: function () {
// 			this.form = {
// 				method: "",
// 				nama_mapel: "",
// 				deskripi_mapel: "",
// 				gambar_mapel: "",
// 				id_mapel: 0,
// 				fileGambar: '',
// 				id_mapel: 0
// 			};
//
// 			this.optionsMapel = [];
// 			jQuery('.error-alert').addClass("hidden");
// 			jQuery('.error-alert-container').html("<ul class='error-list'></ul>");
// 			this.urlPost = '';
// 			$("#file").val(null);
// 		},
// 		toggleForm: function (method) {
// 			this.reset();
// 			this.form.method = method;
// 			this.showForm = !this.showForm;
// 			if (this.showForm) {
// 				this.showFormDisplay = "block";
// 				jQuery('#body').addClass('modal-pop-up');
// 				jQuery('#form-mapel').fadeIn(300);
// 			} else {
// 				this.showFormDisplay = "none";
// 				jQuery('#body').removeClass('modal-pop-up');
// 				jQuery('#form-mapel').fadeOut(300);
// 			}
//
// 			if (method == 'save') {
// 				this.requestAllMapel();
// 				this.urlPost = this.urlSave;
// 			} else if (method == 'update') {
// 				this.urlPost = this.urlUpdate;
// 			} else {
// 				this.urlPost = '';
// 			}
//
// 			this.init();
// 		},
// 		requestMapel: function (url) {
// 			if (!this.loading) {
// 				this.loading = true;
// 				url = url + "&search=" + this.search;
// 				url = url + "&limit=" + this.limit;
// 				url = url + "&idMapel=" + this.idMapel;
// 				jQuery.getJSON(url, result => {
// 					this.mapels = result.data;
// 					this.loading = false;
// 					this.setUpPagination(result);
// 					Vue.nextTick(function () {
// 						$('[data-toggle="tooltip"]').tooltip()
// 					})
// 				}).fail(error => {
// 					this.loading = false;
// 				});
// 			}
// 			this.init();
// 		},
// 		setUpPagination: function (data) {
// 			this.paging.currentPage = data.current_page;
// 			this.paging.totalPage = data.total_page;
// 			this.paging.firstStatus = data.url_first_page != "#" && data.current_page != 1;
// 			this.paging.firstUrl = data.url_first_page;
// 			this.paging.prevStatus = data.url_prev_page != "#";
// 			this.paging.prevUrl = data.url_prev_page;
// 			this.paging.nextStatus = data.url_next_page != "#";
// 			this.paging.nextUrl = data.url_next_page;
// 			this.paging.lastStatus = data.url_last_page != "#" && data.current_page != data.total_page;
// 			this.paging.lastUrl = data.url_last_page;
// 		},
// 		firstPage: function () {
// 			if (this.paging.firstStatus) {
// 				this.requestMapel(this.paging.firstUrl);
// 			}
// 		},
// 		nextPage: function () {
// 			if (this.paging.nextStatus) {
// 				this.requestMapel(this.paging.nextUrl);
// 			}
// 		},
// 		prevPage: function () {
// 			if (this.paging.prevStatus) {
// 				this.requestMapel(this.paging.prevUrl);
// 			}
// 		},
// 		lastPage: function () {
// 			if (this.paging.lastStatus) {
// 				this.requestMapel(this.paging.lastUrl);
// 			}
// 		},
// 		refreshPage: function () {
// 			this.limit = 10;
// 			this.search = '';
// 			this.requestMapel(this.url)
// 		},
// 		searchOrLimitChangePage() {
// 			this.requestMapel(this.url)
// 		},
// 		requestDetailMapel(id) {
// 			this.toggleForm('update');
// 			if (!this.loadingForm) {
// 				this.loadingForm = true;
// 				jQuery.getJSON(this.urlDetail + id, result => {
// 					this.form = result.data;
// 					this.form.fileGambar = base_url + "/upload/mapel/" + this.form.gambar;
// 					this.loadingForm = false;
// 					this.requestAllMapel();
// 				}).fail(error => {
// 					this.loadingForm = false;
// 					this.toggleForm('');
// 				});
// 			}
// 		},
// 		setSelected(value) {
// 			console.log(this.form);
// 			//  trigger a mutation, or dispatch an action
// 		},
// 		requestAllMapel() {
// 			$('#mapelSelect').empty().trigger('change');
// 			if (!this.loadingForm) {
// 				this.loadingForm = true;
// 				jQuery.getJSON(this.urlGetMapel, result => {
// 					this.loadingForm = false;
// 					this.optionsMapel = result.data;
// 					let option = new Option('Pilih Mapel');
// 					$('#mapelSelect').append(option).trigger('change');
//
// 					$.each(this.optionsMapel, function (index, value) {
// 						let selected = false;
//
// 						if (value.id_mapel == this.idMapel) {
// 							selected = true;
// 						}
//
// 						let option = new Option(value.nama_mapel, value.id_mapel, selected, false);
// 						$('#mapelSelect').append(option).trigger('change');
// 						$('#mapelSelect').selectpicker('refresh')
// 					});
// 					$('#mapelSelect').val(this.idMapel).trigger('change');
// 				}).fail(error => {
// 					this.loadingForm = false;
// 				});
// 			}
// 		},
// 		init() {
// 			$('[data-toggle="tooltip"]').tooltip()
// 			$(".form-pop-up").css('margin-left', '');
// 			if (jQuery.browser.mobile !== true) {
// 				//SLIM SCROLL
// 				$('.slimscroller').slimscroll({
// 					height: 'auto',
// 					size: "5px"
// 				});
//
// 				$('.slimscrollleft').slimScroll({
// 					height: 'auto',
// 					position: 'right',
// 					size: "7px",
// 					color: '#bbb',
// 					wheelStep: 7
// 				});
// 			}
// 			if ($("#deskripsi").length > 0 && this.showForm) {
// 				CKEDITOR.replace('deksripsi');
// 			}
// 		},
// 		deleteData(id) {
// 			if (!this.loading) {
// 				this.loading = true;
// 				jQuery.getJSON(this.urlDetail + id, result => {
// 					this.form = result.data;
// 					var nama = this.form.nama;
// 					this.loading = false;
// 					swal({
// 						title: "Apa Anda Yakin Ingin Menghapus mapel " + nama + "?",
// 						text: "Data Mata Pelajaran Akan Terhapus Dan Tidak Bisa Di Kembalikan",
// 						type: "error",
// 						showCancelButton: true,
// 						confirmButtonClass: 'btn-danger',
// 						confirmButtonText: "Ya, Hapus!",
// 						cancelButtonText: "Batal",
// 						closeOnConfirm: true,
// 						closeOnCancel: true
// 					}, function (isConfirm) {
// 						if (isConfirm) {
// 							this.deleteServer(id);
// 						}
// 					}.bind(this));
// 				}).fail(error => {
// 					this.loading = false;
// 				});
// 			}
// 		},
// 		deleteServer(id) {
// 			if (!this.loading) {
// 				this.loading = true;
// 				jQuery.getJSON(this.urlDelete + id, result => {
// 					this.loading = false;
// 				}).fail(error => {
// 					this.loading = false;
// 				}).done(data => {
// 					toastr['success']('', data.message);
// 					this.loading = false;
// 					this.refreshPage();
// 				})
// 			}
// 		},
// 		save() {
// 			// if (!this.loadingForm) {
// 			// 	this.loadingForm = true;
// 			// 	if ($('#file').length >= 1 && $('#file').get(0).files.length >= 1) {
// 			// 		this.file = $('#file').get(0).files[0];
// 			// 	}
// 			// 	let formData = new FormData();
// 			// 	formData.append('nama_mapel', this.form.nama);
// 			// 	formData.append("deskripi_mapel", this.form.deskripsi);
// 			// 	formData.append('gambar_mapel', this.file);
// 			// 	formData.append('id', this.form.id_mapel);
// 			// 	jQuery.ajax({
// 			// 		url: this.urlPost,
// 			// 		type: "POST",
// 			// 		data: formData,
// 			// 		cache: false,
// 			// 		contentType: false,
// 			// 		processData: false,
// 			// 	}).fail(error => {
// 			// 	}).always(data => {
// 			// 		this.loadingForm = false;
// 			// 		this.refreshPage();
// 			// 	}).done(data => {
// 			// 		toastr['success']('Nama Mapel : ' + data.data.nama, data.message);
// 			// 		this.toggleForm('');
// 			// 	});
// 			// }
// 			console.log(this.idMapel);
// 		}
// 	},
// 	mounted() {
// 		this.idMapel = $('#idMapel').val();
// 		this.requestMapel(this.url);
// 		this.init();
// 	}
//
//
// });
