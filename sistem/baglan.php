<?php 
	@session_start();
	ob_start(); 
	$dbhost		= "localhost";
	$dbuser		= "emlakbudur_jokergyo"; 
	$dbname		= "emlakbudur_joker";
	$dbpass		= "serrasu112233***A"; 
	try {
        $vt = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    } catch (PDOException $e) {
        die("Veritabanına bağlanamadı: " . $e->getMessage());
    }
	$pdoAyar = $vt->query("SELECT * FROM ayarlar where id = 1")->fetch();   
	date_default_timezone_set('Europe/Istanbul'); 
	$ayar = $vt->query("SELECT * FROM ayarlar")->fetch();  
	$paytr_api = $vt->query("SELECT * FROM odeme_paytr")->fetch();	   
	@$uyelik_yetki = $vt->query("SELECT * FROM yonetici WHERE id = '".$_SESSION["id"]."'")->fetch();
	@$uye_yetki = $uyelik_yetki["yetki"];  
	$tema = $vt->query("SELECT * FROM ayar_tema where aktif = 1")->fetch();   
	$site = $vt->query("SELECT * FROM ayar_site")->fetch();   
	@define("PATH", realpath("."));
	@define("RESIMLER", $_SERVER['DOCUMENT_ROOT'].'/uploads/resim/');
	@define("URL", rtrim($ayar["site_url"], '/'));	
	@define("RESIM", URL."/uploads/resim/");	  
    require_once ('verot/class.upload.php');   
?> 