<!doctype html>
<html class="no-js" lang="tr"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- set the page title -->
    <title>İletişim</title>
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


<section class="sptb bg-white mt-8 pb-8">
    <div id="con" class="container">
        <?php
            if (isset($_POST["mesajgonder"])) {

                $adsoyad = $_POST["adsoyad"];
                $email = $_POST["email"];
                $tel = $_POST["tel"];
                $mesaj = $_POST["mesaj"];
                $tarih = date("d.m.Y");

                if (empty($adsoyad) || empty($tel)) {

                    echo '<h5 class="alert alert-danger"><i class="fa fa-warning"></i> Telefon ya da ad soyad bölümünü boş olamaz. Lütfen tekrar deneyiniz.</h5>';      

                } else {

                    $stmt_mesaj = $vt->prepare("INSERT INTO emlak_mesajiletisim (adsoyad, email, tel, mesaj, tarih) values (?,?,?,?,?)");
                    $stmt_mesaj->execute([$adsoyad, $email, $tel, $mesaj, $tarih]);

                    echo '<h5 class="alert alert-success"><i class="fa fa-check"></i> Mesajınız başarılı bir şekilde gönderilmiştir. Kısa sürede size site yönetimi size dönüş yapacaktır.</h5>';
                    
                }
            }
        ?>  
        <h1 class="h3"><?=$ayar["site_adi"]?> - Bize Ulaşın</h1>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4><strong><i class="fa fa-map-marker pull-left fa-lg"></i> <?=$ayar["site_adi"]?></strong></h4>
                        <br>
                        <table class="table table-hover table-bordered">
                            <tbody>
                                <tr>
                                    <td style="width: 10%; text-align: center;"><strong><h6><i class="fa fa-phone fa-lg"></i></h6></strong></td>
                                    <td style="width: 30%;"><strong><h6>Telefon</h6></strong></td>
                                    <td><h6><?=$site["sabittel"]?></h6></td>
                                </tr>
                                <tr>
                                    <td style="width: 10%; text-align: center;"><strong><h6><i class="fa fa-mobile fa-lg"></i></h6></strong></td>
                                    <td style="width: 30%;"><strong><h6>Gsm</h6></strong></td>
                                    <td><h6><?=$site["gsm"]?></h6></td>
                                </tr>
                                <tr>
                                    <td style="width: 10%; text-align: center;"><strong><h6><i class="fa fa-print fa-lg"></i></h6></strong></td>
                                    <td style="width: 30%;"><strong><h6>Fax</h6></strong></td>
                                    <td><h6><?=$site["fax"]?></h6></td>
                                </tr>
                                <tr>
                                    <td style="width: 10%; text-align: center;"><strong><h6><i class="fa fa-map-marker fa-lg"></i></h6></strong></td>
                                    <td style="width: 30%;"><strong><h6>Adres</h6></strong></td>
                                    <td><h6><?=$site["adres"]?></h6></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4><strong><i class="fa fa-linkedin pull-left"></i> Sosyal Medya Hesapları</strong></h4>
                        <hr>
                        <ul class="nav nav-pills">
                            <?php
                                $stmt_sosyal = $vt->query("SELECT ayar_sitesosyal.sosyallink, ayar_sosyal.icon FROM ayar_sitesosyal INNER JOIN ayar_sosyal ON ayar_sitesosyal.sosyalid=ayar_sosyal.id AND ayar_sitesosyal.siteid = '1' AND ayar_sosyal.durum = 0 AND ayar_sitesosyal.sosyallink != '' ORDER BY ayar_sosyal.sira ASC");
                                while($sosyal = $stmt_sosyal->fetch()) {
                            ?>
                            <li>
                                <a class="btn btn-default mr-2" href="<?=$sosyal["sosyallink"];?>" target="_blank"> <i class="<?=$sosyal["icon"];?>"></i> <?=$sosyal["baslik"];?> </a>                             
                            </li>
                            <?php } ?>
                        </ul>


                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form class="form form-horizontal" method="POST" action="">
                            <h4><strong><i class="fa fa-map-marker pull-left fa-lg"></i> Mesajınız mı var?</strong></h4>
                            <hr>
                            <div class="form-group">
                                <label class="control-label">Adınız Soyadınız *</label>
                                <input type="text" name="adsoyad" class="form-control">   
                            </div>
                            <div class="form-group">
                                <label class="control-label">Telefon *</label>
                                <input type="text" name="tel" class="form-control"> 
                                
                            </div>
                            <div class="form-group">
                                <label class="control-label">E-Posta Adresiniz</label>
                                <input type="text" name="email" class="form-control"> 
                                
                            </div>
                            <div class="form-group">
                                <label class="control-label">Mesajınız</label>
                                <textarea name="mesaj" class="form-control" rows="4"></textarea>
                                
                            </div>
                            <button type="submit" name="mesajgonder" class="btn btn-lg btn-primary pull-right"><i class="fa fa-envelope"></i> Mesajı Gönder</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">         
                <div class="card">
                    <div class="card-body"> 
                        <script src="https://api-maps.yandex.ru/2.1/?lang=tr_TR" type="text/javascript"></script>
                        <script type="text/javascript">
                            ymaps.ready(init);
                            var myMap, 
                                myPlacemark;
                     
                            function init(){ 
                                myMap = new ymaps.Map("map", {
                                    center: ["<?=$site["enlem"];?>", "<?=$site["boylam"];?>"],
                                    zoom: "<?=$site["zoom"];?>"
                            });
                     
                            myPlacemark = new ymaps.Placemark([8, 8], { hintContent: 'İcon başlığı', balloonContent: 'Kutu içeriği'
                                });
                                 
                                myMap.geoObjects.add(myPlacemark);
                            }
                        </script>  
                        <div id="map" style="width: 100%; height: 500px"></div>
                        <div class="clearfix"></div>
                    </div>                  
                </div>
            </div>
            <div class="col-md-12 d-none">
                <h4><strong>Şubelerimiz</strong></h4>
                <br>
                <div class="row">
                    <?php
                        $stmt_subeler = $vt->query("SELECT * FROM subeler");
                        while($sube = $stmt_subeler->fetch()) {

                            $stmt_il = $vt->prepare("SELECT * FROM sehir where sehir_key = ?");
                            $stmt_il->execute([$sube["il"]]);
                            $il = $stmt_il->fetch();

                            $stmt_ilce = $vt->prepare("SELECT * FROM ilce where ilce_key = ?");
                            $stmt_ilce->execute([$sube["ilce"]]);
                            $ilce = $stmt_ilce->fetch();
                    ?>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6><strong><?=$sube["adi"];?></strong></h6>
                            </div>                                      
                            <div class="card-body">                                        
                                <table class="table table-hover table-bordered">
                                    <tbody>
                                        <tr>
                                            <td style="width: 10%; text-align: center;"><strong><h6><i class="fa fa-phone fa-lg"></i></h6></strong></td>
                                            <td style="width: 30%;"><strong><h6>Telefon</h6></strong></td>
                                            <td><h6><?=$sube["sabittel"]?></h6></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 10%; text-align: center;"><strong><h6><i class="fa fa-mobile fa-lg"></i></h6></strong></td>
                                            <td style="width: 30%;"><strong><h6>Gsm</h6></strong></td>
                                            <td><h6><?=$sube["gsm"]?></h6></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 10%; text-align: center;"><strong><h6><i class="fa fa-print fa-lg"></i></h6></strong></td>
                                            <td style="width: 30%;"><strong><h6>Fax</h6></strong></td>
                                            <td><h6><?=$sube["fax"]?></h6></td>
                                        </tr>
                                        <tr>
                                            <td rowspan="3" style="width: 10%; text-align: center;"><strong><h6><i class="fa fa-map-marker fa-lg"></i></h6></strong></td>
                                            <td style="width: 30%;"><strong><h6>İl</h6></strong></td>
                                            <td><h6><?=$il["adi"]?></h6></td>
                                        </tr>
                                        <tr>                                            
                                            <td style="width: 30%;"><strong><h6>İlçe</h6></strong></td>
                                            <td><h6><?=$ilce["ilce_title"]?></h6></td>
                                        </tr>
                                        <tr>                                            
                                            <td style="width: 30%;"><strong><h6>Adres</h6></strong></td>
                                            <td><h6><?=$sube["adres"]?></h6></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>                                
                                <div class="text-right">
                                    <a class="btn btn-primary" href="/ofis/<?=$sube["id"];?>">Ofis Detayları <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <?php } ?>
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