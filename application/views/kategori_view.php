<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Kategori
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="<?php echo $nav_scrap;?>">Kategori</li>
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
                        <h3 class="box-title">Tambah Kategori Utama</h3>

                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php echo form_open('kategori/insertKategoriUtama', array('id'=>'formkategori')); ?>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Kategori</label>
                            <input type="text" id="kategoritxt" name="kategoritxt" value="" class="form-control" placeholder="Masukkan kategori utama" required/>
                            <p class="help-block"></p>

                        </div>
                        <div id="msg" class="txtlabel" style="color: red;"></div>

                    </div>


                    <div class="box-footer clearfix">

                        <button class="btn btn-primary btn-flat pull-right" id="simpankategori" type="submit"><span class="btn-label"><i class="fa fa-floppy-o"></i></span>&nbsp;Simpan</button>
                        <p class="help-block"></p>
                    </div>
                    <?php echo form_close(); ?>

                </div><!-- /.box -->
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Pindah Kategori Berita</h3>

                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php echo form_open('kategori/insertKategoriBerita', array('id'=>'formkat')); ?>
                    <div class="box-body">

                        <div class="form-group">
                            <?php
                            if(count($kategori_list) > 0) {
                                ?>
                                <?php
                                foreach ($kategori_list as $rows) {

                                    ?>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="minimal" name="checkboxkat[]"
                                                   value="<?php echo $rows['kategori']; ?>"/>
                                            &nbsp;<?php echo $rows['kategori']; ?>
                                        </label>
                                    </div>


                                <?php
                                }
                            }
                            else
                            {
                                ?>


                        <p><strong><?php echo "--Data Kosong--"; ?></strong></p>
                        <?php
                        }
                        ?>
                        </div>
                        <div id="msgkat" class="txtlabel" style="color: red;"></div>

                    </div>


                    <div class="box-footer clearfix">
                        <button class="btn btn-primary btn-flat pull-right" id="simpankategoriberita" type="submit"><span class="btn-label"><i class="fa fa-floppy-o"></i></span>&nbsp;Simpan</button>
                        <p class="help-block"></p>

                    </div>
                    <?php echo form_close(); ?>
                </div><!-- /.box -->
            </div>
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Pengaturan Kategori</h3>

                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php echo form_open('kategori/insertHubKategoriBerita', array('id'=>'formkathub')); ?>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Kategori Utama  <b style="color: red;">*</b> </label>
                            <select name="optkategori" class="form-control">
                                <option value="">--Kategori--</option>
                                <?php
                                foreach($kategori_utama as $rows) {

                                    ?>
                                    <option value="<?php echo $rows['id_kategori'];?>"><?php echo $rows['nama_kategori'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kategori Berita  <b style="color: red;">*</b> </label>
                            <?php
                            if(count($kategori_berita) > 0) {
                                foreach($kategori_berita as $rows) {

                                    ?>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="minimal" name="checkboxkatberita[]"
                                                   value="<?php echo $rows['id_kategoriberita']; ?>"/>
                                            &nbsp;<?php echo $rows['kategori']; ?>
                                        </label>
                                    </div>

                                <?php
                                }
                            }
                            else
                            {
                                ?>

                                <p><strong><?php echo "--Data Kosong--"; ?></strong></p>
                            <?php
                            }
                            ?>
                        </div>
                            <div id="msgkatutama" class="txtlabel" style="color: red;"></div>
                            <div id="msgkatberita" class="txtlabel" style="color: red;"></div>
                        <p style="color: red;">NB : Yang bertanda (*) wajib diisi</p>
                    </div>
                    <div class="box-footer clearfix">
                        <button class="btn btn-primary btn-flat pull-right" id="simpanhubberita" type="submit"><span class="btn-label"><i class="fa fa-floppy-o"></i></span>&nbsp;Simpan</button>
                        <p class="help-block"></p>

                    </div>
                    <?php echo form_close(); ?>

                </div><!-- /.box -->


            </div>
        </div><!-- /.row (main row) -->

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

                    <button type="button" id="btnokekategori" class="btn btn-primary"><span class="btn-label"><i class="fa fa-check-square"></i></span>&nbsp;Ok</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



</section><!-- /.content -->
</div><!-- /.content-wrapper -->