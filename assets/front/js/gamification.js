$(document).ready(function () {
	panel = $(".panel").css("width");
	let width = panel.replace("px", "");
	let i = 0;
	$(".custom-tabs .nav-item").each(function () {
		i++;
	});
	let val1 = width / i + 10;
	let val2 = val1 / i / 3 + 2;
	let px = $(".custom-tabs .nav-item:nth-child(1)").css("width");
	$(".panel").css("width", px);
	$(".custom-tabs .nav-item:nth-child(1)").on("click", function () {
		px = $(".custom-tabs .nav-item:nth-child(1)").css("width");
		$(".panel").css("width", px);
		$(".panel").animate({
			left: "0px",
		});
	});
	$(".custom-tabs .nav-item:nth-child(2)").on("click", function () {
		px = $(".custom-tabs .nav-item:nth-child(2)").css("width");
		$(".panel").css("width", px);
		$(".panel").animate({
			left: val1 + "px",
		});
	});
	$(".custom-tabs .nav-item:nth-child(3)").on("click", function () {
		px = $(".custom-tabs .nav-item:nth-child(3)").css("width");
		$(".panel").css("width", px);
		$(".panel").animate({
			left: val1 + val1 + val1 / 6 + "px",
		});
	});

	i = 0;
	$(".custom-tabs > .nav-link").each(function () {
		$(this).hover(
			function () {
				$(this).addClass("hover");
			},
			function () {
				$(this).removeClass("hover");
			}
		);
	});
	$(".btn-tukar").click(function () {
		var dataUang = parseInt(
			$(this)
				.closest(".tukar")
				.find("h1.uang")
				.text()
				.replace("Rp", "")
				.replace(".", "")
		);
		var dataValue = parseInt(
			$(this).closest(".tukar").find(".btn-tukar").text()
		);

		$.ajax({
			type: "post",
			url: BASE_URL + "front-v2/Gamification/tukar",
			data: {
				coin: dataValue,
				uang: dataUang,
			},
			dataType: "json",
			success: function (response) {
				console.log(response);
				if (response.status == true) {
					toastr.success(response.message);
					setTimeout(function () {
						window.location.reload();
					}, 3000);
				} else {
					toastr.error(response.message);
				}
			},
		});
	});
});
