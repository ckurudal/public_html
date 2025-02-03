<?php
echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
// emlak numarasi uret
$sayiuret = mysql_query("select * from emlak_islem order by islemno desc limit 1");
$emlaknouret = mysql_fetch_array($sayiuret);
$islemno = $emlaknouret["islemno"]+1;
$emlaknokaydet = mysql_query("update emlak_islem set islemno ='$islemno'");
$id=$_GET["id"];
$kategori=$_GET["kategori"];
$query = mysql_query("SELECT * FROM emlak_kategori WHERE kat_id = '$kategori'");
$q=mysql_fetch_array($query);
$kullanici = $vt->query("SELECT * FROM yonetici WHERE id = '".$_SESSION["id"]."'")->fetch(PDO::FETCH_ASSOC);
if ($_GET["islem"] != "sec"):
$ilan_sekli = $vt->query("SELECT * FROM emlak_ilansekli WHERE id = {$q["ilansekli"]}")->fetch();
$proje = $ilan_sekli["kat_tipi"];
endif;
if(!function_exists('fast_encrypt_decrypt')) {
    function fast_encrypt_decrypt($action, $string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret = 'fastphpdevemlakbudur';
        $secret = substr(hash('sha256', $secret), 0, 32);
        $iv = substr(hash('sha256', 'fastphpdevemlakbuduriv'), 0, 16);
        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $secret, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $secret, 0, $iv);
        }
        return $output;
    }
}
?>
<form method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="emlaknoenc" value="<?=fast_encrypt_decrypt('encrypt', $islemno+1);?>">
<?php
$islem=$_GET["islem"];
if ($islem=="sec") {
    ?>
    <section class="content">
        <div class="alert alert-primary alert-dismissible" style="margin-bottom: 10px; padding: 5px 15px;">
            <h5>
                <strong>Emlak veri alanları burada seçeceğiniz kategoriye göre listelenecektir.</strong>
            </h5>
        </div>
        <div class="">
            <!-- /.box-header -->
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-2">
                            <h5><i class="fa fa-angle-down pull-right"></i><strong>Emlak Şekli Seçiniz</strong></h5>
                            <hr>
                            <select multiple name="kat" id="kat" class="form-control" size="12" style="padding:15px; background-color: #e5f0ff; border: 1px solid #b9d6ff;">
                                <?php
                                $katler=mysql_query("SELECT * FROM emlak_kategori where kat_ustid = 0");
                                while ($k=mysql_fetch_array($katler)) {
                                ?>
                                <option value="<?=$k["kat_id"];?>"><?=$k["kat_adi"];?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div id="altkat">
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#kat").change(function(){
                            var katid = $(this).val();
                            $.ajax({
                                type:"POST",
                                url:"ajax_kategori/ajax_kategori_1.php",
                                data:{"kat":katid},
                                success:function(e){
                                    $("#altkat").html(e);
                                }
                            });
                        }); 
                    });
                </script>
                <div class="row">
                    <style>
                        .thumbnail {
                            text-align: inherit;
                        }
                        a.thumbnail:hover {
                            background: #fff !important;
                        }
                    </style>
                    <ul class="nav navbar hidden" style="margin:0 12px;">
                        <?php
                        $katler=mysql_query("SELECT * FROM emlak_kategori order by kat_ustid = 0 DESC");
                        while ($k=mysql_fetch_array($katler)) {
                            ?>
                            <li class="<?php if ($kullanici["yetki"] != 0) { ?> col-md-3 <?php } else { ?> col-md-2 <?php } ?> <?php if ($k["kat_durum"] == 0 ) {echo "hidden";} ?>" style="padding:0 2px;">
                                <a class="btn bg-primary text-left" href="index.php?do=islem&emlak=emlak_ekle&kategori=<?=$k["kat_id"];?>">
                                    <?php
                                    if ($k["kat_ustid"]==0) {
                                        ?>
                                        <?=$k["kat_adi"];?> <span style="color: #bbb;"> Ana Kategori</span>
                                    <?php } else { ?>
                                        <?=$k["kat_adi"];?>
                                    <?php } ?>
                                    <i class="fa fa-arrow-right pull-right"></i>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div> 
            </div>
    </section>
<?php } ?>
<?php
if (isset($_POST["emlakekle"]))
{
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
    // BASLADI - PROJE KAT PLANI
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
    // BITTI - PROJE KAT PLANI
    // BASLADI - ILAN EKLEME ALANI
    $il_adi = $vt->query("SELECT * FROM sehir WHERE sehir_key = '".$_POST["il"]."'")->fetch();
    $ilce_adi = $vt->query("SELECT * FROM ilce WHERE ilce_key = '".$_POST["ilce"]."'")->fetch();
    $ilantipi_adi = $vt->query("SELECT * FROM emlak_ilantipi WHERE id = '".$_POST["emlak_tipi"]."'")->fetch();
    // duzce-satilik-konut-daire/3+1-villa
    $yonetici_id=$_SESSION["id"];
    $baslik = tirnak($_POST["baslik"]);
    $referans_kodu = $_POST["referans_kodu"];
    $seo=seo($il_adi["adi"])."-".seo($ilce_adi["ilce_title"])."-".seo($ilantipi_adi["ad"])."-".seo($q["kat_adi"])."-".seo($_POST["baslik"]);
    $icerik= addslashes($_POST["icerik"]);
    $katid=$_POST["katid"];	// query ile seçilen kategoriye gore otomatik eklenecektir.
    $ilansekli=mysql_query("SELECT * FROM emlak_kategori where kat_id='$q[kat_id]'"); // ilan sekli buradan eklenecektir.
    $i=mysql_fetch_array($ilansekli); // ilan sekli buradan eklenecektir.
    $title=addslashes($_POST["title"]);
    $godesc=addslashes($_POST["godesc"]);
    $keyw=addslashes($_POST["keyw"]);
    $aciklama=addslashes($_POST["aciklama"]);
    $emlakno=$_POST["emlakno"]; // islem no olarak eklenmektedir.
    $emlaknoenc=$_POST["emlaknoenc"];
    $emlaknodec=fast_encrypt_decrypt('decrypt', $emlaknoenc);
    if ($emlaknodec && is_numeric($emlaknodec)) {
        $emlakno = $emlaknodec;
    } else {
        $emlakno = $islemno;
    }
    $eklemetarihi = date("d-m-Y");
    $emlak_sahibi=$_POST["emlak_sahibi"];
    $ilantipi=$_POST["emlak_tipi"];
    $ilantipi=mysql_query("SELECT * FROM emlak_ilantipi where id = '$ilantipi'");
    $it=mysql_fetch_array($ilantipi);
    $fiyat = $_POST["fiyat"];
    if (empty($fiyat)) $fiyat = 0;
    $fiyatkur=$_POST["fiyatkur"];
    $il=$_POST["il"];
    $ilce=$_POST["ilce"];
    $mahalle=$_POST["mahalle"];
    $adres=$_POST["adres"];
    $enlem=$_POST["enlem"];
    $boylam=$_POST["boylam"];
    $zoom=$_POST["zoom"];
    $sokak=$_POST["sokak"];
    // yayinlama secenekleri
    $anavitrin=$_POST["anavitrin"];
    $katvitrin=$_POST["katvitrin"];
    $firsatvitrin=$_POST["firsatvitrin"];
    $slidervitrin=$_POST["slidervitrin"];
    $onecikan=$_POST["onecikan"];
    $acil=$_POST["acil"];
    $video=$_POST["video"];
    $sifreli			= $_POST["sifreli"];
    if($sifreli==0) {
        $ilan_sifre = "";
    } else {
        $ilan_sifre	= $_POST["ilan_sifre"];
    }  
    $gunluk_onay			= $_POST["gunluk_onay"];
    $periyot			= $_POST["periyot"];
    $yetiskin_fiyat			= $_POST["yetiskin_fiyat"];
    $cocuk_fiyat			= $_POST["cocuk_fiyat"];
    $bebek_fiyat			= $_POST["bebek_fiyat"];
    $ozel_metin_1			= $_POST["ozel_metin_1"];
    $ozel_metin_2			= $_POST["ozel_metin_2"];
    $ozel_metin_3			= $_POST["ozel_metin_3"];
    $gunluk_fiyat_birim			= $_POST["gunluk_fiyat_birim"];
    $yoneticibilgigoster = mysql_query("SELECT * FROM yonetici where id = '".$_SESSION['id']."'");
    $yoneticigoster = mysql_fetch_array($yoneticibilgigoster);
    if ($_SESSION["yetki"] == 0) {
        $onay = 1;
    } else {
        $onay = 0;
    }
    if ($yoneticigoster["yetki"] == 0) {
        $ekle = mysql_query("INSERT INTO emlak_ilan (
            baslik,
            referans_kodu,
            sifreli,
            ilan_sifre,
            eklemetarihi,  
            emlak_sahibi,  
            onay, 
            seo, 
            yonetici_id, 
            icerik, 
            katid, 
            ilansekli, 
            title, 
            godesc, 
            keyw, 
            aciklama, 
            emlakno, 
            ilantipi, 
            fiyat, 
            fiyatkur, 
            il, 
            ilce, 
            mahalle, 
            adres, 
            anavitrin, 
            katvitrin, 
            firsatvitrin, 
            slidervitrin, 
            onecikan, 
            acil, 
            video, 
            gunluk_onay,
            periyot,
            yetiskin_fiyat,
            cocuk_fiyat,
            bebek_fiyat,
            ozel_metin_1,
            ozel_metin_2,
            ozel_metin_3,
            gunluk_fiyat_birim, 
            enlem, 
            boylam, 
            zoom, 
            sokak
            ) VALUES ( 
            '$baslik', 
            '$referans_kodu', 
            '$sifreli', 
            '$ilan_sifre', 
            '$eklemetarihi', 
            '$emlak_sahibi', 
            '1', 
            '$seo', 
            '$yonetici_id', 
            '$icerik', 
            '$q[kat_id]', 
            '$i[ilansekli]', 
            '$title', 
            '$godesc',
            '$keyw',
            '$aciklama',
            '$emlakno',
            '$it[id]',
            '$fiyat',
            '$fiyatkur',
            '$il',
            '$ilce',
            '$mahalle',
            '$adres',
            '$anavitrin',
            '$katvitrin',
            '$firsatvitrin',
            '$slidervitrin',
            '$onecikan',
            '$acil',
            '$video', 
            '$gunluk_onay',
            '$periyot',
            '$yetiskin_fiyat',
            '$cocuk_fiyat',
            '$bebek_fiyat',
            '$ozel_metin_1',
            '$ozel_metin_2',
            '$ozel_metin_3',
            '$gunluk_fiyat_birim', 
            '$enlem',
            '$boylam',
            '$zoom',
            '$sokak');");
    } else {
        $ekle = mysql_query("INSERT INTO emlak_ilan ( baslik, referans_kodu, sifreli, ilan_sifre, eklemetarihi, seo, yonetici_id, icerik, katid, ilansekli, title, godesc, keyw, aciklama, emlakno, ilantipi, fiyat, fiyatkur, il, ilce, mahalle, adres, anavitrin, katvitrin, firsatvitrin, slidervitrin, onecikan, acil, video, gunluk_onay, periyot, yetiskin_fiyat,cocuk_fiyat, bebek_fiyat, ozel_metin_1, ozel_metin_2, ozel_metin_3, gunluk_fiyat_birim, enlem, boylam, zoom, sokak ) VALUES ( '$baslik', '$referans_kodu', '$sifreli', '$ilan_sifre', '$eklemetarihi', '$seo', '$yonetici_id', '$icerik', '$q[kat_id]', '$i[ilansekli]', '$title', '$godesc', '$keyw', '$aciklama', '$emlakno', '$it[id]', '$fiyat', '$fiyatkur', '$il', '$ilce', '$mahalle', '$adres', '$anavitrin', '$katvitrin', '$firsatvitrin', '$slidervitrin', '$onecikan', '$acil', '$video', '$gunluk_onay', '$periyot', '$yetiskin_fiyat', '$cocuk_fiyat', '$bebek_fiyat', '$ozel_metin_1', '$ozel_metin_2', '$ozel_metin_3', '$gunluk_fiyat_birim', '$enlem', '$boylam', '$zoom', '$sokak');");
    }
    if (empty($baslik))
    {
        // hata_alert("Başlık boş bırakılamaz. Lütfen başlık giriniz.");
    } else {
    }
    if ($ekle) {
        if (isset($_POST["resimsira"]) && is_array($_POST["resimsira"])) {
            $resimsira = $_POST["resimsira"];
            asort($resimsira);
            $ilkResim = true;
            foreach ($resimsira as $key => $value) {
                if (is_numeric($key) && is_numeric($value)) {
                    $vt->query("UPDATE emlak_resim SET sira = '{$value}', kapak = '".($ilkResim ? 1 : 0)."' WHERE id = '{$key}' LIMIT 1");
                    $ilkResim = false;
                }
            }
        }
        $son_eklenen_ilan = $vt->query("SELECT * FROM emlak_ilan WHERE yonetici_id = '".$_SESSION["id"]."' ORDER BY id DESC LIMIT 1")->fetch();
        yonetici_mail_bildir("Yeni ilan girişi yapıldı. Lütfen kontrol ediniz.");
        yonetici_sms_bildir("Yeni ilan girişi yapıldı. Lütfen kontrol ediniz.");
        go("index.php?do=islem&emlak=emlak_ilanlar&hareket=onay",0);
    }
    // BITTI - ILAN EKLEME ALANI
}
?>
<div class="content">
    <!-- PROJE EKLEME ALANI -->
    <?php if ($proje == "proje"): ?> 
    <div class="box">
        <div class="box-header with-border">
            <h4><i class="fa fa-check"></i> Proje Kapak Resmi </h4>
        </div> 
        <div class="box-body">
            <label>Proje Kapak Resmi</label>
            <input type="file" class="form-control" value="" name="proje_kapak">
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h4><i class="fa fa-check"></i> Kat Planları </h4>
        </div> 
        <div class="box-body"> 
            <div class="row">
                <div class="col-lg-10">
                    <div id="plan"> 
                        <div id="ekle" class="row">
                            <div class="col-lg-4">
                                <label>Kat Planı</label>
                                <input type="file" class="form-control" value="" name="plan_resim[]" placeholder="Oda Sayısı">
                            </div>
                            <div class="col-lg-2">
                                <label>Oda Sayısı</label>
                                <input type="text" class="form-control" value="" name="kat_oda[]" placeholder="2+1">
                            </div>
                            <div class="col-lg-2">
                                <label>Kat Sayısı</label>
                                <input type="text" class="form-control" value="" name="kat_sayi[]" placeholder="Örn: Tek Kat">
                            </div>
                            <div class="col-lg-2">
                                <label>Fiyat</label>
                                <input type="number" class="form-control" value="" name="kat_fiyat[]" placeholder="750.000">
                            </div>
                            <div class="col-lg-2">
                                <label>Metrekare</label>
                                <input type="number" class="form-control" value="" name="kat_mkare[]" placeholder="185">
                            </div>
                        </div>  
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
</div>
<?php if ($_GET["kategori"] != ""): ?>
    <?php if (ilanAylikLimit($_SESSION["id"])>aktifIlanlar($_SESSION["id"])): ?>
        <section class="content-header hidden">
            <i class="fa fa-credit-card fa-2x pull-left"></i>
            Yeni İlan Ekle
            <p> <small> İlan Yönetimi </small> </p>
        </section>
        <section class="content">
            <div class="alert alert-default text-center">
                <h5> Veri Alanları <strong> <span class="badge"><?=$q["kat_adi"];?></span> </strong> İlan Şekline Göre Listelenmiştir. </h5>
            </div>
            <br>
            <div class="box">
                <?php if (yetki() != 0): ?>
                    <!-- <h5 class="text-center"> Fotoğraf Ekle </h5> -->
                    <div class="alert alert-warning fade in text-center">
                        <!-- <i class="fa fa-image fa-lg" style="font-size: 25px; margin: 15px 0 20px 0; transform: rotate(20deg);"></i> -->
                        <?php if (m_paket_say($_SESSION["id"]) > 0): ?>
                            <p>İlanınıza <strong><span class="h4"><?php echo m_paket_limit($_SESSION["id"], 'resim_limit'); ?></span></strong> adet fotoğraf ekleyebilirsiniz</p>
                        <?php else: ?>
                            <p>İlanınıza <strong><span class="h4"><?php echo uye_standart_ayar($kullanici["yetki"], "resim_limit"); ?></span></strong> adet fotoğraf ekleyebilirsiniz</p>
                        <?php endif; ?>
                    </div> 
                <?php endif; ?>
            </div>
            <div class="row">
                <div class="<?php if ($kullanici["yetki"] == 0) { ?>col-md-12 <?php } else { ?> col-md-12 <?php } ?>">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4><i class="fa fa-check"></i> İlan Bilgileri </h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body pad" style="">
                            <div class="form-horizontal">
                                <div class="col-sm-6">
                                    <div class="form-group"> 
                                        <label class="control-label">Başlık:</label>
                                        <input type="text" class="form-control" name="baslik">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group"> 
                                        <label class="control-label">Referans No:</label>
                                        <input type="text" class="form-control" name="referans_kodu">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group"> 
                                        <label class="control-label">Fiyat:</label>
                                        <input type="text" name="fiyat" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group"> 
                                        <label class="control-label">Birim</label>
                                        <select name="fiyatkur" class="form-control select2">
                                            <?php
                                            // Para Birimi
                                            $parabirim = mysql_query("select * from para_birimi where id");
                                            while ($paraver = mysql_fetch_array($parabirim)) {
                                                ?>
                                                <option> <?=$paraver["ad"];?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label class="control-label">Açıklama:</label>
                                        <textarea id="editor1" name="icerik" rows="15" cols="80"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="control-label">Google Başlık (Title):</label>
                                        <input type="text" name="title" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label class="control-label">Google Açıklama:</label>
                                        <textarea class="form-control" id="" name="godesc" rows="5" cols="80"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="control-label">Anahtar Kelimeler (Etiket):</label>
                                        <input type="text" name="keyw" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label class="control-label">İlan Notu:</label>
                                        <textarea class="form-control" id="" name="aciklama" rows="5" cols="80"></textarea>
                                        <h6><i class="fa fa-warning"></i> NOT: Bu bölüme yazacaklarınız yalnızca size özel bir bölümdür, yönetim panelinizden sadece siz görüntüleyebilirsiniz.</h6>
                                    </div>
                                </div>
                                <div class="form-group"> 
                                    <!-- Emlak Resim Yukleme -->
                                    <div id="flash_uploader">
                                        <!-- Emlak resim yükleyicisi buradan başlıyor. -->
                                    </div>
                                    <div class="box-body">
                                        <div id="resimgetir">
                                            <!-- Yüklenen resimler ajax ile burada gösterilecektir. -->
                                        </div>
                                        <div id="sil">
                                            <!-- Resim Sil -->
                                        </div>
                                        <!-- ./ Emlak Resim Yukleme -->
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <?php if ($proje != "proje") { ?>
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
                                                <input type="radio" name="gunluk_onay" value="1" class="minimal">
                                                Günlük Kiralama İçin Uygundur
                                            </label>
                                            <label for="ilan_tipi" onclick="formKapat1(this);">
                                                <input type="radio" name="gunluk_onay" checked value="0" class="minimal">
                                                Günlük Kiralama İçin Uygun Değildir
                                            </label>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="clearfix"></div>
                            <div class="clearfix" id="daire_kiralama" style="display:none">
                                <div class="col-sm-3">
                                    <div class="form-group"> 
                                        <label class="control-label">Günlük Kiralama Periyodu:</label>
                                        <input type="text" name="periyot" class="form-control" placeholder="Örn: Gecelik, 1 Gecelik....">
                                    </div>
                                </div>  
                                <div class="clearfix"></div>
                                <div class="col-sm-3">
                                    <div class="form-group"> 
                                        <label class="control-label">Yetişkin Fiyat:</label>
                                        <input type="number" name="yetiskin_fiyat" class="form-control" placeholder="">
                                    </div>
                                </div>  
                                <div class="col-sm-3">
                                    <div class="form-group"> 
                                        <label class="control-label">Çocuk Fiyat:</label>
                                        <input type="number" name="cocuk_fiyat" class="form-control" placeholder="">
                                    </div>
                                </div>  
                                <div class="col-sm-3">
                                    <div class="form-group"> 
                                        <label class="control-label">Bebek Fiyat:</label>
                                        <input type="number" name="bebek_fiyat" class="form-control" placeholder="">
                                    </div>
                                </div>  
                                <div class="col-sm-3">
                                    <div class="form-group"> 
                                        <label class="control-label">Günlük Fiyat Birim</label>
                                        <select name="gunluk_fiyat_birim" class="form-control sele ct2"> 
                                            <?php
                                                // Para Birimi
                                                    $parabirim = mysql_query("select * from para_birimi where id");
                                                    while ($paraver = mysql_fetch_array($parabirim)) { ?>
                                                    <option value="<?=$paraver["ad"];?>"> <?=$paraver["ad"];?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group"> 
                                        <label class="control-label">Özel Metin Alanı 1 (Zorunlu Değil):</label>
                                        <textarea name="ozel_metin_1" class="form-control" placeholder="Örn: 0-3 yaş arası kişi sayısına dahil değildir. Kapasite fazlası kesinlikle kabul edilmemektedir." id="" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group"> 
                                        <label class="control-label">Özel Metin Alanı 2 (Zorunlu Değil):</label>
                                        <textarea name="ozel_metin_2" class="form-control" placeholder="Örn: Rezervasyon tablosunu kullanarak istediğiniz tarihlerdeki fiyatı hesaplayabiliriniz" id="" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group"> 
                                        <label class="control-label">Özel Metin Alanı 3 (Zorunlu Değil):</label>
                                        <textarea name="ozel_metin_3" class="form-control" placeholder="Örn: Yapmış olduğunuz ön rezervasyonunuz, sizden önce ve ya sonra yapılan rezervasyona dikkat edilerek alınması uygundur. Tarihler arasında boşluk olması durumunda rezervasyonunuz onaylanmayacaktır. Onay belgeniz gönderildiği taktirde rezervasyonunuz onaylanmış olacaktır." id="" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                            </div> 
                        </div> 
                        <?php } ?>
                        <div class="box-header with-border">
                            <h5 class="text-center"> İlan Detayları </h5>
                            <div class="pull-right box-tools">
                                <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <?php
                        // emlak formu ekleme alani
                        if (isset($_POST["emlakekle"])) {
                            $eformdetay=$_POST["eformdetay"];
                            $formid=$_POST["formid"];
                            for ($i=0; $i<count($eformdetay);$i++){
                                $ilanid=mysql_query("SELECT * FROM emlak_ilan order by id desc");
                                $i2=mysql_fetch_array($ilanid);
                                if (!empty($eformdetay[$i]) AND $eformdetay[$i]!="Seçiniz") {
                                $ekle=mysql_query("INSERT INTO emlak_ilandetay (eformdetay, seo, formid, ilanid, emlakno, ilansekli) values ('".$eformdetay[$i]."','".seo($eformdetay[$i])."','".$formid[$i]."','$i2[id]','$islemno','$i2[ilansekli]')");
                                }
                            }
                        }
                        ?>
                        <div class="box-body pad">
                            <div class="">
								<div class="form-horizontal">
									<?php
									$formkat=mysql_query("SELECT emlak_form_kat.* FROM emlak_form_kat INNER JOIN emlak_form ON emlak_form_kat.eformid=emlak_form.id where emlak_form_kat.kat = '$kategori' ORDER BY emlak_form.sira ASC");
									while ($f=mysql_fetch_array($formkat)) {
										// Emlak Form
										$eform = mysql_query("select * from emlak_form where id = '$f[eformid]'");
										$formrow = mysql_fetch_array($eform);
										$deg = trim($formrow[deg]);
										$ayir = explode(",", $deg);
										$say = trim(count($ayir));
										?>
										<div class="col-lg-3 <?php if ($formrow[durum] == 1) { echo "hidden";}?>">
											<label class="control-lab el" name="test"><h5><strong><?=$formrow["ad"]?>:</strong></h5></label>
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
									<?php } ?>
								</div>
                            </div>
                        </div>
                        <div class="box-header with-border">
                            <h5 class="text-center">İlan Özellikleri </h5>
                        </div>
                        <div class="box-body pad">
                            <div class="form-horizontal">
                                <?php
                                // emlak ozellik ekleme alani
                                if (isset($_POST["emlakekle"])) {
                                    $ozid=$_POST["ozid"];
                                    $oztip=$_POST["oztip"];
                                    if (!$_POST["ozid"]=="") {
                                        foreach ($ozid as $oid) {
                                            $liste=mysql_query("SELECT * FROM emlak_ozellik where id = '$oid'");
                                            while ($l=mysql_fetch_array($liste)) {
                                                $ilanid=mysql_query("SELECT * FROM emlak_ilan order by id desc");
                                                $i=mysql_fetch_array($ilanid);
                                                $ekle=mysql_query("INSERT INTO emlak_ozellikdetay (ozelliktip, ad, ilanid, ilansekli, ozellik) values ('$l[ozelliktipi]','$l[ad]','$i[id]','$q[ilansekli]','$l[id]')");
                                            }
                                        }
                                    }
                                }
                                ?>
                                <?php
                                $ozelliktipliste2 = mysql_query("SELECT * FROM emlak_ozelliktipliste where kat = '$q[kat_id]'");
                                while ($ot2=mysql_fetch_array($ozelliktipliste2)) {
                                    // Emlak Ozellik Tipi
                                    $ozelliktip = mysql_query("SELECT * FROM emlak_ozelliktip where id = '$ot2[ozellikid]'");
                                    $ot = mysql_fetch_array($ozelliktip);
                                    ?>
                                    <div class="form-group" <?php if ($ot["durum"]==1) {echo "hidden";} ?>>
                                        <input type="text" name="oztip[]" value="<?=$ot['id']?>" class="hidden">
                                        <div class="col-sm-12">
                                            <h5><strong><i class="fa fa-arrow-right"></i> <?=$ot["ad"];?>:</strong></h5>
                                            <div class="row">
                                                <?php
                                                // Emlak Ozellikleri
                                                $ozellik = mysql_query("select * from emlak_ozellik where ozelliktipi = '$ot[id]'");
                                                while ($o = mysql_fetch_array($ozellik)) {
                                                    ?>
                                                    <div class="col-md-3 col-xs-6" <?php if ($o["durum"]==1) {echo "hidden";} ?>>
                                                        <label for="ozad" class="">
                                                            <div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                                                                <input type="checkbox" name="ozid[]" value="<?=$o['id'];?>" class="minimal">
                                                            </div>
                                                            <?=$o["ad"];?>
                                                        </label>
                                                    </div>
                                                <?php } ?>
                                                <br>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="box-header with-border">
                            <h4><i class="fa fa-check"></i> Video </h3>
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
                                    <textarea id="edit" name="video" placeholder="Video ekleyin"></textarea>
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
                        <div class="box-body pad">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label class="control-label">Emlak No:</label>
                                        <input type="text" name="emlakno" disabled class="form-control" value="<?=$islemno+1;?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label class="control-label">Emlak Sahibi:</label>
                                        <select name="emlak_sahibi" class="form-control select2">
                                            <option value="" selected> Emlak Sahibi </option>
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
                                        <h6>İlan Tipi:</h5>
                                            <div>
                                                <?php
                                                // Emlak Tipi
                                                $emlaktip = mysql_query("select * from emlak_ilantipi where id");
                                                while ($t = mysql_fetch_array($emlaktip)) {
                                                    $tipkatliste = mysql_query("SELECT * FROM emlak_ilantipi_katliste where katid = '".$q["kat_id"]."' && ilantipid = '".$t["id"]."'");
                                                    ?>
                                                    <?php if ($t["durum"]=="0") { ?>
                                                        <?php if (mysql_num_rows($tipkatliste)) { ?>
                                                            <label for="ilan_tipi">
                                                                <input type="radio" name="emlak_tipi" value="<?=$t["id"];?>" class="minimal">
                                                                <?=$t["ad"];?>
                                                            </label>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(yetki() == 0): ?>
                    <div class="box">
                        <div class="alert alert-warning">
                            <strong> Bu İlanın Nerede Görüntüleneceğini Seçiniz </strong>
                        </div>
                        <div class="box-body pad" style="">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <h6> Yayınlama Seçenekleri:</h6>
                                        <div>
                                            <div class="form-group"> 
                                                <label for="anavitrin" class="">
                                                    <div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                                                        <input type="checkbox" name="anavitrin" value="1" class="minimal" style="position: absolute; opacity: 0;">
                                                    </div>
                                                    Anasayfa Vitrini
                                                </label>
                                                <label for="firsatvitrin" class="">
                                                    <div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                                                        <input type="checkbox" name="firsatvitrin" value="1" class="minimal" style="position: absolute; opacity: 0;">
                                                    </div>
                                                    Fırsat Vitrini
                                                </label>
                                                <!--
                                                <label for="slidervitrin" class="">
                                                    <div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                                                        <input type="checkbox" name="slidervitrin" value="1" class="minimal" style="position: absolute; opacity: 0;">
                                                    </div>
                                                    Slider Alanı
                                                </label>
                                                -->
                                                <label for="avitrin" class="">
                                                    <div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                                                        <input type="checkbox" name="acil" value="1" class="minimal" style="position: absolute; opacity: 0;">
                                                    </div>
                                                    Acil İlanlar
                                                </label>
                                                <label for="onecikan" class="">
                                                    <div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                                                        <input type="checkbox" name="onecikan" value="1" class="minimal" style="position: absolute; opacity: 0;">
                                                    </div>
                                                    Öne Çıkan İlanlar
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="box">
                        <div class="alert alert-warning">
                            <strong> İl / İlçe Seçimleri ve Harita Bilgileri </strong>
                        </div>
                        <div class="box-body pad">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label class="control-label">Bölge:</label>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <select name="il" id="il" class="form-control select2">
                                                    <option selected="selected"> İl Seçiniz </option>
                                                    <?php
                                                    $iller = mysql_query("select * from sehir order by sehir_key asc");
                                                    while($il=mysql_fetch_array($iller)) {
                                                        ?>
                                                        <option value="<?=$il['sehir_key'];?>"> <?=$il['adi'];?> </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <select name="ilce" id="ilce" class="form-control select2">
                                                    <option selected="selected"> İlçe Seçiniz </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="control-label">Mahalle:</label>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <select name="mahalle" id="mahalle" class="form-control select2">
                                                    <option selected="selected"> Mahalle Seçiniz </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
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
                                        <textarea class="form-control" id="adres" name="adres" rows="8" cols="80"></textarea>
                                    </div>
                                </div>
                            <div class="form-group">
                                <div class="alert alert-warning fade in">
                                    <i class="icon-remove close" data-dismiss="alert"></i>
                                    Harita üzerinde lokasyonu tespit ederek, tıklayınız<!--editle -->
                                </div>
                                <div id="map"></div> 
                                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA301piyuyufUrduxQlk7H0ji1DfNRJde8&callback=initMap&v=weekly" defer></script>
                                <style>
                                    #map {
                                        height: 600px;
                                    }
                                </style>
                                <script type="text/javascript">
                                    function initMap() {
                                        const myLatlng = { lat: 38.86326047995549, lng: 34.60400390625 };
                                        const map = new google.maps.Map(document.getElementById("map"), {
                                            zoom: 6,
                                            center: myLatlng,
                                        });
                                        let marker = new google.maps.Marker({
                                            map,
                                            draggable: true,
                                            position: { lat: 38.86326047995549, lng: 34.60400390625 },
                                        });


                                        map.addListener('click', function (event) {
                                            marker.setPosition(event.latLng);
                                            updateFormFields();
                                        });

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
                                        <input type="text" class="form-control" id="enlem" name="enlem" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label class="control-label">Boylam Kodu:</label>
                                        <input type="text" class="form-control" id="boylam" name="boylam" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label class="control-label">Zoom (Yakınlık):</label>
                                        <input type="text" class="form-control" id="zoom" name="zoom" value="10" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label class="control-label">Sokak Görüntüsü Kodu Ekleyin:</label>
                                        <textarea id="sokak" name="sokak"></textarea>
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
                                        <label><h4><input class="check-control" type="checkbox" value="" required=""><strong> <a href="#" data-toggle="modal" data-target=".bd-example-modal-lg">İlan verme kuralları</a></strong>'nı Okudum ve Kabul Ediyorum.</h4></label>
                                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                          <div class="modal-dialog modal-lg">
                                            <div class="modal-content"> 
                                              <div class="modal-header">
                                                <h4 class="modal-title" id="myLargeModalLabel">İlan Verme Kuralları</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">×</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                <?php echo $site["ilan_verme_kurallari"] ?>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <br>
                                        <br>
                                        <button type="submit" class="btn btn-primary btn-block btn-lg" name="emlakekle"> <i class="fa fa-save"></i> <strong>EKLE VE DEVAM ET</strong> </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </section>
        <?php else: ?>
            <?php if(yetki() != 0): ?>
                <section class="content">
                    <div class="alert alert-primary text-center">
                        <h5> <i class="fa fa-warning fa-3x"></i> </h5>
                        <h3>Uyarı(!) <br></h3>
                        <h5>Aylık toplam <?php echo aktifIlanlar($_SESSION["id"]); ?> adet ilan liminiti aştınız. Ekleyebilmeniz için üyelik paketi satın almanız gerekmektedir.</h5>
                        <br>
                        <a href="index.php?do=siparisler/siparisler&paket=magaza" class="btn btn-inverse btn-lg"> <i class="fa fa-arrow-left"></i> <strong;> ÜYELİK PAKETLERİ </a>
                        <br>
                        <br>
                    </div>
                </section>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
    <!-- YONETİCİ ILAN EKLEME ALANI -->
    <?php if (yetki()==0): ?>
    <section class="content-header hidden">
    <i class="fa fa-credit-card fa-2x pull-left"></i>
    Yeni İlan Ekle
    <p> <small> İlan Yönetimi </small> </p>
    </section>
    <?php if ($islem != "sec"): ?>
    <section class="content">
        <div class="alert alert-default text-center">
            <h5> Veri Alanları <strong> <span class="badge"><?=$q["kat_adi"];?></span> </strong> İlan Şekline Göre Listelenmiştir. </h5>
        </div>
        <br>
        <div class="box">
            <?php if (yetki() != 0): ?>
                <!-- <h5 class="text-center"> Fotoğraf Ekle </h5> -->
                <div class="alert alert-warning fade in text-center">
                    <!-- <i class="fa fa-image fa-lg" style="font-size: 25px; margin: 15px 0 20px 0; transform: rotate(20deg);"></i> -->
                    <?php if (m_paket_say($_SESSION["id"]) > 0): ?>
                        <p>İlanınıza <strong><span class="h4"><?php echo m_paket_limit($_SESSION["id"], 'resim_limit'); ?></span></strong> adet fotoğraf ekleyebilirsiniz</p>
                    <?php else: ?>
                        <p>İlanınıza <strong><span class="h4"><?php echo uye_standart_ayar($kullanici["yetki"], "resim_limit"); ?></span></strong> adet fotoğraf ekleyebilirsiniz</p>
                    <?php endif; ?>
                </div>
                <br>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="<?php if ($kullanici["yetki"] == 0) { ?>col-md-12 <?php } else { ?> col-md-12 <?php } ?>">
                <div class="box">
                    <div class="box-header with-border">
                        <h4><i class="fa fa-check"></i> İlan Bilgileri </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad" style="">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Başlık:</label>
                                        <input type="text" class="form-control" name="baslik">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group"> 
                                        <label class="control-label">Referans No:</label>
                                        <input type="text" class="form-control" name="referans_kodu">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label class="control-label">Fiyat:</label>
                                        <input type="text" name="fiyat" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label class="control-label">Birim</label>
                                        <select name="fiyatkur" class="form-control select2">
                                            <?php
                                            // Para Birimi
                                            $parabirim = mysql_query("select * from para_birimi where id");
                                            while ($paraver = mysql_fetch_array($parabirim)) {
                                                ?>
                                                <option> <?=$paraver["ad"];?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label class="control-label">Açıklama:</label>
                                    <textarea id="editor1" name="icerik" rows="15" cols="80"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label class="control-label">Google Başlık (Title):</label>
                                    <input type="text" name="title" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label class="control-label">Google Açıklama:</label>
                                    <textarea class="form-control" id="" name="godesc" rows="5" cols="80"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label class="control-label">Anahtar Kelimeler (Etiket):</label>
                                    <input type="text" name="keyw" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label class="control-label">İlan Notu:</label>
                                    <textarea class="form-control" id="" name="aciklama" rows="5" cols="80"></textarea>
                                    <h6><i class="fa fa-warning"></i> NOT: Bu bölüme yazacaklarınız yalnızca size özel bir bölümdür, yönetim panelinizden sadece siz görüntüleyebilirsiniz.</h6>
                                </div>
                            </div>
                            <div class="form-group"> 
                                <!-- Emlak Resim Yukleme -->
                                <div id="flash_uploader">
                                    <!-- Emlak resim yükleyicisi buradan başlıyor. -->
                                </div>
                                <div class="box-body">
                                    <div id="resimgetir">
                                        <!-- Yüklenen resimler ajax ile burada gösterilecektir. -->
                                    </div>
                                    <div id="sil">
                                        <!-- Resim Sil -->
                                    </div>
                                    <!-- ./ Emlak Resim Yukleme -->
                                </div>
                            </div>
                        </div>
                    </div> 
                    <?php if ($proje != "proje") { ?>
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
                                                <input type="radio" name="gunluk_onay" value="1" class="minimal">
                                                Günlük Kiralama İçin Uygundur
                                            </label>
                                            <label for="ilan_tipi" onclick="formKapat1(this);">
                                                <input type="radio" name="gunluk_onay" checked value="0" class="minimal">
                                                Günlük Kiralama İçin Uygun Değildir
                                            </label>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="clearfix"></div>
                            <div class="clearfix" id="daire_kiralama" style="display:none">
                                <div class="col-sm-3">
                                    <div class="form-group"> 
                                        <label class="control-label">Günlük Kiralama Periyodu:</label>
                                        <input type="text" name="periyot" class="form-control" placeholder="Örn: Gecelik, 1 Gecelik....">
                                    </div>
                                </div>  
                                <div class="clearfix"></div>
                                <div class="col-sm-3">
                                    <div class="form-group"> 
                                        <label class="control-label">Yetişkin Fiyat:</label>
                                        <input type="number" name="yetiskin_fiyat" class="form-control" placeholder="">
                                    </div>
                                </div>  
                                <div class="col-sm-3">
                                    <div class="form-group"> 
                                        <label class="control-label">Çocuk Fiyat:</label>
                                        <input type="number" name="cocuk_fiyat" class="form-control" placeholder="">
                                    </div>
                                </div>  
                                <div class="col-sm-3">
                                    <div class="form-group"> 
                                        <label class="control-label">Bebek Fiyat:</label>
                                        <input type="number" name="bebek_fiyat" class="form-control" placeholder="">
                                    </div>
                                </div>  
                                <div class="col-sm-3">
                                    <div class="form-group"> 
                                        <label class="control-label">Günlük Fiyat Birim</label>
                                        <select name="gunluk_fiyat_birim" class="form-control sele ct2"> 
                                            <?php
                                                // Para Birimi
                                                    $parabirim = mysql_query("select * from para_birimi where id");
                                                    while ($paraver = mysql_fetch_array($parabirim)) { ?>
                                                    <option value="<?=$paraver["ad"];?>"> <?=$paraver["ad"];?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group"> 
                                        <label class="control-label">Özel Metin Alanı 1 (Zorunlu Değil):</label>
                                        <textarea name="ozel_metin_1" class="form-control" placeholder="Örn: 0-3 yaş arası kişi sayısına dahil değildir. Kapasite fazlası kesinlikle kabul edilmemektedir." id="" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group"> 
                                        <label class="control-label">Özel Metin Alanı 2 (Zorunlu Değil):</label>
                                        <textarea name="ozel_metin_2" class="form-control" placeholder="Örn: Rezervasyon tablosunu kullanarak istediğiniz tarihlerdeki fiyatı hesaplayabiliriniz" id="" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group"> 
                                        <label class="control-label">Özel Metin Alanı 3 (Zorunlu Değil):</label>
                                        <textarea name="ozel_metin_3" class="form-control" placeholder="Örn: Yapmış olduğunuz ön rezervasyonunuz, sizden önce ve ya sonra yapılan rezervasyona dikkat edilerek alınması uygundur. Tarihler arasında boşluk olması durumunda rezervasyonunuz onaylanmayacaktır. Onay belgeniz gönderildiği taktirde rezervasyonunuz onaylanmış olacaktır." id="" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    <?php } ?>
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
                                            <input type="radio" name="sifreli" value="1" class="minimal">
                                            Şifreli
                                        </label>
                                        <label for="sifreli" onclick="sifreKapat(this);">
                                            <input type="radio" name="sifreli" checked value="0" class="minimal">
                                            Şifresiz
                                        </label>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="clearfix"></div>
                        <div class="clearfix" id="sifreGoster" style="display:none">
                            <div class="col-sm-3">
                                <div class="form-group"> 
                                    <label class="control-label">Şifre Giriniz:</label>
                                    <input type="text" name="ilan_sifre" class="form-control" placeholder="">
                                </div>
                            </div>   
                        </div> 
                    </div>
                    <div class="box-header with-border">
                        <h5 class="text-center"> İlan Detayları </h5>
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <?php
                    // emlak formu ekleme alani
                    if (isset($_POST["emlakekle"])) {
                        $eformdetay=$_POST["eformdetay"];
                        $formid=$_POST["formid"];
                        for ($i=0; $i<count($eformdetay);$i++){
                            $ilanid=mysql_query("SELECT * FROM emlak_ilan order by id desc");
                            $i2=mysql_fetch_array($ilanid);
                            if (!empty($eformdetay[$i]) AND $eformdetay[$i]!="Seçiniz") {
                            $ekle=mysql_query("INSERT INTO emlak_ilandetay (eformdetay, seo, formid, ilanid, emlakno, ilansekli) values ('".$eformdetay[$i]."','".seo($eformdetay[$i])."','".$formid[$i]."','$i2[id]','$islemno','$i2[ilansekli]')");
                            }
                        }
                    }
                    ?>
                    <div class="box-body pad">
                        <div class="form-horizontal">
							<div class="row">
								<?php
								$formkat=mysql_query("SELECT emlak_form_kat.* FROM emlak_form_kat INNER JOIN emlak_form ON emlak_form_kat.eformid=emlak_form.id where emlak_form_kat.kat = '$kategori' ORDER BY emlak_form.sira ASC");
								while ($f=mysql_fetch_array($formkat)) {
									// Emlak Form
									$eform = mysql_query("select * from emlak_form where id = '$f[eformid]'");
									$formrow = mysql_fetch_array($eform);
									$deg = trim($formrow[deg]);
									$ayir = explode(",", $deg);
									$say = trim(count($ayir));
									?>
									<div class="col-md-3 <?php if ($formrow[durum] == 1) { echo "hidden";}?>">
										<label class="control-label" name="test"><h5><strong><?=$formrow["ad"]?>:</strong></h5></label>
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
								<?php } ?>
							</div>
						</div>
                    </div>
                    <div class="box-header with-border">
                        <h5 class="text-center">İlan Özellikleri </h5>
                    </div>
                    <div class="box-body pad">
                        <div class="form-horizontal">
                            <?php
                            // emlak ozellik ekleme alani
                            if (isset($_POST["emlakekle"])) {
                                $ozid=$_POST["ozid"];
                                $oztip=$_POST["oztip"];
                                if (!$_POST["ozid"]=="") {
                                    foreach ($ozid as $oid) {
                                        $liste=mysql_query("SELECT * FROM emlak_ozellik where id = '$oid'");
                                        while ($l=mysql_fetch_array($liste)) {
                                            $ilanid=mysql_query("SELECT * FROM emlak_ilan order by id desc");
                                            $i=mysql_fetch_array($ilanid);
                                            $ekle=mysql_query("INSERT INTO emlak_ozellikdetay (ozelliktip, ad, ilanid, ilansekli, ozellik) values ('$l[ozelliktipi]','$l[ad]','$i[id]','$q[ilansekli]','$l[id]')");
                                        }
                                    }
                                }
                            }
                            ?>
                            <?php
                            $ozelliktipliste2 = mysql_query("SELECT * FROM emlak_ozelliktipliste where kat = '$q[kat_id]'");
                            while ($ot2=mysql_fetch_array($ozelliktipliste2)) {
                                // Emlak Ozellik Tipi
                                $ozelliktip = mysql_query("SELECT * FROM emlak_ozelliktip where id = '$ot2[ozellikid]'");
                                $ot = mysql_fetch_array($ozelliktip);
                                ?>
                                <div class="form-group" <?php if ($ot["durum"]==1) {echo "hidden";} ?>>
                                    <input type="text" name="oztip[]" value="<?=$ot['id']?>" class="hidden">
                                    <div class="col-sm-12">
                                        <h5><strong><i class="fa fa-arrow-right"></i> <?=$ot["ad"];?>:</strong></h5>
                                        <div class="row">
                                            <?php
                                            // Emlak Ozellikleri
                                            $ozellik = mysql_query("select * from emlak_ozellik where ozelliktipi = '$ot[id]'");
                                            while ($o = mysql_fetch_array($ozellik)) {
                                                ?>
                                                <div class="col-md-3 col-xs-6" <?php if ($o["durum"]==1) {echo "hidden";} ?>>
                                                    <label for="ozad" class="">
                                                        <div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                                                            <input type="checkbox" name="ozid[]" value="<?=$o['id'];?>" class="minimal">
                                                        </div>
                                                        <?=$o["ad"];?>
                                                    </label>
                                                </div>
                                            <?php } ?>
                                            <br>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div> 
                    </div>
                    <div class="box-header with-border">
                        <h4><i class="fa fa-check"></i> Video </h3>
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
                                <textarea id="edit" name="video" placeholder="Video ekleyin"></textarea>
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
                    <div class="box-body pad">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label class="control-label">Emlak No:</label>
                                    <input type="text" name="emlakno" disabled class="form-control" value="<?=$islemno+1;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label class="control-label">Emlak Sahibi:</label>
                                    <select name="emlak_sahibi" class="form-control select2">
                                        <option value="" selected> Emlak Sahibi </option>
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
                                    <h6>İlan Tipi:</h5>
                                        <div>
                                            <?php
                                            // Emlak Tipi
                                            $emlaktip = mysql_query("select * from emlak_ilantipi where id");
                                            while ($t = mysql_fetch_array($emlaktip)) {
                                                $tipkatliste = mysql_query("SELECT * FROM emlak_ilantipi_katliste where katid = '".$q["kat_id"]."' && ilantipid = '".$t["id"]."'");
                                                ?>
                                                <?php if ($t["durum"]=="0") { ?>
                                                    <?php if (mysql_num_rows($tipkatliste)) { ?>
                                                        <label for="ilan_tipi">
                                                            <input type="radio" name="emlak_tipi" value="<?=$t["id"];?>" class="minimal">
                                                            <?=$t["ad"];?>
                                                        </label>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(yetki() == 0): ?>
                    <div class="box">
                        <div class="alert alert-warning">
                            <strong> Bu İlanın Nerede Görüntüleneceğini Seçiniz </strong>
                        </div>
                        <div class="box-body pad" style="">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <h6> Yayınlama Seçenekleri:</h6>
                                        <div>
                                            <div class="form-group">
                                                <label for="anavitrin" class="">
                                                    <div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                                                        <input type="checkbox" name="anavitrin" value="1" class="minimal" style="position: absolute; opacity: 0;">
                                                    </div>
                                                    Anasayfa Vitrini
                                                </label>
                                                <label for="firsatvitrin" class="">
                                                    <div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                                                        <input type="checkbox" name="firsatvitrin" value="1" class="minimal" style="position: absolute; opacity: 0;">
                                                    </div>
                                                    Fırsat Vitrini
                                                </label>
                                                <!--
                                                <label for="slidervitrin" class="">
                                                    <div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                                                        <input type="checkbox" name="slidervitrin" value="1" class="minimal" style="position: absolute; opacity: 0;">
                                                    </div>
                                                    Slider Alanı
                                                </label>
                                                -->
                                                <label for="avitrin" class="">
                                                    <div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                                                        <input type="checkbox" name="acil" value="1" class="minimal" style="position: absolute; opacity: 0;">
                                                    </div>
                                                    Acil İlanlar
                                                </label>
                                                <label for="onecikan" class="">
                                                    <div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                                                        <input type="checkbox" name="onecikan" value="1" class="minimal" style="position: absolute; opacity: 0;">
                                                    </div>
                                                    Öne Çıkan İlanlar
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="box">
                    <div class="alert alert-warning">
                        <strong> İl / İlçe Seçimleri ve Harita Bilgileri </strong>
                    </div>
                    <div class="box-body pad">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label">İl:</label>
                                            <select name="il" id="il" class="form-control select2">
                                                <option selected="selected"> İl Seçiniz </option>
                                                <?php
                                                $iller = mysql_query("select * from sehir order by sehir_key asc");
                                                while($il=mysql_fetch_array($iller)) {
                                                    ?>
                                                    <option value="<?=$il['sehir_key'];?>"> <?=$il['adi'];?> </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="control-label">İlçe:</label>
                                            <select name="ilce" id="ilce" class="form-control select2">
                                                <option selected="selected"> İlçe Seçiniz </option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="control-label">Mahalle:</label>
                                            <select name="mahalle" id="mahalle" class="form-control select2">
                                                <option selected="selected"> Mahalle Seçiniz </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
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
                                    <textarea class="form-control" id="adres" name="adres" rows="8" cols="80"></textarea>
                                </div>
                            </div> 
                            <div class="form-group">
                                <div class="alert alert-warning fade in">
                                    <i class="icon-remove close" data-dismiss="alert"></i>
                                    Harita üzerinde lokasyonu tespit ederek, tıklayınız
                                </div>
                                <div id="map"></div> 
                                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA301piyuyufUrduxQlk7H0ji1DfNRJde8&callback=initMap&v=weekly" defer></script> 
                                <style>
                                    #map {
                                        height: 600px;
                                    }
                                </style>
                                <script type="text/javascript">
                                    function initMap() {
                                        const myLatlng = { lat: 38.86326047995549, lng: 34.60400390625 };
                                        const map = new google.maps.Map(document.getElementById("map"), {
                                            zoom: 6,
                                            center: myLatlng,
                                        });
                                        let marker = new google.maps.Marker({
                                            map,
                                            draggable: true,
                                            position: { lat: 38.86326047995549, lng: 34.60400390625 },
                                        });


                                        map.addListener('click', function (event) {
                                            marker.setPosition(event.latLng);
                                            updateFormFields();
                                        });

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
                                    <input type="text" class="form-control" id="enlem" name="enlem" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label class="control-label">Boylam Kodu:</label>
                                    <input type="text" class="form-control" id="boylam" name="boylam" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label class="control-label">Zoom (Yakınlık):</label>
                                    <input type="text" class="form-control" id="zoom" name="zoom" value="10" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label class="control-label">Sokak Görüntüsü Kodu Ekleyin:</label>
                                    <textarea id="sokak" name="sokak"></textarea>
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
                                    <label><h4><input class="check-control" type="checkbox" value="" required=""><strong> <a href="#" data-toggle="modal" data-target=".bd-example-modal-lg">İlan verme kuralları</a></strong>'nı Okudum ve Kabul Ediyorum.</h4></label>
                                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                      <div class="modal-dialog modal-lg">
                                        <div class="modal-content"> 
                                          <div class="modal-header">
                                            <h4 class="modal-title" id="myLargeModalLabel">İlan Verme Kuralları</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">×</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <?php echo $site["ilan_verme_kurallari"] ?>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <br>
                                    <br>
                                    <button type="submit" class="btn btn-primary btn-block btn-lg" name="emlakekle"> <i class="fa fa-save"></i> <strong>EKLE VE DEVAM ET</strong> </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif ?>
<?php endif; ?>
</form>
<script type="text/javascript">
// ajax resim yukleme ve gosterme
function resimsonuc(){
    $.ajax({
        type:'POST',
        url:'ajax.php?do=resimver&islemno=<?=$islemno;?>',
        success:function(cevap){
            $("#resimgetir").html(cevap)
        }
    })
}
// ajax resim silme
function resimsil(id){
    $.ajax({
        type:'POST',
        url:'ajax.php?do=resimsil&islemno=<?=$islemno;?>&id=' + id,
        success:function(cevap){
            $("#sil"+id).html(cevap);
        }
    })
}
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