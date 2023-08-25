<div class="content-page">
	<div class="content">
		<div class="container">

			<!-- start row -->

			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
						<h4 class="page-title">
							<a data-toggle="tooltip" data-placement="top" title="Daftar Pembelian"
							   href="<?= base_url('back/instruktur') ?>"
							   data-original-title="Daftar Instruktur">
								<i class="fa fa-arrow-left"></i>
							</a>
							<span
									title="<?= $title ?>"><?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?>
							</span>
						</h4>
						<ol class="breadcrumb p-0 m-0">
							<li>
								<a title="Daftar Instruktur"
								   href="<?= base_url('back/instruktur') ?>">
									Daftar Instruktur
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

			<input type="hidden" id="id" value="<?= $id ?>">
			<input type="hidden" id="idUser" value="<?= $id_user ?>">

			<!-- start row -->
			<div class="row">
				<div class="col-sm-12">
					<div class="card-box">
						<h4 class="m-t-0 header-title"><b>Data Instruktur</b></h4>
						<table class="table table-bordered m-0">
							<colgroup>
								<col class="col-sm-4">
								<col class="col-sm-8">
							</colgroup>
							<tbody>
							<tr>
								<td>Nama</td>
								<td id="nama-user"><?= $instruktur["nama_user"] ?></td>
							</tr>
							<tr>
								<td>Username</td>
								<td id="username-user"><?= $instruktur["username"] ?></td>
							</tr>
							<tr>
								<td>Email</td>
								<td id="email-user"><?= $instruktur["email_user"] ?></td>
							</tr>
							<!-- <tr>
								<td>No. TELP</td>
								<td id="no-telp-user"><?= $instruktur["telepon_user"] ?></td>
							</tr>
							<tr>
								<td>Alamat</td>
								<td id="alamat-user"><?= $instruktur["alamat_user"] ?></td>
							</tr> -->
							<tr>
								<td>TTL</td>
								<td id="ttl-user">
									<?= $instruktur["tempat_lahir"] ?>
									, <?= formatTanggal2($instruktur["tanggal_lahir"]) ?>
								</td>
							</tr>
							<tr>
								<td>Jenis Kelamin</td>
								<td id="ttl-user"><?= $instruktur["jk_user"] ?></td>
							</tr>
							<tr>
								<td>Biodata</td>
								<td><?= $instruktur["biodata"] ?></td>
							</tr>
							<tr>
								<td>Foto</td>
								<td id="foto-user">
									<img height="150"
										 src="<?= is_file_return('user', base_url('/upload/instruktur/' . $instruktur["gambar_user"])) ?>"/>
								</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>

			</div>

			<div class="row">

				<?php
				if ($mapel["total"] > 0) {
					foreach ($mapel["data"] as $keyMapel => $valueMapel) {
						?>
						<div class="col-md-3">
							<div class="card-box">
								<img style="width: 100%;"
									 src="<?= base_url() ?>/upload/mapel/<?= $valueMapel["gambar_mapel"] ?>"/>
								<div style="width: 100%;text-align: center;">
									<h4><?= $valueMapel["nama_mapel"] ?></h4>
								</div>
							</div>
						</div>

						<?php
					}
				}
				?>

			</div>

			<!-- end row -->
		</div>
	</div>
</div>
