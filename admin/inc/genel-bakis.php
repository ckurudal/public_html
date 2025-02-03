<?php echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; ?>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <?php $tum_ilanlar = $vt->query("SELECT * FROM emlak_ilan WHERE durum = 0 AND onay = 1")->fetchAll() ?>
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?php echo count($tum_ilanlar) ?></h3>

                    <p>Toplam İlan</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="index.php?do=islem&emlak=emlak_ekle&islem=sec" class="small-box-footer">İlan Oluştur <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <?php 
                $ilan_sekilleri = $vt->query("SELECT * FROM emlak_ilansekli WHERE durum 0 AND kat_tipi = 'proje'");
                $proje_ilanlari = $vt->query("SELECT * FROM emlak_ilan WHERE durum = 0 AND onay = 1 AND ilansekli = '".$ilan_sekilleri["id"]."'");
            ?>
            <div class="small-box bg-white">
                <div class="inner">
                    <h3><?php echo count($proje_ilanlari) ?></h3>

                    <p>İnşaat Projesi</p>
                </div>
                <div class="icon">
                    <i class="fa fa-arrows"></i>
                </div>
                <a href="index.php?do=islem&emlak=emlak_ekle&islem=sec" class="small-box-footer">Yeni Proje Oluştur <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <?php $dopingli_ilanlar = $vt->query("SELECT * FROM emlak_ilan WHERE durum = 0 AND onay = 1 AND doping_onay = 1")->fetchAll() ?>
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3><?php echo count($dopingli_ilanlar) ?></h3>

                    <p>Dopingli İlan</p>
                </div>
                <div class="icon">
                    <i class="fa fa-rocket"></i>
                </div>
                <a href="index.php?do=siparisler/siparisler&tip=doping" class="small-box-footer">Dopingli İlanlar <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <?php $ofisler = $vt->query("SELECT * FROM subeler WHERE durum = 0")->fetchAll() ?>
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><?php echo count($ofisler) ?></h3>

                    <p>Emlak Ofisi</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="index.php?do=islem&ofis=yonetici&islem=ekle&uyeekle=kurumsal" class="small-box-footer">Emlak Ofisi Oluştur <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <?php $kurumsal_uyeler = $vt->query("SELECT * FROM yonetici WHERE durum = 0 AND yetki = '2'")->fetchAll() ?>
            <div class="small-box bg-white">
                <div class="inner">
                    <h3><?php echo count($kurumsal_uyeler) ?></h3>

                    <p>Kurumsal Üye</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="index.php?do=islem&ofis=yonetici&islem=ekle&uyeekle=kurumsal" class="small-box-footer">Kurumsal Üye Oluştur <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <?php $bireysel_uyeler = $vt->query("SELECT * FROM yonetici WHERE durum = 0 AND yetki = '1'")->fetchAll() ?>
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?php echo count($bireysel_uyeler) ?></h3>

                    <p>Bireysel Üye</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
                <a href="index.php?do=islem&ofis=yonetici&islem=ekle&uyeekle=bireysel" class="small-box-footer">Bireysel Üye Oluştur <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <?php $emlak_danismanlari = $vt->query("SELECT * FROM yonetici WHERE durum = 0 AND yetki = '3'")->fetchAll() ?>
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3><?php echo count($emlak_danismanlari) ?></h3>

                    <p>Emlak Danışmanı</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person"></i>
                </div>
                <a href="index.php?do=islem&ofis=yonetici&islem=ekle&uyeekle=danisman" class="small-box-footer">Danışman Oluştur <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <?php $uye_paketleri = $vt->query("SELECT * FROM magaza_paket")->fetchAll() ?>
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><?php echo count($uye_paketleri) ?></h3>

                    <p>Üyelik Paketi</p>
                </div>
                <div class="icon">
                    <i class="fa fa-th"></i>
                </div>
                <a href="index.php?do=islem&magaza=magaza_paketleri" class="small-box-footer">Yeni Paket Oluştur <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=islem&emlak=emlak_ekle&islem=sec">
                        <div class="text-center">

                            <br><p><i class="fa fa-plus fa-3x text-primary"></i></p><br>

                            <h6><strong>YENİ İLAN EKLE</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=islem&emlak=emlak_ekle&islem=sec">
                        <div class="text-center">

                            <br><p><i class="fa fa-plus-circle fa-3x text-primary"></i></p><br>

                            <h6><strong>PROJE EKLE</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=islem&emlak=emlak_ilanlar">
                        <div class="text-center">

                            <br><p><i class="fa fa-list fa-3x text-primary"></i></p><br>

                            <h6><strong>İLANLARIM</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=islem&emlak=emlak_ilanlar">
                        <div class="text-center">

                            <br><p><i class="fa fa-rocket fa-3x text-primary"></i></p><br>

                            <h6><strong>DOPİNG SATIN AL</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>&tab_goster=dopingleri">
                        <div class="text-center">

                            <br> <p><i class="fa fa-bullhorn fa-3x text-primary"></i></p><br>

                            <h6><strong>DOPİNGLERİM</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=siparisler/siparisler&paket=magaza">
                        <div class="text-center">

                            <br> <p><i class="fa fa-dropbox fa-3x text-primary"></i></p><br>

                            <h6><strong>PAKET SATIN AL</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>&tab_goster=magaza_paketleri">
                        <div class="text-center">

                            <br> <p><i class="fa fa-tags fa-3x text-primary"></i></p><br>

                            <h6><strong>PAKETLERİM</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>&tab_goster=mesajlari">
                        <div class="text-center">

                            <br> <p><i class="fa fa-envelope-open fa-3x text-primary"></i></p><br>

                            <h6><strong>MESAJLARIM</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>">
                        <div class="text-center">

                            <br> <p><i class="fa fa-user-circle fa-3x text-primary"></i></p><br>

                            <h6><strong>ÜYELİĞİM</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=ayar/paytr_api">
                        <div class="text-center">

                            <br> <p><i class="fa fa-credit-card fa-3x text-primary"></i></p><br>

                            <h6><strong>PAYTR AYARLARI	</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=ayar/smsayar">
                        <div class="text-center">

                            <br> <p><i class="fa fa-commenting-o fa-3x text-primary"></i></p><br>

                            <h6><strong>SMS AYARLARI</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=ayar/mailayar">
                        <div class="text-center">

                            <br> <p><i class="fa fa-inbox fa-3x text-primary"></i></p><br>

                            <h6><strong>MAİL AYARLARI</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=ayarsite">
                        <div class="text-center">

                            <br> <p><i class="fa fa-inbox fa-3x text-primary"></i></p><br>

                            <h6><strong>SİTE AYARLARI</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=doping/doping_ayarlari">
                        <div class="text-center">

                            <br> <p><i class="fa fa-rocket fa-3x text-primary"></i></p><br>

                            <h6><strong>DOPİNG AYARLARI</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=islem&magaza=magaza_paketleri">
                        <div class="text-center">

                            <br> <p><i class="fa fa-dropbox fa-3x text-primary"></i></p><br>

                            <h6><strong>ÜYELİK PAKETLERİ</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=uyeler/uye_standart_ayar">
                        <div class="text-center">

                            <br> <p><i class="fa fa-user-circle fa-3x text-primary"></i></p><br>

                            <h6><strong>LİMİT AYARLARI</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=ayar/ana_ikon_box">
                        <div class="text-center">

                            <br> <p><i class="fa fa-code fa-3x text-primary"></i></p><br>

                            <h6><strong>Anasayfa İkonları</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=ayar/anavitrinayar">
                        <div class="text-center">

                            <br> <p><i class="fa fa-code fa-3x text-primary"></i></p><br>

                            <h6><strong>Anasayfa Modülleri</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=ayarsite">
                        <div class="text-center">

                            <br> <p><i class="fa fa-filter fa-3x text-primary"></i></p><br>

                            <h6><strong>Limit Ayarları</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=islem&webmaster=uyelik_sozlesmesi">
                        <div class="text-center">

                            <br> <p><i class="fa fa-check fa-3x text-primary"></i></p><br>

                            <h6><strong>Üyelik Sözleşmesi / Gizlilik</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>