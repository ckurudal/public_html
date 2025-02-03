<?php 
	
	require "../sistem/baglan.php";  
	
	$do= $_GET["do"];
?>   
<script>
  // plupload resim yukleme
  $(function() {
    $("#flash_uploader").pluploadQueue({
      runtimes : 'html5',   // Gönderme metodu
      url : 'plugins/plupload/upload_resim_ekle.php',   // Dosyaları işecek php betiği
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

  $(function(){
    $(this).on("click", "#teksil", function(){ 
      $(this).hide(); 
    });
  }); 

</script>
