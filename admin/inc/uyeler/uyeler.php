<?php  
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;

	$islem = $_GET["islem"]; 
	$id = $_GET["id"];
	$ofis = $_GET["ofis"];
	$hareket = $_GET["hareket"];
	$durum = $_GET["durum"];
	$sifre = $_GET["sifre"];

	$yonetici = mysql_query("SELECT * FROM yonetici where id = '$id'");
	$yoneticiliste = mysql_query("SELECT * FROM yonetici where yetki = 1 order by id desc");
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

			$varmi=mysql_num_rows(mysql_query("SELECT * FROM yonetici where email='$email'"));

			if($varmi!=0) { 

				hata("<strong>$email</strong> kayıtlı, lütfen farklı bir e-posta giriniz."); 

			} else {

				$yoneticiekle = mysql_query("INSERT INTO yonetici (adsoyad, seo, kadi, pass, email, tel, fax, gsm, unvan, sira, sube, aciklama) VALUES ('$adsoyad', '$seo', '$kadi', '$pass', '$email', '$tel', '$fax', '$gsm', '$unvan', '$sira', '$sube', '$aciklama')");

                $ids = mysql_query("SELECT * FROM yonetici where kadi = '$kadi'");
                $id = mysql_fetch_array($ids);

                // sosyal medya bilgileri

				for ($i=0; $i < count($sosyalid) ; $i++) {
					
                	$sosyalekle = mysql_query("INSERT INTO yonetici_sosyal (yoneticiid, sosyalid, sosyallink, baslik) VALUES ('".$id["id"]."', '".$sosyalid[$i]."','".$sosyallink[$i]."','".$sosyalbaslik[$i]."')");
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
									
					                $ids = mysql_query("SELECT * FROM yonetici where kadi = '$kadi'");
					                $id = mysql_fetch_array($ids); 

					                $link = "/uploads/resim/".$saat.".jpg";
					                $ekle = mysql_query("UPDATE yonetici SET resim = '$link' where id = '".$id["id"]."'");
					                $yuklenenler++; 
  
					            }

					        } else {

					            $yuklenmeyenler++;

					        }
					    }
					}

					$ids = mysql_query("SELECT * FROM yonetici where kadi = '$kadi'");
					$id = mysql_fetch_array($ids); 

					go("index.php?do=islem&uyeler=uyeler&islem=liste&hareket=onay&id=$id[id]",0); 

				}

			}

		}

		if (isset($_POST["yoneticikaydet"])) {

			$yoneticikaydet = mysql_query("UPDATE yonetici SET adsoyad = '$adsoyad', seo = '$seo', tel = '$tel', fax = '$fax', gsm = '$gsm', unvan = '$unvan', sira = '$sira', sube = '$sube', aciklama = '$aciklama' where id = '$id'");

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
								
								
				            	$resimal = mysql_query("SELECT * FROM yonetici where id = $id");
				            	$ral = mysql_fetch_array($resimal);

								$sil = @unlink("..".$ral['resim']);
				                
				                $link = "/uploads/resim/".$saat.".jpg";
				                $ekle = mysql_query("UPDATE yonetici SET resim = '$link' where id = '$id'");
				                $yuklenenler++; 

				            }

				        } else {

				            $yuklenmeyenler++;

				        }
				    }
				}

				$silsosyal = mysql_query("DELETE FROM yonetici_sosyal where yoneticiid = '$id'");


				for ($i=0; $i < count($sosyalid) ; $i++) {
				
                	$sosyalekle = mysql_query("INSERT INTO yonetici_sosyal (yoneticiid, sosyalid, sosyallink, baslik) VALUES ('$id', '".$sosyalid[$i]."','".$sosyallink[$i]."','".$sosyalbaslik[$i]."')");
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
						$sosyalmedya = mysql_query("SELECT * FROM ayar_sosyal order by sira asc");
						while ($sosyal=mysql_fetch_array($sosyalmedya)) {
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
			$yoneticiler = mysql_query("SELECT * FROM yonetici where id = '$id'");
			while($y = mysql_fetch_array($yoneticiler)) {
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
							$sosyalmedya = mysql_query("SELECT * FROM ayar_sosyal order by sira asc");
							while($sosyal=mysql_fetch_array($sosyalmedya)) {
							$ysosyal = mysql_query("SELECT * FROM yonetici_sosyal where sosyalid = '".$sosyal["id"]."' && yoneticiid = '$id' ");
							$ys = mysql_fetch_array($ysosyal);
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
		$ysifre=mysql_fetch_array($yonetici);

		if (isset($_POST["sifrekaydet"])) {

			$yenisifre=trim(md5($_POST["yenisifre"]));

			$sifreduzenle=mysql_query("UPDATE yonetici SET pass = '$yenisifre' where id = '$id'"); 

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
					
					$sil = mysql_query("DELETE FROM yonetici where id = '$id'"); 
	            	
	            	$ral = mysql_fetch_array($yonetici); 
					$resimsil = @unlink("..".$ral['resim']);

					$sosyalsil = mysql_query("DELETE FROM yonetici_sosyal where yoneticiid = '$id'");

					go("index.php?do=islem&uyeler=uyeler&islem=liste&hareket=onay&id=$id",0);

				}

				if ($durum == "0") {
					$d = mysql_query("UPDATE yonetici SET durum = '0' where id = '$id'"); 
					go("index.php?do=islem&uyeler=uyeler&islem=liste&hareket=onay&id=$id",0);
				}
				if ($durum == "1") {
					$d = mysql_query("UPDATE yonetici SET durum = '1' where id = '$id'"); 
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
				    		while($yliste = mysql_fetch_array($yoneticiliste)) {
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