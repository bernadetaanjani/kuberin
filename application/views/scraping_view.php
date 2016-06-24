            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
            <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Scraping
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="<?php echo $nav_scrap;?>">Scraping</li>
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
                                <?php echo form_open('scraping/testdanscrap', array('id'=>'formscrap')); ?>
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
                                            <label>Link  <b style="color: red;">*</b> </label>
                                            <input type="text" id="taglink1" name="taglink1" value="" class="form-control" placeholder="Masukkan tag link berita 1"/>
                                            <p class="help-block"></p>
                                            <input type="text" id="taglink2" name="taglink2" value="" class="form-control" placeholder="Masukkan tag link berita 2"/>
                                            <p class="help-block"></p>
                                            <input type="text" id="taglink3" name="taglink3" value="" class="form-control" placeholder="Masukkan tag link berita 3"/>
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Judul  <b style="color: red;">*</b> </label>
                                            <input type="text" id="tagjudul1" name="tagjudul1" value="" class="form-control" placeholder="Masukkan tag judul berita 1"/>
                                            <p class="help-block"></p>
                                            <input type="text" id="tagjudul2" name="tagjudul2" value="" class="form-control" placeholder="Masukkan tag judul berita 2"/>
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Kategori  <b style="color: red;">*</b> </label>
                                            <input type="text" id="tagkategori1" name="tagkategori1" value="" class="form-control" placeholder="Masukkan tag kategori berita 1"/>
                                            <p class="help-block"></p>
                                            <input type="text" id="tagkategori2" name="tagkategori2" value="" class="form-control" placeholder="Masukkan tag kategori berita 2"/>
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal  <b style="color: red;">*</b> </label>
                                            <input type="text" id="tagtanggal1" name="tagtanggal1" value="" class="form-control" placeholder="Masukkan tag tanggal berita 1"/>
                                            <p class="help-block"></p>
                                            <input type="text" id="tagtanggal2" name="tagtanggal2" value="" class="form-control" placeholder="Masukkan tag tanggal berita 2"/>
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Gambar  <b style="color: red;">*</b> </label>
                                            <input type="text" id="taggambar1" name="taggambar1" value="" class="form-control" placeholder="Masukkan tag gambar berita 1"/>
                                            <p class="help-block"></p>
                                            <input type="text" id="taggambar2" name="taggambar2" value="" class="form-control" placeholder="Masukkan tag gambar berita 2"/>
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Berita  <b style="color: red;">*</b> </label>
                                            <input type="text" id="tagberita1" name="tagberita1" value="" class="form-control" placeholder="Masukkan tag isi berita 1"/>
                                            <p class="help-block"></p>
                                            <input type="text" id="tagberita2" name="tagberita2" value="" class="form-control" placeholder="Masukkan tag isi berita 2"/>
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Konten Tidak Perlu</label>
                                            <input type="text" id="tagbuangkonten" name="tagbuangkonten" value="" class="form-control" placeholder="Masukkan tag buang konten tidak perlu"/>
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>Pagination</label>
                                            <input type="text" id="pagination1" name="pagination1" value="" class="form-control" placeholder="Masukkan tag pagination 1"/>
                                            <p class="help-block"></p>
                                            <input type="text" id="pagination2" name="pagination2" value="" class="form-control" placeholder="Masukkan tag pagination 2"/>
                                            <p class="help-block"></p>
                                        </div>
                                        <p style="color: red;">NB : Yang bertanda (*) wajib diisi</p>
                                    </div><!-- /.box-body -->

                                    <div class="box-footer col-lg-12">
                                        <div class="col-lg-6">
                                            <div id="LoadingImageHijau" style="display: none; vertical-align: middle;">
                                                <center><img src="<?php echo $base_url; ?>assets/img/loader.gif"/></center>
                                            </div>
                                            <input class="btn btn-lg btn-success btn-block btn-flat" id="btntest" type="submit" name="submitfrm" value="Test"/>
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="col-lg-6">
                                            <div id="LoadingImageBiru" style="display: none; vertical-align: middle;">
                                                <center><img src="<?php echo $base_url; ?>assets/img/loaderbir.gif"/></center>
                                            </div>
                                            <input class="btn btn-lg btn-info btn-block btn-flat" id="btnsimpan" type="submit" name="submitfrm" value="Simpan"/>
                                            <p class="help-block"></p>
                                        </div>
                                    </div>
                                <?php echo form_close(); ?>
                            </div><!-- /.box -->
                        </div>

                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <div class="col-md-6">
                            <div class="box box-info">
                                <div class="box-header">
                                    <h3 class="box-title">Output</h3>
                                </div><!-- /.box-header -->
                            <!-- form start -->
                                <form role="form">
                                    <div class="box-body" style="word-wrap: break-word">
                                        <div id="penandalink" class="txtlabel" style="display: none">Link</div>
                                        <div id="linkber"></div>
                                        <div id="penandajudul" class="txtlabel" style="display: none">Judul</div>
                                        <div id="judulber"></div>
                                        <div id="penandakat" class="txtlabel" style="display: none">Kategori</div>
                                        <div id="kategoriber"></div>
                                        <div id="penandatgl" class="txtlabel" style="display: none">Tanggal</div>
                                        <div id="tanggalber"></div>
                                        <div id="penandawkt" class="txtlabel" style="display: none">Waktu</div>
                                        <div id="waktuber"></div>
                                        <div id="penandagambar" class="txtlabel" style="display: none">Gambar</div>
                                        <div id="gambarber"></div>
                                        <div id="penandaisi" class="txtlabel" style="display: none">Isi</div>
                                        <div id="isiber"></div>
                                        <div id="datatest" class="txtlabel">Data Belum di Test !</div>
                                        <div id="msg" class="txtlabel" style="color: red;"></div>

                                    </div><!-- /.box-body -->

                                    
                                </form>
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