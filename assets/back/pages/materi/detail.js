var FormBatchLatihan = function () {

	//INIT LOADING
	var loading = false;
	var loadingFormElement = $('.loading-form');
	var id = $('#idKelas').val();
	var meta = $('#metaKelas').val();
	var idMapel = $('#idMapel').val();
	var metaMapel = $('#metaMapel').val();
	var idBab = $('#idBab').val();
	var metaBab = $('#metaBab').val();
	var idMateri = $('#id_materi').val();

	//INIT FORM

	var urlDetailApi = base_url_api + "/MateriApi/detail";

	//INIT DETAIL
	var namaMateriDetailElement = $('#nama-materi-detail');
	var namaMapelDetailElement = $('#nama-mapel-detail');
	var namaKelasDetailElement = $('#nama-kelas-detail');
	var namaBabDetailElement = $('#nama-bab-detail');
	var deskripsiMateriDetailElement = $('#deskripsi-materi-detail');
	var durasiMateriDetailElement = $('#durasi-materi-detail');
	var tipeMateriDetailElement = $('#tipe-materi-detail');
	var videoMateriDetailElement = $('.video-materi-detail');
	var isiMateriDetailElement = $('#isi-materi');
	var metaMateriElement = $('#meta_materi');

	var namaMateri, namaMapel, namaKelas, namaBab, deskripsiMateri, tipeMateri, metaMateri, isiMateri, durasiMateri;

	var detailOpen = function () {

		if (!loading) {
			loading = true;

			var request = jQuery.ajax({
				url: urlDetailApi + "/" + idMateri,
				method: "GET",
				beforeSend: function (xhr) {
					loadingFormElement.show();
				}
			});

			request.always(function (xhr, status, error) {
				loading = false;
				loadingFormElement.hide();
			});

			request.done(function (xhr, status, error) {
				console.log(xhr.data);

				namaMateri = xhr.data.nama_materi;
				namaMapel = xhr.data.nama_mapel;
				namaKelas = xhr.data.nama_kelas;
				namaBab = xhr.data.nama_bab;
				deskripsiMateri = xhr.data.deskripsi_materi;
				durasiMateri = xhr.data.durasi;
				tipeMateri = xhr.data.tipe;
				videoMateri = xhr.data.url_video;
				metaMateri = xhr.data.meta_link_materi;
				isiMateri = xhr.data.isi_materi;

				namaMateriDetailElement.html(namaMateri);
				namaMapelDetailElement.html(namaMapel);
				namaKelasDetailElement.html(namaKelas);
				namaBabDetailElement.html(namaBab);
				deskripsiMateriDetailElement.html(deskripsiMateri);
				durasiMateriDetailElement.html(durasiMateri);
				isiMateriDetailElement.html(isiMateri);
				videoMateriDetailElement.html(videoMateri);
				if (tipeMateri == "pilihan") {
					tipeMateriDetailElement.html('<span class="label label-info">Ujian/Test</span>');
				} else if (tipeMateri == "teks") {
					tipeMateriDetailElement.html('<span class="label label-primary">Materi Teks</span>');
				} else if (tipeMateri == "praktek") {
					tipeMateriDetailElement.html('<span class="label label-info">Praktek</span>');
				} else if (tipeMateri == "pdf") {
					tipeMateriDetailElement.html('<span class="label label-info">PDF</span>');
					loadBase64PDF();
				} else {
					tipeMateriDetailElement.html('<span class="label label-default">Materi Video</span>');
					var videoHtml = '<div class="video-container"><iframe id="video" width="560" height="315" src="https://www.youtube.com/embed/' + videoMateri + '?rel=0&hd=1" frameborder="0" allowfullscreen></iframe></div>';
					isiMateriDetailElement.html(videoHtml + "<br><br>" + isiMateri);
				}
				metaMateriElement.val(metaMateri);

				loading = false;

			});

			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				loadingFormElement.hide();
			});


		}
	};

	pdfjsLib.GlobalWorkerOptions.workerSrc = base_url + 'assets/front/plugins/pdf.js/build/pdf.worker.js';

	var pdfDoc = null,
		pageNum = 1,
		pageRendering = false,
		pageNumPending = null,
		scale = 1.15,
		canvas = document.getElementById('pdf-container'),
		ctx = canvas.getContext('2d');

	/**
	 * Get page info from document, resize canvas accordingly, and render page.
	 * @param num Page number.
	 */
	function renderPage(num) {
		pageRendering = true;
		// Using promise to fetch the page
		pdfDoc.getPage(num).then(function (page) {
			var viewport = page.getViewport({scale: scale});
			canvas.height = viewport.height;
			canvas.width = viewport.width;

			// Render PDF page into canvas context
			var renderContext = {
				canvasContext: ctx,
				viewport: viewport
			};
			var renderTask = page.render(renderContext);

			// Wait for rendering to finish
			renderTask.promise.then(function () {
				pageRendering = false;
				if (pageNumPending !== null) {
					// New page rendering is pending
					renderPage(pageNumPending);
					pageNumPending = null;
				}
			});
		});

		// Update page counters
		document.getElementById('page_num').textContent = num;
	}

	function base64ToUint8Array(base64) {
		var raw = atob(base64);
		var uint8Array = new Uint8Array(raw.length);
		for (var i = 0; i < raw.length; i++) {
			uint8Array[i] = raw.charCodeAt(i);
		}
		return uint8Array;
	}

	/**
	 * If another page rendering in progress, waits until the rendering is
	 * finised. Otherwise, executes rendering immediately.
	 */
	function queueRenderPage(num) {
		if (pageRendering) {
			pageNumPending = num;
		} else {
			renderPage(num);
		}
	}

	/**
	 * Displays previous page.
	 */
	function onPrevPage() {
		if (pageNum <= 1) {
			return;
		}
		pageNum--;
		queueRenderPage(pageNum);
	}

	document.getElementById('prev').addEventListener('click', onPrevPage);

	/**
	 * Displays next page.
	 */
	function onNextPage() {
		if (pageNum >= pdfDoc.numPages) {
			return;
		}
		pageNum++;
		queueRenderPage(pageNum);
	}

	document.getElementById('next').addEventListener('click', onNextPage);

	function loadBase64PDF() {
		if (!loading) {
			loading = true;
			var request = $.ajax({
				url: base_url + "/materi/base64/" + idMateri,
				type: 'GET',
				contentType: false,
				processData: false,
				beforeSend: function (xhr) {
					loadingFormElement.show();
				}
			});

			request.done(function (xhr, status, error) {


				var subject = xhr.data;
				console.log(subject);

				var pdfData = base64ToUint8Array(subject.base64);

				pdfjsLib.getDocument({data: pdfData}).promise.then(function (pdfDoc_) {
					pdfDoc = pdfDoc_;
					document.getElementById('page_count').textContent = pdfDoc.numPages;

					// Initial/first page rendering
					renderPage(pageNum);
				});

				loading = false;

			});

			request.always(function (xhr, status, error) {
				loading = false;
				loadingFormElement.hide();
			});
		}
	}

	return {
		init: function () {
			loadingFormElement.hide();
			detailOpen();
		}
	}

}();

// Initialize when page loads
jQuery(function () {
	FormBatchLatihan.init();
});

