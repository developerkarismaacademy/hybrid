<script>
    var loading = false;
    var loadingFormElement = $('.loading-form');
    var urlSimpanPraktekApi = base_url_api + "/ProgressApi/simpanNilaiPraktek";
    var urlSimpanIndikatorApi = base_url_api + "/ProgressApi/simpanNilaiIndikator";

    $(".konten-materi").hide();

    <?= (isset($_SESSION["terakhirAksesMateri"])) ? "showPenilaian({$_SESSION["terakhirAksesMateri"]}, {$_SESSION["terakhirAksesBab"]})" : "showPenilaian({$materiPertama}, {$babPertama})" ?>

    loadingFormElement.hide();
    $(function () {
        //Init Show Nilai
        $("span[class^='nilai-praktek-']").each(function () {
            kelas = $(this).attr("class");
            idBab = kelas.replace('nilai-praktek-', '');
        });
    });

    function showPenilaian(id, idBab, jenisMateri) {
        $(".konten-materi").hide();
        $("#konten-materi-" + id).show('slow');

        if (jenisMateri == "praktek") {
            $(".nilai-praktek-" + idBab).each(function () {
                $(this).text(nilaiPraktekHitung(id));
            });
        }
    }

    function simpanNilaiIndikator(id, nilai, idMateri, idBab) {
        var request = $.ajax({
            url: urlSimpanIndikatorApi,
            data: {
                user_id: <?= $siswa["id_user"] ?>,
                indikator_id: id,
                nilai: nilai,
                nilai_total: nilaiPraktekHitung(idMateri),
                materi_id: idMateri,
            },
            type: 'POST',
        });

        request.done(function (xhr, status, error) {
            if (xhr.success) {
                toastr["success"]("Sukses", "Berhasil Menyimpan Data");

                $(".nilai-praktek-" + idBab).each(function () {
                    $(this).text(nilaiPraktekHitung(idMateri));
                });

                $(".badge-notif-" + idBab).remove();
                $("#item-materi-" + id + " h4.text-danger").addClass("text-success").removeClass("text-danger");
                $("#item-materi-" + id + " i.text-danger").addClass("fa-check-circle text-success").removeClass("fa-exclamation-circle text-danger");
            } else {
                toastr["error"]("Gagal", "Gagal Menyimpan Data");
            }
        });

        request.always(function (xhr, status, error) {
            loading = false;
            loadingFormElement.hide();
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
    }


    function nilaiPraktekHitung(id) {
        nilaiAkhir = 0;
        totalIndikator = 0;
        nilainya = 0;
        $(".input-indikator-" + id).each(function () {
            nilainya = ($(this).val() == "") ? 0 : parseInt($(this).val());
            nilaiAkhir = nilaiAkhir + nilainya;
            totalIndikator++;
        });
        return (nilaiAkhir != 0) ? nilaiAkhir / totalIndikator * 10 : 0;
    }
</script>
<?php
$this->load->view("back/layout/raport-check-js.php");

$_SESSION["terakhirAksesMateri"] = null;
$_SESSION["terakhirAksesBab"] = null;
unset($_SESSION["terakhirAksesMateri"], $_SESSION["terakhirAksesBab"]);
?>
