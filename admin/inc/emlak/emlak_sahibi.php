<?php 

	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
	
	uyeYasak(yetki());
	
	$islem = $_GET["islem"];
	$id = $_GET["id"]; 
	$hareket = $_GET["hareket"];

	// POST EDILENLER
	$baslik=trim($_POST["baslik"]);
	$seo=seo($baslik);
	$durum=seo($_POST["durum"]);
	$sira=seo($_POST["sira"]);

?>   
<form method="post" action="" enctype="multipart/form-data">
	<section class="content"> 

	<?php if ($hareket == "onay") {

		// ONAY VE DURUM PDO ALANLARI
	
		onay();

		if ($_GET["ok"] == 1) {
			$kaydet=$vt->prepare("UPDATE emlak_sahibi SET durum = '1' where id = '$id'")->execute();
		}

		if ($_GET["ok"] == 0) {
			$kaydet=$vt->prepare("UPDATE emlak_sahibi SET durum = '0' where id = '$id'")->execute();
		}

		if ($_GET["sil"]) {
			$sil=$vt->prepare("DELETE FROM emlak_sahibi WHERE id = '$id'")->execute();
		}

	} ?>

	<?php if ($islem == "") {



			if (isset($_POST["ekle"])) {
				
				if (empty($baslik)) {					
					hata("Başlık boş olamaz. Lütfen bir başlık giriniz.");
				} else {

					$kontrol = $vt->prepare("SELECT * FROM emlak_sahibi WHERE seo = ?");
					$kontrol->execute(array($seo));
   					$say = $kontrol->fetch(PDO::FETCH_ASSOC);

					if ($say>0) {
						hata("Aynı isimde başlık daha önce girilmiş, lütfen farklı bir başlık giriniz.");
					} else {
						$ekle = $vt->prepare("INSERT INTO emlak_sahibi (baslik, seo, durum) VALUES (?,?,?)")->execute(array($baslik,$seo,$durum));
						if ($ekle==true) {
							go("index.php?do=islem&emlak=emlak_sahibi&hareket=onay",0);
						}
					}		
				}
			}

		?>
	 	<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title"><i class="fa fa-check"></i> Emlak Sahibi Ekleme </h3>
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
			<div class="box-body pad">
				<div class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-2 control-label">Başlık:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" value="" name="baslik">
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Sıra:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" value="" name="sira">
					  </div>
					</div>   
					<div class="form-group">
					  <label class="col-sm-2 control-label">Durum:</label>
					  <div class="col-sm-10"> 
						<label for="odasayisi">
							  <input type="radio" name="durum" checked value="0" class="minimal">
							  Aktif Et
							</label>
							<label for="odasayisi">
							  <input type="radio" name="durum" value="1" class="minimal">
							  Pasif Yap
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
	<?php } ?>
	<?php if ($islem=="ekle" or $islem=="duzenle") { ?>

		<?php if ($islem=="duzenle") {

			$liste=$vt->query("SELECT * FROM emlak_sahibi WHERE id = {$id}")->fetch(); 

			if (isset($_POST["kaydet"])) {

				$kaydet=$vt->prepare("UPDATE emlak_sahibi SET baslik = ?, seo = ?, durum = ?, sira = ? where id = '$id'")->execute(array($baslik,$seo,$durum,$sira));

				if ($kaydet==true) {

					go("index.php?do=islem&emlak=emlak_sahibi&hareket=onay",0);

				}
			}
		
		} ?>

	 	<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title"><i class="fa fa-check"></i> Emlak Sahibi Ekleme </h3>
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
			<div class="box-body pad">
				<div class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-2 control-label">Başlık:</label>
					  <div class="col-sm-10"> 
					  	<?php if ($islem=="ekle") { ?>
						<input type="text" class="form-control" value="" name="baslik">
						<?php } ?>
					  	<?php if ($islem=="duzenle") { ?>
						<input type="text" class="form-control" value="<?=$liste["baslik"];?>" name="baslik">
						<?php } ?>
					  </div>
					</div>   
					<div class="form-group">
					  <label class="col-sm-2 control-label">Sıra:</label>
					  <div class="col-sm-10"> 
					  	<?php if ($islem=="ekle") { ?>
						<input type="text" class="form-control" value="" name="sira">
						<?php } ?>
					  	<?php if ($islem=="duzenle") { ?>
						<input type="text" class="form-control" value="<?=$liste["sira"];?>" name="sira">
						<?php } ?>
					  </div>
					</div>   
					<div class="form-group">
					  <label class="col-sm-2 control-label">Durum:</label>
					  <div class="col-sm-10"> 
					  	<?php if ($islem=="ekle") { ?>
						<label for="durum">
							<input type="radio" name="durum" checked value="0" class="minimal"> Aktif Et
						</label>
						<label for="durum">
							<input type="radio" name="durum" value="1" class="minimal"> Pasif Yap
						</label>
						<?php } ?>
					  	<?php if ($islem=="duzenle") { ?>
				  		<label for="durum">
							<input type="radio" name="durum" <?php if ($liste["durum"]==0) { ?>checked value="0"<?php } else { ?>value="0"<?php } ?> class="minimal"> Aktif Et
						</label>
						<label for="durum">
							<input type="radio" name="durum" value="1" <?php if ($liste["durum"]==1) { ?>checked value="1"<?php } else { ?>value="1"<?php } ?> class="minimal"> Pasif Yap
						</label>
					  	<?php } ?>
					  </div>
					</div>  
				</div>
			</div>
			<div class="box"> 
				<div class="box-footer">
					<button type="submit" name="kaydet" class="btn btn-success btn-lg pull-right"> <i class="fa fa-save"></i> Kaydet </button>
				 </div> 
			</div>
	 	</div>

	<?php } ?>
	</form>
 	<div class="table-responsive"> 
		<table id="example1" class="table table-bordered dataTable" colspan="5" role="grid" aria-describedby="example1_info">
			<thead>
				 <tr>
                    <td class="text-center" style="width:1%;"> ID </td>
                    <td style="width:20%;"> Başlık </td>
                    <td style="width:2%;"> Durum </td>
                    <td style="width:2%;"> Sıra </td>
                    <td style="width:5%;" class="text-center"> İşlemler </td>
                </tr>
			</thead>
			<tbody>
				<?php
					$listesahip=$vt->query("SELECT * FROM emlak_sahibi ORDER BY sira ASC");
					foreach ($listesahip as $l) {
					
				?>
				<tr>
					<th class="text-center">
						<h5> <strong> <?=$l["id"];?> </strong> </h5>
					</th>
					<th>
						<h5> <strong> <?=$l["baslik"];?> </strong> </h5>
					</th>
					<th class="text-center">
						<?php if ($l["durum"]==0) { ?>
						<span class="btn bg-success btn-xs btn-block"> Aktif </span>
						<?php } else { ?>
						<span class="btn bg-danger btn-xs btn-block"> Pasif </span>
						<?php } ?>
					</th>
					<th class="text-center">
						<?=$l["sira"];?> 
					</th>
					<th class="text-center">

						<a href="index.php?do=islem&emlak=emlak_sahibi&islem=duzenle&id=<?=$l['id'];?>" title="Düzenle" class="btn btn-primary btn-xs btn-block">
							<i class="fa fa-pencil"></i> Düzenle
						</a>

						<?php if ($l["durum"]==0) { ?>
						<a href="index.php?do=islem&emlak=emlak_sahibi&hareket=onay&ok=1&id=<?=$l['id'];?>" title="Pasif Et" class="btn btn-warning btn-xs btn-block">
							<i class="fa fa-close"></i> Pasif Yap
						</a>
						<?php } else { ?>
						<a href="index.php?do=islem&emlak=emlak_sahibi&hareket=onay&ok=0&id=<?=$l['id'];?>" title="Aktif Et" class="btn btn-success btn-xs btn-block">
							<i class="fa fa-check"></i> Aktif Et
						</a>
						<?php } ?>


            			<a  data-toggle="modal" data-target="#<?=$l["id"]?>" href="#" title="Sil" class="btn btn-danger btn-xs btn-block">
							<i class="fa fa-trash"></i> Sil
						</a>
						<div class="modal modal-default text-center fade" id="<?=$l["id"]?>" style="display: none;">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">×</span></button>
								<h4 class="modal-title">Silme Onayı Ver</h4>
							  </div>
							  <div class="modal-body">
								<h4><strong> "<?=$l["baslik"]?>" </strong> isimli ilan tipi silinecektir. İşlemi onaylıyor musunuz ?</h4>
							  </div>
							  <div class="modal-footer">
								<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
								<a href="index.php?do=islem&emlak=emlak_sahibi&hareket=onay&sil=1&id=<?=$l['id'];?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
							  </div>
							</div> 
						  </div> 
						</div>  

					</th>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</section>
</div>


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
