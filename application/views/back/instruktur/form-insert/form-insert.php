<div class="content-page">
  <div class="content">
    <div class="container">

      <!-- start row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="page-title-box">
            <h4 class="page-title">
              <a data-toggle="tooltip" data-placement="top" title="Daftar Pembelian" href="<?= base_url('back/instruktur') ?>" data-original-title="Daftar Instruktur">
                <i class="fa fa-arrow-left"></i>
              </a>
              <span title="<?= $title ?>">
                <?= (strlen($title) > 40 ? substr($title, 0, 40) . "..." : $title) ?>
              </span>
            </h4>
            <ol class="breadcrumb p-0 m-0">
              <li>
                <a title="Daftar Instruktur" href="<?= base_url('back/instruktur') ?>">
                  Daftar Instruktur
                </a>
              </li>
              <li class="active">
                <span title="<?= $title ?>">
                  <?= (strlen($title) > 18 ? substr($title, 0, 18) . "..." : $title) ?>
                </span>
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
          <div class="alert alert-icon alert-danger alert-dismissible fade in error-alert hidden" role="alert">
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
            <form method="POST" id="form-instruktur" enctype="multipart/form-data">
              <h4 class="m-t-0 header-title"><b><?= $title ?></b></h4>
              <div class="pull-right">
                <a href="<?= base_url('back/instruktur') ?>" class="btn btn-danger btn-bordered waves-effect">Back
                </a>
                <button type="reset" class="btn btn-default btn-bordered waves-effect">Reset
                </button>
                <button type="submit" class="btn btn-info btn-bordered waves-effect">Simpan
                </button>
              </div>
              <div class="m-t-10 clearfix">
                <div class="form-group">
                  <label class="control-label">Nama Instruktur </label>
                  <input type="text" id="nama_user" name="nama_user" placeholder="Nama Instruktur . . ." class="form-control">
                </div>
                <div class="form-group">
                  <label class="control-label">Email Instruktur</label>
                  <input type="email" id="email_user" name="email_user" placeholder="Email Instruktur . . ." class="form-control">
                </div>
                <div class="form-group">
                  <label class="control-label">Username Instruktur</label>
                  <input type="text" id="username" name="username" placeholder="Username Instruktur . . ." class="form-control">
                </div>
                <div class="form-group">
                  <label class="control-label">Password</label>
                  <input type="password" id="password" name="password" placeholder="Password . . ." class="form-control">
                </div>
                <div class="form-group">
                  <label class="control-label">Konfirmasi Password</label>
                  <input type="password" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Password . . ." class="form-control">
                </div>
                <div class="form-group">
                  <label class="control-label">Biodata</label>
                  <textarea name="biodata" class="form-control" id="biodata"></textarea>
                </div>
                <div class="form-group">
                  <label class="control-label">Jenis Kelamin</label>
                  <select name="jk_user" class="form-control">
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                  </select>
                </div>


                <div class="form-group m-t-5">
                  <label class="control-label">Foto Instruktur</label>
                  <br>
                  <img src="<?= base_url() ?>/upload/instruktur/default.png" id="img-gambar-user" width="200">
                  <br>
                  <br>
                  <input type="file" accept="image/*" class="filestyle" id="gambar_user" name="gambar_user" ref="file">
                </div>
                <div class="form-group m-t-5">
                  <label class="control-label">Tanda Tangan</label>
                  <br>
                  <img src="<?= base_url() ?>/upload/instruktur/default.png" id="img-gambar-tanda-tangan" width="200">
                  <br>
                  <br>
                  <input type="file" accept="image/png" class="filestyle" id="gambar_tanda_tangan" name="gambar_tanda_tangan" ref="file">
                </div>
                <div class="pull-right">
                  <a href="<?= base_url('back/instruktur') ?>" class="btn btn-danger btn-bordered waves-effect">Back
                  </a>
                  <button type="reset" class="btn btn-default btn-bordered waves-effect">Reset
                  </button>
                  <button type="submit" class="btn btn-info btn-bordered waves-effect">Simpan
                  </button>
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
<!-- container -->