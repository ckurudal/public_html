<?php 

	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
	 
	$hareket =  @$_GET["hareket"];  

?>
<!-- Content Header (Page header) -->
<section class="content-header">

	<i class="fa fa-desktop fa-2x pull-left"></i>

	Anasayfa İkon Box Ayarları

	<p> <small> Anasayfa İkon Box Ayarları </small> </p>

</section>
<?php 

    if ($hareket == "onay") {
        onay();
    } 

?> 
<section class="content">
<?php 

	if (isset($_POST["kaydet"])) { 

		// $duzenle = $vt->query("UPDATE reklam SET kategori_sidebar = '".$kategori_sidebar."', ilan_sidebar = '".$ilan_sidebar."', kategori_ust = '".$kategori_ust."', kategori_alt = '".$kategori_alt."' WHERE id = 1");

        for ($i=0;$i<count($_POST["id"]);$i++) 
        {   
            $duzenle = $vt->query("UPDATE ana_ikon_box SET 

            ikon = '".$_POST["ikon"][$i]."',
            baslik = '".$_POST["baslik"][$i]."',
            icerik = '".$_POST["icerik"][$i]."',
            link = '".$_POST["link"][$i]."',
            renk = '".$_POST["renk"][$i]."',
            sira = '".$_POST["sira"][$i]."'

            WHERE id = ".$_POST["id"][$i]."");
        }

        go("index.php?do=ayar/ana_ikon_box&hareket=onay",0);		 
        
	}

?>
</section>
<section class="content">
	<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
		<div class="row">
            <?php 
                $sayi = 1;                    
                $ana_ikon_box = $vt->query("SELECT * FROM ana_ikon_box")->fetchAll();
                foreach ($ana_ikon_box AS $box):
            ?>
			<div class="col-md-3">
				<div class="box"> 
					<div class="box-header with-border">
						<h3 class="box-title"> <i class="fa fa-check"></i> KOL <?php echo $sayi++; ?></h3>
					</div> 
					<div class="box-body pad" style="">
						<div class="form-horizontal">
                        <input type="hidden" class="form-control" placeholder="id" value="<?php echo $box["id"]; ?>" name="id[]">
							<div class="form-group">
                                <input type="text" class="form-control" placeholder="İkon" value="<?php echo $box["ikon"]; ?>" name="ikon[]">
                                <a style="display:block; padding-top:5px;" href="https://fontawesome.com/v3.2.1/icons/" target="_blank">İkonları Kodlarını Gör <i class="fa fa-external-link"></i></a>
							</div>  
						</div> 
						<div class="form-horizontal">
							<div class="form-group"> 
								<input type="text" class="form-control" placeholder="Başlık" value="<?php echo $box["baslik"]; ?>" name="baslik[]">
							</div>  
						</div> 
						<div class="form-horizontal">
							<div class="form-group"> 
								<textarea class="form-control" placeholder="İçerik" name="icerik[]" rows="8" ><?php echo $box["icerik"]; ?></textarea>
							</div>  
						</div> 
						<div class="form-horizontal">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Link" value="<?php echo $box["link"]; ?>" name="link[]">
							</div>  
						</div> 
						<div class="form-horizontal">
							<div class="form-group">
                                <div class="input-group my-colorpicker2 colorpicker-element">
                                    <input type="text" name="renk[]" class="form-control" placeholder="Renk Seçiniz" value="<?php echo $box["renk"]; ?>">
                                    <div class="input-group-addon">
                                    <i style="background-color: rgb(139, 38, 38);"></i>
                                    </div>
                                </div>
							</div>  
						</div> 
						<div class="form-horizontal">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Sayı" value="<?php echo $box["sira"]; ?>" name="sira[]">
							</div>  
						</div> 
					</div>
				</div> 
			</div> 
            <?php endforeach; ?>
		</div>
		<div class="box-footer col-md-12">						
			<button type="submit" name="kaydet" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Kaydet </button>
		</div>
	</form>
</section>