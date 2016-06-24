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
                        <h3 class="box-title">Data Tabel Berita</h3>
                        <div class="box-tools">
                            <div class="input-group">
                                <a href="<?php echo site_url('databerita');?>" class="btn btn-info btn-flat">Kembali</a>
                            </div>
                        </div>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body table-responsive">

                        <?php
                        if($berita_list !==""){
                        if (count($berita_list) > 0) {
                        $no = $offset + 1;
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
                            foreach ($berita_list as $rows) {
                                $berita = $rows['isi_berita'];
                                $berita = character_limiter($berita, 250);
                                ?>

                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $rows['judul']; ?></td>
                                    <td><?php echo date("d-m-Y", strtotime($rows['tanggal'])); ?></td>
                                    <td><?php echo date('G:i', strtotime($rows['waktu'])); ?></td>
                                    <td><?php echo $berita; ?></td>
                                    <td align="center"><a href="javascript:void(0)" id="btnview"
                                                          onclick="show(<?php echo $rows['id_berita']; ?>);"
                                                          class="btn btn-primary btn-sm btn-labeled btn-flat"><span
                                                class="btn-label"><i
                                                    class="fa fa-file-text-o"></i></span>&nbsp;Lihat</a></td>
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
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Isi berita</th>
                            <th>Selengkapnya</th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="6">
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
                }
                ?>
                <?php echo validation_errors(); ?>
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



        </div><!-- /.row (main row) -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->