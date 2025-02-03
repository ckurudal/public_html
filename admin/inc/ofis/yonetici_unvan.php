<?php  
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
	
	uyeYasak(yetki());
	

	$id = $_GET["id"];
	$islem = $_GET["islem"];
	$hareket = $_GET["hareket"];
	$durum = $_GET["durum"];

	$unvanlar = mysql_query("SELECT * FROM yonetici_unvan where id = '$id'");
	$unvanliste = mysql_query("SELECT * FROM yonetici_unvan order by id desc");
?>
<section class="content-header">

	<i class="fa fa-user-plus fa-2x pull-left"></i>

	Danışman Ünvan Yönetimi

	<p> <small> Ünvan Ayarları </small> </p>

</section>
<section class="co ntent">
<?php 
	if (isset($_POST["unvanekle"]) || isset($_POST["unvankaydet"]) || isset($_POST["sirakaydet"])) { 
		
		$baslik = trim(mysql_real_escape_string($_POST["baslik"])); 
		$seo = seo($_POST["baslik"]); 
		$sira = $_POST["sira"]; 
		$siraid = $_POST["siraid"];

		if (isset($_POST["unvanekle"])) {

			$unvanekle = mysql_query("INSERT INTO yonetici_unvan (baslik, seo) values ('$baslik', '$seo')");	

			if ($unvanekle == true) {
				go("index.php?do=islem&ofis=yoneticiunvan&islem=liste&hareket=onay",0);
			}
		}

		if (isset($_POST["unvankaydet"])) {

			$unvankaydet = mysql_query("UPDATE yonetici_unvan SET baslik = '$baslik', seo = '$seo' where id = '$id'");	

			if ($unvankaydet == true) {
				go("index.php?do=islem&ofis=yoneticiunvan&islem=liste&hareket=onay",0);
			}
		}

		if (isset($_POST["sirakaydet"])) {

			for ($i=0; $i < count($siraid) ; $i++) { 
				
				$sirakaydet = mysql_query("UPDATE yonetici_unvan SET sira = '$sira[$i]' where id = '$siraid[$i]'");
 				 
				if ($sirakaydet == true) {
					go("index.php?do=islem&ofis=yoneticiunvan&islem=liste&hareket=onay",0);
				}

 			} 
			
		}
	}
?>
</section>
<?php if ($islem == "ekle") { ?>
<form action="" method="post" enctype="multipart/form-data">
	<section class="content">
		<div class="box"> 
			<div class="box-header with-border">
			  <h3 class="box-title"><i class="fa fa-check"></i> Yeni Ekle </h3>
			  <!-- /. tools -->
			</div>
			<!-- /.box-header -->
			<div class="box-body pad" style="">
				<div class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-2 control-label">Başlık:</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="baslik">
					  </div>
					</div>
				</div>
			</div>
		</div> 
		<div class="box"> 
			<div class="box-footer">
				<button type="submit" class="btn btn-success btn-lg pull-right" name="unvanekle"> <i class="fa fa-check"></i> Yeni Ekle </button>
			 </div> 
		</div> 
	</section>
</form>
<?php } ?> 
<?php if ($islem == "duzenle") { ?>
<form action="" method="post" enctype="multipart/form-data">
	<?php 
		$u = mysql_fetch_array($unvanlar);
	?>
	<section class="content">
		<div class="box"> 
			<div class="box-header with-border">
			  <h3 class="box-title"><i class="fa fa-check"></i> Ünvan Düzenle </h3>
			  <!-- tools box -->
			  <div class="pull-right box-tools">
				<a href="#" class="btn btn-  btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Daralt">
				  <i class="fa fa-minus"></i></a>
				<a type="button" class="btn btn-  btn-sm" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Kapat">
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
						<input type="text" class="form-control" name="baslik" value="<?=$u["baslik"];?>">
					  </div>
					</div>
				</div>
			</div>
		</div> 
		<div class="box"> 
			<div class="box-footer">
				<button type="submit" class="btn btn-primary btn-lg pull-right" name="unvankaydet"> <i class="fa fa-check"></i> Kaydet </button>
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
			
			$sil = mysql_query("DELETE FROM yonetici_unvan where id = '$id'"); 

			go("index.php?do=islem&ofis=yoneticiunvan&islem=liste&hareket=onay&id=$id",0);

		}

		if ($durum == "0") {
			$d = mysql_query("UPDATE yonetici_unvan SET durum = '0' where id = '$id'"); 
			go("index.php?do=islem&ofis=yoneticiunvan&islem=liste&hareket=onay&id=$id",0);
		}
		if ($durum == "1") {
			$d = mysql_query("UPDATE yonetici_unvan SET durum = '1' where id = '$id'"); 
			go("index.php?do=islem&ofis=yoneticiunvan&islem=liste&hareket=onay&id=$id",0);
		}
	?>
    <a href="index.php?do=islem&ofis=yoneticiunvan&islem=ekle" class="btn btn-lg bt-xs btn-success">
        <i class="fa fa-plus"></i> Yeni Ekle
    </a>
	<form method="POST" action="" class="form">
		<div class="bo x">	  

			<div class="box-bo dy table-responsive">
				
					<table id="example1" class="table table-bordered dataTable" colspan="5" role="grid" aria-describedby="example1_info">
				    <thead>
				        <tr>                        
				            <td class="text-center" style="width:0.00000001%;"> ID </td>
				            <td style="width:0.3%;"> Ünvan </td>
				            <td style="width:0.1%;"> Sıra No </td>
				            <td style="width:0.05%;"> Durum </td> 			            
				            <td class="text-center" style="width:0.1%;"> İşlemler </td>
				        </tr>
			   		</thead>
			    	<tbody>
			    		<?php 
				    		while($uliste = mysql_fetch_array($unvanliste)) {
				    	?> 
			    		<tr>
			    			<th><?=$uliste["id"];?></th>
			    			<th><?=$uliste["baslik"];?></th>
			    			<th>
			    				<input type="text" class="form-control hidden" name="siraid[]" value="<?=$uliste["id"];?>">
			    				<input type="text" class="form-control" name="sira[]" value="<?=$uliste["sira"];?>">
			    			</th>
			    			<th>
			    				<?php 
			        				if ($uliste["durum"] == 0) {
			        			?>
			        			<span class="btn bg-success btn-xs btn-block"> Aktif </span>
			        			<?php } else if ($uliste["durum"] == 1) { ?>
			        			<span class="btn bg-danger btn-xs btn-block"> Pasif </span>
			        			<?php } ?>
			    			</th>
				    		<th class="text-center">
				    			<a href="index.php?do=islem&ofis=yoneticiunvan&islem=duzenle&id=<?=$uliste['id']?>"  title="Düzenle" class="btn btn-primary btn-xs btn-block">
									<i class="fa fa-pencil"></i> Düzenle
								</a>
								<?php 
									if ($uliste["durum"] == "0") {
								?>
								<a href="index.php?do=islem&ofis=yoneticiunvan&islem=liste&durum=1&id=<?=$uliste['id']?>" title="Yayından Kaldır" class="btn btn-warning btn-xs btn-block">
									<i class="fa fa-close"></i> Pasif Et
								</a>
								<?php } else if ($uliste["durum"] == "1"){ ?>
								<a href="index.php?do=islem&ofis=yoneticiunvan&islem=liste&durum=0&id=<?=$uliste['id']?>" title="Yayınla" class="btn btn-success btn-xs btn-block">
									<i class="fa fa-check"></i> Aktif Yap
								</a>
								<?php } ?>
								<a href="#" data-toggle="modal" data-target="#<?=$uliste["id"];?>" title="Sil" class="btn btn-danger btn-xs btn-block">
									<i class="fa fa-trash"></i> Sil
								</a>  
								<div class="modal modal-default fade" id="<?=$uliste["id"]?>" style="display: none;">
								  <div class="modal-dialog">
									<div class="modal-content">
									  <div class="modal-header alert alert-info">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										  <span aria-hidden="true">×</span></button>
										<h4 class="modal-title"><i class="fa fa-close"></i> Silme Onayı Ver</h4>
									  </div>
									  <div class="modal-body">
										<h4><strong> "<?=$uliste["baslik"]?>" </strong> isimli ünvan silinecektir. İşlemi onaylıyor musunuz ?</h4>
									  </div>
									  <div class="modal-footer">
										<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
										<a href="index.php?do=islem&ofis=yoneticiunvan&islem=liste&hareket=sil&id=<?=$uliste['id']?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
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
		
		<button type="submit" class="btn btn-primary btn-lg" name="sirakaydet"> <i class="fa fa-check"></i> Sıralamayı Kaydet </button>

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
