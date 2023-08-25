<div class="content-page">
  <div class="content">
    <div class="container">

      <div class="row">
        <div class="col-xs-12">
          <div class="page-title-box">
            <h4 class="page-title">
              <a href="<?= base_url('back/voucher') ?>">
                <i class="fa fa-arrow-left"></i>
              </a>
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
                    <th>Kode Voucher</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1;
                  foreach ($voucher as $v) : ?>
                    <tr>
                      <td><?= $no ?></td>
                      <td><?= $v['kode_voucher'] ?></td>
                      <td><?= ($v['status'] == '1') ? 'Active' : 'Expired' ?></td>
                      <td><a href="<?= base_url('back/voucher/delete/') . $v['mapel_id'] . '/' . $v['id_voucher'] ?>" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Voucher" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i></a></td>
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