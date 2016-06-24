<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo $base_url; ?>assets/img/logo.ico">

    <title><?php echo $page_title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo $base_url; ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>assets/css/style.css" rel="stylesheet" type="text/css">

  </head>

  <body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">

          <a class="navbar-brand" href="#">Kuberin Administrator</a>
        </div>
        <!--/.nav-collapse -->
      </div>
    </nav>
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
              <div class="col-lg-3">
                  <div class="judullogo">
                    <img src="<?php echo $base_url; ?>assets/dist/img/avatar5.png" class="img-responsive" alt="User Image"/>
                  </div>

              </div>
              <div class="col-lg-9">
                <div class="judulhome">
                  <h1>Selamat Datang di <strong>Kuberin</strong></h1>
                  <h3>Kumpulan Berita Indonesia Admin Panel</h3>

                </div>
              </div>
                
          </div>
          <div class="col-lg-4">
          <div class="panellogin">
            <div class="panel panel-primary">
              <div class="panel-heading form-login-heading">
                <h1 class="panel-title">Please sign in</h1>
              </div>
              <div class="panel-body panelbdy">
                <div accept-charset="UTF-8" role="form">
                  <?php echo form_open('home/login', array('id'=>'form')); ?>
                  <fieldset>
                    <div class="control-group">
                      <div class="input-group form-group controls">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
                      </div>
                      <p class="help-block"></p>
                    </div>
                    <div class="control-group">
                      <div class="input-group form-group controls">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                      </div>
                      <p class="help-block"></p>
                    </div>
                      <div id = "msg-container" class="error"></div>

                    <input class="btn btn-lg btn-info btn-block" type="submit" value="Login">
                  </fieldset>
                </div>
                <?php echo form_close(); ?>
              </div>
            </div>
            
          </div>
            
            
          </div>
        </div>   
        
      </div> <!-- /container -->
      
    </div>
    <footer class="footer">
      <div class="container">
        <p><strong>Copyright &copy; 2015 KUBERIN </strong> Kumpulan Berita Indonesia. Designed by Andry Setiawan | All Rights Reserved</p>
      </div>  

    </footer>

    <script type="text/javascript" src="<?php echo $base_url;?>assets/js/jquery.min.js"></script>   
    <script type="text/javascript" src="<?php echo $base_url;?>assets/js/TweenLite.min.js"></script>
    <script type="text/javascript" src="<?php echo $base_url;?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
      $(document).mousemove(function(event) {
          TweenLite.to($(".content"), 
          .5, {
              css: {
                  backgroundPosition: "" + parseInt(event.pageX / 8) + "px " + parseInt(event.pageY / '12') + "px, " + parseInt(event.pageX / '15') + "px " + parseInt(event.pageY / '15') + "px, " + parseInt(event.pageX / '30') + "px " + parseInt(event.pageY / '30') + "px",
                "background-position": parseInt(event.pageX / 8) + "px " + parseInt(event.pageY / 12) + "px, " + parseInt(event.pageX / 15) + "px " + parseInt(event.pageY / 15) + "px, " + parseInt(event.pageX / 30) + "px " + parseInt(event.pageY / 30) + "px"
              }
            })
          })
        })
        $(function(){
            $('#form').submit(function(){
                $.post($('#form').attr('action'),$('#form').serialize(),function(json){
                    if(json.st == 0 )
                    {
                        $('#msg-container').html(json.msg);
                    }
                    else
                    {
                        window.location = json.msg;
                    }

                },'json');
                return false;
            });
        });
    </script>
  </body>
</html>
