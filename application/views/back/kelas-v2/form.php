<transition name="slide-fade">
    <div   class="form-pop-up " style="display: none;" id="form-kelas">
        <div v-if="loadingForm" class="loading text-center">
            <i class="fa fa-spin fa-circle-o-notch fa-4x"></i>
            <br>
            <br>
            Loading Data
        </div>
        <div class="panel panel-default">
            <div class="">
                <div class="panel-heading" style="">
                    <h3 class="header-title panel-title pull-left"><b>Form Kelas</b></h3>
                    <button v-on:click="toggleForm('')" type="button" class="close pull-right" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="clearfix"></div>
                </div>
                <form method="POST" action="">
                    <div class="panel-body">
                        <div class="slimscroller">
                            <div class="alert alert-icon alert-danger alert-dismissible fade in error-alert hidden"
                                 role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <i class="mdi mdi-block-helper"></i>
                                <div class="error-alert-container">

                                </div>
                            </div>
                            <div class="form-group">
                                <label>Nama Kelas</label>
                                <input type="text" v-model="form.nama_kelas" placeholder="Nama Kelas . . ."
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Deskripsi Kelas</label>
                                <ckeditor :editor="editor" v-model="form.deskripsi_kelas"></ckeditor>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Gambar Kelas</label>
                                <br>
                                <img src="<?= base_url() ?>/assets/back/images/no-image.jpg" id="img-gambar-kelas"
                                     width="200">
                                <br>
                                <br>
                                <input type="file" accept="image/*" class="filestyle" id="file" name="file" ref="file">
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-6 col-xs-6">
                                Kolom bertanda <span class="text-danger">*</span> <b>Wajib Diisi</b>
                            </div>
                            <div class="col-md-6 col-xs-6 text-right">
                                <button type="button" class="btn btn-danger btn-bordered waves-effect"
                                        v-on:click="toggleForm('')">Batal
                                </button>
                                <button type="button" v-on:click="save()"
                                        class="btn btn-info btn-bordered waves-effect">Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</transition>
