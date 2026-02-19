<?php 
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
	
	uyeYasak(yetki());
	

	$islem =  @$_GET["islem"];
	$hareket =  @$_GET["hareket"];  


?>

<!-- Content Header (Page header) -->

<section class="content-header">
	<i class="fa fa-cogs fa-2x pull-left"></i>
	 Site Doğrulama
	<p> <small> Web Master Araçları </small> </p>
</section>

<section class="content">
<?php 

	if (isset($_POST["kaydet"])) { 

		$dogrulama = addslashes($_POST["dogrulama"]); 

		$kaydet = $vt->query("UPDATE ayar_site SET dogrulama = '$dogrulama' where id = '1'");

		go("index.php?do=islem&webmaster=dogrulama&hareket=onay",0);		


		
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
				<!-- /.box-header -->
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-check"></i> Doğrulama Kodu </h3>
					</div>
					<div class="box-body pad" style="">
						<div class="form-horizontal">
							<div class="form-group">								
								<div class="alert alert-warning">
									<span>Google Webmaster Tool, Yandex Webmaster, Bing Webmaster vb. platformlara üye olduğunuzda sizden doğrulama isteyecektir. Doğrulama için size verilen html etiketlerini ilgili bölümleri yapıştırınız. İşlemler hakkında tecrübeli değilseniz Destek Talebi oluşturabilirsiniz.</span>
								</div>
							</div>
							<div class="form-group">
							  <label class="col-sm-3 control-label">Verification Kodu :</label>
							  <div class="col-sm-9"> 
									<textarea class="form-control" name="dogrulama" rows="8" ><?php echo $site["dogrulama"]; ?></textarea>
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
			<?php include ("/../right-menu.php"); ?>
		</div>
	</div>
</section>