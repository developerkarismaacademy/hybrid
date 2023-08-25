<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
		var $disabledResults = $(".js-example-disabled-results");
		$disabledResults.select2();
		let mapel2 = $("#mapel-2");
		mapel2.select2();
        $('#example').DataTable({
            processing: true
        });
    });
</script>
