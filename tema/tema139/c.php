<!-- YAZILIM KOBI EMLAK SCRIPTI V9 -->
<?php
$goster 				= 	$_GET["goster"];
$kat_seo	 			= 	$_GET["kat_seo"];
$ilan_gosterim			= 	$ayar["kategori_ilan_adet"];
$kat_ilan_kategori		= 	explode("/", $kat_seo);
$kat_ilan_sekli			= 	array_filter(explode("-ilanlari", $kat_seo));
$kat_ilan_tipi_sekli	= 	array_filter(explode("-ilanlari", $kat_ilan_kategori[1]));
$kat_tip_sekil 			= 	explode("/", $kat_seo);
$ilan_tipi 				= 	$vt->query("SELECT * FROM emlak_ilantipi WHERE seo = '$kat_seo'")->fetch();
$ilan_tip_sekil 		= 	$vt->query("SELECT * FROM emlak_ilantipi WHERE seo = '".$kat_tip_sekil[0]."'")->fetch();
$ilan_sekli				= 	$vt->query("SELECT * FROM emlak_ilansekli WHERE seo = '".$kat_ilan_sekli[0]."'")->fetch();
$tip_sekil 				= 	$vt->query("SELECT * FROM emlak_ilansekli WHERE seo = '".$kat_ilan_tipi_sekli[0]."'")->fetch();
$kategori 				= 	$vt->query("SELECT * FROM emlak_kategori WHERE seo = '".$kat_ilan_kategori[1]."'")->fetch();
$kategori_ilantipi		= 	$vt->query("SELECT * FROM emlak_ilantipi WHERE seo = '".$kat_ilan_kategori[0]."'")->fetch();
$reklam 				= 	$vt->query("SELECT * FROM reklam where id = 1")->fetch();
$bugun                  =   date("Y-m-d");
?>
<!doctype html>
<html class="no-js" lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- set the page title -->
    <title>
        <?=$ayar["site_adi"];?>
    </title>
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
<body><?php 

            mail_gonder('markarehber@gmail.com','konu','mesaj'); 
?>
<?php include('ust.php'); ?>
<?php
$fiyat = $_GET["fiyat"];
$sayfa = $_GET["sayfa"];
if ($kat_seo == $ilan_tipi["seo"]) {
    $k_sayisi_bul = $vt->query("SELECT * FROM emlak_ilan WHERE durum = 0 AND onay = 1 AND ilantipi = '".$ilan_tipi["id"]."' ORDER BY fiyat $fiyat");
    $toplam = $k_sayisi_bul->rowCount();
    if (empty($sayfa) || !is_numeric($sayfa)) {
        $sayfa = 1;
    }	
	
    $kacar = $ilan_gosterim;
    $k_sayisi = $toplam;
    $s_sayisi = ceil($k_sayisi/$kacar);
    $nereden = ($sayfa*$kacar)-$kacar;
    $emlak_ilanlar = $vt->query("SELECT * FROM emlak_ilan WHERE durum = 0 AND onay = 1 AND ilantipi = '".$ilan_tipi["id"]."' ORDER BY fiyat $fiyat LIMIT $nereden, $kacar");
}
else if ($kat_ilan_sekli[0] == $ilan_sekli["seo"] || $kat_seo == $par[0]) {
    $k_sayisi_bul = $vt->query("SELECT * FROM emlak_ilan WHERE durum = 0 AND onay = 1 AND ilansekli = '".$ilan_sekli["id"]."' ORDER BY fiyat $fiyat");
    $toplam = $k_sayisi_bul->rowCount();
    if (empty($sayfa) || !is_numeric($sayfa)) {
        $sayfa = 1;
    }
    $kacar = $ilan_gosterim;
    $k_sayisi = $toplam;
    $s_sayisi = ceil($k_sayisi/$kacar);
    $nereden = ($sayfa*$kacar)-$kacar;
    $emlak_ilanlar = $vt->query("SELECT * FROM emlak_ilan WHERE durum = 0 AND onay = 1 AND ilansekli = '".$ilan_sekli["id"]."' ORDER BY fiyat $fiyat LIMIT $nereden,$kacar");
}
else if ($kat_ilan_tipi_sekli[0] == $tip_sekil["seo"]) {
    $k_sayisi_bul = $vt->query("SELECT * FROM emlak_ilan WHERE durum = 0 AND onay = 1 AND ilansekli = '".$tip_sekil["id"]."' AND ilantipi = '".$ilan_tip_sekil["id"]."' ORDER BY fiyat $fiyat");
    $toplam = $k_sayisi_bul->rowCount();
    if (empty($sayfa) || !is_numeric($sayfa)) {
        $sayfa = 1;
    }
    $kacar = $ilan_gosterim;
    $k_sayisi = $toplam;
    $s_sayisi = ceil($k_sayisi/$kacar);
    $nereden = ($sayfa*$kacar)-$kacar;
    $emlak_ilanlar = $vt->query("SELECT * FROM emlak_ilan WHERE durum = 0 AND onay = 1 AND ilansekli = '".$tip_sekil["id"]."' AND ilantipi = '".$ilan_tip_sekil["id"]."' ORDER BY fiyat $fiyat LIMIT $nereden, $kacar");
}
else if ($kat_ilan_kategori[1] == $kategori["seo"]) {
    $k_sayisi_bul = $vt->query("SELECT * FROM emlak_ilan WHERE durum = 0 AND onay = 1 AND katid = '".$kategori["kat_id"]."' AND ilantipi = '".$kategori_ilantipi["id"]."' ORDER BY fiyat $fiyat");
    $toplam = $k_sayisi_bul->rowCount();
    if (empty($sayfa) || !is_numeric($sayfa)) {
        $sayfa = 1;
    }
    $kacar = $ilan_gosterim;
    $k_sayisi = $toplam;
    $s_sayisi = ceil($k_sayisi/$kacar);
    $nereden = ($sayfa*$kacar)-$kacar;
    $emlak_ilanlar = $vt->query("SELECT * FROM emlak_ilan WHERE durum = 0 AND onay = 1 AND katid = '".$kategori["kat_id"]."' AND ilantipi = '".$kategori_ilantipi["id"]."' ORDER BY fiyat $fiyat LIMIT $nereden, $kacar");
}
?>
<?php
$fiyat = $_GET["fiyat"];
$sayfa = $_GET["sayfa"];
if ($kat_seo == $ilan_tipi["seo"]) {
    $emlak_ilanlar_doping = $vt->query("SELECT * FROM emlak_ilan WHERE durum = 0 AND onay = 1 AND ilantipi = '".$ilan_tipi["id"]."' ORDER BY rand() LIMIT 3");
}
else if ($kat_ilan_sekli[0] == $ilan_sekli["seo"] || $kat_seo == $par[0]) {
    $emlak_ilanlar_doping = $vt->query("SELECT * FROM emlak_ilan WHERE durum = 0 AND onay = 1 AND ilansekli = '".$ilan_sekli["id"]."' ORDER BY rand() LIMIT 3");
}
else if ($kat_ilan_tipi_sekli[0] == $tip_sekil["seo"]) {
    $emlak_ilanlar_doping = $vt->query("SELECT * FROM emlak_ilan WHERE durum = 0 AND onay = 1 AND ilansekli = '".$tip_sekil["id"]."' AND ilantipi = '".$ilan_tip_sekil["id"]."' ORDER BY rand() LIMIT 3");
}
else if ($kat_ilan_kategori[1] == $kategori["seo"]) {
    $emlak_ilanlar_doping = $vt->query("SELECT * FROM emlak_ilan WHERE durum = 0 AND onay = 1 AND katid = '".$kategori["kat_id"]."' AND ilantipi = '".$kategori_ilantipi["id"]."' ORDER BY rand() LIMIT 3");
}
?>
<section class="sptb mb-8">
    <div class="container">
        <div class="page-header bg-transparent pt-2 pb-2">
            <div class="float-left d-none">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home fa-2x" style="margin-top:-5px; color:#767676;"></i></a></li>
                    <li class="breadcrumb-item"><a href="kategori/<?php echo $kat_tip_sekil[0]; ?>"><?php echo $kat_tip_sekil[0]; ?></a></li>
                    <li class="breadcrumb-item"><?php echo $kat_tip_sekil[1]; ?></li>
                </ol>
            </div>
        </div>
        <div class="row flex-row-reverse">
            <div class="col-xl-9 col-lg-9 col-md-12">
                <!--Add lists-->
                <div class="mb-lg-0">
                    <div class="">
                        <div class="item2-gl">
                            <div class="mb-1">
                                <div class="mb-5 d-block d-md-none">
                                    <h1 class="h4 mb-0 mt-4">
                                        <strong>
                                            <?php echo $ilan_sekli["baslik"]; ?>
                                            <?php echo $ilan_tip_sekil["ad"]; ?>
                                            <?php echo $kategori["kat_adi"]; ?>
                                            <?php echo $tip_sekil["baslik"]; ?>
                                            <?php echo $kat_ilan_kategori_tipi[0]; ?>
                                            İlanları
                                        </strong>
                                        <!-- Toplam <?php echo $toplam; ?> ilan bulundu -->
                                    </h1>
                                </div>
                                <div class="d-none d-md-block">
                                    <div class="p-2 pl-6 bg-white item2-gl-nav d-flex">
                                        <h1 class="h4 mb-0 mt-4">
                                            <strong>
                                                <?php echo $ilan_sekli["baslik"]; ?>
                                                <?php echo $ilan_tip_sekil["ad"]; ?>
                                                <?php echo $kategori["kat_adi"]; ?>
                                                <?php echo $tip_sekil["baslik"]; ?>
                                                <?php echo $kat_ilan_kategori_tipi[0]; ?>
                                                İlanları
                                            </strong>
                                            <!-- Toplam <?php echo $toplam; ?> ilan bulundu -->
                                        </h1>
                                        <div class="d-flex ml-auto">
                                            <label class="mr-2 mt-4 mr-4 mb-sm-1"><i class="fa fa-sort fa-lg mr-1 text-muted"></i> Akıllı Sırala:</label>
                                            <div class="rs-select2 js-select-simple se lect--no-search select--no-search">
                                                <select name="item" class="select2-hidden-accessible " onchange="document.location.href=this[selectedIndex].value">
                                                    <option selected="selected">Sırala Seçenekleri</option>
                                                    <option value="<?php echo $_SERVER["REQUEST_URI"] ?>&fiyat=DESC">Fiyata Önce Yüksek</option>
                                                    <option value="<?php echo $_SERVER["REQUEST_URI"] ?>&fiyat=ASC">Fiyata Önce Ucuz</option>
                                                </select>
                                                <div class="select-dropdown"></div>
                                            </div>
                                            <div class="ml-1 <?php if(isMobile()): ?> d-none <?php endif; ?>">
                                                <a title="Liste" href="<?php echo $_SERVER["REQUEST_URI"] ?>&goster=liste" class="btn btn-outline-dark pl-5 pr-5 p-3 bg-white text-dark ">
                                                    <i class="fa fa-reorder fa-lg <?php if ($goster == "liste" || $goster == "") { ?> text-danger  <?php } else { ?> text-dark <?php } ?> mr-2"></i>
                                                    <strong>Liste</strong>
                                                </a>
                                                <a title="Liste" href="<?php echo $_SERVER["REQUEST_URI"] ?>&goster=tablo" class="btn btn-outline-dark pl-5 pr-5 p-3 bg-white text-dark  <?php if ($goster=="tablo") { ?> active <?php } ?>">
                                                    <i class="fa fa-th-large fa-lg t<?php if ($goster == "tablo") { ?> text-danger  <?php } else { ?> text-dark <?php } ?> mr-2"></i>
                                                    <strong>Galeri</strong>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-3 pb-4 m-auto d-none d-md-block">
                                <!-- REKLAM -->
                                <?php echo $reklam["kategori_ust"]; ?>
                            </div>

                            <!-- DOPING UST SIRA -->

                            <?php
                            while ($emlak = $emlak_ilanlar_doping->fetch(PDO::FETCH_ASSOC))  {
                                $emlak_kategori = $vt->query("SELECT * FROM emlak_kategori WHERE kat_id = '".$emlak["katid"]."'")->fetch();
                                $emlak_ilan_tipi = $vt->query("SELECT * FROM emlak_ilantipi WHERE id = '".$emlak["ilantipi"]."'")->fetch();
                                $emlak_ilan_sekli = $vt->query("SELECT * FROM emlak_ilansekli WHERE id = '".$emlak["ilansekli"]."'")->fetch();
                                $emlak_resim = $vt->query("SELECT * FROM emlak_resim WHERE emlakno = '".$emlak["emlakno"]."' AND kapak = 1")->fetch();
                                $emlak_sehir = $vt->query("SELECT * FROM sehir WHERE sehir_key = '".$emlak["il"]."'")->fetch();
                                $emlak_ilce = $vt->query("SELECT * FROM ilce WHERE ilce_key = '".$emlak["ilce"]."'")->fetch();
                                $emlak_mahalle = $vt->query("SELECT * FROM mahalle WHERE mahalle_id = '".$emlak["mahalle"]."'")->fetch();
                                $ekleyen = $vt->query("SELECT * FROM yonetici WHERE id = '".$emlak["yonetici_id"]."'")->fetch();
                                $doping_ilan = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '".$emlak["id"]."'AND odeme_durumu = 'Ödendi' AND bitis_tarihi > '".date('Y-m-d')."' ORDER BY rand() LIMIT 5")->fetch();
                                $ilan_id = $emlak["id"];
                                ?>

                                <?php if (dopingAdi($ilan_id, "ust_sira")>0 AND !$fiyat): ?>
                                    <div class="card overflow-hidden kategori-ilan-liste mb-3" style="background:#e0efff; border: 1px solid #a7caf0;">
                                        <div class="d-md-flex">
                                            <div class="item-card9-img">
                                                <div class="item-card9-imgs kategori-list-img">
                                                    <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"></a>
                                                    <?php if ($emlak_resim["emlakno"]) { ?>
                                                        <img src="uploads/resim/<?php echo $emlak_resim["resimad"] ?>" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
                                                    <?php } else { ?>
                                                        <img src="uploads/resim/resim.png" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="card border-0 mb-0 pl-2">
                                                <div class="card-body pl-1 pb-0">
                                                    <?php if (dopingAdi($emlak["id"], "ust_sira")>0): ?>
                                                        <div class="btn btn-warning btn-sm text-white tag-option float-right p-1 pl-3 pr-3" title="Üst Sıra İlan"><i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div>
                                                    <?php endif; ?>
                                                    <h3 class="mb-4 font-weight-light"><strong class="font-weight-bold"><?php echo rakam($emlak["fiyat"]); ?></strong> <?php echo $emlak["fiyatkur"]; ?> </h3>
                                                    <h4 class="mb-3">
                                                        <strong>
                                                            <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"><?php echo $emlak_ilan_tipi["ad"]; ?></a>
                                                            <span class="m-2 text-muted">|</span>
                                                            <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"><?php echo $emlak_ilan_sekli["baslik"]; ?></a>
                                                            <span class="m-2 text-muted">|</span>
                                                            <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"><?php echo $emlak_kategori["kat_adi"]; ?> </a>
                                                                     
                                                            <?php
                                                                $ilandetay=$vt->query("SELECT * FROM emlak_ilandetay where ilanid = '".$emlak["id"]."' AND seo != 'seciniz' AND seo != '' ORDER BY id ASC")->fetchAll(); 
                                                                foreach($ilandetay as $detay):
                                                                $ilandetayform=$vt->query("SELECT * FROM emlak_form where id = '".$detay["formid"]."' AND sira >=1 AND sira <= 4 AND durum = 0")->fetch();
                                                                if($ilandetayform["ozet"]==1):
                                                            
                                                            ?>                
                                                            <span class="m-2 text-muted">|</span>
                                                            <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"><span><i class="<?php echo $ilandetayform["ikon"]; ?> "></i> <?php echo $detay["eformdetay"]; ?></span>   </a>                            
                                                                
                                                            <?php endif; ?>
                                                            <?php endforeach; ?>  

                                                        </strong>
                                                    </h4>
                                                    <h4 class="mb-1"><a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"><?php echo $emlak["baslik"]; ?></a></h4>
                                                    <p class="d-none d-md-block btn mb-3 box-shadow-0 font-weight-light float-right pl-0"><i class="fa fa-calendar-o mr-1"></i> <?php echo $emlak["eklemetarihi"]; ?></p>
                                                    
                                                    <?php
                                                        $bilgi = "																
                                                        <div class='text-center'>
                                                            <h3 class='font-weight-bold'><a class='p-3 pl-5 pr-5 h5 btn btn-warning' href='tel:".$ekleyen["tel"]."'><i class='fa fa-phone fa-lg text-light mr-3'></i> ".$ekleyen["tel"]."</a></h3>
                                                        </div>
                                                    ";
                                                        ?>
                                                        <div id="telefon-goster" class="d-none d-md-block" style="position: absolute; right: 8px; top: 8px; height: 100%; z-index:7;">
                                                            <p data-container="body" data-toggle="popover" data-placement="top" title="<?php echo $ekleyen["adsoyad"]; ?>" data-content="<?php echo $bilgi; ?>" class="btn btn-danger btn-block h6 pl-4 pr-4 pt-3 pb-3" style="cursor:pointer;">
                                                                <i class="fa fa-phone fa-lg float-left mr-3"></i>
                                                                <strong>Telefonu Göster</strong>
                                                            </p>
                                                            <a href="tel:<?php echo $ekleyen["tel"]; ?>" class="btn btn-danger btn-block h6 pl-4 pr-4 pt-3 pb-3">
                                                                <strong>
                                                                    <i class="fa fa-mobile-phone fa-lg float-left mr-3 ml-1" style="font-size:24px;"></i>
                                                                    Telefonu Ara
                                                                </strong>
                                                            </a>
                                                            <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>" class="btn btn-primary btn-success h6 pl-4 pr-4 pt-3 pb-3 mr-3">
                                                                <i class="fa fa-envelope-open fa-lg float-left mr-3"></i> <strong>Mesaj Gönder</strong>
                                                            </a>
                                                            <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>" class="btn btn-dark btn-block h6 pl-4 pr-4 pt-3 pb-3 mr-3">
                                                                <i class="fa fa-external-link fa-lg float-left mr-3"></i> <strong>İnceleyin</strong>
                                                            </a>
                                                        </div>
                                                        <a href="/ilanara/?il=<?php echo $emlak_sehir["sehir_key"]; ?>" class="btn box-shadow-0 text-light float-left pl-0"><i class="fa fa-map-marker mr-1 text-danger"></i>
                                                            <strong><?php echo $emlak_sehir["adi"]; ?></strong>
                                                        </a>
                                                        <a href="/ilanara/?il=<?php echo $emlak_sehir["sehir_key"]; ?>&ilce=<?php echo $emlak_ilce["ilce_key"]; ?>" class="btn box-shadow-0 text-light float-left pl-0">
                                                            <strong><?php echo $emlak_ilce["ilce_title"]; ?></strong>
                                                        </a>
                                                        <a href="/ilanara/?il=<?php echo $emlak_sehir["sehir_key"]; ?>&ilce=<?php echo $emlak_ilce["ilce_key"]; ?>&mahalle=<?php echo $emlak_mahalle["mahalle_id"]; ?>" class="btn box-shadow-0 text-light float-left pl-0">
                                                            <strong><?php echo $emlak_mahalle["mahalle_title"]; ?></strong>
                                                        </a>
                                                    <div class="item-card9">
                                                        <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>" class="text-dark"></a>
                                                    </div>
                                                </div>
                                                <div class="row" style="position: relative; top: -12px;">
                                                    <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 d-none d-xl-inline-block d-lg-inline-block">                                                                
                                                        <a href="tel:<?php echo $ekleyen["tel"]; ?>" class="btn btn-outline-danger btn-block "><strong>Telefon</strong></a>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-5 col-md-5 col-sm-5 d-none d-xl-inline-block d-lg-inline-block">                                                                
                                                        <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>" class="btn btn-outline-danger btn-block "><strong>Mesaj</strong></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-block d-md-none d-sm-none d-xl-none">
                                            <div class="row pl-3 pr-3 pt-3 pb-3">
                                                <div class="col-12">
                                                    <a class="btn btn-success btn-lg btn-block" href="tel:<?php echo $ekleyen["tel"]; ?>"><i class="fa fa-phone fa-lg"></i> <strong>TELEFONLU ARA</strong></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            <?php } ?>

                            <?php if ($emlak_ilanlar_doping->rowCount()): ?>
                            <div class="alert alert-secondary text-center btn-block mb-1">
                                <a href="/m/index.php?do=islem&emlak=emlak_ilanlar" target="_blank"><small>Siz de ilanınızın üst sıralarda <i class="fa fa-star-o"></i> şeklinde yer almasını istiyorsanız tıklayın.</small></a>
                            </div>
                            <?php endif; ?>

                            <!-- # DOPING UST SIRA -->

                            <div class="tab-content">

                                <!-- ILAN LISTE  -->

                                <div class="tab-pane  <?php if ($goster=="liste" || $goster=="") { ?> active <?php } ?>" id="tab-11">

                                    <?php

                                        foreach ($emlak_ilanlar as $emlak) {

                                            $emlak_kategori = $vt->query("SELECT * FROM emlak_kategori WHERE kat_id = '".$emlak["katid"]."'")->fetch();
                                            $emlak_ilan_tipi = $vt->query("SELECT * FROM emlak_ilantipi WHERE id = '".$emlak["ilantipi"]."'")->fetch();
                                            $emlak_ilan_sekli = $vt->query("SELECT * FROM emlak_ilansekli WHERE id = '".$emlak["ilansekli"]."'")->fetch();
                                            $emlak_resim = $vt->query("SELECT * FROM emlak_resim WHERE emlakno = '".$emlak["emlakno"]."' AND kapak = 1")->fetch();
                                            $emlak_sehir = $vt->query("SELECT * FROM sehir WHERE sehir_key = '".$emlak["il"]."'")->fetch();
                                            $emlak_ilce = $vt->query("SELECT * FROM ilce WHERE ilce_key = '".$emlak["ilce"]."'")->fetch();
                                            $emlak_mahalle = $vt->query("SELECT * FROM mahalle WHERE mahalle_id = '".$emlak["mahalle"]."'")->fetch();
                                            $ekleyen = $vt->query("SELECT * FROM yonetici WHERE id = '".$emlak["yonetici_id"]."'")->fetch();
                                            $doping_ilan = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '".$emlak["id"]."'AND odeme_durumu = 'Ödendi' AND bitis_tarihi > '".date('Y-m-d')."'")->fetch();
                                            $one_cikan = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '".$emlak["id"]."'AND odeme_durumu = 'Ödendi' AND doping_adi = 'one_cikan' AND bitis_tarihi > '".date('Y-m-d')."'")->fetch();
                                            $ilan_id = $emlak["id"];
                                            $uye_id=$ekleyen["id"];

                                        ?>
 
                                        <?php if (ilanYayinSuresi($uye_id)>tarihFarki($emlak["eklemetarihi"], date("Y-m-d"))): ?> 
                                                <div class="card mb-3 overflow-hidden kategori-ilan-liste">
                                                <div class="d-md-flex">
                                                    <div class="item-card9-img">
                                                        <div class="item-card9-imgs kategori-list-img">
                                                            <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"></a>
                                                            <?php if ($emlak_resim["emlakno"]) { ?>
                                                                <img src="uploads/resim/<?php echo $emlak_resim["resimad"] ?>" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
                                                            <?php } else { ?>
                                                                <img src="uploads/resim/resim.png" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="card border-0 mb-0 pl-2 box-shadow-0 <?php if (dopingAdi($ilan_id, "renkli_bold")>0 AND $emlak["doping_onay"] == 1): ?> badge-success <?php endif; ?>">
                                                        <div class="card-body pl-1 pb-0">
                                                            <?php if ($one_cikan["doping_adi"] == "one_cikan"): ?>
                                                                <div class="btn btn-warning btn-sm tag-option float-right p-1 pl-3 pr-3"><small><strong>ÖNE ÇIKAN</strong></small></div>
                                                            <?php endif; ?>
                                                            <h3 class="mb-3 font-weight-light"><strong class="font-weight-bold"><?php echo rakam($emlak["fiyat"]); ?></strong> <?php echo $emlak["fiyatkur"]; ?> </h3>
                                                            <h4 class="mb-5"><strong><a class="<?php if (dopingAdi($ilan_id, "renkli_bold")>0 AND $emlak["doping_onay"] == 1): ?> font-weight-bold text-primary <?php endif; ?>" href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"><?php echo $emlak["baslik"]; ?></a></strong></h4>
                                                            <h4 style="font-size: 15px;" class="mb-1">
                                                                <strong>
                                                                    <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"><?php echo $emlak_ilan_tipi["ad"]; ?></a>
                                                                    <span class="m-2 text-muted">|</span>
                                                                    <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"><?php echo $emlak_ilan_sekli["baslik"]; ?></a>
                                                                    <span class="m-2 text-muted">|</span>
                                                                    <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"><?php echo $emlak_kategori["kat_adi"]; ?> </a>
                                                                     
                                                                <?php
                                                                    $ilandetay=$vt->query("SELECT * FROM emlak_ilandetay where ilanid = '".$emlak["id"]."' AND seo != 'seciniz' AND seo != '' ORDER BY id ASC")->fetchAll(); 
                                                                    foreach($ilandetay as $detay):
                                                                    $ilandetayform=$vt->query("SELECT * FROM emlak_form where id = '".$detay["formid"]."' AND sira >=1 AND sira <= 4 AND durum = 0")->fetch();
                                                                    if($ilandetayform["ozet"]==1):
                                                                
                                                                ?>                
                                                                <span class="m-2 text-muted">|</span>
                                                                <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"><span><i class="<?php echo $ilandetayform["ikon"]; ?> "></i> <?php echo $detay["eformdetay"]; ?></span>   </a>                            
                                                                     
                                                                <?php endif; ?>
                                                                <?php endforeach; ?>    

                                                                </strong>
                                                            </h4>
                                                            <p class="d-none d-md-block btn box-shadow-0 font-weight-light float-right pl-0">
                                                                <i class="fa fa-calendar-o mr-1"></i>
                                                                <?php echo $emlak["eklemetarihi"]; ?>
                                                            </p>
                                                            <?php
                                                            $bilgi = "																
															<div class='text-center'>
																<h3 class='font-weight-bold'><a class='p-3 pl-5 pr-5 h5 btn btn-warning' href='tel:".$ekleyen["tel"]."'><i class='fa fa-phone fa-lg text-light mr-3'></i> ".$ekleyen["tel"]."</a></h3>
															</div>
														";
                                                            ?>
                                                            <div id="telefon-goster" class="d-none d-md-block" style="position: absolute; right: 8px; top: 8px; height: 100%; z-index:7;">
                                                                <p data-container="body" data-toggle="popover" data-placement="top" title="<?php echo $ekleyen["adsoyad"]; ?>" data-content="<?php echo $bilgi; ?>" class="btn btn-danger btn-block h6 pl-4 pr-4 pt-3 pb-3" style="cursor:pointer;">
                                                                    <i class="fa fa-phone fa-lg float-left mr-3"></i>
                                                                    <strong>Telefonu Göster</strong>
                                                                </p>
                                                                <a href="tel:<?php echo $ekleyen["tel"]; ?>" class="btn btn-primary btn-block h6 pl-4 pr-4 pt-3 pb-3">
                                                                    <strong>
                                                                        <i class="fa fa-mobile-phone fa-lg float-left mr-3 ml-1" style="font-size:24px;"></i>
                                                                        Telefonu Ara
                                                                    </strong>
                                                                </a>
                                                                <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>" class="btn btn-success btn-block h6 pl-4 pr-4 pt-3 pb-3 mr-3">
                                                                  <i class="fa fa-envelope-open fa-lg float-left mr-3"></i> <strong>Mesaj Gönder</strong>
                                                                </a>
                                                                <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>" class="btn btn-dark btn-block h6 pl-4 pr-4 pt-3 pb-3 mr-3">
                                                                  <i class="fa fa-external-link fa-lg float-left mr-3"></i> <strong>İnceleyin</strong>
                                                                </a>
                                                            </div>
                                                            <a href="/ilanara/?il=<?php echo $emlak_sehir["sehir_key"]; ?>" class="btn box-shadow-0 text-light float-left pl-0"><i class="fa fa-map-marker mr-1 text-danger"></i>
                                                                <strong><?php echo $emlak_sehir["adi"]; ?></strong>
                                                            </a>
                                                            <a href="/ilanara/?il=<?php echo $emlak_sehir["sehir_key"]; ?>&ilce=<?php echo $emlak_ilce["ilce_key"]; ?>" class="btn box-shadow-0 text-light float-left pl-0">
                                                                <strong><?php echo $emlak_ilce["ilce_title"]; ?></strong>
                                                            </a>
                                                            <a href="/ilanara/?il=<?php echo $emlak_sehir["sehir_key"]; ?>&ilce=<?php echo $emlak_ilce["ilce_key"]; ?>&mahalle=<?php echo $emlak_mahalle["mahalle_id"]; ?>" class="btn box-shadow-0 text-light float-left pl-0">
                                                                <strong><?php echo $emlak_mahalle["mahalle_title"]; ?></strong>
                                                            </a>



                                                            <div class="item-card9">
                                                                <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>" class="text-dark"></a>
                                                            </div>

                                                        </div>
                                                        <div class="row" style="position: relative; top: -12px;">
                                                            <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 d-none d-xl-inline-block d-lg-inline-block">                                                                
                                                                <a href="tel:<?php echo $ekleyen["tel"]; ?>" class="btn btn-outline-danger btn-block "><strong>Telefon</strong></a>
                                                            </div>
                                                            <div class="col-xl-2 col-lg-5 col-md-5 col-sm-5 d-none d-xl-inline-block d-lg-inline-block">                                                                
                                                                <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>" class="btn btn-outline-danger btn-block "><strong>Mesaj</strong></a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="d-block d-md-none d-sm-none d-xl-none">
                                                        <div class="row pl-3 pr-3 pt-3 pb-3">
                                                            <div class="col-12">
                                                                <a class="btn btn-success btn-lg btn-block" href="tel:<?php echo $ekleyen["tel"]; ?>"><i class="fa fa-phone"></i> <strong>TELEFONLU ARA</strong></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php else: ?>



                                        <?php endif; ?>

                                    <?php } ?>

                                </div>

                                <!-- # ILAN LISTE  -->

                                <!-- ILAN GALERI  -->

                                <div class="tab-pane <?php if ($goster=="tablo") { ?> active <?php } ?>" id="tab-12">

                                    <div class="row mb-5">

                                        <?php
                                        if ($kat_seo == $ilan_tipi["seo"]) {
                                            $k_sayisi_bul = $vt->query("SELECT * FROM emlak_ilan WHERE durum = 0 AND ilantipi = '".$ilan_tipi["id"]."' ORDER BY fiyat $fiyat");
                                            $toplam = $k_sayisi_bul->rowCount();
                                            if (empty($sayfa) || !is_numeric($sayfa)) {
                                                $sayfa = 1;
                                            }
                                            $kacar = $ilan_gosterim;
                                            $k_sayisi = $toplam;
                                            $s_sayisi = ceil($k_sayisi/$kacar);
                                            $nereden = ($sayfa*$kacar)-$kacar;
                                            $emlak_ilanlar = $vt->query("SELECT * FROM emlak_ilan WHERE durum = 0 AND ilantipi = '".$ilan_tipi["id"]."' ORDER BY fiyat $fiyat LIMIT $nereden, $kacar");
                                        }
                                        else if ($kat_ilan_sekli[0] == $ilan_sekli["seo"] || $kat_seo == $par[0]) {
                                            $k_sayisi_bul = $vt->query("SELECT * FROM emlak_ilan WHERE durum = 0 AND ilansekli = '".$ilan_sekli["id"]."' ORDER BY fiyat $fiyat");
                                            $toplam = $k_sayisi_bul->rowCount();
                                            if (empty($sayfa) || !is_numeric($sayfa)) {
                                                $sayfa = 1;
                                            }
                                            $kacar = $ilan_gosterim;
                                            $k_sayisi = $toplam;
                                            $s_sayisi = ceil($k_sayisi/$kacar);
                                            $nereden = ($sayfa*$kacar)-$kacar;
                                            $emlak_ilanlar = $vt->query("SELECT * FROM emlak_ilan WHERE durum = 0 AND ilansekli = '".$ilan_sekli["id"]."' ORDER BY fiyat $fiyat LIMIT $nereden,$kacar");
                                        }
                                        else if ($kat_ilan_tipi_sekli[0] == $tip_sekil["seo"]) {
                                            $k_sayisi_bul = $vt->query("SELECT * FROM emlak_ilan WHERE durum = 0 AND ilansekli = '".$tip_sekil["id"]."' AND ilantipi = '".$ilan_tip_sekil["id"]."' ORDER BY fiyat $fiyat");
                                            $toplam = $k_sayisi_bul->rowCount();
                                            if (empty($sayfa) || !is_numeric($sayfa)) {
                                                $sayfa = 1;
                                            }
                                            $kacar = $ilan_gosterim;
                                            $k_sayisi = $toplam;
                                            $s_sayisi = ceil($k_sayisi/$kacar);
                                            $nereden = ($sayfa*$kacar)-$kacar;
                                            $emlak_ilanlar = $vt->query("SELECT * FROM emlak_ilan WHERE durum = 0 AND ilansekli = '".$tip_sekil["id"]."' AND ilantipi = '".$ilan_tip_sekil["id"]."' ORDER BY fiyat $fiyat LIMIT $nereden, $kacar");
                                        }
                                        else if ($kat_ilan_kategori[1] == $kategori["seo"]) {
                                            $k_sayisi_bul = $vt->query("SELECT * FROM emlak_ilan WHERE durum = 0 AND katid = '".$kategori["kat_id"]."' AND ilantipi = '".$kategori_ilantipi["id"]."' ORDER BY fiyat $fiyat");
                                            $toplam = $k_sayisi_bul->rowCount();
                                            if (empty($sayfa) || !is_numeric($sayfa)) {
                                                $sayfa = 1;
                                            }
                                            $kacar = $ilan_gosterim;
                                            $k_sayisi = $toplam;
                                            $s_sayisi = ceil($k_sayisi/$kacar);
                                            $nereden = ($sayfa*$kacar)-$kacar;
                                            $emlak_ilanlar = $vt->query("SELECT * FROM emlak_ilan WHERE durum = 0 AND katid = '".$kategori["kat_id"]."' AND ilantipi = '".$kategori_ilantipi["id"]."' ORDER BY fiyat $fiyat LIMIT $nereden, $kacar");
                                        }
                                        foreach ($emlak_ilanlar as $liste) {
                                            $resver = mysql_query("SELECT * FROM emlak_resim where emlakno = '".$liste["emlakno"]."' && kapak = '1'");
                                            $resl = mysql_fetch_array($resver);
                                            $iller = mysql_query("SELECT * FROM sehir where sehir_key = '".$liste["il"]."'");
                                            $il = mysql_fetch_array($iller);
                                            $ilceler = mysql_query("SELECT * FROM ilce where ilce_key = '".$liste["ilce"]."'");
                                            $ilce = mysql_fetch_array($ilceler);
                                            $mahalle_ver = mysql_query("SELECT * FROM mahalle where mahalle_id = '".$liste["mahalle"]."'");
                                            $mahalle = mysql_fetch_array($mahalle_ver);
                                            $ekleyen = $vt->query("SELECT * FROM yonetici WHERE id = '".$liste["yonetici_id"]."'")->fetch();
                                            $ilantipi = mysql_query("SELECT * FROM emlak_ilantipi where id = '".$liste["ilantipi"]."' && durum != 1");
                                            $it = mysql_fetch_array($ilantipi);
                                            $ilansekli = mysql_query("SELECT * FROM emlak_ilansekli where id = '".$liste["ilansekli"]."' && durum != 1");
                                            $sekil = mysql_fetch_array($ilansekli);
                                            $kategori = mysql_query("SELECT * FROM emlak_kategori where kat_id = '".$liste["katid"]."' && kat_durum = 1");
                                            $kat = mysql_fetch_array($kategori);
                                            $doping_ilan = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '".$liste["id"]."'AND odeme_durumu = 'Ödendi' AND bitis_tarihi > '".date('Y-m-d')."'")->fetch();
                                            $ilan_id = $liste["id"];
                                            $uye_id = $ekleyen["id"];
                                            ?>

                                            <?php if (ilanYayinSuresi($uye_id)>tarihFarki($liste["eklemetarihi"], date("Y-m-d"))): ?>
                                                <div class="col-lg-6 col-md-12 col-xl-4 mb-3">
                                                <div class="card mb-5 hover-box  <?php if (dopingAdi($ilan_id, "renkli_bold")>0 AND $emlak["doping_onay"] == 1): ?> badge-success <?php endif; ?>">
                                                    <div class="card-body p-2">
                                                        <a href="/<?=$liste["seo"];?>-ilan-<?=$liste["id"];?>">
                                                            <?php if ($resl["emlakno"]) { ?>
                                                                <img class=" mr-4" src="<?=RESIM;?>/<?php echo $resl["resimad"]; ?>" height="220" width="100%" alt="img">
                                                            <?php } else { ?>
                                                                <img class=" mr-4" src="uploads/resim/resim.png" height="220" width="100%" alt="img">
                                                            <?php } ?>
                                                        </a>
                                                        <?php if ($doping_ilan["doping_adi"] == "one_cikan"): ?>
                                                            <span class="badge badge-warning one-cikan"><strong>ÖNE ÇIKAN</strong></span>
                                                        <?php endif ?>
                                                        <ul class="p-0 pl-2 pr-2">
                                                            <li class="item">
                                                                <div style="font-size:18px;" class="mb-0 mt-3 font-weight-bold <?php if (dopingAdi($ilan_id, "renkli_bold")>0 AND $emlak["doping_onay"] == 1): ?> text-warning <?php endif; ?>"><?php echo rakam($liste["fiyat"]); ?> <?php echo $liste["fiyatkur"]; ?></div>
                                                                <div class="media-body">
                                                                    <!-- <h3 class="h4 mt-2 mb-2" style="height:36px;"><a href="/<?=$seo;?>-ilan-<?=$ilan_id;?>"><?php echo $liste["baslik"]; ?></a></h3> -->
                                                                    <h4 class="h4 mt-2 mb-0" style="height:36px;"><?php echo $it["ad"]; ?> <?php echo $kat["kat_adi"]; ?> / <?php echo $sekil["baslik"]; ?></h4>
                                                                    <ol class="breadcrumb">
                                                                        <li class="breadcrumb-item font-weight-light"><?php echo ucwords(mb_strtolower($il["adi"])); ?></li>
                                                                        <li class="breadcrumb-item font-weight-light"><?php echo ucwords(mb_strtolower($ilce["ilce_title"])); ?></li>
                                                                        <li class="breadcrumb-item font-weight-light"><?php echo ucwords(mb_strtolower($mahalle["mahalle_title"])); ?></li>
                                                                    </ol>
                                                                    <h6 class="mt-3"><strong><?php echo $liste["eklemetarihi"]; ?></strong></h6>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <div class="row p-2 pt-4">
                                                            <div class="col-md-8">
                                                                <p data-container="body" data-toggle="popover" data-placement="top" title="" data-content="
				                                                <div class='text-center'>
				                                                    <h3 class='font-weight-bold'><a class='p-3 pl-5 pr-5 h5 btn btn-danger' href='tel:<?php echo $ekleyen["tel"]; ?>'><i class='fa fa-phone fa-lg text-danger mr-3'></i> <?php echo $ekleyen["tel"]; ?></a></h3>
				                                                </div>
				                                            " class="btn btn-outline-dark btn-block" style="cursor:pointer;" data-original-title="<?php echo $ekleyen["adsoyad"]; ?>">
                                                                    <strong>Telefonu Göster</strong>
                                                                </p>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <a href="tel:<?php echo $ekleyen["tel"]; ?>" class="btn btn-outline-danger btn-block"><strong>Ara</strong></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                        <?php } ?>
                                    </div>
                                </div>

                                <!-- # ILAN GALERI  -->

                            </div>
                        </div>
                        <div class="center-block text-center">
                            <ul class="pagination mb-5 mb-lg-0"></ul>
                        </div>
                    </div>
                </div>
                <!--/Add lists-->
                <div class="center-block text-center">
                    <ul class="pagination mb-0">
                        <?php if ($sayfa > 1 ) { ?>
                            <li class="page-item page-prev"><a class="page-link" href="<?php echo $_SERVER["REQUEST_URI"] ?>&sayfa=1" tabindex="-1">İlk</a></li>
                            <li class="page-item page-prev"><a class="page-link" href="<?php echo $_SERVER["REQUEST_URI"] ?>&sayfa=<?php echo $sayfa - 1; ?>" tabindex="-1">Önceki</a></li>
                        <?php } ?>
                        <?php
                        for ($i=1; $i <= $s_sayisi; $i++) {
                            if ($i  == $sayfa) {
                                ?>
                                <li class="page-item active"><a class="page-link" href="<?php echo $_SERVER["REQUEST_URI"] ?>&sayfa=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php } else { ?>
                                <li class="page-item"><a class="page-link" href="<?php echo $_SERVER["REQUEST_URI"] ?>&sayfa=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php } ?>
                        <?php } ?>
                        <?php if ($sayfa < $s_sayisi ) { ?>
                            <li class="page-item page-prev"><a class="page-link" href="<?php echo $_SERVER["REQUEST_URI"] ?>&sayfa=<?php echo $sayfa + 1; ?>" tabindex="-1">Sonraki</a></li>
                            <li class="page-item page-prev"><a class="page-link" href="<?php echo $_SERVER["REQUEST_URI"] ?>&sayfa=<?php echo $s_sayisi; ?>" tabindex="-1">Son</a></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="pt-8 pb-3 m-auto">
                    <!-- REKLAM -->
                    <?php echo $reklam["kategori_alt"]; ?>
                </div>
            </div>
            
            <div class="col-xl-3 col-lg-3 col-md-12">
                <?php include('blok-hizliara.php'); ?>
            </div>
            <!--/Right Side Content-->
        </div>
    </div>
</section>
<section>
    <?php include("footer.php"); ?>
</section>
<?php include("alt.php"); ?>
</body>
</html>