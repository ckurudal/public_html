<?php

	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
	$islem = $_GET["islem"];
	$hareket = $_GET["hareket"];
	$id = $_GET["id"];

?>
<?php	if ($islem == "onay") { ?>
	<div style="margin-top: 20px;"> <?php onay(); ?> </div>
<?php } ?>

<?php
	if ($islem == "siparis_onay") {

		if ($hareket == 0) {$onay = 0; $baslangic_tarihi = 0;}
		if ($hareket == 1) {$onay = 1; $baslangic_tarihi = date("Y-m-d");}

		$onayla = $vt->query("UPDATE magaza_uye_paket SET onay = '$onay', baslangic_tarihi = '$baslangic_tarihi' WHERE id = '$id'");

		// SMS BILDIRIM

		$paket_id 	= $vt->query("SELECT * FROM magaza_uye_paket WHERE id = '$id'")->fetch();
		$uye 		= $vt->query("SELECT * FROM yonetici WHERE id = '".$paket_id["uye_id"]."'")->fetch();

		if ($hareket == 1):

		mail_gonder($uye['email'], "Sayın ".$uye["adsoyad"].", üyelik paketiniz onaylanmıştır.", "Sayın ".$uye["adsoyad"].", üyelik paketiniz onaylanmıştır.");
		sms_gonder($uye['id'],"Sayın ".$uye["adsoyad"]."", " üyelik paketiniz onaylanmıştır.");

		endif;

		if ($hareket == 0):

		mail_gonder($uye['email'], "Sayın ".$uye["adsoyad"]." üyelik paketiniz yayından kaldırılmıştır.", "Sayın ".$uye["adsoyad"].", üyelik paketiniz yayından kaldırılmıştır.");
		sms_gonder($uye['id'],"Sayın ".$uye["adsoyad"]."", " üyelik paketiniz yayından kaldırılmıştır.");

		endif;

		go("index.php?do=siparisler/siparisler&tip=magaza&islem=onay",0);

	}
?>
<?php
	if ($islem == "siparis_sil") {

		$paket_id 	= $vt->query("SELECT * FROM magaza_uye_paket WHERE id = '$id'")->fetch();
		$uye 		= $vt->query("SELECT * FROM yonetici WHERE id = '".$paket_id["uye_id"]."'")->fetch();


		mail_gonder($uye['email'], "Sayın ".$uye["adsoyad"].", üyelik paketiniz silinmiştir.", "Sayın ".$uye["adsoyad"].", üyelik paketiniz silinmiştir.");
		sms_gonder($uye['id'],"Sayın ".$uye["adsoyad"]."", " üyelik paketiniz silinmiştir.");


		$sil = $vt->query("DELETE FROM magaza_uye_paket WHERE id = '$id'");

		if (yetki() == 0) {
			go("index.php?do=siparisler/siparisler&tip=magaza&islem=onay",0);
		} else {
			go("index.php?do=islem&ofis=yonetici&islem=duzenle&id={$_SESSION["id"]}&tab_goster=magaza_paketleri",0);
		}


	}
?>

<form class="form" action="" method="post">
	<div class="table-responsive">
		<table id="example1" class="table table-bordered dataTable" colspan="5" role="grid" aria-describedby="example1_info">
			<thead>
				<tr>
					<th><p><strong> ID </strong></p></th>
					<th><p><strong> Üye </strong></p></th>
					<th><p><strong> Sipariş Adı </strong></p></th>
					<th><p><strong> Sipariş No </strong></p></th>
					<th><p><strong> Ödeme Yöntemi </strong></p></th>
					<th><p><strong> Tutar </strong></p></th>
					<th><p><strong> Sipariş Tarihi </strong></p></th>
					<th><p><strong> Onay Tarihi </strong></p></th>
					<th><p><strong> Bitiş Tarihi </strong></p></th>
					<th><p><strong> Paket Kalan Süre </strong></p></th>
					<th><p><strong> Durum </strong></p></th>
					<th><p><strong> İşlemler </strong></p></th>
				</tr>
			</thead>
			<tbody>

				<?php

					$siparis_magaza 	= $vt->query("SELECT * FROM magaza_uye_paket ORDER by id DESC")->fetchAll(PDO::FETCH_ASSOC);

					foreach ($siparis_magaza as $siparis) {

						$yonetici 		= $vt->query("SELECT * FROM yonetici WHERE id = '".$siparis["uye_id"]."'")->fetch(PDO::FETCH_ASSOC);
						$paket 			= $vt->query("SELECT * FROM magaza_paket WHERE id = '".$siparis["paket_id"]."'")->fetch(PDO::FETCH_ASSOC);

				?>

				<tr>

					<td class="text-center">

						<?php echo $siparis["id"]; ?>

					</td>

					<td>

						<a target="_blank" href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $yonetici["id"]; ?>&yetki=<?php echo $yonetici["yetki"]; ?>"><?php echo $yonetici["adsoyad"]; ?></a>

					</td>

					<td class="text-center">

						<a target="_blank" href="index.php?do=islem&magaza=magaza_paketleri&islem=duzenle&id=<?php echo $paket["id"]; ?>"><?php echo $paket["paket_adi"]; ?></a>

					</td>

					<td class="text-center">

						<pre><?php echo $siparis["siparis_no"]; ?></pre>

					</td>

					<td class="text-center">

						<?php echo $siparis["odeme_tipi"]; ?>

					</td>

					<td class="text-center">

						<?php echo $siparis["fiyat"]; ?> <?php echo $siparis["fiyat_kur"]; ?>

					</td>

					<td class="text-center">

						<?php echo $siparis["siparis_tarihi"]; ?>

					</td>

					<td class="text-center">
						<?php if ($siparis["onay"] == "1") { ?>
						<?php echo $siparis["baslangic_tarihi"]; ?>
						<?php } else { ?>
							-
						<?php } ?>

					</td>

					<td class="text-center">

						<?php if ($siparis["onay"] == "1") { ?>
						<?php echo $siparis["bitis_tarihi"]; ?>
						<?php } else { ?>
							-
						<?php } ?>

					</td>

					<td class="text-center">

						<?php if ($siparis["bitis_tarihi"]>date("Y-m-d")) { ?>

						<span class="btn bg-info btn-xs btn-block">  <?php echo kalan_sure(date("Y-m-d"), $siparis["bitis_tarihi"]); ?> Gün Kaldı.  </span>

						<?php } else { ?>

						<span class="btn bg-danger btn-xs btn-block"> Süresi Doldu  </span>

						<?php } ?>

					</td>

					<td class="text-center">

						<?php if ($siparis["onay"] == "1") { ?>
						<p class="text-center btn btn-block bg-success btn-xs btn-block">  Onaylı </p>
						<?php } ?>
						<?php if ($siparis["onay"] == "0") { ?>
						<p class="text-center btn btn-block bg-danger btn-xs btn-block blink">  Onay Bekliyor </p>
						<?php } ?>

					</td>

					<td>
						<?php if ($siparis["onay"] == "0") { ?>
						<a href="index.php?do=siparisler/siparisler&tip=magaza&islem=siparis_onay&id=<?php echo $siparis["id"]; ?>&hareket=1" class="text-center btn btn-block btn-xs btn-success">  Onayla </a>
						<?php } ?>
						<?php if ($siparis["onay"] == "1") { ?>
						<a href="index.php?do=siparisler/siparisler&tip=magaza&islem=siparis_onay&id=<?php echo $siparis["id"]; ?>&hareket=0" class="text-center btn btn-block btn-xs btn-warning">  Onayı Kaldır </a>
						<?php } ?>

						<a href="index.php?do=magaza/uye_paket_duzenle&id=<?php echo $yonetici["id"]; ?>&paket_id=<?php echo $siparis["id"]; ?>" class="text-center btn btn-block btn-xs btn-primary"> Detaylar </a>

						<a href="#" data-toggle="modal" data-target="#sil<?=$siparis["id"];?>" class="text-center btn btn-block btn-xs btn-danger"> Sil </a>

						<div class="modal modal-default fade" id="sil<?=$siparis["id"];?>" style="display: none;">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header alert alert-info">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">×</span></button>
								<h4 class="modal-title"><i class="fa fa-close"></i> Silme Onayı Ver</h4>
							  </div>
							  <div class="modal-body">
									<div class="text-center">
										<h4 style="display: grid; width: 100%;"><pre><strong><?=$siparis["siparis_no"]?></strong></pre> sipariş numaralı paket silinecektir. İşlemi onaylıyor musunuz?</h4>
									</div>
							  </div>
							  <div class="modal-footer">
								<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
								<a href="index.php?do=siparisler/siparisler&tip=magaza&islem=siparis_sil&id=<?php echo $siparis["id"]; ?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
							  </div>
							</div>
						  </div>
						</div>

					</td>

				</tr>

				<?php } ?>

			</tbody>
		</table>
	</div>
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
