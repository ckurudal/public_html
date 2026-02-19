<?php
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
	$id 		= $_GET['id'];
	$i 			= $vt->query("SELECT * FROM emlak_ilan where id = '$id'")->fetch();
	$islemno 	= $i['emlakno'];
	$kategori 	= $i['katid'];
	$katedit 	= $_GET['katedit'];
	$danisman 	= $_GET['danisman'];
	$q 			= $vt->query("SELECT * FROM emlak_kategori WHERE kat_id = '$kategori'")->fetch();
    if ($_GET["islem"] != "sec"):
    $ilan_sekli = $vt->query("SELECT * FROM emlak_ilansekli WHERE id = {$q["ilansekli"]}")->fetch();
    $proje = $ilan_sekli["kat_tipi"];
    endif;	
 ?>
<!-- Content Header (Page header) -->
<section class="content-header hidden">
	<i class="fa fa-edit fa-2x pull-left"></i>
	İlan Yönetimi
	<p> <small> İlan Düzenleme Ayarları </small> </p>  
</section>
<?php
	if (isset($_POST["danismandegistir"])) {
		$yoneticiid = $_POST["yoneticiid"];
		$toplu = $_POST["toplu"];
		if (yetki() == 2) {
			$sube 		= $vt->query("SELECT * FROM subeler WHERE yetkiliuye = '".$_SESSION["id"]."'")->fetch();
			if ($toplu == 1) {
				$toplukaydet = $vt->query("UPDATE emlak_ilan SET yonetici_id = '$yoneticiid', ofisid = '".$sube["id"]."' where yonetici_id = '".$i["yonetici_id"]."'");
				if ($toplukaydet == true) {
					go("index.php?do=islem&ofis=yonetici&islem=duzenle&id={$yoneticiid}&tab_goster=ilanlari", 0);
				}
			} else {
				$dkaydet = $vt->query("UPDATE emlak_ilan SET yonetici_id = '$yoneticiid', ofisid = '".$sube["id"]."'  where id = '$id'");
				if ($dkaydet == true) {
					go("index.php?do=islem&ofis=yonetici&islem=duzenle&id={$yoneticiid}&tab_goster=ilanlari", 0);
				}
			}
		} else {
			if ($toplu == 1) {
				$yonetici 		= $vt->query("SELECT * FROM yonetici WHERE id = '".$yoneticiid."'")->fetch();
				$toplukaydet = $vt->query("UPDATE emlak_ilan SET yonetici_id = '$yoneticiid', ofisid = '".$yonetici["ofis"]."' where yonetici_id = '".$i["yonetici_id"]."'");
				if ($toplukaydet == true) {
					go("index.php?do=islem&ofis=yonetici&islem=duzenle&id={$yoneticiid}&tab_goster=ilanlari", 0);
				}
			} else {
				$yonetici 		= $vt->query("SELECT * FROM yonetici WHERE id = '".$yoneticiid."'")->fetch();
				$dkaydet = $vt->query("UPDATE emlak_ilan SET yonetici_id = '$yoneticiid', ofisid = '".$yonetici["ofis"]."' where id = '$id'");
				if ($dkaydet == true) {
					go("index.php?do=islem&ofis=yonetici&islem=duzenle&id={$yoneticiid}&tab_goster=ilanlari", 0);
				}
			}
		}
	}
?>
<section class="content">
 <?php
 	if ($danisman == "degistir") {
 ?>
 <form action="" method="POST">
 	<div class="box">
 		<div class="box-body">
 			<div class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-2 control-label">İlan Numarası:</label>
					<div class="col-sm-10">
						<input type="text" name="emlakno" class="form-control" disabled value="<?=$i['emlakno'];?>">
				  	</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Şimdiki Danışman:</label>
					<div class="col-sm-10">
						<?php
							$yoneticibaglan = $vt->query("SELECT * FROM yonetici where id = '".$i["yonetici_id"]."'");
							$yoneticiver = $yoneticibaglan->fetch();
						?>
						<input type="text" name="emlakno" class="form-control" disabled value="<?=$yoneticiver['adsoyad'];?>">
				  	</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Danışman Seçiniz:</label>
					<div class="col-sm-10">
						<select class="form-control select2" name="yoneticiid">
							<?php
								$yoneticiliste = $vt->query("SELECT * FROM yonetici order by id asc");
								while ($yoneticil = $yoneticiliste->fetch()) {
									if ($i["yonetici_id"] !== $yoneticil["id"]) {
									$sube = $vt->query("SELECT * FROM subeler WHERE yetkiliuye = '".$_SESSION["id"]."'")->fetch();										
							?>							
							<?php if (!yetki() == 0): ?>
								<?php if ($yoneticil["ofis"] == $sube["id"]): ?>
								<option value="<?=$yoneticil['id'];?>"><?=$yoneticil['adsoyad'];?></option>
								<?php endif; ?>
							<?php else: ?>
								<option value="<?=$yoneticil['id'];?>"><?=$yoneticil['adsoyad'];?></option>
							<?php endif; ?>
							<?php } ?>
							<?php } ?>
						</select>
				  	</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Tümünü Değiştir:</label>
					<div class="col-sm-10">
					<label for="toplu">
						  	<div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
						  		<input type="checkbox" name="toplu" value="1" class="minimal" style="position: absolute; opacity: 0;">
						  	</div>
							<strong><?=$yoneticiver['adsoyad'];?></strong> isimli danışmanın tüm ilanlarını seçilen danışmana aktarmak istiyorsanız seçiniz.
						</label>
				  	</div>
				</div>
			</div>
 		</div>
 	</div>
		<div class="box">
			<div class="box-footer">
				<button type="submit" class="btn btn-primary btn-lg pull-right" name="danismandegistir"> <i class="fa fa-check"></i> Kaydet </button>
			 </div>
		</div>
 </form>
 <?php } else { ?>
<?php
	$emlak_ilan_kontrol = $vt->query("SELECT * FROM emlak_ilan WHERE id = '$id'")->fetch();	
?>
<?php  if ($emlak_ilan_kontrol["yonetici_id"] == $_SESSION["id"] || yetki() == 0): ?>
<form method="post" action="" enctype="multipart/form-data">
		<?php
			if (isset($_POST["ozellikgetir"])) {
				// emlak formu ekleme alani
				$eformdetay	= $_POST["eformdetay"];
				$formid		= $_POST["formid"];
				$kat		= $_POST["kat"];
				$katilansekliver = $vt->query("SELECT * FROM emlak_kategori where kat_id = '$kat'");
				$katilansekli = $katilansekliver->fetch();
				$katduzenle = $vt->query("UPDATE emlak_ilan SET
					katid 		= 	'$kat',
					ilansekli	= 	'".$katilansekli["ilansekli"]."'
				where id = '$id'");
				$siled = $vt->query("delete from emlak_ilandetay where ilanid = '$id'");
				$silod = $vt->query("delete from emlak_ozellikdetay where ilanid = '$id'");
				go("index.php?do=islem&emlak=emlak_duzenle&id=$id",0);
		?>
		<div class="alert alert-success alert-dismissible">
			<h5> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> </h5>
			<div class="text-center">
				<h5> <i class="icon fa fa-check"></i> Kategori başarı ile değiştirilmiştir. Düzenlemeye devam edebilirsiniz. </h5>
			</div>
		</div>
		<?php } ?>
		<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title"><i class="fa fa-check"></i> Kategori Bilgileri </h3>
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
			<div class="box-body">
				<div class="form-horizontal">
					<div class="form-group">
					  <h6 class="col-sm-1">Kategori:</h6>
					  <div class="col-sm-4">
						  <select class="form-control select2" name="kat">
						  <?php if ($kategori == $q['kat_id']) { ?>
							<option value="<?=$q['kat_id'];?>"> <?=$q['kat_adi'];?> </option>
						  <?php } ?>
						  <?php
							  // ilan kategori
							  function kategori($id = 0, $i = 0) {
								  $query = $vt->query("SELECT * FROM emlak_kategori WHERE kat_ustid = '$id' AND kat_id");
								  if ($query->rowCount()) {
									  while ($row = $query->fetch()) {
										  if ($row["kat_durum"] == 1) {
										  	echo '<option value="'.$row["kat_id"].'"> '.str_repeat("--", $i).$row["kat_adi"].' </option>';
										  }
										  kategori($row["kat_id"], $i + 2, $ustid);
									  }
								  } else {
									  return false;
								  }
							  }
								kategori();
						  ?>
						  </select>
					  </div>
					  <div class="col-sm-3">
						<button type="submit" class="btn btn-success btn-block" name="ozellikgetir"><i class="fa fa-check"></i> Kategoriyi Değiştir</button>
					  </div>
					  <div class="col-sm-2">
						<a href="index.php?do=doping/ilan_doping&ilan_id=<?php echo $id; ?>" class="btn btn-default btn-block" target="_blank"> <i class="fa fa-rocket"></i> <strong></strong> Doping Yap </a>
					  </div>
					  <div class="col-sm-2">
							<a href="index.php?do=islem&emlak=emlak_resim&id=<?php echo $id; ?>" class="btn btn-warning btn-block" target="_blank"> <i class="fa fa-camera"></i> Resimler </a>							
					  </div>
					</div>
				</div>
			</div>
		</div>
		<div class="alert alert-primary">
			<strong>NOT:</strong> Kategori değişimi yapmak istiyorsanız, verileri eklemeden önce kategoriyi değiştirmelisiniz.
		</div>
		<br>
	</form>
	<form method="post" action="" enctype="multipart/form-data">
		<?php
			if (isset($_POST["emlakduzenle"])) {
				function resimUzanti($uzanti)
				{
					if ($uzanti == "image/jpeg")
					{
						return "jpeg";
					}
					if ($uzanti == "image/jpg")
					{
						return "jpg";
					}
					if ($uzanti == "image/png")
					{
						return "png";
					}
					if ($uzanti == "image/gif")
					{
						return "gif";
					}
				}
                 // PROJE KAPAK RESIM YUKLE
                $kapak_tip = $_FILES["proje_kapak"]["type"];
                if ($kapak_tip != "image/jpeg" AND $kapak_tip != "image/jpg" AND $kapak_tip != "image/png" AND $kapak_tip != "image/gif"):
                    hata_alert("Kapak resmi için lütfen resim formatında dosya seçiniz.");
                else:
                    $proje_kapak_resim_ad = rand(1000000,2000000)."-".seo($_POST["baslik"])."-".$islemno."-".seo($_FILES["proje_kapak"]["name"]);
                    move_uploaded_file($_FILES["proje_kapak"]["tmp_name"], "../uploads/proje_resim/".$proje_kapak_resim_ad.".".resimUzanti($kapak_tip)); 
                    // VT PROJE KAPAK RESIM EKLE
                    $proje_kapak_ekle=$vt->prepare("INSERT INTO proje_kapak (emlakno, proje_kapak) VALUES (?,?)");
                    $kapak_deger=$proje_kapak_ekle->execute(array($islemno, $proje_kapak_resim_ad.".".resimUzanti($kapak_tip)));
                endif;  
                // PROJE GUNCELLE
                for ($i=0; $i<count($_POST["kat_oda"]); $i++)
                {
                    $tip = $_FILES["plan_resim"]["type"][$i];
                    if ($tip != "image/jpeg" AND $tip != "image/jpg" AND $tip != "image/png" AND $tip != "image/gif"):
                        hata_alert("Kat planları için lütfen resim formatında dosya/dosyalar seçiniz.");
                    else:
                        // PROJE RESIM YUKLE
                        $proje_resim_ad = rand(1000000,2000000)."-".seo($_POST["baslik"])."-".$islemno."-".seo($_FILES["plan_resim"]["name"][$i]);
                        move_uploaded_file($_FILES["plan_resim"]["tmp_name"][$i], "../uploads/proje_resim/".$proje_resim_ad.".".resimUzanti($tip)); 
                        // VT PROJE RESIM EKLE
                        $proje_ekle=$vt->prepare("INSERT INTO projeler (emlakno, plan_resim, kat_oda, kat_sayi, kat_fiyat, kat_mkare) VALUES (?,?,?,?,?,?)");
                        $deger=$proje_ekle->execute(array($islemno, $proje_resim_ad.".".resimUzanti($tip), $_POST["kat_oda"][$i], $_POST["kat_sayi"][$i], $_POST["kat_fiyat"][$i], $_POST["kat_mkare"][$i])); 
                    endif;
                }
				// emlak ilan tablo ayarlari			 
                $il_adi = $vt->query("SELECT * FROM sehir WHERE sehir_key = '".$_POST["il"]."'")->fetch();
                $ilce_adi = $vt->query("SELECT * FROM ilce WHERE ilce_key = '".$_POST["ilce"]."'")->fetch();
                $ilantipi_adi = $vt->query("SELECT * FROM emlak_ilantipi WHERE id = '".$_POST["emlak_tipi"]."'")->fetch();	
		        $baslik 		= tirnak($_POST["baslik"]);
		        $sifreli	= $_POST["sifreli"];
		        if($sifreli==0) {
		            $ilan_sifre = "";
		        } else {
		            $ilan_sifre	= $_POST["ilan_sifre"];
		        } 
				$seo            = seo($il_adi["adi"])."-".seo($ilce_adi["ilce_title"])."-".seo($ilantipi_adi["ad"])."-".seo($q["kat_adi"])."-".seo($_POST["baslik"]);
				$eklemetarihi	= $eklemetarihi = date("d-m-Y");
				$emlak_sahibi	= addslashes($_POST["emlak_sahibi"]);
				$icerik			= addslashes($_POST["icerik"]);
				$title	 		= addslashes($_POST["title"]);
				$godesc 		= addslashes($_POST["godesc"]);
				$keyw 			= addslashes($_POST["keyw"]);
				$aciklama		= addslashes($_POST["aciklama"]);
				$emlak_tipi		= $_POST["emlak_tipi"];
                $fiyat = $_POST["fiyat"];
                if (empty($fiyat)) $fiyat = 0; 
				$fiyatkur		= $_POST["fiyatkur"];
				$il 			= $_POST["il"];
				$ilce 			= $_POST["ilce"];
				$mahalle 		= $_POST["mahalle"];
				$adres 			= $_POST["adres"];
				$anavitrin		= $_POST["anavitrin"];
				$katvitrin		= $_POST["katvitrin"];
				$firsatvitrin	= $_POST["firsatvitrin"];
				$slidervitrin	= $_POST["slidervitrin"];
				$onecikan		= $_POST["onecikan"];
				$acil			= $_POST["acil"];
				$enlem			= $_POST["enlem"];
				$boylam			= $_POST["boylam"];
				$zoom			= $_POST["zoom"];
				$sokak			= $_POST["sokak"];
				$video			= addslashes($_POST["video"]);
				$gunluk_onay			= $_POST["gunluk_onay"];
				$periyot			= $_POST["periyot"];
				$yetiskin_fiyat			= $_POST["yetiskin_fiyat"];
				$cocuk_fiyat			= $_POST["cocuk_fiyat"];
				$bebek_fiyat			= $_POST["bebek_fiyat"];
				$ozel_metin_1			= $_POST["ozel_metin_1"];
				$ozel_metin_2			= $_POST["ozel_metin_2"];
				$ozel_metin_3			= $_POST["ozel_metin_3"];
				$gunluk_fiyat_birim			= $_POST["gunluk_fiyat_birim"];
				if (empty($baslik))
				{				
					hata_alert("Başlık boş bırakılamaz. Lütfen başlık giriniz.");
				} else  {
					$eilanduzenle = $vt->query("UPDATE emlak_ilan SET
						baslik 		= 	'$baslik',
						referans_kodu = 	'$referans_kodu',
						sifreli = 	'$sifreli',
						ilan_sifre = 	'$ilan_sifre',
						eklemetarihi= 	'$eklemetarihi',
						emlak_sahibi= 	'$emlak_sahibi',
						seo 		= 	'$seo',
						icerik 		= 	'$icerik',
						title		=	'$title',
						godesc		=	'$godesc',
						keyw		=	'$keyw',
						aciklama	=	'$aciklama',
						ilantipi	=	'$emlak_tipi',
						fiyat		=	'$fiyat',
						fiyatkur	=	'$fiyatkur',
						il 			=	'$il',
						ilce 		=	'$ilce',
						mahalle 	=	'$mahalle',
						adres 		=	'$adres',
						sokak 		=	'$sokak',
						anavitrin	=	'$anavitrin',
						katvitrin	=	'$katvitrin',
						firsatvitrin=	'$firsatvitrin',
						slidervitrin=	'$slidervitrin',
						onecikan	=	'$onecikan',
						acil		=	'$acil',
						video 		= 	'$video',
						enlem 		= 	'$enlem',
						boylam 		= 	'$boylam',
						zoom		= 	'$zoom',
						gunluk_onay			= 	'$gunluk_onay',
						periyot				= 	'$periyot',
						yetiskin_fiyat		= 	'$yetiskin_fiyat',
						cocuk_fiyat			= 	'$cocuk_fiyat',
						bebek_fiyat			= 	'$bebek_fiyat',
						ozel_metin_1		= 	'$ozel_metin_1',
						ozel_metin_2		= 	'$ozel_metin_2',
						ozel_metin_3		= 	'$ozel_metin_3',
						gunluk_fiyat_birim		= 	'$gunluk_fiyat_birim'
						where id = '$id'");
				}
				if ($_POST["sokak"] == "") {
					$sokaksil = $vt->query("UPDATE emlak_ilan SET sokak = '' where id = '$id'");
				}
				// emlak ilan detay tablo ayarlari
				$eformdetay		= 	$_POST["eformdetay"];
				$formid			=	$_POST["formid"];
				$sil = $vt->query("delete from emlak_ilandetay where ilanid = '$id'");
				for ($i=0; $i<count($eformdetay);$i++){
					$ilanid=$vt->query("SELECT * FROM emlak_ilan where id = '$id'");
					$i2=$ilanid->fetch();
					if (!empty($eformdetay[$i]) AND $eformdetay[$i]!="Seçiniz") {
					$ekle=$vt->query("INSERT INTO emlak_ilandetay (eformdetay, seo, formid, ilanid, emlakno, ilansekli) values ('".$eformdetay[$i]."','".seo($eformdetay[$i])."','".$formid[$i]."','$i2[id]','$i2[emlakno]','$i2[ilansekli]')");
					}
				}
				if ($eilanduzenle) {
					go("index.php?do=islem&emlak=emlak_ilanlar&hareket=onay&id=$id",0);
				} else {
					
                } 
			}
		?>
	<div class="row">
		<div class="<?php if ($kullanici["yetki"] == 0) { ?>col-md-12 <?php } else { ?> col-md-12 <?php } ?>"> 
            <!-- PROJE EKLEME ALANI -->
            <?php if ($proje == "proje"): ?> 
                <?php 
                $proje_kapak = $vt->query("SELECT * FROM proje_kapak WHERE emlakno = {$islemno}")->fetch();
                ?>
                <?php if ($proje_kapak["proje_kapak"] == ""): ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h4><i class="fa fa-check"></i> Proje Kapak Resmi </h4>
                    </div> 
                    <div class="box-body">
                        <label>Proje Kapak Resmi</label>
                        <input type="file" class="form-control" value="" name="proje_kapak">
                    </div>
                </div>
                <?php else: ?>
                    <div class="row">
                        <div class="col-lg-3"> 
                            <div class="box plan_cerceve" style="max-height:230px;">
                                <div class="box-body text-center w-100">
                                    <div class="plan-img" style="max-height:150px;">
                                        <img class="img-thumbnail plan_resim" src="../uploads/proje_resim/<?php echo $proje_kapak["proje_kapak"]; ?>">
                                    </div> 
                                    <a class="btn btn-danger btn-xs" href="index.php?do=islem&emlak=emlak_duzenle&id=<?php echo $id; ?>&proje_kapak_sil=<?php echo $proje_kapak["id"]; ?>"><i class="fa fa-trash"></i> <strong>PROJE KAPAK SİL</strong> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php
                    if ($_GET["kat_plani_sil"]):
                        $proje_resim_sil = $vt->query("SELECT * FROM projeler WHERE id = {$_GET["kat_plani_sil"]}")->fetch();
                        @unlink('../uploads/proje_resim/'.$proje_resim_sil[plan_resim]);
                        $plan_sil = $vt->query("DELETE FROM projeler WHERE id = {$_GET["kat_plani_sil"]}");
                        if ($plan_sil):
                            go("index.php?do=islem&emlak=emlak_duzenle&id={$id}&hareket=onay");
                        endif;
                    endif;
                    if ($_GET["proje_kapak_sil"]):
                        $proje_kapak_resim_sil = $vt->query("SELECT * FROM proje_kapak WHERE id = {$_GET["proje_kapak_sil"]}")->fetch();
                        @unlink('../uploads/proje_resim/'.$proje_kapak_resim_sil[proje_kapak]);
                        $plan_sil = $vt->query("DELETE FROM proje_kapak WHERE id = {$_GET["proje_kapak_sil"]}");
                        if ($plan_sil):
                            go("index.php?do=islem&emlak=emlak_duzenle&id={$id}&hareket=onay");
                        endif;
                    endif;
                ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h4><i class="fa fa-check"></i> Kat Planları </h4>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <?php
                                $proje_resimleri_row = $vt->query("SELECT * FROM projeler WHERE emlakno = {$islemno}")->fetchAll();
                                foreach ($proje_resimleri_row as $proje):
                            ?>
                            <div class="col-lg-3"> 
                                <div class="box plan_cerceve">
                                    <div class="box-body text-center w-100">
                                        <div class="plan-img">
                                            <img class="img-thumbnail plan_resim" src="../uploads/proje_resim/<?php echo $proje["plan_resim"]; ?>">
                                        </div>
                                        <div class="plan_icerik text-center">
                                            <h4><?php echo $proje["kat_mkare"]; ?>M2 <?php echo $proje["kat_oda"]; ?></h4>
                                            <h5><?php echo $proje["kat_sayi"]; ?></h5>
                                            <h5><i class="fa fa-bed text-red"></i> <?php echo $proje["kat_oda"]; ?> - <i class="fa fa-home text-red"></i> <?php echo $proje["kat_mkare"]; ?>M2</h5>
                                            <hr>
                                            <a class="btn btn-danger btn-xs" href="index.php?do=islem&emlak=emlak_duzenle&id=<?php echo $id; ?>&kat_plani_sil=<?php echo $proje["id"]; ?>"><i class="fa fa-trash"></i> <strong>PLANI SİL</strong> </a>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div> 
                    <div class="box-body"> 
                        <hr>
                        <div class="row">
                            <div class="col-lg-10">
                                <div id="plan">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <a onclick="addrow(this);" class="btn btn-success btn-lg btn-block"><i class="fa fa-plus"></i></a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <a onclick="addrow(this);" class="btn btn-danger btn-lg btn-block"><i class="fa fa-minus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
                <!-- Introduce online jquery --> 
                <script>
                    function addrow(o){
                        var div=$(o).parent();
                        if($(o).html() == '<i class="fa fa-plus"></i>'){ 
                            var newdiv=$('#ekle').clone();
                            $('#plan').append('<div id="ekle" class="row"> <div class="col-lg-4"> <label>Kat Planı</label> <input type="file" class="form-control" value="" name="plan_resim[]" placeholder="Oda Sayısı"> </div> <div class="col-lg-2"> <label>Oda Sayısı</label> <input type="text" class="form-control" value="" name="kat_oda[]" placeholder="2+1"> </div> <div class="col-lg-2"> <label>Kat Sayısı</label> <input type="text" class="form-control" value="" name="kat_sayi[]" placeholder="Örn: Tek Kat"> </div> <div class="col-lg-2"> <label>Fiyat</label> <input type="number" class="form-control" value="" name="kat_fiyat[]" placeholder="750.000"> </div> <div class="col-lg-2"> <label>Metrekare</label> <input type="number" class="form-control" value="" name="kat_mkare[]" placeholder="185"> </div> </div>')
                            newdiv.find('a').html('<i class="fa fa-minus"></i>').addClass('btn-danger');
                            // $('#ekle').before(newdiv); 
                        }else{
                            $('#ekle').remove();
                        }
                    } 
                </script> 
                <?php endif; ?> 
                <!-- PROJE EKLEME ALANI BITTI --> 
			<div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title"><i class="fa fa-check"></i> İlan Bilgileri </h3>
				</div>
				<div class="box-body">
					<div class="form-horizontal">
						<div class="form-group">
						  <h6 class="col-sm-2">Başlık:</h6>
						  <div class="col-sm-10">
							<input type="text" class="form-control" name="baslik" value="<?=$i['baslik']?>">
						  </div>
						</div>
						<div class="form-group">
						  <h6 class="col-sm-2">Referans Kodu:</h6>
						  <div class="col-sm-10">
							<input type="text" class="form-control" name="referans_kodu" value="<?=$i['referans_kodu']?>">
						  </div>
						</div>
						<div class="form-group">
						  <h6 class="col-sm-2">İçerik:</h5>
						  <div class="col-sm-10">
							<textarea id="editor1" name="icerik" rows="15" cols="80"><?=$i['icerik'];?></textarea>
						  </div>
						</div>
						<br>
						<div class="form-group">
						  <h6 class="col-sm-2">Google Başlık (Title):</h6>
						  <div class="col-sm-10">
							<input type="text" name="title" class="form-control" value="<?=$i['title'];?>">
						  </div>
						</div>
						<div class="form-group">
						  <h6 class="col-sm-2">Google Açıklama:</h6>
						  <div class="col-sm-10">
							<textarea class="form-control" id="" name="godesc" rows="5" cols="80"><?=$i['godesc'];?></textarea>
						  </div>
						</div>
						<div class="form-group">
						  <h6 class="col-sm-2">Anahtar Kelimeler (Etiket):</h6>
						  <div class="col-sm-10">
							<input type="text" name="keyw" class="form-control" value="<?=$i['keyw'];?>">
						  </div>
						</div>
						<div class="form-group">
						  <h6 class="col-sm-2">İlan Notu:</h6>
						  <div class="col-sm-10">
							<textarea class="form-control" id="" name="aciklama" rows="5" cols="80"><?=$i['aciklama'];?></textarea>
							<h6><i class="fa fa-warning"></i> NOT: Bu bölüme yazacaklarınız yalnızca size özel bir bölümdür, yönetim panelinizden sadece siz görüntüleyebilirsiniz.</h6>
						  </div>
						</div>
					</div>
				</div>
				<div class="box-header with-border">
				  <h3 class="box-title"><i class="fa fa-check"></i> İlan Detayları </h3>
				</div>
				<div class="box-body">
					<div class="form-horizontal">
						<?php
							$formkat=$vt->query("SELECT emlak_form_kat.* FROM emlak_form_kat INNER JOIN emlak_form ON emlak_form_kat.eformid=emlak_form.id where emlak_form_kat.kat = '$kategori' ORDER BY emlak_form.sira ASC");
							while ($f=$formkat->fetch()) {
						?>
						<?php
							// Emlak Form
							$eform = $vt->query("select * from emlak_form where id = '$f[eformid]'");
					 		while ($formrow = $eform->fetch()) {
					 			$deg = trim($formrow[deg]);
						 		$ayir = explode(",", $deg);
						 		$say = trim(count($ayir));
						?>
						<div class="form-horizontal">
							<?php
								$idetaykont=$vt->query("SELECT * FROM emlak_ilandetay where ilanid = '$id' and formid = '$f[eformid]'");
								$dk=$idetaykont->fetch();
								if (empty($dk)) {
							?>
							  <div class="col-sm-3 <?php if ($formrow[durum] == 1) { echo "hidden";}?>">
								<label class="control-label" name="test"><?=$formrow["ad"]?>:</label>
								<!-- Emlak Form Select Input Ayarlari -->
								<?php if ($say > 1) { ?>
								<input hidden type="text" name="formid[]" value="<?=$formrow["id"]?>" class="form-control hidden">
								<select name="eformdetay[]" class="form-control select2">
									<option value="Seçiniz">Seçiniz</option>
									<?php
										foreach ($ayir as $a) {
										$e = strip_tags($a);
									?>
									<option><?=$e;?></option>
									<?php } ?>
								</select>
								<?php } else { ?>
								<input type="text" name="formid[]" value="<?=$formrow["id"]?>" class="form-control hidden">
								<input type="text" name="eformdetay[]" class="form-control">
								<?php } ?>
							  </div>
							<?php } else { ?>
						  <div class="col-sm-3">
						  	<label class="control-label" name="test"><?=$formrow["ad"]?>:</label>
					  		<!-- Emlak Form Select Input Ayarlari -->
						  	<?php if ($say > 1) { ?>
						  	<input hidden type="text" name="formid[]" value="<?=$formrow["id"]?>" class="form-control hidden">
							<select name="eformdetay[]" class="form-control select2"> 
								<option value="Seçiniz"> Seçiniz </option>
								<?php
									$idetay=$vt->query("SELECT * FROM emlak_ilandetay where ilanid = '$id' and formid = '$f[eformid]'");
									while($ide=$idetay->fetch()) {
								?>
								<?php
									if ($ide['formid']) {
								?>
								<option selected value="<?=$ide['eformdetay'];?>"> <?=$ide['eformdetay'];?> </option>
								<?php } else { ?>
								<option value="Seçiniz"> Seçiniz </option>
								<?php } ?>
								<?php } ?>
							  	<?php
							  		foreach ($ayir as $a) {
							  		$e = strip_tags($a);
							  	?>
								<option value="<?=$e;?>"> <?=$e;?> </option>
								<?php } ?>
							</select>
							<?php } else { ?>
							<input type="text" name="formid[]" value="<?=$formrow["id"]?>" class="form-control hidden">
							<input type="text" name="eformdetay[]" class="form-control"
							<?php
								$idetay2=$vt->query("SELECT * FROM emlak_ilandetay where ilanid = '$id' and formid = '$f[eformid]'");
								while($ide2=$idetay2->fetch()) {
							?>
								value="<?=trim($ide2['eformdetay']);?>"
							<?php } ?>
							>
							<?php } ?>
						  </div>
						<?php } ?>
						</div>
						<?php } ?>
						<?php } ?>
					</div>
				</div>
				<div class="box-header with-border">
				  <h3 class="box-title"><i class="fa fa-check"></i> İlan Özellikleri </h3>
				</div>
				<div class="box-body"> 
					<?php
						if (isset($_POST["emlakduzenle"])) {
							$silod = $vt->query("delete from emlak_ozellikdetay where ilanid = '$id'");
							$ozid=$_POST["ozid"];
							$oztip=$_POST["oztip"];
							if (!$_POST["ozid"]=="") {
								foreach ($ozid as $oid) {
									$liste=$vt->query("SELECT * FROM emlak_ozellik where id = '$oid'");
									while ($l=$liste->fetch()) {
										$ilanid=$vt->query("SELECT * FROM emlak_ilan where id = '$id'");
										$i=$ilanid->fetch();
										$ekle=$vt->query("INSERT INTO emlak_ozellikdetay (ozelliktip, ad, ilanid, ilansekli, ozellik) values ('$l[ozelliktipi]','$l[ad]','$i[id]','$q[ilansekli]','$l[id]')");
									}
								}
							}
						}
					?>
					<div class="form-horizontal">
						<?php
							$ozelliktipliste2 = $vt->query("SELECT * FROM emlak_ozelliktipliste where kat = '$q[kat_id]'");
							while ($ot2=$ozelliktipliste2->fetch()) {
								// Emlak Ozellik Tipi
								$ozelliktip = $vt->query("SELECT * FROM emlak_ozelliktip where id = '$ot2[ozellikid]'");
						 		$ot = $ozelliktip->fetch();
						?>
						<div class="form-group" <?php if ($ot["durum"]==1) {echo "hidden";} ?>>
						<input type="text" name="oztip[]" value="<?=$ot['id']?>" class="hidden">
						  <div class="col-sm-12">
						  	<h5><strong><i class="fa fa-arrow-right"></i> <?=$ot["ad"];?>:</strong></h5>
								<?php
									// Emlak Ozellikleri
									$ozellik = $vt->query("SELECT * FROM emlak_ozellik WHERE ozelliktipi = '$ot[id]'");
									while ($o = $ozellik->fetch()) {
								?>
								<div class="col-md-3 col-xs-6" <?php if ($o["durum"]==1) {echo "hidden";} ?>>
									<label for="ozad" class="">
										<div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
											<input type="checkbox" name="ozid[]" <?php $ozellikdetay=$vt->query("SELECT * FROM emlak_ozellikdetay where ilanid = '$id'"); while($od=$ozellikdetay->fetch()) {  if ($o['id'] == $od['ozellik']) {echo "checked";} } ?> value="<?=$o['id'];?>" class="minimal">
										</div>
										<?=$o["ad"];?>
									</label>
								</div>
								<?php } ?> 
								<br>
								<br>
								<br>
						  </div>
						</div>
						<?php } ?>
					</div>
				</div>
				<div class="box-header with-border">
				  <h3 class="box-title"><i class="fa fa-check"></i> Video </h3>
				</div>
				<div class="box-body">
					<style type="text/css">
						.fr-popup .fr-input-line input + label, .fr-popup .fr-input-line textarea + label {
							position: inherit !important;
						}
						</style>
						<div class="form-group">
						  <h6 class="col-sm-2">Video</h6>
						  <div class="col-sm-10">
						      <textarea id="edit" name="video" placeholder="Video ekleyin"><?=$i["video"];?></textarea>
						  </div>
						</div>
				</div>
			</div>
		</div>
		<div class="<?php if ($kullanici["yetki"] == 0) { ?>col-md-12 <?php } else { ?> col-md-12 <?php } ?>">
			<div class="box">
				<div class="alert alert-warning">
					<strong> İlan Bilgileri </strong>
				</div>
				<div class="box-body">
					<div class="form-group">
					  <div class="col-sm-12">
					  	<label class="control-label">Emlak No:</label>
						<input type="text" name="emlakno" disabled class="form-control" value="<?=$i['emlakno'];?>">
					  </div>
					</div>
					<div class="form-group">
					  <div class="col-sm-12">
					  	<label class="control-label">Emlak Sahibi:</label>
						<select name="emlak_sahibi" class="form-control select2">
							<option value="<?=$i["emlak_sahibi"];?>" selected> <?=$i["emlak_sahibi"];?> </option>
							<?php
								// İlan Sahibi
								$emlak_sahibi = $vt->query("SELECT * FROM emlak_sahibi ORDER BY sira ASC")->fetchAll();
								foreach($emlak_sahibi AS $sahip) {
							?>
							<option value="<?php echo $sahip["baslik"] ?>"> <?=$sahip["baslik"];?> </option>
							<?php } ?>
						</select>
					  </div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<br>
							<h5>İlan Tipi:</h5>
							<div class="row">
								<?php
									// Emlak Tipi
									$emlaktip = $vt->query("select * from emlak_ilantipi where id");
									while ($t = $emlaktip->fetch()) {
										$tipkatliste = $vt->query("SELECT * FROM emlak_ilantipi_katliste where katid = '".$q["kat_id"]."' AND ilantipid = '".$t["id"]."'");
								?>
								<?php if ($t["durum"]=="0") { ?>
									<div class="col-md-2">
									<?php if ($tipkatliste->rowCount()) { ?>
									<label for="ilan_tipi">
									  <input type="radio" <?php if ($i['ilantipi'] == $t['id']) {echo "checked";} ?> name="emlak_tipi" value="<?=$t["id"];?>" class="minimal">
									  <?=$t["ad"];?>
									</label>
									<?php } ?>
									</div>
								<?php } ?>
								<?php } ?>
							</div>
						 </div>
					  	<div class="col-sm-6">
						  	<label class="control-label">Fiyat:</label>
							<input type="text" name="fiyat" class="form-control" value="<?=$i['fiyat'];?>">
						</div>
						<div class="col-sm-6">
						  	<label class="control-label">Birim</label>
							<select name="fiyatkur" class="form-control select2">
								<option value="<?=$i["fiyatkur"];?>" selected> <?=$i["fiyatkur"];?> </option>
								<?php
									// Para Birimi
										$parabirim = $vt->query("select * from para_birimi where id");
										while ($paraver = $parabirim->fetch()) { ?>
										<option value="<?=$paraver["ad"];?>"> <?=$paraver["ad"];?> </option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>  
			</div>
			<?php if(yetki() == 0): ?>
			<div class="box">
				<div class="alert alert-warning">
					<strong> Bu İlanın Nerede Görüntüleneceğini Seçiniz. </strong>
				</div>
				<div class="box-body">
					<div class="form-group">
						<h5> Yayınlama Seçenekleri:</h5>
						<label for="anavitrin" class="">
							<div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
								<input type="checkbox" <?php if ($i['anavitrin'] == 1) {echo "checked";} ?> name="anavitrin" value="1" class="minimal" style="position: absolute; opacity: 0;">
							</div>
							Anasayfa Vitrini
						</label>
						<label for="firsatvitrin" class="">
							<div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
								<input type="checkbox" <?php if ($i['firsatvitrin'] == 1) {echo "checked";} ?> name="firsatvitrin" value="1" class="minimal" style="position: absolute; opacity: 0;">
							</div>
							Fırsat Vitrini
						</label>
					    <!--
						<label for="slidervitrin" class="">
							<div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
								<input type="checkbox" <?php if ($i['slidervitrin'] == 1) {echo "checked";} ?> name="slidervitrin" value="1" class="minimal" style="position: absolute; opacity: 0;">
							</div>
							Slider Alanı
						</label>
						-->
						<label for="avitrin" class="">
							<div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
								<input type="checkbox" <?php if ($i['acil'] == 1) {echo "checked";} ?> name="acil" value="1" class="minimal" style="position: absolute; opacity: 0;">
							</div>
							Acil İlanlar
						</label>								
						<label for="onecikan" class="">
							<div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
								<input type="checkbox" <?php if ($i['onecikan'] == 1) {echo "checked";} ?> name="onecikan" value="1" class="minimal" style="position: absolute; opacity: 0;">
							</div>
							Öne Çıkan İlanlar
						</label>
					</div>  
				</div>
			</div>
			<?php endif; ?> 
			<?php if ($proje != "proje") { ?>
			<div class="box">
				<div class="alert alert-warning">
					<strong> Günlük Kiralama Seçenekleri </strong>
				</div>
				<div class="box-body">  
					<div class="col-sm-6">  
						<div class="form-group">
							<label class="control-label">Günlük Kiralama İçin Uygun Mu?</label> 
							<div class="">
								<div class="col-lg-12">
									<label for="ilan_tipi" onclick="formAc1(this);">
										<input type="radio" id="daire_kiralama_ac" name="gunluk_onay" <?php if ($i["gunluk_onay"]==1) { ?> checked <?php } ?> value="1" class="minimal">
										Günlük Kiralama İçin Uygundur
									</label>
									<label for="ilan_tipi" onclick="formKapat1(this);">
										<input type="radio" name="gunluk_onay" <?php if ($i["gunluk_onay"]==0) { ?> checked <?php } ?> value="0" class="minimal">
										Günlük Kiralama İçin Uygun Değildir
									</label> 
								</div> 
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="clearfix" id="daire_kiralama" <?php if ($i["gunluk_onay"]!=1) { ?> style="display:none" <?php } ?>>
    					    <div class="col-sm-3">
    						<div class="form-group"> 
    							<label class="control-label">Günlük Kiralama Periyodu:</label>
    							<input type="text" name="periyot" class="form-control" placeholder="Örn: Gecelik, 1 Gecelik...." value="<?php echo $i["periyot"] ?>">
    						</div>
    					</div>  
    					<div class="clearfix"></div>
    					<div class="col-sm-3">
    						<div class="form-group"> 
    							<label class="control-label">Yetişkin Fiyat:</label>
    							<input type="number" name="yetiskin_fiyat" class="form-control" placeholder="" value="<?php echo $i["yetiskin_fiyat"] ?>">
    						</div>
    					</div>  
    					<div class="col-sm-3">
    						<div class="form-group"> 
    							<label class="control-label">Çocuk Fiyat:</label>
    							<input type="number" name="cocuk_fiyat" class="form-control" placeholder="" value="<?php echo $i["cocuk_fiyat"] ?>">
    						</div>
    					</div>  
    					<div class="col-sm-3">
    						<div class="form-group"> 
    							<label class="control-label">Bebek Fiyat:</label>
    							<input type="number" name="bebek_fiyat" class="form-control" placeholder="" value="<?php echo $i["bebek_fiyat"] ?>">
    						</div>
    					</div>  
    					<div class="col-sm-3">
    						<div class="form-group"> 
    							<label class="control-label">Günlük Fiyat Birim</label>
    							<select name="gunluk_fiyat_birim" class="form-control sel ect2">
    								<option value="<?=$i["gunluk_fiyat_birim"];?>" selected> <?=$i["gunluk_fiyat_birim"];?> </option> 
    								<?php
    									// Para Birimi
    										$parabirim = $vt->query("select * from para_birimi where id");
    										while ($paraver = $parabirim->fetch()) { ?>
    										<option value="<?=$paraver["ad"];?>"> <?=$paraver["ad"];?> </option>
    								<?php } ?>
    							</select>
    						</div>
    					</div>
    					<div class="col-sm-3">
    						<div class="form-group"> 
    							<label class="control-label">Özel Metin Alanı 1 (Zorunlu Değil):</label>
    							<textarea name="ozel_metin_1" class="form-control" placeholder="Örn: 0-3 yaş arası kişi sayısına dahil değildir. Kapasite fazlası kesinlikle kabul edilmemektedir." id="" cols="30" rows="10"><?php echo $i["ozel_metin_1"] ?></textarea>
    						</div>
    					</div>
    					<div class="col-sm-3">
    						<div class="form-group"> 
    							<label class="control-label">Özel Metin Alanı 2 (Zorunlu Değil):</label>
    							<textarea name="ozel_metin_2" class="form-control" placeholder="Örn: Rezervasyon tablosunu kullanarak istediğiniz tarihlerdeki fiyatı hesaplayabiliriniz" id="" cols="30" rows="10"><?php echo $i["ozel_metin_2"] ?></textarea>
    						</div>
    					</div>
    					<div class="col-sm-3">
    						<div class="form-group"> 
    							<label class="control-label">Özel Metin Alanı 3 (Zorunlu Değil):</label>
    							<textarea name="ozel_metin_3" class="form-control" placeholder="Örn: Yapmış olduğunuz ön rezervasyonunuz, sizden önce ve ya sonra yapılan rezervasyona dikkat edilerek alınması uygundur. Tarihler arasında boşluk olması durumunda rezervasyonunuz onaylanmayacaktır. Onay belgeniz gönderildiği taktirde rezervasyonunuz onaylanmış olacaktır." id="" cols="30" rows="10"><?php echo $i["ozel_metin_3"] ?></textarea>
    						</div>
    					</div>
					</div>
				</div> 
			</div>
			<?php } ?> 
			<div class="box">	
                <div class="box-header with-border">
                    <h4 class="text-center p-0 m-0" style="padding: 0; font-weight: 400; margin: 0;">İlan Şifreleme Seçenekleri</h4>
                    <div class="pull-right box-tools">
                        <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="alert alert-primary text-center">
                    <h4 style="font-weight: 500; padding: 0; margin: 0; font-size: 15px;">Bu seçenek aktif ediliğinde ilanlarınız sadece şifreyi bilenler tarafından görüntülenecektir.</h4>
                </div>  
                <div class="box-body">  
                    <div class="col-sm-6">  
                        <div class="form-group">
                            <label class="control-label">İlanı Şifrele</label> 
                            <div class="">
                                <div class="col-lg-12">
                                    <label for="sifreli" onclick="sifreAc(this);">
                                        <input type="radio" name="sifreli" <?php if ($i["sifreli"]==1) { ?> checked <?php } ?> value="1" class="minimal">
                                        Şifreli
                                    </label>
                                    <label for="sifreli" onclick="sifreKapat(this);">
                                        <input type="radio" name="sifreli"  <?php if ($i["sifreli"]==0) { ?> checked <?php } ?>  value="0" class="minimal">
                                        Şifresiz
                                    </label>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="clearfix"></div>
                    <div class="clearfix" id="sifreGoster" <?php if ($i["sifreli"]!=1) { ?> style="display:none" <?php } ?>>
                        <div class="col-sm-3">
                            <div class="form-group"> 
                                <label class="control-label">Şifre Giriniz:</label>
                                <input type="text" name="ilan_sifre" class="form-control" placeholder="" value="<?php echo $i["ilan_sifre"] ?>">
                            </div>
                        </div>   
                    </div> 
                </div>		
				<div class="alert alert-warning">
					<strong> İl / İlçe Seçimleri ve Harita Bilgileri </strong>
				</div>
				<div class="box-body">
					<div class="form-horizontal">
						<div class="form-group">
						  <div class="col-sm-12">
							  <div class="row">
								<div class="col-sm-4">
                                            <label class="control-label">İl:</label>
									<select name="il" id="il" class="form-control select2">
										<?php
											$illersec = $vt->query("select * from sehir where sehir_key = '$i[il]'");
											$ilsec=$illersec->fetch();
											if ($ilsec["sehir_key"]==$i["il"]) {
												echo '<option value="'.$ilsec["sehir_key"].'" selected="selected">'.$ilsec["adi"].'</option>';
											} else {
										?>
										<option selected> İL SEÇİNİZ </option>
										<?php } ?>
										<?php
											$iller = $vt->query("select * from sehir order by sehir_key asc");
											while($il=$iller->fetch()) {
										?>
											<option value="<?=$il['sehir_key'];?>"> <?=$il['adi'];?> </option>
										<?php } ?>
									</select>
								  </div>
								  <div class="col-sm-4">
                                            <label class="control-label">İlçe:</label>
									<select name="ilce" id="ilce" class="form-control select2">
										<?php
											$ilcelersec = $vt->query("select * from ilce where ilce_key = '$i[ilce]'");
											$ilcesec=$ilcelersec->fetch();
											if ($ilcesec["ilce_key"]==$i["ilce"]) {
												echo '<option value="'.$ilcesec["ilce_key"].'" selected="selected">'.$ilcesec["ilce_title"].'</option>';
											} else {
										?>
										<option selected="selected"> İLÇE SEÇİNİZ </option>
										<?php } ?>
										<?php
											$ilceler = $vt->query("SELECT * FROM ilce where ilce_sehirkey = '$i[il]'");
											while($ilce=$ilceler->fetch()) {
												echo '<option value="'.$ilce["ilce_key"].'">'.$ilce["ilce_title"].'</option>';
											}
										?>
									</select>
								  </div>
                                    <div class="col-md-4">
										<label class="control-label">Mahalle:</label>
										<div class="row">
											<div class="col-sm-12">
												<select name="mahalle" id="mahalle" class="form-control select2">
													<?php
														$mahallelersec = $vt->query("select * from mahalle where mahalle_id = '$i[mahalle]'");
														$mahallesec=$mahallelersec->fetch();
														if ($mahallesec["mahalle_id"]==$i["mahalle"]) {
															echo '<option value="'.$mahallesec["mahalle_id"].'" selected="selected">'.$mahallesec["mahalle_title"].'</option>';
														} else {
													?>
													<option selected="selected"> MAHALLE SEÇİNİZ </option>
													<?php } ?>
													<?php
														$mahalleler = $vt->query("SELECT * FROM mahalle where mahalle_ilcekey = '$ilcesec[ilce_key]'");
														while($mahalle=$mahalleler->fetch()) {
															echo '<option value="'.$mahalle["mahalle_id"].'">'.$mahalle["mahalle_title"].'</option>';
														}
													?>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
					  		<script type="text/javascript">
								$(document).ready(function(){
								  	$("#il").change(function(){
								    	var ilid = $(this).val();
								    	$.ajax({
								    		type:"POST",
								    		url:"ajax_harita.php",
								    		data:{"il":ilid},
								    		success:function(e){
								    			$("#ilce").html(e);
								    		}
								    	});
								  	});
								  	$("#ilce").change(function(){
								    	var ilceid = $(this).val();
								    	$.ajax({
								    		type:"POST",
								    		url:"ajax_harita.php",
								    		data:{"ilce":ilceid},
								    		success:function(e){
								    			$("#mahalle").html(e);
								    		}
								    	});
								  	});
								});
						  </script>
						</div>
						<div class="form-group">
						  <div class="col-sm-12">
						  	<label class="control-label">Sokak Adresi:</label>
							<textarea class="form-control" id="adres" name="adres" rows="8" cols="80"><?=$i["adres"];?></textarea>
						  </div>
						</div> 
						<div class="form-group"id="haritaDiv">
							<div class="alert alert-warning fade in">
								<i class="icon-remove close" data-dismiss="alert"></i>
								Harita üzerinde lokasyonu tespit ederek, tıklayınız
							</div>
							<div id="map"></div> 
                            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPuyfS_blXebQaLwwiV2TiwqEr-t1B12c&callback=initMap&v=weekly" defer></script> 
                            <style>
                                #map {
                                    height: 600px;
                                }
                            </style>
                            <script type="text/javascript">
                                function initMap() {
                                  const myLatlng = { lat: <?=$i["enlem"];?>, lng: <?=$i["boylam"];?> };
                                  const map = new google.maps.Map(document.getElementById("map"), {
                                    zoom: <?=$i["zoom"];?>,
                                    center: myLatlng,
                                  }); 
                                  let marker = new google.maps.Marker({
                                        map,
                                        draggable: true,
                                        position: { lat: <?=$i["enlem"];?>, lng: <?=$i["boylam"];?> },
                                  }); 
                                  
        // Haritaya tıklama olayını dinle
        map.addListener('click', function(event) {
            // Tıklanan konumu marker'a taşı
            marker.setPosition(event.latLng);
            updateFormFields();
        });

        // Form verilerini güncelle
        function updateFormFields() {
        document.getElementById('enlem').value = marker.getPosition().lat();
        document.getElementById('boylam').value = marker.getPosition().lng();
        document.getElementById('zoom').value = map.getZoom();
        }
                                  marker.addListener("mouseup", (mapsMouseEvent) => {
                                    const pozisyon = mapsMouseEvent.latLng;    
                                    $('#enlem').val(pozisyon.lat);
                                    $('#boylam').val(pozisyon.lng); 
                                    $('#zoom').val(map.getZoom());  
                                  });
								  $("#il").change(function () {
                                            var city = $("#il option:selected").text();
                                            var geocoder = new google.maps.Geocoder();
                                            geocoder.geocode({
                                            'address': city + " Türkiye"
                                            }, function (results, status) {
                                            if (status == google.maps.GeocoderStatus.OK) {
                                                map.setCenter(results[0].geometry.location);
                                                map.setZoom(10);
                                            }
                                            });
                                        });
                                        $("#ilce").change(function () {
                                            var city = $("#il option:selected").text();
                                            var district = $("#ilce option:selected").text();
                                            var geocoder = new google.maps.Geocoder();
                                            geocoder.geocode({
                                            'address': city + " " + district + " Türkiye"
                                            }, function (results, status) {
                                            if (status == google.maps.GeocoderStatus.OK) {
                                                map.setCenter(results[0].geometry.location);
                                                map.setZoom(12);
                                            }
                                            });
                                        });
                                        $("#mahalle").change(function () {
                                            var city = $("#il option:selected").text();
                                            var district = $("#ilce option:selected").text();
                                            var neighborhood = $("#mahalle option:selected").text();
                                            var geocoder = new google.maps.Geocoder();
                                            geocoder.geocode({
                                            'address': city + " " + district + " " + neighborhood + " Türkiye"
                                            }, function (results, status) {
                                            if (status == google.maps.GeocoderStatus.OK) {
                                                map.setCenter(results[0].geometry.location);
                                                map.setZoom(14);
                                            }
                                            });
                                        });
                                }
                                window.initMap = initMap;
                            </script> 
						</div>
						<div class="form-group">
						  <div class="col-sm-12">
						  	<label class="control-label">Enlem Kodu:</label>
							<input type="text" class="form-control" id="enlem" name="enlem" value="<?=$i["enlem"];?>" required>
						  </div>
						</div>
						<div class="form-group">
						  <div class="col-sm-12">
						  	<label class="control-label">Boylam Kodu:</label>
							<input type="text" class="form-control" id="boylam" name="boylam" value="<?=$i["boylam"];?>" required>
						  </div>
						</div>
						<div class="form-group">
						  <div class="col-sm-12">
						  	<label class="control-label">Zoom (Yakınlık):</label>
							<input type="text" class="form-control" id="zoom" name="zoom" value="<?=$i["zoom"];?>" required>
						  </div>
						</div>
						<div class="form-group">
						  <div class="col-sm-12">
						  	<label class="control-label">Sokak Görüntüsü Kodu Ekleyin:</label>
							 <textarea id="sokak" name="sokak"><?=$i["sokak"];?></textarea>
							 <br>
							 <div class="row">
								<?php if (yetki() == 0): ?>
								<div class="col-md-12 col-xs-12">
								<?php else: ?>
								<div class="col-md-3 col-xs-12">
								<?php endif; ?>
									<a class="btn btn-default btn-block" target="_blank" href="https://www.google.com/maps"><i class="fa fa-send"></i> Kod Almak İçin Tıklayınız</a>
								</div>
								<?php if (yetki() == 0): ?>
								<div class="col-md-12 col-xs-12">
								<?php else: ?>
								<div class="col-md-3 col-xs-12">
								<?php endif; ?>
									<a href="#" data-toggle="modal" data-target="#sokak-ekleme" title="Sokak Nasıl Eklenir?" class="btn btn-default btn-block">
										<i class="fa fa-street-view fa-lg"></i> Sokak Kodu Nasıl Eklenir
									</a>								 			 		
								</div>
							 </div>						 
							 <div class="modal modal-default fade" id="sokak-ekleme" style="display: none;">
								  <div class="modal-dialog">
									<div class="modal-content">
									  <div class="modal-header alert alert-info">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										  <span aria-hidden="true">×</span></button>
										<h4 class="modal-title"><i class="fa fa-street-view"></i> Sokak Kodu Nasıl Eklenir?</h4>
									  </div>
									  <div class="modal-body">
										  <h3><strong>Sokak Görüntüsü Nasıl Eklenir?</strong></h3>
										  <p>- Editörün altında bulundan butona tıklayınız.</p>
										  <p>- Açılan pencerece solda bulunan arama kutusuna adresi yazınız.</p>
										  <p>- Bulunan sonuçlarda sol kenarda 360 ikonu bulunan sokak görünüm resimleri çıkacaktır.</p>
										  <p>- İlanınıza en yakın sokağın görüntüsüne tıklayınız.</p>
										  <p>- Ekranın sol üzerinde çıkan adres başlığındaki üç noktaya tıklayınız.</p>
										  <p>- <strong>"Paylaşın veya resim yerleştirin"</strong> yazan bağlantıya tıklayınız.</p>
										  <p>- Harita yerleştirme bölümünde açılan html kodu kopyalayınız.</p>
										  <p>- Kodu buradaki editörün kod görünümüne ekleyiniz.</p>
										  <p class="alert alert-success">Eğer yardım almak isterseniz. Lütfen yazılım ekibiyle iletişe geçiniz.</p>
										  <a class="btn btn-default" target="_blank" href="https://www.google.com/maps"><i class="fa fa-send"></i> Kod Almak İçin Tıklayınız</a>
									  </div>
									  <div class="modal-footer">
										<a href="#" class="btn btn-default" data-dismiss="modal"> Kapat </a>
									  </div>
									</div>
								  </div>
								</div>
						  </div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<?php if (yetki() == 0): ?>
				<div class="col-md-12">
				<?php else: ?>
					<div class="col-md-offset-9 col-md-3">				
				<?php endif; ?> 
						<button type="submit" class="btn btn-primary btn-block btn-lg" name="emlakduzenle"> <i class="fa fa-save"></i> <strong>İLANI GÜNCELLE</strong> </button>
					</div>
				</div> 
			</div>
		</div>
</form>
<?php else: ?>
<div class="box">
	<div class="box-body">
		<div class="alert alert-danger text-center">
			<h5> <i class="fa fa-warning fa-3x"></i> </h5>
			<h4>Hata(!) Başkasına ait bir ilana müdahele etmeye çalışıyorsunuz.</h4>
			<h5> Lütfen geri dönün ve kendi ilanlarınızı düzenelemeye çalışın. </h5>
			<a href="index.php?do=islem&amp;emlak=emlak_ilanlar" class="btn btn-primary btn-lg"> <i class="fa fa-arrow-left"></i> Geri Dön </a>
			<br>
			<br>		
		</div>
	</div>
</div>
<?php endif; ?>
<?php } ?>
</section> 
<script>
	$(function() {
    	$('textarea#edit').froalaEditor({
		  language: 'tr',
		   toolbarButtons: ['insertVideo','html'],
		   heightMin: 200
		});
  	});
	$(function() {
    	$('textarea#sokak').froalaEditor({
		  language: 'tr',
		   toolbarButtons: ['html'],
		   heightMin: 250
		});
  	});
</script>