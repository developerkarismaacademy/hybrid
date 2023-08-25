<script src="<?= base_url(); ?>assets/back/plugins/multiselect/js/jquery.multi-select.js" type="text/javascript">
</script>
<script src="<?= base_url(); ?>assets/back/plugins/jquery-quicksearch/jquery.quicksearch.js" type="text/javascript">
</script>
<script src="<?= base_url(); ?>assets/back/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript">
</script>

<script src="<?= base_url(); ?>assets/back/plugins/custombox/custombox.min.js"></script>
<script src="<?= base_url(); ?>assets/back/plugins/custombox/custombox.legacy.min.js"></script>


<!-- <script src="<?= base_url(); ?>assets/back/pages/kelas/list.js" type="text/javascript">
</script> -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<script>
  $(document).ready(function() {
    getData()
    var table = $('#example').DataTable();

    function getData() {
      $.ajax({
        type: "GET",
        url: "<?= base_url() ?>back/invoice/getData",
        async: false,
        dataType: "json",
        success: function(response) {
          if (response.status_code == 200) {
            console.log(response);
            let html = '';
            response.data.map((data, index) => {
              html += '<tr class="value-invoice">' +
                '<td>' + (index + 1) + '</td>' +
                '<td>' + data.invoice + '</td>' +
                '<td>' + data.email + '</td>' +
                '<td>' + data.no_ponsel + '</td>' +
                '<td>' + data.partisipasi + '</td>' +
                '<td>' + data.pembelian + '</td>' +
                '<td>' + `<a href="<?= base_url('back/invoice/hapus/') ?>${data.id}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete Invoice"><i class="fa fa-trash"></i></a>` + '</td>' +
                '</tr>'
            })
            $('#invoice-data').html(html)
          }
        }
      });
    }
    $('#cek-invoice').click(function(e) {
      e.preventDefault();
      let invoice_value = $('#invoice-value').val();
      $("#myModal").css('display', 'none');
      $(".modal-backdrop").remove();
      $.ajax({
        type: "POST",
        url: "<?= base_url() ?>back/invoice/tambah",
        data: {
          inv: invoice_value
        },
        dataType: "json",
        success: function(response) {
          // console.log(response);
          response.map((data, index) => {
            if (data.success == true) {
              toastr.success(data.message)
            } else {
              toastr.error(data.message)
            }
          })
          setTimeout(function() {
            window.location.reload();
          }, 3000);
        }
      });
      $('#invoice-value').val('');
      getData()
      table.clear();
    });
  });
</script>