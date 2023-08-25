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
            src: intro_video,
            provider: 'youtube',
            size: 720,
        },
        {
            src: intro_video,
            provider: 'youtube',
            size: 1080,
        },
    ],
});

var marginBottom = $("#harga").height() - $("nav.navbar").height();
$("body").css("margin-bottom", marginBottom + 70);
$(window).resize(function () {
    $("body").css("margin-bottom", marginBottom + 70);
});


$("#parent-materi-kelas-list [id^=collapse-]").on('hidden.bs.collapse', function () {
    id = $(this).attr("id");
    $("i[aria-controls='" + id + "'").removeClass("fa-chevron-down").addClass("fa-chevron-right");
})
$("#parent-materi-kelas-list [id^=collapse-]").on('show.bs.collapse', function () {
    id = $(this).attr("id");
    $("i[aria-controls='" + id + "'").removeClass("fa-chevron-right").addClass("fa-chevron-down");
});

$('#vidModal').on('shown.bs.modal', function (e) {
    player.play();
})
$('#vidModal').on('hidden.bs.modal', function (e) {
    player.pause();
})

var urlUlasanAPI = base_url + "data-ulasan-mapel/" +  meta_link_mapel;
var loading = false;
var dataUlasan = [];
var totalData = 0;
var totalDataInPage = 0;
var totalPage = 0;
var cloneDataElement = $('#clone-data');
var tableDateElement = $('#ulasan-container');
var page = 1;
var limit = 5;
var sort = "top";

var btnPagePreviousElement = $('#btn-page-previous');
var btnPageCloneElement = $('#btn-page');
var btnPageNextElement = $('#btn-page-next');
var pagingContainerElement = $('#pagination-ulasan');
var pagingDetailElement = $('#paging-detail');

var requestUlasan = function (url) {
    if (!loading) {
        loading = true;
        url = url + "?page=" + page;
        url = url + "&limit=" + limit;
        url = url + "&sort=" + sort;

        var request = jQuery.ajax({
            url: url,
            method: "GET",
            beforeSend: function (xhr) {
                tableDateElement.css("min-height", "200px");
                startLoadingElement("#ulasan-container");
            }
        });

        request.always(function (xhr, status, error) {
        });

        request.done(function (xhr, status, error) {
            dataUlasan = xhr.data;
            totalData = xhr.total;
            totalDataInPage = xhr.total_in_page;
            totalPage = xhr.total_page;
            totalData = xhr.total;
            setUpPagination(xhr);
            updateListUlasan();
        });

        request.fail(function (jqXHR, textStatus) {
            loading = false;
            toastr["error"]("Terjadi Kesalahan");
            stopLoadingElement("#ulasan-container");
        });


    }
};


var updateListUlasan = function () {
    $('.data-ulasan').remove();
    $.each(dataUlasan, function (index, value) {
        var clone = cloneDataElement.clone();

        clone.addClass("data-ulasan");
        clone.prop('id', 'data' + (index + 1));
        clone.removeClass("clone-data");
        clone.removeClass("d-none");

        clone.find('.user-image').attr("src", base_url + "upload/profile-picture/" + value.gambar_user);
        clone.find('.user-nama').html(value.nama_user);


        clone.find('.isi-ulasan').html(value.ulasan);
        clone.find('.stars-active').css("width", ((parseInt(value.rating) + 0.05) / 5 * 100) + "%");

        if (value.pretest_status == 1) {
            clone.find('.status-ulasan').html('<span class="label label-info">Pretest</span>');
        } else {
            clone.find('.status-ulasan').html('<span class="label label-primary">Premium</span>');
        }


        if (index <= 0) {
            clone.insertAfter(cloneDataElement);
        } else {
            clone.insertAfter($('#data' + (index)));
        }
    });
    $('.data-ulasan').show();
    loading = false;
    stopLoadingElement("#ulasan-container");
};

var setUpPagination = function (data) {
    //PAGING START

    page = parseInt(data.current_page);
    if ((page - 1) <= 0) {
        btnPagePreviousElement.find('.page-link').prop('href', 'javascript:;');
        btnPagePreviousElement.addClass('disabled');
    } else {
        btnPagePreviousElement.find('.page-link').prop('href', 'javascript:changePage(' + (page - 1) + ')');
        btnPagePreviousElement.removeClass('disabled');
    }

    if ((page + 1) > totalPage) {
        btnPageNextElement.find('.page-link').prop('href', 'javascript:;');
        btnPageNextElement.addClass('disabled');
    } else {
        btnPageNextElement.find('.page-link').prop('href', 'javascript:changePage(' + (page + 1) + ')');
        btnPageNextElement.removeClass('disabled');
    }

    $('.page-number-dinamis').remove();

    var start = page - 1;

    if (totalPage < 6) {
        start = 2;
    } else if (page < 3) {
        start = 2;
    } else if (page > totalPage - 3) {
        start = totalPage - 3;
    } else {
        start = page - 1;
    }

    //page number 1
    var cloneBtnPage = btnPageCloneElement.clone();

    cloneBtnPage.removeClass("d-none");
    cloneBtnPage.addClass("page-number-dinamis");
    cloneBtnPage.prop('id', 'page-number-1');

    cloneBtnPage.find('.page-link').html('1');
    if (page == 1) {
        cloneBtnPage.find('.page-link').prop('href', 'javascript:;');
        cloneBtnPage.addClass('active');

    } else {
        cloneBtnPage.find('.page-link').prop('href', 'javascript:changePage(1)');
        cloneBtnPage.removeClass('disabled');
        cloneBtnPage.removeClass('active');
    }

    cloneBtnPage.insertAfter(btnPageCloneElement);


    if (start > 2) {
        cloneBtnPage = btnPageCloneElement.clone();

        cloneBtnPage.removeClass("d-none");
        cloneBtnPage.addClass("page-number-dinamis");
        cloneBtnPage.prop('id', 'page-number--1');
        cloneBtnPage.find('.page-link').html('...');
        cloneBtnPage.addClass('disabled');
        cloneBtnPage.find('.page-link').prop('href', 'javascript:;');
        cloneBtnPage.addClass('active');

        cloneBtnPage.insertAfter($('#page-number-1'));

    }
    var akhir = page;

    for (var i = start; i < totalPage; i++) {
        cloneBtnPage = btnPageCloneElement.clone();

        cloneBtnPage.removeClass("d-none");
        cloneBtnPage.addClass("page-number-dinamis");
        cloneBtnPage.prop('id', 'page-number-' + i);

        cloneBtnPage.find('.page-link').html(i);
        if (page == i) {
            cloneBtnPage.find('.page-link').prop('href', 'javascript:;');
            cloneBtnPage.addClass('active');

        } else {
            cloneBtnPage.find('.page-link').prop('href', 'javascript:changePage(' + i + ')');
            cloneBtnPage.removeClass('disabled');
            cloneBtnPage.removeClass('active');
        }

        if (start > 2 && i == start) {
            cloneBtnPage.insertAfter($('#page-number--1'));
        } else {
            cloneBtnPage.insertAfter($('#page-number-' + (i - 1)));
        }

        akhir = i;
        if (i > (start + 1)) {
            break;
        }
    }

    if (start < (totalPage - 3)) {
        cloneBtnPage = btnPageCloneElement.clone();

        cloneBtnPage.removeClass("d-none");
        cloneBtnPage.addClass("page-number-dinamis");
        cloneBtnPage.prop('id', 'page-number--2');
        cloneBtnPage.find('.page-link').html('...');
        cloneBtnPage.addClass('disabled');
        cloneBtnPage.find('.page-link').prop('href', 'javascript:;');
        cloneBtnPage.addClass('active');

        cloneBtnPage.insertAfter($('#page-number-' + akhir));
    }

    if (totalPage > 1) {
        cloneBtnPage = btnPageCloneElement.clone();

        cloneBtnPage.removeClass("d-none");
        cloneBtnPage.addClass("page-number-dinamis");
        cloneBtnPage.prop('id', 'page-number-' + totalPage);

        cloneBtnPage.find('.page-link').html(totalPage);
        if (page == totalPage) {
            cloneBtnPage.find('.page-link').prop('href', 'javascript:;');
            cloneBtnPage.addClass('active');
        } else {
            cloneBtnPage.find('.page-link').prop('href', 'javascript:changePage(' + totalPage + ')');
            cloneBtnPage.removeClass('disabled');
            cloneBtnPage.removeClass('active');
        }
        cloneBtnPage.insertBefore(btnPageNextElement);
    }

    pagingDetailElement.html("Menampilkan  (<span class='font-weight-bold'>" + (data.start + 1) + "</span> - <span class='font-weight-bold'>" + data.end + "</span> Dari <span class='font-weight-bold'>" + totalData + "</span> Data) " +
        "<br> Halaman <span class='font-weight-bold'>" + page + "</span> , Total <span class='font-weight-bold'>" + totalPage + "</span> Halaman");

};

requestUlasan(urlUlasanAPI);

function changePage(i) {
    page = i;
    requestUlasan(urlUlasanAPI);
}

function changeSort(i) {
    sort = i;
    page = 1;
    requestUlasan(urlUlasanAPI);
}
