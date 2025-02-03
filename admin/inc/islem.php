<?php
	
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
	
	$emlak 		= @$_GET["emlak"];
	$ofis 		= @$_GET["ofis"];
	$resim 		= @$_GET["resim"];
	$ajax		= @$_GET["ajax"];
	$ayarlar 	= @$_GET["ayarlar"];
	$uyeler		= @$_GET["uyeler"];
	$icerik		= @$_GET["icerik"];
	$webmaster	= @$_GET["webmaster"];
	$magaza		= @$_GET["magaza"];
	$doping		= @$_GET["doping"];

	// siparisler

	if (@$siparisler == "siparisler") {
		include ("inc/siparisler/siparisler.php");
	}

	// magaza ayarlari

	if ($magaza == "magaza_paketleri") {
		include ("inc/magaza/magaza_paketleri.php");
	}

	// doping ayarlari

	if ($doping == "doping_ayarlari") {
		include ("inc/doping/doping_ayarlari.php");
	}

	// doping ayarlari

	if ($doping == "dopingler") {
		include ("inc/doping/dopingler.php");
	}

	// doping ayarlari

	if ($doping == "ilan_doping") {
		include ("inc/doping/ilan_doping.php");
	}

	// magaza ayarlari

	if ($magaza == "uye_paket_duzenle") {
		include ("inc/magaza/uye_paket_duzenle.php");
	}

	// emlak ekle
	if ($emlak == "emlak_ekle") {
		include ("inc/emlak/emlak_ekle.php");
	}

	// emlak duzenle
	if ($emlak == "emlak_duzenle") {
		include ("inc/emlak/emlak_duzenle.php");
	}

	// emlak resim duzenle
	if ($emlak == "emlak_resim") {
		include ("inc/emlak/emlak_resim.php");
	}

	// tum ilanlar
	if ($emlak == "emlak_ilanlar") {
		include ("inc/emlak/emlak_ilanlar.php");
	}

	// favori listem
	if ($emlak == "emlak_favoriler") {
		include ("inc/emlak/emlak_favoriler.php");
	}

	// anasayfa vitrin ilanlar
	if ($emlak == "emlak_anavitrin") {
		include ("inc/emlak/vitrin_emlak_anavitrin.php");
	}

	// kategori vitrin ilanlar
	if ($emlak == "emlak_katvitrin") {
		include ("inc/emlak/vitrin_emlak_katvitrin.php");
	}

	// firsat vitrin ilanlar
	if ($emlak == "emlak_firsatvitrin") {
		include ("inc/emlak/vitrin_emlak_firsatvitrin.php");
	}

	// acil emlak vitrin ilanlar
	if ($emlak == "emlak_acilvitrin") {
		include ("inc/emlak/vitrin_emlak_acilvitrin.php");
	}

	// onecikan vitrin ilanlar
	if ($emlak == "emlak_onecikan") {
		include ("inc/emlak/vitrin_emlak_onecikan.php");
	}

	// emlak ekle kategori sec
	if ($emlak == "emlak_sec") {
		include ("inc/emlak/emlak_sec.php");
	}

	// emlak formlari
	if ($emlak == "emlak_form") {
		include ("inc/emlak/emlak_form.php");
	}

	// emlak ozellik tipleri
	if ($emlak == "emlak_ozelliktip") {
		include ("inc/emlak/emlak_ozelliktip.php");
		$aktif="aktif";
	}

	// emlak ozellikleri
	if ($emlak == "emlak_ozellikleri") {
		include ("inc/emlak/emlak_ozellikleri.php");
	}

	// ilan Tipi

	if ($emlak=="emlak_ilantipi") {
		include ("inc/emlak/emlak_ilantipi.php");
	}

	// ilan Sahibi

	if ($emlak=="emlak_sahibi") {
		include ("inc/emlak/emlak_sahibi.php");
	}

	// ilan sekilleri

	if ($emlak=="emlak_ilansekli") {
		include ("inc/emlak/emlak_ilansekli.php");
	}

	// emlak kategori
	if ($emlak == "kategori") {
		include ("inc/emlak/kategori.php");
	}

	// emlak kategori ekle
	if ($emlak == "kategori_ekle") {
		include ("inc/emlak/kategori_ekle.php");
	}

	// emlak kategori duzenle
	if ($emlak == "kategori_duzenle") {
		include ("inc/emlak/kategori_duzenle.php");
	}

	// emlak iller
	if ($emlak == "iller") {
		include ("inc/emlak/emlak_iller.php");
	}

	// emlak iller ekle
	if ($emlak == "ilyonet") {
		include ("inc/emlak/emlak_iller_ekle.php");
	}

	// emlak ilceler
	if ($emlak == "ilceler") {
		include ("inc/emlak/emlak_ilceler.php");
	}

	// emlak ilceler yonet
	if ($emlak == "ilceyonet") {
		include ("inc/emlak/emlak_ilceler_ekle.php");
	}

	// emlak semt/mahalle yonet
	if ($emlak == "mahallebul") {
		include ("inc/emlak/emlak_mahalle_ara.php");
	}

	// ajax ile cek
	if ($emlak == "ajax") {
		include ("inc/ajax.php");
	}

	// subeler
	if ($ofis == "subeler") {
		include ("inc/ofis/subeler.php");
	}

	// sube ekle
	if ($ofis == "subeekle") {
		include ("inc/ofis/sube_ekle.php");
	}

	// yonetici / danisman ekle
	if ($ofis == "yonetici") {
		include ("inc/ofis/yonetici_islem.php");
	}

	// yonetici / danisman ekle
	if ($ofis == "yoneticiunvan") {
		include ("inc/ofis/yonetici_unvan.php");
	}

	// ayar / sosyal medya hesaplari
	if ($ayarlar == "ayarsosyal") {
		include ("inc/ayar/ayar_sosyal.php");
	}

	// ayar / site logo
	if ($ayarlar == "ayarlogo") {
		include ("inc/ayar/sitelogo.php");
	}

	// ayar / mobil site logo
	if ($ayarlar == "mobilsitelogo") {
		include ("inc/ayar/mobilsitelogo.php");
	}

	// ayar / favicon
	if ($ayarlar == "favicon") {
		include ("inc/ayar/favicon.php");
	}

	// ayar / odeme ayarlari
	if ($ayarlar == "paytr_api") {
		include ("inc/ayar/paytr_api.php");
	}

	// ayar / watermark ekleme
	if ($ayarlar == "watermark") {
		include ("inc/ayar/watermark.php");
	}

	// ayar / iletisim bilgileri
	if ($ayarlar == "iletisim") {
		include ("inc/ayar/iletisim.php");
	}

	// ayar / harita lokasyon bilgileri
	if ($ayarlar == "haritaadres") {
		include ("inc/ayar/haritaadres.php");
	}

	// ayar / smtp ayar
	if ($ayarlar == "mailayar") {
		include ("inc/ayar/mailayar.php");
	}

	// ayar / sms ayar
	if ($ayarlar == "smsayar") {
		include ("inc/ayar/smsayar.php");
	}

	// ayar / gorunum ayar
	if ($ayarlar == "gorunumayar") {
		include ("inc/ayar/gorunumayar.php");
	}

	// ayar / tema ayar
	if ($ayarlar == "temaayar") {
		include ("inc/ayar/temaayar.php");
	}


	// reklam / reklam
	if ($ayarlar == "reklam") {
		include ("inc/reklam/reklam_alanlari.php");
	}

	// webmaster / analytics
	if ($webmaster == "uyelik_sozlesmesi") {
		include ("inc/ayar/uyelik_sozlesmesi.php");
	}

	// webmaster / analytics
	if ($webmaster == "analyticsapi") {
		include ("inc/ayar/analyticsapi.php");
	}

	// webmaster / yandex
	if ($webmaster == "yandex") {
		include ("inc/ayar/yandex.php");
	}

	// webmaster / canli destek
	if ($webmaster == "canlidestek") {
		include ("inc/ayar/canlidestek.php");
	}

	// webmaster / dogrulama
	if ($webmaster == "dogrulama") {
		include ("inc/ayar/dogrulama.php");
	}

	// webmaster / meta head kod ekle
	if ($webmaster == "metakod") {
		include ("inc/ayar/metakod.php");
	}

	// webmaster / jscript ekleme
	if ($webmaster == "jscript") {
		include ("inc/ayar/jscript.php");
	}

	// uyeler
	if ($uyeler == "uyeler") {
		include ("inc/uyeler/uyeler.php");
	}

	// uye standart ayarlar
	if ($uyeler == "uye_standart_ayar") {
		include ("inc/uyeler/uye_standart_ayar.php");
	}

	// sayfa kategori
	if ($icerik == "sayfakategori") {
		include ("inc/icerik/sayfakategori.php");
	}

	// sayfa icerik
	if ($icerik == "sayfa") {
		include ("inc/icerik/sayfa.php");
	}

	// haber kategori
	if ($icerik == "haberkategori") {
		include ("inc/icerik/haberkategori.php");
	}

	// haber icerik
	if ($icerik == "haber") {
		include ("inc/icerik/haber.php");
	}

	// blog kategori
	if ($icerik == "blogkategori") {
		include ("inc/icerik/blogkategori.php");
	}

	// blog icerik
	if ($icerik == "blog") {
		include ("inc/icerik/blog.php");
	}

	// ust menu yonetimi
	if ($icerik == "ustmenu") {
		include ("inc/icerik/ustmenu.php");
	}

	// alt menu yonetimi
	if ($icerik == "altmenu") {
		include ("inc/icerik/altmenu.php");
	}

	// slayt yonetimi
	if ($icerik == "slider") {
		include ("inc/icerik/slider.php");
	}

	// slayt yonetimi
	if ($icerik == "sayfamodul") {
		include ("inc/icerik/sayfamodul.php");
	}

	// bildirim emlak mesaj
	if ($icerik == "emlakmesaj") {
		include ("inc/bildirim/emlakmesaj.php");
	}


?>
