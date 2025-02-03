<?php

	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
	
	uyeYasak(yetki());
	

	$islem = $_GET["islem"];

	$paket = $vt->query("SELECT * FROM doping_paketleri WHERE id")->fetchAll(PDO::FETCH_OBJ);

	$paket_1 = $vt->query("SELECT * FROM doping_paketleri WHERE id = '1'")->fetch(PDO::FETCH_OBJ);
	$paket_2 = $vt->query("SELECT * FROM doping_paketleri WHERE id = '2'")->fetch(PDO::FETCH_OBJ);
	$paket_3 = $vt->query("SELECT * FROM doping_paketleri WHERE id = '3'")->fetch(PDO::FETCH_OBJ);
	$paket_4 = $vt->query("SELECT * FROM doping_paketleri WHERE id = '4'")->fetch(PDO::FETCH_OBJ);

?>

<section class="content-header">

	<i class="fa fa-rocket fa-2x pull-left"></i>
	Doping Ayarları
	<p> <small> Standart Doping Ayarları </small> </p>

</section>
<?php
if (isset($_POST["kaydet"])) { ?>
<section class="content">
	<?php

		foreach ($paket as $p) {

					$doping_adi 					= $_POST["doping_adi_{$p->id}"];
					$periyot_fiyat_kur		= $_POST["periyot_fiyat_kur_{$p->id}"][0];
					$sicak_firsat					= $_POST["sicak_firsat_{$p->id}"];
					$vitrin_ilan					= $_POST["vitrin_ilan_{$p->id}"];
					$one_cikan						= $_POST["one_cikan_{$p->id}"];
					$ust_sira							= $_POST["ust_sira_{$p->id}"];
					$renkli_bold					= $_POST["renkli_bold_{$p->id}"];
					$acil_ilan						= $_POST["acil_ilan_{$p->id}"];
					$sure									= $_POST["sure_{$p->id}"];
					$sure_zaman						= $_POST["sure_zaman_{$p->id}"];

				// DANISMAN AYARI TABLO -> ID 1 = DANIMSMAN

				$kaydet_paket_1 = $vt->query("UPDATE doping_paketleri SET

					doping_adi 				= '$doping_adi',
					periyot_fiyat_kur = '$periyot_fiyat_kur',
					sicak_firsat			= '$sicak_firsat',
					vitrin_ilan				= '$vitrin_ilan',
					one_cikan					= '$one_cikan',
					ust_sira					= '$ust_sira',
					renkli_bold				= '$renkli_bold',
					acil_ilan					= '$acil_ilan',
					sure							= '$sure',
					sure_zaman				= '$sure_zaman'

					WHERE id = '$p->id'");

					go("index.php?do=doping/doping_ayarlari&islem=onay",0);


		}

	?>
</section>
<?php } ?>

<?php	if ($islem == "onay") { ?>
	<section class="content">
		<?php onay(); ?>
	</section>
<?php } ?>

<section class="content">

	<div class="alert alert-warning text-center">
		<h5> Kullanıcıların ilan ekleme/düzenleme aşamalarında satın almak istediği doping özelliklerini ve ücretlerini tanımlayabilirsiniz. </h5>
	</div>

	<br>
	<form class="form" action="" method="post">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title"> Doping Ayarları </h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-4 hidden-xs">
					<div class="form-group">
						<label class="control-label"> Doping Adı </label>
					</div>
					<div class="form-group hidden">
						<label class="control-label"> Para Birimi </label>
					</div>
					<div class="form-group">
						<label class="control-label"> Süre </label>
					</div>
					<div class="form-group">
						<label class="control-label"> Sıcak Fırsatlarda Göster </label>
					</div>
					<div class="form-group">
						<label class="control-label"> Vitrin İlanlarında Göster </label>
					</div>
					<div class="form-group">
						<label class="control-label"> Öne Çıkan İlanlarda Göster </label>
					</div>
					<div class="form-group">
						<label class="control-label"> Üst Sıralarda Listele </label>
					</div>
					<div class="form-group">
						<label class="control-label"> Listelemelerde Renkli Arka Plan ve Bold Yazı </label>
					</div>
					<div class="form-group">
						<label class="control-label"> Anasayfa Acil İlanlar </label>
					</div>
				</div>

				<!-- PAKET 1 -->

				<div class="col-md-2">
					<div class="form-group">
                        <div class="hidden-lg">
                            <p class="btn bg-success btn-block" style="margin-bottom: 15px;"><strong>PAKET 1</strong></p>
                        </div>
						<input type="text" class="form-control" name="doping_adi_1" value="<?php echo $paket_1->doping_adi; ?>">
					</div>
					<div class="form-group hidden">
						<div class="row">
							<div class="col-md-6">
								<select class="form-control" name="periyot_fiyat_kur_1[]">
									<option selected="selected"> <?php echo $paket_1->periyot_fiyat_kur; ?> </option>
									<?php
										// Para Birimi
										$parabirim = $vt->query("select * from para_birimi where id")->fetchAll(PDO::FETCH_OBJ);
										foreach ($parabirim as $para) {
									?>
									<option value="<?php echo $para->ad; ?>"> <?php echo $para->ad; ?> </option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<input type="text" class="form-control" name="sure_1" value="<?php echo $paket_1->sure; ?>">
							</div>
							<div class="col-md-6">
								<select class="form-control" name="sure_zaman_1">
									<option selected="selected"> <?php echo $paket_1->sure_zaman; ?> </option>
									<option value="Gün"> Gün </option>
									<option value="Ay"> Ay </option>
									<option value="Yıl"> Yıl </option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
                        <label class="control-label hidden-lg"> Sıcak Fırsatlarda Göster </label>
						<input type="text" class="form-control" name="sicak_firsat_1" value="<?php echo $paket_1->sicak_firsat; ?>">
					</div>
					<div class="form-group">
                        <label class="control-label hidden-lg"> Vitrin İlanlarında Göster </label>
						<input type="text" class="form-control" name="vitrin_ilan_1" value="<?php echo $paket_1->vitrin_ilan; ?>">
					</div>
					<div class="form-group">
                        <label class="control-label hidden-lg"> Öne Çıkan İlanlarda Göster </label>
						<input type="text" class="form-control" name="one_cikan_1" value="<?php echo $paket_1->one_cikan; ?>">
					</div>
					<div class="form-group">
                        <label class="control-label hidden-lg"> Üst Sıralarda Listele </label>
						<input type="text" class="form-control" name="ust_sira_1" value="<?php echo $paket_1->ust_sira; ?>">
					</div>
					<div class="form-group">
                        <label class="control-label hidden-lg"> Listelemelerde Renkli Arka Plan ve Bold Yazı </label>
						<input type="text" class="form-control" name="renkli_bold_1" value="<?php echo $paket_1->renkli_bold; ?>">
					</div>
					<div class="form-group">
                        <label class="control-label hidden-lg"> Anasayfa Acil İlanlar </label>
						<input type="text" class="form-control" name="acil_ilan_1" value="<?php echo $paket_1->acil_ilan; ?>">
					</div>
				</div>

				<!-- PAKET 2 -->

				<div class="col-md-2">
				  <div class="form-group">
                      <div class="hidden-lg">
                          <p class="btn bg-success btn-block" style="margin-bottom: 15px;"><strong>PAKET 2</strong></p>
                      </div>
				    <input type="text" class="form-control" name="doping_adi_2" value="<?php echo $paket_2->doping_adi; ?>">
				  </div>
				  <div class="form-group hidden">
				    <div class="row">
				    	<div class="col-md-6">
								<select class="form-control" name="periyot_fiyat_kur_2[]">
									<option selected="selected"> <?php echo $paket_2->periyot_fiyat_kur; ?> </option>
									<?php
										// Para Birimi
										$parabirim = $vt->query("select * from para_birimi where id")->fetchAll(PDO::FETCH_OBJ);
										foreach ($parabirim as $para) {
									?>
									<option value="<?php echo $para->ad; ?>"> <?php echo $para->ad; ?> </option>
									<?php } ?>
								</select>
				    	</div>
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="row">
				      <div class="col-md-6">
				        <input type="text" class="form-control" name="sure_2" value="<?php echo $paket_2->sure; ?>">
				      </div>
				      <div class="col-md-6">
				        <select class="form-control" name="sure_zaman_2">
				          <option selected="selected"> <?php echo $paket_2->sure_zaman; ?> </option>
				          <option value="Gün"> Gün </option>
				          <option value="Ay"> Ay </option>
				          <option value="Yıl"> Yıl </option>
				        </select>
				      </div>
				    </div>
				  </div>
				  <div class="form-group">
                      <label class="control-label hidden-lg"> Sıcak Fırsatlarda Göster </label>
				    <input type="text" class="form-control" name="sicak_firsat_2" value="<?php echo $paket_2->sicak_firsat; ?>">
				  </div>
				  <div class="form-group">
                      <label class="control-label hidden-lg"> Vitrin İlanlarında Göster </label>
				    <input type="text" class="form-control" name="vitrin_ilan_2" value="<?php echo $paket_2->vitrin_ilan; ?>">
				  </div>
				  <div class="form-group">
                      <label class="control-label hidden-lg"> Öne Çıkan İlanlarda Göster </label>
				    <input type="text" class="form-control" name="one_cikan_2" value="<?php echo $paket_2->one_cikan; ?>">
				  </div>
				  <div class="form-group">
                      <label class="control-label hidden-lg"> Üst Sıralarda Listele </label>
				    <input type="text" class="form-control" name="ust_sira_2" value="<?php echo $paket_2->ust_sira; ?>">
				  </div>
				  <div class="form-group">
                      <label class="control-label hidden-lg"> Listelemelerde Renkli Arka Plan ve Bold Yazı </label>
				    <input type="text" class="form-control" name="renkli_bold_2" value="<?php echo $paket_2->renkli_bold; ?>">
				  </div>
				  <div class="form-group">
                      <label class="control-label hidden-lg"> Anasayfa Acil İlanlar </label>
				    <input type="text" class="form-control" name="acil_ilan_2" value="<?php echo $paket_2->acil_ilan; ?>">
				  </div>
				</div>

				<!-- PAKET 3 -->

				<div class="col-md-2">
				  <div class="form-group">
                      <div class="hidden-lg">
                          <p class="btn bg-success btn-block" style="margin-bottom: 15px;"><strong>PAKET 3</strong></p>
                      </div>
				    <input type="text" class="form-control" name="doping_adi_3" value="<?php echo $paket_3->doping_adi; ?>">
				  </div>
				  <div class="form-group hidden">
				    <div class="row">
				    	<div class="col-md-6">
								<select class="form-control" name="periyot_fiyat_kur_3[]">
						      <option selected="selected"> <?php echo $paket_3->periyot_fiyat_kur; ?> </option>
						      <?php
						        // Para Birimi
						        $parabirim = $vt->query("select * from para_birimi where id")->fetchAll(PDO::FETCH_OBJ);
						        foreach ($parabirim as $para) {
						      ?>
						      <option value="<?php echo $para->ad; ?>"> <?php echo $para->ad; ?> </option>
						      <?php } ?>
						    </select>
				    	</div>
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="row">
				      <div class="col-md-6">
				        <input type="text" class="form-control" name="sure_3" value="<?php echo $paket_3->sure; ?>">
				      </div>
				      <div class="col-md-6">
				        <select class="form-control" name="sure_zaman_3">
				          <option selected="selected"> <?php echo $paket_3->sure_zaman; ?> </option>
				          <option value="Gün"> Gün </option>
				          <option value="Ay"> Ay </option>
				          <option value="Yıl"> Yıl </option>
				        </select>
				      </div>
				    </div>
				  </div>
				  <div class="form-group">
                      <label class="control-label hidden-lg"> Sıcak Fırsatlarda Göster </label>
				    <input type="text" class="form-control" name="sicak_firsat_3" value="<?php echo $paket_3->sicak_firsat; ?>">
				  </div>
				  <div class="form-group">
                      <label class="control-label hidden-lg"> Vitrin İlanlarında Göster </label>
				    <input type="text" class="form-control" name="vitrin_ilan_3" value="<?php echo $paket_3->vitrin_ilan; ?>">
				  </div>
				  <div class="form-group">
                      <label class="control-label hidden-lg"> Öne Çıkan İlanlarda Göster </label>
				    <input type="text" class="form-control" name="one_cikan_3" value="<?php echo $paket_3->one_cikan; ?>">
				  </div>
				  <div class="form-group">
                      <label class="control-label hidden-lg"> Üst Sıralarda Listele </label>
				    <input type="text" class="form-control" name="ust_sira_3" value="<?php echo $paket_3->ust_sira; ?>">
				  </div>
				  <div class="form-group">
                      <label class="control-label hidden-lg"> Listelemelerde Renkli Arka Plan ve Bold Yazı </label>
				    <input type="text" class="form-control" name="renkli_bold_3" value="<?php echo $paket_3->renkli_bold; ?>">
				  </div>
				  <div class="form-group">
                      <label class="control-label hidden-lg"> Anasayfa Acil İlanlar </label>
				    <input type="text" class="form-control" name="acil_ilan_3" value="<?php echo $paket_3->acil_ilan; ?>">
				  </div>
				</div>

				<!-- PAKET 4 -->

				<div class="col-md-2">
				  <div class="form-group">
                      <div class="hidden-lg">
                          <p class="btn bg-success btn-block" style="margin-bottom: 15px;"><strong>PAKET 4</strong></p>
                      </div>
				    <input type="text" class="form-control" name="doping_adi_4" value="<?php echo $paket_4->doping_adi; ?>">
				  </div>
				  <div class="form-group hidden">
				    <div class="row">
				    	<div class="col-md-6">
								<select class="form-control" name="periyot_fiyat_kur_4[]">
						      <option selected="selected"> <?php echo $paket_4->periyot_fiyat_kur; ?> </option>
						      <?php
						        // Para Birimi
						        $parabirim = $vt->query("select * from para_birimi where id")->fetchAll(PDO::FETCH_OBJ);
						        foreach ($parabirim as $para) {
						      ?>
						      <option value="<?php echo $para->ad; ?>"> <?php echo $para->ad; ?> </option>
						      <?php } ?>
						    </select>
				    	</div>
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="row">
				      <div class="col-md-6">
				        <input type="text" class="form-control" name="sure_4" value="<?php echo $paket_4->sure; ?>">
				      </div>
				      <div class="col-md-6">
				        <select class="form-control" name="sure_zaman_4">
				          <option selected="selected"> <?php echo $paket_4->sure_zaman; ?> </option>
				          <option value="Gün"> Gün </option>
				          <option value="Ay"> Ay </option>
				          <option value="Yıl"> Yıl </option>
				        </select>
				      </div>
				    </div>
				  </div>
				  <div class="form-group">
                      <label class="control-label hidden-lg"> Sıcak Fırsatlarda Göster </label>
				    <input type="text" class="form-control" name="sicak_firsat_4" value="<?php echo $paket_4->sicak_firsat; ?>">
				  </div>
				  <div class="form-group">
                      <label class="control-label hidden-lg"> Vitrin İlanlarında Göster </label>
				    <input type="text" class="form-control" name="vitrin_ilan_4" value="<?php echo $paket_4->vitrin_ilan; ?>">
				  </div>
				  <div class="form-group">
                      <label class="control-label hidden-lg"> Öne Çıkan İlanlarda Göster </label>
				    <input type="text" class="form-control" name="one_cikan_4" value="<?php echo $paket_4->one_cikan; ?>">
				  </div>
				  <div class="form-group">
                      <label class="control-label hidden-lg"> Üst Sıralarda Listele </label>
				    <input type="text" class="form-control" name="ust_sira_4" value="<?php echo $paket_4->ust_sira; ?>">
				  </div>
				  <div class="form-group">
                      <label class="control-label hidden-lg"> Listelemelerde Renkli Arka Plan ve Bold Yazı </label>
				    <input type="text" class="form-control" name="renkli_bold_4" value="<?php echo $paket_4->renkli_bold; ?>">
				  </div>
				  <div class="form-group">
                      <label class="control-label hidden-lg"> Anasayfa Acil İlanlar </label>
				    <input type="text" class="form-control" name="acil_ilan_4" value="<?php echo $paket_4->acil_ilan; ?>">
				  </div>
				</div>

			</div>

		</div>
		<div class="box-footer text-right">
				<button type="submit" class="btn btn-primary btn-lg" name="kaydet"> <i class="fa fa-save fa-lg"></i> <strong> Kaydet </strong> </button>
		 </div>
	</div>
</form>

</section>
<style media="screen">
	.control-label {
		padding-top: 15px !important;
	}
</style>
