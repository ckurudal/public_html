<?php
	$ayarlar=@$_GET["ayarlar"];
	$webmaster=@$_GET["webmaster"];
?>

<?php 
	if (!$webmaster) {
?>
<div class="box box-info">
	<div class="box-header with-border">
	  <h4 class="box-title"> <i class="fa fa-edit"></i> Diğer Ayarlar </h4>
	</div>
	<div class="right-menu">
		<ul class="nav nav-navbar">					
			<li><a href="index.php?do=ayarsite"><i class="fa fa-angle-right"></i> Site Ayarları </a></li>            
            <li> <a href="index.php?do=ayar/sitelogo"> <i class="fa fa-image"></i> Site Logo </a> </li> 
            <li> <a href="index.php?do=ayar/mobilsitelogo"> <i class="fa fa-camera"></i> Mobil Site Logo </a> </li>
            <li> <a href="index.php?do=ayar/favicon"> <i class="fa fa-superpowers"></i> Favicon </a> </li>
            <li> <a href="index.php?do=ayar/watermark"> <i class="fa fa-binoculars"></i> Filigran / Watermark </a> </li>
            <li> <a href="index.php?do=ayar/iletisim"> <i class="fa fa-envelope"></i> İletişim Bilgileri </a> </li>
            <li> <a href="index.php?do=ayar/haritaadres"> <i class="fa fa-map-marker"></i> Harita/Lokasyon İşaretle </a> </li>
            <li> <a href="index.php?do=ayar/ayar_sosyal"> <i class="fa fa-share-alt"></i> Sosyal Medya Siteleri </a> </li>
            <!-- <li> <a href="index.php?do=ayar/mailayar"> <i class="fa fa-envelope-o"></i> SMTP Mail Yapılandırması </a> </li> -->
            <!-- <li> <a href="index.php?do=ayar/smsayar"> <i class="fa fa-commenting-o"></i> SMS Entegrasyonu </a> </li> -->           
            
            <!-- <li> <a href=""> <i class="fa fa-plug"></i> Modül Ayarları </a> </li> -->
            <!-- <li> <a href=""> <i class="fa fa-language"></i> Yabancı Dil Yönetimi </a> </li> -->					
		</ul>
	</div> 
</div>
<?php } ?>

<?php 
	if ($webmaster) {
?>
<div class="box box-info">
	<div class="box-header with-border">
	  <h4 class="box-title"> <i class="fa fa-edit"></i> Diğer Ayarlar </h4>
	</div>
	<div class="right-menu">
		<ul class="nav nav-navbar">					
			<li>
                <a href="index.php?do=islem&webmaster=analyticsapi">
                    <i class="fa fa-angle-right"></i> Google Analytics </a>
            </li>
            <li>
                <a href="index.php?do=islem&webmaster=yandex">                
                    <i class="fa fa-angle-right"></i> Yandex Metrica </a>
            </li>
            <li>
                <a href="index.php?do=islem&webmaster=canlidestek">
                    <i class="fa fa-angle-right"></i> Canlı Destek </a>
            </li>
            <li>
                <a href="index.php?do=islem&webmaster=dogrulama">
                    <i class="fa fa-angle-right"></i> Site Doğrulama </a>
            </li>
            <li>
                <a href="index.php?do=islem&webmaster=metakod">
                    <i class="fa fa-angle-right"></i> Meta Kodu Ekleyici </a>
            </li>					
            <li>
                <a href="index.php?do=islem&webmaster=jscript">
                    <i class="fa fa-angle-right"></i> Javascript Kodu Ekleyici </a>
            </li>
		</ul>
	</div> 
</div>
<?php } ?>