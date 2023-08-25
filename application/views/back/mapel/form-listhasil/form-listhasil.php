<div class="content-page">
	<div class="content">
		<div class="container">

			<!-- start row -->

			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
                    <h4 class="page-title">
							<a data-toggle="tooltip" data-placement="top" title=""
							   data-original-title="Daftar Mata Pelajaran <?= $kelas['nama_kelas'] ?>"
							   href="<?= base_url('back/mapel/' . $kelas['meta_link_kelas']) ?>">
								<i class="fa fa-arrow-left"></i>
							</a>
							<span title="<?= $title ?>"><?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?>
							</span>
						</h4>
						<ol class="breadcrumb p-0 m-0">
							<li>
								<a title="Daftar Mata Pelajaran <?= $kelas['nama_kelas'] ?>"
								   href="<?= base_url('back/mapel/' . $kelas['meta_link_kelas']) ?>">
									<?= (strlen("Daftar Mata Pelajaran " . $kelas['nama_kelas']) > 16 ? substr("Daftar Mata Pelajaran " . $kelas['nama_kelas'], 0, 16) . "..." : "Daftar Mata Pelajaran " . $kelas['nama_kelas']) ?>
								</a>
							</li>
							<li class="active">
								<span title="<?= $title ?>"><?= (strlen($title) > 18 ? substr($title, 0, 18) . "..." : $title) ?></span>
							</li>
						</ol>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<!-- end row -->

			<input type="hidden" id="idMapel" value="<?= $mapel['id_mapel'] ?>">
			<input type="hidden" id="metaMapel" value="<?= $mapel['meta_link_mapel'] ?>">
			<input type="hidden" id="metaKelas" value="<?= $kelas['meta_link_kelas'] ?>">

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
                        <div class="form-group">
                            <label class="control-label">Tambah List Hasil</label>
                            <div class="row no-gutter">
								<div class="col-md-6">
                                	<input class="form-control" type="text" name="tambah" id="tambah" placeholder="Tambah List Hasil" maxlength=100>
								</div>
								<div class="col-md-6">
                                    <button class="btn btn-success" type="button" id="btn-tambah"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>

						<form id="form-urutan" method="post">
							<div class="pull-right">
								<a href="<?= base_url('back/mapel/' . $kelas['meta_link_kelas']) ?>"
								   class="btn btn-danger btn-bordered waves-effect">Back
								</a>

								<button type="submit"
										class="btn btn-info btn-bordered waves-effect">Simpan
								</button>
							</div>
							<div class="m-t-10 clearfix">
								<div class="custom-dd-empty dd" id="mapel-listhasil">
									<ol class="dd-list">
										<?php 
										if(isset($listhasil)){
											foreach ($listhasil as $key => $value) { ?>
												<li class="dd-item dd3-item item-list" data-id="<?= $value['id_mapel_listhasil'] ?>" data-deskripsi="<?= $value['deskripsi_mapel_listhasil'] ?>">
													<div class="dd-handle dd3-handle"></div>
													<div class="dd3-content">
														<?= $value['deskripsi_mapel_listhasil'] ?>
														<span class="pull-right text-danger fa fa-trash"  onclick="hapusAction($(this))"></span>
													</div>
												</li>
										<?php }
										}
										?>
									</ol>
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
