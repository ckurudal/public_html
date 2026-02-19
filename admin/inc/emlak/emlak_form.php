<?php 
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
	uyeYasak(yetki());
	$islem = $_GET["islem"];
	$id = $_GET["id"];	
	$durum = $_GET["durum"];
	$hareket = $_GET["hareket"];
    if ($islem == "aramaaktif") {
    	$aramaaktif = $vt->query("UPDATE emlak_form SET arama = '1' where id = '$id'");
    	go("index.php?do=emlak/emlak_form&hareket=onay");
    }
    if ($islem == "aramapasif") {
    	$aramapasif = $vt->query("UPDATE emlak_form SET arama = '0', metinalani = '0', toplusecim = '0', minmax = '0' where id = '$id'");
    	go("index.php?do=emlak/emlak_form&hareket=onay");
    }
    if ($islem == "topluaktif") {
    	$aramaaktif = $vt->query("UPDATE emlak_form SET toplusecim = '1', metinalani = '0', arama = '1' where id = '$id'");
    	go("index.php?do=emlak/emlak_form&hareket=onay");
    }
    if ($islem == "toplupasif") {
    	$aramapasif = $vt->query("UPDATE emlak_form SET toplusecim = '0' where id = '$id'");
    	go("index.php?do=emlak/emlak_form&hareket=onay");
    }
    if ($islem == "metinalaniaktif") {
    	$aramaaktif = $vt->query("UPDATE emlak_form SET metinalani = '1', toplusecim = '0', minmax = '0', arama = '1' where id = '$id'");
    	go("index.php?do=emlak/emlak_form&hareket=onay");
    }
    if ($islem == "metinalanipasif") {
    	$aramapasif = $vt->query("UPDATE emlak_form SET metinalani = '0' where id = '$id'");
    	go("index.php?do=emlak/emlak_form&hareket=onay");
    }
    if ($islem == "minmaxaktif") {
    	$aramaaktif = $vt->query("UPDATE emlak_form SET minmax = '1', metinalani = '0', arama = '1' where id = '$id'");
    	go("index.php?do=emlak/emlak_form&hareket=onay");
    }
    if ($islem == "minmaxpasif") {
    	$aramapasif = $vt->query("UPDATE emlak_form SET minmax = '0' where id = '$id'");
    	go("index.php?do=emlak/emlak_form&hareket=onay");
    }
 ?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<i class="fa fa-edit fa-2x pull-left"></i>
    İlan Formları
    <small> İlan Seçenekleri </small> 
</section> 
<?php if ($islem == "") { ?>
<section class="content">
	<form method="post" action="" enctype="multipart/form-data">
		<?php  
			if (isset($_POST["sirakaydet"])) {
				$sira = $_POST["sira"]; 
				$siraid = $_POST["siraid"]; 
				for ($i=0; $i < count($sira); $i++) { 
					$sirakaydet = $vt->query("UPDATE emlak_form SET sira = '$sira[$i]' where id = '$siraid[$i]'");
				}
			}
			 // durum guncelle 
	        if ($durum) {
	            $ver = $vt->query("SELECT * FROM emlak_form WHERE id = '$durum'")->fetch();
	            $kdurum = $ver["durum"];
	            if ($ver["durum"] == 1) {
	                    $vt->query("UPDATE emlak_form SET durum = '0' WHERE id = '$durum'");
	                    onay();
	                } else {
	                    $vt->query("UPDATE emlak_form SET durum  = '1' WHERE id = '$durum'");
	                    onay();
	            }
	        }
		?>
		<div class="b ox">
			<?php 
				if ($hareket=="onay") {
					onay();
				}
			?>
			<div class="box-bo dy table-responsive">
	            <a href="index.php?do=islem&emlak=emlak_form&islem=ekle" class="btn btn-lg bt-xs btn-success">
	                <i class="fa fa-plus"></i> Yeni Form Ekle
	            </a>  
	          	<table id="example1" class="table table-bordered dataTable" colspan="5" role="grid" aria-describedby="example1_info">
                    <thead>
	                    <tr>
	                        <td style="width:1%;" class="text-center"> #ID </td>
	                        <td style="width:1%;"> İlan Formu </td>
	                        <td style="width:1%;" class="text-center"> İkon </td>
	                        <td style="width:1%;" class="text-center"> İlan Özeti </td>
	                        <td style="width:50%;"> Aktif Kategoriler </td>
	                        <td style="width:1%;"> Sıra No </td>
	                        <td style="width:1%;"> Durum </td>
	                        <td style="width:1%;" class="hidden"> Arama Formu Ayarları</td>
	                        <td style="width:1%;" class="text-center"> İşlemler </td>
	                    </tr>
                    </thead>
                    <tbody>
                    	<?php
                    		$query=$vt->query("SELECT * FROM emlak_form ORDER BY sira ASC");
                    		while ($row=$query->fetch()) {
                    	?>
                    	<tr> 
                        <tr> 
                            <th class="hidden">
	                    		<h5><strong><?=$row["sira"];?></strong></h5>
	                    	</th>
                            <th class="text-center" style="width: 8px; white-space: nowrap;"> 
	                    		<h5><strong><?=$row["id"];?></strong></h5>
	                    	</th>
	                    	<th class="" style="width: 8px; white-space: nowrap;">
	                    		<h5><strong><?=$row["ad"];?></strong></h5>
	                    	</th>
                            <th class="text-center" style="width: 8px; white-space: nowrap;"> 
	                    		<i class="<?php echo $row["ikon"]; ?> fa-2x"></i>
	                    	</th>
                            <th class="text-center" style="width: 8px; white-space: nowrap;"> 
	                    		<?php if($row["ozet"] == 1): ?>
                                    <span class="btn btn-success btn-xs"><i class="fa fa-check"></i> Görünür</span>
                                <?php else: ?> 
                                    <span class="btn btn-danger btn-xs"><i class="fa fa-times"></i> Görünmez</span>
                                <?php endif; ?>
	                    	</th>
	                    	<th class=""> 
	                    	<?php
	                    		$formkat=$vt->query("SELECT * FROM emlak_form_kat where eformid = '$row[id]'");
	                    		while ($formkatver=$formkat->fetch()) {
									$kategori=$vt->query("SELECT * FROM emlak_kategori where kat_id = '$formkatver[kat]'");
									$kategoriver=$kategori->fetch();
									echo '<span class="btn btn-default btn-xs" style="margin-bottom:5px;">'.$kategoriver[kat_adi].'</span> ';	                    			
	                    		}
	                    	?>
	                    	 </th>
	                    	<th style="width: 8px; white-space: nowrap;"> 
	                    	<input type="text" class="hidden" name="siraid[]" value="<?=$row["id"];?>">
	                    	<input type="text" name="sira[]" value="<?=$row["sira"];?>">
	                    	 </th>
	                    	<th class="" style="width: 8px; white-space: nowrap;"> 
	                    	<?php 
		                    	if ($row["durum"] == 0 ) {
                                    echo '
										<span class="btn bg-success btn-xs btn-block"> Aktif </span>
									';
                                } else {
                                    echo '
										<span class="btn bg-danger btn-xs btn-block"> Pasif </span>
									';
                                }
	                    	?>
	                    	 </th>	                    	 
	                    	 <th class="hidden">
	                    	 	<?php if ($row["arama"] == 0) { ?>
	                    	 	<a href="index.php?do=emlak/emlak_form&islem=aramaaktif&id=<?=$row["id"];?>" class="btn btn-default btn-block btn-xs text-left">
	                    	 		<span class="btn btn-default btn-xs"><i class="fa fa-check"></i></span> Arama Formunda Göster
	                    	 	</a>
	                    	 	<?php } else { ?>
	                    	 	<a href="index.php?do=emlak/emlak_form&islem=aramapasif&id=<?=$row["id"];?>" class="btn btn-default btn-block btn-xs text-left">
	                    	 		<span class="btn btn-danger btn-xs"><i class="fa fa-close"></i></span> Arama Formunda Gizle
	                    	 	</a>
	                    	 	<?php } ?>
	                    	 	<?php if ($row["metinalani"] == 0) { ?>
	                    	 	<a href="index.php?do=emlak/emlak_form&islem=metinalaniaktif&id=<?=$row["id"];?>" class="btn btn-default btn-block btn-xs text-left">
	                    	 		<span class="btn btn-default btn-xs"><i class="fa fa-check"></i></span> Metin Alanı Aktif Et
	                    	 	</a>
	                    	 	<?php } else { ?>
	                    	 	<a href="index.php?do=emlak/emlak_form&islem=metinalanipasif&id=<?=$row["id"];?>" class="btn btn-default btn-block btn-xs text-left">
	                    	 		<span class="btn btn-danger btn-xs"><i class="fa fa-close"></i></span> Metin Alanı Pasif Et
	                    	 	</a>
	                    	 	<?php } ?>
	                    	 	<?php if ($row["toplusecim"] == 0) { ?>
	                    	 	<a href="index.php?do=emlak/emlak_form&islem=topluaktif&id=<?=$row["id"];?>" class="btn btn-default btn-block btn-xs text-left">
	                    	 		<span class="btn btn-default btn-xs"><i class="fa fa-check"></i></span> Liste / Toplu Seçim Aktif Et
	                    	 	</a>
	                    	 	<?php } else { ?>
	                    	 	<a href="index.php?do=emlak/emlak_form&islem=toplupasif&id=<?=$row["id"];?>" class="btn btn-default btn-block btn-xs text-left">
	                    	 		<span class="btn btn-danger btn-xs"><i class="fa fa-close"></i></span> Liste / Toplu Seçim Pasif Et
	                    	 	</a>
	                    	 	<?php } ?> 	                    	 	
	                    	 	<?php if ($row["minmax"] == 0) { ?>
	                    	 	<a href="index.php?do=emlak/emlak_form&islem=minmaxaktif&id=<?=$row["id"];?>" class="btn btn-default btn-block btn-xs text-left">
	                    	 		<span class="btn btn-default btn-xs"><i class="fa fa-check"></i></span> Min - Max <?php if ($row["toplusecim"] == 1) {echo "Liste";} else {echo "Metin";}?> Aktif Et
	                    	 	</a>
	                    	 	<?php } else { ?>
	                    	 	<a href="index.php?do=emlak/emlak_form&islem=minmaxpasif&id=<?=$row["id"];?>" class="btn btn-default btn-block btn-xs text-left">
	                    	 		<span class="btn btn-danger btn-xs"><i class="fa fa-close"></i></span> Min - Max <?php if ($row["toplusecim"] == 1) {echo "Liste";} else {echo "Metin";}?> Pasif Et
	                    	 	</a>
	                    	 	<?php } ?>	  
	                    	 </th>
	                    	<th class="text-center" style="width: 8px; white-space: nowrap;"> 
	                    	<a href="index.php?do=islem&emlak=emlak_form&islem=duzenle&id=<?=$row["id"];?>" title="Düzenle" class="btn btn-primary">
									<i class="fa fa-pencil"></i>
							</a>
							<?php if ($row[durum]==0) { ?>
							<a href="index.php?do=islem&emlak=emlak_form&durum=<?=$row["id"];?>" title="Pasif Et" class="btn btn-warning">
								<i class="fa fa-check"></i>
							</a>
							<?php } else { ?>
							<a href="index.php?do=islem&emlak=emlak_form&durum=<?=$row["id"];?>" title="Aktif Et" class="btn btn-success">
								<i class="fa fa-close"></i>
							</a>
							<?php } ?>
							<a  data-toggle="modal" data-target="#<?=$row["id"]?>" href="#" title="Sil" class="btn btn-danger">
								<i class="fa fa-trash"></i>
							</a>
							<div class="modal modal-default text-center fade" id="<?=$row["id"]?>" style="display: none;">
							  <div class="modal-dialog">
								<div class="modal-content">
								  <div class="modal-header alert alert-info">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">×</span></button>
									<h4 class="modal-title"><i class="fa fa-close"></i> Silme Onayı Ver</h4>
								  </div>
								  <div class="modal-body">
									<h4><strong> "<?=$row["ad"]?>" </strong> isimli form silinecektir. İşlemi onaylıyor musunuz ?</h4>
								  </div>
								  <div class="modal-footer">
									<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
									<a href="index.php?do=islem&emlak=emlak_form&islem=sil&id=<?=$row["id"];?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
								  </div>
								</div> 
							  </div> 
							</div> 							
	                    	</th>
                    	</tr>
                    	<?php } ?>
                    </tbody>
            </table>
			</div>
		</div>
	    <button name="sirakaydet" class="btn btn-lg btn-primary"> <i class="fa fa-save fa-lg"></i> Sıralamayı Kaydet </button>
	</form>
</section>
<?php } ?>
<?php if ($islem == "sil") { ?>
	<section class="content">
		<?php 
			$id = $_GET[id];
			$sil = $vt->query("DELETE FROM emlak_form where id = '$id'");
			$silformkat = $vt->query("DELETE FROM emlak_form_kat where eformid = '$id'");
			if ($sil || $silformkat) {				
				onay("Başarılı bir şekilde silindi");
				go("index.php?do=islem&emlak=emlak_form",0.5);
			} else {
				hata();
			}
		?>
	</section>
<?php } ?>
<?php if ($islem == "ekle") { ?>
<form method="post" action="" enctype="multipart/form-data">
	<section class="content">
			<?php 
				$eform = $vt->query("SHOW TABLE STATUS LIKE 'emlak_form'")->fetch();					
				$efi = $eform['Auto_increment'];
			 ?>
			<?php
				if (isset($_POST["ekleFormKat"])) {
					$kat = $_POST['kat'];
					$deg = $_POST['deg'];
					$ad = $_POST['ad'];
					$seo = seo($_POST['ad']);
					$ozet = seo($_POST['ozet']);
					$ikon = seo($_POST['ikon']);
					$ilansekli = $_POST['ilansekli'];
					if (empty($ad) || empty($kat)) {
						hata('<strong>"Başlık"</strong> ve <strong>"Gösterilecek Kategoriler"</strong> boş olamaz!');
					} else {
						foreach ($kat as $k) {
							$isekli=$vt->query("SELECT * FROM emlak_kategori where kat_id = '$k'");
							$i=$isekli->fetch();
							$ekle = $vt->query("INSERT INTO emlak_form_kat (kat, eformid, ilansekli) VALUES ('$k','$efi','$i[ilansekli]')");
						}
						$adekle = $vt->query("INSERT INTO emlak_form (deg,ad, seo, ozet, ikon) VALUES ('$deg','$ad','$seo','$ozet','$ikon')");						
						if ($ekle && $adekle) {
							onay("Emlak formları başarılı bir şekilde eklenmiştir.");
						}
					}
				}
			?>
	 	<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title"><i class="fa fa-check"></i> İlan Form Ekleme </h3>
			  <!-- tools box -->
			  <div class="pull-right box-tools">
				<a href="#" class="btn" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Daralt">
				  <i class="fa fa-minus"></i></a>
				<a href="#" class="btn" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Kapat">
				  <i class="fa fa-times"></i></a>
			  </div>
			  <!-- /. tools -->
			</div> 
			<!-- /.box-header -->
			<div class="box-body pad" style="">
				<div class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-2 control-label">Başlık:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="ad">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Seçiciler:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="deg">
                        <p><strong>Seçicileri virgülle ayırınız. Örn: 2+1, 3+1, 5+1....</strong></p>
					  </div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">İlan Özetinde Göster:</label>
						<div class="col-md-10">
							<label for="anasayfa_goster">
							  <input type="radio" name="ozet" value="1" class="minimal">
								Göster
							</label>
							<label for="ozellikler">
							  <input type="radio" name="ozet" value="0" class="minimal">
								Gizle
							</label>
						</div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">İkon:</label>
					  <div class="col-sm-2"> 
						<input type="text" class="form-control" name="ikon">
					  </div>
					  <div class="col-sm-6">  
						<a class="h5" style="display:block; padding-top:5px;" href="https://fontawesome.com/search" target="_blank">İkonları Kodlarını Gör <i class="fa fa-external-link"></i></a>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Gösterilecek Kategoriler:</label>
					  <div class="col-sm-10">
		                	<select name="kat[]" style="min-height: 500px;" multiple class="form-control">
		                		<?php 
		                			$qkat=$vt->query("SELECT * FROM emlak_kategori WHERE kat_ustid = 0");
		                			while($kategori=$qkat->fetch()) {
		                		?>
			                    <optgroup label="<?=$kategori["kat_adi"];?>">
									<option value="<?=$kategori["kat_id"];?>"> <?=$kategori["kat_adi"];?> </option>
									<?php 
										$katid = $kategori["kat_id"];
										$qust = $vt->query("SELECT * FROM emlak_kategori where kat_ustid = '$katid'");
										while($ustkat=$qust->fetch()) {
									?>
									<option value="<?=$ustkat["kat_id"];?>"> -- <?=$ustkat["kat_adi"];?> </option>
									<?php } ?>
			                    </optgroup>
			                    <?php } ?>
		                  </select>
					  </div>
					</div> 
				</div>
			</div>
			<div class="box"> 
				<div class="box-footer">
					<button type="submit" name="ekleFormKat" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Kaydet </button>
				 </div> 
			</div>
		  </div>
	</section>
</form>
<?php } ?>
<?php if ($islem == "duzenle") { ?>
<form method="post" action="" enctype="multipart/form-data">
	<section class="content">
		  	<?php 
		  		if (isset($_POST["duzenleFormKat"])) {
		  			$kat = $_POST['kat'];
					$deg = $_POST['deg'];
					$ad = trim($_POST['ad']);
					$seo = seo($_POST['ad']);
					$sira=$_POST['sira'];	
					$ozet=$_POST['ozet'];	
					$ikon=$_POST['ikon'];					
					$formd = $vt->query("UPDATE emlak_form SET ad = '$ad', seo = '$seo', deg = '$deg', sira = '$sira', ozet = '$ozet', ikon = '$ikon' where id = '$id'");
					$forms = $vt->query("DELETE FROM emlak_form_kat WHERE eformid = '$id'");
					foreach ($kat as $k) {
						$isekli=$vt->query("SELECT * FROM emlak_kategori where kat_id = '$k'");
						$i=$isekli->fetch();
						$ekle = $vt->query("INSERT INTO emlak_form_kat (kat, eformid, ilansekli) VALUES ('$k','$id','$i[ilansekli]')");
					}					
					if ($forms) {
						onay("Başarılı bir şekilde güncellendi.");
						go("index.php?do=islem&emlak=emlak_form", 0.5);
					} else {
						hata();
					}
		  		}
		  	?>
		  	<?php
		  		$e = $vt->query("SELECT * FROM emlak_form where id = '$id'")->fetch();		  		
		  		$emlakformkat = $vt->query("SELECT * FROM emlak_form_kat where eformid = '$id'")->fetch();
		  		$efk = $emlakformkat['kat'];
		  		$ayir = explode(",", $efk);
		  		$esitle = $ayir;
		  		$katsec = $vt->query("SELECT * FROM emlak_kategori where kat_id = '$efk'")->fetch();
		  		$formver = $katsec[kat_id];
			?>
	 	<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title"><i class="fa fa-check"></i> İlan Bilgileri </h3>
			  <!-- tools box -->
			  <div class="pull-right box-tools">
				<a href="#" class="btn" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Daralt">
				  <i class="fa fa-minus"></i></a>
				<a href="#" class="btn" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Kapat">
				  <i class="fa fa-times"></i></a>
			  </div>
			  <!-- /. tools -->
			</div> 
			<!-- /.box-header -->
			<div class="box-body pad" style="">
				<div class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-2 control-label">Başlık:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="ad" value="<?=$e[ad];?>">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Seçiciler:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="deg" value="<?=$e[deg];?>">
					  </div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">İlan Altında Göster:</label>
						<div class="col-md-10">
							<label for="anasayfa_goster">
							  <input type="radio" name="ozet" <?php if($e["ozet"]==1): ?>checked<?php endif; ?> value="1" class="minimal">
								Göster
							</label>
							<label for="ozellikler">
							  <input type="radio" name="ozet" <?php if($e["ozet"]==0): ?>checked<?php endif; ?> value="0" class="minimal">
								Gizle
							</label>
						</div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Kategori İkon:</label>
					  <div class="col-sm-2"> 
						<input type="text" class="form-control" name="ikon" value="<?=$e["ikon"];?>">
					  </div>
					  <div class="col-sm-6">  
						<a class="h5" style="display:block; padding-top:5px;" href="https://fontawesome.com/v3.2.1/icons/" target="_blank">İkonları Kodlarını Gör <i class="fa fa-external-link"></i></a>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Gösterilecek Kategoriler:</label>
					  <div class="col-sm-10">
					  	<?php 
							$emlakformkat = $vt->query("SELECT * FROM emlak_form_kat where eformid = '$id'")->fetch();
							$al = $emlakformkat["kat"];
							$eformidver = $emlakformkat["eformid"];
							$ayire = explode(",", $al);
						?>
	                	<select name="kat[]" style="min-height: 500px;" multiple class="form-control">
	                		<?php
	                			$qkat=$vt->query("SELECT * FROM emlak_kategori WHERE kat_ustid = 0");
	                			while($kategori=$qkat->fetch()) {										
	                		?> 
		                    <optgroup label="<?=$kategori["kat_adi"];?>">
								<option 
								<?php   
									$formkatver = $vt->query("select * from emlak_form_kat where eformid = '$id'");									
			                		while ($efk=$formkatver->fetch()) {
			                			if ($efk[kat] == $kategori["kat_id"]) {				                				
			                				echo "selected ";
			                			}
			                		}
								?>
								value="<?=$kategori["kat_id"];?>"> <?=$kategori["kat_adi"];?> </option>									
								<?php 
									$katid = $kategori["kat_id"];
									$qust = $vt->query("SELECT * FROM emlak_kategori where kat_ustid = '$katid'");
									while($ustkat=$qust->fetch()) {
								?>
								<option 
								<?php   
									$formkatver = $vt->query("select * from emlak_form_kat where eformid = '$id'");									
			                		while ($efk=$formkatver->fetch()) {
			                			if ($efk[kat] == $ustkat["kat_id"]) {				                				
			                				echo "selected ";
			                			}
			                		}
								?>
								value="<?=$ustkat["kat_id"];?>"> -- <?=$ustkat[kat_adi];?>
								</option>
								<?php } ?>
		                    </optgroup>
		                    <?php } ?>
	                 	</select>	                 	
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Sıra:</label>
					  <div class="col-sm-10">
					  	<?php 
					  		$e=$vt->query("SELECT * FROM emlak_form WHERE id ='$id'");
					  		$ecek=$e->fetch();
					  	?>
					  	<input type="text" name="sira" class="form-control" value="<?=$ecek[sira];?>">
					  </div>
					</div>
				</div>
			</div>
			<div class="box"> 
				<div class="box-footer">
					<button type="submit" name="duzenleFormKat" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Kaydet </button>
				 </div> 
			</div>
		  </div>
	</section>
</form>
<?php } ?>
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