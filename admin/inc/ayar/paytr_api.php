<?php
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
	
	uyeYasak(yetki());
	
	$islem = @$_GET["islem"];
?>

<section class="content-header">

	<i class="fa fa-credit-card fa-2x pull-left"></i>
	 
	PayTR Api Ayarları

	<p> <small> Ödeme Ayarları </small> </p>

</section>

<?php	

	if (isset($_POST["kaydet"])) {

		$merchant_id	= $_POST["merchant_id"];
		$merchant_key	= $_POST["merchant_key"];
		$merchant_salt	= $_POST["merchant_salt"];
		$bildirim_url	= $_POST["bildirim_url"];
		$hata_url		= $_POST["hata_url"];
		
		$duzenle = $vt->query("UPDATE odeme_paytr SET merchant_id = '$merchant_id', merchant_key = '$merchant_key', merchant_salt = '$merchant_salt', bildirim_url = '$bildirim_url', hata_url = '$hata_url'");
		
		if ($duzenle == true) {
			go("index.php?do=ayar/paytr_api&islem=onay", 0);
		} else {
			hata();
		}
		
	}

?>

<form action="" method="post">

	<section class="content">
	
		<?php
			if ($islem == "onay") {
				onay();
			}
		?>

		<div class="box">
		
			<div class="box-header with-border">
			  <h5 class="box-title"> <i class="fa fa-code"></i> PayTR Api Entegrasyonu </h5>
			</div>
			<div class="box-body">
				
				<form class="form-horizontal" method="post" action="">
					<div class="form-group row">
					  <label class="col-sm-2 control-label">merchant_id:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="merchant_id" value="<?php echo $paytr_api["merchant_id"]; ?>">
					  </div>
					</div>
					<div class="form-group row">
					  <label class="col-sm-2 control-label">merchant_key:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="merchant_key" value="<?php echo $paytr_api["merchant_key"]; ?>">
					  </div>
					</div> 
					<div class="form-group row">
					  <label class="col-sm-2 control-label">merchant_salt:</label>
					  <div class="col-sm-10">
						<input type="text" name="merchant_salt" class="form-control" value="<?php echo $paytr_api["merchant_salt"]; ?>">
					  </div>
					</div> 
					<div class="form-group row">
					  <label class="col-sm-2 control-label">Bildirim URL:</label>
					  <div class="col-sm-10">
						<input type="text" name="bildirim_url" class="form-control" value="<?php echo $paytr_api["bildirim_url"]; ?>">
					  </div>
					</div> 
					<div class="form-group row">
					  <label class="col-sm-2 control-label">Hata URL:</label>
					  <div class="col-sm-10">
						<input type="text" name="hata_url" class="form-control" value="<?php echo $paytr_api["hata_url"]; ?>">
					  </div>
					</div> 
				  <!-- /.box-body -->
				  <div class="box-footer">						
					<button type="submit" name="kaydet" class="btn btn-success btn-lg pull-right"> <i class="fa fa-check"></i> Kaydet </button>
				  </div>
				  <!-- /.box-footer -->
				</form> 
				
			</div>
			
		</div>

	</section>
	
</form>