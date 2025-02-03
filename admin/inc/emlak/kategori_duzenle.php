<?php 

	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
	uyeYasak(yetki());
	$id = $_GET["id"];
?>

<!-- Content Header (Page header) -->
<section class="content-header">
	<i class="fa fa-list fa-2x pull-left"></i>
	Kategori Düzenleme
	<p> <small> Kategori Yönetimi </small> </p> 
</section>
<form method="post" action="">
	<section class="content">
		<?php

		$id = $_GET["id"];

			if ($id = $_GET["id"]) {

			if ($_POST) {
				
				$kat_adi 			= $_POST["kat_adi"];
				$seo 				= seo($_POST["kat_adi"]);
				$kat_seo_title 		= $_POST["kat_seo_title"];
				$kat_desc 			= $_POST["kat_desc"];
				$kat_keyw 			= $_POST["kat_keyw"];
				$kat_durum 			= $_POST["kat_durum"];
				$sira_no 			= $_POST["sira_no"];
				$kat_ustid 			= $_POST["kat_ustid"];
				$ilansekli 			= $_POST["ilansekli"]; 
				$anasayfa_goster 	= $_POST["anasayfa_goster"]; 
				$anasayfa_baslik	= $_POST["anasayfa_baslik"];
				$anasayfa_link 		= $_POST["anasayfa_link"];

				$kat_kattip = $_POST["kat_kattip"];
				$kat_kattipid = $_POST["kat_kattipid"];

				$guncelle = mysql_query("UPDATE emlak_kategori SET kat_adi = '$kat_adi', seo = '$seo', kat_seo_title = '$kat_seo_title', kat_desc = '$kat_desc', kat_keyw = '$kat_keyw', kat_durum = '$kat_durum', sira_no = '$sira_no', kat_ustid = '$kat_ustid', ilansekli = '$ilansekli', anasayfa_goster = '$anasayfa_goster', anasayfa_baslik = '$anasayfa_baslik', anasayfa_link = '$anasayfa_link' WHERE kat_id = '$id' ");

				$ilantipsil = mysql_query("DELETE FROM emlak_ilantipi_katliste where katid = '$id'");

				for ($i=0; $i < count($kat_kattipid); $i++) { 	

					$kattipekle = mysql_query("INSERT INTO emlak_ilantipi_katliste 

						(katid, ilantipid, ilantipdurum) values ('".$id."', '".$kat_kattipid[$i]."', '".$kat_kattip[$i]."')"); 
				}


				if ($guncelle) {					
					go("index.php?do=islem&emlak=kategori&islem=ok", 0);
				} else {					
					go("index.php?do=islem&emlak=kategori&islem=hata", 0);
				}

			} else {

			$query = mysql_query("SELECT * FROM emlak_kategori WHERE kat_id = '$id'");
			if (mysql_affected_rows()) {
			$row = mysql_fetch_array($query);

				// ust ve ana kategorileri listeler

				function kategori($id = 0, $string = 0, $ustid) {
				  $query = mysql_query("SELECT * FROM emlak_kategori WHERE kat_ustid = '$id'");
				  if (mysql_affected_rows()) {
					while ($row = mysql_fetch_array($query)) {
					  echo '<option';
					  if ($row["kat_id"] == $ustid) {
						echo ' selected ';
					  }
					  echo ' value="'.$row["kat_id"].'"> '.str_repeat("-", $string).$row["kat_adi"].' </option>';
					  kategori($row["kat_id"], $string + 2, $ustid);
					}
				  } else {
					return false;
				  }
				}
			  }
			}

		  } else {

		  }

		?>
		<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title"><i class="fa fa-check"></i> Kategori Bilgileri </h3>
			  <!-- tools box -->
			  <div class="pull-right box-tools">
				<a href="#"class="btn btn-  btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Daralt">
				  <i class="fa fa-minus"></i></a>
				<a type="button" class="btn btn-  btn-sm" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Kapat">
				  <i class="fa fa-times"></i></a>
			  </div>
			  <!-- /. tools -->
			</div>
			<!-- /.box-header -->
			<div class="box-body pad">
				<div class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-2 control-label">Başlık:</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" name="kat_adi" value="<?php echo $row["kat_adi"]; ?>">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Üst Kategori Seçiniz:</label>
					  <div class="col-sm-10">
						<select class="form-control select2" name="kat_ustid">
							<option value="0"> Ana Kategori </option>
 							<?php
								
								kategori(0,0,$row["kat_ustid"]);

							?>
						</select>
					  </div>
					</div>
					<div class="form-group" style="padding:15px;">
					  <label class="col-sm-2 control-label">İlan Şekli Seçiniz:</label>
					  <div class="col-sm-10">

					  	<?php 
					  		$ilansekli=mysql_query("SELECT * FROM emlak_ilansekli where id");
					  	?> 

						<?php while ($isekli=mysql_fetch_array($ilansekli)) { ?>
							<?php
								if ($isekli[id]==$row[ilansekli]) { ?>
										
								<label for="ilansekli" >
								  <input type="radio" name="ilansekli" checked value="<?=$isekli["id"];?>" class="minimal">
								   <?=$isekli[baslik];?> 
								</label> <br>

								<?php } else { ?>
									
								<label for="ilansekli" >
								  <input type="radio" name="ilansekli" value="<?=$isekli["id"];?>" class="minimal">
								   <?=$isekli[baslik];?> 
								</label> <br>

								<?php } ?>
						<?php } ?>
					  </div> 
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Title:</label>
					  <div class="col-sm-10">
						<input type="text" name="kat_seo_title" class="form-control" value="<?php echo $row["kat_seo_title"]; ?>">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Google Açıklama:</label>
					  <div class="col-sm-10">
						<textarea name="kat_desc" value="<?php echo $row["kat_desc"]; ?>" class="form-control" rows="5" cols="80"><?php echo $row["kat_desc"]; ?></textarea>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Anahtar Kelimeler (Etiket):</label>
					  <div class="col-sm-10">
						<input type="text" name="kat_keyw" value="<?php echo $row["kat_keyw"]; ?>" class="form-control">
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Sıra No:</label>
					  <div class="col-sm-10">
						<input type="text" name="sira_no" value="<?php echo $row["sira_no"]; ?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Durum:</label>
						<div class="col-md-10">
							<label for="ozellikler">
							  <input type="radio" <?php if ($row["kat_durum"] == 1) { ?> checked <?php } ?>name="kat_durum" value="1" class="minimal">
							  Aktif
							</label>
							<label for="ozellikler">
							  <input type="radio" <?php if ($row["kat_durum"] == 0) { ?> checked <?php } ?> name="kat_durum" value="0" class="minimal">
							  Pasif
							</label>
						</div>
					  </div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Anasayfada Göster:</label>
						<div class="col-md-10">
							<label for="anasayfa_goster">
							  <input type="radio" <?php if ($row["anasayfa_goster"] == 1) { ?> checked <?php } ?>name="anasayfa_goster" value="1" class="minimal">
							  Göster
							</label>
							<label for="anasayfa_goster">
							  <input type="radio" <?php if ($row["anasayfa_goster"] == 0) { ?> checked <?php } ?> name="anasayfa_goster" value="0" class="minimal">
							  Gizle
							</label>
						</div>
					  </div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Anasayfada Link:</label>
						<div class="col-md-3 hidden">
							<input type="text" name="anasayfa_baslik" placeholder="Anasayfa Başlık" value="<?php echo $row["anasayfa_baslik"]; ?>" class="form-control">							
						</div>
						<div class="col-md-3">
							<input type="text" name="anasayfa_link" placeholder="Anasayfa Link" value="<?php echo $row["anasayfa_link"]; ?>" class="form-control">							
						</div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">İlan Kategori Tipi:</label>
						<div class="col-md-10">
							<?php
								// Emlak Tipi
								$emlaktip = mysql_query("select * from emlak_ilantipi where id");							
								while ($tipver = mysql_fetch_array($emlaktip)) {

							 ?>
							<?php if ($tipver["durum"]=="0") { ?>
							<label for="kat_kattip">

							<?php
								$kattipver = mysql_query("SELECT * FROM emlak_ilantipi_katliste where ilantipid = '".$tipver["id"]."' && katid = '$id'");
								$kver = mysql_fetch_array($kattipver);
							?>
						  		<input type="checkbox" name="kat_kattipid[]" <?php if ($kver) {echo "checked";} ?> value="<?=$tipver["id"];?>" class="minimal">
							
							 	<input type="text" name="kat_kattip[]" value="1" class="minimal hidden">		 					  
								<?=$tipver["ad"];?>
							</label>
							<?php } } ?>
						</div>
					</div>
				</div> 
				</div>
			<div class="box-footer">
				<button type="submit" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Kaydet </button>
			 </div>
		  </div>
	</section>
</form>
