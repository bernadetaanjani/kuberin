    <body class="skin-green">
        <div class="wrapper">
      
            <header class="main-header">
                <!-- Logo -->
                <a href="<?php echo site_url();?>" class="logo"><b>Kuberin</b> Administrator</a>
                <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo $base_url; ?>assets/dist/img/avatar5.png" class="user-image" alt="User Image"/>
                                    <span class="hidden-xs"><?php echo $username;?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="<?php echo $base_url; ?>assets/dist/img/avatar5.png" class="img-circle" alt="User Image" />
                                        <p>
                                            <?php echo $username;?>
                                        </p>
                                    </li>
                      
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                        
                                        <div class="pull-right">
                                            <a href="<?php echo site_url('home/logout');?>" class="btn btn-default btn-flat"><i class="fa fa-fw fa-power-off"></i>Log out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <section class="sidebar">
                <!-- Sidebar user panel -->
                    <ul class="sidebar-menu">
                        <li class="header">MAIN NAVIGATION</li>
                        <li class="<?php echo $nav_scrap ;?> treeview">
                            <a href="<?php echo site_url('scraping');?>">
                                <i class="fa fa-dashboard"></i> <span>Scraping Berita</span></i>
                            </a>
                        </li>
                        <li class="<?php echo $nav_data ;?> treeview">
                            <a href="<?php echo site_url('databerita');?>">
                                <i class="fa fa-table"></i> <span>Data Berita</span>
                            </a>
                        </li>
                        <li class="<?php echo $nav_tags ;?><?php echo $nav_kategori ;?> treeview">
                            <a href="#">
                                <i class="fa fa-gear"></i> <span>Pengaturan</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php echo $nav_tags ;?>">
                                    <a href="<?php echo site_url('datatags');?>"><i class="fa fa-code"></i> Tags</a>
                                </li>
                                <li class="<?php echo $nav_kategori ;?>">
                                    <a href="<?php echo site_url('kategori');?>"><i class="fa fa-list-ol"></i> Kategori</a>
                                </li>

                            </ul>
                        </li>

                        <li class="<?php echo $nav_summarize ;?><?php echo $nav_summarizebaru ;?> <?php echo $nav_summarizevalen ;?> treeview">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>Summarize Berita</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php echo $nav_summarize ;?>">
                                    <a href="<?php echo site_url('summarize');?>"><i class="fa fa-plus-square"></i> Ver 1</a>
                                </li>
                                <li class="<?php echo $nav_summarizebaru ;?>">
                                    <a href="<?php echo site_url('summarizebaru');?>"><i class="fa fa-plus-square"></i> Ver 2</a>
                                </li>
                                <li class="<?php echo $nav_summarizevalen ;?>">
                                    <a href="<?php echo site_url('summarizevalen');?>"><i class="fa fa-plus-square"></i> Ver 3</a>
                                </li>

                            </ul>
                        </li>
                        <li class="<?php echo $nav_datalatih ;?> treeview">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>Analisis Sentimen</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php echo $nav_datalatih ;?>">
                                    <a href="<?php echo site_url('datalatih');?>"><i class="fa fa-plus-square"></i> Data Latih</a>
                                </li>
                                <li class="<?php echo $nav_naivebayes;?>">
                                    <a href="<?php echo site_url('naivebayes');?>"><i class="fa fa-plus-square"></i>Naive Bayes</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </section>
            <!-- /.sidebar -->
            </aside>