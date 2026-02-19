<?php  

	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
	
	uyeYasak(yetki());
	
	$id =  $_GET["id"];
	$islem =  $_GET["islem"];
	$hareket =  $_GET["hareket"];
	$durum =  $_GET["durum"];
	$sliderid = $vt->query("SELECT * FROM slider where id = '$id'");
?>
<section class="content-header">

	<i class="fa fa-camera-retro fa-2x pull-left"></i>

	Slayt Yönetimi 

	<p> <small> Slider / Banner Yönetimi </small> </p>

</section>
<?php 
	if (isset($_POST["ekle"]) || isset($_POST["kaydet"]) || isset($_POST["sirakaydet"])) {
		
		$baslik	= tirnak($_POST['baslik']); 
		$link	= $_POST['link']; 
		$font	= $_POST['font']; 
		$font_family	= $_POST['font_family']; 
		$font_size	= $_POST['font_size']; 
		$harici	= $_POST['harici']; 
		$sira	= $_POST['sira']; 
		$aciklama	= $_POST['aciklama'];
		$siraid 		= $_POST["siraid"];
		$sira 			= $_POST["sira"];

		if (isset($_POST["ekle"])) {

			$ekle = $vt->query("INSERT INTO slider (baslik, link, harici, sira, aciklama, font, font_family, font_size) values ('$baslik','$link','$harici','$sira','$aciklama','$font','$font_family','$font_size')");

			if ($ekle == true) {

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

				            	$ids = $vt->query("SELECT * FROM slider order by id desc limit 1");
				                $id = $ids->fetch(); 

				                $link2 = "/uploads/resim/".$saat.".jpg";
				                $ekle = $vt->query("UPDATE slider SET resim = '$link2' where id = '".$id["id"]."'");
				                $yuklenenler++; 

				            }

				        } else {

				            $yuklenmeyenler++;

				        }
				    }
				}
				go("index.php?do=icerik/slider&hareket=onay",0);
			}
		}

		if (isset($_POST["kaydet"])) {
			$kaydet = $vt->query("UPDATE slider SET baslik = '$baslik', link = '$link', harici = '$harici', sira = '$sira', aciklama = '$aciklama', font = '$font', font_family = '$font_family', font_size = '$font_size' where id = '$id'");

			if ($kaydet == true) {
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

				            	$resimal = $vt->query("SELECT * FROM slider where id = '$id'");
				                $ral = $resimal->fetch(); 

				                $sil = @unlink("..".$ral['resim']);

				                $link2 = "/uploads/resim/".$saat.".jpg";
				                $ekle = $vt->query("UPDATE slider SET resim = '$link2' where id = '$id'");
				                $yuklenenler++; 

				            }

				        } else {

				            $yuklenmeyenler++;

				        }
				    }
				}
				go("index.php?do=icerik/slider&hareket=onay",0);
			}
		}

		if (isset($_POST["sirakaydet"])) {

			for ($i=0; $i < count($siraid) ; $i++) { 
				
				$sirakaydet = $vt->query("UPDATE slider SET sira = '$sira[$i]' where id = '$siraid[$i]'");
 				 
				if ($sirakaydet == true) {
					go("index.php?do=icerik/slider&hareket=onay",0);
				}

 			} 
			
		}
	}	
?>
<?php if ($islem == "ekle") { ?>
<form action="" method="post" enctype="multipart/form-data">
	<section class="content">  
		<div class="box"> 
			<div class="box-header with-border">
				<h3 class="box-title"> <i class="fa fa-plus"></i> Slider Ekleme </h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body" style="">
				<div class="form-horizontal"> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Slayt Başlığı:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="baslik" value="">
					  </div>
					</div>  
					<div class="form-group">
					  <label class="col-sm-2 control-label">Font Bağlantısı:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="font" value="">
						<br>
						<a target="_blank" href="https://fonts.google.com/">Google Fontlar <i class="fa fa-external-link"></i></a>
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Font Family:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="font_family" value=""> 
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Font Size:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="font_size" value=""> 
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Açıklama:</label>
					  <div class="col-sm-10"> 
						<textarea id="editor1" class="form-control" name="aciklama"></textarea>
					  </div> 
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Harici Link</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="link">
					  </div>
					</div>  
					<div class="form-group">
					  <label class="col-sm-2 control-label">Harici Bağlantı</label>
					  <div class="col-sm-10"> 
						<label for="anavitrin">
						  	<div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
						  		<input type="checkbox" name="harici" value="1" class="minimal" style="position: absolute; opacity: 0;">
						  	</div>
							Tıklandığında yeni sayfada açılsın.
						</label>
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Sıra:</label>
					  <div class="col-sm-10">
					  	<input type="text" class="form-control" name="sira">
					  </div> 
					</div>  
					<div class="form-group">
					  <label class="col-sm-2 control-label">Resim:</label>
					  <div class="col-sm-10">
					  	<input type="file" class="form-control" name="resim[]">
					  </div> 
					</div> 
				</div>
			</div>
		</div> 
		<div class="box"> 
			<div class="box-footer">
				<button type="submit" class="btn btn-success btn-lg pull-right" name="ekle"> <i class="fa fa-check"></i> Yeni Ekle </button>
			 </div> 
		</div> 
	</section>
</form>
<?php } ?> 
<?php if ($islem == "duzenle") { ?>
<form action="" method="post" enctype="multipart/form-data">
	<?php
		$sliderler = $vt->query("SELECT * FROM slider where id = '$id'");
		$s = $sliderler->fetch();
	?> 
	<section class="content">  
		<div class="box"> 
			<div class="box-header with-border">
				<h3 class="box-title"> <i class="fa fa-edit"></i> Slider Düzenleme </h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body" style="">
				<div class="form-horizontal"> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Slayt Başlığı:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="baslik" value="<?=$s["baslik"];?>">
					  </div>
					</div>  
					<div class="form-group">
					  <label class="col-sm-2 control-label">Font Bağlantısı:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="font" value="<?=$s["font"];?>">
						<br>
						<a target="_blank" href="https://fonts.google.com/">Google Fontlar <i class="fa fa-external-link"></i></a>
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Font Family:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="font_family" value="<?=$s["font_family"];?>"> 
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Font Size:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="font_size" value="<?=$s["font_size"];?>"> 
					  </div>
					</div>  
					<div class="form-group">
					  <label class="col-sm-2 control-label">Açıklama:</label>
					  <div class="col-sm-10"> 
						<textarea id="editor1" class="form-control" name="aciklama"><?=$s["aciklama"];?></textarea>
					  </div> 
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Harici Link</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="link" value="<?=$s["link"];?>">
					  </div>
					</div>  
					<div class="form-group">
					  <label class="col-sm-2 control-label">Harici Bağlantı</label>
					  <div class="col-sm-10"> 
						<label for="anavitrin">
						  	<div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
						  		<?php 
						  			if ($s["harici"] == 1) {
						  		?>
						  		<input type="checkbox" name="harici" checked value="1" class="minimal" style="position: absolute; opacity: 0;">
						  		<?php } else { ?>
						  		<input type="checkbox" name="harici" value="1" class="minimal" style="position: absolute; opacity: 0;">						  		
						  		<?php } ?>
						  	</div>
							Tıklandığında yeni sayfada açılsın.
						</label>
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Sıra:</label>
					  <div class="col-sm-10">
					  	<input type="text" class="form-control" name="sira" value="<?=$s["sira"];?>">
					  </div> 
					</div>  
					<div class="form-group">
					  <label class="col-sm-2 control-label">Resim:</label>
					  <div class="col-sm-10">
					  	<input type="file" class="form-control" name="resim[]">
					  </div> 
					</div>   
					<div class="form-group">
					  <label class="col-sm-2 control-label"></label>
					  <div class="col-sm-10">
					  	
		    			<?php 
		    				if (!$s["resim"] == "") {
		    			?>
	    				<div class="resim_li ste">
							<img class="img-thumbnail img-responsive" src="<?=$s["resim"];?>"/>								
						</div>
						<?php } else { ?>
						<div class="resim_list e">
							<img class="img-thumbnail img-responsive" style="overflow:hidden;" src="../uploads/resim/resim.png"/>								
						</div>
						<?php } ?>
					  </div> 
					</div> 
				</div>
			</div>
		</div> 
		<div class="box"> 
			<div class="box-footer">
				<button type="submit" class="btn btn-primary btn-lg pull-right" name="kaydet"> <i class="fa fa-check"></i> Kaydet </button>
			 </div> 
		</div> 
	</section> 
</form>
<?php } ?> 
<?php
	if ($islem == "") {
?>
<section class="content">
	<?php 

		if ($hareket == "onay") {
			onay();
		}

		if ($durum == "0") {
			$d = $vt->query("UPDATE slider SET durum = '0' where id = '$id'"); 
			go("index.php?do=icerik/slider&hareket=onay&id=$id",0);
		}
		if ($durum == "1") {
			$d = $vt->query("UPDATE slider SET durum = '1' where id = '$id'"); 
			go("index.php?do=icerik/slider&hareket=onay&id=$id",0);
		}

		if ($hareket == "sil") {
			
			$sil = $vt->query("DELETE FROM slider where id = '$id'"); 

			$ral = $sliderid->fetch(); 
			$resimsil = @unlink("..".$ral['resim']);

			go("index.php?do=icerik/slider&hareket=onay&id=$id",0);

		}

	?>
    <a href="index.php?do=icerik/slider&islem=ekle" class="btn btn-lg bt-xs btn-success">
        <i class="fa fa-plus"></i> Yeni Ekle
    </a>
	<form action="" method="post">
		<div class="bo x"> 
			<div class="box-bo dy table-responsive">
				<table id="example1" class="table table-bordered dataTable" colspan="5" role="grid" aria-describedby="example1_info">
				    <thead>
				        <tr>                        
				            <td style="width:0.004%;"> ID </td>
				            <td style="width:0.01%;"> Slider Resim </td> 
				            <td style="width:0.1%;" colspan="2"> Slider Adı </td>
				            <td style="width:0.01%;"> Durum </td> 
				            <td style="width:0.03%;"> Sıra No </td> 
				            <td class="text-center" style="width:0.05%;"> İşlem</td>  			            
				        </tr>
				    </thead>
				    <tbody> 
				    		<?php 
				    			$sliderver = $vt->query("SELECT * FROM slider where id order by id desc");
				    			while($liste = $sliderver->fetch()) {
				    		?>
							<tr> 		
								<th class="text-center"><?=$liste["id"];?></th>			
								<th>
				    			<?php 
				    				if (!$liste["resim"] == "") {
				    			?>
			    				<div class="resim_liste" style="width: 150px !important; margin:inherit;">
									<img src="<?=$liste["resim"];?>"/>								
								</div>
								<?php } else { ?>
								<div class="resim_liste">
									<img src="../uploads/resim/resim.png"/>								
								</div>
								<?php } ?>
								</th>			
								<th><?=$liste["baslik"];?></th>			
								<th><?=strip_tags($liste["aciklama"]);?></th>			
								<th>
									<?php 
				        				if ($liste["durum"] == 0) {
				        			?>
					        			<span class="btn bg-success btn-xs btn-block"> Akttif </span>
					        			<?php } else if ($liste["durum"] == 1) { ?>
					        			<span class="btn bg-danger btn-xs btn-block"> Pasif </span>
			        				<?php } ?>
								</th>
								<th>
									<input type="text" name="siraid[]" class="form-control hidden" value="<?=$liste["id"];?>">
									<input type="text" name="sira[]" class="form-control" value="<?=$liste["sira"];?>">
								</th>
								</th>
								<th class="text-center">
									<a href="index.php?do=icerik/slider&islem=duzenle&id=<?=$liste['id']?>" title="Düzenle" class="btn btn-primary btn-xs btn-block">
										<i class="fa fa-pencil"></i> Düzenle
									</a>
									<?php 
										if ($liste["durum"] == "0") {
									?>
									<a href="index.php?do=icerik/slider&durum=1&id=<?=$liste['id']?>" title="Yayından Kaldır" class="btn btn-warning btn-xs btn-block">
										<i class="fa fa-close"></i> Pasif Yap
									</a>
									<?php } else if ($liste["durum"] == "1"){ ?>
									<a href="index.php?do=icerik/slider&durum=0&id=<?=$liste['id']?>" title="Yayınla" class="btn btn-success btn-xs btn-block">
										<i class="fa fa-check"></i> Akfit Yap
									</a>
									<?php } ?>
									<a href="#" data-toggle="modal" data-target="#<?=$liste["id"];?>" title="Sil"" class="btn btn-danger btn-xs btn-block">
										<i class="fa fa-trash"></i> Sil
									</a>
									<div class="modal modal-default text-center fade" id="<?=$liste["id"]?>" style="display: none;">
									  <div class="modal-dialog">
										<div class="modal-content">
										  <div class="modal-header alert alert-info">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true">×</span></button>
											<h4 class="modal-title"><i class="fa fa-close"></i> Silme Onayı Ver</h4>
										  </div>
										  <div class="modal-body">
											<h4><strong> "<?=$liste["baslik"]?>" </strong> isimli slaytı silmek istiyor musunuz ?</h4>
										  </div>
										  <div class="modal-footer">
											<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
											<a href="index.php?do=icerik/slider&hareket=sil&id=<?=$liste['id']?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
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
		
		<button type="submit" class="btn btn-primary btn-lg" name="sirakaydet"> <i class="fa fa-check"></i> Sıralamayı Kaydet </button>
		
	</form>
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