<script src="<?= base_url(); ?>assets/back/plugins/multiselect/js/jquery.multi-select.js" type="text/javascript">
</script>
<script src="<?= base_url(); ?>assets/back/plugins/jquery-quicksearch/jquery.quicksearch.js" type="text/javascript">
</script>
<script src="<?= base_url(); ?>assets/back/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript">
</script>

<script src="<?= base_url(); ?>assets/back/plugins/custombox/custombox.min.js"></script>
<script src="<?= base_url(); ?>assets/back/plugins/custombox/custombox.legacy.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $('#submit-import').click(function(e) {
    e.preventDefault();
    var form = new FormData($("#form-import")[0]);
    $.ajax({
      url: "<?= base_url() ?>back/invoice/import",
      method: "POST",
      dataType: 'json',
      data: form,
      processData: false,
      contentType: false,
      success: function(response) {
        response.map((data, index) => {
          if (data.success == true) {
            toastr.success(data.message)
          } else {
            toastr.error(data.message)
          }
        })
        setTimeout(function() {
          window.location.href = "<?= base_url() ?>back/invoice";
        }, 3000);
      }
    });
  });
  $(document).ready(function() {
    var $disabledResults = $(".js-example-disabled-results");
    $disabledResults.select2();
  });
</script>