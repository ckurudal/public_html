<div class="bg-transparent main-search-top">
                            
	<form class="form" method="get" action="/ilanara/">

		<?php if(!isMobile()): ?>

		<div class="input-group m-auto pb-5 d-none d-sm-block">
			<div class="p-t-10 pb-0 mb-0 font-weight-light">
			
				<?php
					$ilan_tipi_ara = $vt->query("SELECT * FROM emlak_ilantipi where durum = 0 LIMIT 1")->fetch();                                           
				?>
				
				<label class="f-17 radio-container h5 font-weight-bold text-white"><?=$ilan_tipi_ara["ad"];?>
					<input type="radio" checked="checked" name="emlaktipi" value="<?=$ilan_tipi_ara["id"];?>">
					<span class="checkmark"></span>
				</label>
			
				<?php
					$ilantipver2 = mysql_query("SELECT * FROM emlak_ilantipi where durum = 0 LIMIT 1,15");
					while($tipver = mysql_fetch_array($ilantipver2)) {
				?>

				<label class="f-17 radio-container h5 font-weight-bold text-white"><?=$tipver["ad"];?>
					<input type="radio" name="emlaktipi" value="<?=$tipver["id"];?>">
					<span class="checkmark"></span>
				</label>

				<?php } ?>

			</div>
		</div>

		<?php else: ?>

		<div class="row no-gutters d-block d-sm-none">
			<div class="col-xl-3 col-lg-2 col-md-12 select2-lg">
				<div class="rs-select2 js-select-simple se lect--no-search">
					<select class="select2-hidden-accessible" name="emlaktipi">
						<?php
						$ilantipver2 = mysql_query("SELECT * FROM emlak_ilantipi where durum = 0");
						while($tipver = mysql_fetch_array($ilantipver2)) {
							?>
							<option value="<?=$tipver["id"];?>">
								<?=$tipver["ad"];?>
							</option>
						<?php } ?>
					</select>
					<div class="select-dropdown"></div>
				</div>
			</div>
		</div>

		<?php endif; ?>

		<div class="row no-gutters">

			<div class="col-xl-3 col-lg-2 col-md-12 select2-lg">
				<div class="rs-select2 js-select-simple se lect--no-search">
					<select class="select2-hidden-accessible" name="emlaksekli">
							<?php
								$ilansekliver = mysql_query("SELECT * FROM emlak_ilansekli where id && durum = 0");
								while($sekilver = mysql_fetch_array($ilansekliver)) {
							?>
							<option value="<?=$sekilver["id"];?>">
								<?=$sekilver["baslik"];?>
							</option>
							<?php } ?>
					</select>
					<div class="select-dropdown"></div>
				</div>
			</div>
			 
			<div class="col-xl-7 col-lg-2 col-md-12">
				
				 <div class="input-group">
					<input class="input--style-4 input-lg" type="text" placeholder="Nerede yaşamak istiyorsunuz?" name="baslik">
				</div>
				
			</div>
				
			<div class="col-xl-2 col-lg-3 col-md-12 mb-0">
				<button type="submit" class="btn btn-lg btn-block btn-success pb-4 pt-4"><i class="fa fa-search"></i> ARA</a>
			</div>
			
		</div>
		
	</form>
	
</div>