<?php 
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
	
	uyeYasak(yetki());
	

	$islem =  @$_GET["islem"];
	$hareket =  @$_GET["hareket"];  

	$ayariletisim = mysql_query("SELECT * FROM ayar_site where id");
	$a = mysql_fetch_array($ayariletisim);

?>

<!-- Content Header (Page header) -->

<section class="content-header">

	<i class="fa fa-cog fa-2x pull-left"></i>
	 
	Harita Lokasyon Bilgileri

	<p> <small> Genel Ayarları </small> </p>

</section>	
 
<?php 

	if (isset($_POST["kaydet"])) {
 
		$il 	= $_POST["il"];
		$ilce 	= $_POST["ilce"];
		$mahalle 	= $_POST["mahalle"];

		$enlem 	= $_POST["enlem"];
		$boylam 	= $_POST["boylam"];
		$zoom 	= $_POST["zoom"];

		$kaydet = mysql_query("UPDATE ayar_site SET il = '$il', ilce = '$ilce', mahalle = '$mahalle', enlem = '$enlem', boylam = '$boylam', zoom = '$zoom' where id = '1'");	

		go("index.php?do=ayar/haritaadres",0);  

	}

?> 
<section class="content">
	<div class="row">
		<div class="col-md-9">  
			<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
				<?php 

					if ($hareket == "onay") {
						onay();
					} 

				?>  
				<div class="box">
					<div class="box-header with-border">
					  <h5 class="box-title"> <i class="fa fa-edit"></i> Harita Lokasyon Bilgileri </h5>
					</div>

				<!-- /.box-header -->
					<div class="box-body pad" style="">
						<div class="form-horizontal">
							<div class="form-group">
							  <label class="col-sm-2 control-label">Bölge:</label> 
							  <div class="col-sm-10">
								  <div class="row">
								  <?php

								  	$iller = mysql_query("SELECT * FROM sehir where sehir_key = '".$site["il"]."'");
								  	$ilr = mysql_fetch_array($iller);

								  	$ilceler = mysql_query("SELECT * FROM ilce where ilce_key = '".$site["ilce"]."'");
								  	$ilcer = mysql_fetch_array($ilceler);

								  	$mahler = mysql_query("SELECT * FROM mahalle where mahalle_id = '".$site["mahalle"]."'");
								  	$mah = mysql_fetch_array($mahler);


								  ?>
									<div class="col-sm-4"> 
										<select name="il" id="il" class="form-control select2">
											<option selected="selected"> İl Seçiniz </option>
											<?php if (is_numeric($site["il"])) { ?>
											<option selected="selected"> <?=$ilr["adi"];?> </option>
											<?php } ?>

											<?php 
												$iller = mysql_query("select * from sehir order by sehir_key asc");
												while($il=mysql_fetch_array($iller)) {
											?>
											<option value="<?=$il['sehir_key'];?>"> <?=$il['adi'];?> </option>
											<?php } ?>
										</select>
									  </div>
									  <div class="col-sm-4">  
										<select name="ilce" id="ilce" class="form-control select2">
											<option selected="selected"> İlçe Seçiniz </option>  
											<?php if (is_numeric($site["ilce"])) { ?>
											<option selected="selected" value="<?=$site["ilce"];?>"> <?=$ilcer["ilce_title"];?> </option>  
											<?php } ?>
										</select>
									  </div>
									  <div class="col-sm-4">
										<select name="mahalle" id="mahalle" class="form-control select2">
											<option selected="selected"> Mahalle Seçiniz </option>
											<?php if (is_numeric($site["mahalle"])) { ?>
											<option selected="selected" value="<?=$site["mahalle"];?>"> <?=$mah["mahalle_title"];?> </option>  
											<?php } ?>
										</select>
									  </div> 						  
								  </div>
							  </div> 
						  		<script type="text/javascript">
									$(document).ready(function(){ 

									  	$("#il").change(function(){
									    
									    	var ilid = $(this).val();
									    	$.ajax({
									    		type:"POST",
									    		url:"ajax_harita.php",
									    		data:{"il":ilid},
									    		success:function(e){ 
									    			$("#ilce").html(e);
									    		}
									    	}); 
									  	});

									  	$("#ilce").change(function(){
									    
									    	var ilceid = $(this).val();
									    	$.ajax({
									    		type:"POST",
									    		url:"ajax_harita.php",
									    		data:{"ilce":ilceid},
									    		success:function(e){ 
									    			$("#mahalle").html(e);
									    		}
									    	}); 
									  	});

									});
							  </script>
							</div>     
							 
							<script src="https://api-maps.yandex.ru/2.1/?apikey=dba724ec-ef3a-49da-bfe9-ba8a1ee7de7d&lang=tr_TR" type="text/javascript"></script> 
							<script type="text/javascript">
								ymaps.ready(init);
								var editimoMap;
								var zoom;
								function init() {
									editimoMap = new ymaps.Map("map", { center: [<?php echo $site["enlem"] ?>, <?php echo $site["boylam"] ?>], zoom: <?php echo $site["zoom"] ?>, controls: ["zoomControl", "searchControl", "typeSelector", "fullscreenControl"] });
									var myPlacemark = new ymaps.Placemark(
										[<?php echo $site["enlem"] ?>, <?php echo $site["boylam"] ?>],
										{ balloonContentHeader: "<?php echo $ayar["site_adi"] ?>:", balloonContentBody: "", balloonContentFooter: "<?php echo $ayar["site_url"] ?>" },
										{ preset: "islands#redDotIcon", draggable: true }
									);
									myPlacemark.events.add("dragend", function (e) {
										var thisPlacemark = e.get("target");
										var coords = thisPlacemark.geometry.getCoordinates();
										thisPlacemark.properties.set("balloonContent", coords);
										var enlem = document.getElementById("enlem");
										var boylam = document.getElementById("boylam");
										var zoo = document.getElementById("zoom");
										if (typeof enlem != "undefined") enlem.value = myPlacemark.geometry._coordinates[0];
										if (typeof boylam != "undefined") boylam.value = myPlacemark.geometry._coordinates[1];
										if (typeof zoom != "undefined") zoo.value = zoom;
									}); 
									editimoMap.setCenter([<?php echo $site["enlem"] ?>, <?php echo $site["boylam"] ?>]);
									editimoMap.setZoom(<?php echo $site["zoom"] ?>, { duration: 10000 });
									editimoMap.panTo([<?php echo $site["enlem"] ?>, <?php echo $site["boylam"] ?>], { checkZoomRange: true });
									editimoMap.geoObjects.removeAll(myPlacemark);
									editimoMap.geoObjects.add(myPlacemark); 
								}
							</script>
							<div id="map" style="width: 100%; height: 400px; margin: 10px 0px;"></div>
							
							<div class="form-group">
							  <label class="col-sm-2 control-label">Enlem Kodu:</label>
							  <div class="col-sm-10">
								<input type="text" class="form-control" id="enlem" name="enlem" value="<?=$site["enlem"];?>">
							  </div>
							</div>

							<div class="form-group">
							  <label class="col-sm-2 control-label">Boylam Kodu:</label>
							  <div class="col-sm-10">
								<input type="text" class="form-control" id="boylam" name="boylam" value="<?=$site["boylam"];?>">
							  </div>
							</div>

							<div class="form-group">
							  <label class="col-sm-2 control-label">Zoom (Yakınlık):</label>
							  <div class="col-sm-10">
								<input type="text" class="form-control" id="zoom" name="zoom" value="<?=$site["zoom"];?>">
							  </div>
							</div>
						</div>  
					</div>
				</div> 
				<div class="box">						
					<div class="box-footer">						
						<button type="submit" name="kaydet" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Kaydet </button>
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-3">
			<?php include ("right-menu.php"); ?>
		</div>
	</div>
</section>