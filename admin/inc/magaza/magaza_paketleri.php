

<?php
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;

	uyeYasak(yetki());

	$islem = $_GET["islem"];
	$id = $_GET["id"];
?>

<section class="content-header">

	Üyelik Paketleri

	<p> <small> Tüm Üyelik Paketleri </small> </p>

	<ol class="breadcrumb">

		<li><a href="index.php"><i class="fa fa-dashboard"></i> Anasayfa </a></li>

		<li> <a href="index.php?do=tumilanlar"> Tüm İlanlar </a> </li>

		<li class="active"> İlan Yönetimi </li>

	</ol>

</section>
<?php if ($islem == "") { ?>
<section class="content">
    <a href="index.php?do=islem&magaza=magaza_paketleri&islem=ekle" class="btn btn-lg bt-xs btn-success">
        <i class="fa fa-plus"></i> Üyelik Paketi Ekle
    </a>
	<?php

		$paket_sil = $_GET["paket_sil"];

		$paket_sil_hepsi = $vt->query("DELETE FROM magaza_paket WHERE id = '$paket_sil'");
		$priyot_sil_hepsi = $vt->query("DELETE FROM magaza_paket_periyot WHERE periyot_paket_id = '$paket_sil'");

		if ($paket_sil) {
			onay();
			echo "<br>";
		}

	?>

				<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive">
					<table id="example1" class="table table-bordered dataTable" colspan="5" role="grid" aria-describedby="example1_info">
            	<thead>
                	<tr>
                		<th class="text-center" style="width: 5%"><p><strong>ID</strong></p></th>
                		<th style="width: 15%"><p><strong>Paket Adı</strong></p></th>
                		<th style="width: 15%"><p><strong>Aylık Limit</strong></p></th>
                		<th style="width: 15%"><p><strong>Resim Limiti</strong></p></th>
                		<th style="width: 15%"><p><strong>Danışman Limiti</strong></p></th>
                        <th style="width: 15%"><p><strong>İlan Süresi</strong></p></th>
                		<th style="width: 8%"><p><strong>İşlemler</strong></p></th>
                	</tr>
                </thead>
                <tbody>
                	<?php

                		$paketler = $vt->query("SELECT * FROM magaza_paket WHERE id ORDER BY sira DESC")->fetchAll(PDO::FETCH_OBJ);

                		foreach ($paketler as $paket) {
                	?>
                	<tr>
                		<td class="text-center">
                			<h5><strong><?php echo $paket->id; ?></strong></h5>
                		</td>
                		<td>
                			<a href="index.php?do=islem&magaza=magaza_paketleri&islem=duzenle&id=<?php echo $paket->id; ?>""><h5><strong> <?php echo $paket->paket_adi; ?> </strong></h5></a>
                		</td>
                		<td>
                			<?php echo $paket->aylik_limit; ?>
                		</td>
                		<td><?php echo $paket->resim_limit; ?></td>
                		<td><?php echo $paket->danisman_limit; ?></td>
                        <td><?php echo $paket->ilan_sure; ?> <?php echo $paket->ilan_sure_zaman; ?> </td>
                		<td>
                			<a href="index.php?do=islem&magaza=magaza_paketleri&islem=duzenle&id=<?php echo $paket->id; ?>" class="btn btn-primary btn-xs btn-block"> <i class="fa fa-edit"></i> Düzenle </a>
                			<a href="#" data-toggle="modal" data-target="#<?php echo $paket->id; ?>" title="Sil" class="btn btn-danger btn-xs btn-block"> <i class="fa fa-trash"></i> Sil </a>

							<div class="modal modal-default fade" id="<?php echo $paket->id; ?>" style="display: none;">
							  <div class="modal-dialog">
								<div class="modal-content">
								  <div class="modal-header alert alert-info">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">×</span></button>
									<h4 class="modal-title"><i class="fa fa-close"></i> Silme Onayı Ver</h4>
								  </div>
								  <div class="modal-body">
										<h4 style="display: grid; width: 100%;">"<?php echo $paket->paket_adi; ?>" isimli paket silinecektir. İşlemi onaylıyor musunuz?</h4>
								  </div>
								  <div class="modal-footer">
									<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
									<a href="index.php?do=islem&magaza=magaza_paketleri&paket_sil=<?php echo $paket->id; ?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
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

</section>
<?php } ?>

<?php if ($islem == "ekle") { ?>
<section class="content">

		<?php

			if (isset($_POST["paket_ekle"])) {

				$paket_adi 			= $_POST["paket_adi"];
				$sira 				= $_POST["sira"];
				$aylik_limit 		= $_POST["aylik_limit"];
				$resim_limit 		= $_POST["resim_limit"];
				$danisman_limit 	= $_POST["danisman_limit"];
				$ilan_sure 			= $_POST["ilan_sure"];
				$ilan_sure_zaman 	= $_POST["ilan_sure_zaman"];

				if (empty($paket_adi)) {

					hata("Hata! Paket adı bol bırakılamaz. Lütfen bir paket adı giriniz.");

				} else {

					$ekle=$vt->prepare("INSERT INTO magaza_paket (paket_adi, sira, aylik_limit, resim_limit, danisman_limit, ilan_sure, ilan_sure_zaman) VALUES (?,?,?,?,?,?,?)");
	    			$deger=$ekle->execute(array($paket_adi, $sira, $aylik_limit, $resim_limit, $danisman_limit, $ilan_sure, $ilan_sure_zaman));

				  	$son_id = $vt->lastInsertId(); ## SON EKLENEN ID ALIYORUZ

	    			if ($ekle == true) {

	    				onay();
	    				echo "<br>";

	    				$periyot_sure = $_POST["periyot_sure"];
	    				$periyot_sure_zaman = $_POST["periyot_sure_zaman"];
	    				$periyot_fiyat = $_POST["periyot_fiyat"];
	    				$periyot_fiyat_kur = $_POST["periyot_fiyat_kur"];

	    				for ($i=0; $i<count($periyot_sure);$i++){

		    				$ekle_per=$vt->prepare("INSERT INTO magaza_paket_periyot (periyot_sure, periyot_paket_id, periyot_sure_zaman, periyot_fiyat, periyot_fiyat_kur) VALUES (?,?,?,?,?)");
		    				$deger=$ekle_per->execute(array($periyot_sure[$i], $son_id, $periyot_sure_zaman[$i], $periyot_fiyat[$i], $periyot_fiyat_kur[$i]));

	    				}


	    			}

				}


			}

		?>

	<form class="form" action="" method="post">
		<div class="row">
			<div class="col-md-7">
				<div class="box">
				 	<div class="box-header with-border">
					  <h3 class="box-title"> Yeni Paket Ekle </h3>
					</div>
					<div class="box-body">

						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label class="control-label">Paket Adı: <small>(MAKSIMUM 150 KARAKTER) *</small></label>
									<?php
										if (isset($_POST["paket_ekle"])) {$paket_adi = $_POST["paket_adi"];
										if (empty($paket_adi)) {
									?>
									<input type="text" class="form-control" name="paket_adi" style="border:1px solid red;">
									<?php } ?>
									<?php } else { ?>
									<input type="text" class="form-control" name="paket_adi">
									<?php } ?>
								</div>
								<div class="col-md-6">
									<label class="control-label">Sıra:</label>
									<input type="text" class="form-control" name="sira">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-3">
									<label class="control-label">Aylık Limit:</label>
									<input type="text" class="form-control" name="aylik_limit">
									<p>Sınırsız/Limitsiz için 0 yazınız.</p>
								</div>
								<div class="col-md-3">
									<label class="control-label">Resim Limit:</label>
									<input type="text" class="form-control" name="resim_limit">
								</div>
								<div class="col-md-6">
									<div class="row">
										<div class="col-md-4">
											<label class="control-label">Danışman Limit:</label>
											<input type="text" class="form-control" name="danisman_limit">
										</div>
										<div class="col-md-8">
											<div class="row">
												<div class="col-md-6">
													<label class="control-label">İlan Süresi:</label>
													<input type="text" class="form-control" name="ilan_sure">
												</div>
												<div class="col-md-6">
													<label class="control-label"> &nbsp; </label>
													<select class="form-control" name="ilan_sure_zaman">
														<option>Gün</option>
														<option>Ay</option>
														<option>Yıl</option>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-5">

				<div class="box">
				 	<div class="box-header with-border">
					  <h3 class="box-title"> Ücretlendirme </h3>
					</div>
					<div class="box-body">

						<div id="button_pro">
							<div class='space' id='input_1'>


								<div class="row" style="margin-bottom:20px;">

									<div class="col-md-2">
										<input type="text" placeholder="Süre" class="form-control" name="periyot_sure[]">
									</div>

									<div class="col-md-2">
										<select class="form-control" name="periyot_sure_zaman[]">
											<option>Gün</option>
											<option>Ay</option>
											<option>Yıl</option>
										</select>
									</div>

									<div class="col-md-2">
										<input type="text" class="form-control" name="periyot_fiyat[]" placeholder="Fiyat">
									</div>

									<div class="col-md-2">
										<select class="form-control" name="periyot_fiyat_kur[]">
											<?php
												// Para Birimi
												$parabirim = $vt->query("select * from para_birimi where id");
												while ($paraver = $parabirim->fetch()) {
											?>
											<option> <?=$paraver["ad"];?> </option>
											<?php } ?>
										</select>
									</div>
								</div>

								<div class="row">
									<div class="col-md-4">
										<a class="add right btn btn-block btn-info btn-sm"><i class="fa fa-plus"></i> Periyod Ekle</a>
									</div>
								</div>

							</div>
					   </div>
                       
					</div>
					<div class="box-footer">
						<button type="submit" class="btn btn-success btn-lg pull-right" name="paket_ekle"> <i class="fa fa-check"></i> Paket Ekle </button>
					 </div>
				</div>

			</div>
		</div>
	</form>
</section>
<?php } ?>

<?php if ($islem == "duzenle") { ?>
<section class="content">

		<?php

			$periyot_sil = $_GET["periyot_sil"];
			$sil_periyot = $vt->query("DELETE FROM magaza_paket_periyot WHERE id = '$periyot_sil'");

			if (isset($_POST["periyot_kaydet"])) {

				$paket_adi 			= $_POST["paket_adi"];
				$sira 				= $_POST["sira"];
				$aylik_limit 		= $_POST["aylik_limit"];
				$resim_limit 		= $_POST["resim_limit"];
				$danisman_limit 	= $_POST["danisman_limit"];
				$ilan_sure 			= $_POST["ilan_sure"];
				$ilan_sure_zaman 	= $_POST["ilan_sure_zaman"];

				if (empty($paket_adi)) {

					hata("Hata! Paket adı bol bırakılamaz. Lütfen bir paket adı giriniz.");

				} else {

					$paket_guncelle = $vt->prepare("UPDATE magaza_paket SET paket_adi=:paket_adi, sira=:sira, aylik_limit=:aylik_limit, resim_limit=:resim_limit, danisman_limit=:danisman_limit, ilan_sure=:ilan_sure, ilan_sure_zaman=:ilan_sure_zaman WHERE id=:id ");
	    			$paket_guncelle->execute(array(':paket_adi'=>$paket_adi , ':sira'=>$sira, ':aylik_limit'=>$aylik_limit, ':resim_limit'=>$resim_limit, ':danisman_limit'=>$danisman_limit, ':ilan_sure'=>$ilan_sure, ':ilan_sure_zaman'=>$ilan_sure_zaman, ':id'=>$id));

	    			if ($paket_guncelle == true) {

	    				$sil_periyot_tum = $vt->query("DELETE FROM magaza_paket_periyot WHERE periyot_paket_id = '$id'");

	    				$periyot_sure = $_POST["periyot_sure"];
	    				$periyot_sure_zaman = $_POST["periyot_sure_zaman"];
	    				$periyot_fiyat = $_POST["periyot_fiyat"];
	    				$periyot_fiyat_kur = $_POST["periyot_fiyat_kur"];

	    				for ($i=0; $i<count($periyot_sure);$i++){


	    					$ekle_per=$vt->prepare("INSERT INTO magaza_paket_periyot (periyot_sure, periyot_paket_id, periyot_sure_zaman, periyot_fiyat, periyot_fiyat_kur) VALUES (?,?,?,?,?)");
		    				$deger=$ekle_per->execute(array($periyot_sure[$i], $id, $periyot_sure_zaman[$i], $periyot_fiyat[$i], $periyot_fiyat_kur[$i]));


	    				}

	    			}

	    			onay();
	    			echo "<br>";

	    		}






				// $sil_periyot_tum = $vt->query("DELETE FROM magaza_paket_periyot WHERE periyot_paket_id = '$id'");

		    	// $periyot_duzenle = $db->query("UPDATE magaza_paket_periyot SET veri_adi = 'Yeni Veri', veri_adi_2 = 'Yeni Veri 2' WHERE id = '$id'");
			}


		?>

	<form class="form" action="" method="post">
		 <div class="row">
			 <div class="col-md-7">
				 <div class="box">
				 	<div class="box-header with-border">
					  <h3 class="box-title"> Paket Düzenle </h3>
					  <!-- tools box -->
					  <div class="pull-right box-tools">
						<a href="#" class="btn" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Daralt">
						  <i class="fa fa-minus"></i></a>
						<a href="#" class="btn" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Kapat">
						  <i class="fa fa-times"></i></a>
					  </div>
					  <!-- /. tools -->
					</div>
					<div class="box-body">
						<?php

							$paket_duzenle = $vt->query("SELECT * FROM magaza_paket WHERE id = '$id'")->fetchObject();

						?>
							<div class="row">

								<div class="col-md-12">
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<label class="control-label">Paket Adı: <small>(MAKSIMUM 150 KARAKTER) *</small></label>
												<input type="text" class="form-control" value="<?php echo $paket_duzenle->paket_adi; ?>" name="paket_adi">
											</div>
											<div class="col-md-6">
												<label class="control-label">Sıra:</label>
												<input type="text" class="form-control" name="sira" value="<?php echo $paket_duzenle->sira; ?>">
											</div>
										</div>
									</div>

									<div class="form-group">
										<div class="row">
											<div class="col-md-3">
												<label class="control-label">Aylık Limit:</label>
												<input type="text" class="form-control" name="aylik_limit" value="<?php echo $paket_duzenle->aylik_limit; ?>">
											</div>
											<div class="col-md-3">
												<label class="control-label">Resim Limit:</label>
												<input type="text" class="form-control" name="resim_limit" value="<?php echo $paket_duzenle->resim_limit; ?>">
											</div>
											<div class="col-md-2">
												<label class="control-label">Danışman Limit:</label>
												<input type="text" class="form-control" name="danisman_limit" value="<?php echo $paket_duzenle->danisman_limit; ?>">
											</div>
											<div class="col-md-4">
												<div class="row">
													<div class="col-md-6">
														<label class="control-label">İlan Süresi:</label>
														<input type="text" class="form-control" name="ilan_sure" value="<?php echo $paket_duzenle->ilan_sure; ?>">
													</div>
													<div class="col-md-6">
														<label class="control-label"> &nbsp; </label>
														<select class="form-control" name="ilan_sure_zaman">
															<?php if ($paket_duzenle->ilan_sure_zaman != "") { ?>
															<option selected=""><?php echo $paket_duzenle->ilan_sure_zaman; ?></option>
															<?php } ?>
															<option>Gün</option>
															<option>Ay</option>
															<option>Yıl</option>
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

							</div>

					</div>
				</div>
			</div>
			<div class="col-md-5">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title"> Ücretlendirme </h3>
					</div>
					<div class="box-body">

						<div id="button_pro">
							<div class='space' id='input_1'>

								<?php

									$periyot_duzenle = $vt->query("SELECT * FROM magaza_paket_periyot WHERE periyot_paket_id = '$id'")->fetchAll(PDO::FETCH_OBJ);

									foreach ($periyot_duzenle as $periyot) {

								?>

								<div class="row" style="margin-bottom:20px;">

									<div class="col-md-2">
										<input type="text" placeholder="Süre" value="<?php echo $periyot->periyot_sure; ?>" class="form-control" name="periyot_sure[]">
									</div>

									<div class="col-md-2">
										<select class="form-control" name="periyot_sure_zaman[]">
											<?php if ($periyot->periyot_sure_zaman != "") { ?>
											<option selected=""><?php echo $periyot->periyot_sure_zaman; ?></option>
											<?php } ?>
											<option>Gün</option>
											<option>Ay</option>
											<option>Yıl</option>
										</select>
									</div>

									<div class="col-md-2">
										<input type="text" class="form-control" name="periyot_fiyat[]" value="<?php echo $periyot->periyot_fiyat; ?>" placeholder="Fiyat">
									</div>

									<div class="col-md-2">
										<select class="form-control" name="periyot_fiyat_kur[]">
											<?php if ($periyot->periyot_fiyat_kur != "") { ?>
											<option selected=""><?php echo $periyot->periyot_fiyat_kur; ?></option>
											<?php } ?>
											<?php
												// Para Birimi
												$parabirim = $vt->query("select * from para_birimi where id");
												while ($paraver = $parabirim->fetch()) {
											?>
											<option> <?=$paraver["ad"];?> </option>
											<?php } ?>
										</select>
									</div>
									<div class="col-md-4">
										<a href="index.php?do=islem&magaza=magaza_paketleri&islem=duzenle&id=<?php echo $id; ?>&periyot_sil=<?php echo $periyot->id; ?>" class="remove btn pull-right btn-danger btn-sm"><i class="fa fa-close"></i> Periyodu Kaldır</a>
									</div>
								</div>

								<?php } ?>

								<div class="row">
									<div class="col-md-4">
										<a class="add right btn btn-block btn-info btn-sm"><i class="fa fa-plus"></i> Periyod Ekle</a>
									</div>
								</div>

							</div>
					   </div>
					</div>

					<div class="box-footer">
						<button type="submit" class="btn btn-success btn-lg pull-right" name="periyot_kaydet"> <i class="fa fa-save"></i> Kaydet </button>
					 </div>

				</div>
			</div>
		</div>
	</form>
</section>
<?php } ?>

<script>
$('document').ready(function(){
    var id=2,txt_box;
	$('#button_pro').on('click','.add',function(){
		  $(this).remove();
		  txt_box='<div class="space" id="input_'+id+'" ><a class="remove btn pull-right btn-danger btn-sm"><i class="fa fa-close"></i> Periyodu Kaldır</a><div class="row" style="margin-bottom:20px;"> <div class="col-md-2"> <input type="text" placeholder="Süre" class="form-control" name="periyot_sure[]"> </div> <div class="col-md-2"> <select class="form-control" name="periyot_sure_zaman[]"> <option>Gün</option> <option>Ay</option> <option>Yıl</option> </select> </div> <div class="col-md-2"> <input type="text" class="form-control" name="periyot_fiyat[]" placeholder="Fiyat"> </div> <div class="col-md-2"> <select class="form-control" name="periyot_fiyat_kur[]"> <?php $parabirim = $vt->query("select * from para_birimi where id"); while ($paraver = $parabirim->fetch()) { ?> <option> <?=$paraver["ad"];?> </option> <?php } ?> </select> </div> </div><div class="row"> <div class="col-md-4"> <a class="add right btn btn-block btn-info btn-sm"><i class="fa fa-plus"></i> Periyod Ekle</a> </div> </div></div>';
		  $("#button_pro").append(txt_box);
		  id++;
	});

	$('#button_pro').on('click','.remove',function(){
	        var parent=$(this).parent().prev().attr("id");
			var parent_im=$(this).parent().attr("id");
			$("#"+parent_im).slideUp('medium',function(){
				$("#"+parent_im).remove();
				if($('.add').length<1){
					$("#"+parent).append('<div class="row"> <div class="col-md-4"> <a class="add right btn btn-block btn-info btn-sm"><i class="fa fa-plus"></i> Periyod Ekle</a> </div> </div>');
				}
			});
			});


});
</script>

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
