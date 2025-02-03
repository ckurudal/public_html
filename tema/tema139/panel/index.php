<?php if ($_SESSION["uyelogin"]) header('location:index.php'); ?>
<?php $islem = $_GET["islem"]; ?>
<?php if ($islem == "girisyap" || $islem == "kurumsal-uyelik" || $islem == "bireysel-uyelik" || $islem == "uyelik-sec"): ?>

    <style>

        .bannerimg
        {
            display:none !important;
        }

        .horizontalMenu>.horizontalMenu-list>li>a
        {
            color:#333 !important;
        }

        .horizontal-main
        {
            background:#fff !important;
            bottom: inherit !important;
        }

        .horizontal-main:after
        {
            background:#fff!important;
        }

        desktoplogo-1
        {
            padding: 30px 0!important;
        }

        .footer-main
        {
            display:none;
        }
 


    </style>

<?php endif; ?>

<div class="content sptb mt-5 " style="padding-bottom:45px;">


    <div class="modal fade" id="uyelik_sozlesmesiLong" tabindex="-1" role="dialog" aria-labelledby="uyelik_sozlesmesiLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uyelik_sozlesmesiLongTitle">Üyelik Sözleşmesi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo $site["uyelik_sozlesmesi"]; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
            </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="gizlilikLong" tabindex="-1" role="dialog" aria-labelledby="gizlilikLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gizlilikLongTitle">Gizlilik Politikası</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo $site["gizlilik"]; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
            </div>
            </div>
        </div>
    </div>

    <div id="con" class=" ">
        <?php
        $islem = $_GET["islem"];
        $hareket = $_GET["hareket"];
        ?>
        <?php if ($islem == "") { include("panel.php"); } ?>
        <?php if ($islem == "odeme_ayarlari") { include("odeme_ayarlari.php"); } ?>
        <?php if ($islem == "magaza_paketleri") { include("magaza_paketleri.php"); } ?>
        <?php if ($islem == "magaza_paketim") { include("magaza_paketim.php"); } ?>
        <?php if ($islem == "dopinglerim") { include("dopinglerim.php"); } ?>
        <?php if ($islem == "girisyap") { ?>

            <div class="row">

                <div class="col-md-6 mb-5">
                    <div class="card p-5" >
                        <div class="card-body">
                            <h2>
                                <strong>Giriş Yap</strong>
                            </h2>
                            <br>
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
                                    <h6 class="alert alert-success"><i class="fa fa-check fa-lg"></i> Üyelik kaydı başarılı. Lütfen giriş yapınız.</h6>
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
                                    <div class="row">
                                        <div class="col-6">
                                            <a href="uyelik-sec">Üyelik Oluştur</a>
                                        </div>
                                        <div class="col-6 text-right">
                                            <a href="<?php echo $ayar["site_yonetim_url"] ?>giris.php?islem=sifre">Şifremi Unuttum</a>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-block btn-lg p-4" name="uyegirisi"><strong>GİRİŞ</strong></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-5">
                        <div class="card-body">
                            <h2>
                                <strong>Üye Değil misiniz?</strong>
                            </h2>
                            <h5 class="mb-3 pb-3">Hemen üye ol, hayalindeki evi bulan binlerce kişiye katıl!</h5>
                            <form action="#">

                                <div class="mb-3">

                                    <div class="widgets-cards">
                                        <div class="d-flex">
                                            <div class="widgets-cards-icons">
                                                <div class="wrp icon-circle border"><i class="text-dark fa fa-image icons"></i></div>
                                            </div>
                                            <div class="widgets-cards-data">
                                                <div class="wrp text-wrapper">
                                                    <p>Ücretsiz ilan ver</p>
                                                    <p class="text-muted mt-1 mb-0">Uygun fiyata istediğin kadar ilan ver satışını gerçekleştir. Yeni üyeliklerde ücretsiz ilanlar ekleyebilirsiniz.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="mb-5">

                                    <div class="widgets-cards">
                                        <div class="d-flex">
                                            <div class="widgets-cards-icons">
                                                <div class="wrp icon-circle border"><i class="text-dark fa fa-edit icons"></i></div>
                                            </div>
                                            <div class="widgets-cards-data">
                                                <div class="wrp text-wrapper">
                                                    <p>İlanlarını düzenle ve yönet</p>
                                                    <p class="text-muted mt-1 mb-0">Profilinden tüm ilanlarını yönet istediğini yayınla, düzenle herşey senin elinde.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div> 

                                <h3><a href="uyelik-sec" class="btn btn-dark btn-block btn-lg p-4"><strong>ÜYE OL</strong></a></h3>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if ($islem == "uyelik-sec"): ?>

            <div class="row">

                <div class="col-md-6 mb-5">

                    <div class="card pt-7">
                        <div class="card-body">
                            <div class="service-card text-center">
                                <div class="border icon-bg icon-service text-dark"> <i class="fa fa-user-o"></i> </div>
                                <div class="servic-data mt-3">
                                    <br>
                                    <br>
                                    <br>

                                    <h2 class="font-weight-semibold mb-2">DANIŞMAN BAŞVURU</h2>

                                    <br>
                                    <h5>Gayrimenkul Danışmanı Olmak İstiyorum</h5>
                                    <br>
                                    <br>
                                    <br>

                                    <div class="row">
                                        <div class="offset-md-1 col-md-10">
                                            <a href="bireysel-uyelik" class="btn btn-outline-dark btn-block btn-lg p-3"><strong>ÜYE OL</strong></a>
                                        </div>
                                    </div>

                                    <br>
                                    <br>

                                    <span class="btn">Zaten üye misin? Hemen</span> |
                                    <a href="giris-yap" class="btn"><strong>Giriş Yap!</strong></a>

                                    <br>
                                    <br>
                                    <br>
                                    <br>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="card pt-7">
                        <div class="card-body">
                            <div class="service-card text-center">
                                <div class="border icon-bg icon-service text-dark"> <i class="fa fa-building-o"></i> </div>
                                <div class="servic-data mt-3">
                                    <br>
                                    <br>
                                    <br>

                                    <h2 class="font-weight-semibold mb-2">EMLAKBUDUR OFİSİ OLMAK İSTİYORUM</h2>
                                    <br>
                                    <h5>FRANCHISE BAŞVURU</h5>
                                    <br>
                                    <br>
                                    <br>

                                    <div class="row">
                                        <div class="offset-md-1 col-md-10">
                                            <a href="/kurumsal-uyelik" class="btn btn-outline-success btn-block btn-lg p-3"><strong>ÜYE OL</strong></a>
                                        </div>
                                    </div>

                                    <br>
                                    <br>

                                    <span class="btn">Zaten üye misin? Hemen</span> |
                                    <a href="giris-yap" class="btn"><strong>Giriş Yap!</strong></a>

                                    <br>
                                    <br>
                                    <br>
                                    <br>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        <?php endif; ?>

        <?php if ($islem == "bireysel-uyelik") { ?>
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <div class="card p-5">
                        <div class="card-body">
                            <h2>
                                <strong>Gayrimenkul Danışmanı Olun</strong>
                            </h2>

                            <h5>EmlakBudur Danışmanı Olmak İstiyorum.</h5>

                            <br>

                            <div class="text-center">

                                <div class="row">

                                    <div class="col-md-6">

                                        <a href="bireysel-uyelik" class="btn btn-block btn-dark btn-lg pb-4 pt-4 h5"><i class="fa fa-check-square-o"></i> <strong>EmlakBudur'lu Ol</strong> </a>

                                    </div>

                                    <div class="col-md-6">

                                        <a href="kurumsal-uyelik" class="btn btn-block btn-outline-success btn-lg pb-4 pt-4 h5"> <strong>Franchaise Başvurusu</strong> </a>

                                    </div>

                                </div>

                            </div>
                            <hr>
                            <?php
                            if (isset($_POST["bireyseluyelik"])) {

                                $email = $_POST["email"];
                                $pass = md5($_POST["pass"]);
                                $passtekrar = md5($_POST["passtekrar"]);
                                $adsoyad = $_POST["adsoyad"];
                                $seo = seo($_POST["adsoyad"]);
                                $tarih = date("d.m.Y");
                                $tel = $_POST["tel"];
                                $sozlesme = $_POST["sozlesme"];

                                $kontroluye = mysql_query("SELECT * FROM yonetici");
                                $uye = mysql_fetch_assoc($kontroluye);

                                ?>
                                <?php if (empty($email)) {

                                    hata_alert("E-posta adresi boş bırakılamaz. Lütfen bir e-posta giriniz.");

                                } else if (mysql_num_rows(mysql_query("SELECT * FROM yonetici where email = '$email'"))) {

                                    hata_alert("E-posta başka bir üye tarafından kullanılıyor. Lütfen farklı bir e-posta giriniz.");

                                } else if ($pass != $passtekrar) {

                                    hata_alert("Şifrelerin aynı olduğunda emin olunuz.");

                                } else if (mysql_num_rows(mysql_query("SELECT * FROM yonetici where tel = '$tel'"))) {

                                    hata_alert("Telefon kullanılıyor. Lütfen farklı bir telefon giriniz.");

                                } else {

                                    $bireyseluyelik = mysql_query("INSERT INTO yonetici (email,pass,adsoyad,seo,tel,yetki,tarih,eposta_bildirim,sms_bildirim) values ('$email','$pass','$adsoyad','$seo','$tel','1','$tarih','1','1')");

                                    if ($bireyseluyelik == true) {

                                        $konu = "Tebrikler ".$adsoyad.", bireysel üyeliğiniz başarılı bir şekilde oluşturulmuştur.";
                                        $mesaj = "Tebrikler ".$adsoyad.", bireysel üyeliğiniz başarılı bir şekilde oluşturulmuştur.<br><h3><strong>Üyelik Bilgileriniz:</strong></h3>E-posta: ".$email."<br> Şifre: ".$_POST["pass"]."";

                                        mail_gonder($email, $konu, $mesaj);

                                        go("index.php?do=hesabim&islem=girisyap&hareket=onay",0);

                                    }

                                }


                            }
                            ?>
                            <form action="" method="POST" class="form-horizontal">
                                <div class="form-group">
                                    <input class="input--style-4 input-lg" type="text" placeholder="Ad Soyad *" required="" name="adsoyad">
                                </div>
                                <div class="form-group">
                                    <input class="input--style-4 input-lg" type="text" placeholder="E-Posta *" required="" name="email">
                                </div>
                                <div class="form-group">
                                    <input class="input--style-4 input-lg mb-4" type="text" placeholder="Telefon * (0533 333 33 33)" required="" name="tel">
                                    <small><strong>NOT:</strong> Telefon numaranızı 0533 333 33 33 formatında yazmalısınız.</small>
                                </div>
                                <div class="form-group">
                                    <input class="input--style-4 input-lg" type="password" placeholder="Şifre *" required="" name="pass">
                                </div>
                                <div class="form-group">
                                    <input class="input--style-4 input-lg" type="password" placeholder="Şifre (Tekrar) *" required="" name="passtekrar">
                                </div>
                                <div class="form-group">
                                    <br>
                                    <label><input class="check-control" type="checkbox" value="" name="sozlesme" required=""><strong> <a href="#" data-toggle="modal" data-target="#uyelik_sozlesmesiLong">Üyelik sözleşmesi</a></strong> ve <strong> <a href="#" data-toggle="modal" data-target="#gizlilikLong">gizlilik politikası</a></strong>'nı Okudum ve Kabul Ediyorum.</label>
                                    <br>
                                </div>
                                <button name="bireyseluyelik" type="submit" class="btn btn-dark btn-block btn-lg p-4"><strong>Üye Ol</strong></button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-7">
                                    <span class="btn h5 btn-block p-4"> <strong>Zaten Üye Misiniz?</strong></span>
                                </div>
                                <div class="col-md-5">
                                    <a href="giris-yap" class="btn btn-lg btn-block btn-success p-3"> <strong>Giriş Yap</strong></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if ($islem == "kurumsal-uyelik") { ?>
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <div class="card p-5">
                        <div class="card-body">
                            <h2>
                                <strong>E/B Franchaise Başvuru</strong>
                            </h2>

                            <h5>Franchaise EmlakBudur Ofisi Açmak İstiyorum.</h5>

                            <br>

                            <div class="text-center">

                                <div class="row">

                                    <div class="col-md-6">

                                        <a href="bireysel-uyelik" class="btn btn-block btn-outline-dark btn-lg pb-4 pt-4 h5"> <strong>Bireysel Üye Ol</strong> </a>

                                    </div>

                                    <div class="col-md-6">

                                        <a href="kurumsal-uyelik" class="btn btn-block btn-success btn-lg pb-4 pt-4 h5"><i class="fa fa-check-square-o"></i> <strong>Kurumsal Üye Ol</strong> </a>

                                    </div>

                                </div>

                            </div>
                            <hr>
                            <?php
                            if (isset($_POST["kurumsaluyelik"])) {

                                $firmadi = $_POST["firmadi"];

                                $email = $_POST["email"];
                                $pass = md5($_POST["pass"]);
                                $passtekrar = md5($_POST["passtekrar"]);
                                $adsoyad = $_POST["adsoyad"];
                                $seo = seo($_POST["adsoyad"]);
                                $il = $_POST["il"];
                                $ilce = $_POST["ilce"];
                                $tel = $_POST["tel"];
                                $tarih = date("d.m.Y");
                                $sozlesme = $_POST["sozlesme"];

                                $kontroluye = mysql_query("SELECT * FROM yonetici");
                                $uye = mysql_fetch_assoc($kontroluye);

                                ?>

                                <?php if (empty($email)) {

                                    hata_alert("E-posta adresi boş bırakılamaz. Lütfen bir e-posta giriniz.");

                                } else if (mysql_num_rows(mysql_query("SELECT * FROM yonetici where email = '$email'"))) {

                                    hata_alert("E-posta başka bir üye tarafından kullanılıyor. Lütfen farklı bir e-posta giriniz.");

                                } else if ($pass != $passtekrar) {

                                    hata_alert("Şifrelerin aynı olduğunda emin olunuz.");

                                } else if (mysql_num_rows(mysql_query("SELECT * FROM yonetici where tel = '$tel'"))) {

                                    hata_alert("Telefon kullanılıyor. Lütfen farklı bir telefon giriniz.");

                                } else {

                                    $kurumsaluyelik = mysql_query("INSERT INTO yonetici (email,pass,adsoyad,seo,il,ilce,tel,yetki,tarih, eposta_bildirim, sms_bildirim) values ('$email','$pass','$adsoyad','$seo','$il','$ilce','$tel','2','$tarih','1','1')");

                                    $uyeson = mysql_query("SELECT * FROM yonetici order by id desc limit 1");
                                    $sayid = mysql_fetch_array($uyeson);

                                    $ofisekle = mysql_query("INSERT INTO subeler (adi,yetkiliuye) values ('$firmadi','".$sayid["id"]."')");

                                    $ofisliste = mysql_query("SELECT * FROM subeler order by id desc limit 1");
                                    $oliste = mysql_fetch_array($ofisliste);

                                    $ofis_uye_ata =  $vt->query("UPDATE yonetici SET ofis = '".$oliste["id"]."' WHERE id = '".$sayid["id"]."'");

                                    $sms_mesaj = "Tebrikler ".$adsoyad.", kurumsal üyeliğiniz başarılı bir şekilde oluşturulmuştur. Üyelik Bilgileriniz: ".$email." Şifre: ".$_POST["pass"]."";
                                    $mesaj = "Tebrikler ".$adsoyad.", kurumsal üyeliğiniz başarılı bir şekilde oluşturulmuştur.<br><h3><strong>Üyelik Bilgileriniz:</strong></h3>E-posta: ".$email."<br> Şifre: ".$_POST["pass"]."";

                                    uye_sms_gonder($tel, $sms_mesaj);

                                    mail_gonder($email, $sms_mesaj, $mesaj);

                                    echo $oliste["id"];

                                    go("index.php?do=hesabim&islem=girisyap&hareket=onay",0);

                                }


                            }
                            ?>
                            <form action="" method="POST" class="form-horizontal">
                                <div class="form-group">
                                    <input class="input--style-4 input-lg" type="text" placeholder="Firma Adı *" required="" name="firmadi">
                                </div>
                                <div class="form-group">
                                    <input class="input--style-4 input-lg" type="text" placeholder="Ad Soyad *" required="" name="adsoyad">
                                </div>
                                <div class="form-group">
                                    <div class="rs-select2 js-select-simple se lect--no-search">
                                        <select name="il" id="il" class="select2-hidden-accessible">
                                            <option selected="selected"> İl Seçiniz * </option>
                                            <?php
                                            $iller = mysql_query("select * from sehir order by sehir_key asc");
                                            while($il=mysql_fetch_array($iller)) {
                                                ?>
                                                <option value="<?=$il['sehir_key'];?>"> <?=$il['adi'];?> </option>
                                            <?php } ?>
                                        </select>
                                        <div class="select-dropdown"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="rs-select2 js-select-simple se lect--no-search">
                                                <select name="ilce" id="ilce" class="input--style-4 input-lg sel ect2">
                                                    <option selected="selected"> İlçe </option>
                                                </select>
                                                <div class="select-dropdown"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="rs-select2 js-select-simple se lect--no-search">
                                                <select name="mahalle" id="mahalle" class="input--style-4 input-lg sel ect2">
                                                    <option selected="selected"> Mahalle </option>
                                                </select>
                                                <div class="select-dropdown"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="input--style-4 input-lg mb-4" type="text" placeholder="Telefon * (0533 333 33 33)" required="" name="tel">
                                    <small><strong>NOT:</strong> Telefon numaranızı 0533 333 33 33 formatında yazmalısınız.</small>
                                </div>
                                <div class="form-group">
                                    <input class="input--style-4 input-lg" type="text" placeholder="E-Posta *" required="" name="email">
                                </div>
                                <div class="form-group">
                                    <input class="input--style-4 input-lg" type="password" placeholder="Şifre *" required="" name="pass">
                                </div>
                                <div class="form-group">
                                    <input class="input--style-4 input-lg" type="password" placeholder="Şifre (Tekrar) *" required="" name="passtekrar">
                                </div>
                                <div class="form-group">
                                    <br>
                                    <label><input class="check-control" type="checkbox" value="" name="sozlesme" required=""><strong> <a href="#" data-toggle="modal" data-target="#uyelik_sozlesmesiLong">Üyelik sözleşmesi</a></strong> ve <strong> <a href="#" data-toggle="modal" data-target="#gizlilikLong">gizlilik politikası</a></strong>'nı Okudum ve Kabul Ediyorum.</label>
                                    <br>
                                </div>
                                <button name="kurumsaluyelik" type="submit" class="btn btn-dark btn-block btn-lg p-4"><strong>Üye Ol</strong></button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-7">
                                    <span class="btn h5 btn-block p-4"> <strong>Zaten Üye Misiniz?</strong></span>
                                </div>
                                <div class="col-md-5">
                                    <a href="giris-yap" class="btn btn-lg btn-block btn-success p-3"> <strong>Giriş Yap</strong></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <script type="text/javascript">
            $(document).ready(function(){

                $("#il").change(function(){

                    var ilid = $(this).val();
                    $.ajax({
                        type:"POST",
                        url:"index.php?do=ajax_harita_talep",
                        data:{"il":ilid},
                        success:function(e){
                            $("#ilce").html(e);
                        }
                    });
                });

                $("#ilce").change(function(){

                    var ilceid = $(this).val();
                    $.ajax({
                        type:"POST",
                        url:"index.php?do=ajax_harita_talep",
                        data:{"ilce":ilceid},
                        success:function(e){
                            $("#mahalle").html(e);
                        }
                    });
                });
            });
        </script>
        <?php if ($islem == "cikis") {

            session_destroy();
            go("index.php", 0);
        } ?>
    </div>
</div>
