<div class="container kelas-parent">
    <div class="row">
        <div class="clone-data col-lg-3 col-md-6 px-3" id="clone-data">
            <div class="card w-100">
                <a href="#" class="link-detail">
                    <div class="card-gambar img-bg-fill">
                        <div class="row px-3">
                            <div class="col p-1 status-webinar">
                                <div class="kelas-jenis badge badge-pill">{status_webinar}</div>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="card-body">
                    <div class="card-text d-flex flex-column">
                        <div class="row mb-3">
                            <div class="col">
                                <div class="kelas-title font-weight-bold line-limit-3">
                                    <a href="#" class="nama-mapel link-detail">

                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row my-0 my-lg-auto d-none">
                            <div class="col">
                                <div class="kelas-instruktur media">
                                    <img src="<?= base_url('assets/front/v2/img/default.png') ?>"
                                         alt="ft-ins" width="30px" height="30px"
                                         class="rounded-circle align-self-center object-cover foto-instruktur mr-1">
                                    <div class="media-body">
                                        <div class="nama-instruktur line-limit-1">
                                            by {nama_user}
                                        </div>
                                        <div class="instruktur-job small line-limit-1">
                                            Pembicara
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pb-3 pb-lg-0 my-auto my-lg-3 d-none">
                            <div class="col-12 small d-inline-block d-flex align-items-center">
								<span class="score mr-3">
									<div class="score-wrap">
										<span class="stars-active">
											<i class="fa fa-star" aria-hidden="true"></i>
											<i class="fa fa-star" aria-hidden="true"></i>
											<i class="fa fa-star" aria-hidden="true"></i>
											<i class="fa fa-star" aria-hidden="true"></i>
											<i class="fa fa-star" aria-hidden="true"></i>
										</span>
										<span class="stars-inactive">
											<i class="fa fa-star-o" aria-hidden="true"></i>
											<i class="fa fa-star-o" aria-hidden="true"></i>
											<i class="fa fa-star-o" aria-hidden="true"></i>
											<i class="fa fa-star-o" aria-hidden="true"></i>
											<i class="fa fa-star-o" aria-hidden="true"></i>
										</span>
									</div>
								</span>
                                <span class="rating">
									<b>{rating}</b> ({jml_user} rating)
								</span>
                            </div>
                            <hr>
                            <div class="col-12 harga">
                                <div class="row no-gutter">
                                    <div class="col-7 pr-1">
                                        <div class="harga-asli small text-truncate">
											<span class="badge badge-pill badge-danger">
												{diskon}%
											</span>
                                            <span class="text-line-through text-truncate">
												{harga_basic}
											</span>
                                        </div>
                                    </div>
                                    <div class="col pl-1 text-right">
                                        <div class="harga-diskon text-truncate">
                                            {harga_diskon}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-auto d-none">
                            <div class="col">
                                <a class="btn btn-success w-100 link-login" href="#">
                                    {status}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pagination-box text-center m-t-15 m-b-5" id="paging-container">
        <p class="text-center font-weight-normal" id="paging-detail">
            Menampilkan ({awal} - {akhir} Dari {total} Data) <br>
            Halaman {current_page} Total {total_page} Halaman
        </p>
        <ul class="pagination justify-content-center">
            <li class="page-item" id="btn-page-previous">
                <a class="page-link" href="#">Previous</a>
            </li>
            <li id="btn-page" class="page-item page-number d-none">
                <a class="page-link" href="#">1</a>
            </li>
            <li class="page-item" id="btn-page-next">
                <a class="page-link" href="#">Next</a>
            </li>
        </ul>
    </div>
</div>
