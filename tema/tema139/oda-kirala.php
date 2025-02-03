<!doctype html>
<html class="no-js" lang="tr">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- set the page title -->
    <title><?=$ayar["site_adi"];?></title>
    <meta name="description" content="<?=$ayar['site_desc'];?>" />
    <meta name="keywords" content="<?=$ayar['site_keyw'];?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
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

<section class="detay-ust mb-7 pt-5 pb-2"> 

    <div class="container"> 

        <?php 
 
            $siparis_no = rand(1000,200000);

            $ilan_id = $_POST["ilan_id"];
            $ilan_baslik = $_POST["ilan_baslik"];

            $periyot = $_POST["periyot"];
            $birim = $_POST["gunluk_fiyat_birim"]; 
            $yetiskin_fiyat = $_POST["yetiskin_fiyat"]; 
            $cocuk_fiyat = $_POST["cocuk_fiyat"]; 
            $bebek_fiyat = $_POST["bebek_fiyat"]; 

            $giris_tarihi = $_POST["giris_tarihi"];
            $cikis_tarihi = $_POST["cikis_tarihi"];
            $yetiskin_sayisi = $_POST["yetiskin_sayisi"];
            $cocuk_sayisi = $_POST["cocuk_sayisi"];
            $bebek_sayisi = $_POST["bebek_sayisi"]; 

            $tarih1= new DateTime($_POST["giris_tarihi"]);
            $tarih2= new DateTime($_POST["cikis_tarihi"]);
            $interval= $tarih1->diff($tarih2);
            $day = $interval->format('%a');

            $yGun = $yetiskin_fiyat * $day * $yetiskin_sayisi;
            $cGun = $cocuk_fiyat * $day * $cocuk_sayisi;
            $bGun = $bebek_fiyat * $day * $bebek_sayisi;

            $toplam = $yGun+$cGun+$bGun; 

        ?> 

        <div class="card">
            <div class="card-body bg-white"> 
                <form action="/oda-odeme" method="POST" class="form-horizontal">

                    <input hidden name="siparis_no" type="text" value="<?php echo rand(1000,200000) ?>" type="text">
                    <input hidden name="ilan_baslik" type="text" value="<?php echo $_POST["ilan_baslik"] ?>" type="text">
                    <input hidden name="toplam" type="text" value="<?php echo $toplam ?>" type="text">

                    <div class="card">
                        <div class="card-header justify-content-center">
                            <h3><?php echo $ilan_baslik ?> İçin Rezervasyon Oluşturuluyor</h3>
                        </div>
                        <div class="row">  
                            <div class="col-md-4">
                                <div class="card-body pl-7"> 
                                    <div class="form-group">
                                        <h3>Kişisel Bilgiler</h3>
                                    </div>
                                    <div class="form-group"> 
                                        <input type="text" name="ad_soyad" class="form-control input-lg" placeholder="Adınız Soyadınız" required>
                                    </div>
                                    <div class="form-group"> 
                                        <input type="number" name="tc_kimlik" class="form-control input-lg" placeholder="Tc Kimlik / Pasaport No" required>
                                    </div>
                                    <div class="form-group"> 
                                        <input type="number" name="telefon" class="form-control input-lg" placeholder="Telefon Numaranız" required>
                                    </div>
                                    <div class="form-group"> 
                                        <input type="email" name="email" class="form-control input-lg" placeholder="E-posta Adresiniz" required>
                                    </div>   
                                    <div class="form-group"> 
							            <textarea name="siparis_notu" class="form-control" placeholder="Sipariş Notu" id="" cols="30" rows="3"></textarea>
                                    </div>  
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-body">
                                    <div class="form-group">
                                        <h3>&nbsp;</h3>
                                    </div> 
                                    <div class="form-group">
                                        <select name="yetiskin_sayisi" class="form-control input-lg" id=""> 
                                            <option <?php if ($_POST["yetiskin_sayisi"]==1) { ?> selected <?php } ?> value="1">Toplam 1 Yetişkin Kalacak</option> 
                                            <option <?php if ($_POST["yetiskin_sayisi"]==2) { ?> selected <?php } ?> value="2">Toplam 2 Yetişkin Kalacak</option> 
                                            <option <?php if ($_POST["yetiskin_sayisi"]==3) { ?> selected <?php } ?> value="3">Toplam 3 Yetişkin Kalacak</option> 
                                            <option <?php if ($_POST["yetiskin_sayisi"]==4) { ?> selected <?php } ?> value="4">Toplam 4 Yetişkin Kalacak</option> 
                                            <option <?php if ($_POST["yetiskin_sayisi"]==5) { ?> selected <?php } ?> value="5">Toplam 5 Yetişkin Kalacak</option> 
                                            <option <?php if ($_POST["yetiskin_sayisi"]==6) { ?> selected <?php } ?> value="6">Toplam 6 Yetişkin Kalacak</option> 
                                            <option <?php if ($_POST["yetiskin_sayisi"]==7) { ?> selected <?php } ?> value="7">Toplam 7 Yetişkin Kalacak</option> 
                                        </select>
                                    </div> 
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-6"> 
                                                <select name="yetiskin_sayisi" class="form-control input-lg" id=""> 
                                                    <option <?php if ($_POST["cocuk_sayisi"]==1) { ?> selected <?php } ?> value="1">1 Çocuk</option> 
                                                    <option <?php if ($_POST["cocuk_sayisi"]==2) { ?> selected <?php } ?> value="2">2 Çocuk</option> 
                                                    <option <?php if ($_POST["cocuk_sayisi"]==3) { ?> selected <?php } ?> value="3">3 Çocuk</option> 
                                                    <option <?php if ($_POST["cocuk_sayisi"]==4) { ?> selected <?php } ?> value="4">4 Çocuk</option> 
                                                    <option <?php if ($_POST["cocuk_sayisi"]==5) { ?> selected <?php } ?> value="5">5 Çocuk</option> 
                                                    <option <?php if ($_POST["cocuk_sayisi"]==6) { ?> selected <?php } ?> value="6">6 Çocuk</option> 
                                                    <option <?php if ($_POST["cocuk_sayisi"]==7) { ?> selected <?php } ?> value="7">7 Çocuk</option> 
                                                </select>
                                            </div>
                                            <div class="col-lg-6"> 
                                                <select name="yetiskin_sayisi" class="form-control input-lg" id=""> 
                                                    <option <?php if ($_POST["bebek_sayisi"]==1) { ?> selected <?php } ?> value="1">1 Bebek</option> 
                                                    <option <?php if ($_POST["bebek_sayisi"]==2) { ?> selected <?php } ?> value="2">2 Bebek</option> 
                                                    <option <?php if ($_POST["bebek_sayisi"]==3) { ?> selected <?php } ?> value="3">3 Bebek</option> 
                                                    <option <?php if ($_POST["bebek_sayisi"]==4) { ?> selected <?php } ?> value="4">4 Bebek</option> 
                                                    <option <?php if ($_POST["bebek_sayisi"]==5) { ?> selected <?php } ?> value="5">5 Bebek</option> 
                                                    <option <?php if ($_POST["bebek_sayisi"]==6) { ?> selected <?php } ?> value="6">6 Bebek</option> 
                                                    <option <?php if ($_POST["bebek_sayisi"]==7) { ?> selected <?php } ?> value="7">7 Bebek</option> 
                                                </select>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="form-group">  
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <select name="il" id="il" class="form-control input-lg select2" required>
                                                    <option selected="selected"> İl Seçiniz </option>
                                                    <option value="1"> ADANA </option>
                                                    <option value="2"> ADIYAMAN </option>
                                                    <option value="3"> AFYONKARAHİSAR </option>
                                                    <option value="4"> AĞRI </option>
                                                    <option value="5"> AMASYA </option>
                                                    <option value="6"> ANKARA </option>
                                                    <option value="7"> ANTALYA </option>
                                                    <option value="8"> ARTVİN </option>
                                                    <option value="9"> AYDIN </option>
                                                    <option value="10"> BALIKESİR </option>
                                                    <option value="11"> BİLECİK </option>
                                                    <option value="12"> BİNGÖL </option>
                                                    <option value="13"> BİTLİS </option>
                                                    <option value="14"> BOLU </option>
                                                    <option value="15"> BURDUR </option>
                                                    <option value="16"> BURSA </option>
                                                    <option value="17"> ÇANAKKALE </option>
                                                    <option value="18"> ÇANKIRI </option>
                                                    <option value="19"> ÇORUM </option>
                                                    <option value="20"> DENİZLİ </option>
                                                    <option value="21"> DİYARBAKIR </option>
                                                    <option value="22"> EDİRNE </option>
                                                    <option value="23"> ELAZIĞ </option>
                                                    <option value="24"> ERZİNCAN </option>
                                                    <option value="25"> ERZURUM </option>
                                                    <option value="26"> ESKİŞEHİR </option>
                                                    <option value="27"> GAZİANTEP </option>
                                                    <option value="28"> GİRESUN </option>
                                                    <option value="29"> GÜMÜŞHANE </option>
                                                    <option value="30"> HAKKARİ </option>
                                                    <option value="31"> HATAY </option>
                                                    <option value="32"> ISPARTA </option>
                                                    <option value="33"> MERSİN </option>
                                                    <option value="34"> İSTANBUL </option>
                                                    <option value="35"> İZMİR </option>
                                                    <option value="36"> KARS </option>
                                                    <option value="37"> KASTAMONU </option>
                                                    <option value="38"> KAYSERİ </option>
                                                    <option value="39"> KIRKLARELİ </option>
                                                    <option value="40"> KIRŞEHİR </option>
                                                    <option value="41"> KOCAELİ </option>
                                                    <option value="42"> KONYA </option>
                                                    <option value="43"> KÜTAHYA </option>
                                                    <option value="44"> MALATYA </option>
                                                    <option value="45"> MANİSA </option>
                                                    <option value="46"> KAHRAMANMARAŞ </option>
                                                    <option value="47"> MARDİN </option>
                                                    <option value="48"> MUĞLA </option>
                                                    <option value="49"> MUŞ </option>
                                                    <option value="50"> NEVŞEHİR </option>
                                                    <option value="51"> NİĞDE </option>
                                                    <option value="52"> ORDU </option>
                                                    <option value="53"> RİZE </option>
                                                    <option value="54"> SAKARYA </option>
                                                    <option value="55"> SAMSUN </option>
                                                    <option value="56"> SİİRT </option>
                                                    <option value="57"> SİNOP </option>
                                                    <option value="58"> SİVAS </option>
                                                    <option value="59"> TEKİRDAĞ </option>
                                                    <option value="60"> TOKAT </option>
                                                    <option value="61"> TRABZON </option>
                                                    <option value="62"> TUNCELİ </option>
                                                    <option value="63"> ŞANLIURFA </option>
                                                    <option value="64"> UŞAK </option>
                                                    <option value="65"> VAN </option>
                                                    <option value="66"> YOZGAT </option>
                                                    <option value="67"> ZONGULDAK </option>
                                                    <option value="68"> AKSARAY </option>
                                                    <option value="69"> BAYBURT </option>
                                                    <option value="70"> KARAMAN </option>
                                                    <option value="71"> KIRIKKALE </option>
                                                    <option value="72"> BATMAN </option>
                                                    <option value="73"> ŞIRNAK </option>
                                                    <option value="74"> BARTIN </option>
                                                    <option value="75"> ARDAHAN </option>
                                                    <option value="76"> IĞDIR </option>
                                                    <option value="77"> YALOVA </option>
                                                    <option value="78"> KARABÜK </option>
                                                    <option value="79"> KİLİS </option>
                                                    <option value="80"> OSMANİYE </option>
                                                    <option value="81"> DÜZCE </option>
                                                    <option value="123"> KIBRIS </option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <select name="ilce" id="ilce" class="form-control input-lg select2" required>
                                                    <option selected="selected"> İlçe </option>
                                                </select>
                                            </div> 
                                        </div> 
                                        <script type="text/javascript">
                                            $(document).ready(function () {
                                                $("#il").change(function () {
                                                    var ilid = $(this).val();
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "index.php?do=ajax_harita_talep",
                                                        data: { il: ilid },
                                                        success: function (e) {
                                                            $("#ilce").html(e);
                                                        },
                                                    });
                                                });

                                            });
                                        </script>
                                    </div> 
                                    <div class="form-group"> 
							            <textarea name="adres" class="form-control" placeholder="Adres" id="" cols="30" rows="3"></textarea>
                                    </div>  
                                    <div class="form-group"> 
                                        <select class="form-control input-lg" name="nereden_duydunuz" id="" required>
                                            <option value="">Bizi Nereden Duydunuz</option>
                                            <option value="Arama Moturu">Arama Moturu</option>
                                            <option value="Tavsiye">Tavsiye</option>
                                            <option value="İnstagram">İnstagram</option>
                                            <option value="Facebook">Facebook</option>
                                            <option value="Email">Email</option>
                                            <option value="Diğer">Diğer</option>
                                        </select>
                                    </div>   
                                    <div class="form-group">
                                        <br>
                                        <label><input class="check-control" type="checkbox" value="" name="sozlesme" required=""><strong><a href="#" data-toggle="modal" data-target="#gizlilikLong">Gizlilik politikası</a></strong>'nı Okudum ve Kabul Ediyorum.</label>
                                        <br> 
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
                                                    <button type="button" class="btn btn-success" data-dismiss="modal">Kapat</button>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-4">
                                        <button type="submit" name="odemeYap" class="btn btn-warning btn-block pt-4 pb-4"><strong>ÖDEME YAP</strong></button>
                                    </div>    
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card p-4" style="min-height:700px">
                                    <div class="card-body"> <div class="form-group">
                                        <h3>Ücretlendirme</h3>
                                    </div> 
                                    <div class="row"> 
                                        <div class="col-lg-12"> 
                                            <div class="form-group mt-4 mb-1">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <h4>Giriş Tarihi</h4>
                                                    </div>
                                                    <div class="col-lg-4 text-right">
                                                        <h4><strong><?php echo $_POST["giris_tarihi"] ?> </strong></h4> 
                                                        <input hidden name="giris_tarihi" type="text" value="<?php echo $_POST["giris_tarihi"] ?>" type="text">
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-lg-12"> 
                                            <div class="form-group mt-4 mb-1">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <h4>Çıkış Tarihi</h4>
                                                    </div>
                                                    <div class="col-lg-4 text-right">
                                                        <h4><strong><?php echo $_POST["cikis_tarihi"] ?> </strong></h4>
                                                        <input hidden name="cikis_tarihi" type="text" value="<?php echo $_POST["cikis_tarihi"] ?>" type="text">
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-lg-12"> 
                                            <div class="form-group mt-4 mb-1">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <h4>Gün Sayısı</h4>
                                                    </div>
                                                    <div class="col-lg-4 text-right">
                                                        <h4><strong><?php echo $day ?> Gün</strong></h4>
                                                        <input hidden name="gun_sayisi" type="text" value="<?php echo $day ?>" type="text">
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-lg-12"> 
                                            <div class="form-group mt-4 mb-1">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <h4>Periyot</h4>
                                                    </div>
                                                    <div class="col-lg-4 text-right">
                                                        <h4><strong><?php echo $_POST["periyot"] ?> </strong></h4>
                                                        <input hidden name="periyot" type="text" value="<?php echo $_POST["periyot"]?>" type="text">
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-lg-12"> 
                                            <div class="form-group mt-4 mb-1">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <h4> Yetişkin / <?php echo $_POST["periyot"] ?></h4>
                                                    </div>
                                                    <div class="col-lg-4 text-right">
                                                        <h4><strong><?php echo $_POST["yetiskin_sayisi"] ?> x <?php echo $_POST["yetiskin_fiyat"] ?> <small><?php echo $_POST["gunluk_fiyat_birim"] ?></small> </strong></h4>
                                                        <input hidden name="yetiskin_fiyat" type="text" value="<?php echo $_POST["yetiskin_fiyat"] ?>" type="text">
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-lg-12"> 
                                            <div class="form-group mt-4 mb-1">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <h4> Çocuk / <?php echo $_POST["periyot"] ?></h4>
                                                    </div>
                                                    <div class="col-lg-4 text-right">
                                                        <h4><strong><?php echo $_POST["cocuk_sayisi"] ?> x <?php echo $_POST["cocuk_fiyat"] ?> <small><?php echo $_POST["gunluk_fiyat_birim"] ?></small> </strong></h4>
                                                        <input hidden name="cocuk_fiyat" type="text" value="<?php echo $_POST["cocuk_fiyat"] ?>" type="text">
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-lg-12"> 
                                            <div class="form-group mt-4 mb-4">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <h4> Bebek / <?php echo $_POST["periyot"] ?></h4>
                                                    </div>
                                                    <div class="col-lg-4 text-right">
                                                        <h4><strong><?php echo $_POST["bebek_sayisi"] ?> x <?php echo $_POST["bebek_fiyat"] ?> <small><?php echo $_POST["gunluk_fiyat_birim"] ?></small> </strong></h4>
                                                        <input hidden name="bebek_fiyat" type="text" value="<?php echo $_POST["bebek_fiyat"] ?>" type="text">
                                                    </div>
                                                </div>
                                            </div> 
                                        </div> 
                                        <div class="col-lg-12"> 
                                            <div class="form-group mt-4 mb-1">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <h4><?php echo $_POST["yetiskin_sayisi"] ?> Yetişkin, <?php echo $_POST["cocuk_sayisi"] ?> Yetişkin, <?php echo $_POST["bebek_sayisi"] ?> Bebek</h4> 
                                                    </div> 
                                                </div>
                                            </div>  
                                        </div> 
                                        <div class="col-lg-12"> 
                                            <div class="form-group mt-4 mb-1">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <h4><strong>Ara Toplam</strong></h4>
                                                    </div>
                                                    <div class="col-lg-4 text-right">
                                                        <h4><strong><?php echo $toplam ?> <?php echo $_POST["gunluk_fiyat_birim"] ?></strong></h4>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-lg-12"> 
                                            <div class="form-group mt-4 mb-1">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <h3><strong>Toplam</strong></h3>
                                                    </div>
                                                    <div class="col-lg-6 text-right">
                                                        <h3><strong><?php echo $toplam ?> <?php echo $_POST["gunluk_fiyat_birim"] ?></strong></h3>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>  
                                    </div> 
                                </div> 
                            </div> 
                        </div>
                    </div>
                </form>
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