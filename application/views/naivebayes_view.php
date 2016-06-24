            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
            <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Data Latih
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="<?php echo $nav_scrap;?>">Pengelolaan Data Latih</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <!-- Small boxes (Stat box) -->
       
                    <!-- Main row -->
                    

                    <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Data Tabel Berita</h3>
                        <a style="" href="<?php echo site_url('datalatih/tambah');?>">Tambah Data Latih</a>

                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body table-responsive">

                            <?php
                                if(count($data_latih) > 0) {
                                $no = $offset+1;
                            ?>
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th style="max-width:200px;">Judul</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th style="max-width:700px;">Isi berita</th>
                                <th>Sentimen</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                    foreach($data_latih as $rows)
                                    {
                                $berita=$rows['isi_berita'];
                                // $berita=character_limiter($berita,250);
                            ?>

                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $rows['judul']; ?></td>
                                <td><?php echo date("d-m-Y", strtotime($rows['tanggal'])); ?></td>
                                <td><?php echo date('G:i',strtotime($rows['waktu'])); ?></td>
                                <td ><?php echo $berita; ?></td>
                                <td align="center">
                                    <a href="<?php echo site_url('datalatih') ?>/positif/<?php echo $rows['id_berita'] ?>" style="background-color:blue; margin:5px; width:60px; " id="btnview" onclick="show(<?php echo $rows['id_berita']; ?>);"  class="btn btn-primary btn-sm btn-labeled btn-flat"><span class="btn-label"></span>&nbsp;Positif</a>
                                    <a href="<?php echo site_url('datalatih') ?>/negatif/<?php echo $rows['id_berita'] ?>" style="background-color:red; margin:5px; width:60px;" id="btnview" onclick="show(<?php echo $rows['id_berita']; ?>);"  class="btn btn-primary btn-sm btn-labeled btn-flat"><span class="btn-label"></span>&nbsp;Negatif</a>
                                    <a href="<?php echo site_url('datalatih') ?>/netral/<?php echo $rows['id_berita'] ?>" style="background-color:green; margin:5px; width:60px;" id="btnview" onclick="show(<?php echo $rows['id_berita']; ?>);"  class="btn btn-primary btn-sm btn-labeled btn-flat"><span class="btn-label"></span>&nbsp;Netral</a>
                                
                                    
                                </td>
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

                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        
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
                    <p>Page rendered in <strong>{elapsed_time}</strong> seconds</p>

                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->