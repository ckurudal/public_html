<?php if (isMobile()): ?>
<div class="row no-gutters">
    <div class="col-12 mb-4">
        <a id="filtrele" class="btn btn-outline-dark btn-block pb-3 pt-3"><i class="fa fa-filter"></i> FİLTRELE</a>
    </div>
    <div class="col-12 mb-4">
        <div class="rs-select2 js-select-simple se lect--no-search select--no-search">
            <select name="item" class="select2-hidden-accessible " onchange="document.location.href=this[selectedIndex].value">
                <option selected="selected">Sırala Seçenekleri</option>
                <option value="<?php echo $_SERVER["REQUEST_URI"] ?>&fiyat=DESC">Fiyata Önce Yüksek</option>
                <option value="<?php echo $_SERVER["REQUEST_URI"] ?>&fiyat=ASC">Fiyata Önce Ucuz</option>
            </select>
            <div class="select-dropdown"></div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php

	$reklam = $vt->query("SELECT * FROM reklam where id = 1")->fetch();

?>

<div class="card <?php if (isMobile()): ?>mobil-gizle<?php endif; ?>" style="<?php if (isMobile()): ?>display:none;<?php endif; ?>">
	<form action="/ilanara/" method="get" class="m-0">
		<div class="card-header">
            <?php if (isMobile()): ?>
                <a class="btn btn-danger btn-sm text-white" id="kapat" style="position: absolute; right: 20px;">KAPAT</a>
            <?php endif; ?>
            <script>
                $('#kapat').click(function(e){
                    $('.mobil-gizle').hide(300);
                });
                $('#filtrele').click(function(e){
                    $('.mobil-gizle').show(300);
                });
            </script>
            <h6 class="mb-0"><strong><i class="fa fa-search"></i> Detaylı İlan Arama </strong> </h6>
		</div>
		<div class="card-b ody mr-4 ml-4 mt-4">
			<div class="form-group has-feedback no-margin">
				<?php if ($_GET["baslik"]): ?>
		    		
		    	<div class="input-group">
				  <input type="text" name="baslik" class="form-control inp ut--style-4" value="<?php echo $GET_baslik; ?>"> 
				</div>					
		        
		    	<?php else: ?>

		    	<div class="input-group">
				  <input type="text" name="baslik" value="" class="form-control inp ut--style-4" placeholder="Konum, firma adı, ilan no ile arayın (Örn. 1234-123456)"> 
				</div>
		        
		    	<?php endif; ?>
		    </div><!-- /.form-group -->
		</div>
		<div class="card-body coll apse in" id="adres" aria-expanded="false">						
			<h6 class="mb-3"><strong>Konum</strong></h6>
			<div class="form-group">
			
				<div class="rs-select2 js-select-simple se lect--no-search">
			
					<select name="il" id="ilSidebar" name="il" class="form-control">
						 
						<?php if ($GET_il != ""): ?>
		                            
                        	<option value="<?php echo $il_getir->sehir_key; ?>"> <?php echo $il_getir->adi; ?> </option>
                    	
                    	<?php endif; ?>

						<option value=""> İl Seçiniz </option> 
						<?php 
							$stmt_iller = $vt->query("select * from sehir order by adi asc");
							while($il=$stmt_iller->fetch()) {
						?>

						<option value="<?=$il['sehir_key'];?>"> <?=$il['adi'];?> </option>

						<?php } ?>
					</select>
					<div class="select-dropdown"></div>
				</div>
			</div>
			<div class="form-group">
				
				<div class="rs-select2 js-select-simple se lect--no-search">
					<select name="ilce" id="ilceSidebar" class="form-control">

						<?php if ($GET_ilce != ""): ?>
		                            
                        	<option value="<?php echo $ilce_getir->ilce_key; ?>" selected="selected"> <?php echo $ilce_getir->ilce_title; ?> </option>  
                    	
                    	<?php endif; ?>

						<option value=""> İlçe </option>  
					</select>
					<div class="select-dropdown"></div>
				</div>
			</div>				
			<div class="form-group">
				<div class="rs-select2 js-select-simple se lect--no-search">
					<select name="mahalle" id="mahalleSidebar" class="form-control" size="7">
						
						<?php if ($GET_mahalle != ""): ?>

							<option value="<?php echo $mahalle_getir->mahalle_id; ?>" selected="selected"> <?php echo $mahalle_getir->mahalle_title; ?> </option>
                    	
                    	<?php endif; ?>

						<option value="" <?php if ($GET_mahalle == ""): ?> selected="selected" <?php endif; ?>"> Mahalle & Köy </option>
					</select>
					<div class="select-dropdown"></div>
				</div>
			</div>
		</div>
		<div class="card-body coll apse in" id="kategori" aria-expanded="false">
			<div class="form-group"> 
				<h6 class="mb-3 mt-2"><strong>Emlak Şekli</strong></h6>				
				 <div class="input-group ml-2 mr-2 mb-0">
					<div class="row">
						<?php
							$stmt_sekil = $vt->query("SELECT * FROM emlak_ilansekli where durum = 0");
							while($sekilver = $stmt_sekil->fetch()) {
						?>	
						<div class="col-md-6 col-6">
							<div class="">
								<label class="radio-container">
									<span style="font-size:13px;"><?=$sekilver["baslik"];?></span>
									<input type="radio" <?php if ($emlak_sekli_getir != "" && $emlak_sekli_getir->id == $sekilver["id"]): ?> checked <?php endif; ?> value="<?=$sekilver["id"];?>" name="emlaksekli">
									<span class="checkmark"></span>
								</label>
							</div>
							
						</div>
						<?php } ?> 
						
					</div>
				</div>  
				
			</div>
			<h6 class="mb-3"><strong>Kategori</strong></h6>
			<div class="form-group"> 
				<div class="rs-select2 js-select-simple se lect--no-search">
								
					<select class="form-control" name="kategori">

						<?php if ($GET_kategori != ""): ?>

						<option selected="selected" value="<?=$emlak_kategori_getir->kat_id;?>"><?php echo $emlak_kategori_getir->kat_adi; ?></option>	

						<?php endif; ?>

						<option value="">Emlak Kategorisi</option>
						<?php
							$stmt_katver = $vt->query("SELECT * FROM emlak_kategori where kat_ustid = 0 AND kat_durum = 1 order by sira_no asc");
							while($katver = $stmt_katver->fetch()) {
						?>
						<optgroup label="<?=$katver["kat_adi"];?>">

							<option <?php if($_POST["kategori"] == $katver["kat_id"]): ?> selected <?php endif; ?> value="<?=$katver["kat_id"];?>"><?=$katver["kat_adi"];?></option>
							<?php
								$stmt_altkategori = $vt->prepare("SELECT * FROM emlak_kategori where kat_ustid = ? AND kat_durum = 1 order by sira_no asc");
								$stmt_altkategori->execute([$katver["kat_id"]]);
								while($katver = $stmt_altkategori->fetch()) {
							?>
								<option <?php if($_POST["kategori"] == $katver["kat_id"]): ?> selected <?php endif; ?> value="<?=$katver["kat_id"];?>">- <?=$katver["kat_adi"];?></option>									
							<?php } ?>
						</optgroup>
						<?php } ?>
					</select>
					<div class="select-dropdown"></div>
				</div>
			</div>
			<div class="form-group"> 
				<h6 class="mb-3 mt-6"><strong>Emlak Tipi</strong></h6>
				<div class="rs-select2 js-select-simple se lect--no-search">
					<select class="form-control" name="emlaktipi">

						<?php if ($emlak_tipi_getir != ""): ?>

							<option selected="selected" value="<?php echo $emlak_tipi_getir->id; ?>"><?php echo $emlak_tipi_getir->ad; ?></option>			                                                       	
                    	
                    	<?php endif; ?>

						<option value="">Emlak Tipi</option>

						<?php
							$stmt_tipver = $vt->query("SELECT * FROM emlak_ilantipi where durum = 0");
							while($tipver = $stmt_tipver->fetch()) {
						?>
						<option <?php if($_POST["emlaktipi"] == $tipver["id"]): ?> selected <?php endif; ?> value="<?=$tipver["id"];?>"><?=$tipver["ad"];?></option>
						<?php } ?>
					</select>
					<div class="select-dropdown"></div>
				</div>
			</div>
		</div>
		<div class="card-body colla pse in border-bottom" id="fiyat" aria-expanded="false"> 
			<h6 class="mb-3"><strong>Fiyat</strong></h6>
			<div class="form-group"> 

				<div class="form-group">					

					<input type="text" class="input--style-4" name="minfiyat" placeholder="Min Fiyat" value="<?php if ($GET_minfiyat != ""): ?><?php echo $GET_minfiyat; ?><?php else: ?><?php echo $_POST["minfiyat"]; ?><?php endif; ?>">

				</div>

				<div class="form-group">

					<input type="text" class="input--style-4" name="maxfiyat" placeholder="Max Fiyat" value="<?php if ($GET_maxfiyat != ""): ?><?php echo $GET_maxfiyat; ?><?php else: ?><?php echo $_POST["maxfiyat"]; ?><?php endif; ?>">

				</div>

				<div class="form-group">
					 <div class="input-group ml-2 mr-2 mb-5 mt-4">
						<div class="row"> 
						
							<?php									
								$fiyatkur = $vt->query("SELECT * FROM para_birimi ORDER BY id ASC")->fetchAll();
								foreach ($fiyatkur AS $kur)
								{
							?>
							<div class="col-md-3 col-3">
								<div class="">

									<label class="radio-container"><?=$kur["sembol"];?>

										<input type="radio" <?php if($GET_fiyatkur == $kur["ad"]): ?> checked <?php endif; ?> value="<?=$kur["ad"];?>" name="fiyatkur">
										
										<span class="checkmark"></span>

									</label>

								</div>
							</div>
							<?php } ?>
						</div>
					</div> 
				</div>
			</div>
		</div>

		<!--
		<div class="d-none">
		<?php

			$stmt_ilanform = $vt->query("SELECT * FROM emlak_form where arama = '1' order by sira asc");
			while($io = $stmt_ilanform->fetch()) {

				$ex = explode(",", $io['deg']);

		?>
		<div class="bg-light border-bottom">
			<a class="btnPlus btn-block h6 mb-0 p-5" role="button" data-toggle="collapse" href="#<?=$io["seo"];?>" aria-expanded="false" aria-controls="card-body">
				<i class="fa fa-chevron-down pull-right"></i>
				<strong><span class="h6"><strong><?=$io["ad"];?></strong></span></strong>
			</a>			
		</div>
		<div class="card-body collapse" id="<?=$io["seo"];?>" aria-expanded="false" style="height: 0px;">
			<?php if ($io["toplusecim"] == 1) { ?>				
				<?php if (($io["minmax"] == 1) && ($io["toplusecim"] == 1)) { ?>
				<div class="form-g roup mb-4">
					<div class="rs-select2 js-select-simple se lect--no-search">
						<select class="form-control" name="mintoplu<?=$io["id"];?>">
							<option selected="selected">Min <?=$io["ad"];?></option>
							<?php
								for ($i=0; $i < count($ex) ; $i++) {
							?>
							<option value="<?=seo(trim($ex[$i]));?>"><?=$ex[$i];?></option>
							<?php } ?>
						</select>
						<div class="select-dropdown"></div>
						<input type="text" hidden name="minmaxtoplu<?=$io["id"];?>" value="<?=$io["id"]?>">
					</div>
				</div>
				<div class="form-gr oup">
					<div class="rs-select2 js-select-simple se lect--no-search">
						<select class="form-control" name="maxtoplu<?=$io["id"];?>">
							<option selected="selected">Max <?=$io["ad"];?></option>
							<?php
								for ($i=0; $i < count($ex) ; $i++) {
							?>
							<option value="<?=seo(trim($ex[$i]));?>"><?=$ex[$i];?></option>
							<?php } ?>
						</select>
						<div class="select-dropdown"></div>
					</div>
				</div>
				<?php } else { ?>
					<?php if ($io["toplusecim"]	== 1) { ?>
					<div class="form-group p-3 pb-0 pt-4">
						<div class="row">
						<?php
							for ($i=0; $i < count($ex) ; $i++) {
						?>
						<div class="col-md-12">
							<label class="radio-container mb-2">
								
								<?=$ex[$i];?>
								
								<input type="checkbox" value="<?=seo(trim($ex[$i]));?>" name="<?=$io["id"];?><?php if ($toplusecim==""): ?>[]<?php endif; ?>">
								
								<span class="checkmark"></span>
							</label>
						</div> 
						<?php } ?>
						</div>
					</div>
					/*
					<div class="form-group">
						<select class="form-control" name="<?=$io["id"];?><?php if ($toplusecim=="") {?>[]<?php } ?>" multiple="multiple" size="5">								
							<?php
								for ($i=0; $i < count($ex) ; $i++) {
							?>
							<option value="<?=seo(trim($ex[$i]));?>"><?=$ex[$i];?></option>
							<?php } ?>
						</select>
						<small>CTRL Tuşu İle Çoklu Seçim Yapabilirsiniz.</small>
					</div>
					*/
					<?php } else { ?>
					<?php } ?>
				<?php } ?>
				<?php } else { ?>
				<?php if ($io["metinalani"]	!= 1) { ?>
				<?php if ($io["minmax"] != 1) { ?>
				<div class="rs-select2 js-select-simple se lect--no-search">
					<select class="form-control" name="<?=$io["id"];?>">
						
						<option value="">Seçiniz</option>
						<?php
							for ($i=0; $i < count($ex) ; $i++) {
						?>
						<option value="<?=seo(trim($ex[$i]));?>"><?=$ex[$i];?></option>
						<?php } ?>
					</select>
					<div class="select-dropdown"></div>
				</div>
				<?php } else { ?>
				<div class="row">
					<div class="col-md-6 col-6">
						<input type="text" hidden name="minmaxid<?=$io["id"];?>" placeholder="Min <?=$io["ad"];?>" value="<?=$io["id"];?>">
						<input type="text" class="input--style-4" name="min<?=$io["id"];?>" placeholder="Min <?=$io["ad"];?>" value="">
					</div>
					<div class="col-md-6 xol-6">
						<input type="text" class="input--style-4" name="max<?=$io["id"];?>" placeholder="Max <?=$io["ad"];?>" value="">
					</div>
				</div>
				<?php } ?>
				<?php } else { ?>
				<input type="text" class="input--style-4" name="<?=$io["id"];?>" placeholder="<?=$io["ad"];?>" value="">
				<?php } ?>
			<?php } ?> 
		</div> 
		<?php } ?>	
		</div>	
	-->
		<div class="card-body">
			<div class="arama-btn">			
				<button type="submit" class="btn btn-danger btn-block p-3"><i class="fa fa-search"></i> <strong>ARA</strong></button>			
			</div>
		</div>
	</form>
</div>

<div class="pt-5 pb-3 d-none d-md-block">

<!-- REKLAM -->

<?php echo $reklam["kategori_sidebar"]; ?>

</div>