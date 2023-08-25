<script src="<?= base_url() ?>/assets/front/v2/pages/diskusi/diskusi.js"></script>

<script type="text/javascript">

    var textMateri = $("#materi-teks-isi").html().split('<div style="page-break-after: always"><span style="display:none">&nbsp;</span></div>');


    var currentPage = 0;
    $("#page-end").hide();
    gantiHalaman(currentPage);

    function gantiHalaman(i) {

        currentPage = i;

        $("#materi-teks-isi").html(textMateri[currentPage]);

        if (currentPage == 0) {
            $("#page-nav-prev").addClass("disabled");
            $("#page-nav-prev").addClass("btn-disabled");

        } else {
            $("#page-nav-prev").removeClass("disabled");
            $("#page-nav-prev").removeClass("btn-disabled");

        }

        $("#total-halaman").html((currentPage + 1) + "/" + (textMateri.length));

        if (currentPage == (textMateri.length - 1)) {
            $("#page-end").show();
            $("#page-nav-next").addClass("disabled");
            $("#page-nav-next").addClass("btn-disabled");

        } else {
            $("#page-end").hide();
            $("#page-nav-next").removeClass("disabled");
            $("#page-nav-next").removeClass("btn-disabled");
        }

        $("#page-nav-prev").attr("href", "javascript:gantiHalaman(" + (currentPage - 1) + ");");

        $("#page-nav-next").attr("href", "javascript:gantiHalaman(" + (currentPage + 1) + ");");
    }

    var loading = false;

    var selesai = function () {
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
