<?php    
    $ofissay = $vt->query("SELECT COUNT(*) FROM subeler where id")->fetch();
    $ofisbul = $_GET["ofisbul"];
    $arama = $_GET["arama"];
    $ilver = $_GET["ilver"];
    $iller = $vt->query("select * from sehir where sehir_key = '".$ilver."'")->fetch();
?>
<!doctype html>
<html class="no-js" lang="tr"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- set the page title -->
    <title>Emlak Ofisleri - <?=$ayar["site_adi"];?></title>
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
        <h1>Emlak Budur - Ofisleri</h1> 
    </div>
</div>
<div class="border-bottom bg-white pt-6">
    <div class="container">
        <form class="form" method="get">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-2 mb-4">
                        <h4 class="pt-4"><i class="fa fa-search"></i> EMLAK OFİSİ ARA</h4>
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
                            <input class="input--style-4" type="text" name="arama" value="<?php echo $arama; ?>" placeholder="Emlak ofisi arama">
                        <?php else: ?>
                            <input class="input--style-4" type="text" name="arama" placeholder="Emlak ofisi arama">                                    
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
        <div class="col-md-12">
            <div class="row">
				 <?php
                    if ($arama != "" || $ilver != "") {
                        $ofisler = $vt->query("SELECT * FROM subeler where adi like '%".$arama."%' AND il like '%".$ilver."%' AND durum = 0");
                    } else {
                        $ofisler = $vt->query("SELECT * FROM subeler where id AND durum = 0");
                    }
                    if ($ofisler->rowCount() == 0) {
				?>
                <div class="col-md-12">
					<?php echo hata("Aradığınız kriterlere uygun emlak ofisi bulunamadı."); ?>
				</div>
				<?php
                    }
                    while($ofis = $ofisler->fetch()) {
                        $ilansayisi = $vt->query("SELECT COUNT(*) FROM emlak_ilan where yonetici_id = '".$ofis["id"]."'");              
                        $sayi = $ilansayisi->fetch();
                        $ilcever = $vt->query("SELECT * FROM ilce where ilce_key = '".$ofis["ilce"]."'")->fetch();
                        $ilver = $vt->query("SELECT * FROM sehir where sehir_key = '".$ofis["il"]."'")->fetch();
                ?>	
                <div class="col-lg-3 col-md-4 mb-5">
                    <div class="card">
                        <div class="card-body  item-user">
                            <div class="profile-pic mb-0 text-center pt-5"> 
                                <a href="/ofis/<?=$ofis["id"];?>/<?=$ofis["seo"];?>" class="text-dark">
                                <?php if ($ofis["resim"] == ""): ?>
                                <img src="/uploads/resim/resim.png" height="145" class="brround m-auto">
                                <?php else: ?>
                                <img src="<?=$ofis["resim"];?>" height="350" class="brround avatar-xxl" alt="<?=$ofis["adi"];?>">
                                <?php endif; ?>
                                 </a>
                                <div class="mt-7">
                                    <a href="/ofis/<?=$ofis["id"];?>/<?=$ofis["seo"];?>" class="text-dark">
                                        <h4 class="mt-3 mb-1 font-weight-semibold"><?=$ofis["adi"]?></h4>
                                    </a>
                                    <p class="mb-0" style="height: 36px;">
                                        <?php if (is_numeric($ofis["il"])) { ?>
                                        <?=$ilver["adi"];?> / 
                                        <?php } ?>
                                        <?php if (is_numeric($ofis["ilce"])) { ?>
                                        <?=$ilcever["ilce_title"];?>
                                        <?php } ?>                                                                
                                    </p>
                                    <span class="text-muted"><?=$dan["sube"];?></span>
                                    <h6 class="mt-2 mb-0"><a href="/ofis/<?=$ofis["id"];?>/<?=$ofis["seo"];?>" class="btn btn-sm"><i class="fa fa-arrow-right"></i> Ofis Detayları</a></h6> 
                                </div>
                            </div>
                        </div>
                        <div class="card-body item-user"> 
                            <div> 
                                <?php if ($dan["email"] != "") { ?> 
                                <h6>                                
                                    <a class="btn btn-danger btn-block btn-lg" href="mailto:<?=$ofis["email"];?>" class="text-body"> 
                                        <i class="fa fa-envelope"></i><small><?=$ofis["email"];?></small>
                                    </a>
                                </h6>
                                <?php } ?>  
                               <div class="row">
                                   <div class="col-md-8">
                                        <h6> 
                                            <a class="btn btn-light btn-block" href="tel:<?=$ofis["sabittel"];?>" class="text-body">
                                            <i class="fa fa-phone"></i> <?=$ofis["sabittel"];?><small><?php if ($ofis["sabittel"] == "") { ?> Girilmemiş <?php } ?></small></a>
                                        </h6>
                                   </div>
                                   <div class="col-md-4">
                                       <h6> 
                                            <a class="btn btn-light btn-block" href="tel:<?=$ofis["sabittel"];?>" class="text-body">
                                                Ara
                                            </a>
                                        </h6>
                                   </div>
                               </div>
                            </div>
                        </div>
                    </div>
                 </div>
                <?php } ?>
				<?php if (!$_GET["ilver"]): ?> 
                <div class="col-lg-3 col-md-4 mb-5">
                    <div class="card bg-primary" style="height:423px;">
						<?php if (!$_SESSION["uyelogin"]): ?>
                        <div class="card-body">
								
							</div>
                        </div> 
						<?php else: ?>
						<div class="card-body">
							<div class="text-center text-white mt-8">
									
							</div>
                        </div>
						<?php endif; ?>
                    </div>
                 </div>
				 <?php endif; ?>				  
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