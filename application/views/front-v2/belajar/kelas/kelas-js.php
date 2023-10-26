<script src="<?= base_url() ?>/assets/front/v2/plugins/plyr/plyr.js"></script>
<script src="<?= base_url() ?>/assets/front/v2/pages/diskusi/diskusi.js"></script>
<script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.31/dist/sweetalert2.all.min.js
"></script>

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
<?php if (!$is_review): ?>
    <script type="text/javascript">
        const URL = "<?= base_url('ulasan/' . $mapel['meta_link_mapel'])?>"
        setTimeout(() => {
            Swal.fire({
                title: 'Anda belum memberikan ulasan',
                description: 'Silahkan berikan ulasan',
                icon: 'info',
            }).then(result => {
                window.location.replace(URL)
            })
        }, 500)
    </script>
<?php endif; ?>

