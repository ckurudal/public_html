<?php 

	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
	
	uyeYasak(yetki());
	
	$islem = $_GET["islem"];
	$id = $_GET["id"];	

 ?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<i class="fa fa-edit"></i> İlan Formları
	<ol class="breadcrumb">
		<li><a href="index.php"><i class="fa fa-dashboard"></i> Anasayfa </a></li>
		<li> <a href="index.php?do=tumilanlar"> Tüm İlanlar </a> </li>
		<li class="active"> İlan Yönetimi </li>
	</ol>
</section> 
<?php if ($islem == "") { ?>
<form method="post" action="" enctype="multipart/form-data">
	<section class="content">
		asd
	</section>
</form>
<?php } ?>
<?php if ($islem == "sil") { ?>
	<section class="content">
		<?php 
			$id = $_GET[id];

			$sil = mysql_query("DELETE FROM emlak_form where id = '$id'");
			$silformkat = mysql_query("DELETE FROM emlak_form_kat where eformid = '$id'");

			if ($sil || $silformkat) {				
				onay("Başarılı bir şekilde silindi");
				go("index.php?do=islem&emlak=emlak_form",0.5);
			} else {
				hata();
			}

		?>
	</section>
<?php } ?>
<?php if ($islem == "ekle") { ?>
<form method="post" action="" enctype="multipart/form-data">
	<section class="content">
			<?php 
				$eform = mysql_fetch_assoc(mysql_query("SHOW TABLE STATUS LIKE 'emlak_form'"));					
				$efi = $eform['Auto_increment'];
			 ?>
			<?php
				if (isset($_POST["ekleFormKat"])) {
					$kat = $_POST['kat'];
					$deg = $_POST['deg'];
					$ad = $_POST['ad'];

					if (empty($ad) || empty($kat)) {
						hata('<strong>"Başlık"</strong> ve <strong>"Gösterilecek Kategoriler"</strong> boş olamaz!');
					} else {

						foreach ($kat as $k) {

							$ekle = mysql_query("INSERT INTO emlak_form_kat (kat, eformid) VALUES ('$k','$efi')");							
						}


						$adekle = mysql_query("INSERT INTO emlak_form (deg,ad) VALUES ('$deg','$ad')");						

						if ($ekle && $adekle) {
							onay("Emlak formları başarılı bir şekilde eklenmiştir.");
						}
					}
					
				}
			?>
	 	<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title"><i class="fa fa-check"></i> İlan Form Ekleme </h3>
			  <!-- tools box -->
			  <div class="pull-right box-tools">
				<a href="#" class="btn" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Daralt">
				  <i class="fa fa-minus"></i></a>
				<a href="#" class="btn" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Kapat">
				  <i class="fa fa-times"></i></a>
			  </div>
			  <!-- /. tools -->
			</div> 
			<!-- /.box-header -->
			<div class="box-body pad" style="">
				<div class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-2 control-label">Başlık:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="ad">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Seçiciler:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="deg">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Gösterilecek Kategoriler:</label>
					  <div class="col-sm-10">
		                	<select name="kat[]" style="min-height: 500px;" multiple class="form-control">
		                		<?php 

		                			$qkat=mysql_query("SELECT * FROM emlak_kategori WHERE kat_ustid = 0");
		                			while($kategori=mysql_fetch_assoc($qkat)) {
		                		?>
			                    <optgroup label="<?=$kategori["kat_adi"];?>">
									<option value="<?=$kategori["kat_id"];?>"> <?=$kategori["kat_adi"];?> </option>
									<?php 
										$katid = $kategori["kat_id"];
										$qust = mysql_query("SELECT * FROM emlak_kategori where kat_ustid = '$katid'");
										while($ustkat=mysql_fetch_array($qust)) {
									?>
									<option value="<?=$ustkat["kat_id"];?>"> -- <?=$ustkat["kat_adi"];?> </option>
									<?php } ?>
			                    </optgroup>
			                    <?php } ?>
		                  </select>
					  </div>
					</div> 
				</div>
			</div>
			<div class="box"> 
				<div class="box-footer">
					<button type="submit" name="ekleFormKat" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Kaydet </button>
				 </div> 
			</div>
		  </div>
	</section>
</form>
<?php } ?>
<?php if ($islem == "duzenle") { ?>
<form method="post" action="" enctype="multipart/form-data">
	<section class="content">
		  	<?php 
		  		if (isset($_POST["duzenleFormKat"])) {
		  			$kat = $_POST['kat'];
					$deg = $_POST['deg'];
					$ad = trim($_POST['ad']);
					$sira=$_POST['sira'];					

					$formd = mysql_query("UPDATE emlak_form SET ad = '$ad', deg = '$deg', sira = '$sira' where id = '$id'");
					$forms = mysql_query("DELETE FROM emlak_form_kat WHERE eformid = '$id'");
					foreach ($kat as $k) {
						$ekle = mysql_query("INSERT INTO emlak_form_kat (kat, eformid) VALUES ('$k','$id')");							
					}					

					if ($forms) {
						onay("Başarılı bir şekilde güncellendi.");
						go("index.php?do=islem&emlak=emlak_form", 0.5);
					} else {
						hata();
					}
					
		  		}
		  	?>

		  	<?php

		  		$e = mysql_fetch_array(mysql_query("SELECT * FROM emlak_form where id = '$id'"));		  		

		  		$emlakformkat = mysql_fetch_array(mysql_query("SELECT * FROM emlak_form_kat where eformid = '$id'"));
		  		$efk = $emlakformkat['kat'];
		  		$ayir = explode(",", $efk);
		  		$esitle = $ayir;

		  		$katsec = mysql_fetch_array(mysql_query("SELECT * FROM emlak_kategori where kat_id = '$efk'"));
		  		$formver = $katsec[kat_id];

			?>

	 	<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title"><i class="fa fa-check"></i> İlan Bilgileri </h3>
			  <!-- tools box -->
			  <div class="pull-right box-tools">
				<a href="#" class="btn" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Daralt">
				  <i class="fa fa-minus"></i></a>
				<a href="#" class="btn" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Kapat">
				  <i class="fa fa-times"></i></a>
			  </div>
			  <!-- /. tools -->
			</div> 
			<!-- /.box-header -->
			<div class="box-body pad" style="">
				<div class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-2 control-label">Başlık:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="ad" value="<?=$e[ad];?>">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Seçiciler:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="deg" value="<?=$e[deg];?>">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Gösterilecek Kategoriler:</label>
					  <div class="col-sm-10">
					  	<?php 

							$emlakformkat = mysql_fetch_array(mysql_query("SELECT * FROM emlak_form_kat where eformid = '$id'"));
							$al = $emlakformkat["kat"];
							$eformidver = $emlakformkat["eformid"];
							$ayire = explode(",", $al);
						?>
	                	<select name="kat[]" style="min-height: 500px;" multiple class="form-control">
	                		<?php
	                			$qkat=mysql_query("SELECT * FROM emlak_kategori WHERE kat_ustid = 0");
	                			while($kategori=mysql_fetch_assoc($qkat)) {										
	                		?> 
		                    <optgroup label="<?=$kategori["kat_adi"];?>">
								<option 
								<?php   
									$formkatver = mysql_query("select * from emlak_form_kat where eformid = '$id'");									
			                		while ($efk=mysql_fetch_array($formkatver)) {
			                			if ($efk[kat] == $kategori["kat_id"]) {				                				
			                				echo "selected ";
			                			}
			                		}
								?>
								value="<?=$kategori["kat_id"];?>"> <?=$kategori["kat_adi"];?> </option>									
								<?php 
									$katid = $kategori["kat_id"];
									$qust = mysql_query("SELECT * FROM emlak_kategori where kat_ustid = '$katid'");

									while($ustkat=mysql_fetch_array($qust)) {

								?>
								<option 
								<?php   
									$formkatver = mysql_query("select * from emlak_form_kat where eformid = '$id'");									
			                		while ($efk=mysql_fetch_array($formkatver)) {
			                			if ($efk[kat] == $ustkat["kat_id"]) {				                				
			                				echo "selected ";
			                			}
			                		}
								?>
								value="<?=$ustkat["kat_id"];?>"> -- <?=$ustkat[kat_adi];?>
								</option>
								<?php } ?>
		                    </optgroup>
		                    <?php } ?>
	                 	</select>	                 	
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Sıra:</label>
					  <div class="col-sm-10">
					  	<?php 
					  		$e=mysql_query("SELECT * FROM emlak_form WHERE id ='$id'");
					  		$ecek=mysql_fetch_assoc($e);
					  	?>
					  	<input type="text" name="sira" class="form-control" value="<?=$ecek[sira];?>">
					  </div>
					</div>
				</div>
			</div>
			<div class="box"> 
				<div class="box-footer">
					<button type="submit" name="duzenleFormKat" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Kaydet </button>
				 </div> 
			</div>
		  </div>
	</section>
</form>
<?php } ?>