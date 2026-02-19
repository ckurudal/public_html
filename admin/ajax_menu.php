<?php 
	require "../sistem/baglan.php";  	

	$ilid = $_POST["il"]; 

	echo '<option>Seçiniz</option>';

	$ilceler = $vt->query("SELECT * FROM ilce where ilce_sehirkey = '$ilid'"); 
	
	while($ilce=$ilceler->fetch()) { 	

		echo '<option value="'.$ilce["ilce_key"].'">'.$ilce["ilce_title"].'</option>';

	}

	$ilceid = $_POST["ilce"];

	$mahalleler = $vt->query("SELECT * FROM mahalle where mahalle_ilcekey = '$ilceid'"); 
	
	while($mahalle=$mahalleler->fetch()) { 	

		echo '<option value="'.$mahalle["mahalle_id"].'">'.$mahalle["mahalle_title"].'</option>';

	}

	// mahalle arama 

	$ilsec = $_POST["ilsec"];  

	$ilceler2 = $vt->query("SELECT * FROM ilce where ilce_sehirkey = '$ilsec'"); 
	
	while($ilce=$ilceler2->fetch()) { 	

		echo '<option value="'.$ilce["ilce_key"].'">'.$ilce["ilce_title"].'</option>';

	}
?>
