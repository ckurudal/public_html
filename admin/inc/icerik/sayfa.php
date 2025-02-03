<?php
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
	
	uyeYasak(yetki());
	

	$id = $_GET["id"];
	$islem = $_GET["islem"];
	$hareket = $_GET["hareket"];
	$durum = $_GET["durum"];

	$sayfalar = mysql_query("SELECT * FROM sayfa order by id DESC");
	$sayfalarid = mysql_query("SELECT * FROM sayfa where id = '$id'");

	$sayfakategori = mysql_query("SELECT * FROM sayfa_kategori order by id ASC");

?>
<section class="co ntent">
<?php
	if (isset($_POST["sayfaekle"]) || isset($_POST["sayfakaydet"]) || isset($_POST["sirakaydet"])) {

		$baslik 		= addslashes($_POST["baslik"]);
		$icerik 		= trim(mysql_real_escape_string($_POST["icerik"]));
		$seo 			= seo($baslik);
		$title 			= trim(mysql_real_escape_string($_POST["title"]));
		$aciklama 		= trim(mysql_real_escape_string($_POST["aciklama"]));
		$keyw			= trim(mysql_real_escape_string($_POST["keyw"]));
		$kategori		= $_POST["kategori"];
		$video 			= trim(mysql_real_escape_string($_POST["video"]));
		$resim 			= $_POST["resim"];
		$sira 			= "";
		$siraid 		= $_POST["siraid"];
		$sira 			= $_POST["sira"];

		if (isset($_POST["sayfaekle"])) {

			$sayfaekle = mysql_query("INSERT INTO sayfa (baslik, icerik, seo, title, aciklama, keyw, kategori, video, sira) values ('$baslik','$icerik','$seo','$title','$aciklama','$keyw','$kategori','$video','$sira')");

			if ($sayfaekle == true) {
				go("index.php?do=islem&icerik=sayfa&islem=liste&hareket=onay",0);
			} else {
				echo mysql_error();
			}

			// resim yukleme

				$yuklenmeyenler = 0;
				$yuklenenler = 0;
				$toplam = count($_FILES["resim"]["name"]);
				for ($i = 0; $i < $toplam; $i++) {
				    if (is_uploaded_file($_FILES["resim"]["tmp_name"][$i])) {
				        $resim = pathinfo($_FILES["resim"]["name"][$i]);
				        $resim_adi = $resim["filename"];
				        $resim_uzanti = $resim["extension"];
				        $uzantilar = array("png", "gif", "jpg", "PNG", "GIF", "JPG", "jpeg", "JPEG");
				        if (in_array($resim_uzanti, $uzantilar)) {
				            $saat = date("H:i:s");
				            $saat = sha1(md5($saat));
				            $dosya = "../uploads/resim/".$saat.".jpg";
				            if (move_uploaded_file($_FILES["resim"]["tmp_name"][$i], $dosya)) {

				                $ids = mysql_query("SELECT * FROM sayfa order by id desc limit 1");
				                $id = mysql_fetch_array($ids);

				                $link = "/uploads/resim/".$saat.".jpg";
				                $ekle = mysql_query("UPDATE sayfa SET resim = '$link' where id = '".$id["id"]."'");
				                $yuklenenler++;

				            }

				        } else {

				            $yuklenmeyenler++;

				        }
				    }
				}
		}

		if (isset($_POST["sayfakaydet"])) {

			$unvankaydet = mysql_query("UPDATE sayfa SET baslik = '$baslik', icerik = '$icerik', seo = '$seo', title = '$title', aciklama = '$aciklama', keyw = '$keyw', kategori = '$kategori', video = '$video' where id = '$id'");

			if ($unvankaydet == true) {

				// resim yukleme

				$yuklenmeyenler = 0;
				$yuklenenler = 0;
				$toplam = count($_FILES["resim"]["name"]);
				for ($i = 0; $i < $toplam; $i++) {
				    if (is_uploaded_file($_FILES["resim"]["tmp_name"][$i])) {
				        $resim = pathinfo($_FILES["resim"]["name"][$i]);
				        $resim_adi = $resim["filename"];
				        $resim_uzanti = $resim["extension"];
				        $uzantilar = array("png", "gif", "jpg", "PNG", "GIF", "JPG", "jpeg", "JPEG");
				        if (in_array($resim_uzanti, $uzantilar)) {
				            $saat = date("H:i:s");
				            $saat = sha1(md5($saat));
				            $dosya = "../uploads/resim/".$saat.".jpg";
				            if (move_uploaded_file($_FILES["resim"]["tmp_name"][$i], $dosya)) {


				            	$resimal = mysql_query("SELECT * FROM sayfa where id = $id");
				            	$ral = mysql_fetch_array($resimal);

								$sil = @unlink("..".$ral['resim']);

				                $link = "/uploads/resim/".$saat.".jpg";
				                $ekle = mysql_query("UPDATE sayfa SET resim = '$link' where id = '$id'");
				                $yuklenenler++;

				            }

				        } else {

				            $yuklenmeyenler++;

				        }
				    }
				}

				go("index.php?do=islem&icerik=sayfa&islem=liste&hareket=onay",0);
			}
		}

		if (isset($_POST["sirakaydet"])) {

			for ($i=0; $i < count($siraid) ; $i++) {

				$sirakaydet = mysql_query("UPDATE sayfa SET sira = '$sira[$i]' where id = '$siraid[$i]'");

				if ($sirakaydet == true) {
					go("index.php?do=islem&icerik=sayfa&islem=liste&hareket=onay",0);
				}

 			}

		}

	}
?>
</section>
<!-- Content Header (Page header) -->
<section class="content-header">

	<i class="fa fa-pencil fa-2x pull-left"></i>

	Sayfa Yönetimi

	<p> <small> İçerik Yönetim Ayarları </small> </p>

</section>
<?php if ($islem == "ekle") { ?>
<form action="" method="post" enctype="multipart/form-data">
	<section class="content">
			<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"> <i class="fa fa-plus"></i> Yeni Sayfa Ekleme </h3>
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
					  <label class="col-sm-2 control-label">İçerik:</label>
					  <div class="col-sm-10">
						<textarea id="editor1" name="icerik" rows="15" cols="80"></textarea>
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
					<div class="form-group">
					  <label class="col-sm-2 control-label">Kategori:</label>
					  <div class="col-sm-10">
						<select class="form-control select2" name="kategori">
							<option>Seçiniz</option>
							<?php
								while($sk = mysql_fetch_array($sayfakategori)) {
							?>
							<?php
								if ($sk["durum"] == 0) {
							?>
							<option value="<?=$sk["id"];?>"><?=$sk["baslik"];?></option>
							<?php } ?>
							<?php } ?>
						</select>
					  </div>
					</div>
					<style type="text/css">
					.fr-popup .fr-input-line input + label, .fr-popup .fr-input-line textarea + label {
						position: inherit !important;
					}
					</style>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Video</label>
					  <div class="col-sm-10">
					      <textarea id="edit" name="video" placeholder="Video ekleyin"></textarea>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Kapak Resmi:</label>
					  <div class="col-sm-4">
					  	<input type="file" class="form-control" name="resim[]"/>
					  </div>
					</div>
				</div>
			</div>
		</div>
		<div class="box">
			<div class="box-footer">
				<button type="submit" class="btn btn-success btn-lg pull-right" name="sayfaekle"> <i class="fa fa-check"></i> Yeni Ekle </button>
			 </div>
		</div>
	</section>
</form>
<?php } ?>
<?php if ($islem == "duzenle") { ?>
<form action="" method="post" enctype="multipart/form-data">
	<?php
		$s = mysql_fetch_array($sayfalarid);
	?>
	<section class="content">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"> <i class="fa fa-edit"></i> Sayfa Düzenleme </h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body" style="">
				<div class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-2 control-label">Başlık:</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" name="baslik" value="<?=$s["baslik"];?>">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">İçerik:</label>
					  <div class="col-sm-10">
						<textarea id="editor1" name="icerik" rows="15" cols="80"><?=$s["icerik"];?></textarea>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Title:</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" name="title" value="<?=$s["title"];?>">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Google Açıklama:</label>
					  <div class="col-sm-10">
						<textarea class="form-control" id="" name="aciklama" rows="5" cols="80"><?=$s["aciklama"];?></textarea>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Anahtar Kelimeler:</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" name="keyw" value="<?=$s["keyw"];?>">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Kategori:</label>
					  <div class="col-sm-10">
						<select class="form-control select2" name="kategori">
							<?php
								$sfkatadi = mysql_query("SELECT * FROM sayfa_kategori Where id = '".$s["kategori"]."'");
								$sfkadi = mysql_fetch_array($sfkatadi);
							?>
							<?php
								if (!$s["kategori"] == 0) {
							?>

							<?php } ?>
							<?php
								if ($s["kategori"] == 0) {
							?>
							<option>Seçiniz</option>
							<?php } ?>
							<?php
								while($sk = mysql_fetch_array($sayfakategori)) {
							?>
							<?php
								if ($sk["durum"] == 0) {
							?>
							<option value="<?=$sk["id"];?>"><?=$sk["baslik"];?></option>
							<?php } ?>
							<?php } ?>
						</select>
					  </div>
					</div>
					<style type="text/css">
					.fr-popup .fr-input-line input + label, .fr-popup .fr-input-line textarea + label {
						position: inherit !important;
					}
					</style>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Video</label>
					  <div class="col-sm-10">
					      <textarea id="edit" name="video" placeholder="Video ekleyin"><?=$s["video"];?></textarea>
					  </div>
					</div>
					<?php if (!empty($s["resim"])) { ?>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Kapak Resmi:</label>
					  <div class="col-sm-10">
						<div class="resim_liste" style="width: 200px; height: 200px; margin: inherit;">
							<img src="<?=$s["resim"];?>">
						</div>
					  </div>
					</div>
					<?php } ?>
					<div class="form-group">
					  <label class="col-sm-2 control-label">Kapak Resmini Değiştir:</label>
					  <div class="col-sm-4">
					  	<input type="file" class="form-control" name="resim[]"/>
					  </div>
					</div>
				</div>
			</div>
		</div>
		<div class="box">
			<div class="box-footer">
				<button type="submit" class="btn btn-primary btn-lg pull-right" name="sayfakaydet"> <i class="fa fa-check"></i> Kaydet </button>
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

			$sil = mysql_query("DELETE FROM sayfa where id = '$id'");

			$ral = mysql_fetch_array($sayfalarid);
			$resimsil = @unlink("..".$ral['resim']);

			go("index.php?do=islem&icerik=sayfa&islem=liste&hareket=onay&id=$id",0);

		}

		if ($durum == "0") {
			$d = mysql_query("UPDATE sayfa SET durum = '0' where id = '$id'");
			go("index.php?do=islem&icerik=sayfa&islem=liste&hareket=onay&id=$id",0);
		}
		if ($durum == "1") {
			$d = mysql_query("UPDATE sayfa SET durum = '1' where id = '$id'");
			go("index.php?do=islem&icerik=sayfa&islem=liste&hareket=onay&id=$id",0);
		}
	?>

    <a href="index.php?do=islem&icerik=sayfa&islem=ekle" class="btn btn-lg bt-xs btn-success">
        <i class="fa fa-plus"></i> Yeni Ekle
    </a>

	<form method="POST" action="">
		<div class="bo x">
			<div class="box-bo dy table-responsive">
				<table id="example1" class="table table-bordered dataTable" colspan="5" role="grid" aria-describedby="example1_info">
				    <thead>
				        <tr>
				            <td class="text-center" style="width:0.00000001%;"> ID </td>
				            <td style="width:0.03%;"> Kapak Resmi </td>
				            <td style="width:0.3%;"> Başlık </td>
				            <td style="width:0.3%;"> Kategori Adı </td>
				            <td style="width:0.1%;"> Sıra No </td>
				            <td style="width:0.05%;"> Durum </td>
				            <td class="text-center" style="width:0.1%;"> İşlemler </td>
				        </tr>
			   		</thead>
			    	<tbody>
				    	<?php
				    		while($sliste = mysql_fetch_array($sayfalar)) {
				    	?>
			    		<tr>
			    			<th><?=$sliste["id"];?></th>
			    			<th>
				    			<?php
				    				if (!$sliste["resim"] == "") {
				    			?>
			    				<div class="resim_liste">
									<img src="<?=$sliste["resim"];?>"/>
								</div>
								<?php } else { ?>
								<div class="resim_liste">
									<img src="../uploads/resim/resim.png"/>
								</div>
								<?php } ?>
				    		</th>
			    			<th><?=$sliste["baslik"];?></th>
			    			<th>
			    				<?php
			    					$sayfakatadi = mysql_query("SELECT * FROM sayfa_kategori where id = '".$sliste["kategori"]."'");
			    					$sk = mysql_fetch_array($sayfakatadi);
			    				?>
			    				<?=$sk["baslik"];?>
			    			</th>
			    			<th>
			    				<input type="text" class="form-control hidden" name="siraid[]" value="<?=$sliste["id"];?>">
			    				<input type="text" class="form-control" name="sira[]" value="<?=$sliste["sira"];?>">
			    			</th>
			    			<th>
			    				<?php
			        				if ($sliste["durum"] == 0) {
			        			?>
			        			<span class="btn bg-success btn-xs btn-block"> Yayında </span>
			        			<?php } else if ($sliste["durum"] == 1) { ?>
			        			<span class="btn bg-danger btn-xs btn-block"> Yayında Değil</span>
			        			<?php } ?>
			    			</th>
				    		<th class="text-center">
				    			<a href="index.php?do=islem&icerik=sayfa&islem=duzenle&id=<?=$sliste['id']?>" title="Düzenle" class="btn btn-primary btn-xs btn-block">
									<i class="fa fa-pencil"></i> Düzenle
								</a>
								<?php
									if ($sliste["durum"] == "0") {
								?>
								<a href="index.php?do=islem&icerik=sayfa&islem=liste&durum=1&id=<?=$sliste['id']?>" title="Yayından Kaldır" class="btn btn-warning btn-xs btn-block">
									<i class="fa fa-close"></i> Pasif Yap
								</a>
								<?php } else if ($sliste["durum"] == "1"){ ?>
								<a href="index.php?do=islem&icerik=sayfa&islem=liste&durum=0&id=<?=$sliste['id']?>" title="Yayınla" class="btn btn-success btn-xs btn-block">
									<i class="fa fa-check"></i> Aktif Et
								</a>
								<?php } ?>
								<a href="#" data-toggle="modal" data-target="#<?=$sliste["id"];?>" title="Sil" class="btn btn-danger btn-xs btn-block">
									<i class="fa fa-trash"></i> Sil
								</a>
								<div class="modal modal-default fade" id="<?=$sliste["id"]?>" style="display: none;">
								  <div class="modal-dialog">
									<div class="modal-content">
									  <div class="modal-header alert alert-info">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										  <span aria-hidden="true">×</span></button>
										<h4 class="modal-title"><i class="fa fa-close"></i> Silme Onayı Ver</h4>
									  </div>
									  <div class="modal-body">
										<h4><strong> "<?=$sliste["baslik"]?>" </strong> isimli sayfa silinecektir. İşlemi onaylıyor musunuz ?</h4>
									  </div>
									  <div class="modal-footer">
										<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
										<a href="index.php?do=islem&icerik=sayfa&islem=liste&hareket=sil&id=<?=$sliste['id']?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
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
<script type="text/javascript">

	$(function() {
    	$('textarea#edit').froalaEditor({
		  language: 'tr',
		   toolbarButtons: ['insertVideo','html'],
		   heightMin: 200
		});

  	});


</script>
 
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