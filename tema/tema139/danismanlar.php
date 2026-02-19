<?php 
    $id = $_GET["id"];

    $arama = isset($_GET["arama"]) ? $_GET["arama"] : "";
    $arama = strip_tags($arama);
    $ilver = isset($_GET["ilver"]) ? $_GET["ilver"] : "";
    $iller = $vt->query("select * from sehir where sehir_key = '".$ilver."'")->fetch();

    $stmt_d = $vt->prepare("SELECT * FROM yonetici where id = ?");
    $stmt_d->execute([$id]);
    $d = $stmt_d->fetch();

    $stmt_emlakofisi = $vt->prepare("SELECT * FROM subeler where id = ?");
    $stmt_emlakofisi->execute([$d["ofis"]]);
    $emlakofisi = $stmt_emlakofisi->fetch();
    $stmt_kurumsalofisi = $vt->prepare("SELECT * FROM subeler where yetkiliuye = ?");
    $stmt_kurumsalofisi->execute([$d["id"]]);
    $kurumsalemlakofisi = $stmt_kurumsalofisi->fetch();
    
    $danismanlarQuery = "SELECT * FROM yonetici where durum = 0 AND yetki != 0";
    $danismanlarBind = array();

    if ($arama != "") {
        $danismanlarQuery .= " AND adsoyad LIKE :arama";
        $danismanlarBind[":arama"] = "%".$arama."%";
    }

    if ($ilver != "") {
        $danismanlarQuery .= " AND il = :il";
        $danismanlarBind[":il"] = $ilver;
    }

    $stmt_dan = $vt->prepare("SELECT * FROM yonetici where id = ?");
    $stmt_dan->execute([$id]);
    $dan = $stmt_dan->fetch();

?>
<!doctype html>
<html class="no-js" lang="tr"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- set the page title -->
    <title>Gayrimenkul Danışmanları - <?=$ayar["site_adi"];?></title>
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
<div class="container-fluid" style="background: url('<?=TEMA_URL?>/assets/images/photos/slider-bg.jpg');padding: 70px 0 50px 0;margin: -20px 0 0px 0;border-bottom: 1px solid #ddd;background-size: cover;background-repeat: no-repeat;background-position: center center;color: #fff;">
    <div class="container">
        <h1>Profesyoneller</h1> 
    </div>
</div>
<div class="border-bottom bg-white pt-6">
    <div class="container">
        <form class="form" method="get">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-2 mb-4">
                        <h4 class="pt-4"><i class="fa fa-search"></i> DANIŞMAN ARA</h4>
                    </div>
                    <div class="col-md-2">
                        <div class="rs-select2 js-select-simple se lect--no-search">
                            <select name="ilver" id="ilSidebar" class="form-control">
                                <?php if ($ilver != ""): ?>
                                    <option value="<?php echo $ilver; ?>"> <?php echo $iller["adi"]; ?> </option>
                                <?php endif; ?>
                                <option value=""> İl Seçiniz </option> 
                                <?php 
                                    $stmt_iller = $vt->query("select * from sehir order by adi asc");
                                    while($il=$stmt_iller->fetch()) {
                                ?>
                                <option value="<?=$il['sehir_key'];?>"> <?=$il['adi'];?> </option>
                                <?php } ?>
                            </select>
                            <div class="select-dropdown"></div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <?php if ($arama != ""): ?>
                            <input class="input--style-4" type="text" name="arama" value="<?php echo $arama; ?>" placeholder="Danışman adı ara...">
                        <?php else: ?>
                            <input class="input--style-4" type="text" name="arama" placeholder="Danışman ara">                                    
                        <?php endif; ?>
                    </div>
                    <div class="col-md-1 mb-4">
                        <button type="submit" class="btn btn-success btn-block h-100"><strong>ARA</strong></button>
                    </div>
                    <div class="col-md-1">
                        <a href="/ofisler/" class="btn btn-link text-danger btn-block p-3"><strong><i class="fa fa-close"></i> Temizle</strong></a>
                    </div>
                </div>
            </div>
        </form> 
    </div>
</div>
<section class="mt-5 pt-7 pb-8">
    <div class="container">
        <div class="row">
            <?php 
                $danismanlar = $vt->prepare($danismanlarQuery);
                $danismanlar->execute($danismanlarBind);
                while($dan = $danismanlar->fetch(PDO::FETCH_ASSOC)) {

                    // $subeler removed (invalid query with no condition)
            ?>
            <div class="col-lg-3 col-md-4 mb-5">
                <div class="card">
                    <div class="card-body  item-user text-center pt-7">
                        <div class="profile-pic mb-0"> 
                            <?php 
                                if ($dan["resim"] == "") {
                            ?>
                            <img src="/uploads/resim/uyeresimyok.png" height="150" class="brround avatar-xxl">
                            <?php } else { ?>
                            <img src="/<?=$dan["resim"];?>" height="150" class="brround avatar-xxl"> 
                            <?php } ?>
                            
                            <div class="">
                                <a href="/danisman/<?=$dan["id"];?>" class="text-dark">
                                    <h4 class="mt-3 mb-1 font-weight-semibold"><?=$dan["adsoyad"];?></h4>
                                </a>
                                
                                <?php if ($dan["unvan"] == ""): ?>
                                
                                    <p class="mb-0">Yetkili Danışman</p>
                                    
                                <?php else: ?>

                                    <p class="mb-0"><?=$dan["unvan"];?></p>                                    

                                <?php endif; ?>

                                <span style="display: block; height: 36px;" class="text-muted"><?=$dan["sube"];?></span>
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-body item-user">
                        <div> 
                                  
                            <h6> 
                                <a class="btn btn-outline-danger btn-block" href="tel:<?=$dan["tel"];?>" class="text-body">
                                <i class="fa fa-phone"></i> <?=$dan["tel"];?><small><?php if ($dan["tel"] == "") { ?> Girilmemiş <?php } ?></small></a>
                            </h6>   

                            <h6> 
                                <a class="btn btn-outline-danger btn-block" href="tel:<?=$dan["gsm"];?>" class="text-body">
                                    <i class="fa fa-phone"></i> <small><?=$dan["gsm"];?> <?php if ($dan["gsm"] == "") { ?> Girilmemiş <?php } ?></small> 
                                </a>
                            </h6>

                            <?php if ($dan["email"] != "") { ?> 
                            <h6>                                
                                <a class="btn btn-block mt-4" href="mailto:<?=$dan["email"];?>" class="text-body"> 
                                    <i class="fa fa-envelope"></i><small> <?=$dan["email"];?></small>
                                </a>
                            </h6>
                            <?php } ?>

                            <?php
                                $dan_ilan_say = $vt->query("SELECT * FROM emlak_ilan WHERE yonetici_id = '".$dan["id"]."' AND durum = 0 AND onay = 1");
                            ?>

                            <div class="text-center pt-4 mb-3">
                                <a class="btn-block" href="/danisman/<?=$dan["id"];?>"><strong>Tüm İlanları (<?php echo $dan_ilan_say->rowCount(); ?>)</strong></a>
                            </div>

                        </div>
                    </div>
                </div>
             </div>
            <?php } ?>
        </div>
    </div>
</section>





<section>
<?php include("footer.php"); ?>    
</section>
<?php include("alt.php"); ?>
</body>
</html>