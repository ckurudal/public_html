<?php

$reklam = $vt->query("SELECT * FROM reklam where id = 1")->fetch();

?> 
 
<form class="form" method="get" action="/ilanara/">

        <?php if(!isMobile()): ?>

        <div class="input-group m-auto d-none d-sm-block">
            <div class="p-t-10 pb-0 mb-0 font-weight-light">
            
                <?php
                    $ilan_tipi_ara = $vt->query("SELECT * FROM emlak_ilantipi where durum = 0 LIMIT 1")->fetch();                                           
                ?>
                
                <label class="radio-container h5 font-weight-bold text-white"><?=$ilan_tipi_ara["ad"];?>
                    <input type="radio" checked="checked" name="emlaktipi" value="<?=$ilan_tipi_ara["id"];?>">
                    <span class="checkmark main"></span>
                </label>
            
                <?php
                    $ilantipver2stmt = $vt->query("SELECT * FROM emlak_ilantipi where durum = 0 LIMIT 1,15");
                    while($tipver = $ilantipver2stmt->fetch()) {
                ?>

                <label class="radio-container h5 font-weight-bold text-white"><?=$tipver["ad"];?>
                    <input type="radio" name="emlaktipi" value="<?=$tipver["id"];?>">
                    <span class="checkmark main"></span>
                </label>

                <?php } ?>

            </div>
        </div>

        <?php endif; ?>
        
        <div class="bg-transparent main-sea rch-top">
        
<div class="row no-gutters">

<?php if(isMobile()): ?>

<div class="col-xl-3 col-lg-2 col-md-2 col-sm-3 select2-lg arama-1-item">
<div class="rs-select2 js-select-simple se lect--no-search">
<select class="select2-hidden-accessible" name="emlaktipi">
<?php
$ilantipver2stmt2 = $vt->query("SELECT * FROM emlak_ilantipi where durum = 0");
while($tipver = $ilantipver2stmt2->fetch()) {
?>
<option value="<?=$tipver["id"];?>">
<?=$tipver["ad"];?>
</option>
<?php } ?>
</select>
<div class="select-dropdown"></div>
</div>
</div>

        <?php endif; ?>  
<div class="col-xl-2 col-lg-2 col-md-2 col-sm select2-lg arama-2-item">
<div class="form-group"> 
<div class="rs-select2 js-select-simple se lect--no-search"> 
<select class="form-control" name="emlaksekli"> 

<!-- <option value="">Emlak Şekli</option> -->
<?php
$ilansekliver_stmt = $vt->query("SELECT * FROM emlak_ilansekli where id && durum = 0");
while($sekilver = $ilansekliver_stmt->fetch()) {
?>
<option value="<?=$sekilver["id"];?>"><?=$sekilver["baslik"];?></option>
<?php } ?>
</select>
<div class="select-dropdown"></div>
</div>
</div>
</div> 
<div class="col-xl-4 col-lg-4 col-md col-sm select2-lg arama-3-item">
<div class="form-group"> 
<div class="input-group">
<input class="input--style-4 input-lg height-62" type="text" placeholder="Nerede yaşamak istiyorsunuz?" name="baslik">
</div>
</div>
</div> 
<div class="col-xl-2 col-lg col-md col-sm select2-lg">
<div class="form-group">

<div class="rs-select2 js-select-simple se lect--no-search"> 
<select name="il" id="ilSidebar" name="il" class="form-control">
 
<?php if ($GET_il != ""): ?>

<option value="<?php echo $il_getir->sehir_key; ?>"> <?php echo $il_getir->adi; ?> </option>

<?php endif; ?>

<option value=""> İl Seçiniz </option> 
<?php 
$iller_stmt = $vt->query("SELECT * FROM sehir ORDER BY adi ASC");
while($il=$iller_stmt->fetch()) {
?>

<option value="<?=$il['sehir_key'];?>"> <?=$il['adi'];?> </option>

<?php } ?>
</select>
<div class="select-dropdown"></div>
</div>
</div>
</div> 
<div class="col-xl-2 col-lg col-md col-sm select2-lg">
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
</div>  
<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2  arama-4-item"> 
<button type="submit" class="btn btn-lg btn-block btn-success pb-4 pt-4"><i class="fa fa-search"></i> ARA</a>
</div>
</div>
</div> 
</form>
