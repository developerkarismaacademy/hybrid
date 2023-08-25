var FormBatchLatihan = function () {

	//INIT LOADING
	var loading = false;
	var loadingFormElement = $('.loading-form');
	var idTransaksi = $('#idTransaksi').val();
	var idUser = $('#idUser').val();


	//INIT FORM

	var urlDetailApi = base_url_api + "/TransaksiApi/detail";
	var urlConfirmApi = base_url_api + "/TransaksiApi/confirm";
	var pageTitleElement = $('.title-page');
	var namaUserElement = $('#nama-user');
	var emailUserElement = $('#email-user');
	var noTelpUserElement = $('#no-telp-user');
	var totalItemTransaksiElement = $('#total-item-transaksi');
	var totalElement = $('#total');
	var confirmButtonElement = $('#confirm-button');
	var totalBeliTransaksiElement = $('#total-beli-transaksi');
	var totalBayarTransaksiElement = $('#total-bayar-transaksi');
	var bankUserElement = $('#bank-user');
	var bankKarismaElement = $('#bank-karisma');
	var noRekUserElement = $('#no-rek-user');
	var atasNamaElement = $('#atas-nama');
	var buktiTransferElement = $('#bukti-transfer');
	var tanggalElement = $('#tanggal');
	var statusOrderElement = $('#status-order');

	//INIT DETAIL
	var loadingDetail = $("#loading");
	var cloneDataElement = $('#clone-data');
	var tableDateElement = $('#table-data');


	var namaUser, emailUser, noTelpUser, totalItemTransaksi, totalBeliTransaksi, totalBayarTransaksi, bankUser,
		bankKarisma, noRekUser, atasNama, buktiTransfer;

	var detailOpen = function () {

		if (!loading) {
			loading = true;

			var request = jQuery.ajax({
				url: urlDetailApi + "/" + idTransaksi + "/" + idUser,
				method: "GET",
				beforeSend: function (xhr) {
					loadingFormElement.show();
				}
			});

			request.always(function (xhr, status, error) {
				loading = false;
				loadingFormElement.hide();
			});

			request.done(function (xhr, status, error) {

				namaUser = xhr.data.nama_user;
				emailUser = xhr.data.email_user;
				noTelpUser = xhr.data.telepon_user;
				totalItemTransaksi = xhr.data.jumlah;

				// totalBeliTransaksi = value.data.;

				totalBayarTransaksi = xhr.data.jumlah_bayar;
				bankUser = xhr.data.bank_user;
				bankKarisma = xhr.data.bank_karisma;
				noRekUser = xhr.data.no_rek_user;
				atasNama = xhr.data.atas_nama;
				buktiTransfer = xhr.data.bukti_transfer;

				var status = parseInt(xhr.data.status);

				switch (status) {
					case 0:
						statusOrderElement.html('<span class="label label-warning">Belum Di Bayar</span>');
						confirmButtonElement.hide();
						break;
					case 1:
						statusOrderElement.html('<span class="label label-danger">Menunggu Konfirmasi</span>');
						confirmButtonElement.show();
						confirmButtonElement.html("Confirm");
						confirmButtonElement.click(function () {
							ConfirmData(xhr.data.id_transaksi, xhr.data.user_id);
						});
						break;
					case 2:
						statusOrderElement.html('<span class="label label-success">Selesai</span>');
						confirmButtonElement.hide();
						break;
				}

				pageTitleElement.html("Detail Pembelian #" + parseInt(idTransaksi).pad(8));
				namaUserElement.html(namaUser);
				emailUserElement.html(emailUser);
				noTelpUserElement.html(noTelpUser);
				totalItemTransaksiElement.html(totalItemTransaksi);
				totalBeliTransaksiElement.html(totalBeliTransaksi);
				totalBayarTransaksiElement.html(totalBayarTransaksi);
				bankUserElement.html(bankUser);
				bankKarismaElement.html(bankKarisma);
				noRekUserElement.html(noRekUser);
				atasNamaElement.html(atasNama);
				buktiTransferElement.attr("src", imgUrl + buktiTransfer);
				tanggalElement.html(xhr.data.tanggal);
				var detail = xhr.detail.data;

				var totalBeli = 0;

				$.each(detail, function (index, value) {
					var clone = cloneDataElement.clone();

					clone.addClass("data-transaksi");
					clone.prop('id', 'data' + (index + 1));
					clone.removeClass("clone-data");
					var level = "";
					var harga = "";
					if (value.level_mapel == "1") {
						level = "BASIC";
						harga = value.harga_basic;
					} else if (value.level_mapel == "2") {
						level = "SILVER";
						harga = value.harga_silver;
					} else if (value.level_mapel == "3") {
						level = "GOLD";
						harga = value.harga_gold;
					}

					clone.find(".nama-mapel").html(value.nama_mapel);
					clone.find(".level-mapel").html(level);
					clone.find(".harga-mapel").html(harga);

					totalBeli += parseInt(harga);

					if (index <= 0) {
						clone.insertAfter(cloneDataElement);
					} else {
						clone.insertAfter($('#data' + (index)));
					}
				});

				totalBeliTransaksiElement.html(totalBeli);
				totalElement.html(totalBeli);

				cloneDataElement.hide();
				$('.data-transaksi').show();
				loading = false;
				loadingDetail.hide();
				tableDateElement.show();

			});

			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				loadingFormElement.hide();
			});


		}
	};


	var ConfirmData = function (id, user_id) {

		if (!loading) {
			loading = true;

			var request = jQuery.ajax({
				url: urlConfirmApi + "/" + id + "/" + user_id,
				method: "GET",
				beforeSend: function (xhr) {
					loadingFormElement.show();
				}
			});

			request.always(function (xhr, status, error) {
				loading = false;
				loadingFormElement.hide();
			});

			request.done(function (xhr, status, error) {

				toastr["success"]("Sukses", "Berhasil Menyimpan Data");
				setTimeout(function () {
					location.reload();

				}, 1500);

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
	FormBatchLatihan.init();
});

