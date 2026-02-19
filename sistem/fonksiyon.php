<?php  

function temizle($yazi) {
    $yazi = trim($yazi);
    $bul = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü',' ');
    $degis = array('c','c','g','g','i','i','o','o','s','s','u','u',' ');
    $hatasiz = str_replace($bul, $degis, $yazi);
    return $hatasiz;
}

function odaOdeme($userMail=true, $price=true, $order_no=true, $product, $adSoyad, $telefon) {

    require('baglan.php');  

    ## 1. ADIM için örnek kodlar ##

    ####################### DÜZENLEMESİ ZORUNLU ALANLAR #######################
    #
    ## API Entegrasyon Bilgileri - Mağaza paneline giriş yaparak BİLGİ sayfasından alabilirsiniz.
    $merchant_id    = $paytr_api["merchant_id"];
    $merchant_key   = $paytr_api["merchant_key"];
    $merchant_salt  = $paytr_api["merchant_salt"];
    #
    ## Müşterinizin sitenizde kayıtlı veya form vasıtasıyla aldığınız eposta adresi
    $email = $userMail;
    #
    ## Tahsil edilecek tutar.
    $payment_amount = $price*100; //9.99 için 9.99 * 100 = 999 gönderilmelidir.
    #
    ## Sipariş numarası: Her işlemde benzersiz olmalıdır!! Bu bilgi bildirim sayfanıza yapılacak bildirimde geri gönderilir.
    $merchant_oid = $order_no;
    #
    ## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız ad ve soyad bilgisi
    $user_name = $adSoyad;
    #
    ## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız adres bilgisi
    $user_address = $userMail;
    #
    ## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız telefon bilgisi
    $user_phone = $telefon;
    #
    ## Başarılı ödeme sonrası müşterinizin yönlendirileceği sayfa
    ## !!! Bu sayfa siparişi onaylayacağınız sayfa değildir! Yalnızca müşterinizi bilgilendireceğiniz sayfadır!
    ## !!! Siparişi onaylayacağız sayfa "Bildirim URL" sayfasıdır (Bakınız: 2.ADIM Klasörü).
    $merchant_ok_url = $paytr_api["bildirim_url"].'?gelen=odaKirala&orderNo='.$order_no;
    #
    ## Ödeme sürecinde beklenmedik bir hata oluşması durumunda müşterinizin yönlendirileceği sayfa
    ## !!! Bu sayfa siparişi iptal edeceğiniz sayfa değildir! Yalnızca müşterinizi bilgilendireceğiniz sayfadır!
    ## !!! Siparişi iptal edeceğiniz sayfa "Bildirim URL" sayfasıdır (Bakınız: 2.ADIM Klasörü).
    $merchant_fail_url = $paytr_api["hata_url"];
    #
    ## Müşterinin sepet/sipariş içeriği 
    $user_basket = base64_encode(json_encode(array(
        array($product, $price, 1), // 1. ürün (Ürün Ad - Birim Fiyat - Adet )
    )));
    #
    /* ÖRNEK $user_basket oluşturma - Ürün adedine göre array'leri çoğaltabilirsiniz
    $user_basket = base64_encode(json_encode(array(
        array("Örnek ürün 1", "18.00", 1), // 1. ürün (Ürün Ad - Birim Fiyat - Adet )
        array("Örnek ürün 2", "33.25", 2), // 2. ürün (Ürün Ad - Birim Fiyat - Adet )
        array("Örnek ürün 3", "45.42", 1)  // 3. ürün (Ürün Ad - Birim Fiyat - Adet )
    )));
    */
    ############################################################################################

    ## Kullanıcının IP adresi
    if( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    } elseif( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else {
        $ip = $_SERVER["REMOTE_ADDR"];
    }

    ## !!! Eğer bu örnek kodu sunucuda değil local makinanızda çalıştırıyorsanız
    ## buraya dış ip adresinizi (https://www.whatismyip.com/) yazmalısınız. Aksi halde geçersiz paytr_token hatası alırsınız.
    $user_ip=$ip;
    ##

    ## İşlem zaman aşımı süresi - dakika cinsinden
    $timeout_limit = "30";

    ## Hata mesajlarının ekrana basılması için entegrasyon ve test sürecinde 1 olarak bırakın. Daha sonra 0 yapabilirsiniz.
    $debug_on = 0;

    ## Mağaza canlı modda iken test işlem yapmak için 1 olarak gönderilebilir.
    $test_mode = 0;

    $no_installment = 0; // Taksit yapılmasını istemiyorsanız, sadece tek çekim sunacaksanız 1 yapın

    ## Sayfada görüntülenecek taksit adedini sınırlamak istiyorsanız uygun şekilde değiştirin.
    ## Sıfır (0) gönderilmesi durumunda yürürlükteki en fazla izin verilen taksit geçerli olur.
    $max_installment = 0;

    $currency = "TL";
    
    ####### Bu kısımda herhangi bir değişiklik yapmanıza gerek yoktur. #######
    $hash_str = $merchant_id .$user_ip .$merchant_oid .$email .$payment_amount .$user_basket.$no_installment.$max_installment.$currency.$test_mode;
    $paytr_token=base64_encode(hash_hmac('sha256',$hash_str.$merchant_salt,$merchant_key,true));
    $post_vals=array(
            'merchant_id'=>$merchant_id,
            'user_ip'=>$user_ip,
            'merchant_oid'=>$merchant_oid,
            'email'=>$email,
            'payment_amount'=>$payment_amount,
            'paytr_token'=>$paytr_token,
            'user_basket'=>$user_basket,
            'debug_on'=>$debug_on,
            'no_installment'=>$no_installment,
            'max_installment'=>$max_installment,
            'user_name'=>$user_name,
            'user_address'=>$user_address,
            'user_phone'=>$user_phone,
            'merchant_ok_url'=>$merchant_ok_url,
            'merchant_fail_url'=>$merchant_fail_url,
            'timeout_limit'=>$timeout_limit,
            'currency'=>$currency,
            'test_mode'=>$test_mode
        );
    
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1) ;
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    
     // XXX: DİKKAT: lokal makinanızda "SSL certificate problem: unable to get local issuer certificate" uyarısı alırsanız eğer
     // aşağıdaki kodu açıp deneyebilirsiniz. ANCAK, güvenlik nedeniyle sunucunuzda (gerçek ortamınızda) bu kodun kapalı kalması çok önemlidir!
     // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
     
    $result = @curl_exec($ch);

    if(curl_errno($ch))
        die("PAYTR IFRAME connection error. err:".curl_error($ch));

    curl_close($ch);
    
    $result=json_decode($result,1);
        
    if($result['status']=='success')
        $token=$result['token'];
    else
        die("PAYTR IFRAME failed. reason:".$result['reason']);
    #########################################################################

    echo '  
        <!-- Ödeme formunun açılması için gereken HTML kodlar / Başlangıç -->
        <script src="https://www.paytr.com/js/iframeResizer.min.js"></script>
        <iframe src="https://www.paytr.com/odeme/guvenli/'.$token.'" id="paytriframe" frameborder="0" scrolling="no" style="width: 100%;"></iframe>
        <script>iFrameResize({},"#paytriframe");</script>
        <!-- Ödeme formunun açılması için gereken HTML kodlar / Bitiş --> 
        '; 

}

// MAIL GONDER
function mail_gonder($kime, $konu, $mesaj = true)
{
    require('baglan.php');
    require("PHPMailer/class.phpmailer.php");
    error_reporting(0);
    $uye = $vt->query("SELECT * FROM yonetici WHERE email = '$kime'")->fetch();
    if ($ayar["mail_durum"] == 0 && $uye["eposta_bildirim"] == 1):
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 1; // Hata ayıklama değişkeni: 1 = hata ve mesaj gösterir, 2 = sadece mesaj gösterir
        $mail->SMTPAuth = true; //SMTP doğrulama olmalı ve bu değer değişmemeli
        $mail->SMTPSecure = $ayar["smtpsunucu"]; // Normal bağlantı için tls , güvenli bağlantı için ssl yazın
        $mail->Host = $ayar["smtpserver"]; // Mail sunucusunun adresi (IP de olabilir)
        $mail->Port = $ayar["smtpport"]; // Normal bağlantı için 587, güvenli bağlantı için 465 yazın
        $mail->IsHTML(true);
        $mail->SetLanguage("tr", "phpmailer/language");
        $mail->CharSet  ="utf-8";
        $mail->Username = $ayar["eposta"]; // Gönderici adresinizin sunucudaki kullanıcı adı (e-posta adresiniz)
        $mail->Password = $ayar["mailsifre"]; // Mail adresimizin sifresi
        $mail->SetFrom($mail->Username, $ayar["gonderici"]); // Mail atıldığında gorulecek isim ve email (genelde yukarıdaki username kullanılır)
        $mail->AddAddress($kime); // Mailin gönderileceği alıcı adres
        $mail->Subject = $konu; // Email konu başlığı
        $mail->Body = $mesaj; // Mailin içeriği
        if(!$mail->Send()):
            echo "Email Gönderim Hatasi: ".$mail->ErrorInfo;
        endif;
    endif;
}
// MAIL GONDER
function yonetici_mail_bildir($mesaj = 0)
{
    require('../sistem/baglan.php');
    require("PHPMailer/class.phpmailer.php");
    error_reporting(0);
    if ($ayar["mail_durum"] == 0):
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 1; // Hata ayıklama değişkeni: 1 = hata ve mesaj gösterir, 2 = sadece mesaj gösterir
        $mail->SMTPAuth = true; //SMTP doğrulama olmalı ve bu değer değişmemeli
        $mail->SMTPSecure = $ayar["smtpsunucu"]; // Normal bağlantı için tls , güvenli bağlantı için ssl yazın
        $mail->Host = $ayar["smtpserver"]; // Mail sunucusunun adresi (IP de olabilir)
        $mail->Port = $ayar["smtpport"]; // Normal bağlantı için 587, güvenli bağlantı için 465 yazın
        $mail->IsHTML(true);
        $mail->SetLanguage("tr", "phpmailer/language");
        $mail->CharSet  ="utf-8";
        $mail->Username = $ayar["eposta"]; // Gönderici adresinizin sunucudaki kullanıcı adı (e-posta adresiniz)
        $mail->Password = $ayar["mailsifre"]; // Mail adresimizin sifresi
        $mail->SetFrom($mail->Username, $ayar["gonderici"]); // Mail atıldığında gorulecek isim ve email (genelde yukarıdaki username kullanılır)
        $yonetici_sms = $vt->query("SELECT * FROM yonetici WHERE yetki = 0 AND eposta_bildirim = 1")->fetchAll();
        foreach ($yonetici_sms as $yonetici)
        {
            $mail->AddAddress($yonetici["email"]); // Mailin gönderileceği alıcı adres
            if ($mesaj):
                $mail->Subject = $mesaj; // Email konu başlığı
                $mail->Body = $mesaj;
            else:
                $mail->Subject = "Yeni bildirimleriniz var. Lütfen kontrol ediniz."; // Email konu başlığı
                $mail->Body = "Yeni bildirimleriniz var. Lütfen kontrol ediniz.";
            endif;
        }
        if(!$mail->Send()):
            echo "Email Gönderim Hatasi: ".$mail->ErrorInfo;
        endif;
    endif;
}
// NETGSM API AYARLARI
function sms_gonder($uye_id,$mesaj)
{
    require('baglan.php');
    $username   = $ayar['netgsm_username']; //
    $password   = urlencode($ayar['netgsm_password']); //
    $netgsm_baslik  = $ayar['netgsm_baslik']; //
    if ($ayar["sms_durum"] == 0):
        $uye = $vt->query("SELECT * FROM yonetici WHERE id = '$uye_id' && sms_bildirim = 1")->fetch();
        $url= "https://api.netgsm.com.tr/sms/send/get/?usercode={$username}&password={$password}&gsmno=".$uye["tel"]."&message=".urlencode($mesaj)."&msgheader={$netgsm_baslik}";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $http_response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($http_code != 200){
            echo "$http_code $http_response\n";
            return false;
        }
        $balanceInfo = $http_response;
        // echo "MesajID : $balanceInfo <br>";
        return $balanceInfo;
    endif;
}
// NETGSM YONETICI SMS BILDIRIM API AYARLARI
function yonetici_sms_bildir($mesaj = 0)
{
    // YONETİCİ SMS BILDIRIM
    require('baglan.php');
    if (yetki() != 0):
        $yonetici_sms = $vt->query("SELECT * FROM yonetici WHERE yetki = 0 AND sms_bildirim = 1")->fetchAll();
        foreach ($yonetici_sms as $yonetici)
        {
            if ($mesaj):
                sms_gonder($yonetici['id'],"Sayın ".$yonetici["adsoyad"].", ".$mesaj."");
            else:
                sms_gonder($yonetici['id'],"Sayın ".$yonetici["adsoyad"].", bildirimleriniz var. Lütfen kontrol ediniz.");
            endif;
        }
    endif;
    return;
}
// NETGSM YONETICI SMS BILDIRIM API AYARLARI
function uye_sms_gonder($numara, $mesaj)
{
    // SMS GONDER
    require('baglan.php');
    $username   = $ayar['netgsm_username']; //
    $password   = urlencode($ayar['netgsm_password']); //
    $netgsm_baslik  = $ayar['netgsm_baslik']; //
    if ($ayar["sms_durum"] == 0):
        $url= "https://api.netgsm.com.tr/sms/send/get/?usercode={$username}&password={$password}&gsmno={$numara}&message=".urlencode($mesaj)."&msgheader={$netgsm_baslik}";
    endif;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $http_response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if($http_code != 200){
        echo "$http_code $http_response\n";
        return false;
    }
    $balanceInfo = $http_response;
    echo "MesajID : $balanceInfo <br>";
    return $balanceInfo;
}
// MYSQL SAY
function say($tablo, $veri_1, $deger_1, $veri_2 = 0, $deger_2 = 0)
{
    require('sistem/baglan.php');
    if (!$veri_2 || !$deger_2):
        $veri = $vt->prepare("SELECT * FROM $tablo WHERE $veri_1 = '$deger_1'");
    else:
        $veri = $vt->prepare("SELECT * FROM $tablo WHERE $veri_1 = '$deger_1' AND $veri_2 = '$deger_2'");
    endif;
    $veri->execute();
    $say = $veri->rowCount();
    return $say;
}
// GELEN MESAJ SAY
function gelen_mesaj($uye_id)
{
    require('baglan.php');
    $gelen_mesaj = $vt->prepare("SELECT * FROM emlak_dangelenmesaj WHERE kime = '$uye_id' AND okundu = 0");
    $gelen_mesaj->execute();
    $mesaj_say = $gelen_mesaj->rowCount();
    return $mesaj_say;
}
// GELEN KISI MESAJ SAY
function gelen_mesaj_kisi($kime, $kimden)
{
    require('../sistem/baglan.php');
    $gelen_mesaj = $vt->prepare("SELECT * FROM emlak_dangelenmesaj WHERE kime = '$kime' AND kimden = '$kimden' AND okundu = 0");
    $gelen_mesaj->execute();
    $mesaj_say = $gelen_mesaj->rowCount();
    return $mesaj_say;
}
function dopingAdi ($ilan_id, $doping_adi)
{
    require('baglan.php');
    $doping_ilan = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '".$ilan_id."'AND odeme_durumu = 'Ödendi' AND doping_adi = '".$doping_adi."' AND bitis_tarihi > '".date('Y-m-d')."'");
    $say = $doping_ilan->rowCount();
    return $say;
}
// DOPING BEKLEYEN ODEME
function doping_bekleyen($ilan_id)
{
    require('../sistem/baglan.php');
    $bekleyen = $vt->prepare("SELECT * FROM doping_ilanlari WHERE ilan_id = '$ilan_id' AND odeme_durumu = 'Ödeme Bekliyor'");
    $bekleyen->execute();
    $bekleyen_say = $bekleyen->rowCount();
    return $bekleyen_say;
}
// YETKI YASAK SAYFA
function uyeYasak($yetki) {
    require('../sistem/baglan.php');
    if( $uye_yetki != 0 ) die('
            <section class="content">
                <h5 class="well text-center" style="padding:150px 0;">
                    <i class="fa fa-close fa-5x text-danger"></i> <br> <br>Üzgünüz! Bu sayfaya erişim yetkiniz yok! <br> <br>
                    <a class="btn btn-success" href="index.php">Anasayfaya Dön</a>
                </h5>
            </section>');
};
// YASAK SAYFA
function yasak() {
    echo '
            <section class="content">
                <h5 class="well text-center" style="padding:150px 0;">
                    <i class="fa fa-close fa-5x text-danger"></i> <br> <br>Üzgünüz! Bu sayfaya erişim yetkiniz yok! <br> <br>
                    <a class="btn btn-success" href="index.php">Anasayfaya Dön</a>
                </h5>
            </section>
        ';
    return;
};
function magaza_id($uye_id)
{
    require('../sistem/baglan.php');
    $magaza = $vt->query("SELECT * FROM subeler WHERE yetkiliuye = '$uye_id'")->fetch();
    $magaza_id = $magaza["id"];
    return $magaza_id;
}
function kategori_seo_kontrol ($sef, $kategori, $baslik, $mesaj = false) {
    if ($sef == $kategori)
    {
        echo "$mesaj ".$baslik;
    }
    return;
}
function tirnak($baslik){
    $baslik= htmlentities($baslik, ENT_QUOTES, "UTF-8");
    return $baslik;
}
// MAGAZA PAKET PERIYOT TOPLAM FIYAT
function magaza_paket_toplam($urun_id = true) {
    require('../sistem/baglan.php');
    $toplam_fiyat = $vt->query("SELECT * FROM magaza_paket_periyot WHERE periyot_paket_id = '$urun_id'")->fetchAll(PDO::FETCH_OBJ);
    $tutar = 0;
    foreach ($toplam_fiyat as $toplam) {
        $tutar = $tutar + $toplam->periyot_fiyat;
    }
    return $tutar;
}
// MAGAZA PAKET RESIM LIMIT
function m_paket_limit($uye_id, $bilgi)
{
    require('baglan.php');
    $uyelik_paket = $vt->query("SELECT * FROM magaza_uye_paket WHERE uye_id = '$uye_id' AND onay = '1'")->fetchAll(PDO::FETCH_OBJ);
    $limit = 0;
    foreach ($uyelik_paket as $paket)
    {
        $limit = $limit + $paket->$bilgi;
    }
    return $limit;
}
function tarihFarki ($tarih_1, $tarih_2)
{
    $tarih1= new DateTime($tarih_1);
    $tarih2= new DateTime($tarih_2);
    $interval= $tarih1->diff($tarih2);
    return $interval->format('%a');
}
// ILAN YAYIN SURESI
function ilanYayinSuresi($uye_id)
{
    require('baglan.php');
    $bugun = date("Y-m-d");
    $uye        = $vt->query("SELECT * FROM yonetici WHERE id = '{$uye_id}'")->fetch();
    $ilan       = $vt->query("SELECT * FROM emlak_ilan WHERE id = '{$ilan_id}'")->fetch();
    $paketler   = $vt->prepare("SELECT * FROM magaza_uye_paket WHERE uye_id = '{$uye_id}' AND onay = 1");
    $paketler->execute();
    $uye_paket      = $paketler->fetchAll(PDO::FETCH_ASSOC);
    if (m_paket_say($uye_id)>0)
    {
        // Uye Paketi Varsa
        $ilan_suresi = 0;
        foreach ($uye_paket as $paket)
        {
            $ilan_suresi = $ilan_suresi + $paket["ilan_sure"] * gun($paket["ilan_sure_zaman"]);
        }
        return $ilan_suresi;
        exit;
    }
    else
    {
        // Uye Paketi Yoksa
        // DANISMAN ISE
        if ($uye["yetki"] == 3)
        {
            $standart_ayar = $vt->query("SELECT * FROM uye_standart_ayar WHERE yetki = 'danisman'")->fetch();
            $ilan_suresi = $standart_ayar["ilan_sure"] * gun($standart_ayar["ilan_sure_zaman"]);
            return $ilan_suresi;
            exit;
        }
        // KURUMSAL ISE
        if ($uye["yetki"] == 2)
        {
            $standart_ayar = $vt->query("SELECT * FROM uye_standart_ayar WHERE yetki = 'kurumsal'")->fetch();
            $ilan_suresi = $standart_ayar["ilan_sure"] * gun($standart_ayar["ilan_sure_zaman"]);
            return $ilan_suresi;
            exit;
        }
        // BIREYSEL ISE
        if ($uye["yetki"] == 1)
        {
            $standart_ayar = $vt->query("SELECT * FROM uye_standart_ayar WHERE yetki = 'bireysel'")->fetch();
            $ilan_suresi = $standart_ayar["ilan_sure"] * gun($standart_ayar["ilan_sure_zaman"]);
            return $ilan_suresi;
            exit;
        }
        // YONETICI ISE
        if ($uye["yetki"] == 0)
        {
            $standart_ayar = $vt->query("SELECT * FROM uye_standart_ayar")->fetch();
            $ilan_suresi = 1000;
            return $ilan_suresi;
            exit;
        }
    }
}

// ILAN PAKET SURESI
function uyePaketSuresi($uye_id)
{
    require('baglan.php');
    $bugun = date("Y-m-d");
    $uye        = $vt->query("SELECT * FROM yonetici WHERE id = '{$uye_id}'")->fetch();
    $ilan       = $vt->query("SELECT * FROM emlak_ilan WHERE id = '{$ilan_id}'")->fetch();
    $paketler   = $vt->prepare("SELECT * FROM magaza_uye_paket WHERE uye_id = '{$uye_id}' AND onay = 1");
    $paketler->execute();
    $uye_paket      = $paketler->fetchAll(PDO::FETCH_ASSOC);
    if (m_paket_say($uye_id)>0)
    {
        // Uye Paketi Varsa
        $paket_suresi = 0;
        foreach ($uye_paket as $paket)
        {
            $paket_suresi = $ilan_suresi + $paket["periyot_sure"] * gun($paket["periyot_sure_zaman"]);
        }
        if ($paket_suresi == 0)
        {
            return 0;
        }
        else
        {
            return $paket_suresi;
        }
    }
}

// DANISMAN LIMIT
function danismanLimit($uye_id)
{
    require('baglan.php');
    $bugun = date("Y-m-d");
    $uye        = $vt->query("SELECT * FROM yonetici WHERE id = '{$uye_id}'")->fetch();
    $ilan       = $vt->query("SELECT * FROM emlak_ilan WHERE id = '{$ilan_id}'")->fetch();
    $paketler   = $vt->prepare("SELECT * FROM magaza_uye_paket WHERE uye_id = '{$uye_id}' AND onay = 1");
    $paketler->execute();
    $uye_paket      = $paketler->fetchAll(PDO::FETCH_ASSOC);
    if (m_paket_say($uye_id)>0)
    {
        // Uye Paketi Varsa
        $danisman_limit = 0;
        foreach ($uye_paket as $paket)
        {
            $danisman_limit = $danisman_limit + $paket["danisman_limit"];
        }
        return $danisman_limit;
        exit;
    }
    else
    {
        // Uye Paketi Yoksa
        // DANISMAN ISE
        if ($uye["yetki"] == 3)
        {
            $danisman_limit = 0;
            return $danisman_limit;
            exit;
        }
        // KURUMSAL ISE
        if ($uye["yetki"] == 2)
        {
            $standart_ayar = $vt->query("SELECT * FROM uye_standart_ayar WHERE yetki = 'kurumsal'")->fetch();
            $danisman_limit = $standart_ayar["danisman_limit"];
            return $danisman_limit;
            exit;
        }
        // BIREYSEL ISE
        if ($uye["yetki"] == 1)
        {
            $danisman_limit = 0;
            return $danisman_limit;
            exit;
        }
    }
}
// RESIM LIMIT
function uyeIlanResimLimit($uye_id)
{
    require('baglan.php');
    $bugun = date("Y-m-d");
    $uye        = $vt->query("SELECT * FROM yonetici WHERE id = '{$uye_id}'")->fetch();
    $ilan       = $vt->query("SELECT * FROM emlak_ilan WHERE id = '{$ilan_id}'")->fetch();
    $paketler   = $vt->prepare("SELECT * FROM magaza_uye_paket WHERE uye_id = '{$uye_id}' AND onay = 1");
    $paketler->execute();
    $uye_paket      = $paketler->fetchAll(PDO::FETCH_ASSOC);
    if (m_paket_say($uye_id)>0 AND uyePaketSuresi($uye_id)>0)
    {
        // Uye Paketi Varsa
        $resim_limit = 0;
        foreach ($uye_paket as $paket)
        {
            $resim_limit = $resim_limit + $paket["resim_limit"];
        }
        return $resim_limit;
        exit;
    }
    else
    {
        // Uye Paketi Yoksa
        // DANISMAN ISE
        if ($uye["yetki"] == 3)
        {
            $standart_ayar = $vt->query("SELECT * FROM uye_standart_ayar WHERE yetki = 'danisman'")->fetch();
            $resim_limit = $standart_ayar["resim_limit"];
            return $resim_limit;
            exit;
        }
        // KURUMSAL ISE
        if ($uye["yetki"] == 2)
        {
            $standart_ayar = $vt->query("SELECT * FROM uye_standart_ayar WHERE yetki = 'kurumsal'")->fetch();
            $resim_limit = $standart_ayar["resim_limit"];
            return $resim_limit;
            exit;
        }
        // BIREYSEL ISE
        if ($uye["yetki"] == 1)
        {
            $standart_ayar = $vt->query("SELECT * FROM uye_standart_ayar WHERE yetki = 'bireysel'")->fetch();
            $resim_limit = $standart_ayar["resim_limit"];
            return $resim_limit;
            exit;
        }
    }
}
// MAGAZA PAKET VARMI
function m_paket_say($uye_id)
{
    require('baglan.php');
    $uye_paket = $vt->prepare("SELECT * FROM magaza_uye_paket WHERE uye_id = '$uye_id' AND onay = 1");
    $uye_paket->execute();
    $paket_say = $uye_paket->rowCount();
    return $paket_say;
}
// MAGAZA PAKET VARMI ONAYSIZ
function mPaketOnaysiz($uye_id)
{
    require('baglan.php');
    $uye_paket = $vt->prepare("SELECT * FROM magaza_uye_paket WHERE uye_id = '$uye_id'");
    $uye_paket->execute();
    $paket_say = $uye_paket->rowCount();
    return $paket_say;
}
// ILAN RESIM SAY
function resim_say($emlak_no)
{
    require('../sistem/baglan.php');
    $emlak_resim = $vt->prepare("SELECT * FROM emlak_resim WHERE emlakno = '$emlak_no'");
    $emlak_resim->execute();
    $resim_say = $emlak_resim->rowCount();
    return $resim_say;
}
// MAGAZA TOPLAM DANISMAN SAYISI
function m_danisman_say($ofis_id)
{
    require('../sistem/baglan.php');
    $uye_paket = $vt->prepare("SELECT * FROM yonetici WHERE ofis = '$ofis_id' AND id != '".$_SESSION["id"]."'");
    $uye_paket->execute();
    $dan_say = $uye_paket->rowCount();
    return $dan_say;
}
// UYE TOPLAM ILAN SAYISI
function uye_ilan_say($uye_id)
{
    require('../sistem/baglan.php');
    $uye_ilan = $vt->prepare("SELECT * FROM emlak_ilan WHERE yonetici_id = '$uye_id'");
    $uye_ilan->execute();
    $ilan_say = $uye_ilan->rowCount();
    return $ilan_say;
}
// UYE PAKET ILAN SAYISI
function aktifIlanlar($uye_id)
{
    require('../sistem/baglan.php');
    $bugun = date("Y-m-d");

    // aylik farki bul
    $once = date("Y-m-d", strtotime('-30 days'));
    $sonra = date("Y-m-d", strtotime('-1 days'));

    // suresi dolan ilanlar
    $uye_ilan = $vt->prepare("SELECT * FROM emlak_ilan WHERE yonetici_id = '$uye_id' AND eklemetarihi BETWEEN '$once' AND '$sonra' AND durum = 0 AND onay = 1");
    $uye_ilan->execute();
    $say = $uye_ilan->rowCount();
    $uye = $uye_ilan->fetch(PDO::FETCH_ASSOC);

    return $say;

}
// AYLIK ILAN LIMITLERI
function ilanAylikLimit($uye_id)
{
    require('../sistem/baglan.php');
    $bugun = date("Y-m-d");

    // uyelik paketi toplamlari bul
    $paket_ilan = $vt->prepare("SELECT * FROM magaza_uye_paket WHERE onay = 1 AND bitis_tarihi  >'$bugun'");
    $paket_ilan->execute();
    $paket_say = $paket_ilan->rowCount();
    $ilan_paket_limiti = $paket_ilan->fetchAll(PDO::FETCH_ASSOC);

    $ilan_limiti_say = 0;
    foreach ($ilan_paket_limiti AS $limit)
    {
        $ilan_limiti_say = $ilan_limiti_say + $limit["aylik_limit"];
    }

    if (m_paket_say($uye_id)>0 AND uyePaketSuresi($uye_id)>0)
    {
        // Uye Paketi Varsa
        return $ilan_limiti_say;
    }
    else
    {
        // Uye Paketi Yoksa
        $uye = $vt->query("SELECT * FROM yonetici WHERE id = '$uye_id' AND durum = 0")->fetch();

        // DANISMAN ISE
        if ($uye["yetki"] == 3)
        {
            $standart_ayar = $vt->query("SELECT * FROM uye_standart_ayar WHERE yetki = 'danisman'")->fetch();
            $aylik_limit = $standart_ayar["aylik_limit"];
            return $aylik_limit;
        }
        // KURUMSAL ISE
        if ($uye["yetki"] == 2)
        {
            $standart_ayar = $vt->query("SELECT * FROM uye_standart_ayar WHERE yetki = 'kurumsal'")->fetch();
            $aylik_limit = $standart_ayar["aylik_limit"];
            return $aylik_limit;
        }
        // BIREYSEL ISE
        if ($uye["yetki"] == 1)
        {
            $standart_ayar = $vt->query("SELECT * FROM uye_standart_ayar WHERE yetki = 'bireysel'")->fetch();
            $aylik_limit = $standart_ayar["aylik_limit"];
            return $aylik_limit;
        }
    }



}
// UYE STANDART AYAR
function uye_standart_ayar($yetki, $limit_bilgi)
{
    if ($yetki == 0) {$yetki = "yonetici";}
    if ($yetki == 1) {$yetki = "bireysel";}
    if ($yetki == 2) {$yetki = "kurumsal";}
    if ($yetki == 3) {$yetki = "danisman";}
    require('../sistem/baglan.php');
    $uye_ayar = $vt->query("SELECT * FROM uye_standart_ayar WHERE yetki = '$yetki'")->fetch();
    return $uye_ayar["$limit_bilgi"];
}
// EMLAK KATEGORI ILAN DETAY OZELLIKLERI
function ilanOzellikDetay ($ilan_id, $veri) {
    require('sistem/baglan.php');
    $emlak_ilan_detay = $vt->query("SELECT * FROM emlak_ilandetay WHERE ilanid = '$ilan_id'")->fetch();
    return $emlak_ilan_detay[$veri];
}
// DOPING TOPLAM FIYAT
function doping_toplam($ilan) {
    require('../sistem/baglan.php');
    $toplam_fiyat = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '$ilan'")->fetchAll(PDO::FETCH_OBJ);
    $tutar = 0;
    foreach ($toplam_fiyat as $toplam) {
        $tutar = $tutar + $toplam->fiyat;
    }
    echo $tutar;
}
// DOPING TOPLAM ODENECEK FIYAT
function doping_toplam_odeme($ilan) {
    require('../sistem/baglan.php');
    $toplam_fiyat_odenecek = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '$ilan' AND odeme_durumu = 'Ödeme Bekliyor'")->fetchAll(PDO::FETCH_OBJ);
    $tutar_odenecek = 0;
    foreach ($toplam_fiyat_odenecek as $toplam_odenecek) {
        $tutar_odenecek = $tutar_odenecek + $toplam_odenecek->fiyat;
    }
    return $tutar_odenecek;
}
// DOPING TOPLAM ODENEN FIYAT
function doping_toplam_odenen($ilan) {
    require('../sistem/baglan.php');
    $toplam_fiyat = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '$ilan'")->fetchAll(PDO::FETCH_OBJ);
    $tutar = 0;
    foreach ($toplam_fiyat as $toplam) {
        $tutar = $tutar + $toplam->fiyat;
    }
    $toplam_fiyat_odenecek = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '$ilan' AND odeme_durumu = 'Ödeme Bekliyor'")->fetchAll(PDO::FETCH_OBJ);
    $tutar_odenecek = 0;
    foreach ($toplam_fiyat_odenecek as $toplam_odenecek) {
        $tutar_odenecek = $tutar_odenecek + $toplam_odenecek->fiyat;
    }
    $odenecek = $tutar - $tutar_odenecek;
    echo $odenecek;
}
// DOPING ADI GETIR
function doping_adi($ad) {
    require('../sistem/baglan.php');
    $doping_adi = $vt->query("SELECT * FROM doping_ilanlari WHERE doping_adi = '$ad'")->fetchAll(PDO::FETCH_OBJ);
    foreach ($doping_adi as $d) {
        if ($d->doping_adi=="sicak_firsat") {$adi = "Sıcak Fırsat";}
        if ($d->doping_adi=="vitrin_ilan") {$adi = "Vitrin İlan";}
        if ($d->doping_adi=="one_cikan") {$adi = "Öne Çıkan";}
        if ($d->doping_adi=="ust_sira") {$adi = "Üst Sıra";}
        if ($d->doping_adi=="renkli_bold") {$adi = "Renli Kalın Yazı ";}
        if ($d->doping_adi=="acil_ilan") {$adi = "Anasayfa Acil";}
    }
    return $adi;
}

###### UYELIK AYARLARI ######################################################################################################
function yetki()
{
    global $vt;
    // UYE YETKILERI
    $uyelik_yetki = $vt->query("SELECT * FROM yonetici WHERE id = '".$_SESSION["id"]."'")->fetch();
    $uye_yetki = $uyelik_yetki["yetki"];
    return $uye_yetki;
}
function yetkiAdi()
{
    if (yetki()==0)
    {
        echo "Yönetici";
    }
    if (yetki()==1)
    {
        echo "Bireysel Üye";
    }
    if (yetki()==2)
    {
        echo "Kurumsal Üye";
    }
    if (yetki()==3)
    {
        echo "Danışman";
    }

}
// IKI TARIH ARASINDAKI FARK
function fark_bul($tarih1, $tarih2)
{
    if (!preg_match("@\.@",$tarih1) || !preg_match("@\.@",$tarih2)) exit('Standart Format: 01.01.1970');
    list($gun1,$ay1,$yil1) = explode('.',$tarih1);
    list($gun2,$ay2,$yil2) = explode('.',$tarih2);
    $tarih1_timestamp = mktime('0','0','0',$ay1,$gun1,$yil1);
    $tarih2_timestamp = mktime('0','0','0',$ay2,$gun2,$yil2);
    if ($tarih1_timestamp > $tarih2_timestamp){
        $fark = ($tarih1_timestamp - $tarih2_timestamp) / 86400;
    }
    if ($tarih2_timestamp > $tarih1_timestamp){
        $fark = ($tarih2_timestamp - $tarih1_timestamp) / 86400;
    }
    return $fark;
}
// MySQL VERI CEK
function veri($mysql_adi, $tablo, $id = true, $tablo_adi = true) {
    require('../sistem/baglan.php');
    $data   = $vt->query("SELECT * FROM $mysql_adi WHERE $tablo = '$id'")->fetchAll(PDO::FETCH_OBJ);
    foreach ($data as $d) {
        return $d->$tablo_adi;
    }
    return;
}
function paket_kalan($bitis_tarihi)
{
    $bugun = date("Y-m-d");
    if ($bitis_tarihi<$bugun) {
        echo "Süresi Doldu";
    } else {
        echo $bitis_tarihi;
    }
    return;
}
function bitis_tarihi($baslangic_tarihi, $sure=true) {
    $bugun =date("Y-m-d");
    $baslangic_tarihi = strtotime(''.$sure.' day',strtotime($bugun));
    $baslangic_tarihi = date('Y-m-d' , $baslangic_tarihi);
    return $baslangic_tarihi;
}
function toplam_sure($par1=0, $par2=0) {
    if ($par2=="Gün") {$par2 = "1";}
    if ($par2=="Ay") {$par2 = "31";}
    if ($par2=="Yıl") {$par2 = "365";}
    $sure = $par1;
    $zaman = $par2;
    $t_sure = $sure * $zaman;
    return $t_sure;
}
function gecen_sure($ekleme_tarihi, $bugun) {
    $tarih1 = new DateTime($ekleme_tarihi);
    $tarih2 = new DateTime($bugun);
    $interval = $tarih1->diff($tarih2);
    return $interval->format('%a');

};
function kalan_sure($tarih = true, $bitis_tarihi = true) {
    $tarih1 = new DateTime($tarih);
    $tarih2 = new DateTime($bitis_tarihi);
    $interval = $tarih1->diff($tarih2);
    echo $interval->format('%a');
    return;
};
function gun($gun = true) {
    if ($gun=="Gün") {$gun = "1";}
    if ($gun=="Ay") {$gun = "31";}
    if ($gun=="Yıl") {$gun = "365";}
    return $gun;
    return;
}
function p($par, $st = false) {
    if ($st) {
        return htmlspecialchars(addcslashes(trim($_POST[$par])));
    } else {
        return addslashes(trim($_POST[$par]));
    }
}
function g($par) {
    return @strip_tags(trim(addslashes($_GET[$par])));
}
function kisalt($par, $uzunluk = 50) {
    if (strlen($par) > $uzunluk) {
        $par = mb_substr($par, 0, $uzunluk, "UTF-8")."..";
    }
    return $par;
}
function go($par, $time = 0) {
    if ($time == 0) {
        header("location:{$par}");
    } else {
        header("Refresh: {$time}; url={$par}");
    }
}
function session($par) {
    if ($_SESSION[$par]) {
        return $_SESSION[$par];
    } else {
        return false;
    }
}
function session_olustur($par) {
    foreach ($par as $anahtar => $deger) {
        $_SESSION[$anahtar] = $deger;
    }
}
function seo($url) {
    $turkcefrom = array("/Ğ/","/Ü/","/Ş/","/İ/","/Ö/","/Ç/","/ğ/","/ü/","/ş/","/ı/","/ö/","/ç/");
    $turkceto = array("G","U","S","I","O","C","g","u","s","i","o","c");
    $url = preg_replace("/[^0-9a-zA-ZÄzÜŞİÖÇğüşıöç]/"," ",$url);
    // Türkçe harfleri ingilizceye çevir
    $url = preg_replace($turkcefrom,$turkceto,$url);
    // Birden fazla olan boşlukları tek boşluk yap
    $url = preg_replace("/ +/"," ",$url);
    // Boşukları - işaretine çevir
    $url = preg_replace("/ /","-",$url);
    // Tüm beyaz karekterleri sil
    $url = preg_replace("/\s/","",$url);
    // Karekterleri küçült
    $url = strtolower($url);
    // Başta ve sonda - işareti kaldıysa yoket
    $url = preg_replace("/^-/","",$url);
    $url = preg_replace("/-$/","",$url);
    return $url;
}
function query($query) {
    global $vt;
    return $vt->query($query);
}
function row($query) {
    return $query->fetch(PDO::FETCH_BOTH);
}
function rows($query) {
    return $query->rowCount();
}
// onay fonksiyonu
function onay($mesaj = false) {
    if ($mesaj) {
        echo '
            <div class="text-center alert alert-success alert-dismissible">
                <h6> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> </h6>
                <h6> <i class="icon fa fa-check"></i> '.$mesaj.' </h6>
            </div>
            ';
    } else {
        echo '
                <div class="alert alert-success alert-dismissible">
                    <h6> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> </h6>
                    <div class="text-center">
                        <h6> <i class="icon fa fa-check"></i> İşlemleriniz başarıyla gerçekleştirilmiştir. </h6>
                    </div>
                </div>
            ';
    }
}
function hata($mesaj = false) {
    if ($mesaj) {
        echo '
                <div class="text-center alert alert-default alert-dismissible h6">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                     <i class="icon fa fa-info-circle"></i> '.$mesaj.'
                </div>
                ';
    } else {
        echo '
                <div class="alert alert-danger alert-dismissible h4">
                    <h6> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> </h6>
                    <div class="text-center">
                        <h5> <i class="icon fa fa-info-circle"></i> İşlemde bir hata oluştu. </h5>
                    </div>
                </div>
                ';
    }
};
function hata_alert($msg = true) {
    if (empty($msg)) {
        echo "<script type='text/javascript'>İşlemleriniz başarıyla gerçekleştirilmiştir.</script>";
    } else {
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
}
function onay_alert($msg = true) {
    if (empty($msg)) {
        echo "<script type='text/javascript'>İşlemleriniz başarıyla gerçekleştirilmiştir.</script>";
    } else {
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
}
// WATERMARK FONKSIYONU
function watermark_image($image, $output) {
    $path = "../uploads/resim";
    @$info = getimagesize($image);
    $resimW = $info[0];
    $resimH = $info[1];
    switch ($info['mime']) {
        case 'image/jpeg';
            $main = imagecreatefromjpeg($image);
            break;
        case 'image/png';
            $main = imagecreatefrompng($image);
            break;
        case 'image/gif';
            $main = imagecreatefromgif($image);
            break;
        default:
            return false;
    }
    $yuzde = "100%";
    imagealphablending($main, true);
    $overlay = @imagecreatefrompng("$path/watermark.png");
    @imagecopy($main, $overlay, abs(300), abs(300), abs(0), abs(0), imagesx($overlay), imagesy($overlay));
    @imagepng($main, $output);
    @imagedestroy($main);
    @imagedestroy($overlay);
}
// Resim Üzerine Logo Ekleme //
function resim_damga($resim, $damga_resmi, $yeni_resim_adi)
{
    $foto = imagecreatefromjpeg($resim);
    $damga = imagecreatefrompng($damga_resmi);
    // Damganın kenar boşluklarını ayarlayıp resmin
    // yükseklik ve genişliğini alalım
    $sag_bosluk = 10;
    $alt_bosluk = 10;
    $sx = imagesx($damga);
    $sy = imagesy($damga);
    $ressx = imagesx($foto);
    $ressy = imagesy($foto);
    $sag_bosluk = $ressx/2;
    $alt_bosluk = $ressy/2;
    $sag_bosluk = $sag_bosluk-150;
    $alt_bosluk = $alt_bosluk-100;
    // Damga resmini koordinatları belirterek kenar boşlukları ile
    // birlikte fotoğrafın üzerine kopyalayalım.
    imagecopy($foto, $damga, imagesx($foto) - $sx - $sag_bosluk, imagesy($foto) - $sy - $alt_bosluk, 0, 0, imagesx($damga), imagesy($damga));
    // Sonucu çıktılayıp belleği serbest bırakalım.
    imagepng($foto, $yeni_resim_adi);
    imagedestroy($foto);
    $foto2 = imagecreatefrompng($resim);
    $damga = imagecreatefrompng($damga_resmi);
    // Damganın kenar boşluklarını ayarlayıp resmin
    // yükseklik ve genişliğini alalım
    $sag_bosluk = 10;
    $alt_bosluk = 10;
    $sx = imagesx($damga);
    $sy = imagesy($damga);
    $ressx = imagesx($foto2);
    $ressy = imagesy($foto2);
    $sag_bosluk = $ressx/2;
    $alt_bosluk = $ressy/2;
    $sag_bosluk = $sag_bosluk-150;
    $alt_bosluk = $alt_bosluk-100;
    // Damga resmini koordinatları belirterek kenar boşlukları ile
    // birlikte fotoğrafın üzerine kopyalayalım.
    imagecopy($foto2, $damga, imagesx($foto2) - $sx - $sag_bosluk, imagesy($foto2) - $sy - $alt_bosluk, 0, 0, imagesx($damga), imagesy($damga));
    // Sonucu çıktılayıp belleği serbest bırakalım.
    imagepng($foto2, $yeni_resim_adi);
    imagedestroy($foto2);
}
function rakam($sayi) {
    $bicimlendir = number_format($sayi,0,"",".");
    return $bicimlendir;
}
function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
function clean($text)
{
    $text = str_replace("/s+/", "", $text);
    $text = str_replace(" ", "", $text);
    $text = str_replace(" ", "", $text);
    $text = str_replace(" ", "", $text);
    $text = str_replace("/s/g", "", $text);
    $text = str_replace("/s+/g", "", $text);
    $text = str_replace("(", "", $text);
    $text = str_replace(")", "", $text);
    $text = trim($text);
    return $text;
}
function html($title){
    $title= htmlentities($title, ENT_QUOTES, "UTF-8");
    return $title;
}
function html_encode($title){
    $title=html_entity_decode($title, ENT_QUOTES);
    return $title;
} 
?>


