<?php  
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;

	$islem = $_GET["islem"]; 
	$id = $_GET["id"];
	$ofis = $_GET["ofis"];
	$hareket = $_GET["hareket"];
	$durum = $_GET["durum"];
	$sifre = $_GET["sifre"];

	$stmt_yonetici = $vt->prepare("SELECT * FROM yonetici where id = ?");
	$stmt_yonetici->execute([$id]);
	$yonetici = $stmt_yonetici;
	$yoneticiliste = $vt->query("SELECT * FROM yonetici where yetki = 1 order by id desc");
?>
<section class="content-header">
	  <i class="fa fa-edit"></i> Danışman Yönetimi
	  <ol class="breadcrumb">
		<li><a href="index.php"><i class="fa fa-dashboard"></i> Anasayfa </a></li>
		<li> <a href="index.php?do=tumilanlar"> Tüm İlanlar </a> </li>
		<li class="active"> İlan Yönetimi </li>
	  </ol>
</section>
<section class="content">
<?php 

	if (isset($_POST["yoneticiekle"]) || isset($_POST["yoneticikaydet"])) {
 
		$adsoyad	= $_POST["adsoyad"];
		$seo		= seo($_POST["adsoyad"]); 
		$pass		= md5($_POST["pass"]);
		$email		= $_POST["email"];
		$tel		= $_POST["tel"];
		$fax		= $_POST["fax"];
		$gsm		= $_POST["gsm"];
		$unvan		= $_POST["unvan"];
		$sira		= $_POST["sira"];
		$sube		= $_POST["sube"];
		$aciklama	= $_POST["aciklama"];

		$sosyalid 	= $_POST["sosyalid"];
		$sosyallink = $_POST["sosyallink"];
		$sosyalbaslik = $_POST["sosyalbaslik"];

		if (isset($_POST["yoneticiekle"])) {

			$stmt_varmi = $vt->prepare("SELECT * FROM yonetici where email=?");
			$stmt_varmi->execute([$email]);
			$varmi = $stmt_varmi->rowCount();

			if($varmi!=0) { 

				hata("<strong>$email</strong> kayıtlı, lütfen farklı bir e-posta giriniz."); 

			} else {

				$stmt_yoneticiekle = $vt->prepare("INSERT INTO yonetici (adsoyad, seo, kadi, pass, email, tel, fax, gsm, unvan, sira, sube, aciklama) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
				$yoneticiekle = $stmt_yoneticiekle->execute([$adsoyad, $seo, $kadi, $pass, $email, $tel, $fax, $gsm, $unvan, $sira, $sube, $aciklama]);

                $stmt_ids = $vt->prepare("SELECT * FROM yonetici where kadi = ?");
                $stmt_ids->execute([$kadi]);
                $id = $stmt_ids->fetch();

                // sosyal medya bilgileri

				for ($i=0; $i < count($sosyalid) ; $i++) {
					
				$stmt_sosyal = $vt->prepare("INSERT INTO yonetici_sosyal (yoneticiid, sosyalid, sosyallink, baslik) VALUES (?,?,?,?)");
                	$stmt_sosyal->execute([$id["id"], $sosyalid[$i], $sosyallink[$i], $sosyalbaslik[$i]]);
				}
				
				if ($yoneticiekle) {

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
									
					                $stmt_ids2 = $vt->prepare("SELECT * FROM yonetici where kadi = ?");
					                $stmt_ids2->execute([$kadi]);
					                $id = $stmt_ids2->fetch(); 

					                $link = "/uploads/resim/".$saat.".jpg";
					                $stmt_ekle = $vt->prepare("UPDATE yonetici SET resim = ? where id = ?");
					                $stmt_ekle->execute([$link, $id["id"]]);
					                $yuklenenler++; 
  
					            }

					        } else {

					            $yuklenmeyenler++;

					        }
					    }
					}

					$stmt_ids3 = $vt->prepare("SELECT * FROM yonetici where kadi = ?");
					$stmt_ids3->execute([$kadi]);
					$id = $stmt_ids3->fetch(); 
					go("index.php?do=islem&uyeler=uyeler&islem=liste&hareket=onay&id=$id[id]",0); 

				}

			}

		}

		if (isset($_POST["yoneticikaydet"])) {

			$stmt_kaydet = $vt->prepare("UPDATE yonetici SET adsoyad = ?, seo = ?, tel = ?, fax = ?, gsm = ?, unvan = ?, sira = ?, sube = ?, aciklama = ? where id = ?");
		$yoneticikaydet = $stmt_kaydet->execute([$adsoyad, $seo, $tel, $fax, $gsm, $unvan, $sira, $sube, $aciklama, $id]);

			if ($yoneticikaydet) { 

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
								
								
					$stmt_resimal = $vt->prepare("SELECT * FROM yonetici where id = ?");
					$stmt_resimal->execute([$id]);
					$ral = $stmt_resimal->fetch();

								$sil = @unlink("..".$ral['resim']);
				                
				                $link = "/uploads/resim/".$saat.".jpg";
					$stmt_ekle2 = $vt->prepare("UPDATE yonetici SET resim = ? where id = ?");
					$stmt_ekle2->execute([$link, $id]);
				                $yuklenenler++; 

				            }

				        } else {

				            $yuklenmeyenler++;

				        }
				    }
				}

				$stmt_silsosyal = $vt->prepare("DELETE FROM yonetici_sosyal where yoneticiid = ?");
				$stmt_silsosyal->execute([$id]);


				for ($i=0; $i < count($sosyalid) ; $i++) {
				
					$stmt_sosyal2 = $vt->prepare("INSERT INTO yonetici_sosyal (yoneticiid, sosyalid, sosyallink, baslik) VALUES (?,?,?,?)");
					$stmt_sosyal2->execute([$id, $sosyalid[$i], $sosyallink[$i], $sosyalbaslik[$i]]);
				}

				go("index.php?do=islem&uyeler=uyeler&islem=liste&hareket=onay&id=$id",0); 
			}


		}


	}
?>
</section>
<?php if ($islem == "ekle") { ?>
<form action="" method="post" enctype="multipart/form-data">
	<section class="content">
		<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title"><i class="fa fa-check"></i> Danışman Bilgileri </h3>
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
					  <label class="col-sm-2 control-label">Adı Soyadı:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="adsoyad">
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Email:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="email">
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Şifre:</label>
					  <div class="col-sm-10">
						<input type="password" name="pass" class="form-control">
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Profil Resmi:</label>
					  <div class="col-sm-4">
					  	<input type="file" class="form-control" name="resim[]"/> 
					  </div>
					</div>  
					<div class="form-group">
					  <label class="col-sm-2 control-label">Hakkında:</label>
					  <div class="col-sm-10"> 
						<textarea id="editor1" name="aciklama" rows="15" cols="80"></textarea>
					  </div>
					</div>  
					<div class="form-group">
					  <label class="col-sm-2 control-label">Sıra:</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" name="sira">
					  </div>
					</div> 
				</div>
			</div>
		</div>
		<div class="alert alert-warning">
			<strong> Danışman İletişim Bilgileri </strong>
		</div>
		<div class="box">
			<!-- /.box-header -->
			<div class="box-body pad" style="">
				<div class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-2 control-label">Tel:</label>
					  <div class="col-sm-10">
						<input type="text" name="tel" class="form-control">
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">GSM:</label>
					  <div class="col-sm-10">
						<input type="text" name="gsm" class="form-control">
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Fax (Varsa):</label>
					  <div class="col-sm-10">
						<input type="text" name="fax" class="form-control">
					  </div>
					</div>  
				</div>
			</div>
		</div>
		<div class="alert alert-warning">
			<strong> Sosyal Medya Hesapları </strong>
		</div>
		<div class="box">
			<!-- /.box-header -->
			<div class="box-body pad">
				<div class="form-horizontal">
					<?php 
						$sosyalmedya = $vt->query("SELECT * FROM ayar_sosyal order by sira asc");
						while ($sosyal=$sosyalmedya->fetch()) {
					?>
					<div class="form-group">
					  <label class="col-sm-2 control-label"><?=$sosyal["baslik"];?>:</label>
						<input type="text" class="form-control hidden" name="sosyalbaslik[]" value="<?=$sosyal["baslik"];?>">
					  <div class="col-sm-10"> 
						<input type="text" class="form-control hidden" name="sosyalid[]" value="<?=$sosyal["id"];?>">
						<input type="text" class="form-control" name="sosyallink[]" value="">
					  </div>
					</div> 
					<?php } ?>  
				</div>
			</div>
		</div> 
		<div class="box"> 
			<div class="box-footer">
				<button type="submit" class="btn btn-success btn-lg pull-right" name="yoneticiekle"> <i class="fa fa-check"></i> Yeni Ekle </button>
			 </div> 
		</div> 
	</section>
</form>
<?php } ?>
<?php if ($islem == "duzenle") { ?>
	<form action="" method="post" enctype="multipart/form-data">
		<?php
			$stmt_yoneticiler = $vt->prepare("SELECT * FROM yonetici where id = ?");
			$stmt_yoneticiler->execute([$id]);
			$yoneticiler = $stmt_yoneticiler;
			while($y = $yoneticiler->fetch()) {
		?>
		<section class="content">
			<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><i class="fa fa-check"></i> Danışman Bilgileri </h3>
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
						<?php if (!empty($y["resim"])) { ?>
						<div class="form-group">
						  <label class="col-sm-2 control-label">Profil Resmi:</label>
						  <div class="col-sm-10"> 
							<div class="resim_liste" style="width: 200px; height: 200px; margin: inherit;">
								<img src="<?=$y["resim"];?>">								
							</div>
						  </div>
						</div>
						<?php } ?>
						<div class="form-group">
						  <label class="col-sm-2 control-label">Profil Resmi:</label>
						  <div class="col-sm-4">
						  	<input type="file" class="form-control" name="resim[]"/> 
						  </div>
						</div>  
						<div class="form-group">
						  <label class="col-sm-2 control-label">Adı Soyadı:</label>
						  <div class="col-sm-10"> 
							<input type="text" class="form-control" name="adsoyad" value="<?=$y["adsoyad"];?>">
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-sm-2 control-label">Email:</label>
						  <div class="col-sm-10"> 
							<input type="text" class="form-control" name="email" disabled="disabled" value="<?=$y["email"];?>">
						  </div>
						</div> 
						<div class="form-group">
						  <label class="col-sm-2 control-label">Hakkında:</label>
						  <div class="col-sm-10"> 
							<textarea id="editor1" name="aciklama" rows="15" cols="80"><?=$y["aciklama"];?></textarea>
						  </div>
						</div>  
						<div class="form-group">
						  <label class="col-sm-2 control-label">Sıra:</label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" name="sira" value="<?=$y["sira"];?>">
						  </div>
						</div> 
					</div>
				</div>
			</div>
			<div class="alert alert-warning">
				<strong> Danışman İletişim Bilgileri </strong>
			</div>
			<div class="box">
				<!-- /.box-header -->
				<div class="box-body pad" style="">
					<div class="form-horizontal">
						<div class="form-group">
						  <label class="col-sm-2 control-label">Tel:</label>
						  <div class="col-sm-10">
							<input type="text" name="tel" class="form-control" value="<?=$y["tel"];?>">
						  </div>
						</div> 
						<div class="form-group">
						  <label class="col-sm-2 control-label">GSM:</label>
						  <div class="col-sm-10">
							<input type="text" name="gsm" class="form-control" value="<?=$y["gsm"];?>">
						  </div>
						</div> 
						<div class="form-group">
						  <label class="col-sm-2 control-label">Fax (Varsa):</label>
						  <div class="col-sm-10">
							<input type="text" name="fax" class="form-control" value="<?=$y["fax"];?>">
						  </div>
						</div>  
					</div>
				</div>
			</div>
			<div class="alert alert-warning">
				<strong> Sosyal Medya Hesapları </strong>
			</div>
			<div class="box">
				<!-- /.box-header -->
				<div class="box-body pad">
					<div class="form-horizontal">   

						<?php
							$sosyalmedya = $vt->query("SELECT * FROM ayar_sosyal order by sira asc");
							while($sosyal=$sosyalmedya->fetch()) {
							$stmt_ysosyal = $vt->prepare("SELECT * FROM yonetici_sosyal where sosyalid = ? AND yoneticiid = ?");
						$stmt_ysosyal->execute([$sosyal["id"], $id]);
						$ysosyal = $stmt_ysosyal;
							$ys = $ysosyal->fetch();
						?>
						<div class="form-group">
							<input type="text" class="form-control hidden" name="sosyalbaslik[]" value="<?=$sosyal["baslik"];?>">
						  <label class="col-sm-2 control-label"><?=$sosyal["baslik"];?>:</label>							
						  <div class="col-sm-10"> 							
							<input type="text" class="form-control hidden" name="sosyalid[]" value="<?=$sosyal["id"];?>">
							<input type="text" class="form-control" name="sosyallink[]" value="<?=$ys["sosyallink"];?>">
						  </div>
						</div> 
						<?php } ?>   
					</div>
				</div>
			</div> 
			<div class="box"> 
				<div class="box-footer">				
					<button type="submit" class="btn btn-success btn-lg pull-right" name="yoneticikaydet"> <i class="fa fa-check"></i> Kaydet </button>
				 </div> 
			</div> 
		</section>
	<?php } ?>
	</form>
<?php } ?>

<?php if ($islem == "liste") { ?> 
<section class="content">
	<?php
		if ($sifre == "sifre") { 
		$ysifre=$yonetici->fetch();

		if (isset($_POST["sifrekaydet"])) {

			$yenisifre=trim(md5($_POST["yenisifre"]));

			$stmt_sifre = $vt->prepare("UPDATE yonetici SET pass = ? where id = ?");
		$sifreduzenle = $stmt_sifre->execute([$yenisifre, $id]);

			go("index.php?do=islem&uyeler=uyeler&islem=liste&hareket=onay",0); 
		}
	?>
	<form action="" method="POST">
		<div class="box">
			<div class="box-body">
				<div class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-2 control-label">Üye Adı:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" value="<?=$ysifre["adsoyad"];?>" disabled>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">E-Posta Adresi:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" value="<?=$ysifre["email"];?>" disabled>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Yeni Şifre:</label>
						<div class="col-sm-10">  
							<input type="text" class="form-control" name="yenisifre">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="box"> 
			<div class="box-footer">
				<button type="submit" class="btn btn-primary btn-lg pull-right" name="sifrekaydet"> <i class="fa fa-check"></i> Kaydet </button>
			 </div> 
		</div>
	</form>
	<?php } ?>
	<div class="box-header">
         <div class="pull-right"> 
            <a href="index.php?do=islem&uyeler=uyeler&islem=ekle" class="btn btn-lg bt-xs btn-success">
                <i class="fa fa-plus"></i> Yeni Ekle
            </a>   
         </div> 
	</div> 
	<div class="box">
		<div class="box-body">
			<?php 
				if ($hareket == "onay") {
					onay();
				}

				if ($hareket == "sil") {
					
					$stmt_sil = $vt->prepare("DELETE FROM yonetici where id = ?");
					$stmt_sil->execute([$id]);
	            	
	            	$ral = $yonetici->fetch(); 
					$resimsil = @unlink("..".$ral['resim']);

					$stmt_sosyalsil = $vt->prepare("DELETE FROM yonetici_sosyal where yoneticiid = ?");
					$stmt_sosyalsil->execute([$id]);

					go("index.php?do=islem&uyeler=uyeler&islem=liste&hareket=onay&id=$id",0);

				}

				if ($durum == "0") {
					$stmt_d0 = $vt->prepare("UPDATE yonetici SET durum = '0' where id = ?");
					$stmt_d0->execute([$id]);
					go("index.php?do=islem&uyeler=uyeler&islem=liste&hareket=onay&id=$id",0);
				}
				if ($durum == "1") {
					$stmt_d1 = $vt->prepare("UPDATE yonetici SET durum = '1' where id = ?");
					$stmt_d1->execute([$id]);
					go("index.php?do=islem&uyeler=uyeler&islem=liste&hareket=onay&id=$id",0);
				}
			?>
			<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
				<table id="example1" class="table table-bordered table-striped table-hover dataTable" role="grid" aria-describedby="example1_info">
				    <thead>
				        <tr>                        
				            <td style="width:0.01%;"> ID </td>
				            <td style="width:0.001%;"> Profil </td>
				            <td style="width:0.1%;"> Ad Soyad </td>  
				            <td style="width:0.05%;"> Email / GSM / Tel</td>  
				            <td style="width:0.05%;"> Durum </td> 
				            <td class="text-center" style="width:0.1%;"> İşlemler </td>
				        </tr>
				    </thead>
				    <tbody>  
				    	<?php 
				    		while($yliste = $yoneticiliste->fetch()) {
				    	?>
				    	<tr>
				    		<th><?=$yliste["id"];?></th>
				    		<th>
				    			<?php 
				    				if (!$yliste["resim"] == "") {
				    			?>
			    				<div class="resim_liste">
									<img src="<?=$yliste["resim"];?>"/>								
								</div>
								<?php } else { ?>
								<div class="resim_liste">
									<img src="../uploads/resim/resim.png"/>								
								</div>
								<?php } ?> 
				    		</th>
				    		<th><?=$yliste["adsoyad"];?></th> 
				    		<th>
				    			<?=$yliste["email"];?> <br>
				    			<strong>GSM: </strong><?=$yliste["gsm"];?> <br>
				    			<strong>Tel: </strong><?=$yliste["tel"];?> 
				    		</th>  
				    		<th>
					    		<?php 
			        				if ($yliste["durum"] == 0) {
			        			?>
			        			<span class="btn btn-success btn-xs btn-block"> Yayında </span>
			        			<?php } else if ($yliste["durum"] == 1) { ?>
			        			<span class="btn btn-info btn-xs btn-block"> Yayında Değil</span>
			        			<?php } ?>
				    		</th>
				    		<th class="text-center">
				    			<a href="index.php?do=islem&uyeler=uyeler&islem=duzenle&id=<?=$yliste['id']?>" style="text-align: left;" title="Düzenle" class="btn btn-success btn-block btn-xs">
									<i class="fa fa-pencil"></i> Düzenle
								</a>
								<?php 
									if ($yliste["durum"] == "0") {
								?>
								<a href="index.php?do=islem&uyeler=uyeler&islem=liste&durum=1&id=<?=$yliste['id']?>" style="text-align: left;" title="Yayından Kaldır" class="btn btn-xs btn-block btn-default">
									<i class="fa fa-close"></i> Pasif Et
								</a>
								<?php } else if ($yliste["durum"] == "1"){ ?>
								<a href="index.php?do=islem&uyeler=uyeler&islem=liste&durum=0&id=<?=$yliste['id']?>" style="text-align: left;" title="Yayınla" class="btn btn-xs btn-block btn-default">
									<i class="fa fa-check"></i> Aktif Et
								</a>
								<?php } ?>
								<a href="index.php?do=islem&uyeler=uyeler&islem=liste&sifre=sifre&id=<?=$yliste['id']?>" style="text-align: left;" title="Şifre Değiştir" class="btn btn-info btn-block btn-xs">
									<i class="fa fa-key"></i> Şifre Değiştir
								</a>
								<?php 
									if ($yliste["id"] !== $_SESSION['id']) {
								?>
								<a href="#" data-toggle="modal" data-target="#<?=$yliste["id"];?>" title="Sil" style="text-align: left;" class="btn btn-xs btn-block btn-danger">
									<i class="fa fa-trash" style="color: r ed;"></i> Sil
								</a>
								<?php } ?>  
								<div class="modal modal-default fade" id="<?=$yliste["id"]?>" style="display: none;">
								  <div class="modal-dialog">
									<div class="modal-content">
									  <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										  <span aria-hidden="true">×</span></button>
										<h4 class="modal-title">Silme Onayı Ver</h4>
									  </div>
									  <div class="modal-body">
										<h4><strong> "<?=$yliste["adsoyad"]?>" </strong> isimli danışman silinecektir. İşlemi onaylıyor musunuz ?</h4>
									  </div>
									  <div class="modal-footer">
										<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
										<a href="index.php?do=islem&uyeler=uyeler&islem=liste&hareket=sil&id=<?=$yliste['id']?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
									  </div>
									</div> 
								  </div> 
								</div>
				    		</th>
				    	</tr> 
				    	<?php } ?>
				    </tbody>
				</table>
			</div>
		</div>
	</div>
</section>
<?php } ?>
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>