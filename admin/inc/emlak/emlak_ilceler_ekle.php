<?php  
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
    $rand_key = rand(2000,1000);  
    
	uyeYasak(yetki());
	$islem = $_GET["islem"];
	$emlak = $_GET["emlak"]; 
	$hareket = $_GET["hareket"];
	$id = $_GET["id"];  
	$dbilceler = $vt->query("select * from ilce where ilce_id = '$id'");
	$ilce = $dbilceler->fetch(); 
	$dbilsec = $vt->query("select * from sehir where sehir_key = '$ilce[ilce_sehirkey]'");
	$ilsec = $dbilsec->fetch();
?>
<?php if (isset($_POST["ilceduzenle"])) {
	$ilce_title = trim($_POST["ilce_title"]); 
	$ilce_sehirkey = trim($_POST["ilce_sehirkey"]);  
	$ilduzenle = $vt->query("update ilce set 
	ilce_title			=  	'$ilce_title',
	ilce_sehirkey		=  	'$ilce_sehirkey',
	ilce_key		    =  	'$rand_key'
	where ilce_id = '$id'; 
	");
	go("index.php?do=islem&emlak=ilceler&hareket=onay",0);
} ?>
<section class="content-header">
	<i class="fa fa-edit"></i> İlçe Yönetimi   
  <ol class="breadcrumb">
	<li><a href="index.php"><i class="fa fa-dashboard"></i> Anasayfa </a></li>
	<li> <a href="index.php?do=tumilanlar"> Tüm İlanlar </a> </li>
	<li class="active"> İlan Yönetimi </li>
  </ol>
</section> 
<?php 
	if ($islem == "ekle" || $islem == "duzenle") {
?>
<section class="content">
<!-- Content Header (Page header) -->
<?php if (isset($_POST["ilceekle"])) {  
	$ilce_title = trim($_POST["ilce_title"]); 
	$ilce_sehirkey = trim($_POST["ilce_sehirkey"]);   
	if (empty($ilce_title)) { 
		hata("İlçe adı boş olamaz."); 
	} else { 
		$ilceekle = $vt->query("insert into ilce  
		(ilce_title,ilce_sehirkey, ilce_key)	values  ('$ilce_title','$ilce_sehirkey','$rand_key');
	"); 
		go("index.php?do=islem&emlak=ilceler&hareket=onay",0); 
	}
} ?>
	<form method="post" action="" enctype="multipart/form-data">
		<div class="box">
            <div class="box-header with-border">
                <h5 class="box-title"> <i class="fa fa-edit"></i> İlçe Ekle/Düzenle </h5>
            </div>
            <div class="box-body"> 
                <div class="form-horizontal"> 
                    <div class="form-group">
                        <label class="col-sm-2 control-label">İlçe Adı:</label>
                        <div class="col-sm-10">
                            <?php if ($islem == "ekle") { ?>
                            <input type="text" class="form-control" name="ilce_title" value="">
                            <?php } ?>
                            <?php if ($islem == "duzenle") { ?>
                            <input type="text" class="form-control" name="ilce_title" value="<?=$ilce['ilce_title'];?>">
                            <?php } ?>
                        </div>
                    </div>   
                    <div class="form-group">
                        <label class="col-sm-2 control-label">İl Seçiniz:</label>
                        <div class="col-sm-10">
                            <?php if ($islem == "ekle") { ?>
                            <select class="form-control select2" name="ilce_sehirkey">
                            <?php 
                                $illerekle = $vt->query("select * from sehir order by adi asc");
                                while($il = $illerekle->fetch()) {
                            ?>	
                            <option value="<?=$il['sehir_key'];?>"><?=$il["adi"];?></option>
                            <?php } ?>
                            </select>
                            <?php } ?>
                            <?php if ($islem == "duzenle") { ?> 
                            <select class="form-control select2" name="ilce_sehirkey">
                                <?php
                                    if ($ilsec["sehir_key"]==$ilce["ilce_sehirkey"]) {
                                        echo '<option selected="selected" value="'.$ilsec["sehir_key"].'">'.$ilsec["adi"].'</option>';
                                    } else {
                                ?> 
                                <option selected> İL SEÇİNİZ </option>
                                <?php } ?>
                                <?php 
                                    $iller = $vt->query("select * from sehir order by adi asc");
                                    while($il = $iller->fetch()) {
                                ?>	
                                <option value="<?=$il['sehir_key'];?>"><?=$il["adi"];?></option>
                                <?php } ?>
                            </select> 
                            <?php } ?>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        <?php if ($islem == "ekle") { ?>
        <button type="submit" class="btn btn-primary btn-lg pull-right" name="ilceekle"> Ekle <i class="fa fa-check"></i> </button>
        <?php } ?>
        <?php if ($islem == "duzenle") { ?>
        <button type="submit" class="btn btn-success btn-lg pull-right" name="ilceduzenle"> Kaydet <i class="fa fa-check"></i> </button>
        <?php } ?>
	</form>
</section>	
<?php } ?>