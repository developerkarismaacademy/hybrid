<script src="<?= base_url() ?>/assets/front/v2/pages/diskusi/diskusi.js"></script>
<script>

	$("[id^='kuis-nav-']").click(function () {
		$("[data-kuis^='kuis-container-']").addClass("d-none");
		$("[data-kuis=kuis-container-" + $(this).attr("data-nav") + "]").removeClass("d-none");
		$("#kuis-info").html($(this).attr("data-nav"));
	})

	var loading = false;
	var cloneData = $("#clone-data-praktik");
	loadPraktek();

	function loadPraktek() {
		if (!loading) {
			loading = true;
			var url = "<?= base_url("log-praktek") ?>";

			var request = jQuery.ajax({
				url: url,
				method: "POST",
				data: {
					idMateri: <?= $materiActive["id_materi"] ?>,
				},
				beforeSend: function (xhr) {
					startLoadingElement("#materi-kuis-isi");
				}
			});

			request.always(function (xhr, status, error) {
				loading = false;
			});

			request.done(function (xhr, status, error) {
				stopLoadingElement("#materi-kuis-isi");
				$('.data-praktek').remove();
				if (xhr.success) {
					if (xhr.data.total <= 0) {
						$("#kosong").removeClass("d-none");
					} else {
						$("#kosong").addClass("d-none");

						$.each(xhr.data.data, function (index, value) {
							var clone = cloneData.clone();

							clone.addClass("data-praktek");
							clone.removeClass("d-none");

							clone.find(".subjek").html(value.nama);
							clone.find(".no").html((index + 1));
							clone.find(".tipe").html(value.tipe.toUpperCase());
							if (value.tipe != "link") {
								clone.find(".link-download").attr("href", base_url + "upload/praktek/<?=$_SESSION['siswaData']['id_user']?>/<?=$materiActive["id_materi"]?>/" + value.file);
							} else if (value.tipe == "link") {
								clone.find(".link-download").attr("href", value.file);
								clone.find(".link-download i").removeClass("fa-download");
								clone.find(".link-download i").addClass("fa-external-link");
							}
							clone.find(".link-hapus").click(function () {
								hapusPraktek(value.id_log_praktek)
							});

							$("#data-log").append(clone);
						});

					}
				} else {
					toastr["error"]("Terjadi Kesalahan");
				}
			});

			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				stopLoadingElement("#materi-kuis-isi");
			});


		}
	}

	function simpanPraktek(tipe) {
		if (!loading) {
			loading = true;
			var url = "<?= base_url("simpan-praktek") ?>";

			var fd = new FormData($("#form-" + tipe)[0]);
			fd.append('tipe', tipe);
			fd.append('idMapel', <?= $mapel["id_mapel"] ?>);
			fd.append('idMateri', <?= $materiActive["id_materi"] ?>);

			var request = jQuery.ajax({
				url: url,
				method: "POST",
				data: fd,
				contentType: false,
				processData: false,
				beforeSend: function (xhr) {
					startLoadingElement("#materi-kuis-isi");
				}
			});

			request.always(function (xhr, status, error) {
				loading = false;
				loadPraktek();
			});

			request.done(function (xhr, status, error) {
				stopLoadingElement("#materi-kuis-isi");
				if (xhr.success) {
					toastr["success"]("Berhasil Di Simpan");
				} else {
					toastr["error"](`${xhr.error}`);
				}
			});

			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				stopLoadingElement("#materi-kuis-isi");
			});


		}
	}

	$("#btn-dokumen").click(function () {
		simpanPraktek("dokumen");
	});

	$("#btn-lampiran").click(function () {
		simpanPraktek("lampiran");
	});

	$("#btn-gambar").click(function () {
		simpanPraktek("gambar");
	});

	$("#btn-link").click(function () {
		simpanPraktek("link");
	});

	function hapusPraktek(id) {
		if (!loading) {
			loading = true;
			var url = "<?= base_url("hapus-praktek") ?>";

			var request = jQuery.ajax({
				url: url,
				method: "POST",
				data: {
					idLogUjian: id,
					idMapel: <?= $mapel["id_mapel"] ?>,
				},
				beforeSend: function (xhr) {
					startLoadingElement("#materi-kuis-isi");
				}
			});

			request.always(function (xhr, status, error) {
				loading = false;
				loadPraktek();
			});

			request.done(function (xhr, status, error) {
				stopLoadingElement("#materi-kuis-isi");
				if (xhr.success) {
					toastr["success"](xhr.message);
				} else {
					toastr["error"](xhr.message);
				}
			});

			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				stopLoadingElement("#materi-kuis-isi");
			});


		}
	}

	//Create filename
	$('.custom-file-input').on('change', function () {
		//get the file name
		var fileName = $(this).val();
		//replace the "Choose a file" label
		$(this).next('.custom-file-label').html(fileName);
	})
</script>
