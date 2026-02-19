<?php

    echo !defined("ADMIN") ? die ("Güvenlik Duvarı...") : null;
	
	uyeYasak(yetki());

    $emlak             = @$_GET["emlak"];
    $ofis              = @$_GET["ofis"];
    $do                = @$_GET["do"];
    $ayarlar           = @$_GET["ayarlar"];
    $uyeler            = @$_GET["uyeler"];
    $uyeekle           = @$_GET["uyeekle"];
    $icerik            = @$_GET["icerik"];
    $webmaster         = @$_GET["webmaster"];
    $ofistip           = @$_GET["ofistip"];
    $uyetip            = @$_GET["uyetip"];
    $yetki             = @$_GET["yetki"];
    $sifre             = @$_GET["sifre"];
    $uyelikayar        = @$_GET["uyelikayar"];
    $uye               = @$_GET["uye"];
    $reklam            = @$_GET["reklam"];
    $magaza            = @$_GET["magaza"];

 ?>

 <?php if ($kullanici["yetki"] != 0) { ?>
 <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="">
                <a href="<?php echo $ayar["site_yonetim_url"] ?>">
                    <i class="fa fa-home"></i>
                    <span> Panel Anasayfa </span>
                </a>
            </li>

            <li class="menu-open aktif">
                <a href="#">
                    <i class="fa fa-list"></i>
                    <span> İlanlar </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if ($emlak == "emlak_ilanlar") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=emlak_ilanlar">
                            <i class="fa fa-stop"></i> Tüm İlanlar <span class="label pull-right"><?=$ilan[0];?></span></a>
                    </li>
                    <li class=" <?php if ($emlak == "emlak_ekle") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=emlak_ekle&islem=sec">
                            <i class="fa fa-plus"></i> Yeni İlan Ekle</a>
                    </li>
                    <li class=" <?php if ($emlak == "kategori" || $emlak == "kategori_ekle" || $emlak == "kategori_duzenle") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=emlak_ilanlar&uyeonay=yayindaolmayan">
                            <i class="fa fa-clock-o" <?php if ($pasifsay[0]>0) {echo 'style="color:red;"';} ?>></i> Taslaklar <span class="label pull-right"><?=$pasifsay[0];?></span></a>
                    </li>
                    <li class=" <?php if ($emlak == "kategori" || $emlak == "kategori_ekle" || $emlak == "kategori_duzenle") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=emlak_ilanlar&uyeonay=onaybekleyen">
                            <i class="fa fa-refresh" <?php if ($onaysay[0]>0) {echo 'style="color:red;"';} ?>></i> Onay Bekleyen <span class="label pull-right"><?=$onaysay[0];?></span></a>
                    </li>
                </ul>
            </li>

            <?php if ($kullanici["yetki"] == 2) { ?>
            <li class="menu-open aktif">
                <a href="#">
                    <i class="fa fa-list"></i>
                    <span> Emlak Ofisim </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class=" <?php if ($ofis == "subeekle") { echo "aktifAlt";}?>">
                        <a href="/ofisim" target="_blank">
                            <i class="fa fa-angle-right"></i> Emlak Ofisim </a>
                    </li>
                </ul>
            </li>
            <li class="menu-open aktif">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span> Danışmanlar </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" style="<?php if ($ofistip == "ofis") {echo "display:none;";}?>">
                    <li>
                        <a href="/danismanlar/<?=$_SESSION["id"];?>" target="_blank">
                            <i class="fa fa-angle-right"></i> Danışmanlar </a>
                    </li>
                    <li> <!-- class=" <?php if ($ofis == "yoneticiekle") { echo "aktifAlt";}?>" -->
                        <a href="/index.php?do=hesabim&s=danismanlar&ayar=yeni-danisman-ekle" target="_blank">
                            <i class="fa fa-plus"></i> Danışman / Yeni Ekle </a>
                    </li>

                    <li> <!-- class=" <?php if ($ofis == "yoneticiekle") { echo "aktifAlt";}?>" -->
                        <a href="/danisman-ilanlari" target="_blank">
                            <i class="fa fa-plus"></i> Danışman İlanları </a>
                    </li>
                </ul>
            </li>
            <?php } ?>
            <li class="menu-open aktif">
                <a href="#">
                    <i class="fa fa-bell"></i>
                    <span> Bildirim ve Mesajlar </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="/index.php?do=hesabim&s=bildirim&ayar=gelenmesaj" target="_blank">
                            <i class="fa fa-angle-right"></i> Gelen Mesajlar </a>
                    </li>
                    <li>
                        <a href="/index.php?do=hesabim&s=bildirim&ayar=danismanmesaj" target="_blank">
                            <i class="fa fa-angle-right"></i> Danışman Mesajları </a>
                    </li>
                    <?php if ($kullanici["yetki"] == 2) { ?>
                    <li>
                        <a href="/index.php?do=hesabim&s=bildirim&ayar=ofisgelenmesaj" target="_blank">
                            <i class="fa fa-angle-right"></i> Ofis Mesajları </a>
                    </li>
                    <?php } ?>
                    <li>
                        <a href="/index.php?do=hesabim&s=bildirim&ayar=ilanmesaj" target="_blank">
                            <i class="fa fa-angle-right"></i> İlan Mesajları </a>
                    </li>
                </ul>
            </li>
            <li class="menu-open aktif">
                <a href="#">
                    <i class="fa fa-cog"></i>
                    <span> Üyeliğim </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?=$_SESSION['id'];?>&uyelikayar=duzenle">
                            <i class="fa fa-angle-right"></i> Üyelik Ayarları </a>
                    </li>
                    <li>
                        <a href="index.php?do=islem&ofis=yonetici&islem=liste&sifre=sifre&id=<?=$_SESSION['id'];?>&uyelikayar=duzenle">
                            <i class="fa fa-angle-right"></i> Şifre Değiştir </a>
                    </li>
                    <li>
                        <a href="index.php?do=cikis">
                            <i class="fa fa-angle-right"></i> Çıkış Yap </a>
                    </li>
                </ul>
            </li>
        </ul>
    </section>
</aside>
 <?php } ?>
 <?php if ($kullanici["yetki"] == 0) { ?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="">
                <a href="<?php echo $ayar["site_yonetim_url"] ?>">
                    <i class="fa fa-dashboard"></i>
                    <span> Anasayfa </span>
                </a>
            </li>
            <li>
                <a>
                    <i class="fa fa-cogs"></i>
                    <span> Ayarlar </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="index.php?do=ayarsite"><i class="fa fa-edit"></i> Site Ayarları </a></li>
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

            <li>
                <a>
                    <i class="fa fa-edit"></i>
                    <span> İlanlar </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    <?php if ($onaysay[0]>0) { ?>
                    <span class="bildirim blink"><?php echo $onaysay[0]; ?></span>
                    <?php } ?>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if ($emlak == "emlak_ilanlar") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=emlak_ilanlar">
                            <i class="fa fa-stop"></i> Tüm İlanlar <span class="label pull-right"><?=$ilan[0];?></span></a>
                    </li>
                    <li class=" <?php if ($emlak == "emlak_ekle") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=emlak_ekle&islem=sec">
                            <i class="fa fa-plus"></i> Yeni İlan Ekle</a>
                    </li>
                    <li class=" <?php if ($emlak == "kategori" || $emlak == "kategori_ekle" || $emlak == "kategori_duzenle") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=kategori">
                            <i class="fa fa-angle-right"></i> Kategoriler <span class="label pull-right"><?=$kat[0];?></span></a>
                    </li>
 
                    <li class=" <?php if ($emlak == "kategori" || $emlak == "kategori_ekle" || $emlak == "kategori_duzenle") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=emlak_ilanlar&uyeonay=yayindaolmayan">
                            <i class="fa fa-clock-o"></i> Taslaklar <span class="label pull-right"><?=$pasifsay[0];?></span></a>
                    </li>
                    <li class=" <?php if ($emlak == "kategori" || $emlak == "kategori_ekle" || $emlak == "kategori_duzenle") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=emlak_ilanlar&uyeonay=onaybekleyen">
                            <i class="fa fa-refresh" <?php if ($onaysay[0]>0) {echo 'style="color:red;"';} ?>></i> Onay Bekleyen <span class="label pull-right"><?=$onaysay[0];?></span></a>
                    </li>
                </ul>
            </li>
            <li>
                <a>
                    <i class="fa fa-cog"></i>
                    <span> Yapılandır </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class=" <?php if ($emlak == "emlak_form") { echo "aktifAlt";}?>">
                        <a href="index.php?do=emlak/emlak_form">
                            <i class="fa fa-angle-right"></i> İlan Formları </a>
                    </li>
                    <li class=" <?php if ($emlak == "emlak_ozelliktip") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=emlak_ozelliktip">
                            <i class="fa fa-angle-right"></i> İlan Özellik Tipleri </a>
                    </li>
                    <li class=" <?php if ($emlak == "emlak_ozellikleri") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=emlak_ozellikleri">
                            <i class="fa fa-angle-right"></i> İlan Özellikleri </a>
                    </li>
                    <li class=" <?php if ($emlak == "emlak_ilantipi") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=emlak_ilantipi">
                            <i class="fa fa-angle-right"></i> İlan Tipi Yönetimi </a>
                    </li>
                    <li class=" <?php if ($emlak == "emlak_ilansekli") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=emlak_ilansekli">
                            <i class="fa fa-angle-right"></i> İlan Şekilleri </a>
                    </li> 
                    <li class=" <?php if ($emlak == "emlak_sahibi") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=emlak_sahibi">
                            <i class="fa fa-angle-right"></i> Emlak Sahibi
                        </a>
                    </li> 
                </ul>
            </li>
            <li class="hidden">
                <a>
                    <i class="fa fa-desktop"></i>
                    <span> Vitrin </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if ($emlak == "emlak_anavitrin") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=emlak_anavitrin">
                            <i class="fa fa-star"></i> Anasayfa Vitrini <span class="label pull-right"><?=$avitrin[0];?></span></a>
                    </li>
                    <li class="<?php if ($emlak == "emlak_firsatvitrin") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=emlak_firsatvitrin">
                            <i class="fa fa-bolt"></i> Fırsat Vitrini <span class="label pull-right"><?=$fvitrin[0];?></span></a>
                    </li>
                    <li class="<?php if ($emlak == "emlak_acilvitrin") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=emlak_acilvitrin">
                            <i class="fa fa-bell-o"></i> Acil İlanlar <span class="label pull-right"><?=$acilv[0];?></span></a>
                    </li>
                    <li class="<?php if ($emlak == "emlak_onecikan") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=emlak_onecikan">
                            <i class="fa fa-arrow-up"></i> Öne Çıkan İlanlar <span class="label pull-right"><?=$ovitrin[0];?></span></a>
                    </li>
                </ul>
            </li>
            <li>
                <a>
                    <i class="fa fa-shopping-basket"></i>
                    <span> Kurumsal </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="index.php?do=islem&ofis=subeler">
                            <i class="fa fa-angle-right"></i> Tüm Mağazalar </a>
                    </li>
                    <li>
                        <a href="index.php?do=islem&magaza=magaza_paketleri">
                            <i class="fa fa-angle-right"></i> Üyelik Paketleri </a>
                    </li>
                    <li>
                        <a href="index.php?do=islem&magaza=magaza_paketleri&islem=ekle">
                            <i class="fa fa-angle-right"></i> Paket Ekle </a>
                    </li>
                </ul>
            </li>
            <li>
                <a>
                    <i class="fa fa-rocket"></i>
                    <span> Doping </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                      <a href="index.php?do=siparisler/siparisler&tip=doping">
                        <i class="fa fa-angle-right"></i> Dopingli İlanlar
                      </a>
                    </li>
                    <li>
                        <a href="index.php?do=doping/doping_ayarlari">
                            <i class="fa fa-angle-right"></i> Doping Ayarları </a>
                    </li>
                </ul>
            </li>
            <li>
                <a>
                    <i class="fa fa-try"></i>
                    <span> Satışlar </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    <?php 

                        $kiralik_say = $vt->query("SELECT COUNT(*) FROM siparis_oda where siparis_onay = ''");
                        $kiralik_say = $kiralik_say->fetch();

                        $doping_say = $vt->query("SELECT COUNT(*) FROM emlak_ilan where doping_onay = 0 AND doping = 'var'");
                        $doping_onay_say = $doping_say->fetch();

                        $magaza_say = $vt->query("SELECT COUNT(*) FROM magaza_uye_paket where onay = 0");
                        $magaza_onay_say = $magaza_say->fetch();

                        $toplam = $kiralik_say[0] + $doping_onay_say[0] + $magaza_onay_say[0];

                    ?>
                    <?php if ($toplam>0) { ?>
                    <span class="bildirim blink"><?php echo $toplam; ?></span>
                    <?php } ?>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="index.php?do=siparisler/siparis_daire_kirala">
                            <i class="fa fa-angle-right"></i> Daire Kiralama Siparişleri 
                            <?php if ($kiralik_say[0]>0) { ?>
                            <span class="bildirim-absolute blink"><?php echo $kiralik_say[0]; ?></span>
                            <?php } ?> 
                        </a>
                    </li>
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
            <li>
                <a>
                    <i class="fa fa-user-circle-o"></i>
                    <span> Üyeler </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" style="<?php if ($ofistip == "ofis") {echo "display:none;";}?>">
                    <li>
                       <a href="index.php?do=islem&ofis=yonetici&islem=liste">
                            <i class="fa fa-angle-right"></i>
                            <span> Üye Listesi </span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?do=uyeler/uye_standart_ayar">
                            <i class="fa fa-angle-right"></i> Standart Ayarlar </a>
                    </li>
                    <li>
                        <a href="index.php?do=islem&ofis=yoneticiunvan&islem=liste">
                            <i class="fa fa-angle-right"></i> Ünvanlar </a>
                    </li>
                </ul>
            </li>
            <li>
                <a>
                    <i class="fa fa-users"></i>
                    <span> Yöneticiler </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" style="<?php if ($ofistip == "ofis") {echo "display:none;";}?>">
                    <li>
                       <a href="index.php?do=islem&ofis=yonetici&islem=liste&uye=yonetici">
                            <i class="fa fa-television"></i>
                            <span> Site Yöneticileri </span>
                        </a>
                    </li>
                    <li> <!-- class=" <?php if ($ofis == "yoneticiekle") { echo "aktifAlt";}?>" -->
                        <a href="index.php?do=islem&ofis=yonetici&islem=ekle&uyeekle=yonetici">
                            <i class="fa fa-plus"></i> Yeni Yönetici Ekle </a>
                    </li>
                    <!--
                    <li> class=" <?php if ($ofis == "yoneticiekle") { echo "aktifAlt";}?>" 
                        <a href="index.php?do=islem&ofis=yonetici&islem=yetkiler">
                            <i class="fa fa-times-circle"></i> Yönetici Yetkileri </a>
                    </li>
                    -->
                </ul>
            </li>

            <li>
                <a>
                    <i class="fa fa-copy"></i>
                    <span> Tasarım </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
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

            <li>
                <a>
                    <i class="fa fa-puzzle-piece"></i>
                    <span> İçerikler </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="index.php?do=islem&icerik=sayfa&islem=liste">
                            <i class="fa fa-angle-right"></i> Sayfalar 
                        </a>
                    </li> 
                    <li>
                        <a href="index.php?do=islem&icerik=sayfakategori&islem=liste">
                            <i class="fa fa-angle-right"></i> Sayfa Kategorileri 
                        </a>
                    </li>
                    <li>
                        <a href="index.php?do=islem&icerik=haber&islem=liste">
                            <i class="fa fa-angle-right"></i> Haberler 
                        </a>
                    </li> 
                    <li>
                        <a href="index.php?do=islem&icerik=haberkategori&islem=liste">
                            <i class="fa fa-angle-right"></i> Haber Kategorileri 
                        </a>
                    </li> 
                    <li>
                        <a href="index.php?do=islem&icerik=blog&islem=liste">
                            <i class="fa fa-angle-right"></i> Bloglar 
                        </a>
                    </li> 
                    <li>
                        <a href="index.php?do=islem&icerik=blogkategori&islem=liste">
                            <i class="fa fa-angle-right"></i> Blog Kategorileri 
                        </a>
                    </li>
                </ul>
            </li>
 
            <li>

                <?php 

                    $emlakmesajver = $vt->query("SELECT COUNT(*) FROM emlak_mesaj where onay = 0");
                    $emlakmesaj = $emlakmesajver->fetch();

                    $gelenmesajver = $vt->query("SELECT COUNT(*) FROM emlak_mesajiletisim where onay = 0");
                    $gelenmesaj = $gelenmesajver->fetch();

                    $emlaktalepver = $vt->query("SELECT COUNT(*) FROM emlak_mesajemlaktalep where onay = 0");
                    $emlaktalep = $emlaktalepver->fetch();

                    $emlakonay = $vt->query("SELECT COUNT(*) FROM emlak_ilan where onay = 0")->fetch();

                    $toplam_mesaj = $emlakmesaj[0] + $gelenmesaj[0] + $emlaktalep[0] + gelen_mesaj($_SESSION["id"]); 

                ?>

                <a>
                    <i class="fa fa-bell"></i>
                    <span> Mesajlar </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    <?php if ($toplam_mesaj>0) { ?>
                    <span class="bildirim blink"><?php echo $toplam_mesaj; ?></span>
                    <?php } ?>
                </a>
                <ul class="treeview-menu">

                    <li>
                        <a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>&tab_goster=mesajlari">
                            <i class="fa fa-angle-right"></i> Üye Gelen Mesaj
                            <?php if (gelen_mesaj($_SESSION["id"])>0) { ?>
                            <span class="bildirim-absolute blink"><?php echo gelen_mesaj($_SESSION["id"]); ?></span>
                            <?php } ?>
                        </a>
                    </li>

                    <li>
                        <a href="index.php?do=bildirim/gelenmesaj">
                            <i class="fa fa-angle-right"></i> Gelen Mesajlar
                            <?php if ($gelenmesaj[0]>0) { ?>
                            <span class="bildirim-absolute blink"><?php echo $gelenmesaj[0]; ?></span>
                            <?php } ?>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?do=bildirim/emlaktalep">
                            <i class="fa fa-angle-right"></i> Emlak Talep Formları
                            <?php if ($emlaktalep[0]>0) { ?>
                            <span class="bildirim-absolute blink"><?php echo $emlaktalep[0]; ?></span>
                            <?php } ?>
                        </a>
                    </li> 
                </ul>
            </li>
            <li>
                <a>
                    <i class="fa fa-map-marker"></i>
                    <span> Şehirler </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu"> 
                    <li class="<?php if ($emlak == "iller" || $emlak == "ilyonet") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=iller">
                            <i class="fa fa-angle-right"></i> Şehir Yönetimi
                        </a>
                    </li>
                    <li class="<?php if ($emlak == "ilceler" || $emlak == "ilceyonet") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=ilceler">
                            <i class="fa fa-angle-right"></i> İlçe Yönetimi
                        </a>
                    </li>
                    <li class="<?php if ($emlak == "mahallebul") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=mahallebul">
                            <i class="fa fa-angle-right"></i> Semt/Mahalle Yönetimi
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a>
                    <i class="fa fa-code"></i>
                    <span> Webmaster </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
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
                            <i class="fa fa-angle-right"></i> Site Doğrulama </a>
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

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
<?php } ?>
