<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Summarize Berita
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="<?php echo $nav_scrap;?>">Summarize Berita</li>
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
                        <h3 class="box-title">Filter Berita</h3>
                        <div class="box-tools">

                        </div>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php echo form_open('summarizevalen/tampilBeritaFilter', array('id'=>'formgetberita')); ?>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Kata Kunci  <b style="color: red;">*</b> </label>
                            <input type="text" id="katakunci" name="katakunci" value="" class="form-control" placeholder="Masukkan kata kunci"/>
                              <p class="help-block"></p>

                        </div>
                        <div class="form-group">
                            <label>Date range:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="reservation" name="tanggalrange"/>
                            </div><!-- /.input group -->
                        </div><!-- /.form group -->
                        <div class="form-group">
                            <label>Sumber</label>

                                <?php
                                foreach($sumberberita_list as $rows) {

                                    ?>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="minimal" name="optsumberberita[]"
                                                   value="<?php echo $rows['sumberberita']; ?>"/>
                                            &nbsp;<?php echo $rows['sumberberita']; ?>
                                        </label>
                                    </div>
                                <?php
                                }
                                ?>


                        </div>
                        <div class="form-group">
                            <label>Jumlah Berita  <b style="color: red;">*</b> </label>
                            <select name="optjumlahberita" class="form-control">
                                <option value="">--Jumlah Berita--</option>
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="25">25</option>

                            </select>

                        </div>
                        <div id="msgbaru" class="txtlabel" style="color: red;"></div>
                        <p style="color: red;">NB : Yang bertanda (*) wajib diisi</p>

                    </div>
                    <div class="box-footer clearfix">
                        <button class="btn btn-primary btn-flat pull-right" id="getberita" type="submit"><span class="btn-label"><i class="fa fa-search"></i></span>&nbsp;Cari</button>
                        <p class="help-block"></p>

                    </div>
                    <?php echo form_close(); ?>

                </div>
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Summarize</h3>
                        <p>Pilihlah berita yang ingin di ringkas!!!</p>

                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php echo form_open('summarizevalen/summarizeberita', array('id'=>'formsumbaru')); ?>
                    <div class="box-body">
                        <input type="hidden" id="kk" name="testkatakunci" class="form-control" />
                          

                        <table style="display: none" id="tblberitasum" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Pilih</th>
                                <th>Judul</th>
                                <th>Selengkapnya</th>

                            </tr>
                            </thead>

                        </table>
                        <div id="msgkat" class="txtlabel" style="color: red;"></div>

                    </div>


                    <div class="box-footer clearfix">
                        <button class="btn btn-primary btn-flat pull-right" id="sumberita" type="submit" disabled><span class="btn-label"><i class="fa fa-plus-square"></i></span>&nbsp;Summarize</button>
                        <p class="help-block"></p>

                    </div>
                    <?php echo form_close(); ?>
                </div><!-- /.box -->


            </div>
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Output</h3>
                        <div class="box-tools">

                        </div>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">

                        <div id="penandaisi" class="txtlabel" style="display: none">Hasil Summarize : </div>
                        <div id="isiber"></div>
                        <div id="datatest" class="txtlabel">Belum di summarize!</div>
                        <div id="msg" class="txtlabel" style="color: red;"></div>
                        <br>
                        <div id="penandatblscore" class="txtlabel" style="display: none">Skor Berita : </div>
                        <table style="display: none" id="tblscore" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Kalimat</th>
                                <th>Skor</th>

                            </tr>
                            </thead>

                        </table>
                        <br>
                        <div id="penandatblkalimat" class="txtlabel" style="display: none">Berita Terkait : </div>
                        <table style="display: none" id="tblkalimat" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Kalimat</th>
                                <th>Berita Terkait</th>

                            </tr>
                            </thead>

                        </table>

                    </div>
                    <div class="box-footer clearfix">

                    </div>

                </div>



            </div><!-- /.box -->
            <div class="modal fade bs-example-modal-lg" id="modalBerita">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Detail Berita</h4>
                        </div>
                        <div class="modal-body">
                            <h1 id="judulberita"></h1>
                            <p id="tanggaldanwaktu"></p>
                            <p id="kategoriberita"></p>
                            <img class="img-responsive" id="gambarberita" src=""/>
                            </br>
                            <div id="isiberita"></div>
                            </br>
                            Sumber : <div id="sumber" style="word-wrap:break-word;"></div>
                            </br>
                            <a href="" id="linkberitabtn" target="_blank" class="btn btn-primary btn-sm btn-labeled btn-flat pull-right"><span class="btn-label"><i class="fa fa-file-text"></i></span>&nbsp;Sumber Berita</a>

                        </div>
                        <div class="modal-footer">


                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>



        <!-- Main row -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->