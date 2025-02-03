<?php 

	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
	
	uyeYasak(yetki());
	

	$islem =  @$_GET["islem"];
	$hareket =  @$_GET["hareket"];  

?>

<!-- Content Header (Page header) -->

<section class="content-header">

	<i class="fa fa-cog fa-2x pull-left"></i>
	 
	Filigran / Watermark

	<p> <small> Genel Ayarları </small> </p>

</section>

<section class="content">
<?php  

 	if (isset($_POST["kaydet"])) {
	 		
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
		            $dosya = "../uploads/resim/watermark.png";
		            if (move_uploaded_file($_FILES["resim"]["tmp_name"][$i], $dosya)) {
						
		                $ids = mysql_query("SELECT * FROM ayar_site where id = '1'");
		                $id = mysql_fetch_array($ids); 

		                $sil = @unlink("../watermark.png");

		                $link = "/uploads/resim/watermark.png";
		                $ekle = mysql_query("UPDATE ayar_site SET watermark = '$link' where id = '1'");
		                $yuklenenler++; 

		            }

		        } else {

		            $yuklenmeyenler++;

		        }
		    }

		}	

		go("index.php?do=islem&ayarlar=watermark&hareket=onay",0);

 	}

?>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-9">  
			<form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
				<?php 

					if ($hareket == "onay") {
						onay();
					} 

				?>  

				<div class="box">
					<div class="box-header with-border">
					  <h5 class="box-title"> <i class="fa fa-edit"></i> Fligran / Watermark </h5>
					</div>
				<!-- /.box-header -->
					<div class="box-body pad" style="">
						<div class="form-horizontal">
							<div class="form-group">								
								<div class="alert alert-warning">
									<span>Yükleyeceğiniz görsel <strong>300x200</strong> px boyutlarında, arka planı transparan ve hafif silik yazı veya logo içermelidir.</span>
								</div>
							</div> 
							<div class="form-group">
							  <label class="col-sm-2 control-label">Filigran Yükle:</label>
							  <div class="col-sm-4"> 
									<input type="file" name="resim[]" class="form-control">
							  </div>
							</div>  
							<div class="form-group">
							  <label class="col-sm-2 control-label">Filigran Resmi:</label>
							  <div class="col-sm-4"> 
									<img src="<?=$site["watermark"];?>" width="" style="background: #111; padding: 20px; max-width: 100%;"/>
							  </div>
							  <div class="col-sm-5"> 
									<br>
									<span>Yükleyeceğiniz görsel 300x200 px boyutlarında, arka planı transparan ve hafif silik yazı veya logo içermelidir.</span>
  							  </div>
							</div>   
						</div>
						<div class="box-footer">						
							<button type="submit" name="kaydet" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Kaydet </button>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-3">
			<?php include ("right-menu.php"); ?>
		</div>
	</div>
</section>

