<div class="alert alert-warning">
	<strong> Dopingler </strong>
</div>
<div class="box">
	<div class="box-body">
		<?php 
			$gorev		= $_GET["gorev"];
			$siparis_no = $_GET["siparis_no"];
			$ilan_id 	= $_GET["ilan_id"];
			$yetki 		= $yonetici["yetki"];
			$sayfa 		= $_SERVER['REQUEST_URI'];
		?>
		<?php 

			if ($gorev == "sil") {

				$sil = $vt->query("DELETE FROM doping_ilanlari WHERE siparis_no = '$siparis_no'");
				
				$emlak_doping_kapat = $vt->query("UPDATE emlak_ilan SET doping_onay = 0, doping = 'yok' WHERE id = '$ilan_id'");
				
				onay_alert("İşlemini başarılı bir şekilde gerçekleşmiştir.");
				
				// go("index.php?do=islem&ofis=yonetici&islem=duzenle&id=$id&tab_goster=dopingleri",0);


			}
				
		?>

		<?php 
			if ($gorev == "doping_onay") {
				
				if ($hareket == 0) {$onay = 0;}
				if ($hareket == 1) {$onay = 1;}

				$onayla = $vt->query("UPDATE emlak_ilan SET doping_onay = '$onay' WHERE id = '$ilan_id'");

				go("index.php?do=islem&ofis=yonetici&islem=duzenle&id=$id&tab_goster=dopingleri",0);

			}
		?>

		<?php	if ($gorev == "onay") { ?> 
			<div style="margin-top: 20px;"> <?php onay(); ?> </div>
		<?php } ?>

		<form class="form" action="" method="post">
			<div class="table-responsive">
				<table id="example9" class="table table-bordered dataTable" colspan="5" role="grid" aria-describedby="example10_info">
					<thead>
						<tr>
							
							<th><p><strong> Üye </strong></p></th>					
							<th style="width:20%;"><p><strong> İlan Başlık </strong></p></th>
							
							<th><p><strong> Sipariş Tarihi </strong></p></th>
							<th><p><strong> Tutar </strong></p></th>										
							<th class="text-center"><p><strong> Ödeme Tipi </strong></p></th>
							<th class="text-center"><p><strong> Bekleyen Ödeme </strong></p></th>													
							<th><p><strong> Durum </strong></p></th>
							<th><p><strong> İşlemler </strong></p></th> 													
						</tr>
					</thead>
					<tbody>

						<?php

							$emlak_ilan = $vt->query("SELECT * FROM emlak_ilan WHERE doping = 'var' AND yonetici_id = '".$id."'")->fetchAll(PDO::FETCH_ASSOC);

							foreach ($emlak_ilan as $emlak) {
							
								$doping_ilanlari = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '".$emlak["id"]."'")->fetch(PDO::FETCH_ASSOC);

								$yonetici = $vt->query("SELECT * FROM yonetici WHERE id = '".$emlak["yonetici_id"]."'")->fetch(PDO::FETCH_ASSOC);

								$doping_paketleri = $vt->query("SELECT * FROM doping_paketleri WHERE id = '".$doping_ilanlari["paket_id"]."'")->fetch(PDO::FETCH_ASSOC);
							
						?>

						<tr>					
							 
							<td>
								<a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $yonetici["id"]; ?>&yetki=<?php echo $yonetici["yetki"]; ?>" target="_blank"> <?php echo $yonetici["adsoyad"]; ?> </a>
							</td>					
							<td>
								<a href="index.php?do=islem&emlak=emlak_duzenle&id=<?php echo $emlak["id"]; ?>" target="_blank"> <?php echo $emlak["baslik"]; ?> </a>
							</td>
							
							 
							<td><?php echo $doping_ilanlari["tarih"]; ?></td>
							<td><?php echo $doping_ilanlari["fiyat"]; ?> <?php echo $doping_paketleri["periyot_fiyat_kur"]; ?></td>
							<td class="text-center"><?php echo $doping_ilanlari["odeme_tipi"]; ?></td>
							 
							<td>
								<?php if (doping_bekleyen($emlak["id"]) > 0) { ?>
									<p class="text-center btn bg-danger btn-xs btn-block">  Ödeme Bekliyor </p>
								<?php } else { ?>
									<p class="text-center btn bg-success btn-xs btn-block">  Bekleyen Yok </p>
								<?php } ?>
							</td>
							 
							<td>
								<?php if ($emlak["doping_onay"] == 1) { ?>
									<p class="text-center btn bg-success btn-xs btn-block">  Onaylı </p>
								<?php } else { ?>
									<p class="text-center btn bg-danger btn-xs btn-block">  Onay Bekliyor </p>
								<?php } ?>
							</td>

							<td>

								<?php if ($emlak["doping_onay"] == "0" && $uyelik_yetki["yetki"] == 0) { ?> 
								
								<a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $id; ?>&tab_goster=dopingleri&gorev=doping_onay&hareket=1&ilan_id=<?php echo $emlak["id"]; ?>" class="text-center btn btn-block btn-xs btn-success">  Onayla </a>
								
								<?php } ?>

								<?php if ($emlak["doping_onay"] == "1" && $uyelik_yetki["yetki"] == 0) { ?>
								
								<a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $id; ?>&tab_goster=dopingleri&gorev=doping_onay&hareket=0&ilan_id=<?php echo $emlak["id"]; ?>" class="text-center btn btn-block btn-xs btn-warning">  Onayı Kaldır </a>

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
										<a href="<?php echo $_SERVER['REQUEST_URI']; ?>&gorev=sil&siparis_no=<?php echo $doping_ilanlari["siparis_no"]; ?>&ilan_id=<?php echo $emlak["id"]; ?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
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
	</div>
</div>