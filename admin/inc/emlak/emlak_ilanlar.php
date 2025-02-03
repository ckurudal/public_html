<?php
	
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
	
	$hareket 	= @$_GET["hareket"];
	$onayid 	= @$_GET["onayid"];
	$uyeonay 	= @$_GET["uyeonay"];
	$ilanonay 	= @$_GET["ilanonay"];

	$magaza = $vt->query("SELECT * FROM subeler WHERE id = '".@$_GET["magaza"]."'")->fetch(PDO::FETCH_OBJ);

 ?>
<!-- Content Header (Page header) -->
<section class="content-header">
<?php
	if (@$_GET["magaza"]) {
?>

<div class="alert alert-primary">
	<?php echo $magaza->adi; ?> Mağazasına Ait Tüm İlanlar
</div>

<?php } else { ?>
	<i class="fa fa-edit fa-2x pull-left"></i>
	İlan Yönetimi
	<p> <small> İlan Yönetimi </small> </p> 
<?php } ?>
</section>
<form method="post" action="" enctype="multipart/form-data">

	<?php

		$emlakilan = mysql_query("select * from emlak_ilan where id");
		$e = mysql_fetch_array($emlakilan);
	?>

	<section class="content">

		<?php
			if ($emlakno = @$_GET["islemno"]) {
				$resimemlakno = $emlakno;
			}
			// islem sil
			if ($sil = @$_GET["sil"]) {
				if ($emlakno = @$_GET["islemno"]) {

					if (yetki() == 0):
					
					// MAIL - SMS BILDIRIM
					
					$ilan_id 	= $vt->query("SELECT * FROM emlak_ilan WHERE emlakno = '$emlakno'")->fetch();
					$uye 		= $vt->query("SELECT * FROM yonetici WHERE id = '".$ilan_id["yonetici_id"]."'")->fetch(); 
					
					sms_gonder($uye['id'],"Sayın ".$uye["adsoyad"].", ".$ilan_id["emlakno"]." numaralı ilanınız silinmiştir.");		
					mail_gonder($uye['email'],"Sayın ".$uye["adsoyad"].", ".$ilan_id["emlakno"]." numaralı ilanınız silinmiştir.","Sayın ".$uye["adsoyad"].", ".$ilan_id["emlakno"]." numaralı ilanınız silinmiştir. <br>".$ayar["site_url"]."");

					endif;
					
                    $resimemlakno = $emlakno;
                    

					// resim dosyalarini sil
					$resimdosya = mysql_query("select * from emlak_resim where emlakno = '$resimemlakno'");
					while (@$resver = mysql_fetch_array($resimdosya)) {
						//echo $resver["resimad"]."<br>";
						$targetDir = '../uploads/resim/mini-'.$resver[resimad];
						@unlink("$targetDir");
						$targetDir = '../uploads/resim/'.$resver[resimad];
						@unlink("$targetDir");
					}
                    $resimsil=mysql_query("DELETE FROM emlak_resim where emlakno = '$resimemlakno'");
                    

					// proje resim dosyalarini sil
                    $projeresimdosya = mysql_query("select * from projeler where emlakno = '$resimemlakno'");                    

					while (@$projeresver = mysql_fetch_array($projeresimdosya)) {
						//echo $resver["resimad"]."<br>";
						$projetargetDir = '../uploads/proje_resim/'.$projeresver[plan_resim];
						@unlink("$projetargetDir");
					}
					$projeresimsil=mysql_query("DELETE FROM projeler where emlakno = '$resimemlakno'");
                    

					// proje resim dosyalarini sil
                    $projekapakresimdosya = mysql_query("select * from proje_kapak where emlakno = '$resimemlakno'");                    

					while (@$projeresver = mysql_fetch_array($projekapakresimdosya)) {
						//echo $resver["resimad"]."<br>";
						$projekapaktargetDir = '../uploads/proje_resim/'.$projeresver[proje_kapak];
						@unlink("$projekapaktargetDir");
					}
					$projekapakresimsil=mysql_query("DELETE FROM proje_kapak where emlakno = '$resimemlakno'");
				}

				$ilansil=mysql_query("DELETE FROM emlak_ilan where id = '$sil'");

				if ($sil) {
					
					onay(); 
					
					
				}

				$ozellikdetaysil=mysql_query("DELETE FROM emlak_ozellikdetay where ilanid = '$sil'");
				$ilandetaysil=mysql_query("DELETE FROM emlak_ilandetay where ilanid = '$sil'");
			}
			// durum guncelle
			$durum = @$_GET["durum"];
			if ($durum) {
				$ver = mysql_fetch_array(mysql_query("SELECT * FROM emlak_ilan WHERE id = '$durum'"));
				$kdurum = $ver["durum"];
				if ($ver["durum"] == 1) {
					mysql_query("UPDATE emlak_ilan SET durum = '0', satildi = 0, kiralandi = 0 WHERE id = '$durum'");
					onay();
				} else {
					mysql_query("UPDATE emlak_ilan SET durum  = '1' WHERE id = '$durum'");
					onay();
				}
			}
			if ($hareket == "onay") {
				onay();
			}
		?> 

		<?php
			if ($ilanonay == "onayla") {

				$ilanonayla = mysql_query("UPDATE emlak_ilan SET onay = 1 where id = '$onayid'");

				if ($ilanonayla) {

					onay();
					
					if (yetki() == 0):
					
					$ilan_id 	= $vt->query("SELECT * FROM emlak_ilan WHERE id = '$onayid'")->fetch();
					$uye 		= $vt->query("SELECT * FROM yonetici WHERE id = '".$ilan_id["yonetici_id"]."'")->fetch();
					
					mail_gonder($uye['email'],"Tebrikler, ".$ilan_id["emlakno"]." numaralı ilanınız Onaylandı.","Tebrikler! Sayın ".$uye["adsoyad"].", ".$ilan_id["emlakno"]." numaralı ilanınız onaylanarak yayına alınmıştır. <br>".$ayar["site_url"]."");
					
					sms_gonder($uye['id'],"Tebrikler! Sayın ".$uye["adsoyad"].", ".$ilan_id["emlakno"]." numaralı ilanınız onaylanarak yayına alınmıştır.");

					endif;

				}

			}

			if ($ilanonay == "onaykaldir") {

				$ilanonaykaldir = mysql_query("UPDATE emlak_ilan SET onay = 0 where id = '$onayid'");

				if ($ilanonaykaldir) {

					onay();
					
					if (yetki() == 0):
					
					$ilan_id 	= $vt->query("SELECT * FROM emlak_ilan WHERE id = '$onayid'")->fetch();
					$uye 		= $vt->query("SELECT * FROM yonetici WHERE id = '".$ilan_id["yonetici_id"]."'")->fetch();
					
					mail_gonder($uye['email'],"Sayın ".$uye["adsoyad"].", ".$ilan_id["emlakno"]." numaralı ilanınız yayından kaldırılmıştır.","Sayın ".$uye["adsoyad"].", ".$ilan_id["emlakno"]." numaralı ilanınız yayından kaldırılmıştır.");
					
					sms_gonder($uye['id'],"Sayın ".$uye["adsoyad"].", ".$ilan_id["emlakno"]." numaralı ilanınız yayından kaldırılmıştır.");

					endif;

				}

			}
		?>


      <div class="row">
      	
      	<div class="col-md-2">
      		
	      <a href="index.php?do=islem&emlak=emlak_ekle&islem=sec" class="btn btn-lg bt-xs btn-success btn-block">
	          <i class="fa fa-plus"></i> Yeni İlan Ekle
	      </a>

      	</div>
		
      	<div class="col-md-10 hidden">
      		
	      <?php if ($kullanici["yetki"] == 0) { ?>
			<div class="text-right hidden-xs hidden-sm">
				<span class="btn bg-info" style="margin-right: 5px;"><i class="fa fa-desktop" style="color: #333;"></i> Anasayfa Vitrin</span>
				<span class="btn bg-info" style="margin-right: 5px;"><i class="fa fa-star" style="color: #333;"></i> Fırsat Vitrin</span>
				<!--<span class="btn bg-info" style="margin-right: 5px;"><i class="fa fa-th" style="color: #333;"></i> Slider Vitrin</span>-->
				<span class="btn bg-info" style="margin-right: 5px;"><i class="fa fa-bell" style="color: #333;"></i> Acil Vitrin</span>
				<span class="btn bg-info" style="margin-right: 5px;"><i class="fa fa-bullhorn" style="color: #333;"></i> Öne Çıkanlar</span>
			</div> 
			<?php } ?>

      	</div>

      </div> 
      	
	<?php if(yetki() == 2 && $magaza == true): ?>

	
	<?php endif; ?>
	
	 <div class="bo x">

		<div class="bo x-body table-responsive">
			
			<table id="example1" class="table table-bordered dataTable" colspan="5" role="grid" aria-describedby="example1_info">
                <thead>
                    <tr>
                        <td> ID </td>
                        <td> Resim </td>
                        <td> İlan Başlığı </td>
                        <td> Kategori </td>
                        <td> İlan Detayları </td>
                        <?php if ($kullanici["yetki"] == "0") { ?>
                        <td class="hidden"> Vitrin </td>
                        <?php } ?>
                        <td> İşlemler </td>
                    </tr>
                </thead> 
                <tbody>
                <?php
				
					$magaza = @$_GET["magaza"]; 

                	if ($kullanici["yetki"] != 0) {

                    	if ($uyeonay == "onaybekleyen") {

                    		$ilanlar=mysql_query("SELECT * FROM emlak_ilan where onay = 0 && yonetici_id = '".$kullanici["id"]."' order by id DESC");

							} else if ($uyeonay == "satildi") {

	                    		$ilanlar=mysql_query("SELECT * FROM emlak_ilan where satildi = 1 && yonetici_id = '".$kullanici["id"]."' order by id DESC");

							} else if ($uyeonay == "kiralandi") {

	                    		$ilanlar=mysql_query("SELECT * FROM emlak_ilan where kiralandi = 1 && yonetici_id = '".$kullanici["id"]."' order by id DESC");

							} else if ($uyeonay == "yayindaolmayan") {

	                    		$ilanlar=mysql_query("SELECT * FROM emlak_ilan where durum = 1 && yonetici_id = '".$kullanici["id"]."' && onay = 1 && satildi = 0 && kiralandi = 0 && durum = 1 order by id DESC");

							} else if (@$_GET["magaza"]) {

								$uye_yasak = $vt->query("SELECT * FROM yonetici WHERE id = '".$_SESSION["id"]."'")->fetch();
	
							$sube_kontrol = $vt->query("SELECT * FROM subeler WHERE yetkiliuye = '".$uye_yasak["id"]."'")->fetch(PDO::FETCH_ASSOC);  

							$ilanlar=mysql_query("SELECT * FROM emlak_ilan where onay = 1 and ofisid = '".$sube_kontrol["id"]."'");

							} else {

	                    		$ilanlar=mysql_query("SELECT * FROM emlak_ilan where onay = 1 && durum = 0 && satildi = 0 && kiralandi = 0 && yonetici_id = '".$kullanici["id"]."' order by id DESC");

							}

                	} else {

                    	if ($uyeonay == "onaybekleyen") {

                    		$ilanlar=mysql_query("SELECT * FROM emlak_ilan where onay = 0 order by id DESC");

						} else if ($uyeonay == "satildi") {

							$ilanlar=mysql_query("SELECT * FROM emlak_ilan where satildi = 1 order by id DESC");

						} else if ($uyeonay == "kiralandi") {

							$ilanlar=mysql_query("SELECT * FROM emlak_ilan where kiralandi = 1 order by id DESC");

						} else if ($uyeonay == "yayindaolmayan") {

							$ilanlar=mysql_query("SELECT * FROM emlak_ilan where durum = 1 && onay = 1 order by id DESC");

						} else if (@$_GET["magaza"]) {
							
							$uye_yasak = $vt->query("SELECT * FROM yonetici WHERE id = '".$_SESSION["id"]."'")->fetch();
	
							$sube_kontrol = $vt->query("SELECT * FROM subeler WHERE yetkiliuye = '".$uye_yasak["id"]."'")->fetch(PDO::FETCH_ASSOC);  

							$ilanlar=mysql_query("SELECT * FROM emlak_ilan where onay = 1 and ofisid = '".$sube_kontrol["id"]."'");

						} else  {

							$ilanlar=mysql_query("SELECT * FROM emlak_ilan where onay = 1 && durum = 0 && satildi = 0 && kiralandi = 0 order by id DESC");

						}
                	}

                	while ($ilan=mysql_fetch_array($ilanlar)) { 

						$doping_sicak_firsat 	= $vt->query("SELECT * FROM doping_ilanlari WHERE doping_adi LIKE '%sicak_firsat%' AND ilan_id = '{$ilan["id"]}'")->fetch();
						$doping_vitrin_ilan 	= $vt->query("SELECT * FROM doping_ilanlari WHERE doping_adi LIKE '%vitrin_ilan%' AND ilan_id = '{$ilan["id"]}'")->fetch(); 
						$doping_one_cikan 		= $vt->query("SELECT * FROM doping_ilanlari WHERE doping_adi LIKE '%one_cikan%' AND ilan_id = '{$ilan["id"]}'")->fetch();
						$doping_acil_ilan 		= $vt->query("SELECT * FROM doping_ilanlari WHERE doping_adi LIKE '%acil_ilan%' AND ilan_id = '{$ilan["id"]}'")->fetch();

                    ?>
					<?php
						$katadi=mysql_query("SELECT * FROM emlak_kategori where kat_id = '$ilan[katid]'");
						$k=mysql_fetch_array($katadi);
						
						$proje_sekli = $vt->query("SELECT * FROM emlak_ilansekli WHERE id = '{$k["ilansekli"]}'")->fetch();
						
					?>					
					
                    <tr>
                    	<th class="text-center" <?php if ($ilan["doping"] == "var") { ?> style="background:#f2dede;" <?php } ?>>
							<?=$ilan['id'];?>
                    	</th>
                    	<th <?php if ($ilan["doping"] == "var") { ?> style="background:#f2dede;" <?php } ?>>                    		

							<?php
								$resver=$ilan['emlakno'];
								$resim=mysql_query("SELECT * FROM emlak_resim where emlakno = '$resver' and kapak = '1'");
								$r=mysql_fetch_array($resim);
								if (empty($r['emlakno'])) { ?>
								<div class="resim_liste">
									<img src="../uploads/resim/resim.png"/>
								</div>
							<?php } else { ?>
								<div class="resim_liste">
									<img src="../uploads/resim/<?=$r['resimad'];?>" />
								</div>
							<?php } ?>
							
							<p></p>

							<?php if ($ilan["doping"] == "var") { ?> <a style="padding:4px 12px; max-width:175px; margin:4px auto" href="index.php?do=doping/ilan_doping&ilan_id=<?php echo $ilan["id"]; ?>" class="btn bg-primary btn-block btn-xs"> <strong>DOPİNGLİ İLAN</strong> </a> <?php } ?>
							
							<?php if ($doping_sicak_firsat == true) { ?>
							<p class="btn btn-default btn-xs btn-block" style="padding:4px 12px; max-width:175px; margin:4px auto; text-align:left;">
								<i class="fa fa-rocket"></i> 
								<strong>SICAK FIRSAT</strong>
							</p>
							<?php } ?>
							
							<?php if ($doping_vitrin_ilan == true) { ?>
							<p class="btn btn-default btn-xs btn-block" style="padding:4px 12px; max-width:175px; margin:4px auto; text-align:left;">
								<i class="fa fa-rocket"></i> 
								<strong>VİTRİN</strong>
							</p>
							<?php } ?>
							
							<?php if ($doping_one_cikan == true) { ?>
							<p class="btn btn-default btn-xs btn-block" style="padding:4px 12px; max-width:175px; margin:4px auto; text-align:left;">
								<i class="fa fa-rocket"></i> 
								<strong>ÖNE ÇIKAN</strong>
							</p>
							<?php } ?>
							
							<?php if ($doping_acil_ilan == true) { ?>
							<p class="btn btn-default btn-xs btn-block" style="padding:4px 12px; max-width:175px; margin:4px auto; text-align:left;">
								<i class="fa fa-rocket"></i> 
								<strong>ACİL</strong>
							</p>
							<?php } ?> 
							
						</th> 
                    	<th class="bilgi-th">
                            <?php if ($proje_sekli["kat_tipi"]=="proje"): ?>
                            <span class="proje-bilgi">PROJE</span>
                            <?php endif; ?>
							<p>İlan no: <strong><?=$ilan['emlakno'];?></strong> </p>
 							<?php if (empty($ilan["baslik"])) { ?>
								<a target="_blank" style="background: #fbdede; color: red; font-size:10px; border: 1px solid #fb9393;" class="btn btn-default" href="/index.php?do=emlakdetay&id=<?=$ilan['id']?>" title="Başlık girilmemiş"> <strong> Başlık girilmemiş </strong> </a>
							<?php } else { ?>
								<a target="_blank" class="text" href="/<?=$ilan["seo"];?>-ilan-<?=$ilan['id']?>" title="<?=$ilan["baslik"];?>"> <?=$ilan["baslik"];?> </a>
							<?php } ?>
							<?php
								$yoneticibaglan = mysql_query("SELECT * FROM yonetici where id = '".$ilan["yonetici_id"]."'");
								$yoneticiver = mysql_fetch_array($yoneticibaglan);
							?>							
							<?php
								$ilandetayver = mysql_query("SELECT * FROM emlak_kategori where kat_id = '".$ilan["katid"]."'");
								$ilandetay = mysql_fetch_array($ilandetayver);

								$ilansekliver = mysql_query("SELECT * FROM emlak_ilansekli where id = '".$ilandetay["ilansekli"]."'");
								$isekli = mysql_fetch_array($ilansekliver);
								
								
							?>	
							<h6><?=$isekli["baslik"];?> / <?=$k["kat_adi"];?></h6>
							<hr>
							
							<?php if ($ilan["onay"] == 1) { ?>
							<?php if ($ilan["anavitrin"] == 1) { ?>								
							<span class="btn btn-info btn-xs" style="padding:4px 12px; border-radius:300px">
								<i class="fa fa-check"></i> 
								Vitrin
							</span>
							<?php } ?>
							<?php if ($ilan["firsatvitrin"] == 1) { ?>								
							<span class="btn btn-info btn-xs" style="padding:4px 12px; border-radius:300px">
								<i class="fa fa-check"></i> 
								Fırsat
							</span>
							<?php } ?>
							<?php if ($ilan["slidervitrin"] == 1) { ?>								
							<!--
							<span class="btn btn-info btn-xs" style="padding:4px 12px; border-radius:300px">
								<i class="fa fa-check"></i> 
								Slider
							</span>
							-->
							<?php } ?>  
							<?php if ($ilan["acil"] == 1) { ?>								
							<span class="btn btn-info btn-xs" style="padding:4px 12px; border-radius:300px">
								<i class="fa fa-check"></i> 
								Acil
							</span>
							<?php } ?>  
							<?php if ($ilan["onecikan"] == 1) { ?>								
							<span class="btn btn-info btn-xs" style="padding:4px 12px; border-radius:300px">
								<i class="fa fa-check"></i> 
								Öne Çıkan
							</span>
							<?php } ?>   
							<?php } ?>   
						</th>
						<th>
							<span class="btn btn-block btn-default btn-xs"><strong><i class="fa fa-user-o"></i> </strong><?=$yoneticiver["adsoyad"];?></span>
							<span class="btn btn-block btn-default btn-xs"><strong><i class="fa fa-calendar-check-o"></i> </strong> <?=date("d-m-Y",strtotime($ilan['eklemetarihi']));?></span>                            
							<!-- <?php $ilan_sahibi=$vt->query("SELECT * FROM emlak_sahibi where id = '".$ilan["sahibi"]."'")->fetch(); ?> -->
							<?php if ($ilan["emlak_sahibi"]!="") { ?>
							<span class="btn btn-block btn-default btn-xs" style="text-align: left;"><strong>Kimden:</strong> <?=$ilan['emlak_sahibi'];?></span>
							<?php } ?>
						</th>

	            		<th>
	            		<?php
	            			$ilantipi=mysql_query("SELECT * FROM emlak_ilantipi where id = '".$ilan["ilantipi"]."'");
	            			$tip=mysql_fetch_array($ilantipi);
	            			if ($tip["id"]!=0) {
	            		?>
	            			<?php
	            				if ($tip["durum"] == 0) {
	            			?>
	            			<span class="btn btn-xs btn-block" style="background: <?=$tip["baslikrenk"];?>; color: <?=$tip["yazirenk"];?>; "><?=$tip["ad"];?></span>
	            		<?php } ?>
	            		<?php } ?>
	            		<?php
	            			echo "<span class='btn btn-block btn-default btn-xs'>".rakam($ilan['fiyat'])." ".$ilan['fiyatkur']."</span>";
	            		?>
						<?php
							if ($ilan[durum] == 0) {
								echo '<span class="btn bg-success btn-xs btn-block"> Yayında </span>';
							} else {
								echo '<span class="btn bg-danger btn-xs btn-block"> Yayında Değil</span>';
							}
						?>
						<?php if ($ilan["kiralandi"]==1) { ?>
							<span class="btn btn-success btn-xs btn-block">Kiralandı</span>
						<?php } ?>
						<?php if ($ilan["satildi"]==1) { ?>
							<span class="btn btn-danger btn-xs btn-block">Satıldı</span>
						<?php } ?>
                    	</th>

                    	<?php if ($kullanici["yetki"] == "0") { ?>
                    	<th class="hidden" style="width: 10px; white-space: nowrap;">

                    		<?php if ($ilan["onay"] == 0) { ?>
								<a href="index.php?do=islem&emlak=emlak_duzenle&id=<?=$ilan['id']?>" title="Düzenle" class="btn btn-danger btn-xs btn-block">
									<i class="fa fa-edit"></i> Onay Bekliyor
								</a>
                    		<?php } ?>
							<?php if ($ilan["onay"] == 1) { ?>
							<a href="" class="btn btn-xs btn-block bg-info">
								<?php if ($ilan["anavitrin"] == 1) {echo '<i class="fa fa-desktop" style="color: #333;"></i> Anasayfa Aktif';} ?>
								<?php if ($ilan["anavitrin"] == 0) {echo '<i class="fa fa-desktop" style="color: #aaa;"></i> Anasayfa Pasif';} ?>
							</a>
							<a href="" class="btn btn-xs btn-block bg-info">
								<?php if ($ilan["firsatvitrin"] == 1) {echo '<i class="fa fa-star" style="color: #333;"></i> Fırsat Aktif';} ?>
								<?php if ($ilan["firsatvitrin"] == 0) {echo '<i class="fa fa-star" style="color: #aaa;"></i> Fırsat Pasif';} ?>
							</a>
							<--
							<a href="" class="btn btn-xs btn-block bg-info">
								<?php if ($ilan["slidervitrin"] == 1) {echo '<i class="fa fa-th" style="color: #333;"></i> Slider Pasif';} ?>
								<?php if ($ilan["slidervitrin"] == 0) {echo '<i class="fa fa-th" style="color: #aaa;"></i> Slider Pasif';} ?>
							</a>
							-->
							<a href="" class="btn btn-xs btn-block bg-info">
								<?php if ($ilan["acil"] == 1) {echo '<i class="fa fa-bell" style="color: #333;"></i> Acil Pasif';} ?>
								<?php if ($ilan["acil"] == 0) {echo '<i class="fa fa-bell" style="color: #aaa;"></i> Acil Pasif';} ?>
							</a>
							<a href="" class="btn btn-xs btn-block bg-info">
								<?php if ($ilan["onecikan"] == 1) {echo '<i class="fa fa-bullhorn" style="color: #333;"></i> Öne Çıkan Pasif';} ?>
								<?php if ($ilan["onecikan"] == 0) {echo '<i class="fa fa-bullhorn" style="color: #aaa;"></i> Öne Çıkan Pasif';} ?>
							</a>
							<?php } ?>
						</th>

						<?php } ?>
                    	<th class="text-center" style="width: 10px; white-space: nowrap;">
                    		<?php if ($ilan["onay"] == 1) { ?>
							<a href="index.php?do=islem&emlak=emlak_duzenle&id=<?=$ilan['id']?>" title="Düzenle" class="btn btn-block btn-xs btn-primary">
								<i class="fa fa-pencil"></i> Düzenle
							</a> 
							<!--
							<a href="index.php?do=islem&emlak=emlak_resim&id=<?=$ilan['id']?>" title="Düzenle" class="btn btn-primary btn-xs">
								<i class="fa fa-image"></i>
							</a>
							-->
							<a href="#" data-toggle="modal" data-target="#<?=$ilan["id"];?>" title="Sil" class="btn btn-danger btn-xs btn-block">
								<i class="fa fa-trash" style="color: re d;"></i> Sil
							</a> 
							
							<?php if ($kullanici["yetki"] == 0 or $kullanici["yetki"] == 2) { ?>
								<a href="index.php?do=islem&emlak=emlak_duzenle&danisman=degistir&id=<?=$ilan["id"];?>" class="btn btn-warning btn-xs btn-block">
									<i class="fa fa-users"></i> <strong>DANIŞMAN ATA</strong>
								</a>
							<?php } ?>

							<?php if ($ilan[durum]==0) { ?>
							<a href="index.php?do=islem&emlak=emlak_ilanlar&durum=<?=$ilan["id"];?>" title="Taslak Yap" class="btn  btn-default btn-xs btn-block">
								<i class="fa fa-close" style="color: red;"></i> Taslak Yap
							</a>
							<?php } else { ?>
							<a href="index.php?do=islem&emlak=emlak_ilanlar&durum=<?=$ilan["id"];?>" title="Aktif Et" class="btn btn-default btn-xs btn-block">
								<i class="fa fa-check" style="color: green;"></i> Yayınla
							</a>
							<?php } ?>
						<?php } ?>
						
						<?php if ($ilan["onay"] == 0): ?>						
						
						<a href="index.php?do=islem&emlak=emlak_duzenle&id=<?=$ilan['id']?>" title="Düzenle" class="btn btn-inverse btn-xs btn-block">
							<i class="fa fa-pencil"></i> Düzenle
						</a>
						
						<a href="#" data-toggle="modal" data-target="#<?=$ilan["id"];?>" title="Sil" class="btn btn-danger btn-xs btn-block">
							<i class="fa fa-trash" style="color: re d;"></i> Sil
						</a>
						
						<?php endif; ?> 
						
						<a href="index.php?do=doping/ilan_doping&ilan_id=<?php echo $ilan["id"]; ?>" class="btn btn-block btn-warning btn-xs"> <i class="fa fa-rocket"></i> <strong>DOPİNG YAP</strong> </a>

	            		<?php
	            			$uyelerbag = mysql_query("SELECT * FROM yonetici where id = '".$ilan["yonetici_id"]."'");
	            			$uye = mysql_fetch_array($uyelerbag);
	            		?>
						
						<a href="index.php?do=islem&emlak=emlak_resim&resim=yukle&id=<?=$ilan['id']?>" class="btn btn-danger btn-xs btn-block"><i class="fa fa-edit"></i> <strong>RESİMLER</strong></a>
						
	            		<?php if ($ilan["onay"] == 1 and $kullanici["yetki"] == 0) { ?>
            			
							<a href="index.php?do=islem&emlak=emlak_ilanlar&onayid=<?=$ilan['id']?>&ilanonay=onaykaldir" title="Onayı Kaldır" class="btn btn-default btn-xs btn-block btn-xs">
								<i class="fa fa-edit"></i> Onayı Kaldır
							</a>
                    		<?php } ?>
                    		<?php if ($ilan["onay"] == 0 and $kullanici["yetki"] == 0) { ?>
								<a href="index.php?do=islem&emlak=emlak_ilanlar&uyeonay=onaybekleyen&onayid=<?=$ilan['id']?>&ilanonay=onayla" title="Onayla" class="btn btn-primary btn-xs btn-block btn-xs">
									<i class="fa fa-edit"></i> Onayla
								</a>
                    		<?php } ?>
							
							<a href="#" data-toggle="modal" data-target="#emlaknotu<?=$ilan["id"];?>" title="Emlak Notu" class="btn btn-default btn-xs btn-block btn-xs">
								<i class="fa fa-bar-chart"></i> İlan Notu
							</a>
							
							
							<div class="modal modal-default fade" id="emlaknotu<?=$ilan["id"];?>" style="display: none;">
							  <div class="modal-dialog">
								<div class="modal-content">
								  <div class="modal-header alert alert-info">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">×</span></button>
									<h4 class="modal-title"><i class="fa fa-check"></i> Emlak Notları</h4>
								  </div>
								  <div class="modal-body">
									<div class="row">
										<div class="col-md-4">
											<?php
												$resver=$ilan['emlakno'];
												$resim=mysql_query("SELECT * FROM emlak_resim where emlakno = '$resver' and kapak = '1'");
												$r=mysql_fetch_array($resim);
												if (empty($r['emlakno'])) { ?>
												<div class="resim _liste">
													<img src="../uploads/resim/resim.png" height="80" class="img-thumbnail" />
												</div>
											<?php } else { ?>
												<div class="resim _liste">
													<img src="../uploads/resim/<?=$r['resimad'];?>"  height="80" class="img-thumbnail"/>
												</div>
											<?php } ?>
										</div>
										<div class="col-md-8">
											<?php if ($ilan["aciklama"] !="") { ?>
												<p class="h4" style="white-space:break-spaces;"><?=$ilan["aciklama"];?></p>
											<?php } else { ?>
												<h4 class="text-danger">Emlak hakkında bir not eklenmemiş.</h4>
												<h5>Eklemek için lütfen ilan düzenleme sayfasına giriniz.</h5>
											<?php } ?>
										</div>
									</div>
								  </div>
								  <div class="modal-footer">
									<a href="#" class="btn btn-default" data-dismiss="modal"> Kapat </a>
								  </div>
								</div>
							  </div>
							</div>
							<div class="modal modal-default fade" id="<?=$ilan["id"]?>" style="display: none;">
							  <div class="modal-dialog">
								<div class="modal-content">
								  <div class="modal-header alert alert-info">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">×</span></button>
									<h4 class="modal-title"><i class="fa fa-close"></i> Silme Onayı Ver</h4>
								  </div>
								  <div class="modal-body">
										<h4 style="white-space: pre-wrap;"><strong> "<?=$ilan["baslik"]?>" </strong> isimli ilan silinecektir. İşlemi onaylıyor musunuz?</h4>
								  </div>
								  <div class="modal-footer">
									<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
									<a href="index.php?do=islem&emlak=emlak_ilanlar&sil=<?=$ilan["id"];?>&islemno=<?=$ilan["emlakno"];?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
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
			<div class="row">
				<div class="col-md-2">
					<a href="index.php?do=islem&emlak=emlak_ekle&islem=sec" class="btn btn-success btn-lg btn-block"> <i class="fa fa-plus fa-lg"></i> Yeni İlan Ekle </a>							
				</div>
				<div class="col-md-10">
					
				</div>
			</div>

	</section>
</form>



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
