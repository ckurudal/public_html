<?php

	$sayfa_adi = $_SERVER[REQUEST_URI]; 

	$sef = explode("/", $sayfa_adi);

?>

<div class="card-header">
	<h4><strong>BANA ÖZEL</strong></h4>
</div>
<div class="list-catergory">
    <div class="item-list">

    	<div class="item1-links mb-0">
		    <a href="/uyeligim" class="<?php if ($sef[1] == "uyeligim") { ?> active <?php } ?> d-flex border-bottom">
		        <span class="icon1 mr-3"><i class="icon icon-user"></i></span> Üyeliğim 
		    </a>
		    <a href="/ilanlarim" class="<?php if ($sef[1] == "ilanlarim" || $onay == "aktif" || $onay == "pasif" || $onay == "bekleyen") { ?> active <?php } ?> d-flex border-bottom">
		        <span class="icon1 mr-3"><i class="icon icon-diamond"></i></span> İlanlarım
		    </a>
		    <a href="/magaza-paketim" class="<?php if ($sef[1] == "magaza-paketim") { ?> active <?php } ?> d-flex border-bottom">
		        <span class="icon1 mr-3"><i class="icon icon-folder-alt"></i></span> Mağaza Paketim
		    </a>
		    <a href="/danismanlarim/<?php echo $_SESSION["id"]; ?>" class="<?php if ($sef[1] == "danismanlarim" || $ayar == "danisman-duzenle" || $ayar == "yeni-danisman-ekle" || $ayar == "danisman-listesi") { ?> active <?php } ?> d-flex border-bottom">
		        <span class="icon1 mr-3"><i class="icon icon-user"></i></span> Danışmanlarım
		    </a>
		    <a href="/gelen-mesajlar" class="<?php if ($sef[1] == "gelen-mesajlar" || $ayar == "gelenmesaj" || $ayar == "danismanmesaj" || $ayar == "ofisgelenmesaj" || $ayar == "ilanmesaj") { ?> active <?php } ?> d-flex border-bottom">
		        <span class="icon1 mr-3"><i class="icon icon-envelope"></i></span> Mesajlarım
		    </a>
		    <a href="/dopinglerim" class="<?php if ($sef[1] == "dopinglerim") { ?> active <?php } ?> d-flex border-bottom">
		        <span class="icon1 mr-3"><i class="icon icon-rocket"></i></span> Dopinglerim
		    </a>
		    <a href="/odeme-ayarlari" class="<?php if ($sef[1] == "odeme-ayarlari") { ?> active <?php } ?> d-flex border-bottom">
		        <span class="icon1 mr-3"><i class="icon icon-credit-card"></i></span> Ödemelerim
		    </a>
		    <a href="/sifredegistir" class="<?php if ($sef[1] == "sifredegistir") { ?> active <?php } ?> d-flex border-bottom">
		        <span class="icon1 mr-3"><i class="icon icon-key"></i></span> Şifre Değiştir
		    </a>
		    <a href="/sosyalmedya" class="<?php if ($sef[1] == "sosyalmedya") { ?> active <?php } ?> d-flex border-bottom">
		        <span class="icon1 mr-3"><i class="icon icon-list"></i></span> Sosyal Medya Hesapları
		    </a>
		    <a href="#" class="d-flex">
		        <span class="icon1 mr-3"><i class="icon icon-power"></i></span> Güvenli Çıkış
		    </a>
		</div>
    </div>
</div>