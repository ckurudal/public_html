<?php

	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
    $id = $_GET["id"];

?>

<section class="content-header">

		<i class="fa fa-calendar fa-2x pull-left"></i> 
		Daire Kiralama Yönetimi  
		<p> <small> Daire Kiralama Yönetimi </small> </p>

</section> 

<section class="content">  

    <?php 
        if ($_GET["hareketIslem"]=="onayKaldir") {

            $action = $vt->prepare("UPDATE siparis_oda SET siparis_onay = ? WHERE id = ? ");
            $action = $action->execute(array( '', $id ));
            if ($action=true) {
                onay();
                go("index.php?do=siparisler/siparis_daire_kirala",1); 
            } 
        }
        if ($_GET["hareketIslem"]=="onayla") {
            $action = $vt->prepare("UPDATE siparis_oda SET siparis_onay = ? WHERE id = ? ");
            $action = $action->execute(array( 'onayli', $id ));
            if ($action=true) {
                onay();
                go("index.php?do=siparisler/siparis_daire_kirala",1);
            }  
        }
        if ($_GET["hareketIslem"]=="odenmediYap") {

            $action = $vt->prepare("UPDATE siparis_oda SET siparis_odeme = ? WHERE id = ? ");
            $action = $action->execute(array( 'odenmedi', $id ));
            if ($action=true) {
                onay();
                go("index.php?do=siparisler/siparis_daire_kirala",1);
            } 
        }
        if ($_GET["hareketIslem"]=="odendiYap") {
            $action = $vt->prepare("UPDATE siparis_oda SET siparis_odeme = ? WHERE id = ? ");
            $action = $action->execute(array( 'odendi', $id ));
            if ($action=true) {
                onay();
                go("index.php?do=siparisler/siparis_daire_kirala",1);
            }  
        }
        if ($_GET["hareketIslem"]=="sil") {
            $silsosyal = $vt->query("DELETE FROM siparis_oda where id = '$id'");
            if ($action=true) {
                onay();
                go("index.php?do=siparisler/siparis_daire_kirala",1);
            }  
        }
    ?>

	<form class="form" action="" method="post">
	    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive">
		    <table id="example1" class="table table-bordered table-hover table-striped dataTable" colspan="5" role="grid" aria-describedby="example1_info">
			<thead>
				<tr>
					<th><p><strong> ID </strong></p></th> 
					<th><p><strong> Sipariş No </strong></p></th>
					<th style="min-width:200px"><p><strong> Sipariş Durumu </strong></p></th> 
					<th><p><strong> Nereden Duydunuz? </strong></p></th>
					<th style="max-width:200px; min-width:150px; "><p><strong> Kişisel Bilgiler </strong></p></th>  
					<th style="max-width:150px"><p><strong> Sipariş Notu </strong></p></th>  
					<th style="width:100px !important;"><p><strong> Sipariş Özeti </strong></p></th>
					<th><p><strong> İşlemler </strong></p></th>
				</tr>
			</thead>
			<tbody>

				<?php 

					$odaRezervasyonlari = $vt->query("SELECT * FROM siparis_oda WHERE id ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

					foreach ($odaRezervasyonlari as $siparis) {

                        $sehir = $vt->query("SELECT * FROM sehir WHERE sehir_key = '".$siparis["il"]."'")->fetch(PDO::FETCH_ASSOC);
                        $ilce = $vt->query("SELECT * FROM ilce WHERE ilce_key = '".$siparis["ilce"]."'")->fetch(PDO::FETCH_ASSOC);
					
				?> 

				<tr>
					
					<td class="text-center">

						#<?php echo $siparis["id"]; ?>
							
					</td>
					
					<td class="text-center">

						<span class="badge"><?php echo $siparis["siparis_no"]; ?></span>
							
					</td>
					
					<td style="padding:0 !important"> 

                        <table class="table table-hover">  
                            <tbody> 
                                <tr>
                                    <th class="text-left" colspan="2"><h5 class="text-primary"><strong><i class="fa fa-angle-down fa-lg"></i> REZERVASYON DETAY</strong></h5> </th>  
                                    <th class="text-right" colspan="1"><i class="fa fa-calendar fa-lg "></i> </th>  
                                </tr>   
                                <tr>
                                    <th>Yetişkin Sayısı: </th> 
                                    <th class="text-right"><?php echo $siparis["yetiskin_sayisi"]; ?> x <?php echo $siparis["yetiskin_fiyat"]; ?><?php echo $siparis["gunluk_fiyat_birim"]; ?></th> 
                                    <th class="text-right"><?php echo $siparis["yetiskin_sayisi"]*$siparis["yetiskin_fiyat"]; ?><?php echo $siparis["gunluk_fiyat_birim"]; ?></th> 
                                </tr>  
                                <tr>
                                    <th>Çocuk Sayısı: </th> 
                                    <th class="text-right"><?php echo $siparis["cocuk_sayisi"]; ?> x <?php echo $siparis["cocuk_fiyat"]; ?><?php echo $siparis["gunluk_fiyat_birim"]; ?></th> 
                                    <th class="text-right"><?php echo $siparis["cocuk_sayisi"]*$siparis["cocuk_fiyat"]; ?><?php echo $siparis["gunluk_fiyat_birim"]; ?></th> 
                                </tr>  
                                <tr>
                                    <th>Bebek Sayısı: </th> 
                                    <th class="text-right"><?php echo $siparis["bebek_sayisi"]; ?> x <?php echo $siparis["bebek_fiyat"]; ?><?php echo $siparis["gunluk_fiyat_birim"]; ?></th> 
                                    <th class="text-right"><?php echo $siparis["bebek_sayisi"]*$siparis["bebek_fiyat"]; ?><?php echo $siparis["gunluk_fiyat_birim"]; ?></th> 
                                </tr>   
                                <tr>
                                    <th class="text-left"><h5><strong>Toplam</strong></h5></th> 
                                    <th class="text-right"><?php echo $siparis["gun_sayisi"]; ?> <?php echo $siparis["periyot"]; ?></th> 
                                    <th class="text-right"><h5><strong><?php echo $siparis["toplam"]; ?><?php echo $siparis["gunluk_fiyat_birim"]; ?></strong></h5></th> 
                                </tr>  
                                <tr>
                                    <th colspan="2"><h5><strong><?php echo $siparis["ilan_baslik"]; ?></strong></h5> </th> 
                                    <th class="text-right" colspan="1"><span class="badge"><?php echo $siparis["gun_sayisi"]; ?> GÜN</span></th> 
                                </tr>    
                                <tr>
                                    <th colspan="1">Giriş Tarihi: </th>  
                                    <th colspan="2" class="text-right"><?php echo $siparis["giris_tarihi"]; ?></th> 
                                </tr>  
                                <tr>
                                    <th colspan="1">Çıkış Tarihi: </th>  
                                    <th colspan="2" class="text-right"><?php echo $siparis["cikis_tarihi"]; ?></th> 
                                </tr>   
                                <tr>
                                    <th colspan="3"> 
                                    </th>  
                                </tr>  
                                <tr> 
                                    <th colspan="1">
                                        <?php if ($siparis["siparis_onay"] == "onayli") { ?> 
                                            <a href="index.php?do=siparisler/siparis_daire_kirala&hareketIslem=onayKaldir&id=<?php echo $siparis["id"] ?>" class="btn btn-danger btn-block btn-xs">ONAYI KALDIR</a>
                                        <?php } ?>
                                        <?php if ($siparis["siparis_onay"] == "") { ?>
                                            <a href="index.php?do=siparisler/siparis_daire_kirala&hareketIslem=onayla&id=<?php echo $siparis["id"] ?>" class="btn btn-primary btn-block btn-xs">ONAYLA</a>
                                        <?php } ?>
                                    </th>  
                                    <th colspan="2">
                                        <?php if ($siparis["siparis_odeme"] == "odendi") { ?> 
                                        <a href="index.php?do=siparisler/siparis_daire_kirala&hareketIslem=odenmediYap&id=<?php echo $siparis["id"] ?>" class="text-center btn btn-block btn-xs btn-warning"> <i class="fa fa-close"></i> ÖDENMEDİ YAP </a>
                                        <?php } ?>
                                        <?php if ($siparis["siparis_odeme"] == "odenmedi") { ?>
                                        <a href="index.php?do=siparisler/siparis_daire_kirala&hareketIslem=odendiYap&id=<?php echo $siparis["id"] ?>" class="text-center btn btn-block btn-xs btn-success"> <i class="fa fa-check"></i> ÖDENDİ YAP </a>
                                        <?php } ?>
                                    </th>  
                                </tr>  
                            </tbody>  
                        </table> 
							
					</td> 
					
					<td class="text-center">

						<?php echo $siparis["nereden_duydunuz"]; ?>
							
					</td> 
					
					<td>

						<p><strong>Ad Soyad:</strong> <?php echo $siparis["ad_soyad"]; ?></p>
						<p><strong>Telefon:</strong> <?php echo $siparis["telefon"]; ?></p>
                        <p><strong>E-posta:</strong> <?php echo $siparis["email"]; ?></p>
                        <p><strong>TC Kimlik:</strong> <?php echo $siparis["tc_kimlik"]; ?></p>
                        <hr>
                        <p><?php echo $siparis["adres"]; ?></p>
                        <p><?php echo $ilce["ilce_title"]; ?> / <?php echo $sehir["adi"]; ?></p> 

					</td>
					
					<td>
 
                        <blockquote><p><strong><small><?php echo $siparis["siparis_notu"]; ?></small></strong></p></blockquote>
							
					</td>
					
					<td class="text-center">

						<?php if ($siparis["siparis_odeme"] == "odenmedi") { ?>
						    <span class="btn btn-warning btn-xs btn-block blink">Ödeme Bekliyor</span>
						<?php } else { ?>
						    <span class="btn btn-success btn-xs btn-block">Ödendi</span>
						<?php } ?>
                        
						<?php if ($siparis["siparis_onay"] == "") { ?>
						    <span class="btn btn-warning btn-xs btn-block blink">Onay Bekliyor</span>
						<?php } else { ?>
						    <span class="btn btn-success btn-xs btn-block">Onaylandı</span>		
                        <?php } ?>
							
					</td>

					<td> 
						
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
										<h4 style="display: grid; width: 100%;"><strong><?=$siparis["siparis_no"]?></strong> sipariş numaralı paket silinecektir. İşlemi onaylıyor musunuz?</h4>
									</div>
							  </div>
							  <div class="modal-footer">
								<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
								<a href="index.php?do=siparisler/siparis_daire_kirala&hareketIslem=sil&id=<?php echo $siparis["id"] ?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
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

</section>

<style media="screen">
	.control-label {
		padding-top: 15px !important;
	}
</style>


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
