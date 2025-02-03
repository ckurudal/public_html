<?php
		 
		
		require "../../sistem/baglan.php";  	 
		
		// ajax kategori
		
		$altkatid = $_POST["altkat2"]; 
		
		
		
?> 

<?php 

	$altkatt2 = $vt->query("SELECT * FROM emlak_kategori where kat_id = '$altkatid[0]'"); 
	$altkatt2->exec;
	$katt2 = $altkatt2->fetch();
	
	$altkatt = $vt->query("SELECT * FROM emlak_kategori where kat_id = '".$_SESSION["ust_kat"]."'"); 
	$altkatt->exec;
	$katt = $altkatt->fetch();
	
?>
<h5><i class="fa fa-angle-down pull-right"></i><strong>Eklemeye Başla</strong></h5>
<hr>
<div class="kat_devam_et">
	<div class="text-center">  
		<i class="fa fa-check-circle fa-2x text-green"></i>
		<br>
		<br>
		<span class="text-green h5"><strong><?php echo $katt["kat_adi"]; ?></strong></span>
		/
		<span class="text-green h5"><strong><?php echo $katt2["kat_adi"]; ?></strong></span>
		<br>
		<br>
		<a id="link" href="index.php?do=islem&emlak=emlak_ekle&kategori=<?php echo $altkatid[0]; ?>" class="btn btn-primary btn-xs">Sonraki Adım</a>
	</div>
</div>