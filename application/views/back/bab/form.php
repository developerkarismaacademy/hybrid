<transition name="slide-fade">
	<div class="form-pop-up " style="display: none;" id="form-mapel">
		<div v-if="loadingForm" class="loading text-center">
			<i class="fa fa-spin fa-circle-o-notch fa-4x"></i>
			<br>
			<br>
			Loading Data
		</div>
		<div class="panel panel-default">
			<div class="">
				<div class="panel-heading" style="">
					<h3 class="header-title panel-title pull-left"><b>Form mapel</b></h3>
					<button v-on:click="toggleForm('')" type="button" class="close pull-right" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="clearfix"></div>
				</div>
				<form method="POST" action="">
					<div class="panel-body">
						<div class="slimscroller">
							<div class="alert alert-icon alert-danger alert-dismissible fade in error-alert hidden"
								 role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
								<i class="mdi mdi-block-helper"></i>
								<div class="error-alert-container">

								</div>
							</div>
							<div class="form-group">
								<label>Nama mapel</label>
								<input type="text" v-model="form.nama_mapel" placeholder="Nama mapel . . ."
									   class="form-control">
							</div>
							<div class="form-group">
								<label>Kelas</label>
								<select id="kelasSelect" v-model="form.id_kelas" class="selectpicker"
										@change="setSelected"
										data-style="btn-default" data-live-search="true">

								</select>
							</div>


							<div class="form-group">
								<label class="control-label">Deskripsi mapel</label>
								<ckeditor :editor="editor" v-model="form.deskripi_mapel"></ckeditor>
							</div>
							<div class="form-group">
								<label class="control-label">Gambar mapel</label>
								<input type="file" accept="image/*" class="filestyle" id="file" name="file" ref="file">
							</div>
							<div class="form-group">
								<table class="table m-0 table-colored-bordered table-bordered-teal">
									<thead>
									<tr>
										<th colspan="3" class="text-center">Harga</th>
									</tr>
									</thead>
									<tbody>
									<tr>
										<td>
											<label>Harga Basic</label>
											<input type="text" v-model="form.harga_basic"
												   placeholder="Harga Basic . . ."
												   class="form-control">
										</td>
										<td>
											<label>Harga Silver</label>
											<input type="text" v-model="form.harga_basic"
												   placeholder="Harga Silver . . ."
												   class="form-control">
										</td>
										<td>
											<label>Harga Gold</label>
											<input type="text" v-model="form.harga_basic" placeholder="Harga Gold . . ."
												   class="form-control">
										</td>

									</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<div class="row">
							<div class="col-md-6 col-xs-6">
								Kolom bertanda <span class="text-danger">*</span> <b>Wajib Diisi</b>
							</div>
							<div class="col-md-6 col-xs-6 text-right">
								<button type="button" class="btn btn-danger btn-bordered waves-effect"
										v-on:click="toggleForm('')">Batal
								</button>
								<button type="button" v-on:click="save()"
										class="btn btn-info btn-bordered waves-effect">Simpan
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</transition>

<script type="text/x-template" id="select2-template">
	<select>
		<slot></slot>
	</select>
</script>
