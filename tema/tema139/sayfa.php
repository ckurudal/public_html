<?php

    $id = $_GET["id"];
    
    $stmt_sayfa = $vt->prepare("SELECT * FROM sayfa where id = ?");
    $stmt_sayfa->execute([$id]);
    $sayfa = $stmt_sayfa->fetch();

    $stmt_sayfakat = $vt->prepare("SELECT * FROM sayfa_kategori where id = ?");
    $stmt_sayfakat->execute([$sayfa["kategori"]]);
    $kat = $stmt_sayfakat->fetch();

?>
<!doctype html>
<html class="no-js" lang="tr"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- set the page title -->
    <title><?=$sayfa["baslik"];?></title>
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

           
            <div class="col-xl-9 col-lg-9 col-md-12">
                <div class="card">
                    <div class="card-body p-6">

                             <h1 class="h3"><strong><?=$sayfa["baslik"];?></strong></h1>
                            
                            <?=$sayfa["icerik"];?>

                            <?php if ($sayfa["resim"] != "") { ?>
                            
                                <img src="<?=$sayfa["resim"];?>" alt="<?=$sayfa["baslik"];?>" class="img-responsive img-thumbnail">
                            
                            <?php } ?>

                            <?php if ($sayfa["video"] != "") { ?>
                            
                                <?=$sayfa["video"];?>

                            <?php } ?>

                            


                    </div>
                </div>  
            </div>
			
			 <div class="col-xl-3 col-lg-3 col-md-12 mb-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?=$kat["baslik"];?></h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-catergory">
                            <div class="item-list">
                                <ul class="list-group mb-0"> 
                                    <?php 
                                        $sayfakat=$vt->query("SELECT * FROM sayfa where kategori = '".$sayfa["kategori"]."'");
                                        while($sayfabaslik=$sayfakat->fetch()) {
                                            
                                    ?>
                                    <li class="list-group-item border-bottom-0">
                                        <a href="/<?=$sayfabaslik["seo"];?>-sayfa-<?=$sayfabaslik["id"];?>" class="text-dark btn-block"><?=$sayfabaslik["baslik"];?></a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
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