<?php  
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
	
	uyeYasak(yetki());
	

	$id = $_GET["id"];
	$islem = $_GET["islem"];
	$hareket = $_GET["hareket"];
	$durum = $_GET["durum"];

	$haberlar = $vt->query("SELECT * FROM haber_kategori where id = '$id'");
	$haberkatliste = $vt->query("SELECT * FROM haber_kategori order by id desc");
?>
<section class="cont ent"> 
<?php 
	if (isset($_POST["haberkategoriekle"]) || isset($_POST["haberkategorikaydet"])) {

		$baslik 		= trim($_POST["baslik"]);
		$seo 			= seo($_POST["baslik"]);
		$title 			= trim($_POST["title"]);
		$aciklama 		= trim($_POST["aciklama"]);
		$keyw			= trim($_POST["keyw"]);

		if (isset($_POST["haberkategoriekle"])) {

			$haberkategoriekle = $vt->query("INSERT INTO haber_kategori (baslik, seo, title, aciklama, keyw) values ('$baslik','$seo','$title','$aciklama','$keyw')");	

			if ($haberkategoriekle == true) {
				go("index.php?do=islem&icerik=haberkategori&islem=liste&hareket=onay",0);
			}
		}

		if (isset($_POST["haberkategorikaydet"])) {

			$unvankaydet = $vt->query("UPDATE haber_kategori SET baslik = '$baslik', seo = '$seo', title = '$title', aciklama = '$aciklama', keyw = '$keyw'  where id = '$id'");	

			if ($unvankaydet == true) {
				go("index.php?do=islem&icerik=haberkategori&islem=liste&hareket=onay",0);
			}
		}

	}
?>
</section>
<!-- Content Header (Page header) -->
<section class="content-header">	

	<i class="fa fa-pencil fa-2x pull-left"></i>

	Haber Kategorileri

	<p> <small> Haber Kategori Yönetimi </small> </p>

</section> 
<?php if ($islem == "ekle") { ?>
<form action="" method="post" enctype="multipart/form-data">
	<section class="content"> 
		<div class="box"> 
			<div class="box-header with-border">
				<h3 class="box-title"> <i class="fa fa-edit"></i> Haber Kategori Ekleme </h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body" style="">
				<div class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-2 control-label">Başlık:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="baslik">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Title:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="title">
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Google Açıklama:</label>
					  <div class="col-sm-10"> 
						<textarea class="form-control" id="" name="aciklama" rows="5" cols="80"></textarea>
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Anahtar Kelimeler:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="keyw">
					  </div>
					</div> 
				</div>
			</div>
		</div> 
		<div class="box"> 
			<div class="box-footer">
				<button type="submit" class="btn btn-success btn-lg pull-right" name="haberkategoriekle"> <i class="fa fa-check"></i> Yeni Ekle </button>
			 </div> 
		</div> 
	</section>
</form>
<?php } ?> 
<?php if ($islem == "duzenle") { ?>
<form action="" method="post" enctype="multipart/form-data">
	<?php 
		$sk = $haberlar->fetch();
	?>
	<section class="content"> 
		<div class="box"> 
			<div class="box-header with-border">
				<h3 class="box-title"> <i class="fa fa-edit"></i> Haber Kategori Düzenleme </h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body" style="">
				<div class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-2 control-label">Başlık:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="baslik" value="<?=$sk["baslik"];?>">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Title:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="title" value="<?=$sk["title"];?>">
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Google Açıklama:</label>
					  <div class="col-sm-10"> 
						<textarea class="form-control" id="" name="aciklama" rows="5" cols="80"><?=$sk["aciklama"];?></textarea>
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Anahtar Kelimeler:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="keyw" value="<?=$sk["keyw"];?>">
					  </div>
					</div> 
				</div>
			</div>
		</div> 
		<div class="box"> 
			<div class="box-footer">
				<button type="submit" class="btn btn-primary btn-lg pull-right" name="haberkategorikaydet"> <i class="fa fa-check"></i> Kaydet </button>
			 </div> 
		</div> 
	</section>
</form>
<?php } ?> 
<?php if ($islem == "liste") { ?>
<section class="content">

	<?php 
		if ($hareket == "onay") {
			onay();
		}

		if ($hareket == "sil") {
				
			$sil = $vt->query("DELETE FROM haber_kategori where id = '$id'"); 

			go("index.php?do=islem&icerik=haberkategori&islem=liste&hareket=onay&id=$id",0);

		}

		if ($durum == "0") {
			$d = $vt->query("UPDATE haber_kategori SET durum = '0' where id = '$id'"); 
			go("index.php?do=islem&icerik=haberkategori&islem=liste&hareket=onay&id=$id",0);
		}
		if ($durum == "1") {
			$d = $vt->query("UPDATE haber_kategori SET durum = '1' where id = '$id'"); 
			go("index.php?do=islem&icerik=haberkategori&islem=liste&hareket=onay&id=$id",0);
		}
	?>

	<a href="index.php?do=islem&icerik=haberkategori&islem=ekle" class="btn btn-lg bt-xs btn-success">
        <i class="fa fa-plus"></i> Yeni Ekle
    </a>  
	<div class="bo x">	   	
		<div class="box-bod y table-responsive">
			
			<table id="example1" class="table table-bordered dataTable" colspan="5" role="grid" aria-describedby="example1_info">
			    <thead>
			        <tr>                        
			            <td class="text-center" style="width:0.00000001%;"> ID </td>
			            <td style="width:70%;"> Kategori Adı </td> 
			            <td style="width:0.05%;"> Durum </td> 			            
			            <td class="text-center" style="width:0.000001%;"> İşlemler </td>
			        </tr>
		   		</thead>
		    	<tbody>
			    	<?php 
			    		while($skliste = $haberkatliste->fetch()) {
			    	?>
		    		<tr>
		    			<th class="text-center"><?=$skliste["id"];?></th>
		    			<th><?=$skliste["baslik"];?></th> 
		    			<th>
		    				<?php 
		        				if ($skliste["durum"] == 0) {
		        			?>
		        			<span class="btn bg-success btn-xs btn-block"> Akftif </span>
		        			<?php } else if ($skliste["durum"] == 1) { ?>
		        			<span class="btn bg-danger btn-xs btn-block"> Pasif </span>
		        			<?php } ?>
		    			</th>
			    		<th class="text-center">
			    			<a href="index.php?do=islem&icerik=haberkategori&islem=duzenle&id=<?=$skliste['id']?>" title="Düzenle" class="btn btn-primary btn-xs btn-block">
								<i class="fa fa-pencil"></i> Düzenle
							</a>
							<?php 
								if ($skliste["durum"] == "0") {
							?>
							<a href="index.php?do=islem&icerik=haberkategori&islem=liste&durum=1&id=<?=$skliste['id']?>" title="Yayından Kaldır" class="btn btn-warning btn-xs btn-block">
								<i class="fa fa-close"></i> Pasif Yap
							</a>
							<?php } else if ($skliste["durum"] == "1"){ ?>
							<a href="index.php?do=islem&icerik=haberkategori&islem=liste&durum=0&id=<?=$skliste['id']?>" title="Yayınla" class="btn btn-success btn-xs btn-block">
								<i class="fa fa-check"></i> Aktif Et
							</a>
							<?php } ?> 
							<a href="#" data-toggle="modal" data-target="#<?=$skliste["id"];?>" title="Sil" class="btn btn-danger btn-xs btn-block">
								<i class="fa fa-trash"></i> Sil
							</a>  
							<div class="modal modal-default fade" id="<?=$skliste["id"]?>" style="display: none;">
							  <div class="modal-dialog">
								<div class="modal-content">
								  <div class="modal-header alert alert-info">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">×</span></button>
									<h4 class="modal-title"><i class="fa fa-close"></i> Silme Onayı Ver</h4>
								  </div>
								  <div class="modal-body">
									<h4><strong> "<?=$skliste["baslik"]?>" </strong> isimli kategori silinecektir. İşlemi onaylıyor musunuz ?</h4>
								  </div>
								  <div class="modal-footer">
									<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
									<a href="index.php?do=islem&icerik=haberkategori&islem=liste&hareket=sil&id=<?=$skliste['id']?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
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