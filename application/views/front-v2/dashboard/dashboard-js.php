<script src="<?= base_url() ?>/assets/front/v2/plugins/plyr/plyr.js"></script>
<script type="text/javascript">
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
		sources: [{
			src: 'EDJ2zjNOTrg',
			provider: 'youtube',
			size: 720,
		},
			{
				src: 'EDJ2zjNOTrg',
				provider: 'youtube',
				size: 1080,
			},
		],
	});


	$('#vidModal').on('shown.bs.modal', function (e) {
		player.play();
	})
	$('#vidModal').on('hidden.bs.modal', function (e) {
		player.pause();
	})
</script>
