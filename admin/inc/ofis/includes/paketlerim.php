<?php if (mPaketOnaysiz($id)==0): ?>

	<div class="alert alert-default text-center">
		<h5> <i class="fa fa-warning fa-3x"></i> </h5>
		<br>
		<h4>Satın alınmış bir üyelik paketiniz bulunmuyor.</h4>
		<h6> Üyelik paketi satın almak istiyorsanız. Lütfen üyelik paketlerini inceleyiniz. </h6>
		<br>
		<a href="index.php?do=siparisler/siparisler&paket=magaza" class="btn btn-primary btn-lg"> <i class="fa fa-arrow-left"></i> Üyelik Paketleri </a>
		<br>
		<br>
	</div>

<?php else: ?>
    <a href="index.php?do=siparisler/siparisler&paket=magaza" class="btn btn-default pull-right" style="margin-top: 8px; margin-right: 8px;"><i class="fa fa-plus"></i> Yeni Paket Satın Al</a>
    <div class="alert alert-warning">
        <strong> Üyelik Paketleri </strong>
    </div>
    <div class="box">
	<div class="box-body">

		<?php
			$stmt_magaza_paket = $vt->prepare("SELECT * FROM magaza_uye_paket WHERE uye_id = ?");
			$stmt_magaza_paket->execute([$_SESSION["id"]]);
			$magaza_uye_paket = $stmt_magaza_paket->fetchAll();
			foreach ($magaza_uye_paket as $paket) {
		?>

		<div class="box box-default collapsed-box">

			<div class="box-header with-border" class="btn btn-box-tool" data-widget="collapse" style="cursor: pointer; color: #fff; background: #4994ca!important;">

			<h4 class="box-title">

				<strong>

					<i class="fa fa-dropbox" style="color:#fff;"></i>

					<?php echo $paket["paket_adi"]; ?>

				</strong>

			  <?php if ($paket["onay"] == 0): ?>

				/ Ödeme Bekliyor

			  <?php endif; ?>

			</h4>

			  <div class="box-tools pull-right" style="display:block;">
				<button type="button" class="btn btn-default" data-widget="collapse"><i class="fa fa-plus"></i>
				</button>
			  </div>
			  <!-- /.box-tools -->
			</div>
			<!-- /.box-header -->
			<div class="box-body" style="display: none;">
				 <div class="table-responsive border-top">
					<table class="table table-hover text-nowrap">
						<tbody>
							<tr>
								<th colspan="2"><strong>PAKET DETAYLARI</strong></th>
								<th class="text-center"><strong>PERİYOT</strong></th>
								<th class="text-center"><strong>DURUM</strong></th>
							</tr>
							<tr>
								<th class="bg-success text-white" style="background:#eee;" colspan="4"><h5><i class="fa fa-dropbox"></i> <?php echo $paket["paket_adi"]; ?></h5></th>
							</tr>
							<tr>
								<td class="text-right">
									<p>İlan Ekleme Limiti (Aylık):</p>
									<hr>
									<p>İlan Başına Resim:</p>
									<hr>
									İlan Yayın Süresi:
									<hr>
									<?php if (yetki() == 0 || yetki() == 2 ): ?>
									Danışman Limiti:
									<hr>
									Özel Firma Profil Sayfası:
									<hr>
									İlanlara Danışman Atama:
									<?php endif; ?>

								</td>
								<td>
									<p><strong><?php echo $paket["aylik_limit"]; ?> Adet</strong></p>
									<hr>
									<p><strong><?php echo $paket["resim_limit"]; ?> Adet</strong> </p>
									<hr>
									<p><strong><?php echo $paket["ilan_sure"]; ?> <?php echo $paket["ilan_sure_zaman"]; ?></strong> </p>
									<hr>
									<?php if (yetki() == 0 || yetki() == 2 ): ?>
									<p><strong><?php echo $paket["danisman_limit"]; ?> Adet</strong> </p>
									<hr>
									<p><strong>Aktif</strong> </p>
									<hr>
									<p><strong>Aktif</strong> </p>
									<?php endif; ?>

								</td>
								<td class="text-center">

									<p>

										<?php

											$bugun = date("Y-m-d");

											if ($paket["bitis_tarihi"]<$bugun) {

												echo "Süresi Doldu";

											} else {

												echo kalan_sure(date("Y-m-d"), $paket["bitis_tarihi"])." Gün Kaldı.";

											}

										?>

									</p>

									<hr>

									<?php if ($paket["onay"] == 0): ?>

									<p><strong>BAŞLANGIÇ TARİHİ: Onay Bekliyor</strong></p>

									<?php else: ?>

									<p><strong>BAŞLANGIÇ TARİHİ: <?php echo $paket["baslangic_tarihi"]; ?></strong></p>

									<?php endif; ?>


									<hr>

									<p>
										<strong>

											BİTİŞ TARİHİ:

											<?php echo paket_kalan($paket["bitis_tarihi"]); ?>

										</strong>
									</p>

									<hr>

									<p>SİPARİŞ NO: <strong><?php echo $paket["siparis_no"]; ?></strong></p>

									<hr>

								</td>
								<td class="text-center">

									<?php if ($paket["onay"] == 1) { ?>

									<a href="#" class="btn btn-success btn-block"><strong>AKTİF</strong></a>

									<p class="btn btn-primary btn-block">
										<strong>

											<?php

												$bugun = date("Y-m-d");

												if ($paket["bitis_tarihi"]<$bugun) {

													echo "Süresi Doldu";

												} else {

													echo kalan_sure(date("Y-m-d"), $paket["bitis_tarihi"])." Gün Kaldı.";

												}

											?>



										</strong>
									</p>

									<?php } else { ?>

									<a href="#" class="btn btn-danger btn-block"><strong>PASİF</strong></a>
									<a href="index.php?do=siparisler/siparisler&paket=magaza&odeme_sayfasi=<?php echo $paket["siparis_no"]; ?>&fiyat=<?php echo $paket["fiyat"]; ?>&paket=<?php echo $paket["paket_adi"]; ?>" class="btn btn-warning btn-block"><strong><i class="fa fa-shopping-basket"></i> ÖDEME YAP</strong></a>

									<?php } ?>




								</td>
							</tr>
							<tr>

								<th colspan="1">
									Sipariş Tarihi: <strong><?php echo $paket["siparis_tarihi"]; ?></strong>
								</th>

								<th colspan="1">
									Ödeme Yöntemi: <strong><?php echo $paket["odeme_tipi"]; ?></strong>
								</th>

								<th colspan="1">


										Ödeme Durumu:

										<?php if ($paket["onay"] == 1) { ?>

										<strong>Ödendi</strong>

										<?php } else { ?>

										<strong>Ödeme Bekliyor</strong>

										<?php } ?>


								</th>

								<th class="text-center" colspan="1">
									FİYAT: <?php echo $paket["fiyat"]; ?> <?php echo $paket["fiyat_kur"]; ?>

								</th>
							</tr>
							<tr>
								<th class="bg-light" colspan="3">
								</th>
								<th class="bg-light" colspan="1">

									<a class="btn btn-danger btn-block" href="#" data-toggle="modal" data-target="#sil<?php echo $paket["id"] ?>" class="text-center btn btn-block btn-xs btn-danger"> Kaldır </a>

									<div class="modal modal-default fade" id="sil<?php echo $paket["id"] ?>" style="display: none;">
									  <div class="modal-dialog">
										<div class="modal-content">
										  <div class="modal-header alert alert-info">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true">×</span></button>
											<h4 class="modal-title"><i class="fa fa-close"></i> Silme Onayı Ver</h4>
										  </div>
										  <div class="modal-body">
												<h4 style="display: grid; width: 100%;">  "<?php echo $paket["paket_adi"]; ?>" isimli paket silinecektir. İşlemi onaylıyor musunuz?</h4>
										  </div>
										  <div class="modal-footer">
											<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
											<a href="index.php?do=siparisler/siparisler&tip=magaza&islem=siparis_sil&id=<?php echo $paket["id"]; ?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
										  </div>
										</div>
									  </div>
									</div>
								</th>

							</tr>

						</tbody>
					</table>

					<div class="alert alert-primary">
						<strong>ÖNEMLİ NOT:</strong> Paketi kaldırırsanız ödemeniz geri iade edilmez.
					</div>
				</div>
			</div>
			<!-- /.box-body -->
		  </div>

			<br>

			<h6 class="pull-right">

				Toplam Ödeme:

				<strong>

				<?php

					$stmt_toplam_fiyat = $vt->prepare("SELECT * FROM magaza_uye_paket WHERE uye_id = ?");
					$stmt_toplam_fiyat->execute([$_SESSION["id"]]);
					$toplam_fiyat = $stmt_toplam_fiyat->fetchAll();

					$tutar = 0;

					foreach ($toplam_fiyat as $toplam) {
						$tutar = $tutar + $toplam["fiyat"];
					}

					echo $tutar." TL";

				?>

				</strong>

			</h6>

		<?php } ?>

		<?php

			if ($uyelik_yetki["yetki"] == 0) {

		?>

		<div class="table-responsive">
			<table id="example7" class="table table-bordered table-striped table-hover dataTable" role="grid" aria-describedby="example8_info" style="width: 100% !important">
				<thead>
					<tr>
						<td style="width:1%;"> Paket Adı </td>
						<td style="width:1%;"> Başlangıç Tarihi </td>
						<td style="width:1%;"> Bitiş Tarihi </td>
						<td style="width:1%;"> Bitiş Süresi </td>
						<td style="width:1%;"> Fiyat </td>
						<td style="width:1%;"> Durum </td>
						<td class="text-center" style="width:1% !important; white-space: nowrap;"> İşlemler </td>
					</tr>
				</thead>
				<tbody>
				<?php

					$magaza_paket_uye=$vt->query("SELECT * FROM magaza_uye_paket WHERE uye_id = '$id'")->fetchAll(PDO::FETCH_OBJ);

					foreach ($magaza_paket_uye as $paket) {

						$magaza_paket=$vt->query("SELECT * FROM magaza_paket WHERE id = '".$paket->paket_id."'")->fetch(PDO::FETCH_OBJ);

						$tarih1= new DateTime($paket->baslangic_tarihi);
						$tarih2= new DateTime($paket->bitis_tarihi);
						$bitis_sure= $tarih1->diff($tarih2);
						$bitis = $bitis_sure->format('%a gün kaldı.');

				?>
					<tr>
						<th>
							<a href="index.php?do=magaza/uye_paket_duzenle&id=<?php echo $id; ?>&paket_id=<?php echo $paket->id; ?>"> <h5> <strong> <?php echo $paket->paket_adi; ?> </strong> </h5> </a>

						</th>
						<th><?php echo $paket->baslangic_tarihi; ?></th>
						<th><?php echo $paket->bitis_tarihi; ?></th>
						<th><?php echo $bitis; ?></th>
						<th> <?php echo $paket->fiyat; ?> <?php echo $paket->fiyat_kur; ?> </th>
						<th>

							<?php if ($paket->onay == 0) { ?>
								<span class="btn bg-danger btn-xs btn-block"> <strong> Onay Bekliyor </strong> </span>
							<?php } ?>
							<?php if ($paket->onay == 1) { ?>
								<span class="btn bg-success btn-xs btn-block"> <strong> Onaylandı </strong> </span>
							<?php } ?>

						</th>
						<th>

							<a href="index.php?do=magaza/uye_paket_duzenle&id=<?php echo $id; ?>&paket_id=<?php echo $paket->id; ?>" class="btn btn-primary btn-xs btn-block"> <i class="fa fa-edit"></i> Düzenle </a>

							<?php if ($paket->onay == 0) { ?>
							<a href="index.php?do=magaza/uye_paket_duzenle&id=<?php echo $id; ?>&paket_id=<?php echo $paket->paket_id; ?>&siparis_no=<?php echo $paket->siparis_no; ?>&islem=onay" class="btn btn-success btn-xs btn-block"> <i class="fa fa-check"></i> Onayla </a>
							<?php } ?>
							<?php if ($paket->onay == 1) { ?>
							<a href="index.php?do=magaza/uye_paket_duzenle&id=<?php echo $id; ?>&paket_id=<?php echo $paket->paket_id; ?>&siparis_no=<?php echo $paket->siparis_no; ?>&islem=iptal" class="btn btn-warning btn-xs btn-block"> <i class="fa fa-close"></i> İptal Et </a>
							<?php } ?>
							<a href="#" data-toggle="modal" data-target="#<?php echo $paket->id; ?>" title="Sil" class="btn btn-inverse btn-xs btn-block"> <i class="fa fa-trash"></i> Sil </a>

							<div class="modal modal-default fade" id="<?php echo $paket->id; ?>" style="display: none;">
							  <div class="modal-dialog">
								<div class="modal-content">
								  <div class="modal-header alert alert-info">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">×</span></button>
									<h4 class="modal-title"><i class="fa fa-close"></i> Silme Onayı Ver</h4>
								  </div>
								  <div class="modal-body">
										<h4 style="display: grid; width: 100%;">  "<?php echo $paket->paket_adi; ?>" isimli paket silinecektir. İşlemi onaylıyor musunuz?</h4>
								  </div>
								  <div class="modal-footer">
									<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
									<a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $id; ?>&yetki=<?php echo $dan["yetki"]; ?>&paket_sil=<?php echo $paket->id; ?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
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
		<?php } ?>
	</div>
</div>
<?php endif; ?>