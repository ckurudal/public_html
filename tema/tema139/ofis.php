<?php

    $id = $_GET["id"];
    $hareket = $_GET["hareket"];
    $kat_emlak_tipi = $_GET["emlak-tipi"];
    $kat_danisman = $_GET["danisman"];
    $fiyat = $_GET["fiyat"];

    $subeler = mysql_query("SELECT * FROM subeler where id = '$id'");

    $sube = mysql_fetch_array($subeler);

    $ofis_sehir = $vt->query("SELECT * FROM sehir WHERE sehir_key = '".$sube["il"]."'")->fetch();

    $ofis_ilce = $vt->query("SELECT * FROM ilce WHERE ilce_key = '".$sube["ilce"]."'")->fetch();

    $ofis_mahalle = $vt->query("SELECT * FROM mahalle WHERE mahalle_id = '".$sube["mahalle"]."'")->fetch();

    $firmasahibi=$vt->query("SELECT * FROM yonetici where id = '".$sube["yetkiliuye"]."'")->fetch();
    
 
?>
<!doctype html>
<html class="no-js" lang="tr"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- set the page title -->
    <title><?=$sube["adi"];?> - <?=$ayar["site_adi"];?></title>
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

<?php include('ust.php'); ?>

<section class="sptb mb-8">

    <div class="container">

        <div class="row">
                    
            <div class="col-md-12 mb-4">                            
                
                <div class="d-flex ml-auto float-right">
                    
                    <div class="rs-select2 js-select-simple mr-1">
                       
                        <select name="item" class="select2-hidden-accessible " onchange="document.location.href=this[selectedIndex].value">
                            
                            <option value="/ofis/<?php echo $sube["id"]; ?>/<?php echo $sube["seo"]; ?>">Emlak Tipi</option>        

                            <?php 

                                $emlak_tipi = $vt->query("SELECT * FROM emlak_ilantipi WHERE durum = 0")->fetchAll();
                                foreach ($emlak_tipi as $tip) {

                            ?>

                            <option <?php if ($tip["id"] == $kat_emlak_tipi): ?> selected <?php endif; ?> value="/ofis/<?php echo $sube["id"]; ?>/<?php echo $sube["seo"]; ?>?emlak-tipi=<?php echo $tip["id"]; ?>"><?php echo $tip["ad"]; ?> </option>                            

                            <?php } ?>

                            <option value="/ofis/<?php echo $sube["id"]; ?>/<?php echo $sube["seo"]; ?>">Hepsi</option>        

                        </select>

                        <div class="select-dropdown"></div>

                    </div>
                    
                    <div class="rs-select2 js-select-simple" style="width:225px;">
                       
                        <div class="rs-select2 js-select-simple se lect--no-search select--no-search">
                            <select name="item" class="select2-hidden-accessible " onchange="document.location.href=this[selectedIndex].value">
                                <option selected="selected">Sırala Seçenekleri</option>
                                <option value="<?php echo $_SERVER["REQUEST_URI"] ?>&fiyat=DESC">Fiyata Önce Yüksek</option>
                                <option value="<?php echo $_SERVER["REQUEST_URI"] ?>&fiyat=ASC">Fiyata Önce Ucuz</option>                                               
                            </select>
                            <div class="select-dropdown"></div>
                        </div>

                    </div>

                </div>

                <h4 style="font-size:18px;" class="mb-4 mt-3"><strong><?php echo $sube["adi"]; ?> </strong>firmasına ait tüm ilanlar</h4>

            </div>

            <div class="col-md-3">                        
                
                <div class="card mb-4">

                    <div class="card-body">

                        <div class="text-center border-bottom pb-3">

                            <?php if ($sube["resim"] == ""): ?>

                            <img src="/uploads/resim/resim.png" width="100%" class="img-thumbnail">

                            <?php else: ?>

                            <img src="/<?=$sube["resim"];?>" height="100%" class="img-thumbnail" alt="<?=$ofis["adi"];?>">
                            
                            <?php endif; ?>
                            
                            <h4 class="mt-5"><?php echo $sube["adi"] ?></h4>

                            <h6 class="mb-2"><?php echo $sube["firmaunvan"]; ?></h6>

                            <p class="m-5"><i class="fa fa-map-marker fa-lg"></i> <?php echo $ofis_sehir["adi"]; ?> <?php echo $ofis_ilce["ilce_title"]; ?> <?php echo $ofis_mahalle["mahalle_title"]; ?> </p>
                            

                            <?php if ($sube["gsm"] != ""): ?>
                            <a href="tel:<?php echo $sube["gsm"]; ?>" class="h4 btn-block btn-outline-danger p-4 btn"><i class="fa fa-phone"></i> <strong><?php echo $sube["gsm"]; ?></strong></a>
                            <?php endif; ?>

                            <?php if ($sube["sabittel"] != ""): ?>
                            <a href="tel:<?php echo $sube["sabittel"]; ?>" class="h4 btn-block btn-outline-danger p-4 btn"><i class="fa fa-phone"></i> <strong><?php echo $sube["sabittel"]; ?></strong></a>
                            <?php endif; ?>

                            <?php if ($sube["sabitteldiger"] != ""): ?>
                            <a href="tel:<?php echo $sube["sabitteldiger"]; ?>" class="h4 btn-block btn-outline-danger p-4 btn"><i class="fa fa-phone"></i> <strong><?php echo $sube["sabitteldiger"]; ?></strong></a>
                            <?php endif; ?>

                            <?php if ($sube["fax"] != ""): ?>
                            <a href="tel:<?php echo $sube["fax"]; ?>" class="h4 btn-block btn-outline-danger p-4 btn"><i class="fa fa-phone"></i> <strong><?php echo $sube["fax"]; ?></strong></a>
                            <?php endif; ?>

                            <p class="mt-5"><a href="mailto:<?php echo $sube["email"]; ?>"><i class="fa fa-envelope-o"></i>  <?php echo $sube["email"] ?></a></p>


                        </div>

                    </div>

                    <div class="p-4">
                                    
                        <h4 class="mb-0"><strong>YETKİLİ DANIŞMAN</strong></h4>

                    </div>

                    <div class="card-body danisman-liste-sidebar mr-5 ml-2">

                        <?php

                            $yetkili_danisman = $vt->query("SELECT * FROM yonetici WHERE id = '".$sube["yetkiliuye"]."'")->fetch(); 

                        ?>

                        <div class="row pb-3 mb-3 border-bottom">
                            
                            <div class="col-sm-12 col-md-3 text-center">
                                <a href="#">

                                    <?php if ($yetkili_danisman["resim"] == ""): ?>

                                    <img src="/uploads/resim/resim.png" width="100%" class="img-thumbnail">

                                    <?php else: ?>

                                    <img src="/<?=$yetkili_danisman["resim"];?>" alt="<?=$yetkili_danisman["adsoyad"];?>" class="img-thumbnail" style="height:auto !important; width:100%;">
                                    
                                    <?php endif; ?>

                                    
                                </a>
                            </div>

                            <div class="col-sm-12 col-md-9">
                                
                                <h5 class="pb-0"><a class="btn-link" href="/danisman/<?=$yetkili_danisman["id"];?>/<?=$ofis_danisman["seo"];?>"><strong><?=$yetkili_danisman["adsoyad"];?></strong></a></h5>
                                
                                <p class="pb-0 mb-4"><?php echo $yetkili_danisman["unvan"]; ?></p>
                                
                                <?php if ($yetkili_danisman["gsm"] != ""): ?>
                                    <h5 class="pb-1"><a href="tel:<?=$yetkili_danisman["gsm"];?>"><?=$yetkili_danisman["gsm"];?></a></h5>
                                <?php endif ?>

                                <?php if ($yetkili_danisman["tel"] != ""): ?>
                                    <h5 class="pb-1"><a href="tel:<?=$yetkili_danisman["tel"];?>"><?=$yetkili_danisman["tel"];?></a></h5>
                                <?php endif ?>

                                <?php if ($yetkili_danisman["fax"] != ""): ?>
                                    <h5 class="pb-1"><a href="tel:<?=$yetkili_danisman["fax"];?>"><?=$yetkili_danisman["fax"];?></a></h5>
                                <?php endif ?>
                                                                       
                                <!-- <h6 class="pb-1"><a href="mailto:<?=$yetkili_danisman["email"];?>"><?=$yetkili_danisman["email"];?></a></h6> -->

                            </div>

                        </div> 

                    </div>

                    <?php
                    
                        $danismanlari_say = $vt->query("SELECT * FROM yonetici WHERE ofis = '".$sube["id"]."' AND id != '".$sube["yetkiliuye"]."'", PDO::FETCH_ASSOC);

                    ?>

                    <?php if ($danismanlari_say->rowCount()>0): ?>                        

                    <div class="p-4">
                                    
                        <h4 class="mb-0"><strong>DANIŞMANLARIMIZ</strong></h4>

                    </div>

                    <div class="card-body danisman-liste-sidebar mr-5 ml-2">

                        <?php

                            $danismanlari = $vt->query("SELECT * FROM yonetici WHERE ofis = '".$sube["id"]."' AND id != '".$sube["yetkiliuye"]."'")->fetchAll();                            
                            foreach ($danismanlari as $ofis_danisman) {

                        ?>

                        <div class="row pb-3 mb-3 border-bottom">
                            
                            <div class="col-sm-12 col-md-3 text-center">
                                <a href="#">

                                    <?php if ($ofis_danisman["resim"] == ""): ?>

                                    <img src="/uploads/resim/resim.png" width="100%" class="img-thumbnail">

                                    <?php else: ?>

                                    <img src="/<?=$ofis_danisman["resim"];?>" alt="<?=$ofis_danisman["adsoyad"];?>" class="img-thumbnail" style="height:auto !important;">
                                    
                                    <?php endif; ?>

                                    
                                </a>
                            </div>

                            <div class="col-sm-12 col-md-9">
                                
                                <h5 class="pb-0"><a class="btn-link" href="/danisman/<?=$ofis_danisman["id"];?>/<?=$ofis_danisman["seo"];?>"><strong><?=$ofis_danisman["adsoyad"];?></strong></a></h5>
                                
                                <p class="pb-0 mb-4"><?php echo $ofis_danisman["unvan"]; ?></p>
                                
                                <?php if ($ofis_danisman["gsm"] != ""): ?>
                                    <h5 class="pb-1"><a href="tel:<?=$ofis_danisman["gsm"];?>"><?=$ofis_danisman["gsm"];?></a></h5>
                                <?php endif ?>

                                <?php if ($ofis_danisman["tel"] != ""): ?>
                                    <h5 class="pb-1"><a href="tel:<?=$ofis_danisman["tel"];?>"><?=$ofis_danisman["tel"];?></a></h5>
                                <?php endif ?>

                                <?php if ($ofis_danisman["fax"] != ""): ?>
                                    <h5 class="pb-1"><a href="tel:<?=$ofis_danisman["fax"];?>"><?=$ofis_danisman["fax"];?></a></h5>
                                <?php endif ?>
                                                                       
                                <!-- <h6 class="pb-1"><a href="mailto:<?=$ofis_danisman["email"];?>"><?=$ofis_danisman["email"];?></a></h6> -->

                            </div>

                        </div>

                        <?php } ?>

                    </div>

                    <?php endif ?>
                    

                </div>

                <?php

                     if (isset($_POST["ofismesajgonder"])) {

                        $kimden = $_POST["kimden"];
                        $kime = $_POST["kime"];
                        $tel = $_POST["tel"];
                        $email = $_POST["email"];
                        $mesaj = $_POST["mesaj"];
                        $basvuru = $_POST["basvuru"];
                        $ozgecmis = $_POST["ozgecmis"];
                        $tarih = date('d/m/Y');

                        if ($_SESSION["uyelogin"]) {
                            if (is_numeric($kimden)) {
                                echo '
                                    <div class="alert alert-danger">
                                        <i class="fa fa-warning fa-lg"></i> Lütfen isim giriniz.
                                    </div>
                                ';
                            } else if (empty($tel)) {
                                echo '
                                    <div class="alert alert-danger">
                                        <i class="fa fa-warning fa-lg"></i> Lütfen telefon giriniz.
                                    </div>
                                ';
                            } else if (!is_numeric($tel)) {
                                echo '
                                    <div class="alert alert-danger">
                                        <i class="fa fa-warning fa-lg"></i> Geçerli bir telefon giriniz.
                                    </div>
                                ';                                  
                            } else if (empty($email)) {
                                echo '
                                    <div class="alert alert-danger">
                                        <i class="fa fa-warning fa-lg"></i> Lütfen e-posta giriniz.
                                    </div>
                                ';
                            } else {
                                $gonder = mysql_query("INSERT INTO emlak_ofisgelenmesaj (kimden, kime, email, tel, mesaj, tarih) values ('".$uye["id"]."','".$firmasahibi["id"]."','$email','$tel','$mesaj','$tarih')");
                                echo '
                                    <div class="alert alert-success">
                                        <i class="fa fa-check fa-lg"></i> Sayın '.$uye["adsoyad"].', Mesajınız başarılı bir şekilde gönderilmiştir.
                                    </div>
                                ';
                            }
                        } else {
                            if (is_numeric($kimden)) {
                                echo '
                                    <div class="alert alert-danger">
                                        <i class="fa fa-warning fa-lg"></i> Lütfen isim giriniz.
                                    </div>
                                ';
                            } else if (empty($tel)) {
                                echo '
                                    <div class="alert alert-danger">
                                        <i class="fa fa-warning fa-lg"></i> Lütfen telefon giriniz.
                                    </div>
                                ';
                            } else if (empty($email)) {
                                echo '
                                    <div class="alert alert-danger">
                                        <i class="fa fa-warning fa-lg"></i> Lütfen e-posta giriniz.
                                    </div>
                                ';
                            } else {
                                $gonder = mysql_query("INSERT INTO emlak_ofisgelenmesaj (kimden, kime, email, tel, ozgecmis, mesaj, basvuru, tarih) values ('$kimden','".$firmasahibi["id"]."','$email','$tel','$ozgecmis','$mesaj','$basvuru','$tarih')");
                                echo '
                                    <div class="alert alert-success">
                                        <i class="fa fa-check fa-lg"></i> Sayın '.$kimden.', Mesajınız başarılı bir şekilde gönderilmiştir.
                                    </div>
                                ';
                            }
                        }
                     }
                ?>
                
                <div class="card d-none">
                    <div class="card-header">
                        <i class="fa fa-envelope fa-lg"></i>
                        <?php if ($_SESSION["uyelogin"]) { ?>
                            Ofise Mesaj Gönder
                        <?php } else { ?>
                            İletişim Formu
                        <?php } ?>                                          
                    </div>
                    <div class="card-body">
                        <form class="form" action="" method="POST">
                            <div class="form-group">
                                <label>Ad Soyad:</label>                                        
                                <input type="text" class="form-control" name="kimden" placeholder="">                                        
                            </div>
                            <div class="form-group">
                                <div class="control-label">
                                    <label>Telefon:</label>
                                    <input type="text" class="form-control" name="tel" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>E-Posta:</label>
                                <input type="text" class="form-control" name="email" placeholder="">                                        
                            </div>
                            <?php if (!$_SESSION["uyelogin"]) { ?>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3 control-label">
                                    </div>
                                    <div class="col-md-9">
                                        <label for="basvuru" class="form-control">
                                            <input id="basvuru" type="checkbox" value="1" name="basvuru">
                                            Danışman Olmak İstiyorum
                                        </label>
                                    </div>
                                </div>                                  
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3 control-label">
                                        <label>Özgeçmiş:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="ozgecmis" placeholder="" rows="5"></textarea>
                                        <span style="font-size: 11px;"> <i class="fa fa-warning"></i> Danışmanlık istemiyorsanız boş bırakabilirsiniz.</span>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3 control-label">
                                        <label>Mesajınız:</label>
                                    </div>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="mesaj" placeholder="" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="submit" name="ofismesajgonder" class="btn btn-danger"><i class="fa fa-envelope fa-lg"></i> <strong> Mesajı Gönder</strong></button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            
            <div class="col-md-9">                

                <div class="row">
                <?php  

                    $yoneticiler = $vt->query("SELECT * FROM yonetici WHERE ofis = '".$sube["id"]."'")->fetchAll();

                    foreach ($yoneticiler as $y) {
                                                                                    
                    if ($kat_emlak_tipi) {

                        $ilanliste = $vt->query("SELECT * FROM emlak_ilan where yonetici_id = '".$y["id"]."' and durum = 0 AND onay = 1 AND ilantipi = '".$kat_emlak_tipi."' ORDER BY fiyat $fiyat");

                    } else {

                        $ilanliste = $vt->query("SELECT * FROM emlak_ilan where yonetici_id = '".$y["id"]."' and durum = 0 AND onay = 1 ORDER BY fiyat $fiyat");

                    }

                    while ($liste = $ilanliste->fetch(PDO::FETCH_ASSOC)) {

                        $iller = mysql_query("SELECT * FROM sehir where sehir_key = '".$liste["il"]."'");
                        $il = mysql_fetch_array($iller);

                        $ilceler = mysql_query("SELECT * FROM ilce where ilce_key = '".$liste["ilce"]."'");
                        $ilce = mysql_fetch_array($ilceler);

                        $mahalle_ver = mysql_query("SELECT * FROM mahalle where mahalle_id = '".$liste["mahalle"]."'");
                        $mahalle = mysql_fetch_array($mahalle_ver);

                        $ilantipi = mysql_query("SELECT * FROM emlak_ilantipi where id = '".$liste["ilantipi"]."' && durum != 1");
                        $it = mysql_fetch_array($ilantipi);

                        $ilansekli = mysql_query("SELECT * FROM emlak_ilansekli where id = '".$liste["ilansekli"]."' && durum != 1");
                        $sekil = mysql_fetch_array($ilansekli);

                        $kategori = mysql_query("SELECT * FROM emlak_kategori where kat_id = '".$liste["katid"]."' && kat_durum = 1");
                        $kat = mysql_fetch_array($kategori);
                        
                        $dizi = explode (" ",$it['ad']);

                        $kategoriver = mysql_query("SELECT * FROM emlak_kategori where kat_id = '".$liste["katid"]."'");
                        $kategori = mysql_fetch_array($kategoriver);
                        
                        $resver = mysql_query("SELECT * FROM emlak_resim where emlakno = '".$liste["emlakno"]."' && kapak = '1'");
                        $resl = mysql_fetch_array($resver);

                        ?> 
                        <div class="col-lg-4 col-md-12 col-xl-4">
                            
                            <div class="card mb-5 hover-box"> 
                                <div class="card-body p-2">

                                    <a target="_blank" href="/<?=$liste["seo"];?>-ilan-<?=$liste["id"];?>">
										<?php if($resl["resimad"] != ""): ?>
										<img class=" mr-4" src="<?=RESIM;?>/<?php echo $resl["resimad"]; ?>" height="250" width="100%" alt="img">
										<?php else: ?>
										<img class=" mr-4" src="/uploads/resim/resim.png" height="250" width="100%" alt="img">
										<?php endif; ?>
                                        
                                    </a>

                                    <ul class="p-0 pl-2 pr-2">
                                        <li class="item">
                                            
                                            <div style="font-size:18px;" class="mb-0 mt-3 font-weight-bold"><?php echo $liste["fiyat"]; ?> <?php echo $liste["fiyatkur"]; ?></div>

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
                                                    
                                                    <h3 class='font-weight-bold'><a class='p-3 pl-5 pr-5 h5 btn ' href='tel:<?php echo $y["tel"]; ?>'><i class='fa fa-phone fa-lg text-danger mr-3'></i> <?php echo $y["tel"]; ?></a></h3>
                                                    
                                                </div>
                                            " class="btn btn-outline-dark btn-block" style="cursor:pointer;" data-original-title="<?php echo $y["adsoyad"]; ?>">                                                
                                                <strong>Telefonu Göster</strong>
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <a href="tel:<?php echo $y["tel"]; ?>" class="btn btn-outline-danger btn-block"><strong>Ara</strong></a>                                            
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>  

                    <?php } ?>
                <?php } ?> 
                </div> 

            </div>

        </div> 

    </div>

</section>




<section>
<?php include("footer.php"); ?>    
</section>
<?php include("alt.php"); ?>
</body>
<!-- Mirrored from www.spruko.com/demo/reallist/htm/Reallist-LTR/Html/ by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 05 Apr 2020 15:27:18 GMT -->
</html>