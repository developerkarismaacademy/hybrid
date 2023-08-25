
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>

<style>
    .banner-overlay {
        height: 100%;
        font-size: 3em;
        background: rgba(0, 0, 0, 0.5);

        display: flex;
        justify-content: center;
        align-items: center;

        cursor: pointer;
    }

    .banner-overlay span {
        color: #24395D;
    }

    .banner-overlay span.fa-play {
        color: #FFA737;
        font-size: 0.9em;
    }

    .modal {
        z-index: 10002;
    }

    .modal-backdrop {
        z-index: 10001;
    }

    .collapse:hover,
    [data-toggle="collapse"]:hover {
        cursor: pointer;
    }
    .device-wrapper{
        max-width:100%;
    }
    .device::after{
        z-index: 0!important;
    }
    .device .screen{
        z-index: 1!important;
    }
    .sertifikat{
        background-size: contain;
        width: 100%;
        height: 200px;
        background-position: center;
        background-repeat: no-repeat;
    }

    .slick-track{
        text-align: center;
        display: flex;
        justify-content: center; 
    }
</style>

<link rel="stylesheet" href="<?= base_url() ?>/assets/front/v2/plugins/plyr/plyr.css" media="none"
      onload="if(media!='all')media='all'">
