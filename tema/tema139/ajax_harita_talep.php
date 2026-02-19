<?php 
	require "sistem/baglan.php";  	

	$ilid = $_POST["il"]; 

	echo '<option>Seçiniz</option>';

	$stmt_ilce = $vt->prepare("SELECT * FROM ilce where ilce_sehirkey = ?");
	$stmt_ilce->execute([$ilid]);
	while($ilce = $stmt_ilce->fetch()) { 	
		echo '<option value="'.$ilce["ilce_key"].'">'.$ilce["ilce_title"].'</option>';
	}

	$ilceid = $_POST["ilce"];

	$stmt_mah = $vt->prepare("SELECT * FROM mahalle where mahalle_ilcekey = ?");
	$stmt_mah->execute([$ilceid]);
	while($mahalle = $stmt_mah->fetch()) { 	
		echo '<option value="'.$mahalle["mahalle_id"].'">'.$mahalle["mahalle_title"].'</option>';
	}

	// mahalle arama 

	$ilsec = $_POST["ilsec"];  

	$stmt_ilce2 = $vt->prepare("SELECT * FROM ilce where ilce_sehirkey = ?");
	$stmt_ilce2->execute([$ilsec]);
	while($ilce = $stmt_ilce2->fetch()) { 	
		echo '<option value="'.$ilce["ilce_key"].'">'.$ilce["ilce_title"].'</option>';
	}
?>
