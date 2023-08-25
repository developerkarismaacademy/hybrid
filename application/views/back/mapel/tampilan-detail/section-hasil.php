<div class="panel panel-color panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Hasil Belajar</h3>
    </div>
    <div class="panel-body">
    <div class="form-group">
        <label class="control-label">Tambah List Hasil</label>
        <div class="row no-gutter">
        <div class="col-md-6">
            <input class="form-control" type="text" name="tambah" id="tambah" placeholder="Tambah List Hasil" maxlength=100>
        </div>
        <div class="col-md-6">
            <button class="btn btn-success" type="button" id="btn-tambah"><i class="fa fa-plus"></i></button>
        </div>
        </div>
        

        <form id="form-urutan" method="post">
        <div class="pull-right">
            <a href="<?= base_url('back/mapel/' . $kelas['meta_link_kelas']) ?>"
            class="btn btn-danger btn-bordered waves-effect">Back
            </a>

            <button type="submit"
                class="btn btn-info btn-bordered waves-effect">Simpan
            </button>
        </div>
        <div class="m-t-10 clearfix">
            <div class="custom-dd-empty dd" id="mapel-listhasil">
            <ol class="dd-list">
                <?php 
                if(isset($listhasil)){
                foreach ($listhasil as $key => $value) { ?>
                    <li class="dd-item dd3-item item-list" data-id="<?= $value['id_mapel_listhasil'] ?>" data-deskripsi="<?= $value['deskripsi_mapel_listhasil'] ?>">
                    <div class="dd-handle dd3-handle"></div>
                    <div class="dd3-content">
                        <?= $value['deskripsi_mapel_listhasil'] ?>
                        <span class="pull-right text-danger fa fa-trash"  onclick="hapusAction($(this))"></span>
                    </div>
                    </li>
                <?php }
                }
                ?>
            </ol>
            </div>
        </div>
        </form>
    </div>
    </div>
</div>