<?php
	$gelen = $_GET["gelen"];
	$ilan_id = $_GET["ilan_id"];
	$odeme_kodu = $_GET["odeme_kodu"];
	$orderNo = $_GET["orderNo"];
	include("../sistem/baglan.php");
	$odeme_sayfasi = $_GET["odeme_sayfasi"];
	$paytr_api = $vt->query("SELECT * FROM odeme_paytr")->fetch();
	$post = $_POST;
	$merchant_key 	= $paytr_api["merchant_key"];
	$merchant_salt	= $paytr_api["merchant_salt"];	
	$hash = base64_encode(hash_hmac('sha256',$post['merchant_oid'].$merchant_salt.$post['status'].$post['total_amount'],$merchant_key,true) );
	$dr = $post['status'];
	if($dr == 'success'){
		echo "OK";
	}
	function go($par, $time = 0) {
		if ($time == 0) {
			header("location:{$par}");
		} else {
			header("Refresh: {$time}; url={$par}");
		}
	}
	if ($gelen == "magaza") {
		$siparis_onay = $vt->query("UPDATE magaza_uye_paket SET onay = '1' WHERE siparis_no = '".$odeme_sayfasi."'");
		go("".$site["url"]."/m/index.php?do=siparisler/siparisler&paket=magaza&siparis=onay",0); 
	}
	if ($gelen == "doping") {
		$siparis_onay = $vt->query("UPDATE doping_ilanlari SET odeme_durumu = 'Ödendi', siparis_no = '".$odeme_kodu."' WHERE ilan_id = '".$ilan_id."'");	
		$siparis_onay = $vt->query("UPDATE emlak_ilan SET doping_onay = '1'WHERE id = '".$ilan_id."'");	
		go("".$site["url"]."/m/index.php?do=islem&ofis=yonetici&islem=duzenle&id={$_SESSION["id"]}&tab_goster=dopingleri",0);
	}
	if ($gelen == "odaKirala") { 
	    echo $orderNo;
		$siparis_onay = $vt->query("UPDATE siparis_oda SET siparis_odeme = 'Ödendi' WHERE siparis_no = '".$orderNo."'");
		
		if ($siparis_onay==true) {
		    go("/index.php",0);
		} else { 
		    echo "Bir sorun oluştu.";
		} 
	}
?>