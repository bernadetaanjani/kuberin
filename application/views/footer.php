			<footer class="main-footer">
			
				<strong>Copyleft &copy; 2015 KUBERIN </strong> Kumpulan Berita Indonesia. ADMIN LTE Template Edited by Andry Setiawan
			</footer>
		</div><!-- ./wrapper -->

    <!-- jQuery 2.1.3 -->
    <script src="<?php echo $base_url; ?>assets/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo $base_url; ?>assets/js/bootstrap.min.js" type="text/javascript"></script> 
	<!-- DATA TABES SCRIPT -->
    <script src="<?php echo $base_url; ?>assets/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="<?php echo $base_url; ?>assets/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>	
    <!-- Morris.js charts -->
    <script src="<?php echo $base_url; ?>assets/dist/js/raphael-min.js"></script>
    <script src="<?php echo $base_url; ?>assets/plugins/morris/morris.min.js" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="<?php echo $base_url; ?>assets/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="<?php echo $base_url; ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="<?php echo $base_url; ?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo $base_url; ?>assets/plugins/knob/jquery.knob.js" type="text/javascript"></script>
    
	<!-- daterangepicker -->
    <script src="<?php echo $base_url; ?>assets/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <!-- datepicker -->
    <script src="<?php echo $base_url; ?>assets/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="<?php echo $base_url; ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="<?php echo $base_url; ?>assets/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <!-- Slimscroll -->
    <script src="<?php echo $base_url; ?>assets/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='<?php echo $base_url; ?>assets/plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="<?php echo $base_url; ?>assets/dist/js/app.min.js" type="text/javascript"></script>

	<!-- page script -->
    <script type="text/javascript">
        $('.input-group.date').datepicker({
            format: "yyyy-mm-dd",
            todayBtn: "linked",
            orientation: "top left",
            todayHighlight: true
        });
        $('#btnsimpan').prop('disabled', true);
        $('#reservation').daterangepicker({format: 'YYYY/MM/DD'});
        $('#example2').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });
        function show(id)
        {

            var info = 'id=' + id;
            $.ajax({
                type: "POST",
                url : "<?php echo site_url('databerita/tampilberita')?>",
                dataType: "json",
                data: info,
                success: function(data){
                    $("#modalBerita").modal('show');
                    $("#judulberita").text(data.judul);
                    $("#tanggaldanwaktu").text(data.tanggaldanwaktu);
                    $("#kategoriberita").text(data.kategori);
                    $("#gambarberita").attr("src",data.gambar);
                    $("#isiberita").html(data.isiberita);
                    $("#linkberitabtn").attr("href", data.link);
                    $("#sumber").html(data.link);

                }
            });
            return false;

        }
        function edittags(id)
        {
            var info = 'id=' + id;
            $.ajax({
                type: "POST",
                url : "<?php echo site_url('datatags/tampiltags')?>",
                dataType: "json",
                data: info,
                success: function(data){
                    $("#sumberberita").val(data.sumberberita);
                    $("#url").val(data.url);
                    $("#taglink1").val(data.taglink1);
                    $("#taglink2").val(data.taglink2);
                    $("#taglink3").val(data.taglink3);
                    $("#tagjudul1").val(data.judulberita1);
                    $("#tagjudul2").val(data.judulberita2);
                    $("#tagkategori1").val(data.kategoriberita1);
                    $("#tagkategori2").val(data.kategoriberita2);
                    $("#tagtanggal1").val(data.tanggalberita1);
                    $("#tagtanggal2").val(data.tanggalberita2);
                    $("#taggambar1").val(data.gambarberita1);
                    $("#taggambar2").val(data.gambarberita2);
                    $("#tagberita1").val(data.isiberita1);
                    $("#tagberita2").val(data.isiberita2);
                    $("#tagbuangkonten").val(data.buangkonten);
                    $("#pagination1").val(data.pagination1);
                    $("#pagination2").val(data.pagination2);

                    $('#btnsimpan').prop('disabled', true);
                    $('#btntest').removeAttr('disabled');
                    $("#penandalink").hide();
                    $("#penandajudul").hide();
                    $("#penandakat").hide();
                    $("#penandatgl").hide();
                    $("#penandawkt").hide();
                    $("#penandagambar").hide();
                    $("#penandaisi").hide();
                    $("#linkber").hide();
                    $("#judulber").hide();
                    $("#kategoriber").hide();
                    $("#tanggalber").hide();
                    $("#waktuber").hide();
                    $("#gambarber").hide();
                    $("#isiber").hide();
                    $("#datatest").show();

                }
            });
            return false;

        }

      $(function () {
        $("#example1").dataTable();
      });
      $(document).ready(function(){
          $("input[type=submit]").click(function() {
              formButton = $(this).val();
          });

          $("#btntest").click(function(){
              var formData = $("#formscrap").serialize()
              formData+="&select="+formButton;
              $("#LoadingImageHijau").show();
              $("#btntest").hide();

              $.post($("#formscrap").attr('action'),
                  formData,

                  function(json) {
                      if (json.msg == "true")
                      {
                          $("#penandalink").show();
                          $("#penandajudul").show();
                          $("#penandakat").show();
                          $("#penandatgl").show();
                          $("#penandawkt").show();
                          $("#penandagambar").show();
                          $("#penandaisi").show();
                          $("#linkber").show();
                          $("#judulber").show();
                          $("#kategoriber").show();
                          $("#tanggalber").show();
                          $("#waktuber").show();
                          $("#gambarber").show();
                          $("#isiber").show();
                          $("#linkber").html(json.linkurl);
                          $("#judulber").html(json.judul);
                          $("#kategoriber").html(json.kategori);
                          $("#tanggalber").html(json.tanggal);
                          $("#waktuber").html(json.waktu);
                          $("#gambarber").html(json.gambar);
                          $("#isiber").html(json.isiberita);
                          $("#LoadingImageHijau").hide();
                          $("#datatest").hide();
                          $("#btntest").show();
                          $("#msg").hide();
                          $('#btnsimpan').prop('disabled', false);
                          $('#btnsimpan').removeAttr('disabled');
                      }
                      else
                      {
                          $("#penandalink").hide();
                          $("#penandajudul").hide();
                          $("#penandakat").hide();
                          $("#penandatgl").hide();
                          $("#penandawkt").hide();
                          $("#penandagambar").hide();
                          $("#penandaisi").hide();
                          $("#linkber").hide();
                          $("#judulber").hide();
                          $("#kategoriber").hide();
                          $("#tanggalber").hide();
                          $("#waktuber").hide();
                          $("#gambarber").hide();
                          $("#isiber").hide();
                          $("#LoadingImageHijau").hide();
                          $("#datatest").hide();
                          $("#btntest").show();
                          $("#msg").show();
                          $("#msg").html(json.msg);

                      }


                  },
                 'json');
              return false;
          });
          $("#btnsimpan").click(function(){
              var formData = $("#formscrap").serialize()
              formData+="&select="+formButton;
              $("#LoadingImageBiru").show();
              $("#btnsimpan").hide();
              $("#msg").hide();

              $.post($("#formscrap").attr('action'),
                  formData,

                  function(json){
                      if(json.st == 0 )
                      {
                          $('#msg').show();
                          $('#msg').html(json.msg);
                          $("#LoadingImageBiru").hide();
                          $("#penandalink").hide();
                          $("#penandajudul").hide();
                          $("#penandakat").hide();
                          $("#penandatgl").hide();
                          $("#penandawkt").hide();
                          $("#penandagambar").hide();
                          $("#penandaisi").hide();
                          $("#linkber").hide();
                          $("#judulber").hide();
                          $("#kategoriber").hide();
                          $("#tanggalber").hide();
                          $("#waktuber").hide();
                          $("#gambarber").hide();
                          $("#isiber").hide();
                          $("#datatest").hide();
                          $("#btnsimpan").show();

                      }
                      else
                      {
                          $("#LoadingImageBiru").hide();
                          $("#datatest").show();
                          $("#penandalink").hide();
                          $("#penandajudul").hide();
                          $("#penandakat").hide();
                          $("#penandatgl").hide();
                          $("#penandawkt").hide();
                          $("#penandagambar").hide();
                          $("#penandaisi").hide();
                          $("#linkber").hide();
                          $("#judulber").hide();
                          $("#kategoriber").hide();
                          $("#tanggalber").hide();
                          $("#waktuber").hide();
                          $("#gambarber").hide();
                          $("#isiber").hide();
                          $("#btnsimpan").show();
                          $("#modalSuc").modal({
                              backdrop: 'static',
                              keyboard: false
                          });
                          $("#msgmodal").html(json.msg);

                      }


                  },
                  'json');
              return false;


          });
          $("#btnoke").click(function(){
              window.location = 'scraping';
          });

          $("#btnoketags").click(function(){
              window.location = 'datatags';
          });
          $("#btnokekategori").click(function(){
              window.location = 'kategori';
          });
          $("#simpankategori").click(function(){
              $.post($("#formkategori").attr('action'),$("#formkategori").serialize(),
                  function(json){
                      if(json.st == 0 )
                      {
                          $('#msg').show();
                          $('#msg').html(json.msg);
                      }
                      else
                      {
                          $("#modalSuc").modal({
                              backdrop: 'static',
                              keyboard: false
                          });
                          $("#msgmodal").html(json.msg);

                      }
                  },
                  'json');
              return false;

          });
          $("#simpankategoriberita").click(function(){
              $.post($("#formkat").attr('action'),$("#formkat").serialize(),
                  function(json){
                      if(json.st == 1 )
                      {
                          $("#modalSuc").modal({
                              backdrop: 'static',
                              keyboard: false
                          });
                          $("#msgmodal").html(json.msg);

                      }
                      else
                      {
                          $('#msgkat').show();
                          $('#msgkat').html(json.msg);

                      }
                  },
                  'json');
              return false;

          });
          $("#simpanhubberita").click(function(){
              $.post($("#formkathub").attr('action'),$("#formkathub").serialize(),
                  function(json){
                      if(json.st == 1 )
                      {
                          $('#msgkatutama').hide();
                          $('#msgkatberita').hide();
                          $("#modalSuc").modal({
                              backdrop: 'static',
                              keyboard: false
                          });
                          $("#msgmodal").html(json.msg);

                      }
                      else if(json.st == 2)
                      {
                          $('#msgkatutama').show();
                          $('#msgkatutama').html(json.msg1);
                          $('#msgkatberita').show();
                          $('#msgkatberita').html(json.msg2);
                      }
                      else if(json.st == 3)
                      {
                          $('#msgkatberita').hide();
                          $('#msgkatutama').show();
                          $('#msgkatutama').html(json.msg1);

                      }

                      else
                      {
                          $('#msgkatutama').hide();
                          $('#msgkatberita').show();
                          $('#msgkatberita').html(json.msg2);

                      }
                  },
                  'json');
              return false;

          });
          $("#summarizeberita").click(function(){
              $("#tblkalimat tr td").remove();
              $("#tblscore tr td").remove();

              $.post($("#formsummarize").attr('action'),$("#formsummarize").serialize(),
                  function(json){
                      if(json.st == 0 )
                      {
                          $('#msg').show();
                          $('#msg').html(json.msg);
                          $("#penandaisi").hide();
                          $("#isiber").hide();
                          $("#datatest").hide();
                          $("#penandatblscore").hide();
                          $("#penandatblkalimat").hide();
                          $("#tblscore").hide();
                          $("#tblkalimat").hide();

                      }
                      else if(json.st == 1)
                      {
                          $("#penandaisi").show();
                          $("#isiber").show();
                          $("#isiber").html(json.msg);
                          $("#datatest").hide();
                          $("#msg").hide();
                          $("#penandatblscore").show();
                          $("#penandatblkalimat").show();
                          $("#tblscore").show();
                          $("#tblkalimat").show();
                          drawTableScore(json.sum_score);
                          drawTableKalimat(json.kalimat);


                      }
                      else
                      {

                          $('#msg').show();
                          $('#msg').html(json.msg);
                          $("#penandaisi").hide();
                          $("#isiber").hide();
                          $("#datatest").hide();
                          $("#penandatblscore").hide();
                          $("#penandatblkalimat").hide();
                          $("#tblscore").hide();
                          $("#tblkalimat").hide();

                      }

                  },
                  'json');
              return false;


          });
          $("#caridata").click(function(){
              if($('#katakunci').val() == '' && $('#reservation').val()=='' && $('#optsumberberita').val()==''){
                  $("#modalSuc").modal({
                      backdrop: 'static',
                      keyboard: false
                  });
                  return false;
              }
          });
          $("#getberita").click(function(){
              $("#tblberitasum tr td").remove();

              $.post($("#formgetberita").attr('action'),$("#formgetberita").serialize(),
                  function(json){
                      if(json.st == 0)
                      {
                          $('#msgbaru').show();
                          $('#msgbaru').html(json.msg);
                          $("#penandaisi").hide();
                          $("#isiber").hide();
                          $("#penandatblscore").hide();
                          $("#penandatblkalimat").hide();
                          $("#tblscore").hide();
                          $("#tblkalimat").hide();
                          $("#tblberitasum").hide();
                          $('#sumberita').prop('disabled', true);

                      }
                      else if(json.st==1)
                      {
                          $('#msgbaru').hide();
                          $("#penandaisi").hide();
                          $("#isiber").hide();
                          $("#penandatblscore").hide();
                          $("#penandatblkalimat").hide();
                          $("#tblscore").hide();
                          $("#tblkalimat").hide();
                          $("#tblberitasum").show();
                          drawTableBerita(json.msg.berita);
                          tampilKK(json.msg.kk);
                          $('#sumberita').removeAttr('disabled');


                      }
                      else
                      {
                          $('#msgbaru').show();
                          $('#msgbaru').html(json.msg);
                          $("#penandaisi").hide();
                          $("#isiber").hide();
                          $("#penandatblscore").hide();
                          $("#penandatblkalimat").hide();
                          $("#tblscore").hide();
                          $("#tblkalimat").hide();
                          $("#tblberitasum").hide();
                          $('#sumberita').prop('disabled', true);

                      }

                  },
                  'json');
              return false;
          });
          $("#sumberita").click(function(){
              $("#tblkalimat tr td").remove();
              $("#tblscore tr td").remove();

              $.post($("#formsumbaru").attr('action'),$("#formsumbaru").serialize(),
                  function(json){
                      if(json.st == 0 )
                      {
                          $('#msgkat').show();
                          $('#msgkat').html(json.msg);
                          $("#penandaisi").hide();
                          $("#isiber").hide();
                          $("#datatest").hide();
                          $("#penandatblscore").hide();
                          $("#penandatblkalimat").hide();
                          $("#tblscore").hide();
                          $("#tblkalimat").hide();

                      }
                      else if(json.st == 1)
                      {
                          $("#penandaisi").show();
                          $("#isiber").show();
                          $("#isiber").html(json.msg);
                          $("#datatest").hide();
                          $("#msgkat").hide();
                          $("#penandatblscore").show();
                          $("#penandatblkalimat").show();
                          $("#tblscore").show();
                          $("#tblkalimat").show();
                          drawTableScoreBaru(json.sum_score);
                          drawTableKalimatBaru(json.kalimat);
                      }
                      else
                      {

                          $('#msgkat').show();
                          $('#msgkat').html(json.msg);
                          $("#penandaisi").hide();
                          $("#isiber").hide();
                          $("#datatest").hide();
                          $("#penandatblscore").hide();
                          $("#penandatblkalimat").hide();
                          $("#tblscore").hide();
                          $("#tblkalimat").hide();

                      }

                  },
                  'json');
              return false;


          });

          function tampilKK(data)
          {
             /*var row = $("<tr />")
              $("#tblberitasum").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it
              row.append($('<td></td>'));
              row.append($("<td>" + data + "</td>"));
              row.append($('<td></td>'));*/
              document.getElementById("kk").value=data;
          }
          function drawTableBerita(data) {
              for (var i = 0; i < data.length; i++) {
                  drawRowBerita(data[i]);
              }
          }
          function drawRowBerita(rowData) {
              var row = $("<tr />")
              $("#tblberitasum").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it
              row.append($('<td><div class="checkbox"><label><input type="checkbox" class="minimal" name="checkboxberita[]" value="' + rowData.id_berita +'"/></label></div></td>'));
              row.append($("<td>" + rowData.judul + "</td>"));
              row.append($('<td align="center"><a href="javascript:void(0)" id="btnview" onclick="show(' + rowData.id_berita + ');"  class="btn btn-primary btn-sm btn-labeled btn-flat"><span class="btn-label"><i class="fa fa-file-text-o"></i></span>&nbsp;Lihat</a></td>'));

          }
          function drawTableScore(data) {
              for (var i = 0; i < data.length; i++) {
                  drawRowScore(data[i]);
              }
          }

          function drawRowScore(rowData) {
              var row = $("<tr />")
              $("#tblscore").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it
              row.append($("<td>" + rowData.kalimat + "</td>"));
              row.append($("<td>" + rowData.score + "</td>"));

          }
          function drawTableKalimat(data) {
              for (var i = 0; i < data.length; i++) {
                  drawRowKalimat(data[i]);
              }
          }

          function drawRowKalimat(rowData) {
              var row = $("<tr />")
              $("#tblkalimat").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it
              row.append($("<td>" + rowData.kalimat + "</td>"));
              row.append($('<td align="center"><a href="javascript:void(0)" id="btnview" onclick="show(' + rowData.id + ');"  class="btn btn-primary btn-sm btn-labeled btn-flat"><span class="btn-label"><i class="fa fa-file-text-o"></i></span>&nbsp;Lihat</a></td>'));

          }
          function drawTableScoreBaru(data) {
              for (var i = 0; i < data.length; i++) {
                  drawRowScoreBaru(data[i]);
              }
          }

          function drawRowScoreBaru(rowData) {
              var row = $("<tr />")
              $("#tblscore").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it
              row.append($("<td>" + rowData.kalimat + "</td>"));
              row.append($("<td>" + rowData.score + "</td>"));

          }
          function drawTableKalimatBaru(data) {
              for (var i = 0; i < data.length; i++) {
                  drawRowKalimatBaru(data[i]);
              }
          }

          function drawRowKalimatBaru(rowData) {
              var row = $("<tr />")
              $("#tblkalimat").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it
              row.append($("<td>" + rowData.kalimat + "</td>"));
              row.append($('<td align="center"><a href="javascript:void(0)" id="btnview" onclick="show(' + rowData.id + ');"  class="btn btn-primary btn-sm btn-labeled btn-flat"><span class="btn-label"><i class="fa fa-file-text-o"></i></span>&nbsp;Lihat</a></td>'));

          }



      });
        $('input[type="checkbox"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-green'
        });
    </script>
	</body>
</html>