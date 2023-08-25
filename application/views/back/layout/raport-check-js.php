<script>
    var urlRaporApi = base_url_api + "/ProgressApi/updateRaport";
    $(".raport_allowed").change(function () {
        var raport_allowed = $(this).is(':checked');
        var id_mapel = $("#idMapel").val();

        var request = $.ajax({
            url: urlRaporApi,
            data: {
                user: <?= $siswa["id_user"] ?>,
                raport: raport_allowed,
                mapel: id_mapel,
            },
            type: 'POST',
        });

        request.done(function (xhr, status, error) {
            if (xhr.success) {
                toastr["success"]("Sukses", "Berhasil Menyimpan Data");

            } else {
                toastr["error"]("Gagal", "Gagal Menyimpan Data");
            }
        });

        request.always(function (xhr, status, error) {
        });

        request.fail(function (xhr, status, error) {

            if (xhr.status != 422) {
                if (!xhr.success) {
                    toastr['error']('Server Error', xhr.message);
                } else {
                    toastr['error']('Server Bermasalah', 'Terjadi Kesalahan Jaringan');
                }
            }

        });
    });

</script>
