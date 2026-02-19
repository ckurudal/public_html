<?php 
    require "sistem/baglan.php";  

    $ilid = $_POST["il"] ?? '';
    $ilid = trim(strip_tags($ilid));

    echo '<option value="">Seçiniz</option>';
 
    $stmt = $vt->prepare("SELECT * FROM ilce WHERE ilce_sehirkey = ?");
    $stmt->execute([$ilid]);
    while($ilce = $stmt->fetch()) {  
        echo '<option value="'.htmlspecialchars($ilce["ilce_key"]).'">'.htmlspecialchars($ilce["ilce_title"]).'</option>';
    }

    $ilceid = $_POST["ilce"] ?? '';
    $ilceid = trim(strip_tags($ilceid));

    $stmt2 = $vt->prepare("SELECT * FROM mahalle WHERE mahalle_ilcekey = ?");
    $stmt2->execute([$ilceid]);
    while($mahalle = $stmt2->fetch()) {
        echo '<option value="'.htmlspecialchars($mahalle["mahalle_id"]).'">'.htmlspecialchars($mahalle["mahalle_title"]).'</option>';
    }

    $ilsec = $_POST["ilsec"] ?? '';
    $ilsec = trim(strip_tags($ilsec));

    $stmt3 = $vt->prepare("SELECT * FROM ilce WHERE ilce_sehirkey = ?");
    $stmt3->execute([$ilsec]);
    while($ilce = $stmt3->fetch()) { 
        echo '<option value="'.htmlspecialchars($ilce["ilce_key"]).'">'.htmlspecialchars($ilce["ilce_title"]).'</option>';
    }
?>
