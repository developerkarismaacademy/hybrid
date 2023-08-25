
<div class="content-page">
	<div class="content">
		<div class="container">
			<form action="<?= base_url('voucher/save') ?>" method="post">
				<div class="mb-3">
					<label id="label" for="" class="form-label">Kode Voucher</label>
					<input type="text" class="form-control" id="" name="kode_voucher">
				</div>
				<div class="mb-3">
					<label for="" class="form-label">Mapel</label>
					<select class="form-select" aria-label="Default select example" name="mapel_id">
						<?php foreach ($mapel as $m) : ?>
							<option value="<?= $m->id_mapel ?>"><?= $m->nama_mapel ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<div class="mb-3">
					<label for="" class="form-label">Banyak Voucher</label>
					<input type="number" min="1" class="form-control" name="qty">
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
	</div>
</div>
<script>
	function _(el) {
		return document.getElementById(el)
	}
	_('label').innerHTML = 'Kode Voucher'
</script>
