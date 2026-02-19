<?php

	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
	
	$id = $_GET["id"];	
	
	$islem = $_GET["islem"];

	$uye_yasak = $vt->query("SELECT * FROM yonetici WHERE id = '".$_SESSION["id"]."'")->fetch();
	
	$sube_kontrol = $vt->query("SELECT * FROM subeler WHERE id = '$id'")->fetch(PDO::FETCH_ASSOC);
	
	$subeler = $vt->query("SELECT * FROM subeler WHERE id = '$id'")->fetchAll(PDO::FETCH_ASSOC);
	
?>

<?php if ($uye_yasak["id"] == $sube_kontrol["yetkiliuye"] || yetki() == 0): ?>

<section class="content-header">
	Mağaza Yönetimi
	<p> <small> Mağaza Bilgileri </small> </p>
</section>
<?php
	if (isset($_POST["subeekle"]) || isset($_POST["subekaydet"])) {

		$adi 			= $_POST["adi"];
		$seo 			= seo($_POST["adi"]);
		$icerik 		= $_POST["icerik"];
		$title 			= $_POST["title"];
		$aciklama 		= $_POST["aciklama"];
		$keyw 			= $_POST["keyw"];
		$email 			= $_POST["email"];
		$sabittel 		= $_POST["sabittel"];
		$sabitteldiger	= $_POST["sabitteldiger"];
		$gsm 			= $_POST["gsm"];
		$fax 			= $_POST["fax"];
		$il 			= $_POST["il"];
		$ilce 			= $_POST["ilce"];
		$mahalle 		= $_POST["mahalle"];
		$adres 			= $_POST["adres"];

		$firmaunvan		= $_POST["firmaunvan"];
		$vergino		= $_POST["vergino"];
		$vergidairesi		= $_POST["vergidairesi"]; 

		$yetkili 		= $_POST["yetkili"];

		if (isset($_POST["subeekle"])) {

			$subeekle = $vt->query("INSERT INTO subeler ( adi, yetkiliuye, seo, icerik, title, aciklama, keyw, email, sabittel, sabitteldiger, gsm, fax, il, ilce, mahalle, adres ) VALUES ( '$adi', '$yetkili', '$seo', '$icerik', '$title', '$aciklama', '$keyw', '$email', '$sabittel', '$sabitteldiger', '$gsm', '$fax', '$il', '$ilce', '$mahalle', '$adres' )");

			if ($subeekle) {
				go("index.php?do=islem&ofis=subeler&islem=ekle",0);
			}

		}

		if (isset($_POST["subekaydet"])) {

			$subekaydet = $vt->query("UPDATE subeler SET adi = '$adi', firmaunvan = '$firmaunvan', vergino = '$vergino', vergidairesi = '$vergidairesi', seo = '$seo', icerik = '$icerik', title = '$title', aciklama = '$aciklama', keyw = '$keyw', email = '$email', sabittel = '$sabittel', sabitteldiger = '$sabitteldiger', gsm = '$gsm', fax = '$fax', il = '$il', ilce = '$ilce', mahalle = '$mahalle', adres = '$adres' where id = '$id' ");

			$uyekaydet = $vt->query("UPDATE yonetici SET ofis = '".$id."' where id = '$yetkili'");

			if ($subekaydet) {

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

				                $eskiresim = $vt->query("SELECT * FROM subeler where id = '$id'")->fetch();

				            	unlink("../".$eskiresim["resim"]);

				                $link = "uploads/resim/".$saat.".jpg";
				                $ekle = $vt->query("UPDATE subeler SET resim = '$link' where id = '$id'");
				                $yuklenenler++;

				            }

				        } else {

				            $yuklenmeyenler++;

				        }
				    }
				}
			
				if (yetki()==0) {
					go("index.php?do=islem&ofis=subeler&islem=kaydet&id=$id",0);
				} else { 
					go("index.php?do=islem&ofis=subeekle&islem=duzenle&id=$id",0);					
				}

			}

		}

	}
?>
<?php if ($islem == "ekle") { ?>
<form action="" method="post">
	<section class="content">
		<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title"><i class="fa fa-check"></i> Mağaza Bilgileri </h3>
			  <!-- tools box -->
			  <!-- /. tools -->
			</div>
			<!-- /.box-header -->
			<div class="box-body pad" style="">
				<div class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-2 control-label">Başlık:</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" name="adi">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Mağaza Yetkilisi:</label>
					  <div class="col-sm-10">
						<select class="form-control select2" name="yetkili">
							<option>Seçiniz</option>
							<option value="0">Yekilik Yok</option>
							<?php
								$yoneticiler = $vt->query("SELECT * FROM yonetici where yetki = 2 AND durum = 0");
								while($yonetici = $yoneticiler->fetch()) {
							?>
							<option value="<?=$yonetici["id"];?>"><?=$yonetici["adsoyad"];?></option>
							<?php } ?>
						</select>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">İçerik:</label>
					  <div class="col-sm-10">
						<textarea id="editor1" name="icerik" rows="15" cols="80"></textarea>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Title:</label>
					  <div class="col-sm-10">
						<input type="text" name="title" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Google Açıklama:</label>
					  <div class="col-sm-10">
						<textarea class="form-control" id="" name="aciklama" rows="5" cols="80"></textarea>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Anahtar Kelimeler (Etiket):</label>
					  <div class="col-sm-10">
						<input type="text" name="keyw" class="form-control">
					  </div>
					</div>
				</div>
			</div>
		</div>
		<div class="alert alert-warning">
			<strong> Mağaza İletişim Bilgileri Ekleme Alanı </strong>
		</div>
		<div class="box">
			<!-- /.box-header -->
			<div class="box-body pad" style="">
				<div class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-2 control-label">Mağaza Email:</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" name="email">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Sabit Telefon:</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" name="sabittel">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Sabit Telefon (Diğer):</label>
					  <div class="col-sm-10">
						<input type="text" name="sabitteldiger" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Yetkili GSM:</label>
					  <div class="col-sm-10">
						<input type="text" name="gsm" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Fax:</label>
					  <div class="col-sm-10">
						<input type="text" name="fax" class="form-control">
					  </div>
					</div>
				</div>
			</div>
		</div>
		<div class="alert alert-warning">
			<strong> Şube Adres Bilgileri </strong>
		</div>
		<div class="box">
			<!-- /.box-header -->
			<div class="box-body pad" style="">
				<div class="form-horizontal">
						<div class="form-group">
						  <label class="col-sm-2 control-label">Bölge:</label>
						  <div class="col-sm-10">
							  <div class="row">
								<div class="col-sm-4">
									<select name="il" id="il" class="form-control select2">
										<option selected="selected"> İl Seçiniz </option>
										<?php
											$iller = $vt->query("select * from sehir order by sehir_key asc");
											while($il=$iller->fetch()) {
										?>
										<option value="<?=$il['sehir_key'];?>"> <?=$il['adi'];?> </option>
										<?php } ?>
									</select>
								  </div>
								  <div class="col-sm-4">
									<select name="ilce" id="ilce" class="form-control select2">
										<option selected="selected"> İlçe Seçiniz </option>
									</select>
								  </div>
								  <div class="col-sm-4">
									<select name="mahalle" id="mahalle" class="form-control select2">
										<option selected="selected"> Mahalle Seçiniz </option>
									</select>
								  </div>
							  </div>
						  </div>
							<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
					  		<script type="text/javascript">
								$(document).ready(function(){

								  	$("#il").change(function(){

								    	var ilid = $(this).val();
								    	$.ajax({
								    		type:"POST",
								    		url:"ajax_harita.php",
								    		data:{"il":ilid},
								    		success:function(e){
								    			$("#ilce").html(e);
								    		}
								    	});
								  	});

								  	$("#ilce").change(function(){

								    	var ilceid = $(this).val();
								    	$.ajax({
								    		type:"POST",
								    		url:"ajax_harita.php",
								    		data:{"ilce":ilceid},
								    		success:function(e){
								    			$("#mahalle").html(e);
								    		}
								    	});
								  	});

								});
						  </script>
						</div>
						<div class="form-group">
						  <label class="col-sm-2 control-label">Adres:</label>
						  <div class="col-sm-10">
							<textarea class="form-control" id="adres" name="adres" rows="8" cols="80"></textarea>
						  </div>
						</div>
					</div>
				</div>
			</div>
			<div class="box">
				<div class="box-footer">
					<button type="submit" class="btn btn-success btn-lg pull-right" name="subeekle"> <i class="fa fa-check"></i> Ekle </button>
				 </div>
			</div>
		</div>
	</section>
</form>
<?php } ?>
<?php if ($islem == "duzenle") { ?>
<form action="" method="post" enctype="multipart/form-data">
	<?php
		
		foreach ($subeler as $s) 
		{		
		
	?>
	<section class="content">
		<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title"><i class="fa fa-check"></i> Mağaza Bilgileri </h3>
			  <!-- tools box -->
			  <div class="pull-right box-tools">
				<a href="#" class="btn" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Daralt">
				  <i class="fa fa-minus"></i></a>
				<a href="#" class="btn" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Kapat">
				  <i class="fa fa-times"></i></a>
			  </div>
			  <!-- /. tools -->
			</div>
			<!-- /.box-header -->
			<div class="box-body pad" style="">
				<div class="form-horizontal">
					<div class="form-group"> 
					  <div class="col-sm-12">
					  		<div class="">
								<?php if ($s["resim"] == "") { ?>
			        				<img src="/uploads/resim/resim.png" class="img-responsive img-thumbnail" width="200">
			        			<?php } else { ?>
			        				<img src="/<?=$s["resim"];?>" class="img-responsive img-thumbnail" width="200">
			        			<?php } ?>
					  		</div>
					  </div>

					  <div class="col-sm-3">
					  	<label class="control-label">Firma Resmi / Logo Seç:</label>
					  	<input type="file" class="form-control" name="resim[]"/>
					  </div>

					  <div class="col-sm-3">
					  	<label class="control-label">Başlık:</label>
						<input type="text" class="form-control" name="adi" value="<?=$s["adi"];?>">
					  </div>

					  <div class="col-sm-3">
					  		<label class="control-label">Mağaza Yetkilisi:</label>
					  		<?php
								$yoneticilerid = $vt->query("SELECT * FROM yonetici where id = '".$s["yetkiliuye"]."' AND durum = 0 AND yetki = 2");
								$yoneticiid = $yoneticilerid->fetch();
							?>
							<a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $yoneticiid["id"]; ?>&yetki=<?php echo $yoneticiid["yetki"]; ?>" target="_blank" class="form-control"> <?=$yoneticiid["adsoyad"];?> </a>
						<!--
						<select class="form-control select2" name="yetkili">
							<option value="0">Yetkili Yok</option>
							<?php
								$yoneticilerid = $vt->query("SELECT * FROM yonetici where id = '".$s["yetkiliuye"]."' AND durum = 0 AND yetki = 2");
								$yoneticiid = $yoneticilerid->fetch();
							?>
							<?php if ($s["yetkiliuye"] != 0) { ?>
							<option selected="selected"><?=$yoneticiid["adsoyad"];?></option>
							<?php } ?>
							<?php
								$yoneticiler = $vt->query("SELECT * FROM yonetici where yetki = 2 AND durum = 0");
								while($yonetici = $yoneticiler->fetch()) {
							?>
							<option value="<?=$yonetici["id"];?>"><?=$yonetici["adsoyad"];?></option>
							<?php } ?>
						</select>
						-->
					  </div>
					  <div class="col-sm-3">
					  	<label class="control-label">Firma Ünvan:</label>
							<input type="text" name="firmaunvan" class="form-control" value="<?=$s["firmaunvan"];?>">
					  </div>
					  <div class="col-sm-3">
					  	<label class="control-label">Vergi No:</label>
							<input type="text" name="vergino" class="form-control" value="<?=$s["vergino"];?>">
					  </div>
					  <div class="col-sm-3">
					  	<label class="control-label">Vergi Dairesi:</label>
							<input type="text" name="vergidairesi" class="form-control" value="<?=$s["vergidairesi"];?>">
					  </div>
					  <?php if (yetki() == 0): ?>
						<div class="col-sm-3">
					  	<label class="control-label"> &nbsp; </label>
							<a href="index.php?do=islem&ofis=yonetici&islem=liste&emlakofisi=<?php echo $s["id"]; ?>" target="_blank" class="btn btn-block btn-primary"> Mağazanın Tüm Danışmanları </a>
					  </div>
						<div class="col-sm-3">
					  	<label class="control-label"> &nbsp; </label>
							<a href="/ofis/<?php echo $s["id"]; ?>/<?php echo $s["seo"]; ?>" target="_blank" class="btn btn-block btn-inverse"> Mağazanın Tüm İlanları </a>
					  </div>
					  <?php endif; ?>
					  <div class="col-sm-12">
						<label class="control-label">İçerik:</label>
						<textarea id="editor1" name="icerik" rows="15" cols="80"> <?=$s["icerik"];?> </textarea>
					  </div>
					</div>
					<div class="form-group">
					  <div class="col-sm-12">
					  	<label class="control-label">Title:</label>
						<input type="text" name="title" class="form-control" value="<?=$s["title"];?>">
					  </div>
					  <div class="col-sm-12">
					  	<label class="control-label">Google Açıklama:</label>
						<textarea class="form-control" id="" name="aciklama" rows="5" cols="80"><?=$s["aciklama"];?></textarea>
					  </div>
					  <div class="col-sm-12">
					  	<label class="control-label">Anahtar Kelimeler (Etiket):</label>
						<input type="text" name="keyw" class="form-control" value="<?=$s["keyw"];?>">
					  </div>
					</div>
				</div>
			</div>
		</div>
		<div class="alert alert-warning">
			<strong> Mağaza İletişim Bilgileri Ekleme Alanı </strong>
		</div>
		<div class="box">
			<!-- /.box-header -->
			<div class="box-body pad" style="">
				<div class="form-horizontal">
					<div class="form-group">
					  <div class="col-sm-3">
					  	<label class="control-label">Mağaza Email:</label>
						<input type="text" class="form-control" name="email" value="<?=$s["email"];?>">
					  </div>
					  <div class="col-sm-3">
					  	<label class="control-label">Sabit Telefon (Diğer):</label>
						<input type="text" name="sabitteldiger" class="form-control" value="<?=$s["sabitteldiger"];?>">
					  </div>
					  <div class="col-sm-3">
					  	<label class="control-label">Sabit Telefon:</label>
						<input type="text" class="form-control" name="sabittel" value="<?=$s["sabittel"];?>">
					  </div>
					  <div class="col-sm-3">
					  	<label class="control-label">Yetkili GSM:</label>
						<input type="text" name="gsm" class="form-control" value="<?=$s["gsm"];?>">
					  </div>
					  <div class="col-sm-3">
					  	<label class="control-label">Fax:</label>
						<input type="text" name="fax" class="form-control" value="<?=$s["fax"];?>">
					  </div>
					</div>
				</div>
			</div>
		</div>
		<div class="alert alert-warning">
			<strong> Mağaza Adres Bilgileri </strong>
		</div>
		<div class="box">
			<!-- /.box-header -->
			<div class="box-body pad" style="">

				<div class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-2 control-label">Bölge:</label>
					  <div class="col-sm-10">
						  <div class="row">
							<div class="col-sm-4">
								<select name="il" id="il" class="form-control select2">
									<?php
										$illersec = $vt->query("select * from sehir where sehir_key = '$s[il]'");
										$ilsec=$illersec->fetch();

										if ($ilsec["sehir_key"]==$s["il"]) {
											echo '<option value="'.$ilsec["sehir_key"].'" selected="selected">'.$ilsec["adi"].'</option>';
										} else {
									?>
									<option selected=""> İL SEÇİNİZ </option>
									<?php } ?>
									<?php
										$iller = $vt->query("select * from sehir order by sehir_key asc");
										while($il=$iller->fetch()) {
									?>
										<option value="<?=$il['sehir_key'];?>"> <?=$il['adi'];?> </option>
									<?php } ?>
								</select>
							  </div>
							  <div class="col-sm-4">
								<select name="ilce" id="ilce" class="form-control select2">

									<?php
										$ilcelersec = $vt->query("select * from ilce where ilce_key = '$s[ilce]'");
										$ilcesec=$ilcelersec->fetch();

										if ($ilcesec["ilce_key"]==$s["ilce"]) {
											echo '<option value="'.$ilcesec["ilce_key"].'" selected="selected">'.$ilcesec["ilce_title"].'</option>';
										} else {
									?>
									<option selected="selected"> İLÇE SEÇİNİZ </option>
									<?php } ?>
									<?php

										$ilceler = $vt->query("SELECT * FROM ilce where ilce_sehirkey = '$s[il]'");
										while($ilce=$ilceler->fetch()) {

											echo '<option value="'.$ilce["ilce_key"].'">'.$ilce["ilce_title"].'</option>';

										}
									?>
								</select>
							  </div>
							  <div class="col-sm-4">
								<select name="mahalle" id="mahalle" class="form-control select2">

									<?php
										$mahallelersec = $vt->query("select * from mahalle where mahalle_id = '$s[mahalle]'");
										$mahallesec=$mahallelersec->fetch();

										if ($mahallesec["mahalle_id"]==$s["mahalle"]) {
											echo '<option value="'.$mahallesec["mahalle_id"].'" selected="selected">'.$mahallesec["mahalle_title"].'</option>';
										} else {
									?>
									<option selected="selected"> MAHALLE SEÇİNİZ </option>
									<?php } ?>
									<?php
										$mahalleler = $vt->query("SELECT * FROM mahalle where mahalle_ilcekey = '$ilcesec[ilce_key]'");
										while($mahalle=$mahalleler->fetch()) {

											echo '<option value="'.$mahalle["mahalle_id"].'">'.$mahalle["mahalle_title"].'</option>';

										}
									?>
								</select>
							  </div>
						  </div>
					  </div>
						<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
				  		<script type="text/javascript">
							$(document).ready(function(){

							  	$("#il").change(function(){

							    	var ilid = $(this).val();
							    	$.ajax({
							    		type:"POST",
							    		url:"ajax_harita.php",
							    		data:{"il":ilid},
							    		success:function(e){
							    			$("#ilce").html(e);
							    		}
							    	});
							  	});

							  	$("#ilce").change(function(){

							    	var ilceid = $(this).val();
							    	$.ajax({
							    		type:"POST",
							    		url:"ajax_harita.php",
							    		data:{"ilce":ilceid},
							    		success:function(e){
							    			$("#mahalle").html(e);
							    		}
							    	});
							  	});

							});
					  </script>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Adres:</label>
					  <div class="col-sm-10">
						<textarea class="form-control" id="adres" name="adres" rows="8" cols="80"><?=$s["adres"];?></textarea>
					  </div>
					</div>
				</div>
			</div>
			</div>
			<div class="box">
				<div class="box-footer">
					<button type="submit" class="btn btn-success btn-lg pull-right" name="subekaydet"> <i class="fa fa-check"></i> Kaydet </button>
				 </div>
			</div> 			
	</section>
	
	<?php } ?>
	
</form>

<?php } ?>

<?php else: ?>

	<section class="content">
		<h5 class="well text-center" style="padding:150px 0;">
			<i class="fa fa-close fa-5x text-danger"></i> <br> <br>Üzgünüz! Bu sayfaya erişim yetkiniz yok! <br> <br>
			<a class="btn btn-success" href="index.php">Anasayfaya Dön</a>
		</h5>
	</section>

<?php endif; ?>