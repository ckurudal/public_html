<?php
	require_once "../sistem/baglan.php"; 
	require_once "../sistem/fonksiyon.php"; 
	define("ADMIN", true);
  $stmt_kullanici = $vt->prepare("SELECT * FROM yonetici WHERE id = ?");
  $stmt_kullanici->execute([$_SESSION["id"]]);
  $kullanici = $stmt_kullanici->fetch();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title> <?php echo $ayar['site_adi']; ?> </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro-v6@44659d9/css/all.min.css" rel="stylesheet" type="text/css" />
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/iCheck/all.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <?php if ($kullanici["yetki"] == 0) { ?>
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <?php } ?>
  <?php if ($kullanici["yetki"] != 0) { ?>
  <link rel="stylesheet" href="dist/css/uye_panel.css">    
  <link rel="stylesheet" href="dist/css/skins/uye_panel.min.css">
  <?php } ?>
  <!-- plupload css -->
  <link rel="stylesheet" href="plugins/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css" type="text/css" media="screen" />
  <link href="https://fonts.googleapis.com/css?family=Titillium+Web:200,200i,300,300i,400,400i,600,600i,700,700i,900" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="bower_components/froalaeditor/css/froala_editor.css"> 
  <link rel="stylesheet" href="bower_components/froalaeditor/css/plugins/code_view.css"> 
  <link rel="stylesheet" href="bower_components/froalaeditor/css/plugins/video.css"> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>  
  <script src="//cdn.ckeditor.com/4.15.1/full/ckeditor.js"></script>
  <!-- Data Table -->
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> 
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition fixed skin-black sidebar-mini">
<?php
	if($_SESSION['uyelogin']) {
		require_once "inc/default.php";
	} else {
		go("giris.php", 0);
	}
?>
<!-- ./wrapper -->
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- production -->
<script type="text/javascript" src="plugins/plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="plugins/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
<script type="text/javascript" src="plugins/plupload/js/i18n/tr.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- Data Tables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll -->
<!-- <script src="bower_components/jquer-slimscroll/jquery.slimscroll.min.js"></script> -->
<!-- iCheck 1.0.1 -->
<script src="plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- CK Editor -->
<script src="bower_components/ckeditor/ckeditor.js"></script>   
  <script type="text/javascript" src="bower_components/froalaeditor/js/froala_editor.min.js"></script> 
  <script type="text/javascript" src="bower_components/froalaeditor/js/plugins/code_view.min.js"></script> 
  <script type="text/javascript" src="bower_components/froalaeditor/js/plugins/video.min.js"></script> 
  <script type="text/javascript" src="bower_components/froalaeditor/js/languages/tr.js"></script> 
<!-- Page script -->
<script type="text/javascript">
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 YYY-mm-dd
    $('#datemask2').inputmask('YYY-mm-dd', { 'placeholder': 'YYY-mm-dd' })
    //Money Euro
    $('[data-mask]').inputmask()
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'YYY-mm-dd h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })
    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()
    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  });
  // CK EDITOR SETTINGS 
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1');
    CKEDITOR.replace('editor2');
    CKEDITOR.replace('uyelik_sozlesmesi');
    CKEDITOR.replace('gizlilik');
    CKEDITOR.replace('ilan_verme_kurallari');
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  });
  // plupload resim yukleme
  $(function() {
    $("#flash_uploader").pluploadQueue({
      runtimes : 'html5',   // Gönderme metodu
      url : 'plugins/plupload/upload.php<?php if(isset($islemno) && !empty($islemno)) { echo '?id='.$islemno; } ?>',   // Dosyaları işecek php betiği
      chunk_size : '1mb',   // Azami paröa boyutu boyutu
      unique_names : true,       
      filters : {
        max_file_size : '15mb', // Azami dosya boyutu
        mime_types: [
          {title : "Fotoğrafları seçin", extensions : "jpg,JPG,JPEG,jpeg,png,gif,PNG,GIF"} // Destek verilecek uzantılar  extensions : "jpg,gif,png"          
        ]
      },
        init : {
        FilesAdded: function(up, files) {
          up.start();
       $("#resimgetir").html('<p style="font-size:16px; text-align:center;"><strong><i class="fa fa-spinner fa-2x fa-spin" style="color:#ff0000!important"></i> Lütfen bekleyiniz, işlemleriniz tamamlanıyor</strong><br><span style="font-size:13px;">Yükleme hızı internet hızınıza bağlı olarak değişkenlik gösterebilir.</span></p>')
        }},
      // Eğer mümkünse resimleri tarayicida yeniden boyutlandır
      resize : {width : 800, height : 800, quality : 90},
      // Flash settings
      flash_swf_url : 'plugins/plupload/js/Moxie.swf'   // Yükleyici SWF dosyasının patikası ve adı
    });
    $("#resim_duzenle").pluploadQueue({
      runtimes : 'html5',   // Gönderme metodu
      url : 'plugins/plupload/upload_resim_ekle.php?id=<?=$id;?>',   // Dosyaları işecek php betiği
      chunk_size : '1mb',   // Azami paröa boyutu boyutu
      unique_names : true,       
      filters : {
        max_file_size : '15mb', // Azami dosya boyutu
        mime_types: [
          {title : "Fotoğrafları seçin", extensions : "jpg,JPG,JPEG,jpeg,png,gif,PNG,GIF"} // Destek verilecek uzantılar  extensions : "jpg,gif,png"          
        ]
      },
        init : {
        FilesAdded: function(up, files) {
          up.start();
       $("#resimgetir").html('<p style="font-size:16px; text-align:center;"><strong><i class="fa fa-spinner fa-2x fa-spin" style="color:#ff0000!important"></i> Lütfen bekleyiniz, işlemleriniz tamamlanıyor</strong><br><span style="font-size:13px;">Yükleme hızı internet hızınıza bağlı olarak değişkenlik gösterebilir.</span></p>')
        }},
      // Eğer mümkünse resimleri tarayicida yeniden boyutlandır
      resize : {width : 800, height : 800, quality : 90},
      // Flash settings
      flash_swf_url : 'plugins/plupload/js/Moxie.swf'   // Yükleyici SWF dosyasının patikası ve adı
    });
        var uploader = $('#flash_uploader').pluploadQueue();
        uploader.bind('FileUploaded', function() {
            if (uploader.files.length == (uploader.total.uploaded + uploader.total.failed)) {
                resimsonuc();
            }
        });
  });
function bs_input_file() {
    $(".input-file").before(
      function() {
        if ( ! $(this).prev().hasClass('input-ghost') ) {
          var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
          element.attr("name",$(this).attr("name"));
          element.change(function(){
            element.next(element).find('input').val((element.val()).split('\\').pop());
          });
          $(this).find("button.btn-choose").click(function(){
            element.click();
          });
          $(this).find("button.btn-reset").click(function(){
            element.val(null);
            $(this).parents(".input-file").find('input').val('');
          });
          $(this).find('input').css("cursor","pointer");
          $(this).find('input').mousedown(function() {
            $(this).parents('.input-file').prev().click();
            return false;
          });
          return element;
        }
      }
    );
  }
  $(function() {
    bs_input_file();
  });
</script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('YYY-mm-dd', { 'placeholder': 'YYY-mm-dd' })
    //Datemask2 YYY-mm-dd
    $('#datemask2').inputmask('YYY-mm-dd', { 'placeholder': 'YYY-mm-dd' })
    //Money Euro
    $('[data-mask]').inputmask()
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, locale: { format: 'YYY-mm-dd hh:mm A' }})
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })
    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()
    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>   				
<script>
    /* DIV HTML SIRALAMA */
    var toSort = document.getElementById('list').children;
    toSort = Array.prototype.slice.call(toSort, 0);
    toSort.sort(function(a, b) {
        var aord = +a.id.split('-')[1];
        var bord = +b.id.split('-')[1];
        // two elements never have the same ID hence this is sufficient:
        return (aord > bord) ? 1 : -1;
    });
    var parent = document.getElementById('list');
    parent.innerHTML = "";
    for(var i = 0, l = toSort.length; i < l; i++) {
        parent.appendChild(toSort[i]);
    }
</script>  
<script>
    function formAc1(element)
    {
        $("#daire_kiralama").attr("style","display: block !important");
    }
    function formKapat1(element)
    {
        $("#daire_kiralama").attr("style","display: none !important");
    }
    function sifreAc(element)
    {
        $("#sifreGoster").attr("style","display: block !important");
    }
    function sifreKapat(element)
    {
        $("#sifreGoster").attr("style","display: none !important");
    }
</script> 
</body>
</html>