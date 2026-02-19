<?php
    ob_start();
    $popup = $vt->query("SELECT * FROM tema_popup")->fetch();
    setcookie("pop_up", "pop_up_gizle", time() + $popup["sure"] ); // Süre kadar gizli tutar sonra gösterir
?>  
<?php if (!isset($_COOKIE["pop_up"]) AND $popup["durum"]=="Aktif") { ?>
<script type="text/javascript">
$(window).on('load', function() {
    $('#myModal').modal('show'); 
});
function popupClose() {
    $('#myModal').hide();
    $('.modal-backdrop').hide();
    $('body').removeClass('modal-open');
}
</script>
<section id="myModal" class="popup-graybox">
    <div class="coupon-popup-sec">
        <div class="coupon-content">
            <div class="row align-items-center"> 
                <div class="col-lg-7 d-none d-lg-block">
                    <a href="<?php echo $popup["link"] ?>" target="_blank">
                    <?php if ($popup["gorunum"]=="Resim") { ?>
                    <img src="<?php echo RESIM.$popup["resim"] ?>" class="img-thumbnail" alt="<?php echo $popup["baslik"] ?>">
                    <?php } if ($popup["gorunum"]=="Video") { ?> 
                    <iframe width="100%" height="570" src="https://www.youtube.com/embed/<?php echo $popup["video_link"] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    <?php } ?>
                    </a>                 
                </div>
                <div class="col-lg-5">
                    <div class="mr-lg-5 p-6 p-lg-0 pt-lg-6">
                        <h4 class="m-0 p-0 pb-2"><strong><?php echo $popup["baslik"] ?></strong></h4>
                        <p class="font-weight-light mb-5"><?php echo $popup["icerik"] ?></p>
                        <?php if ($popup["form"]=="Göster") { ?>
                        <form action="" method="post" class="form">
                            <div class="form-group">
                                <input name="ad_soyad" type="text" class="input-lg" placeholder="Adınız Soyadınız">
                            </div>
                            <div class="form-group">
                                <input name="cep" type="text" class="input-lg" placeholder="Telefon Numaranız">
                            </div> 
                            <div class="form-group">
                                <button name="beni_ara" type="submit" class="btn btn-danger  btn-block">GÖNDER</button>
                            </div>
                            <div class="form-group">
                                * Emlak profesyonellerimiz sizleri en kısa sürede arayacaklardır.
                            </div> 
                        </form>
                        <?php } ?>
                        <ul class="list-unstyled list-inline mt-3 mb-5">
                            <?php
                            $ayarsitesosyal_stmt = $vt->query("SELECT ayar_sitesosyal.sosyallink, ayar_sosyal.icon FROM ayar_sitesosyal INNER JOIN ayar_sosyal ON ayar_sitesosyal.sosyalid=ayar_sosyal.id AND ayar_sitesosyal.siteid = '1' AND ayar_sosyal.durum = 0 AND ayar_sitesosyal.sosyallink != '' ORDER BY ayar_sosyal.sira ASC");
                            while ($ayars=$ayarsitesosyal_stmt->fetch()) {
                                ?>
                                <?php
                                if ($ayars["sosyallink"] != "") {
                                    ?>
                                    <li class="list-inline-item"><a href="<?=$ayars["sosyallink"];?>" class="btn-floating btn-sm rgba-white-slight mx-1 waves-effect waves-light" target="_blank"><i class="<?=$ayars["icon"];?>"></i></a></li>
                                <?php } ?>
                            <?php } ?>
                        </ul> 
                    </div>
                </div>
            </div> 
            <button class="coupon-cls-btn close-btn" onClick="popupClose()">X</button>
        </div>
    </div>
</section> 
<?php } ?>
<div class="mobile-user-menu d-lg-none d-block"> 

        <div class="row no-gutters">
            <div class="col-3">
                <a class="" href="/"><i class="fa fa-home"></i> <span>ANASAYFA</span></a> 
            </div>
            <div class="col-6">
                <a class="cart bg-danger" target="_blank" href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&amp;emlak=emlak_ekle&amp;islem=sec"><i class="fa fa-plus"></i> <span>İLAN VER</span><i class="number cartNumber">ÜCRETSİZ</i></a> 
            </div>
            <div class="col-3">
                <a class="" id="login-open-4" href="<?php echo $ayar["site_yonetim_url"] ?>"><i class="fa fa-user-circle"></i> <span>HESABIM</span></a>
            </div>
        </div>
               
       
</div>
<a href="#" id="element" data-toggle="modal" onclick="dilAc()" class="mobil-dil-button mobil-dil-button d-block d-lg-none text-white"><i class="fa fa-globe"></i> Dil Seçiniz <i class="fa fa-angle-down"></i> </a>
<div class="dil-mobil">
    <a href="/#" onclick="doGTranslate('tr|tr'); return false;" title="Turkish" class="gflag nturl" style="background-position: -100px -500px;"> <i class="fa fa-angle-right"></i> Turkish </a>
    <a href="/#" onclick="doGTranslate('tr|en');return false;" title="English" class="gflag nturl" style="background-position: -0px -0px;"> <i class="fa fa-angle-right"></i> English </a>
    <a href="/#" onclick="doGTranslate('tr|de');return false;" title="German" class="gflag nturl" style="background-position: -300px -100px;"> <i class="fa fa-angle-right"></i> German </a>
    <a href="/#" onclick="doGTranslate('tr|fr');return false;" title="French" class="gflag nturl" style="background-position: -200px -100px;"> <i class="fa fa-angle-right"></i> French </a>
    <a href="/#" onclick="doGTranslate('tr|ar');return false;" title="Arabic" class="gflag nturl" style="background-position: -100px -0px;"> <i class="fa fa-angle-right"></i> Arabic </a>
    <a href="/#" onclick="doGTranslate('tr|hy');return false;" title="Armenian" class="gflag nturl" style="background-position: -400px -600px;"> <i class="fa fa-angle-right"></i> Armenian </a>
    <a href="/#" onclick="doGTranslate('tr|az');return false;" title="Azerbaijani" class="gflag nturl" style="background-position: -500px -600px;"> <i class="fa fa-angle-right"></i> Azerbaijani </a>
    <a href="/#" onclick="doGTranslate('tr|bg');return false;" title="Bulgarian" class="gflag nturl" style="background-position: -200px -0px;"> <i class="fa fa-angle-right"></i> Bulgarian </a>
    <a href="/#" onclick="doGTranslate('tr|zh-CN');return false;" title="Chinese (Simplified)" class="gflag nturl" style="background-position: -300px -0px;"> <i class="fa fa-angle-right"></i> Chinese </a>
    <a href="/#" onclick="doGTranslate('tr|cs');return false;" title="Czech" class="gflag nturl" style="background-position: -600px -0px;"> <i class="fa fa-angle-right"></i> Czech </a>
    <a href="/#" onclick="doGTranslate('tr|el');return false;" title="Greek" class="gflag nturl" style="background-position: -400px -100px;"> <i class="fa fa-angle-right"></i> Greek </a>
    <a href="/#" onclick="doGTranslate('tr|it');return false;" title="Italian" class="gflag nturl" style="background-position: -600px -100px;"> <i class="fa fa-angle-right"></i> Italian </a>
    <a href="/#" onclick="doGTranslate('tr|ja');return false;" title="Japanese" class="gflag nturl" style="background-position: -700px -100px;"> <i class="fa fa-angle-right"></i> Japanese </a>
    <a href="/#" onclick="doGTranslate('tr|fa');return false;" title="Persian" class="gflag nturl" style="background-position: -200px -500px;"> <i class="fa fa-angle-right"></i> Persian </a>
    <a href="/#" onclick="doGTranslate('tr|pt');return false;" title="Portuguese" class="gflag nturl" style="background-position: -300px -200px;"> <i class="fa fa-angle-right"></i> Portuguese </a>
    <a href="/#" onclick="doGTranslate('tr|ru');return false;" title="Russian" class="gflag nturl" style="background-position: -500px -200px;"> <i class="fa fa-angle-right"></i> Russian </a>
    <a href="/#" onclick="doGTranslate('tr|es');return false;" title="Spanish" class="gflag nturl" style="background-position: -600px -200px;"> <i class="fa fa-angle-right"></i> Spanish </a>
    <a href="/#" onclick="doGTranslate('tr|sv');return false;" title="Swedish" class="gflag nturl" style="background-position: -700px -200px;"> <i class="fa fa-angle-right"></i> Swedish </a>
</div>
<script> 
function dilAc() {
    $('.dil-mobil').toggle(); 
};  
$('.gflag').click(function(){ 
    $('.dil-mobil').toggle();
});
</script>
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
                                    $login_stmt = $vt->prepare("SELECT * FROM yonetici WHERE email = ? AND pass = ? AND durum = 0");
                                    $login_stmt->execute([$email, md5($sifre)]);
                                    if ($login_stmt->rowCount() > 0) {
                                        $row = $login_stmt->fetch();
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
        <div class="container<?php if ($ayar["site_header"] == 1) echo "-fluid"; ?>">
            <div class="row">
                <div class="col-xl-6 col-lg-6 d-none d-xl-inline-block d-lg-inline-block">
                    <div class="top-bar-left d-flex">
                        <div class="clearfix">
                            <ul class="socials">
                                <?php
                                $ayarsitesosyal_stmt2 = $vt->query("SELECT ayar_sitesosyal.sosyallink, ayar_sosyal.icon FROM ayar_sitesosyal INNER JOIN ayar_sosyal ON ayar_sitesosyal.sosyalid=ayar_sosyal.id AND ayar_sitesosyal.siteid = '1' AND ayar_sosyal.durum = 0 AND ayar_sitesosyal.sosyallink != '' ORDER BY ayar_sosyal.sira ASC");
                                while ($ayars=$ayarsitesosyal_stmt2->fetch()) {
                                    ?>
                                    <?php
                                    if ($ayars["sosyallink"] != "") {
                                        ?>
                                        <li><a class="social-icon text-dark" href="<?=$ayars["sosyallink"];?>" target="_blank"><i class="<?=$ayars["icon"];?>"></i></a></li>
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
                <div class="col-xl-6 col-lg-6 d-none d-xl-inline-block d-lg-inline-block"> 
					<div class="top-bar-right">
                        <ul class="custom top-menu-right">
						
							 <?php if ($site["email"] != ""): ?>
							 <li>
								<a href="mailto:<?php echo $site["email"]; ?>"><i class="fa fa-envelope-o"></i> <?php echo $site["email"]; ?></a>
							 </li>
							 <?php endif; ?>
							 <?php if ($site["sabittel"] != ""): ?>
							 <li>
								<a href="tel:<?php echo $site["sabittel"]; ?>"><i class="fa fa-phone fa-lg"></i> <?php echo $site["sabittel"]; ?></a>
							 </li>
							 <?php endif; ?>
							 <?php if ($site["gsm"] != ""): ?>
							 <li>
								<a href="tel:<?php echo $site["gsm"]; ?>"><i class="fa fa-mobile-phone fa-lg"></i> <?php echo $site["gsm"]; ?></a>
							 </li>
							 <?php endif; ?>
							 
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
				 <a href="index.php"><img src="<?=$ayar["mobilsitelogo"];?>" width="<?=$ayar["mobillogouzunluk"];?>"></a>
			</span>
            <?php if ($_SESSION["uyelogin"]): ?>
            <a href="<?php echo $ayar["site_yonetim_url"] ?>" target="_blank" class="callusbtn">
                <i class="fa fa-user fa-2x text-danger" aria-hidden="true"></i>
                <p><small>HESABIM</small></p>
            </a>
            <?php else: ?>
            <a href="/giris-yap" class="callusbtn">
                <i class="fa fa-sign-in fa-2x text-danger" aria-hidden="true"></i>
                <p><small>GİRİŞ YAP</small></p>
            </a>
            <?php endif; ?>
        </div>
    </div>
    <!-- /Duplex Houses Header -->
    <div id="sticky-wrapper" class="sticky-wrapper">
        <div class="horizontal-main bg-dark-transparent clearfix">
            <div class="container<?php if ($ayar["site_header"] == 1) echo "-fluid"; ?> horizontal-mainwrapper clearfix">
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
                        <!--<li>
						    <form class="form aramaustbar" method="GET" action="/ilanara/">
						        <div class="form-group">
						            <input type="text" class="form-control" name="baslik" placeholder="Konum, ilan no ya da emlak ofisi adıyla arayın (Örn. 1234-123456)">
						        </div> 
						    </form>
						</li>-->
                        <?php if ($_SESSION["uyelogin"]): ?>
                            <li aria-haspopup="true">
    	                    	<span class="horizontalMenu-click">
    								<i class="horizontalMenu-arrow fa fa-angle-down"></i>
    							</span>
                                <a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&emlak=emlak_favoriler" class="btn-light pl-5 pr-5">
                                    <i class="horizontalMenu-arrow fa fa-heart-o "></i> 
                                </a>
                            </li>
                            <li aria-haspopup="true">
    	                    	<span class="horizontalMenu-click">
    								<i class="horizontalMenu-arrow fa fa-angle-down"></i>
    							</span>
                                <a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>&tab_goster=mesajlari" class="btn-light pl-5 pr-5">
                                    <i class="horizontalMenu-arrow fa fa-envelope-o "></i>
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
                                <a class="btn-light pl-5 pr-5">
                                    <!-- <?php echo $uye_login["adsoyad"]; ?> --><i class="fa fa-user "></i>
                                </a>
                                <ul class="sub-menu">
                                    <?php if(yetki() == 0): ?>
                                        <li class="menuparent">
                                            <a href="<?php echo $ayar["site_yonetim_url"] ?>" target="_blank"><i class="fa fa-desktop fa-lg"></i> Yönetim Paneli</a>
                                        </li>
                                        <hr style="margin:0; padding:0;">
                                    <?php endif; ?>
                                    <li class="menuparent">
                                        <a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&emlak=emlak_ekle&islem=sec" target="_blank"><i class="fa fa-plus-circle fa-lg"></i> Ücretsiz İlan Ver</a>
                                    </li>
                                    <li class="menuparent">
                                        <a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&emlak=emlak_ilanlar" target="_blank"><i class="fa fa-building fa-lg"></i> İlanlarım</a>
                                    </li>
                                    <li class="menuparent">
                                        <a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&emlak=emlak_favoriler" target="_blank"><i class="fa fa-heart fa-lg"></i> Favori Listem</a>
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
                                        <a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>&tab_goster=magaza_paketleri" target="_blank"><i class="fa fa-dropbox fa-lg"></i> Üyelik Paketlerim</a>
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
                            <!-- <li class="mr-3"><span><a href="/emlak-talep-formu" class="btn btn-primary">  <i class="fa fa-pencil text-white"></i> Sat / Kirala</a></span></li> -->                            
							<?php if ($ayar["talep_formu"] == 1): ?>
							<li><span><a href="emlak-talep-formu" class="btn btn-danger mt-3 mr-1 ml-1 pt-2 px-6 rounded rounded-pill">Sat / Kiraya Ver</a></span></li>
							<?php endif; ?>
                            <li><span><a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&emlak=emlak_ekle&islem=sec" class="btn btn-warning mt-3 mr-1 ml-1 pt-2 rounded rounded-pill pl-6 pr-6"><strong>ÜCRETSİZ İLAN VER</strong></a></span></li>
                            <!-- <li><span><a href="/emlak-talep-formu" class="btn btn-outline-danger pr-5 pl-5 ml-3"> <strong>Sat / Kirala</strong></a></span></li> -->
                        <?php } else { ?>
                            <!-- <li class="mr-3"><span><a href="/emlak-talep-formu" class="btn btn-primary"><i class="fa fa-pencil text-white"></i> Sat / Kirala</a></span></li> -->
                            <?php if ($_SESSION["uyelogin"]) { ?>
								<?php if ($ayar["talep_formu"] == 1): ?>
								<li><span><a href="emlak-talep-formu" class="btn btn-danger mt-3 mr-1 ml-1 pt-2 px-6 rounded rounded-pill">Sat / Kiraya Ver</a></span></li>
								<?php endif; ?>
                                <li><span><a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&emlak=emlak_ekle&islem=sec" class="btn btn-warning mt-3 mr-1 ml-1 pt-2 rounded rounded-pill pl-6 pr-6"><strong>ÜCRETSİZ İLAN VER</strong></a></span></li>
                            <?php } else { ?>
                                <li><span><a href="#" data-toggle="modal" data-target="#girisYapModal" class="btn btn-success mt-3 mr-1 ml-1 pt-2 px-6 rounded rounded-pill"><i class="fa fa-user-o"></i> Giriş</a></span></li>
                                <li>
                                    <span><a href="/uyelik" class="btn btn-primary mt-3 mr-1 ml-1 pt-2 px-6 rounded rounded-pill"><i class="fa fa-user-circle-o"></i> Üyelik</a></span>
                                </li>
								<?php if ($ayar["talep_formu"] == 1): ?>
								<li><span><a href="emlak-talep-formu" class="btn btn-danger mt-3 mr-1 ml-1 pt-2 px-6 rounded rounded-pill">Sat / Kiraya Ver</a></span></li>
								<?php endif; ?>
                                <li><span><a href="<?php echo $ayar["site_yonetim_url"] ?>index.php?do=islem&emlak=emlak_ekle&islem=sec" class="btn btn-warning mt-3 mr-1 ml-1 pt-2 rounded rounded-pill pl-6 pr-6"><strong>E/B PANEL</strong></a></span></li>
                                <!-- <li><span><a href="/emlak-talep-formu" class="btn btn-outline-danger pr-5 pl-5 ml-3"> <strong>Sat / Kirala</strong></a></span></li> -->
                            <?php } ?>
                        <?php } ?>
						
                    </ul>
                </nav>
                <nav class="horizontalMenu clearfix d-md-flex">
                    <div class="overlapblackbg"></div>
                    <ul class="ana-menu horizontalMenu-list">
                        <!-- <li aria-haspopup="true"><span class="horizontalMenu-click"><i class="horizontalMenu-arrow fa fa-home"></i></span><a href="/index.php"> <span class="fa fa-home m-0"></span></a></li> -->
                        <?php
                        $ustmenuler_stmt = $vt->query("SELECT * FROM ustmenu where ustid = 0 AND durum = 0 order by sira");
                        while($ustmenu = $ustmenuler_stmt->fetch()) {
                            $katsay_stmt = $vt->prepare("SELECT COUNT(*) FROM ustmenu where ustid = ? AND durum = 0");
                            $katsay_stmt->execute([$ustmenu["id"]]);
                            $say = $katsay_stmt->fetch(PDO::FETCH_NUM);
                            ?>
                            <li aria-haspopup="true">
                                <?php if ($ustmenu["url"] == "" AND $ustmenu["seo"] != "") { ?>
                                <a <?php if($ustmenu["harici"] == 1) { ?> <?php } ?> href="/<?=$ustmenu["seo"];?>">
                                    <i class="<?=$ustmenu["icon"];?>"></i>
                                    <?=$ustmenu["baslik"];?>
                                    <?php if ($say[0] > 0) { ?>
                                        <i class="fa fa-angle-down"></i>
                                    <?php } ?>
                                </a>
								<?php } else if ($ustmenu["url"] == "" AND $ustmenu["seo"] == "") { ?>
                                <a>
                                    <i class="<?=$ustmenu["icon"];?>"></i>
                                    <?=$ustmenu["baslik"];?>
                                    <?php if ($say[0] > 0) { ?>
                                        <i class="fa fa-angle-down"></i>
                                    <?php } ?>
                                </a>
                                <?php } else { ?>
                                <a <?php if($ustmenu["harici"] == 1) { ?> <?php } ?> href="<?=$ustmenu["url"];?>">
                                    <i class="<?=$ustmenu["icon"];?>"></i>
                                    <?=$ustmenu["baslik"];?>
                                    <?php if ($say[0] > 0) { ?>
                                        <i class="fa fa-angle-down"></i>
                                    <?php } ?>
                                </a>
                                <?php } ?>
                                <ul <?php if ($say[0] > 0) {?> class="sub-menu" <?php } ?>>
                                    <?php
                                        $ustmenuler2_stmt = $vt->prepare("SELECT * FROM ustmenu where ustid = ? AND durum = 0 order by sira asc");
                                        $ustmenuler2_stmt->execute([$ustmenu["id"]]);
                                        while($ustmenu2 = $ustmenuler2_stmt->fetch()) {
                                            $menusaygoster_stmt = $vt->prepare("SELECT COUNT(*) FROM ustmenu where ustid = ? AND durum = 0");
                                            $menusaygoster_stmt->execute([$ustmenu2["id"]]);
                                            $menusay = $menusaygoster_stmt->fetch(PDO::FETCH_NUM);
                                        ?>
                                        <li <?php if ($menusay[0]!=0) { ?> class="menuparent" <?php } ?>>
											<?php if ($ustmenu2["url"] == "" AND $ustmenu2["seo"] != "") { ?>
                                            <a <?php if($ustmenu2["harici"] == 1) { ?> <?php } ?> href="/<?=$ustmenu2["seo"];?>"><strong><?=$ustmenu2["baslik"];?></strong></a>
											<?php } else if ($ustmenu2["url"] == "" AND $ustmenu2["seo"] == "") { ?>
											<a><strong><?=$ustmenu2["baslik"];?><?php if ($menusay[0] > 0) { ?><i class="fa fa-angle-right float-right" style="position: relative; top: 8px;"></i><?php } ?></strong></a>
											<?php } else { ?>
											<a <?php if($ustmenu2["harici"] == 1) { ?> <?php } ?> href="<?=$ustmenu2["url"];?>"><strong><?=$ustmenu2["baslik"];?></strong></a>
											<?php } ?>
                                            <ul <?php if ($menusay[0] > 0) { ?> class="sub-menu" <?php } ?>>
                                                <?php
                                                $ustmenuler3_stmt = $vt->prepare("SELECT * FROM ustmenu where ustid = ? AND durum = 0 order by sira asc");
                                                $ustmenuler3_stmt->execute([$ustmenu2["id"]]);
                                                while($ustmenu3 = $ustmenuler3_stmt->fetch()) {
                                                    $menusaygoster3_stmt = $vt->prepare("SELECT COUNT(*) FROM ustmenu where ustid = ? AND durum = 0");
                                                    $menusaygoster3_stmt->execute([$ustmenu3["id"]]);
                                                    $menusay = $menusaygoster3_stmt->fetch(PDO::FETCH_NUM);
                                                    ?>
                                                    <li <?php if ($menusay[0]!=0) { ?> class="menuparent" <?php } ?>>
													<?php if ($ustmenu3["url"] == "") { ?>
                                                        <a <?php if($ustmenu3["harici"] == 1) { ?> <?php } ?> href="/<?=$ustmenu3["seo"];?>"><?=$ustmenu3["baslik"];?></a>
													<?php } else { ?>
														<a <?php if($ustmenu3["harici"] == 1) { ?> <?php } ?> href="<?=$ustmenu3["url"];?>"><?=$ustmenu3["baslik"];?></a>
													<?php } ?>
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
<!-- AI CHATBOT WIDGET -->
<div id="chatbot-widget">
    <button id="chatbot-toggle" title="AI Asistan">
        <i class="fa fa-comments"></i>
        <span id="chatbot-badge">1</span>
    </button>
    <div id="chatbot-pencere">
        <div class="chatbot-header">
            <i class="fa fa-robot"></i>
            <span>AI Emlak Asistanı</span>
            <span class="chatbot-ai-badge">YAPAY ZEKA</span>
        </div>
        <div id="chatbot-mesajlar"></div>
        <div class="chatbot-footer">
            <input type="text" id="chatbot-input" placeholder="Bir şeyler sorun...">
            <button id="chatbot-gonder"><i class="fa fa-paper-plane"></i></button>
        </div>
    </div>
</div>

<!-- PROPERTY COMPARISON BAR -->
<div id="karsilastir-bar">
    <div class="kb-title">
        <i class="fa fa-exchange"></i>
        Karşılaştırma Listesi
        <span id="karsilastir-sayac" class="kb-sayac">0</span>
    </div>
    <button id="karsilastir-listele-btn">Karşılaştır</button>
    <button id="karsilastir-temizle-btn">Temizle</button>
</div>

<!-- BACK TO TOP -->
<button id="back-to-top" title="Yukarı çık"><i class="fa fa-chevron-up"></i></button>
