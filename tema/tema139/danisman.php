<?php 

    $id = $_GET["id"];

    $fiyat = $_GET["fiyat"];

     $kat_emlak_tipi = $_GET["emlak-tipi"];

    $stmt_d = $vt->prepare("SELECT * FROM yonetici where id = ?");
    $stmt_d->execute([$id]); $d = $stmt_d->fetch();

    $stmt_emlakofisi = $vt->prepare("SELECT * FROM subeler where id = ?");
    $stmt_emlakofisi->execute([$d["ofis"]]); $emlakofisi = $stmt_emlakofisi->fetch();
    $stmt_kurumsalofisi = $vt->prepare("SELECT * FROM subeler where yetkiliuye = ?");
    $stmt_kurumsalofisi->execute([$d["id"]]); $kurumsalemlakofisi = $stmt_kurumsalofisi->fetch();

    $stmt_dan = $vt->prepare("SELECT * FROM yonetici where id = ?");
    $stmt_dan->execute([$id]); $dan = $stmt_dan->fetch();

    $uye_login = $vt->query("SELECT * FROM yonetici WHERE id = '".$_SESSION["id"]."'")->fetch();

    $danilan_say = $vt->query("SELECT * FROM emlak_ilan WHERE yonetici_id = '$id' AND durum = 0 AND onay = 1");
    $ilansay = $danilan_say->rowCount();

    $danisman_bilgi = $vt->query("SELECT * FROM yonetici WHERE id = '$id'");
    $danisman_veri = $danisman_bilgi->fetch(PDO::FETCH_OBJ);

    $stmt_ilver = $vt->prepare("SELECT * FROM sehir where sehir_key = ?");
    $stmt_ilver->execute([$dan["il"]]); $ilver = $stmt_ilver->fetch();

    $stmt_ilce2 = $vt->prepare("SELECT * FROM ilce where ilce_key = ?");
    $stmt_ilce2->execute([$dan["ilce"]]); $ilce = $stmt_ilce2->fetch();

    $stmt_mah2 = $vt->prepare("SELECT * FROM mahalle where mahalle_id = ?");
    $stmt_mah2->execute([$dan["mahalle"]]); $mahalle = $stmt_mah2->fetch();
	
?>
<!doctype html>
<html class="no-js" lang="tr"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- set the page title -->
    <title><?=$d["adsoyad"];?> - <?=$ayar["site_adi"];?></title>
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
                            
                            <option value="danisman/<?php echo $dan["id"] ?>/">Emlak Tipi</option>        

                            <?php 

                                $emlak_tipi = $vt->query("SELECT * FROM emlak_ilantipi WHERE durum = 0")->fetchAll();
                                foreach ($emlak_tipi as $tip) {

                            ?>

                            <option <?php if ($tip["id"] == $kat_emlak_tipi): ?> selected <?php endif; ?> value="danisman/<?php echo $dan["id"] ?>/?emlak-tipi=<?php echo $tip["id"]; ?>"><?php echo $tip["ad"]; ?> </option>                            

                            <?php } ?>

                            <option value="danisman/<?php echo $dan["id"] ?>/">Hepsi</option>        

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

                <h4 style="font-size:18px;" class="mb-4 mt-3"><strong><?php echo $dan["adsoyad"]; ?> </strong> için <?php echo $ilansay; ?> adet ilan bulundu</h4>

            </div>

            <div class="col-md-3">
                <div class="card text-center">
                    <?php
                        $stmt_danliste = $vt->prepare("SELECT * FROM yonetici where id = ?");
                        $stmt_danliste->execute([$id]);
                        while($dan = $stmt_danliste->fetch()) {

                            // $subeler removed (invalid query with no condition)
                    ?>
                    <div class="card-body  item-user">
                        <div class="profile-pic mb-0">

                            <?php if ($dan["resim"] == "") {?>
                            <img src="/uploads/resim/uyeresimyok.png" width="150" class="brround avatar-xxl">
                            <?php } else { ?>
                            <img src="/<?=$dan["resim"];?>" width="150" class=""brround avatar-xxl">
                            <?php } ?>

                            <div class="">

                                <h4 class="mt-3 mb-1"><?=$dan["adsoyad"];?></h4>
                                <h6 class="font-weight-light"><?=$dan["unvan"];?></h6>
                                <span class="text-muted"><?=$dan["sube"];?></span>

                            </div>

                        </div>
                    </div>
                    <div class="card-body item-user">
                        <div class="border-bottom">
                            <?php if ($dan["tel"] != "") { ?>
                            <h6>
                                <a class="h4 btn-block btn-outline-danger p-4 btn" href="tel:<?=$dan["tel"];?>" class="text-body">
                                    <i class="fa fa-phone"></i> <strong><?=$dan["tel"];?></strong>
                                </a>
                            </h6>
                            <?php } ?>
                            <?php if ($dan["gsm"] != "") { ?>
                            <h6>
                                <a class="h4 btn-block btn-outline-danger p-4 btn" href="tel:<?=$dan["gsm"];?>" class="text-body">
                                    <i class="fa fa-phone"></i> <strong><?=$dan["gsm"];?></strong>
                                </a>
                            </h6>
                            <?php } ?>
                            <?php if ($dan["fax"] != "") { ?>
                            <h6>
                                <a class="h4 btn-block btn-outline-danger p-4 btn" href="tel:<?=$dan["fax"];?>" class="text-body">
                                    <i class="fa fa-phone"></i> <strong><?=$dan["fax"];?></strong>
                                </a>
                            </h6>
                            <?php } ?>
                            <?php if ($dan["email"] != "") { ?>
                            <p class="mt-5">
                                <a href="mailto:<?=$dan["email"];?>" class="text-body">
                                    <i class="fa fa-envelope-o"></i> <?=$dan["email"];?>
                                </a>
                            </p>
                            <?php } ?>
                        </div>
                        <div class=" item-user-icons mt-4">
                            <?php


                                $uyesosyal = $vt -> query("SELECT * FROM yonetici_sosyal WHERE yoneticiid = '".$id."'");
                                while ($uyesos = $uyesosyal -> fetch(PDO::FETCH_OBJ)) {

                                    $sosyalmedya = $vt -> query("SELECT * FROM ayar_sosyal WHERE durum = 0 && id = '".$uyesos->sosyalid."'");
                                    while ($sos = $sosyalmedya -> fetch(PDO::FETCH_OBJ)) {

                            ?>
                            <?php if (!empty($uyesos->sosyallink)) { ?>
                            <a href="<?php echo $uyesos->sosyallink; ?>" target="_blank" class="btn btn-primary">
                                <i class="<?php echo $sos->icon; ?>"></i>
                            </a>
                            <?php } ?>
                            <?php } ?>
                        <?php } ?>
                        </div>
                    </div>
                    <?php } ?>

                    <?php if ($d["yetki"] == 2 || $d["yetki"] == 3) { ?>
                    <div class="row">
                        <?php if ($d["yetki"] == 3) { ?>
                        <?php if ($emlakofisi): ?>
                        <div class="col-md-12">
                            <div class="text-center mb-3">
                                <?php if ($emlakofisi["resim"] == ""): ?>
                                <img src="/uploads/resim.png" class="img-thumbnail">
                                <?php else: ?>
                                <img src="/<?=$emlakofisi["resim"];?>" class="img-thumbnail">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h5 class="text-center"> <strong><?=$emlakofisi["adi"];?></strong> </h5>
                            <h6 class="text-center"> <?=$emlakofisi["firmaunvan"];?> </h6>
                            <a href="/ofis/<?=$emlakofisi["id"];?>/<?=$emlakofisi["seo"];?>" class="btn btn-block h6 mb-5"> Ofis Detayları</a>
                        </div>
                        <?php endif; ?>
                        <?php } ?>
                        <?php if ($d["yetki"] == 2) { ?>
                        <div class="col-md-12">
                            <div class="text-center mb-3">
                                <?php if ($kurumsalemlakofisi["resim"] == ""): ?>
                                <img src="/uploads/resim/resim.png" class="img-thumbnail">
                                <?php else: ?>
                                <img src="/<?=$kurumsalemlakofisi["resim"];?>" class="img-thumbnail">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h5 class="text-center"> <strong><?=$kurumsalemlakofisi["adi"];?></strong> </h5>
                            <p class="text-center"> <?=$kurumsalemlakofisi["firmaunvan"];?> </p>
                            <a href="/ofis/<?=$kurumsalemlakofisi["id"];?>/<?=$kurumsalemlakofisi["seo"];?>" class="btn btn-block h6 mb-5"> Ofis Detayları</a>
                        </div>
                        <?php } ?>
                    </div>
                    <?php } ?>

                </div>

            </div>

            <div class="col-md-9">

                <div class="row">
                    
                    <div class="col-lg-12">
					<?php if ($ilansay == 0) { ?> <h6 class="alert alert-dark text-center p-8"> <i class="fa fa-close fa-2x"></i> <br><br> <small> Henüz ilan eklenmemiştir. </small> </h6> <?php } ?>
					</div>

                    <?php  
                                                                                
                        if ($kat_emlak_tipi) {
                            $stmt_ilanliste = $vt->prepare("SELECT * FROM emlak_ilan where yonetici_id = ? and durum = 0 AND onay = 1 AND ilantipi = ? ORDER BY fiyat $fiyat");
                            $stmt_ilanliste->execute([$id, $kat_emlak_tipi]);
                        } else {
                            $stmt_ilanliste = $vt->prepare("SELECT * FROM emlak_ilan where yonetici_id = ? and durum = 0 AND onay = 1 ORDER BY fiyat $fiyat");
                            $stmt_ilanliste->execute([$id]);
                        }

                        while ($liste = $stmt_ilanliste->fetch()) {

                            $stmt_il = $vt->prepare("SELECT * FROM sehir where sehir_key = ?");
                            $stmt_il->execute([$liste["il"]]); $il = $stmt_il->fetch();

                            $stmt_ilce = $vt->prepare("SELECT * FROM ilce where ilce_key = ?");
                            $stmt_ilce->execute([$liste["ilce"]]); $ilce = $stmt_ilce->fetch();

                            $stmt_mah = $vt->prepare("SELECT * FROM mahalle where mahalle_id = ?");
                            $stmt_mah->execute([$liste["mahalle"]]); $mahalle = $stmt_mah->fetch();

                            $stmt_ilantipi = $vt->prepare("SELECT * FROM emlak_ilantipi where id = ? AND durum != 1");
                            $stmt_ilantipi->execute([$liste["ilantipi"]]); $it = $stmt_ilantipi->fetch();

                            $stmt_sekli = $vt->prepare("SELECT * FROM emlak_ilansekli where id = ? AND durum != 1");
                            $stmt_sekli->execute([$liste["ilansekli"]]); $sekil = $stmt_sekli->fetch();

                            $stmt_kat = $vt->prepare("SELECT * FROM emlak_kategori where kat_id = ? AND kat_durum = 1");
                            $stmt_kat->execute([$liste["katid"]]); $kat = $stmt_kat->fetch();
                            
                            $dizi = explode (" ",$it['ad']);

                            $stmt_kategoriver = $vt->prepare("SELECT * FROM emlak_kategori where kat_id = ?");
                            $stmt_kategoriver->execute([$liste["katid"]]); $kategori = $stmt_kategoriver->fetch();
                            
                            $stmt_resim = $vt->prepare("SELECT * FROM emlak_resim where emlakno = ? AND kapak = '1'");
                            $stmt_resim->execute([$liste["emlakno"]]); $resl = $stmt_resim->fetch();

                    ?>

                    <div class="col-lg-4 col-md-12 col-xl-4">
                            
                            <div class="card mb-5 hover-box"> 
                                <div class="card-body p-2">

                                    <a target="_blank" href="/<?=$liste["seo"];?>-ilan-<?=$liste["id"];?>">
										<?php if($resl["resimad"] != ""): ?>
										<img class=" mr-4" src="<?=RESIM;?>/<?php echo $resl["resimad"]; ?>" height="250" width="100%" alt="img">
										<?php else: ?>
										<img src="/uploads/resim/resim.png" height="250" width="100%" alt="img">
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
                                                    
                                                    <h3 class='font-weight-bold'><a class='p-3 pl-5 pr-5 h5 btn t' href='tel:<?php echo $d["tel"]; ?>'><i class='fa fa-phone fa-lg text-danger mr-3'></i> <?php echo $d["tel"]; ?></a></h3>
                                                    
                                                </div>
                                            " class="btn btn-outline-dark btn-block" style="cursor:pointer;" data-original-title="<?php echo $d["adsoyad"]; ?>">                                                
                                                <strong>Telefonu Göster</strong>
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <a href="tel:<?php echo $d["tel"]; ?>" class="btn btn-outline-danger btn-block"><strong>Ara </strong></a>                                            
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

<section>
<?php include("footer.php"); ?>    
</section>
<?php include("alt.php"); ?>
</body>
<!-- Mirrored from www.spruko.com/demo/reallist/htm/Reallist-LTR/Html/ by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 05 Apr 2020 15:27:18 GMT -->
</html>