<?php

echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;

$emlakmesajver = $vt->query("SELECT COUNT(*) FROM emlak_mesaj where onay = 0");
$emlakmesaj = $emlakmesajver->fetch();

$gelenmesajver = $vt->query("SELECT COUNT(*) FROM emlak_mesajiletisim where onay = 0");
$gelenmesaj = $gelenmesajver->fetch();

$emlaktalepver = $vt->query("SELECT COUNT(*) FROM emlak_mesajemlaktalep where onay = 0");
$emlaktalep = $emlaktalepver->fetch();

$emlakonay = $vt->query("SELECT COUNT(*) FROM emlak_ilan where onay = 0")->fetch();

$doping_say = $vt->query("SELECT COUNT(*) FROM emlak_ilan where doping_onay = 0 AND doping = 'var'");
$doping_onay_say = $doping_say->fetch();

$magaza_say = $vt->query("SELECT COUNT(*) FROM magaza_uye_paket where onay = 0");
$magaza_onay_say = $magaza_say->fetch(); 

$toplam = $emlakmesaj[0] + $gelenmesaj[0] + $emlaktalep[0] + $emlakonay[0] + gelen_mesaj($_SESSION["id"]) + $doping_onay_say[0] + $magaza_onay_say[0];  
	
    if ($kullanici["yetki"] != 0) {

    	$ilan          = $vt->query("SELECT COUNT(*) FROM emlak_ilan where onay = 1 AND durum = 0 AND satildi = 0 AND kiralandi = 0 AND yonetici_id = '".$kullanici["id"]."'")->fetch();
    	$avitrin       = $vt->query("SELECT COUNT(*) FROM emlak_ilan where anavitrin = '1' AND yonetici_id = '".$kullanici["id"]."'")->fetch();
    	$kvitrin       = $vt->query("SELECT COUNT(*) FROM emlak_ilan where katvitrin = '1' AND yonetici_id = '".$kullanici["id"]."'")->fetch();
    	$fvitrin       = $vt->query("SELECT COUNT(*) FROM emlak_ilan where firsatvitrin = '1' AND yonetici_id = '".$kullanici["id"]."'")->fetch();
    	$ovitrin       = $vt->query("SELECT COUNT(*) FROM emlak_ilan where onecikan = '1' AND yonetici_id = '".$kullanici["id"]."'")->fetch();
    	$acilv         = $vt->query("SELECT COUNT(*) FROM emlak_ilan where acil = '1' AND yonetici_id = '".$kullanici["id"]."'")->fetch();
        $kat           = $vt->query("SELECT COUNT(*) FROM emlak_kategori")->fetch();
        $onaysay       = $vt->query("SELECT COUNT(*) FROM emlak_ilan where onay = 0 AND yonetici_id = '".$kullanici["id"]."'")->fetch();
        $satildisay    = $vt->query("SELECT COUNT(*) FROM emlak_ilan where satildi = 1 AND yonetici_id = '".$kullanici["id"]."'")->fetch();
        $kiralandisay  = $vt->query("SELECT COUNT(*) FROM emlak_ilan where kiralandi = 1 AND yonetici_id = '".$kullanici["id"]."'")->fetch();
        $pasifsay      = $vt->query("SELECT COUNT(*) FROM emlak_ilan where durum = 1 AND onay = 1 AND satildi = 0 AND kiralandi = 0 AND onay = 1 AND yonetici_id = '".$kullanici["id"]."'")->fetch();

    } else {

        $ilan          = $vt->query("SELECT COUNT(*) FROM emlak_ilan where onay = 1 AND durum = 0 AND satildi = 0 AND kiralandi = 0")->fetch();
        $avitrin       = $vt->query("SELECT COUNT(*) FROM emlak_ilan where anavitrin = '1'")->fetch();
        $kvitrin       = $vt->query("SELECT COUNT(*) FROM emlak_ilan where katvitrin = '1'")->fetch();
        $fvitrin       = $vt->query("SELECT COUNT(*) FROM emlak_ilan where firsatvitrin = '1'")->fetch();
        $ovitrin       = $vt->query("SELECT COUNT(*) FROM emlak_ilan where onecikan = '1'")->fetch();
        $acilv         = $vt->query("SELECT COUNT(*) FROM emlak_ilan where acil = '1'")->fetch();
        $kat           = $vt->query("SELECT COUNT(*) FROM emlak_kategori")->fetch();
        $onaysay       = $vt->query("SELECT COUNT(*) FROM emlak_ilan where onay = 0")->fetch();
        $satildisay    = $vt->query("SELECT COUNT(*) FROM emlak_ilan where satildi = 1")->fetch();
        $kiralandisay  = $vt->query("SELECT COUNT(*) FROM emlak_ilan where kiralandi = 1")->fetch();
        $pasifsay      = $vt->query("SELECT COUNT(*) FROM emlak_ilan where durum = 1 AND satildi = 0 AND kiralandi = 0 AND onay = 1")->fetch();
    }

?>
<?php if ($kullanici["yetki"] != 0) { ?>


    
    <style type="text/css">
        
        .content-wrapper {
            /* margin-left: 0 !important; */
        }

        .skin-black .main-sidebar {
            /* display: none !important; */
        }

    </style>

<?php } ?>

<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo $ayar["site_yonetim_url"] ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">
            <b>V</b>9.23</span> 
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
            <?php if ($kullanici["yetki"] == 0) { ?>
            V9.23<b> YÖNETİCİ </b>PANELİ</span>
            <?php } else { ?>
            V9.23<b> EMLAK </b>| <small>BANA ÖZEL</small></span>
            <?php } ?>			
    </a>		
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
				
		<a style="margin:22px 24px;" class="btn btn-success btn-xs hidden-lg hidden-md hidden-sm" target="_blank" href="/index.php"><i class="fa fa-eye"></i> Siteye Git</a>
		
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="hidden">
                    <a href="<?php echo URL?>" target="_blank"> <i class="fa fa-camera-retro"></i> Videolu Eğitim Merkezi </a>
                </li>
                <?php if ($kullanici["yetki"] == 0) { ?>
                <li class="dropdown">

                    <a href="index.php?do=bildirimler" class="dropdown-toggle" data-toggle="dropdown">

                        <span class="bildirim-top">
                            
                            <i class="fa fa-bell"></i> Bildirimler
                            
                            <span class="caret"></span>
                        
                        </span>
                        
                    </a>
                    <?php if ($toplam>0) { ?>
                    <span class="bildirim blink"><?=$toplam;?></span>
                    <?php } ?>

                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>&tab_goster=mesajlari">
                                <span class="badge <?php if (gelen_mesaj($_SESSION["id"])>0) {?>blink<?php } ?>"><?php echo gelen_mesaj($_SESSION["id"]); ?></span> Üye Gelen Mesajlar 
							</a>
                        </li>
                        <li>
                            <a href="index.php?do=bildirim/gelenmesaj">
                                <span class="badge <?php if ($gelenmesaj[0]>0) {?>blink<?php } ?>"> <?=$gelenmesaj[0];?> </span> Gelen Mesajlar </a>
                        </li>
                        <li>
                            <a href="index.php?do=bildirim/emlaktalep">
                                <span class="badge <?php if ($emlaktalep[0]>0) {?>blink<?php } ?>"> <?=$emlaktalep[0];?> </span> Emlak Talep Formları </a>
                        </li>
                        <li>
                            <a href="index.php?do=islem&emlak=emlak_ilanlar&uyeonay=onaybekleyen">
                                <span class="badge <?php if ($emlakonay[0]>0) {?>blink<?php } ?>"> <?=$emlakonay[0];?> </span> Onay Bekleyen İlanlar </a>
                        </li>
						<hr>
						<li>
							<a href="index.php?do=siparisler/siparisler&tip=doping">
								<i class="fa fa-angle-right"></i> Doping Siparişleri
								<?php if ($doping_onay_say[0]>0) { ?>
								<span class="bildirim-absolute blink"><?php echo $doping_onay_say[0]; ?></span>
								<?php } ?>
							</a>
						</li>
						<li>
							<a href="index.php?do=siparisler/siparisler&tip=magaza">
								<i class="fa fa-angle-right"></i> Üyelik Paketi Siparişleri
								<?php if ($magaza_onay_say[0]>0) { ?>
								<span class="bildirim-absolute blink"><?php echo $magaza_onay_say[0]; ?></span>
								<?php } ?>
							</a>
						</li>
                    </ul>
                </li>
                <li class="dropdown hidden-md hidden-sm">
                    <a href="index.php?do=sitearaclari" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-globe"></i> Webmaster
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu"> 
                        <li>
                            <a href="index.php?do=islem&webmaster=uyelik_sozlesmesi">
                                <i class="fa fa-angle-right"></i> Üyelik Sözleşmesi / Gizlilik </a>
                        </li>
                        <li>
                            <a href="index.php?do=islem&webmaster=analyticsapi">
                                <i class="fa fa-angle-right"></i> Google Analytics </a>
                        </li>
                        <li>
                            <a href="index.php?do=islem&webmaster=yandex">
                                <i class="fa fa-angle-right"></i> Yandex Metrica </a>
                        </li>
                        <li>
                            <a href="index.php?do=islem&webmaster=canlidestek">
                                <i class="fa fa-angle-right"></i> Canlı Destek </a>
                        </li>
                        <li>                            
                            <a href="index.php?do=islem&webmaster=dogrulama">
                                <i class="fa fa-angle-right"></i> Doğrulama Araçları </a>
                        </li>
                        <li>
                            <a href="index.php?do=islem&webmaster=metakod">                            
                                <i class="fa fa-angle-right"></i> Meta Kodu Ekleyici </a>
                        </li>
                        <li>
                            <a href="index.php?do=islem&webmaster=jscript">                            
                                <i class="fa fa-angle-right"></i> Javascript Kodu Ekleyici </a>
                        </li> 
                    </ul>
                </li>
                <li class="dropdown hidden-md hidden-sm">
                    <a href="index.php?do=sitearaclari" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fal fa-palette" style="margin-right:4px"></i> Tasarım Ayarları
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">  
                        <li>
                            <a href="index.php?do=ayar/anavitrinayar">
                                <i class="fa fa-angle-right"></i> Anasayfa Modül Ayarları </a>
                        </li>
                        <li>
                            <a href="index.php?do=ayar/popupayar">
                                <i class="fa fa-angle-right"></i> Pop-Up Ayarları </a>
                        </li>
                        <li> <a href="index.php?do=ayar/sitelogo"> <i class="fa fa-angle-right"></i> Site Logo </a> </li> 
                        <li> <a href="index.php?do=ayar/mobilsitelogo"> <i class="fa fa-angle-right"></i> Mobil Site Logo </a> </li>
                        <li> <a href="index.php?do=ayar/favicon"> <i class="fa fa-angle-right"></i> Favicon </a> </li>
                        <li> <a href="index.php?do=ayar/watermark"> <i class="fa fa-angle-right"></i> Filigran / Watermark </a> </li>
                        <li>
                            <a href="index.php?do=islem&icerik=ustmenu&islem=liste">
                                <i class="fa fa-angle-right"></i> Üst Menü </a>
                        </li>
                        <li>
                            <a href="index.php?do=islem&icerik=altmenu&islem=liste">
                                <i class="fa fa-angle-right"></i> Footer / Alt Menü </a>
                        </li>
                        <li>
                            <a href="index.php?do=icerik/slider">
                                <i class="fa fa-angle-right"></i> Slider Vitrin / Banner
                            </a>
                        </li>
                        <li>
                            <a href="index.php?do=ayar/temaayar">
                                <i class="fa fa-angle-right"></i> Temalar </a>
                        </li>
                        <li>
                            <a href="index.php?do=reklam/reklam_alanlari">
                                <i class="fa fa-angle-right"></i> Reklam Kodu Yönetimi </a>
                        </li>
                        <li>                            
                            <a href="index.php?do=ayar/ana_ikon_box">
                                <i class="fa fa-angle-right"></i> Anasayfa Icon Box </a>
                        </li> 
                    </ul>
                </li>
				<li class="dropdown hidden-md hidden-sm">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-cog"></i> Genel Ayarlar
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li> <a href="index.php?do=ayarsite"> <i class="fa fa-edit"></i> Site Ayarları </a> </li> 
                        <li> <a href="index.php?do=ayar/iletisim"> <i class="fa fa-envelope"></i> İletişim Bilgileri </a> </li>
                        <li> <a href="index.php?do=ayar/haritaadres"> <i class="fa fa-map-marker"></i> Harita/Lokasyon İşaretle </a> </li>
                        <li> <a href="index.php?do=ayar/ayar_sosyal"> <i class="fa fa-share-alt"></i> Sosyal Medya Siteleri </a> </li>
                        <li> <a href="index.php?do=ayar/paytr_api"> <i class="fa fa-credit-card"></i> PayTR Api </a> </li>
                        <li> <a href="index.php?do=ayar/mailayar"> <i class="fa fa-envelope-o"></i> SMTP Mail Yapılandırması </a> </li>
                        <li> <a href="index.php?do=ayar/smsayar"> <i class="fa fa-commenting-o"></i> SMS Entegrasyonu </a> </li>
                        <!-- <li> <a href=""> <i class="fa fa-plug"></i> Modül Ayarları </a> </li> -->
                        <!-- <li> <a href=""> <i class="fa fa-language"></i> Yabancı Dil Yönetimi </a> </li> -->
                    </ul>
                </li> 
                <?php } ?>
				<li class="hidden-xs">
					<a href="<?php echo URL?>" target="_blank"> <i class="fa fa-eye"></i> Siteye Git </a>
				</li>
            </ul>
        </div> 
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav"> 
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php 
                            $stmt_yoneticibilgi = $vt->prepare("SELECT * FROM yonetici WHERE id = ?");
                            $stmt_yoneticibilgi->execute([$_SESSION['id']]);
                            $yoneticibilgi = $stmt_yoneticibilgi;
                            $yoneticiver = $yoneticibilgi->fetch();
                        ?>
                        <?php if ($yoneticiver["resim"] == "") { ?>
                            <img src="/uploads/resim/resim.png" class="user-image" alt="<?=$yoneticiver["adsoyad"];?>">
                        <?php } else { ?>
                         <img src="/<?=$yoneticiver["resim"];?>" class="user-image" alt="<?=$yoneticiver["adsoyad"];?>">
                        <?php } ?>
                        <span class="hidden-xs">Hoşgeldiniz,</span><span> <?=$yoneticiver['adsoyad'];?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?php if ($yoneticiver["resim"] == "") { ?>
                                <img src="/uploads/resim/resim.png" class="img-circle" alt="<?=$yoneticiver["adsoyad"];?>">
                            <?php } else { ?>
                             <img src="/<?=$yoneticiver["resim"];?>" class="img-circle" alt="<?=$yoneticiver["adsoyad"];?>">
                            <?php } ?>
                            <p>
                                <?=$yoneticiver["adsoyad"];?>
                                <small><?=$yoneticiver["unvan"];?></small>
                            </p>
                        </li> 
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?=$_SESSION['id'];?>" class="btn btn-default btn-flat">Profil Güncelle</a>
                            </div>
                            <div class="pull-right">
                                <a href="index.php?do=cikis" class="btn btn-default btn-flat"> Çıkış </a>
                            </div>
                        </li>
                    </ul>
                </li> 
            </ul>
        </div>
        <div class="pull-right hidden-sm hidden-xs">
            <ul class="nav navbar-nav">
                <!-- <li><a href="index.php?do=islem&emlak=emlak_ekle&islem=sec"><i class="fa fa-plus"></i> Yeni İlan Ekle</a></li> -->
                <li><a href="index.php?do=islem&ofis=yonetici&islem=liste&sifre=sifre&id=<?=$_SESSION['id'];?>"><i class="fa fa-key"></i> Şifre Değiştir</a></li>
                <li><a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?=$_SESSION['id'];?>"><i class="fa fa-cog"></i> Hesap Ayarları</a></li>
                <li><a href="index.php?do=cikis"><i class="fa fa-sign-out"></i> Çıkış </a></li>
            </ul>
        </div>
    </nav>
</header>
