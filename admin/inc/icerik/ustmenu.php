 <?php

	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
	
	uyeYasak(yetki());
	
	$id =  $_GET["id"];
	$islem =  $_GET["islem"];
	$hareket =  $_GET["hareket"];
	$durum =  $_GET["durum"];

?>

<section class="content-header">  

	<i class="fa fa-th fa-2x pull-left"></i>

	Üst Menü Yönetimi

	<p> <small> Menü Yönetimi </small> </p>

</section>
<?php
	if (isset($_POST["ekle"]) || isset($_POST["kaydet"]) || isset($_POST["sirakaydet"])) {
		$ustid	= $_POST['ustid'];
		$baslik	= $_POST['baslik'];
        $url	= $_POST['url'];
        if (!empty($url)) {
            $seo	= "";
            $bolge	= "";
        } else {
            $seo	= $_POST["seo"];
            $bolge	= $_POST["bolge"];
        }
		$harici	= $_POST['harici'];
		$icon	= $_POST['icon'];
		$sira = $_POST["sira"];
		$siraid = $_POST["siraid"];
		$tekaltmenu = $_POST["tekaltmenu"];

		if (isset($_POST["ekle"])) {

			$ekle = $vt->query("INSERT INTO ustmenu (ustid, baslik, seo, url, harici, icon, tekaltmenu, bolge) values ('$ustid','$baslik','$seo','$url','$harici','$icon','$tekaltmenu','$bolge')");

			if ($ekle == true) {
				go("index.php?do=islem&icerik=ustmenu&islem=liste&hareket=onay",0);
			}
		}

		if (isset($_POST["kaydet"])) {
			$kaydet = $vt->query("UPDATE ustmenu SET ustid = '$ustid', baslik = '$baslik', seo = '$seo', harici = '$harici', url = '$url', icon = '$icon', tekaltmenu = '$tekaltmenu', bolge = '$bolge' where id = '$id'");

			if ($kaydet == true) {
				go("index.php?do=islem&icerik=ustmenu&islem=liste&hareket=onay",0);
			}
		}

		if (isset($_POST["sirakaydet"])) {

			for ($i=0; $i < count($siraid) ; $i++) {

				$sirakaydet = $vt->query("UPDATE ustmenu SET sira = '$sira[$i]' where id = '$siraid[$i]'");

				if ($sirakaydet == true) {
					go("index.php?do=islem&icerik=ustmenu&islem=liste&hareket=onay",0);
				}

 			}

		}
	}
?>
<?php if ($islem == "ekle") { ?>
<form action="" method="post" enctype="multipart/form-data">
	<section class="content">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"> <i class="fa fa-plus"></i> Üst Menü Ekleme </h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body" style="">
				<div class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-2 control-label">Menü Adı:</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" name="baslik" value="">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Üst Menü Seç:</label>
					  <div class="col-sm-10">
						<?php

							// ust ve ana kategorileri listeler

							function ustmenu($id = 0, $string = 0, $ustid) {
							  $query = $vt->query("SELECT * FROM ustmenu WHERE ustid = '$id'");
							  if ($query->rowCount()) {
								while ($row = $query->fetch()) {
								  if ($row["durum"] == 0) {
								  	echo '<option';
									  if ($row["id"] == $ustid) {
										echo ' selected ';
									  }
									  echo ' value="'.$row["id"].'"> '.str_repeat("-", $string).$row["baslik"].' </option>';
									  ustmenu($row["id"], $string + 2, $ustid);
								  }
								}
							  } else {
								return false;
							  }
							}

						?>
						<select class="form-control selec t2" name="ustid">
							<option value="0">Üst Menü</option>
							<?php ustmenu(); ?>
						</select>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Bağlantı Sayfası:</label>
					  <div class="col-sm-10">
						<select class="form-control select2" name="seo">
							<option value="">Seçiniz</option>
							<optgroup label="İçerikler">
								<?php
									$sayfalar = $vt->query("SELECT * FROM sayfa where id");
									while($sayfa = $sayfalar->fetch()) {
								?>
									<?php
										if ($sayfa["durum"] == 0) {
									?>
									<option value="<?=$sayfa["seo"];?>-sayfa-<?=$sayfa["id"];?>/"><?=$sayfa["baslik"];?></option>
									<?php } ?>
								<?php } ?>
							</optgroup>
							<optgroup label="Sabit Sayfalar">
								<option value="haberler/">Haberler</option>
								<option value="blog/">Blog</option>
								<option value="danismanlar/">Danışmanlar</option>
								<option value="ofisler/">Ofisler</option>
								<option value="iletisim/">İletişim</option>
								<option value="emlak-talep-formu/">Emlak Talep Formu</option>
							</optgroup>
                            <optgroup label="İlan Tipi">
                                <?php
                                $emlakilantipi = $vt->query("SELECT * FROM emlak_ilantipi where id and durum = 0",PDO::FETCH_OBJ);
                                foreach ($emlakilantipi as $tip) {
                                ?>
                                <option value="kategori/<?php echo seo($tip->ad); ?>"><?php echo $tip->ad; ?></option>
                                <?php } ?>
                            </optgroup>
							<optgroup label="İlan Şekli [TÜM İLANLAR]">
								<?php
									$ilansekli = $vt->query("SELECT * FROM emlak_ilansekli where id");
									while($isekli = $ilansekli->fetch()) {
								?>
									<?php
										if ($isekli["durum"] == 0) {
									?>
									<option value="kategori/<?=seo($isekli["baslik"]);?>-ilanlari">TÜM İLANLAR - <?=$isekli["baslik"];?></option>
									<?php } ?>
								<?php } ?>
							</optgroup>
							<?php
								$tipliste = $vt->query("SELECT * FROM emlak_ilantipi where id");
								while($tip = $tipliste->fetch()) {
							?>
								<?php
									if ($tip["durum"] == 0) {
								?>
								<optgroup label="<?=$tip["ad"];?>">
									<?php
										$kategoriustadi = $vt->query("SELECT * FROM emlak_kategori where kat_ustid = '0'");
										while($katustadi = $kategoriustadi->fetch()) {
											$ilansekli = $vt->query("SELECT * FROM emlak_ilansekli where id = '".$katustadi["ilansekli"]."'");
											while($isekli = $ilansekli->fetch()) {
									?>
										<option value="kategori/<?=$tip["seo"];?>/<?=$isekli["seo"];?>-ilanlari">TÜM - <?=$tip["ad"];?> -> <?=$katustadi["kat_adi"];?> İlanları</option>
										<?php } ?>
									<?php } ?>
									<?php
										$kattipliste = $vt->query("SELECT * FROM emlak_ilantipi_katliste where ilantipid = '".$tip["id"]."'");
										while($kattip = $kattipliste->fetch()) {
									?>
										<?php
											$kategori = $vt->query("SELECT * FROM emlak_kategori where kat_id = '".$kattip["katid"]."'");
											while($katad = $kategori->fetch()) {

										?>
											<?php
												if ($katad["kat_durum"] == 1) {
											?>
											<option value="kategori/<?=$tip["seo"];?>/<?=$katad["seo"];?>"><?=$tip["ad"];?> -> <?=$katad["kat_adi"];?> </option>
											<?php } ?>
										<?php } ?>
									<?php } ?>
								</optgroup>
								<?php } ?>
							<?php } ?>
						</select>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Bağlantı Adresi (Link Ekle):</label>
					  <div class="col-sm-2">
						<input type="text" class="form-control" name="url">
					  </div>
                        <label class="col-sm-1 control-label hidden">Bölge Seçimi:</label>
                        <div class="col-sm-2 hidden">
                            <select name="bolge" class="form-control select2">
                                <option value="">Şehir Seçiniz</option>
                                <?php
                                $sehirler = $vt->query("SELECT * FROM sehir ORDER BY adi ASC", PDO::FETCH_OBJ);
                                foreach ($sehirler as $sehir) {
                                    ?>
                                    <option value="?bolge=<?php echo seo($sehir->adi); ?>"><?php echo $sehir->adi; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <label class="hidden">Eğer link eklerseniz <strong>"Bağlantı Sayfası"</strong> Bölge eklerseniz <strong>Bağlantı Adresi</strong> pasif olacaktır!</label>
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
					  <label class="col-sm-2 control-label">Mega Menü</label>
					  <div class="col-sm-10">
						<label for="anavitrin">
						  	<div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
						  		<input type="checkbox" name="tekaltmenu" value="1" class="minimal" style="position: absolute; opacity: 0;">
						  	</div>
							Mega menü olarak gösterme (Eğer ikinci alt kategori yoksa bunu aktif ediniz)
						</label>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Menü Resmi / İkon:</label>
					  <div class="col-sm-2">
					  	<input type="text" class="form-control" name="icon" placeholder="fa fa-code">
					  </div>
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
		$ustmenuler = $vt->query("SELECT * FROM ustmenu where id = '$id'");
		$u = $ustmenuler->fetch();
	?>
	<section class="content">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"> <i class="fa fa-th"></i> Üst Menü Düzenle </h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body" style="">
				<div class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-2 control-label">Menü Adı:</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" name="baslik" value="<?=$u["baslik"];?>">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Üst Menü Seç:</label>
					  <div class="col-sm-10">
						<?php
							// ust ve ana kategorileri listeler
							function ustmenu($id = 0, $string = 0, $ustid) {
							  $query = $vt->query("SELECT * FROM ustmenu WHERE ustid = '$id'");
							  if ($query->rowCount()) {
								while ($row = $query->fetch()) {
								  if ($row["durum"] == 0) {
								  	echo '<option';
									  if ($row["id"] == $ustid) {
										echo ' selected ';
									  }
									  echo ' value="'.$row["id"].'"> '.str_repeat("-", $string).$row["baslik"].' </option>';
									  ustmenu($row["id"], $string + 2, $ustid);
								  }
								}
							  } else {
								return false;
							  }
							}
						?>
						<select class="form-control select2" name="ustid">
							<?php
								if ($u["ustid"] == 0) {
							?>
							<option value="0">Üst Menü</option>
							<?php } else { ?>
								<?php

									$ustidver = $vt->query("SELECT * FROM ustmenu where id = '".$u["ustid"]."'");
									$uv = $ustidver->fetch();

								?>
								<option value="<?=$uv["id"];?>"><?=$uv["baslik"];?></option>
							<?php } ?>
							<?php ustmenu(0,0,0); ?>
						</select>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Bağlantı Sayfası:</label>
					  <div class="col-sm-10">
						<select class="form-control select2" name="seo">

							<?php
								if ($u["url"] != "" || $u["seo"] == "") {
							?>

							<option value="">Seçiniz</option>
							<?php } else { ?>
                                <option value="<?=$u["seo"];?>"><?=$u["seo"];?></option>
                                <option value="">Seçiniz</option>
                            <?php } ?>

							<optgroup label="Sayfalar">
								<?php
									$sayfalar = $vt->query("SELECT * FROM sayfa where id");
									while($sayfa = $sayfalar->fetch()) {
								?>
									<?php
										if ($sayfa["durum"] == 0) {
									?>
									<option value="<?=$sayfa["seo"];?>-sayfa-<?=$sayfa["id"];?>/"><?=$sayfa["baslik"];?></option>
									<?php } ?>
								<?php } ?>
							</optgroup>

							<optgroup label="Sabit Sayfalar">
								<option value="haberler/">Haberler</option>
								<option value="blog/">Blog</option>
								<option value="danismanlar/">Danışmanlar</option>
								<option value="ofisler/">Ofisler</option>
								<option value="iletisim/">İletişim</option>
								<option value="emlak-talep-formu/">Emlak Talep Formu</option>
							</optgroup>

							<optgroup label="İlan Tipleri">
								<?php
									$ilantipi2=$vt->query("SELECT * FROM emlak_ilantipi WHERE id and durum=0 ORDER BY id ASC");
									foreach ($ilantipi2 as $i) {
								?>
								<option value="kategori/<?=$i["seo"];?>"><?=$i["ad"];?></option>
								<?php } ?>
							</optgroup>

							<optgroup label="İlan Şekli [TÜM İLANLAR]">
								<?php
									$ilansekli = $vt->query("SELECT * FROM emlak_ilansekli where id and durum = 0");
									while($isekli = $ilansekli->fetch()) {
								?>
									<?php
										if ($isekli["durum"] == 0) {
									?>
									<option value="kategori/<?=$isekli["seo"];?>-ilanlari">TÜM İLANLAR - <?=$isekli["baslik"];?></option>
									<?php } ?>
								<?php } ?>
							</optgroup>

							<?php
								$tipliste = $vt->query("SELECT * FROM emlak_ilantipi where id and durum = 0");
								while($tip = $tipliste->fetch()) {
							?>

							<optgroup label="<?=$tip["ad"];?>">
								<?php
									$kategoriustadi = $vt->query("SELECT * FROM emlak_kategori where kat_ustid = '0'");
									while($katustadi = $kategoriustadi->fetch()) {
										$ilansekli = $vt->query("SELECT * FROM emlak_ilansekli where id = '".$katustadi["ilansekli"]."'");
										while($isekli = $ilansekli->fetch()) {
								?>
									<option value="kategori/<?=$tip["seo"];?>/<?=$isekli["seo"];?>-ilanlari">TÜM - <?=$tip["ad"];?> -> <?=$isekli["baslik"];?> İlanları</option>
									<?php } ?>
								<?php } ?>
								<?php
									$kattipliste = $vt->query("SELECT * FROM emlak_ilantipi_katliste where ilantipid = '".$tip["id"]."'");
									while($kattip = $kattipliste->fetch()) {
								?>
									<?php
										$kategori = $vt->query("SELECT * FROM emlak_kategori where kat_id = '".$kattip["katid"]."'");
										while($katad = $kategori->fetch()) {

									?>
										<?php
											if ($katad["kat_durum"] == 1) {
										?>
										<option value="kategori/<?=$tip["seo"];?>/<?=$katad["seo"];?>"><?=$tip["ad"];?> -> <?=$katad["kat_adi"];?> </option>
										<?php } ?>
									<?php } ?>
								<?php } ?>
							</optgroup>

							<?php } ?>

						</select>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Bağlantı Adresi (Link Ekle):</label>
					  <div class="col-sm-2">
						<input type="text" class="form-control" name="url" value="<?=$u["url"];?>">
					  </div>
                    <label class="col-sm-1 control-label hidden">Bölge Seçimi:</label>
                    <div class="col-sm-2 hidden">
                        <select name="bolge" class="form-control select2">
                            <?php if (!empty($u["bolge"])) { ?>
                                <option selected><?php echo $u["bolge"]; ?></option>
                                <option value="">Şehir Seçiniz</option>
                            <?php } else { ?>
                                <option value="">Şehir Seçiniz</option>
                            <?php } ?>
                            <?php
                            $sehirler = $vt->query("SELECT * FROM sehir ORDER BY adi ASC", PDO::FETCH_OBJ);
                            foreach ($sehirler as $sehir) {
                                ?>
                                <option value="?bolge=<?php echo seo($sehir->adi); ?>"><?php echo $sehir->adi; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <label class="hidden">Eğer link eklerseniz <strong>"Bağlantı Sayfası"</strong> Bölge eklerseniz <strong>Bağlantı Adresi</strong> pasif olacaktır!</label>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Harici Bağlantı</label>
					  <div class="col-sm-10">
						<label for="anavitrin">
						  	<div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
						  		<?php
						  			if ($u["harici"] == 1) {
						  		?>
						  		<input type="checkbox" name="harici" checked value="1" class="minimal" style="position: absolute; opacity: 0;">
						  		<?php } else { ?>
						  		<input type="checkbox" name="harici" value="1" class="minimal" style="position: absolute; opacity: 0;">
						  		<?php } ?>
						  	</div>
							Tıklandığında yeni sayfada açılsın.
						</label>
					  </div>
					</div>

					<div class="form-group">
					  <label class="col-sm-2 control-label">Mega Menü</label>
					  <div class="col-sm-10">
						<label for="anavitrin">
						  	<div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
						  		<?php
						  			if ($u["tekaltmenu"] == 1) {
						  		?>
						  		<input type="checkbox" name="tekaltmenu" checked value="1" class="minimal" style="position: absolute; opacity: 0;">
						  		<?php } else { ?>
						  		<input type="checkbox" name="tekaltmenu" value="1" class="minimal" style="position: absolute; opacity: 0;">
						  		<?php } ?>

						  	</div>
							Mega menü olarak gösterme (Eğer üçüncü alt kategori yoksa bunu aktif ediniz)
						</label>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Menü Resmi / İkon: </label>
					  <div class="col-sm-2">
					  	<input type="text" class="form-control" name="icon" placeholder="fa fa-text" value="<?=$u["icon"];?>">
					  </div>
					  	<?php
					  		if ($u["icon"] != "") {
					  	?>
						<span class="btn btn-d efault"> <i class="<?=$u["icon"];?> fa-lg"></i> </span>
					  	<?php } ?>
					  	<!--
					  <a href="#" data-toggle="modal" data-target="#ikonlist" title="İkon Listesi" style="text-align: left; padding: 8.88px;" class="btn btn-default">
					  	<i class="fa fa-external-link"></i>
					  </a>
						-->
					<div class="modal modal-default fade" id="ikonlist" style="display: none;">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header text-center alert alert-info">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">×</span></button>
							<h4 class="modal-title"><i class="fa fa-check-circle"></i> İkon Seçiniz</h4>
						  </div>
						  <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
							<h5 class="alert alert-info text-center"><i class="fa fa-bullhorn"></i> Eklemek istediğiniz ikon kodunu kopyalayınız.</h5>
							<?php include("/../ikonlar.php"); ?>
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
				<button type="submit" class="btn btn-primary btn-lg pull-right" name="kaydet"> <i class="fa fa-check"></i> Kaydet </button>
			 </div>
		</div>
	</section>
</form>
<?php } ?>
<?php
	if ($islem == "liste") {
?>
<section class="content">
    
	<?php

		if ($hareket == "onay") {
			onay();
		}

		if ($durum == "0") {
			$d = $vt->query("UPDATE ustmenu SET durum = '0' where id = '$id'");
			go("index.php?do=islem&icerik=ustmenu&islem=liste&hareket=onay&id=$id",0);
		}
		if ($durum == "1") {
			$d = $vt->query("UPDATE ustmenu SET durum = '1' where id = '$id'");
			go("index.php?do=islem&icerik=ustmenu&islem=liste&hareket=onay&id=$id",0);
		}

		if ($hareket == "sil") {

			$sil = $vt->query("DELETE FROM ustmenu where id = '$id'");
			$silustid = $vt->query("DELETE FROM ustmenu where ustid = '$id'");

			go("index.php?do=islem&icerik=ustmenu&islem=liste&hareket=onay",0);

		}

	?>

    <a href="index.php?do=islem&icerik=ustmenu&islem=ekle" class="btn btn-lg bt-xs btn-success">
        <i class="fa fa-plus"></i> Yeni Ekle
    </a>
	
	<form action="" method="post">
		<div class="bo x">
			<div class="box-bo dy table-responsive">
				<table id="example1" class="table table-bordered dataTable" colspan="5" role="grid" aria-describedby="example1_info">
				    <thead>
				        <tr>
				            <td style="width:0.004%;"> ID </td>
				            <td style="width:0.3%;"> Ad </td>
				            <td style="width:0.1%;"> Üst Menü </td>
				            <td style="width:0.1%;"> Sef Link </td>
				            <td style="width:0.1%;"> Url </td>
				            <td style="width:0.01%;"> Durum </td>
				            <td style="width:0.0000001%;"> Sıra No </td>
				            <td class="text-center" style="width:0.1%;"> İşlemler </td>
				        </tr>
				    </thead>
				    <tbody>
			    			<?php

	                        // ilan kategori

	                        function ustmenu($id = 0, $i = 0, $string = true) {
	                        	$anakat = $vt->query("SELECT * FROM ustmenu where ustid = '$id' order by sira ASC");
								while($akat = $anakat->fetch()) {

							?>
							<tr>
								<th><?=$akat["id"];?></th>
								<?php if ($akat["ustid"] == 0) { ?>
								<th><strong><?=$akat["baslik"];?> - [ Ana Menü ]</strong></th>
								<?php } else { ?>
								<th><?=str_repeat('-', $i).$akat["baslik"];?></th>
								<?php } ?>

								<?php if ($akat["ustid"] != 0) { ?>
									<th>
										<?php
											$ustkat = $vt->query("SELECT * FROM ustmenu where id = '".$akat["ustid"]."'");
											$ustver = $ustkat->fetch();
										?>
										<?=$ustver["baslik"];?>
									</th>
								<?php } else { ?>
									<th> - </th>
								<?php } ?>
								<th>
									<?php if ($akat["url"] == "") { ?>
										<?=$akat["seo"];?>
									<?php } else { ?>
										-
									<?php } ?>
								</th>
								<th>
									<?=$akat["url"];?>
								</th>
								<th>
									<?php
				        				if ($akat["durum"] == 0) {
				        			?>
					        			<span class="btn bg-success btn-xs btn-block"> Aktif </span>
					        			<?php } else if ($akat["durum"] == 1) { ?>
					        			<span class="btn bg-danger btn-xs btn-block"> Pasif </span>
			        				<?php } ?>
								</th>
								<th>
									<input type="text" name="siraid[]" class="form-control hidden" value="<?=$akat["id"];?>">
									<input type="text" name="sira[]" class="form-contro l btn-xs" value="<?=$akat["sira"];?>">
								</th>
								</th>
								<th class="text-center" style="width: 10px; white-space: nowrap;">
									<a href="index.php?do=islem&icerik=ustmenu&islem=duzenle&id=<?=$akat['id']?>" title="Düzenle" class="btn btn-primary btn-xs btn-blo ck">
										<i class="fa fa-pencil"></i> Düzenle
									</a>
									<?php
										if ($akat["durum"] == "0") {
									?>
									<a href="index.php?do=islem&icerik=ustmenu&islem=liste&durum=1&id=<?=$akat['id']?>" title="Yayından Kaldır" class="btn btn-warning btn-xs btn-b lock">
										<i class="fa fa-close"></i> Pasif Et
									</a>
									<?php } else if ($akat["durum"] == "1"){ ?>
									<a href="index.php?do=islem&icerik=ustmenu&islem=liste&durum=0&id=<?=$akat['id']?>" title="Yayınla" class="btn btn-success btn-xs btn-bl ock">
										<i class="fa fa-check"></i> Aktif Et
									</a>
									<?php } ?>
									<a href="#" data-toggle="modal" data-target="#<?=$akat["id"];?>" title="Sil" class="btn btn-danger btn-xs btn-b lock">
										<i class="fa fa-trash"></i> Sil
									</a>
									<div class="modal modal-default text-center fade" id="<?=$akat["id"]?>" style="display: none;">
									  <div class="modal-dialog">
										<div class="modal-content">
										  <div class="modal-header alert alert-info">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true">×</span></button>
											<h4 class="modal-title"><i class="fa fa-close"></i> Silme Onayı Ver</h4>
										  </div>
										  <div class="modal-body">
											<h5 class="alert alert-info"><i class="fa fa-bullhorn"></i><strong> UYARI: </strong> Eğer bir <strong>[ Ana Menü ]</strong> ya da <strong>Üst Menü</strong> silerseniz. Alt menülerde silinecektir!</h5>
											<h4><strong> "<?=$akat["baslik"]?>" </strong> isimli menüyü silmek istiyor musunuz ?</h4>
										  </div>
										  <div class="modal-footer">
											<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
											<a href="index.php?do=islem&icerik=ustmenu&islem=liste&hareket=sil&id=<?=$akat['id']?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
										  </div>
										</div>
									  </div>
									</div>
								</th>
							</tr>
							<?php ustmenu($akat["id"], $i + 2); ?>
							<?php } ?>
							<?php } ?>

							<?php ustmenu(0,0,0); ?>
				    </tbody>
				</table>
			</div>
		</div>

		<button type="submit" class="btn btn-primary btn-lg" name="sirakaydet"> <i class="fa fa-check"></i> Sıralamayı Kaydet </button>

	</form>
</section>
<?php } ?>
<!--
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
-->