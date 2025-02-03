<?php
	
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
	
	uyeYasak(yetki());
	
	$id = $_GET["id"];
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<i class="fa fa-list fa-2x pull-left"></i>
	Tüm Kategoriler
	<p> <small> Kategori Yönetimi </small> </p> 
</section>
<form method="post" action="">

	<section class="content"> 

	<?php 
			
		// bildirimler

		$islem = $_GET["islem"];

		if ($islem == "ok") {
			onay();
		}

		if ($islem == "hata") {
			hata();
		}

		// kategori sil

		$sil = (@$_GET["sil"]);

		if ($sil) {
			$katsil = mysql_query("DELETE FROM emlak_kategori WHERE kat_id = '$sil'");
			$kattipsil = mysql_query("DELETE FROM emlak_ilantipi_katliste WHERE katid = '$sil'");
			if ($katsil) {
				onay();
			} else {
				hata();
			}
		}

		// durum guncelle 

		$durum = (@$_GET["durum"]);
		
		if ($durum) {
			$ver = mysql_fetch_array(mysql_query("SELECT * FROM emlak_kategori WHERE kat_id = '$durum'"));
			$kdurum = $ver["kat_durum"];
			if ($ver["kat_durum"] == 1) {
					mysql_query("UPDATE emlak_kategori SET kat_durum  = '0' WHERE kat_id = '$durum'");
					onay();
				} else {
					mysql_query("UPDATE emlak_kategori SET kat_durum  = '1' WHERE kat_id = '$durum'");
					onay();
			}
		}

		// sira guncelle
		
		?>


		<a href="index.php?do=islem&emlak=kategori_ekle" class="btn btn-success btn-lg">
                    <i class="fa fa-plus"></i> Yeni Kategori Ekle
                </a> 
		<?php if (isset($_POST["sirakaydet"])) { 
			
			$sira = $_POST["sira"];
			$siraid = $_POST["siraid"];

			for ($i=0; $i < count($sira); $i++) { 

				$sirakaydet = mysql_query("UPDATE emlak_kategori SET sira_no = '$sira[$i]' where kat_id = '$siraid[$i]'");
			}

		} ?>
		<div class="bo x">
			<div class="box-b ody table-responsive">
				<table id="example1" class="table table-bordered dataTable" colspan="5" role="grid" aria-describedby="example1_info">
	                    <thead>
		                    <tr>
		                        <td class="text-center" style="width:0.1%;"> ID </td>
		                        <td> Kategori Adı </td> 
		                        <td> Kategori İlan Şekli </td> 
		                        <td> Kategori İlan Tipi </td> 
		                        <td> Sıra No </td>
		                        <td> Durum </td>
		                        <td> Anasayfada Göster </td>
		                        <td class="text-center"> İşlemler </td>
		                    </tr>
	                    </thead>
	                    <tbody>
	                    <tr>
	                        <?php

	                        // ilan kategori

	                        kategori();

	                        function kategori($id = 0, $i = 0) {
	                            $query = mysql_query("SELECT * FROM emlak_kategori WHERE kat_ustid = '$id' && kat_id");
	                            if (mysql_affected_rows()) {
	                                while ($row = mysql_fetch_array($query)) {

	                                    echo '<tr>';
	                                    echo '<th class="text-center"><span>'.$row["kat_id"].'</span></th>';
	                                    echo '<th>';
	                                    echo '<p href="index.php?do=ilanduzenle&id='.$row["kat_id"].'">';
	                                    if ($row["kat_ustid"] == 0) {
	                                        echo '<strong>'.str_repeat('-', $i).$row["kat_adi"].' - [ Ana Kategori ] </strong>';
	                                    } else {
	                                        echo ''.str_repeat('[-] ', $i).$row["kat_adi"].'';
	                                    }									
	                                    echo '</th>';

	                                    echo '<th>';

	                                   	$ilansekliver = mysql_query("SELECT * FROM emlak_ilansekli where id = '".$row["ilansekli"]."'");
										$isekli = mysql_fetch_array($ilansekliver);

										echo '<span class="btn btn-default btn-xs"> <span>'.$isekli["baslik"].'</span></span> ';

	                                    echo '</th>';

	                                    echo '<th>';

										$kattipliste = mysql_query("SELECT * FROM emlak_ilantipi_katliste where katid = '".$row["kat_id"]."'");
										while($kattip = mysql_fetch_array($kattipliste)) {
			                            
			                                $tipliste = mysql_query("SELECT * FROM emlak_ilantipi where id = '".$kattip["ilantipid"]."'");
											while($tip = mysql_fetch_array($tipliste)) {

												echo '<span class="btn btn-default btn-xs" style="margin-right: 4px;"> '.$tip["ad"].' </span>';

											}

										}

	                                    echo '</th>';

	                                    echo '
													<th>
														<input type="text" class="form-control hidden" name="siraid[]" value="'.$row["kat_id"].'">
														<input type="text" class="form-control" name="sira[]" value="'.$row["sira_no"].'">
													</th>
												';
	                                    echo '<th> ';
	                                    if ($row["kat_durum"] == 1 ) {
	                                        echo '<span class="btn btn-success btn-block btn-xs"> Yayında </span>';
	                                    } else {
	                                        echo '
															<span class="btn btn-warning btn-block btn-xs"> Yayında Değil </span>
														';
	                                    }
	                                    echo '</th> ';
	                                    
										echo '<th class="text-center" style="width: 1px; white-space: nowrap;">';
										
										if ($row["anasayfa_goster"] == 0) {
										
											echo '<span class="btn bg-danger btn-block btn-xs"> Gizli </span>';
	                                    
										} else {
											
											echo '<span class="btn bg-success btn-block btn-xs"> Görünüyor </span>';											
											
										}
										
										echo '</th> ';
										
	                                    echo '<th class="text-center" style="width: 1px; white-space: nowrap;">';
	                                    echo '
											<a href="index.php?do=islem&emlak=kategori_duzenle&id='.$row["kat_id"].'" title="Düzenle" class="btn btn-inverse">
												<i class="fa fa-pencil"></i>
											</a>
												';
	                                    if ($row["kat_durum"] == 1) {
	                                        echo '
															<a href="index.php?do=islem&emlak=kategori&durum='.$row["kat_id"].'" title="Pasif Et" class="btn btn-default">
																<i class="fa fa-power-off fa-lg"></i>
															</a>
														';
	                                    } else {
	                                        echo'
															<a href="index.php?do=islem&emlak=kategori&durum='.$row["kat_id"].'" title="Aktif Et" class="btn btn-default">
																<i class="fa fa-check fa-lg"></i>
															</a>
														';
	                                    }
	                                    echo '
													<a href="#" data-toggle="modal" data-target="#'.$row["kat_id"].'" title="Sil" class="btn btn-danger">
														<i class="fa fa-trash"></i>
													</a>
													<div class="modal modal-default fade" id="'.$row["kat_id"].'" style="display: none;">
													  <div class="modal-dialog">
														<div class="modal-content">
														  <div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															  <span aria-hidden="true">×</span></button>
															<h4 class="modal-title">Silme Onayı Ver</h4>
														  </div>
														  <div class="modal-body">
															<h4><strong> "'.$row["kat_adi"].'" </strong> isimli kategori silinecektir. İşlemi onaylıyor musunuz ?</h4>
														  </div>
														  <div class="modal-footer">
															<a href="#" class="btn btn-default" data-dismiss="modal"> Hayır </a>
															<a href="index.php?do=islem&emlak=kategori&sil='.$row["kat_id"].'" class="btn btn-danger"> Onaylıyorum Sil <i class="fa fa-trash"></i> </a>
														  </div>
														</div> 
													  </div> 
													</div> 
												';
	                                    echo '</th>';
	                                    echo '</tr>';
	                                    kategori($row["kat_id"], $i + 1);
	                                }
	                            } else {
	                                return false;
	                            }
	                        }

	                        ?>
	                    </tr>
                    </tbody>

                	</table>
            </div>
          </div>
          <button name="sirakaydet" class="btn btn-lg btn-primary"> <i class="fa fa-save fa-lg"></i> Sıralamayı Kaydet </button>
	</section>
</form>

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