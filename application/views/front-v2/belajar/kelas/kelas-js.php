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
		sources: [
			{
				src: '<?= $mapel["intro_video"] ? $mapel["intro_video"] : "8o2rCqOxpHY" ?>',
				provider: 'youtube',
				size: 720,
			},
			{
				src: '<?= $mapel["intro_video"] ? $mapel["intro_video"] : "8o2rCqOxpHY" ?>',
				provider: 'youtube',
				size: 1080,
			},
		],
	});


</script>
