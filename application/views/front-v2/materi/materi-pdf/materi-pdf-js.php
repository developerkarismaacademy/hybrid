<script src="<?= base_url() ?>/assets/front/v2/pages/diskusi/diskusi.js"></script>
<script src="<?= base_url() ?>/assets/front/plugins/pdf.js/build/pdf.js"></script>

<script type="text/javascript">
	pdfjsLib.GlobalWorkerOptions.workerSrc = '<?= base_url(); ?>assets/front/plugins/pdf.js/build/pdf.worker.js';

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
		pdfDoc.getPage(num).then(function(page) {
			var viewport = page.getViewport({
				scale: scale
			});
			canvas.height = viewport.height;
			canvas.width = viewport.width;

			// Render PDF page into canvas context
			var renderContext = {
				canvasContext: ctx,
				viewport: viewport
			};
			var renderTask = page.render(renderContext);

			// Wait for rendering to finish
			renderTask.promise.then(function() {
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


	/**
	 * Asynchronously downloads PDF.
	 */

	loadBase64PDF();


	var loading = false;

	function loadBase64PDF() {
		if (!loading) {
			loading = true;
			var request = $.ajax({
				url: base_url + "/materi/base64" + "/" + <?= $materiActive["id_materi"] ?>,
				type: 'GET',
				contentType: false,
				processData: false,
				beforeSend: function(xhr) {
					startLoadingElement("#konten");
				}
			});

			request.done(function(xhr, status, error) {


				var subject = xhr.data;
				console.log(subject);

				var pdfData = base64ToUint8Array(subject.base64);

				pdfjsLib.getDocument({
					data: pdfData
				}).promise.then(function(pdfDoc_) {
					pdfDoc = pdfDoc_;
					document.getElementById('page_count').textContent = pdfDoc.numPages;

					// Initial/first page rendering
					renderPage(pageNum);
				});

				loading = false;

			});

			request.always(function(xhr, status, error) {
				loading = false;
				stopLoadingElement("#konten");
			});
		}
	}

	var selesai = function() {
		if (!loading) {
			loading = true;
			var url = "<?= base_url("simpan-log") ?>";

			var request = jQuery.ajax({
				url: url,
				method: "POST",
				data: {
					tipe: "baca",
					idMateri: <?= $materiActive["id_materi"] ?>,
					idMapel: <?= $mapel["id_mapel"] ?>,
				},
				beforeSend: function(xhr) {
					startLoadingElement("#konten");
				}
			});

			request.always(function(xhr, status, error) {});

			request.done(function(xhr, status, error) {
				stopLoadingElement("#konten");
				$("#kuis-modal-end").modal();
			});

			request.fail(function(jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				stopLoadingElement("#konten");
			});


		}
	};
	$("#fileRequest").click(function() {

		let file = $("#fileRequest").val();
		const fileUrl = base_url + 'upload/materi-pdf/' + file; // replace with the URL of the file you want to download
		const fileName = $('#judulMateri').text() // replace with the desired file name
		const a = document.createElement("a");
		a.href = fileUrl;
		a.download = fileName;
		document.body.appendChild(a);
		a.click();
		document.body.removeChild(a);

	});
</script>