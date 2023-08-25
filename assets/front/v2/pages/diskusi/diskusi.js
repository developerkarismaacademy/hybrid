var ListDiskusi = function () {

	//INIT URL
	var urlGetApi = base_url_api + "/DiskusiApi/jsondata";
	var urlDetailApi = base_url_api + "/DiskusiApi/detail/";
	var urlDeleteApi = base_url_api + "/DiskusiApi/delete/";
	var urlSimpanApi = base_url_api + "/DiskusiApi/simpan/";
	var urlUpdateApi = base_url_api + "/DiskusiApi/update/";
	var noImage = base_url + "/assets/front/v2/img/no-image.jpg";
	var idMapel = $("#id-mapel").val();
	var idBab = $("#id-bab").val();
	var idMateri = $("#id-materi").val();

	//INIT PAGING
	var page = 1;
	var limit = 5;

	var btnPagePreviousElement = $('#btn-page-previous');
	var btnPageCloneElement = $('#btn-page');
	var btnPageNextElement = $('#btn-page-next');
	var pagingContainerElement = $('#paging-container');
	var pagingDetailElement = $('#paging-detail');

	//INIT LOADING
	var loading = false;
	var loadingElement = $('.diskusi-loading');

	//INIT GET DATA
	var dataDiskusi = [];
	var totalData = 0;
	var totalPage = 0;
	var cloneDataElement = $('#clone-data');
	var tableDataElement = $("#diskusi-container");
	var diskusiZeroElement = $('.diskusi-zero');
	var diskusiNewElement = $('.diskusi-new');
	var diskusiNotifElement = $('.diskusi-notif');


	//INIT USER SESI
	var requestDiskusi = function (url) {
		if (!loading) {
			loading = true;
			url = url + "?page=" + page;
			url = url + "&idMapel=" + idMapel;
			if (idBab != "")
				url = url + "&idBab=" + idBab;
			if (idMateri != "")
				url = url + "&idMateri=" + idMateri;

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
				dataDiskusi = xhr.data;
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
		$('.diskusi-container').addClass("d-none");
		if (totalData <= 0) {
			diskusiZeroElement.removeClass("d-none");
			diskusiNewElement.addClass("order-2");
			diskusiNewElement.find(".diskusi-form-container").removeAttr('class').addClass("col-10");
			diskusiNotifElement.addClass("order-1 mb-3");
			tableDataElement.addClass("py-md-5 my-md-3")

			diskusiNewElement.find("[type='reset']").remove();
			diskusiNewElement.find(".diskusi-photo-container").remove();
		} else {
			var idPrev = 0;

			var idIndukFlag = 0;
			var idDataFlag = 0;
			$.each(dataDiskusi, function (index, value) {
				var idData = value.id_diskusi;
				var idInduk = value.diskusi_id;

				if (value.is_deleted != 1)
					var isi = value.isi;
				else
					var isi = "<i class='text-secondary'><i class='fa fa-trash'></i> Komentar telah dihapus</i>";
				var time = dateDifferent(value.created_at);

				if (value.level_user == "siswa") {
					var nama = value.nama_user;
					var fotoUser = base_url + "upload/profile-picture/" + value.gambar_user;
				} else if (value.level_user == "instruktur") {
					var nama = "<span class='text-warning'>" + value.nama_user + "</span>";
					var fotoUser = base_url + "upload/instruktur/" + value.gambar_user;
				} else {
					var nama = "<span class='text-info'>" + value.nama_user + "</span>";
					var nama = value.nama_user;
					var fotoUser = noImage;
				}
				if (!checkFile(fotoUser)) {
					fotoUser = noImage;
				}

				var type = "diskusi";

				if (idInduk != null) {
					type = "jawaban";
					cloneDataElement = $('#clone-sub-data-' + idInduk);
				}

				var clone = cloneDataElement.clone();

				clone.prop('id', type + '-post-' + idData);
				clone.prop('data-name', type + '-lain');

				$('[data-name=' + type + '-lain]').addClass("d-none");
				clone.addClass("row mb-2 pt-4 border-top border-ka-light");
				clone.removeClass("clone-data");

				//DATA
				clone.find('.' + type + '-nama-user').html(nama);
				clone.find('.' + type + '-teks').html(isi);
				clone.find('.' + type + '-time').html(time);

				if (value.is_user == 1 && value.is_deleted != 1) {
					menu_html = "<i class='btn btn-outline-dark rounded-circle fa fa-ellipsis-v' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'></i> <div class='dropdown-menu'> <a class='dropdown-item diskusi-hapus'  href=javascript:ListDiskusi.deleteDiskusi(" + idData + ")><i class='fa fa-trash'></i> Hapus</a> </div>";
					clone.find('.' + type + '-menu').html(menu_html);
				} else {
					clone.find('.' + type + '-menu').addClass("d-none");
				}

				clone.find('.' + type + '-foto-user').attr("src", fotoUser);

				clone.find('.' + type + '-teks').prop('id', type + '-teks-' + idData);
				clone.find('.' + type + '-action').prop('id', type + '-action-' + idData);

				if (idInduk == null) {
					//REPLY
					//buat tracking clone yang mana
					clone.find('#clone-sub-data').prop('id', 'clone-sub-data-' + idData);
					//add setelah apa
					clone.find('#jawaban-container').prop('id', "jawaban-container-" + idData);

					//aksi reply
					clone.find('.reply-btn').attr("href", "javascript:ListDiskusi.replyDiskusi(" + idData + ")");
					//container reply
					clone.find('.reply-container').html("<div id='reply-teks-" + idData + "'></div><div class='text-right w-100' id='reply-action-" + idData + "'></div>");
					clone.find('.reply-container').prop('id', "reply-container-" + idData);

					if (index <= 0) {
						clone.insertAfter(cloneDataElement);
					} else {
						clone.insertAfter($('#diskusi-post-' + (idPrev)));
					}
				} else {
					clone.find('.jawaban-teks').prop('id', 'jawaban-teks-' + idData);
					clone.find('.jawaban-action').prop('id', 'jawaban-action-' + idData);

					clone.find('.jawaban-jawabanke').html("<i class='text-secondary'><i class='fa fa-comment'></i> Reply</i>")

					if (idIndukFlag != idInduk || idIndukFlag == 0)
						clone.insertAfter($('#jawaban-container-' + idInduk));
					else if (idIndukFlag == idInduk)
						clone.insertAfter($('#jawaban-post-' + idDataFlag));

					idDataFlag = idData;
					idIndukFlag = idInduk;
				}
				cloneDataElement.removeClass("d-none");

				$('[data-name=' + type + '-lain]').removeClass("d-none");

				idPrev = idData;
			});
		}
		$('.diskusi-container').removeClass("d-none");
		$('#clone-data').addClass("d-none");
		loading = false;
		loadingElement.hide();
	};

	var deleteDiskusi = function (id) {
		if (!loading) {
			loadingElement.show();
			tableDataElement.hide();
			loading = true;
			jQuery.getJSON(urlDetailApi + id, result => {
				loadingElement.hide();
				tableDataElement.show();
				loading = false;
				swalBootstrap.fire({
					title: "Apa Anda Yakin Ingin Menghapus Komentar Ini?",
					text: "",
					type: "warning",
					showCancelButton: true,
					confirmButtonText: "Ya, Hapus!",
					cancelButtonText: "Tidak",
					closeOnConfirm: true,
					closeOnCancel: true,
					reverseButtons: true,
				}).then((result) => {
					if (result.isConfirmed) {
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
			tableDataElement.hide();
			loading = true;
			jQuery.getJSON(urlDeleteApi + id, result => {
				loading = false;
			}).fail(error => {
				loading = false;
			}).done(data => {
				toastr['success']('', data.message);
				setTimeout(function () {
					location.reload()
				}, 1500);
			})
		}
	};


	var replyDiskusi = function (id) {
		CKEDITOR.replace("reply-teks-" + id, {
			height: 96,
			width: "100%",
		});
		$("#reply-container-" + id).removeClass("d-none");
		$("#reply-action-" + id).html(`<div class="mt-3 text-right"><button type="reset" onClick="ListDiskusi.batalReply(` + id + `)" class="btn text-white px-4">BATAL</button><button type="button" onClick="ListDiskusi.replyServer(` + id + `)" class="btn btn-success px-4">KIRIM</button></div>`);
	}

	var replyServer = function (id) {
		var dataSimpan = new FormData();
		for (instance in CKEDITOR.instances) {
			CKEDITOR.instances['reply-teks-' + id].updateElement();
		}
		dataSimpan.append("isi", $('#reply-teks-' + id).html());
		dataSimpan.append("diskusi_id", id);

		var request = $.ajax({
			url: urlSimpanApi,
			data: dataSimpan,
			type: 'POST',
			contentType: false,
			processData: false
		});

		request.done(function (xhr, status, error) {
			if (xhr.success) {
				toastr["success"]("Berhasil", "Berhasil Tambah Balasan");
				ListDiskusi.batalReply(id);
				setInterval(function () {
					location.reload();
				}, 1500);
			} else {
				toastr["error"]("Gagal", "Gagal Tambah Balasan");
			}
		});

		request.always(function (xhr, status, error) {
		});

		request.fail(function (xhr, status, error) {
		});
	};

	var batalReply = function (id) {
		CKEDITOR.instances['reply-teks-' + id].destroy();

		$("#reply-container-" + id).html("<div id='reply-teks-" + id + "'></div><div class='text-right w-100' id='reply-action-" + id + "'></div>");
		$("#reply-container-" + id).addClass("d-none");
	}


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

		cloneBtnPage.removeClass("d-none");
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
				cloneBtnPage.find('.page-link').prop('href', 'javascript:ListDiskusi.changePage(' + totalPage + ')');
				cloneBtnPage.removeClass('disabled');
				cloneBtnPage.removeClass('active');
			}
			cloneBtnPage.insertBefore(btnPageNextElement);
		}


		pagingDetailElement.html("Menampilkan  (<span class='font-weight-bold'>" + (data.start + 1) + "</span> - <span class='font-weight-bold'>" + data.end + "</span> Dari <span class='font-weight-bold'>" + totalData + "</span> Data) " +
			"<br> Halaman <span class='font-weight-bold'>" + page + "</span> Total <span class='font-weight-bold'>" + totalPage + "</span> Halaman");

	};

	return {
		init: function () {
			requestDiskusi(urlGetApi);
		},
		refresh: function () {
			page = 1;
			requestDiskusi(urlGetApi);
		}, changePage: function (i) {
			page = i;
			requestDiskusi(urlGetApi);
		},
		deleteDiskusi(id) {
			deleteDiskusi(id);
		},
		replyDiskusi(id) {
			replyDiskusi(id);
		},
		replyServer(id) {
			replyServer(id);
		},
		batalReply(id, type) {
			batalReply(id, type);
		},
	}


}();


///////////////
// FORM
// FORM
// FORM
// FORM
// FORM
// FORM
// FORM
// FORM
// FORM
// FORM
// FORM
// FORM
// FORM
// FORM
// FORM
// FORM
// FORM
//////////////

var FormDiskusi = function () {

	//INIT URL
	var urlSimpanApi = base_url_api + "/DiskusiApi/simpan";
	var formDiskusiElement = $('#form-diskusi');


	formDiskusiElement.submit(function (event) {
		event.preventDefault();
		for (instance in CKEDITOR.instances) {
			CKEDITOR.instances['diskusi-input-0'].updateElement();
		}
		var formData = new FormData(formDiskusiElement[0]);
		var isi = jQuery("#cke_diskusi-input-0 iframe").contents().find("body").text();

		if (isi.length > 0) {
			var request = $.ajax({
				url: urlSimpanApi,
				data: formData,
				type: 'POST',
				contentType: false,
				processData: false
			});

			request.done(function (xhr, status, error) {
				if (xhr.success) {
					toastr["success"]("Sukses", "Berhasil Memberi Komentar");
					setTimeout(function () {
						location.reload();
					}, 1500);
				} else {
					toastr["error"]("Gagal", "Gagal Memberi Komentar");
				}
			});

			request.always(function (xhr, status, error) {
			});

			request.fail(function (xhr, status, error) {
			});
		} else {
			toastr["warning"]("Komentar harus diisi sebelum dikirim");
		}

	});

	return {
		init: function () {
			CKEDITOR.replace('diskusi-input-0', {
				height: 96,
			});
		},

	}


}();


// Initialize when page loads
jQuery(function () {
	ListDiskusi.init();
	FormDiskusi.init();
});
