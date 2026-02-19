<?php 

	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
	
	uyeYasak(yetki());	
  
	$islem = $_GET["islem"];
	$emlak = $_GET["emlak"]; 
	$hareket = $_GET["hareket"];
	$id = $_GET["id"];
		
	$dbiller = $vt->query("select * from sehir order by sehir_key desc");

 ?> 
<section class="content-header">
	
	<i class="fa fa-edit fa-2x pull-left"></i>
	
	İl Yönetimi

	<p> <small> İl Yönetimi </small> </p> 

</section>
<section class="content"> 
	<div class="box-header">
		 <a href="index.php?do=islem&emlak=ilyonet&islem=ekle" class="btn btn-lg bt-xs btn-success">
			<i class="fa fa-plus"></i> Yeni Ekle
		</a>  
		<br>
		<br>
	</div>
	<div class="box">
		<div class="box-body pad table-responsive">
			<?php if ($hareket == "onay") { onay(); } ?>
			<?php if ($islem == "sil") { 
			
				$ilsil = $vt->query("delete from sehir where id = '$id'");
					
				go("index.php?do=islem&emlak=iller&hareket=onay",0);
			
			} ?>
			<table class="table table-bordered table-hover table-checkable table-striped">
				<thead>
					<tr>                        
						<td class="text-center" style="width:0.08%;"> Plâka Kodu </td> 
						<td style="width:0.4%;"> Ad </td>
						<td style="width:0.7%;"> İlçe Sayısı </td>
						<td style="width:0.1%;" class="text-center"> İlçeleri Listele </td>
						<td class="text-center" style="width:0.3%;"> İşlemler </td> 
					</tr>
				</thead>
				<tbody>
					<?php 
						while($iller = $dbiller->fetch()) { 
							$ilcelersay = $vt->query("SELECT COUNT(*) FROM ilce where ilce_sehirkey = '".$iller["sehir_key"]."'");
							$ilcesay = $ilcelersay->fetch();
					?>
					<tr> 
						<th class="text-center"> <span> <?=$iller["sehir_key"];?> </th>
						<th> <?=$iller["adi"];?> </th>
						<th> <?=$ilcesay[0];?> </th>
						<th class="text-center"> 
							<a href="index.php?do=islem&emlak=ilceler&ilcelist=<?=$iller['sehir_key']?>" title="İlçeleri Listele" class="btn btn-info">
								<i class="fa fa-plus"></i> İlçeleri Listele
								
							</a>							
						</th>
						<th class="text-center"> 
							<a href="index.php?do=islem&emlak=ilyonet&islem=duzenle&id=<?=$iller['id']?>" title="Düzenle" class="btn btn-inverse">
								<i class="fa fa-pencil"></i> 
							</a>
							<a href="index.php?do=islem&emlak=iller&islem=sil&id=<?=$iller['id']?>" title="Düzenle" class="btn btn-danger">
								<i class="fa fa-trash"></i>
							</a>
						</th>
					</tr>
					<?php } ?>
				</tbody> 
			</table>
		</div>
	</div>
</section>   