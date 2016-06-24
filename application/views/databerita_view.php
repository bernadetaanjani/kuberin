<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Data Berita
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="<?php echo $nav_scrap;?>">Data Berita</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->

        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Filter Berita</h3>

                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php echo form_open('databerita/cari'); ?>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-xs-4">
                                <label>Kata Kunci  <b style="color: red;">*</b> </label>
                                <input type="text" id="katakunci" name="katakunci" value="" class="form-control" placeholder="Masukkan kata kunci"/>
                            </div>

                            <div class="form-group col-xs-4">
                                <label>Date range:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="reservation" name="tanggalberita"/>
                                </div><!-- /.input group -->
                            </div><!-- /.form group -->

                            <div class="form-group col-xs-4">
                                <label>Sumber</label>
                                <div class="form-group">
                                    <select name="optsumberberita" id="optsumberberita" class="form-control">
                                        <option value="">--Sumber Berita--</option>
                                        <?php
                                        foreach($sumberberita_list as $rows) {

                                            ?>
                                            <option value="<?php echo $rows['sumberberita'];?>"><?php echo $rows['sumberberita'];?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>

                        </div>


                        <p style="color: red;">NB : Yang bertanda (*) wajib diisi</p>
                    </div>


                    <div class="box-footer clearfix">

                        <button class="btn btn-primary btn-flat pull-right" id="caridata" type="submit"><span class="btn-label"><i class="fa fa-search"></i></span>&nbsp;&nbsp;Cari</button>
                        <p class="help-block"></p>
                    </div>
                    <?php echo form_close(); ?>
                </div>


            </div><!-- /.box -->
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Data Tabel Berita</h3>

                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body table-responsive">

                            <?php
                                if(count($berita_list) > 0) {
                                $no = $offset+1;
                            ?>
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Isi berita</th>
                                <th>Selengkapnya</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                    foreach($berita_list as $rows)
                                    {
                                $berita=$rows['isi_berita'];
                                $berita=character_limiter($berita,250);
                            ?>

                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $rows['judul']; ?></td>
                                <td><?php echo date("d-m-Y", strtotime($rows['tanggal'])); ?></td>
                                <td><?php echo date('G:i',strtotime($rows['waktu'])); ?></td>
                                <td><?php echo $berita; ?></td>
                                <td align="center"><a href="javascript:void(0)" id="btnview" onclick="show(<?php echo $rows['id_berita']; ?>);"  class="btn btn-primary btn-sm btn-labeled btn-flat"><span class="btn-label"><i class="fa fa-file-text-o"></i></span>&nbsp;Lihat</a></td>
                            </tr>
                            <?php
                                        $no++;
                                    }
                            ?>
                            </tbody>



                            <tfoot>


                            </tfoot>
                        </table>
                    </div>
                    <?php
                    }
                    else
                    {
                    ?>
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Url</th>
                            <th>Aksi</th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="3">
                                <strong><?php echo "Data Kosong"; ?></strong>
                            </td>

                        </tr>
                        </tbody>



                        <tfoot>


                        </tfoot>
                    </table>
                </div>
                <?php
                }
                ?>

                    <div class="box-footer clearfix">
                        <?php echo $links;?>
                    </div>

                </div><!-- /.box -->

            </div>


            <!-- right col (We are only adding the ID to make the widgets sortable)-->

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

        <div class="modal fade" id="modalSuc">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">

                        <h4 class="modal-title">Kesalahan</h4>
                    </div>
                    <div class="modal-body">
                        <div id="msgmodal">Harus DiIsi Salah Satu!!!!</div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="btn-label"><i class="fa fa-check-square"></i></span>&nbsp;Ok</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->



        </div><!-- /.row (main row) -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->