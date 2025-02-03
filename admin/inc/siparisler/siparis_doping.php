



<?php 
	$islem = $_GET["islem"];
	$siparis_no = $_GET["siparis_no"];
	$ilan_id = $_GET["ilan_id"];
	$hareket = $_GET["hareket"];
?>
<?php 

	if ($islem == "sil") {

		// SMS BILDIRIM
		
		$ilan_doping_id = $vt->query("SELECT * FROM emlak_ilan WHERE id = '$ilan_id'")->fetch();
		$uye 			= $vt->query("SELECT * FROM yonetici WHERE id = '".$ilan_doping_id["yonetici_id"]."'")->fetch();
		
		mail_gonder($uye['email'], "Sayın ".$uye["adsoyad"].", ".$ilan_doping_id["emlakno"]." numaralı ilan dopinginiz silinmiştir.", "Sayın ".$uye["adsoyad"].", ".$ilan_doping_id["emlakno"]." numaralı ilan dopinginiz onaylanmıştır.");
		sms_gonder($uye['id'],"Sayın ".$uye["adsoyad"].", ".$ilan_doping_id["emlakno"]." numaralı ilan dopinginiz silinmiştir."); 
		
		$sil = $vt->query("DELETE FROM doping_ilanlari WHERE siparis_no = '$siparis_no'");
		
		$emlak_doping_kapat = $vt->query("UPDATE emlak_ilan SET doping_onay = 0, doping = 'yok' WHERE id = '$ilan_id'");		
		
		go("index.php?do=siparisler/siparisler&tip=doping&islem=onay",0);

	}

?>

<?php 
	if ($islem == "doping_onay") {
		
		if ($hareket == 0) {$onay = 0;}
		if ($hareket == 1) {$onay = 1;}

		$onayla = $vt->query("UPDATE emlak_ilan SET doping_onay = '$onay' WHERE id = '$ilan_id'");

		// SMS BILDIRIM
		
		$ilan_doping_id = $vt->query("SELECT * FROM emlak_ilan WHERE id = '$ilan_id'")->fetch();
		$uye 			= $vt->query("SELECT * FROM yonetici WHERE id = '".$ilan_doping_id["yonetici_id"]."'")->fetch();
		
		if ($hareket == 1):

		mail_gonder($uye['email'], "Sayın ".$uye["adsoyad"].", ".$ilan_doping_id["emlakno"]." numaralı ilan dopinginiz onaylanmıştır.", "Sayın ".$uye["adsoyad"].", ".$ilan_doping_id["emlakno"]." numaralı ilan dopinginiz onaylanmıştır.");
		sms_gonder($uye['id'],"Sayın ".$uye["adsoyad"].", ".$ilan_doping_id["emlakno"]." numaralı ilan dopinginiz onaylanmıştır."); 

		endif;
		
		if ($hareket == 0):

		mail_gonder($uye['email'], "Sayın ".$uye["adsoyad"].", ".$ilan_doping_id["emlakno"]." numaralı ilan dopinginiz yayından kaldılmıştır.", "Sayın ".$uye["adsoyad"].", ".$ilan_doping_id["emlakno"]." numaralı ilan dopinginiz yayından kaldılmıştır.");
		sms_gonder($uye['id'],"Sayın ".$uye["adsoyad"].", ".$ilan_doping_id["emlakno"]." numaralı ilan dopinginiz yayından kaldılmıştır."); 

		endif;

		go("index.php?do=siparisler/siparisler&tip=doping&islem=onay",0);

	}
?>

<?php	if ($islem == "onay") { ?> 
	<div style="margin-top: 20px;"> <?php onay(); ?> </div>
<?php } ?>

<form class="form" action="" method="post">
	<div class="table-responsive">
		<table id="example1" class="table table-bordered dataTable" colspan="5" role="grid" aria-describedby="example1_info">
			<thead>
				<tr>
					<th><p><strong> ID </strong></p></th>
					<th><p><strong> Üye </strong></p></th>					
					<th style="width:20%;"><p><strong> İlan Başlık </strong></p></th>
					<th><p><strong> Sipariş No </strong></p></th>
					<th><p><strong> Sipariş Tarihi </strong></p></th>
					<th><p><strong> Tutar </strong></p></th>										
					<th class="text-center"><p><strong> Ödeme Tipi </strong></p></th>
					<th class="text-center"><p><strong> Ödeme Durum </strong></p></th>
					<th><p><strong> Durum </strong></p></th>
					<th><p><strong> İşlemler </strong></p></th>

					
					
					
				</tr>
			</thead>
			<tbody>

				<?php 

					$emlak_ilan = $vt->query("SELECT * FROM emlak_ilan WHERE doping = 'var'")->fetchAll(PDO::FETCH_ASSOC);

					foreach ($emlak_ilan as $emlak) {
					
					$doping_ilanlari = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '".$emlak["id"]."'")->fetch(PDO::FETCH_ASSOC);

					$yonetici = $vt->query("SELECT * FROM yonetici WHERE id = '".$emlak["yonetici_id"]."'")->fetch(PDO::FETCH_ASSOC);

					$doping_paketleri = $vt->query("SELECT * FROM doping_paketleri WHERE id = '".$doping_ilanlari["paket_id"]."'")->fetch(PDO::FETCH_ASSOC);
					
				?>

				<tr>					
					
					<td class="text-center"><?php echo $emlak["id"]; ?></td>
					<td>
						<a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $yonetici["id"]; ?>&yetki=<?php echo $yonetici["yetki"]; ?>" target="_blank"> <?php echo $yonetici["adsoyad"]; ?> </a>
					</td>					
					<td>
						<a href="index.php?do=islem&emlak=emlak_duzenle&id=<?php echo $emlak["id"]; ?>" target="_blank"> <?php echo $emlak["baslik"]; ?> </a>
					</td>
					
					<td class="text-center"><pre><?php echo $doping_ilanlari["siparis_no"]; ?></pre></td>
					<td><?php echo $doping_ilanlari["tarih"]; ?></td>
					<td><?php echo $doping_ilanlari["fiyat"]; ?> <?php echo $doping_paketleri["periyot_fiyat_kur"]; ?></td>
					<td class="text-center"><?php echo $doping_ilanlari["odeme_tipi"]; ?></td>
					<td class="text-center">

						<?php $odeme_kontrol = $vt->query("SELECT * FROM doping_ilanlari WHERE odeme_durumu = 'Ödeme Bekliyor' AND ilan_id = '".$emlak["id"]."'"); ?>
						
						<?php if ($odeme_kontrol->rowCount()>0): ?>
							<span class="blink">Ödeme Bekliyor</span>
						<?php else: ?>
							<?php echo $doping_ilanlari["odeme_durumu"]; ?>
						<?php endif; ?>
					</td>
					<td>
						<?php if ($emlak["doping_onay"] == 1) { ?>
							<p class="text-center btn bg-success btn-xs btn-block">  Onaylı </p>
						<?php } else { ?>
							<p class="text-center btn bg-danger btn-xs btn-block blink">  Onay Bekliyor </p>
						<?php } ?>
					</td>

					<td>
						
						<?php if ($odeme_kontrol->rowCount()>0): ?>

						<a href="index.php?do=doping/ilan_doping&ilan_id=<?php echo $emlak["id"]; ?>" class="text-center btn btn-block btn-xs btn-link blink"> Ödeme Onayla </a>

						<?php endif; ?>

						<?php if ($emlak["doping_onay"] == "0") { ?> 
						
						<a href="index.php?do=siparisler/siparisler&tip=doping&islem=doping_onay&hareket=1&ilan_id=<?php echo $emlak["id"]; ?>" class="text-center btn btn-block btn-xs btn-success">  Onayla </a>
						
						<?php } ?>

						<?php if ($emlak["doping_onay"] == "1") { ?>
						
						<a href="index.php?do=siparisler/siparisler&tip=doping&islem=doping_onay&hareket=0&ilan_id=<?php echo $emlak["id"]; ?>" class="text-center btn btn-block btn-xs btn-warning">  Onayı Kaldır </a>

						<?php } ?>
						
						<a href="index.php?do=doping/ilan_doping&ilan_id=<?php echo $emlak["id"]; ?>" class="text-center btn btn-block btn-xs btn-primary"> Detaylar </a>
						
						<a href="#" data-toggle="modal" data-target="#sil<?php echo $doping_ilanlari["id"]; ?>" class="text-center btn btn-block btn-xs btn-danger"> Sil </a>

						<div class="modal modal-default fade" id="sil<?php echo $doping_ilanlari["id"]; ?>" style="display: none;">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header alert alert-info">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">×</span></button>
								<h4 class="modal-title"><i class="fa fa-close"></i> Silme Onayı Ver</h4>
							  </div>
							  <div class="modal-body">
									<div class="text-center">
										<h4 style="display: grid; width: 100%;"><pre><strong><?php echo $doping_ilanlari["siparis_no"]; ?></strong></pre> sipariş numaralı paket tamamen silinecektir. İşlemi onaylıyor musunuz?</h4>
									</div>
							  </div>
							  <div class="modal-footer">
								<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
								<a href="index.php?do=siparisler/siparisler&tip=doping&islem=sil&siparis_no=<?php echo $doping_ilanlari["siparis_no"]; ?>&ilan_id=<?php echo $emlak["id"]; ?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
							  </div>
							</div>
						  </div>
						</div>
				
					</td>

				</tr>

				<?php } ?>

			</tbody>
		</div>
	</form>