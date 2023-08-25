<script src="<?= base_url() ?>/assets/front/v2/plugins/plyr/plyr.js"></script>
<script src="<?= base_url() ?>/assets/front/v2/pages/diskusi/diskusi.js"></script>

<script type="text/javascript">
	var loading = false;

	const player = new Plyr('#player', {
		youtube: {
			autoplay: 0,
			noCookie: false,
			rel: 0,
			showinfo: 0,
			modestbranding: 1,
			enablejsapi: 0,
			loop: 1
		},
	});

	player.on("statechange", function (event) {
	})
	player.on("ready", function (event) {
		$("#duration").html("(" + fancyTimeFormat(player.duration) + ")");
	})
	player.on('ended', event => {
		selesai();
	});


	var selesai = function () {
		if (!loading) {
			loading = true;
			var url = "<?= base_url("simpan-log") ?>";

			var request = jQuery.ajax({
				url: url,
				method: "POST",
				data: {
					tipe: "video",
					idMateri: <?= $materiActive["id_materi"] ?>,
					idMapel: <?= $mapel["id_mapel"] ?>,
				},
				beforeSend: function (xhr) {
					startLoadingElement("#konten");
				}
			});

			request.always(function (xhr, status, error) {
			});

			request.done(function (xhr, status, error) {
				stopLoadingElement("#konten");
				$("#kuis-modal-end").modal();
			});

			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				stopLoadingElement("#konten");
			});


		}
	};

</script>
