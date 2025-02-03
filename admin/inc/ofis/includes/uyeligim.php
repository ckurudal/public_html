
<!-- KAYIT VE DUZENLEME ISLEMLERI inc/ofis/yonetici_islem.php DOSYASINDA YAPILAMAKTADIR -->

 <div class="box">
	<div class="alert alert-warning">
		<strong> Üye Bilgileri </strong>
	</div>
	<!-- /.box-header -->
	<div class="box-body pad">
		<div class="row">
			<div class="col-md-12">

				<div class="form-horizontal">
				<?php if(yetki() == 0): ?>
					<div class="form-group">
						<?php if (!empty($y["resim"])) { ?> 
							<div class="col-xl-3 col-lg-3 col-md-4 col-sm-4">
								<div class="box">
									<div class="box-body text-center bg-white">
										<div class="resim_liste" style="width: 150px; height: 150px; margin: inherit; margin:auto;">
											<img src="/<?=$y["resim"];?>">
										</div>
										<br>
										<strong><?php echo $y["adsoyad"]; ?></strong>
										<br>
										<br>
										<?php if ($y["yetki"] == 0) { ?>
											<span class="btn btn-success btn-block btn-xs">Site Yöneticisi</span>
										<?php } ?>
										<?php if ($y["yetki"] == 1) { ?>
											<span class="btn btn-danger btn-block btn-xs">Bireysel Üye</span>
										<?php } ?>
										<?php if ($y["yetki"] == 2) { ?>
											<span class="btn btn-warning btn-block btn-xs">Kurumsal Üye</span>
										<?php } ?>
										<?php if ($y["yetki"] == 3) { ?>
											<span class="btn btn-primary btn-block btn-xs">Danışman</span>
										<?php } ?>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
					<?php endif; ?>
					<?php if (!empty($y["resim"])) { ?>
					<div class="form-group hidden">
					  <label class="col-sm-2 control-label">Profil Resmi:</label>
					  <div class="col-sm-10">
						<div class="resim_liste" style="width: 200px; height: 200px; margin: inherit;">
							<img src="/<?=$y["resim"];?>">
						</div>
					  </div>
					</div>
					<?php } ?> 
					  <div class="col-sm-6">
						<label class="control-label">Adı Soyadı:</label>
						<input type="text" class="form-control" name="adsoyad" value="<?=$y["adsoyad"];?>">
					  </div> 
					  <div class="col-sm-3">
						<label class="control-label">Yeni Profil Resmi Seç:</label>
						<input type="file" class="form-control" name="resim[]"/>
					  </div>
					  
					  <div class="col-sm-3">
						<label class="control-label">Ünvan:</label>
						<select class="form-control sele ct2" name="unvan">
							<?php if ($y["unvan"] == "") { ?>
								<option selected value="">Seçiniz</option>
								<?php } else { ?>
								<option value="">Seçiniz</option>
								<option selected value="<?=$y["unvan"];?>"><?=$y["unvan"];?></option>
							<?php } ?>
								<?php
								$unvanlar = mysql_query("SELECT * FROM yonetici_unvan where id");
								while ($unvan=mysql_fetch_array($unvanlar)) {
							?>
							<?php
								if ($unvan["durum"] == 0) {
							?>
							<option value="<?=$unvan["baslik"];?>"><?=$unvan["baslik"];?></option>
							<?php } ?>
							<?php } ?>
						</select>
					  </div> 	
					  
					<?php if (yetki() == 0): ?>
					<?php if ($y["yetki"] == 2 || $y["yetki"] == 3) { ?> 
					  <div class="col-sm-3">
						  <label class="control-label">
							<?php if ($y["yetki"] == 2) { ?>
								Mağaza
							<?php } else { ?>
								<?php if ($y["yetki"] == 0) { ?>
								Bağlı Olduğu Kurumsal:
								<?php } else { ?>
								Mağaza:
								<?php } ?>
							<?php } ?>
						  </label>
						<?php if ($y["yetki"] == 2) { ?>
						<?php
							$ofisid2 = mysql_query("SELECT * FROM subeler where yetkiliuye = '".$y["id"]."'");
							$ofis2=mysql_fetch_array($ofisid2);
						?>
						<input type="text" disabled="disabled" class="form-control" value="<?=$ofis2["adi"]?>">
						<?php } ?>
						<?php if ($y["yetki"] != 2) { ?>
						<select class="form-control select2" name="ofis">
							<option <?php if ($y["ofis"] == 0) {echo "selected";} ?> value="">Seçiniz</option>
							<?php
								$ofisid = mysql_query("SELECT * FROM subeler where id = '".$y["ofis"]."'");
								$ofis=mysql_fetch_array($ofisid);
							?>
							<?php if ($y["ofis"] != 0) { ?>
							<option selected value="<?=$ofis["id"];?>"><?=$ofis["adi"]?></option>
							<?php } ?>
							<?php
								$subeler = mysql_query("SELECT * FROM subeler where id");
								while ($sube=mysql_fetch_array($subeler)) {
							?>
							<?php
								if ($sube["durum"] == 0) {
							?>
							<option value="<?=$sube["id"];?>"><?=$sube["adi"];?></option>
							<?php } ?>
							<?php } ?>
						</select>
						<?php } ?>
					  </div> 
					 <?php } ?>
					 <?php endif; ?> 				  
					  
					<div class="col-sm-3">
						<label class="control-label">Tel: <small>(SMS BİLDİRİM NUMARASIDIR.)</small></label>
						<input type="text" name="tel" class="form-control" placeholder="0 (555) 333 33 33" value="<?=$y["tel"];?>">
					  </div>
					<div class="col-sm-3">
						<label class="control-label">Telefon 2:</label>
						<input type="text" name="gsm" class="form-control" value="<?=$y["gsm"];?>">
					  </div>
					 <div class="col-sm-3">
						<label class="control-label">Fax (Varsa):</label>
						<input type="text" name="fax" class="form-control" value="<?=$y["fax"];?>">
					  </div>
					  
					<?php if (yetki() == 0): ?>
					<?php if ($y["yetki"] == 3 || $y["yetki"] == 1) { ?> 
					  <div class="col-sm-3">
							<label class="control-label">Üyelik Tipi:</label>
							<select class="form-control se lect2" name="yetki">
								<option value="1" <?php if ($y["yetki"] == 1) {echo "selected";} ?>>Bireysel Üye</option>
								<option value="3" <?php if ($y["yetki"] == 3) {echo "selected";} ?>>Danışman</option>
							</select> 
					  </div> 
					<?php } ?> 
					  <div class="col-sm-3 hidden">
							<label class="control-label">Üyelik Tipi:</label>
							<label for="yetki" class="hidden">
								<input type="radio" name="yetki" <?php if ($y["yetki"] == 2) {echo "checked";} ?> value="2" class="minimal">
								Kurumsal Üye
							</label>
							<label for="yetki" class="hidden">
								<input type="radio" name="yetki" <?php if ($y["yetki"] == 0) {echo "checked";} ?> value="0" class="minimal">
								Site Yöneticisi
							</label>
					  </div> 
					<?php endif; ?>					
					  <div class="col-sm-3">
						<label class="control-label">Email:</label>
						<input type="text" class="form-control" name="email" disabled="disabled" value="<?=$y["email"];?>">
					  </div>
					<?php if (yetki()==0): ?> 
					  <div class="col-sm-3">
						<label class="control-label">Sıra:</label>
						<input type="text" class="form-control" name="sira" value="<?=$y["sira"];?>">
					  </div> 
					<?php endif; ?>
					
					
					<!--
					
					<?php if ($uyelik_yetki["yetki"] == 0) { ?>
					
					<div class="form-group">

						<label class="col-sm-2 control-label">Aylık İlan Ekleme:</label>
					  <div class="col-sm-10">
							<input type="text" class="form-control" name="aylik_limit" value="<?=$y["aylik_limit"];?>">
					  </div>

					</div>
					<div class="form-group">

						<label class="col-sm-2 control-label">Aylık Resim Ekleme:</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="resim_limit" value="<?=$y["resim_limit"];?>">
						</div>

					</div>
					<div class="form-group">

						<label class="col-sm-2 control-label">İlan Yayın Süresi:</label>
						<div class="col-sm-2">
							<input type="text" class="form-control" name="ilan_sure" value="<?=$y["ilan_sure"];?>">
						</div>
						<div class="col-sm-2">
							<select class="form-control" name="ilan_sure_zaman">
								<option>  <?=$y["ilan_sure_zaman"];?> </option>
								<option value="Gün"> Gün </option>
								<option value="Ay"> Ay </option>
								<option value="Yıl"> Yıl </option>
							</select>
						</div>

					</div>
					
					<?php } ?>
					
					-->
 
					<div class="col-sm-12">
						<label class="control-label">Hakkında:</label>
						<textarea id="edi tor1" class="form-control" name="aciklama" rows="4" cols="80"><?=$y["aciklama"];?></textarea>
					</div>  
 
					<div class="col-sm-12">
						<label class="control-label">Bildirim Ayarları:</label>
						<div class="alert alert-warning">			
							 
							<label for="yetki">
								<input type="checkbox" name="eposta_bildirim" <?php if ($y["eposta_bildirim"] == 1) {echo "checked";} ?> value="1" class="minimal">
								Bildirimlerden <strong>E-Posta</strong> ile bilgilendirilmek istiyorum.
							</label>
							
							<br>	 
					
							<label for="yetki">				 
								<input type="checkbox" name="sms_bildirim" <?php if ($y["sms_bildirim"] == 1) {echo "checked";} ?> value="1" class="minimal">
								Bildirimlerden <strong>SMS</strong> ile bilgilendirilmek istiyorum.
							</label> 
							
						</div>
					</div>  
					
					<?php
						$sosyalmedya = mysql_query("SELECT * FROM ayar_sosyal order by sira asc");
						while($sosyal=mysql_fetch_array($sosyalmedya)) {
						$ysosyal = mysql_query("SELECT * FROM yonetici_sosyal where sosyalid = '".$sosyal["id"]."' && yoneticiid = '$id' ");
						$ys = mysql_fetch_array($ysosyal);
					?>
					
					<div class="col-md-4">
						<input type="text" class="form-control hidden" name="sosyalbaslik[]" value="<?=$sosyal["baslik"];?>">
						 <label class="control-label"><?=$sosyal["baslik"];?>:</label>
						<input type="text" class="form-control hidden" name="sosyalid[]" value="<?=$sosyal["id"];?>">
						<input type="text" class="form-control" name="sosyallink[]" value="<?=$ys["sosyallink"];?>">
					</div>
					
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	</div>     

	<div class="box">
	<div class="box-footer">
		<button type="submit" class="btn btn-success btn-lg pull-right" name="yoneticikaydet"> <i class="fa fa-check"></i> Kaydet </button>
	 </div>
	</div>