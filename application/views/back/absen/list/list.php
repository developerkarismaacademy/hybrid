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
                        <div class="card-box">
                            <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Voucher" href="<?= base_url('back/absen/tambah') ?>" class="btn btn-icon waves-effect waves-light btn-success" style="margin-bottom:20px">
                                <i class="fa fa-plus"></i> Tambah
                            </a>
                            <table id="example" class="display" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Absen</th>
                                        <th>Keterangan</th>
                                        <th>Expired Date</th>
                                        <th>Total Murid</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($absen as $item) : ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= $item['kode_absen'] ?></td>
                                            <td><?= $item['keterangan'] ?></td>
                                            <td><?= $item['expired_date'] ?></td>
                                            <td><?= $item['total_murid'] ?></td>
                                            <td>
                                                <a href="<?= base_url('back/absen/murid/') . $item['id_absen'] ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="List siswa"><i class="fa fa-list-ol"></i></a>
                                                <a href="<?= base_url('back/absen/hapus/') . $item['id_absen'] ?>" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="List siswa" onclick="return confirm('Apakah anda yakin ?')"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php $no++;
                                    endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Absen</th>
                                        <th>Keterangan</th>
                                        <th>Expired Date</th>
                                        <th>Total Murid</th>
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