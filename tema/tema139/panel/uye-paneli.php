<?php if ($_SESSION["uyelogin"]): ?>
<?php
$islem = $_GET["islem"];
?>
<!doctype html>
<html class="no-js" lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- set the page title -->
    <title>Üyeli - <?=$ayar["site_adi"];?></title>
    <meta name="description" content="<?=$ayar['site_desc'];?>" />
    <meta name="keywords" content="<?=$ayar['site_keyw'];?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="robots" content="index, follow" />
    <meta name="Revisit-After" content="1 Days" />
    <link rel="shortcut icon" type="image/x-icon" href="<?=$ayar['favicon'];?>">
    <meta name="generator" content="RoxiKonsept 2.0" />
    <link rel="canonical" href="<?php echo "https://".$_SERVER['HTTP_HOST']."".$_SERVER['REQUEST_URI'].""; ?>" />
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <base href="<?=$ayar["site_url"];?>">
       <!-- Bootstrap Css -->
    <link href="<?=TEMA_URL?>/assets/plugins/bootstrap-4.3.1-dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Dashboard Css -->
    <link href="<?=TEMA_URL?>/assets/css/style.css" rel="stylesheet" />
    <!-- Font-awesome  Css -->
    <link href="<?=TEMA_URL?>/assets/css/icons.css" rel="stylesheet"/> 
    <!--Horizontal Menu-->
    <link href="<?=TEMA_URL?>/assets/plugins/horizontal-menu/horizontal.css" rel="stylesheet" />
    <!--Select2 Plugin -->
    <link href="<?=TEMA_URL?>/assets/plugins/select2/select2.min.css" rel="stylesheet" />
    <!-- Cookie css -->
    <link href="<?=TEMA_URL?>/assets/plugins/cookie/cookie.css" rel="stylesheet">
    <!-- Owl Theme css-->
    <link href="<?=TEMA_URL?>/assets/plugins/owl-carousel/owl.carousel.css" rel="stylesheet" />
    <!-- Custom scroll bar css-->
    <link href="<?=TEMA_URL?>/assets/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet" />
    <!-- P-scroll bar css-->
    <link href="<?=TEMA_URL?>/assets/plugins/pscrollbar/perfect-scrollbar.css" rel="stylesheet" />
    <!-- Switcher css -->
    <link href="<?=TEMA_URL?>/assets/switcher/css/switcher.css" rel="stylesheet" id="switcher-css" type="text/css" media="all" />
    <link href="<?=TEMA_URL?>/assets/css/feather.css" rel="stylesheet" id="switcher-css" type="text/css" media="all" />
    <!-- COLOR-SKINS -->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="<?=TEMA_URL?>/assets/skins/color-skins/color15.css" />
    <link rel="stylesheet" href="<?=TEMA_URL?>/assets/skins/demo.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta http-equiv="imagetoolbar" content="no" />
    <!--[if gte IE 5]><frame></frame><![endif]-->
	
    <!-- Icons font CSS-->
    <link href="<?=TEMA_URL?>/assets/forms/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="<?=TEMA_URL?>/assets/forms/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="<?=TEMA_URL?>/assets/forms/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="<?=TEMA_URL?>/assets/forms/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">
    <!-- Lightbox -->
    <link href="<?=TEMA_URL?>/assets/lightbox/css/lightgallery.css" rel="stylesheet">

    <!-- Main CSS-->
    <link href="<?=TEMA_URL?>/assets/forms/css/main.css" rel="stylesheet" media="all">



</head>
<body>
<div id="google_translate_element2"></div>
<div class="header-main">
    <div class="modal fade" id="girisYapModal" tabindex="-1" role="dialog" aria-labelledby="girisModal"
         aria-hidden="true">
        <div class="modal-dialog form-dark" role="document">
            <!--Content-->
            <div class="modal-content card card-image">
                <div class="text-white rgba-stylish-strong z-depth-4">
                    <!--Header-->
                    <div class="modal-header text-center pb-4">
                        <h4 class="modal-title text-dark" id="girisModal">
                            <strong>Giriş Yap</strong>
                            <a class="green-text font-weight-bold"><strong></strong></a>
                        </h4>
                        <button type="button" class="close white-text" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span> Kapat
                        </button>
                    </div>
                    <!--Body-->
                    <div class="modal-body py-5 px-5">
                        <form method="post" class="cardCalcForm">
                            <?php
                            if (isset($_POST["uyegirisi"])) {
                                $email = p("email");
                                $sifre = p("sifre");
                                if (!$email || !$sifre) {
                                    echo '<h6 class="alert alert-danger"><i class="fa fa-warning fa-lg"></i> Email ve şifre giriniz.</h6>';
                                } else {
                                    $query = mysql_query("SELECT * FROM yonetici WHERE email = '$email' && pass = '".md5($sifre)."' && durum = 0");
                                    if (mysql_affected_rows()) {
                                        $row = row($query);
                                        $_SESSION = array (
                                            "uyelogin" => true,
                                            "id" => $row["id"],
                                            "email" => $row["email"],
                                        );
                                        @session_olustur($session);
                                        go("/", 0);
                                    } else {
                                        hata_alert("E-posta adresiniz veya şifreniz hatalı. Lütfen bilgilerinizi kontrol ediniz.");
                                    }
                                }
                            }
                            ?>
                            <?php if ($hareket == "onay") { ?>
                                <h6 class="alert alert-danger"><i class="fa fa-check fa-lg"></i> Üyelik kaydı başarılı. Lütfen giriş yapınız.</h6>
                            <?php } ?>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" name="email" placeholder="E-posta Adresi" class="input--style-4 input-lg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="password" name="sifre" placeholder="Şifre" class="input--style-4 input-lg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <a href="<?php echo $ayar["site_yonetim_url"] ?>giris.php?islem=sifre">Şifremi Unuttum</a>
                            </div>
                            <button type="submit" class="btn btn-danger btn-block" name="uyegirisi"><strong>GİRİŞ</strong></button>
                            <div class="form-group text-center mt-5">
                                <a href="index.php?do=hesabim&islem=uyelik-sec">Üyelik Oluştur</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-sm-4 col-8 col-12">
                    <div class="top-bar-left d-flex">
                        <div class="clearfix">
                            <ul class="socials">
                                <?php
                                $ayarsitesosyal = mysql_query("SELECT * FROM ayar_sitesosyal where siteid = '1'");
                                while ($ayars=mysql_fetch_array($ayarsitesosyal)) {
                                    ?>
                                    <?php
                                    if ($ayars["sosyallink"] != "") {
                                        ?>
                                        <li><a class="social-icon text-dark" href="<?=$ayars["link"];?>/<?=$ayars["sosyallink"];?>" target="_blank"><i class="<?=$ayars["icon"];?>"></i></a></li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="clearfix">
                            <ul class="contact">
                                <li class="dropdown mr-5"> <a href="#" class="text-dark" data-toggle="dropdown"><span> Dil Seçiniz <i class="fa fa-caret-down text-muted"></i></span> </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a href="/#" onclick="doGTranslate('tr|tr');return false;" title="Turkish" class="gflag nturl" style="background-position: -100px -500px;">
                                            <i class="fa fa-angle-right"></i> Turkish
                                        </a>
                                        <a href="/#" onclick="doGTranslate('tr|en');return false;" title="English" class="gflag nturl" style="background-position: -0px -0px;">
                                            <i class="fa fa-angle-right"></i> English
                                        </a>
                                        <a href="/#" onclick="doGTranslate('tr|de');return false;" title="German" class="gflag nturl" style="background-position: -300px -100px;">
                                            <i class="fa fa-angle-right"></i> German
                                        </a>
                                        <a href="/#" onclick="doGTranslate('tr|fr');return false;" title="French" class="gflag nturl" style="background-position: -200px -100px;">
                                            <i class="fa fa-angle-right"></i> French
                                        </a>
                                        <a href="/#" onclick="doGTranslate('tr|ar');return false;" title="Arabic" class="gflag nturl" style="background-position: -100px -0px;">
                                            <i class="fa fa-angle-right"></i> Arabic
                                        </a>
                                        <a href="/#" onclick="doGTranslate('tr|hy');return false;" title="Armenian" class="gflag nturl" style="background-position: -400px -600px;">
                                            <i class="fa fa-angle-right"></i> Armenian
                                        </a>
                                        <a href="/#" onclick="doGTranslate('tr|az');return false;" title="Azerbaijani" class="gflag nturl" style="background-position: -500px -600px;">
                                            <i class="fa fa-angle-right"></i> Azerbaijani
                                        </a>
                                        <a href="/#" onclick="doGTranslate('tr|bg');return false;" title="Bulgarian" class="gflag nturl" style="background-position: -200px -0px;">
                                            <i class="fa fa-angle-right"></i> Bulgarian
                                        </a>
                                        <a href="/#" onclick="doGTranslate('tr|zh-CN');return false;" title="Chinese (Simplified)" class="gflag nturl" style="background-position: -300px -0px;">
                                            <i class="fa fa-angle-right"></i> Chinese
                                        </a>
                                        <a href="/#" onclick="doGTranslate('tr|cs');return false;" title="Czech" class="gflag nturl" style="background-position: -600px -0px;">
                                            <i class="fa fa-angle-right"></i> Czech
                                        </a>
                                        <a href="/#" onclick="doGTranslate('tr|el');return false;" title="Greek" class="gflag nturl" style="background-position: -400px -100px;">
                                            <i class="fa fa-angle-right"></i> Greek
                                        </a>
                                        <a href="/#" onclick="doGTranslate('tr|it');return false;" title="Italian" class="gflag nturl" style="background-position: -600px -100px;">
                                            <i class="fa fa-angle-right"></i> Italian
                                        </a>
                                        <a href="/#" onclick="doGTranslate('tr|ja');return false;" title="Japanese" class="gflag nturl" style="background-position: -700px -100px;">
                                            <i class="fa fa-angle-right"></i> Japanese
                                        </a>
                                        <a href="/#" onclick="doGTranslate('tr|fa');return false;" title="Persian" class="gflag nturl" style="background-position: -200px -500px;">
                                            <i class="fa fa-angle-right"></i> Persian
                                        </a>
                                        <a href="/#" onclick="doGTranslate('tr|pt');return false;" title="Portuguese" class="gflag nturl" style="background-position: -300px -200px;">
                                            <i class="fa fa-angle-right"></i> Portuguese
                                        </a>
                                        <a href="/#" onclick="doGTranslate('tr|ru');return false;" title="Russian" class="gflag nturl" style="background-position: -500px -200px;">
                                            <i class="fa fa-angle-right"></i> Russian
                                        </a>
                                        <a href="/#" onclick="doGTranslate('tr|es');return false;" title="Spanish" class="gflag nturl" style="background-position: -600px -200px;">
                                            <i class="fa fa-angle-right"></i> Spanish
                                        </a>
                                        <a href="/#" onclick="doGTranslate('tr|sv');return false;" title="Swedish" class="gflag nturl" style="background-position: -700px -200px;">
                                            <i class="fa fa-angle-right"></i> Swedish
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-sm-8 col-4">
                    <div class="top-bar-right d-none">
                        <ul class="custom d-none">
                            <?php if ($_SESSION["uyelogin"]) { ?>
                                <li>
                                    <a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&ofis=yonetici&islem=duzenle&id=376&tab_goster=mesajlari">
                                        <i class="fa fa-download"></i>  <span>Mesaj Kutusu</span>
                                        <?php if ($danmesajtopla>0) { ?>
                                            (<?=$danmesajtopla;?>)
                                        <?php } ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="/hesabim">
                                        <i class="fa fa-user mr-1"></i> <span>Bana Özel</span>
                                    </a>
                                </li>
                                <li><a href="/cikis-yap"><i class="fa fa-sign-out fa-lg"></i><span>Çıkış Yap</span></a></li>
                            <?php } ?>
                            <?php if (!$_SESSION["uyelogin"]) { ?>
                                <li><a href="/giris-yap"> <i class="fa fa-sign-in mr-1"></i><span>Giriş Yap</span></a></li>
                                <li><a href="/uye-ol"> <i class="fa fa-user mr-1"></i><span>Üye Ol</span></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="horizontal-header clearfix ">
        <div class="container">
            <a id="horizontal-navtoggle" class="animated-arrow">
                <i class="fa fa-bars fa-2x text-danger"></i>
                <p><small>MENÜ</small></p>
            </a>
            <span class="smllogo">
				 <a href="index.php"><img src="<?=$ayar["mobilsitelogo"];?>" width="<?=$ayar["logouzunluk"];?>"></a>
			</span>
            <?php if ($_SESSION["uyelogin"]): ?>
            <a href="/uye-paneli" class="callusbtn">
                <i class="fa fa-user fa-2x text-danger" aria-hidden="true"></i>
                <p><small>HESABIM</small></p>
            </a>
            <?php else: ?>
            <a href="/uye-paneli" class="callusbtn">
                <i class="fa fa-sign-in fa-2x text-danger" aria-hidden="true"></i>
                <p><small>GİRİŞ YAP</small></p>
            </a>
            <?php endif; ?>
        </div>
    </div>
    <!-- /Duplex Houses Header -->
    <div id="sticky-wrapper" class="sticky-wrapper">
        <div class="horizontal-main bg-dark-transparent clearfix">
            <div class="container horizontal-mainwrapper clearfix">
                <div class="desktoplogo">
                    <a href="/index.php"> <img src="/<?=$ayar["sitelogo"];?>" width="<?=$ayar["logouzunluk"];?>" alt="<?=$site["firmadi"];?>">  </a>
                </div>
                <div class="desktoplogo-1">
                    <a href="/index.php"><img src="/<?=$ayar["sitelogo"];?>" width="<?=$ayar["logouzunluk"];?>" alt="<?=$site["firmadi"];?>">  </a>
                </div>
                <!--Nav-->
                <nav class="horizontalMenu clearfix d-md-flex float-right">
                    <div class="overlapblackbg"></div>
                    <?php $uye_login = $vt->query("SELECT * FROM yonetici WHERE id = '".$_SESSION["id"]."'")->fetch(); ?>
                    <ul class="horizontalMenu-list">
                        <?php if ($_SESSION["uyelogin"]): ?>
                            <li aria-haspopup="true">
	                    	<span class="horizontalMenu-click">
								<i class="horizontalMenu-arrow fa fa-angle-down"></i>
							</span>
                                <a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>&tab_goster=mesajlari" target="_blank" class="btn-light pl-5 pr-5">
                                    <i class="horizontalMenu-arrow fa fa-envelope-o fa-lg mr-3"></i> Mesajlarım
                                    <?php
                                    $gelen_mesaj_say = gelen_mesaj($_SESSION["id"]);
                                    if ($gelen_mesaj_say>0):
                                        ?>
                                        <span class="badge badge-danger" style="position: absolute; top: 5px; font-size: .7rem;"><strong><?php echo $gelen_mesaj_say; ?></strong></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <li aria-haspopup="true">
							<span class="horizontalMenu-click">
								<i class="horizontalMenu-arrow fa fa-angle-down"></i>
							</span>
                                <a href="#" class="btn-light pl-5">
                                    <?php echo $uye_login["adsoyad"]; ?> <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="sub-menu">
                                    <?php if(yetki() == 0): ?>
                                        <li class="menuparent">
                                            <a href="<?php echo $ayar["site_yonetim_url"] ?>" target="_blank"><i class="fa fa-desktop fa-lg"></i> Yönetim Paneli</a>
                                        </li>
                                        <hr style="margin:0; padding:0;">
                                    <?php endif; ?>
                                    <li class="menuparent">
                                        <a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&emlak=emlak_ekle&islem=sec" target="_blank"><i class="fa fa-plus-circle fa-lg"></i> İlan Ver</a>
                                    </li>
                                    <li class="menuparent">
                                        <a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&emlak=emlak_ilanlar" target="_blank"><i class="fa fa-building fa-lg"></i> İlanlarım</a>
                                    </li>
                                    <li class="menuparent">
                                        <a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>&tab_goster=dopingleri" target="_blank"><i class="fa fa-rocket fa-lg"></i> Dopinglerim</a>
                                    </li>
                                    <?php if ($uye_login["yetki"] == 2) { ?>
                                        <li class="menuparent">
                                            <a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>&tab_goster=danismanlari" target="_blank"><i class="fa fa-users fa-lg"></i> Danışmanlarım</a>
                                        </li>
                                        <li class="menuparent">
                                            <a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&ofis=subeekle&islem=duzenle&id=<?php echo $uye_login["ofis"]; ?>" target="_blank"><i class="fa fa-archive fa-lg"></i> Mağazam</a>
                                        </li>
                                    <?php } ?>
                                    <li class="menuparent">
                                        <a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>&tab_goster=magaza_paketleri" target="_blank"><i class="fa fa-dropbox fa-lg"></i> Paketlerim</a>
                                    </li>
                                    <li class="menuparent">
                                        <a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>&tab_goster=mesajlari" target="_blank"><i class="fa fa-inbox fa-lg"></i> Mesajlarım <span class="badge badge-danger"><small><?php echo gelen_mesaj($_SESSION["id"]); ?></small></span></a>
                                    </li>
                                    <li class="menuparent">
                                        <a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>" target="_blank"><i class="fa fa-user-o fa-lg"></i> Üyeliğim</a>
                                    </li>
                                    <li class="menuparent">
                                        <a href="/cikis-yap"><i class="fa fa-sign-out fa-lg"></i> Çıkış Yap</a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <?php if ($_SESSION["uyelogin"]) { ?>
                            <!-- <li class="mr-3"><span><a href="/emlak-talep-formu" class="btn btn-primary">  <i class="fa fa-pencil text-white"></i> Evimi Sat / Kirala</a></span></li> -->
                            <li><span><a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&emlak=emlak_ekle&islem=sec" target="_blank" class="btn btn-danger mt-2 p-3 pr-5 pl-0 ml-3 rounded rounded-pill font-weight-semibold"><i class="fa fa-plus text-white mr-1 ml-2"></i> Ücretsiz İlan Ver</a></span></li>
                            <!-- <li><span><a href="/emlak-talep-formu" class="btn btn-outline-danger pr-5 pl-5 ml-3"> <strong>Evimi Sat / Kirala</strong></a></span></li> -->
                        <?php } else { ?>
                            <!-- <li class="mr-3"><span><a href="/emlak-talep-formu" class="btn btn-primary"><i class="fa fa-pencil text-white"></i> Evimi Sat / Kirala</a></span></li> -->
                            <?php if ($_SESSION["uyelogin"]) { ?>
                                <li><span><a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&emlak=emlak_ekle&islem=sec" target="_blank" class="btn btn-danger p-3 pr-5 pl-0 ml-3 rounded-pill"><i class="fa fa-plus text-white mr-3"></i> <strong>Ücretsiz İlan Ver</strong></a></span></li>
                            <?php } else { ?>
                                <li><span><a href="#" data-toggle="modal" data-target="#girisYapModal" class="btn btn-dark mt-4 p-2 pl-5 pr-5 ml-3 rounded rounded-pill"><i class="fa fa-user-o fa-lg text-white"> </i> Giriş Yap</a></span></li>
                                <li>
                                    <span><a href="/uyelik" class="btn mt-4 p-2 pl-5 pr-5 btn-danger ml-3 rounded rounded-pill"><i class="fa fa-user-plus fa-lg text-white"></i> Üye Ol</a></span>
                                </li>
                                <li><span><a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&emlak=emlak_ekle&islem=sec" target="_blank" class="btn btn-danger mt-4 p-2 pr-5 pl-3 pl-0 ml-3 rounded rounded-pill font-weight-semibold"><i class="fa fa-plus text-white mr-1 ml-2"></i> Ücretsiz İlan Ver</a></span></li>
                                <!-- <li><span><a href="/emlak-talep-formu" class="btn btn-outline-danger pr-5 pl-5 ml-3"> <strong>Evimi Sat / Kirala</strong></a></span></li> -->
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </nav>
                <nav class="horizontalMenu clearfix d-md-flex">
                    <div class="overlapblackbg"></div>
                    <ul class="horizontalMenu-list">
                        <li aria-haspopup="true"><span class="horizontalMenu-click"><i class="horizontalMenu-arrow fa fa-home"></i></span><a href="/index.php"> <span class="fa fa-home m-0"></span></a></li>
                        <?php
                        $ustmenuler = mysql_query("SELECT * FROM ustmenu where ustid = 0 && durum = 0 order by sira");
                        while($ustmenu = mysql_fetch_array($ustmenuler)) {
                            $katsay = mysql_query("SELECT COUNT(*) FROM ustmenu where ustid = '".$ustmenu["id"]."' && durum = 0");
                            $say = mysql_fetch_array($katsay);
                            ?>
                            <li aria-haspopup="true">

                                <?php if ($ustmenu["url"] == "") { ?>
                                    <a href="/<?=$ustmenu["seo"];?>">
                                        <i class="<?=$ustmenu["icon"];?>"></i>
                                        <?=$ustmenu["baslik"];?>
                                        <?php if ($say[0] > 0) { ?>
                                            <i class="fa fa-angle-down"></i>
                                        <?php } ?>
                                    </a>
                                <?php } else { ?>
                                    <a href="/<?=$ustmenu["url"];?>">
                                        <i class="<?=$ustmenu["icon"];?>"></i>
                                        <?=$ustmenu["baslik"];?>
                                        <?php if ($say[0] > 0) { ?>
                                            <i class="fa fa-angle-down"></i>
                                        <?php } ?>
                                    </a>
                                <?php } ?>
                                <ul <?php if ($say[0] > 0) {?> class="sub-menu" <?php } ?>>
                                    <?php
                                    $ustmenuler2 = mysql_query("SELECT * FROM ustmenu where ustid = '".$ustmenu["id"]."' && durum = 0 order by sira asc");
                                    while($ustmenu2 = mysql_fetch_array($ustmenuler2)) {
                                        $menusaygoster = mysql_query("SELECT COUNT(*) FROM ustmenu where ustid = '".$ustmenu2["id"]."' && durum = 0");
                                        $menusay = mysql_fetch_array($menusaygoster);
                                        ?>
                                        <li <?php if ($menusay[0]!=0) { ?> class="menuparent" <?php } ?>>
                                            <a href="/<?=$ustmenu2["seo"];?>"><?=$ustmenu2["baslik"];?></a>
                                            <ul <?php if ($say[0] > 0) {?> class="sub-menu" <?php } ?>>
                                                <?php
                                                $ustmenuler3 = mysql_query("SELECT * FROM ustmenu where ustid = '".$ustmenu2["id"]."' && durum = 0 order by sira asc");
                                                while($ustmenu3 = mysql_fetch_array($ustmenuler3)) {
                                                    $menusaygoster = mysql_query("SELECT COUNT(*) FROM ustmenu where ustid = '".$ustmenuler3["id"]."' && durum = 0");
                                                    $menusay = mysql_fetch_array($menusaygoster);
                                                    ?>
                                                    <li <?php if ($menusay[0]!=0) { ?> class="menuparent" <?php } ?>>
                                                        <a href="/<?=$ustmenu3["seo"];?>"><?=$ustmenu3["baslik"];?></a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
                <!--Nav-->
            </div>
        </div>
    </div>
</div>
<div class="bannerimg cover-image bg-background3" data-image-src="../../assets/images/banners/banner2.jpg" style="background: url('../../assets/images/banners/banner2.jpg';) center center;">
    <div class="header-text mb-0">
        <div class="container">
            <div class="text-center text-white ">
                <h3>BANA ÖZEL</h3>
            </div>
        </div>
    </div>
</div>
<div class="container">



    <section class="pb-5 pl-3 pr-3">
        <div class="row">

            <div class="col-6">
                <div class="card mb-5">
                    <div class="card-body text-center pt-7 pb-6">
                        <a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&emlak=emlak_ekle&islem=sec" class="">
                            <p><i class="fa fa-plus-circle fa-2x text-danger"></i></p>
                            <p>İLAN EKLE</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card mb-5">
                    <div class="card-body text-center pt-7 pb-6">
                        <a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&emlak=emlak_ilanlar" class="">
                            <p><i class="fa fa-building fa-2x text-danger"></i></p>
                            <p>İLANLARIM</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card mb-5">
                    <div class="card-body text-center pt-7 pb-6">
                        <a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>&tab_goster=dopingleri" class="">
                            <p><i class="fa fa-rocket fa-2x text-danger"></i></p>
                            <p>DOPİNGLERİM</p>
                        </a>
                    </div>
                </div>
            </div>
            <?php if (yetki() == 2): ?>
                <div class="col-6">
                    <div class="card mb-5">
                        <div class="card-body text-center pt-7 pb-6">
                            <a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>&tab_goster=danismanlari" class="">
                                <p><i class="fa fa-users fa-2x text-danger"></i></p>
                                <p>DANIŞMANLARIM</p>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (yetki() == 2): ?>
                <div class="col-6">
                    <div class="card mb-5">
                        <div class="card-body text-center pt-7 pb-6">
                            <a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&ofis=subeekle&islem=duzenle&id=<?php echo $uye_login["ofis"]; ?>" class="">
                                <p><i class="fa fa-archive fa-2x text-danger"></i></p>
                                <p>MAĞAZAM</p>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="col-6">
                <div class="card mb-5">
                    <div class="card-body text-center pt-7 pb-6">
                        <a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>>&tab_goster=magaza_paketleri" class="">
                            <p><i class="fa fa-dropbox fa-2x text-danger"></i></p>
                            <p>PAKETLERİM</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card mb-5">
                    <div class="card-body text-center pt-7 pb-6">
                        <a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>&tab_goster=mesajlari" class="">
                            <p><i class="fa fa-inbox fa-2x text-danger"></i></p>
                            <p>MESAJLARIM</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card mb-5">
                    <div class="card-body text-center pt-7 pb-6">
                        <a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>" class="">
                            <p><i class="fa fa-user-circle-o fa-2x text-danger"></i></p>
                            <p>ÜYELİĞİM</p>
                        </a>
                    </div>
                </div>
            </div>
			<?php if ($ayar["talep_formu"] == 1): ?>
            <div class="col-6">
                <div class="card mb-5">
                    <div class="card-body text-center pt-7 pb-6">
                        <a href="/emlak-talep-formu" class="">
                            <p><i class="fa fa-plus fa-2x text-danger"></i></p>
                            <p>TALEP FORMU</p>
                        </a>
                    </div>
                </div>
            </div>
			<?php endif; ?>
            <div class="<?php if ($ayar["talep_formu"] == 1): ?> col-6 <?php else: ?> col-12 <?php endif; ?> ">
                <div class="card mb-5">
                    <div class="card-body text-center pt-7 pb-6">
                        <a href="/cikis-yap" class="">
                            <p><i class="fa fa-sign-out fa-2x text-danger"></i></p>
                            <p>ÇIKIŞ YAP</p>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

</div>


<section>
    <?php include("/../footer.php"); ?>
</section>
<?php include("/../alt.php"); ?>
</body> 
</html>

<?php else: ?>
<?php go("giris-yap"); ?>
<?php endif; ?>