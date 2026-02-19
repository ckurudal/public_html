<?php
require_once "../sistem/baglan.php";
require_once "../sistem/fonksiyon.php";
$islem = $_GET["islem"];
$bilgi = $_GET["bilgi"];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> <?php echo $ayar["site_adi"]; ?> </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<style type="text/css">
    body {
        background: url(https://www.backhousemedia.com/website/wp-content/uploads/2017/05/Website-design-BG.jpg) no-repeat center center fixed !important;
        background-size: cover !important;
    }
    .form-control {
        height: 55px;
    }
    .input-group-addon {
        padding: 6px 20px;
    }
</style>
<?php if($islem == ""): ?>
<style>
.login-box {height: 100vh;background: #fbfbfb;}
</style>
    <div class="login-box col-md-3">
        <div class="login-logo">
            <h4> <a href="giris.php"><i class="fa fa-user-plus"></i> <b> ÜYE </b>GİRİŞİ</a> </h4>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <form action="" method="post">
                <?php
                if ($_POST) {
                    $email = strip_tags(p("email"));
                    $sifre = md5(p("sifre"));
                    if (!$email || !$sifre) {
                        hata_alert("E-posta ve şifre giriniz..");
                    } else {
                        $query = $vt->query("SELECT * FROM yonetici WHERE email = '$email' AND pass = '$sifre' AND durum = 0");
                        if ($query->rowCount()) {
                            $row = row($query);
                            $_SESSION = array (
                                "uyelogin" => true,
                                "id" => $row["id"],
                                "email" => $row["email"],
                            );
                            @session_olustur($session);
                            onay("Başarı ile giriş yaptınız.");
                            go($ayar["site_yonetim_url"]."index.php", 0);
                        } else {
                            hata_alert("Hatalı bilgiler girdiniz. Lütfen tekrar deneyiniz.");
                            echo "<br>";
                        }
                    }
                }
                ?>
                <?php if ($bilgi == "onay"): ?>
                    <?php onay("Yeni şifrenizi giriniz."); ?>
                <?php endif; ?>
                <div class="form-group has-feedback">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-users"></i></span>
                        <input type="text" class="form-control" name="email" placeholder="E-Posta">
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        <input type="password" name="sifre" class="form-control" placeholder="Parola">
                    </div>
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-success btn-block btn-lg"> <strong>GİRİŞ YAP</strong> </button>
                        <!-- <h6><a href="" class="text-center btn-block"> Şifremi Unuttum </a></h6> -->
                    </div>
                    <div class="text-center">
                        <br>
                        <br>
                        <br>
                        <br>
                        <a href="?islem=sifre"> Şifremi Unuttum</a>
                        |
                        <a href="<?php echo $ayar["site_url"]; ?>"> Siteye Git </a>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <div class="text-center">
            <br>
            <?php echo $ayar["site_adi"]; ?>
        </div>
        <!-- /.login-box-body -->
    </div>
<?php endif; ?>
<?php if ($islem == "sifre") : ?>
    <div class="col-md-offset-3 col-md-6">
        <style type="text/css">
            body {
                /*  background: url(dist/img/admin-login.jpg) no-repeat center center fixed !important; */
            }
            .form-control {
                height: 45px;
            }
            .input-group-addon {
                padding: 6px 15px;
            }
        </style>
        <!-- /.login-logo -->
        <div class="login-box-body" style="margin-top:20%;">
            <form action="" method="post">
                <?php
                if (isset($_POST["sms_kod_gonder"])) {
                    $tel 	= $_POST["tel"];
                    $uye_tel = $vt->prepare("SELECT * FROM yonetici WHERE tel = '$tel'");
                    $uye_tel->execute();
                    $tel_say = $uye_tel->rowCount();
                    if (empty($tel)) {
                        hata_alert("Lütfen telefon numarası giriniz.");
                        echo "<br>";
                    } else if (!$tel_say>0) {
                        hata_alert("Böyle bir numara sistemde kayıtlı değildir.");
                        echo "<br>";
                    } else {
                        $kod = rand(300000,888888);
                        $_SESSION = array (
                            "onay_kodu" => true,
                            "kod" => $kod,
                            "tel" => $tel
                        );
                        $mesaj = "Yeni şifre için onay kodunuz ".$kod." ";
                        uye_sms_gonder($tel, $mesaj);
                        go($ayar["site_yonetim_url"]."giris.php?islem=sms_onay",0);
                    }
                }
                if (isset($_POST["email_kod_gonder"])) {
                    $email 	= $_POST["email"];
                    $uye_email = $vt->prepare("SELECT * FROM yonetici WHERE email = '$email'");
                    $uye_email->execute();
                    $email_say = $uye_email->rowCount();
                    if (empty($email)) {
                        hata_alert("Lütfen e-posta giriniz.");
                        echo "<br>";
                    } else if (!$email_say>0) {
                        hata_alert("Böyle bir e-posta adresi sistemde kayıtlı değildir.");
                        echo "<br>";
                    } else {
                        $kod = rand(300000,888888);
                        $_SESSION = array (
                            "onay_kodu" => true,
                            "kod" => $kod,
                            "email" => $email
                        );
                        $mesaj = "Yeni şifre için onay kodunuz ".$kod." ";
                        mail_gonder($email, $mesaj, $mesaj);
                        go($ayar["site_yonetim_url"]."giris.php?islem=mail_onay",0);
                    }
                }
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="login-box">
                            <div class="login-logo">
                                <h4> <a href="giris.php"><i class="fa fa-key"></i> <b> SMS KODU </b>GÖNDER</a> </h4>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input type="text" class="form-control" name="tel" placeholder="0(533) 333 33 33">
                            </div>
                            <br>
                            <p class="text-center">Şifre yenileme kodu, sms ile gönderilecektir.</p>
                            <button type="submit" name="sms_kod_gonder" class="btn btn-inverse btn-block btn-lg"> <strong>SMS KODU GÖNDER</strong> </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="login-box">
                            <div class="login-logo">
                                <h4> <a href="giris.php"><i class="fa fa-envelope"></i> <b> E-POSTA KODU </b>GÖNDER</a> </h4>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="text" class="form-control" name="email" placeholder="E-posta adresi">
                            </div>
                            <br>
                            <p class="text-center">Şifre yenileme onay kodu, e-posta ile gönderilecektir.</p>
                            <button type="submit" name="email_kod_gonder" class="btn btn-inverse btn-block btn-lg"> <strong>E-POSTA KODU GÖNDER</strong> </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="text-center">
                        <br>
                        <br>
                        <br>
                        <br>
                        <a href="?"> Giriş Yap </a>
                        |
                        <a href="<?php echo $ayar["site_url"]; ?>"> Siteye Git </a>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <div class="text-center">
            <br>
            <?php echo $ayar["site_adi"]; ?>
        </div>
        <!-- /.login-box-body -->
    </div>
<?php endif; ?>
<?php if ($islem == "sms_onay") : ?>
    <div class="login-box col-md-offset-4 col-md-3">
        <div class="login-logo">
            <h4> <a href="giris.php"><i class="fa fa-phone"></i> <b> SMS </b>ONAY KODU</a> </h4>
        </div>
        <style type="text/css">
            body {
                /*  background: url(dist/img/admin-login.jpg) no-repeat center center fixed !important; */
            }
            .form-control {
                height: 55px;
            }
            .input-group-addon {
                padding: 6px 20px;
            }
        </style>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <form action="" method="post">
                <?php
                if (isset($_POST["sms_onay"])) {
                    $onay_kodu 	= $_POST["onay_kodu"];
                    if (empty($onay_kodu))
                    {
                        hata_alert("Lütfen geçerli bir kod giriniz.");
                        echo "<br>";
                    }
                    else if ($onay_kodu == $_SESSION["kod"])
                    {
                        $yeni_sifre = rand(7777,8888);
                        $mesaj = "Şifreniz değiştirilecek ".$yeni_sifre." yapılmıştır. Yeni şifreniz ile giriş yapabilirsiniz.";
                        $pass = md5($yeni_sifre);
                        uye_sms_gonder($_SESSION["tel"], $mesaj);
                        onay("Yeni Şifreniz {$_SESSION["tel"]} numarasına gönderilmiştir.");
                        $duzenle = $vt->query("UPDATE yonetici SET pass = '$pass' WHERE tel = '".$_SESSION["tel"]."'");
                        session_destroy();
                        go($ayar["site_yonetim_url"]."giris.php",2);
                    } else {
                        hata_alert("Onay kodu hatalı...");
                        echo "<br>";
                    }
                }
                ?>
                <div class="form-group has-feedback">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-check"></i></span>
                        <input type="text" class="form-control" name="onay_kodu" placeholder="Onay Kodu (* * * * * *)">
                    </div>
                </div>
                <div class="form-group has-feedback hidden">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="text" name="email" class="form-control" placeholder="E-posta">
                    </div>
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-xs-12">
                        <button type="submit" name="sms_onay" class="btn btn-inverse btn-block btn-lg"> <strong>KODU ONAYLA</strong> </button>
                        <br>
                        <a href="?islem=sifre" class="btn btn-success btn-lg btn-block"> <strong>TEKRAR GÖNDER</strong> </a>
                        <br>
                        <!-- <h6><a href="" class="text-center btn-block"> Şifremi Unuttum </a></h6> -->
                    </div>
                    <div class="text-center">
                        <br>
                        <br>
                        <br>
                        <br>
                        <a href="?"> Giriş Yap </a>
                        |
                        <a href="<?php echo $ayar["site_url"]; ?>"> Siteye Git </a>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <div class="text-center">
            <br>
            <?php echo $ayar["site_adi"]; ?>
        </div>
        <!-- /.login-box-body -->
    </div>
<?php endif; ?>
<?php if ($islem == "mail_onay") : ?>
    <div class="login-box col-md-offset-4 col-md-3">
        <div class="login-logo">
            <h4> <a href="giris.php"><i class="fa fa-envelope"></i> <b> E-POSTA </b>ONAY KODU</a> </h4>
        </div>
        <style type="text/css">
            body {
                /*  background: url(dist/img/admin-login.jpg) no-repeat center center fixed !important; */
            }
            .form-control {
                height: 55px;
            }
            .input-group-addon {
                padding: 6px 20px;
            }
        </style>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <form action="" method="post">
                <?php
                if (isset($_POST["email_kodu_onayla"])) {
                    $onay_kodu 	= $_POST["onay_kodu"];
                    if (empty($onay_kodu))
                    {
                        hata_alert("Lütfen geçerli bir kod giriniz.");
                        echo "<br>";
                    }
                    else if ($onay_kodu == $_SESSION["kod"])
                    {
                        $yeni_sifre = rand(7777,8888);
                        $mesaj = "Şifreniz değiştirilecek ".$yeni_sifre." yapılmıştır. Yeni şifreniz ile giriş yapabilirsiniz.";
                        $pass = md5($yeni_sifre);
                        mail_gonder($_SESSION["email"], $mesaj, $mesaj);
                        onay("Yeni Şifreniz {$_SESSION["email"]} numarasına gönderilmiştir.");
                        $duzenle = $vt->query("UPDATE yonetici SET pass = '$pass' WHERE email = '".$_SESSION["email"]."'");
                        session_destroy();
                        go($ayar["site_yonetim_url"]."giris.php",2);
                    } else {
                        hata_alert("Onay kodu hatalı...");
                        echo "<br>";
                    }
                }
                ?>
                <div class="form-group has-feedback">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-check"></i></span>
                        <input type="text" class="form-control" name="onay_kodu" placeholder="Onay Kodu (* * * * * *)">
                    </div>
                </div>
                <div class="form-group has-feedback hidden">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="text" name="email" class="form-control" placeholder="E-posta">
                    </div>
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-xs-12">
                        <button type="submit" name="email_kodu_onayla" class="btn btn-inverse btn-block btn-lg"> <strong>KODU ONAYLA</strong> </button>
                        <br>
                        <a href="?islem=sifre" class="btn btn-success btn-lg btn-block"> <strong>TEKRAR GÖNDER</strong> </a>
                        <br>
                        <!-- <h6><a href="" class="text-center btn-block"> Şifremi Unuttum </a></h6> -->
                    </div>
                    <div class="text-center">
                        <br>
                        <br>
                        <br>
                        <br>
                        <a href="?"> Giriş Yap </a>
                        |
                        <a href="<?php echo $ayar["site_url"]; ?>"> Siteye Git </a>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <div class="text-center">
            <br>
            <?php echo $ayar["site_adi"]; ?>
        </div>
        <!-- /.login-box-body -->
    </div>
<?php endif; ?>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });
</script>
</body>
</html>