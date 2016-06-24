            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
            <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Tambah Data Latih
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="<?php echo $nav_scrap;?>">Tambah Data Latih</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <!-- Small boxes (Stat box) -->
       
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-md-6">
                            <div class="box box-info">
                                <div class="box-header">
                                    <h3 class="box-title">Input</h3>
                                </div><!-- /.box-header -->
                            <!-- form start -->
                                <?php echo form_open('tambahdatalatih/simpan', array('id'=>'formdl')); ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>Sumber Berita  <b style="color: red;">*</b> </label>
                                            <input type="text" id="sumberberita" name="sumberberita" value="" class="form-control" placeholder="Masukkan Sumber Berita, ex:Kompas, Tempo, Sindonews"/>
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Url  <b style="color: red;">*</b> </label>
                                            <input type="text" id="url" name="url" value="" class="form-control" placeholder="Masukkan Url situs berita"/>
                                            <p class="help-block"></p> 
                                        </div>
                                        <div class="form-group">
                                            <label>Judul  <b style="color: red;">*</b> </label>
                                            <input type="text" id="tagjudul" name="tagjudul" value="" class="form-control" placeholder="Masukkan   judul berita 1"/>
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Kategori  <b style="color: red;">*</b> </label>
                                            <input type="text" id="tagkategori" name="tagkategori" value="" class="form-control" placeholder="Masukkan   kategori berita 1"/>
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal  <b style="color: red;">*</b> </label>
                                            <input type="text" id="tagtanggal" name="tagtanggal" value="" class="form-control" placeholder="Masukkan   tanggal berita 1"/>
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Gambar  <b style="color: red;">*</b> </label>
                                            <input type="text" id="taggambar" name="taggambar" value="" class="form-control" placeholder="Masukkan   gambar berita 1"/>
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Berita  <b style="color: red;">*</b> </label>
                                            <input type="text" id="tagberita" name="tagberita" value="" class="form-control" placeholder="Masukkan   isi berita 1"/>
                                            <p class="help-block"></p>
                                        </div>
                                        <p style="color: red;">NB : Yang bertanda (*) wajib diisi</p>
                                    </div><!-- /.box-body -->

                                    <input class="btn btn-lg btn-success btn-block btn-flat" id="btnsave" type="submit" name="submitfrm" value="Simpan"/>

                                    <!-- <div class="box-footer col-lg-12">
                                        <div class="col-lg-6">
                                            div id="LoadingImageHijau" style="display: none; vertical-align: middle;">
                                                <center><img src="<?php echo $base_url; ?>assets/img/loader.gif"/></center>
                                            </div>
                                            <input class="btn btn-lg btn-success btn-block btn-flat" id="btnsimpan" type="submit" name="submitfrm" value="Simpan"/>
                                            <p class="help-block"></p>
                                        </div>
                                    </div> -->
                                <?php echo form_close(); ?>
                            </div><!-- /.box -->
                        </div>

                        <div class="modal fade" id="modalSuc">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">

                                        <h4 class="modal-title">Konfirmasi</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div id="msgmodal"></div>
                                    </div>
                                    <div class="modal-footer">

                                        <button type="button" id="btnoke" class="btn btn-primary"><span class="btn-label"><i class="fa fa-check-square"></i></span>&nbsp;Ok</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

               
                
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->