<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function() {

    getData()

    function getData() {
      $.ajax({
        type: "GET",
        url: "<?= base_url() ?>back/Penukaran/getData",
        dataType: "json",
        async: false,
        success: function(response) {
          let html = '';
          $.map(response, function(data, index) {
            html += '<tr class="value-invoice">' +
              '<td>' + (index + 1) + '</td>' +
              '<td>' + data.user_id + '</td>' +
              '<td>' + data.coin + '</td>' +
              '<td>' + data.uang + '</td>' +
              '<td>' +
              '<select class="form-control status">' +
              '<option> ' +
              '</option>' +
              '</select>' +
              '</td>' +
              '</tr>'
          });
          $('#data-penukaran').html(html)
          $('#example').DataTable();
        }
      });
    }
  });
</script>