<?php   
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;  
	uyeYasak(yetki());
	$popup = $vt->query("SELECT * FROM tema_popup ORDER BY id DESC")->fetch();
	$id = $popup["id"];
?>
<section class="content-header">
	<i class="fa fa-external-link fa-2x pull-left"></i>
	Pop-Up Ayarları
	<p> <small> Pop-Up Yönetimi </small> </p>
</section>  
<section class="content">  
	<?php  
		if (@$_GET["hareket"]=="onay") {
		onay();
		}
		if (isset($_POST["kaydet"])) {
		$ekle = $vt->prepare("INSERT INTO tema_popup SET
			baslik = ?,
			sure = ?,
			gorunum = ?,
			form = ?,
			icerik = ?, 
			video_link = ?,
			link = ?,
			durum = ?
		");
		$ekle = $ekle -> execute(array(
			trim($_POST["baslik"]),
			trim($_POST["sure"]*60),
			trim($_POST["gorunum"]),
			trim($_POST["form"]),
			trim($_POST["icerik"]), 
			trim($_POST["video_link"]),
			trim($_POST["link"]),
			trim($_POST["durum"])
		));
		$yeni_id = $vt->query("SELECT * FROM tema_popup ORDER BY id DESC")->fetch();
		if ($_FILES["resim"]["type"] != "") {
			// ORIGIINAL IMAGE
			@unlink(RESIMLER.$popup["resim"]);
			$resim = new Verot\Upload\Upload($_FILES["resim"], 'tr_TR');
			$resim->allowed = array('image/*');
			$resim->file_new_name_body = sha1(md5(date("H:i:s")));
			$resim->image_convert = "webp";
			$resim->webp_quality = 80;
			$resim->Process(RESIMLER);
			$action = $vt->prepare("UPDATE tema_popup SET resim = ? WHERE id = ?");
			$action = $action->execute(array( trim($resim -> file_dst_name),$yeni_id["id"]));
		} else {
			$action = $vt->prepare("UPDATE tema_popup SET resim = ? WHERE id = ?");
			$action = $action->execute(array( trim($popup["resim"]),$yeni_id["id"]));
		}
		if ($ekle) { 
			$sil = $vt->prepare("DELETE FROM tema_popup WHERE id != ?");
			$sil = $sil->execute(array(
				$yeni_id["id"]
			));
			go("index.php?do=ayar/popupayar&hareket=onay");
		} 
		} 
	?>
	<form action="" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="col-lg-12">
				<div class="box"> 
					<div class="box-header with-border">
						<h5 class="box-title"> <i class="fa fa-external-link"></i> Pop-Up Yönetimi </h5>
					</div>
					<div class="box-body"> 
						<div class="row">
							<div class="col-lg-3"> 
								<div class="form-group">
									<label class="control-label" for="">Başlık</label>
									<input name="baslik" value="<?php echo $popup["baslik"] ?>" type="text" class="form-control">
								</div>
							</div>
							<div class="col-lg-3"> 
								<div class="form-group">
									<label class="control-label" for="">Dakika Cinsinden Süre <small>(Hangi Sıklıkla Gösterilsin)</small></label>
									<input name="sure" value="<?php echo $popup["sure"]/60 ?>" type="text" class="form-control">
									<p><strong>ÖRN: 20</strong> (20 Dakikada Bir Gösterilir.) </p>
								</div>
							</div>   
							<div class="col-lg-3"> 
								<div class="form-group">
									<label class="control-label" for="">Durum</label>
									<select name="durum" class="form-control" name="" id="">
										<option value="">Seçiniz</option>
										<option <?php if ($popup["durum"] == "Aktif") { ?> selected <?php } ?> value="Aktif">Aktif</option>
										<option <?php if ($popup["durum"] == "Pasif") { ?> selected <?php } ?>value="Pasif">Pasif</option>
									</select>  
								</div>
							</div>  
							<div class="col-lg-3"> 
								<div class="form-group">
									<label class="control-label" for="">Beni Ara Formu</label> 
									<select name="form" class="form-control" name="" id="">
										<option value="Seçiniz">Seçiniz</option>
										<option <?php if ($popup["form"] == "Göster") { ?> selected <?php } ?> value="Göster">Göster</option>
										<option <?php if ($popup["form"] == "Gizle") { ?> selected <?php } ?>value="Gizle">Gizle</option>										
									</select> 
								</div>
							</div>  
						</div>
						<div class="form-group">
							<label class="control-label" for="">İçerik</label>
							<textarea name="icerik" rows="3" type="text" class="form-control"><?php echo $popup["icerik"] ?></textarea>
						</div>   
						<div class="row">
							<div class="col-lg-3">  
								<div class="form-group">
									<label class="control-label" for="">Mevcut Resim</label>
									<a href="<?php echo RESIM.$popup["resim"] ?>" style="height: 126px;" class="form-control" target="_blank">
										<img src="<?php echo RESIM.$popup["resim"] ?>" alt="<?php echo $popup["baslik"] ?>" style="object-fit: contain; object-position: top center; height: 100%; width: 100%;">
									</a>
								</div>
							</div>  
							<div class="col-lg-3"> 
								<div class="form-group">
									<label class="control-label" for="">Resim</label>
									<input name="resim" value="<?php echo $popup["resim"] ?>" type="file" class="form-control">									
								</div>  
								<div class="form-group">
									<label class="control-label" for="">Resim Link</label>
									<input name="link" value="<?php echo $popup["link"] ?>" type="text" class="form-control">
								</div>
							</div>
							<div class="col-lg-3"> 
								<div class="form-group">
									<label class="control-label" for="">Görünüm Seçeneği</label>
									<select name="gorunum" class="form-control" name="" id="">
										<option value="Seçiniz">Seçiniz</option>
										<option <?php if ($popup["gorunum"] == "Resim") { ?> selected <?php } ?> value="Resim">Resim</option>
										<option <?php if ($popup["gorunum"] == "Video") { ?> selected <?php } ?>value="Video">Video</option> 
									</select>
								</div>
								<div class="form-group">
									<label class="control-label" for="">Video Url <small>(EMBED NUMARASI)</small></label>
									<input name="video_link" value="<?php echo $popup["video_link"] ?>" type="text" class="form-control">
									<p>y.com/watch?v=<strong>BURADAKİKOD</strong>&ab_channel=kanalismi</p>
								</div>  
							</div> 
						</div> 
					</div>
				</div>
			</div>
		</div>
		<button type="submit" class="btn btn-primary btn-lg" name="kaydet"> <i class="fa fa-check"></i> Kaydet </button>
	</form>
</section> 