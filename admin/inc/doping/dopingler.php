<?php

	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
	$islem = $_GET["islem"];
	$hareket = $_GET["hareket"];
	$id = $_GET["id"];

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
	if ($islem == "doping_onay") {
		
		if ($hareket == 0) {$onay = 1;}
		if ($hareket == 1) {$onay = 0;}

		$onayla = $vt->query("UPDATE emlak_ilan SET doping_onay = '$onay' WHERE id = '$id'");

		go("index.php?do=doping/dopingler&islem=onay",0);

	}
?>


<?php 
	if ($islem == "doping_sil") {
				
		$sil = $vt->query("DELETE FROM doping_ilanlari WHERE ilan_id = '$id'");

		$doping_kapat = $vt->query("UPDATE emlak_ilan SET doping = 'yok', doping_onay = '0' WHERE id = '$id'");

		go("index.php?do=doping/doipngler&islem=onay",0);

	}
?>
<section class="content">
	<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive">
		<table id="example1" class="table table-bordered dataTable" colspan="5" role="grid" aria-describedby="example1_info">
				<thead>
					<tr>
						<th><p><strong> ID </strong></p></th>
						<th><p><strong> Üye </strong></p></th>
						<th><p><strong> İlan </strong></p></th>
						<th><p><strong> Alış Tarihi </strong></p></th>
						<th><p><strong> Tutar </strong></p></th>
						<th><p><strong> Ödeme Yöntemi </strong></p></th>
						<th><p><strong> Durum </strong></p></th>
						<th><p><strong> İşlemler </strong></p></th>
					</tr>
				</thead>
				<tbody>

					<?php 

						$emlak_ilan = $vt->query("SELECT * FROM emlak_ilan WHERE doping = 'var' ORDER by id DESC")->fetchAll(PDO::FETCH_ASSOC);

						foreach ($emlak_ilan as $doping) {
									
							$yonetici = $vt->query("SELECT * FROM yonetici WHERE id = '".$doping["yonetici_id"]."'")->fetch(PDO::FETCH_ASSOC);
							
							$paket = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '".$doping["id"]."'")->fetch(PDO::FETCH_ASSOC);
					?>

					<tr>
						<td class="text-center">

							<?php echo $doping["id"]; ?>
								
						</td>
						<td>
							<a target="_blank" href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $yonetici["id"]; ?>&yetki=<?php echo $yonetici["yetki"]; ?>"> <?php echo $yonetici["adsoyad"]; ?></a>							
						</td>
						<td> 
							

							<a href="index.php?do=doping/ilan_doping&ilan_id=<?php echo $doping["id"]; ?>"><?php echo $doping["baslik"]; ?></a>
						
								
						</td>
						<td class="text-center"> EKLENECEK </td>
						<td class="text-center"> <?php doping_toplam($doping["id"]); ?> </td>
						<td class="text-center"> EKLENECEK </td>
						<td>
							
							<?php if ($doping["doping_onay"] == "1") { ?> 
							<p class="text-center btn btn-block bg-success">  Onaylı </p>
							<?php } ?>
							<?php if ($doping["doping_onay"] == "0") { ?>
							<p class="text-center btn btn-block bg-danger">  Onay Bekliyor </p>								
							<?php } ?>

						</td>
						<td> 
							<?php if ($doping["doping_onay"] == "0") { ?> 
							<a href="index.php?do=doping/dopingler&islem=doping_onay&id=<?php echo $doping["id"]; ?>&hareket=0" class="text-center btn btn-block btn-xs btn-success">  Onayla </a>
							<?php } ?>
							<?php if ($doping["doping_onay"] == "1") { ?>
							<a href="index.php?do=doping/dopingler&islem=doping_onay&id=<?php echo $doping["id"]; ?>&hareket=1" class="text-center btn btn-block btn-xs btn-warning">  Onayı Kaldır </a>
							<?php } ?>

							<a href="index.php?do=doping/ilan_doping&ilan_id=<?php echo $doping["id"]; ?>" class="text-center btn btn-block btn-xs btn-primary"> Detaylar </a>
							
							<a href="#" data-toggle="modal" data-target="#sil<?=$doping["id"];?>" class="text-center btn btn-block btn-xs btn-danger"> Sil </a>

							<div class="modal modal-default fade" id="sil<?=$doping["id"];?>" style="display: none;">
							  <div class="modal-dialog">
								<div class="modal-content">
								  <div class="modal-header alert alert-info">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">×</span></button>
									<h4 class="modal-title"><i class="fa fa-close"></i> Silme Onayı Ver</h4>
								  </div>
								  <div class="modal-body">
										<h4 style="display: grid; width: 100%;"><strong> "<?=$doping["baslik"]?>" </strong> isimli ilanın tüm doipngleri silinecektir. İşlemi onaylıyor musunuz?</h4>
								  </div>
								  <div class="modal-footer">
									<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
									<a href="index.php?do=doping/dopingler&islem=doping_sil&id=<?php echo $doping["id"]; ?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
								  </div>
								</div>
							  </div>
							</div>
						</td>
					</tr>

					<?php } ?>

				</tbody>
			</div>

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
