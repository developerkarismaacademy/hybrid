<?php

if ($logUjian["total"] > 0) {
    $jumlahRetake = $logUjian["data"]["retake_log_ujian"];
    $allowRetake = $jumlahRetake >= 0 && $jumlahRetake <= 1;
    $retaken = $jumlahRetake >= 1 && $jumlahRetake <= 2;
} else {
    $data = [
        "jumlahRetake" => 0,
        "allowRetake" => true,
        "retaken" => false,
    ];
}
?>

<script src="<?= base_url() ?>assets/front/v2/plugins/jquery.countdown/jquery.countdown.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstimezonedetect/1.0.7/jstz.js"></script>
<script type="text/javascript" src="https://momentjs.com/downloads/moment.js"></script>
<script type="text/javascript" src="https://momentjs.com/downloads/moment-timezone-with-data.js"></script>


<script>
    var tz = jstz.determine(); // Determines the time zone of the browser client
    var timezone = tz.name();

    $("#kuis-aktif").hide();
    var currentPage = 1;


    $("[id^='kuis-nav-']").click(function () {
        $("[data-kuis^='kuis-container-']").addClass("d-none");
        $("[data-kuis=kuis-container-" + $(this).attr("data-nav") + "]").removeClass("d-none");
        $("#kuis-info").html($(this).attr("data-nav"));

        currentPage = parseInt($(this).attr("data-nav"));

        $("#kuis-nav-prev").attr("data-nav", (currentPage - 1) <= 1 ? 1 : (currentPage - 1))
        $("#kuis-nav-next").attr("data-nav", (currentPage + 1) >= <?= $soal["total"] ?> ? <?= $soal["total"] ?> : (currentPage + 1))
        if ((currentPage - 1) < 1) {
            $("#kuis-nav-prev").addClass("disabled");
            $("#kuis-nav-next").removeClass("disabled");
        } else
            if (currentPage + 1 > <?= $soal["total"] ?>){
        $("#kuis-nav-prev").removeClass("disabled");
        $("#kuis-nav-next").addClass("disabled");
    }else {
        $("[id^='kuis-nav-']").removeClass("disabled");
    }
    })

    var loading = false;

    var idLog = 0;

    function start() {
        if (!loading) {
            loading = true;
            var url = "<?= base_url("start") ?>";
            console.log(url);

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
                if (xhr.success) {
                    $("#kuis-aktif").show();
                    $(".kuis-start").hide();
                    idLog = xhr.data.data.id_log_ujian;

                    var endtime = moment.tz(xhr.data.data.estimasi_time, "Asia/Jakarta");

                    $('#kuis-detik').countdown(endtime.toDate(), function (event) {
                        $(this).html(event.strftime('%H:%M:%S'));
                    }).on('finish.countdown', function () {
                        selesai();
                    });
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

    function simpanJawaban(id, jawaban) {
        if (!loading) {
            loading = true;
            var url = "<?= base_url("simpan-jawaban") ?>";

            var request = jQuery.ajax({
                url: url,
                method: "POST",
                data: {
                    idSoal: id,
                    jawaban: jawaban,
                    idMateri: <?= $materiActive["id_materi"] ?>,
                    idLogUjian: idLog,
                    jmlSoal: <?= $soal["total"] ?>,
                },
                beforeSend: function (xhr) {
                    startLoadingElement("#materi-kuis-isi");
                    $('#kuis-detik').countdown('pause');
                }
            });

            request.always(function (xhr, status, error) {
                loading = false;
            });

            request.done(function (xhr, status, error) {
                if (xhr.success) {
                    stopLoadingElement("#materi-kuis-isi");
                    $('#kuis-detik').countdown("resume");
                    $('#kuis-nav-next').click();
                } else {
                    toastr["error"]("Terjadi Kesalahan");
                }
            });

            request.fail(function (jqXHR, textStatus) {
                loading = false;
                toastr["error"]("Terjadi Kesalahan");
                stopLoadingElement("#materi-kuis-isi");
                $('#kuis-detik').countdown("resume");
            });
        }
    }

    function retake() {
        swalBootstrap.fire({
            title: 'Anda yakin?',
            icon: 'warning',
            html: 'Nilai yang diambil adalah nilai terakhir.',
            showCloseButton: false,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: 'Ya, retake!',
            cancelButtonText: 'Tidak!',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                if (!loading) {
                    loading = true;
                    var url = "<?= base_url("retake") ?>";

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
                        stopLoadingElement("#materi-kuis-isi");
                    });

                    request.done(function (xhr, status, error) {
                        if (xhr.success) {
                            window.location.reload();
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
        });
    }

    var selesai = function () {
        if (!loading) {
            loading = true;
            var url = "<?= base_url("selesai") ?>";

            var request = jQuery.ajax({
                url: url,
                method: "POST",
                data: {
                    idLogUjian: idLog,
                    idMapel: <?= $mapel["id_mapel"] ?>,
                },
                beforeSend: function (xhr) {
                    $("#kuis-modal-end").hide();
                    startLoadingElement("#konten");
                }
            });

            request.always(function (xhr, status, error) {
            });

            request.done(function (xhr, status, error) {
                $('#kuis-modal-ya').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                setTimeout(function () { location.reload() }, 3000);
            });

            request.fail(function (jqXHR, textStatus) {
                loading = false;
                toastr["error"]("Terjadi Kesalahan");
                $("#kuis-modal-end").hide();
                stopLoadingElement("#konten");
            });


        }
    };
</script>