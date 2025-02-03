<?php
    $islem = $_GET["islem"];
?>
<!doctype html>
<html class="no-js" lang="tr"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- set the page title -->
    <title>Üyelik</title>
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
<div class="bannerimg cover-image bg-background3" data-image-src="../../assets/images/banners/banner2.jpg" style="background: url(&quot;../../assets/images/banners/banner2.jpg&quot;) center center;">
    <div class="header-text mb-0">
        <div class="container">
            <div class="text-center text-white ">
                <h3>Üye Paneli</h3>
            </div>
        </div>
    </div>
</div> 
<div class="container">
    <?php include("panel/index.php");?>

    <?php if ($islem == "cikis") {

        session_destroy();
        go("index.php", 0);
    } ?>

</div>


<section>
<?php include("footer.php"); ?>    
</section>
<?php include("alt.php"); ?>
</body>
<!-- Mirrored from www.spruko.com/demo/reallist/htm/Reallist-LTR/Html/ by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 05 Apr 2020 15:27:18 GMT -->
</html>