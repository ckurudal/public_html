<?php 
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
	
	uyeYasak(yetki());
	
	$islem =  @$_GET["islem"];
	$id =  @$_GET["id"];
	$hareket =  @$_GET["hareket"];
	$durum =  @$_GET["durum"];

	$sosyalsiteler = mysql_query("SELECT * FROM ayar_sosyal order by sira asc");
	$sosyalsitelerid = mysql_query("SELECT * FROM ayar_sosyal where id = '$id'");

?>

<!-- Content Header (Page header) -->

<section class="content-header">

	<i class="fa fa-cog fa-2x pull-left"></i>
	 
	Sosyal Medya Site Ayarları

	<p> <small> Genel Ayarları </small> </p>

</section>	
 
<section class="co ntent">
<?php 

	if (isset($_POST["sosyalekle"]) || isset($_POST["sosyalkaydet"]) || isset($_POST["sirakaydet"])) {
		
		$baslik = trim(mysql_real_escape_string($_POST["baslik"])); 
		$seo = seo($_POST["baslik"]); 
		$link = $_POST["link"]; 
		$icon = $_POST["icon"]; 
		$sira = $_POST["sira"]; 
		$siraid = $_POST["siraid"]; 

		if (isset($_POST["sosyalekle"])) {

			$sosyalekle = mysql_query("INSERT INTO ayar_sosyal (baslik, seo, link, icon) values ('$baslik', '$seo', '$link', '$icon')");	

			if ($sosyalekle == true) {
				go("index.php?do=ayar/ayar_sosyal&hareket=onay",0);
			}
		}

		if (isset($_POST["sosyalkaydet"])) {

			$sosyalkaydet = mysql_query("UPDATE ayar_sosyal SET baslik = '$baslik', seo = '$seo', link = '$link', icon = '$icon' where id = '$id'");	

			if ($sosyalkaydet == true) {
				go("index.php?do=ayar/ayar_sosyal&hareket=onay",0);
			}
		} 
	}

	if ($islem == "sil") {

		$sil = mysql_query("DELETE FROM ayar_sosyal where id = '$id'");

		$silsosyal = mysql_query("DELETE FROM yonetici_sosyal where sosyalid = '$id'");	

		$sil_ayarsitesosyal = mysql_query("DELETE FROM ayar_sitesosyal where sosyalid = '$id'");		 

		go("index.php?do=ayar/ayar_sosyal&hareket=onay",0);
	} 

	if (isset($_POST["sirakaydet"])) {

		for ($i=0; $i < count($siraid) ; $i++) { 
			
			$sirakaydet = mysql_query("UPDATE ayar_sosyal SET sira = '$sira[$i]' where id = '$siraid[$i]'");
				 
			if ($sirakaydet == true) {
				go("index.php?do=ayar/ayar_sosyal&hareket=onay",0);
			}

			} 
		
	}

?>
</section>
<section class="content">	
	<div class="row">
		<div class="col-md-9">			
			<?php
				if ($islem == "duzenle") {
			?>
			<?php 
				$sosd = mysql_fetch_array($sosyalsitelerid);
			?>

			<div class="box">
				<div class="box-header with-border">
				  <h5 class="box-title"> <i class="fa fa-edit"></i> Sosyal Medya Hesapları Düzenleme </h5>
				</div>
				<div class="box-body">
					<form class="form-horizontal" method="post" action="">
						<div class="form-group">
						  <label class="col-sm-4 control-label">Sosyal Medya Site Adı:</label>
						  <div class="col-sm-8"> 
							<input type="text" class="form-control" name="baslik" value="<?=$sosd["baslik"];?>">
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-sm-4 control-label">Sosyal Medya Linki:</label>
						  <div class="col-sm-8"> 
							<input type="text" class="form-control" name="link" placeholder="www.facebook.com" value="<?=$sosd["link"];?>">
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-sm-4 control-label">Ikon Class:</label>
						  <div class="col-sm-2"> 
							<input type="text" class="form-control" name="icon" placeholder="fa fa-facebok" value="<?=$sosd["icon"];?>">
						  </div>
					  	<?php 
					  		if ($sosd["icon"] != "") {
					  	?>
						<span class="btn bg-success"> <i class="<?=$sosd["icon"];?>" style="font-size:23px;"></i> </span>
					  	<?php } ?>
					  	<!--
						<a href="#" data-toggle="modal" data-target="#ikonlist" title="İkon Listesi" style="text-align: left; padding: 8.88px;" class="btn btn-default">
							<i class="fa fa-external-link"></i>
						</a>
						-->
						<div class="modal modal-default fade" id="ikonlist" style="display: none;">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header text-center  alert alert-info">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">×</span></button>
								<h4 class="modal-title"><i class="fa fa-check-circle"></i> İkon Seçiniz</h4>
							  </div>
							  <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
								<h5 class="alert alert-info text-center "><i class="fa fa-bullhorn"></i> Eklemek istediğiniz ikon kodunu kopyalayınız.</h5>
								<?php include("/../ikonlar.php"); ?>							
							  </div>
							  <div class="modal-footer">
								<a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Kapat </a>							
							  </div>
							</div> 
						  </div> 
						</div>
						</div> 
					  <!-- /.box-body -->
					  <div class="box-footer">						
						<button type="submit" class="btn btn-primary btn-lg pull-right" name="sosyalkaydet"> <i class="fa fa-check"></i> Kaydet </button>
					  </div>
					  <!-- /.box-footer -->
					</form>
				</div>
			</div>
			<?php } ?>
			<?php
				if ($islem == "ekle") {
			?>
			<div class="box">
				<div class="box-header with-border">
				  <h5 class="box-title"> <i class="fa fa-edit"></i> Sosyal Medya Hesapları Ekleme </h5>
				</div>
				<div class="box-body">
					<form class="form-horizontal" method="post" action="">
						<div class="form-group">
						  <label class="col-sm-4 control-label">Sosyal Medya Site Adı:</label>
						  <div class="col-sm-8"> 
							<input type="text" class="form-control" name="baslik">
						  </div>
						</div> 
						<div class="form-group">
						  <label class="col-sm-4 control-label">Sosyal Medya Linki:</label>
						  <div class="col-sm-8"> 
							<input type="text" class="form-control" name="link" placeholder="www.facebook.com">
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-sm-4 control-label">Ikon Class:</label>
						  <div class="col-sm-2"> 
							<input type="text" class="form-control" name="icon" placeholder="fa fa-facebok"> 					  
						  </div>
						  <a href="#" data-toggle="modal" data-target="#ikonlist" title="İkon Listesi" style="text-align: left; padding: 8.88px;" class="btn btn-default">
						  	<i class="fa fa-external-link"></i>
						  </a>
						<div class="modal modal-default fade" id="ikonlist" style="display: none;">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header text-center  alert alert-info">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">×</span></button>
								<h4 class="modal-title"><i class="fa fa-check-circle"></i> İkon Seçiniz</h4>
							  </div>
							  <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
								<h5 class="alert alert-info text-center "><i class="fa fa-bullhorn"></i> Eklemek istediğiniz ikon kodunu kopyalayınız.</h5>
								<?php include("/../ikonlar.php"); ?>							
							  </div>
							  <div class="modal-footer">
								<a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Kapat </a>							
							  </div>
							</div> 
						  </div> 
						</div>
						</div> 
					  <!-- /.box-body -->
					  <div class="box-footer">						
						<button type="submit" class="btn btn-primary btn-lg pull-right" name="sosyalekle"> <i class="fa fa-check"></i> Ekle </button>
					  </div>
					  <!-- /.box-footer -->
					</form>
				</div>
			</div>
			<?php } ?>
			<?php 

				if ($hareket == "onay") {
					onay();
				}

				if ($durum == "0") {
					$d = mysql_query("UPDATE ayar_sosyal SET durum = '0' where id = '$id'"); 
					go("index.php?do=ayar/ayar_sosyal&hareket=onay",0);
				}
				if ($durum == "1") {
					$d = mysql_query("UPDATE ayar_sosyal SET durum = '1' where id = '$id'"); 
					go("index.php?do=ayar/ayar_sosyal&hareket=onay",0);
				}

			?>
			<div class="box"> 
				<div class="box-footer">
					<a href="index.php?do=ayar/ayar_sosyal&islem=ekle" class="btn btn-success btn-lg pull-right" name="unvanekle"> <i class="fa fa-plus"></i> Yeni Ekle </a>
				 </div> 
			</div> 
			<form method="POST" action="">
				<div class="box">
					<div class="box-header with-border">
					  <h5 class="box-title"> <i class="fa fa-edit"></i> Site Sosyal Medya Hesapları </h5>
					</div>
					<div class="box-body table-responsive">
						
						<table class="table table-bordered table-hover table-striped table-checkable">
						    <thead>
						        <tr>                        
						            <td class="text-center" colspan="2" style="width:0.001%;"> ID </td>
						            <td style="width:0.1%;"> Başlık </td>
						            <td style="width:0.1%;"> İkon Class </td>
						            <td style="width:0.05%;"> link </td> 			            
						            <td style="width:0.05%;"> sira </td> 			            
						            <td style="width:0.05%;"> Durum </td> 			            
						            <td class="text-center" style="width:0.1%;"> İşlemler </td>
						        </tr>
					   		</thead>
					    	<tbody>
					    		<?php 
					    			while($sos = mysql_fetch_array($sosyalsiteler)) {
					    		?>
					    		<tr>
					    			<th><?=$sos["id"];?></th>
					    			<th><i class="<?=$sos["icon"];?> fa-2x"></i> </th>
					    			<th><?=$sos["baslik"];?></th>
					    			<th><?=$sos["icon"];?></th>
					    			<th><?=$sos["link"];?></th>
					    			<th>
					    				<input type="text" class="form-control hidden" name="siraid[]" value="<?=$sos["id"];?>">
					    				<input type="text" class="form-control" name="sira[]" value="<?=$sos["sira"];?>">
					    			</th>
					    			<th>
					    				<?php 
				        				if ($sos["durum"] == 0) {
					        			?>
					        			<span class="btn bg-success btn-xs btn-block"> Yayında </span>
					        			<?php } else if ($sos["durum"] == 1) { ?>
					        			<span class="btn bg-danger btn-xs btn-block"> Yayında Değil</span>
					        			<?php } ?>
					    			</th>
					    			<th class="text-center">
					    				<a href="index.php?do=ayar/ayar_sosyal&islem=duzenle&id=<?=$sos['id']?>" title="Düzenle" class="btn btn-primary btn-xs btn-block">
											<i class="fa fa-pencil"></i> Düzenle
										</a>
										<?php 
											if ($sos["durum"] == "0") {
										?>
										<a href="index.php?do=ayar/ayar_sosyal&durum=1&id=<?=$sos['id']?>" title="Yayından Kaldır" class="btn btn-warning btn-xs btn-block">
											<i class="fa fa-close"></i> Pasif Yap
										</a>
										<?php } else if ($sos["durum"] == "1"){ ?>
										<a href="index.php?do=ayar/ayar_sosyal&durum=0&id=<?=$sos['id']?>" title="Yayınla" class="btn btn-success btn-xs btn-block">
											<i class="fa fa-check"></i> Aktif Et
										</a>
										<?php } ?> 
										<a href="#" data-toggle="modal" data-target="#<?=$sos["id"];?>" title="Sil" class="btn btn-danger btn-xs btn-block">
											<i class="fa fa-trash"></i> Sil
										</a>  
										<div class="modal modal-default fade" id="<?=$sos["id"]?>" style="display: none;">
										  <div class="modal-dialog">
											<div class="modal-content">
											  <div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												  <span aria-hidden="true">×</span></button>
												<h4 class="modal-title">Silme Onayı Ver</h4>
											  </div>
											  <div class="modal-body">
												<h4><strong> "<?=$sos["baslik"]?>" </strong> isimli sosyal medya sitesi silinecektir.<br>İşlemi onaylıyor musunuz ?</h4>
											  </div>
											  <div class="modal-footer">
												<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
												<a href="index.php?do=ayar/ayar_sosyal&islem=sil&id=<?=$sos['id']?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
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
				<div class="box"> 
					<div class="box-footer">
						<button type="submit" class="btn btn-primary btn-lg pull-right" name="sirakaydet"> <i class="fa fa-check"></i> Sıralamayı Kaydet </button>
					 </div> 
				</div>
			</form>
		</div>
		<div class="col-md-3">
			<?php include ("right-menu.php"); ?>
		</div>
	
	</div> 
	
</section>