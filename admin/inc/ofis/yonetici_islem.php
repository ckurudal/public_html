<?php
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;		
	$islem = $_GET["islem"];
	$id = $_GET["id"];
	$ofis = $_GET["ofis"];
	$hareket = $_GET["hareket"];
	$durum = $_GET["durum"];
	$sifre = $_GET["sifre"];
	$uye = $_GET["uye"];
	$emlakofisi = $_GET["emlakofisi"];
	$uyeekle = $_GET["uyeekle"];
	$yetki = $_GET["yetki"];
	$ofistip = $_GET["ofistip"];
	$uyetip = $_GET["uyetip"];
	$mesaj_goster = $_GET["mesaj_goster"];
	$tab_goster = $_GET["tab_goster"];
	$yonetici = mysql_query("SELECT * FROM yonetici where id = '".$id."'");
	$sube_bul = $vt->query("SELECT * FROM subeler WHERE yetkiliuye = '".$_SESSION["id"]."'")->fetch();	
	$uye_yasak = $vt->query("SELECT * FROM yonetici WHERE id = '".$_SESSION["id"]."'")->fetch();
	if ($uye == "bireysel") {
		$yoneticiliste = mysql_query("SELECT * FROM yonetici where yetki = 1 order by id desc");
	} else if ($uye == "kurumsal") {
		$yoneticiliste = mysql_query("SELECT * FROM yonetici where yetki = 2 order by id desc");
	} else if ($uye == "yonetici") {
		$yoneticiliste = mysql_query("SELECT * FROM yonetici where yetki = 0 order by id desc");
	} else if ($uye == "danisman") {
		$yoneticiliste = mysql_query("SELECT * FROM yonetici where yetki = 3 order by id desc");
	} else if ($emlakofisi == true) {
		$yoneticiliste = mysql_query("SELECT * FROM yonetici where yetki = 3 && ofis = '".$emlakofisi."' order by id desc");
	} else if ($islem == "liste") {
		$yoneticiliste = mysql_query("SELECT * FROM yonetici where id");
	} else {
		$yoneticiliste = mysql_query("SELECT * FROM yonetici where yetki = 3 order by id desc");
	}
?> 
<section class="content-header"> 
	  	<i class="fa fa-user-o fa-2x pull-left"></i>
			Üye Yönetimi
	  	<?php if ($uye == "bireysel") { ?>
	    	/ Bireysel Üyeler
	 	<?php } ?>
	 	<?php if ($uye == "kurumsal") { ?>
		    / Kurumsal Üyeler
	 	<?php } ?>
	 	<?php if ($uye == "danisman") { ?>
		    / Danışmanlar
	 	<?php } ?>
	 	<?php if ($uyeekle == "bireysel") { ?>
	 		/ Bireysel Üye Ekle
	 	<?php } ?>
	 	<?php if ($uyeekle == "kurumsal") { ?>
	 		/ Kurumsal Üye Ekle
	 	<?php } ?>
	 	<?php if ($uyeekle == "danisman") { ?>
	 		/ Danışman Ekle
	 	<?php } ?>
	 	<?php if ($uyeekle == "yonetici") { ?>
	 		/ Yönetici Ekle
	 	<?php } ?>
	 	<p>  <small>Üyelik İşlemleri</small>  </p>
</section>
<section>
	<?php
		if (isset($_POST["yoneticiekle"]) || isset($_POST["yoneticikaydet"]) || isset($_POST["yoneticieklekurumsal"])) {
			$adsoyad		= $_POST["adsoyad"];
			$seo			= seo($_POST["adsoyad"]);
			$pass			= md5($_POST["pass"]);
			$email			= $_POST["email"];
			$tel			= $_POST["tel"];
			$fax			= $_POST["fax"];
			$gsm			= $_POST["gsm"];
			$unvan			= $_POST["unvan"];
			$yetki			= $_POST["yetki"];
			$sira			= $_POST["sira"];
			$aciklama		= $_POST["aciklama"];
			$ofis			= $_POST["ofis"];
			$eposta_bildirim= $_POST["eposta_bildirim"];
			$sms_bildirim	= $_POST["sms_bildirim"];
			// UYELIK STANDART AYARLAR
			$aylik_limit			= $_POST["aylik_limit"];
			$resim_limit			= $_POST["resim_limit"];
			$ilan_sure				= $_POST["ilan_sure"];
			$ilan_sure_zaman	= $_POST["ilan_sure_zaman"];
			$firmadi		= $_POST["firmadi"];
			$firmadiseo		= seo($_POST["firmadi"]);
			$firmaunvan		= $_POST["firmaunvan"];
			$vergino		= $_POST["vergino"];
			$vergidairesi		= $_POST["vergidairesi"];
			$sosyalid 		= $_POST["sosyalid"];
			$sosyallink 	= $_POST["sosyallink"];
			$sosyalbaslik 	= $_POST["sosyalbaslik"];
			if (isset($_POST["yoneticiekle"]) || isset($_POST["yoneticieklekurumsal"])) {
				$uye_id = $vt->query("SELECT * FROM yonetici WHERE id = '$id'")->fetch(); 
				$varmi_tel=mysql_num_rows(mysql_query("SELECT * FROM yonetici where id != '$id' AND tel='$tel'"));
				$varmi_mail=mysql_num_rows(mysql_query("SELECT * FROM yonetici where id != '$id' AND email='$email'"));
				if($varmi_tel!=0 || $varmi_mail!=0) {
					hata_alert("Telefon ya da mail başkası tarafından kullanılıyor. Lütfen farklı bilgiler giriniz.");
				} else {
					if (empty($tel) || empty($email)) {
						hata_alert("lütfen geçerli bir telefon ya da mail adresi giriniz.");
					} else {				
						if($varmi_tel!=0 || $varmi_mail!=0) {
							hata_alert("Telefon ya da mail başkası tarafından kullanılıyor. Lütfen farklı bilgiler giriniz.");
						} else {
							if (yetki() == 2) {
								$yoneticiekle = mysql_query("INSERT INTO yonetici (adsoyad, ofis, seo, pass, email, tel, fax, gsm, unvan, eposta_bildirim, sms_bildirim, sira, aciklama, yetki, aylik_limit, resim_limit, ilan_sure, ilan_sure_zaman) VALUES ('$adsoyad', '".$sube_bul["id"]."', '$seo', '$pass', '$email', '$tel', '$fax', '$gsm', '$unvan', '$eposta_bildirim', '$sms_bildirim', '$sira', '$aciklama', '$yetki', '$aylik_limit', '$resim_limit', '$ilan_sure', '$ilan_sure_zaman')");
							} else { 
								$yoneticiekle = mysql_query("INSERT INTO yonetici (adsoyad, seo, pass, email, tel, fax, gsm, unvan, eposta_bildirim, sms_bildirim, sira, aciklama, yetki, aylik_limit, resim_limit, ilan_sure, ilan_sure_zaman) VALUES ('$adsoyad','$seo', '$pass', '$email', '$tel', '$fax', '$gsm', '$unvan', '$eposta_bildirim', '$sms_bildirim', '$sira', '$aciklama', '$yetki', '$aylik_limit', '$resim_limit', '$ilan_sure', '$ilan_sure_zaman')");
							}		
						}
					}		
					$ids = mysql_query("SELECT * FROM yonetici where email = '$email'");
					$id = mysql_fetch_array($ids);
					if (isset($_POST["yoneticieklekurumsal"])) {
						$uyekurumsal = mysql_query("SELECT * FROM yonetici order by id desc limit 1");
						$uk = mysql_fetch_array($uyekurumsal);
						$firmaekle = mysql_query("INSERT INTO subeler (adi, yetkiliuye, seo, firmaunvan, vergino, vergidairesi) values ('$firmadi','".$uk["id"]."','$firmadiseo','$firmaunvan','$vergino','$vergidairesi')");
						$sube_bagla = $vt->query("SELECT * FROM subeler WHERE yetkiliuye = '".$uk["id"]."'")->fetch();
						$sube_ata = $vt->query("UPDATE yonetici SET ofis = '".$sube_bagla["id"]."', sube = '".$sube_bagla["adi"]."' WHERE id = '".$uk["id"]."'");
					}
					// sosyal medya bilgileri
					for ($i=0; $i < count($sosyalid) ; $i++) {
						$sosyalekle = mysql_query("INSERT INTO yonetici_sosyal (yoneticiid, sosyalid, sosyallink, baslik) VALUES ('".$id["id"]."', '".$sosyalid[$i]."','".$sosyallink[$i]."','".$sosyalbaslik[$i]."')");
					}
					if ($yoneticiekle) {
						// resim yukleme
						$yuklenmeyenler = 0;
						$yuklenenler = 0;
						$toplam = count($_FILES["resim"]["name"]);
						for ($i = 0; $i < $toplam; $i++) {
							if (is_uploaded_file($_FILES["resim"]["tmp_name"][$i])) {
								$resim = pathinfo($_FILES["resim"]["name"][$i]);
								$resim_adi = $resim["filename"];
								$resim_uzanti = $resim["extension"];
								$uzantilar = array("png", "gif", "jpg", "PNG", "GIF", "JPG", "jpeg", "JPEG");
								if (in_array($resim_uzanti, $uzantilar)) {
									$saat = date("H:i:s");
									$saat = sha1(md5($saat));
									$dosya = "../uploads/resim/".$saat.".jpg";
									if (move_uploaded_file($_FILES["resim"]["tmp_name"][$i], $dosya)) {
										$ids = mysql_query("SELECT * FROM yonetici where email = '$email'");
										$id = mysql_fetch_array($ids);
										$link = "uploads/resim/".$saat.".jpg";
										$ekle = mysql_query("UPDATE yonetici SET resim = '$link' where id = '".$id["id"]."'");
										$yuklenenler++;
									}
								} else {
									$yuklenmeyenler++;
								}
							}
						}
						$ids = mysql_query("SELECT * FROM yonetici where kadi = '$kadi'");
						$id = mysql_fetch_array($ids);
						$sonyeler = mysql_query("SELECT * FROM yonetici order by id desc limit 1");
						$sonuye = mysql_fetch_array($sonyeler);
						if (yetki() == 0) {go("index.php?do=islem&ofis=yonetici&islem=liste&uye=yonetici&hareket=onay",0);}
						if (yetki() == 1) {go("index.php?do=islem&ofis=yonetici&islem=liste&uye=bireysel&hareket=onay",0);}
						if (yetki() == 2) {go("index.php?do=islem&ofis=yonetici&islem=duzenle&id={$_SESSION["id"]}&tab_goster=magaza_paketleri&tab_goster=danismanlari",0);}
						if (yetki() == 3) {go("index.php?do=islem&ofis=yonetici&islem=liste&uye=danisman&hareket=onay",0);} 
					} else {
						echo mysql_error();
					}
				}
			}
			if (isset($_POST["yoneticikaydet"])) {
				$uye_id = $vt->query("SELECT * FROM yonetici WHERE id = '$id'")->fetch(); 
				$varmi=mysql_num_rows(mysql_query("SELECT * FROM yonetici where id != '$id' AND tel='$tel'"));
				if (empty($tel)) {
					hata_alert("lütfen geçerli bir telefon giriniz.");
				} else {				
					if($varmi!=0) {
						hata_alert("Telefon numarası başka bir kullanıcıda kayıtlı, lütfen farklı bilgiler giriniz.");
					} else {
						if (yetki() == 0) {
							$yoneticikaydet = mysql_query("UPDATE yonetici SET 
							
    							adsoyad = '$adsoyad', 
    							seo = '$seo', 
    							tel = '$tel', 
    							fax = '$fax', 
    							gsm = '$gsm', 
    							unvan = '$unvan', 
    							eposta_bildirim = '$eposta_bildirim', 
    							sms_bildirim = '$sms_bildirim', 
    							sira = '$sira', 
    							yetki = '$yetki', 
    							aciklama = '$aciklama', 
    							aylik_limit = '$aylik_limit', 
    							resim_limit = '$resim_limit', 
    							ilan_sure = '$ilan_sure', 
    							ilan_sure_zaman = '$ilan_sure_zaman' 
    							WHERE id = '$id'
							
							");
						} else {
							$yoneticikaydet = mysql_query("UPDATE yonetici SET 
							
    							adsoyad = '$adsoyad', 
    							seo = '$seo', 
    							tel = '$tel', 
    							fax = '$fax', 
    							gsm = '$gsm', 
    							unvan = '$unvan', 
    							eposta_bildirim = '$eposta_bildirim', 
    							sms_bildirim = '$sms_bildirim', 
    							sira = '$sira', 
    							aciklama = '$aciklama', 
    							aylik_limit = '$aylik_limit', 
    							resim_limit = '$resim_limit', 
    							ilan_sure = '$ilan_sure', 
    							ilan_sure_zaman = '$ilan_sure_zaman' 
    							WHERE id = '$id'
							
							");
						}					
					}
				}
				if ($yoneticikaydet) {
					// resim yukleme
					$yuklenmeyenler = 0;
					$yuklenenler = 0;
					$toplam = count($_FILES["resim"]["name"]);
					for ($i = 0; $i < $toplam; $i++) {
						if (is_uploaded_file($_FILES["resim"]["tmp_name"][$i])) {
							$resim = pathinfo($_FILES["resim"]["name"][$i]);
							$resim_adi = $resim["filename"];
							$resim_uzanti = $resim["extension"];
							$uzantilar = array("png", "gif", "jpg", "PNG", "GIF", "JPG", "jpeg", "JPEG");
							if (in_array($resim_uzanti, $uzantilar)) {
								$saat = date("H:i:s");
								$saat = sha1(md5($saat));
								$dosya = "../uploads/resim/".$saat.".jpg";
								if (move_uploaded_file($_FILES["resim"]["tmp_name"][$i], $dosya)) {
									$resimal = mysql_query("SELECT * FROM yonetici where id = $id");
									$ral = mysql_fetch_array($resimal);
									unlink("../".$ral['resim']);
									$link = "uploads/resim/".$saat.".jpg";
									$ekle = mysql_query("UPDATE yonetici SET resim = '$link' where id = '$id'");
									$yuklenenler++;
								}
							} else {
								$yuklenmeyenler++;
							}
						}
					}
					$silsosyal = mysql_query("DELETE FROM yonetici_sosyal where yoneticiid = '$id'");
					for ($i=0; $i < count($sosyalid) ; $i++) {
						$sosyalekle = mysql_query("INSERT INTO yonetici_sosyal (yoneticiid, sosyalid, sosyallink, baslik) VALUES ('$id', '".$sosyalid[$i]."','".$sosyallink[$i]."','".$sosyalbaslik[$i]."')");
					}
					$yetkikontrol = mysql_query("SELECT * FROM yonetici where id = '$id'");
					$kontrol = mysql_fetch_array($yetkikontrol);
					if ($kontrol["yetki"] == 1) {
						$ofissil = mysql_query("UPDATE yonetici SET ofis = '0' where id = '$id'");
					}
					if (yetki() == 0) {go("index.php?do=islem&ofis=yonetici&islem=duzenle&id=$id&hareket=onay",0);}
					if (yetki() == 1) {go("index.php?do=islem&ofis=yonetici&islem=duzenle&id=$id&hareket=onay",0);}
					if (yetki() == 2) {go("index.php?do=islem&ofis=yonetici&islem=duzenle&id=$id&hareket=onay",0);}
					if (yetki() == 3) {go("index.php?do=islem&ofis=yonetici&islem=duzenle&id=$id&hareket=onay",0);} 
				}
			}
		}
	?>
</section>
<?php if ($islem == "liste") { ?>
	<?php require_once('includes/uyeler.php'); ?>
<?php } ?>
<?php if ($islem == "ekle") { ?>
	<?php require_once('includes/uye_ekle.php'); ?>
<?php } ?>
<?php if ($islem == "duzenle") { ?>
	<form action="" method="post" enctype="multipart/form-data">
		<?php
			$yoneticiler = mysql_query("SELECT * FROM yonetici where id = '$id'");
			while($y = mysql_fetch_array($yoneticiler)) {
		?>
		<section class="content">
			<?php
				$paket_sil = $_GET["paket_sil"];
				if ($paket_sil) {
					$uye_paket_sil = $vt->query("DELETE FROM magaza_uye_paket WHERE id = '$paket_sil'");
					if ($uye_paket_sil) {
						onay();
						echo "<br>";
						echo "<br>";
					}
				}
			?>
			<div class="row">
				<div class="col-md-12">
					<?php if (yetki() == 0): ?>
					<ul class="nav nav-title-a nav-justified nav-tabs">
						<li <?php if ($tab_goster == "uye_bilgileri" || $tab_goster == "") { ?> class="active" <?php } ?>>						
							<a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $id ?>&tab_goster=uye_bilgileri"><strong><i class="fa fa-chevron-right"></i>Üye Bilgileri</strong></a>
						</li>
						<li <?php if ($tab_goster == "ilanlari") { ?> class="active" <?php } ?>>
							<a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $id ?>&tab_goster=ilanlari"><strong><i class="fa fa-chevron-right"></i>İlanları</strong></a>
						</li>
						<?php if ($y["yetki"]==2) { ?>
						<li <?php if ($tab_goster == "danismanlari") { ?> class="active" <?php } ?>>
							<a href="<?php echo $_SERVER["REQUEST_URI"]; ?>&tab_goster=danismanlari"><strong><i class="fa fa-chevron-right"></i>Danışmanları</strong></a>
						</li>
						<?php } ?>
						<li <?php if ($tab_goster == "magaza_paketleri") { ?> class="active" <?php } ?>>
							<a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $id ?>&tab_goster=magaza_paketleri"><strong><i class="fa fa-chevron-right"></i>Üyelik Paketleri</strong></a>
						</li>
						<li <?php if ($tab_goster == "dopingleri") { ?> class="active" <?php } ?>>
							<a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $id ?>&tab_goster=dopingleri"><strong><i class="fa fa-chevron-right"></i>Dopingleri</strong></a>
						</li>
						<li <?php if ($tab_goster == "mesajlari") { ?> class="active" <?php } ?>>
							<a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $id ?>&tab_goster=mesajlari"><strong><i class="fa fa-chevron-right"></i>Mesajları</strong></a>
						</li>
					</ul>
					<?php endif; ?>
					<?php  if ($tab_goster == "uye_bilgileri" || $tab_goster == "") { ?>
						<?php require_once('includes/uyeligim.php'); ?>						
					<?php } ?>
					<?php  if ($tab_goster == "ilanlari") { ?>
						<?php require_once('includes/ilanlarim.php'); ?>						
					<?php } ?>
					<?php  if ($tab_goster == "danismanlari") { ?>
						<?php require_once('includes/danismanlarim.php'); ?>						
					<?php } ?>
					<?php  if ($tab_goster == "magaza_paketleri") { ?>
						<?php require_once('includes/paketlerim.php'); ?>						
					<?php } ?>
					<?php  if ($tab_goster == "dopingleri") { ?>
						<?php require_once('includes/dopinglerim.php'); ?>
					<?php } ?>
					<?php  if ($tab_goster == "mesajlari") { ?>
						<?php require_once('includes/mesajlarim.php'); ?>
					<?php } ?>
				</div>
			</div>
		</section>
	<?php } ?>
	</form>
<?php } ?>
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
	$(function () {   
	  	$('#example3').DataTable() 
	    $('#example4').DataTable({
	      'paging'      : true,
	      'lengthChange': false,
	      'searching'   : false,
	      'ordering'    : true,
	      'info'        : true,
	      'autoWidth'   : false
	    })
	  })
	$(function () {   
	  	$('#example5').DataTable() 
	    $('#example6').DataTable({
	      'paging'      : true,
	      'lengthChange': false,
	      'searching'   : false,
	      'ordering'    : true,
	      'info'        : true,
	      'autoWidth'   : false
	    })
	  })
	$(function () {   
	  	$('#example7').DataTable() 
	    $('#example8').DataTable({
	      'paging'      : true,
	      'lengthChange': false,
	      'searching'   : false,
	      'ordering'    : true,
	      'info'        : true,
	      'autoWidth'   : false
	    })
	  })
	$(function () {   
	  	$('#example9').DataTable() 
	    $('#example10').DataTable({
	      'paging'      : true,
	      'lengthChange': false,
	      'searching'   : false,
	      'ordering'    : true,
	      'info'        : true,
	      'autoWidth'   : false
	    })
	  })
	$(function () {   
	  	$('#example11').DataTable() 
	    $('#example12').DataTable({
	      'paging'      : true,
	      'lengthChange': false,
	      'searching'   : false,
	      'ordering'    : true,
	      'info'        : true,
	      'autoWidth'   : false
	    })
	  })
</script> 