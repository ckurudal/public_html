<?php 
 	include('header.php');
 	include('alt.php');
 	global $vt;
 	$favorix = $_GET["favori"];  
 	$ilanId = $_GET["ilanId"];  
 	$uyeId = $_GET["uyeId"];   
   
    if ($favorix=="ekle") {
        $favoriEkle = $vt->prepare("INSERT INTO favoriler SET uye_id = ?, ilan_id = ?");
        $favoriEkle -> execute(array($uyeId,$ilanId)); 
    }
    
    if ($favorix=="sil") { 
        $favoriSil = $vt->exec("DELETE FROM favoriler WHERE ilan_id = '{$ilanId}' AND uye_id = '{$uyeId}' ")->fetch(); 
    }  

?> 