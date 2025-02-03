<?php 
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
	
	uyeYasak(yetki());
	

	$islem =  @$_GET["islem"];
	$hareket =  @$_GET["hareket"];  

?>

<!-- Content Header (Page header) -->

<section class="content-header">

	<i class="fa fa-mobile-phone fa-2x pull-left"></i>
	 
	Mobil Site Logosu

	<p> <small> Genel Ayarları </small> </p>

</section>

<section class="content">
<?php 

	if (isset($_POST["resimkaydet"])) {
		
		$mobillogouzunluk = $_POST["mobillogouzunluk"];  

		$resimkaydet = mysql_query("UPDATE ayarlar SET mobillogouzunluk = '$mobillogouzunluk' where id = '1'");	

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
							
			                $ids = mysql_query("SELECT * FROM ayarlar where id = '1'");
			                $id = mysql_fetch_array($ids); 

			                $sil = @unlink("..".$id['mobilsitelogo']);

			                $link = "/uploads/resim/".$saat.".jpg";
			                $ekle = mysql_query("UPDATE ayarlar SET mobilsitelogo = '$link' where id = '1'");
			                $yuklenenler++; 

			            }

			        } else {

			            $yuklenmeyenler++;

			        }
			    }
			}

			go("index.php?do=islem&ayarlar=mobilsitelogo&hareket=onay",0);
		if ($resimkaydet == true) { 
 

		}



	}

?>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-9">  
			<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
				<?php 

					if ($hareket == "onay") {
						onay();
					} 

				?>  
				<div class="box">
					<div class="box-header with-border">
					  <h5 class="box-title"> <i class="fa fa-edit"></i> Mobil Site Logosu </h5>
					</div>
				<!-- /.box-header -->
					<div class="box-body pad" style="">
						<div class="form-horizontal">
							<div class="form-group">								
								<div class="alert alert-warning">
									<span>Web sitenizin mobil ve tablet sürümlerinde farklı bir logo kullanmak isterseniz, bu alandan yükleyebilirsiniz.</span>
								</div>
							</div>
							<div class="form-group">
							  <label class="col-sm-2 control-label">Mobil Site Logosu:</label>
							  <div class="col-sm-10"> 
									<img class="img-thumbnail" src="<?=$ayar["mobilsitelogo"];?>" width="<?=$ayar["mobillogouzunluk"];?>"/>								
							  </div>
							</div>
							<div class="form-group">
							  <label class="col-sm-2 control-label">Mobi Logo Yükle:</label>
							  <div class="col-sm-3">
							  	<input type="file" class="form-control" name="resim[]"/> 
							  </div>
							   <label class="col-sm-2 control-label">Uzunluk:</label>
							  <div class="col-sm-3">
							  	<input type="text" class="form-control" name="mobillogouzunluk" value="<?=$ayar["mobillogouzunluk"];?>"/> 
							  </div>
							</div>   
						</div>
						<div class="box-footer">						
							<button type="submit" name="resimkaydet" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Kaydet </button>
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