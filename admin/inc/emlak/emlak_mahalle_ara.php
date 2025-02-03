<?php  
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;   	
	uyeYasak(yetki());	
	$ilsec = $_POST['ilsec'];
	$ilcesec = $_POST['ilcesec'];
	$islem = $_GET["islem"];
	$id = $_GET["id"];
	$mahalle = $_GET["mahalle"];
	$mahalleid = $_GET["mahalleid"];
	$mahalleadi = $_GET["mahalleadi"];
	$ilcesehirkey = $_GET["ilcesehirkey"];
	$sil = $_GET["sil"];
?>  
<section class="content-header">
	
	<i class="fa fa-edit fa-2x pull-left"></i>
	
	Semt/Mahalle Yönetimi   

	<p> <small> Semt/Mahalle Yönetimi   </small> </p> 

</section> 
<section class="content"> 
	<?php 
	if(isset($_POST["mahalleekle"])){

        $mahalle_ekle       = $_POST["mahalle_ekle"]; 
        $mahalle_ilcekey    = $_POST["ilcesec"];

        $mahekle = mysql_query("INSERT INTO mahalle (mahalle_title, mahalle_ilcekey) values ('$mahalle_ekle','$mahalle_ilcekey')");

        echo $mahalle_ilcekey."<br>";
        echo $mahalle_ekle."<br>";

        go("index.php?do=islem&emlak=mahallebul&islem=onay",0);

	}
	?>
	<?php 
		if (isset($_POST["mahallebul"])) {
	?>
	<div class="box-header">
    	 <div class="pull-right"> 
            <a href="index.php?do=islem&emlak=mahallebul&islem=ekle&ilcesehirkey=<?=$ilcesec;?>&ilkey=<?=$ilsec;?>" class="btn btn-success pull-right btn-lg"> Yeni Ekle <i class="fa fa-check"></i> </a>              
         </div> 
    </div> 
    <?php } ?>
    <?php 
        
        if ($islem == "onay") {
            onay();
        }

        if ($islem == "sil") {
            $mahallesil = mysql_query("DELETE from mahalle where mahalle_id = '$mahalleid'");

            if ($mahallesil) {
                onay();
            }
        }

        if (isset($_POST["mahallekaydet"])) {

            $mahalle_title      = $_POST["mahalle_title"];
            $mahalle_ilcekey    = $_POST["ilcesec"];
 
            $kaydetmah = mysql_query("UPDATE mahalle SET 

                mahalle_title   = '$mahalle_title',
                mahalle_ilcekey = '$mahalle_ilcekey'

                where mahalle_id = '$mahalleid'

            ");  

            if ($kaydetmah) {
                go("index.php?do=islem&emlak=mahallebul&islem=onay",0);
            } else {
                echo mysql_error();
            }

        }
    ?>
    <div class="box box-body">        
        <form method="POST" <?php if (isset($_POST["mahallebul"])) { echo "hidden"; } ?> action="" enctype="multipart/form-data">
            <div class="form-horizontal">
                <?php 
                    if ($islem == "duzenle" || $islem == "ekle") {
                ?>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Mahalle/Bölge Adı:</label>
                  <div class="col-sm-10"> 
                  <?php 
                    if ($islem == "ekle") {
                  ?> 
                  <input type="text" name="mahalle_ekle" class="form-control" value="">
                  <?php } else { ?>
                  <input type="text" name="mahalle_title" class="form-control" value="<?=$mahalleadi;?>">
                  <?php } ?>
                  </div>
                </div>  
                <?php } ?>
                <div class="form-group">
                  <label class="col-sm-2 control-label">İl Seçiniz:</label>
                  <div class="col-sm-10">    
                    <select class="form-control select2" name="ilsec" id="ilsec"> 
                        <option> Seçiniz </option>
                        <?php 
                            $iller = mysql_query("select * from sehir order by sehir_key asc");
                            while($il = mysql_fetch_array($iller)) {
                        ?>
                        <?php 
                            if ($islem == "duzenle" || $islem == "ekle") {
                        ?> 
                        <?php if ($islem == "duzenle") { ?>
                        <?php if ($il["sehir_key"] == $id ) { ?> 
                        <option selected="selected"> <?=$il["adi"];?> </option>
                        <?php } ?>
                        <option value="<?=$il["sehir_key"];?>"> <?=$il["adi"];?> </option>  
                        <?php } ?>  

                        <?php 
                            if ($islem == "ekle") {
                        ?>

                        <?php 
                            if ($il["sehir_key"] == $ilkey = $_GET['ilkey']) {
                        ?>
                        <option selected value="<?=$il["sehir_key"];?>"> <?=$il["adi"];?> </option> 
                        <?php } else { ?> 
                        <option value="<?=$il["sehir_key"];?>"> <?=$il["adi"];?> </option> 
                        <?php } ?>
                        <?php } ?>

                        <?php } else { ?>
                        <option value="<?=$il["sehir_key"];?>"> <?=$il["adi"];?> </option> 
                        <?php } ?>
                        <?php } ?>
                    </select>   
                  </div>
                </div>   
                <div class="form-group">
                  <label class="col-sm-2 control-label">İlçe Seçiniz:</label>
                  <div class="col-sm-10">  
                    <select class="form-control select2" name="ilcesec" id="ilcesec"> 
                        <option selected> Seçiniz </option> 
                        <?php 
                            if ($islem == "duzenle") {
                        ?>
                        <?php 
                            $ilceler = mysql_query("select * from ilce where ilce_sehirkey = '$id'");
                            while($ilce = mysql_fetch_array($ilceler)) {
                        ?>
                        <?php 
                            if ($ilce["ilce_key"] == $mahalle) {
                        ?>
                        <option selected="selected" value="<?=$ilce["ilce_key"];?>"> <?=$ilce["ilce_title"];?> </option>                    
                        <?php } else { ?>
                        <option value="<?=$ilce["ilce_key"];?>"> <?=$ilce["ilce_title"];?> </option> 
                        <?php } ?>
                        <?php } ?>
                        <?php } ?>

                        <?php 
                            if ($islem == "ekle") {  
                            $ilcever = mysql_query("select * from ilce where ilce_sehirkey = '".$ilkey = $_GET['ilkey']."'");
                            while($ilc = mysql_fetch_array($ilcever)) { 
                        ?>
                        <?php 
                            if ($ilc["ilce_key"] == $ilcesehirkey) {
                        ?>
                        <option selected="selected" value="<?=$ilc["ilce_key"];?>"> <?=$ilc["ilce_title"];?> </option>
                        <?php } else { ?>
                        <option value="<?=$ilc["ilce_key"];?>"> <?=$ilc["ilce_title"];?> </option>
                        <?php } ?>
                        <?php } ?>
                        <?php } ?>
                    </select>  
                  </div>
                </div>   
                <div class="col-md-12">
                    <div class="form-group">            
                        <div class="text-right">            
                            <?php 
                                if ($islem == "duzenle" || $islem == "ekle") {
                            ?>
                            <?php if ($islem == "ekle") { ?>
                            <button type="submit" class="btn btn-primary btn-lg" name="mahalleekle"> Ekle <i class="fa fa-check"></i> </button> 
                            <?php } ?>
                            <?php if ($islem == "duzenle") { ?>
                            <button type="submit" class="btn btn-success btn-lg" name="mahallekaydet"> Kaydet <i class="fa fa-check"></i> </button> 
                            <?php } ?>
                            <?php } else { ?>
                            <button type="submit" class="btn btn-primary btn-lg <?php if ($islem == "ekle") {echo "hidden";} ?>" name="mahallebul"> Devam Et <i class="fa fa-check"></i> </button>               
                            <?php } ?>
                         </div> 
                     </div> 
                </div>
            </div>   
        </form>
    </div>

<?php 
    if (isset($_POST["mahallebul"])) {
?>
<div class="box box-body table-responsive">        
    <table class="table table-bordered table-hover table-checkable table-striped">
        <thead class="bg-primary">
        <tr>                        
            <td class="text-center" style="width:0.001%;"> ID </td> 
            <td style="width:0.3%;"> Mahalle/Semt Adı </td>
            <td style="width:0.3%;"> İlçe Adı </td> 
            <td style="width:0.3%;"> Şehir Adı </td> 
            <td class="text-center" style="width:0.07%;"> İşlemler </td> 
        </tr>
        </thead>
        <tbody>
            <?php 
                $mahalle = mysql_query("select * from mahalle where mahalle_ilcekey = '$ilcesec'");
                while($m = mysql_fetch_array($mahalle)) {
            ?>
            <tr>
                <th><?=$m["mahalle_id"];?></th>
                <th><?=$m["mahalle_title"];?></th>
                <th>
                <?php   
                    $ilcead = mysql_fetch_array($ilceadi = mysql_query("select * from ilce where ilce_key = '$ilcesec'"));
                    echo $ilcead["ilce_title"];
                ?>
                </th>
                <th>
                <?php   
                    $ilad = mysql_fetch_array($iladi = mysql_query("select * from sehir where sehir_key = '$ilsec'"));
                    echo $ilad["adi"];
                ?>
                </th>
                <th class="text-center">
                    <a href="index.php?do=islem&emlak=mahallebul&islem=duzenle&id=<?=$ilad["sehir_key"];?>&mahalle=<?=$m["mahalle_ilcekey"];?>&mahalleadi=<?=$m["mahalle_title"];?>&mahalleid=<?=$m["mahalle_id"];?>" title="Düzenle" class="btn btn-inverse">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <a href="index.php?do=islem&emlak=mahallebul&islem=sil&mahalleid=<?=$m['mahalle_id']?>" style="text-align: left;" title="Sil" class="btn btn-danger">
                        <i class="fa fa-trash"></i>
                    </a>
                </th>
            </tr>
            <?php } ?>
        </tbody>        
    </table>
</div>
<?php } ?>
</section>	

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>	
<script type="text/javascript">
	$(document).ready(function(){ 

	  	$("#ilsec").change(function(){
	    
	    	var ilsecid = $(this).val();
	    	$.ajax({
	    		type:"POST",
	    		url:"ajax_harita.php",
	    		data:{"ilsec":ilsecid},
	    		success:function(e){ 
	    			$("#ilcesec").html(e);
	    		}
	    	}); 
	  	}); 

	});
</script>