<?php  
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 

	$id = $_GET["id"];
	$islem = $_GET["islem"];
	$hareket = $_GET["hareket"];
	$durum = $_GET["durum"];
?>
<section class="content-header">	  

	<i class="fa fa-comments-o fa-2x pull-left"></i>

	Emlak Bilgi Talepleri

	<p> <small> Bildirim ve Mesajlar </small> </p>

</section>
<section class="cont ent">
<?php 

?>
</section>
<?php if ($islem == "") { ?>
<section class="content">

	<?php 

		if ($hareket == "onay") {
			onay();
		}

		if ($hareket == "sil") {
			
			$sil = mysql_query("DELETE FROM emlak_mesajemlaktalep where id = '$id'"); 

			go("index.php?do=bildirim/emlaktalep&hareket=onay",0);

		}

		if ($durum == "0") {
			$d = mysql_query("UPDATE emlak_mesajemlaktalep SET onay = '0' where id = '$id'"); 
			go("index.php?do=bildirim/emlaktalep&hareket=onay&id=$id",0);
		}
		if ($durum == "1") {
			$d = mysql_query("UPDATE emlak_mesajemlaktalep SET onay = '1' where id = '$id'"); 
			go("index.php?do=bildirim/emlaktalep&hareket=onay&id=$id",0);
		}

	?>

	<a href="index.php?do=bildirim/emlaktalep" class="btn btn-lg bt-xs btn-success">
        <i class="fa fa-refresh"></i> Yenile
    </a>

	<form method="POST" action="">
		<div class="bo x">	   	
			<div class="box-b ody table-responsive">
				
				<table id="example1" class="table table-bordered dataTable" colspan="5" role="grid" aria-describedby="example1_info">
				    <thead>
				        <tr>                        
				            <td class="text-center" style="width:0.00000001%;"> ID </td>				            
				            <td style="width:0.1%;"> Ad Soyad </td>
				            <td style="width:0.05%;"> Email </td> 			            
				            <td style="width:0.05%;"> Tel </td> 			            				            
				            <td style="width:0.3%;"> Emlak Tipi </td>				            
				            <td style="width:0.4%;"> Mesaj </td> 			            
				            <td style="width:0.5%;"> Bölge </td> 			            				            
				            <td style="width:0.5%;"> Min / Max Fiyat </td> 			            
				            <td style="width:0.4%;"> Talep Türü </td> 			            
				            <td style="width:0.2%;"> Tarih </td> 			            
				            <td class="text-center" style="width:0.1%;"> İşlemler </td>
				        </tr>
			   		</thead>
			    	<tbody>
			    		<?php 
			    			$mesajliste = mysql_query("SELECT * FROM emlak_mesajemlaktalep where id order by id desc");
				    		while($mliste = mysql_fetch_array($mesajliste)) {
				    	?> 
			    		<tr>
			    			<th class="text-center" style="<?php if ($mliste["onay"] == 0) { ?> background:#fcf8e3; <?php } else { ?> background: #dff0d8; <?php } ?>">
			    				<?=$mliste["id"];?>			    					
			    			</th>
			    			<th><?=$mliste["adsoyad"];?></th>			    			
			    			<th>
			    				<?=$mliste["email"];?>
			    			</th>		    			
			    			<th>
			    				<?=$mliste["tel"];?>
			    			</th>		    			
			    			<th>
			    				<?=$mliste["emlaktipi"];?> <?=$mliste["kategori"];?>
			    			</th>
			    			<th>
			    				<?=$mliste["mesaj"];?>
			    			</th>	  	    			
			    			<th>
			    				<?php

			    					$adres = $mliste["adres"];
			    					$kelimeler = explode(",", $adres);

			    					$sehirler2 = mysql_query("SELECT * FROM sehir where sehir_key = '".$kelimeler[0]."'");
			    					$sehir2 = mysql_fetch_array($sehirler2);

			    					$ilceler = mysql_query("SELECT * FROM ilce where ilce_key = '".$kelimeler[1]."'");
			    					$ilce = mysql_fetch_array($ilceler);

			    					$mahler = mysql_query("SELECT * FROM mahalle where mahalle_id = '".$kelimeler[2]."'");
			    					$mah = mysql_fetch_array($mahler);

			    					if ($mliste["adres"] == 0) {
			    						echo "-";
			    					} else {
			    						echo $sehir2["adi"]." / ";
				    					echo $ilce["ilce_title"]." / ";
				    					echo $mah["mahalle_title"];
			    					}

			    				?>
			    			</th>	 	    			
			    			<th>
			    				<?=$mliste["minfiyat"];?> <?=$mliste["fiyatkur"];?> - <?=$mliste["maxfiyat"];?> <?=$mliste["fiyatkur"];?>
			    			</th>		    			
			    			<th>
			    				<?=$mliste["taleptur"];?>
			    			</th>		    			
			    			<th>
			    				<?=$mliste["tarih"];?>
			    			</th>
				    		<th class="text-center">
				    			<?php if ($mliste["onay"] == 0) { ?>
				    			<a href="index.php?do=bildirim/emlaktalep&durum=1&id=<?=$mliste['id']?>" class="btn btn-block btn-xs bg-success">
									<i class="fa fa-check"></i> Okundu Olarak İşaretle
								</a>
				    			<?php } else { ?>
				    			<a href="index.php?do=bildirim/emlaktalep&durum=0&id=<?=$mliste['id']?>" class="btn btn-block btn-xs bg-warning">
									<i class="fa fa-close"></i> Okunmadı Olarak İşaretle
								</a>
				    			<?php } ?>
								<a href="#" data-toggle="modal" data-target="#<?=$mliste["id"];?>" class="btn btn-block btn-xs btn-danger">
									<i class="fa fa-trash"></i> Mesajı Sil
								</a>  
								<div class="modal modal-default fade" id="<?=$mliste["id"]?>" style="display: none;">
								  <div class="modal-dialog">
									<div class="modal-content">
									  <div class="modal-header alert alert-info">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										  <span aria-hidden="true">×</span></button>
										<h4 class="modal-title"><i class="fa fa-close"></i> Silme Onayı Ver</h4>
									  </div>
									  <div class="modal-body">
										<h4><strong> "<?=$mliste["adsoyad"]?>" </strong> isimli mesaj silinecektir. İşlemi onaylıyor musunuz ?</h4>
									  </div>
									  <div class="modal-footer">
										<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
										<a href="index.php?do=bildirim/emlaktalep&hareket=sil&id=<?=$mliste['id']?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
									  </div>
									</div> 
								  </div> 
								</div> 
				    		</th>
			    		</tr>
			    		<?php } ?>
			    	</tbody>
			   	</table> 	
			</div>
		</div> 
	</form>
</section>
<?php } ?>

<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>