<?php
    $id = $_GET["id"];
    $ilanseo = $_GET["ilanseo"];
    $ilan = $vt->query("SELECT * FROM emlak_ilan WHERE id = '".$id."'")->fetch();
    $emlakresim = mysql_query("SELECT * FROM emlak_resim where emlakno = '".$ilan["emlakno"]."' && kapak = 1");
    $resim = mysql_fetch_array($emlakresim);
    $ilantipi = mysql_query("SELECT * FROM emlak_ilantipi where id = '".$ilan["ilantipi"]."' && durum = 0");
    $itip = mysql_fetch_array($ilantipi);
    $kategoriler = mysql_query("SELECT * FROM emlak_kategori where kat_id = '".$ilan["katid"]."' && kat_durum = 1");
    $kat = mysql_fetch_array($kategoriler);
    $ilan_sekli = mysql_query("SELECT * FROM emlak_ilansekli where id = '".$ilan["ilansekli"]."' && durum = 0");
    $sekil = mysql_fetch_array($ilan_sekli);
    $iller = mysql_query("SELECT * FROM sehir where sehir_key = '".$ilan["il"]."'");
    $il = mysql_fetch_array($iller);
    $ilceler = mysql_query("SELECT * FROM ilce where ilce_key = '".$ilan["ilce"]."'");
    $ilce = mysql_fetch_array($ilceler);
    $mahalleler = mysql_query("SELECT * FROM mahalle where mahalle_id = '".$ilan["mahalle"]."'");
    $mahalle = mysql_fetch_array($mahalleler);
    $yonetici = $vt->query("SELECT * FROM yonetici WHERE id = '".$ilan["yonetici_id"]."'")->fetch();
    $yonetici_sube = $vt->query("SELECT * FROM subeler WHERE yetkiliuye = '".$yonetici["id"]."'")->fetch();
    $p = $_GET["p"];        
    $resim_limit = uyeIlanResimLimit($ilan["yonetici_id"]);     
    if ($yonetici["yetki"] == 0) $resim_limit = 500;
    $reklam = $vt->query("SELECT * FROM reklam where id = 1")->fetch();

    $metaDescription = $ilan["icerik"] != "" ? mb_substr(preg_replace('/\s+/', ' ', strip_tags($ilan["icerik"])), 0, 150, "UTF-8") : $ilan["baslik"];
?>
<!doctype html>
<html class="no-js" lang="tr">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- set the page title -->
    <title><?=$ilan["title"] != "" ? $ilan["title"] : $ilan["baslik"];?> - <?=$ayar["site_adi"];?></title>
    <meta name="description" content="<?php echo htmlspecialchars($metaDescription); ?>">
    <meta name="keywords" content="<?=$ayar['site_keyw'];?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <meta name="robots" content="index, follow" />
    <meta name="Revisit-After" content="1 Days" />
    <link rel="shortcut icon" type="image/x-icon" href="<?=$ayar['favicon'];?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($ilan["title"] != "" ? $ilan["title"] : $ilan["baslik"]); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($metaDescription); ?>">
    <meta property="og:image" content="<?php echo RESIM.$resim["resimad"]; ?>">
    <meta property="og:url" content="<?php echo URL.'/'.$ilan["seo"]."-".$ilan["emlakno"]."-ilan-".$ilan["id"]; ?>">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($ilan["title"] != "" ? $ilan["title"] : $ilan["baslik"]); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($metaDescription); ?>">
    <meta name="twitter:image" content="<?php echo RESIM.$resim["resimad"]; ?>">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="canonical" href="<?php echo URL.'/'.$ilan["seo"]."-".$ilan["emlakno"]."-ilan-".$ilan["id"]; ?>">
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <base href="<?=URL?>/">
    <?php include('header.php'); ?>
</head>
<body>
<?php include('ust.php'); ?> 
<?php if ($ilan["id"] != $id) header('location:ilanara?kontrol=yok'); ?>
<section class="detay-ust mb-7"> 
    <div class="border-bottom pt-3 pb-3 bg-white d-none d-md-block box-shadow">
        <div class="container"> 
            <div class="row">
                <div class="col-xl-9 col-lg-8 col-md-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php"><i class="fa fa-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="ilanara?emlaktipi=<?php echo $itip["id"]; ?>"><?php echo $itip["ad"]; ?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="ilanara?emlaktipi=<?php echo $itip["id"]; ?>&emlaksekli=<?php echo $sekil["id"]; ?>"><?php echo $sekil["baslik"]; ?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="ilanara?emlaktipi=<?php echo $itip["id"]; ?>&emlaksekli=<?php echo $sekil["id"]; ?>&kategori=<?php echo $kat["kat_id"]; ?>"><?php echo $kat["kat_adi"]; ?></a>
                        </li>
                    </ol>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-12">
                </div>
            </div>
        </div>
    </div> 
    <?php if($ilan["ilan_sifre"]!="" AND $_SESSION["ilan_sifre"][$ilan["seo"]][$ilan["id"]]!=$ilan["ilan_sifre"]) { ?>
    <div class="d-flex align-items-center justify-content-center py-lg-9 bg-light">
        <div class="container"> 
            <div class="row">
                <div class="col-lg-3 mb-4">
                    <div class="card p-1 hover-box"> 
                        <div id="carouselExampleControls" class="carousel slide liste-slide" data-ride="carousel">
                          <div class="carousel-inner"> 
                                <?php 
                                
                                    $i=0;
                                    $resimler=$vt->query("SELECT * FROM emlak_resim WHERE emlakno = '{$ilan["emlakno"]}' ORDER BY sira ASC",PDO::FETCH_ASSOC);
                                    foreach($resimler AS $resim) {
                                ?>
                                <div class="carousel-item <?php if($i==0) { ?> active <?php } ?>">
                                  <img class="d-block w-100" src="<?php echo RESIM.$resim["resimad"] ?>" alt="<?php echo $ilan["baslik"] ?>">
                                </div>
                                <?php $i++; } ?>
                              </div>
                              <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                              </a>
                              <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                              </a>
                        </div>
                        <div class="ozet"> 
                        
                            <span class="badge bg-primary text-white one-cikan"><strong><?php echo ucwords(mb_strtolower($itip["ad"])); ?></strong></span>
                            <div class="row d-flex px-1 align-items-center justify-content-center">
                            <?php
                                $ilandetay=$vt->query("SELECT emlak_form.*, emlak_ilandetay.eformdetay AS dbaslik, emlak_form.ad AS eformad, emlak_form.ikon AS ikon FROM emlak_form, emlak_ilandetay WHERE emlak_ilandetay.emlakno = '{$ilan["emlakno"]}' AND emlak_form.id = emlak_ilandetay.formid AND emlak_form.durum = 0 AND emlak_form.ozet = 1 ORDER BY emlak_form.sira ASC LIMIT 4")->fetchAll(); 
                                foreach ($ilandetay AS $detay) {                                              
                            ?>
                            <div class="col py-3 text-center" data-toggle="tooltip" title="<?php echo $detay["eformad"] ?>">
                                <i class="fa <?php echo $detay["ikon"] ?> fs-18 text-primary mr-1"></i><span class="max-width-ozet"><?php echo $detay["dbaslik"] ?></span> 
                            </div>  
                            <?php } ?>                                       
                            </div>
                        </div>
                        <div class="p-2"> 
                            <h5 class=" mt-1 mb-2 font-weight-bold" style="/* text-transform: uppercase; */height: 46px;overflow: hidden;"><a href="/<?=$ilan["seo"];?>-<?=$ilan["emlakno"];?>-ilan-<?=$ilan["id"];?>"><?=$ilan["baslik"];?></a></h5>
                            <p class="mb-5">
                                <i class="icon icon-location-pin"></i> <?php echo ucwords(mb_strtolower($il["adi"])); ?>
                                <?php echo ucwords(mb_strtolower($ilce["ilce_title"])); ?>
                                <?php echo ucwords(mb_strtolower($mahalle["mahalle_title"])); ?>
                            </p>
                            <ul class="row mb-4">
                                <li class="col-6">
                                    <small class="btn btn-block btn-white btn-sm"><i class="fa fa-calendar-o"></i> <?php echo $ilan["eklemetarihi"]; ?></small>
                                </li>  
                                <li class="col-6">
                                    <span class="btn btn-block btn-white btn-sm"><i class="fa fa-tag"></i> <strong><?php echo rakam($ilan["fiyat"]); ?></strong> <?php echo $ilan["fiyatkur"]; ?></span>
                                </li>  
                            </ul> 
                            <div class="row ilan-meta no-gutters">
                                <div class="col-4 text-center p-1">
                                    <a href="https://wa.me/<?php echo clean($site["gsm"]); ?>" target="_blank" class="btn btn-success btn-block">
                                        <i class="fa fa-whatsapp fa-lg"></i>
                                    </a>
                                </div>
                                <div class="col-4 text-center p-1">
                                    <a href="mailto:<?php echo $site["email"]; ?>" class="btn btn-primary btn-block">
                                        <i class="fa fa-envelope fa-lg"></i>
                                    </a>
                                </div>
                                <div class="col-4 text-center p-1">
                                    <a href="tel:<?php echo $site["sabittel"]; ?>" class="btn btn-danger btn-block">
                                        <i class="fa fa-phone fa-lg"></i>
                                    </a>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <?php
                            if(isset($_POST["ilanSifreControl"])) {
                                if($_POST["ilan_sifre"]==$ilan["ilan_sifre"]) {
                                    $_SESSION["ilan_sifre"][$ilan["seo"]][$ilan["id"]]=true;
                                    go($_SERVER['HTTP_REFERER']);
                                } else {
                                    hata_alert("Yanlış bir şifre girdiniz. Lütfen tekrar deneyiniz.");
                                }
                            }
                        ?>
                        <h3 class="card-header f-18"><i class="fa fa-lock fa-lg text-warning mr-3"></i> Şifreli İlan</h3>
                        <div class="card-body d-flex align-items-center justify-content-center" style="height: 443px;"> 
                            <div class="d-block text-center">
                                <p class="alert alert-primary d-lg-block d-none">
                                    <i class="fa fa-info-circle"></i> Lütfen sahip olduğunuz ilan şifresini giriniz.
                                </p>
                                <p class="alert alert-primary d-lg-none d-block">
                                    <i class="fa fa-info-circle"></i> Lütfen sahip olduğunuz şifreyi giriniz.
                                </p>
                                <form class="form" action="" method="POST">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <input type="password" name="ilan_sifre" class="form-control input-lg" placeholder="Şifre Giriniz" />
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <button class="btn btn-warning btn-block" name="ilanSifreControl" style="height:51px">Gönder</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <a href="index.php"><img src="<?=$ayar["mobilsitelogo"];?>" width="<?=$ayar["mobillogouzunluk"];?>"></a> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-4"> 
                    <div class="card mb-5" style="height: 515px;">
                        <div class="card-body  item-user">
                            <div class="profile-pic mb-0 p-3">
                                <ul>
                                   <li style="" class="item">
                                        <div class="med ia mt-0 text-center">
                                            <a href="/danisman/<?=$dan["id"];?>">
                                               <?php if ($yonetici["resim"] == "") { ?>
                                                <img src="/uploads/resim/resim.png" width="100" class="brround avatar-xxl">
                                                <?php } else { ?>
                                                <?php if ($yonetici["id"] == $sube["yetkiliuye"]): ?>
                                                <img src="/<?=$yonetici["resim"];?>" width="100" class="brround avatar-xxl">
                                                <?php else: ?>
                                                <img src="/<?=$yonetici["resim"];?>" width="100" class="brround avatar-xxl mb-3">
                                                <?php endif; ?>
                                                <?php } ?>
                                            </a>
                                            <div class="">
                                                <p class="m-0 mt-1">Yetkili Kişi</p>
                                                <a href="/danisman/<?=$yonetici["id"];?>" class="m-0 mt-1">
                                                <h6 class="mb-1 mt-1">
                                                    <strong><?=$yonetici["adsoyad"];?></strong>
                                                </h6>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <div class="border-bottom mb-3 pb-3">
                                    <a href="/danisman/<?=$yonetici["id"];?>" class="text-dark">
                                        <h6 class="mt-3 mb-1 font-weight-semibold"></h6>
                                    </a>
                                </div>
                                <?php if ($yonetici["tel"] != "") { ?>
                                <h6>
                                    <a class="btn btn-success btn-block p-3 mb-2" href="tel:<?=$yonetici["tel"];?>" class="text-body">
                                    <i class="fa fa-phone fa-2x float-left ml-2"></i> <?=$yonetici["tel"];?></a>
                                </h6>
                                <?php } ?>
                                <?php if ($yonetici["gsm"] != "") { ?>
                                <h6>
                                    <a class="btn btn-success btn-block p-3 mb-2" href="tel:<?=$yonetici["gsm"];?>" class="text-body">
                                        <i class="fa fa-phone fa-2x float-left ml-2"></i> <?=$yonetici["gsm"];?>
                                    </a>
                                </h6>
                                <?php } ?>
                                <?php if ($_SESSION["id"] != $yonetici["id"]): ?>
                                    <?php if ($_SESSION["uyelogin"]): ?>
                                        <h6>
                                            <a class="btn btn-danger btn-block p-3 text-white" data-toggle="modal" data-target="#mesajGonder">
                                                <i class="fa fa-envelope fa-2x float-left ml-2"></i> Mesaj Gönder
                                            </a>
                                        </h6>
                                    <?php else: ?>
                                         <h6>
                                            <a href="giris-yap" target="_blank" onClick="alert('Mesaj gönderebilmek için giriş yapmalısınız.')" class="btn btn-danger btn-block p-3 text-white">
                                                <i class="fa fa-envelope fa-2x float-left ml-2"></i> Mesaj Gönder
                                            </a>
                                        </h6>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php
                                    if (isset($_POST["danmesajgonder"])) {
                                        $kime = $_POST["kime"];
                                        $ilan_baslik = $_POST["ilan_baslik"];
                                        $mesaj = $_POST["mesaj"];
                                        $tarih = date('d/m/Y');
                                        $mesaj_ekle = mysql_query("INSERT INTO emlak_dangelenmesaj (kimden, kime, mesaj, tarih) values ('".$_SESSION["id"]."','".$ilan["yonetici_id"]."','".$mesaj."','".$tarih."')");
                                        mail_gonder($yonetici['email'], "Sayın ".$yonetici["adsoyad"].", ".$ilan_baslik." ilanınız için yeni bir mesajınız bulunuyor.", "Sayın ".$yonetici["adsoyad"].", ".$ilan_baslik." ilanınız için yeni bir yeni mesajınız bulunuyor.");
                                        sms_gonder($yonetici['id'],"Sayın ".$uye["adsoyad"]."", " üyelik paketiniz onaylanmıştır.");
                                        onay_alert("Mesajınız başarılı bir şekilde gönderilmiştir.");
                                    }
                                ?>
                                <form action="" method="post">
                                <div class="modal fade" id="mesajGonder" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="mesajGonderLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title text-center" id="staticBackdropLabel">Mesaj Gönder</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                       <div class="card overflow-hidden box-shadow-0 kategori-ilan-liste mb-5">
                                            <div class="d-md-flex" style="background: #eee;">
                                                <div class="item-card9-img">
                                                    <div class="item-card9-imgs kategori-list-img">
                                                        <?php if ($resim["resimad"] == "") { ?>
                                                        <img src="/uploads/resim/uyeresimyok.png" class="cover-image">
                                                        <?php } else { ?>
                                                        <img src="/uploads/resim/<?php echo $resim["resimad"]; ?>" class="cover-image">
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="card border-0 mb-0 pl-2 box-shadow-0">
                                                    <div class="card-body pl-1 pb-0">
                                                        
                                                        <?php if ($ilan["fiyat"]==0) { ?>
                                                        <h4 style="font-size: 22px;" class="mb-4">Görüşülür</h4>
                                                        <?php } else { ?>
                                                        <h4 style="font-size: 22px;" class="mb-4"><strong><?php echo rakam($ilan["fiyat"]); ?> </strong><?php echo $ilan["fiyatkur"]; ?></h4>
                                                        <?php } ?>
    
                                                        <h4 style="font-size: 15px;" class="mb-3">
                                                            <strong>
                                                                <a href="/ilanara/?emlaktipi=<?php echo $itip["id"]; ?>"><?php echo $itip["ad"]; ?></a>
                                                                <span class="m-2 text-muted">|</span>
                                                                <a href="/ilanara/?emlaksekli=<?php echo $sekil["id"]; ?>"><?php echo $sekil["baslik"]; ?></a>
                                                                <span class="m-2 text-muted">|</span>
                                                                <a href="/ilanara/?kategori=<?php echo $kat["kat_id"]; ?>"><?php echo $kat["kat_adi"]; ?> </a>
                                                            </strong>
                                                        </h4>
                                                        <h5 class="mb-1"><?php echo $ilan["baslik"]; ?></h5>
                                                        <a href="/ilanara/?il=<?php echo $il["sehir_key"] ?>" class="btn mb-3 box-shadow-0 float-left pl-0"><i class="fa fa-map-marker mr-1 text-danger"></i>
                                                            <?php echo $il["adi"] ?>
                                                        </a>
                                                        <div class="item-card9">
                                                            <a href="yukari-ouml-ve-ccedil-lerde-ccedil-ok-temiz-sakin-otoparkli-ouml-n-uuml-a-ccedil-ik-ve-merkezi-5481-ilan-352" class="text-dark"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <input class="input--style-4" style="background: #eee;" type="text" disabled name="kime" placeholder="Kime: <?php echo $yonetici["adsoyad"]; ?>">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input class="input--style-4" type="text" name="ilan_baslik" value="<?php echo $ilan["baslik"]; ?>">
                                                    </div>
                                                    <div class="col-md-12 mt-5">
                                                        <div class="form-group">
                                                            <textarea class="input--style-4 form-control" name="mesaj" rows="3" placeholder="Mesajınız:">Merhaba, <?php echo $ilan["emlakno"] ?> no.lu ilanınız hakkında detaylı bilgi almak için benimle iletişime geçmenizi rica ediyorum. Teşekkürler, İyi çalışmalar.</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-light p-1 pl-7 pr-7" data-dismiss="modal">İptal</button>
                                        <button type="submit" name="danmesajgonder" class="btn btn-danger p-1 pl-7 pr-7">Gönder</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-left">
                                <a href="/danisman/<?=$yonetici["id"];?>" class="btn-block text-center">
                                    <i class="fa fa-user"></i> Diğer İlanları
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } else { ?>
    <?php if($sekil["kat_tipi"] == "proje"): ?>
    <div class="">
        <div class="row">
            <div class="proje-title">
                <?php $proje_kapak = $vt->query("SELECT * FROM proje_kapak WHERE emlakno = {$ilan["emlakno"]}")->fetch(); ?>
                <img class="img-fluid" src="uploads/proje_resim/<?php echo $proje_kapak["proje_kapak"]; ?>" alt=""> <!--<?=RESIM.$resim["resimad"];?> -->
                <div class="title-in">
                    <div class="container"> 
                        <div class="row h-100">
                            <div class="col-lg-4 d-none d-lg-block">
                                <div class="p-5 m-5">
                                    <div class="bg-white p-4 pl-5 pr-5 shadow-1 d-none d-xl-block d-lg-block d-md-block d-sm-block">
                                        <div class="row"> 
                                            <div class="col-lg-3">                                                
                                                <?php if ($yonetici_sube["resim"]!=""): ?>
                                                    <img src="<?php echo $yonetici_sube["resim"]; ?>" alt="">
                                                <?php else: ?>
                                                    <img src="<?php echo $yonetici["resim"]; ?>" alt="">
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-lg-9">                                                
                                                <h4><strong><?php echo $yonetici["adsoyad"]; ?></strong></h4>
                                                <h6><i class="fa fa-map-marker"></i> <?=$il["adi"];?> <?=$ilce["ilce_title"];?>    </h6>
                                                <h5><strong><?php echo $yonetici_sube["adi"]; ?></strong></h5>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="tel:<?php echo $yonetici["tel"]; ?>" name="danmesajgonder" class="btn btn-dark btn-block"><i class="fa fa-phone"></i> <strong>BİZE ULAŞIN</strong></a> 
                                </div>
                            </div>
                            <div class="col-lg-4"> 
                            </div>
                            <div class="col-lg-4">
                                <div class="card h-100 p-2" style="background: rgba(60,77,83,.87); border: none;">
                                    <div class="card-body">
                                        <form action="" method="post"> 
                                            <div class="overflow-hidden box-shadow-0 kategori-ilan-liste mb-5"> 
                                                <div class="border-0 mb-0 pl-2 box-shadow-0">
                                                    <div class="card-body pl-1 pb-0"> 
                                                        <h3 style="white-space:nowrap; overflow:hidden;" class="text-white mb-4"><strong><?php echo $ilan["baslik"]; ?></strong></h3>
                                                        <div class="row text-white">
                                                            <div class="col-lg-3 col-md-3 col-3 d-flex h-100 justify-content-center align-items-center">
                                                                <span class="icon-service1" style="background:#ffffff38; width:50px; height:50px; "> 
                                                                    <i style="color:#fff; font-size:1.5rem;" class="fa fa-phone"></i>
                                                                </span>
                                                            </div>
                                                            <div class="col-lg-9 col-md-9 col-9">
                                                                <h5>BİZE ULAŞIN</h5>
                                                                <h3><strong><?php echo $yonetici["tel"]; ?></strong></h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">  
                                                            <?php if ($_SESSION["uyelogin"]): ?>                                     
                                                            <input class="form-control p-5" type="text" name="ad_soyad" placeholder="Adınız Soyadınız" value="<?php echo $yonetici["adsoyad"]; ?>">
                                                            <?php else: ?> 
                                                            <input class="form-control p-5" type="text" name="ad_soyad" placeholder="Adınız Soyadınız" value="">
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">                                        
                                                            <?php if ($_SESSION["uyelogin"]): ?>                                     
                                                            <input class="form-control p-5" type="text" name="telefon" placeholder="Telefon" value="">
                                                            <?php else: ?> 
                                                            <input class="form-control p-5" type="text" name="telefon" placeholder="Telefon" value="">
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <textarea class="form-control p-3 pb-3" name="mesaj" rows="3" placeholder="Mesajınız:">Merhaba, <?php echo $ilan["emlakno"] ?> no.lu ilanınız hakkında detaylı bilgi almak için benimle iletişime geçmenizi rica ediyorum. Teşekkürler, İyi çalışmalar.</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <button type="submit" name="projemesajgonder" class="btn btn-success btn-lg btn-block"><strong>BİLGİ AL</strong></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </form>
                                        <?php  
                                            if (isset($_POST["projemesajgonder"])) {
                                                if ($_SESSION["uyelogin"]) {
                                                    $kime = $_POST["kime"];
                                                    $ilan_baslik = $_POST["ilan_baslik"];
                                                    $mesaj = $_POST["mesaj"];
                                                    $tarih = date('d/m/Y');
                                                    $mesaj_ekle = mysql_query("INSERT INTO emlak_dangelenmesaj (kimden, kime, mesaj, tarih, tel) values ('".$_SESSION["id"]."','".$ilan["yonetici_id"]."','".$mesaj." Numaram: ".$_POST["telefon"]."','".$tarih."','".$_POST["telefon"]."')");
                                                    mail_gonder($dan['email'], "Sayın ".$dan["adsoyad"].", ".$ilan_baslik." ilanınız için yeni bir mesajınız bulunuyor.", "Sayın ".$dan["adsoyad"].", ".$ilan_baslik." ilanınız için yeni bir yeni mesajınız bulunuyor.");
                                                    sms_gonder($dan['id'],"Sayın ".$uye["adsoyad"]."", " üyelik paketiniz onaylanmıştır.");
                                                    onay_alert("Mesajınız başarılı bir şekilde gönderilmiştir.");
                                                } else {
                                                    go("/giris-yap");
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid proje-alt-baslik">
        <div class="container">
            <div class="offset-lg-1 col-lg-10 justify-content-center">
                <div class="row">
                    <div class="col-lg col-md-6 col-12 mb-5 mb-lg-auto">
                        <div class="row">
                            <div class="col-3 text-center">
                                <i class="icon icon-tag fa-3x text-warning"></i>
                            </div>
                            <div class="col-9"> 
                            <?php if ($ilan["fiyat"]==0) { ?>
                                Görüşülür
                            <?php } else { ?>
                            Fiyat <p class="h4 p-0 m-0 text-success"><strong><?php echo $ilan["fiyat"] ?> <?php echo $ilan["fiyatkur"]; ?></strong></p>
                            <?php } ?>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 mb-5 mb-lg-auto">
                        <div class="row">
                            <div class="col-3 text-center">
                                <i class="icon icon-location-pin fa-3x text-warning"></i>
                            </div>
                            <div class="col-9">
                                Bulunduğu Yer
                                <p class="h4 p-0 m-0"><strong><?=$il["adi"];?> <?=$ilce["ilce_title"];?></strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg col-md-6 col-12 mb-5 mb-lg-auto">
                        <div class="row">
                            <div class="col-3 text-center">
                                <i class="fa fa-dropbox fa-3x text-warning"></i>
                            </div>
                            <div class="col-9">
                                İlan No                      
                                <p class="h4 p-0 m-0"><strong><?php echo $ilan["emlakno"]; ?></strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg col-md-6 col-12 mb-5 mb-lg-auto">
                        <div class="row">
                            <div class="col-3 text-center">
                                <i class="fa fa-dropbox fa-3x text-warning"></i>
                            </div>
                            <div class="col-9">
                                Referans No                      
                                <p class="h4 p-0 m-0"><strong><?php echo $ilan["referans_kodu"]; ?></strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg col-md-6 col-12 mb-5 mb-lg-auto">
                        <div class="row">
                            <div class="col-3 text-center">
                                <i class="icon icon-calendar fa-3x text-warning"></i>
                            </div>
                            <div class="col-9">
                                İlan Tarihi                      
                                <p class="h4 p-0 m-0"><strong><?php echo $ilan["eklemetarihi"]; ?></strong></p>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div> 
    <div class="container pt-lg-7 mt-4">
        <div class="row">
            <div class="col-lg-6 mb-4 pt-5">
                <div class="row"> 
                    <div class="col-md-12">
                        <h2 class="mb-5">Proje Görselleri</h2>
                    </div>
                    <div class="col-md-10">
                        <?php $emlak_resim_1 = $vt->query("SELECT * FROM emlak_resim WHERE emlakno = '{$ilan["emlakno"]}' AND kapak = 1 LIMIT 1")->fetch(); ?>
                        <div id="am" class="buyuk-resim" style="background: url('<?=RESIM.$emlak_resim_1["resimad"];?>');">
                            <div class="tum-resim-goster d-none">
                                <i class="fa fa-file-image-o mr-3"></i> Tüm Fotoğraflar
                            </div>
                            <div class="resimD-icon">
                                <i class="fa fa-file-image-o fa-5x"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <?php
                            if ($resim_limit<3):
                                $emlak_resim_1 = $vt->query("SELECT * FROM emlak_resim WHERE emlakno = '{$ilan["emlakno"]}' AND kapak != 1 ORDER BY sira DESC LIMIT {$resim_limit}")->fetchAll();
                            else:
                                $emlak_resim_1 = $vt->query("SELECT * FROM emlak_resim WHERE emlakno = '{$ilan["emlakno"]}' AND kapak != 1 ORDER BY sira DESC LIMIT 3")->fetchAll();
                            endif; 
                        ?>
                        <?php
                            foreach ($emlak_resim_1 AS $e_resim) {
                        ?>
                        <div class="d-none d-md-block">
                            <a class="kucuk-resim" style="background: url('<?=RESIM.$e_resim["resimad"];?>');">
                                <img class="img-responsive d-none" src="<?=RESIM.$e_resim["resimad"];?>">
                                <div class="resimD-icon">
                                    <i class="fa fa-file-image-o fa-2x"></i>
                                </div>
                            </a>
                        </div>
                        <?php } ?>
                        <div id="lightgallery">
                            <?php $emlak_resim_say = $vt->query("SELECT * FROM emlak_resim WHERE emlakno = '{$ilan["emlakno"]}' LIMIT {$resim_limit}"); ?>
                                <div data-src="<?=RESIM.$resim["resimad"];?>">
                                    <a href="" class="kucuk-resim" style="background: #fff; text-decoration: none; margin:0;">
                                        <img class="img-responsive d-none" src="<?=RESIM.$resim["resimad"];?>">
                                        <p style="color:#232323ba;" class="text-center pt-3 h1 font-weight-light">+<?php echo $emlak_resim_say->rowCount(); ?><smal class="h6"></smal></p>
                                        <div class="resimD-icon" style="top: 0; position: absolute;">
                                            <i class="fa fa-search-plus fa-2x"></i>
                                        </div>
                                    </a>
                                </div>
                                <?php
                                    $resim_tumu = $vt->query("SELECT * FROM emlak_resim WHERE emlakno = '{$ilan["emlakno"]}' LIMIT 1,{$resim_limit}")->fetchAll();
                                    foreach ($resim_tumu AS $resim) {
                                ?>
                                    <div class="d-none" data-src="<?=RESIM.$resim["resimad"];?>">
                                        <a href="" class="kucuk-resim" style="background: #fff; text-decoration: none; margin:0;">
                                            <img class="img-responsive d-none" src="<?=RESIM.$resim["resimad"];?>">
                                        </a>
                                    </div>
                                <?php } ?>
                        </div>
                        <script type="text/javascript">
                            $(document).ready(function(){
                                $('#lightgallery').lightGallery();
                            });
                        </script> 
                    </div>
                </div>  
            </div>
            <div class="col-lg-6 p-5 mb-4">
                <h2 class="mb-5">Proje Hakkında</h2>
                <div class="card">
                    <div class="card-body mb-5 p-6" style="max-height:375px; overflow-y:auto;">
                            <?php echo $ilan["icerik"]; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <h2 class="mb-5">Proje Özeti</h2>
                <div class="card mb-5">
                    <div class="card-body p-6">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="border-bottom p-3">
                                    İlan No
                                    <span class="pull-right"><strong><?=$ilan["emlakno"];?></strong></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border-bottom p-3">
                                    Referans No
                                    <span class="pull-right"><strong><?php echo $ilan["referans_kodu"]; ?></strong></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border-bottom p-3">
                                    İlan Tipi
                                    <span class="pull-right pl-3 pr-3" style="background: <?=$itip["baslikrenk"];?>; color: <?=$itip["yazirenk"];?>;"><strong><?=$itip["ad"];?></strong></span>
                                </div>
                            </div>
                            <?php
                                
                                $emlak_ilan_detay = $vt->query("SELECT emlak_form.*, emlak_ilandetay.eformdetay AS dbaslik, emlak_form.ad AS eformad FROM emlak_form, emlak_ilandetay WHERE emlak_ilandetay.emlakno = '{$ilan["emlakno"]}' AND emlak_form.id = emlak_ilandetay.formid AND emlak_form.durum = 0 ORDER BY emlak_form.sira ASC")->fetchAll();
                                foreach ($emlak_ilan_detay AS $detay) { 
                            ?>
                            <div class="col-md-6">
                                <div class="border-bottom p-3">
                                    <?=$detay["eformad"];?>
                                    <span class="pull-right"><strong><?php if ($detay["dbaslik"] == "Seçiniz" || $detay["dbaslik"] == "") { ?> - <?php } else { ?> <?=$detay["dbaslik"];?> <?php } ?></strong></span>
                                </div>
                            </div>  
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
             $emlak_projeler=$vt->query("SELECT * FROM projeler WHERE emlakno = {$ilan["emlakno"]}"); 
             $emlak_projeler->execute();
             if ($emlak_projeler->rowCount()>0):
            ?>
            <div class="col-lg-12">
                <h2 class="mb-5">Kat Planları</h2>  
                <div id="kat_planlari" class="row">
                <?php
                    $kat_planlari = $vt->query("SELECT * FROM projeler WHERE emlakno = {$ilan["emlakno"]} ORDER BY kat_oda ASC")->fetchAll();
                    foreach ($kat_planlari as $plan):
                ?>
                <div class="col-lg-4" data-src="uploads/proje_resim/<?php echo $plan["plan_resim"]; ?>">
                    <div class="card mb-5">
                        <div class="card-body">
                            <a href="#">
                                <img class="img-responsive" src="uploads/proje_resim/<?php echo $plan["plan_resim"]; ?>" alt="<i class='fa fa-bed text-success'></i> <?php echo $plan["kat_oda"] ?> <i class='fa fa-align-justify text-success'></i> <?php echo $plan["kat_mkare"] ?>M2 <i class='fa fa-home text-success'></i> <?php echo $plan["kat_sayi"] ?>">
                            </a>
                            <div class="text-center">
                            <p class="h4 pt-4 pb-1"><?php echo $plan["kat_oda"] ?> <?php echo $plan["kat_mkare"] ?>M2</p>
                            <p class="h4 pt-3 pb-1"><?php echo $plan["kat_sayi"] ?></p> 
                            <p class="h4 pt-3 pb-5"><i class='fa fa-bed text-success'></i> <?php echo $plan["kat_oda"] ?> <i class='fa fa-align-justify text-success'></i> <?php echo $plan["kat_mkare"] ?>M2 <?php if ($ilan["fiyatkur"]!=""): ?><i class="fa fa-tag text-success"></i> <?php echo $plan["kat_fiyat"] ?><?php echo $ilan["fiyatkur"] ?><?php endif; ?></p> 
                            </div>
                        </div>
                    </div>             
                </div> 
                <?php endforeach; ?> 
                </div>
            </div> 
            <?php endif; ?> 
            <?php
             $emlak_ozellikleri=$vt->query("SELECT * FROM emlak_ozellikdetay WHERE ilanid = {$ilan["id"]}"); 
             $emlak_ozellikleri->execute();
             if ($emlak_ozellikleri->rowCount()>0):
            ?>
            <div class="col-lg-12">
                <h2 class="mb-5">Proje Özellikleri</h2> 
                <div class="card mb-5">
                    <div class="card-body p-7">
                        <?php
                            $ozelliktip = mysql_query("SELECT * FROM emlak_ozelliktip where id");
                            while($otip = mysql_fetch_array($ozelliktip)) {
                                $ozellikilanid3 = mysql_query("SELECT * FROM emlak_ozellikdetay where ilanid = '".$ilan["id"]."' && ozelliktip = '".$otip["id"]."'");
                                $ilanid2 = mysql_fetch_array($ozellikilanid3);
                        ?>
                        <?php if (mysql_num_rows($ozellikilanid3)) { ?>
                        <h5 class="border-bottom pb-3 mb-3"><strong><?=$otip["ad"];?></strong></h5>
                        <div class="row mb-2">
                            <?php
                                $ozellikilanid = $vt->query("SELECT * FROM emlak_ozellikdetay where ilanid = '".$ilan["id"]."' && ozelliktip = '".$otip["id"]."'");
                                while($ilanid = $ozellikilanid -> fetch()) {
                                    $saybeni = $ozellikilanid -> rowCount();
                            ?>
                            <div class="col-md-3 col-xs-6">
                                <p><i class="fa fa-check-circle fa-lg" style="color: #2ec995;"></i> <?=$ilanid["ad"];?></p>
                            </div>
                            <?php } ?>
                        </div>
                        <?php } ?>
                    <?php } ?>
                    </div>
                </div>  
            </div>
            <?php endif; ?>
            <script type="text/javascript">
            $(document).ready(function(){
                $('#kat_planlari').lightGallery();
            });
            </script> 
            <?php if ($ilan["sokak"]!=""): ?>
            <div class="col-lg-6">
                <h2 class="mb-5">Sokak Görünümü</h2>  
                <div class="card mb-5 proje-ikili-ortala">
                    <div class="card-body text-center">                        
                        <?=$ilan["sokak"]?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if ($ilan["video"]!=""): ?>
            <div class="col-lg-6 mb-4">
                <h2 class="mb-5">Proje Videosu</h2> 
                <div class="card proje-ikili-ortala">
                    <div class="card-body">
                        <?php if ($ilan["video"] == ""): ?>
                            <div class="text-center p-8">
                                <i class="fa fa-video-camera fa-5x text-light"></i>
                                <p class="h4 font-weight-light mt-8 mb-8 text-dark">İLANIN VİDEO GÖRÜNÜMÜ BULUNMUYOR</p>
                            </div>
                        <?php else: ?>
                            <div class="text-center">
                                <?=html_encode($ilan["video"]);?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if ($ilan["enlem"] != "" || $ilan["boylam"] != ""): ?> 
            <div class="col-lg-12">
                <h2 class="mb-5">Proje Adresi</h2> 
                <div class="card mb-5">
                    <div class="card-body">
                    <?php if ($ilan["enlem"] == "" || $ilan["boylam"] == ""): ?>
                        <div class="text-center p-8">
                            <i class="fa fa-warning fa-5x text-light"></i>
                            <p class="h4 font-weight-light mt-8 mb-8 text-dark">İLANIN HARİTA BİLGİSİ BULUNMUYOR</p>
                        </div>
                    <?php else: ?> 
                    <div id="map"></div>  
                        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA301piyuyufUrduxQlk7H0ji1DfNRJde8&callback=initMap&v=weekly" defer></script> 
                        <style>
                            #map {
                                height: 500px;
                            }
                        </style>
                        <script type="text/javascript">
                            let map;
                        
                            function initMap() {
                                const mapOptions = {
                                    zoom: <?php echo $ilan["zoom"] ?>,
                                    center: { lat: <?php echo $ilan["enlem"] ?>, lng: <?php echo $ilan["boylam"] ?> },
                                };
                        
                                map = new google.maps.Map(document.getElementById("map"), mapOptions);
                        
                                const marker = new google.maps.Marker({
                                    // The below line is equivalent to writing:
                                    // position: new google.maps.LatLng(<?php echo $ilan["enlem"] ?>, <?php echo $ilan["boylam"] ?>)
                                    position: { lat: <?php echo $ilan["enlem"] ?>, lng: <?php echo $ilan["boylam"] ?> },
                                    map: map,
                                });
                                // You can use a LatLng literal in place of a google.maps.LatLng object when
                                // creating the Marker object. Once the Marker object is instantiated, its
                                // position will be available as a google.maps.LatLng object. In this case,
                                // we retrieve the marker's position using the
                                // google.maps.LatLng.getPosition() method.
                                const infowindow = new google.maps.InfoWindow({
                                    content: "<?php echo $ilan["baslik"] ?>",
                                });
                        
                                google.maps.event.addListener(marker, "click", () => {
                                    infowindow.open(map, marker);
                                });
                            }
                        
                            window.initMap = initMap;
                        </script>
                    <?php endif; ?>
                    </div> 
                    
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    <?php if ($sekil["kat_tipi"]!="proje"): ?>
    <div class="pt-5 pb-2">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-8 col-md-12 mb-2 col-12">
                    <h1 class="font-weight-light mb-2 h3 text-muted font-weight-semibold"><?php echo $ilan["baslik"]; ?></h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><i class="fa fa-map-marker text-warning"></i></li>
                        <li class="breadcrumb-item">
                            <?php echo ucwords(mb_strtolower($il["adi"])); ?>
                        </li>
                        <li class="breadcrumb-item"><?php echo ucwords(mb_strtolower($ilce["ilce_title"])); ?></li>
                        <li class="breadcrumb-item"><?php echo ucwords(mb_strtolower($mahalle["mahalle_title"])); ?></li>
                    </ol>
                </div>
                <div class="col-xl-2 col-lg-8 col-md-12 col-12 mb-4">
                    <div class="text-lg-right">
                        <?php if($ilan["fiyat"]==0) { ?>
                        <h2 class="text-muted pt-1">Görüşülür</h2>
                        <?php } else { ?>
                        <h3 class="text-muted pt-1"><strong><?=rakam($ilan["fiyat"]);?></strong> <small><?=$ilan["fiyatkur"];?></small></h3>
                        <?php } ?>

                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="row no-gutters">
                    
                        <div class="col-xl-9 col-9 col-lg-4 col-md-12 mb-4">
                            <a class="btn btn-block btn-warning btn-lg rounded-0" href="" data-toggle="modal" data-target="#paylas"><i class="fa fa-share"></i> <strong>İLANI PAYLAŞ</strong> </a>
                            <div class="modal fade" id="paylas" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="mesajGonderLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-center" id="staticBackdropLabel">Paylaş</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center">
                                                <?php include 'sistem/paylas.php'; ?>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light p-1 pl-7 pr-7" data-dismiss="modal">İptal</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-3 col-lg-4 col-md-12 mb-4">
                            
                                                               
                            <?php $favori = $vt->query("SELECT * FROM favoriler WHERE uye_id = '{$_SESSION["id"]}' AND ilan_id = '{$ilan["id"]}' ")->fetch(); ?>
                            <?php if(!$_SESSION["uyelogin"]) { ?>
                            <a href="#" data-toggle="modal" id="girisKontrol3<?php echo $ilan["id"] ?>" class=" btn btn-block btn-warning btn-lg mt-0 rounded-0" style="">
                                <i class="fa fa-heart-o fa-lg"></i>
                            </a>
                            <?php } else { ?>
                            <a href="#" id="favEkle3<?php echo $ilan["id"] ?>" data-toggle="modal" class="btn btn-block btn-warning btn-lg mt-0 rounded-0" style="display:<?php if ($favori) { ?>none<?php } ?>">
                                <i class="fa fa-heart-o fa-lg"></i>
                            </a>
                            <?php } ?>
                            <a href="#" id="favCikar3<?php echo $ilan["id"] ?>" data-toggle="modal" class="btn btn-block btn-warning btn-lg mt-0 rounded-0" style="display:<?php if (!$favori) { ?>none<?php } ?>">
                                <i class="fa fa-heart fa-lg"></i>
                            </a> 
                            <script> 
                            $('#girisKontrol3<?php echo $ilan["id"] ?>').click(function ilanId(e){  
                                alert('Favorilere ekleyebilmeniz için lütfen üye girişi yapınız.');
                                window.location.href = '<?php echo $ayar["site_url"] ?>giris-yap';
                            });
                            $('#favEkle3<?php echo $ilan["id"] ?>').click(function ilanId(e){  
                                
                                $.post("index.php?do=ajax_favori&favori=ekle&ilanId=<?php echo $ilan["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>",function(data){
                                    $('#gosterx').html(data);
                                }); 
                                
                                
                                $('#favEkle3<?php echo $ilan["id"] ?>').css({ 'display': 'none' }); 
                                $('#favCikar3<?php echo $ilan["id"] ?>').css({ 'display': 'block' }); 
                    			
                            });
                            $('#favCikar3<?php echo $ilan["id"] ?>').click(function(){ 
                                
                                $.post("index.php?do=ajax_favori&favori=sil&ilanId=<?php echo $ilan["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>", function(data){
                                    $("#gosterx").html(data);
                                }); 
                                 
                                $('#favEkle3<?php echo $ilan["id"] ?>').css({ 'display': 'block' }); 
                                $('#favCikar3<?php echo $ilan["id"] ?>').css({ 'display': 'none' });  
                                
                            }); 
                            </script>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <?php
            if (isset($_POST["mesajgonder"])) {
                $adsoyad    = $_POST["adsoyad"];
                $email      = $_POST["email"];
                $tel        = $_POST["tel"];
                $gsm        = $_POST["gsm"];
                $konu       = $_POST["konu"];
                $mesaj      = $_POST["mesaj"];
                $tarih      = date('d/m/Y');
                if (empty($adsoyad) || empty($tel)) {
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <i class="fa fa-warning fa-lg"></i> Ad soyad ya da telefon boş bırakılamaz. Lütfen tekrar deneyiniz!
                </div>
            </div>
        </div>
        <hr>
        <?php
                } else {
                    $mesajgonder = mysql_query("INSERT INTO emlak_mesaj (adsoyad,email,kime,tel,gsm,konu,mesaj,emlakid,tarih) values ('$adsoyad','$email','".$ilan["yonetici_id"]."','$tel','$gsm','$konu','$mesaj','".$ilan["id"]."','$tarih')");
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <i class="fa fa-check fa-lg"></i> Mesajınız başarılı bir şekilde ulaşmıştır. En kısa sürede dönüş yapılacaktır.
                </div>
            </div>
        </div>
        <hr>
        <?php } ?>
        <?php } ?>
        <div class="row">
            <div class="col-xl-9 col-lg-8 col-md-12 mb-5">
                <?php if ($sekil["kat_tipi"]!="proje"): ?>
                <div class="ilanD-wrapper mb-5">
                    <div class="ilanD-ust">
                        <ul class="nav nav-fill ilanDtabTitle">
                            <li class="nav-item">
                                <a class="nav-link active" href="<?php echo $_SERVER['REQUEST_URI'];?>#detay">
                                    <i class="fa fa-image fa-2x"></i> İlan Detayları
                                </a>
                            </li>
                            <li class="nav-item d-none d-md-block">
                                <a class="nav-link" href="<?php echo $_SERVER['REQUEST_URI'];?>#harita">
                                    <i class="fa fa-map-marker fa-2x"></i> Harita
                                </a>
                            </li>
                            <li class="nav-item d-none d-md-block">
                                <a class="nav-link" href="<?php echo $_SERVER['REQUEST_URI'];?>#sokak">
                                    <i class="fa fa-street-view fa-2x"></i> Sokak Görünümü
                                </a>
                            </li>
                            <li class="nav-item d-none d-md-block">
                                <a class="nav-link" href="<?php echo $_SERVER['REQUEST_URI'];?>#video">
                                    <i class="fa fa-video-camera fa-2x"></i> Video
                                </a>
                            </li>
                            <li class="nav-item">
                                <?php if ($_SESSION["uyelogin"]): ?>
                                    <a class="nav-link" href="#" data-toggle="modal" data-target="#mesajGonder">
                                        <i class="fa fa-comment-o fa-2x"></i> Mesaj Gönder
                                    </a>
                                <?php else: ?>
                                    <a class="nav-link" href="giris-yap" target="_blank" onClick="alert('Mesaj gönderebilmek için giriş yapmalısınız.')" >
                                        <i class="fa fa-comment-o fa-2x"></i> Mesaj Gönder
                                    </a>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>
                    <div class="ilanD-ic">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-md-10">
                                        <?php $emlak_resim_1 = $vt->query("SELECT * FROM emlak_resim WHERE emlakno = '{$ilan["emlakno"]}' AND kapak = 1 LIMIT 1")->fetch(); ?> 
                                        <div id="carouselExampleControls" class="carousel slide" style="background:#000;" data-ride="carousel">
                                          <div class="carousel-inner"> 
                                            <?php
                                                $i=0;
                                                $emlak_resim_1 = $vt->query("SELECT * FROM emlak_resim WHERE emlakno = '{$ilan["emlakno"]}' ORDER BY sira ASC")->fetchAll();
                                                foreach ($emlak_resim_1 AS $e_resim) {
                                            ?>
                                            <div class="carousel-item <?php if ($i++==0) {echo "active";} ?>">
                                              <img style="object-fit:contain; width:100% !important; max-height:400px;" class="d-block w-100 imgonclick" src="<?=RESIM.$e_resim["resimad"];?>" alt="Second slide">
                                            </div>
                                            <?php $i++; } ?>
                                            <div class="tum-resim-goster">
                                                <i class="fa fa-file-image-o mr-3"></i> Tüm Fotoğraflar
                                            </div>
                                          </div>
                                          <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                          </a>
                                          <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                          </a>
                                        </div> 
                                    </div>
                                    <div class="col-md-2">
                                        <?php
                                            if ($resim_limit<3):
                                                $emlak_resim_1 = $vt->query("SELECT * FROM emlak_resim WHERE emlakno = '{$ilan["emlakno"]}' AND kapak != 1 ORDER BY sira DESC LIMIT {$resim_limit}")->fetchAll();
                                            else:
                                                $emlak_resim_1 = $vt->query("SELECT * FROM emlak_resim WHERE emlakno = '{$ilan["emlakno"]}' AND kapak != 1 ORDER BY sira DESC LIMIT 3")->fetchAll();
                                            endif; 
                                        ?>
                                        <?php
                                            foreach ($emlak_resim_1 AS $e_resim) {
                                        ?>
                                        <div class="d-none d-md-block">
                                            <a class="kucuk-resim" style="background: url('<?=RESIM.$e_resim["resimad"];?>');">
                                                <img class="img-responsive d-none" src="<?=RESIM.$e_resim["resimad"];?>">
                                                <div class="resimD-icon">
                                                    <i class="fa fa-file-image-o fa-2x"></i>
                                                </div>
                                            </a>
                                        </div>
                                        <?php } ?>
                                        <div id="lightgallery">
                                            <?php $emlak_resim_say = $vt->query("SELECT * FROM emlak_resim WHERE emlakno = '{$ilan["emlakno"]}' LIMIT {$resim_limit}"); ?>
                                                <div data-src="<?=RESIM.$resim["resimad"];?>">
                                                    <a href="" class="kucuk-resim" style="background: #fff; text-decoration: none; margin:0;">
                                                        <img class="img-responsive d-none" src="<?=RESIM.$resim["resimad"];?>">
                                                        <p
                                                        style="color:#232323ba;"
                                                        class="text-center
                                                        pt-3 h1
                                                        font-weight-light">+<?php
                                                        echo
                                                        $emlak_resim_say->rowCount();
                                                        ?> <smal
                                                        class="h6"></smal></p>
                                                        <div class="resimD-icon" style="top: 0; position: absolute;">
                                                            <i class="fa fa-search-plus fa-2x"></i>
                                                        </div>
                                                    </a>
                                                </div>
                                                <?php
                                                    $resim_tumu = $vt->query("SELECT * FROM emlak_resim WHERE emlakno = '{$ilan["emlakno"]}' LIMIT 1,{$resim_limit}")->fetchAll();
                                                    foreach ($resim_tumu AS $resim) {
                                                ?>
                                                    <div class="d-none" data-src="<?=RESIM.$resim["resimad"];?>">
                                                        <a href="" class="kucuk-resim" style="background: #fff; text-decoration: none; margin:0;">
                                                            <img class="img-responsive d-none" src="<?=RESIM.$resim["resimad"];?>">
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                        </div>
                                    <script type="text/javascript">
                                            $(document).ready(function(){
                                                $('#lightgallery').lightGallery();
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                        </div>
                    </div>
                    <div class="ilanD-alt d-none d-md-block">
                        <ul class="nav nav-pills nav-fill minidetay">
                            <li class="nav-item">
                                <p class="font-weight-light">İlan No</p>
                                <p class="text-muted">
                                    <strong><i class="fa fa-dropbox text-warning mr-1"></i> <?php echo $ilan["emlakno"]; ?></strong>
                                </p>
                            </li>
                            <li class="nav-item">
                                <p class="font-weight-light">Referans No</p>
                                <p class="text-muted">
                                    <strong><i class="fa fa-dropbox text-warning mr-1"></i> <?php echo $ilan["referans_kodu"]; ?></strong>
                                </p>
                            </li>
                            <li class="nav-item">
                                <p class="font-weight-light">Fiyat</p>

                                <?php if($ilan["fiyat"]==0) { ?>
                                <p class="text-muted"><strong>Görüşülür</strong></p>
                                <?php } else { ?>
                                <p class="text-muted"><strong><i class="icon icon-tag text-warning mr-1"></i> <?=rakam($ilan["fiyat"]);?> <?=$ilan["fiyatkur"];?></strong></p>
                                <?php } ?>

                                
                            </li>
                            <li class="nav-item">
                                <p class="font-weight-light">İlan Tarihi</p>
                                <p class="text-muted">
                                    <strong><i class="icon icon-calendar text-warning mr-1"></i> <?php echo $ilan["eklemetarihi"]; ?></strong>
                                </p>
                            </li>
                            <li class="nav-item">
                                <p class="font-weight-light">Bulunduğu Yer</p>
                                <p class="text-muted">
                                    <strong><i class="icon icon-location-pin text-warning mr-1"></i> <?=$il["adi"];?> <?=$ilce["ilce_title"];?> <?=$mahalle["mahalle_title"];?></strong>
                                </p>
                            </li>
                        </ul>
                    </div> 
                </div>
                <?php endif; ?>
                <div class="gizle-425 d-block d-xl-none d-lg-none d-md-none d-sm-none" style="height:50px;"></div>
                <a name="detay"></a>
                <div class="card mb-5">
                    <div class="card-body p-7">
                         <h3 class="h3 mb-5">İlan Özeti</h3>
                        <div class="widget-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="border-bottom p-3">
                                        İlan No
                                        <span class="pull-right"><strong><?=$ilan["emlakno"];?></strong></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border-bottom p-3">
                                        Referans No
                                        <span class="pull-right"><strong><?php echo $ilan["referans_kodu"]; ?></strong></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border-bottom p-3">
                                        İlan Tipi
                                        <span class="pull-right pl-3 pr-3" style="background: <?=$itip["baslikrenk"];?>; color: <?=$itip["yazirenk"];?>;"><strong><?=$itip["ad"];?></strong></span>
                                    </div>
                                </div>
                                <?php
                                
                                    $emlak_ilan_detay = $vt->query("SELECT emlak_form.*, emlak_ilandetay.eformdetay AS dbaslik, emlak_form.ad AS eformad FROM emlak_form, emlak_ilandetay WHERE emlak_ilandetay.emlakno = '{$ilan["emlakno"]}' AND emlak_form.id = emlak_ilandetay.formid AND emlak_form.durum = 0 ORDER BY emlak_form.sira ASC")->fetchAll();
                                    foreach ($emlak_ilan_detay AS $detay) { 
                                ?>
                                <div class="col-md-6">
                                    <div class="border-bottom p-3">
                                        <?=$detay["eformad"];?>
                                        <span class="pull-right"><strong><?php if ($detay["dbaslik"] == "Seçiniz" || $detay["dbaslik"] == "") { ?> - <?php } else { ?> <?=$detay["dbaslik"];?> <?php } ?></strong></span>
                                    </div>
                                </div>  
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-5">
                    <div class="card-body p-7">
                        <h3 class="h3 mb-5">İlan Açıklaması</h3>
                        <div class="mb-4">
                            <?php echo $ilan["icerik"]; ?>
                        </div>
                    </div>
                </div>
            <div class="card mb-5">
                <div class="card-body p-7">
                    <h3 class="h3 mb-7">İlan Özellikleri</h3>
                        <?php
                            $ozelliktip = mysql_query("SELECT * FROM emlak_ozelliktip where id");
                            while($otip = mysql_fetch_array($ozelliktip)) {
                                $ozellikilanid3 = mysql_query("SELECT * FROM emlak_ozellikdetay where ilanid = '".$ilan["id"]."' && ozelliktip = '".$otip["id"]."'");
                                $ilanid2 = mysql_fetch_array($ozellikilanid3);
                        ?>
                        <?php if (mysql_num_rows($ozellikilanid3)) { ?>
                            <h5 class="border-bottom pb-3 mb-3"><strong><?=$otip["ad"];?></strong></h5>
                            <div class="row mb-5">
                                <?php
                                    $ozellikilanid = $vt->query("SELECT * FROM emlak_ozellikdetay where ilanid = '".$ilan["id"]."' && ozelliktip = '".$otip["id"]."'");
                                    while($ilanid = $ozellikilanid -> fetch()) {
                                        $saybeni = $ozellikilanid -> rowCount();
                                ?>
                                <div class="col-md-3 col-6">
                                    <p><i class="fa fa-check-circle fa-lg" style="color: #2ec995;"></i> <?=$ilanid["ad"];?></p>
                                </div>
                                <?php } ?>
                            </div>
                            <!--
                            <div class="row">
                                <?php
                                    $ozellikilanid = $vt->query("SELECT * FROM emlak_ozellikdetay where ilanid = '".$ilan["id"]."' && ozelliktip = '".$otip["id"]."'");
                                    while($ilanid = $ozellikilanid -> fetch()) {
                                        $saybeni = $ozellikilanid -> rowCount();
                                ?>
                                <div class="col-md-3 col-xs-6">
                                    <h6><i class="fa fa-check-circle fa-lg" style="color: #52ca46;"></i> <?=$ilanid["ad"];?></h6>
                                </div>
                                <?php } ?>
                            </div>
                            -->
                        <?php } ?>
                    <?php } ?>
                    </div>
                </div>
                <a name="harita"></a>
                <div class="card mb-5">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-map-marker fa-lg"></i> Harita Görünümü</h3>
                    </div>
                   <div class="card-body">
                       <?php if ($ilan["enlem"] == "" || $ilan["boylam"] == ""): ?>
                           <div class="text-center p-8">
                               <i class="fa fa-warning fa-5x text-light"></i>
                               <p class="h4 font-weight-light mt-8 mb-8 text-dark">İLANIN HARİTA BİLGİSİ BULUNMUYOR</p>
                           </div>
                        <?php else: ?>  
                        <div id="map"></div>  
                        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA301piyuyufUrduxQlk7H0ji1DfNRJde8&callback=initMap&v=weekly" defer></script> 
                        <style>
                            #map {
                                height: 500px;
                            }
                        </style>
                        <script type="text/javascript">
 
                            function initMap() {
                        
                              const myLatlng = { lat: <?php echo $ilan["enlem"] ?>, lng: <?php echo $ilan["boylam"] ?> };
                              const map = new google.maps.Map(document.getElementById("map"), {
                                zoom: <?php echo $ilan["zoom"] ?>,
                                center: myLatlng,
                              }); 
                              let marker = new google.maps.Marker({
                                    map,
                                    draggable: false,
                                    position: { lat: <?php echo $ilan["enlem"] ?>, lng: <?php echo $ilan["boylam"] ?> },
                              }); 
                              marker.addListener("mouseup", (mapsMouseEvent) => {
                                  
                                const pozisyon = mapsMouseEvent.latLng;    
                            
                                $('#enlem').val(pozisyon.lat);
                                $('#boylam').val(pozisyon.lng); 
                                $('#zoom').val(map.getZoom());  
                                
                              });
                        
                            }
                        
                            window.initMap = initMap;
                        </script> 
                        <?php endif; ?>

                   </div>
                </div>
                
                <a name="sokak"></a>
                    <?php if ($ilan["sokak"] != ""): ?>
                    <div class="card mb-5">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-street-view fa-lg"></i> Sokak Görünümü (360°)</h3>
                        </div>
                        <div class="card-body text-center">
                            <?=$ilan["sokak"]?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <a name="video"></a>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-video-camera fa-lg"></i> Video</h3>
                        </div>
                        <div class="card-body">
                            <?php if ($ilan["video"] == ""): ?>
                                <div class="text-center p-8">
                                    <i class="fa fa-video-camera fa-5x text-light"></i>
                                    <p class="h4 font-weight-light mt-8 mb-8 text-dark">İLANIN VİDEO GÖRÜNÜMÜ BULUNMUYOR</p>
                                </div>
                            <?php else: ?>
                            <div class="text-center">
                                <?=html_encode($ilan["video"]);?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-12">
                <?php if ($ilan["gunluk_onay"]==1) { ?>
                    <div class="card mb-5">
                        <h4 class="card-header">
                            <strong> Online Oda Kirala</strong>
                        </h4>
                        <div class="card-body">
                            <form action="/oda-kirala" method="POST">
                                <input hidden name="periyot" type="text" value="<?php echo $ilan["periyot"] ?>" type="text">
                                <input hidden name="gunluk_fiyat_birim" value="<?php echo $ilan["gunluk_fiyat_birim"] ?>" type="text" type="text">
                                <input hidden name="yetiskin_fiyat" value="<?php echo $ilan["yetiskin_fiyat"] ?>" type="text" type="text">
                                <input hidden name="cocuk_fiyat" value="<?php echo $ilan["cocuk_fiyat"] ?>" type="text" type="text">
                                <input hidden name="bebek_fiyat" value="<?php echo $ilan["bebek_fiyat"] ?>" type="text" type="text">
                                <input hidden name="ilan_id" value="<?php echo $ilan["id"] ?>" type="text" type="text">
                                <input hidden name="ilan_baslik" value="<?php echo $ilan["baslik"] ?>" type="text" type="text">
                                <div class="row"> 
                                    <div class="col-lg-12"> 
                                        <div class="form-group mt-4 mb-1">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <h4>Yetişkin / <?php echo $ilan["periyot"] ?></h4>
                                                </div>
                                                <div class="col-lg-4 text-right">
                                                    <h4><strong><?php echo $ilan["yetiskin_fiyat"] ?> <small><?php echo $ilan["gunluk_fiyat_birim"] ?></small> </strong></h4>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-lg-12"> 
                                        <div class="form-group mt-4 mb-1">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <h4>Çocuk / <?php echo $ilan["periyot"] ?></h4>
                                                </div>
                                                <div class="col-lg-4 text-right">
                                                    <h4><strong><?php echo $ilan["cocuk_fiyat"] ?> <small><?php echo $ilan["gunluk_fiyat_birim"] ?></small> </strong></h4>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-lg-12"> 
                                        <div class="form-group mt-4 mb-4">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <h4>Bebek (3+ Yaş) / <?php echo $ilan["periyot"] ?></h4>
                                                </div>
                                                <div class="col-lg-4 text-right">
                                                    <h4><strong><?php echo $ilan["bebek_fiyat"] ?> <small><?php echo $ilan["gunluk_fiyat_birim"] ?></small> </strong></h4>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input name="giris_tarihi" class="form-control input-lg" type="date" placeholder="Giriş Tarihi">
                                        </div> 
                                    </div>
                                    <div class="col-lg-6"> 
                                        <div class="form-group">
                                            <input name="cikis_tarihi" class="form-control input-lg" type="date" placeholder="Giriş Tarihi">
                                        </div> 
                                    </div> 
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <select name="yetiskin_sayisi" class="form-control input-lg" id="">
                                                <option selected value="">Yetişkin Sayısı</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                            </select>
                                        </div> 
                                    </div> 
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <select name="cocuk_sayisi" class="form-control input-lg" id="">
                                                <option selected value="">Çocuk</option>
                                                <option value="0">Yok</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                            </select>
                                        </div> 
                                    </div> 
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <select name="bebek_sayisi" class="form-control input-lg" id="">
                                                <option selected value="">Bebek</option>
                                                <option value="0">Yok</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                            </select>
                                        </div> 
                                    </div> 
                                    <?php if ($ilan["ozel_metin_1"]!="") { ?>
                                    <div class="col-lg-12">
                                        <div class="alert alert-danger">
                                            <small><?php echo $ilan["ozel_metin_1"] ?></small>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php if ($ilan["ozel_metin_2"]!="") { ?>
                                    <div class="col-lg-12">
                                        <div class="alert alert-primary">
                                            <small><?php echo $ilan["ozel_metin_2"] ?></small>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php if ($ilan["ozel_metin_3"]!="") { ?>
                                    <div class="col-lg-12">
                                        <div class="alert alert-success">
                                            <small><?php echo $ilan["ozel_metin_3"] ?></small>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="col-lg-12">
                                        <div class="form-group mt-4">
                                            <button type="submit" class="btn btn-warning btn-block pt-4 pb-4"><strong>Fiyat Hesapla</strong></button>
                                        </div> 
                                    </div> 
                                </div>
                            </form>
                        </div>
                    </div>
                <?php } ?>
                <?php
                    $danismanlar = mysql_query("SELECT * FROM yonetici where id = '".$ilan["yonetici_id"]."'");
                    while($dan = mysql_fetch_array($danismanlar)) {
                        $sube = $vt->query("SELECT * FROM subeler where id = '".$dan["ofis"]."'")->fetch();
                        $il = $vt->query("SELECT * FROM sehir where sehir_key = '".$sube["il"]."'")->fetch();
                        $ilce = $vt->query("SELECT * FROM ilce where ilce_key = '".$sube["ilce"]."'")->fetch();
                        $mahalle = $vt->query("SELECT * FROM mahalle where mahalle_id = '".$sube["mahalle"]."'")->fetch();
                ?>
                <?php if ($dan["ofis"] == $sube["id"]): ?>
                <div class="card mb-5">
                    <div class="card-body  p-3 item-user">
                        <div class="profile-pic mb-0">
                             <a href="/ofis/<?php echo $sube["id"]; ?>/<?php echo $sube["seo"]; ?>">
                               <?php if ($sube["resim"] == "") { ?>
                                <img src="/uploads/resim/resim.png" width="100%" class="brr ound avatar-x xl">
                                <?php } else { ?>
                                <img src="/<?=$sube["resim"];?>" width="100%" class="brround avatar-xxl">
                                <?php } ?>
                            </a>
                            <ul>
                               <li style="" class="item">
                                    <div class="media mt-0">
                                        <div class="media-body mt-3">
                                            <h4 class="mb-1 mt-1 font-weight-semibold">
                                                <a href="/ofis/<?php echo $sube["id"]; ?>/<?php echo $sube["seo"]; ?>"><?=$sube["adi"];?></a>
                                            </h4>
                                            <?php echo ucwords(mb_strtolower($il["adi"])); ?> <?php echo ucwords(mb_strtolower($ilce["ilce_title"])); ?> <?php echo ucwords(mb_strtolower($mahalle["mahalle_title"])); ?>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-footer mt-1">
                        <div class="text-left">
                            <a href="/ofis/<?php echo $sube["id"]; ?>/<?php echo $sube["seo"]; ?>" class="btn-block text-center">
                                Ofisin Diğer İlanları
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="card mb-5">
                    <div class="card-body  item-user">
                        <div class="profile-pic mb-0 p-3">
                            <ul>
                               <li style="" class="item">
                                    <div class="med ia mt-0 <?php if ($dan["id"] != $sube["yetkiliuye"]): ?> text-center <?php endif; ?>">
                                        <a href="/danisman/<?=$dan["id"];?>">
                                           <?php if ($dan["resim"] == "") { ?>
                                            <img src="/uploads/resim/resim.png" width="50" class="brround avatar-xxl">
                                            <?php } else { ?>
                                            <?php if ($dan["id"] == $sube["yetkiliuye"]): ?>
                                            <img src="/<?=$dan["resim"];?>" width="50" class="brround avatar-xxl">
                                            <?php else: ?>
                                            <img src="/<?=$dan["resim"];?>" width="100" class="brround avatar-xxl">
                                            <?php endif; ?>
                                            <?php } ?>
                                        </a>
                                        <div class="">
                                            <p class="m-0 mt-1">Yetkili Kişi</p>
                                            <a href="/danisman/<?=$dan["id"];?>" class="m-0 mt-1">
                                            <h6 class="mb-1 mt-1">
                                                <strong><?=$dan["adsoyad"];?></strong>
                                            </h6>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="border-bottom mb-3 pb-3">
                                <a href="/danisman/<?=$dan["id"];?>" class="text-dark">
                                    <h6 class="mt-3 mb-1 font-weight-semibold"></h6>
                                </a>
                            </div>
                            <?php if ($dan["tel"] != "") { ?>
                            <h6>
                                <a class="btn btn-success btn-block p-3 mb-2" href="tel:<?=$dan["tel"];?>" class="text-body">
                                <i class="fa fa-phone fa-2x float-left ml-2"></i> <?=$dan["tel"];?></a>
                            </h6>
                            <?php } ?>
                            <?php if ($dan["gsm"] != "") { ?>
                            <h6>
                                <a class="btn btn-success btn-block p-3 mb-2" href="tel:<?=$dan["gsm"];?>" class="text-body">
                                    <i class="fa fa-phone fa-2x float-left ml-2"></i> <?=$dan["gsm"];?>
                                </a>
                            </h6>
                            <?php } ?>
                            <?php if ($_SESSION["id"] != $dan["id"]): ?>
                                <?php if ($_SESSION["uyelogin"]): ?>
                                    <h6>
                                        <a class="btn btn-danger btn-block p-3 text-white" data-toggle="modal" data-target="#mesajGonder">
                                            <i class="fa fa-envelope fa-2x float-left ml-2"></i> Mesaj Gönder
                                        </a>
                                    </h6>
                                <?php else: ?>
                                     <h6>
                                        <a href="giris-yap" target="_blank" onClick="alert('Mesaj gönderebilmek için giriş yapmalısınız.')" class="btn btn-danger btn-block p-3 text-white">
                                            <i class="fa fa-envelope fa-2x float-left ml-2"></i> Mesaj Gönder
                                        </a>
                                    </h6>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php
                                if (isset($_POST["danmesajgonder"])) {
                                    $kime = $_POST["kime"];
                                    $ilan_baslik = $_POST["ilan_baslik"];
                                    $mesaj = $_POST["mesaj"];
                                    $tarih = date('d/m/Y');
                                    $mesaj_ekle = mysql_query("INSERT INTO emlak_dangelenmesaj (kimden, kime, mesaj, tarih) values ('".$_SESSION["id"]."','".$ilan["yonetici_id"]."','".$mesaj."','".$tarih."')");
                                    mail_gonder($dan['email'], "Sayın ".$dan["adsoyad"].", ".$ilan_baslik." ilanınız için yeni bir mesajınız bulunuyor.", "Sayın ".$dan["adsoyad"].", ".$ilan_baslik." ilanınız için yeni bir yeni mesajınız bulunuyor.");
                                    sms_gonder($dan['id'],"Sayın ".$uye["adsoyad"]."", " üyelik paketiniz onaylanmıştır.");
                                    onay_alert("Mesajınız başarılı bir şekilde gönderilmiştir.");
                                }
                            ?>
                            <form action="" method="post">
                            <div class="modal fade" id="mesajGonder" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="mesajGonderLabel" aria-hidden="true">
                              <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title text-center" id="staticBackdropLabel">Mesaj Gönder</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                   <div class="card overflow-hidden box-shadow-0 kategori-ilan-liste mb-5">
                                        <div class="d-md-flex" style="background: #eee;">
                                            <div class="item-card9-img">
                                                <div class="item-card9-imgs kategori-list-img">
                                                    <?php if ($resim["resimad"] == "") { ?>
                                                    <img src="/uploads/resim/uyeresimyok.png" class="cover-image">
                                                    <?php } else { ?>
                                                    <img src="/uploads/resim/<?php echo $resim["resimad"]; ?>" class="cover-image">
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="card border-0 mb-0 pl-2 box-shadow-0">
                                                <div class="card-body pl-1 pb-0">
                                                    
                                                    <?php if ($ilan["fiyat"]==0) { ?>
                                                    <h4 style="font-size: 22px;" class="mb-4">Görüşülür</h4>
                                                    <?php } else { ?>
                                                    <h4 style="font-size: 22px;" class="mb-4"><strong><?php echo rakam($ilan["fiyat"]); ?> </strong><?php echo $ilan["fiyatkur"]; ?></h4>
                                                    <?php } ?>

                                                    <h4 style="font-size: 15px;" class="mb-3">
                                                        <strong>
                                                            <a href="/ilanara/?emlaktipi=<?php echo $itip["id"]; ?>"><?php echo $itip["ad"]; ?></a>
                                                            <span class="m-2 text-muted">|</span>
                                                            <a href="/ilanara/?emlaksekli=<?php echo $sekil["id"]; ?>"><?php echo $sekil["baslik"]; ?></a>
                                                            <span class="m-2 text-muted">|</span>
                                                            <a href="/ilanara/?kategori=<?php echo $kat["kat_id"]; ?>"><?php echo $kat["kat_adi"]; ?> </a>
                                                        </strong>
                                                    </h4>
                                                    <h5 class="mb-1"><?php echo $ilan["baslik"]; ?></h5>
                                                    <a href="/ilanara/?il=<?php echo $il["sehir_key"] ?>" class="btn mb-3 box-shadow-0 float-left pl-0"><i class="fa fa-map-marker mr-1 text-danger"></i>
                                                        <?php echo $il["adi"] ?>
                                                    </a>
                                                    <div class="item-card9">
                                                        <a href="yukari-ouml-ve-ccedil-lerde-ccedil-ok-temiz-sakin-otoparkli-ouml-n-uuml-a-ccedil-ik-ve-merkezi-5481-ilan-352" class="text-dark"></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <input class="input--style-4" style="background: #eee;" type="text" disabled name="kime" placeholder="Kime: <?php echo $dan["adsoyad"]; ?>">
                                                </div>
                                                <div class="col-md-8">
                                                    <input class="input--style-4" type="text" name="ilan_baslik" value="<?php echo $ilan["baslik"]; ?>">
                                                </div>
                                                <div class="col-md-12 mt-5">
                                                    <div class="form-group">
                                                        <textarea class="input--style-4 form-control" name="mesaj" rows="3" placeholder="Mesajınız:">Merhaba, <?php echo $ilan["emlakno"] ?> no.lu ilanınız hakkında detaylı bilgi almak için benimle iletişime geçmenizi rica ediyorum. Teşekkürler, İyi çalışmalar.</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-light p-1 pl-7 pr-7" data-dismiss="modal">İptal</button>
                                    <button type="submit" name="danmesajgonder" class="btn btn-danger p-1 pl-7 pr-7">Gönder</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-left">
                            <a href="/danisman/<?=$dan["id"];?>" class="btn-block text-center">
                                <i class="fa fa-user"></i> Diğer İlanları
                            </a>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="mb-7">
                    <div class="text-center">
                        <?php include 'sistem/paylas.php'; ?>
                    </div>
                     <h3 class="h3 mt-7 mb-4"><strong>Sizin İçin Seçtiklerimiz</strong></h3>
                     <?php 
                        $sectiklerimiz=$vt->query("SELECT * FROM emlak_ilan where id != '".$id."' AND durum = 0 AND onay = 1 ORDER BY rand() LIMIT 3");
                        while($ilan_secim=$sectiklerimiz->fetch()){
                        $ilantipi=$vt->query("SELECT * FROM emlak_ilantipi where id = '".$ilan_secim["ilantipi"]."'")->fetch();
                        $dizi = explode (" ",$ilantipi['ad']);
                        $il=$vt->query("SELECT * FROM sehir where sehir_key = '".$ilan_secim["il"]."'")->fetch();
                        $ilce=$vt->query("SELECT * FROM ilce where ilce_key = '".$ilan_secim["ilce"]."'")->fetch();
                        $mahalle = $vt->query("SELECT * FROM mahalle where mahalle_id = '".$ilan_secim["mahalle"]."'")->fetch();
                        $ilanresim=$vt->query("SELECT * FROM emlak_resim where emlakno = '".$ilan_secim["emlakno"]."' && kapak = 1")->fetch();
                        $ekleyen = $vt->query("SELECT * FROM yonetici where id = '".$ilan_secim["yonetici_id"]."'")->fetch(); 
                        $kategori = $vt->query("SELECT * FROM emlak_kategori where kat_id = '".$ilan["katid"]."'")->fetch(); 
                        $ilan_tipi = $vt->query("SELECT * FROM emlak_ilantipi WHERE id = '".$ilan_secim["ilantipi"]."'")->fetch();
                        $ilan_sekli = $vt->query("SELECT * FROM emlak_ilansekli WHERE id = '".$ilan_secim["ilansekli"]."'")->fetch();
                        $ilan_kategori = $vt->query("SELECT * FROM emlak_kategori WHERE kat_id = '".$ilan_secim["katid"]."'")->fetch(); 
                    ?>
                    <div class="card p-1 hover-box mb-4">
                        
                        <?php $favori = $vt->query("SELECT * FROM favoriler WHERE uye_id = '{$_SESSION["id"]}' AND ilan_id = '{$ilan_secim["id"]}' ")->fetch(); ?>
                        <?php if(!$_SESSION["uyelogin"]) { ?>
                        <a href="#" data-toggle="modal" id="girisKontrol1<?php echo $ilan_secim["id"] ?>" class="favori-ekle" style="">
                            <i class="fa fa-heart-o fa-lg"></i>
                        </a>
                        <?php } else { ?>
                        <a href="#" id="favEkle1<?php echo $ilan_secim["id"] ?>" data-toggle="modal" class="favori-ekle" style="display:<?php if ($favori) { ?>none<?php } ?>">
                            <i class="fa fa-heart-o fa-lg"></i>
                        </a>
                        <?php } ?>
                        <a href="#" id="favCikar1<?php echo $ilan_secim["id"] ?>" data-toggle="modal" class="favori-cikar" style="display:<?php if (!$favori) { ?>none<?php } ?>">
                            <i class="fa fa-heart fa-lg"></i>
                        </a> 
                        <script> 
                        $('#girisKontrol1<?php echo $ilan_secim["id"] ?>').click(function ilanId(e){  
                            alert('Favorilere ekleyebilmeniz için lütfen üye girişi yapınız.');
                            window.location.href = '<?php echo $ayar["site_url"] ?>giris-yap';
                        });
                        $('#favEkle1<?php echo $ilan_secim["id"] ?>').click(function ilanId(e){  
                            
                            $.post("index.php?do=ajax_favori&favori=ekle&ilanId=<?php echo $ilan_secim["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>",function(data){
                                $('#gosterx').html(data);
                            }); 
                            
                            
                            $('#favEkle1<?php echo $ilan_secim["id"] ?>').css({ 'display': 'none' }); 
                            $('#favCikar1<?php echo $ilan_secim["id"] ?>').css({ 'display': 'block' }); 
                			
                        });
                        $('#favCikar1<?php echo $ilan_secim["id"] ?>').click(function(){ 
                            
                            $.post("index.php?do=ajax_favori&favori=sil&ilanId=<?php echo $ilan_secim["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>", function(data){
                                $("#gosterx").html(data);
                            }); 
                             
                            $('#favEkle1<?php echo $ilan_secim["id"] ?>').css({ 'display': 'block' }); 
                            $('#favCikar1<?php echo $ilan_secim["id"] ?>').css({ 'display': 'none' });  
                            
                        }); 
                        </script>
                        
                        <a class="emlak-grid-resim" href="/<?=$ilan_secim["seo"];?>-ilan-<?=$ilan_secim["id"];?>">
                            <?php if($ilanresim["resimad"] != ""): ?>
                            <img src="<?=RESIM;?>/<?php echo $ilanresim["resimad"]; ?>" height="200" width="100%" alt="img">
                            <?php else: ?>
                            <img src="/uploads/resim/resim.png" height="200" width="100%" alt="img">
                            <?php endif; ?>
                            <span class="badge bg-primary text-white one-cikan"><strong>ÖNE ÇIKAN</strong></span>
                        </a>
                        <div class="ozet"> 
                            <div class="row d-flex px-1 align-items-center justify-content-center">
                            <?php
                                $ilandetay=$vt->query("SELECT emlak_form.*, emlak_ilandetay.eformdetay AS dbaslik, emlak_form.ad AS eformad, emlak_form.ikon AS ikon FROM emlak_form, emlak_ilandetay WHERE emlak_ilandetay.emlakno = '{$ilan_secim["emlakno"]}' AND emlak_form.id = emlak_ilandetay.formid AND emlak_form.durum = 0 AND emlak_form.ozet = 1 ORDER BY emlak_form.sira ASC LIMIT 4")->fetchAll(); 
                                foreach ($ilandetay AS $detay) {                                              
                            ?>
                            <div class="col py-3 text-center" data-toggle="tooltip" title="<?php echo $detay["eformad"] ?>">
                                <i class="fa <?php echo $detay["ikon"] ?> fs-18 text-primary mr-1"></i><span class="max-width-ozet"><?php echo $detay["dbaslik"] ?></span> 
                            </div>  
                            <?php } ?>                                       
                            </div>
                        </div>
                        <div class="px-4 pb-4">
                            <p class="emlak_tipi_kat">
                                <strong>
                                    <?php echo ucwords(mb_strtolower($ilan_tipi["ad"])); ?>
                                    <?php echo ucwords(mb_strtolower($ilan_kategori["kat_adi"])); ?>
                                </strong>
                            </p> 
                                <p class=" mt-1 mb-2 font-weight-bold" style="/* text-transform: uppercase; */height: 46px;overflow: hidden;"><a href="/<?=$ilan_secim["seo"];?>-ilan-<?=$ilan_secim["id"];?>"><?=$ilan_secim["baslik"];?></a></p>
                            <p class="mb-5">
                                <i class="icon icon-location-pin"></i> <?php echo ucwords(mb_strtolower($il["adi"])); ?>
                                <?php echo ucwords(mb_strtolower($ilce["ilce_title"])); ?>
                                <?php echo ucwords(mb_strtolower($mahalle["mahalle_title"])); ?>
                            </p>
                            <ul class="row mb-1"> 
                                <li class="col-6">
                                    <small class="btn btn-block btn-white btn-sm"><i class="fa fa-calendar-o"></i> <?php echo $ilan_secim["eklemetarihi"]; ?></small>
                                </li>  
                                <li class="col-6">
                                    <?php if($ilan_secim["fiyat"]==0) { ?>
                                    <span class="btn btn-block btn-warning btn-sm rounded-pill"> Görüşülür</span>
                                    <?php } else { ?>
                                    <span class="btn btn-block btn-white btn-sm"><i class="fa fa-tag"></i> <strong><?php echo rakam($ilan_secim["fiyat"]); ?></strong> <?php echo $ilan_secim["fiyatkur"]; ?></span>
                                    <?php } ?>
                                </li>  
                            </ul>
                            <a href="/<?=$ilan_secim["seo"];?>-ilan-<?=$ilan_secim["id"];?>" href="/<?=$ilan_secim["seo"];?>-ilan-<?=$ilan_secim["id"];?>" class="btn btn-default bg-xs mt-4 btn-block">
                                DETAY
                            </a>
                        </div> 
                    </div>
                    <?php } ?>
                </div>
                <div class="pt-5 pb-3">
                <!-- REKLAM -->
                <?php echo $reklam["ilan_sidebar"]; ?>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="container">
        <?php
            $ilan_varmi = $vt->query("SELECT * FROM emlak_ilan WHERE yonetici_id = '".$ilan["yonetici_id"]."' and durum = 0")->rowCount();
            if ($ilan_varmi>1) {
        ?>
         <h3 class="h3 mt-7 mb-4 pl-2"><strong>Danışmanın Diğer İlanları</strong></h3>
        <div class="row"> 
        <?php
            $limitonecikanvitrin = $ayar["one_cikan"];
            $emlakilanfirsat=$vt->query("SELECT * FROM emlak_ilan where yonetici_id = '".$ilan["yonetici_id"]."' and id != '".$id."' LIMIT 4");
            while($ilanx=$emlakilanfirsat->fetch()){
            $ilantipi=$vt->query("SELECT * FROM emlak_ilantipi where id = '".$ilan["ilantipi"]."'")->fetch();
            $dizi = explode (" ",$ilantipi['ad']);
            $il=$vt->query("SELECT * FROM sehir where sehir_key = '".$ilanx["il"]."'")->fetch();
            $ilce=$vt->query("SELECT * FROM ilce where ilce_key = '".$ilanx["ilce"]."'")->fetch();
            $mahalle = $vt->query("SELECT * FROM mahalle where mahalle_id = '".$ilanx["mahalle"]."'")->fetch();
            $ilanresim=$vt->query("SELECT * FROM emlak_resim where emlakno = '".$ilanx["emlakno"]."' && kapak = 1")->fetch();
            $ekleyen = $vt->query("SELECT * FROM yonetici where id = '".$ilanx["yonetici_id"]."'")->fetch(); 
            $kategori = $vt->query("SELECT * FROM emlak_kategori where kat_id = '".$ilanx["katid"]."'")->fetch(); 
            $ilan_tipi = $vt->query("SELECT * FROM emlak_ilantipi WHERE id = '".$ilanx["ilantipi"]."'")->fetch();
            $ilan_sekli = $vt->query("SELECT * FROM emlak_ilansekli WHERE id = '".$ilanx["ilansekli"]."'")->fetch();
            $ilan_kategori = $vt->query("SELECT * FROM emlak_kategori WHERE kat_id = '".$ilanx["katid"]."'")->fetch();
            $doping_ilanlari = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '".$ilanx["id"]."' AND doping_adi = 'one_cikan' AND bitis_tarihi > '".date('Y-m-d')."' AND odeme_durumu = 'Ödendi'")->fetch();
        ?>
        <div class="col-lg-3 col-sm-6 col-12 mb-5">
            <div class="card p-1 hover-box">
                 
                <?php $favori = $vt->query("SELECT * FROM favoriler WHERE uye_id = '{$_SESSION["id"]}' AND ilan_id = '{$ilanx["id"]}' ")->fetch(); ?>
                <?php if(!$_SESSION["uyelogin"]) { ?>
                <a href="#" data-toggle="modal" id="girisKontrol2<?php echo $ilanx["id"] ?>" class="favori-ekle" style="">
                    <i class="fa fa-heart-o fa-lg"></i>
                </a>
                <?php } else { ?>
                <a href="#" id="favEkle2<?php echo $ilanx["id"] ?>" data-toggle="modal" class="favori-ekle" style="display:<?php if ($favori) { ?>none<?php } ?>">
                    <i class="fa fa-heart-o fa-lg"></i>
                </a>
                <?php } ?>
                <a href="#" id="favCikar2<?php echo $ilanx["id"] ?>" data-toggle="modal" class="favori-cikar" style="display:<?php if (!$favori) { ?>none<?php } ?>">
                    <i class="fa fa-heart fa-lg"></i>
                </a> 
                <script> 
                $('#girisKontrol2<?php echo $ilanx["id"] ?>').click(function ilanId(e){  
                    alert('Favorilere ekleyebilmeniz için lütfen üye girişi yapınız.');
                    window.location.href = '<?php echo $ayar["site_url"] ?>giris-yap';
                });
                $('#favEkle2<?php echo $ilanx["id"] ?>').click(function ilanId(e){  
                    
                    $.post("index.php?do=ajax_favori&favori=ekle&ilanId=<?php echo $ilanx["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>",function(data){
                        $('#gosterx').html(data);
                    }); 
                    
                    
                    $('#favEkle2<?php echo $ilanx["id"] ?>').css({ 'display': 'none' }); 
                    $('#favCikar2<?php echo $ilanx["id"] ?>').css({ 'display': 'block' }); 
        			
                });
                $('#favCikar2<?php echo $ilanx["id"] ?>').click(function(){ 
                    
                    $.post("index.php?do=ajax_favori&favori=sil&ilanId=<?php echo $ilanx["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>", function(data){
                        $("#gosterx").html(data);
                    }); 
                     
                    $('#favEkle2<?php echo $ilanx["id"] ?>').css({ 'display': 'block' }); 
                    $('#favCikar2<?php echo $ilanx["id"] ?>').css({ 'display': 'none' });   
                    
                }); 
                </script>
                
                <a class="emlak-grid-resim" href="/<?=$ilan["seo"];?>-ilan-<?=$ilan["id"];?>">
                    <?php if($ilanresim["resimad"] != ""): ?>
                    <img src="<?=RESIM;?>/<?php echo $ilanresim["resimad"]; ?>" height="200" width="100%" alt="img">
                    <?php else: ?>
                    <img src="/uploads/resim/resim.png" height="200" width="100%" alt="img">
                    <?php endif; ?>
                    <span class="badge bg-primary text-white one-cikan"><strong>ÖNE ÇIKAN</strong></span>
                </a>
                <div class="ozet"> 
                    <div class="row d-flex px-1 align-items-center justify-content-center">
                    <?php
                        $ilandetay=$vt->query("SELECT emlak_form.*, emlak_ilandetay.eformdetay AS dbaslik, emlak_form.ad AS eformad, emlak_form.ikon AS ikon FROM emlak_form, emlak_ilandetay WHERE emlak_ilandetay.emlakno = '{$ilan["emlakno"]}' AND emlak_form.id = emlak_ilandetay.formid AND emlak_form.durum = 0 AND emlak_form.ozet = 1 ORDER BY emlak_form.sira ASC LIMIT 4")->fetchAll(); 
                        foreach ($ilandetay AS $detay) {                                              
                    ?>
                    <div class="col py-3 text-center" data-toggle="tooltip" title="<?php echo $detay["eformad"] ?>">
                        <i class="fa <?php echo $detay["ikon"] ?> fs-18 text-primary mr-1"></i><span class="max-width-ozet"><?php echo $detay["dbaslik"] ?></span> 
                    </div>  
                    <?php } ?>                                       
                    </div>
                </div>
                <div class="px-4 pb-4">
                    <p class="emlak_tipi_kat">
                        <strong>
                            <?php echo ucwords(mb_strtolower($ilan_tipi["ad"])); ?>
                            <?php echo ucwords(mb_strtolower($ilan_kategori["kat_adi"])); ?>
                        </strong>
                    </p> 
                        <p class=" mt-1 mb-2 font-weight-bold" style="/* text-transform: uppercase; */height: 46px;overflow: hidden;"><a href="/<?=$ilan["seo"];?>-ilan-<?=$ilan["id"];?>"><?=$ilan["baslik"];?></a></p>
                    <p class="mb-5">
                        <i class="icon icon-location-pin"></i> <?php echo ucwords(mb_strtolower($il["adi"])); ?>
                        <?php echo ucwords(mb_strtolower($ilce["ilce_title"])); ?>
                        <?php echo ucwords(mb_strtolower($mahalle["mahalle_title"])); ?>
                    </p>
                    <ul class="row mb-1">
                        <li class="col-6">
                            <small class="btn btn-block btn-white btn-sm"><i class="fa fa-calendar-o"></i> <?php echo $ilan["eklemetarihi"]; ?></small>
                        </li>  
                        <li class="col-6">
                            <?php if($ilan["fiyat"]==0) { ?>
                            <span class="btn btn-block btn-warning btn-sm rounded-pill"> Görüşülür</span>
                            <?php } else { ?>
                            <span class="btn btn-block btn-white btn-sm"><i class="fa fa-tag"></i> <strong><?php echo rakam($ilan["fiyat"]); ?></strong> <?php echo $ilan["fiyatkur"]; ?></span>
                            <?php } ?>
                        </li>  
                    </ul>
                    <a href="/<?=$ilan["seo"];?>-ilan-<?=$ilan["id"];?>" href="/<?=$ilan["seo"];?>-ilan-<?=$ilan["id"];?>" class="btn btn-default bg-xs mt-4 btn-block">
                        DETAY
                    </a>
                </div> 
            </div>
        </div>
        <?php } ?>
        </div>
     <?php } ?>
    </div>
    <?php endif; ?>
    <?php } ?>
</section>
<section>
<?php include("footer.php"); ?>
</section>
<?php include("alt.php"); ?>
</body>
<!-- Mirrored from www.spruko.com/demo/reallist/htm/Reallist-LTR/Html/ by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 05 Apr 2020 15:27:18 GMT -->
</html>