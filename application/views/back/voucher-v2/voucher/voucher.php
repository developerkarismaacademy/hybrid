<div class="content-page">
    <div class="content">
        <div class="container">

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
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-icon alert-danger alert-dismissible fade in error-alert hidden" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <div class="error-alert-container">

                        </div>
                    </div>
                    <div class="card-box">
                        <h4 class="m-t-0 header-title"><b>Daftar Voucher</b></h4>

                        <div class="card-box">
                            <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Voucher" href="<?= base_url('back/voucher/save') ?>" class="btn btn-icon waves-effect waves-light btn-success" style="margin-bottom:20px">
                                <i class="fa fa-plus"></i> Tambah
                            </a>
                            <table id="example" class="display" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Mapel</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($voucher as $v) : ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= $v['nama_mapel'] ?></td>
                                            <td><?= $v['total'] ?></td>
                                            <td><a href="<?= base_url('back/voucher/detail/') . $v['mapel_id'] ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Daftar Voucher <?= $v['nama_mapel'] ?>"><i class="fa fa-list-ol"></i></a></td>
                                        </tr>
                                    <?php $no++;
                                    endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Mapel</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>