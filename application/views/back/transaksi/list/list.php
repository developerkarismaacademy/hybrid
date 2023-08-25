<div class="content-page">
    <div class="content">
        <div class="container">

            <!-- start row -->

            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">
							<span
                                    title="<?= $title ?>"><?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?>
							</span>
                        </h4>
                        <ol class="breadcrumb p-0 m-0">
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
                        <h4 class="m-t-0 header-title"><b><?= $title ?></b></h4>
                        <button data-toggle="tooltip" data-placement="top" title="" data-original-title="Refresh Data"
                                onclick="ListTransaksi.refresh()"
                                class="btn btn-icon waves-effect waves-light btn-primary">
                            <i class="fa fa-refresh"></i>
                        </button>
                        <a href="<?= base_url("back/pembelian/tambah");?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Transaksi"
                                class="btn btn-icon waves-effect waves-light btn-success">
                            <i class="fa fa-plus"></i>
                        </a>
                        <div class="btn-limit">
                            <select onchange="ListTransaksi.limitChange()" class="selectpicker"
                                    id="limit" data-style="btn-default">
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                                <option>100</option>
                            </select>
                        </div>
                        <div class="search-box pull-right">
                            <form id="form-search">
                                <div class="input-group">
								<span class="input-group-btn">
									<button type="submit"
                                            class="btn waves-effect waves-light btn-primary">
										<i class="fa fa-search"></i>
									</button>
								</span>
                                    <input type="text"
                                           id="search" name="search" class="form-control"
                                           placeholder="Search">
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive m-t-10">
                            <table class="table m-0 table-colored table-striped table-hover table-colored-bordered table-info table-bordered-info">
                                <colgroup>
                                    <col class="col-sm-3">
                                    <col class="col-sm-1 text-right">
                                    <col class="col-sm-4 text-right">
                                    <col class="col-sm-2 ">
                                    <col class="col-sm-2 text-right">
                                </colgroup>
                                <thead>
                                <tr>
                                    <th id="th-nama">Nama</th>
                                    <th id="th-jumlah">Total Item</th>
                                    <th id="th-total">Total Bayar</th>
                                    <th id="th-status">Status</th>
                                    <th class="text-right">ACTION</th>
                                </tr>
                                </thead>
                                <tbody id="loading">
                                <tr>
                                    <th colspan="5" class="text-center">
                                        <i class="fa fa-spin fa-circle-o-notch fa-4x"></i>
                                        <br>
                                        <br>
                                        Loading Data
                                    </th>
                                </tr>
                                </tbody>
                                <tbody id="table-data">
                                <tr id="clone-data" class="clone-data">
                                    <td class="nama-user"> {{user.nama}}</td>
                                    <td class="jumlah-mapel"> {{transaksi.jumlah_mapel}}</td>
                                    <td class="total-bayar"> {{transaksi.total_bayar}}</td>
                                    <td class="status"> {{transaksi.status}}</td>
                                    <td class="text-right">
                                        <a href="#"
                                           class="btn waves-effect waves-light btn-teal link-detail"
                                           data-toggle="tooltip"
                                           data-placement="top" title="" data-original-title="Detail Transaksi">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination-box text-center  m-t-15 m-b-5" id="paging-container">
                            <p class="text-center font-weight-normal" id="paging-detail">
                                Menampilkan ({awal} - {akhir} Dari {total} Data) <br>
                                Halaman {current_page}, Total {total_page} Halaman
                            </p>
                            <ul class="pagination justify-content-center">
                                <li class="page-item" id="btn-page-previous">
                                    <a class="page-link" href="#">Previous</a>
                                </li>
                                <li id="btn-page" class="page-item page-number hide"><a class="page-link"
                                                                                        href="#">1</a>
                                </li>
                                <li class="page-item" id="btn-page-next">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
    </div>
</div>
<!-- container -->

