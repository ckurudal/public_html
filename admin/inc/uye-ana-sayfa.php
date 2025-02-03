<?php echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; ?>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-3 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=islem&emlak=emlak_ekle&islem=sec">
                        <div class="text-center">

                            <br><p><i class="fa fa-plus fa-3x text-success"></i></p><br>

                            <h6><strong>YENİ İLAN EKLE</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=islem&emlak=emlak_ilanlar">
                        <div class="text-center">

                            <br><p><i class="fa fa-list fa-3x text-success"></i></p><br>

                            <h6><strong>İLANLARIM</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=islem&emlak=emlak_ilanlar">
                        <div class="text-center">

                            <br><p><i class="fa fa-rocket fa-3x text-success"></i></p><br>

                            <h6><strong>DOPİNG SATIN AL</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>&tab_goster=dopingleri">
                        <div class="text-center">

                           <br> <p><i class="fa fa-bullhorn fa-3x text-success"></i></p><br>

                            <h6><strong>DOPİNGLERİM</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=siparisler/siparisler&paket=magaza">
                        <div class="text-center">

                           <br> <p><i class="fa fa-dropbox fa-3x text-success"></i></p><br>

                            <h6><strong>ÜYELİK PAKETİ SATIN AL</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>&tab_goster=magaza_paketleri">
                        <div class="text-center">

                           <br> <p><i class="fa fa-tags fa-3x text-success"></i></p><br>

                            <h6><strong>ÜYELİK PAKETLERİM</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>&tab_goster=mesajlari">
                        <div class="text-center">

                           <br> <p><i class="fa fa-envelope-open fa-3x text-success"></i></p><br>

                            <h6><strong>MESAJLARIM</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 text-center">
            <div class="box">
                <div class="box-body">
                    <a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>">
                        <div class="text-center">

                           <br> <p><i class="fa fa-user-circle fa-3x text-success"></i></p><br>

                            <h6><strong>ÜYELİĞİM</strong></h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

</section>

