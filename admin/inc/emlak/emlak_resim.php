<?php 

	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
	
	$id=$_GET['id'];
	
	$resimid=$_GET['resimid'];
	
	$kapak=$_GET['kapak'];
	
	$resim=$_GET['resim'];
	
	$resimyukle=$_GET['resimyukle'];
	
	$kapakislem = $_GET['islemno'];
	
	$ilan = $vt->query("SELECT * FROM emlak_ilan where id = '$id'");
	
	$i = $ilan->fetch();
	
	$islemno = $i['emlakno']; 
	
 ?>

 <style>
.res {
	height: 200px;
}

.sMesaj {
	height:200px;
} 
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
	<?=$i["baslik"];?> - Resim Yönetimi    
  <ol class="breadcrumb">
	<li><a href="index.php"><i class="fa fa-dashboard"></i> Anasayfa </a></li>
	<li> <a href="index.php?do=tumilanlar"> Tüm İlanlar </a> </li>
	<li class="active"> İlan Yönetimi </li>
  </ol>
</section>  
<section class="content">  
<?php 
	if ($resim == "yukle") {  
?>

		<!-- Emlak Resim Yukleme -->
		<div id="resim_duzenle">
				
			<!-- Emlak resim yükleyicisi buradan başlıyor. -->

		</div>	 
		<!-- ./ Emlak Resim Yukleme -->
		
		<div class="box"> 
			<div class="box-footer">
				<a href="index.php?do=islem&emlak=emlak_resim&id=<?=$id;?>" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-plus"></i> Yükle </a>
			 </div> 
		</div> 
			
<?php } ?>

<form method="post" action="" enctype="multipart/form-data"> 
 <?php 
 
	 if ($kapak == "degistir") {
	  
	    $kapakver = $vt->query("update emlak_resim set 
			kapak	=	'0'
			WHERE id != '$resimid' and emlakno = $islemno; 
		 "); 
		 
		 $kapakver1 = $vt->query("update emlak_resim set 
			kapak	=	'1'
			WHERE id = '$resimid' and emlakno = $islemno; 
		 ");
	   
		 $kapakver3 = $vt->query("update emlak_resim set 
			sira	=	'1'
			WHERE sira = '0' and emlakno = $islemno; 
		 "); 
		 
		 $kapakver2 = $vt->query("update emlak_resim set 
			sira	=	'0'
			WHERE kapak = '1' and emlakno = $islemno; 
		 "); 
	   
		 
		}
		
	 if ($resim == "sil") {
	  
		$resimemlakno = $islemno;
							
		// resim dosyalarini sil
		
		$resimdosya = $vt->query("select * from emlak_resim where id = '$resimid'");
			
		$resver = $resimdosya->fetch();
			 
			//echo $resver["resimad"]."<br>";
			
			$targetDir = '../uploads/resim/mini-'.$resver['resimad'];
			
			@unlink("$targetDir");  
			
			$targetDir = '../uploads/resim/'.$resver['resimad'];
			
			@unlink("$targetDir");  
		
	    $resimsil=$vt->query("DELETE FROM emlak_resim where id = '$resimid'"); 
		
		if ($resver['kapak'] == 1) {
			
			$kapak = $vt->query("update emlak_resim set kapak = '1', sira = '0' where emlakno = '$islemno' order by id asc limit 1");
			
		}
		
		}
		
		
	 if (isset($_POST["resimduzenle"])) {
		 
		$sira 	= $_POST["sira"];
		$idr 	= $_POST["idr"]; 
		
		for ($i=0; $i<count($idr); $i++) {
			$resim=$vt->query("update emlak_resim set
				sira	=	'".$sira[$i]."'
			where id = '".$idr[$i]."'");
		} 
			
		if ($resim == "1") { 
			
			go("index.php?do=islem&emlak=emlak_ilanlar&hareket=onay&id=$id",0);
		}
	 }
	 
	 
 ?>   
 
	<?php if(yetki() != 0): ?>

		<!-- UYE PAKETI VARSA -->

		<?php if (m_paket_say($_SESSION["id"])>0): ?>
			
			<div class="alert alert-warning fade in text-center">
				
				<strong>Uyarı: </strong>Listemelerde toplam <strong><?php echo m_paket_limit($_SESSION["id"], "resim_limit"); ?></strong> adet resim gösterilir. Daha fazla resim göstermek isterseniz <a target="_blank" href="index.php?do=siparisler/siparisler&paket=magaza"><strong>üyelik paketi</strong></a> satın alabilirsiniz.
				
			</div>
			
			<br>
			
		<?php endif; ?>

		<!-- UYE PAKETI YOKSA -->

		<?php if (!m_paket_say($_SESSION["id"])>0): ?>

			<div class="alert alert-warning fade in text-center">

				<strong>Uyarı: </strong>Listemelerde toplam <strong><?php echo uye_standart_ayar(yetki(), "resim_limit"); ?></strong> adet resim gösterilir. Daha fazla resim göstermek isterseniz <a target="_blank" href="index.php?do=siparisler/siparisler&paket=magaza"><strong>üyelik paketi</strong></a> satın alabilirsiniz.
			
			</div>
			
			<br>

		<?php endif; ?>
		
	<?php endif; ?>
		   
			<div class="box"> 
				<div class="box-footer">
					<a href="index.php?do=islem&emlak=emlak_resim&resim=yukle&id=<?=$id;?>" class="btn btn-success btn-lg pull-right"> <i class="fa fa-plus"></i> Yeni Resim Yükle </a>
				 </div> 
			</div>  
			
			<div class="row">
			<?php   
				$resimno = $i["emlakno"]; 
				$resimver = $vt->query("SELECT * FROM emlak_resim WHERE emlakno='$resimno' ORDER BY sira ASC");
				while ($resimcek = $resimver->fetch()) { 
				
			?>
			<div id="tekli" class="col-md-3">
			  <div class="">
				<a class="res" href="../uploads/resim/<?=$resimcek["resimad"];?>" target="_blank">
				  <img class="ekle-resim img-responsive" src="../uploads/resim/<?php echo $resimcek["resimad"]; ?>"/>
				</a>
				<div class="btn-block">
				  <a href="index.php?do=islem&emlak=emlak_resim&id=<?=$id;?>&kapak=degistir&resimid=<?=$resimcek['id'];?>&islemno=<?=$islemno;?>" class="btn <?php if ($resimcek['kapak'] == 1) {echo "btn-success";} else {echo "btn-default";} ?> btn-block">
					<i class="fa fa-check"></i> <?php if ($resimcek['kapak'] == 1) {echo "Kapak";} else {echo "Kapak Yap";} ?>
				  </a>
				  <a href="index.php?do=islem&emlak=emlak_resim&id=<?=$id;?>&resim=sil&resimid=<?=$resimcek['id'];?>" class="btn btn-danger btn-xs btn-block">
					<i class="fa fa-trash"></i> Sil
				  </a> 
				  <div class="btn-default btn-block btn">
					  <div class="form-group"> 
						  <label class="control-label">Sıra:</label>
						  <br>
							<input type="text" class="form-control text-center hidden" name="idr[]" value="<?=$resimcek['id']?>" >
							<input type="text" class="form-control text-center <?php if ($resimcek['sira'] == 0) {echo "hidden";} ?>" name="sira[]" value="<?=$resimcek['sira']?>">
							<?php if ($resimcek['sira'] == 0) {echo '<input type="text" value="0" class="form-control text-center" disabled>';} ?>
						  </div>
				  </div>
				  
				</div>
			  </div>
			  <br>
			</div>			
			<?php } ?>
			</div>
		   
			<div class="box"> 
				<div class="box-footer">
					<button type="submit" class="btn btn-primary btn-lg pull-right" name="resimduzenle"> <i class="fa fa-check"></i> Değişiklikleri Kaydet </button>
				 </div> 
			</div> 
		   
	  </div> 
</form>
</section> 
<script type="text/javascript">
   

</script>