<?php 
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
	uyeYasak(yetki()); 
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<i class="fa fa-desktop fa-2x pull-left"></i>
	Anasayfa Ayarları
	<p> <small> Genel Ayarları </small> </p>
</section>	
<section class="content"> 
<?php 
    if (@$_GET["hareket"] == "onay") {
		onay();
	} 
	if (isset($_POST["kaydet"])) {  
		$sil = $vt->exec("DELETE FROM anasayfavitrinayar");
    	for ($i=0; $i < count($_POST["list"]); $i++) {   
    	    echo $_POST["durum"][$i]."<br>";
    	    $ekle = $vt->prepare("INSERT INTO anasayfavitrinayar SET 
    	        modul_ad = ?,
    	        modul_baslik = ?,
    	        modul_icerik = ?,
    	        sira = ?,
    	        durum = ?
    	    ");
    	    $ekle = $ekle -> execute(array(
    	        trim(seo($_POST["list"][$i])),    
    	        trim($_POST["baslik"][$i]),   
    	        trim($_POST["modul_icerik"][$i]),   
    	        trim(seo($_POST["sira"][$i])),
    	        trim($_POST["durum"][$i])
    	    ));
    	    if ($ekle) {go('index.php?do=ayar/anavitrinayar&hareket=onay');}
    	}
	}
?>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-9">   
        	<form method="POST" action="" enctype="multipart/form-data">
        		<div class="box">	 
        		    <div class="box-body">	 
        			<div id="" class="table-responsive">
        				<table id="example1" class="table table-bordered table-hover dataTable" colspan="5" role="grid" aria-describedby="example1_info">
        				    <thead>
        				        <tr>                         
        				            <td style="width:0.3%"> Modül Adı </td>   
        				            <td style="width:0.7%"> Başlık - Anasayfada Görünecek Başlık </td>
        				            <td style="width:0.7%"> Alt Başlık </td>
        				            <td class="text-center" style="width:0.05%"> Modül Sıra </td> 
        				            <td class="text-center" style="width:0.01%"> Durum </td> 	 
        				        </tr>
        			   		</thead>
        			    	<tbody id="list">  
        			    	    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'ilan-ver-buton-alani-1'")->fetch(); ?>
        			    		<tr id="categorie5.1-<?php echo $cek["sira"] ?>">
        			    			<th>
        			    			    <input type="text" class="form-control" disabled value="İlan Ver Buton Alanı 1">
        			    			    <input name="list[]" type="hidden" class="form-control" value="İlan Ver Buton Alanı 1">
        			    			</th>  
        			    			<th><input name="baslik[]" type="text" class="form-control" value="<?php echo $cek["modul_baslik"] ?>"></th> 
        			    			<th><input name="modul_icerik[]" type="text" class="form-control" value="<?php echo $cek["modul_icerik"] ?>"></th> 
        			    			<th><input name="sira[]" type="number" class="form-control" value="<?php echo $cek["sira"] ?>"></th> 
        			    			<th class="text-center"> 						
        								<select name="durum[]" class="form-control select2"> 
        								    <?php if ($cek["durum"]=="") { ?>
        								    <option selected value="Pasif"> Seçiniz </option>
        								    <?php } else { ?>
        								    <option selected value="<?php echo $cek["durum"] ?>"> <?php echo $cek["durum"] ?> </option>
        								    <?php } ?>
        								    <option value="Aktif"> Aktif </option>
        								    <option value="Pasif"> Pasif </option>
        								</select>
									</th>   
        			    		</tr>  
        			    	    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'ilan-ver-buton-alani-2'")->fetch(); ?>
        			    		<tr id="categorie5.1-<?php echo $cek["sira"] ?>">
        			    			<th>
        			    			    <input type="text" class="form-control" disabled value="İlan Ver Buton Alanı 2">
        			    			    <input name="list[]" type="hidden" class="form-control" value="İlan Ver Buton Alanı 2">
        			    			</th>  
        			    			<th><input name="baslik[]" type="text" class="form-control" value="<?php echo $cek["modul_baslik"] ?>"></th> 
        			    			<th><input name="modul_icerik[]" type="text" class="form-control" value="<?php echo $cek["modul_icerik"] ?>"></th> 
        			    			<th><input name="sira[]" type="number" class="form-control" value="<?php echo $cek["sira"] ?>"></th> 
        			    			<th class="text-center"> 						
        								<select name="durum[]" class="form-control select2"> 
        								    <?php if ($cek["durum"]=="") { ?>
        								    <option selected value="Pasif"> Seçiniz </option>
        								    <?php } else { ?>
        								    <option selected value="<?php echo $cek["durum"] ?>"> <?php echo $cek["durum"] ?> </option>
        								    <?php } ?>
        								    <option value="Aktif"> Aktif </option>
        								    <option value="Pasif"> Pasif </option>
        								</select>
									</th>   
        			    		</tr>  
        			    	    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'trigger-alani'")->fetch(); ?>
        			    		<tr id="categorie5.1-<?php echo $cek["sira"] ?>">
        			    			<th>
        			    			    <input type="text" class="form-control" disabled value="Trigger Alanı">
        			    			    <input name="list[]" type="hidden" class="form-control" value="Trigger Alanı">
        			    			</th>  
        			    			<th><input name="baslik[]" type="text" class="form-control" value="<?php echo $cek["modul_baslik"] ?>"></th> 
        			    			<th><input name="modul_icerik[]" type="text" class="form-control" value="<?php echo $cek["modul_icerik"] ?>"></th> 
        			    			<th><input name="sira[]" type="number" class="form-control" value="<?php echo $cek["sira"] ?>"></th> 
        			    			<th class="text-center"> 						
        								<select name="durum[]" class="form-control select2"> 
        								    <?php if ($cek["durum"]=="") { ?>
        								    <option selected value="Pasif"> Seçiniz </option>
        								    <?php } else { ?>
        								    <option selected value="<?php echo $cek["durum"] ?>"> <?php echo $cek["durum"] ?> </option>
        								    <?php } ?>
        								    <option value="Aktif"> Aktif </option>
        								    <option value="Pasif"> Pasif </option>
        								</select>
									</th>   
        			    		</tr>  
        			    	    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'hizli-kategori-linkleri'")->fetch(); ?>
        			    		<tr id="categorie5.1-<?php echo $cek["sira"] ?>">
        			    			<th>
        			    			    <input type="text" class="form-control" disabled value="Hızlı Kategori Linkleri">
        			    			    <input name="list[]" type="hidden" class="form-control" value="Hızlı Kategori Linkleri">
        			    			</th>  
        			    			<th><input name="baslik[]" type="text" class="form-control" value="<?php echo $cek["modul_baslik"] ?>"></th> 
        			    			<th><input name="modul_icerik[]" type="text" class="form-control" value="<?php echo $cek["modul_icerik"] ?>"></th> 
        			    			<th><input name="sira[]" type="number" class="form-control" value="<?php echo $cek["sira"] ?>"></th> 
        			    			<th class="text-center"> 						
        								<select name="durum[]" class="form-control select2"> 
        								    <?php if ($cek["durum"]=="") { ?>
        								    <option selected value="Pasif"> Seçiniz </option>
        								    <?php } else { ?>
        								    <option selected value="<?php echo $cek["durum"] ?>"> <?php echo $cek["durum"] ?> </option>
        								    <?php } ?>
        								    <option value="Aktif"> Aktif </option>
        								    <option value="Pasif"> Pasif </option>
        								</select>
									</th>   
        			    		</tr> 
        			    	    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'danismanlar'")->fetch(); ?>
        			    		<tr id="categorie5.1-<?php echo $cek["sira"] ?>">
        			    			<th>
        			    			    <input type="text" class="form-control" disabled value="Danışmanlar">
        			    			    <input name="list[]" type="hidden" class="form-control" value="Danışmanlar">
        			    			</th>  
        			    			<th><input name="baslik[]" type="text" class="form-control" value="<?php echo $cek["modul_baslik"] ?>"></th> 
        			    			<th><input name="modul_icerik[]" type="text" class="form-control" value="<?php echo $cek["modul_icerik"] ?>"></th> 
        			    			<th><input name="sira[]" type="number" class="form-control" value="<?php echo $cek["sira"] ?>"></th> 
        			    			<th class="text-center"> 						
        								<select name="durum[]" class="form-control select2"> 
        								    <?php if ($cek["durum"]=="") { ?>
        								    <option selected value="Pasif"> Seçiniz </option>
        								    <?php } else { ?>
        								    <option selected value="<?php echo $cek["durum"] ?>"> <?php echo $cek["durum"] ?> </option>
        								    <?php } ?>
        								    <option value="Aktif"> Aktif </option>
        								    <option value="Pasif"> Pasif </option>
        								</select>
									</th>   
        			    		</tr> 
        			    	    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'ikon-box'")->fetch(); ?>
        			    		<tr id="categorie5.1-<?php echo $cek["sira"] ?>">
        			    			<th>
        			    			    <input type="text" class="form-control" disabled value="Ikon Box">
        			    			    <input name="list[]" type="hidden" class="form-control" hidden value="Ikon Box">
        			    			</th>   
        			    			<th><input name="baslik[]" type="text" class="form-control" value="<?php echo $cek["modul_baslik"] ?>"></th> 
        			    			<th><input name="modul_icerik[]" type="text" class="form-control" value="<?php echo $cek["modul_icerik"] ?>"></th> 
        			    			<th><input name="sira[]" type="number" class="form-control" value="<?php echo $cek["sira"] ?>"></th> 
        			    			<th class="text-center"> 						
        								<select name="durum[]" class="form-control select2"> 
        								    <?php if ($cek["durum"]=="") { ?>
        								    <option selected value="Pasif"> Seçiniz </option>
        								    <?php } else { ?>
        								    <option selected value="<?php echo $cek["durum"] ?>"> <?php echo $cek["durum"] ?> </option>
        								    <?php } ?>
        								    <option value="Aktif"> Aktif </option>
        								    <option value="Pasif"> Pasif </option>
        								</select>
									</th>    
        			    		</tr> 
        			    	    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'one-cikan-konut-projeleri'")->fetch(); ?>
        			    		<tr id="categorie5.1-<?php echo $cek["sira"] ?>"> 
        			    			<th>
        			    			    <input type="text" class="form-control" disabled value="Öne Çıkan Konut Projeleri">
        			    			    <input name="list[]" type="hidden" class="form-control" hidden value="Öne Çıkan Konut Projeleri">
        			    			</th>  
        			    			<th><input name="baslik[]" type="text" class="form-control" value="<?php echo $cek["modul_baslik"] ?>"></th> 
        			    			<th><input name="modul_icerik[]" type="text" class="form-control" value="<?php echo $cek["modul_icerik"] ?>"></th> 
        			    			<th><input name="sira[]" type="number" class="form-control" value="<?php echo $cek["sira"] ?>"></th> 
        			    			<th class="text-center"> 						
        								<select name="durum[]" class="form-control select2"> 
        								    <?php if ($cek["durum"]=="") { ?>
        								    <option selected value="Pasif"> Seçiniz </option>
        								    <?php } else { ?>
        								    <option selected value="<?php echo $cek["durum"] ?>"> <?php echo $cek["durum"] ?> </option>
        								    <?php } ?>
        								    <option value="Aktif"> Aktif </option>
        								    <option value="Pasif"> Pasif </option>
        								</select>
									</th>      
        			    		</tr> 
        			    	    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'emlak-haberleri'")->fetch(); ?>
        			    		<tr id="categorie5.1-<?php echo $cek["sira"] ?>"> 
        			    			<th>
        			    			    <input type="text" class="form-control" disabled value="Emlak Haberleri">
        			    			    <input name="list[]" type="hidden" class="form-control" hidden value="Emlak Haberleri">
        			    			</th>  
        			    			<th><input name="baslik[]" type="text" class="form-control" value="<?php echo $cek["modul_baslik"] ?>"></th> 
        			    			<th><input name="modul_icerik[]" type="text" class="form-control" value="<?php echo $cek["modul_icerik"] ?>"></th> 
        			    			<th><input name="sira[]" type="number" class="form-control" value="<?php echo $cek["sira"] ?>"></th> 
        			    			<th class="text-center"> 						
        								<select name="durum[]" class="form-control select2"> 
        								    <?php if ($cek["durum"]=="") { ?>
        								    <option selected value="Pasif"> Seçiniz </option>
        								    <?php } else { ?>
        								    <option selected value="<?php echo $cek["durum"] ?>"> <?php echo $cek["durum"] ?> </option>
        								    <?php } ?>
        								    <option value="Aktif"> Aktif </option>
        								    <option value="Pasif"> Pasif </option>
        								</select>
									</th>     
        			    		</tr> 
        			    	    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'blog'")->fetch(); ?>
        			    		<tr id="categorie5.1-<?php echo $cek["sira"] ?>"> 
        			    			<th>
        			    			    <input type="text" class="form-control" disabled value="Blog">
        			    			    <input name="list[]" type="hidden" class="form-control" hidden value="Blog">
        			    			</th>  
        			    			<th><input name="baslik[]" type="text" class="form-control" value="<?php echo $cek["modul_baslik"] ?>"></th> 
        			    			<th><input name="modul_icerik[]" type="text" class="form-control" value="<?php echo $cek["modul_icerik"] ?>"></th> 
        			    			<th><input name="sira[]" type="number" class="form-control" value="<?php echo $cek["sira"] ?>"></th> 
        			    			<th class="text-center"> 						
        								<select name="durum[]" class="form-control select2"> 
        								    <?php if ($cek["durum"]=="") { ?>
        								    <option selected value="Pasif"> Seçiniz </option>
        								    <?php } else { ?>
        								    <option selected value="<?php echo $cek["durum"] ?>"> <?php echo $cek["durum"] ?> </option>
        								    <?php } ?>
        								    <option value="Aktif"> Aktif </option>
        								    <option value="Pasif"> Pasif </option>
        								</select>
									</th>       
        			    		</tr> 
        			    	    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'sehirlere-gore-ilanlar'")->fetch(); ?>
        			    		<tr id="categorie5.1-<?php echo $cek["sira"] ?>"> 
        			    			<th>
        			    			    <input type="text" class="form-control" disabled value="Şehirlere Göre İlanlar">
        			    			    <input name="list[]" type="hidden" class="form-control" hidden value="Şehirlere Göre İlanlar">
        			    			</th>  
        			    			<th><input name="baslik[]" type="text" class="form-control" value="<?php echo $cek["modul_baslik"] ?>"></th> 
        			    			<th><input name="modul_icerik[]" type="text" class="form-control" value="<?php echo $cek["modul_icerik"] ?>"></th> 
        			    			<th><input name="sira[]" type="number" class="form-control" value="<?php echo $cek["sira"] ?>"></th> 
        			    			<th class="text-center"> 						
        								<select name="durum[]" class="form-control select2"> 
        								    <?php if ($cek["durum"]=="") { ?>
        								    <option selected value="Pasif"> Seçiniz </option>
        								    <?php } else { ?>
        								    <option selected value="<?php echo $cek["durum"] ?>"> <?php echo $cek["durum"] ?> </option>
        								    <?php } ?>
        								    <option value="Aktif"> Aktif </option>
        								    <option value="Pasif"> Pasif </option>
        								</select>
									</th>        
        			    		</tr> 
        			    	    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'sicak-firsatlar'")->fetch(); ?>
        			    		<tr id="categorie5.1-<?php echo $cek["sira"] ?>"> 
        			    			<th>
        			    			    <input type="text" class="form-control" disabled value="Sıcak Fırsatlar">
        			    			    <input name="list[]" type="hidden" class="form-control" hidden value="Sıcak Fırsatlar">
        			    			</th>  
        			    			<th><input name="baslik[]" type="text" class="form-control" value="<?php echo $cek["modul_baslik"] ?>"></th> 
        			    			<th><input name="modul_icerik[]" type="text" class="form-control" value="<?php echo $cek["modul_icerik"] ?>"></th> 
        			    			<th><input name="sira[]" type="number" class="form-control" value="<?php echo $cek["sira"] ?>"></th> 
        			    			<th class="text-center"> 						
        								<select name="durum[]" class="form-control select2"> 
        								    <?php if ($cek["durum"]=="") { ?>
        								    <option selected value="Pasif"> Seçiniz </option>
        								    <?php } else { ?>
        								    <option selected value="<?php echo $cek["durum"] ?>"> <?php echo $cek["durum"] ?> </option>
        								    <?php } ?>
        								    <option value="Aktif"> Aktif </option>
        								    <option value="Pasif"> Pasif </option>
        								</select>
									</th>         
        			    		</tr> 
        			    	    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'en-yeni-ilanlar'")->fetch(); ?>
        			    		<tr id="categorie5.1-<?php echo $cek["sira"] ?>"> 
        			    			<th>
        			    			    <input type="text" class="form-control" disabled value="En Yeni İlanlar">
        			    			    <input name="list[]" type="hidden" class="form-control" hidden value="En Yeni İlanlar">
        			    			</th>  
        			    			<th><input name="baslik[]" type="text" class="form-control" value="<?php echo $cek["modul_baslik"] ?>"></th> 
        			    			<th><input name="modul_icerik[]" type="text" class="form-control" value="<?php echo $cek["modul_icerik"] ?>"></th> 
        			    			<th><input name="sira[]" type="number" class="form-control" value="<?php echo $cek["sira"] ?>"></th> 
        			    			<th class="text-center"> 						
        								<select name="durum[]" class="form-control select2"> 
        								    <?php if ($cek["durum"]=="") { ?>
        								    <option selected value="Pasif"> Seçiniz </option>
        								    <?php } else { ?>
        								    <option selected value="<?php echo $cek["durum"] ?>"> <?php echo $cek["durum"] ?> </option>
        								    <?php } ?>
        								    <option value="Aktif"> Aktif </option>
        								    <option value="Pasif"> Pasif </option>
        								</select>
									</th>         
        			    		</tr> 
        			    	    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'vitrin-ilanlari'")->fetch(); ?>
        			    		<tr id="categorie5.1-<?php echo $cek["sira"] ?>">  
        			    			<th>
        			    			    <input type="text" class="form-control" disabled value="Vitrin İlanları">
        			    			    <input name="list[]" type="hidden" class="form-control" hidden value="Vitrin İlanları">
        			    			</th> 
        			    			<th><input name="baslik[]" type="text" class="form-control" value="<?php echo $cek["modul_baslik"] ?>"></th> 
        			    			<th><input name="modul_icerik[]" type="text" class="form-control" value="<?php echo $cek["modul_icerik"] ?>"></th> 
        			    			<th><input name="sira[]" type="number" class="form-control" value="<?php echo $cek["sira"] ?>"></th> 
        			    			<th class="text-center"> 						
        								<select name="durum[]" class="form-control select2"> 
        								    <?php if ($cek["durum"]=="") { ?>
        								    <option selected value="Pasif"> Seçiniz </option>
        								    <?php } else { ?>
        								    <option selected value="<?php echo $cek["durum"] ?>"> <?php echo $cek["durum"] ?> </option>
        								    <?php } ?>
        								    <option value="Aktif"> Aktif </option>
        								    <option value="Pasif"> Pasif </option>
        								</select>
									</th>       
        			    		</tr> 
        			    	    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'one-cikan-ilanlar'")->fetch(); ?>
        			    		<tr id="categorie5.1-<?php echo $cek["sira"] ?>"> 
        			    			<th>
        			    			    <input type="text" class="form-control" disabled value="Öne Çıkan İlanlar">
        			    			    <input name="list[]" type="hidden" class="form-control" hidden value="Öne Çıkan İlanlar">
        			    			</th>  
        			    			<th><input name="baslik[]" type="text" class="form-control" value="<?php echo $cek["modul_baslik"] ?>"></th> 
        			    			<th><input name="modul_icerik[]" type="text" class="form-control" value="<?php echo $cek["modul_icerik"] ?>"></th> 
        			    			<th><input name="sira[]" type="number" class="form-control" value="<?php echo $cek["sira"] ?>"></th> 
        			    			<th class="text-center"> 						
        								<select name="durum[]" class="form-control select2"> 
        								    <?php if ($cek["durum"]=="") { ?>
        								    <option selected value="Pasif"> Seçiniz </option>
        								    <?php } else { ?>
        								    <option selected value="<?php echo $cek["durum"] ?>"> <?php echo $cek["durum"] ?> </option>
        								    <?php } ?>
        								    <option value="Aktif"> Aktif </option>
        								    <option value="Pasif"> Pasif </option>
        								</select>
									</th>       
        			    		</tr> 
        			    	    <?php $cek = $vt->query("SELECT * FROM anasayfavitrinayar WHERE modul_ad = 'anasayfa-acil'")->fetch(); ?>
        			    		<tr id="categorie5.1-<?php echo $cek["sira"] ?>"> 
        			    			<th>
        			    			    <input type="text" class="form-control" disabled value="Anasayfa Acil">
        			    			    <input name="list[]" type="hidden" class="form-control" hidden value="Anasayfa Acil">
        			    			</th>  
        			    			<th><input name="baslik[]" type="text" class="form-control" value="<?php echo $cek["modul_baslik"] ?>"></th> 
        			    			<th><input name="modul_icerik[]" type="text" class="form-control" value="<?php echo $cek["modul_icerik"] ?>"></th> 
        			    			<th><input name="sira[]" type="number" class="form-control" value="<?php echo $cek["sira"] ?>"></th> 
        			    			<th class="text-center"> 						
        								<select name="durum[]" class="form-control select2"> 
        								    <?php if ($cek["durum"]=="") { ?>
        								    <option selected value="Pasif"> Seçiniz </option>
        								    <?php } else { ?>
        								    <option selected value="<?php echo $cek["durum"] ?>"> <?php echo $cek["durum"] ?> </option>
        								    <?php } ?>
        								    <option value="Aktif"> Aktif </option>
        								    <option value="Pasif"> Pasif </option>
        								</select>
									</th>       
								</tr>
        			    	</tbody>
        			    </table>
        			</div>
        		</div>
        		</div>
        		<button name="kaydet" class="btn btn-lg btn-primary"> <i class="fa fa-save fa-lg"></i> Sıralamayı Kaydet </button>
        	  </form>
		</div>  
		<div class="col-md-3">
			<?php include ("right-menu.php"); ?>
		</div>
	</div>
</section>