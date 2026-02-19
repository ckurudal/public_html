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
	$stmt_yonetici = $vt->prepare("SELECT * FROM yonetici where id = ?");
	$stmt_yonetici->execute([$id]);
	$yonetici = $stmt_yonetici;
	$stmt_sube_bul = $vt->prepare("SELECT * FROM subeler WHERE yetkiliuye = ?");
	$stmt_sube_bul->execute([$_SESSION["id"]]);
	$sube_bul = $stmt_sube_bul->fetch();
	$stmt_uye_yasak = $vt->prepare("SELECT * FROM yonetici WHERE id = ?");
	$stmt_uye_yasak->execute([$_SESSION["id"]]);
	$uye_yasak = $stmt_uye_yasak->fetch();
	if ($uye == "bireysel") {
		$yoneticiliste = $vt->query("SELECT * FROM yonetici where yetki = 1 order by id desc");
	} else if ($uye == "kurumsal") {
		$yoneticiliste = $vt->query("SELECT * FROM yonetici where yetki = 2 order by id desc");
	} else if ($uye == "yonetici") {
		$yoneticiliste = $vt->query("SELECT * FROM yonetici where yetki = 0 order by id desc");
	} else if ($uye == "danisman") {
		$yoneticiliste = $vt->query("SELECT * FROM yonetici where yetki = 3 order by id desc");
	} else if ($emlakofisi == true) {
		$stmt_yl = $vt->prepare("SELECT * FROM yonetici where yetki = 3 AND ofis = ? order by id desc");
		$stmt_yl->execute([$emlakofisi]);
		$yoneticiliste = $stmt_yl;
	} else if ($islem == "liste") {
		$yoneticiliste = $vt->query("SELECT * FROM yonetici where id");
	} else {
		$yoneticiliste = $vt->query("SELECT * FROM yonetici where yetki = 3 order by id desc");
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
				$stmt_uye_id = $vt->prepare("SELECT * FROM yonetici WHERE id = ?");
				$stmt_uye_id->execute([$id]);
				$uye_id = $stmt_uye_id->fetch();
				$stmt_varmi_tel = $vt->prepare("SELECT * FROM yonetici where id != ? AND tel=?");
				$stmt_varmi_tel->execute([$id, $tel]);
				$varmi_tel = $stmt_varmi_tel->rowCount();
				$stmt_varmi_mail = $vt->prepare("SELECT * FROM yonetici where id != ? AND email=?");
				$stmt_varmi_mail->execute([$id, $email]);
				$varmi_mail = $stmt_varmi_mail->rowCount();
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
								$stmt_ye1 = $vt->prepare("INSERT INTO yonetici (adsoyad, ofis, seo, pass, email, tel, fax, gsm, unvan, eposta_bildirim, sms_bildirim, sira, aciklama, yetki, aylik_limit, resim_limit, ilan_sure, ilan_sure_zaman) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
								$yoneticiekle = $stmt_ye1->execute([$adsoyad, $sube_bul["id"], $seo, $pass, $email, $tel, $fax, $gsm, $unvan, $eposta_bildirim, $sms_bildirim, $sira, $aciklama, $yetki, $aylik_limit, $resim_limit, $ilan_sure, $ilan_sure_zaman]);
							} else { 
								$stmt_ye2 = $vt->prepare("INSERT INTO yonetici (adsoyad, seo, pass, email, tel, fax, gsm, unvan, eposta_bildirim, sms_bildirim, sira, aciklama, yetki, aylik_limit, resim_limit, ilan_sure, ilan_sure_zaman) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
								$yoneticiekle = $stmt_ye2->execute([$adsoyad, $seo, $pass, $email, $tel, $fax, $gsm, $unvan, $eposta_bildirim, $sms_bildirim, $sira, $aciklama, $yetki, $aylik_limit, $resim_limit, $ilan_sure, $ilan_sure_zaman]);
							}		
						}
					}		
					$stmt_ids_email = $vt->prepare("SELECT * FROM yonetici where email = ?");
					$stmt_ids_email->execute([$email]);
					$id = $stmt_ids_email->fetch();
					if (isset($_POST["yoneticieklekurumsal"])) {
						$uyekurumsal = $vt->query("SELECT * FROM yonetici order by id desc limit 1");
						$uk = $uyekurumsal->fetch();
						$stmt_firmaekle = $vt->prepare("INSERT INTO subeler (adi, yetkiliuye, seo, firmaunvan, vergino, vergidairesi) values (?,?,?,?,?,?)");
						$stmt_firmaekle->execute([$firmadi, $uk["id"], $firmadiseo, $firmaunvan, $vergino, $vergidairesi]);
						$stmt_sube_bagla2 = $vt->prepare("SELECT * FROM subeler WHERE yetkiliuye = ?");
						$stmt_sube_bagla2->execute([$uk["id"]]);
						$sube_bagla = $stmt_sube_bagla2->fetch();
						$stmt_sube_ata = $vt->prepare("UPDATE yonetici SET ofis = ?, sube = ? WHERE id = ?");
						$stmt_sube_ata->execute([$sube_bagla["id"], $sube_bagla["adi"], $uk["id"]]);
					}
					// sosyal medya bilgileri
					for ($i=0; $i < count($sosyalid) ; $i++) {
						$stmt_sosyal = $vt->prepare("INSERT INTO yonetici_sosyal (yoneticiid, sosyalid, sosyallink, baslik) VALUES (?,?,?,?)");
$stmt_sosyal->execute([$id["id"], $sosyalid[$i], $sosyallink[$i], $sosyalbaslik[$i]]);
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
										$stmt_ids_em2 = $vt->prepare("SELECT * FROM yonetici where email = ?");
										$stmt_ids_em2->execute([$email]);
										$id = $stmt_ids_em2->fetch();
										$link = "uploads/resim/".$saat.".jpg";
										$stmt_ekle = $vt->prepare("UPDATE yonetici SET resim = ? where id = ?");
										$stmt_ekle->execute([$link, $id["id"]]);
										$yuklenenler++;
									}
								} else {
									$yuklenmeyenler++;
								}
							}
						}
						$stmt_ids_kadi = $vt->prepare("SELECT * FROM yonetici where kadi = ?");
						$stmt_ids_kadi->execute([$kadi]);
						$id = $stmt_ids_kadi->fetch();
						$sonyeler = $vt->query("SELECT * FROM yonetici order by id desc limit 1");
						$sonuye = $sonyeler->fetch();
						if (yetki() == 0) {go("index.php?do=islem&ofis=yonetici&islem=liste&uye=yonetici&hareket=onay",0);}
						if (yetki() == 1) {go("index.php?do=islem&ofis=yonetici&islem=liste&uye=bireysel&hareket=onay",0);}
						if (yetki() == 2) {go("index.php?do=islem&ofis=yonetici&islem=duzenle&id={$_SESSION["id"]}&tab_goster=magaza_paketleri&tab_goster=danismanlari",0);}
						if (yetki() == 3) {go("index.php?do=islem&ofis=yonetici&islem=liste&uye=danisman&hareket=onay",0);} 
					}
				}
			}
			if (isset($_POST["yoneticikaydet"])) {
				$stmt_uye_id2 = $vt->prepare("SELECT * FROM yonetici WHERE id = ?");
				$stmt_uye_id2->execute([$id]);
				$uye_id = $stmt_uye_id2->fetch();
				$stmt_varmi2 = $vt->prepare("SELECT * FROM yonetici where id != ? AND tel=?");
				$stmt_varmi2->execute([$id, $tel]);
				$varmi = $stmt_varmi2->rowCount();
				if (empty($tel)) {
					hata_alert("lütfen geçerli bir telefon giriniz.");
				} else {				
					if($varmi!=0) {
						hata_alert("Telefon numarası başka bir kullanıcıda kayıtlı, lütfen farklı bilgiler giriniz.");
					} else {
						if (yetki() == 0) {
						$stmt_yk1 = $vt->prepare("UPDATE yonetici SET adsoyad = ?, seo = ?, tel = ?, fax = ?, gsm = ?, unvan = ?, eposta_bildirim = ?, sms_bildirim = ?, sira = ?, yetki = ?, aciklama = ?, aylik_limit = ?, resim_limit = ?, ilan_sure = ?, ilan_sure_zaman = ? WHERE id = ?");
						$yoneticikaydet = $stmt_yk1->execute([$adsoyad, $seo, $tel, $fax, $gsm, $unvan, $eposta_bildirim, $sms_bildirim, $sira, $yetki, $aciklama, $aylik_limit, $resim_limit, $ilan_sure, $ilan_sure_zaman, $id]);
						} else {
						$stmt_yk2 = $vt->prepare("UPDATE yonetici SET adsoyad = ?, seo = ?, tel = ?, fax = ?, gsm = ?, unvan = ?, eposta_bildirim = ?, sms_bildirim = ?, sira = ?, aciklama = ?, aylik_limit = ?, resim_limit = ?, ilan_sure = ?, ilan_sure_zaman = ? WHERE id = ?");
						$yoneticikaydet = $stmt_yk2->execute([$adsoyad, $seo, $tel, $fax, $gsm, $unvan, $eposta_bildirim, $sms_bildirim, $sira, $aciklama, $aylik_limit, $resim_limit, $ilan_sure, $ilan_sure_zaman, $id]);
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
								$stmt_resimal = $vt->prepare("SELECT * FROM yonetici where id = ?");
								$stmt_resimal->execute([$id]);
								$ral = $stmt_resimal->fetch();
									unlink("../".$ral['resim']);
									$link = "uploads/resim/".$saat.".jpg";
								$stmt_ekle2 = $vt->prepare("UPDATE yonetici SET resim = ? where id = ?");
								$stmt_ekle2->execute([$link, $id]);
									$yuklenenler++;
								}
							} else {
								$yuklenmeyenler++;
							}
						}
					}
					$stmt_silsosyal = $vt->prepare("DELETE FROM yonetici_sosyal where yoneticiid = ?");
					$stmt_silsosyal->execute([$id]);
					for ($i=0; $i < count($sosyalid) ; $i++) {
						$stmt_sosyal2 = $vt->prepare("INSERT INTO yonetici_sosyal (yoneticiid, sosyalid, sosyallink, baslik) VALUES (?,?,?,?)");
						$stmt_sosyal2->execute([$id, $sosyalid[$i], $sosyallink[$i], $sosyalbaslik[$i]]);
					}
					$stmt_yetkikontrol = $vt->prepare("SELECT * FROM yonetici where id = ?");
					$stmt_yetkikontrol->execute([$id]);
					$kontrol = $stmt_yetkikontrol->fetch();
					if ($kontrol["yetki"] == 1) {
						$stmt_ofissil = $vt->prepare("UPDATE yonetici SET ofis = '0' where id = ?");
						$stmt_ofissil->execute([$id]);
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
			$stmt_yoneticiler = $vt->prepare("SELECT * FROM yonetici where id = ?");
			$stmt_yoneticiler->execute([$id]);
			$yoneticiler = $stmt_yoneticiler;
			while($y = $yoneticiler->fetch()) {
		?>
		<section class="content">
			<?php
				$paket_sil = $_GET["paket_sil"];
				if ($paket_sil) {
					$stmt_paket_sil = $vt->prepare("DELETE FROM magaza_uye_paket WHERE id = ?");
					$uye_paket_sil = $stmt_paket_sil->execute([$paket_sil]);
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