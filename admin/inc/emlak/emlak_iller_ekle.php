<?php  
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
	
	uyeYasak(yetki());
	
	$islem = $_GET["islem"];
	$emlak = $_GET["emlak"]; 
	$hareket = $_GET["hareket"];
	$id = $_GET["id"]; 
	$dbiller = mysql_query("select * from sehir where id = '$id'");
	$iller = mysql_fetch_array($dbiller);

 ?>
<?php if (isset($_POST["ilduzenle"])) {  
	$adi 		= trim($_POST["adi"]); 
	$plaka 		= trim($_POST["plaka"]);  
	$ozet 		= trim($_POST["ozet"]);  
	$resim_link = trim($_POST["resim_link"]);  
	$ilduzenle 	= mysql_query("update sehir set 
	adi			=  	'$adi', 
	sehir_key 	= 	'$plaka',
	ozet 		= 	'$ozet',
	resim_link 	= 	'$resim_link'
	where id = '$id'; 
	");
	go("index.php?do=islem&emlak=iller&hareket=onay",0);

} ?>
<section class="content-header">
	
	<i class="fa fa-edit fa-2x pull-left"></i>
	
	İl Yönetimi

	<p> <small> İl Yönetimi </small> </p> 

</section>
<?php 
	if ($islem == "ekle" || $islem == "duzenle") {
?>
<section class="content">
<!-- Content Header (Page header) -->
<?php if (isset($_POST["ilekle"])) {  
	$adi = trim($_POST["adi"]); 
	$plaka = trim($_POST["plaka"]);  
	$ozet = trim($_POST["ozet"]);
	$resim_link = trim($_POST["resim_link"]);
	if (empty($adi)) { 
		hata("Şehir adı boş olamaz."); 
	} else { 
		$ilekle = mysql_query("insert into sehir  
		(adi,sehir_key,ozet,resim_link)	values  ('$adi','$plaka','$ozet','$resim_link'); 
		"); 
		go("index.php?do=islem&emlak=iller&hareket=onay",0); 
	}

} ?>
	<div class="box">
		<div class="box-header with-border">
		  <h3 class="box-title"><i class="fa fa-check"></i> Yeni İl Ekle </h3>
		  <!-- tools box -->
		  <div class="pull-right box-tools">
			<a href="#" class="btn" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Daralt">
			  <i class="fa fa-minus"></i></a>
			<a href="#" class="btn" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Kapat">
			  <i class="fa fa-times"></i></a>
		  </div>
		  <!-- /. tools -->
		</div>
		<div class="box-body">
			<form method="post" action="" enctype="multipart/form-data">
				<div class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-2 control-label">Başlık:</label>
					  <div class="col-sm-10">
						<?php if ($islem == "ekle") { ?>
						<input type="text" class="form-control" name="adi" value="">
						<?php } ?>
						<?php if ($islem == "duzenle") { ?>
						<input type="text" class="form-control" name="adi" value="<?=$iller['adi'];?>">
						<?php } ?>
					  </div>
					</div>   
					<div class="form-group">
					  <label class="col-sm-2 control-label">İl Plaka Kodu:</label>
					  <div class="col-sm-10">
						<?php if ($islem == "ekle") { ?>
						<input type="text" class="form-control" name="plaka" value="">
						<?php } ?>
						<?php if ($islem == "duzenle") { ?>
						<input type="text" class="form-control" name="plaka" value="<?=$iller['sehir_key'];?>">
						<?php } ?>
					  </div>
					</div> 
					<div class="form-group">
						<label class="col-sm-2 control-label">Anasayfada Göster:</label>
						<div class="col-md-10">
							<label for="anasayfa_goster">
							  <input type="radio" name="ozet" <?php if($iller["ozet"]==1 AND $islem == "duzenle"): ?>checked<?php endif; ?> value="1" class="minimal">
								Göster
							</label>
							<label for="ozellikler">
							  <input type="radio" name="ozet" <?php if($iller["ozet"]==0 AND $islem == "duzenle"): ?>checked<?php endif; ?> value="0" class="minimal">
								Gizle
							</label>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Anasayfa Resim Adresi:</label>
						<div class="col-md-10">
							<input type="text" class="form-control" name="resim_link" value="<?=$iller['resim_link'];?>">
							<br>
							<a href="https://hizliresim.com/" target="_blank"><i class="fa fa-external-link"></i> <strong>Resimlerinizi güvenli bir şekilde buraya ekleyebilirsiniz.</strong></a>
						</div>
					</div>
					<div class="form-group">
						<?php if ($islem == "ekle") { ?>
						<button type="submit" class="btn btn-primary btn-lg pull-right" name="ilekle"> Ekle <i class="fa fa-check"></i> </button>
						<?php } ?>
						<?php if ($islem == "duzenle") { ?>
						<button type="submit" class="btn btn-success btn-lg pull-right" name="ilduzenle"> Kaydet <i class="fa fa-check"></i> </button>
						<?php } ?>
					 </div> 
				</div>   
			</form>
		</div>
	</div>
</section>	
<?php } ?>