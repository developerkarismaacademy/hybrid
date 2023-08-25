AOS.init();

$(function () {
	$('[data-toggle="tooltip"]').tooltip();

	//Footer short
	// shortContent();
	// $(window).resize(function() {
	//     shortContent();
	// });

});

$(document).scroll(function () {
	if ($(window).scrollTop() > 100) {
		$(".top-header").addClass("fixed-top");
	} else {
		$(".top-header").removeClass("fixed-top");
	}
});


function readMore(e = "", id = ""){
	if ($(e).text() == 'Baca selengkapnya') {
		$(e).text('Sembunyikan');
	} else {
		$(e).text('Baca selengkapnya');
	}
	if ($("#deskripsi"+id).text().length <= 200 + 3) {
		$("#deskripsi"+id).html($("#deskripsi"+id).attr("data-long"));
	} else {
		$("#deskripsi"+id).html($("#deskripsi"+id).attr("data-long").substring(0,200) + "...");
	}

}
