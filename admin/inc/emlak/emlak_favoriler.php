<?php
	
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
	if($_GET["islem"]=="sil") {
	    $favori_sil = $vt->exec("DELETE FROM favoriler WHERE ilan_id = '{$_GET["id"]}' AND uye_id = '{$_SESSION["id"]}'");
	}

 ?>
<!-- Content Header (Page header) -->
<section class="content-header"> 
	<i class="fa fa-heart fa-2x pull-left"></i>
	Favori İlanlarım
	<p> <small> Favori İlanlarım </small> </p>  
</section> 
	
	<section class="content">
	 <div class="box"> 
		<h4 class="alert alert-primary">
        	<i class="fa fa-heart-o fa-lg"></i> Favoriye Eklediğim İlanlar
        </h4>
        <div class="box box-body">
        	<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive">
        		<table id="example3" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example4_info">
        			<thead>
        				<tr>
        					<th class="text-center" style="width: 3%"><p><strong>ID</strong></p></th>
        					<th style="width: 1%"><p><strong>Resim</strong></p></th>
        					<th style="width: 1%"><p><strong>Fiyat</strong></p></th>
        					<th style="width: 50%"><p><strong>Başlık</strong></p></th>
        					<th style="width: 15%"><p><strong>Durum</strong></p></th> 
        					<td class="text-center" style="width:8% !important; white-space: nowrap;"> İşlemler </td>
        				</tr>
        			</thead>
        			<tbody>
        				<?php
        
        					$uye_ilan = $vt->query("SELECT 
        					
        					    emlak_ilan.*, 
        					    emlak_ilansekli.baslik AS ilansekli, 
        					    emlak_ilantipi.ad AS ilantipi,
        					    sehir.adi AS sehir
        					    
        					    FROM emlak_ilan 
        					
        					    INNER JOIN favoriler ON emlak_ilan.id = favoriler.ilan_id
        					    INNER JOIN emlak_ilantipi ON emlak_ilan.ilantipi = emlak_ilantipi.id
        					    INNER JOIN emlak_ilansekli ON emlak_ilan.ilansekli = emlak_ilansekli.id
        					    INNER JOIN sehir ON emlak_ilan.il = sehir.id
        					    
        					    AND favoriler.uye_id = '{$_SESSION["id"]}'
        					    
        					    GROUP BY emlak_ilan.emlakno")->fetchAll(PDO::FETCH_OBJ); 
        					foreach ($uye_ilan as $ilan) {
        				?>
        				<tr>
        					<th class="text-center" <?php if ($ilan->doping == "var") { ?> style="background:#f2dede;" <?php } ?>>
        						<?php echo $ilan->id; ?>
        					</td>
        					<td>
        						<?php
    								$resver=$ilan->emlakno;
    								$resim=$vt->query("SELECT * FROM emlak_resim where emlakno = '$resver' and kapak = '1'");
    								$r=$resim->fetch();
    								if (empty($r['emlakno'])) { ?>
    								<div class="resim_liste">
    									<img src="../uploads/resim/resim.png"/>
    								</div>
    							<?php } else { ?>
    								<div class="resim_liste">
    									<img src="../uploads/resim/<?=$r['resimad'];?>" />
    								</div>
    							<?php } ?>
    							<br>
        						<?php if ($ilan->doping == "var") { ?> <a href="index.php?do=doping/ilan_doping&ilan_id=<?php echo $ilan->id; ?>" class="btn bg-primary btn-block btn-xs"> <strong>DOPİNGLİ İLAN</strong> </a> <br> <?php } ?>
        						 
        					</td>
        					<td class="text-center" style="white-space:nowrap;"><?php echo $ilan->fiyat; ?> <?php echo $ilan->fiyatkur; ?> </td>
        					<td>
        						<?php if (empty($ilan->baslik)) { ?>
    								<a target="_blank" style="background: #fbdede; color: red; font-size:10px; border: 1px solid #fb9393;" class="btn btn-default" href="/index.php?do=emlakdetay&id=<?=$ilan->id?>" title="Başlık girilmemiş"> <strong> Başlık girilmemiş </strong> </a>
    							<?php } else { ?>
    								<a target="_blank" class="text" href="/<?=$ilan->seo;?>-ilan-<?=$ilan->id?>" title="<?=$ilan->baslik;?>"> <?=$ilan->baslik;?> </a>
    							<?php } ?>
        					</td>
        					<td>
         
        							<span class=""><?php echo $ilan->ilantipi ?>, </span> 
        							<span class=""><?php echo $ilan->ilansekli ?>, </span> 
        							<span class=""><?php echo $ilan->sehir ?></span> 
        
        					</td> 
        					<td>
        						
        						<a href="index.php?do=islem&emlak=emlak_favoriler&islem=sil&id=<?php echo $ilan->id ?>" class="btn btn-danger btn-xs btn-block"> <i class="fa fa-heart"></i> Favoriden Çıkar </a>
        
        					</td>
        				</tr>
        
        
        			<?php } ?>
        			</tbody>
        		</table>
        	</div>
        
        </div> 
	</section>
</form>

 
