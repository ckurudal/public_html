<form class="form" action="" method="post">
	<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive">
		<table id="example1" class="table table-bordered dataTable" colspan="5" role="grid" aria-describedby="example1_info">
			<thead>
				<tr>
					<th><p><strong> ID </strong></p></th>
					<th><p><strong> Üye </strong></p></th>
					<th><p><strong> Sipariş Adı </strong></p></th>
					<th><p><strong> Sipariş Tipi </strong></p></th>
					<th><p><strong> Sipariş No </strong></p></th>
					<th><p><strong> Ödeme Yöntemi </strong></p></th>
					<th><p><strong> Tutar </strong></p></th>
					<th><p><strong> Açıklama </strong></p></th>
					<th><p><strong> Sipariş Notu </strong></p></th>
					<th><p><strong> Sipariş Tarihi </strong></p></th>
					<th><p><strong> Onay Tarihi </strong></p></th>
					<th><p><strong> Durum </strong></p></th>
					<th><p><strong> İşlemler </strong></p></th>
				</tr>
			</thead>
			<tbody>

				<?php 

					$siparis_danisman = $vt->query("SELECT * FROM siparis_danisman WHERE id")->fetchAll(PDO::FETCH_ASSOC);

					foreach ($siparis_danisman as $siparis) {
					
				?>

				<tr>
					
					<td class="text-center">

						<?php echo $siparis["id"]; ?>
							
					</td>
					
					<td class="text-center">

						<?php echo $siparis["uye_id"]; ?>
							
					</td>
					
					<td class="text-center">

						<?php echo $siparis["siparis_adi"]; ?>
							
					</td>
					
					<td class="text-center">

						<?php echo $siparis["siparis_tipi"]; ?>
							
					</td>
					
					<td class="text-center">

						<?php echo $siparis["siparis_no"]; ?>
							
					</td>
					
					<td class="text-center">

						<?php echo $siparis["odeme_yontemi"]; ?>
							
					</td>
					
					<td class="text-center">

						<?php echo $siparis["tutar"]; ?>
							
					</td>
					
					<td class="text-center">

						<?php echo $siparis["aciklama"]; ?>
							
					</td>
					
					<td class="text-center">

						<?php echo $siparis["siparis_notu"]; ?>
							
					</td>
					
					<td class="text-center">

						<?php echo $siparis["siparis_tarihi"]; ?>
							
					</td>
					
					<td class="text-center">
						<?php if ($siparis["durum"] == "1") { ?>
						<?php echo $siparis["onay_tarihi"]; ?>
						<?php } else { ?>
							-
						<?php } ?>
							
					</td>
					
					<td class="text-center">

						<?php if ($siparis["durum"] == "1") { ?> 
						<p class="text-center btn btn-block bg-success">  Onaylı </p>
						<?php } ?>
						<?php if ($siparis["durum"] == "0") { ?>
						<p class="text-center btn btn-block bg-danger">  Onay Bekliyor </p>								
						<?php } ?>
							
					</td>

					<td>
						<?php if ($siparis["durum"] == "0") { ?> 
						<a href="index.php?do=doping/dopingler&islem=doping_onay&id=<?php echo $doping["id"]; ?>&hareket=0" class="text-center btn btn-block btn-xs btn-success">  Onayla </a>
						<?php } ?>
						<?php if ($siparis["durum"] == "1") { ?>
						<a href="index.php?do=doping/dopingler&islem=doping_onay&id=<?php echo $doping["id"]; ?>&hareket=1" class="text-center btn btn-block btn-xs btn-warning">  Onayı Kaldır </a>
						<?php } ?>

						<a href="index.php?do=doping/ilan_doping&ilan_id=<?php echo $doping["id"]; ?>" class="text-center btn btn-block btn-xs btn-primary"> Detaylar </a>
						
						<a href="#" data-toggle="modal" data-target="#sil<?=$doping["id"];?>" class="text-center btn btn-block btn-xs btn-danger"> Sil </a>
				
					</td>

				</tr>

				<?php } ?>

			</tbody>
		</div>
	</form>