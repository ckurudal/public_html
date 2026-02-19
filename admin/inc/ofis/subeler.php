<?php
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
	
	uyeYasak(yetki());
	
	$islem = $_GET["islem"];
	$subeler = $vt->query("SELECT * FROM subeler order by id desc");
	$id = $_GET["id"];
	$durum = $_GET["durum"];
?>
<section class="content-header">
	Mağaza Yönetimi
	<p> <small> Tüm Mağazalar </small> </p>
  <ol class="breadcrumb">
	<li><a href="index.php"><i class="fa fa-dashboard"></i> Anasayfa </a></li>
	<li> <a href="index.php?do=tumilanlar"> Tüm İlanlar </a> </li>
	<li class="active"> İlan Yönetimi </li>
  </ol>
</section>
<section class="content">
	<a href="index.php?do=islem&ofis=yonetici&islem=ekle&uyeekle=kurumsal" class="btn btn-lg bt-xs btn-success">
			<i class="fa fa-plus"></i> Yeni Mağaza Ekle
	</a>
	<div class="bo x">
		<div class="box-bod y table-responsive">
			<?php

				if ($islem == "ekle" || $islem == "kaydet")
				{
					onay();
				}

				if ($islem == "sil") {

					$subeid = $vt->query("SELECT * FROM subeler where id = '$id'");
					$sube = $subeid->fetch();

					$targetDir = '../'.$sube['resim'];

					unlink("$targetDir");

					$yoneticisil = $vt->query("DELETE FROM yonetici where id = '".$sube["yetkiliuye"]."'");

					$sosyalsil = $vt->query("DELETE FROM yonetici_sosyal where yoneticiid = '".$sube["yetkiliuye"]."'");

					$sil = $vt->query("DELETE FROM subeler where id = '$id'");

					go("index.php?do=islem&ofis=subeler",0);
				}

				if ($durum == "0") {
					$d = $vt->query("UPDATE subeler SET durum = '0' where id = '$id'");
					go("index.php?do=islem&ofis=subeler",0);
				}
				if ($durum == "1") {
					$d = $vt->query("UPDATE subeler SET durum = '1' where id = '$id'");
					go("index.php?do=islem&ofis=subeler",0);
				}
			?>
			<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive">
			<table id="example1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example1_info">
		        <thead>
			        <tr>
			            <td class="text-center" style="width:0.03%;"> ID </td>
			            <td style="width:0.001%;"> Resim </td>
			            <td style="width:0.1%;"> Mağaza Adı </td>
			            <td style="width:0.1%;"> Mağaza Yetkilisi </td>
			            <td style="width:0.005%;"> Danışmanlar </td>
			            <td style="width:0.1%;"> Mağaza Telefon </td>
			            <td style="width:0.1%;"> Mağaza Email </td>
			            <td style="width:0.05%;"> Durum </td>
			            <td class="text-center" style="width:0.1%;"> İşlemler </td>
			        </tr>
		        </thead>
		        <tbody>
		        	<?php
		        		while($s = $subeler->fetch()) {

		        			$yetkiliid = $vt->query("SELECT * FROM yonetici where id = '".$s["yetkiliuye"]."' AND yetki = 2");
		        			$yetkili = $yetkiliid->fetch();
		        	?>
		        	<tr>
		        		<th class="text-center">
		        			<h5> <strong> <?=$s["id"];?> </strong> </h5>
		        		</th>
		        		<th>
		        			<?php if ($s["resim"] == "") { ?>
		        				<img src="/uploads/resim/resim.png" width="80">
		        			<?php } else { ?>
		        				<img src="/<?=$s["resim"];?>" width="80">
		        			<?php } ?>
		        		</th>
		        		<th>
		        			<h5> <strong> <?=$s["adi"];?> </strong> </h5>
		        		</th>
		        		<th>
		        			<a class="btn btn-block btn-default btn-xs" href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?=$yetkili["id"];?>&yetki=<?=$yetkili["yetki"];?>"><i class="fa fa-user-plus"></i> <?=$yetkili["adsoyad"];?></a>
		        		</th>
		        		<th>
									<a class="btn btn-info btn-xs btn-block" href="index.php?do=islem&ofis=yonetici&islem=liste&emlakofisi=<?=$s["id"];?>"><i class="fa fa-plus"></i> Danışmanları Listele</a>
									<a class="btn btn-success btn-xs btn-block" href="index.php?do=islem&emlak=emlak_ilanlar&magaza=<?=$s["id"];?>"><i class="fa fa-plus"></i> Tüm İlanları</a>
								</th>
		        		<th><?=$s["sabittel"];?></th>
		        		<th><?=$s["email"];?></th>
		        		<th>
		        			<?php
		        				if ($s["durum"] == 0) {
		        			?>
		        			<span class="btn btn-success btn-xs btn-block"> Yayında </span>
		        			<?php } else if ($s["durum"] == 1) { ?>
		        			<span class="btn btn-info btn-xs btn-block"> Yayında Değil</span>
		        			<?php } ?>
		        		</th>
		        		<th class="text-center" style="width: 1px; white-space: nowrap;">
		        			<a href="index.php?do=islem&ofis=subeekle&islem=duzenle&id=<?=$s['id']?>" title="Düzenle" class="btn btn-primary btn-block btn-xs">
								<i class="fa fa-pencil"></i> Düzenle
							</a>
							<?php
								if ($s["durum"] == "0") {
							?>
							<a href="index.php?do=islem&ofis=subeler&durum=1&id=<?=$s['id']?>" title="Yayından Kaldır" class="btn btn-info btn-block btn-xs">
								<i class="fa fa-close"></i> Yayından Kaldır
							</a>
							<?php } else if ($s["durum"] == "1"){ ?>
							<a href="index.php?do=islem&ofis=subeler&durum=0&id=<?=$s['id']?>" title="Yayınla" class="btn btn-success btn-block btn-xs">
								<i class="fa fa-check"></i> Yayınla
							</a>
							<?php } ?>
							<a href="#" data-toggle="modal" data-target="#<?=$s["id"];?>" title="Sil" class="btn btn-danger btn-block btn-xs">
								<i class="fa fa-trash" style="color: r ed;"></i>  Sil
							</a>
							<div class="modal modal-default fade" id="<?=$s["id"]?>" style="display: none;">
							  <div class="modal-dialog">
								<div class="modal-content">
								  <div class="modal-header alert alert-info">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">×</span></button>
									<h4 class="modal-title"><i class="fa fa-close"></i> Silme Onayı Ver</h4>
								  </div>
								  <div class="modal-body">
									<h4><strong> "<?=$s["adi"]?>" </strong> isimli <u>şube</u> ve <br><strong><?=$yetkili["adsoyad"];?></strong> isimli <u>kurumsal üye</u> silinecektir.<br>İşlemi onaylıyor musunuz ?</h4>
								  </div>
								  <div class="modal-footer">
									<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
									<a href="index.php?do=islem&ofis=subeler&islem=sil&id=<?=$s['id']?>" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
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
    </div>
</section>

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
