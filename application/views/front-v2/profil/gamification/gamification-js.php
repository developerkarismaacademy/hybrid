<script>

  $(document).ready(function () {
    $(".btn-tukar").click(function () {
      var dataUang = $(this).closest(".tukar").find("h5.uang").attr("data-uang");
      var dataValue = $(this).closest(".tukar").find(".btn-tukar").attr("data-coin");

      $.ajax({
        type: "post",
        url: "<?= base_url() ?>front-v2/Gamification/tukar",
        data: {
          coin: dataValue,
          uang: dataUang
        },
        dataType: "json",
        success: function (response) {
          console.log(response);
          if (response.status == true) {

            toastr.success(response.message)
            setTimeout(function () {
              window.location.reload();
            }, 3000);
          } else {

            toastr.error(response.message)
          }
        }
      });
    });
  });
</script>