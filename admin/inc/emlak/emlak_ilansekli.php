<?php 

	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
	
	uyeYasak(yetki());
	

	$islem = $_GET["islem"];
	$id = $_GET["id"];
	$hareket = $_GET["hareket"];
	$db = "emlak_ilansekli";

 ?>
<!-- Content Header (Page header) -->
<section class="content-header">

  	<i class="fa fa-edit fa-2x pull-left"></i>
	
	İlan Şekli Yönetimi   

	<p> <small> İlan Seçenekleri </small> </p>
</section>
<?php if ($islem == "") { ?>
<form method="post" action="" enctype="multipart/form-data">	
	<section class="content">
		<?php
			if ($hareket == "onay") {
				onay();
			}
		?>	
		<?php
			$sil=$_GET["sil"];
			if ($sil) {
				$silid=mysql_query("DELETE FROM $db where id = '$sil'");
				if ($silid) {
					go("index.php?do=islem&emlak=emlak_ilansekli&hareket=onay",0);			
				}
			}

			$durum=$_GET["durum"];

			if ($durum) {
	            $ver = mysql_fetch_array(mysql_query("SELECT * FROM $db WHERE id = '$durum'"));
	            $kdurum = $ver["durum"];
	            if ($ver["durum"] == 1) {
	                    mysql_query("UPDATE $db SET durum = '0' WHERE id = '$durum'");
	                    go("index.php?do=islem&emlak=emlak_ilansekli&hareket=onay",0);
	                } else {
	                    mysql_query("UPDATE $db SET durum  = '1' WHERE id = '$durum'");
	                    go("index.php?do=islem&emlak=emlak_ilansekli&hareket=onay",0);
	            }
	        }
		?>
		 <div class="b ox"> 
			<div class="box-bod y pad table-responsive" style=""> 
	            <a href="index.php?do=islem&emlak=emlak_ilansekli&islem=ekle" class="btn btn-lg bt-xs btn-success">
	                <i class="fa fa-plus"></i> Yeni Ekle
	            </a>
				<table id="example1" class="table table-bordered dataTable" colspan="5" role="grid" aria-describedby="example1_info">
                    <thead>
                    <tr>
                        <td class="text-center" style="width:1%;"> ID </td>
                        <td style="width:30%;"> İlan Şekli </td>
                        <td style="width:10%;"> Kategori Tipi </td>
                        <td style="width:10%;"> Durum </td>
                        <td style="width:10%;" class="text-center"> İşlemler </td>
                    </tr>
                    </thead>
                    <tbody>
                    	<?php 
                    		$ilansekli=mysql_query("SELECT * FROM $db ORDER BY id DESC");
                    		while ($row=mysql_fetch_array($ilansekli)) { 
                    	?>
                    	<tr>
                    		<th class="text-center"> 
                    			<h5> <strong> <?=$row[id];?> </strong> </h5>
                    		</th>
                    		<th class=""> 
                    			<h5> <strong> <?=$row[baslik];?> </strong> </h5>
                    		</th>
                    		<th class=""> 
                    		<?php if ($row["kat_tipi"] == "standart" ) { ?>
                                <span class="btn bg-success btn-xs btn-block"> Standart Kategori </span>
                            <?php } else { ?>
                            	<span class="btn bg-primary btn-xs btn-block"> Proje Kategorisi </span>
                            <?php } ?>
                    		 </th>
                    		<th class=""> 
                    		<?php if ($row["durum"] == 0 ) { ?>
                                <span class="btn bg-success btn-xs btn-block"> Aktif </span>
                            <?php } else { ?>
                            	<span class="btn bg-danger btn-xs btn-block"> Pasif </span>
                            <?php } ?>
                    		 </th>
                    		<th class="text-center"> 
                    			<a href="index.php?do=islem&emlak=emlak_ilansekli&islem=duzenle&id=<?=$row["id"];?>" title="Düzenle" class="btn btn-primary btn-xs btn-block">
									<i class="fa fa-pencil"></i> Düzenle
								</a>
								<?php if ($row[durum]==0) { ?>
								<a href="index.php?do=islem&emlak=emlak_ilansekli&durum=<?=$row["id"];?>" title="Pasif Et" class="btn btn-warning btn-xs btn-block">
									<i class="fa fa-close"></i> Pasif Yap
								</a>
								<?php } else { ?>
								<a href="index.php?do=islem&emlak=emlak_ilansekli&durum=<?=$row["id"];?>" title="Aktif Et" class="btn btn-success btn-xs btn-block">
									<i class="fa fa-check"></i> Aktif Et
								</a>
								<?php } ?>
                    			<a  data-toggle="modal" data-target="#<?=$row["id"]?>" href="#" title="Sil" class="btn btn-danger btn-xs btn-block">
									<i class="fa fa-trash"></i> Sil
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
										<h4><strong> "<?=$row["baslik"]?>" </strong> isimli ilan şekli silinecektir. İşlemi onaylıyor musunuz ?</h4>
									  </div>
									  <div class="modal-footer">
										<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
										<a href="index.php?do=islem&emlak=emlak_ilansekli&sil=<?=$row["id"];?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
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
	</section>
</form>
<?php }?>
<?php if ($islem=="ekle" or $islem=="duzenle") { ?>
	<section class="content">
		 <?php if ($islem=="ekle") { ?>
		 	<?php 
		 		if (isset($_POST["ekle"])) {

		 			$baslik=trim($_POST["baslik"]);
		 			$seo=seo($_POST["baslik"]);
		 			$odasayisi=$_POST["odasayisi"];
		 			$gorunum=$_POST["gorunum"];
		 			$kat_tipi=$_POST["kat_tipi"];

		 			if (empty($baslik)) {

		 				hata("Hata! Başlık alanı boş olamaz.");

		 			} else {

		 				$ekle=mysql_query("INSERT INTO $db (baslik,seo,odasayisi,gorunum,kat_tipi) VALUES ('$baslik','$seo','$odasayisi','$gorunum','$kat_tipi')");

			 			if ($ekle) {
			 				go("index.php?do=islem&emlak=emlak_ilansekli&hareket=onay",0);
			 			} else {
			 				hata();
			 				echo mysql_error();
			 			}		 			
		 				
		 			}
		 		}
		 	?>
			<form method="post" action="" enctype="multipart/form-data">	
			 	<div class="box">
					<div class="box-header with-border">
					  <h3 class="box-title"><i class="fa fa-check"></i> İlan Şekli Ekleme </h3>
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
								<input type="text" class="form-control" value="" name="baslik">
							  </div>
							</div> 
							<div class="form-group">
							  <label class="col-sm-2 control-label">Emlak Tipi:</label>
							  <div class="col-sm-10"> 
									<label for="kat_tipi">
									  <input type="radio" name="kat_tipi" checked value="standart" class="minimal">
									  Standart
									</label>
									<label for="kat_tipi">
									  <input type="radio" name="kat_tipi" value="proje" class="minimal">
									  Proje Kategorisi
									</label>
							  </div>
							</div> 
							<!--
							<div class="form-group">
							  <label class="col-sm-2 control-label">Oda Sayısı:</label>
							  <div class="col-sm-10"> 
									<label for="odasayisi">
									  <input type="radio" name="odasayisi" checked value="0" class="minimal">
									  Göster
									</label>
									<label for="odasayisi">
									  <input type="radio" name="odasayisi" value="1" class="minimal">
									  Gizle
									</label>
							  </div>
							</div> 
							-->
							<!--
							<div class="form-group">
								<label class="col-sm-2 control-label">Kategori Görünüm:</label>
								<div class="col-md-10">
									<label for="gorunum">
									  <input type="radio" name="gorunum" value="4" class="minimal">
									  <span class="btn btn-default"><i class="fa fa-table"></i>  4 'lü</span>
									</label>
									<label for="gorunum">
									  <input type="radio" name="gorunum" value="3" class="minimal">
									  <span class="btn btn-default"><i class="fa fa-th"></i> 3 'lü</span>
									</label>
									<label for="gorunum">
									  <input type="radio" name="gorunum" value="2" class="minimal">
									  <span class="btn btn-default"><i class="fa fa-th-large"></i> 2 'lü</span>
									</label>
									<label for="gorunum">
									  <input type="radio" name="gorunum" value="1" class="minimal">
									  <span class="btn btn-default"><i class="fa fa-list"></i> Liste</span>
									</label>
								</div>
							  </div>
							  -->
							<!--
							<div class="form-group">
								<label class="col-sm-2 control-label">Durum:</label>
								<div class="col-md-10">
									<label for="ozellikler">
									  <input type="radio" name="durum" checked value="0" class="minimal">
									  Aktif
									</label>
									<label for="ozellikler">
									  <input type="radio" name="durum" value="1" class="minimal">
									  Pasif
									</label>
								</div>
							</div> 
							-->
						</div>
					</div>
					<div class="box"> 
						<div class="box-footer">
							<button type="submit" name="ekle" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Kaydet </button>
							<a href="index.php?do=islem&emlak=emlak_ilansekli" class="btn btn-default btn-lg"> <i class="fa fa-chevron-left"></i> İlan Şekilleri </a>
						 </div> 
					</div>
			 	</div>
			</form>	
		 <?php } ?>

		 <?php if ($islem=="duzenle") { ?>
		 	<?php  

		 		if (isset($_POST["guncelle"])) {
		 			$baslik=trim($_POST["baslik"]);
		 			$seo=seo($_POST["baslik"]);
		 			$odasayisi=$_POST["odasayisi"];
		 			$durum=$_POST["durum"];
		 			$gorunum=$_POST["gorunum"];
		 			$kat_tipi=$_POST["kat_tipi"];

		 			$g=mysql_query("UPDATE $db SET baslik='$baslik', seo='$seo', odasayisi='$odasayisi', durum='$durum', gorunum='$gorunum', kat_tipi='$kat_tipi' where id = '$id'");

		 			if ($g) {
		 				go("index.php?do=islem&emlak=emlak_ilansekli&hareket=onay",0);
		 			}
		 		}

		 		$duzenle=mysql_query("SELECT *  from emlak_ilansekli where id = '$id'");
		 		$ver=mysql_fetch_array($duzenle);

		 	?>
		 	<form method="post" action="" enctype="multipart/form-data">	
			 	<div class="box">
					<div class="box-header with-border">
					  <h3 class="box-title"><i class="fa fa-check"></i> İlan Şekli Ekleme </h3>
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
								<input type="text" class="form-control" value="<?=$ver[baslik];?>" name="baslik">
							  </div>
							</div> 
							<div class="form-group">
							  <label class="col-sm-2 control-label">Emlak Tipi:</label>
							  <div class="col-sm-10"> 
									<label for="kat_tipi">
									  <input type="radio" name="kat_tipi" <?php if($ver["kat_tipi"]=="standart"): ?>checked<?php endif; ?> value="standart" class="minimal">
									  Standart
									</label>
									<label for="kat_tipi">
									  <input type="radio" name="kat_tipi" <?php if($ver["kat_tipi"]=="proje"): ?>checked<?php endif; ?> value="proje" class="minimal">
									  Proje Kategorisi
									</label>
							  </div>
							</div> 
							<!--
							<div class="form-group">
							  <label class="col-sm-2 control-label">Oda Sayısı:</label>
							  <div class="col-md-10">
									<?php if ($ver[odasayisi]==0) { ?>
									<label for="ozellikler">
									  <input type="radio" name="odasayisi" checked value="0" class="minimal">
									  Göster
									</label>
									<label for="ozellikler">
									  <input type="radio" name="odasayisi" value="1" class="minimal">
									  Gizle
									</label>
									<?php } else { ?>
									<label for="ozellikler">
									<input type="radio" name="odasayisi"  value="0" class="minimal">
									  Göster
									</label>
									<label for="ozellikler">
									  <input type="radio" name="odasayisi" checked value="1" class="minimal">
									  Gizle
									</label>
									<?php } ?>
								</div>
							</div> 
							-->
							<!--
							<div class="form-group">
								<label class="col-sm-2 control-label">Kategori Görünüm:</label>
								<div class="col-md-10">
									<label for="gorunum">
									  <input type="radio" name="gorunum" <?php if ($ver["gorunum"] == 4) { ?> checked <?php } ?> value="4" class="minimal">
									  <span class="btn btn-default"><i class="fa fa-table"></i>  4 'lü</span>
									</label>
									<label for="gorunum">
									  <input type="radio" name="gorunum" <?php if ($ver["gorunum"] == 3) { ?> checked <?php } ?> value="3" class="minimal">
									  <span class="btn btn-default"><i class="fa fa-th"></i> 3 'lü</span>
									</label>
									<label for="gorunum">
									  <input type="radio" name="gorunum" <?php if ($ver["gorunum"] == 2) { ?> checked <?php } ?> value="2" class="minimal">
									  <span class="btn btn-default"><i class="fa fa-th-large"></i> 2 'lü</span>
									</label>
									<label for="gorunum">
									  <input type="radio" name="gorunum" <?php if ($ver["gorunum"] == 1) { ?> checked <?php } ?> value="1" class="minimal">
									  <span class="btn btn-default"><i class="fa fa-list"></i> Liste</span>
									</label>
								</div>
							  </div>
							  -->
							<!--
							<div class="form-group">
								<label class="col-sm-2 control-label">Durum:</label>
								<div class="col-md-10">
									<?php if ($ver[durum]==0) { ?>
									<label for="ozellikler">
									  <input type="radio" name="durum" checked value="0" class="minimal">
									  Aktif
									</label>
									<label for="ozellikler">
									  <input type="radio" name="durum" value="1" class="minimal">
									  Pasif
									</label>
									<?php } else { ?>
									<label for="ozellikler">
									<input type="radio" name="durum"  value="0" class="minimal">
									  Aktif
									</label>
									<label for="ozellikler">
									  <input type="radio" name="durum" checked value="1" class="minimal">
									  Pasif
									</label>
									<?php } ?>
								</div>
							</div> 
							-->
						</div>
					</div>
					<div class="box"> 
						<div class="box-footer">
							<button type="submit" name="guncelle" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Güncelle </button>
							<a href="index.php?do=islem&emlak=emlak_ilansekli" class="btn btn-default btn-lg"> <i class="fa fa-chevron-left"></i> İlan Şekilleri </a>
						 </div> 
					</div>
			 	</div>
			</form>	
		 <?php } ?>

	</section>
<?php }?>

<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,

    })
  })
</script>
