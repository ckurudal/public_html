<?php
	$paket = $_GET["paket"];
	$paket_id = $_GET["paket_id"];
	$odeme_sayfasi = $_GET["odeme_sayfasi"];
	$fiyat = $_GET["fiyat"];
	$siparis = $_GET["siparis"];

	$magaza_paketleri = $vt->query("SELECT * FROM magaza_paket WHERE id ORDER BY sira ASC")->fetchAll(PDO::FETCH_ASSOC);
	$stmt_kullanici = $vt->prepare("SELECT * FROM yonetici WHERE id = ?");
	$stmt_kullanici->execute([$_SESSION["id"]]);
	$kullanici = $stmt_kullanici->fetch(PDO::FETCH_ASSOC);
	$paket_bilgi = $vt->query("SELECT * FROM magaza_paket WHERE id = '$paket_id'")->fetch(PDO::FETCH_ASSOC);
	$siparis_kod = $vt->query("SELECT * FROM siparis_magaza ORDER BY id DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);

?>
<?php if ($paket == "") { ?>
<div class="row" style="margin-top: 20px;">
	<div class="col-md-6">
		<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title"> <i class="fa fa-shopping-cart"></i> Üyelik Paketi Ekle </h3>
			</div>
			<div class="box-body">
				<div class="text-center">
					<p><i class="fa fa-shopping-cart fa-5x text-primary"></i></p>
					<h4 style="margin: 35px 0 65px 0;">Üyelik Paketi Ekleyin</h4>
					<a href="index.php?do=siparisler/siparisler&paket=magaza" class="btn btn-inverse btn-block">
						<p class="text-center"><i class="fa fa-check"></i> Sipariş Oluştur</p>
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title"> <i class="fa fa-rocket"></i> Doping Ekle </h3>
			</div>
			<div class="box-body">
				<div class="text-center">
					<p><i class="fa fa-rocket fa-5x text-primary"></i></p>
					<h4 style="margin: 35px 0 65px 0;">İlana Doping Ekleyin</h4>
					<a href="index.php?do=islem&emlak=emlak_ilanlar" class="btn btn-inverse btn-block">
						<p class="text-center"><i class="fa fa-check"></i> Sipariş Oluştur</p>
					</a>
				</div>
			</div>
		</div>
	</div>
	<!--
	<div class="col-md-4">
		<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title"> <i class="fa fa-user-o"></i> Danışman Paketi Ekle </h3>
			</div>
			<div class="box-body">
				<div class="text-center">
					<p><i class="fa fa-user-plus fa-5x text-primary"></i></p>
					<h4 style="margin: 35px 0 65px 0;">Danışman Paketi Ekleyin</h4>
					<a href="index.php?do=siparisler/siparisler&paket=danisman" class="btn btn-inverse btn-block">
						<p class="text-center"><i class="fa fa-check"></i> Sipariş Oluştur</p>
					</a>
				</div>
			</div>
		</div>
	</div>
	-->
</div>
<?php } ?>

<?php if ($paket == "magaza") { ?>
<?php if ($paket_id != true && $odeme_sayfasi != true && $siparis != true) { ?>
<form class="form" action="" method="post" multiple="multiple">

	<div class="box">
		<div class="box-body">

			<ul class="nav nav-pills nav-justified thumbnail setup-panel">

		        <li class="active">
		            <a href="#step-1">
		                <h4 class="list-group-item-heading">Paket Seçimi</h4>
		                <p class="list-group-item-text">Üyelik Paketini Seçiniz</p>
		            </a>
		    	</li>


		        <li class="disabled">
		        	<a href="#step-2">
		            	<h4 class="list-group-item-heading">Fiyat Seçimi</h4>
		            	<p class="list-group-item-text">Periyot ve fiyat seçiniz</p>
		    	    </a>
		    	</li>

		        <li class="disabled">
		        	<a href="#step-3">
		                <h4 class="list-group-item-heading">Ödeme</h4>
		                <p class="list-group-item-text">Ödemenizi Yapınız</p>
		            </a>
		        </li>

		        <li class="disabled">
		        	<a href="#step-4">
		            	<h4 class="list-group-item-heading">Sonuç</h4>
		            	<p class="list-group-item-text">Siparişi Tamamlayınız</p>
		    	    </a>
		    	</li>

		    </ul>

		    <div class="box">
			    <div class="box-header with-border">
			    	<section class="content-header">

						<i class="fa fa-dropbox fa-2x pull-left"></i>
						 Üyelik  Paketleri
						<p> <small> Paket Sipariş Seçimi </small> </p>

					</section>
			    </div>
			    <div class="box-body">

					<div class="row">

						<?php

							foreach ($magaza_paketleri as $paket) {

						?>
						<div class="col-md-3">
							<div class="box">
								<div class="box-header with-border">
									<h4 class="text-center"> <i class="fa fa-shopping-basket"></i> <strong><?php echo $paket["paket_adi"]; ?></strong></h4>
								</div>
								<div class="box-body">
									<p class="text-center">İlan Ekleme Limiti: <strong><?php echo $paket["aylik_limit"]; ?> Adet (Aylık)</strong></p class="text-center">

									<p class="text-center">İlan Başına Resim: <strong><?php echo $paket["resim_limit"]; ?> Adet</strong></p class="text-center">

									<p class="text-center">İlan Yayın Süresi: <strong><?php echo $paket["ilan_sure"]; ?> <?php echo $paket["ilan_sure_zaman"]; ?></strong></p class="text-center">

									<?php if (yetki() == 0 || yetki() == 2): ?>

									<p class="text-center">Danışman: <strong><?php echo $paket["danisman_limit"]; ?> Adet</strong></p class="text-center">

									<p class="text-center">İlanlara Danışman Atama</p>

									<?php endif; ?>

								</div>
								<div class="box-footer">
									<a href="index.php?do=siparisler/siparisler&paket=magaza&paket_id=<?php echo $paket["id"]; ?>" name="paket_ekle_<?php echo $paket["id"]; ?>" class="btn btn-lg btn-info btn-block"><strong>SEÇ VE DEVAM ET <i class="fa fa-arrow-right"></i></strong></a>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>

			    </div>
		    </div>

			<div class="alert alert-primary">
				<div class="row">
					<div class="col-md-1">
						<i class="fa fa-info-circle fa-5x"></i>
					</div>
					<div class="col-md-11">
						Üyelik paketi siparişi verin. Satın aldığınız paketin özelliklerini iyice kontrol etmeyi unutmayın. Üyelik paketi siparişlerinde geri iade bulunmamaktadır. Süresi dalan üyelik paketini yenilemek isterseniz. Eski üyelik paketini kaldırarak yeniden paket satın alabilirsiniz.
					</div>
				</div>
			</div>

		</div>
	</div>

</form>
<?php } ?>


<?php  if ($paket_id == true) { ?>

<?php

	if (isset($_POST["siparis_ekle"])) {

		$tutar_kur 					= veri("magaza_paket_periyot", "periyot_paket_id", $paket_id, "periyot_fiyat_kur");
		$uye_id						= $_POST["uye_id"];
		$odeme_yontemi				= $_POST["odeme_yontemi"];
		$siparis_no					= $_POST["siparis_no"];
		$durum						= $_POST["durum"];
		$siparis_notu				= $_POST["siparis_notu"];
		$aciklama					= $_POST["aciklama"];
		$siparis_tarihi				= date("Y-m-d");
		$tutar_id					= $_POST["tutar_id"];
		$tutar_bul 					= $vt->query("SELECT * FROM magaza_paket_periyot WHERE id = '$tutar_id'")->fetch(PDO::FETCH_ASSOC);
		$paket_bul 					= $vt->query("SELECT * FROM magaza_paket WHERE id = '".$tutar_bul["periyot_paket_id"]."'")->fetch(PDO::FETCH_ASSOC);
		$aylik_limit 				= $paket_bul["aylik_limit"];
		$resim_limit 				= $paket_bul["resim_limit"];
		$danisman_limit 			= $paket_bul["danisman_limit"];
		$ilan_sure 					= $paket_bul["ilan_sure"];
		$ilan_sure_zaman 			= $paket_bul["ilan_sure_zaman"];
		$tutar 						= $tutar_bul["periyot_fiyat"];

		if ($durum == 1) {
			$onay_tarihi 			= $siparis_tarihi;}
		if ($durum == 0) {
			$onay_tarihi 			= 0;
		}

		if (empty($uye_id)) {
			hata("HATA! LÜTFEN BİR ÜYE SEÇİNİZ.");
		} else if (empty($tutar_id)) {
			hata("HATA! LÜTFEN PERİYOT SEÇİNİZ.");
		} else {

			// siparislere ekle

			// $siparis_ekle=$vt->prepare("INSERT INTO siparis_magaza (uye_id, urun_id, siparis_no, odeme_yontemi, durum, siparis_notu, aciklama, siparis_tarihi, onay_tarihi, tutar, tutar_kur) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
	    	// $deger_siparis=$siparis_ekle->execute(array($uye_id, $paket_id, $siparis_no, $odeme_yontemi, $durum, $siparis_notu, $aciklama, $siparis_tarihi, $onay_tarihi, $tutar, $tutar_kur));

	    	// uyeye ekle

	    	$paket_adi 				= $paket_bilgi["paket_adi"];
	    	if ($durum == 1) {
	    	$baslangic_tarihi 		= $siparis_tarihi;
	    	} else {
	    	$baslangic_tarihi 		= 0;
	    	}
	    	$toplam_gun 			= $tutar_bul["periyot_sure"];
	    	$toplam_gun_zaman		= $tutar_bul["periyot_sure_zaman"];
	    	$toplam_paket_suresi	= toplam_sure($toplam_gun, $toplam_gun_zaman);
	    	$bitis_tarihi 			= bitis_tarihi($baslangic_tarihi, $toplam_paket_suresi);
	    	$kalan_paket_suresi		= kalan_sure($siparis_tarihi, $bitis_tarihi);

	    	echo $baslangic_tarihi;

	    	$uye_paket_ekle=$vt->prepare("INSERT INTO magaza_uye_paket (siparis_no, siparis_notu, aciklama, uye_id, paket_id, periyot_id, paket_adi, odeme_tipi, siparis_tarihi, onay, baslangic_tarihi, bitis_tarihi, fiyat, fiyat_kur, periyot_sure, periyot_sure_zaman, aylik_limit, resim_limit, danisman_limit, ilan_sure, ilan_sure_zaman) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
	    	$deger_uye_paket=$uye_paket_ekle->execute(array($siparis_no, $siparis_notu, $aciklama, $uye_id, $paket_id, $tutar_id, $paket_adi, $odeme_yontemi, $siparis_tarihi, $durum, $baslangic_tarihi, $bitis_tarihi, $tutar, $tutar_kur, $toplam_gun, $toplam_gun_zaman, $aylik_limit, $resim_limit, $danisman_limit, $ilan_sure, $ilan_sure_zaman));

	    	// go("index.php?do=siparisler/siparisler&tip=magaza&islem=onay", 0);

	    	yonetici_mail_bildir("Yeni üyelik paketi siparişi alındı. Lütfen kontrol ediniz.");

			yonetici_sms_bildir("Yeni üyelik paketi siparişi alındı. Lütfen kontrol ediniz.");

			go("index.php?do=siparisler/siparisler&paket=magaza&odeme_sayfasi=$siparis_no&fiyat=$tutar&paket=".$paket_bul['paket_adi']."", 0);

		}

		echo "<br>";



	}

?>

<form class="form" action="" method="post">

	<div class="box">

		<div class="box-body">

			<ul class="nav nav-pills nav-justified thumbnail setup-panel">

		        <li class="disabled">
		            <a href="#step-1">
		                <h5 class="list-group-item-heading">Paket Seçimi</h5>
		                <p class="list-group-item-text">Üyelik Paketini Seçiniz</p>
		            </a>
		    	</li>


		        <li class="active">
		        	<a href="#step-2">
		            	<h5 class="list-group-item-heading">Fiyat Seçimi</h5>
		            	<p class="list-group-item-text">Periyot ve fiyat seçiniz</p>
		    	    </a>
		    	</li>

		        <li class="disabled">
		        	<a href="#step-3">
		                <h5 class="list-group-item-heading">Ödeme</h5>
		                <p class="list-group-item-text">Ödemenizi Yapınız</p>
		            </a>
		        </li>

		        <li class="disabled">
		        	<a href="#step-4">
		            	<h5 class="list-group-item-heading">Sonuç</h5>
		            	<p class="list-group-item-text">Siparişi Tamamlayınız</p>
		    	    </a>
		    	</li>

		    </ul>

			<div class="row">
				<div class="col-md-12">
					<div class="box">
						<div class="box-header with-border">
						  <section class="content-header">

									<i class="fa fa-credit-card fa-2x pull-left"></i>
									 <?php echo $paket_bilgi["paket_adi"]; ?> Paket
									<p> <small> Fiyat ve Periyot Seçimi </small> </p>

							</section>
						</div>
						<div class="box-body">

								<div class="box">
									<div class="box-body" style="background:#eee;">
										<div class="row text-center">

											<?php
												$paket_periyot = $vt->query("SELECT * FROM magaza_paket_periyot WHERE periyot_paket_id = '".$paket_bilgi["id"]."'")->fetchAll(PDO::FETCH_ASSOC);
												foreach ($paket_periyot as $per) {

											?>

											<div class="col-md-3">

												<div class="box">
													<div class="box-header with-border text-center">

														<h4 style="color:#3c8dbc;"><strong><?php echo $per["periyot_sure"]; ?> <?php echo $per["periyot_sure_zaman"]; ?> </strong></h4>
														İlanlarınız <br><strong><?php echo $per["periyot_sure"]; ?> <?php echo $per["periyot_sure_zaman"]; ?></strong> Gösterilir
													</div>
													<div class="box-body bg-warning text-center">
														<h4><?php echo $per["periyot_fiyat"]; ?> <?php echo $per["periyot_fiyat_kur"]; ?></h4>
														<br>
														<p>Aylık <strong><?php echo $paket_bilgi["aylik_limit"]; ?></strong> Adet İlan</p>
														<p><?php echo $paket_bilgi["resim_limit"]; ?> İlan Resmi</p>

														<?php if (yetki() == 0 || yetki() == 2): ?>

														<p><?php echo $paket_bilgi["danisman_limit"]; ?> Adet Danışman</p>

														<?php endif; ?>

														<br>

														<label for="tutar_id" class="btn btn-primary btn-block">
														  <input type="radio" name="tutar_id" value="<?php echo $per["id"]; ?>" class="minimal">
														  Paketi Seç
														</label>

													</div>
												</div>

											</div>

											<?php } ?>

										</div>

										<div class="col-md-6">

											<h5><a href="index.php?do=siparisler/siparisler&paket=magaza"><< Önceki Adıma Geri Dön</a></h5>

										</div>
										<div class="col-md-6">
											<div class="form-group pull-right">
												<button class="btn btn-success btn-block" name="siparis_ekle"><strong>DEVAM ET <i class="fa fa-arrow-right"></i></strong></button>
											</div>
										</div>

									</div>
								</div>

								<div class="box <?php if(yetki() != 0): ?>hidden<?php endif; ?>">
									<div class="box-body">
										<div class="row">

											<?php if ($kullanici["yetki"] == "0") { ?>

											<div class="col-md-3">
												<div class="form-group">
													<label class="control-label"> Üye Seçiniz </label>
													<select class="form-control select2" name="uye_id" >
														<option value=""> Seçiniz </option>
														<?php
															$tum_uyeler = $vt->query("SELECT * FROM yonetici WHERE id AND yetki != '0'")->fetchAll(PDO::FETCH_ASSOC);
															foreach ($tum_uyeler as $uye) {

														?>
														<option value="<?php echo $uye["id"]; ?>"> <?php echo $uye["adsoyad"]; ?> </option>
														<?php } ?>
													</select>
												</div>
											</div>

											<?php } else { ?>

											<div class="col-md-3">
												<div class="form-group">
													<label class="control-label"> Üye Seçiniz </label>
													<input type="text" name="uye_id" class="form-control hidden" value="<?php echo $_SESSION["id"]; ?>">
													<input type="text" name="uye_id" class="form-control" disabled="" value="<?php echo $kullanici["adsoyad"]; ?>">
												</div>
											</div>

											<?php } ?>

											<div class="col-md-3">
												<div class="form-group">
													<?php
														$odeme_tipi = $vt->query("SELECT * FROM odeme_tipi WHERE durum = '0'")->fetchAll();
														$odeme_tipi_ver = $vt->query("SELECT * FROM odeme_tipi WHERE durum = '0'")->fetch();
													?>
													<label class="control-label"> Ödeme Yöntemi </label>
													<select class="form-control select2" name="odeme_yontemi">
														<?php
															foreach ($odeme_tipi as $odeme) {
														?>
														<option value="<?php echo $odeme["adi"]; ?>"><?php echo $odeme["adi"]; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>

											<div class="col-md-3 <?php if ($kullanici["yetki"] != "0") { ?> hidden <?php } ?>">
												<div class="form-group">
													<label class="control-label"> Durumu <small>[Bu alan zozunludur.]</small></label>
													<select class="form-control select2" name="durum">
														<option value="0"> Seçiniz </option>
														<option value="1"> Onaylandı </option>
														<option value="0"> Pasif </option>
													</select>
												</div>
											</div>

											<div class="<?php if ($kullanici["yetki"] == "0") { ?> col-md-3 <?php } else { ?> col-md-6  <?php } ?>">
												<?php
													$siparis_kod = $vt->query("SELECT * FROM siparis_magaza ORDER BY id DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
												?>
												<div class="form-group">
													<?php $siparis_numarasi = uniqid('MGZ'); ?>
													<label class="control-label"> Sipariş No </label>
													<input type="text" name="siparis_no" class="form-control" disabled value="<?php echo $siparis_numarasi; ?>">
													<input type="text" name="siparis_no" class="form-control hidden" value="<?php echo $siparis_numarasi; ?>">
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label"> Açıklama <small>[Zorunlu Değil]</small></label>
													<textarea class="form-control" placeholder="Açıklama" name="aciklama" rows="7"></textarea>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label"> Sipariş Notu <small>[Zorunlu Değil]</small></label>
													<textarea class="form-control" placeholder="Sipariş İçin Notlarınız" name="siparis_notu" rows="7"></textarea>
												</div>
											</div>

										</div>
									</div>
								</div>

						</div>
					</div>

					<div class="alert alert-primary">
						<div class="row">
							<div class="col-md-1">
								<i class="fa fa-info-circle fa-5x"></i>
							</div>
							<div class="col-md-11">
								Üyelik paketi siparişi verin. Satın aldığınız paketin özelliklerini iyice kontrol etmeyi unutmayın. Üyelik paketi siparişlerinde geri iade bulunmamaktadır. Süresi dalan üyelik paketini yenilemek isterseniz. Eski üyelik paketini kaldırarak yeniden paket satın alabilirsiniz.
							</div>
						</div>
					</div>

				</div>
				<div class="col-md-3 hidden">
					<div class="box">
						<div class="box-header with-border">
							<h4 class="text-center"> <i class="fa fa-shopping-basket"></i> <strong><?php echo $paket_bilgi["paket_adi"]; ?></strong></h4>
						</div>
						<div class="box-body bg-warning">
							<p class="text-center">İlan Ekleme Limiti: <strong><?php echo $paket_bilgi["aylik_limit"]; ?> Adet (Aylık)</strong></p class="text-center">

							<p class="text-center">İlan Başına Resim: <strong><?php echo $paket_bilgi["resim_limit"]; ?> Adet</strong></p class="text-center">

							<p class="text-center">İlan Yayın Süresi: <strong><?php echo $paket_bilgi["ilan_sure"]; ?> <?php echo $paket_bilgi["ilan_sure_zaman"]; ?></strong></p class="text-center">

							<p class="text-center">Danışman: <strong><?php echo $paket_bilgi["danisman_limit"]; ?> Adet</strong></p class="text-center">

							<p class="text-center">Özel Firma Profil Sayfası</p class="text-center">

							<p class="text-center">İlanlara Danışman Atama</p class="text-center">

						</div>
						<div class="box-footer">
							<button type="submit" class="btn btn-success btn-lg btn-block" name="siparis_ekle"> <i class="fa fa-check"></i> <strong> SİPARİŞİ EKLE </strong> </button>
						</div>
					</div>
				</div>
			</div>

		</div>

	</div>

</form>

<?php } ?>


<?php } ?>



<?php if ($odeme_sayfasi == true) { ?>

<form class="form" action="" method="post">

	<div class="box">

		<div class="box-body">

			<ul class="nav nav-pills nav-justified thumbnail setup-panel">

		        <li class="disabled">
		            <a href="#step-1">
		                <h4 class="list-group-item-heading">Paket Seçimi</h4>
		                <p class="list-group-item-text">Üyelik Paketini Seçiniz</p>
		            </a>
		    	</li>


		        <li class="disabled">
		        	<a href="#step-2">
		            	<h4 class="list-group-item-heading">Fiyat Seçimi</h4>
		            	<p class="list-group-item-text">Periyot ve fiyat seçiniz</p>
		    	    </a>
		    	</li>

		        <li class="active">
		        	<a href="#step-3">
		                <h4 class="list-group-item-heading">Ödeme</h4>
		                <p class="list-group-item-text">Ödemenizi Yapınız</p>
		            </a>
		        </li>

		        <li class="disabled">
		        	<a href="#step-4">
		            	<h4 class="list-group-item-heading">Sonuç</h4>
		            	<p class="list-group-item-text">Siparişi Tamamlayınız</p>
		    	    </a>
		    	</li>

		    </ul>

			<div class="box">
			    <div class="box-header with-border">

			    	<section class="content-header">

						<i class="fa fa-credit-card fa-2x pull-left"></i>

						Üyelik Paketi Ödeme

						<p> <small> Güvenli Ödemenizi Yapın </small> </p>

					</section>

			    </div>

				<?php
					$stmt_uye_odeme = $vt->prepare("SELECT * FROM yonetici WHERE id = ?");
					$stmt_uye_odeme->execute([$_SESSION["id"]]);
					$uye=$stmt_uye_odeme->fetch();
				?>

				<div style="width: 100%;margin: 0 auto;display: table;">

					<?php if ($kullanici["tel"] == ""): ?>

						<div class="alert alert-danger text-center">
							<h5> <i class="fa fa-mobile-phone fa-5x"></i> </h5>
							<h2>Hata(!) <br></h2>
							<br>
							<h4>Telefon numaranız olmadan ödeme yapamazsınız. Lütfen telefon numaranızı ekleyiniz.</h4>
							<br>
							<a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>" class="btn btn-default btn-lg"> <i class="fa fa-arrow-left"></i> Telefon Ekle </a>
							<br>
							<br>
							<br>
						</div>

					<?php else: ?>

					<?php

					## 1. ADIM için örnek kodlar ##

					####################### DÜZENLEMESİ ZORUNLU ALANLAR #######################
					#
					## API Entegrasyon Bilgileri - Mağaza paneline giriş yaparak BİLGİ sayfasından alabilirsiniz.
					$merchant_id 	= $paytr_api["merchant_id"];
					$merchant_key 	= $paytr_api["merchant_key"];
					$merchant_salt	= $paytr_api["merchant_salt"];
					#
					## Müşterinizin sitenizde kayıtlı veya form vasıtasıyla aldığınız eposta adresi
					$email = $uye["email"];
					#
					## Tahsil edilecek tutar.
					$payment_amount	= $fiyat * 100; //9.99 için 9.99 * 100 = 999 gönderilmelidir.
					#
					## Sipariş numarası: Her işlemde benzersiz olmalıdır!! Bu bilgi bildirim sayfanıza yapılacak bildirimde geri gönderilir.
					$merchant_oid = $odeme_sayfasi;
					#
					## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız ad ve soyad bilgisi
					$user_name = $uye["adsoyad"];
					#
					## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız adres bilgisi
					$user_address = $uye["email"];
					#
					## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız telefon bilgisi
					$user_phone = $uye["tel"];
					#
					## Başarılı ödeme sonrası müşterinizin yönlendirileceği sayfa
					## !!! Bu sayfa siparişi onaylayacağınız sayfa değildir! Yalnızca müşterinizi bilgilendireceğiniz sayfadır!
					## !!! Siparişi onaylayacağız sayfa "Bildirim URL" sayfasıdır (Bakınız: 2.ADIM Klasörü).
					$merchant_ok_url = $paytr_api["bildirim_url"]."?odeme_sayfasi=".$odeme_sayfasi."&gelen=magaza";
					#
					## Ödeme sürecinde beklenmedik bir hata oluşması durumunda müşterinizin yönlendirileceği sayfa
					## !!! Bu sayfa siparişi iptal edeceğiniz sayfa değildir! Yalnızca müşterinizi bilgilendireceğiniz sayfadır!
					## !!! Siparişi iptal edeceğiniz sayfa "Bildirim URL" sayfasıdır (Bakınız: 2.ADIM Klasörü).
					$merchant_fail_url = $paytr_api["hata_url"];
					#
					## Müşterinin sepet/sipariş içeriği
					## $user_basket = "Mağaza Paketi";
					#
					/* ÖRNEK $user_basket oluşturma - Ürün adedine göre array'leri çoğaltabilirsiniz
					$user_basket = base64_encode(json_encode(array(
						array("Örnek ürün 1", "18.00", 1), // 1. ürün (Ürün Ad - Birim Fiyat - Adet )
						array("Örnek ürün 2", "33.25", 2), // 2. ürün (Ürün Ad - Birim Fiyat - Adet )
						array("Örnek ürün 3", "45.42", 1)  // 3. ürün (Ürün Ad - Birim Fiyat - Adet )
					)));
					*/

					$user_basket = base64_encode(json_encode(array(
						array($paket, $fiyat, 1), // 1. ürün (Ürün Ad - Birim Fiyat - Adet )
					)));

					############################################################################################

					## Kullanıcının IP adresi
					if( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
						$ip = $_SERVER["HTTP_CLIENT_IP"];
					} elseif( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
						$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
					} else {
						$ip = $_SERVER["REMOTE_ADDR"];
					}

					## !!! Eğer bu örnek kodu sunucuda değil local makinanızda çalıştırıyorsanız
					## buraya dış ip adresinizi (https://www.whatismyip.com/) yazmalısınız. Aksi halde geçersiz paytr_token hatası alırsınız.
					$user_ip=$ip;
					##

					## İşlem zaman aşımı süresi - dakika cinsinden
					$timeout_limit = "30";

					## Hata mesajlarının ekrana basılması için entegrasyon ve test sürecinde 1 olarak bırakın. Daha sonra 0 yapabilirsiniz.
					$debug_on = 1;

					## Mağaza canlı modda iken test işlem yapmak için 1 olarak gönderilebilir.
					$test_mode = 0;

					$no_installment	= 0; // Taksit yapılmasını istemiyorsanız, sadece tek çekim sunacaksanız 1 yapın

					## Sayfada görüntülenecek taksit adedini sınırlamak istiyorsanız uygun şekilde değiştirin.
					## Sıfır (0) gönderilmesi durumunda yürürlükteki en fazla izin verilen taksit geçerli olur.
					$max_installment = 0;

					$currency = "TL";

					####### Bu kısımda herhangi bir değişiklik yapmanıza gerek yoktur. #######
					$hash_str = $merchant_id .$user_ip .$merchant_oid .$email .$payment_amount .$user_basket.$no_installment.$max_installment.$currency.$test_mode;
					$paytr_token=base64_encode(hash_hmac('sha256',$hash_str.$merchant_salt,$merchant_key,true));
					$post_vals=array(
							'merchant_id'=>$merchant_id,
							'user_ip'=>$user_ip,
							'merchant_oid'=>$merchant_oid,
							'email'=>$email,
							'payment_amount'=>$payment_amount,
							'paytr_token'=>$paytr_token,
							'user_basket'=>$user_basket,
							'debug_on'=>$debug_on,
							'no_installment'=>$no_installment,
							'max_installment'=>$max_installment,
							'user_name'=>$user_name,
							'user_address'=>$user_address,
							'user_phone'=>$user_phone,
							'merchant_ok_url'=>$merchant_ok_url,
							'merchant_fail_url'=>$merchant_fail_url,
							'timeout_limit'=>$timeout_limit,
							'currency'=>$currency,
							'test_mode'=>$test_mode
						);

					$ch=curl_init();
					curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_POST, 1) ;
					curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
					curl_setopt($ch, CURLOPT_TIMEOUT, 20);
					$result = @curl_exec($ch);

					if(curl_errno($ch))
						die("PAYTR IFRAME connection error. err:".curl_error($ch));

					curl_close($ch);

					$result=json_decode($result,1);

					if($result['status']=='success')
						$token=$result['token'];
					else
						die("PAYTR IFRAME failed. reason:".$result['reason']);
					#########################################################################

					?>

					<!-- Ödeme formunun açılması için gereken HTML kodlar / Başlangıç -->
					<script src="https://www.paytr.com/js/iframeResizer.min.js"></script>
					<iframe src="https://www.paytr.com/odeme/guvenli/<?php echo $token;?>" id="paytriframe" frameborder="0" scrolling="no" style="width: 100%;"></iframe>
					<script>iFrameResize({},'#paytriframe');</script>
					<!-- Ödeme formunun açılması için gereken HTML kodlar / Bitiş -->

					<?php endif; ?>

				</div>

			</div>
		</div>
	</div>

</form>

<?php } ?>

<?php if ($siparis == "hata") { ?>
Hata
<?php } ?>
<?php if ($siparis == "onay") { ?>

	<div class="box">
		<div class="box-body">

			<ul class="nav nav-pills nav-justified thumbnail setup-panel">

		        <li class="disabled">
		            <a href="#step-1">
		                <h4 class="list-group-item-heading">Paket Seçimi</h4>
		                <p class="list-group-item-text">Üyelik Paketini Seçiniz</p>
		            </a>
		    	</li>


		        <li class="disabled">
		        	<a href="#step-2">
		            	<h4 class="list-group-item-heading">Fiyat Seçimi</h4>
		            	<p class="list-group-item-text">Periyot ve fiyat seçiniz</p>
		    	    </a>
		    	</li>

		        <li class="disabled">
		        	<a href="#step-3">
		                <h4 class="list-group-item-heading">Ödeme</h4>
		                <p class="list-group-item-text">Ödemenizi Yapınız</p>
		            </a>
		        </li>

		        <li class="active">
		        	<a href="#step-4">
		            	<h4 class="list-group-item-heading">Sonuç</h4>
		            	<p class="list-group-item-text">Siparişi Tamamlayınız</p>
		    	    </a>
		    	</li>

		    </ul>
			<div class="box">
			    <div class="box-header with-border">

			    	<section class="content-header">

						<i class="fa fa-credit-card fa-2x pull-left"></i>

						Sipariş Tamamlandı

						<p> <small> Paket Satın Alındı </small> </p>

					</section>

			    </div>

				<div class="box-body">

					<div class="well text-center">

						<br><br><br>

						<i class="fa fa-check fa-5x"></i>

						<br><br><br>

						<h4>Tebrikler, Üyelik Paketiniz Başarılı Bir Şekilde Satın Alınmıştır.</h4>

						<br><br><br>

						<a class="btn btn-success" href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>&tab_goster=magaza_paketleri">Üyelik Paketlerinizi İnceleyin</a>

						<br><br><br>

					</div>

				</div>


			</div>
		</div>
	</div>
<?php } ?>

<?php if ($paket == "doping") { ?>
Doping
<?php } ?>

<?php if ($paket == "danisman") { ?>
Danışman
<?php } ?>

<script type="text/javascript">
	$(document).ready(function() {

	    var navListItems = $('ul.setup-panel li a'),
	        allWells = $('.setup-content');

	    allWells.hide();

	    navListItems.click(function(e)
	    {
	        e.preventDefault();
	        var $target = $($(this).attr('href')),
	            $item = $(this).closest('li');

	        if (!$item.hasClass('disabled')) {
	            navListItems.closest('li').removeClass('active');
	            $item.addClass('active');
	            allWells.hide();
	            $target.show();
	        }
	    });

	    $('ul.setup-panel li.active a').trigger('click');

	    // DEMO ONLY //
	    $('#activate-step-2').on('click', function(e) {
	        $('ul.setup-panel li:eq(1)').removeClass('disabled');
	        $('ul.setup-panel li a[href="#step-2"]').trigger('click');
	        $(this).remove();
	    })
	});


</script>