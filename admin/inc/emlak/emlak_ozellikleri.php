<?php 

	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
	
	uyeYasak(yetki());
	
	$islem = $_GET["islem"];
	$id = $_GET["id"];	
	$hareket = $_GET["hareket"];	

 ?>
 <!-- Content Header (Page header) -->
<section class="content-header">

  	<i class="fa fa-edit fa-2x pull-left"></i>
	
	İlan Özellik Yönetimi

	<p> <small> İlan Seçenekleri </small> </p> 

</section> 
<?php if ($islem=="") { ?>
<section class="content">	
	<?php 
		$durum = $_GET["durum"];

		 // durum guncelle 

	    if ($durum) {
	        $ver = mysql_fetch_array(mysql_query("SELECT * FROM emlak_ozellik WHERE id = '$durum'"));
	        $kdurum = $ver["durum"];
	        if ($ver["durum"] == 1) {
	                mysql_query("UPDATE emlak_ozellik SET durum = '0' WHERE id = '$durum'");
	                onay();
	            } else {
	                mysql_query("UPDATE emlak_ozellik SET durum  = '1' WHERE id = '$durum'");
	                onay();
	        }
	    }
	?>	
	<form method="post" action="" enctype="multipart/form-data">	
		<?php
			if ($hareket == "onay") {
				onay();
			}
		?>
		<div class="b ox"> 
			<div class="box-b ody table-responsive">
	            <a href="index.php?do=islem&emlak=emlak_ozellikleri&islem=ekle" class="btn btn-lg bt-xs btn-success">
	                <i class="fa fa-plus"></i> Yeni Özellik Ekle
	            </a> 
				<table id="example1" class="table table-bordered dataTable" colspan="5" role="grid" aria-describedby="example1_info">
                    <thead>
                    <tr>
                        <td class="text-center" style="width:1%;"> ID </td>
                        <td style="width:10%;"> Özellik Adı </td>
                        <td style="width:15%;"> Özellik Tipi </td>
                        <td style="width:15%;"> İlan Şekli </td>
                        <td style="width:5%;"> Durum </td>
                        <td style="width:8%;" class="text-center"> İşlemler </td>
                    </tr>
                    </thead>
                    <tbody>
                    	<?php

                    		$ozellikcek=mysql_query("select * from emlak_ozellik order by id desc");
                    		while ($oz=mysql_fetch_array($ozellikcek)) {

                    	?>
                    	<tr> 
	                    	<th class="text-center"> 
	                    		<h5> <strong> <?=$oz[id];?> </strong> </h5>
	                    	</th>
	                    	<th class="">
	                    		<h5> <strong> <?=$oz[ad];?> </strong> </h5>
	                    	</th>
	                    	<th class=""> 
	                    	<?php 
	                    		$oztipcek = mysql_query("SELECT * FROM emlak_ozelliktip where id = $oz[ozelliktipi]");
	                    		$oztip = mysql_fetch_array($oztipcek);
	                    		echo $oztip[ad];
	                    	?>
	                    	</th> 
	                    	<th class="">
	                    		<?php 
	                    			$ilans=mysql_query("SELECT * FROM emlak_ilansekli where id = '$oz[ilansekli]'");
	                    			$s=mysql_fetch_array($ilans);
	                    		?>
	                    		<span class="btn btn-default btn-xs"><?=$s["baslik"];?></span>
	                    	</th>
	                    	<th class=""> 
	                    	<?php 
		                    	if ($oz["durum"] == 0 ) {
                                    echo '
										<span class="btn bg-success btn-xs btn-block"> Aktif </span>
									';
                                } else {
                                    echo '
										<span class="btn bg-danger btn-xs btn-block"> Pasif </span>
									';
                                }
	                    	?>
	                    	 </th>
	                    	<th class="text-center"> 
	                    	<a href="index.php?do=islem&emlak=emlak_ozellikleri&islem=duzenle&id=<?=$oz["id"];?>" title="Düzenle" class="btn btn-primary btn-xs btn-block">
									<i class="fa fa-pencil"></i> Düzenle
							</a>
							<?php if ($oz[durum]==0) { ?>
							<a href="index.php?do=islem&emlak=emlak_ozellikleri&durum=<?=$oz["id"];?>" title="Pasif Et" class="btn btn-warning btn-xs btn-block">
								<i class="fa fa-close"></i> Pasif Yap
							</a>
							<?php } else { ?>
							<a href="index.php?do=islem&emlak=emlak_ozellikleri&durum=<?=$oz["id"];?>" title="Aktif Et" class="btn btn-success btn-xs btn-block">
								<i class="fa fa-check"></i> Aktif Et
							</a>
							<?php } ?>
							<a  data-toggle="modal" data-target="#<?=$oz["id"]?>" href="#" title="Sil" class="btn btn-danger btn-xs btn-block">
									<i class="fa fa-trash"></i> Sil
							</a>
							<div class="modal modal-default text-center fade" id="<?=$oz["id"]?>" style="display: none;">
							  <div class="modal-dialog">
								<div class="modal-content">
								  <div class="modal-header alert alert-info">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">×</span></button>
									<h4 class="modal-title"><i class="fa fa-close"></i> Silme Onayı Ver</h4>
								  </div>
								  <div class="modal-body">
									<h4><strong> "<?=$oz["ad"]?>" </strong> isimli özellik silinecektir. İşlemi onaylıyor musunuz ?</h4>
								  </div>
								  <div class="modal-footer">
									<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
									<a href="index.php?do=islem&emlak=emlak_ozellikleri&islem=sil&id=<?=$oz["id"];?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
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
<?php if ($islem == "sil") { ?>
	<section class="content">
		<?php 
		
			$id = $_GET[id];

			$sil = mysql_query("DELETE FROM emlak_ozellik where id = '$id'");			

			if ($sil) {				
				onay("Başarılı bir şekilde silindi");
				go("index.php?do=islem&emlak=emlak_ozellikleri",0.5);
			} else {
				hata();
			}

		?>
	</section>
<?php } ?>
<?php if ($islem=="ekle") { ?> 
<section class="content">		 
	<?php
		if (isset($_POST["ekle"])) {
			$ad = trim($_POST["ad"]);
			$seo = seo($_POST["ad"]);
			$ozelliktipi=$_POST["ozelliktipi"];
			$ilansekli=$_POST["ilansekli"];

			if (empty($ad)) {
				hata("Başlık alanı boş olamaz! Lütfen bir başlık ekleyiniz!");
			} else {

				$ekle=mysql_query("INSERT INTO emlak_ozellik (ad,seo,ilansekli,ozelliktipi) VALUES ('$ad','$seo','$ilansekli','$ozelliktipi')");

				if ($ekle) {
					onay();
				}  
			}

			
		}
	?>
	<form method="post" action="" enctype="multipart/form-data">	
		<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title"><i class="fa fa-check"></i> İlan Özellik Ekleme </h3>
			  <!-- tools box -->
			  <div class="pull-right box-tools">
				<a href="#" class="btn" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Daralt">
				  <i class="fa fa-minus"></i></a>
				<a href="#" class="btn" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Kapat">
				  <i class="fa fa-times"></i></a>
			  </div>
			  <!-- /. tools -->
			</div> 
			<!-- /.box-header -->
			<div class="box-body" style="">
				<div class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-2 control-label">Başlık :</label>
					  <div class="col-sm-10"> 
						<input type="text" class="form-control" name="ad">
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Özellik Tipi Seçiniz :</label>
					  <div class="col-sm-10">
		                	<select name="ozelliktipi" class="form-control select2"> 
			                    <optgroup label="">
			                    	<option>Seçiniz</option>
			                    	<?php 
			                    	/*
			                    		$sekliver=mysql_query("SELECT * FROM emlak_ilansekli where id");
			                    		while ($sekli=mysql_fetch_array($sekliver)) {
			                    	?>
									<!-- <option value="<?=$sekli[id];?>"> <?=$sekli[baslik];?> </option> -->

			                    	<?php } */ ?>
									<?php 
			                    		$query=mysql_query("SELECT * FROM emlak_ozelliktip order by ad");
			                    		while ($row=mysql_fetch_array($query)) {
			                    	?>						 									
									<option value="<?=$row[id];?>">-- <?=$row[ad];?></option>									 									
									<?php } ?>
									
			                    </optgroup>			                    
		                  </select>
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">İlan Şekli Seçiniz :</label>
					  <div class="col-sm-10">
		                	<select name="ilansekli" class="form-control select2"> 
			                    <optgroup label=" ">		
			                    	<option>Seçiniz</option>
			                    	<?php 
			                    		$query=mysql_query("SELECT * FROM emlak_ilansekli where id");
			                    		while ($row=mysql_fetch_array($query)) {
			                    	?>
									<option value="<?=$row[id];?>"><?=$row[baslik];?></option>									 									
									<?php } ?>
			                    </optgroup>			                    
		                  </select>
					  </div>
					</div> 
				</div>
			</div>
			<div class="box"> 
				<div class="box-footer">
					<button type="submit" name="ekle" class="btn btn-primary btn-lg"> <i class="fa fa-check"></i> Ekle </button>
					<a href="index.php?do=islem&emlak=emlak_ozellikleri" class="btn btn-default btn-lg pull-right"> <i class="fa fa-chevron-left"></i> İlan Özellikleri </a>
				 </div> 
			</div>
		  </div>
	</form>
</section>
<?php } ?>
<?php if ($islem=="duzenle") { ?> 
<section class="content"> 
	<?php 
		if (isset($_POST["duzenle"])) {
			$ad = trim($_POST["ad"]);
			$seo = seo($_POST["ad"]);
			$ozelliktipi = $_POST["ozelliktipi"];
			$ilansekli = $_POST["ilansekli"];

			$duzenle=mysql_query("UPDATE emlak_ozellik SET ad = '$ad', seo = '$seo', ozelliktipi = '$ozelliktipi', ilansekli = '$ilansekli' where id = '$id'");

			if ($duzenle) {
				go("index.php?do=islem&emlak=emlak_ozellikleri&hareket=onay", 0);
			}
		}
	?>
	<form method="post" action="" enctype="multipart/form-data">	
		<div class="box">
			<div class="box-header with-border">
			  <h3 class="box-title"><i class="fa fa-check"></i> İlan Özellik Tipi Ekleme </h3>
			  <!-- tools box -->
			  <div class="pull-right box-tools">
				<a href="#" class="btn" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Daralt">
				  <i class="fa fa-minus"></i></a>
				<a href="#" class="btn" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Kapat">
				  <i class="fa fa-times"></i></a>
			  </div>
			  <!-- /. tools -->
			</div> 
			<!-- /.box-header -->
			<div class="box-body" style="">
				<div class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-2 control-label">Başlık:</label>
					  <div class="col-sm-10"> 
					  <?php 
						  $query=mysql_query("SELECT * FROM emlak_ozellik where id = '$id'");
						  $row=mysql_fetch_array($query)
					  ?>
						<input type="text" class="form-control" name="ad" value="<?=$row[ad];?>">
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">Özellik Tipi Seçiniz :</label>
					  <div class="col-sm-10">
		                	<select name="ozelliktipi" class="form-control select2"> 
			                   	<optgroup label="">
			                   		<option>Seçiniz</option>
			                    	<?php /*
			                    		$sekliver=mysql_query("SELECT * FROM emlak_ilansekli where id");
			                    		while ($sekli=mysql_fetch_array($sekliver)) {
			                    	?>
									<?php } */ ?>
									<!-- <option value="<?=$sekli[id];?>"> <?=$sekli[baslik];?> </option> -->
									<?php 
			                    		$ozellik=mysql_query("SELECT * FROM emlak_ozellik where id = '$id'");
			                    		$o=mysql_fetch_array($ozellik);
			                    		$query=mysql_query("SELECT * FROM emlak_ozelliktip order by ad asc");
			                    		while ($row=mysql_fetch_array($query)) {
			                    	?>								 									
									<option <?php if ($o["ozelliktipi"] == $row["id"]) {echo "selected";} ?> value="<?=$row[id];?>">-- <?=$row[ad];?></option>									 									
			                    	<?php } ?>
									
			                    </optgroup>			                    
		                  </select>
					  </div>
					</div> 
					<div class="form-group">
					  <label class="col-sm-2 control-label">İlan Şekli Seçiniz :</label>
					  <div class="col-sm-10">
		                	<select name="ilansekli" class="form-control select2"> 
			                    <optgroup label=" ">
			                    	<option>Seçiniz</option>
			                    	<?php 
			                    		$ozellik=mysql_query("SELECT * FROM emlak_ozellik where id = '$id'");
			                    		$o=mysql_fetch_array($ozellik);
			                    		$query=mysql_query("SELECT * FROM emlak_ilansekli where id");
			                    		while ($row=mysql_fetch_array($query)) {
			                    	?>
									<option <?php if ($o["ilansekli"] == $row["id"]) {echo "selected";} ?> value="<?=$row[id];?>"><?=$row[baslik];?></option>									 									
									<?php } ?>
			                    </optgroup>			                    
		                  </select>
					  </div>
					</div> 
				</div>
			</div>
			<div class="box"> 
				<div class="box-footer">
					<button type="submit" name="duzenle" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Kaydet </button>
					<a href="index.php?do=islem&emlak=emlak_ozellikleri" class="btn btn-default btn-lg"> <i class="fa fa-chevron-left"></i> İlan Özellikleri </a>
				 </div> 
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
      'autoWidth'   : false,

    })
  })
</script>
