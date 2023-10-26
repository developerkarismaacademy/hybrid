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
							<span
								title="<?= $title ?>"><?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?>
							</span>
						</h4>
						<ol class="breadcrumb p-0 m-0">
							<li>
								<a title="Daftar Mata Pelajaran <?= $kelas['nama_kelas'] ?>"
								   href="<?= base_url('back/mapel/' . $kelas['meta_link_kelas']) ?>">
									<?= (strlen("Daftar Mata Pelajaran" . $kelas['nama_kelas']) > 18 ? substr("Daftar Mata Pelajaran " . $kelas['nama_kelas'], 0, 18) . "..." : "Daftar Mata Pelajaran " . $kelas['nama_kelas']) ?>
								</a>
							</li>
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
			<input type="hidden" id="idKelas" value="<?= $kelas['id_kelas'] ?>">
			<input type="hidden" id="idMapel" value="<?= $mapel['id_mapel'] ?>">
			<input type="hidden" id="metaMapel" value="<?= $mapel['meta_link_mapel'] ?>">

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
						<h4 class="m-t-0 header-title"><b>
								<?= $title ?>
							</b>
							<button type="button" class="btn btn-info btn-sm" data-toggle="modal"
									data-target="#myModal">Export
							</button>
						</h4>
						<!-- Modal -->
						<div id="myModal" class="modal fade" style="margin-top:100px !important" role="dialog">
							<form action="<?= base_url('back/export/') . $meta_mapel ?>" method="post">
								<div class="modal-dialog ">
									<!-- Modal content-->
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Filter</h4>
										</div>
										<div class="modal-body">
											<div style="margin-bottom:20px">
												<label for="">Tanggal Mulai</label>
												<input type="date" class="form-control" name="tanggal_mulai"
													   value="2023-01-01">
											</div>
											<div style="margin-bottom:20px">
												<label for="">Tanggal Akhir</label>
												<input type="date" class="form-control" name="tanggal_akhir"
													   value="<?= date('Y-m-d') ?>">
											</div>
											<div style="margin-bottom:20px">
												<label for="">Total Data</label>
												<select name="total_data" class="form-control">
													<option value="50">50</option>
													<option value="100">100</option>
													<option value="200">200</option>
													<option value="500">500</option>
													<option value="1000">1000</option>
													<option value="1500">1500</option>
													<option value="2000">2000</option>
												</select>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close
											</button>
											<button type="submit" class="btn btn-primary">Export</button>
										</div>
									</div>

								</div>
							</form>
						</div>
						<table id="siswa-data" class="display" style="width:100%;">
							<thead>
							<tr>
								<th>Invoice</th>
								<th>Nama</th>
								<th>Email</th>
								<th>No Telepon</th>
								<th>Tanggal Pembelian</th>
								<th>Redeem Code</th>
								<th>Kode Voucher</th>
								<th>Tanggal Redeem</th>
								<th>Progress</th>
								<th>Tanggal Pengerjaan</th>
								<th>Pretest</th>
								<th>PostTest</th>
								<th>Sertifikat</th>
								<th>Unjuk Ketrampilan</th>
							</tr>
							</thead>
							<tbody>
							<?php
							foreach ($siswa as $siswaData) :
								$metaLinkMapel = $siswaData['meta_link_mapel'];
								$userId = $siswaData['id_user'];
								$tugas = $this->db->query("SELECT log_praktek.file,log_praktek.tipe,materi.id_materi FROM materi JOIN (SELECT bab.id_bab FROM mapel JOIN bab ON mapel.id_mapel = bab.mapel_id JOIN (SELECT MAX(bab.urutan_bab) AS urutan FROM mapel JOIN bab ON mapel.id_mapel = bab.mapel_id WHERE mapel.meta_link_mapel = '$metaLinkMapel') t1 ON bab.urutan_bab = t1.urutan WHERE mapel.meta_link_mapel = '$metaLinkMapel') t1 ON t1.id_bab = materi.bab_id JOIN log_praktek ON log_praktek.materi_id = materi.id_materi WHERE log_praktek.user_id = $userId")->result_array();

								?>
								<tr>
									<td>
										<?= invoice($siswaData['id_transaksi']) ?>
									</td>
									<td>
										<?= $siswaData['nama_user'] ?>
									</td>
									<td>
										<?= $siswaData['email_user'] ?>
									</td>
									<td>
										<?= $siswaData['telepon_user'] ?>
									</td>
									<td>
										<?= $siswaData['tanggal_pembelian'] ?>
									</td>
									<td>
										<?= $siswaData['redeem_code'] ?? '-' ?>
									</td>
									<td>
										<?= $siswaData['kode_voucher'] ?? '-' ?>
									</td>
									<td>
										<?= ($siswaData['tanggal_redeem']) ? date("Y-m-d H:i:s", $siswaData['tanggal_redeem']) : '-' ?>
									</td>
									<td>
										<?= $siswaData['progress'] ?? '-' ?>
									</td>
									<td>
										<?= $siswaData['tanggal_pengerjaan'] ?? '-' ?>
									</td>
									<td>
										<?= $siswaData['pretest'] ?? '-' ?>
									</td>
									<td>
										<?= $siswaData['posttest'] ?? '-' ?>
									</td>
									<td><?= $siswaData['progress'] == 100 ? '<a href="' . base_url('download-sertifikat/' . $siswaData['meta_link_mapel'] . '/' . $userId) . '" class="badge badge-secondary">Sertifikat</a>' : '-' ?></td>
									<td>
										<?php if (count($tugas) > 0): ?>
											<button type="button" class="btn btn-info btn-lg" data-toggle="modal"
													data-target="#tugasModal<?= $userId ?>">Tugas
											</button>
										<?php else: ?>
											-
										<?php endif; ?>
									</td>
								</tr>
								<div id="tugasModal<?= $userId ?>" style="margin-top:100px !important"
									 class="modal fade" role="dialog">
									<div class="modal-dialog">

										<!-- Modal content-->
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;
												</button>
												<h4 class="modal-title">Tugas</h4>
											</div>
											<div class="modal-body">
												<?php foreach ($tugas as $item): ?>
													<?php
													if ($item["tipe"] == "link") {
														$file = $item["file"];
														$link = $file;
													} else {
														$link = base_url() . "upload/praktek/" . $userId . "/" . $item["id_materi"] . "/" . $item["file"];
														$file = strtolower(getFileExtension($item["file"]));
														$file = array_key_exists($file, knownType) ? knownType[$file] : 'EKSTENSI TIDAK DI KETAHUI';
														$file = "FILE " . $file;
													}
													?>
													<p><a target="_blank" href="<?= $link ?>"><?= $file ?></a></p>
												<?php endforeach; ?>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">
													Close
												</button>
											</div>
										</div>

									</div>
								</div>
							<?php
							endforeach;
							?>
							</tbody>
						</table>

					</div>
				</div>
			</div>
			<!-- end row -->
		</div>
	</div>
</div>
<!-- container -->
