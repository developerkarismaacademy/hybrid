<div class="content-page">
	<div class="content">
		<div class="container">

			<!-- start row -->

			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
						<h4 class="page-title">
							<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Daftar voucher"
							   href="<?= base_url('back/voucher') ?>">
								<i class="fa fa-arrow-left"></i>
							</a>
							<span
								title="<?= $title ?>"><?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?></span>
						</h4>
						<ol class="breadcrumb p-0 m-0">
							<li><a href="<?= base_url('back/voucher') ?>">Daftar Voucher</a></li>
							<li class="active">
								<span
									title="<?= $title ?>"><?= (strlen($title) > 18 ? substr($title, 0, 18) . "..." : $title) ?></span>
							</li>
						</ol>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<!-- end row -->

			<!-- start row -->
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-icon alert-danger alert-dismissible fade in error-alert hidden"
						 role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<div class="error-alert-container">

						</div>
					</div>
					<div class="card-box">
						<div class="loading-form">
							<i class="fa fa-spin fa-circle-o-notch fa-4x"></i>
							<br>
							<br>
							Loading Data
						</div>
						<form method="POST" id="form-voucher" enctype="multipart/form-data">
							<input type="hidden" id="id_voucher" name="id_voucher" value="<?= $id ?>"/>
							<h4 class="m-t-0 header-title"><b><?= $title ?></b></h4>
							<div class="pull-right">
								<a href="<?= base_url('back/kelas') ?>"
								   class="btn btn-danger btn-bordered waves-effect">Back
								</a>
								<button type="button" onclick="FormVoucher.reset();" class="btn btn-default btn-bordered waves-effect">Reset
								</button>
								<button type="submit"
										class="btn btn-info btn-bordered waves-effect">Simpan
								</button>
							</div>
							<div class="m-t-10 clearfix">
							<div class="m-t-10 clearfix">
								<div class="form-group">
									<label class="control-label">Kode Voucher</label>
									<input type="text" id="kode_voucher" name="kode_voucher" placeholder="Kode Voucher . . ."
										   class="form-control">
								</div>

								<div class="form-group">
									<label class="control-label">Jenis Voucher</label>
									<select class="form-control" name="jenis_voucher" id="jenis_voucher"
											data-style="btn-default">
										<option value="item">Item</option>
										<option value="pembelian" >Pembelian</option>
									</select>
								</div>

								<div class="form-group">
									<label class="control-lable">Jenis Item</label>
									<select class="form-control" 	data-style="btn-default" name="jenis_item" id="jenis_item">
										<option value="semua">Semua</option>
										<option value="kategori">Kategori</option>
										<option value="item_tertentu">Item Tertentu</option>
									</select>
								</div>

								<div class="form-group">
									<label class="control-label">Jenis Pembelian</label>
									<select class="form-control" name="jenis_pembelian" id="jenis_pembelian"
											data-style="btn-default">
										<option value="minimal">Minimal</option>
										<option value="semua" >Semua</option>
									</select>
								</div>

								<div class="form-group">
									<label class="control-label">Jenis Potongan</label>
									<select class="form-control" name="jenis_potongan" id="jenis_potongan"
											data-style="btn-default">
										<option value="persen">Persen</option>
										<option value="nominal">Nominal</option>
									</select>
								</div>

								<div class="form-group">
									<label for="control-label">Jumlah Potongan</label>
									<input type="text" id="jumlah_potongan" name="jumlah_potongan" placeholder="Jumlah Potongan . . ."
										   class="form-control">
								</div>
								
								<div class="form-group">
									<label class="control-label">Jenis Batas</label>
									<select class="form-control" name="jenis_batas" id="jenis_batas"
											data-style="btn-default">
										<option value="kuota">Kuota</option>
										<option value="waktu">Waktu</option>
									</select>
								</div>

								<div class="form-group">
									<label for="control-label">Batas Kuota</label>
									<input type="text" id="batas_kuota" name="batas_kuota" placeholder="Batas Kuota . . ."
										   class="form-control">
								</div>
								
								<div class="form-group">
									<label for="control-label">Batas Waktu</label>
                                        <input type="date"  id="batas_waktu"   class="form-control" placeholder="mm/dd/yyyy" name="batas_waktu">
								</div>

								<div class="form-group">
									<label for="">Minimal Transaksi</label>
										<input type="text" id="minimal_transaksi" class="form-control" name="minimal_transaksi" placeholder="Minimal Transaksi">
								</div>

								<div class="form-group">
									<label for="">Deskripsi Voucher</label>
									<textarea name="deskripsi_voucher" id="deskripsi_voucher" class="form-control"></textarea>
								</div>

								<div class="form-group">
									<label for="">Minimal Harga Item</label>
									<input type="text" name="minimal_harga_item" id="minimal_harga_item" class="form-control">
								</div>
								
									<input type="text" name="kategori_id" id="kategori_id" value="1" class="form-control">
									<input type="text" name="item_id"  id="item_id" value="1" class="form-control">
								
								<div class="form-group">
									<label class="control-label">Gambar Voucher</label>
									<br>
									<img src="<?= base_url() ?>/assets/back/images/no-image.jpg" id="img-gambar-voucher"
										 width="200">
									<br>
									<br>
									<input type="file" accept="image/*" class="filestyle" id="gambar_voucher"
										   name="gambar_voucher"
										   ref="file">
								</div>
								<div class="pull-right">
									<a href="<?= base_url('back/voucher') ?>"
									   class="btn btn-danger btn-bordered waves-effect">Back
									</a>
									<button type="button" onclick="FormVoucher.reset();" class="btn btn-default btn-bordered waves-effect">Reset
									</button>
									<button type="submit"
											class="btn btn-info btn-bordered waves-effect">Simpan
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- end row -->
		</div>
	</div>
</div>
<!-- container -->
