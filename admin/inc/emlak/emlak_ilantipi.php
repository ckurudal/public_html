<?php 

	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
	
	uyeYasak(yetki());
	

	$islem = $_GET["islem"];
	$id = $_GET["id"];
	$db = "emlak_ilantipi";
	$hareket = $_GET["hareket"];

 ?>
<!-- Content Header (Page header) -->
<section class="content-header">

  	<i class="fa fa-edit fa-2x pull-left"></i>
	
	İlan Tipi Yönetimi  

	<p> <small> İlan Seçenekleri </small> </p>

</section>
<?php if ($islem == "") { ?>
<form method="post" action="" enctype="multipart/form-data">
	<section class="content">
		<?php 
			if (isset($_POST["ekle"])) {
				$ad=trim($_POST["ad"]);
				$seo=seo($_POST["ad"]);
				$durum=$_POST["durum"];
				$baslikrenk=$_POST["baslikrenk"];
				$yazirenk=$_POST["yazirenk"];
				$anasayfa=$_POST["anasayfa"];
				$alimit=$_POST["alimit"];
				if (empty($ad)) {					
					hata("Başlık boş olamaz. Lütfen bir başlık giriniz.");
				} else {

					$ekle=mysql_query("INSERT INTO $db (ad, seo, baslikrenk, yazirenk, durum, anasayfa, alimit) VALUES ('$ad','$seo','$baslikrenk','$yazirenk','$durum','$anasayfa','$alimit')");

					if ($ekle) {
						go("index.php?do=islem&emlak=emlak_ilantipi&hareket=onay",0);
					}					
				}
			}

			if (isset($_POST["duzenle"])) {
				$ad=trim($_POST["ad"]);
				$seo=seo($_POST["ad"]);
				$durum=$_POST["durum"];
				$baslikrenk=$_POST["baslikrenk"];
				$yazirenk=$_POST["yazirenk"];
				$anasayfa=$_POST["anasayfa"];
				$alimit=$_POST["alimit"];

				$duzenle = mysql_query("UPDATE $db SET ad = '$ad', seo = '$seo', baslikrenk= '$baslikrenk', yazirenk = '$yazirenk', durum = '$durum', anasayfa = '$anasayfa', alimit = '$alimit' where id = '$id'");

				if ($duzenle) {
					go("index.php?do=islem&emlak=emlak_ilantipi&hareket=onay",0); 
				}
			}
		?>
		<?php 
			
			$sil=$_GET["sil"];

			if ($_GET["sil"]) {
				$silid=mysql_query("DELETE FROM $db where id = '$sil'");
				$silkatid=mysql_query("DELETE FROM emlak_ilantipi_katliste where ilantipid = '$sil'");
				if ($silid) {
					go("index.php?do=islem&emlak=emlak_ilantipi&hareket=onay",0); 
				}
			}
			 // durum guncelle 

			$durum = $_GET["durum"];

	        if ($durum) {
	            $ver = mysql_fetch_array(mysql_query("SELECT * FROM $db WHERE id = '$durum'"));
	            $kdurum = $ver["durum"];
	            if ($ver["durum"] == 1) {
	                    mysql_query("UPDATE $db SET durum = '0' WHERE id = '$durum'");
	                    onay();
	                } else {
	                    mysql_query("UPDATE $db SET durum = '1' WHERE id = '$durum'");
	                    onay();
	            }
	        }
	    ?>
	    <?php
			$ok=$_GET["ok"];
		?>
		<?php if ($ok=="") { ?>
			<form method="post" action="" enctype="multipart/form-data">		
			<?php
				if ($hareket == "onay") {
					onay();
				}
			?>
			 	<div class="box">
					<div class="box-header with-border">
					  <h3 class="box-title"><i class="fa fa-check"></i> İlan Tipi Ekleme </h3>
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
								<input type="text" class="form-control" value="" name="ad">
							  </div>
							</div> 
							<div class="form-group">
							  <label class="col-sm-2 control-label">Başlık Rengi:</label>
							  <div class="col-sm-2"> 
								<div class="input-group my-colorpicker2 colorpicker-element">
				                  <input type="text" name="baslikrenk" class="form-control" placeholder="Renk Seçiniz">

				                  <div class="input-group-addon">
				                    <i style="background-color: rgb(139, 38, 38);"></i>
				                  </div>
				                </div>
							  </div>
							</div> 
							<div class="form-group">
							  <label class="col-sm-2 control-label">Yazı Rengi:</label>
							  <div class="col-sm-2"> 
								<div class="input-group my-colorpicker2 colorpicker-element">
				                  <input type="text" name="yazirenk" class="form-control" placeholder="Renk Seçiniz">

				                  <div class="input-group-addon">
				                    <i style="background-color: rgb(139, 38, 38);"></i>
				                  </div>
				                </div>
							  </div>
							</div> 
							<!--
							<div class="form-group">
							  <label class="col-sm-2 control-label">Anasayfada Göster:</label>
							  <div class="col-md-10">
									<label for="anasayfa">
									  <input type="radio" name="anasayfa" value="0" class="minimal">
									  Göster
									</label>
									<label for="anasayfa">
									  <input type="radio" name="anasayfa" value="1" class="minimal">
									  Gizle
									</label>
								</div>
							</div> 
							<div class="form-group">
							  <label class="col-sm-2 control-label">Anasayfa Limiti:</label>
							  <div class="col-md-2">									
									  <input type="text" name="alimit" class="form-control">
								</div>
							</div> 
							-->
							<div class="form-group">
							  <label class="col-sm-2 control-label">Durum:</label>
							  <div class="col-sm-10"> 
								<label for="odasayisi">
									  <input type="radio" name="durum" checked value="0" class="minimal">
									  Aktif
									</label>
									<label for="odasayisi">
									  <input type="radio" name="durum" value="1" class="minimal">
									  Pasif
									</label>
							  </div>
							</div>  
						</div>
					</div>
					<div class="box"> 
						<div class="box-footer">
							<button type="submit" name="ekle" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Yeni Ekle </button>							
						 </div> 
					</div>
			 	</div>
			</form>
			<?php } ?>
			<?php if ($ok=="duzenle") { ?>
			<form method="post" action="" enctype="multipart/form-data">	
			 	<div class="box">
					<div class="box-header with-border">
					  <h3 class="box-title"><i class="fa fa-check"></i> İlan Tipi Ekleme </h3>
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
							  <?php 
							  	$duzenle=mysql_query("SELECT * FROM $db where id = '$id'");
							  	$d=mysql_fetch_array($duzenle);
							  ?>
								<input type="text" class="form-control" value="<?=$d["ad"];?>" name="ad">
							  </div>
							</div> 
							<div class="form-group">
							  <label class="col-sm-2 control-label">Başlık Rengi:</label>
							  <div class="col-sm-2">
								<div class="input-group my-colorpicker2 colorpicker-element">
				                  <input type="text" name="baslikrenk" class="form-control" value="<?=$d["baslikrenk"];?>" placeholder="Renk Seçiniz">
				                  <div class="input-group-addon">
				                    <i style="background-color: rgb(139, 38, 38);"></i>
				                  </div>
				                </div>
							  </div>
							</div> 
							<div class="form-group">
							  <label class="col-sm-2 control-label">Yazı Rengi:</label>
							  <div class="col-sm-2"> 
								<div class="input-group my-colorpicker2 colorpicker-element">
				                  <input type="text" name="yazirenk" class="form-control" value="<?=$d["yazirenk"];?>" placeholder="Renk Seçiniz">

				                  <div class="input-group-addon">
				                    <i style="background-color: rgb(139, 38, 38);"></i>
				                  </div>
				                </div>
							  </div>
							</div> 
							<!--
							<div class="form-group">
							  <label class="col-sm-2 control-label">Anasayfada Göster:</label>
							  <div class="col-md-10">
									<label for="anasayfa">
									  <input type="radio" <?php if ($d["anasayfa"] == 0) { ?> checked <?php } ?> name="anasayfa" value="0" class="minimal">
									  Göster
									</label>
									<label for="anasayfa">
									  <input type="radio" <?php if ($d["anasayfa"] == 1) { ?> checked <?php } ?> name="anasayfa" value="1" class="minimal">
									  Gizle
									</label>
								</div>
							</div>
							<div class="form-group">
							  <label class="col-sm-2 control-label">Anasayfa Limiti:</label>
							  <div class="col-md-2">									
									  <input type="text" name="alimit" value="<?=$d["alimit"];?>" class="form-control">
								</div>
							</div> 
							-->
							<div class="form-group">
							  <label class="col-sm-2 control-label">Durum:</label>
							  <div class="col-md-10">
									<label for="ozellikler">
									  <input type="radio" <?php if ($d["durum"] == 0) { ?> checked <?php } ?> name="durum" value="0" class="minimal">
									  Aktif
									</label>
									<label for="ozellikler">
									  <input type="radio" <?php if ($d["durum"] == 1) { ?> checked <?php } ?> name="durum" value="1" class="minimal">
									  Pasif
									</label>
								</div>
							</div>  
						</div>
					</div>
					<div class="box"> 
						<div class="box-footer">
							<button type="submit" name="duzenle" class="btn btn-success btn-lg pull-right"> <i class="fa fa-save"></i> Kaydet </button>							
						 </div> 
					</div>
			 	</div>
			</form>
			<?php } ?>
			
			
		 <div class="bo x"> 
			<div class="box-bo dy table-responsive"> 
				<table id="example1" class="table table-bordered dataTable" colspan="5" role="grid" aria-describedby="example1_info">
                    <thead>
                    <tr>
                        <td class="text-center" style="width:1%;"> ID </td>
                        <td style="width:20%;"> İlan Tipi </td>
                        <td style="width:20%;"> Başlık Rengi </td>
                        <!-- <td style="width:20%;"> Anasayfa </td> -->
                        <td style="width:10%;"> Durum </td>
                        <td style="width:15%;" class="text-center"> İşlemler </td>
                    </tr>
                    </thead>
                    <tbody> 
                    	<?php 
                    		$tip=mysql_query("SELECT * FROM $db order by id desc");
                    		while ($t=mysql_fetch_array($tip)) {
                    	?>
                    	<tr>
                    		<th class="text-center"> 
                    			<h5> <strong> <?=$t[id];?> </strong> </h5>
                    		</th>
                    		<th class=""> 
                    			<h5> <strong> <?=$t[ad];?> </strong> </h5>
                    		</th>
                    		<th class=""> 
                    			<span class="btn btn-xs text-capitalize" style="background: <?=$t["baslikrenk"];?>; color: <?=$t["yazirenk"];?>; "><?=$t["ad"];?></span>
                    		 </th>
                    		 <!--
                    		<th class=""> 
	                			<?php 
			                    	if ($t["anasayfa"] == 0 ) {
		                                echo '
											<span class="btn btn-success btn-xs"> Gösteriliyor </span>
										';
		                            } else {
		                                echo '
											<span class="btn btn-warning btn-xs"> Gizli </span>
										';
		                            }
		                    	?>
                    		</th>
                    		-->
                    		<th class=""> 
	                			<?php 
			                    	if ($t["durum"] == 0 ) {
		                                echo '
											<span class="btn bg-warning btn-xs btn-block"> Aktif </span>
										';
		                            } else {
		                                echo '
											<span class="btn btn-danger btn-xs btn-block"> Pasif </span>
										';
		                            }
		                    	?>
                    		</th>
                    		<th class="text-center">
	                			<a href="index.php?do=islem&emlak=emlak_ilantipi&ok=duzenle&id=<?=$t[id];?>" title="Düzenle" class="btn btn-primary btn-xs btn-block">
									<i class="fa fa-pencil"></i> Düzenle
								</a>
								<?php if ($t[durum]==0) { ?>
								<a href="index.php?do=islem&emlak=emlak_ilantipi&durum=<?=$t["id"];?>" title="Pasif Et" class="btn btn-warning btn-xs btn-block">
									<i class="fa fa-close"></i> Pasif Yap
								</a>
								<?php } else { ?>
								<a href="index.php?do=islem&emlak=emlak_ilantipi&durum=<?=$t["id"];?>" title="Aktif Et" class="btn btn-success btn-xs btn-block">
									<i class="fa fa-check"></i> Aktif Et
								</a>
								<?php } ?>
                    			<a  data-toggle="modal" data-target="#<?=$t["id"]?>" href="#" title="Sil" class="btn btn-danger btn-xs btn-block">
									<i class="fa fa-trash"></i> Sil
								</a>
								<div class="modal modal-default text-center fade" id="<?=$t["id"]?>" style="display: none;">
								  <div class="modal-dialog">
									<div class="modal-content">
									  <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										  <span aria-hidden="true">×</span></button>
										<h4 class="modal-title">Silme Onayı Ver</h4>
									  </div>
									  <div class="modal-body">
										<h4><strong> "<?=$t["ad"]?>" </strong> isimli ilan tipi silinecektir. İşlemi onaylıyor musunuz ?</h4>
									  </div>
									  <div class="modal-footer">
										<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
										<a href="index.php?do=islem&emlak=emlak_ilantipi&sil=<?=$t["id"];?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
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

		 <?php if ($islem=="duzenle") { ?>
		 	<?php  

		 		if (isset($_POST["guncelle"])) {
		 			$baslik=trim($_POST[baslik]);
		 			$odasayisi=$_POST[odasayisi];
		 			$durum=$_POST[durum];

		 			$g=mysql_query("UPDATE $db SET baslik='$baslik', odasayisi='$odasayisi', durum='$durum' where id = '$id'");

		 			if ($g) {
		 				onay();
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
