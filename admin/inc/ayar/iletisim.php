<?php 

	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
	
	uyeYasak(yetki());
	

	$islem =  @$_GET["islem"];
	$hareket =  @$_GET["hareket"];  

	$ayariletisim = mysql_query("SELECT * FROM ayar_site where id");
	$a = mysql_fetch_array($ayariletisim);

?>

<!-- Content Header (Page header) -->

<section class="content-header">

	<i class="fa fa-cog fa-2x pull-left"></i>
	 
	İletişim Bilgileri Yönetimih

	<p> <small> Genel Ayarları </small> </p>

</section>	

<section class="cont ent">
<?php 

	if (isset($_POST["kaydet"])) {

		$firmadi = $_POST["firmadi"];
		$adres = mysql_real_escape_string($_POST["adres"]);
		$email = $_POST["email"];
		$email2 = $_POST["email2"];
		$sabittel = $_POST["sabittel"];
		$sabittel2 = $_POST["sabittel2"];
		$fax = $_POST["fax"];
		$gsm = $_POST["gsm"];
		$gsm2 = $_POST["gsm2"];

		$sosyalid 	= $_POST["sosyalid"];
		$sosyallink = $_POST["sosyallink"];
		$sosyalbaslik = $_POST["sosyalbaslik"];
		$sosyalicon = $_POST["sosyalicon"];
		$sosyallink2 = $_POST["sosyallink2"];

		$kaydet = mysql_query("UPDATE ayar_site SET firmadi = '$firmadi', adres = '$adres', email = '$email', email2 = '$email2', sabittel = '$sabittel', sabittel2 = '$sabittel2', fax = '$fax', gsm = '$gsm', gsm2 = '$gsm2'  where id = '1'");

		$silsosyal = mysql_query("DELETE FROM ayar_sitesosyal where siteid = '1'");


		for ($i=0; $i < count($sosyalid) ; $i++) {
		
        	$sosyalekle = mysql_query("INSERT INTO ayar_sitesosyal (siteid, sosyalid, sosyallink, baslik, icon, link) VALUES ('1', '".$sosyalid[$i]."','".$sosyallink[$i]."','".$sosyalbaslik[$i]."','".$sosyalicon[$i]."','http://".$sosyallink2[$i]."')");
		}		

		go("index.php?do=islem&ayarlar=iletisim&hareket=onay",0);  

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
					  <h5 class="box-title"> <i class="fa fa-edit"></i> Site İletişim Bilgileri </h5>
					</div>
				<!-- /.box-header -->
					<div class="box-body pad" style="">
						<div class="form-horizontal"> 
							<div class="form-group">
							  <label class="col-sm-2 control-label">Firma Adı:</label>
							  <div class="col-sm-10"> 
							  	<input type="text" class="form-control" name="firmadi" value="<?=$a["firmadi"];?>" /> 									
							  </div>
							</div> 
							<div class="form-group">
							  <label class="col-sm-2 control-label">Adres:</label>
							  <div class="col-sm-10"> 
								<textarea class="form-control" name="adres" rows="8" cols="80"><?=$a["adres"];?></textarea>
							  </div>
							</div>
							<div class="form-group">
							  <label class="col-sm-2 control-label">E-mail:</label>
							  <div class="col-sm-10"> 
							  	<input type="text" class="form-control" name="email" value="<?=$a["email"];?>" /> 									
							  </div>
							</div>
							<div class="form-group">
							  <label class="col-sm-2 control-label">E-mail 2:</label>
							  <div class="col-sm-10"> 
							  	<input type="text" class="form-control" name="email2" value="<?=$a["email2"];?>" /> 									
							  </div>
							</div>  
							<div class="form-group">
							  <label class="col-sm-2 control-label">Sabit Tel:</label>
							  <div class="col-sm-10"> 
							  	<input type="text" class="form-control" name="sabittel" value="<?=$a["sabittel"];?>" /> 									
							  </div>
							</div>    
							<div class="form-group">
							  <label class="col-sm-2 control-label">Sabit Tel 2:</label>
							  <div class="col-sm-10"> 
							  	<input type="text" class="form-control" name="sabittel2" value="<?=$a["sabittel2"];?>" /> 									
							  </div>
							</div>     
							<div class="form-group">
							  <label class="col-sm-2 control-label">Fax:</label>
							  <div class="col-sm-10"> 
							  	<input type="text" class="form-control" name="fax" value="<?=$a["fax"];?>" /> 									
							  </div>
							</div>     
							<div class="form-group">
							  <label class="col-sm-2 control-label">GSM:</label>
							  <div class="col-sm-10"> 
							  	<input type="text" class="form-control" name="gsm" value="<?=$a["gsm"];?>" /> 									
							  </div>
							</div>       
							<div class="form-group">
							  <label class="col-sm-2 control-label">GSM 2:</label>
							  <div class="col-sm-10"> 
							  	<input type="text" class="form-control" name="gsm2" value="<?=$a["gsm2"];?>" /> 									
							  </div>
							</div>    
						</div>
					</div>
				</div>
				<div class="alert alert-warning">
					<i class="fa fa-edit"></i> <strong>Firma</strong> sosyal medya bilgileri
				</div>

				<div class="box">						
					<div class="box-body">	 
						<div class="form-horizontal">   

							<?php
								$sosyalmedya = mysql_query("SELECT * FROM ayar_sosyal order by sira asc");
								while($sosyal=mysql_fetch_array($sosyalmedya)) {
								$ysosyal = mysql_query("SELECT * FROM ayar_sitesosyal where sosyalid = '".$sosyal["id"]."' && siteid = '1' ");
								$ys = mysql_fetch_array($ysosyal);
							?>
							<div class="form-group">
								<input type="text" class="form-control hidden" name="sosyallink2[]" value="<?=$sosyal["link"];?>">
								<input type="text" class="form-control hidden" name="sosyalicon[]" value="<?=$sosyal["icon"];?>">
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
						<button type="submit" name="kaydet" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Kaydet </button>
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-3">
			<?php include ("right-menu.php"); ?>
		</div>
	</div>
</section>