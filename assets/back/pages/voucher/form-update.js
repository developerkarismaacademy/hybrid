var FormVoucher = function () {

	//INIT LOADING
	var loading = false;
	var loadingFormElement = $('.loading-form');
	var id = $('#id_voucher').val();

	//INIT FORM
	var formVoucherElement = $('#form-voucher');
	var kodeVoucherElement = $("#kode_voucher");
	var jenisVoucherElement = $('#jenis_voucher');
	var jenisItemElement = $('#jenis_item');
	var jenisPembelianElement = $('#jenis_pembelian');
	var jenisPotonganElement = $('#jenis_potongan');
	var jumlahPotonganElement = $('#jumlah_potongan');
	var jenisBatasElement = $('#jenis_batas');
	var batasKuotaElement = $('#batas_kuota');
	var batasWaktuElement = $('#batas_waktu');
	var minimalTransaksiElement = $('#minimal_transaksi');
	var deskripsiVoucherElement = $('#deskripsi_voucher');
	var minHargaItemElement = $('#minimal_harga_item');
	var kategoriIdElement = $('#kategori_id');
	var itemId = $('#itemId');

	var bannerVoucherElement = $('#gambar_voucher');
	var imgBannerVoucherElement = $('#img-gambar-voucher');
	var urlSimpanApi = base_url_api + "/VoucherApi/update";
	var urlDetailApi = base_url_api + "/VoucherApi/detail/";

	var kodeVoucher, nama, basic, gold;
	var initValidation = function () {
		formVoucherElement.validate({
			errorClass: 'validation-message text-danger',
			errorElement: 'div',
			ignore: [],
			errorPlacement: function (error, e) {
				jQuery(e).parents('.form-group').append(error);
			},
			highlight: function (e) {
				jQuery(e).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			success: function (e) {
				jQuery(e).closest('.form-group').removeClass('has-error').addClass('has-success');
				jQuery(e).remove();
			},
			rules: {
				'Kode Voucher': {
					required: true,
				}
			},
			messages: {
				'Kode Voucher': {
					required: '=Kode Voucher Harus Di Isi',
				}
			}
		});
	};


	formVoucherElement.submit(function (event) {
		event.preventDefault();
		for (instance in CKEDITOR.instances) {
			CKEDITOR.instances['deskripsi'].updateElement();
		}

		var valid = formVoucherElement.valid();

		if (!loading) {
			loading = true;
			if (valid) {
				loadingFormElement.show();

				var formData = new FormData(formVoucherElement[0]);
				var request = $.ajax({
					url: urlSimpanApi,
					data: formData,
					type: 'POST',
					contentType: false,
					processData: false
				});

				request.done(function (xhr, status, error) {
					if (xhr.success) {
						toastr["success"]("Sukses", "Berhasil Menyimpan Data");
						setTimeout(function () {
							$.redirect(base_url + 'back/voucher', null, 'GET');
						}, 1500);
					} else {
						toastr["error"]("Gagal", "Gagal Menyimpan Data");
					}
				});

				request.always(function (xhr, status, error) {
					loading = false;
					loadingFormElement.hide();
				});

				request.fail(function (xhr, status, error) {

					$('.validation-message').remove();
					var errorForm = [];

					if (xhr.status == 422) {
						var result = xhr.responseJSON;

						$.each(result.form, function (index, value) {
							errorForm.push(index);
							var e = $("#" + index);
							$(e).parents('.form-group').removeClass('has-success').addClass('has-error');
							var error = "<div class='validation-message text-danger'><i class=\"fa fa-close\"></i> " + value + "</div>";
							$(e).parents('.form-group').append(error);
						});

					}

					for (var pair of formData.entries()) {
						if (errorForm.indexOf(pair[0]) == -1) {
							$("#" + pair[0] + " + .form-control-feedback").remove();
							var e = $("#" + pair[0]);
							$(e).parents('.form-group').addClass('has-success').removeClass('has-error');
							var error = "<div class='validation-message text-success'><i class=\"fa fa-check\"></i> Valid</div>";
							$(e).parents('.form-group').append(error);
						}
					}

					if (xhr.status != 422) {
						if (!xhr.success) {
							toastr['error']('Server Error', xhr.message);
						} else {
							toastr['error']('Server Bermasalah', 'Terjadi Kesalahan Jaringan');
						}
					}

				});

			} else {
				loading = false;
			}
		}

	});

	bannerVoucherElement.change(function () {
		bannerVoucherChange(this);
	});

	var bannerVoucherChange = function (input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				imgBannerVoucherElement.attr('src', e.target.result);
			};
			reader.readAsDataURL(input.files[0]);
		}
	}
	var detailOpen = function () {

		if (!loading) {
			loading = true;

			var request = jQuery.ajax({
				url: urlDetailApi + id,
				method: "GET",
				beforeSend: function (xhr) {
					loadingFormElement.show();
				}
			});

			request.always(function (xhr, status, error) {
				loading = false;
				loadingFormElement.hide();

				// 	CKEDITOR.replace('deskripsi');
				// //	deskripsiPaketElement.html(deskripsi);
				// 	CKEDITOR.instances['deskripsi'].setData(deskripsi);
			});

			request.done(function (xhr, status, error) {
				kodeVoucher = xhr.data.kode_voucher;

				var tanggal = xhr.data.batas_waktu.split(" ");

				kodeVoucherElement.val(xhr.data.kode_voucher);
				jenisVoucherElement.val(xhr.data.jenis_voucher);
				jenisItemElement.val(xhr.data.jenis_item);
				jenisPembelianElement.val(xhr.data.jenis_pembelian);
				jenisPotonganElement.val(xhr.data.jenis_potongan);
				jumlahPotonganElement.val(xhr.data.jumlah_potongan);
				jenisBatasElement.val(xhr.data.jenis_batas);
				batasKuotaElement.val(xhr.data.batas_kuota);

				batasWaktuElement.val(tanggal[0]);

				minimalTransaksiElement.val(xhr.data.minimal_transaksi);
				deskripsiVoucherElement.val(xhr.data.deskripsi_voucher);
				minHargaItemElement.val(xhr.data.minimal_harga_item);
				kategoriIdElement.val(xhr.data.kategori_id);
				itemId.val(xhr.data.itemId);

				if (xhr.data.gambar_voucher != "") {
					//	console.log("nama file : " + xhr.data.gambar_voucher);
					imgBannerVoucherElement.attr('src', base_url + "/upload/voucher/" + xhr.data.gambar_voucher);
				} else {
					imgBannerVoucherElement.attr('src', base_url + "/assets/back/images/no-image.jpg")
				}


			});

			request.fail(function (jqXHR, textStatus) {
				loading = false;
				toastr["error"]("Terjadi Kesalahan");
				loadingFormElement.hide();
			});


		}
	};

	var resetForm = function () {
		initValidation();
		formVoucherElement[0].reset();
		kodeVoucherElement.val(kodeVoucher);
		// deskripsiPaketElement.html(deskripsi);
		// CKEDITOR.instances['deskripsi'].setData(deskripsi);
	};


	return {
		init: function () {
			//CKEDITOR.replace('deskripsi');
			$('.selectpicker').selectpicker();
			$(":file").filestyle({input: false});
			initValidation();
			loadingFormElement.show();
			detailOpen();
		},
		reset: function () {
			resetForm();
		}
	}

}();

// Initialize when page loads
jQuery(function () {
	FormVoucher.init();
});

