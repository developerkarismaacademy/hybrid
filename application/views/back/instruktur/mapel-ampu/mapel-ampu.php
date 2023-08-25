<div class="content-page">
	<div class="content">
		<div class="container">

			<!-- start row -->

			<div class="row">
				<div class="col-xs-12">
					<div class="page-title-box">
						<h4 class="page-title">
							<span title="<?= $title ?>"><?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?>
							</span>
						</h4>
						<ol class="breadcrumb p-0 m-0">
							<li class="active">
								<span title="<?= $title ?>"><?= (strlen($title) > 18 ? substr($title, 0, 18) . "..." : $title) ?></span>
							</li>
						</ol>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<!-- end row -->
			<div class="row m-t-20 m-b-20">
				<div class="col-sm-9 col-sm-offset-3">
					<form id="form-search" class="form-group search-box w-100" style="max-width: 75%;">
						<input type="text" id="search" name="search" class="form-control product-search"
							   placeholder="Search here...">
						<button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
					</form>
				</div>
			</div>

			<input type="hidden" value="<?= $this->session->backData["id"] ?>" name="idInstruktur" id="idInstruktur">
			<!-- start row -->
			<div class="row">
				<div class="row equal" id="data-mapel">

					<div class="clone-data col-xs-6 col-sm-3 m-b-20" id="clone-data">
						<a href="#" title="" class="link-detail">
							<div class="card-box h-100">
								<img onerror='this.src="<?= base_url() ?>/upload/mapel/default.png"' style="height:90%;"
									 class="gambar-mapel object-cover w-100"
									 src="<?= base_url() ?>/upload/mapel/default.png">
								<div class="w-100 m-t-auto">
									<span class="badge badge-danger pull-right jml-nilai">New</span>
									<h4 class="nama-mapel line-limit-1" style="width: 75%;">{{ mapel.nama_mapel }}</h4>
								</div>
							</div>
						</a>
					</div>


				</div>
				<div class="pagination-box text-center m-t-15 m-b-5" id="paging-container">
					<p class="text-center font-weight-normal" id="paging-detail">
						Menampilkan ({awal} - {akhir} Dari {total} Data) <br>
						Halaman {current_page}, Total {total_page} Halaman
					</p>
					<ul class="pagination justify-content-center">
						<li class="page-item" id="btn-page-previous">
							<a class="page-link" href="#">Previous</a>
						</li>
						<li id="btn-page" class="page-item page-number hide"><a class="page-link" href="#">1</a>
						</li>
						<li class="page-item" id="btn-page-next">
							<a class="page-link" href="#">Next</a>
						</li>
					</ul>
				</div>
			</div>
			<!-- end row -->
		</div>
	</div>
</div>
<!-- container -->
