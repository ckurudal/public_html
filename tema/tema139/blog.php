<?php

    $id = $_GET["id"];
    $kategori = $_GET["kategori"]; 
    $detay = $_GET["detay"]; 

    $blogdetay = $_GET["blogdetay"];
    
    $stmt_blog = $vt->prepare("SELECT * FROM blog where id = ?");
    $stmt_blog->execute([$detay]);
    $blogs = $stmt_blog->fetch();

    $stmt_blogkat = $vt->prepare("SELECT * FROM blog_kategori where id = ?");
    $stmt_blogkat->execute([$kategori]);
    $kat = $stmt_blogkat->fetch();

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
<body> 
<?php include('ust.php'); ?>


<section class="sptb mb-8">
    <div class="container">
        
        <div class="row">

            <div class="col-xl-9 col-lg-9 col-md-12">
                <!--Add lists-->
                <div class="row">
                    <?php if (!$kategori && !$detay) { ?>
                    <?php
                        $stmt_blogsayfa = $vt->query("SELECT * FROM blog");
                        while($bsayfa = $stmt_blogsayfa->fetch()) {
                            $bkat = $vt->query("SELECT * FROM blog_kategori WHERE id = '".$bsayfa["kategori"]."'")->fetch(); 
                    ?>
                    <div class="col-xl-12 col-lg-12 col-md-12 mb-3">
                        <div class="card overflow-hidden">
                            <div class="row no-gutters blog-list">
                                <div class="col-xl-4 col-lg-12 col-md-12">
                                    <div class="item7-card-img">
                                        <a href="/<?=$bsayfa["seo"];?>-blog-<?=$bsayfa["id"];?>"></a> 
                                        <?php if ($bsayfa["resim"] == "") { ?>
                                        <img src="uploads/resim/resim.png" alt="img" alt="<?=$bsayfa["baslik"];?>" class="cover-image">                                            
                                        <?php } else { ?>
                                        <img src="<?=$bsayfa["resim"];?>" alt="img" alt="<?=$bsayfa["baslik"];?>" class="cover-image">
                                        <?php } ?>
                                        <div class="item7-card-text">
                                            <span class="badge badge-info"><?=$bkat["baslik"];?></span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-8 col-lg-12 col-md-12">
                                    <div class="card-body">
                                        <div class="item7-card-desc d-flex mb-1">
                                            <a href="/<?=$bsayfa["seo"];?>-blog-<?=$bsayfa["id"];?>" class="text-muted">
                                                <i class="fa fa-calendar-o text-muted mr-2"></i><?=$bsayfa["tarih"];?>
                                            </a>
                                        </div>
                                        <a href="/<?=$bsayfa["seo"];?>-blog-<?=$bsayfa["id"];?>" class="text-dark"><h4 class="font-weight-semibold mb-4"><?=$bsayfa["baslik"];?></h4></a>
                                        <p class=""><?=strip_tags(substr($bsayfa["icerik"], 0, 300));?>...</p>
                                        <a href="/<?=$bsayfa["seo"];?>-blog-<?=$bsayfa["id"];?>" class="btn btn-primary btn-sm">DEVAMINI OKU<i class="fa fa-angle-right ml-3"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php } ?>
                    <?php if ($kategori && !$detay) { ?>
                    <?php
                       $stmt_blogsayfa2 = $vt->prepare("SELECT * FROM blog where kategori = ?");
                        $stmt_blogsayfa2->execute([$kategori]);
                        while($bsayfa = $stmt_blogsayfa2->fetch()) {
                            $bkat = $vt->query("SELECT * FROM blog_kategori WHERE id = '".$bsayfa["kategori"]."'")->fetch(); 
                    ?>
                    <div class="col-xl-12 col-lg-12 col-md-12 mb-5">
                        <div class="card overflow-hidden">
                            <div class="row no-gutters blog-list">
                                <div class="col-xl-4 col-lg-12 col-md-12">
                                    <div class="item7-card-img">
                                        <a href="/<?=$bsayfa["seo"];?>-blog-<?=$bsayfa["id"];?>"></a> 
                                        <?php if ($bsayfa["resim"] == "") { ?>
                                        <img src="uploads/resim/resim.png" alt="img" alt="<?=$bsayfa["baslik"];?>" class="cover-image">                                            
                                        <?php } else { ?>
                                        <img src="<?=$bsayfa["resim"];?>" alt="img" alt="<?=$bsayfa["baslik"];?>" class="cover-image">
                                        <?php } ?>
                                        <div class="item7-card-text">
                                            <span class="badge badge-info"><?=$bkat["baslik"];?></span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-8 col-lg-12 col-md-12">
                                    <div class="card-body">
                                        <div class="item7-card-desc d-flex mb-1">
                                            <a href="/<?=$bsayfa["seo"];?>-blog-<?=$bsayfa["id"];?>" class="text-muted">
                                                <i class="fa fa-calendar-o text-muted mr-2"></i><?=$bsayfa["tarih"];?>
                                            </a>
                                        </div>
                                        <a href="/<?=$bsayfa["seo"];?>-blog-<?=$bsayfa["id"];?>" class="text-dark"><h4 class="font-weight-semibold mb-4"><?=$bsayfa["baslik"];?></h4></a>
                                        <p class=""><?=strip_tags(substr($bsayfa["icerik"], 0, 300));?>...</p>
                                        <a href="/<?=$bsayfa["seo"];?>-blog-<?=$bsayfa["id"];?>" class="btn btn-primary btn-sm">DEVAMINI OKU<i class="fa fa-angle-right ml-3"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php } ?>
                    <?php if ($detay) { ?>
                    <?php
                       $stmt_detayb = $vt->prepare("SELECT * FROM blog where id = ?");
                        $stmt_detayb->execute([$detay]);
                        $b = $stmt_detayb->fetch();
                            
                    ?>
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <?php if ($b["resim"] != "") { ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <img src="<?=$b["resim"];?>" alt="<?=$b["baslik"];?>">
                                            </div>
                                        </div>  
                                    </div>
                                <?php } ?>    

                                        
                                <?php if ($b["video"] != "") { ?>
                                <div class="card">                                                                                                
                                    <div class="card-body">
                                        <div class="post-picture-inner">
                                            <a href="" class="post-picture-target">                                                     
                                                <?php if ($b["video"] != "") { ?>
                                                    <center style="width:100%;"><?=$b["video"];?></center>
                                                <?php } ?>  
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>  

                                <div class="item7-card-desc d-flex mb-2 mt-3">
                                    <a href="#" class="text-muted">
                                        <i class="fa fa-calendar-o text-muted mr-2"></i><?=$b["tarih"];?></a>
                                </div> 
                                <h2 class="font-weight-semibold"><?=$b["baslik"]?></h2>
                                <?=$b["icerik"];?>      
                            </div>
                        </div>
                    </div> 
                    <?php } ?>
                </div> 
                <!--/Add lists-->
            </div>

            <div class="col-xl-3 col-lg-3 col-md-12 mb-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Blog Kategorileri</h3> </div>
                    <div class="card-body p-0">
                        <div class="list-catergory">
                            <div class="item-list">
                                <ul class="list-group mb-0"> 
                                    <?php 
                                        $stmt_blogkat2 = $vt->query("SELECT * FROM blog_kategori");
                                        while($blogbaslik = $stmt_blogkat2->fetch()) {
                                    ?>
                                    <li class="list-group-item border-bottom-0">
                                        <a href="/<?=$blogbaslik["seo"];?>-blogkategori-<?=$blogbaslik["id"];?>" class="text-dark"><?=$blogbaslik["baslik"];?></a>
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