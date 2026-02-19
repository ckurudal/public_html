<!doctype html>
<html class="no-js" lang="tr"> 
<head>
    <!-- Meta data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="<?=$ayar["site_desc"];?>" name="description">
    <meta content="<?=$site["firmadi"];?>" name="author">
    <meta name="keywords" content="<?=$ayar["site_keyw"];?>" />
    <!-- Favicon -->
    <link rel="icon" href="<?=$ayar["favicon"];?>" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="<?=$ayar["favicon"];?>" />
    <!-- Title -->
    <title>
        <?=$ayar["site_adi"];?>
    </title>
    <?php include('header.php'); ?>
</head>
<body>
<?php include('ust.php'); ?>
<section class="slider-main">
    <link href="<?php echo $stek->font; ?>" rel="stylesheet"> 
    <div id="carouselExampleControls" class="carousel slide" style="background: #000;" data-ride="carousel">
        
        <div class="carousel-inner">
            <?php
                $i=0;
                $slidertek2=$vt->query("SELECT * FROM slider WHERE durum = 0 ORDER BY sira ASC")->fetchAll(PDO::FETCH_OBJ);
                foreach($slidertek2 AS $stek) {  
                    $countS = count($slidertek2);                             
            ?>  
            <div class="carousel-item <?php if ($i==0) { ?> active <?php } ?>"> 
                <img class="d-block w-100 imgonclick" src="<?php echo $stek->resim; ?>" alt="<?php echo $stek->baslik; ?>" /> 
                <div class="sliderIcerik">                
                    <h1 style="<?php echo $stek->font_family; ?> font-size:<?php echo $stek->font_size; ?>;" class="font-weight-bolder"><?php echo $stek->baslik; ?></h1>
                    <h3 class="font-weight-light"><?php echo $stek->aciklama; ?></h3>
                    
                </div> 
            </div>   
            <?php $i++; } ?> 
        </div> 
        <?php if ($countS>1) { ?>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        <?php } ?>
    </div>
    <div class="slider-multi-content">
        <div class="container">  
            <div class="row">
                <div class="offset-md-2 col-xl-8 col-lg-12 col-md-12 d-block mx-auto">
                    <?php include ('blok-hizliara-yatay.php') ?>
                </div>
            </div>
        </div> 
    </div>
</section> 
<div id="list">
    <!-- IKON BOX -->
    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'ikon-box'")->fetch(); ?>
    <?php if ($cek["durum"]=="Aktif") { ?>
    <section id="categorie5.1-<?php echo $cek["sira"] ?>" class="categories  pb-0">
        <div class="container">
            <div class="section-title text-center">
                <a href="/ilanara/" class="float-right h4 mt-4"></a>
                <h2 class="h2"><?php echo $cek["modul_baslik"] ?></h2>
                <p><?php echo $cek["modul_icerik"] ?></p> 
            </div> 
            <div class="row">
                <?php
                    $ana_ikon_box = $vt->query("SELECT * FROM ana_ikon_box WHERE id ORDER BY sira ASC")->fetchAll();
                    foreach ($ana_ikon_box AS $box):
                ?>
                <div class="col-lg-3 col-md-6 col-sm-6 d-catmb mb-4 mb-lg-0">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="d-flex">
                                <div> 
                                    <span class="icon-service1" style="background:<?php echo $box["renk"]; ?>38;"> 
                                        <i style="color:<?php echo $box["renk"]; ?>" class="<?php echo $box["ikon"]; ?>"></i>
                                    </span>
                                 </div>
                                <a href="<?php echo $box["link"]; ?>" target="_blank">
                                    <div class="ml-4 mt-1">
                                        <h6 class=" mb-0 font-weight-bold">
                                        <?php echo $box["baslik"]; ?>
                                        </h6>
                                        <p class="intro-text-p mb-0 text-muted"><?php echo $box["icerik"]; ?></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?> 
            </div>
        </div>
    </section> 
    <?php } ?>
    <!-- YENİ İLANLAR -->
    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'en-yeni-ilanlar'")->fetch(); ?>
    <?php if ($cek["durum"]=="Aktif") { ?>
    <section id="categorie5.1-<?php echo $cek["sira"] ?>" class=" pt-3 pb-3 mb-0 mt-5">
        <div class="container">
            <div class="section-title text-center mb-5">
                <a href="/ilanara/" class="float-right h4 mt-4"></a>
                <h2 class="h2"><?php echo $cek["modul_baslik"] ?></h2>
                <p><?php echo $cek["modul_icerik"] ?></p> 
            </div> 
            <div class="row flex-lg-wrap flex-nowrap overflow-auto">
            <?php
                $en_yeni_ilanlar = $ayar["en_yeni"];
                    $emlakilanfirsat=$vt->query("SELECT * FROM emlak_ilan where durum = 0 AND onay = 1 order by RAND() limit ".$en_yeni_ilanlar."");
                    while($ilan=$emlakilanfirsat->fetch()){
                    $ilantipi=$vt->query("SELECT * FROM emlak_ilantipi where id = '".$ilan["ilantipi"]."'")->fetch();
                    $dizi = explode (" ",$ilantipi['ad']);
                    $ilan_tipi = $vt->query("SELECT * FROM emlak_ilantipi WHERE id = '".$ilan["ilantipi"]."'")->fetch();
                    $ilan_sekli = $vt->query("SELECT * FROM emlak_ilansekli WHERE id = '".$ilan["ilansekli"]."'")->fetch();
                    $ilan_kategori = $vt->query("SELECT * FROM emlak_kategori WHERE kat_id = '".$ilan["katid"]."'")->fetch(); 
                    $il=$vt->query("SELECT * FROM sehir where sehir_key = '".$ilan["il"]."'")->fetch();
                    $ilce=$vt->query("SELECT * FROM ilce where ilce_key = '".$ilan["ilce"]."'")->fetch();
                    $ilanresim=$vt->query("SELECT * FROM emlak_resim where emlakno = '".$ilan["emlakno"]."' && kapak = 1")->fetch();
                    $ekleyen = $vt->query("SELECT * FROM yonetici where id = '".$ilan["yonetici_id"]."'")->fetch(); 
                ?>
                <div class="col-lg-3 col-sm-6 col-12 mb-5">
                    <div class="card p-1 hover-box">
                 
                        <?php $favori = $vt->query("SELECT * FROM favoriler WHERE uye_id = '{$_SESSION["id"]}' AND ilan_id = '{$ilan["id"]}' ")->fetch(); ?>
                        <?php if(!$_SESSION["uyelogin"]) { ?>
                        <a href="#" data-toggle="modal" id="girisKontrol1<?php echo $ilan["id"] ?>" class="favori-ekle" style="">
                            <i class="fa fa-heart-o fa-lg"></i>
                        </a>
                        <?php } else { ?>
                        <a href="#" id="favEkle1<?php echo $ilan["id"] ?>" data-toggle="modal" class="favori-ekle" style="display:<?php if ($favori) { ?>none<?php } ?>">
                            <i class="fa fa-heart-o fa-lg"></i>
                        </a>
                        <?php } ?>
                        <a href="#" id="favCikar1<?php echo $ilan["id"] ?>" data-toggle="modal" class="favori-cikar" style="display:<?php if (!$favori) { ?>none<?php } ?>">
                            <i class="fa fa-heart fa-lg"></i>
                        </a> 
                        <script> 
                        $('#girisKontrol1<?php echo $ilan["id"] ?>').click(function ilanId(e){  
                            alert('Favorilere ekleyebilmeniz için lütfen üye girişi yapınız.');
                            window.location.href = '<?php echo $ayar["site_url"] ?>giris-yap';
                        });
                        $('#favEkle1<?php echo $ilan["id"] ?>').click(function ilanId(e){  
                            
                            $.post("index.php?do=ajax_favori&favori=ekle&ilanId=<?php echo $ilan["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>",function(data){
                                $('#gosterx').html(data);
                            }); 
                            
                            
                            $('#favEkle1<?php echo $ilan["id"] ?>').css({ 'display': 'none' }); 
                            $('#favCikar1<?php echo $ilan["id"] ?>').css({ 'display': 'block' }); 
                			
                        });
                        $('#favCikar1<?php echo $ilan["id"] ?>').click(function(){ 
                            
                            $.post("index.php?do=ajax_favori&favori=sil&ilanId=<?php echo $ilan["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>", function(data){
                                $("#gosterx").html(data);
                            }); 
                             
                            $('#favEkle1<?php echo $ilan["id"] ?>').css({ 'display': 'block' }); 
                            $('#favCikar1<?php echo $ilan["id"] ?>').css({ 'display': 'none' });   
                            
                        }); 
                        </script>
                        
                        <button class="karsilastir-ekle-btn" 
    data-id="<?=$ilan['id']?>" 
    data-baslik="<?=htmlspecialchars($ilan['baslik'])?>"
    data-fiyat="<?=htmlspecialchars(rakam($ilan['fiyat']).' '.$ilan['fiyatkur'])?>"
    data-resim="<?=$ilanresim['resimad']?>"
    title="Karşılaştır"
    style="position:absolute;top:38px;right:10px;background:rgba(0,0,0,0.55);color:#fff;border:none;border-radius:6px;padding:4px 8px;font-size:11px;cursor:pointer;z-index:2;">
    <i class="fa fa-exchange"></i>
</button>
<a class="emlak-grid-resim" href="/<?=$ilan["seo"];?>-ilan-<?=$ilan["id"];?>">
                            <?php if($ilanresim["resimad"] != ""): ?>
                            <img data-src="<?=RESIM;?>/<?php echo $ilanresim["resimad"]; ?>" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 200'%3E%3C/svg%3E" loading="lazy" class="lazy" height="200" width="100%" alt="<?=htmlspecialchars($ilan["baslik"]);?>">
                            <?php else: ?>
                            <img src="/uploads/resim/resim.png" loading="lazy" height="200" width="100%" alt="İlan Resmi">
                            <?php endif; ?>
                            <span class="badge bg-info text-white one-cikan"><strong>EN YENİ</strong></span>
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
                        <div class="p-2">
                            <p class="emlak_tipi_kat">
                                <strong>
                                    <?php echo ucwords(mb_strtolower($ilan_tipi["ad"])); ?>
                                    <?php echo ucwords(mb_strtolower($ilan_kategori["kat_adi"])); ?>
                                </strong>
                            </p> 
                                <h5 class=" mt-1 mb-2 font-weight-bold" style="/* text-transform: uppercase; */height: 46px;overflow: hidden;"><a href="/<?=$ilan["seo"];?>-ilan-<?=$ilan["id"];?>"><?=$ilan["baslik"];?></a></h5>
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
                <?php } ?>
            </div>
        </div> 
    </section>
    <?php } ?>
    <!-- ÖNE ÇIKAN İLANLAR -->
    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'one-cikan-ilanlar'")->fetch(); ?>
    <?php if ($cek["durum"]=="Aktif") { ?>
    <section id="categorie5.1-<?php echo $cek["sira"] ?>" class="sptb pt-7 pb-6">
        <div class="container">
            <div class="section-title text-center mb-5">
                <a href="/ilanara/" class="float-right h4 mt-4"></a>
                <h2 class="h2"><?php echo $cek["modul_baslik"] ?></h2>
                <p><?php echo $cek["modul_icerik"] ?></p> 
            </div> 
            <div class="row flex-lg-wrap flex-nowrap overflow-auto">
                <?php
                    $limitonecikanvitrin = $ayar["one_cikan"];
                    $emlakilanfirsat=$vt->query("SELECT * FROM emlak_ilan where durum = 0 && onay = 1 AND doping = 'var' AND doping_onay = 1 OR onecikan = 1 ORDER BY rand() limit ".$limitonecikanvitrin."");
                    while($ilan=$emlakilanfirsat->fetch()){
                    $ilantipi=$vt->query("SELECT * FROM emlak_ilantipi where id = '".$ilan["ilantipi"]."'")->fetch();
                    $dizi = explode (" ",$ilantipi['ad']);
                    $il=$vt->query("SELECT * FROM sehir where sehir_key = '".$ilan["il"]."'")->fetch();
                    $ilce=$vt->query("SELECT * FROM ilce where ilce_key = '".$ilan["ilce"]."'")->fetch();
                    $mahalle = $vt->query("SELECT * FROM mahalle where mahalle_id = '".$ilan["mahalle"]."'")->fetch();
                    $ilanresim=$vt->query("SELECT * FROM emlak_resim where emlakno = '".$ilan["emlakno"]."' && kapak = 1")->fetch();
                    $ekleyen = $vt->query("SELECT * FROM yonetici where id = '".$ilan["yonetici_id"]."'")->fetch(); 
                    $kategori = $vt->query("SELECT * FROM emlak_kategori where kat_id = '".$ilan["katid"]."'")->fetch(); 
                    $ilan_tipi = $vt->query("SELECT * FROM emlak_ilantipi WHERE id = '".$ilan["ilantipi"]."'")->fetch();
                    $ilan_sekli = $vt->query("SELECT * FROM emlak_ilansekli WHERE id = '".$ilan["ilansekli"]."'")->fetch();
                    $ilan_kategori = $vt->query("SELECT * FROM emlak_kategori WHERE kat_id = '".$ilan["katid"]."'")->fetch();
                    $doping_ilanlari = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '".$ilan["id"]."' AND doping_adi = 'one_cikan' AND bitis_tarihi > '".date('Y-m-d')."' AND odeme_durumu = 'Ödendi'")->fetch();
                ?>
                <?php if ($doping_ilanlari || $ilan["onecikan"]==1) { ?>
                <div class="col-lg-3 col-sm-6 col-12 mb-5">
                    <div class="card p-1 hover-box">
                         
                    <?php $favori = $vt->query("SELECT * FROM favoriler WHERE uye_id = '{$_SESSION["id"]}' AND ilan_id = '{$ilan["id"]}' ")->fetch(); ?>
                    <?php if(!$_SESSION["uyelogin"]) { ?>
                    <a href="#" data-toggle="modal" id="girisKontrol2<?php echo $ilan["id"] ?>" class="favori-ekle" style="">
                        <i class="fa fa-heart-o fa-lg"></i>
                    </a>
                    <?php } else { ?>
                    <a href="#" id="favEkle2<?php echo $ilan["id"] ?>" data-toggle="modal" class="favori-ekle" style="display:<?php if ($favori) { ?>none<?php } ?>">
                        <i class="fa fa-heart-o fa-lg"></i>
                    </a>
                    <?php } ?>
                    <a href="#" id="favCikar2<?php echo $ilan["id"] ?>" data-toggle="modal" class="favori-cikar" style="display:<?php if (!$favori) { ?>none<?php } ?>">
                        <i class="fa fa-heart fa-lg"></i>
                    </a> 
                    <script> 
                    $('#girisKontrol2<?php echo $ilan["id"] ?>').click(function ilanId(e){  
                        alert('Favorilere ekleyebilmeniz için lütfen üye girişi yapınız.');
                        window.location.href = '<?php echo $ayar["site_url"] ?>giris-yap';
                    });
                    $('#favEkle2<?php echo $ilan["id"] ?>').click(function ilanId(e){  
                        
                        $.post("index.php?do=ajax_favori&favori=ekle&ilanId=<?php echo $ilan["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>",function(data){
                            $('#gosterx').html(data);
                        }); 
                        
                        
                        $('#favEkle2<?php echo $ilan["id"] ?>').css({ 'display': 'none' }); 
                        $('#favCikar2<?php echo $ilan["id"] ?>').css({ 'display': 'block' }); 
            			
                    });
                    $('#favCikar2<?php echo $ilan["id"] ?>').click(function(){ 
                        
                        $.post("index.php?do=ajax_favori&favori=sil&ilanId=<?php echo $ilan["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>", function(data){
                            $("#gosterx").html(data);
                        }); 
                         
                        $('#favEkle2<?php echo $ilan["id"] ?>').css({ 'display': 'block' }); 
                        $('#favCikar2<?php echo $ilan["id"] ?>').css({ 'display': 'none' });   
                        
                    }); 
                    </script>
                    
                    <button class="karsilastir-ekle-btn" 
    data-id="<?=$ilan['id']?>" 
    data-baslik="<?=htmlspecialchars($ilan['baslik'])?>"
    data-fiyat="<?=htmlspecialchars(rakam($ilan['fiyat']).' '.$ilan['fiyatkur'])?>"
    data-resim="<?=$ilanresim['resimad']?>"
    title="Karşılaştır"
    style="position:absolute;top:38px;right:10px;background:rgba(0,0,0,0.55);color:#fff;border:none;border-radius:6px;padding:4px 8px;font-size:11px;cursor:pointer;z-index:2;">
    <i class="fa fa-exchange"></i>
</button>
<a class="emlak-grid-resim" href="/<?=$ilan["seo"];?>-ilan-<?=$ilan["id"];?>">
                        <?php if($ilanresim["resimad"] != ""): ?>
                        <img data-src="<?=RESIM;?>/<?php echo $ilanresim["resimad"]; ?>" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 200'%3E%3C/svg%3E" loading="lazy" class="lazy" height="200" width="100%" alt="<?=htmlspecialchars($ilan["baslik"]);?>">
                        <?php else: ?>
                        <img src="/uploads/resim/resim.png" loading="lazy" height="200" width="100%" alt="İlan Resmi">
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
                    <div class="p-2">
                        <p class="emlak_tipi_kat">
                            <strong>
                                <?php echo ucwords(mb_strtolower($ilan_tipi["ad"])); ?>
                                <?php echo ucwords(mb_strtolower($ilan_kategori["kat_adi"])); ?>
                            </strong>
                        </p> 
                            <h5 class=" mt-1 mb-2 font-weight-bold" style="/* text-transform: uppercase; */height: 46px;overflow: hidden;"><a href="/<?=$ilan["seo"];?>-ilan-<?=$ilan["id"];?>"><?=$ilan["baslik"];?></a></h5>
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
                                <span class="btn btn-block btn-white btn-sm"><i class="fa fa-tag"></i> <strong><?php echo rakam($ilan["fiyat"]); ?></strong> <?php echo $ilan["fiyatkur"]; ?></span>
                            </li>  
                        </ul>
                        <a href="/<?=$ilan["seo"];?>-ilan-<?=$ilan["id"];?>" href="/<?=$ilan["seo"];?>-ilan-<?=$ilan["id"];?>" class="btn btn-default bg-xs mt-4 btn-block">
                            DETAY
                        </a>
                    </div> 
                    </div>
                </div>
                <?php } ?>
                <?php } ?>
                <div class="text-center w-100">
                    <a class="btn btn-primary pl-5 pr-5 m-5" href="/ilanara/">Tüm İlanları Listele</a>
                </div>
            </div> 
        </div>
    </section>
    <?php } ?>
    <!-- HIZLI KATEGORİLER -->
    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'hizli-kategori-linkleri'")->fetch(); ?>
    <?php if ($cek["durum"]=="Aktif") { ?>
    <?php if (say("emlak_kategori", "anasayfa_goster", "1")>0): ?>  
    <section id="categorie5.1-<?php echo $cek["sira"] ?>" class="border bg-white p-5 d-none d-sm-block">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">                 
                    <div class="car d pl-5 pr-5">
                        <div class="card-b ody">
                            <div class="row">
                                <div class="col-md-2">
                                    <h3 class="mt-2"><strong><?php echo $cek["modul_baslik"] ?></strong></h3>
                                    <p><?php echo $cek["modul_icerik"] ?></p>
                                </div>
                                <div class="col-md-10">
                                    <nav class="nav nav-fill hizli-menu mt-4">
                                      <?php
                                        $kategoriler = $vt->query("SELECT * FROM emlak_kategori WHERE kat_durum = 1 AND anasayfa_goster = 1 ORDER BY sira_no ASC limit 0,10")->fetchAll();                                  
                                        foreach ($kategoriler AS $kategori)
                                        {
                                      ?>
                                        <a class="nav-item btn btn-outline-dark  text-dark bg-white pl-5 pr-5" href="<?php echo $kategori["anasayfa_link"]; ?>">
                                            <?php echo $kategori["kat_adi"]; ?> 
                                        </a>
                                      <?php } ?>
                                    </nav>
                                </div>
                            </div>              
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>  
    <?php } ?>
    <!-- VİTRİN İLANLARI -->
    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'vitrin-ilanlari'")->fetch(); ?>
    <?php if ($cek["durum"]=="Aktif") { ?>
    <section id="categorie5.1-<?php echo $cek["sira"] ?>" class="sptb  pt-6">
        <div class="container">
            <div class="section-title text-center mb-5">
                <a href="/ilanara/" class="float-right h4 mt-4"></a>
                <h2 class="h2"><?php echo $cek["modul_baslik"] ?></h2>
                <p><?php echo $cek["modul_icerik"] ?></p> 
            </div>                
            <div class="row flex-lg-wrap flex-nowrap overflow-auto">
            <?php
                    $ana_vitrin_limit = $ayar["ana_vitrin"];
                    $emlakilanfirsat=$vt->query("SELECT * FROM emlak_ilan where durum = 0 && onay = 1 AND doping = 'var' AND doping_onay = 1 OR anavitrin = 1 ORDER BY rand() limit ".$ana_vitrin_limit."");
                    while($ilan=$emlakilanfirsat->fetch()){
                    $ilantipi=$vt->query("SELECT * FROM emlak_ilantipi where id = '".$ilan["ilantipi"]."'")->fetch();
                    $dizi = explode (" ",$ilantipi['ad']);
                    $il=$vt->query("SELECT * FROM sehir where sehir_key = '".$ilan["il"]."'")->fetch();
                    $ilce=$vt->query("SELECT * FROM ilce where ilce_key = '".$ilan["ilce"]."'")->fetch();
                    $mahalle = $vt->query("SELECT * FROM mahalle where mahalle_id = '".$ilan["mahalle"]."'")->fetch();
                    $ilanresim=$vt->query("SELECT * FROM emlak_resim where emlakno = '".$ilan["emlakno"]."' && kapak = 1")->fetch();
                    $resimsay=$vt->query("SELECT * FROM emlak_resim where emlakno = '".$ilan["emlakno"]."'")->fetchAll();
                    $ekleyen = $vt->query("SELECT * FROM yonetici where id = '".$ilan["yonetici_id"]."'")->fetch(); 
                    $kategori = $vt->query("SELECT * FROM emlak_kategori where kat_id = '".$ilan["katid"]."'")->fetch(); 
                    $ilan_tipi = $vt->query("SELECT * FROM emlak_ilantipi WHERE id = '".$ilan["ilantipi"]."'")->fetch(); 
                    $ilan_sekli = $vt->query("SELECT * FROM emlak_ilansekli WHERE id = '".$ilan["ilansekli"]."'")->fetch();
                    $ilan_kategori = $vt->query("SELECT * FROM emlak_kategori WHERE kat_id = '".$ilan["katid"]."'")->fetch();
                    $doping_ilanlari = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '".$ilan["id"]."' AND doping_adi = 'vitrin_ilan' AND bitis_tarihi > '".date('Y-m-d')."' AND odeme_durumu = 'Ödendi'")->fetch();
                ?>
                <?php if ($doping_ilanlari || $ilan["anavitrin"]==1) { ?>
                <div class="col-lg-3 col-sm-6 col-12 mb-5">
                    <div class="card p-1 hover-box">
                        
                 
                    <?php $favori = $vt->query("SELECT * FROM favoriler WHERE uye_id = '{$_SESSION["id"]}' AND ilan_id = '{$ilan["id"]}' ")->fetch(); ?>
                    <?php if(!$_SESSION["uyelogin"]) { ?>
                    <a href="#" data-toggle="modal" id="girisKontrol3<?php echo $ilan["id"] ?>" class="favori-ekle" style="">
                        <i class="fa fa-heart-o fa-lg"></i>
                    </a>
                    <?php } else { ?>
                    <a href="#" id="favEkle3<?php echo $ilan["id"] ?>" data-toggle="modal" class="favori-ekle" style="display:<?php if ($favori) { ?>none<?php } ?>">
                        <i class="fa fa-heart-o fa-lg"></i>
                    </a>
                    <?php } ?>
                    <a href="#" id="favCikar3<?php echo $ilan["id"] ?>" data-toggle="modal" class="favori-cikar" style="display:<?php if (!$favori) { ?>none<?php } ?>">
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
                    
                    <button class="karsilastir-ekle-btn" 
    data-id="<?=$ilan['id']?>" 
    data-baslik="<?=htmlspecialchars($ilan['baslik'])?>"
    data-fiyat="<?=htmlspecialchars(rakam($ilan['fiyat']).' '.$ilan['fiyatkur'])?>"
    data-resim="<?=$ilanresim['resimad']?>"
    title="Karşılaştır"
    style="position:absolute;top:38px;right:10px;background:rgba(0,0,0,0.55);color:#fff;border:none;border-radius:6px;padding:4px 8px;font-size:11px;cursor:pointer;z-index:2;">
    <i class="fa fa-exchange"></i>
</button>
<a class="emlak-grid-resim" href="/<?=$ilan["seo"];?>-ilan-<?=$ilan["id"];?>">
                        <?php if($ilanresim["resimad"] != ""): ?>
                        <img data-src="<?=RESIM;?>/<?php echo $ilanresim["resimad"]; ?>" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 200'%3E%3C/svg%3E" loading="lazy" class="lazy" height="200" width="100%" alt="<?=htmlspecialchars($ilan["baslik"]);?>">
                        <?php else: ?>
                        <img src="/uploads/resim/resim.png" loading="lazy" height="200" width="100%" alt="İlan Resmi">
                        <?php endif; ?>
                        <span class="badge bg-success text-white one-cikan"><strong>VİTRİN</strong></span>
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
                    <div class="p-2">
                        <p class="emlak_tipi_kat">
                            <strong>
                                <?php echo ucwords(mb_strtolower($ilan_tipi["ad"])); ?>
                                <?php echo ucwords(mb_strtolower($ilan_kategori["kat_adi"])); ?>
                            </strong>
                        </p> 
                            <h5 class=" mt-1 mb-2 font-weight-bold" style="/* text-transform: uppercase; */height: 46px;overflow: hidden;"><a href="/<?=$ilan["seo"];?>-ilan-<?=$ilan["id"];?>"><?=$ilan["baslik"];?></a></h5>
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
                                <span class="btn btn-block btn-white btn-sm"><i class="fa fa-tag"></i> <strong><?php echo rakam($ilan["fiyat"]); ?></strong> <?php echo $ilan["fiyatkur"]; ?></span>
                            </li>  
                        </ul>
                        <a href="/<?=$ilan["seo"];?>-ilan-<?=$ilan["id"];?>" href="/<?=$ilan["seo"];?>-ilan-<?=$ilan["id"];?>" class="btn btn-default bg-xs mt-4 btn-block">
                            DETAY
                        </a>
                    </div> 
                    </div>
                </div>
                <?php } ?>
                <?php } ?>
            </div>
        </div>
    </section>
    <?php } ?>
    <!-- ŞEHİRLER -->
    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'sehirlere-gore-ilanlar'")->fetch(); ?>
    <?php if ($cek["durum"]=="Aktif") { ?>
    <section id="categorie5.1-<?php echo $cek["sira"] ?>" class="badge-light pt-7 pb-8 mb-6">
        <div class="container-fluid pl-8 pr-8 p-sm-0">
            <div class="section-title container"> 
                <a href="/ilanara/" class="float-right h5 mt-2">Tüm İlanlar <i class="fa fa-angle-double-right fa-lg"></i></a>
                <h3><strong>
                    <?php echo $cek["modul_baslik"] ?></strong> <br>
                    <small style="font-size:13px"><?php echo $cek["modul_icerik"] ?></small>
                </h3>
            </div>                
            <div id="myCarousel2" class="owl-carousel owl-carousel-icons2 owl-loaded owl-drag">
                <!-- Wrapper for carousel items -->
                <div class="owl-stage-outer">
                    <div class="owl-stage">
                       <?php
                            $sehirler = $vt->query("SELECT * FROM sehir WHERE ozet = 1 ORDER BY sehir_key ASC")->fetchAll(); 
                            foreach ($sehirler AS $sehir):
                            $emlak_say = $vt->query("SELECT * FROM emlak_ilan WHERE il = {$sehir['sehir_key']} AND durum = 0 AND onay = 1");  
                        ?>
                        <div class="owl-item">
                            <div class="item">
                                 <div class="card">
                                    <div class="card-body sehir-con">
                                        <div class="lokasyon-resim d-flex aling-items-end justify-content-center">
                                            <?php if ($sehir["resim_link"] == ""): ?>
                                            <img rel="no-follow" title="<?php echo $sehir["adi"]; ?>" class="img-fluid mb-2 " src="uploads/resim/resim.png">
                                            <?php else: ?>
                                            <img rel="no-follow" title="<?php echo $sehir["adi"]; ?>" class="img-fluid mb-2" src="<?php echo $sehir["resim_link"]; ?>">
                                            <?php endif; ?>
                                            <div class="lokasyon-resim-icerik position-absolute h-100 w-100 text-center">
                                                <!-- <i class="fa fa-map-marker fa-2x d-block w-100 mb-3 text-warning"></i> -->
                                                <h5 class="lokasyon-title d-block w-100">
                                                    <strong>
                                                        <?php echo $sehir["adi"]; ?>
                                                    </strong>
                                                </h5>
                                                <h6 class="lokasyon-bilgi d-block w-100"><strong><?php echo $emlak_say->rowCount(); ?>' den fazla ilan</strong></h6>
                                            </div>
                                        </div>
                                        <div class="p-3">
                                        <?php
                                            $emlak_tipleri = $vt->query("SELECT * FROM emlak_ilantipi WHERE durum = 0 LIMIT 2")->fetchAll();
                                            foreach ($emlak_tipleri AS $tip):
                                        ?>
                                            <a href="/ilanara/?il=<?php echo $sehir["sehir_key"]; ?>&emlaktipi=<?php echo $tip["id"]; ?>" class="btn btn-block" style="background:<?php echo $tip["baslikrenk"]; ?> !important; color:<?php echo $tip["yazirenk"]; ?> !important;"><?php echo $tip["ad"]; ?></a>
                                        <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="owl-nav">
                    <button type="button" role="presentation" class="owl-prev"><span aria-label="Previous">‹</span></button>
                    <button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span></button>
                </div>
                <div class="owl-dots disabled"></div>
            </div>
        </div> 
    </section>
    <?php } ?>
    <!-- ACİL İLANLAR -->
    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'anasayfa-acil'")->fetch(); ?>
    <?php if ($cek["durum"]=="Aktif") { ?>
    <section id="categorie5.1-<?php echo $cek["sira"] ?>" class="sptb  pt-5">
        <div class="container">
            <div class="section-title text-center mb-5">
                <a href="/ilanara/" class="float-right h4 mt-4"></a>
                <h2 class="h2"><?php echo $cek["modul_baslik"] ?></h2>
                <p><?php echo $cek["modul_icerik"] ?></p> 
            </div>
            <div class="row flex-lg-wrap flex-nowrap overflow-auto">
            <?php
                $limitacilvitrin = $ayar["acil_ilan"];
                $emlakilanfirsat=$vt->query("SELECT * FROM emlak_ilan where durum = 0 && onay = 1 AND doping = 'var' AND doping_onay = 1 OR acil = 1 ORDER BY rand() limit ".$limitacilvitrin."");
                while($ilan=$emlakilanfirsat->fetch()){
                $ilantipi=$vt->query("SELECT * FROM emlak_ilantipi where id = '".$ilan["ilantipi"]."'")->fetch();
                $dizi = explode (" ",$ilantipi['ad']);
                $il=$vt->query("SELECT * FROM sehir where sehir_key = '".$ilan["il"]."'")->fetch();
                $ilce=$vt->query("SELECT * FROM ilce where ilce_key = '".$ilan["ilce"]."'")->fetch();
                $mahalle = $vt->query("SELECT * FROM mahalle where mahalle_id = '".$ilan["mahalle"]."'")->fetch();
                $ilanresim=$vt->query("SELECT * FROM emlak_resim where emlakno = '".$ilan["emlakno"]."' && kapak = 1")->fetch();
                $ekleyen = $vt->query("SELECT * FROM yonetici where id = '".$ilan["yonetici_id"]."'")->fetch(); 
                $kategori = $vt->query("SELECT * FROM emlak_kategori where kat_id = '".$ilan["katid"]."'")->fetch(); 
                $ilan_tipi = $vt->query("SELECT * FROM emlak_ilantipi WHERE id = '".$ilan["ilantipi"]."'")->fetch();
                $ilan_sekli = $vt->query("SELECT * FROM emlak_ilansekli WHERE id = '".$ilan["ilansekli"]."'")->fetch();
                $ilan_kategori = $vt->query("SELECT * FROM emlak_kategori WHERE kat_id = '".$ilan["katid"]."'")->fetch();
                $doping_ilanlari = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '".$ilan["id"]."' AND doping_adi = 'acil_ilan' AND bitis_tarihi > '".date('Y-m-d')."' AND odeme_durumu = 'Ödendi'")->fetch();
            ?>
            <?php if ($doping_ilanlari || $ilan["acil"]==1) { ?> 
                <div class="col-lg-3 col-sm-6 col-12 mb-5">
                    <div class="card p-1 hover-box">
                 
                    <?php $favori = $vt->query("SELECT * FROM favoriler WHERE uye_id = '{$_SESSION["id"]}' AND ilan_id = '{$ilan["id"]}' ")->fetch(); ?>
                    <?php if(!$_SESSION["uyelogin"]) { ?>
                    <a href="#" data-toggle="modal" id="girisKontrol4<?php echo $ilan["id"] ?>" class="favori-ekle" style="">
                        <i class="fa fa-heart-o fa-lg"></i>
                    </a>
                    <?php } else { ?>
                    <a href="#" id="favEkle4<?php echo $ilan["id"] ?>" data-toggle="modal" class="favori-ekle" style="display:<?php if ($favori) { ?>none<?php } ?>">
                        <i class="fa fa-heart-o fa-lg"></i>
                    </a>
                    <?php } ?>
                    <a href="#" id="favCikar4<?php echo $ilan["id"] ?>" data-toggle="modal" class="favori-cikar" style="display:<?php if (!$favori) { ?>none<?php } ?>">
                        <i class="fa fa-heart fa-lg"></i>
                    </a> 
                    <script> 
                    $('#girisKontrol4<?php echo $ilan["id"] ?>').click(function ilanId(e){  
                        alert('Favorilere ekleyebilmeniz için lütfen üye girişi yapınız.');
                        window.location.href = '<?php echo $ayar["site_url"] ?>giris-yap';
                    });
                    $('#favEkle4<?php echo $ilan["id"] ?>').click(function ilanId(e){  
                        
                        $.post("index.php?do=ajax_favori&favori=ekle&ilanId=<?php echo $ilan["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>",function(data){
                            $('#gosterx').html(data);
                        }); 
                        
                        
                        $('#favEkle4<?php echo $ilan["id"] ?>').css({ 'display': 'none' }); 
                        $('#favCikar4<?php echo $ilan["id"] ?>').css({ 'display': 'block' }); 
            			
                    });
                    $('#favCikar4<?php echo $ilan["id"] ?>').click(function(){ 
                        
                        $.post("index.php?do=ajax_favori&favori=sil&ilanId=<?php echo $ilan["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>", function(data){
                            $("#gosterx").html(data);
                        }); 
                         
                        $('#favEkle4<?php echo $ilan["id"] ?>').css({ 'display': 'block' }); 
                        $('#favCikar4<?php echo $ilan["id"] ?>').css({ 'display': 'none' });   
                        
                    }); 
                    </script>
                    
                    <button class="karsilastir-ekle-btn" 
    data-id="<?=$ilan['id']?>" 
    data-baslik="<?=htmlspecialchars($ilan['baslik'])?>"
    data-fiyat="<?=htmlspecialchars(rakam($ilan['fiyat']).' '.$ilan['fiyatkur'])?>"
    data-resim="<?=$ilanresim['resimad']?>"
    title="Karşılaştır"
    style="position:absolute;top:38px;right:10px;background:rgba(0,0,0,0.55);color:#fff;border:none;border-radius:6px;padding:4px 8px;font-size:11px;cursor:pointer;z-index:2;">
    <i class="fa fa-exchange"></i>
</button>
<a class="emlak-grid-resim" href="/<?=$ilan["seo"];?>-ilan-<?=$ilan["id"];?>">
                        <?php if($ilanresim["resimad"] != ""): ?>
                        <img data-src="<?=RESIM;?>/<?php echo $ilanresim["resimad"]; ?>" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 200'%3E%3C/svg%3E" loading="lazy" class="lazy" height="200" width="100%" alt="<?=htmlspecialchars($ilan["baslik"]);?>">
                        <?php else: ?>
                        <img src="/uploads/resim/resim.png" loading="lazy" height="200" width="100%" alt="İlan Resmi">
                        <?php endif; ?>
                        <span class="badge bg-danger text-white one-cikan"><strong>ACİL</strong></span>
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
                    <div class="p-2">
                        <p class="emlak_tipi_kat">
                            <strong>
                                <?php echo ucwords(mb_strtolower($ilan_tipi["ad"])); ?>
                                <?php echo ucwords(mb_strtolower($ilan_kategori["kat_adi"])); ?>
                            </strong>
                        </p> 
                            <h5 class=" mt-1 mb-2 font-weight-bold" style="/* text-transform: uppercase; */height: 46px;overflow: hidden;"><a href="/<?=$ilan["seo"];?>-ilan-<?=$ilan["id"];?>"><?=$ilan["baslik"];?></a></h5>
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
                                <span class="btn btn-block btn-white btn-sm"><i class="fa fa-tag"></i> <strong><?php echo rakam($ilan["fiyat"]); ?></strong> <?php echo $ilan["fiyatkur"]; ?></span>
                            </li>  
                        </ul>
                        <a href="/<?=$ilan["seo"];?>-ilan-<?=$ilan["id"];?>" href="/<?=$ilan["seo"];?>-ilan-<?=$ilan["id"];?>" class="btn btn-default bg-xs mt-4 btn-block">
                            DETAY
                        </a>
                    </div> 
                    </div>
                </div>
                <?php } ?>
            <?php } ?>
            </div>
        </div>
    </section>
    <?php } ?>
    <!-- FIRSAT İLANLARI -->
    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'sicak-firsatlar'")->fetch(); ?>
    <?php if ($cek["durum"]=="Aktif") { ?>
    <section id="categorie5.1-<?php echo $cek["sira"] ?>" class="sptb  pt-5 pb-6">
        <div class="container">
            <div class="section-title text-center mb-5">
                <a href="/ilanara/" class="float-right h4 mt-4"></a>
                <h2 class="h2"><?php echo $cek["modul_baslik"] ?></h2>
                <p><?php echo $cek["modul_icerik"] ?></p> 
            </div>
            <div class="row flex-lg-wrap flex-nowrap overflow-auto">
                <?php
                    $firsat_ilan_limit = $ayar["firsat_ilan"];
                    $emlakilanfirsat=$vt->query("SELECT * FROM emlak_ilan where durum = 0 && onay = 1 AND doping = 'var' AND doping_onay = 1 OR firsatvitrin = 1 ORDER BY rand() limit ".$firsat_ilan_limit."");
                    while($ilan=$emlakilanfirsat->fetch()){
                    $ilantipi=$vt->query("SELECT * FROM emlak_ilantipi where id = '".$ilan["ilantipi"]."'")->fetch();
                    $dizi = explode (" ",$ilantipi['ad']);
                    $il=$vt->query("SELECT * FROM sehir where sehir_key = '".$ilan["il"]."'")->fetch();
                    $ilce=$vt->query("SELECT * FROM ilce where ilce_key = '".$ilan["ilce"]."'")->fetch();
                    $mahalle = $vt->query("SELECT * FROM mahalle where mahalle_id = '".$ilan["mahalle"]."'")->fetch();
                    $ilanresim=$vt->query("SELECT * FROM emlak_resim where emlakno = '".$ilan["emlakno"]."' && kapak = 1")->fetch();
                    $ekleyen = $vt->query("SELECT * FROM yonetici where id = '".$ilan["yonetici_id"]."'")->fetch(); 
                    $kategori = $vt->query("SELECT * FROM emlak_kategori where kat_id = '".$ilan["katid"]."'")->fetch(); 
                    $ilan_tipi = $vt->query("SELECT * FROM emlak_ilantipi WHERE id = '".$ilan["ilantipi"]."'")->fetch();
                    $ilan_sekli = $vt->query("SELECT * FROM emlak_ilansekli WHERE id = '".$ilan["ilansekli"]."'")->fetch();
                    $ilan_kategori = $vt->query("SELECT * FROM emlak_kategori WHERE kat_id = '".$ilan["katid"]."'")->fetch();
                    $doping_ilanlari = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '".$ilan["id"]."' AND doping_adi = 'sicak_firsat' AND bitis_tarihi > '".date('Y-m-d')."' AND odeme_durumu = 'Ödendi'")->fetch();
                ?>
                <?php if ($doping_ilanlari || $ilan["firsatvitrin"]==1) { ?> 
                <div class="col-lg-3 col-sm-6 col-12 mb-5">
                    <div class="card p-1 hover-box">
                 
                        <?php $favori = $vt->query("SELECT * FROM favoriler WHERE uye_id = '{$_SESSION["id"]}' AND ilan_id = '{$ilan["id"]}' ")->fetch(); ?>
                        <?php if(!$_SESSION["uyelogin"]) { ?>
                        <a href="#" data-toggle="modal" id="girisKontrol5<?php echo $ilan["id"] ?>" class="favori-ekle" style="">
                            <i class="fa fa-heart-o fa-lg"></i>
                        </a>
                        <?php } else { ?>
                        <a href="#" id="favEkle5<?php echo $ilan["id"] ?>" data-toggle="modal" class="favori-ekle" style="display:<?php if ($favori) { ?>none<?php } ?>">
                            <i class="fa fa-heart-o fa-lg"></i>
                        </a>
                        <?php } ?>
                        <a href="#" id="favCikar5<?php echo $ilan["id"] ?>" data-toggle="modal" class="favori-cikar" style="display:<?php if (!$favori) { ?>none<?php } ?>">
                            <i class="fa fa-heart fa-lg"></i>
                        </a> 
                        <script> 
                        $('#girisKontrol5<?php echo $ilan["id"] ?>').click(function ilanId(e){  
                            alert('Favorilere ekleyebilmeniz için lütfen üye girişi yapınız.');
                            window.location.href = '<?php echo $ayar["site_url"] ?>giris-yap';
                        });
                        $('#favEkle5<?php echo $ilan["id"] ?>').click(function ilanId(e){  
                            
                            $.post("index.php?do=ajax_favori&favori=ekle&ilanId=<?php echo $ilan["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>",function(data){
                                $('#gosterx').html(data);
                            }); 
                            
                            
                            $('#favEkle5<?php echo $ilan["id"] ?>').css({ 'display': 'none' }); 
                            $('#favCikar5<?php echo $ilan["id"] ?>').css({ 'display': 'block' }); 
                			
                        });
                        $('#favCikar5<?php echo $ilan["id"] ?>').click(function(){ 
                            
                            $.post("index.php?do=ajax_favori&favori=sil&ilanId=<?php echo $ilan["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>", function(data){
                                $("#gosterx").html(data);
                            }); 
                             
                            $('#favEkle5<?php echo $ilan["id"] ?>').css({ 'display': 'block' }); 
                            $('#favCikar5<?php echo $ilan["id"] ?>').css({ 'display': 'none' });   
                            
                        }); 
                        </script>
                        <button class="karsilastir-ekle-btn" 
    data-id="<?=$ilan['id']?>" 
    data-baslik="<?=htmlspecialchars($ilan['baslik'])?>"
    data-fiyat="<?=htmlspecialchars(rakam($ilan['fiyat']).' '.$ilan['fiyatkur'])?>"
    data-resim="<?=$ilanresim['resimad']?>"
    title="Karşılaştır"
    style="position:absolute;top:38px;right:10px;background:rgba(0,0,0,0.55);color:#fff;border:none;border-radius:6px;padding:4px 8px;font-size:11px;cursor:pointer;z-index:2;">
    <i class="fa fa-exchange"></i>
</button>
<a class="emlak-grid-resim" href="/<?=$ilan["seo"];?>-ilan-<?=$ilan["id"];?>">
                            <?php if($ilanresim["resimad"] != ""): ?>
                            <img data-src="<?=RESIM;?>/<?php echo $ilanresim["resimad"]; ?>" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 200'%3E%3C/svg%3E" loading="lazy" class="lazy" height="200" width="100%" alt="<?=htmlspecialchars($ilan["baslik"]);?>">
                            <?php else: ?>
                            <img src="/uploads/resim/resim.png" loading="lazy" height="200" width="100%" alt="İlan Resmi">
                            <?php endif; ?>
                            <span class="badge bg-warning text-white one-cikan"><strong>FIRSAT</strong></span>
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
                        <div class="p-2">
                            <p class="emlak_tipi_kat">
                                <strong>
                                    <?php echo ucwords(mb_strtolower($ilan_tipi["ad"])); ?>
                                    <?php echo ucwords(mb_strtolower($ilan_kategori["kat_adi"])); ?>
                                </strong>
                            </p> 
                                <h5 class=" mt-1 mb-2 font-weight-bold" style="/* text-transform: uppercase; */height: 46px;overflow: hidden;"><a href="/<?=$ilan["seo"];?>-ilan-<?=$ilan["id"];?>"><?=$ilan["baslik"];?></a></h5>
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
                                    <span class="btn btn-block btn-white btn-sm"><i class="fa fa-tag"></i> <strong><?php echo rakam($ilan["fiyat"]); ?></strong> <?php echo $ilan["fiyatkur"]; ?></span>
                                </li>  
                            </ul>
                            <a href="/<?=$ilan["seo"];?>-ilan-<?=$ilan["id"];?>" href="/<?=$ilan["seo"];?>-ilan-<?=$ilan["id"];?>" class="btn btn-default bg-xs mt-4 btn-block">
                                DETAY
                            </a>
                        </div> 
                    </div>
                </div>
                <?php } ?>
                <?php } ?>
            </div>
        </div>
    </section>
    <?php } ?>
    <!-- İLAN VE BUTON ALANI 1 -->
    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'ilan-ver-buton-alani-1'")->fetch(); ?>
    <?php if ($cek["durum"]=="Aktif") { ?>
    <section id="categorie5.1-<?php echo $cek["sira"] ?>" class=" mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="card box-1">
                        <div class="text-center">
                            <h3><strong>Ücretsiz İlan verin!</strong></h3>
                            <p>İlanın Yüzbinlerce İlan Arasında Yayınlansın</p> 
                            <a target="_blank" href="/haldiz/index.php?do=islem&amp;emlak=emlak_ekle&amp;islem=sec" class="btn btn-danger btn-block b n-lg p-3"><strong>Ücretsiz İlan Ver!</strong></a>         
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card box-1 text-white" style="background:url('/uploads/resim/01-3.jpg') center center no-repeat; background-size:cover !important;">
                        <div class="card-body">
                            <div class="text-center">
                                <h2><?php echo $cek["modul_baslik"] ?></h2>
                                <p><?php echo $cek["modul_icerik"] ?></p>                       
                                <a href="/ilanara/" class="btn btn-outline-light bt n-lg p-3 pl-7 pr-7"><strong>Tüm İlanlar</strong></a>                                
                            </div>              
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card box-1">
                        <div class="text-center">
                            <h3><strong>Satın / Kiralayın!</strong></h3>
                            <p>İlanın Yüzbinlerce İlan Arasında Yayınlansın</p> 
                            <a target="_blank" href="/haldiz/index.php?do=islem&amp;emlak=emlak_ekle&amp;islem=sec" class="btn btn-danger btn-block b tn-lg p-3"><strong>Ücretsiz İlan Ver!</strong></a>            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> 
    <?php } ?>
    <!-- İLAN VE BUTON ALANI 2 -->
    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'ilan-ver-buton-alani-2'")->fetch(); ?>
    <?php if ($cek["durum"]=="Aktif") { ?>
    <section id="categorie5.1-<?php echo $cek["sira"] ?>" class=" mt-5 mb-7">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="card box-1 text-white bg-success">
                        <div class="text-center">
                            <h3><strong>Ücretsiz İlan verin!</strong></h3>
                            <p>İlanın Yüzbinlerce İlan Arasında Yayınlansın</p> 
                            <a target="_blank" href="/haldiz/index.php?do=islem&amp;emlak=emlak_ekle&amp;islem=sec" class="btn btn-light btn-block b n-lg p-3"><strong>Ücretsiz İlan Ver!</strong></a>          
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card box-1 text-white" style="background:url('/uploads/resim/01-3.jpg') center center no-repeat; background-size:cover !important;">
                        <div class="card-body">
                            <div class="text-center">
                                <h2><?php echo $cek["modul_baslik"] ?></h2>
                                <p><?php echo $cek["modul_icerik"] ?></p>                       
                                <a href="/ilanara/" class="btn btn-outline-light bt n-lg p-3 pl-7 pr-7"><strong>Tüm İlanlar</strong></a>                                
                            </div>              
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card box-1 text-white bg-success">
                        <div class="text-center">
                            <h3><strong>Satın / Kiralayın!</strong></h3>
                            <p>İlanın Yüzbinlerce İlan Arasında Yayınlansın</p> 
                            <a target="_blank" href="/haldiz/index.php?do=islem&amp;emlak=emlak_ekle&amp;islem=sec" class="btn btn-light btn-block b tn-lg p-3"><strong>Ücretsiz İlan Ver!</strong></a>         
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php } ?>
    <!-- DANIŞMANLAR -->
    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'danismanlar'")->fetch(); ?>
    <?php if ($cek["durum"]=="Aktif") { ?>
    <section id="categorie5.1-<?php echo $cek["sira"] ?>" class="sptb position-relative pat tern badge-light pt-8 pb-12">
        <div class="container">
            <div class="section-title center-block text-center">
                <h2 class="text-whi te position-relative pb-5">
                    <?php echo $cek["modul_baslik"] ?><br>
                    <small style="font-size:13px"><?php echo $cek["modul_icerik"] ?></small>
                </h2> 
            </div>
            <div class="row">
                <div class="offset-md-12 col-md-12">
                    <div id="myCarousel" class="owl-carousel owl-carousel-icons owl-loaded owl-drag">
                        <div class="owl-stage-outer">
                            <div class="owl-stage">
                                <?php 
                                    $danadi = $_GET["danadi"];
                                    $il = $_GET["il"];
                                    $ilce = $_GET["ilce"];
                                    $danismanlar = $vt->query("SELECT * FROM yonetici where (il like '%$il%' or ilce like '%$ilce%') and adsoyad like '%$danadi%' ");
                                    while($dan = $danismanlar->fetch()) {
                                        $ilansayisi = $vt->query("SELECT COUNT(*) FROM emlak_ilan where yonetici_id = '".$dan["id"]."'");
                                        $sayi = $ilansayisi->fetch();
                                ?>  
                                <div class="owl-item">
                                    <div class="item text-center">
                                        <div class="testimonia card card-body" style="padding:50px !important;">
                                            <div class="owl-controls clickable text- emlak-grid-resim">
                                                <?php 
                                                if ($dan["resim"] != "") {
                                                ?>
                                                <img src="/<?=$dan["resim"];?>" style="height: 150px; width: auto; margin: auto;" alt="<?=$dan["adsoyad"];?>" width="auto" height="150" class="img-thumbnail">
                                                <?php } else { ?>
                                                <img src="/uploads/resim/resim.png" style="height: 150px; width: auto; margin: auto;" alt="<?=$dan["adsoyad"];?>" width="auto" height="150" class="img-thumbnail">
                                                <?php } ?>
                                            </div>                                                
                                            <div class="testimonia-data">
                                                <h5 class="mb-5"><?=$dan["adsoyad"];?> </h5>
                                                <div class="rating-stars">
                                                    <input type="number" readonly="readonly" class="rating-value star" name="rating-stars-value" value="3">
                                                    <div class="rating-stars-container pl-8 pr-8 mb-3"></div>
                                                    <a href="danisman/<?=$dan["id"];?>" class="btn btn-sm btn-light btn-outline pl-5 pr-5"><i class="fa fa-eye"></i> DETAYLAR (<?php echo $sayi[0]; ?>) </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="owl-nav">
                            <button type="button" role="presentation" class="owl-prev"><span aria-label="Previous">‹</span></button>
                            <button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span></button>
                        </div>
                        <div class="owl-dots disabled"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>  
    <?php } ?>
    <!-- ÖNE ÇIKAN PROJELER -->
    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'one-cikan-konut-projeleri'")->fetch(); ?>
    <?php if ($cek["durum"]=="Aktif") { ?>
    <section id="categorie5.1-<?php echo $cek["sira"] ?>" class="mt-7 bg-primary pb-8" id="categorie5.1-12">
        <div class="container">
            <div class="section-title pt-5 text-white">
                <h5 class="h1 font-weight-light mt-5 mb-5">
                    <?php echo $cek["modul_baslik"] ?><br>
                    <span style="font-size:13px"><?php echo $cek["modul_icerik"] ?></span>
                </h5>
            </div>
            <div class="row flex-lg-wrap flex-nowrap overflow-auto">
                <?php 
                    $sekli=$vt->query("SELECT * FROM emlak_ilansekli where durum = 0 AND kat_tipi = 'proje'")->fetch(PDO::FETCH_ASSOC);
                    $sonilan = $vt->query("SELECT * FROM emlak_ilan where durum = 0 AND onay = 1 AND ilansekli = ".$sekli["id"]." limit 8");
                    while($ilan=$sonilan->fetch(PDO::FETCH_ASSOC)) {
                    $ilantipi=$vt->query("SELECT * FROM emlak_ilantipi where id = '".$ilan["ilantipi"]."'")->fetch();
                    $dizi = explode (" ",$ilantipi['ad']);
                    $il=$vt->query("SELECT * FROM sehir where sehir_key = '".$ilan["il"]."'")->fetch();
                    $ilce=$vt->query("SELECT * FROM ilce where ilce_key = '".$ilan["ilce"]."'")->fetch();
                    $mahalle = $vt->query("SELECT * FROM mahalle where mahalle_id = '".$ilan["mahalle"]."'")->fetch();
                    $ilanresim=$vt->query("SELECT * FROM emlak_resim where emlakno = '".$ilan["emlakno"]."' && kapak = 1")->fetch();
                    $ekleyen = $vt->query("SELECT * FROM yonetici where id = '".$ilan["yonetici_id"]."'")->fetch(); 
                    $kategori = $vt->query("SELECT * FROM emlak_kategori where kat_id = '".$ilan["katid"]."'")->fetch(); 
                    $ilan_tipi = $vt->query("SELECT * FROM emlak_ilantipi WHERE id = '".$ilan["ilantipi"]."'")->fetch();
                    $ilan_sekli = $vt->query("SELECT * FROM emlak_ilansekli WHERE id = '".$ilan["ilansekli"]."'")->fetch();
                    $ilan_kategori = $vt->query("SELECT * FROM emlak_kategori WHERE kat_id = '".$ilan["katid"]."'")->fetch();
                ?>  
                <div class="col-lg-3 col-sm-6 col-12 mb-5">
                    <div class="card p-1 hover-box">
                 
                    <?php $favori = $vt->query("SELECT * FROM favoriler WHERE uye_id = '{$_SESSION["id"]}' AND ilan_id = '{$ilan["id"]}' ")->fetch(); ?>
                    <?php if(!$_SESSION["uyelogin"]) { ?>
                    <a href="#" data-toggle="modal" id="girisKontrol6<?php echo $ilan["id"] ?>" class="favori-ekle" style="">
                        <i class="fa fa-heart-o fa-lg"></i>
                    </a>
                    <?php } else { ?>
                    <a href="#" id="favEkle6<?php echo $ilan["id"] ?>" data-toggle="modal" class="favori-ekle" style="display:<?php if ($favori) { ?>none<?php } ?>">
                        <i class="fa fa-heart-o fa-lg"></i>
                    </a>
                    <?php } ?>
                    <a href="#" id="favCikar6<?php echo $ilan["id"] ?>" data-toggle="modal" class="favori-cikar" style="display:<?php if (!$favori) { ?>none<?php } ?>">
                        <i class="fa fa-heart fa-lg"></i>
                    </a> 
                    <script> 
                    $('#girisKontrol6<?php echo $ilan["id"] ?>').click(function ilanId(e){  
                        alert('Favorilere ekleyebilmeniz için lütfen üye girişi yapınız.');
                        window.location.href = '<?php echo $ayar["site_url"] ?>giris-yap';
                    });
                    $('#favEkle6<?php echo $ilan["id"] ?>').click(function ilanId(e){  
                        
                        $.post("index.php?do=ajax_favori&favori=ekle&ilanId=<?php echo $ilan["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>",function(data){
                            $('#gosterx').html(data);
                        }); 
                        
                        
                        $('#favEkle6<?php echo $ilan["id"] ?>').css({ 'display': 'none' }); 
                        $('#favCikar6<?php echo $ilan["id"] ?>').css({ 'display': 'block' }); 
            			
                    });
                    $('#favCikar6<?php echo $ilan["id"] ?>').click(function(){ 
                        
                        $.post("index.php?do=ajax_favori&favori=sil&ilanId=<?php echo $ilan["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>", function(data){
                            $("#gosterx").html(data);
                        }); 
                         
                        $('#favEkle6<?php echo $ilan["id"] ?>').css({ 'display': 'block' }); 
                        $('#favCikar6<?php echo $ilan["id"] ?>').css({ 'display': 'none' });   
                        
                    }); 
                    </script>
                    <button class="karsilastir-ekle-btn" 
    data-id="<?=$ilan['id']?>" 
    data-baslik="<?=htmlspecialchars($ilan['baslik'])?>"
    data-fiyat="<?=htmlspecialchars(rakam($ilan['fiyat']).' '.$ilan['fiyatkur'])?>"
    data-resim="<?=$ilanresim['resimad']?>"
    title="Karşılaştır"
    style="position:absolute;top:38px;right:10px;background:rgba(0,0,0,0.55);color:#fff;border:none;border-radius:6px;padding:4px 8px;font-size:11px;cursor:pointer;z-index:2;">
    <i class="fa fa-exchange"></i>
</button>
<a class="emlak-grid-resim" href="/<?=$ilan["seo"];?>-ilan-<?=$ilan["id"];?>">
                        <?php if($ilanresim["resimad"] != ""): ?>
                        <img data-src="<?=RESIM;?>/<?php echo $ilanresim["resimad"]; ?>" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 200'%3E%3C/svg%3E" loading="lazy" class="lazy" height="200" width="100%" alt="<?=htmlspecialchars($ilan["baslik"]);?>">
                        <?php else: ?>
                        <img src="/uploads/resim/resim.png" loading="lazy" height="200" width="100%" alt="İlan Resmi">
                        <?php endif; ?>
                        <span class="badge bg-danger text-white one-cikan"><strong>PROJE</strong></span>
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
                    <div class="p-2">
                        <p class="emlak_tipi_kat">
                            <strong>
                                <?php echo ucwords(mb_strtolower($ilan_tipi["ad"])); ?>
                                <?php echo ucwords(mb_strtolower($ilan_kategori["kat_adi"])); ?>
                            </strong>
                        </p> 
                            <h5 class=" mt-1 mb-2 font-weight-bold" style="/* text-transform: uppercase; */height: 46px;overflow: hidden;"><a href="/<?=$ilan["seo"];?>-ilan-<?=$ilan["id"];?>"><?=$ilan["baslik"];?></a></h5>
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
                                <span class="btn btn-block btn-white btn-sm"><i class="fa fa-tag"></i> <strong><?php echo rakam($ilan["fiyat"]); ?></strong> <?php echo $ilan["fiyatkur"]; ?></span>
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
        </div>
    </section>
    <?php } ?>
    <!-- HABERLER -->   
    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'emlak-haberleri'")->fetch(); ?>
    <?php if ($cek["durum"]=="Aktif") { ?>
    <section id="categorie5.1-<?php echo $cek["sira"] ?>" class="sptb  pt-5 pb-6 mb-8">
        <div class="container">
            <div class="section-title">
                <h2 class="text-whi te position-relative pb-5 pt-5">
                    <?php echo $cek["modul_baslik"] ?><br>
                    <small style="font-size:13px"><?php echo $cek["modul_icerik"] ?></small>
                </h2>  
            </div>
            <div class="row">
                <?php
                    $habersayfa = mysql_query("SELECT * FROM haber WHERE durum = 0 LIMIT 1");
                    while($bsayfa = mysql_fetch_array($habersayfa)) {
                        $bkat = $vt->query("SELECT * FROM haber_kategori WHERE id = '".$bsayfa["kategori"]."'")->fetch(); 
                ?>
                <div class="col-lg-12 col-md-12 col-xl-6 col-sm-12 mb-5">
                    <div class="item-card overflow-hidden">
                        <div class="item-card-desc">
                            <div class="card text-center overflow-hidden mb-lg-0">
                                <a href="<?php echo $bsayfa["seo"] ?>-haber- <?php echo $bsayfa["id"]; ?>"></a>
                                <div class="card-img" style="height:485px;"> 
                                    <img src="<?php echo $bsayfa["resim"]; ?>" alt="img" class="cover-image" style="height:485px;">
                                </div>
                                <div class="item-tags">
                                    <div class="tag-option"> <?php echo $bkat["baslik"]; ?> </div>
                                </div>
                                <div class="item-card-text">
                                    <h4 class="mb-0" style="font-size:26px; height:inherit !important;"><?=$bsayfa["baslik"];?>
                                        <span>
                                            <i class="fa fa-check text-primary mr-1"></i><?=$bkat["baslik"];?>
                                        </span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="col-12 col-md-12 col-lg-12 col-xl-6">
                    <div class="row">
                        <?php
                            $habersayfa = mysql_query("SELECT * FROM haber WHERE durum = 0 LIMIT 1,4");
                            while($bsayfa = mysql_fetch_array($habersayfa)) {
                                $bkat = $vt->query("SELECT * FROM haber_kategori WHERE id = '".$bsayfa["kategori"]."'")->fetch(); 
                        ?>
                        <div class="col-sm-12 col-lg-6 col-md-6">
                            <div class="item-card overflow-hidden">
                                <div class="item-card-desc">
                                    <div class="card text-center overflow-hidden mb-5">
                                        <a href="<?php echo $bsayfa["seo"] ?>-haber- <?php echo $bsayfa["id"]; ?>"></a>
                                        <div class="card-img">
                                            <img src="<?php echo $bsayfa["resim"]; ?>" alt="img" class="cover-image">
                                        </div>
                                        <div class="item-tags">
                                            <div class="tag-option"> <?php echo $bkat["baslik"]; ?> </div>
                                        </div>
                                        <div class="item-card-text">
                                            <h4 class="mb-0" style="font-size:20px; height:inherit !important;"><?=$bsayfa["baslik"];?>
                                                <span>
                                                    <i class="fa fa-check text-primary mr-1"></i><?=$bkat["baslik"];?>
                                                </span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php } ?>
    <!-- BLOG -->   
    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'blog'")->fetch(); ?>
    <?php if ($cek["durum"]=="Aktif") { ?>
    <section id="categorie5.1-<?php echo $cek["sira"] ?>" class="sptb  pt-5 pb-6 mb-8">
        <div class="container">
            <div class="section-title">
                <h2 class="text-whi te position-relative pb-5 pt-5">
                    <?php echo $cek["modul_baslik"] ?><br>
                    <small style="font-size:13px"><?php echo $cek["modul_icerik"] ?></small>
                </h2>  
            </div>
            <div class="row">
                <?php
                    $habersayfa = mysql_query("SELECT * FROM blog WHERE durum = 0 LIMIT 1");
                    while($bsayfa = mysql_fetch_array($habersayfa)) {
                        $bkat = $vt->query("SELECT * FROM blog_kategori WHERE id = '".$bsayfa["kategori"]."'")->fetch(); 
                ?>
                <div class="col-lg-12 col-md-12 col-xl-6 col-sm-12 mb-5">
                    <div class="item-card overflow-hidden">
                        <div class="item-card-desc">
                            <div class="card text-center overflow-hidden mb-lg-0">
                                <a href="<?php echo $bsayfa["seo"] ?>-blog-<?php echo $bsayfa["id"]; ?>"></a>
                                <div class="card-img" style="height:485px;"> 
                                    <img src="<?php echo $bsayfa["resim"]; ?>" alt="img" class="cover-image" style="height:485px;">
                                </div>
                                <div class="item-tags">
                                    <div class="tag-option"> <?php echo $bkat["baslik"]; ?> </div>
                                </div>
                                <div class="item-card-text">
                                    <h4 class="mb-0" style="font-size:26px; height:inherit !important;"><?=$bsayfa["baslik"];?>
                                        <span>
                                            <i class="fa fa-check text-primary mr-1"></i><?=$bkat["baslik"];?>
                                        </span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="col-12 col-md-12 col-lg-12 col-xl-6">
                    <div class="row">
                        <?php
                            $habersayfa = mysql_query("SELECT * FROM blog WHERE durum = 0 LIMIT 1,4");
                            while($bsayfa = mysql_fetch_array($habersayfa)) {
                                $bkat = $vt->query("SELECT * FROM blog_kategori WHERE id = '".$bsayfa["kategori"]."'")->fetch(); 
                        ?>
                        <div class="col-sm-12 col-lg-6 col-md-6">
                            <div class="item-card overflow-hidden">
                                <div class="item-card-desc">
                                    <div class="card text-center overflow-hidden mb-5">
                                        <a href="<?php echo $bsayfa["seo"] ?>-blog-<?php echo $bsayfa["id"]; ?>"></a>
                                        <div class="card-img">
                                            <img src="<?php echo $bsayfa["resim"]; ?>" alt="img" class="cover-image">
                                        </div>
                                        <div class="item-tags">
                                            <div class="tag-option"> <?php echo $bkat["baslik"]; ?> </div>
                                        </div>
                                        <div class="item-card-text">
                                            <h4 class="mb-0" style="font-size:20px; height:inherit !important;"><?=$bsayfa["baslik"];?>
                                                <span>
                                                    <i class="fa fa-check text-primary mr-1"></i><?=$bkat["baslik"];?>
                                                </span>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php } ?>
    <!-- TRIGGER -->
    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'trigger-alani'")->fetch(); ?>
    <?php if ($cek["durum"]=="Aktif") { ?>
    <section id="categorie5.1-<?php echo $cek["sira"] ?>" class=" text-warning"  style="background:url('/uploads/resim/banner5.jpg') center center no-repeat; background-size:cover !important;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="car d pt-8 pb-8 mb-5">
                        <div class="ca rd-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h2 class="h1 m-0"><?php echo $cek["modul_baslik"] ?></h2> 
                                    <h6 class="mb-5"><?php echo $cek["modul_baslik"] ?></h6>
                                    <a class="btn btn-success pl-6 pr-6" href="/haldiz/index.php?do=islem&emlak=emlak_ekle&islem=sec" target="_blank">ÜCRETSİZ İLAN VER</a>
                                </div>
                            </div>              
                        </div>
                    </div>
                </div>          
            </div>
        </div>
    </section>
    <?php } ?> 
</div>
<script>
/* ANASAYFA MODÜL SIRALA */
var toSort = document.getElementById('list').children;
toSort = Array.prototype.slice.call(toSort, 0);
toSort.sort(function(a, b) {
    var aord = +a.id.split('-')[1];
    var bord = +b.id.split('-')[1];
    // two elements never have the same ID hence this is sufficient:
    return (aord > bord) ? 1 : -1;
});
var parent = document.getElementById('list');
parent.innerHTML = "";
for(var i = 0, l = toSort.length; i < l; i++) {
    parent.appendChild(toSort[i]);
}
</script>
<section>
<?php include("footer.php"); ?>    
</section>
<?php include("alt.php"); ?>
</body>
</html>