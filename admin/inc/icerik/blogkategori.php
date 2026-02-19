<?php  
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
	
	uyeYasak(yetki());
	

	$id = $_GET["id"];
	$islem = $_GET["islem"];
	$hareket = $_GET["hareket"];
	$durum = $_GET["durum"];

	$bloglar = $vt->query("SELECT * FROM blog_kategori where id = '$id'");
	$blogkatliste = $vt->query("SELECT * FROM blog_kategori order by id desc");
?>
<section class="c ontent"> 
<?php 
	if (isset($_POST["blogkategoriekle"]) || isset($_POST["blogkategorikaydet"])) {

		$baslik 		= trim($_POST["baslik"]);
		$seo 			= seo($_POST["baslik"]);
		$title 			= trim($_POST["title"]);
		$aciklama 		= trim($_POST["aciklama"]);
		$keyw			= trim($_POST["keyw"]);

		if (isset($_POST["blogkategoriekle"])) {

			$blogkategoriekle = $vt->query("INSERT INTO blog_kategori (baslik, seo, title, aciklama, keyw) values ('$baslik','$seo','$title','$aciklama','$keyw')");	

			if ($blogkategoriekle == true) {
				go("index.php?do=islem&icerik=blogkategori&islem=liste&hareket=onay",0);
			}
		}

		if (isset($_POST["blogkategorikaydet"])) {

			$unvankaydet = $vt->query("UPDATE blog_kategori SET baslik = '$baslik', seo = '$seo', title = '$title', aciklama = '$aciklama', keyw = '$keyw'  where id = '$id'");	

			if ($unvankaydet == true) {
				go("index.php?do=islem&icerik=blogkategori&islem=liste&hareket=onay",0);
			}
		}

	}
?>
</section>
<!-- Content Header (Page header) -->
<section class="content-header">

	<i class="fa fa-pencil fa-2x pull-left"></i>

	Blog Kategorileri

	<p> <small> Blog Kategori Yönetimi </small> </p>

</section> 
<?php if ($islem == "ekle") { ?>
<form action="" method="post" enctype="multipart/form-data">
	<section class="content"> 
		<div class="box"> 
			<div class="box-header with-border">
				<h3 class="box-title"> <i class="fa fa-edit"></i> Blog Kategori Ekleme </h3>
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
				<button type="submit" class="btn btn-success btn-lg pull-right" name="blogkategoriekle"> <i class="fa fa-check"></i> Yeni Ekle </button>
			 </div> 
		</div> 
	</section>
</form>
<?php } ?> 
<?php if ($islem == "duzenle") { ?>
<form action="" method="post" enctype="multipart/form-data">
	<?php 
		$bk = $bloglar->fetch();
	?>
	<section class="content"> 
		<div class="box"> 
			<div class="box-header with-border">
				<h3 class="box-title"> <i class="fa fa-edit"></i> Blog Kategori Düzenleme </h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body" style="">
				<div class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-2 control-label">Başlık:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="baslik" value="<?=$bk["baslik"];?>">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Title:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="title" value="<?=$bk["title"];?>">
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Google Açıklama:</label>
					  <div class="col-sm-10"> 
						<textarea class="form-control" id="" name="aciklama" rows="5" cols="80"><?=$bk["aciklama"];?></textarea>
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Anahtar Kelimeler:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="keyw" value="<?=$bk["keyw"];?>">
					  </div>
					</div> 
				</div>
			</div>
		</div> 
		<div class="box"> 
			<div class="box-footer">
				<button type="submit" class="btn btn-primary btn-lg pull-right" name="blogkategorikaydet"> <i class="fa fa-check"></i> Kaydet </button>
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
				
			$sil = $vt->query("DELETE FROM blog_kategori where id = '$id'"); 

			go("index.php?do=islem&icerik=blogkategori&islem=liste&hareket=onay&id=$id",0);

		}

		if ($durum == "0") {
			$d = $vt->query("UPDATE blog_kategori SET durum = '0' where id = '$id'"); 
			go("index.php?do=islem&icerik=blogkategori&islem=liste&hareket=onay&id=$id",0);
		}
		if ($durum == "1") {
			$d = $vt->query("UPDATE blog_kategori SET durum = '1' where id = '$id'"); 
			go("index.php?do=islem&icerik=blogkategori&islem=liste&hareket=onay&id=$id",0);
		}
	?>
	<a href="index.php?do=islem&icerik=blogkategori&islem=ekle" class="btn btn-lg bt-xs btn-success">
        <i class="fa fa-plus"></i> Yeni Ekle
    </a>  
	<div class="bo x">	   	
		<div class="box-b ody table-responsive">
			<table id="example1" class="table table-bordered dataTable" colspan="5" role="grid" aria-describedby="example1_info">
			    <thead>
			        <tr>                        
			            <td class="text-center" style="width:0.00000001%;"> ID </td>
			            <td style="width:70%;"> Kategori Adı </td> 
			            <td style="width:0.05%;"> Durum </td> 			            
			            <td class="text-center" style="width:0.1%;"> İşlemler </td>
			        </tr>
		   		</thead>
		    	<tbody>
			    	<?php 
			    		while($bkliste = $blogkatliste->fetch()) {
			    	?>
		    		<tr>
		    			<th class="text-center"><?=$bkliste["id"];?></th>
		    			<th><?=$bkliste["baslik"];?></th> 
		    			<th>
		    				<?php 
		        				if ($bkliste["durum"] == 0) {
		        			?>
		        			<span class="btn bg-success btn-xs btn-block"> Aktif </span>
		        			<?php } else if ($bkliste["durum"] == 1) { ?>
		        			<span class="btn bg-danger btn-xs btn-block"> Pasif </span>
		        			<?php } ?>
		    			</th>
			    		<th class="text-center">
			    			<a href="index.php?do=islem&icerik=blogkategori&islem=duzenle&id=<?=$bkliste['id']?>" title="Düzenle" class="btn btn-primary btn-xs btn-block">
								<i class="fa fa-pencil"></i> Düzenle
							</a>
							<?php 
								if ($bkliste["durum"] == "0") {
							?>
							<a href="index.php?do=islem&icerik=blogkategori&islem=liste&durum=1&id=<?=$bkliste['id']?>" title="Yayından Kaldır" class="btn btn-warning btn-xs btn-block">
								<i class="fa fa-close"></i> Pasif Yap
							</a>
							<?php } else if ($bkliste["durum"] == "1"){ ?>
							<a href="index.php?do=islem&icerik=blogkategori&islem=liste&durum=0&id=<?=$bkliste['id']?>" title="Yayınla" class="btn btn-success btn-xs btn-block">
								<i class="fa fa-check"></i> Aktif Et
							</a>
							<?php } ?>
							<a href="#" data-toggle="modal" data-target="#<?=$bkliste["id"];?>" title="Sil" class="btn btn-danger btn-xs btn-block">
								<i class="fa fa-trash"></i> Sil
							</a>  
							<div class="modal modal-default fade" id="<?=$bkliste["id"]?>" style="display: none;">
							  <div class="modal-dialog">
								<div class="modal-content">
								  <div class="modal-header alert alert-info">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">×</span></button>
									<h4 class="modal-title"><i class="fa fa-close"></i> Silme Onayı Ver</h4>
								  </div>
								  <div class="modal-body">
									<h4><strong> "<?=$bkliste["baslik"]?>" </strong> isimli kategori silinecektir. İşlemi onaylıyor musunuz ?</h4>
								  </div>
								  <div class="modal-footer">
									<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
									<a href="index.php?do=islem&icerik=blogkategori&islem=liste&hareket=sil&id=<?=$bkliste['id']?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
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