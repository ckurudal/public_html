

<div class="col-md-2">
	
    <h5><i class="fa fa-angle-down pull-right"></i><strong>Kategori Seçiniz</strong></h5>
    <hr>
	<select multiple name="altkat2" id="altkat2" class="form-control" size="12" style="padding:15px; background-color: #e5f0ff; border: 1px solid #b9d6ff;">
	<?php 
	
		@session_start();
		
		require "../../sistem/baglan.php";  	 
		
		// ajax kategori
		
		$katid = $_POST["kat"];
		
		$ust_kat = $_SESSION["ust_kat"] = true;
		$ust_kat = $_SESSION["ust_kat"] = $katid[0];

		$altkatler = mysql_query("SELECT * FROM emlak_kategori where kat_ustid = '$katid[0]'"); 
		
		while($altkat=mysql_fetch_array($altkatler)) { 	
		
			echo '<option value="'.$altkat["kat_id"].'">'.$altkat["kat_adi"].'</option>';

		}
	?>
	</select> 
	
</div>

<?php 

	$altkatt = $vt->query("SELECT * FROM emlak_kategori where kat_id = '$katid[0]'"); 
	$altkatt->exec;
	$katt = $altkatt->fetch();

?>

<div class="col-md-2" id="sonuc">
    <h5><i class="fa fa-angle-down pull-right"></i><strong>Eklemeye Başla</strong></h5>
    <hr>
	<div class="kat_devam_et">
		<div class="text-center">  
			<i class="fa fa-check-circle fa-2x text-green"></i>
			<br>
			<br>
			<span class="text-green h5"><strong><?php echo $katt["kat_adi"]; ?></strong></span>
			<br>
			<br>
			<a id="link" href="index.php?do=islem&emlak=emlak_ekle&kategori=<?php echo $katid[0]; ?>" class="btn btn-primary btn-xs">Sonraki Adım</a>
		</div>
	</div>
</div> 

<script type="text/javascript">
	$(document).ready(function(){
		$("#altkat2").change(function(){
			var altkatid = $(this).val();
			$.ajax({
				type:"POST",
				url:"ajax_kategori/ajax_kategori_2.php",
				data:{"altkat2":altkatid},
				success:function(e){
					$("#sonuc").html(e);
				}
			});
		}); 
	});
</script>