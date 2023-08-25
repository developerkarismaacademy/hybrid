<?php
$adminkah = $this->session->backData["level_user"] == "administrasi";
$instrukturkah = $this->session->backData["level_user"] == "instruktur";
?>
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
              <li>
                <a title="Daftar Mata Pelajaran " href="">

                </a>
              </li>
              <li class="active">
                <span title="<?= $title ?>"><?= (strlen($title) > 18 ? substr($title, 0, 18) . "..." : $title) ?></span>
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
            <div>
              <table id="example" class="display" style="width:100%;">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Coin</th>
                    <th>Uang</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody id="data-penukaran">

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