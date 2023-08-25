//INIT URL
var urlSimpanApi = base_url_api + "/ListhasilApi/simpanListhasil";
var urlHapusApi = base_url_api + "/ListhasilApi/delete";
var idMapel = $('#idMapel').val();
var metaKelas = $('#metaKelas').val();


//INIT LOADING
var loading = false;
var loadingElement = $('.loading-form');

//INIT ELEMENT
var listhasilElement = $('#mapel-listhasil');
var formUrutanElement = $('#form-urutan');
var tambah = $("#tambah");
var btnTambah = $('#btn-tambah');
var btnHapus = $('.btn-hapus');


formUrutanElement.submit(function (event) {
	event.preventDefault();

	var dataUrutan = listhasilElement.nestable('serialize');
	if (!loading) {
		loading = true;
		loadingElement.show();

		var request = $.ajax({
			url: urlSimpanApi,	
			data: {data: dataUrutan, mapel_id: idMapel},
			type: 'POST'
		});

		request.done(function (xhr, status, error) {
			if (xhr.success) {
				toastr["success"]("Sukses", "Berhasil Menyimpan Data");
				setTimeout(function () {
					$.redirect(base_url + 'back/mapel/' + metaKelas, null, 'GET');
				}, 1500);
			} else {
				toastr["error"]("Gagal", "Gagal Menyimpan Data");
			}
		});

		request.always(function (xhr, status, error) {
			loading = false;
			loadingElement.hide();
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
});

btnTambah.click(function(){
	// jika data id tidak ada, berarti perlu ditambah lewat db idnya!
	nestablecount = $(".item-list").length + 1;
	tambahListText = tambah.val();
	if(tambahListText != ""){
		listhasilElement.find("ol.dd-list").append('<li class="dd-item dd3-item item-list" data-deskripsi="'+tambahListText+'"><div class="dd-handle dd3-handle"></div><div class="dd3-content" name="'+nestablecount+'">'+tambahListText+'<span class="pull-right text-danger fa fa-trash" onclick="hapusAction($(this))"></span></div></li>');
	}
	tambah.val("");
});

loadingElement.hide();
listhasilElement.nestable({maxDepth: 1});


var hapusAction = function(el){
	//Error di hapus saat sudah tambah
	idListHasil = el.closest("li").data('id');
	if(typeof idListHasil === 'undefined'){
		el.closest("li").remove();
	}else{
		if (!loading) {
			loading = true;
			loadingElement.show();
			var request = $.ajax({
				url: urlHapusApi + "/" + idListHasil,	
				type: 'POST'
			});

			request.done(function (xhr, status, error) {
				if (xhr.success) {
					el.closest("li").remove();
					toastr["success"]("Sukses", "Berhasil Menghapus Data");
				} else {
					toastr["error"]("Gagal", "Gagal Menyimpan Data");
				}
			});

			request.always(function (xhr, status, error) {
				loading = false;
				loadingElement.hide();
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
	}
};


