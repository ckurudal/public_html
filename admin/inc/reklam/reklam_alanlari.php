<?php 

	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
	

	$islem =  $_GET["islem"];
	$hareket =  $_GET["hareket"];  

?>
<!-- Content Header (Page header) -->
<section class="content-header">

	<i class="fa fa-code fa-2x pull-left"></i>

	Reklam Kodu Yönetimi

	<p> <small> Reklam Alanları </small> </p>

</section>
<section class="c ontent">
<?php 

	if (isset($_POST["kaydet"])) { 

		$kategori_sidebar = mysql_real_escape_string($_POST["kategori_sidebar"]);
		$ilan_sidebar = mysql_real_escape_string($_POST["ilan_sidebar"]);
		$kategori_ust = mysql_real_escape_string($_POST["kategori_ust"]);
		$kategori_alt = mysql_real_escape_string($_POST["kategori_alt"]);

		$duzenle = $vt->query("UPDATE reklam SET kategori_sidebar = '".$kategori_sidebar."', ilan_sidebar = '".$ilan_sidebar."', kategori_ust = '".$kategori_ust."', kategori_alt = '".$kategori_alt."' WHERE id = 1");


		// go("index.php?do=reklam/reklam_alanlari&hareket=onay",0);		


		
	}

?>
</section>
<section class="content">
	<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-6">  
 				<?php 

					if ($hareket == "onay") {
						onay();
					} 

				?>  
				<div class="box">

					<div class="box-header with-border">
						<h3 class="box-title"> Kategori Sidebar </h3>
					</div>

					<div class="box-body pad" style="">
						<div class="form-horizontal">
							<div class="form-group">
						  		<?php 
						  			 $reklam=$vt->query("SELECT * FROM reklam where id = 1")->fetch();
						  		?>
								<textarea class="form-control" name="kategori_sidebar" rows="8" ><?=$reklam["kategori_sidebar"]; ?></textarea>
							</div>  
						</div> 
					</div>
				</div> 
			</div> 
			<div class="col-md-6">  
				<?php 

					if ($hareket == "onay") {
						onay();
					} 

				?>  
				<div class="box">

					<div class="box-header with-border">
						<h3 class="box-title"> İlan Detay Sidebar </h3>
					</div>

					<div class="box-body pad" style="">
						<div class="form-horizontal"> 
							<div class="form-group">
							  <?php 
						  			 $reklam=$vt->query("SELECT * FROM reklam where id = 1")->fetch();
						  		?>
								<textarea class="form-control" name="ilan_sidebar" rows="8" ><?=$reklam["ilan_sidebar"]; ?></textarea>
							</div>  
						</div>
					</div>
				</div>
			</div> 
			<div class="col-md-6">  
				<?php 

					if ($hareket == "onay") {
						onay();
					} 

				?>  
				<div class="box">

					<div class="box-header with-border">
						<h3 class="box-title"> Kategori Üstü Reklamlar </h3>
					</div>

					<div class="box-body pad" style="">
						<div class="form-horizontal"> 
							<div class="form-group">
							  <?php 
						  			 $reklam=$vt->query("SELECT * FROM reklam where id = 1")->fetch();
						  		?>
								<textarea class="form-control" name="kategori_ust" rows="8" ><?=$reklam["kategori_ust"]; ?></textarea>
							</div>  
						</div>
					</div>
				</div>
			</div> 
			<div class="col-md-6">  
				<?php 

					if ($hareket == "onay") {
						onay();
					} 

				?>  
				<div class="box">

					<div class="box-header with-border">
						<h3 class="box-title"> Kategori Altı Reklamlar </h3>
					</div>

					<div class="box-body pad" style="">
						<div class="form-horizontal"> 
							<div class="form-group">
							  <?php 
						  			 $reklam=$vt->query("SELECT * FROM reklam where id = 1")->fetch();
						  		?>
								<textarea class="form-control" name="kategori_alt" rows="8" ><?=$reklam["kategori_alt"]; ?></textarea>
							</div>  
						</div>
					</div>
				</div>
			</div> 
		</div>
		<div class="row">
			
		</div>
		<div class="box-footer col-md-12">						
			<button type="submit" name="kaydet" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Kaydet </button>
		</div>
	</form>
</section>