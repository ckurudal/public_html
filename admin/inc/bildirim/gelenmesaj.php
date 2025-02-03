<?php  
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 

	$id = $_GET["id"];
	$islem = $_GET["islem"];
	$hareket = $_GET["hareket"];
	$durum = $_GET["durum"];
?>
<section class="content-header">	  

	<i class="fa fa-comments-o fa-2x pull-left"></i>

	Gelen Mesajlar

	<p> <small> Bildirim ve Mesajlar </small> </p>

</section>

<?php if ($islem == "") { ?>
<section class="content">
	<?php 
		if ($hareket == "onay") {
			onay();
		}

		if ($hareket == "sil") {
			
			$sil = mysql_query("DELETE FROM emlak_mesajiletisim where id = '$id'"); 

			go("index.php?do=bildirim/gelenmesaj&hareket=onay",0);

		}

		if ($durum == "0") {
			$d = mysql_query("UPDATE emlak_mesajiletisim SET onay = '0' where id = '$id'"); 
			go("index.php?do=bildirim/gelenmesaj&hareket=onay&id=$id",0);
		}
		if ($durum == "1") {
			$d = mysql_query("UPDATE emlak_mesajiletisim SET onay = '1' where id = '$id'"); 
			go("index.php?do=bildirim/gelenmesaj&hareket=onay&id=$id",0);
		}
	?>
	<a href="index.php?do=bildirim/gelenmesaj" class="btn btn-lg bt-xs btn-success">
        <i class="fa fa-refresh"></i> Yenile
    </a>
	<form method="POST" action="">
		<div class="b ox">	   	
			<div class="box-bo dy table-responsive">
				
				<table id="example1" class="table table-bordered dataTable" colspan="5" role="grid" aria-describedby="example1_info">
				    <thead>
				        <tr>                        
				            <td class="text-center" style="width:0.00000001%;"> ID </td>				            
				            <td style="width:0.1%;"> Ad Soyad </td>
				            <td style="width:0.05%;"> Email </td> 			            
				            <td style="width:0.05%;"> Tel </td> 			            				            
				            <td style="width:50%;"> Mesaj </td> 			            
				            <td style="width:0.2%;"> Tarih </td> 			            
				            <td class="text-center" style="width:0.0001%;"> İşlemler </td>
				        </tr>
			   		</thead>
			    	<tbody>

			    		<?php 
			    			$mesajliste = mysql_query("SELECT * FROM emlak_mesajiletisim where id order by onay desc");
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
			    				<?=$mliste["mesaj"];?>
			    			</th>		    			
			    			<th>
			    				<?=$mliste["tarih"];?>
			    			</th>
				    		<th class="text-center">
				    			<?php if ($mliste["onay"] == 0) { ?>
				    			<a href="index.php?do=bildirim/gelenmesaj&durum=1&id=<?=$mliste['id']?>" class="btn btn-block btn-xs bg-success">
									<i class="fa fa-check"></i> Okundu Olarak İşaretle
								</a>
				    			<?php } else { ?>
				    			<a href="index.php?do=bildirim/gelenmesaj&durum=0&id=<?=$mliste['id']?>" class="btn btn-block btn-xs bg-warning">
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
										<a href="index.php?do=bildirim/gelenmesaj&hareket=sil&id=<?=$mliste['id']?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
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