<?php 
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
	uyeYasak(yetki());
	$islem = $_GET["islem"];
	$emlak = $_GET["emlak"]; 
	$hareket = $_GET["hareket"];
	$id = $_GET["id"];
	$ilid = $_GET["ilid"];
	$ilcelist = $_GET["ilcelist"];
 ?> 
<section class="content-header">
	<i class="fa fa-edit fa-2x pull-left"></i>
	İlçe Yönetimi
	<p> <small> İlçe Yönetimi </small> </p> 
</section> 
<section class="content"> 
	<div class="box-header">
		 <div class="pull-right">
			<a href="index.php?do=islem&emlak=ilceyonet&islem=ekle" class="btn btn-lg bt-xs btn-success">
				<i class="fa fa-plus"></i> Yeni Ekle
			</a>                    
		 </div> 
	</div>
	<div class="box">
		<div class="box-body table-responsive">
			<?php if ($hareket == "onay") { onay(); } ?>
			<?php if ($islem == "sil") { 
				$ilsil = $vt->query("delete from ilce where ilce_id = '$id'");
				go("index.php?do=islem&emlak=ilceler&hareket=onay",0);
			} ?>
			<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
				<table id="example1" class="table table-bordered table-striped table-hover dataTable" role="grid" aria-describedby="example1_info">
					<thead>
					<tr role="row">                        
						<td class="text-center" style="width:0.00001%;"> ID </td> 
						<td style="width:0.03%;"> Şehir Adı </td> 
						<td style="width:5%;"> İlçe Adı </td>
						<td class="text-center" style="width:0.1%;"> İşlemler </td> 
					</tr>
					</thead>
					<tbody>
					<?php 
						if($islem == "ilceno") {
					?>
					<?php 
						$dbilceler = $vt->query("select * from ilce where ilce_sehirkey = '$ilid'");
						while($ilce = $dbilceler->fetch()) {
					?>
					<tr>
						<th><?=$ilce["ilce_id"];?></th>
						<th><?=$ilce["ilce_title"];?></th>
						<th>
						<?php 
							$sehir = $vt->query("select * from sehir where sehir_key = '$ilce[ilce_sehirkey]'");
							$s=$sehir->fetch();
							echo $s["adi"];
						?>
						</th>
						<th class="text-center">
							<a href="index.php?do=islem&emlak=ilceyonet&islem=duzenle&id=<?=$ilce['ilce_id']?>" title="Düzenle" class="btn btn-xs btn-inverse">
								<i class="fa fa-pencil"></i>
							</a>
							<?php 
								if(!$islem == "ilceno") {
							?>
							<a href="index.php?do=islem&emlak=ilceler&islem=ilceno&ilid=<?=$s['sehir_key']?>" title="Alt Kategoriler" class="btn btn-default">
								<i class="fa fa-plus"></i>
							</a>
							<?php } ?>
							<a href="index.php?do=islem&emlak=ilceler&islem=sil&id=<?=$ilce['ilce_id']?>" title="Sil" class="btn btn-danger">
								<i class="fa fa-trash"></i>
							</a>
						</th>
					</tr>
					<?php } ?>
					<?php } else { ?>
					<?php 
						if ($ilcelist) {
							$dbilceler = $vt->query("select * from ilce where ilce_sehirkey = '$ilcelist'");
						} else {
							$dbilceler = $vt->query("select * from ilce order by ilce_sehirkey desc");
						}
						while($ilce = $dbilceler->fetch()) {
					?>
					<tr>
						<th><?=$ilce["ilce_id"];?></th>
						<th>
						<?php 
							$sehir = $vt->query("select * from sehir where sehir_key = '$ilce[ilce_sehirkey]'");
							$s=$sehir->fetch();
							echo $s["adi"];
						?>
						</th>
						<th><?=$ilce["ilce_title"];?></th>
						<th class="text-center">
							<?php 
								if(!$islem == "ilceno") {
							?> 
							<?php } ?>
							<a href="index.php?do=islem&emlak=ilceyonet&islem=duzenle&id=<?=$ilce['ilce_id']?>" title="Düzenle" class="btn btn-inverse">
								<i class="fa fa-pencil"></i>
							</a>
							<a href="index.php?do=islem&emlak=ilceler&islem=sil&id=<?=$ilce['ilce_id']?>" title="Sil" class="btn btn-danger">
								<i class="fa fa-trash"></i>
							</a>
						</th>
					</tr>
					<?php } ?>
					<?php } ?>
					</tbody> 
				</table>
			</div>
		</div>
	</div>
</section>   
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