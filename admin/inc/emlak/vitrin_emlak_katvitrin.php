<?php 

	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
	
	uyeYasak(yetki());
	
	$hareket = $_GET["hareket"];
	$vitrin = $_GET["vitrin"];
	$id = $_GET["id"];
 ?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<i class="fa fa-edit fa-2x pull-left"></i>
	Kategori Vitrin İlanlari
	<p> <small> Vitrin Yönetimi </small> </p> 
</section> 
<form method="post" action="" enctype="multipart/form-data">	
	<?php 
		
		$emlakilan = mysql_query("select * from emlak_ilan where id");
		$e = mysql_fetch_array($emlakilan);
	
		if (empty($e)) {
	?>
	
	<section class="content">
		<!-- <h4 class="alert alert-success">Henüz ilan eklenmemiş</h4> -->
		<div class="col-md-2">
			<a  class="well btn-block btn-success text-center" href="index.php?do=islem&emlak=emlak_ekle&islem=sec">
				<i class="fa fa-flag fa-lg" style="font-size:65px;"></i>
				<h4 class="">Yeni İlan Ekle</h4>
			</a> 
		</div>
		<div class="col-md-2">
			<a  class="well btn-block btn-info text-center" href="index.php?do=islem&emlak=emlak_ekle&islem=sec">
				<i class="fa fa-cogs fa-lg" style="font-size:65px;"></i>
				<h4 class="">Yeni Kategori Ekle</h4>
			</a> 
		</div>
		<div class="col-md-2">
			<a  class="well btn-block btn-primary text-center" href="index.php?do=islem&emlak=emlak_ekle&islem=sec">
				<i class="fa fa-users fa-lg" style="font-size:65px;"></i>
				<h4 class="">Yeni Müşteri Ekle</h4>
			</a> 
		</div>
		<div class="col-md-2">
			<a  class="well btn-block btn-default text-center" href="index.php?do=islem&emlak=emlak_ekle&islem=sec">
				<i class="fa fa-home fa-lg" style="font-size:65px;"></i>
				<h4 class="">Yeni Müşteri Ekle</h4>
			</a> 
		</div>
		<div class="col-md-2">
			<a  class="well btn-block btn-warning text-center" href="index.php?do=islem&emlak=emlak_ekle&islem=sec">
				<i class="fa fa-home fa-lg" style="font-size:65px;"></i>
				<h4 class="">Yeni Müşteri Ekle</h4>
			</a> 
		</div>
		<div class="col-md-2">
			<a  class="well btn-block btn-danger text-center" href="index.php?do=islem&emlak=emlak_ekle&islem=sec">
				<i class="fa fa-home fa-lg" style="font-size:65px;"></i>
				<h4 class="">Yeni Müşteri Ekle</h4>
			</a> 
		</div>
	</section>
	
	<?php } else { ?>
	<section class="content">
		 <div class="bo x"> 
			<div class="box-bo dy table-responsive">  
				<?php  
					// vitrin guncelle  
					if ($vitrin == "onay") { 
						$anavitrin = mysql_query("update emlak_ilan set katvitrin = '0' where id = '$id'"); 
						onay();
					} 
				?> 
                <table id="example1" class="table table-bordered dataTable" colspan="5" role="grid" aria-describedby="example1_info">
                    <thead class="bg-success">
                    <tr>                        
                        <td class="text-center" style="width:0.00000001%;"> ID </td>
                        <td style="width:0.3%;" colspan="2"> İlan Bilgileri </td>
                        <td style="width:0.5%;"> Kategori / Pörtföy Sahibi </td>
                        <td style="width:0.1%;"> Ekleme Bilgisi </td>
                        <td style="width:1%;" colspan="2"> İlan Detayları </td> 
                        <td style="width:0.3%;"> Sıralama </td>
                    </tr>
                    </thead>
                    <tbody> 
                    <?php 
                    	$ilanlar=mysql_query("SELECT * FROM emlak_ilan where katvitrin = '1' order by id DESC");
                    	while ($ilan=mysql_fetch_array($ilanlar)) {
                    ?>
					<?php 
						$katadi=mysql_query("SELECT * FROM emlak_kategori where kat_id = '$ilan[katid]'");
						$k=mysql_fetch_array($katadi);
					?>
                    <tr>
                    	<th class="text-center">
						<?=$ilan['id'];?>
                    	</th>
                    	<th>
							<?php 
								$resver=$ilan['emlakno'];
								$resim=mysql_query("SELECT * FROM emlak_resim where emlakno = '$resver' and kapak = '1'");
								$r=mysql_fetch_array($resim); 
								if (empty($r['emlakno'])) { ?> 
								<div class="resim_liste">
									<a target="_blank" class="text-baslik" href="index.php?do=islem&emlak=emlak_duzenle&id=<?=$ilan['id']?>" title="<?=$ilan["baslik"];?>">
										<img src="../uploads/resim/resim.png"/>
									</a>
								</div>
							<?php } else { ?> 
								<div class="resim_liste">
									<a target="_blank" class="text-baslik" href="index.php?do=islem&emlak=emlak_duzenle&id=<?=$ilan['id']?>" title="<?=$ilan["baslik"];?>">
										<img src="../uploads/resim/<?=$r['resimad'];?>" />
									</a>
								</div>
							<?php } ?> 
						</th>
                    	<th>
							<span class="btn btn-xs btn-default btn-block"> İlan No: <strong><?=$ilan["emlakno"];?></strong></span>
							<?php if (empty($ilan["baslik"])) { ?>
								<a target="_blank" style="background: #fbdede; color: red; border: 1px solid #fb9393;" class="text-baslik" href="index.php?do=islem&emlak=emlak_duzenle&id=<?=$ilan['id']?>" title="Başlık girilmemiş"> <strong> Başlık girilmemiş </strong> </a>
							<?php } else { ?>
								<a target="_blank" class="text-baslik" href="index.php?do=islem&emlak=emlak_duzenle&id=<?=$ilan['id']?>" title="<?=$ilan["baslik"];?>"> <?=$ilan["baslik"];?> </a>
							<?php } ?>							
						</th>
						<th>
							<span class="btn btn-block btn-default btn-xs"><span><?=$k["kat_adi"];?></span></span>
							<span class="btn btn-block btn-default btn-xs">Aynur HOŞBAŞ</span> 
						</th>
                    	<th> 
							<span class="btn btn-block btn-default btn-xs"><strong>Ekleme Tarihi:</strong> <?=date("d-m-Y",strtotime($ilan['eklemetarihi']));;?></span>
						</th>
                    	<th>
                    		<?php 
                    			$ilantipi=mysql_query("SELECT * FROM emlak_ilantipi where id = '$ilan[ilantipi]'");
                    			$tip=mysql_fetch_array($ilantipi);
                    			if (!$tip["id"]==0) {
                    				echo '<span class="btn btn-block btn-xs btn-warning ">'.$tip["ad"].'</span>';                    				
                    			}
                    			echo "<span class='btn btn-block btn-default btn-xs'>".$ilan['fiyat']." ".$ilan['fiyatkur']."</span>";
                    		?>  
							<?php if ($ilan["kiralandi"]==1) { ?>
								<span class="btn btn-danger btn-xs btn-block">Kiralandı</span>
							<?php } ?> 
							<?php if ($ilan["satildi"]==1) { ?>
								<span class="btn btn-danger btn-xs btn-block">Satıldı</span>
							<?php } ?>
							<?php 
								if ($ilan[durum] == 0) {
									echo '<span class="btn btn-success btn-xs btn-block"> Yayında </span>';
								} else {
									echo '<span class="btn btn-info btn-xs btn-block"> Yayında Değil</span>';
								}
							?>	
                    	</th>
                    	<th>
							<a href="index.php?do=islem&emlak=emlak_katvitrin&vitrin=onay&id=<?=$ilan["id"];?>" class="btn btn-default btn-xs btn-block" style="text-align: left;">
								<i class="fa fa-check" style="color: #0ac7ff;"></i> 
								<span>Kategori Vitrin</span>
							</a>
						</th> 
                    	<th>
							<input type="text" value="1" name="sira" class="form-control">
						</th>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
          </div>  

	</section>
	<?php } ?>
</form>

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
