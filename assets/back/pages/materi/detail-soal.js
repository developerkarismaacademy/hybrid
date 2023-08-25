var FormUpdateSoal = function () {

	//INIT LOADING
	var loading = false;
	var loadingFormElement = $('.loading-form');
	var id = $('#idKelas').val();
	var meta = $('#metaKelas').val();
	var idMapel = $('#idMapel').val();
	var metaMapel = $('#metaMapel').val();
	var idBab = $('#idBab').val();
	var metaBab = $('#metaBab').val();
	var idMateri = $('#idMateri').val();
	var metaMateri = $('#metaMateri').val();
	var idSoal = $('#id_soal').val();

	//INIT FORM
	var formLatihanSoalElement = $('#form-latihan-soal');
	var kunciElement = $('#kunci');
	var pertanyaanElement = $('#pertanyaan');
	var jawaban1Element = $('#jawaban_1');
	var jawaban2Element = $('#jawaban_2');
	var jawaban3Element = $('#jawaban_3');
	var jawaban4Element = $('#jawaban_4');
	var jawaban5Element = $('#jawaban_5');
	var pembahasanElement = $('#pembahasan');
	var urlSimpanApi = base_url_api + "/MateriApi/ubahSoal";
	var urlDetailApi = base_url_api + "/MateriApi/detailSoal";

	//INIT DETAIL
	var namaMateriDetailElement = $('#nama-materi-detail');
	var namaMapelDetailElement = $('#nama-mapel-detail');
	var namaKelasDetailElement = $('#nama-kelas-detail');
	var namaBabDetailElement = $('#nama-bab-detail');
	var deskripsiMateriDetailElement = $('#deskripsi-materi-detail');
	var tipeMateriDetailElement = $('#tipe-materi-detail');
	var metaMateriElement = $('#meta_materi');


	var namaMateri, namaMapel, namaKelas, namaBab, deskripsiMateri, tipeMateri;
	var pertanyaan, kunci, jawaban_1, jawaban_2, jawaban_3, jawaban_4, jawaban_5, pembahasan;


	var detailOpen = function () {

		if (!loading) {
			loading = true;

			var request = jQuery.ajax({
				url: urlDetailApi + "/" + idSoal,
				method: "GET",
				beforeSend: function (xhr) {
					loadingFormElement.show();
				}
			});

			request.always(function (xhr, status, error) {
				loading = false;
			});

			request.done(function (xhr, status, error) {

				namaMateri = xhr.data.nama_materi;
				namaMapel = xhr.data.nama_mapel;
				namaKelas = xhr.data.nama_kelas;
				namaBab = xhr.data.nama_bab;
				deskripsiMateri = xhr.data.deskripsi_materi;
				tipeMateri = xhr.data.tipe;
				metaMateri = xhr.data.meta_link_materi;

				namaMateriDetailElement.html(namaMateri);
				namaMapelDetailElement.html(namaMapel);
				namaKelasDetailElement.html(namaKelas);
				namaBabDetailElement.html(namaBab);
				deskripsiMateriDetailElement.html(deskripsiMateri);
				if (tipeMateri == "pilihan") {
					tipeMateriDetailElement.html('<span class="label label-info">Ujian/Test</span>');
				}
				metaMateriElement.val(metaMateri);
				pertanyaan = xhr.data.isi_soal;


				jawaban_1 = xhr.data.jawab_1;
				jawaban_2 = xhr.data.jawab_2;
				jawaban_3 = xhr.data.jawab_3;
				jawaban_4 = xhr.data.jawab_4;
				jawaban_5 = xhr.data.jawab_5;
				pembahasan = xhr.data.pembahasan;

				kunciElement.html("Jawaban " + xhr.data.kunci_jawaban);

				pertanyaanElement.html(pertanyaan);
				jawaban1Element.html(jawaban_1);
				jawaban2Element.html(jawaban_2);
				jawaban3Element.html(jawaban_3);
				jawaban4Element.html(jawaban_4);
				jawaban5Element.html(jawaban_5);
				pembahasanElement.html(pembahasan);
				loadingFormElement.hide();


				loading = false;

			});

			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				loadingFormElement.hide();
			});


		}
	};

	return {
		init: function () {
			loadingFormElement.hide();
			detailOpen();
		}
	}

}();

// Initialize when page loads
jQuery(function () {
	FormUpdateSoal.init();
});

