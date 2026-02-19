<?php echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; uyeYasak(yetki()); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
	<i class="fa fa-list fa-2x pull-left"></i>
	Yeni Kategori Ekleme
	<p> <small> Kategori Yönetimi </small> </p> 
</section>
<form method="post" action="" enctype="multipart/form-data">
	<section class="content">
		
		<?php 

			if ($_POST) {
				
			$kat_adi = $_POST["kat_adi"];
			$seo = seo($_POST["kat_adi"]);
			$kat_ustid = $_POST["kat_ustid"];
			$ilansekli = $_POST["ilansekli"]; 

			$kat_kattip = $_POST["kat_kattip"];
			$kat_kattipid = $_POST["kat_kattipid"];
			$anasayfa_goster = $_POST["anasayfa_goster"];
			$anasayfa_baslik = $_POST["anasayfa_baslik"];
			$anasayfa_link = $_POST["anasayfa_link"];
				
			$query = $vt->query("INSERT INTO emlak_kategori
				(
					kat_adi,
					seo,
					kat_ustid,
					ilansekli,
					anasayfa_goster,
					anasayfa_baslik,
					anasayfa_link
				) values (
					'$kat_adi',
					'$seo', 
					'$kat_ustid',
					'$ilansekli',
					'$anasayfa_goster',			
					'$anasayfa_baslik',			
					'$anasayfa_link'			
				)
			");

			$kategori = $vt->query("SELECT * FROM emlak_kategori order by kat_id desc limit 1");
			$katver = $kategori->fetch();

			$katkatid = $katver["kat_id"];

			for ($i=0; $i < count($kat_kattipid); $i++) { 	

				$kattipekle = $vt->query("INSERT INTO emlak_ilantipi_katliste 

					(katid, ilantipid, ilantipdurum) values ('".$katkatid."', '".$kat_kattipid[$i]."', '".$kat_kattip[$i]."')"); 
			}


			
			if ($query) {				
				go("index.php?do=islem&emlak=kategori&islem=ok", 0);
			} else {
				hata();
				
			}
			
			} else {
				
			// ust ve ana kategorileri listeler

			function kategori($id = 0, $string = 0, $ustid) {
			  $query = $vt->query("SELECT * FROM emlak_kategori WHERE kat_ustid = '$id'");
			  if ($query->rowCount()) {
				while ($row = $query->fetch()) {
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
						<input type="text" class="form-control" name="kat_adi">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Üst Kategori Seçiniz:</label>
					  <div class="col-sm-10">
						<select class="form-control select2" value="<?php $row["kat_ustid"]; ?>" name="kat_ustid">
							<option value="0"> Ana Kategori </option> 	
							<?php kategori(0,0,$row["kat_ustid"]); ?>
						</select>
					  </div>
					</div>
					<div class="form-group" style="padding:15px;">
					  <label class="col-sm-2 control-label">İlan Şekli Seçiniz:</label>
					  <div class="col-sm-10">

					  	<?php 
					  		$ilansekli=$vt->query("SELECT * FROM emlak_ilansekli where id");
					  	?> 

						<?php while ($isekli=$ilansekli->fetch()) { ?>
							<label for="ilansekli">
							  <input type="radio" name="ilansekli" value="<?=$isekli["id"];?>" class="minimal">
							   <?=$isekli[baslik];?> 
							</label> <br>
						<?php } ?>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Title:</label>
					  <div class="col-sm-10">
						<input type="text" name="kat_seo_title" class="form-control" value="">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Google Açıklama:</label>
					  <div class="col-sm-10">
						<textarea name="kat_desc" value="" class="form-control" rows="5" cols="80"></textarea>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Anahtar Kelimeler (Etiket):</label>
					  <div class="col-sm-10">
						<input type="text" name="kat_keyw" value="" class="form-control">
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Sıra No:</label>
					  <div class="col-sm-10">
						<input type="text" name="sira_no" value="" class="form-control">
					  </div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Durum:</label>
						<div class="col-md-10">
							<label for="ozellikler">
							  <input type="radio" name="kat_durum" value="1" class="minimal">
							  Aktif
							</label>
							<label for="ozellikler">
							  <input type="radio" name="kat_durum" value="0" class="minimal">
							  Pasif
							</label>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Anasayfada Göster:</label>
						<div class="col-md-10">
							<label for="anasayfa_goster">
							  <input type="radio" name="anasayfa_goster" value="1" class="minimal">
								Göster
							</label>
							<label for="ozellikler">
							  <input type="radio" name="anasayfa_goster" value="0" class="minimal">
								Gizle
							</label>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Anasayfada Başlık:</label>
						<div class="col-md-3 hidden">
							<input type="text" name="anasayfa_baslik" placeholder="Anasayfa Başlık" value="" class="form-control">							
						</div>
						<div class="col-md-3">
							<input type="text" name="anasayfa_link" placeholder="Anasayfa Link" value="" class="form-control">							
						</div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">İlan Kategori Tipi:</label>
						<div class="col-md-10">
							<?php
								// Emlak Tipi
								$emlaktip = $vt->query("select * from emlak_ilantipi where id");							
								while ($tipver = $emlaktip->fetch()) {
							 ?>
							<?php if ($tipver["durum"]=="0") { ?>
							<label for="kat_kattip">
							  <input type="checkbox" name="kat_kattipid[]" value="<?=$tipver["id"];?>" class="minimal">							  
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
		<?php } ?>
	</section>
</form>