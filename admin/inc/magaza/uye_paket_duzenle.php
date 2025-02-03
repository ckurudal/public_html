<?php

	$id = $_GET["id"];
	$paket_id = $_GET["paket_id"];
	$islem = $_GET["islem"];
	$siparis_no = $_GET["siparis_no"];

?>

<section class="content-header"> 
	<i class="fa fa-shopping-basket fa-2x pull-left"></i>
	Üye Mağaza Paketi Ayarları	
	<p> <small> Mağaza Paketleri </small> </p>
</section>

<section class="content">  

		<?php

			$yonetici 				= $vt->query("SELECT * FROM yonetici WHERE id = '$id'")->fetch(PDO::FETCH_OBJ);
			$magaza_paket_uye 		= $vt->query("SELECT * FROM magaza_uye_paket WHERE id = '$paket_id'")->fetch(PDO::FETCH_OBJ);
			$magaza_paket 			= $vt->query("SELECT * FROM magaza_paket WHERE id = '$magaza_paket_uye->paket->id'")->fetch(PDO::FETCH_OBJ);
			$magaza_paket_periyot 	= $vt->query("SELECT * FROM magaza_paket_periyot WHERE id = '".$magaza_paket_uye->periyot_id."'")->fetch(PDO::FETCH_OBJ);
			$subeler 				= $vt->query("SELECT * FROM subeler WHERE yetkiliuye = '".$yonetici->id."'")->fetch(PDO::FETCH_OBJ);

			$tarih = date('Y-m-d');

				$tarih1 = date_create($tarih);
				$tarih2 = date_create($magaza_paket_uye->bitis_tarihi);
				 
				//tarihler arasındaki fark
				$diff = date_diff($tarih1,$tarih2);
				$paket_kalan_sure = $diff->format("%a"); 

		?>

		<?php		


			if (isset($_POST["kaydet"])) {

				$periyot_sure = $_POST["periyot_sure"];
				$periyot_sure_zaman = $_POST["periyot_sure_zaman"];
				$odeme_tipi = $_POST["odeme_tipi"];
				$odeme_durumu = $_POST["odeme_durumu"];
				$resim_limit = $_POST["resim_limit"];
				$danisman_limit = $_POST["danisman_limit"];
				$aylik_limit = $_POST["aylik_limit"];
				$ilan_sure = $_POST["ilan_sure"];
				$ilan_sure_zaman = $_POST["ilan_sure_zaman"];
				$fiyat = $_POST["fiyat"];
				$fiyat_kur = $_POST["fiyat_kur"];
				$aciklama = $_POST["aciklama"];
				$siparis_notu = $_POST["siparis_notu"];
		
				if 		($periyot_sure_zaman == "Gün") { $sure = $periyot_sure * 1; }
				else if ($periyot_sure_zaman == "Ay") 	{ $sure = $periyot_sure * 30; }
				else if ($periyot_sure_zaman == "Yıl") { $sure = $periyot_sure * 365; }

				// echo $paket_sure;

				$paket_bitis = strtotime(''.$sure.' day',strtotime($magaza_paket_uye->baslangic_tarihi));
				$paket_bitis = date('Y-m-d', $paket_bitis );

				$kalan_sure = strtotime('-'.$magaza_paket_uye->baslangic_tarihi.' day',strtotime($tarih));
				$kalan_sure = date('Y-m-d', $kalan );

				echo $paket_bitis;
				

				$kaydet = $vt->query("UPDATE magaza_uye_paket SET periyot_sure = '$periyot_sure', aciklama = '$aciklama', siparis_notu = '$siparis_notu', periyot_sure_zaman = '$periyot_sure_zaman', bitis_tarihi = '$paket_bitis', odeme_tipi = '$odeme_tipi', resim_limit = '$resim_limit', danisman_limit = '$danisman_limit', aylik_limit = '$aylik_limit', ilan_sure = '$ilan_sure', ilan_sure_zaman = '$ilan_sure_zaman', fiyat = '$fiyat', fiyat_kur = '$fiyat_kur' WHERE id = '$paket_id'");
				
				echo $kalan_sure;

				go('index.php?do=magaza/uye_paket_duzenle&id='.$id.'&paket_id='.$paket_id.'&islem=tamam');


			}

			if ($islem=="onay") {

				// $kalan_sure = $_POST["kalan_sure"];

				$onay = $vt->query("UPDATE magaza_uye_paket SET onay = 1, baslangic_tarihi = '$tarih' WHERE uye_id = '$id' AND siparis_no = '$siparis_no'");

				if ($onay == true) {

					go('index.php?do=magaza/uye_paket_duzenle&id='.$id.'&paket_id='.$paket_id.'&islem=tamam');

				}

			}

			if ($islem == "iptal") {

				$iptal = $vt->query("UPDATE magaza_uye_paket SET onay = 0, iptal_tarih = '$tarih' WHERE uye_id = '$id' AND siparis_no = '$siparis_no'");

				if ($iptal == true) {

					go('index.php?do=magaza/uye_paket_duzenle&id='.$id.'&paket_id='.$paket_id.'&islem=tamam');

				}

			}

			if ($islem == "tamam") {

				onay();
				echo "<br>";
				
			}

		?>


	<form class="form" action="" method="post">
		<div class="row">
			<div class="col-md-9">
				
				 <div class="box">
				 	<div class="box-header with-border">
					  <h3 class="box-title"> Üye Paketi Düzenle </h3>
					</div>
					<div class="box-body"> 
							<div class="row">

								<div class="col-md-12">

									<div class="form-group">
										<div class="row">
											<div class="col-md-4">
												<label class="control-label">Üye Bilgisi:</label>
												<a class="form-control" target="_blank" href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $id; ?>&yetki=<?php echo $yonetici->yetki; ?>"><strong> <?php echo $yonetici->adsoyad; ?></strong></a>												
											</div>
											<?php if ($yonetici->yetki==2) { ?>
											<div class="col-md-4">
												<label class="control-label">Mağaza:</label>											

												<a class="form-control" target="_blank" href="index.php?do=islem&ofis=subeekle&islem=duzenle&id=<?php echo $subeler->id; ?>"><strong><?php echo $subeler->adi; ?></strong></a>	

											</div>
											<?php } ?> 
											<div class="col-md-4"> 
												<label class="control-label">Üyelik Tipi:</label>											
												<?php if ($yonetici->yetki == 1) { ?>														
												<a class="form-control" target="_blank" href="index.php?do=islem&ofis=yonetici&islem=liste&uye=bireysel">					
													<strong>Bireysel Üye</strong>
												</a>											
												<?php } ?>	
												<?php if ($yonetici->yetki == 2) { ?>														
												<a class="form-control" target="_blank" href="index.php?do=islem&ofis=yonetici&islem=liste&uye=kurumsal">
													<strong>Kurumsal Üye</strong>
												</a>											
												<?php } ?>	
												<?php if ($yonetici->yetki == 3) { ?>														
												<a class="form-control" target="_blank" href="index.php?do=islem&ofis=yonetici&islem=liste&uye=danisman">
													<strong>Danışman</strong>
												</a>											
												<?php } ?>	 
											</div>											
										</div>
									</div> 

									<div class="form-group">
										<div class="row">

											<div class="col-md-4">
												<?php
													$odeme_tipi = $vt->query("SELECT * FROM odeme_tipi WHERE durum = '0'")->fetchAll();
													$odeme_tipi_ver = $vt->query("SELECT * FROM odeme_tipi WHERE durum = '0'")->fetch();
												?>
												<label class="control-label"> Ödeme Yöntemi </label>
												<select class="form-control select2" name="odeme_tipi">													
													<?php if ($magaza_paket_uye->odeme_tipi == "") { ?>
														<option value="-">Seçiniz</option>
													<?php } else { ?>
														<option value="<?php echo $magaza_paket_uye->odeme_tipi; ?>"><?php echo $magaza_paket_uye->odeme_tipi; ?></option>
													<?php } ?>
													
													<?php 									
														foreach ($odeme_tipi as $odeme) {
													?>
													<option value="<?php echo $odeme["adi"]; ?>"><?php echo $odeme["adi"]; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-md-4">
												
												<label class="control-label"> Durum: </label>
												<?php if ($magaza_paket_uye->onay == 0) { ?>
													<input type="text" class="form-control" disabled="" name="" value="Henüz Onay Bekliyor"> 
												<?php } else { ?>
													<input type="text" class="form-control" disabled="" name="" value="Onaylandı">												
												<?php } ?>

											</div>
											

											<div class="col-md-4">

												<label class="control-label">Sipariş NO:</label>
												<input type="text" class="form-control" name="" disabled="" value="<?php echo $magaza_paket_uye->siparis_no; ?>">

											</div>
 
										</div>
									</div> 
									<div class="form-group">
										<div class="row">

											<div class="col-md-4">
												<label class="control-label">Resim Limit:</label>
												<input type="text" class="form-control" name="resim_limit" value="<?php echo $magaza_paket_uye->resim_limit; ?>">
												<!-- <p>Sınırsız/Limitsiz için 0 yazınız.</p> -->
											</div>



											<div class="col-md-4">
												<label class="control-label">Danışman Limit: <small>[Sadece kurumsal üyeler danışman ekleyebilir.]</small></label>
                                                <?php if ($yonetici->yetki==2): ?>
												<input type="text" class="form-control" name="danisman_limit" value="<?php echo $magaza_paket_uye->danisman_limit; ?>">
                                                <?php else: ?>
                                                    <input type="text" disabled class="form-control" placeholder="Sadece kurumsal üyeler danışman ekleyebilir.">
                                                <?php endif; ?>
												<!-- <p>Sınırsız/Limitsiz için 0 yazınız.</p> -->
											</div>



											<div class="col-md-4">
												<label class="control-label">Aylık İlan Limiti:</label>
												<input type="text" class="form-control" name="aylik_limit" value="<?php echo $magaza_paket_uye->aylik_limit; ?>">
												<!-- <p>Sınırsız/Limitsiz için 0 yazınız.</p> -->
											</div>

											<div class="col-md-2">										
												<label class="control-label">Paket Süresi:</label>
												<input type="text" placeholder="Süre" class="form-control" name="periyot_sure" value="<?php echo $magaza_paket_uye->periyot_sure; ?>">
											</div> 

											<div class="col-md-2">										
												<label class="control-label"> &nbsp; </label>
												<select class="form-control" name="periyot_sure_zaman">
													<option selected=""> <?php echo $magaza_paket_uye->periyot_sure_zaman; ?> </option> 
													<option value="Gün">Gün</option>
													<option value="Ay">Ay</option>
													<option value="Yıl">Yıl</option>
												</select>
											</div> 

											<div class="col-md-2">
												<label class="control-label">Ücretlendirme:</label>
												<input type="text" class="form-control" name="fiyat" placeholder="Fiyat" value="<?php echo $magaza_paket_uye->fiyat; ?>">
											</div>

											<div class="col-md-2">		
												<label class="control-label"> &nbsp; </label>																		
												<select class="form-control" name="fiyat_kur">
													<option selected=""> <?php echo $magaza_paket_uye->fiyat_kur; ?> </option>
													<?php 
														// Para Birimi
														$parabirim = mysql_query("select * from para_birimi where id");
														while ($paraver = mysql_fetch_array($parabirim)) {
													?>
													<option value="<?=$paraver["ad"];?>"> <?=$paraver["ad"];?> </option>
													<?php } ?>
												</select>
											</div> 

											<div class="col-md-2">
												<label class="control-label">İlan Süresi:</label>
												<input type="text" class="form-control" name="ilan_sure" value="<?php echo $magaza_paket_uye->ilan_sure; ?>">
											</div>

											<div class="col-md-2">
												<label class="control-label"> &nbsp; </label>
												<select class="form-control" name="ilan_sure_zaman">
													<option selected=""><?php echo $magaza_paket_uye->ilan_sure_zaman; ?></option>
													<option value="Gün">Gün</option>
													<option value="Ay">Ay</option>
													<option value="Yıl">Yıl</option>
												</select>
											</div>											


										</div>  
									</div>  

								</div>

							</div>

					</div>


				</div>
				<!--
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title"> Sipariş Notları </h3>
					</div>
					<div class="box-body">
						<div class="row">			
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label"> Açıklama <small>[Zorunlu Değil]</small></label>
									<textarea class="form-control" placeholder="Açıklama" name="aciklama" rows="25"><?php echo $magaza_paket_uye->aciklama; ?></textarea>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label"> Sipariş Notu <small>[Zorunlu Değil]</small></label>
									<textarea class="form-control" placeholder="Sipariş İçin Notlarınız" name="siparis_notu" rows="25"><?php echo $magaza_paket_uye->siparis_notu; ?></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				-->
			</div>
			<div class="col-md-3">
				
				
				 <div class="box">
				 	<div class="box-header with-border">
					  <h3 class="box-title"> Paket Özeti </h3>
					</div>
					<div class="box-body">
						<div class="row">

							<div class="col-md-12">
								<label class="control-label">Paket Adı:</label>
								<input type="text" class="form-control" name="" disabled="" value="<?php echo $magaza_paket_uye->paket_adi; ?>">
							</div>

							<div class="col-md-12">										
								<label class="control-label"> Sipariş Tarihi: </label>
								<div class="input-group date">
									<input type="text" class="form-control" disabled value="<?php echo $magaza_paket_uye->siparis_tarihi; ?>">
					                <div class="input-group-addon">
					                	<i class="fa fa-calendar"></i>
					                </div>										
				                </div>								
							</div>
							
							<div class="col-md-12">

								<label class="control-label">Başlangıç / Onay Tarihi:</label>
								
								<?php if ($magaza_paket_uye->onay == 0) { ?>

									<input type="text" class="form-control" disabled="" name="" placeholder="Henüz Onay Bekliyor">	

								<?php } else { ?>

								<div class="input-group date">
									<input type="text" class="form-control" disabled value="<?php echo $magaza_paket_uye->baslangic_tarihi; ?>">
					                <div class="input-group-addon">
					                	<i class="fa fa-calendar"></i>
					                </div>										
				                </div>									

								<?php } ?>

							</div>

							<div class="col-md-12">

								<label class="control-label">Bitiş Tarihi:</label>
								
								<?php if ($magaza_paket_uye->onay == 0) { ?>
										
									<input type="text" class="form-control" disabled="" name=" " value="Henüz Onay Bekliyor">													

								<?php } else { ?>

								<div class="input-group date">
									<input type="text" class="form-control" disabled value="<?php echo $magaza_paket_uye->bitis_tarihi; ?>">
					                <div class="input-group-addon">
					                	<i class="fa fa-calendar"></i>
					                </div>										
				                </div>	
								
								<?php } ?>

							</div>
											
							<div class="col-md-12">
								<label class="control-label"> Kalan Süre: </label>
								
								<?php if ($magaza_paket_uye->onay == 0) { ?>

									<input type="text" class="form-control" disabled="" name="" value="Henüz Onay Bekliyor">	
									

								<?php } else { ?>

								<p class="form-control"> <strong class="text-danger"> <?php if ($magaza_paket_uye->bitis_tarihi>date("Y-m-d")) { ?>  <?php echo $paket_kalan_sure; ?> Gün Kaldı. <?php } else { ?> Süresi Doldu <?php } ?> </strong> </p> 
								
								<?php } ?>

							</div> 

						</div>
					</div>

					<div class="box-footer">
						<?php if ($magaza_paket_uye->onay == 0) { ?>
						<a href="index.php?do=magaza/uye_paket_duzenle&id=<?php echo $id; ?>&paket_id=<?php echo $paket_id; ?>&siparis_no=<?php echo $magaza_paket_uye->siparis_no; ?>&islem=onay" type="submit" class="btn btn-block btn-warning btn-blcok btn-lg" name="onay">
							<i class="fa fa-check"></i> <strong>PAKETİ ONAYLA</strong>
						</a> 
						<?php } ?>
						<?php if ($magaza_paket_uye->onay == 1) { ?>
						<a href="index.php?do=magaza/uye_paket_duzenle&id=<?php echo $id; ?>&paket_id=<?php echo $paket_id; ?>&siparis_no=<?php echo $magaza_paket_uye->siparis_no; ?>&islem=iptal" class="text-danger btn bt btn-block btn-danger btn-lg">
							<i class="fa fa-times"></i> <strong>PAKETİ İPTAL ET</strong>
						</a>  
						<?php } ?>
						<button type="submit" class="btn btn-success btn-lg btn-block" name="kaydet"> <i class="fa fa-save"></i> <strong>KAYDET</strong> </button>
					 </div>

				</div>
			</div>
	</form>
</section>