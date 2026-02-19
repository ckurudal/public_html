
<section class="content">
	<?php

		if ($sifre == "sifre") {

		$ysifre=$yonetici->fetch();

		if (isset($_POST["sifrekaydet"])) {

			$yenisifre=$_POST["yenisifre"];

			if (!empty($yenisifre)) {

			$yenisifre=trim(md5($_POST["yenisifre"]));

				$sifreduzenle=$vt->query("UPDATE yonetici SET pass = '$yenisifre' where id = '$id'");

			}

			go("index.php?do=islem&ofis=yonetici&islem=duzenle&id={$id}",0);

		}

	?>

	<form action="" method="POST">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"> <i class="fa fa-key"></i> Şifre Değiştir </h3>
			</div>
			<div class="box-body">
				<div class="form-horizontal">
					<div class="form-group">
						<div class="col-sm-5">
							<input type="text" class="form-control" placeholder="Üye Adı" value="<?=$ysifre["adsoyad"];?>" disabled>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-5">
							<input type="text" class="form-control" placeholder="E-posta" value="<?=$ysifre["email"];?>" disabled>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-5">
							<input type="text" class="form-control" placeholder="Yeni Şifre" name="yenisifre">
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<button type="submit" class="btn btn-primary btn-lg" name="sifrekaydet"> <i class="fa fa-check"></i> Şifreyi Güncelle </button>
			 </div>
		</div>
	</form>
	<?php } ?>
	<?php if (yetki() == 0 || yetki() == 2 ): ?>
	<?php if (yetki() == 0): ?>
	<div class="box-hea der">
		<?php

				if ($hareket == "onay") {
					onay();
				}

		?>
         <div class="row">
         	<div class="col-md-8">
	            <a href="index.php?do=islem&ofis=yonetici&islem=liste" class="btn btn-lg bt-xs btn-info">
	                <i class="fa fa-chevron-right"></i> Tüm Üyeler
	            </a>
	            <a href="index.php?do=islem&ofis=yonetici&islem=liste&uye=kurumsal" class="btn btn-lg bt-xs btn-info">
	                <i class="fa fa-chevron-right"></i> Kurumsal Üyeler
	            </a>
	            <a href="index.php?do=islem&ofis=yonetici&islem=liste&uye=bireysel" class="btn btn-lg bt-xs btn-info">
	                <i class="fa fa-chevron-right"></i> Bireysel Üyeler
	            </a>
	            <a href="index.php?do=islem&ofis=yonetici&islem=liste&uye=danisman" class="btn btn-lg bt-xs btn-info">
	                <i class="fa fa-chevron-right"></i> Danışmanlar
	            </a>
	            <a href="index.php?do=islem&ofis=yonetici&islem=liste&uye=yonetici" class="btn btn-lg bt-xs btn-primary">
	                <i class="fa fa-chevron-right"></i> Yöneticiler
	            </a>
         	</div>
         	<div class="col-md-4 text-right">

		         	<?php if ($uye == "bireysel") { ?>
		            <a href="index.php?do=islem&ofis=yonetici&islem=ekle&uyeekle=bireysel" class="btn btn-lg bt-xs btn-success">
		                <i class="fa fa-plus"></i> Bireysel / Yeni Ekle
		            </a>
		         	<?php } ?>
		         	<?php if ($uye == "kurumsal") { ?>
		            <a href="index.php?do=islem&ofis=yonetici&islem=ekle&uyeekle=kurumsal" class="btn btn-lg bt-xs btn-success">
		                <i class="fa fa-plus"></i> Kurumsal / Yeni Ekle
		            </a>
		         	<?php } ?>
		         	<?php if ($uye == "danisman") { ?>
		            <a href="index.php?do=islem&ofis=yonetici&islem=ekle&uyeekle=danisman" class="btn btn-lg bt-xs btn-success">
		                <i class="fa fa-plus"></i> Danışman / Yeni Ekle
		            </a>
		         	<?php } ?>
		         	<?php if ($uye == "yonetici") { ?>
		            <a href="index.php?do=islem&ofis=yonetici&islem=ekle&uyeekle=yonetici" class="btn btn-lg bt-xs btn-success">
		                <i class="fa fa-plus"></i> Yönetici / Yeni Ekle
		            </a>
		         	<?php } ?>

         	</div>
    	</div>
	</div>
	<?php endif; ?>
	 <?php if (yetki() == 0 || yetki() == 2): ?>
	<div class="bo x">

    	<?php if ($emlakofisi == true) { ?>
         <?php
         	$subeleradi = $vt->query("SELECT * FROM subeler where id = '$emlakofisi'");
         	$subeadi = $subeleradi->fetch();
         ?>
         <h5 class="alert alert-success"><i class="fa fa-users"></i> <strong><?=$subeadi["adi"];?></strong> Gayrimenkul Danışmanları</h5>
         <?php } ?>
		<div class="box-b ody">


			<?php

				if ($hareket == "sil") {

					$sil = $vt->query("DELETE FROM yonetici where id = '$id'");

	            	$ral = $yonetici->fetch();
					unlink("../".$ral['resim']);

					$sosyalsil = $vt->query("DELETE FROM yonetici_sosyal where yoneticiid = '$id'");

					if ($yetki == 2) {
						$silofis = $vt->query("DELETE FROM subeler where yetkiliuye = '$id'");
					}

					if (yetki() == 0) {go("index.php?do=islem&ofis=yonetici&islem=liste&hareket=onay",0);}
					if (yetki() == 1) {go("index.php?do=islem&ofis=yonetici&islem=liste&uye=bireysel&hareket=onay",0);}
					if (yetki() == 2) {go("index.php?do=islem&ofis=yonetici&islem=duzenle&id={$_SESSION["id"]}&tab_goster=magaza_paketleri&tab_goster=danismanlari",0);}
					if (yetki() == 3) {go("index.php?do=islem&ofis=yonetici&islem=liste&uye=danisman&hareket=onay",0);}

				}

				if ($durum == "0") {
					$d = $vt->query("UPDATE yonetici SET durum = '0' where id = '$id'");

					if ($yetki == 0) {go("index.php?do=islem&ofis=yonetici&islem=liste&uye=yonetici&hareket=onay",0);}
					if ($yetki == 1) {go("index.php?do=islem&ofis=yonetici&islem=liste&uye=bireysel&hareket=onay",0);}
					if ($yetki == 2) {go("index.php?do=islem&ofis=yonetici&islem=liste&uye=kurumsal&hareket=onay",0);}
					if ($yetki == 3) {go("index.php?do=islem&ofis=yonetici&islem=liste&uye=danisman&hareket=onay",0);}

				}
				if ($durum == "1") {
					$d = $vt->query("UPDATE yonetici SET durum = '1' where id = '$id'");

					if ($yetki == 0) {go("index.php?do=islem&ofis=yonetici&islem=liste&uye=yonetici&hareket=onay",0);}
					if ($yetki == 1) {go("index.php?do=islem&ofis=yonetici&islem=liste&uye=bireysel&hareket=onay",0);}
					if ($yetki == 2) {go("index.php?do=islem&ofis=yonetici&islem=liste&uye=kurumsal&hareket=onay",0);}
					if ($yetki == 3) {go("index.php?do=islem&ofis=yonetici&islem=liste&uye=danisman&hareket=onay",0);}
				}
			?>
			<?php if (yetki() == 0): ?>
			<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-boots trap table-responsive">
				<table id="example1" class="table table-bordered table-striped table-hover dataTable" role="grid" aria-describedby="example1_info">
				    <thead>
				        <tr>
				            <td style="width:0.01%;"> ID </td>
				            <td style="width:0.0001%;"> Profial </td>
				            <td style="width:0.1%;"> Ad Soyad </td>
				            <td style="width:0.1%;"> Ünvan </td>
				            <?php if ($uye == "danisman" || $emlakofisi == true) { ?>
				            <td style="width:0.1%;"> Mağaza </td>
				            <?php } ?>
				            <?php if ($uye == "kurumsal") { ?>
				            <td style="width:0.1%;" colspan="2"> Yetkili Olduğu Emlak Ofisi </td>
				            <?php } ?>
				            <td style="width:0.05%;"> Email / GSM / Tel</td>
				            <td style="width:0.1%;"> Üyelik Tipi </td>
				            <td style="width:0.05%;"> Durum </td>
				            <td class="text-center" style="width:0.1%; white-space: nowrap;"> İşlemler </td>
				        </tr>
				    </thead>
				    <tbody>
				    	<?php
				    		while($yliste = $yoneticiliste->fetch()) {
				    	?>
				    	<tr>
				    		<th>
                                <?=$yliste["id"];?>
                            </th>
				    		<th>
				    			<?php
				    			echo $_SESSION["yetki"];
				    				if (!$yliste["resim"] == "") {
				    			?>
			    				<div class="resim_liste">
									<img src="/<?=$yliste["resim"];?>"/>
								</div>
								<?php } else { ?>
								<div class="resim_liste">
									<img src="../uploads/resim/resim.png"/>
								</div>
								<?php } ?>
				    		</th>
				    		<th><?=$yliste["adsoyad"];?></th>
				    		<th><?=$yliste["unvan"];?></th>
				    		<?php if ($uye == "danisman" || $emlakofisi == true) { ?>
				    		<th>
				    		<?php
				    			$emlakofisliste = $vt->query("SELECT * FROM subeler where id = '".$yliste["ofis"]."'");
				    			$ofisliste = $emlakofisliste->fetch();
				    		?>
				    		<?=$ofisliste["adi"];?>
				    		</th>
				    		<?php } ?>
				    		<?php if ($uye == "kurumsal") { ?>
				    		<th>
				    		<?php
				    			$emlakofiskurumsal = $vt->query("SELECT * FROM subeler where yetkiliuye = '".$yliste["id"]."'");
				    			$ofislistekurumsal = $emlakofiskurumsal->fetch();
				    		?>
				    		<a href="index.php?do=islem&ofis=subeekle&islem=duzenle&id=<?=$ofislistekurumsal["id"];?>"><?=$ofislistekurumsal["adi"];?></a>
				    		</th>
				    		<th style="width: 0.01%;"><a class="btn btn-info btn-xs btn-block" href="index.php?do=islem&ofis=yonetici&islem=liste&emlakofisi=<?=$ofislistekurumsal["id"];?>"><i class="fa fa-plus"></i> Danışmanları Listele</a></th>
				    		<?php } ?>
				    		<th>
				    			<?=$yliste["email"];?> <br>
				    			<strong>GSM: </strong><?=$yliste["gsm"];?> <br>
				    			<strong>Tel: </strong><?=$yliste["tel"];?>
				    		</th>
				    		<th>
					    		<?php if ($yliste["yetki"] == 1) { ?> Bireysel Üye <?php } ?>
					    		<?php if ($yliste["yetki"] == 2) { ?> Kurumsal Üye <?php } ?>
					    		<?php if ($yliste["yetki"] == 3) { ?> Danışman <?php } ?>
					    		<?php if ($yliste["yetki"] == 0) { ?> Site Yöneticisi <?php } ?>
				    		</th>
				    		<th>
					    		<?php
			        				if ($yliste["durum"] == 0) {
			        			?>
			        			<span class="btn btn-success btn-xs btn-block"> Yayında </span>
			        			<?php } else if ($yliste["durum"] == 1) { ?>
			        			<span class="btn btn-info btn-xs btn-block"> Yayında Değil</span>
			        			<?php } ?>
				    		</th>
				    		<th class="text-center" >
				    			<a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?=$yliste['id']?>&yetki=<?=$yliste["yetki"];?>" title="Düzenle" class="btn btn-primary btn-xs btn-block">
									<i class="fa fa-pencil"></i> Düzenle
								</a>
								<?php
									if ($yliste["durum"] == "0") {
								?>
								<a href="index.php?do=islem&ofis=yonetici&islem=liste&durum=1&id=<?=$yliste['id']?>&yetki=<?=$yliste["yetki"];?>" title="Yayından Kaldır" class="btn btn-info btn-block btn-xs">
									<i class="fa fa-close"></i> Yayından Kaldır
								</a>
								<?php } else if ($yliste["durum"] == "1"){ ?>
								<a href="index.php?do=islem&ofis=yonetici&islem=liste&durum=0&id=<?=$yliste['id']?>&yetki=<?=$yliste["yetki"];?>" title="Yayınla" class="btn btn-success btn-block btn-xs">
									<i class="fa fa-check"></i> Yayınla
								</a>
								<?php } ?>
								<a href="index.php?do=islem&ofis=yonetici&islem=liste&sifre=sifre&id=<?=$yliste['id']?>&yetki=<?=$yliste["yetki"];?>" title="Şifre Değiştir" class="btn btn-warning btn-block btn-xs">
									<i class="fa fa-key"></i> Şifre Değiştir
								</a>
								<?php
									if ($yliste["id"] !== $_SESSION['id']) {
								?>
								<a href="#" data-toggle="modal" data-target="#<?=$yliste["id"];?>" title="Sil" class="btn btn-danger btn-block btn-xs">
									<i class="fa fa-trash" style="color: r ed;"></i> Sil
								</a>
								<?php } ?>
								<div class="modal modal-default fade" id="<?=$yliste["id"]?>" style="display: none;">
								  <div class="modal-dialog">
									<div class="modal-content">
									  <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										  <span aria-hidden="true">×</span></button>
										<h4 class="modal-title">Silme Onayı Ver</h4>
									  </div>
									  <div class="modal-body">
										<h4><strong> "<?=$yliste["adsoyad"]?>" </strong> isimli danışman silinecektir. İşlemi onaylıyor musunuz ?</h4>
									  </div>
									  <div class="modal-footer">
										<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
										<a href="index.php?do=islem&ofis=yonetici&islem=liste&hareket=sil&id=<?=$yliste['id']?>&yetki=<?=$yliste["yetki"];?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
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
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>
	<?php endif; ?>
</section>