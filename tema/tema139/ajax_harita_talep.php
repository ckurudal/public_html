<?php 
	require "sistem/baglan.php";  	

	$ilid = $_POST["il"]; 

	echo '<option>Seçiniz</option>';

	$ilceler = mysql_query("SELECT * FROM ilce where ilce_sehirkey = '$ilid'"); 
	
	while($ilce=mysql_fetch_array($ilceler)) { 	

		echo '<option value="'.$ilce["ilce_key"].'">'.$ilce["ilce_title"].'</option>';

	}

	$ilceid = $_POST["ilce"];

	$mahalleler = mysql_query("SELECT * FROM mahalle where mahalle_ilcekey = '$ilceid'"); 
	
	while($mahalle=mysql_fetch_array($mahalleler)) { 	

		echo '<option value="'.$mahalle["mahalle_id"].'">'.$mahalle["mahalle_title"].'</option>';

	}

	// mahalle arama 

	$ilsec = $_POST["ilsec"];  

	$ilceler2 = mysql_query("SELECT * FROM ilce where ilce_sehirkey = '$ilsec'"); 
	
	while($ilce=mysql_fetch_array($ilceler2)) { 	

		echo '<option value="'.$ilce["ilce_key"].'">'.$ilce["ilce_title"].'</option>';

	}
?>
