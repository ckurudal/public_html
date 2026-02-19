<?php 
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
	
	uyeYasak(yetki());
	

	$islem =  @$_GET["islem"];
	$hareket =  @$_GET["hareket"];  
	$id =  @$_GET["id"];  
	$tema =  @$_GET["tema"];  

	$temalar = $vt->query("SELECT * FROM ayar_tema where aktif = 0 order by id DESC");
	$temalarid = $vt->query("SELECT * FROM ayar_tema where id = '$id'");

?>
<!-- Content Header (Page header) -->
<section class="content-header">

	<i class="fa fa-laptop fa-2x pull-left"></i>

	Web Site Tema Ayarları

	<p> <small> Tasarım Yönetimi </small> </p>

</section>
<?php
	if ($tema == "aktif") {

		$taktif = $temalarid->fetch();		
		$aktiftema = $vt->query("UPDATE ayarlar SET site_tema = '".$taktif["temaadi"]."', tema_url = '".$taktif["temaurl"]."' where id = '1'");

		$aktif_ayartema = $vt->query("UPDATE ayar_tema SET aktif = '0' where id");
		$aktif_ayartemaid = $vt->query("UPDATE ayar_tema SET aktif = '1' where id = '$id'");

		if ($aktiftema == true) {

			$tadi = $taktif["temaadi"];
			go("index.php?do=islem&ayarlar=temaayar&hareket=onay",0);	
		}

	}
?>
<?php 

	if (isset($_POST["temaekle"]) || isset($_POST["temakaydet"])) { 

		$temaadi	 = trim($_POST["temaadi"]);
		$temaurl	 = trim($_POST["temaurl"]);

		$varmiad=$vt->query("SELECT * FROM ayar_tema where temaadi='$temaadi'")->rowCount();
		$varmiurl=$vt->query("SELECT * FROM ayar_tema where temaurl='$temaurl'")->rowCount();

		if($varmiad!=0 || $varmiurl!=0 || empty($temaadi) || empty($temaurl)) { 

			if ($varmiad != 0) {
				hata("Bu isimde bir tema var. Farklı bir tema adı giriniz.");
			}

			if ($varmiurl != 0) {
				hata("Bu isimde bir tema url var. Farklı bir url adı giriniz.");
			}

			if (empty($temaadi)) {
				hata("Lütfen tema adınız giriniz.");
			}

			if (empty($temaurl)) {
				hata("Lütfen tema url giriniz.");
			}

		} else {

			if (isset($_POST["temaekle"])) {

				$temaekle = $vt->query("INSERT INTO ayar_tema (temaadi, temaurl) values ('$temaadi','$temaurl')");

				// resim yukleme
					
				$yuklenmeyenler = 0;
				$yuklenenler = 0;
				$toplam = count($_FILES["resim"]["name"]);
				for ($i = 0; $i < $toplam; $i++) {
				    if (is_uploaded_file($_FILES["resim"]["tmp_name"][$i])) {
				        $resim = pathinfo($_FILES["resim"]["name"][$i]);
				        $resim_adi = $resim["filename"];
				        $resim_uzanti = $resim["extension"];
				        $uzantilar = array("png", "gif", "jpg", "PNG", "GIF", "JPG", "jpeg", "JPEG");
				        if (in_array($resim_uzanti, $uzantilar)) {
				            $saat = date("H:i:s");
				            $saat = sha1(md5($saat));
				            $dosya = "../uploads/resim/".$saat.".jpg";
				            if (move_uploaded_file($_FILES["resim"]["tmp_name"][$i], $dosya)) {
								
				                $ids = $vt->query("SELECT * FROM ayar_tema order by id desc limit 1");
				                $id = $ids->fetch(); 

				                $link = "/uploads/resim/".$saat.".jpg";
				                $ekle = $vt->query("UPDATE ayar_tema SET resim = '$link' where id = '".$id["id"]."'");
				                $yuklenenler++; 

				            }

				        } else {

				            $yuklenmeyenler++;

				        }
				    }
				} 
				
				go("index.php?do=islem&ayarlar=temaayar&hareket=onay",0);	

			} 
			
		} 

	}

?>
<?php
	if ($islem == "ekle") {
?>
<section class="content">
	<form action="" method="post" enctype="multipart/form-data">
		<div class="box">		
			<div class="box-body">
				<div class="form-horizontal">
					<div class="form-group">								
						 <label class="col-sm-2 control-label">Tema Adı:</label>
						 <div class="col-sm-10"> 
								<input type="text" class="form-control" name="temaadi"/> 
						  </div>
					</div>
					<div class="form-group">								
						 <label class="col-sm-2 control-label">Tema URL:</label>
						 <div class="col-sm-10"> 
								<input type="text" class="form-control" name="temaurl"/> 
						  </div>
					</div>
					<div class="form-group">								
						 <label class="col-sm-2 control-label">Tema Masaüstü Resmi:</label>
						 <div class="col-sm-4"> 
								<input type="file" class="form-control" name="resim[]" multiple/> 
						  </div>
					</div> 
				</div>
				<div class="box-footer">						
					<button type="submit" name="temaekle" class="btn btn-success btn-lg pull-right"> <i class="fa fa-check"></i> Ekle </button>
				</div>
			</div>
		</div>
	</form>
</section>
<?php } ?> 
<section class="content">


	<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
		<?php 

			if ($hareket == "onay") {
				onay();
			} 

		?>  
		<div class="bo x">
		<!-- /.box-header -->
			<div class="box-bo dy" style="">
				<div class="row">
					<?php

						$siteaktiftemaid = $vt->query("SELECT * FROM ayar_tema where aktif = '1'");
						$siteaktiftema = $siteaktiftemaid->fetch();
					?>				
					<?php
						if ($siteaktiftema["aktif"] == 1) {
					?> 
					<div class="col-md-6">
						<div class="box aktiftema"> 
							<div class="box-header with-border">
								<h6 class="box-title"> <i class="fa fa-plus"></i> Aktif Masaüstü Tema - <?=$siteaktiftema["temaurl"];?> </h3>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-md-6">
										<div class="thumbnail sec">
											<div class="temalist">
												<img class="temaresim" src="<?=$siteaktiftema["resim"];?>">
											</div> 
											<a class="btn btn-danger edittema" style="color: #fff; top: 10px;" href="index.php?do=islem&ayarlar=temaayar&islem=duzenle&id=<?=$siteaktiftema["id"];?>"> <i class="fa fa-edit"></i> </a>
										</div>
									</div>
									<div class="col-md-6">
										<h5><strong>Aktif Tema: </strong> <span class="alert alert-primary" style="text-transform: uppercase;"> [ <?=$siteaktiftema["temaadi"];?> ] </span></h5>
										<br>																														
										<!-- <a href="index.php?do=ayar/gorunumayar&id=<?=$siteaktiftema["id"];?>"> <span class="btn btn-default"><i class="fa fa-code"></i></span> Tema Ayarları </a> -->
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">

						<div class="alert alert-primary text-center"">
							<h5><span><i class="fa fa-check-circle fa-2x"></i> <br><br> Kurumsal kimliğinize en uygun ücretsiz emlak sitesi temalarımızdan birini kullanabilirsiniz.</span></h5>
						</div>

						<br>

						<br>

						<div class="alert alert-primary text-center">
							<h5><span><i class="fa fa-bullhorn fa-2x"></i> <br><br> Özel ve benzersiz tema istiyorsanız, satış temsilcilerimiz ile iletişime geçerek özel tasarım hizmeti satın alabilirsiniz.</span></h5>
						</div>

						<br>

						<br>

						<div class="alert alert-primary text-center"">
							<h5><span><i class="fa fa-edit fa-2x"></i> <br><br> Mevcut bir temada revize yaptırmak isternseniz. Ekibimizle iletişime geçiniz. </span></h5>
						</div>

						<br>

						<br>

						<div class="alert alert-primary text-center"">
							<h5><span><i class="fa fa-comments fa-2x"></i> <br><br> Temalar ile ilgili farklı çözümler için ebimizle iletişime geçiniz. </span></h5>
						</div>

					</div>
					<!--
					<div class="col-md-6">
						<div class="box aktiftema">
							<div class="box-header">
							<h4><i class="fa fa-check"></i> Aktif Mobil Tema</h4>
							</div>
							<div class="box-body" style="padding-top: 15px; padding-left: 15px;">
								<div class="row">
									<div class="col-md-6">
										<div class="thumbnail sec">
											<div class="temalist">
												<img class="temaresim" src="<?=$siteaktiftema["resim"];?>">
											</div> 
										</div>
									</div>
									<div class="col-md-6">
										<h3><strong>Mobil Tema: </strong> <?=$siteaktiftema["temaadi"];?></h3> 									
									</div>
								</div>
							</div>
						</div>
					</div>  
					-->
					<?php } ?> 
				</div>  
				<div class="row"> 
					<?php
						$temaaktif = $vt->query("SELECT * FROM ayar_tema where aktif = 1")->fetch();
					?>
					<div class="col-md-3">
						<div class="thumbnail sec">
							<div class="temalist">
								<img class="temaresim" src="<?=$temaaktif["resim"];?>">
							</div>
							<div class="text-center">
								<h4><?=$temaaktif["temaadi"];?></h4>
								<a class="btn btn-default btn-xs" href="<?=URL;?>" target="_blank"> <i class="fa fa-desktop"></i> Siteyi Gör </a>
								<br>
								<br>
							</div> 
						</div>
					</div>
					<?php 
						while($tema = $temalar->fetch()) {
					?>
					<?php
						if ($tema["aktif"] != 1) {
					?>
					<div class="col-md-3">
						<div class="thumbnail sec">
							<div class="temalist">
								<img class="temaresim" src="<?=$tema["resim"];?>">
							</div>
							<div class="text-center">
								<h4><?=$tema["temaadi"];?></h4>
								<a class="btn btn-success" href="index.php?do=islem&ayarlar=temaayar&tema=aktif&id=<?=$tema["id"];?>"> <i class="fa fa-external-link"></i> Aktif Et</a>
								<!-- <a class="btn btn-default" href="<?=URL;?>/temaId=<?=$tema["id"];?>" target="_blank"> <i class="fa fa-desktop"></i> Önizle</a> -->
								<br>
								<br>
							</div> 
						</div>
					</div>
					<?php } ?> 
					<?php } ?> 
				</div> 
	</form> 
</section>