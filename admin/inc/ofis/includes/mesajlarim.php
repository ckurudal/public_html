<div class="alert alert-warning">
	<strong> Mesajlar </strong>
</div>
<div class="box">
	<div class="box-body">
		<div class="row">
			<div class="col-md-3">
				<h5><strong>Gelen Mesajlar</strong></h5>
				<hr>
				<ul class="nav navbar">
					<?php 
						$mesajlar = $vt->query("SELECT DISTINCT kimden, kime FROM emlak_dangelenmesaj ORDER BY id DESC")->fetchAll();
						foreach ($mesajlar as $mesaj) {
							$kimden = $vt->query("SELECT * FROM yonetici WHERE id = '".$mesaj["kimden"]."'")->fetch();
							$mesaj_ver = $vt->query("SELECT * FROM emlak_dangelenmesaj WHERE kime = '$id'")->fetch();
					?>												
						<?php if ($mesaj["kime"] == $id) { ?>
						<li>
							<a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $id; ?>&tab_goster=mesajlari&oku=<?php echo $kimden["id"]; ?>" class="jumbotron">
								<div class="row">
									<!--
									<?php if (yetki() == 0): ?>
									<div class="col-md-3">
										<div class="mesaj_kisi_liste">
											<img src="/<?php echo $kimden["resim"]; ?>" height="75">
										</div>
									</div>
									<?php endif; ?>
									-->
									<div class="col-md-9">
										<h><strong><?php echo $kimden["adsoyad"]; ?> (<?php echo gelen_mesaj_kisi($mesaj["kime"], $mesaj["kimden"]); ?> )</strong></h6>
									</div>
								</div>
							</a>												
						</li>
						<?php } ?>							
						<?php
						    /*
						    
						    <?php if ($mesaj["kime"] == $mesaj["kimden"]) { ?>
    						<li>
    							<a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $id; ?>&tab_goster=mesajlari&oku=<?php echo $kimden["id"]; ?>" class="jumbotron">
    								<div class="row">
    									<!--
    									<?php if (yetki() == 0): ?>
    									<div class="col-md-3">
    										<div class="mesaj_kisi_liste">
    											<img src="/<?php echo $kimden["resim"]; ?>" height="75">
    										</div>
    									</div>
    									<?php endif; ?>
    									-->
    									<div class="col-md-9">
    										<h6><strong><?php echo $kimden["adsoyad"]; ?> (<?php echo gelen_mesaj_kisi($mesaj["kime"], $mesaj["kimden"]); ?> )</strong></h6>
    									</div>
    								</div>
    							</a>												
    						</li>
    						<?php } ?>
						    
						    
						    */
						?>
					<?php } ?>
				</ul>
			</div>
			<div class="col-md-9">  
				<div class="uye_mesajlari">				
					<?php if ($_GET["oku"] == "") { ?>
						<div class="mesaj_bos text-center">
							<i class="fa fa-inbox fa-5x"></i>
							<h5> Mesajlaşma </h5>
							<strong>Mesajlarda arayın</strong>
						</div>
					<?php } ?>
					<?php 
						$oku = $_GET["oku"];
						if ($oku == true) {
							$kimden = $vt->query("SELECT * FROM yonetici WHERE id = '$oku'")->fetch();
							$mesaj_getir = $vt->query("SELECT * FROM emlak_dangelenmesaj ORDER BY id DESC")->fetchAll();
							$mesajlar = $vt->query("SELECT * FROM emlak_dangelenmesaj WHERE kime = '".$id."' AND kimden = '".$oku."'")->fetchAll();
							foreach ($mesajlar as $mesaj)
							{
								$okundu = $vt->query("UPDATE emlak_dangelenmesaj SET okundu = 1 WHERE kime = '".$mesaj["kime"]."' AND kimden = '".$mesaj["kimden"]."'");
							}
							// go("index.php?do=islem&ofis=yonetici&islem=duzenle&id={$id}&tab_goster=mesajlari&oku={$oku}",0);
							foreach ($mesaj_getir as $mesaj) {
								$bilgi = $vt->query("SELECT * FROM yonetici WHERE id = '".$mesaj["kimden"]."'")->fetch();
					?>											
						<?php if ($mesaj["kimden"] == $oku AND $mesaj["kime"] == $id) { ?>
							<div class="admin_uye_mesaj_gelen">											
								<span class="mesaj_profil_resim_sol hidden-xs">
									<img src="/<?php echo $bilgi["resim"]; ?>">
								</span>
								<span class="gelen">
									<a target="_blank" href="<?php if (yetki() == 0): ?>index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $bilgi["id"]; ?>&yetki=<?php echo $bilgi["yetki"]; ?><?php else: ?>#<?php endif; ?>" class="uye_ad_gelen"><strong><?php echo $bilgi["adsoyad"]; ?></strong></a>
									<p><strong><?php echo $mesaj["mesaj"]; ?></strong></p>
									<p><a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $id; ?>&tab_goster=mesajlari&oku=<?php echo $oku; ?>&mesaji_temizle=<?php echo $mesaj["id"]; ?>" class="bnt btn-danger btn-xs mesajimi-tem izle">Sil</a> <?php echo $mesaj["tarih"]; ?></p>	
                                </span>			
							</div> 
							<?php } ?>		 		 									
							<?php if ($mesaj["kimden"] == $id AND $mesaj["kime"] == $oku) { ?> 
								<div class="admin_uye_mesaj_giden">
									<span class="mesaj_profil_resim_sag hidden-xs">
										<img src="/<?php echo $bilgi["resim"]; ?>">
									</span>															
									<span class="giden">
										<p class="uye_ad_giden"><strong><?php echo $bilgi["adsoyad"]; ?></strong></p>
										<p><strong><?php echo $mesaj["mesaj"]; ?></strong></p>
										<p><?php echo $mesaj["tarih"]; ?> <a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $id; ?>&tab_goster=mesajlari&oku=<?php echo $oku; ?>&mesaji_temizle=<?php echo $mesaj["id"]; ?>" class="bnt btn-danger btn-xs mesajimi-tem izle">Sil</a></p>
									</span>		
								</div>	 
							<?php } ?>  
						<?php } ?> 
					<?php } ?>
				</div>
				<?php if($oku ==true): ?>
				<br>
				<!-- <a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $id; ?>&tab_goster=mesajlari&oku=<?php echo $oku; ?>&mesaji_temizle=<?php echo $oku; ?>" class="btn btn-xs btn-danger pull-right">Konuşmayı Sil</a> -->
				<?php
					$mesaji_temizle = $_GET["mesaji_temizle"];
					if ($mesaji_temizle == true)
					{
						echo $mesaji_temizle;
						$sil_gelen = $vt->query("DELETE FROM emlak_dangelenmesaj WHERE id = '$mesaji_temizle'");
						go("index.php?do=islem&ofis=yonetici&islem=duzenle&id={$id}&tab_goster=mesajlari&oku={$oku}",0);
						// $sil_gelen = $vt->query("DELETE FROM emlak_dangelenmesaj WHERE kimden = '$id' AND kime = '$oku'");
						// $sil_giden = $vt->query("DELETE FROM emlak_dangelenmesaj WHERE kimden = '$oku' AND kime = '$id'");
						// go("index.php?do=islem&ofis=yonetici&islem=duzenle&id={$id}&tab_goster=mesajlari",0);
					}
				?>
				<div class="mesaj-gonder">
					<div class="form-group">
						<textarea class="form-control" name="giden_mesaj" rows="5" placeholder="Mesajınız"></textarea>
					</div>
					<div class="form-group">
						<button type="submit" name="mesaj_gonder" id="gonder" class="btn btn-success pull-right"><i class="fa fa-send"></i> Gönder</button>
					</div>
					<?php
						if (isset($_POST["mesaj_gonder"]))
						{
							$email = $kimden["email"];
							$mesaj = $_POST["giden_mesaj"];
							$tarih = date('d/m/Y');
							$stmt_gonder = $vt->prepare("INSERT INTO emlak_dangelenmesaj (kimden, kime, email, tel, mesaj, tarih) VALUES (?,?,?,?,?,?)");
						$gonder = $stmt_gonder->execute([$_SESSION["id"], $kimden["id"], $email, $tel, $mesaj, $tarih]);
							go("index.php?do=islem&ofis=yonetici&islem=duzenle&id={$id}&tab_goster=mesajlari&oku={$oku}",0);
						}
					?>
				</div>
				<?php endif; ?>
				<?php
				?>
			</div>
		</div>
	</div>
</div>