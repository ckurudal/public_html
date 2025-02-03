<!doctype html>
<html class="no-js" lang="tr">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- set the page title -->
    <title><?=$ayar["site_adi"];?></title>
    <meta name="description" content="<?=$ayar['site_desc'];?>" />
    <meta name="keywords" content="<?=$ayar['site_keyw'];?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="robots" content="index, follow" />
    <meta name="Revisit-After" content="1 Days" />
    <link rel="shortcut icon" type="image/x-icon" href="<?=$ayar['favicon'];?>">
    <meta name="generator" content="RoxiKonsept 2.0" />
    <link rel="canonical" href="<?php echo URL.$_SERVER['REQUEST_URI']; ?>" />
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <base href="<?=URL;?>/">
    <?php include('header.php'); ?>
</head>

<body>
    
    <?php include('ust.php') ?>
    
<?php
  
if (isset($_POST["odemeYap"])) {    

    $ekle = $vt->prepare("INSERT INTO siparis_oda SET
        siparis_no = ?,
        ilan_baslik = ?,
        ad_soyad = ?,
        tc_kimlik = ?,
        telefon = ?,
        email = ?,
        siparis_notu = ?,
        yetiskin_sayisi = ?,
        cocuk_sayisi = ?,
        bebek_sayisi = ?,
        nereden_duydunuz = ?,
        giris_tarihi = ?,
        cikis_tarihi = ?,
        gun_sayisi = ?,
        il = ?,
        ilce = ?,
        adres = ?,
        periyot = ?,
        yetiskin_fiyat = ?,
        cocuk_fiyat = ?,
        bebek_fiyat = ?,
        toplam = ?,
        siparis_odeme = ?
        ");

    $ekle = $ekle->execute(array(
        trim($_POST["siparis_no"]),
        temizle($_POST["ilan_baslik"]),
        temizle($_POST["ad_soyad"]),
        trim($_POST["tc_kimlik"]),
        trim($_POST["telefon"]),
        trim($_POST["email"]),
        temizle($_POST["siparis_notu"]),
        trim($_POST["yetiskin_sayisi"]),
        trim($_POST["cocuk_sayisi"]),
        trim($_POST["bebek_sayisi"]),
        temizle($_POST["nereden_duydunuz"]),
        trim($_POST["giris_tarihi"]),
        trim($_POST["cikis_tarihi"]),
        trim($_POST["gun_sayisi"]),
        temizle($_POST["il"]),
        temizle($_POST["ilce"]),
        temizle($_POST["adres"]),
        temizle($_POST["periyot"]),
        trim($_POST["yetiskin_fiyat"]),
        trim($_POST["cocuk_fiyat"]),
        trim($_POST["bebek_fiyat"]),
        trim($_POST["toplam"]),
        temizle("Ödenmedi")
    ));
    if ($ekle) {
        odaOdeme($_POST["email"],$_POST["toplam"],$_POST["siparis_no"],$_POST["ilan_baslik"],$_POST["ad_soyad"],$_POST["telefon"]);
    } else { 
        echo "sorun var";
    }  

}

?>

</body>
</html>