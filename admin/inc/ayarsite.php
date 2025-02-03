<?php 
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
	
	uyeYasak(yetki());
	
	$hareket = @$_GET["hareket"];
?>

<!-- Content Header (Page header) -->

<section class="content-header">

	<i class="fa fa-cog fa-2x pull-left"></i>
	 
	Site Ayarları

	<p> <small> Genel Ayarları </small> </p>

</section>

<section class="content">	
	<?php 						
		
		if ($_POST) {							
			
			$site_adi = p("site_adi");
			$site_desc = p("site_desc");
			$site_keyw = p("site_keyw");
			$site_durum = p("site_durum");
			$talep_formu = p("talep_formu");
			$site_header = p("site_header");
			$kapali_mesaj = p("kapali_mesaj");
			$site_url = p("site_url");
			$site_yonetim_url = p("site_yonetim_url");
			$kategori_ilan_adet = p("kategori_ilan_adet");
			$en_yeni = p("en_yeni");
			$one_cikan = p("one_cikan");
			$ana_vitrin = p("ana_vitrin");
			$acil_ilan = p("acil_ilan");
			$firsat_ilan = p("firsat_ilan");
			
			if (!$site_adi || !$site_desc || !$site_keyw) {
				hata();
			} else {
				
				$update = query("UPDATE ayarlar SET 
					site_adi = '$site_adi',
					site_desc = '$site_desc',
					site_keyw = '$site_keyw',
					site_url = '$site_url',
					site_yonetim_url = '$site_yonetim_url',
					talep_formu = '$talep_formu',
					site_header = '$site_header',
					site_durum = '$site_durum',
					kapali_mesaj = '$kapali_mesaj',
					kategori_ilan_adet = '$kategori_ilan_adet',
					en_yeni = '$en_yeni',
					one_cikan = '$one_cikan',
					ana_vitrin = '$ana_vitrin',
					acil_ilan = '$acil_ilan',
					firsat_ilan = '$firsat_ilan'
					");
				
				if ($update) { 
					go("index.php?do=ayarsite&hareket=onay", 0);
				}
			}
		} 
	?>
	<div class="row">
		<div class="col-md-9">			
			<?php 

				if ($hareket == "onay") {
					onay();
				}

			?>
			<div class="box">
				<div class="box-header with-border">
				  <h5 class="box-title"> <i class="fa fa-edit"></i> Title &amp; Açıklama </h5>
				</div>
				<div class="box-body">
					
					<form class="form-horizontal" method="post" action="">
						<div class="form-group">
						  <label class="col-sm-2 control-label">Site Title:</label>
						  <div class="col-sm-10"> 
							<input type="text" class="form-control" name="site_adi" value="<?php echo $ayar["site_adi"]; ?>">
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-sm-2 control-label">Google Açıklama:</label>
						  <div class="col-sm-10"> 
							<textarea class="form-control" name="site_desc" rows="3" ><?php echo $ayar["site_desc"]; ?></textarea>
						  </div>
						</div> 
						<div class="form-group">
						  <label class="col-sm-2 control-label">Site URL:</label>
						  <div class="col-sm-10">
							<input type="text" name="site_url" class="form-control" value="<?php echo $ayar["site_url"]; ?>">
						  </div>
						</div> 
						<div class="form-group">
						  <label class="col-sm-2 control-label">Site Yönetim URL:</label>
						  <div class="col-sm-10">
							<input type="text" name="site_yonetim_url" class="form-control" value="<?php echo $ayar["site_yonetim_url"]; ?>">
							<small>Admin panel url'sini değiştirmek için buradan değişiklik yaptıktan sonra ftp ile sunucunuza bağlanarak admin dizininin adını değiştirmeniz gerekmektedir.</small>
						  </div>
						</div> 
						<div class="form-group">
						  <label class="col-sm-2 control-label">Anahtar Kelimeler (Etiket):</label>
						  <div class="col-sm-10">
							<input type="text" name="site_keyw" class="form-control" value="<?php echo $ayar["site_keyw"]; ?>">
						  </div>
						</div> 
						<div class="form-group">
						  <label class="col-sm-2 control-label">Kategori İlan Gösterimi:</label>
						  <div class="col-sm-10">
							<input type="text" name="kategori_ilan_adet" class="form-control" value="<?php echo $ayar["kategori_ilan_adet"]; ?>">
						  </div>
						</div> 
                        
						<div class="form-group">
						  <label class="col-sm-2 control-label">Emlak Talep Formu:</label>
						  <div class="col-sm-2">
							<select class="form-control select2" name="talep_formu">
								<?php
																	
									if ($ayar['talep_formu'] == 0) {
										echo '
											<option value="1"> Göster </option>
											<option selected="selected" value="0"> Gizle </option>
										';
									} else {
										echo '
											<option selected="selected" value="1"> Göster </option>
											<option value="0"> Gizle </option>
										';
									}
								?>
							</select>
						  </div>
						</div> 
						
						<div class="form-group">
						  <label class="col-sm-2 control-label">Site Header:</label>
						  <div class="col-sm-2">
							<select class="form-control select2" name="site_header">
								<?php
																	
									if ($ayar['site_header'] == 0) {
										echo '
											<option value="1"> Geniş </option>
											<option selected="selected" value="0"> Dar </option>
										';
									} else {
										echo '
											<option selected="selected" value="1"> Geniş </option>
											<option value="0"> Dar </option>
										';
									}
								?>
							</select>
						  </div>
						</div> 
						
						<div class="form-group">
						  <label class="col-sm-2 control-label">Site Durumu:</label>
						  <div class="col-sm-2">
							<select class="form-control select2" name="site_durum">
								<?php
																	
									if ($ayar['site_durum'] == 0) {
										echo '
											<option value="1"> Açık </option>
											<option selected value="0"> Kapalı </option>
										';
									} else {
										echo '
											<option selected value="1"> Açık </option>
											<option value="0"> Kapalı </option>
										';
									}
								?>
							</select>
						  </div>
						</div>	
						<div class="form-group">
						  <label class="col-sm-2 control-label">Site Kapalı Mesajı:</label>
						  <div class="col-sm-10">
							<input type="text" name="kapali_mesaj" class="form-control" value="<?php echo $ayar['kapali_mesaj']; ?>">
						  </div>
						</div>
                        
						<hr>
                        <div class="form-group">
                            <h4>Anasayfa Limit Ayarları</h4>
                        </div>
                        <label class="col-sm-2 control-label">En Yeni İlanlar:</label>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="number" name="en_yeni" class="form-control" value="<?php echo $ayar["en_yeni"]; ?>">
                            </div>
                        </div>
                        <label class="col-sm-2 control-label">Öne Çıkan İlanlar:</label>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="number" name="one_cikan" class="form-control" value="<?php echo $ayar["one_cikan"]; ?>">
                            </div>
                        </div>
                        <label class="col-sm-2 control-label">Anasayfa Vitrin İlanları:</label>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="number" name="ana_vitrin" class="form-control" value="<?php echo $ayar["ana_vitrin"]; ?>">
                            </div>
                        </div>
                        <label class="col-sm-2 control-label">Acil İlanlar:</label>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="number" name="acil_ilan" class="form-control" value="<?php echo $ayar["acil_ilan"]; ?>">
                            </div>
                        </div>
                        <label class="col-sm-2 control-label">Fırsat İlanları:</label>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="number" name="firsat_ilan" class="form-control" value="<?php echo $ayar["firsat_ilan"]; ?>">
                            </div>
                        </div>
                        </div>
					  <!-- /.box-body -->
					  <div class="box-footer">						
						<button type="submit" class="btn btn-success btn-lg pull-right"> <i class="fa fa-check"></i> Kaydet </button>
					  </div>
					  <!-- /.box-footer -->
					</form> 
					
				</div>
			</div>
    		<div class="col-md-3">
    			<?php include ("right-menu.php"); ?>
    		</div>
		</div> 
	
	</div>
	
</section>