<?php 

	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
	
	uyeYasak(yetki());
	
	$islem = $_GET["islem"];
	$id = $_GET["id"];	
	$hareket = $_GET["hareket"];	

	$aktif = 'menu-open';

 ?>
 <!-- Content Header (Page header) -->
<section class="content-header"> 
  <i class="fa fa-edit fa-2x pull-left"></i>
	
	İlan Özellik Tipleri

	<p> <small> İlan Seçenekleri </small> </p> 
</section> 
<?php if ($islem=="") { ?>
<section class="content">		
	<?php  
		$sil=$_GET["sil"];

		if ($_GET["sil"]) {
			$silid=mysql_query("DELETE FROM emlak_ozelliktip where id = '$sil'");
			if ($silid) {
				onay("Başarılı bir şekilde silindi.");
			}
		}

		 // durum guncelle 

		$durum = $_GET["durum"];

        if ($durum) {
            $ver = mysql_fetch_array(mysql_query("SELECT * FROM emlak_ozelliktip WHERE id = '$durum'"));
            $kdurum = $ver["durum"];
            if ($ver["durum"] == 1) {
                    mysql_query("UPDATE emlak_ozelliktip SET durum = '0' WHERE id = '$durum'");
                    onay();
                } else {
                    mysql_query("UPDATE emlak_ozelliktip SET durum  = '1' WHERE id = '$durum'");
                    onay();
            }
        }

	?>
	<form method="post" action="" enctype="multipart/form-data">	
		<?php
			if ($hareket == "onay") {
				onay();
			}
		?>
		<div class="bo x">
			<div class="box-he ader with-border">
	                
			     <!--
			     <div class="pull-right">
		            <button name="siraguncelle" type="submit" class="btn btn-lg bt-xs btn-primary"> <i class="fa fa-refresh"></i> Sıralamayı Güncelle </button>                     
		         </div>
		         -->
			</div>
			<div class="b ox-body table-responsive" style="">
	            <a href="index.php?do=islem&emlak=emlak_ozelliktip&islem=ekle" class="btn btn-lg bt-xs btn-success">
	                <i class="fa fa-plus"></i> Yeni Ekle
	            </a>
				<table id="example1" class="table table-bordered dataTable" colspan="5" role="grid" aria-describedby="example1_info">
                    <thead>
                    <tr>
                        <td class="text-center" style="width:1%;"> ID </td>
                        <td style="width:5%;"> Özellik Tipi </td>
                        <td style="width:25%;"> Aktif Kategoriler </td>
                        <td style="width:5%;"> Sıra No </td>
                        <td style="width:5%;"> Durum </td>
                        <td style="width:8%;"> İşlemler </td>
                    </tr>
                    </thead>
                    <tbody>
                    	<?php

                    		$query=mysql_query("select * from emlak_ozelliktip order by id desc");
                    		while ($row=mysql_fetch_array($query)) {

                    	?>
                    	<tr> 
	                    	<th class="text-center"> <h5><strong><?=$row[id];?></strong></h5> </th>
	                    	<th class=""><h5><strong><?=$row[ad];?></strong></h5></th>
	                    	<th class=""> 
	                    	<?php

	                    		$liste=mysql_query("SELECT * FROM emlak_ozelliktipliste where ozellikid = '$row[id]'");
	                    		while ($listever=mysql_fetch_array($liste)) {
	                    			
	                    		$kategori=mysql_query("SELECT * FROM emlak_kategori where kat_id = '$listever[kat]'");
	                    		while ($kat=mysql_fetch_array($kategori)) {

  							?>
	                    		
	                    		<span style="margin-bottom:3px; padding-left:20px; padding-right:20px; " class="btn btn-default btn-xs"><?=$kat[kat_adi];?></span>

	                    	<?php } } ?>
	                    		
	                    	 </th>
	                    	<th class="">
	                    	<?=$row[sira];?>
	                    	 </th>
	                    	<th class=""> 
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
	                    	<th class=""> 
	                    	<a href="index.php?do=islem&emlak=emlak_ozelliktip&islem=duzenle&id=<?=$row["id"];?>" title="Düzenle" class="btn btn-primary btn-block btn-xs">
									<i class="fa fa-pencil"></i> Düzenle
							</a> 
							<?php if ($row[durum]==0) { ?>
							<a href="index.php?do=islem&emlak=emlak_ozelliktip&durum=<?=$row["id"];?>" title="Pasif Et" class="btn btn-warning btn-block btn-xs">
								<i class="fa fa-close"></i> Pasif Yap
							</a>
							<?php } else { ?>
							<a href="index.php?do=islem&emlak=emlak_ozelliktip&durum=<?=$row["id"];?>" title="Aktif Et" class="btn btn-success btn-block btn-xs">
								<i class="fa fa-check"></i> Aktif Et
							</a>
							<?php } ?>
							<a  data-toggle="modal" data-target="#<?=$row["id"]?>" href="#" title="Sil" class="btn btn-danger btn-block btn-xs">
									<i class="fa fa-trash"></i> Sil
							</a>
							<div class="modal modal-default fade" id="<?=$row["id"]?>" style="display: none;">
							  <div class="modal-dialog text-center">
								<div class="modal-content">
								  <div class="modal-header alert alert-info">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">×</span></button>
									<h4 class="modal-title"><i class="fa fa-close"></i> Silme Onayı Ver</h4>
								  </div>
								  <div class="modal-body">
									<h4><strong> "<?=$row["ad"]?>" </strong> isimli özellik tipi silinecektir. İşlemi onaylıyor musunuz ?</h4>
								  </div>
								  <div class="modal-footer">
									<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
									<a href="index.php?do=islem&emlak=emlak_ozelliktip&sil=<?=$row["id"];?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
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
	</form>
</section>
<?php } ?>
<?php if ($islem=="ekle") { ?> 

<section class="content">		
<?php 

	$s = mysql_fetch_assoc(mysql_query("SHOW TABLE STATUS LIKE 'emlak_ozelliktip'"));
	$s1 = $s['Auto_increment']; 

	if (isset($_POST["ekle"])) {
 
		$ad = trim($_POST["ad"]);
		$seo = seo($_POST["ad"]);
		$kat = $_POST["kat"];
		$ilansekli = $_POST["ilansekli"];
  
	if (empty($ad) || empty($kat)) {
			hata('<strong>"Başlık"</strong> ve <strong>"Gösterilecek Kategoriler"</strong> boş olamaz!');
			} else {

				foreach ($kat as $k) {

					$ekle = mysql_query("INSERT INTO emlak_ozelliktipliste (kat, ozellikid) VALUES ('$k','$s1')");					

				} 

				$adekle = mysql_query("INSERT INTO emlak_ozelliktip (ad, seo) VALUES ('$ad','$seo')");

				if ($adekle) {
					onay("Emlak formları başarılı bir şekilde eklenmiştir.");
				}
			}
		} 
?> 
	<form method="post" action="" enctype="multipart/form-data">	
		<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title"><i class="fa fa-check"></i> İlan Özellik Tipi Ekleme </h3>
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
			<div class="box-body" style="">
				<div class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-2 control-label">Başlık:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="ad">
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Gösterilecek Kategoriler:</label>
					  <div class="col-sm-10">
		                	<select name="kat[]" style="min-height: 500px;" multiple class="form-control">
		                		<?php 

		                			$qkat=mysql_query("SELECT * FROM emlak_kategori WHERE kat_ustid = 0");
		                			while($kategori=mysql_fetch_assoc($qkat)) {
		                		?>
			                    <optgroup label="<?=$kategori["kat_adi"];?>">
									<option value="<?=$kategori["kat_id"];?>"> <?=$kategori["kat_adi"];?> </option>
									<?php 
										$katid = $kategori["kat_id"];
										$qust = mysql_query("SELECT * FROM emlak_kategori where kat_ustid = '$katid'");
										while($ustkat=mysql_fetch_array($qust)) {
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
					<button type="submit" name="ekle" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Ekle </button>
					<a href="index.php?do=islem&emlak=emlak_ozelliktip" class="btn btn-default btn-lg"> <i class="fa fa-chevron-left"></i> İlan Özellik Tipleri </a>
				 </div> 
			</div>
		  </div>
	</form>
</section>
<?php } ?>

<?php if ($islem=="duzenle") { ?>
<?php 
	$duzenle=mysql_query("SELECT * FROM emlak_ozelliktip where id = '$id'");
	$ver=mysql_fetch_array($duzenle);
?>
<section class="content">
	<?php 
  		if (isset($_POST["duzenle"])) {
  			$kat = $_POST['kat'];
  			$sira = $_POST['sira'];
 			$ad = trim($_POST['ad']); 				
 			$seo = seo($_POST['ad']); 				

			$formd = mysql_query("UPDATE emlak_ozelliktip SET ad = '$ad', seo = '$seo', sira = '$sira' where id = '$id'");
			$forms = mysql_query("DELETE FROM emlak_ozelliktipliste WHERE ozellikid = '$id'");
			foreach ($kat as $k) {

  				$is=mysql_query("SELECT * FROM emlak_kategori where kat_id = $k");
  				$i=mysql_fetch_array($is);

				$ekle = mysql_query("INSERT INTO emlak_ozelliktipliste (kat, ozellikid, ilansekli) VALUES ('$k','$id','$i[ilansekli]')");				
			}					

			if ($forms) {
				onay("Başarılı bir şekilde güncellendi."); 
				go("index.php?do=islem&emlak=emlak_ozelliktip&hareket=onay", 0);
			} else {
				hata();
			}
			
  		}
  	?> 
	<form method="post" action="" enctype="multipart/form-data">	
		<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title"><i class="fa fa-check"></i> İlan Özellik Tipi Ekleme </h3>
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
			<div class="box-body" style="">
				<div class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-2 control-label">Başlık:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="ad" value="<?=$ver[ad];?>">
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Gösterilecek Kategoriler:</label>
					  <div class="col-sm-10">
		                	<select name="kat[]" style="min-height: 500px;" multiple class="form-control">
	                		<?php
	                			$qkat=mysql_query("SELECT * FROM emlak_kategori WHERE kat_ustid = 0");
	                			while($kategori=mysql_fetch_assoc($qkat)) {										
	                		?>
		                    <optgroup label="<?=$kategori["kat_adi"];?>">
								<option 
								<?php   
									$formkatver = mysql_query("select * from emlak_ozelliktipliste where ozellikid = '$id'");
			                		while ($efk=mysql_fetch_array($formkatver)) {
			                			if ($efk[kat] == $kategori["kat_id"]) {
			                				echo "selected ";
			                			}
			                		}
								?>
								value="<?=$kategori["kat_id"];?>"> <?=$kategori["kat_adi"];?> </option>									
								<?php 
									$katid = $kategori["kat_id"];
									$qust = mysql_query("SELECT * FROM emlak_kategori where kat_ustid = '$katid'");

									while($ustkat=mysql_fetch_array($qust)) {

								?>
								<option 
								<?php   
									$formkatver = mysql_query("select * from emlak_ozelliktipliste where ozellikid = '$id'");									
			                		while ($efk=mysql_fetch_array($formkatver)) {
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
						<input type="text" class="form-control" name="sira" value="<?=$ver[sira];?>">
					  </div>
					</div> 
				</div>
			</div>
			<div class="box"> 
				<div class="box-footer">
					<button type="submit" name="duzenle" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Kaydet </button>
				 	<a href="index.php?do=islem&emlak=emlak_ozelliktip" class="btn btn-default btn-lg"> <i class="fa fa-chevron-left"></i> İlan Özellik Tipleri </a>
				 </div> 
			</div>
		  </div>
	</form>
</section>

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
