<?php  
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 

	$id = $_GET["id"];
	$islem = $_GET["islem"];
	$hareket = $_GET["hareket"];
	$durum = $_GET["durum"];
?>
<section class="content-header">
	  
	<i class="fa fa-comments-o fa-2x pull-left"></i>

	Emlak Görüşme Talepleri

	<p> <small> Bildirim ve Mesajlar </small> </p>

</section>
<section class="co ntent">
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
			
			$sil = mysql_query("DELETE FROM emlak_mesaj where id = '$id'"); 

			go("index.php?do=bildirim/emlakmesaj&hareket=onay",0);

		}

		if ($durum == "0") {
			$d = mysql_query("UPDATE emlak_mesaj SET onay = '0' where id = '$id'"); 
			go("index.php?do=bildirim/emlakmesaj&hareket=onay&id=$id",0);
		}
		if ($durum == "1") {
			$d = mysql_query("UPDATE emlak_mesaj SET onay = '1' where id = '$id'"); 
			go("index.php?do=bildirim/emlakmesaj&hareket=onay&id=$id",0);
		}
	?>
	<a href="index.php?do=bildirim/emlakmesaj" class="btn btn-lg bt-xs btn-success">
        <i class="fa fa-refresh"></i> Yenile
    </a>
	<form method="POST" action="">
		<div class="bo x">	   	
			<div class="box-bo dy table-responsive">
				
				<table id="example1" class="table table-bordered dataTable" colspan="5" role="grid" aria-describedby="example1_info">
				    <thead>
				        <tr>                        
				            <td class="text-center" style="width:0.00000001%;"> ID </td>
				            <td style="width: 15%; white-space: nowrap;"> Emlak </td>
				            <td style="width:0.1%;"> Kimden </td>
				            <td style="width:0.1%;"> Kime </td>
				            <td style="width:0.05%;"> Email </td> 			            
				            <td style="width:0.05%;"> Tel </td> 			            
				            <td style="width:0.05%;"> Gsm </td> 			            
				            <td style="width:0.4%;"> Mesaj </td> 			            
				            <td style="width:0.2%;"> Tarih </td> 			            
				            <td class="text-center" style="width:0.1%;"> İşlemler </td>
				        </tr>
			   		</thead>
			    	<tbody>
			    		<?php 
			    			$mesajliste = mysql_query("SELECT * FROM emlak_mesaj where id order by id desc");
				    		while($mliste = mysql_fetch_array($mesajliste)) {
				    	?> 
			    		<tr>
			    			<th class="text-center" style="<?php if ($mliste["onay"] == 0) { ?> background:#fcf8e3; <?php } else { ?> background: #dff0d8; <?php } ?>">
			    				<?=$mliste["id"];?>			    				
			    			</th>
			    			<th>
			    				<?php 
			    					$emlak = mysql_query("SELECT * FROM emlak_ilan where id = '".$mliste["emlakid"]."'");
			    					$e = mysql_fetch_array($emlak);
			    				?>
			    				<a href="/<?=$e["seo"];?>" target="_blank"><?=$e["baslik"];?></a>
			    			</th>
			    			<th><?=$mliste["adsoyad"];?></th>			    			
			    			
			    			<th>
			    				<?php 
			    					$kimle = $vt->query("SELECT * FROM yonetici WHERE id = '".$mliste["kime"]."'")->fetch();
			    				?>
			    				<?php echo $kimle["adsoyad"]; ?>
			    			</th>

			    			<th>
			    				<?=$mliste["email"];?>
			    			</th>		    			
			    			<th>
			    				<?=$mliste["tel"];?>
			    			</th>		    			
			    			<th>
			    				<?=$mliste["gsm"];?>
			    			</th>		    			
			    			<th>
			    				<pre class="alert bg-default"><?=$mliste["mesaj"];?></pre>
			    			</th>		    			
			    			<th>
			    				<?=$mliste["tarih"];?>
			    			</th>
				    		<th class="text-center">
				    			<?php if ($mliste["onay"] == 0) { ?>
				    			<a href="index.php?do=bildirim/emlakmesaj&durum=1&id=<?=$mliste['id']?>" class="btn btn-block btn-xs bg-success">
									<i class="fa fa-check"></i> Okundu Olarak İşaretle
								</a>
				    			<?php } else { ?>
				    			<a href="index.php?do=bildirim/emlakmesaj&durum=0&id=<?=$mliste['id']?>" class="btn btn-block btn-xs bg-warning">
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
										<a href="index.php?do=bildirim/emlakmesaj&hareket=sil&id=<?=$mliste['id']?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
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