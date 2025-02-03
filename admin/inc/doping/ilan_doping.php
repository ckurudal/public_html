<?php

	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;

	$islem = $_GET["islem"];
	$ilan_id = $_GET["ilan_id"];
	$hareket = $_GET["hareket"];

	$emlak 						= $vt->query("SELECT * FROM emlak_ilan WHERE id = '$ilan_id'")->fetch(PDO::FETCH_OBJ);
	$resim 						= $vt->query("SELECT * FROM emlak_resim WHERE emlakno = '$emlak->emlakno' AND kapak = 1")->fetch(PDO::FETCH_OBJ);
	$kategori					= $vt->query("SELECT * FROM emlak_kategori WHERE kat_id = '$emlak->katid' AND kat_durum = 1")->fetch(PDO::FETCH_OBJ);
	$sahibi	 					= $vt->query("SELECT * FROM yonetici WHERE id = '$emlak->yonetici_id' AND durum = 0")->fetch(PDO::FETCH_OBJ);
	$doping_paketi	 			= $vt->query("SELECT * FROM doping_paketleri WHERE id")->fetchAll(PDO::FETCH_OBJ);
	$siparis_kod_no = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '$ilan_id'")->fetch();


	$ilan_dopingleri = $vt->prepare("SELECT * FROM doping_ilanlari WHERE ilan_id = '$ilan_id'");
	$ilan_dopingleri->execute();
	$doping_say = $ilan_dopingleri->rowCount();
	$doping_say = $ilan_dopingleri->rowCount();

	$tarih = date('Y-m-d');

?>

<section class="content-header">

		<i class="fa fa-bell-o fa-2x pull-left"></i>

		İlan Dopingleri

		<p> <small> Dopingli İlanlar </small> </p>

</section>

<?php	if ($islem == "onay") { ?>

	<section class="content">

		<?php onay(); ?>

	</section>

<?php } ?>

<?php

	if (isset($_POST["ayar_kaydet"])) {

		$d_id 			= $_POST["d_id"];
		$sure 			= $_POST["sure"];
		$sure_zaman 	= $_POST["sure_zaman"];
		$fiyat 			= $_POST["fiyat"];


		for ($i=0; $i < count($d_id); $i++) {

			$sure_toplam 	= toplam_sure($sure[$i], $sure_zaman[$i]);
			$bitis_tarihi 	= bitis_tarihi($tarih, $sure_toplam);

			echo "<br>";

			$duzenle = $vt->query("UPDATE doping_ilanlari SET sure = '$sure[$i]', sure_zaman = '$sure_zaman[$i]', fiyat = '$fiyat[$i]', bitis_tarihi = '$bitis_tarihi' WHERE id = '$d_id[$i]'");

		}
        go("index.php?do=doping/ilan_doping&ilan_id=".$ilan_id."&islem=onay",0);

    }

?>

<?php
	if ($islem == "doping_onay") {

		if ($hareket == 0) {$onay = 0;}
		if ($hareket == 1) {$onay = 1;}

		$onayla = $vt->query("UPDATE emlak_ilan SET doping_onay = '$onay' WHERE id = '$ilan_id'");

		go("index.php?do=doping/ilan_doping&ilan_id=".$ilan_id."&islem=onay",0);

	}
?>
<style>
	td h5 {
		 margin-top: inherit !important;
	}
</style>
<form class="form" action="" method="post">


<?php if (isset($_POST["doping_sil"])) { ?>

	<section class="content">

	<?php
		$ilan_doping_sil = $vt->query("UPDATE emlak_ilan SET doping = 'yok' WHERE id = '$ilan_id'");
		$doping_sil = $vt->query("DELETE FROM doping_ilanlari WHERE ilan_id = '$ilan_id'");
		go("index.php?do=doping/ilan_doping&ilan_id={$ilan_id}&islem=onay",0);
	?>

	</section>

<?php } ?>

	<section class="content">
			<div class="row">
			<?php echo $yetki; ?>
				<?php if (yetki() == 0) { ?> <div class="col-md-12"> <?php } else { ?> <div class="col-md-12"> <?php } ?>

					<?php

						// SAYMA ISLEMLERI

						$kontrol_say_1 = $vt->prepare("SELECT * FROM doping_ilanlari WHERE doping_adi = 'sicak_firsat' AND ilan_id = '$ilan_id'");
						$kontrol_say_1->execute();
						$say_1 = $kontrol_say_1->rowCount();

						$kontrol_say_2 = $vt->prepare("SELECT * FROM doping_ilanlari WHERE doping_adi = 'vitrin_ilan' AND ilan_id = '$ilan_id'");
						$kontrol_say_2->execute();
						$say_2 = $kontrol_say_2->rowCount();

						$kontrol_say_3 = $vt->prepare("SELECT * FROM doping_ilanlari WHERE doping_adi = 'one_cikan' AND ilan_id = '$ilan_id'");
						$kontrol_say_3->execute();
						$say_3 = $kontrol_say_3->rowCount();

						$kontrol_say_4 = $vt->prepare("SELECT * FROM doping_ilanlari WHERE doping_adi = 'ust_sira' AND ilan_id = '$ilan_id'");
						$kontrol_say_4->execute();
						$say_4 = $kontrol_say_4->rowCount();

						$kontrol_say_5 = $vt->prepare("SELECT * FROM doping_ilanlari WHERE doping_adi = 'renkli_bold' AND ilan_id = '$ilan_id'");
						$kontrol_say_5->execute();
						$say_5 = $kontrol_say_5->rowCount();

						$kontrol_say_6 = $vt->prepare("SELECT * FROM doping_ilanlari WHERE  doping_adi = 'acil_ilan' AND ilan_id = '$ilan_id'");
						$kontrol_say_6->execute();
						$say_6 = $kontrol_say_6->rowCount();

					?>

					<div class="box">


						<div class="box-header with-border">
							<h3 class="box-title"> <i class="fa fa-rocket"></i> İlanı Dopingle </h3>
						</div>
						<div class="box-body">

							<div class="table-responsive">
                                <div class="row"> 

                                    <div class="col-md-4 hidden-xs">
                                        <div class="form-group">
                                            <label class="control-label"> &nbsp; </label>
                                        </div>
                                        <?php if (!$say_1>0) { ?>
                                            <div class="form-group">
                                                <label class="alert bg-info btn-block"> <strong><i class="fa fa-fire fa-lg"></i> Sıcak Fırsatlarda Göster </strong> </label>
                                            </div>
                                        <?php } ?>
                                        <?php if (!$say_2>0) { ?>
                                            <div class="form-group">
                                                <label class="alert bg-info btn-block"> <strong><i class="fa fa-laptop fa-lg"></i> Vitrin İlanlarında Göster</strong> </label>
                                            </div>
                                        <?php } ?>
                                        <?php if (!$say_3>0) { ?>
                                            <div class="form-group">
                                                <label class="alert bg-info btn-block"> <strong><i class="fa fa-bullhorn fa-lg"></i> Öne Çıkan İlanlarda Göster</strong> </label>
                                            </div>
                                        <?php } ?>
                                        <?php if (!$say_4>0) { ?>
                                            <div class="form-group">
                                                <label class="alert bg-info btn-block"> <strong><i class="fa fa-upload fa-lg"></i> Üst Sıralarda Listele</strong> </label>
                                            </div>
                                        <?php } ?>
                                        <?php if (!$say_5>0) { ?>
                                            <div class="form-group">
                                                <label class="alert bg-info btn-block"> <strong><i class="fa fa-pencil fa-lg"></i> Listelemelerde Renkli Arka Plan ve Bold Yazı</strong> </label>
                                            </div>
                                        <?php } ?>
                                        <?php if (!$say_6>0) { ?>
                                            <div class="form-group">
                                                <label class="alert bg-info btn-block"> <strong><i class="fa fa-desktop fa-lg"></i> Anasayfa Acil İlanlar</strong> </label>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <?php foreach ($doping_paketi as $d) { ?>

                                        <?php

                                        // SAYMA ISLEMLERI

                                        $kontrol_sicak = $vt->prepare("SELECT * FROM doping_ilanlari WHERE paket_id = '$d->id' AND doping_adi = 'sicak_firsat' AND ilan_id = '$ilan_id'");
                                        $kontrol_sicak->execute();
                                        $say_sicak = $kontrol_sicak->rowCount();

                                        $kontrol_vitrin = $vt->prepare("SELECT * FROM doping_ilanlari WHERE paket_id = '$d->id' AND doping_adi = 'vitrin_ilan' AND ilan_id = '$ilan_id'");
                                        $kontrol_vitrin->execute();
                                        $say_vitrin = $kontrol_vitrin->rowCount();

                                        $kontrol_one_cikan = $vt->prepare("SELECT * FROM doping_ilanlari WHERE paket_id = '$d->id' AND doping_adi = 'one_cikan' AND ilan_id = '$ilan_id'");
                                        $kontrol_one_cikan->execute();
                                        $say_one_cikan = $kontrol_one_cikan->rowCount();

                                        $kontrol_ust_sira = $vt->prepare("SELECT * FROM doping_ilanlari WHERE paket_id = '$d->id' AND doping_adi = 'ust_sira' AND ilan_id = '$ilan_id'");
                                        $kontrol_ust_sira->execute();
                                        $say_ust_sira = $kontrol_ust_sira->rowCount();

                                        $kontrol_renkli_bold = $vt->prepare("SELECT * FROM doping_ilanlari WHERE paket_id = '$d->id' AND doping_adi = 'renkli_bold' AND ilan_id = '$ilan_id'");
                                        $kontrol_renkli_bold->execute();
                                        $say_renkli_bold = $kontrol_renkli_bold->rowCount();

                                        $kontrol_acil_ilan = $vt->prepare("SELECT * FROM doping_ilanlari WHERE paket_id = '$d->id' AND doping_adi = 'acil_ilan' AND ilan_id = '$ilan_id'");
                                        $kontrol_acil_ilan->execute();
                                        $say_acil_ilan = $kontrol_acil_ilan->rowCount();

                                        ?>

                                        <div class="col-md-2">

                                            <div class="form-group">
                                                <label class="btn bg-success btn-block"> <strong><?php echo $d->doping_adi; ?></strong> <i class="fa fa-arrow-down"></i> </label>
                                            </div>

                                            <?php $sure 	= toplam_sure($d->sure, $d->sure_zaman); ?>

                                            <?php if (!$say_1>0) { ?>

                                                <div class="form-group text-center">

                                                    <label for="doping_1" class="alert btn-default btn-block">
                                                        <?php if (!$say_1>0) { ?>
                                                            <div class="form-group hidden-lg">
                                                                <label class="alert bg-info btn-block"> <strong><i class="fa fa-fire fa-lg"></i> Sıcak Fırsatlarda Göster </strong> </label>
                                                            </div>
                                                        <?php } ?>
                                                        <input type="radio" name="doping_1" <?php if ($say_sicak>0) {echo "checked "; } ?> value="<?php echo $d->id; ?>" class="minimal">
                                                        <input type="text" name="sicak_firsat" hidden value="sicak_firsat" class="minimal">
                                                        <input type="text" name="fiyat_1[]" hidden value="<?php echo $d->sicak_firsat; ?>" class="minimal">
                                                        <input type="text" name="sure_1[]" hidden value="<?php echo $d->sure; ?>" class="minimal">
                                                        <input type="text" name="sure_zaman_1[]" hidden value="<?php echo $d->sure_zaman; ?>" class="minimal">
                                                        <input type="text" name="bitis_1[]" hidden value="<?php echo bitis_tarihi($tarih, $sure); ?>">

                                                        <strong> <?php echo $d->sicak_firsat; ?> <?php echo  $d->periyot_fiyat_kur; ?> </strong>

                                                    </label>

                                                </div>

                                            <?php } ?>

                                            <?php if (!$say_2>0) { ?>

                                                <div class="form-group text-center">

                                                    <label for="doping_2" class="alert btn-default btn-block">
                                                        <?php if (!$say_2>0) { ?>
                                                            <div class="form-group hidden-lg">
                                                                <label class="alert bg-info btn-block"> <strong><i class="fa fa-laptop fa-lg"></i> Vitrin İlanlarında Göster</strong> </label>
                                                            </div>
                                                        <?php } ?>

                                                        <input type="radio" name="doping_2" <?php if ($say_vitrin>0) {echo "checked "; } ?> value="<?php echo $d->id; ?>" class="minimal">
                                                        <input type="text" name="vitrin_ilan" hidden value="vitrin_ilan" class="minimal">
                                                        <input type="text" name="fiyat_2[]" hidden value="<?php echo $d->vitrin_ilan; ?>" class="minimal">
                                                        <input type="text" name="sure_2[]" hidden value="<?php echo $d->sure; ?>" class="minimal">
                                                        <input type="text" name="sure_zaman_2[]" hidden value="<?php echo $d->sure_zaman; ?>" class="minimal">
                                                        <input type="text" name="bitis_2[]" hidden value="<?php echo bitis_tarihi($tarih, $sure); ?>">

                                                        <strong> <?php echo $d->vitrin_ilan; ?> <?php echo  $d->periyot_fiyat_kur; ?> </strong>

                                                    </label>

                                                </div>

                                            <?php } ?>

                                            <?php if (!$say_3>0) { ?>

                                                <div class="form-group text-center">
                                                    <label for="doping_3" class="alert btn-default btn-block">
                                                        <?php if (!$say_3>0) { ?>
                                                            <div class="form-group hidden-lg">
                                                                <label class="alert bg-info btn-block"> <strong><i class="fa fa-bullhorn fa-lg"></i> Öne Çıkan İlanlarda Göster</strong> </label>
                                                            </div>
                                                        <?php } ?>
                                                        <input type="radio" name="doping_3" <?php if ($say_one_cikan>0) {echo "checked "; } ?> value="<?php echo $d->id; ?>" class="minimal">
                                                        <input type="text" name="one_cikan" hidden value="one_cikan" class="minimal">
                                                        <input type="text" name="fiyat_3[]" hidden value="<?php echo $d->one_cikan; ?>" class="minimal">
                                                        <input type="text" name="sure_3[]" hidden value="<?php echo $d->sure; ?>" class="minimal">
                                                        <input type="text" name="sure_zaman_3[]" hidden value="<?php echo $d->sure_zaman; ?>" class="minimal">
                                                        <input type="text" name="bitis_3[]" hidden value="<?php echo bitis_tarihi($tarih, $sure); ?>">
                                                        <strong> <?php echo $d->one_cikan; ?> <?php echo  $d->periyot_fiyat_kur; ?> </strong>
                                                    </label>
                                                </div>

                                            <?php } ?>

                                            <?php if (!$say_4>0) { ?>

                                                <div class="form-group text-center">
                                                    <label for="doping_4" class="alert btn-default btn-block">
                                                        <?php if (!$say_4>0) { ?>
                                                            <div class="form-group hidden-lg">
                                                                <label class="alert bg-info btn-block"> <strong><i class="fa fa-upload fa-lg"></i> Üst Sıralarda Listele</strong> </label>
                                                            </div>
                                                        <?php } ?>
                                                        <input type="radio" name="doping_4" <?php if ($say_ust_sira>0) {echo "checked "; } ?> value="<?php echo $d->id; ?>" class="minimal">
                                                        <input type="text" name="ust_sira" hidden value="ust_sira" class="minimal">
                                                        <input type="text" name="fiyat_4[]" hidden value="<?php echo $d->ust_sira; ?>" class="minimal">
                                                        <input type="text" name="sure_4[]" hidden value="<?php echo $d->sure; ?>" class="minimal">
                                                        <input type="text" name="sure_zaman_4[]" hidden value="<?php echo $d->sure_zaman; ?>" class="minimal">
                                                        <input type="text" name="bitis_4[]" hidden value="<?php echo bitis_tarihi($tarih, $sure); ?>">
                                                        <strong> <?php echo $d->ust_sira; ?> <?php echo  $d->periyot_fiyat_kur; ?> </strong>
                                                    </label>
                                                </div>

                                            <?php } ?>

                                            <?php if (!$say_5>0) { ?>

                                                <div class="form-group text-center">
                                                    <label for="doping_5" class="alert btn-default btn-block">
                                                        <?php if (!$say_5>0) { ?>
                                                            <div class="form-group hidden-lg">
                                                                <label class="alert bg-info btn-block"> <strong><i class="fa fa-pencil fa-lg"></i> Listelemelerde Renkli Arka Plan ve Bold Yazı</strong> </label>
                                                            </div>
                                                        <?php } ?>
                                                        <input type="radio" name="doping_5" <?php if ($say_renkli_bold>0) {echo "checked "; } ?> value="<?php echo $d->id; ?>" class="minimal">
                                                        <input type="text" name="renkli_bold" hidden value="renkli_bold" class="minimal">
                                                        <input type="text" name="fiyat_5[]" hidden value="<?php echo $d->renkli_bold; ?>" class="minimal">
                                                        <input type="text" name="sure_5[]" hidden value="<?php echo $d->sure; ?>" class="minimal">
                                                        <input type="text" name="sure_zaman_5[]" hidden value="<?php echo $d->sure_zaman; ?>" class="minimal">
                                                        <input type="text" name="bitis_5[]" hidden value="<?php echo bitis_tarihi($tarih, $sure); ?>">
                                                        <strong> <?php echo $d->renkli_bold; ?> <?php echo  $d->periyot_fiyat_kur; ?> </strong>
                                                    </label>
                                                </div>

                                            <?php } ?>

                                            <?php if (!$say_6>0) { ?>

                                                <div class="form-group text-center">
                                                    <label for="doping_6" class="alert btn-default btn-block">
                                                        <?php if (!$say_6>0) { ?>
                                                            <div class="form-group hidden-lg">
                                                                <label class="alert bg-info btn-block"> <strong><i class="fa fa-desktop fa-lg"></i> Anasayfa Acil İlanlar</strong> </label>
                                                            </div>
                                                        <?php } ?>
                                                        <input type="radio" name="doping_6" <?php if ($say_acil_ilan>0) {echo "checked "; } ?> value="<?php echo $d->id; ?>" class="minimal">
                                                        <input type="text" name="acil_ilan" hidden value="acil_ilan" class="minimal">
                                                        <input type="text" name="fiyat_6[]" hidden value="<?php echo $d->acil_ilan; ?>" class="minimal">
                                                        <input type="text" name="sure_6[]" hidden value="<?php echo $d->sure; ?>" class="minimal">
                                                        <input type="text" name="sure_zaman_6[]" hidden value="<?php echo $d->sure_zaman; ?>" class="minimal">
                                                        <input type="text" name="bitis_6[]" hidden value="<?php echo bitis_tarihi($tarih, $sure); ?>">
                                                        <strong> <?php echo $d->acil_ilan; ?> <?php echo  $d->periyot_fiyat_kur; ?> </strong>
                                                    </label>
                                                </div>

                                            <?php } ?>

                                        </div>

                                    <?php } ?>

                                </div>
                            </div>

						</div>


					</div>

					<div class="box hidden">

						<div class="box-header with-border">
							<h3 class="box-title"> <i class="fa fa-bell-o"></i> Sipariş Notları </h3>
						</div>

						<div class="box-body">

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label"> Açıklama <small>[Zorunlu Değil]</small></label>
										<textarea class="form-control" placeholder="Açıklama" name="aciklama" rows="7"><?php echo $siparis_kod_no["aciklama"]; ?></textarea>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label"> Sipariş Notu <small>[Zorunlu Değil]</small></label>
										<textarea class="form-control" placeholder="Sipariş İçin Notlarınız" name="siparis_notu" rows="7"><?php echo $siparis_kod_no["siparis_notu"]; ?></textarea>
									</div>
								</div>
							</div>

						</div>

					</div>

				</div>

				<?php if (yetki() == 0) { ?> <div class="col-md-12"> <?php } else { ?> <div class="col-md-12"> <?php } ?>

					<div class="box">
						<div class="box-header with-border hidden">
							<h3 class="box-title"> <i class="fa fa-try"></i> Ücretlendirme </h3>
						</div>
						<div class="box-body hidden">

							<div class="form-group <?php if ($uye_yetki != 0) { ?> col-md-3 <?php } ?>">

								<label class="control-label"> Sipariş No </label>

								<?php

									$siparis_kod = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '$ilan_id' AND siparis_no != ''");
									$varmi = $siparis_kod->rowCount();

								?>

								<?php if ($varmi>0) { ?>

									<input type="text" class="form-control" name="siparis_no" value="<?php echo $siparis_kod_no["siparis_no"]; ?>">

								<?php } else { ?>

									<input type="text" class="form-control" name="siparis_no" value="<?php echo uniqid('DPNG'); ?>">

								<?php }  ?>

							</div>

							<div class="form-group <?php if ($uye_yetki != 0) { ?> col-md-3 <?php } ?> hidden">

								<label class="control-label"> Durum </label>

								<input type="text" class="form-control" disabled name="" value="<?php if ($emlak->doping_onay == "1") { ?> Aktif <?php } else { ?> Pasif <?php } ?>">

							</div>

							<div class="form-group <?php if ($uye_yetki != 0) { ?> col-md-3 <?php } ?> hidden">
								<?php
									$odeme_tipi = $vt->query("SELECT * FROM odeme_tipi WHERE durum = '0'")->fetchAll();
									$odeme_tipi_ver = $vt->query("SELECT * FROM odeme_tipi WHERE durum = '0'")->fetch();
								?>
								<label class="control-label"> Ödeme Yöntemi </label>
								<select class="form-control sele ct2" name="odeme_tipi">

									<?php
										foreach ($odeme_tipi as $odeme) {
									?>
									<option value="<?php echo $odeme["adi"]; ?>"><?php echo $odeme["adi"]; ?></option>
									<?php } ?>

								</select>
							</div>

							<div class="form-group <?php if ($uye_yetki != 0) { ?> col-md-3 <?php } ?> hidden">
								<?php
									$odeme_durumu = $vt->query("SELECT * FROM odeme_durumu WHERE id")->fetchAll();
									$odeme_durumu_ver = $vt->query("SELECT * FROM odeme_durumu WHERE id")->fetch();
								?>
								<label class="control-label"> Ödeme Durumu </label>
								<select class="form-control sel ect2" name="odeme_durumu">
									<option value="Ödeme Bekliyor">Ödeme Bekliyor</option>
								</select>
							</div>

							<div class="form-group <?php if ($uye_yetki != 0) { ?> col-md-3 <?php } ?>">
								<label class="control-label"> Toplam Tutar </label>
								<input type="text" class="form-control" disabled name="" value="<?php doping_toplam($ilan_id); ?> TL">
							</div>

							<div class="form-group <?php if ($uye_yetki != 0) { ?> col-md-3 <?php } ?>">
								<label class="control-label"> Ödenen Tutar </label>
								<input type="text" class="form-control" disabled name="" value="<?php doping_toplam_odenen($ilan_id); ?> TL">
							</div>

							<div class="form-group <?php if ($uye_yetki != 0) { ?> col-md-3 <?php } ?>">
								<label class="control-label"> Ödenecek Tutar </label>
								<input type="text" class="form-control" name="odenecek_tutar" value="<?php trim(doping_toplam_odeme($ilan_id)); ?>">
							</div>

						</div>
						<div class="box-footer">

							<?php if ($emlak->doping == "var" && $uye_yetki == 0) { ?>
							<button type="submit" class="btn btn-danger btn-lg btn-block" name="doping_sil"> <i class="fa fa-trash fa-lg"></i> <strong> TÜM DOPİNGLERİ KALDIR </strong> </button>
							<br>
							<?php } ?>

							<div class="row">
								<?php if (yetki() == 0) { ?> <div class="col-md-12"> <?php } else { ?> <div class="col-md-6"> <?php } ?>

									<a href="index.php?do=islem&emlak=emlak_ilanlar&hareket=onay" class="btn btn-default btn-block" name="dopingle"> Bu Adımı Atla </a>
								</div>
								<?php if (yetki() == 0) { ?> <div class="col-md-12"> <br> <?php } else { ?> <div class="col-md-6"> <?php } ?>
									<button type="submit" class="btn btn-primary btn-block" name="dopingle"> Devam Et </button>
								</div>
							</div>

						</div>
					</div>

					<!--
					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title"> Detay ve Ücretler </h3>
						</div>
						<div class="box-body">

							<?php if (empty($resim->emlakno)) { ?>
							<div class="resim_liste">
								<img src="../uploads/resim/resim.png"/>
							</div>
							<?php } else { ?>
							<img class="img-thumbnail" src="../uploads/resim/<?=$resim->resimad;?>" />
							<br>

							<br>
							<?php } ?>

							<div class="text-center">
								<h5> <a href="index.php?do=islem&emlak=emlak_duzenle&id=<?php echo $emlak->id; ?>" target="_blank"> <?php echo $emlak->baslik; ?> </a> </h5>
							</div>

							<hr>

							<h5> <strong> Ekleyen: </strong> <a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $sahibi->id; ?>&yetki=<?php echo $sahibi->yetki; ?>" target="_blank"> <?php echo $sahibi->adsoyad; ?> </a> </h5>

							<h5> <strong> Kategori: </strong> <?php echo $kategori->kat_adi; ?> </h5>

							<h5> <strong> Emlak No: </strong> <?php echo $emlak->emlakno; ?> </h5>

							<h5> <strong> Ekleme Tarihi: </strong> <?php echo $emlak->eklemetarihi; ?> </h5>

							<br>

							<a class="btn btn-success btn-block" href="index.php?do=islem&emlak=emlak_duzenle&id=<?php echo $emlak->id; ?>" target="_blank"> İlana Git <i class="fa fa-angle-double-right"></i> </a>
						</div>
					</div>
					-->
				</div>

			</div>

			<style>
				#nerede
				{

					position:relative;
				}
				#nerede:hover #resim
				{
					display:block !important;
				}
				#resim
				{
					position:absolute; z-index:7777;
					display:none; left:0;
					right:0;
					top:-150px;
				}

			</style>
			<br>

			<div id="nerede" class="alert alert-primary text-center">
				<i class="fa fa-arrow-circle-up fa-5x"></i>
				<h2><strong>Daha fazla alıcıya ulaşmak ister misiniz?</strong></h2>
				<h5>
					Doping alın, ilanınızın aramalarda daha fazla görüntülenmesini sağlayın.
					<a class="badge" href="/images/one-cikan.png" target="_blank"><i class="fa fa-eye"></i> İlanı nasıl görünecek?</a>
				</h5>
				<div class="text-center" id="resim">
					<img src="/images/one-cikan.png" class="img-thumbnail">
				</div>

			</div>

	</section>
<?php if ($doping_say>0) { ?>

	<section class="content">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"> <i class="fa fa-rocket"></i> Aktif Dopingler </h3>
			</div>
			<div class="box-body">
					<a target="_blank" href="index.php?do=islem&emlak=emlak_duzenle&id=<?php echo $emlak->id; ?>" class="btn btn-default btn-block h6 hidden-xs">
                        <strong>İLAN: </strong>
                        <?php echo $emlak->baslik; ?>
                    </a>
					<br>
					<div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                            <tr>
                                <td class="text-center"><strong>ID</strong></td>
                                <td><strong>DOPİNG ADI</strong></td>
                                <td class="text-center"><strong>SÜRE</strong></td>
                                <td class="text-center"><strong>PERİYOT</strong></td>
                                <td class="text-center" style="width:12%;"><strong>TUTAR</strong></td>
                                <td class="hidden"><strong>BAŞLANGIÇ</strong></td>
                                <td><strong>BİTİŞ TARİHİ</strong></td>
                                <td class="text-center hidden"><strong>TOPLAM SÜRE</strong></td>
                                <td class="text-center"><strong>KALAN SÜRE</strong></td>
                                <?php if (yetki() == 0): ?>
                                    <td>Ödeme</td>
                                <?php endif; ?>
                                <td></td>
                                <td class="hi dden"><strong>SİL</strong></td>
                            </tr>
                            </thead>

                            <tbody>

                            <?php foreach ($ilan_dopingleri as $doping) { ?>
                                <?php

                                $sure = $doping["sure"];
                                $zaman = gun($doping["sure_zaman"]);

                                // TOPLAM SURE

                                $t_sure = $sure * $zaman;

                                ?>
                                <tr>
                                    <td class="text-center">
                                        <?php echo $doping["id"]; ?>
                                    </td>
                                    <td>
                                        <h6 style="font-weight: 300;"><?php echo doping_adi($doping["doping_adi"]); ?></h6>
                                    </td>
                                    <td class="text-center">
                                        <input type="text" class="form-control <?php if ($uye_yetki != 0 ) { ?>hidden<?php } ?>"  name="sure[]" value="<?php echo $doping["sure"]; ?>">
                                        <?php if ($uye_yetki != 0 ) { ?> <?php echo $doping["sure"]; ?> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <select class="form-control <?php if ($uye_yetki != 0 ) { ?>hidden<?php } ?>" name="sure_zaman[]">
                                            <option> <?php echo $doping["sure_zaman"]; ?> </option>
                                            <option value="Gün"> Gün </option>
                                            <option value="Ay"> Ay </option>
                                            <option value="Yıl"> Yıl </option>
                                        </select>
                                        <?php if ($uye_yetki != 0 ) { ?> <?php echo $doping["sure_zaman"]; ?> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <input type="text" class="form-control hidden" name="fiyat[]" value="<?php echo $doping["fiyat"]; ?>">
                                        <?php echo $doping["fiyat"]; ?> TL
                                    </td>
                                    <td class="hidden">
                                        <?php if ($emlak->doping_onay == "1") { ?>

                                            <input type="text" class="form-control" disabled name="tarih[]" value="<?php echo $doping["tarih"]; ?>">

                                        <?php } else { ?>
                                            <p class="text-center"> Onay Bekliyor </p>
                                        <?php } ?>

                                    </td>
                                    <td>
                                        <?php if ($emlak->doping_onay == "1") { ?>

                                            <input type="text" class="form-control" disabled name="bitis_tarihi[]" value="<?php echo $doping["bitis_tarihi"]; ?>">

                                        <?php } else { ?>
                                            <p class="text-center"> Onay Bekliyor </p>
                                        <?php } ?>
                                    </td>
                                    <td class="hidden">
                                        <p class="text-center btn btn-block bg-success"> <?php echo toplam_sure($doping["sure"], $doping["sure_zaman"]); ?> Gün </p>
                                    </td>
                                    <td>
                                        <?php if ($emlak->doping_onay == "1") { ?>
                                            <p class="text-center btn btn-block bg-warning"> <?php kalan_sure($tarih, $doping["bitis_tarihi"]); ?> </p>
                                        <?php } else { ?>
                                            <p class="text-center blink"> Onay Bekliyor </p>
                                        <?php } ?>

                                    </td>
                                    <td>
                                        <?php if ($doping["odeme_durumu"] == "Ödeme Bekliyor") { ?>

                                            <span class="btn btn-xs bg-danger btn-block blink">Ödeme Bekliyor</span>

                                        <?php } else { ?>

                                            <span class="btn btn-xs bg-success btn-block">Ödendi</span>

                                        <?php } ?>
                                    </td>
                                    <?php if (yetki() == 0): ?>
                                        <td>

                                            <?php if ($doping["odeme_durumu"] == "Ödeme Bekliyor"): ?>
                                                <a href="index.php?do=doping/ilan_doping&ilan_id=<?php echo $ilan_id; ?>&islem=odeme_onay&d_id=<?php echo $doping["id"]; ?>" class="btn btn-primary btn-xs btn-block"> <i class="fa fa-check"></i> <strong>ÖDENDİ</strong> </a>
                                            <?php else: ?>
                                                <a href="index.php?do=doping/ilan_doping&ilan_id=<?php echo $ilan_id; ?>&islem=odeme_iptal&d_id=<?php echo $doping["id"]; ?>" class="btn btn-danger btn-xs btn-block"> <i class="fa fa-close"></i> <strong>ÖDENMEDİ</strong> </a>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                    <td class="text-center">
                                        <a href="index.php?do=doping/ilan_doping&ilan_id=<?php echo $ilan_id; ?>&islem=d_sil&d_id=<?php echo $doping["id"]; ?>"> <i style="color:red;" class="fa fa-window-close fa-lg"></i>  </a>
                                        <div class="hidden">
                                            <?php echo $doping["id"]; ?>
                                            <input type="text" class="form-control hidden" name="d_id[]" value="<?php echo $doping["id"]; ?>">
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="3">
                                    <h5 class="btn btn-block btn-default btn-xs">TOPLAM TUTAR</h5>
                                </td>
                                <td colspan="1">
                                    <h5 class="btn btn-block btn-danger btn-xs"><?php doping_toplam($ilan_id); ?> TL</h5>
                                </td>

                                <td colspan="2">

                                    <h5 class="btn btn-block btn-default btn-xs">BEKLEYEN ÖDEME</h5>


                                </td>

                                <td colspan="1">

                                    <h5 class="btn btn-block btn-danger btn-xs"><?php echo doping_toplam_odeme($ilan_id); ?> TL</h5>


                                </td>

                                <td colspan="2">

                                    <?php

                                    $bekleyen = $vt->prepare("SELECT * FROM doping_ilanlari WHERE ilan_id = '$ilan_id' AND odeme_durumu = 'Ödeme Bekliyor'");
                                    $bekleyen->execute();
                                    $bekleyen_say = $bekleyen->rowCount();

                                    ?>

                                    <?php if ($bekleyen_say > 0) { ?>
                                        <button type="submit" class="btn btn-block btn-warning" name="dopingle"> <i class="fa fa-credit-card fa-lg"></i> <strong> ÖDEME YAP </strong> </button>
                                    <?php } ?>


                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

					<br>

					<div class="alert alert-primary">
						<strong>ÖNEMLİ NOT:</strong> Aktif dopingleri kaldırırsanız kalan sürede silinmiş olur ve ödemeniz geri iade edilmez.
					</div>

			</div>

			<?php if ($uye_yetki == 0) { ?>

			<div class="box-footer text-right">

				<?php if ($emlak->doping_onay == "0") { ?>

				<a href="index.php?do=doping/ilan_doping&ilan_id=<?php echo $ilan_id; ?>&islem=doping_onay&hareket=1" class="btn btn-success btn-lg"> <i class="fa fa-check fa-lg"></i> <strong> TÜMÜNÜ ONAYLA </strong> </a>

				<?php } else { ?>

				<a href="index.php?do=doping/ilan_doping&ilan_id=<?php echo $ilan_id; ?>&islem=doping_onay&hareket=0" class="btn btn-danger btn-lg"> <i class="fa fa-check fa-lg"></i> <strong> TÜM ONAYLARI KALDIR </strong> </a>

				<?php } ?>

				<button type="submit" class="btn btn-primary btn-lg" name="ayar_kaydet"> <i class="fa fa-save fa-lg"></i> <strong> AYARLARI GÜNCELLE </strong> </button>

			</div>

			<?php } ?>

		</div>
	</section>
<?php } ?>


<?php

	if ($islem=="d_sil") {

		$d_id = $_GET["d_id"];

		$sil = $vt->query("DELETE FROM doping_ilanlari WHERE id = '$d_id'");

		go("index.php?do=doping/ilan_doping&ilan_id={$ilan_id}&islem=onay",0);

	}

	if ($islem=="odeme_onay") {

		$d_id = $_GET["d_id"];

		$ilan_id = $_GET["ilan_id"];

		$onayla = $vt->query("UPDATE doping_ilanlari SET odeme_durumu = 'Ödendi' WHERE id = '$d_id'");

		onay_alert("İşleminiz başarılı bir şekilde gerçekleşti.");

		go("index.php?do=doping/ilan_doping&ilan_id={$ilan_id}",0);

	}

	if ($islem=="odeme_iptal") {

		$d_id = $_GET["d_id"];

		$ilan_id = $_GET["ilan_id"];

		$onayla = $vt->query("UPDATE doping_ilanlari SET odeme_durumu = 'Ödeme Bekliyor' WHERE id = '$d_id'");

		onay_alert("İşleminiz başarılı bir şekilde gerçekleşti.");

		go("index.php?do=doping/ilan_doping&ilan_id={$ilan_id}",0);

	}

	if (!$doping_say > 0) {

		$emlak_doping_kapat = $vt->query("UPDATE emlak_ilan SET doping_onay = 0, doping = 'yok' WHERE id = '$ilan_id'");

	}

?>

<?php	if (isset($_POST["dopingle"])) { ?>

	<section class="content">

		<?php

		// ACIKLAMA VE SIPAIRS NOTU EKLE

		$odenecek_tutar = $_POST["odenecek_tutar"];


		// EKLEME SILME VE GUNCELLEME ISLEMLERI

		$sicak_firsat							= $_POST["sicak_firsat"];
		$doping_1 								= $_POST["doping_1"];
		$fiyat_1								= $_POST["fiyat_1"][$doping_1-1];
		$sure_1									= $_POST["sure_1"][$doping_1-1];
		$sure_zaman_1							= $_POST["sure_zaman_1"][$doping_1-1];
		$islem_1 								= "doping_".$doping_1;
		$siparis_no 							= $_POST["siparis_no"];
		$odeme_tipi 							= $_POST["odeme_tipi"];
		$odeme_durumu 							= $_POST["odeme_durumu"];

		$odeme_kodu_sicak						= "SICAK".$siparis_no;

		$bitis_1								= $_POST["bitis_1"][$doping_1-1];

		$sicak = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '$ilan_id' AND doping_adi = 'sicak_firsat' AND odeme_durumu = 'Ödendi'")->fetch(PDO::FETCH_OBJ);

		if ($sicak == false) {

			$sil_sicak_firsat = $vt->query("DELETE FROM doping_ilanlari WHERE doping_adi = '$sicak_firsat' AND ilan_id = '$ilan_id'");

			$sicak_firsat_ekle=$vt->prepare("INSERT INTO doping_ilanlari (doping_adi,paket_id,ilan_id,islem_no,fiyat,tarih,sure,sure_zaman, bitis_tarihi, siparis_no, odeme_tipi, odeme_durumu, odeme_kodu) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$deger=$sicak_firsat_ekle->execute(array($sicak_firsat,$doping_1,$ilan_id,$islem_1,$fiyat_1,$tarih,$sure_1,$sure_zaman_1, $bitis_1, $siparis_no, $odeme_tipi, $odeme_durumu, $odeme_kodu_sicak));

		}

		$vitrin_ilan							= $_POST["vitrin_ilan"];
		$doping_2 								= $_POST["doping_2"];
		$fiyat_2								= $_POST["fiyat_2"][$doping_2-1];
		$sure_2									= $_POST["sure_2"][$doping_2-1];
		$sure_zaman_2							= $_POST["sure_zaman_2"][$doping_2-1];
		$islem_2 								= "doping_".$doping_2;

		$odeme_kodu_vitrin						= "VITRIN".$siparis_no;


		$bitis_2								= $_POST["bitis_2"][$doping_2-1];

		$vitrin = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '$ilan_id' AND doping_adi = 'vitrin_ilan' AND odeme_durumu = 'Ödendi'")->fetch(PDO::FETCH_OBJ);

		if ($vitrin == false) {

			$sil_vitrin_ilan 	= $vt->query("DELETE FROM doping_ilanlari WHERE doping_adi = '$vitrin_ilan' AND ilan_id = '$ilan_id'");

			$vitrin_ilan_ekle=$vt->prepare("INSERT INTO doping_ilanlari (doping_adi,paket_id,ilan_id,islem_no,fiyat,tarih,sure,sure_zaman, bitis_tarihi, siparis_no, odeme_tipi, odeme_durumu, odeme_kodu) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$deger=$vitrin_ilan_ekle->execute(array($vitrin_ilan,$doping_2,$ilan_id,$islem_2,$fiyat_2,$tarih,$sure_2,$sure_zaman_2, $bitis_2, $siparis_no, $odeme_tipi, $odeme_durumu, $odeme_kodu_vitrin));

		}

		$one_cikan								= $_POST["one_cikan"];
		$doping_3								= $_POST["doping_3"];
		$fiyat_3								= $_POST["fiyat_3"][$doping_3-1];
		$sure_3									= $_POST["sure_3"][$doping_3-1];
		$sure_zaman_3							= $_POST["sure_zaman_3"][$doping_3-1];
		$islem_3 								= "doping_".$doping_3;

		$odeme_kodu_one							= "ONE".$siparis_no;


		$bitis_3								= $_POST["bitis_3"][$doping_3-1];

		$one = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '$ilan_id' AND doping_adi = 'one_cikan' AND odeme_durumu = 'Ödendi'")->fetch(PDO::FETCH_OBJ);

		if ($one == false) {

			$sil_one_cikan 	= $vt->query("DELETE FROM doping_ilanlari WHERE doping_adi = '$one_cikan' AND ilan_id = '$ilan_id'");

			$one_cikan_ekle=$vt->prepare("INSERT INTO doping_ilanlari (doping_adi,paket_id,ilan_id,islem_no,fiyat,tarih,sure,sure_zaman, bitis_tarihi, siparis_no, odeme_tipi, odeme_durumu, odeme_kodu) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$deger=$one_cikan_ekle->execute(array($one_cikan,$doping_3,$ilan_id,$islem_3,$fiyat_3,$tarih,$sure_3,$sure_zaman_3, $bitis_3, $siparis_no, $odeme_tipi, $odeme_durumu, $odeme_kodu_one));

		}

		$ust_sira								= $_POST["ust_sira"];
		$doping_4								= $_POST["doping_4"];
		$fiyat_4								= $_POST["fiyat_4"][$doping_4-1];
		$sure_4									= $_POST["sure_4"][$doping_4-1];
		$sure_zaman_4							= $_POST["sure_zaman_4"][$doping_4-1];
		$islem_4 								= "doping_".$doping_4;

		$odeme_kodu_ust						= "UST".$siparis_no;

		$bitis_4								= $_POST["bitis_4"][$doping_4-1];

		$ust = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '$ilan_id' AND doping_adi = 'ust_sira' AND odeme_durumu = 'Ödendi'")->fetch(PDO::FETCH_OBJ);

		if ($ust == false) {

			$sil_ust_sira 	= $vt->query("DELETE FROM doping_ilanlari WHERE doping_adi = '$ust_sira' AND ilan_id = '$ilan_id'");

			$ust_sira_ekle=$vt->prepare("INSERT INTO doping_ilanlari (doping_adi,paket_id,ilan_id,islem_no,fiyat,tarih,sure,sure_zaman, bitis_tarihi, siparis_no, odeme_tipi, odeme_durumu, odeme_kodu) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$deger=$ust_sira_ekle->execute(array($ust_sira,$doping_4,$ilan_id,$islem_4,$fiyat_4,$tarih,$sure_4,$sure_zaman_4, $bitis_4, $siparis_no, $odeme_tipi, $odeme_durumu, $odeme_kodu_ust));

		}

		$renkli_bold							= $_POST["renkli_bold"];
		$doping_5								= $_POST["doping_5"];
		$fiyat_5								= $_POST["fiyat_5"][$doping_5-1];
		$sure_5									= $_POST["sure_5"][$doping_5-1];
		$sure_zaman_5							= $_POST["sure_zaman_5"][$doping_5-1];
		$islem_5 								= "doping_".$doping_5;

		$odeme_kodu_renkli						= "RENKLI".$siparis_no;

		$bitis_5								= $_POST["bitis_5"][$doping_5-1];

		$renkli = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '$ilan_id' AND doping_adi = 'renkli_bold' AND odeme_durumu = 'Ödendi'")->fetch(PDO::FETCH_OBJ);

		if ($renkli == false) {

			$sil_renkli_bold 	= $vt->query("DELETE FROM doping_ilanlari WHERE doping_adi = '$renkli_bold' AND ilan_id = '$ilan_id'");

			$renkli_bold_ekle=$vt->prepare("INSERT INTO doping_ilanlari (doping_adi,paket_id,ilan_id,islem_no,fiyat,tarih,sure,sure_zaman, bitis_tarihi, siparis_no, odeme_tipi, odeme_durumu, odeme_kodu) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$deger=$renkli_bold_ekle->execute(array($renkli_bold,$doping_5,$ilan_id,$islem_5,$fiyat_5,$tarih,$sure_5,$sure_zaman_5, $bitis_5, $siparis_no, $odeme_tipi, $odeme_durumu, $odeme_kodu_renkli));

		}

		$acil_ilan								= $_POST["acil_ilan"];
		$doping_6								= $_POST["doping_6"];
		$fiyat_6								= $_POST["fiyat_6"][$doping_6-1];
		$sure_6									= $_POST["sure_6"][$doping_6-1];
		$sure_zaman_6							= $_POST["sure_zaman_6"][$doping_6-1];
		$islem_6 								= "doping_".$doping_6;

		$odeme_kodu_acil						= "ACIL".$siparis_no;

		$bitis_6								= $_POST["bitis_6"][$doping_6-1];

		$acil = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '$ilan_id' AND doping_adi = 'acil_ilan' AND odeme_durumu = 'Ödendi'")->fetch(PDO::FETCH_OBJ);

		if ($acil == false) {

			$sil_acil_ilan 	= $vt->query("DELETE FROM doping_ilanlari WHERE doping_adi = '$acil_ilan' AND ilan_id = '$ilan_id'");

			$acil_ilan_ekle=$vt->prepare("INSERT INTO doping_ilanlari (doping_adi,paket_id,ilan_id,islem_no,fiyat,tarih,sure,sure_zaman, bitis_tarihi, siparis_no, odeme_tipi, odeme_durumu, odeme_kodu) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$deger=$acil_ilan_ekle->execute(array($acil_ilan,$doping_6,$ilan_id,$islem_6,$fiyat_6,$tarih,$sure_6,$sure_zaman_6, $bitis_6, $siparis_no, $odeme_tipi, $odeme_durumu, $odeme_kodu_acil));

		}

		$aciklama 								= $_POST["aciklama"];
		$siparis_notu 							= $_POST["siparis_notu"];

		$aciklama_ekle 	= $vt->query("UPDATE doping_ilanlari SET aciklama = '$aciklama', siparis_notu = '$siparis_notu' WHERE ilan_id = '$ilan_id'");

		// ILAN DOPING KAPAT

		if ($sicak_firsat != "" || $vitrin_ilan != "" || $one_cikan != "" || $ust_sira != "" || $renkli_bold != "" || $acil_ilan != "") {
			$ilani_duzenle = $vt->query("UPDATE emlak_ilan SET doping = 'var' WHERE id = '$ilan_id'");
		}

		yonetici_mail_bildir("Yeni doping siparişi alındı. Lütfen kontrol ediniz.");
		yonetici_sms_bildir("Yeni doping siparişi alındı. Lütfen kontrol ediniz.");

		go("index.php?do=doping/doping_odeme&ilan_id={$ilan_id}",0);

		?>

	</section>

<?php } ?>

</form>

<style media="screen">
	.control-label {
		padding-top: 15px !important;
	}
</style>
