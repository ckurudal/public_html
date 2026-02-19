
<?php 	

	require "../sistem/baglan.php";  
	require "../sistem/fonksiyon.php";  
	
	$do= $_GET["do"];
	
	$islemno = $_GET['islemno'] + 1;	  
	
	$id = $_GET["id"];
	
?>

<?php if(yetki() != 0): ?>

	<!-- UYE PAKETI VARSA -->

	<?php if (m_paket_say($_SESSION["id"])>0): ?>
		
		<div class="alert alert-warning fade in text-center">
			
			<strong>Uyarı: </strong>İlan başına toplam <strong><?php echo m_paket_limit($_SESSION["id"], "resim_limit"); ?></strong> adet resim gösterilir. Daha fazla resim göstermek isterseniz <a target="_blank" href="index.php?do=siparisler/siparisler&paket=magaza"><strong>üyelik paketi</strong></a> satın alabilirsiniz.
			
		</div>
		
		<br>
		
	<?php endif; ?>

	<!-- UYE PAKETI YOKSA -->

	<?php if (!m_paket_say($_SESSION["id"])>0): ?>

		<div class="alert alert-warning fade in text-center">

			<strong>Uyarı: </strong>İlan başına toplam <strong><?php echo uye_standart_ayar(yetki(), "resim_limit"); ?></strong> adet resim gösterilir. Daha fazla resim göstermek isterseniz <a target="_blank" href="index.php?do=siparisler/siparisler&paket=magaza"><strong>üyelik paketi</strong></a> satın alabilirsiniz.
		
		</div>
		
		<br>

	<?php endif; ?>
	
<?php endif; ?>

<div id="resimkolon" class="row">
	
	<?php 
	
	// resmi yüklerken göster
	
	if ($do == "resimver")
	{
			
		$resimver = $vt->query("SELECT * FROM emlak_resim WHERE emlakno='$islemno' ORDER BY id DESC");
			
		while ($resimcek = $resimver->fetch())
			
	{
		
	?>

	<div id="tekli" class="col-md-4">
	
	  <div class="well">
	  
		<a class="res" href="../uploads/resim/<?=$resimcek["resimad"];?>" target="_blank">
		  
		  <img class="ekle-resim img-responsive" src="../uploads/resim/<?php echo $resimcek["resimad"]; ?>"/>
		  
		</a>  
		
		<div class="sMesaj btn-block">
		  
		  <a id="teksil" class="btn btn-default btn-block" onclick="resimsil(<?=$resimcek[id];?>)" data-id="<?=$resimcek[id];?>">
			
			<i class="fa fa-trash"></i> Sil
			
		  </a> 
		  
		  <br> 
		  
		  <a id="silGoster" class="btn btn-danger btn-block"> <span> Silindi </span> </a>
		  
		</div>
    <div class="form-group">
      <div class="input-group">
        <span class="input-group-addon">Sıra</span>
        <input type="text" class="form-control text-center" name="resimsira[<?=$resimcek['id']?>]" value="<?=$resimcek['sira']?>">
      </div>
    </div>
		
	  </div>
	  
	</div> 
	
	<?php } ?>
	
</div>

<div class="alert alert-warning fade in text-center">

	<i class="icon-remove close" data-dismiss="alert"></i>
	
	<strong>Vitrin/Kapak Resmi</strong> ve resim sıralama ayarları resim yönetiminden yapılmaktadır.

</div>

<?php } ?>

<?php
  // yüklenen resimler sil
  if ($do == "resimsil") {
	  
    $islemno = $_GET['islemno'] + 1;
	
    $id = $_GET["id"];

    $query = $vt->query("select * from emlak_resim where id = '$id' and emlakno = '$islemno'");
    $row = $query->fetch();
    $resimad = $row["resimad"];
    unlink("../uploads/resim/".$resimad);

    $resimsil = $vt->query("delete from emlak_resim where id = '$id' and emlakno = '$islemno'");
  } 
?>

<script>
  // plupload resim yukleme
  $(function() {
    $("#flash_uploader").pluploadQueue({
      runtimes : 'html5',   // Gönderme metodu
      url : 'plugins/plupload/upload.php<?php if(isset($_GET["islemno"])){echo "?id=".$_GET["islemno"];} ?>',   // Yükleme işlemi yapılacak dosya
      chunk_size : '1mb',   // Azami parça boyutu boyutu
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
