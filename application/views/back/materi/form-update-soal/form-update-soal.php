<div class="content-page">
	<div class="content">
		<div class="container">

			<!-- start row -->

			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
						<h4 class="page-title">
							<a data-toggle="tooltip" data-placement="top" title=""
							   data-original-title="Daftar Soal <?= $materi['nama_materi'] ?>"
							   href="<?= base_url('back/materi/' . $materi['meta_link_materi'] . "/soal/latihan") ?>">
								<i class="fa fa-arrow-left"></i>
							</a>
							<span
								title="<?= $title ?>"><?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?>
							</span>
						</h4>
						<ol class="breadcrumb p-0 m-0">
							<li>
								<a title="Daftar Soal <?= $materi['nama_materi'] ?>"
								   href="<?= base_url('back/materi/' . $materi['meta_link_bab']) ?>">
									<?= (strlen("Daftar Soal " . $materi['nama_materi']) > 20 ? substr("Daftar Soal " . $materi['nama_materi'], 0, 20) . "..." : "Daftar Soal " . $materi['nama_materi']) ?>
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
			<input type="hidden" id="metaKelas" value="<?= $kelas['meta_link_kelas'] ?>">
			<input type="hidden" id="idMapel" value="<?= $mapel['id_mapel'] ?>">
			<input type="hidden" id="metaMapel" value="<?= $mapel['meta_link_mapel'] ?>">
			<input type="hidden" id="idBab" value="<?= $bab['id_bab'] ?>">
			<input type="hidden" id="metaBab" value="<?= $bab['meta_link_bab'] ?>">
			<input type="hidden" id="idMateri" name="id_materi" value="<?= $materi['id_materi'] ?>"/>
			<input type="hidden" id="metaMateri" name="meta_materi" value="<?= $materi['meta_link_materi'] ?>"/>


			<!-- start row -->
			<div class="row">

				<div class="col-sm-12">

					<div class="card-box">
						<table class="table table-bordered m-0">
							<colgroup>
								<col class="col-sm-4">
								<col class="col-sm-8">
							</colgroup>
							<tbody>
							<tr>
								<td>Nama Materi</td>
								<td id="nama-materi-detail">Otto</td>
							</tr>
							<tr>
								<td>Mata Pelajaran</td>
								<td id="nama-mapel-detail">Otto</td>
							</tr>
							<tr>
								<td>Kelas</td>
								<td id="nama-kelas-detail">Otto</td>
							</tr>
							<tr>
								<td>Bab</td>
								<td id="nama-bab-detail">Otto</td>
							</tr>
							<tr>
								<td>Deskripsi</td>
								<td id="deskripsi-materi-detail">Thornton</td>
							</tr>
							<tr>
								<td>Tipe</td>
								<td id="tipe-materi-detail">Thornton</td>
							</tr>

							</tbody>
						</table>
					</div>

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
						<div id="form-preview">
							<form method="POST" id="form-latihan-soal" class=" m-b-30" enctype="multipart/form-data">
								<input type="hidden" id="id_soal" name="id_soal" value="<?= $id ?>"/>
								<input type="hidden" id="idMateri" name="id_materi" value="<?= $materi['id_materi'] ?>"/>
								<div class="pull-right">
									<a href=""
									   class="btn btn-danger btn-bordered waves-effect  m-t-20">Back
									</a>
									<button type="button" onclick="FormUpdateSoal.resetForm();" class="btn btn-default btn-bordered waves-effect m-t-20">Reset
									</button>
									<button type="submit"
											class="btn btn-info btn-bordered waves-effect  m-t-20">Simpan
									</button>
								</div>
								<div class="clearfix"></div>


								<div class="form-group">
									<label class="control-label">Pertanyaan</label>
									<textarea id="pertanyaan" name="pertanyaan"></textarea>
								</div>
								<div class="form-group">
									<label class="control-label">Kunci</label>
									<select name="kunci" class="select2" id="kunci"
											data-placeholder="Kunci Jawaban Soal ...">
										<option value="A">Jawaban 1</option>
										<option value="B">Jawaban 2</option>
										<option value="C">Jawaban 3</option>
										<option value="D">Jawaban 4</option>
										<option value="E">Jawaban 5</option>
									</select>
								</div>
								<div class="form-group">
									<label class="control-label">Jawaban</label>

									<ul class="nav nav-pills m-b-30">
										<li class="active">
											<a href="#navpills-1" data-toggle="tab" aria-expanded="false">Jawaban 1</a>
										</li>
										<li class="">
											<a href="#navpills-2" data-toggle="tab" aria-expanded="false">Jawaban 2</a>
										</li>
										<li>
											<a href="#navpills-3" data-toggle="tab" aria-expanded="true">Jawaban 3</a>
										</li>
										<li>
											<a href="#navpills-4" data-toggle="tab" aria-expanded="true">Jawaban 4</a>
										</li>
										<li>
											<a href="#navpills-5" data-toggle="tab" aria-expanded="true">Jawaban 5</a>
										</li>
									</ul>
									<div class="tab-content br-n pn">
										<div id="navpills-1" class="tab-pane active">
											<textarea id="jawaban_1" name="jawaban_1"></textarea>
										</div>
										<div id="navpills-2" class="tab-pane">
											<textarea id="jawaban_2" name="jawaban_2"></textarea>
										</div>
										<div id="navpills-3" class="tab-pane">
											<textarea id="jawaban_3" name="jawaban_3"></textarea>
										</div>
										<div id="navpills-4" class="tab-pane">
											<textarea id="jawaban_4" name="jawaban_4"></textarea>
										</div>
										<div id="navpills-5" class="tab-pane">
											<textarea id="jawaban_5" name="jawaban_5"></textarea>
										</div>

									</div>

								</div>
								<div class="form-group">
									<label class="control-label">Pembahasan</label>
									<textarea id="pembahasan" name="pembahasan"></textarea>
								</div>


								<div class="clearfix"></div>
								<div class="pull-right">
									<a href="<?= base_url('back/materi/' . $bab['meta_link_bab']) ?>"
									   class="btn btn-danger btn-bordered waves-effect">Back
									</a>
									<button type="button" onclick="FormUpdateSoal.resetForm();" class="btn btn-default btn-bordered waves-effect">Reset
									</button>
									<button type="submit"
											class="btn btn-info btn-bordered waves-effect">Simpan
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- end row -->
		</div>
	</div>
</div>
