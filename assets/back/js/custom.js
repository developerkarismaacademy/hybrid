jQuery.ajaxSetup({
    error: function (jqXHR, textStatus, errorThrown) {
        switch (jqXHR.status) {
            case 200:
                jQuery('.error-alert').addClass("hidden");
                break;
            case 500:
                toastr['error']('Server Bermasalah', 'Terjadi Kesalahan Jaringan');
                break;
            case 403:
                toastr['warning']('', 'Anda Tidak Memiliki Akses');
                break;
            case 404:
                toastr['error']('Data Kosong', 'Data Tidak Di Temukan');
                break;
            case 401:
                toastr['error']('Sesi Anda Berkahir', '');
                $.redirect(base_url + 'logout', null, 'GET');
                break;
            case 400:
                toastr['error']('Sesi Anda Berkahir', '');
                $.redirect(base_url + 'logout', null, 'GET');
                break;
            case 422:
                jQuery('.error-alert').removeClass("hidden");
                jQuery('.error-alert-container').html("<ul class='error-list'></ul>");
                jQuery.each(jqXHR.responseJSON.form, function (index, value) {
                    jQuery('.error-list').append("<li>" + value + "</li>");
                });
                // if (jqXHR.responseJSON.image !== undefined && jqXHR.responseJSON.image.length > 0) {
                //     jQuery('.error-list').append("<li>" + jqXHR.responseJSON.image + "</li>");
                // }
                break;
        }
    }
});

Number.prototype.pad = function(size) {
    var s = String(this);
    while (s.length < (size || 2)) {s = "0" + s;}
    return s;
}

function convertToRupiah(angka) {
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for (var i = 0; i < angkarev.length; i++) if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
    return 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
}

/**
 * Usage example:
 * alert(convertToRupiah(10000000)); -> Rp. 10.000.000
 */

function convertToAngka(rupiah) {
    return parseInt(rupiah.replace(/[^0-9]/g, ''), 10);
}

/**
 * Usage example:
 * alert(convertToAngka("Rp 10.000.000")); -> 10000000
 */

jQuery(document).ajaxComplete(function () {
    $('[data-toggle="tooltip"]').tooltip();
});


$('.select2').on("select2:open", function (e) {
    $('body').addClass("select-pop-up");    
});
$('.select2').on("select2:close", function (e) {
    $('body').removeClass("select-pop-up");    
});
