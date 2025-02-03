<?php 
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
	
	uyeYasak(yetki());
	

	$islem =  @$_GET["islem"];
	$hareket =  @$_GET["hareket"];  

?>

<!-- Content Header (Page header) -->

<section class="content-header">

	<i class="fa fa-cog fa-2x pull-left"></i>
	 
	Favicon Yönetimi

	<p> <small> Genel Ayarları </small> </p>

</section>

<section class="content">
<?php 

	if (isset($_POST["resimkaydet"])) { 

        unlink("../favicon.ico");
        
        $sonuc = move_uploaded_file($_FILES["dosya"]["tmp_name"], "../favicon.ico");  

		go("index.php?do=islem&ayarlar=favicon&hareket=onay",0); 



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
					  <h5 class="box-title"> <i class="fa fa-edit"></i> Site Favicon </h5>
					</div>
					<div class="box-body pad" style="">
						<div class="form-horizontal">
							<div class="form-group">								
								<div class="alert alert-warning">
									<span>Tarayıcının üst bölümünde yer alan icon için yükleme alanıdır. 32x32px boyutlarında transparan bir resim yüklemeniz tavsiye edilir.</span>
								</div>
							</div>
							<div class="form-group">
							  <label class="col-sm-2 control-label">Site Favicon:</label>
							  <div class="col-sm-10"> 
									<img class="img-thumbnail" src="/favicon.ico" width="50"/>								
							  </div>
							</div>
							<div class="form-group">
							  <label class="col-sm-2 control-label">Favicon Yükle:</label>
							  <div class="col-sm-4">
							  	<input type="file" class="form-control" name="dosya"/> 
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