<?php  
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
	
	uyeYasak(yetki());
	
	$id =  $_GET["id"];
	$islem =  $_GET["islem"];
	$hareket =  $_GET["hareket"];
	$durum =  $_GET["durum"];


?>
<section class="content-header">
	<i class="fa fa-edit"></i> Sayfa / Modül Ayarları 
  <ol class="breadcrumb">
	<li><a href="index.php"><i class="fa fa-dashboard"></i> Anahaber </a></li>
	<li> <a href="index.php?do=tumilanlar"> Tüm İlanlar </a> </li>
	<li class="active"> İlan Yönetimi </li>
  </ol>
</section> 
<?php 
	if (isset($_POST["ekle"]) || isset($_POST["kaydet"]) || isset($_POST["sirakaydet"])) {
		$ustid	= $_POST['ustid'];
		$baslik	= $_POST['baslik'];
		$seo	= $_POST['seo'];
		$harici	= $_POST['harici'];
		$url	= $_POST['url'];
		$icon	= $_POST['icon'];
		$sira = $_POST["sira"]; 
		$siraid = $_POST["siraid"];

		if (isset($_POST["ekle"])) {

			$ekle = mysql_query("INSERT INTO altmenu (ustid, baslik, seo, url, harici, icon) values ('$ustid','$baslik','$seo','$url','$harici','$icon')");

			if ($ekle == true) {
				go("index.php?do=islem&icerik=altmenu&islem=liste&hareket=onay",0);
			} else {
				echo mysql_error();
			}
		}

		if (isset($_POST["kaydet"])) {
			$kaydet = mysql_query("UPDATE altmenu SET ustid = '$ustid', baslik = '$baslik', seo = '$seo', harici = '$harici', url = '$url', icon = '$icon' where id = '$id'");

			if ($kaydet == true) {
				go("index.php?do=islem&icerik=altmenu&islem=liste&hareket=onay",0);
			} else {
				echo mysql_error();
			}
		}

		if (isset($_POST["sirakaydet"])) {

			for ($i=0; $i < count($siraid) ; $i++) { 
				
				$sirakaydet = mysql_query("UPDATE altmenu SET sira = '$sira[$i]' where id = '$siraid[$i]'");
 				 
				if ($sirakaydet == true) {
					go("index.php?do=islem&icerik=altmenu&islem=liste&hareket=onay",0);
				}

 			} 
			
		}
	}	
?>
<?php if ($islem == "ekle") { ?>
<form action="" method="post" enctype="multipart/form-data">
	<section class="content">  
		<div class="box"> 
			<!-- /.box-header -->
			<div class="box-body" style="">
				<div class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-2 control-label">Üst Menü Seç:</label>
					  <div class="col-sm-10">  
						<?php 
							// ust ve ana kategorileri listeler

							function altmenu($id = 0, $string = 0, $ustid) {
							  $query = mysql_query("SELECT * FROM altmenu WHERE ustid = '$id'");
							  if (mysql_affected_rows()) {
								while ($row = mysql_fetch_array($query)) {
								  echo '<option';
								  if ($row["id"] == $ustid) {
									echo ' selected ';
								  }
								  echo ' value="'.$row["id"].'"> '.str_repeat("-", $string).$row["baslik"].' </option>';
								  altmenu($row["id"], $string + 2, $ustid);
								}
							  } else {
								return false;
							  }
							}
						?> 
						<select class="form-control selec t2" name="ustid">
							<option value="0">Üst Menü</option>
							<?php altmenu(); ?> 
						</select>
					  </div> 
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Menü Adı:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="baslik" value="">
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Bağlantı Sayfası:</label>
					  <div class="col-sm-10"> 
						<select class="form-control selec t2" name="seo">
							<option value="">Seçiniz</option>
							<optgroup label="Sayfalar">
								<?php
									$sayfalar = mysql_query("SELECT * FROM sayfa where id");
									while($sayfa = mysql_fetch_array($sayfalar)) {
								?>
								<option value="/sayfa/<?=$sayfa["seo"];?>/"><?=$sayfa["baslik"];?></option>
								<?php } ?>
							</optgroup>
							<?php
								$tipliste = mysql_query("SELECT * FROM emlak_ilantipi where id");
								while($tip = mysql_fetch_array($tipliste)) {
							?>
								<optgroup label="<?=$tip["ad"];?>">
									<?php
										$kattipliste = mysql_query("SELECT * FROM emlak_ilantipi_katliste where ilantipid = '".$tip["id"]."'");
										while($kattip = mysql_fetch_array($kattipliste)) {
									?>
										<?php
											$kategori = mysql_query("SELECT * FROM emlak_kategori where kat_id = '".$kattip["katid"]."'");
											while($katad = mysql_fetch_array($kategori)) {
										?>
											<option value="/kategori/<?=$tip["seo"];?>/<?=$katad["seo"];?>/"><?=$tip["ad"];?> -> <?=$katad["kat_adi"];?> </option>
										<?php } ?>									
									<?php } ?>
								</optgroup>
							<?php } ?>
						</select>
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Bağlantı Adresi (Link Ekle):</label>
					  Eğer link eklerseniz <strong>"Bağlantı Sayfası"</strong> pasif olacaktır!
					  <div class="col-sm-3"> 
						<input type="text" class="form-control" name="url">
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
					  <label class="col-sm-2 control-label">Menü Resmi / İkon:</label>
					  <div class="col-sm-2">
					  	<input type="text" class="form-control" name="icon" placeholder="fa fa-code">
					  </div>					  
					  <a href="#" data-toggle="modal" data-target="#ikonlist" title="İkon Listesi" style="text-align: left; padding: 8.88px;" class="btn btn-default">
					  	<i class="fa fa-external-link"></i>
					  </a>
					<div class="modal modal-default text-center fade" id="ikonlist" style="display: none;">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header alert alert-info">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">×</span></button>
							<h4 class="modal-title"><i class="fa fa-check-circle"></i> İkon Seçiniz</h4>
						  </div>
						  <div class="modal-body">
							<h5 class="ale rt aler t-info"><i class="fa fa-bullhorn"></i> Eklemek istediğiniz ikon kodunu kopyalayınız.</h5>										
							<div class="thumbnail">
								İNCLUDE
							</div>
						  </div>
						  <div class="modal-footer">
							<a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Kapat </a>							
						  </div>
						</div> 
					  </div> 
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
		$altmenuler = mysql_query("SELECT * FROM altmenu where id = '$id'");
		$u = mysql_fetch_array($altmenuler);
	?>
	<section class="content">  
		<div class="box"> 
			<!-- /.box-header -->
			<div class="box-body" style="">
				<div class="alert alert-warning">İçerik</div>
				<div class="form-horizontal"> 
					<div class="form-group">
					  <label for="hizliarama" class="col-sm-2 control-label">Hızlı Arama:</label>
					  <div class="col-sm-10"> 
						  	<label for="odasayisi">
							  <input type="radio" name="odasayisi" checked value="0" class="minimal">
							  Göster
							</label>
							<label for="odasayisi">
							  <input type="radio" name="odasayisi" value="1" class="minimal">
							  Gizle
							</label>
					  </div>
					</div>  
					<div class="form-group">
					  <label for="hizliarama" class="col-sm-2 control-label">Kategoriler:</label>
					  <div class="col-sm-10"> 
						  	<label for="odasayisi">
							  <input type="radio" name="odasayisi" checked value="0" class="minimal">
							  Göster
							</label>
							<label for="odasayisi">
							  <input type="radio" name="odasayisi" value="1" class="minimal">
							  Gizle
							</label>
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
	<div class="box-header">
         <div class="pull-right"> 
            <a href="index.php?do=islem&icerik=altmenu&islem=ekle" class="btn btn-lg bt-xs btn-success">
                <i class="fa fa-plus"></i> Yeni Ekle
            </a>   
         </div> 
	</div> 
	<form action="" method="post">
		<div class="box"> 
			<div class="box-body"> 
				<table class="table table-striped table-bordered table-hover table-checkable">
				    <thead>
				        <tr>                         
				            <td style="width:0.1%;"> Sayfa Adı </td>   			            
				            <td style="width:0.1%;"> Aktif Modüller </td>   			            
				            <td style="width:0.1%;"> Görünüm </td>   			            
				            <td style="width:0.1%;"> İşlemler </td>   			            
				        </tr>
				    </thead>
				    <tbody>  
			    			<tr> 
			    				<th>Anasayfa</th>
			    				<th>Kategori, Döviz Kuru, Hızlı Arama, Kredi Hesaplama</th>
			    				<th>
			    					<span class="btn btn-default btn-xs">SOL</span>
			    					<span class="btn btn-default btn-xs">ORTA</span>
			    					<span class="btn btn-default btn-xs">SAĞ</span>
			    				</th>
			    				<th><a href="#" class="btn btn-default btn-xs">Düzenle</a></th>
			    			</tr> 
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
</section>
<?php } ?> 