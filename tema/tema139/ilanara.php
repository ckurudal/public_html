<?php
$GET_il 						= $_GET["il"];
$GET_ilce 						= $_GET["ilce"];
$GET_mahalle 					= $_GET["mahalle"];
$GET_kategori 					= $_GET["kategori"];
$GET_emlak_tipi 				= $_GET["emlaktipi"];
$GET_emlak_sekli 				= $_GET["emlaksekli"];
$GET_minfiyat					= $_GET["minfiyat"];
$GET_maxfiyat					= $_GET["maxfiyat"];
$GET_fiyatkur					= $_GET["fiyatkur"];
$GET_baslik						= $_GET["baslik"];
$fiyat = $_GET["fiyat"];
$il_getir 						= $vt->query("SELECT * FROM sehir WHERE sehir_key = '$GET_il'")->fetch(PDO::FETCH_OBJ);
$ilce_getir 					= $vt->query("SELECT * FROM ilce WHERE ilce_key = '$GET_ilce'")->fetch(PDO::FETCH_OBJ);
$mahalle_getir 					= $vt->query("SELECT * FROM mahalle WHERE mahalle_id = '$GET_mahalle'")->fetch(PDO::FETCH_OBJ);
$emlak_kategori_getir 			= $vt->query("SELECT * FROM emlak_kategori WHERE kat_id = '$GET_kategori'")->fetch(PDO::FETCH_OBJ);
$emlak_tipi_getir 				= $vt->query("SELECT * FROM emlak_ilantipi WHERE id = '$GET_emlak_tipi'")->fetch(PDO::FETCH_OBJ);
$emlak_sekli_getir 				= $vt->query("SELECT * FROM emlak_ilansekli WHERE id = '$GET_emlak_sekli'")->fetch(PDO::FETCH_OBJ);

$kontrol = $_GET["kontrol"];

?>
<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- set the page title -->
    <title>
        Emlak Arama Sonuçları
    </title>
    <meta name="description" content="<?=$ayar['site_desc'];?>" />
    <meta name="keywords" content="<?=$ayar['site_keyw'];?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="robots" content="index, follow" />
    <meta name="Revisit-After" content="1 Days" />
    <link rel="shortcut icon" type="image/x-icon" href="<?=$ayar['favicon'];?>">
    <meta name="generator" content="RoxiKonsept 2.0" />
    <link rel="canonical" href="<?php echo URL.$_SERVER['REQUEST_URI']; ?>" />
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <base href="<?=URL;?>/">
    <?php include('header.php'); ?>
</head>
<body>
<?php include('ust.php'); ?>
<section class="sptb">
    <div class="container">

        <div class="row">
            
            <div class="col-xl-9 col-lg-8 col-md-12 order-2">

                <!--Add lists-->
                <div class=" mb-lg-0">
                    <div class="">
                        <div class="item2-gl">
                            <div class="mb-1">
                                <div class="">
                                    <div class="mb-5 d-block d-md-none">
                                         <span class="mb-0 mt-4">
										<?php $baslik = $_GET["baslik"]; ?>
                                             <?php if (!$aramaformu == "") { ?>
                                                 <h5><i class="fa fa-search-plus"></i> <strong><?=$aramaformu;?></strong> Kelimesine Göre Arama Sonuçları</h5>
                                             <?php } else { ?>
                                                 <h5><i class="fa fa-search-plus"></i> <?php if ($baslik): ?> "<?php echo $baslik; ?>" İçin <?php else: ?> Emlak <?php endif; ?> <strong>Arama</strong> Sonuçları</h5>
                                             <?php } ?>
			                           	</span>
                                    </div>
                                    <div class="p-2 pl-6 bg-white item2-gl-nav d-flex">
			                            <span class="mb-0 mt-4">
										<?php $baslik = $_GET["baslik"]; ?>
                                            <?php if (!$aramaformu == "") { ?>
                                                <h5><i class="fa fa-search-plus"></i> <strong><?=$aramaformu;?></strong> Kelimesine Göre Arama Sonuçları</h5>
                                            <?php } else { ?>
                                                <h5><i class="fa fa-search-plus"></i> <?php if ($baslik): ?> "<?php echo $baslik; ?>" İçin <?php else: ?> Emlak <?php endif; ?> <strong>Arama</strong> Sonuçları</h5>
                                            <?php } ?>
			                           	</span>
                                        <div class="d-flex ml-auto">
                                            <label class="mr-2 mt-4 mr-4 mb-sm-1"><i class="fa fa-sort fa-lg mr-1 text-muted"></i> Akıllı Sırala:</label>
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
                                    <div class="p-2 pl-5 bg-white item2-gl-nav mt-2 pt-4 pb-4 text-left">
                                        <a href="/ilanara/" class="btn btn-sm btn-dark mr-3 pl-3 pr-3">Filtreyi temizle <i class="fa fa-close"></i></a> 
                                        <div class="pt-1">
                                            <?php if ($GET_baslik): ?>
                                                <span class="arama-filtreleri">
				                            		<strong class="mr-2 ml-2">Aranan Kelime</strong>
				                            		<span class="badge badge-light mr-3">
					                            		<strong>
															<?php echo $GET_baslik; ?>
					                            		</strong>
					                            	</span>
					                            </span>
                                            <?php endif; ?>
                                            <?php if ($GET_il != ""): ?>
                                                <span class="arama-filtreleri"> <strong class="mr-2">İl</strong> <span class="badge badge-light"> <strong><?php echo $il_getir->adi; ?></strong> </span> </span>
                                            <?php endif; ?>
                                            <?php if ($GET_ilce != ""): ?>
                                                <span class="arama-filtreleri"> <strong class="mr-2 ml-2">İlçe</strong> <span class="badge badge-light"> <strong><?php echo $ilce_getir->ilce_title; ?></strong> </span> </span>
                                            <?php endif; ?>
                                            <?php if ($GET_mahalle != ""): ?>
                                                <span class="arama-filtreleri"> <strong class="mr-2 ml-2">Mahalle</strong> <span class="badge badge-light"> <strong><?php echo $mahalle_getir->mahalle_title; ?></strong> </span> </span>
                                            <?php endif; ?>
                                            <?php if ($emlak_kategori_getir != ""): ?>
                                                <span class="arama-filtreleri"> <strong class="mr-2 ml-2">Kategori</strong> <span class="badge badge-light"> <strong><?php echo $emlak_kategori_getir->kat_adi; ?></strong> </span> </span>
                                            <?php endif; ?>
                                            <?php if ($emlak_tipi_getir != ""): ?>
                                                <span class="arama-filtreleri"> <strong class="mr-2 ml-2">Emlak Tipi</strong> <span class="badge badge-light"> <strong><?php echo $emlak_tipi_getir->ad; ?></strong> </span> </span>
                                            <?php endif; ?>
                                            <?php if ($emlak_sekli_getir != ""): ?>
                                                <span class="arama-filtreleri"> <strong class="mr-2 ml-2">Emlak Şekli</strong> <span class="badge badge-light"> <strong><?php echo $emlak_sekli_getir->baslik; ?></strong> </span> </span>
                                            <?php endif; ?>
                                            <?php if ($GET_minfiyat != "" || $GET_maxfiyat != ""): ?>
                                                <span class="arama-filtreleri">
				                            		<strong class="mr-2 ml-2">Fiyat</strong>
				                            		<span class="badge badge-light">
					                            		<strong>
					                            			<?php if ($GET_minfiyat == "" || $GET_minfiyat == 0): ?> <?php echo $GET_maxfiyat; ?> <?php echo $GET_fiyatkur; ?> ve Altı / <?php endif; ?>
                                                            <?php if ($GET_maxfiyat == "" || $GET_maxfiyat == 0): ?> <?php echo $GET_minfiyat; ?> <?php echo $GET_fiyatkur; ?> ve Üstü / <?php endif; ?>
                                                            <?php if (!$GET_minfiyat == "" || !$GET_minfiyat == 0 || !$GET_maxfiyat == "" || !$GET_maxfiyat == 0): ?> <?php echo $GET_minfiyat; ?> <?php echo $GET_fiyatkur; ?> - <?php echo $GET_maxfiyat; ?> <?php echo $GET_fiyatkur; ?> <?php endif; ?>
					                            		</strong>
					                            	</span>
					                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-content">

                                <?php if ($kontrol == "yok"): ?>

                                <div class="alert alert-danger rounded-0 text-center">
                                    <small>"Aradığın ilan yayından kaldırılmış. Dilersen aynı bölgedeki diğer ilanları inceleyebilirsin."</small>
                                </div>

                                <?php endif; ?>

                                <?php
                                if (isset($_GET["ilanara"]));
                                $ilan_form = $vt->query("SELECT * FROM emlak_form where arama = '1' order by sira asc")->fetchAll();
                                foreach($ilan_form AS $io)
                                {
                                    $mintoplu = $_GET["mintoplu{$io['id']}"];
                                    $maxtoplu = $_GET["maxtoplu{$io['id']}"];
                                    $minmaxtoplu = $_GET["minmaxtoplu{$io['id']}"];
                                    $post  = $_GET["{$io['id']}"];
                                    // min max sorgusu arama
                                    $minpost = $_GET["min{$io['id']}"];
                                    $maxpost = $_GET["max{$io['id']}"];
                                    $minmaxid = $_GET["minmaxid{$io['id']}"];
                                    if ($minpost != "" || $maxpost != "") {
                                        $emlaknoverlist = $vt->query("SELECT * FROM emlak_ilandetay where seo BETWEEN '$minpost' and '$maxpost' && formid = '$minmaxid'");
                                        foreach($emlaknoverlist AS $emlaknover) {
                                            if (is_numeric($emlaknover["seo"]))  {
                                                $emlakver = $vt->query("SELECT * FROM emlak_ilan where emlakno = '".$emlaknover["emlakno"]."' AND onay = 1 AND durum = 0");
                                                foreach($emlakver AS $emlak) {
                                                    $emlak_kategori = $vt->query("SELECT * FROM emlak_kategori WHERE kat_id like '%".$_GET["kategori"]."%' AND kat_id = '".$emlak["katid"]."'")->fetch();
                                                    $emlak_ilan_tipi = $vt->query("SELECT * FROM emlak_ilantipi WHERE id = '".$emlak["ilantipi"]."'")->fetch();
                                                    $emlak_ilan_sekli = $vt->query("SELECT * FROM emlak_ilansekli WHERE id = '".$emlak["ilansekli"]."'")->fetch();
                                                    $emlak_resim = $vt->query("SELECT * FROM emlak_resim WHERE emlakno = '".$emlak["emlakno"]."' AND kapak = 1")->fetch();
                                                    $emlak_sehir = $vt->query("SELECT * FROM sehir WHERE sehir_key = '".$emlak["il"]."'")->fetch();
                                                    $emlak_ilce = $vt->query("SELECT * FROM ilce WHERE ilce_key = '".$emlak["ilce"]."'")->fetch();
                                                    $emlak_mahalle = $vt->query("SELECT * FROM mahalle WHERE mahalle_id = '".$emlak["mahalle"]."'")->fetch();
                                                    $ekleyen = $vt->query("SELECT * FROM yonetici WHERE id = '".$emlak["yonetici_id"]."'")->fetch();
                                                    ?>
                                                    <div class="card overflow-hidden kategori-ilan-liste">
                                        
                                                
                                                
                                                
                                                <?php $favori = $vt->query("SELECT * FROM favoriler WHERE uye_id = '{$_SESSION["id"]}' AND ilan_id = '{$emlak["id"]}' ")->fetch(); ?>
                                                <?php if(!$_SESSION["uyelogin"]) { ?>
                                                <a href="#" data-toggle="modal" id="girisKontrol1<?php echo $emlak["id"] ?>" class="favori-ekle" style="">
                                                    <i class="fa fa-heart-o fa-lg"></i>
                                                </a>
                                                <?php } else { ?>
                                                <a href="#" id="favEkle1<?php echo $emlak["id"] ?>" data-toggle="modal" class="favori-ekle" style="display:<?php if ($favori) { ?>none<?php } ?>">
                                                    <i class="fa fa-heart-o fa-lg"></i>
                                                </a>
                                                <?php } ?>
                                                <a href="#" id="favCikar1<?php echo $emlak["id"] ?>" data-toggle="modal" class="favori-cikar" style="display:<?php if (!$favori) { ?>none<?php } ?>">
                                                    <i class="fa fa-heart fa-lg"></i>
                                                </a> 
                                                <script> 
                                                $('#girisKontrol1<?php echo $emlak["id"] ?>').click(function ilanId(e){  
                                                    alert('Favorilere ekleyebilmeniz için lütfen üye girişi yapınız.');
                                                    window.location.href = '<?php echo $ayar["site_url"] ?>giris-yap';
                                                });
                                                $('#favEkle1<?php echo $emlak["id"] ?>').click(function ilanId(e){  
                                                    
                                                    $.post("index.php?do=ajax_favori&favori=ekle&ilanId=<?php echo $emlak["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>",function(data){
                                                        $('#gosterx').html(data);
                                                    }); 
                                                    
                                                    
                                                    $('#favEkle1<?php echo $emlak["id"] ?>').css({ 'display': 'none' }); 
                                                    $('#favCikar1<?php echo $emlak["id"] ?>').css({ 'display': 'block' }); 
                                        			
                                                });
                                                $('#favCikar1<?php echo $emlak["id"] ?>').click(function(){ 
                                                    
                                                    $.post("index.php?do=ajax_favori&favori=sil&ilanId=<?php echo $emlak["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>", function(data){
                                                        $("#gosterx").html(data);
                                                    }); 
                                                     
                                                    $('#favEkle1<?php echo $emlak["id"] ?>').css({ 'display': 'block' }); 
                                                    $('#favCikar1<?php echo $emlak["id"] ?>').css({ 'display': 'none' });  
                                                    
                                                }); 
                                                </script>
                                                
                                                
                                                
                                                        <div class="d-md-flex">
                                                            <div class="item-card9-img">
                                                                <div class="item-card9-imgs kategori-list-img">
                                                                    <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"></a>
                                                                    <?php if ($emlak_resim["emlakno"]) { ?>
                                                                        <img src="uploads/resim/<?php echo $emlak_resim["resimad"] ?>" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
                                                                    <?php } else { ?>
                                                                        <img src="uploads/resim/resim.png" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <div class="card border-0 m-lg-2 mb-0 pl-lg-2 box-shadow-0">
                                                                <div class="card-body pl-1 pb-0">
                                                                    <?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
                                                                        <div class="bg-warning tag-option float-right p-1 pl-3 pr-3">ÖNE ÇIKAN</div>
                                                                    <?php endif; ?>
                                                                    <h4 style="font-size: 22px;" class="mb-3"><strong><?php echo rakam($emlak["fiyat"]); ?></strong> <?php echo $emlak["fiyatkur"]; ?></h4>
                                                                    <h4 class="mb-3">
                                                        
                                                                        <span><?php echo $emlak_ilan_tipi["ad"]; ?> <?php echo $emlak_kategori["kat_adi"]; ?></span> 
                                                                                 
                                                                        <?php
                                                                            $ilandetay=$vt->query("SELECT emlak_form.*, emlak_ilandetay.eformdetay AS dbaslik, emlak_form.ad AS eformad, emlak_form.ikon AS ikon FROM emlak_form, emlak_ilandetay WHERE emlak_ilandetay.emlakno = '{$emlak["emlakno"]}' AND emlak_form.id = emlak_ilandetay.formid AND emlak_form.durum = 0 AND emlak_form.ozet = 1 ORDER BY emlak_form.sira ASC LIMIT 3")->fetchAll(); 
                                                                            foreach($ilandetay as $detay): 
                                                                        ?>                
                                                                        <span class="m-2 text-muted">|</span>
                                                                        <span><i class="<?php echo $detay["ikon"]; ?> "></i> <?php echo $detay["dbaslik"]; ?></span> 
                                                                             
                                                                        <?php endforeach; ?>   
                                                                        
                                                                    </h4>
                                                                    <h4 class="mb-1 liste-baslik"><a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"><?php echo $emlak["baslik"]; ?></a></h4>
                                                                     
                                                                    <?php
                                                                    $bilgi = "																
																				<div class='text-center'>
																					<h3 class='font-weight-bold'><a class='p-3 pl-5 pr-5 h5 btn ' href='tel:".$ekleyen["tel"]."'><i class='fa fa-phone fa-lg text-light mr-3'></i> ".$ekleyen["tel"]."</a></h3>
																				</div>
																			";
                                                                    ?>
                                                                    <div id="telefon-go ster" style="position: absolute; right: 8px; top: 8px; height: 100%; width: 200px; z-index:7;">
                                                                        <p data-container="body" data-toggle="popover" data-placement="top" title="<?php echo $ekleyen["adsoyad"]; ?>" data-content="<?php echo $bilgi; ?>" class="btn btn-dark btn-block h6 pl-4 pr-4 pt-3 pb-3" style="cursor:pointer;">
                                                                            <i class="fa fa-phone fa-lg float-left mr-3"></i>
                                                                            Telefonu Göster
                                                                        </p>
                                                                        <a href="tel:<?php echo $ekleyen["tel"]; ?>" class="btn btn-success btn-block h6 pl-4 pr-4 pt-3 pb-3">
                                                                            <strong>
                                                                                <i class="fa fa-mobile-phone fa-lg float-left mr-3 ml-1" style="font-size:24px;"></i>
                                                                                Telefonu Ara
                                                                            </strong>
                                                                        </a>
                                                                        <!--
                                                                        <button type="button" class="btn btn-dark btn-block h6 pl-4 pr-4 pt-3 pb-3 mr-3" data-toggle="modal" data-target="#mesajGonder">
                                                                            <i class="fa fa-envelope-o fa-lg float-left mr-3"></i> Mesaj Gönder
                                                                        </button>
                                                                        -->
                                                                    </div>
                                                                    <a href="/ilanara/?il=<?php echo $emlak_sehir["sehir_key"]; ?>" class="btn mb-3 box-shadow-0 float-left pl-0"><i class="fa fa-map-marker mr-1 text-danger"></i>
                                                                        <?php echo $emlak_sehir["adi"]; ?>
                                                                    </a>
                                                                    <a href="/ilanara/?il=<?php echo $emlak_sehir["sehir_key"]; ?>&ilce=<?php echo $emlak_ilce["ilce_key"]; ?>" class="btn mb-3 box-shadow-0 float-left pl-0">
                                                                        <?php echo $emlak_ilce["ilce_title"]; ?>
                                                                    </a>
                                                                    <a href="/ilanara/?il=<?php echo $emlak_sehir["sehir_key"]; ?>&ilce=<?php echo $emlak_ilce["ilce_key"]; ?>&mahalle=<?php echo $emlak_mahalle["mahalle_id"]; ?>" class="btn mb-3 box-shadow-0 float-left pl-0">
                                                                        <?php echo $emlak_mahalle["mahalle_title"]; ?>
                                                                    </a>
                                                                    <div class="item-card9">
                                                                        <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>" class="text-dark"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div style="display:block; height:13px;"></div>
                                                    <?php
                                                }
                                            }
                                        }
                                        // YENİ ALAN
                                        if ($mintoplu != "" || $maxtoplu != "") {
                                            $emlaknoverlist = $vt->query("SELECT * FROM emlak_ilandetay where seo BETWEEN '$mintoplu' and '$maxtoplu' && formid = '$minmaxtoplu'");
                                            foreach($emlaknoverlist AS $emlaknover) {
                                                if (is_numeric($emlaknover["seo"]))  {
                                                    $emlakver = $vt->query("SELECT * FROM emlak_ilan where emlakno = '".$emlaknover["emlakno"]."' AND onay = 1 AND durum = 0");
                                                    foreach($emlakver AS $emlak) {
                                                        $emlak_kategori = $vt->query("SELECT * FROM emlak_kategori WHERE kat_id like '%".$_GET["kategori"]."%' AND kat_id = '".$emlak["katid"]."'")->fetch();
                                                        $emlak_ilan_tipi = $vt->query("SELECT * FROM emlak_ilantipi WHERE id = '".$emlak["ilantipi"]."'")->fetch();
                                                        $emlak_ilan_sekli = $vt->query("SELECT * FROM emlak_ilansekli WHERE id = '".$emlak["ilansekli"]."'")->fetch();
                                                        $emlak_resim = $vt->query("SELECT * FROM emlak_resim WHERE emlakno = '".$emlak["emlakno"]."' AND kapak = 1")->fetch();
                                                        $emlak_sehir = $vt->query("SELECT * FROM sehir WHERE sehir_key = '".$emlak["il"]."'")->fetch();
                                                        $emlak_ilce = $vt->query("SELECT * FROM ilce WHERE ilce_key = '".$emlak["ilce"]."'")->fetch();
                                                        $emlak_mahalle = $vt->query("SELECT * FROM mahalle WHERE mahalle_id = '".$emlak["mahalle"]."'")->fetch();
                                                        $ekleyen = $vt->query("SELECT * FROM yonetici WHERE id = '".$emlak["yonetici_id"]."'")->fetch();
                                                        ?>
                                                        <div class="card overflow-hidden kategori-ilan-liste">
                                        
                                                
                                                
                                                
                                                <?php $favori = $vt->query("SELECT * FROM favoriler WHERE uye_id = '{$_SESSION["id"]}' AND ilan_id = '{$emlak["id"]}' ")->fetch(); ?>
                                                <?php if(!$_SESSION["uyelogin"]) { ?>
                                                <a href="#" data-toggle="modal" id="girisKontrol2<?php echo $emlak["id"] ?>" class="favori-ekle" style="">
                                                    <i class="fa fa-heart-o fa-lg"></i>
                                                </a>
                                                <?php } else { ?>
                                                <a href="#" id="favEkle2<?php echo $emlak["id"] ?>" data-toggle="modal" class="favori-ekle" style="display:<?php if ($favori) { ?>none<?php } ?>">
                                                    <i class="fa fa-heart-o fa-lg"></i>
                                                </a>
                                                <?php } ?>
                                                <a href="#" id="favCikar2<?php echo $emlak["id"] ?>" data-toggle="modal" class="favori-cikar" style="display:<?php if (!$favori) { ?>none<?php } ?>">
                                                    <i class="fa fa-heart fa-lg"></i>
                                                </a> 
                                                <script> 
                                                $('#girisKontrol2<?php echo $emlak["id"] ?>').click(function ilanId(e){  
                                                    alert('Favorilere ekleyebilmeniz için lütfen üye girişi yapınız.');
                                                    window.location.href = '<?php echo $ayar["site_url"] ?>giris-yap';
                                                });
                                                $('#favEkle2<?php echo $emlak["id"] ?>').click(function ilanId(e){  
                                                    
                                                    $.post("index.php?do=ajax_favori&favori=ekle&ilanId=<?php echo $emlak["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>",function(data){
                                                        $('#gosterx').html(data);
                                                    }); 
                                                    
                                                    
                                                    $('#favEkle2<?php echo $emlak["id"] ?>').css({ 'display': 'none' }); 
                                                    $('#favCikar2<?php echo $emlak["id"] ?>').css({ 'display': 'block' }); 
                                        			
                                                });
                                                $('#favCikar2<?php echo $emlak["id"] ?>').click(function(){ 
                                                    
                                                    $.post("index.php?do=ajax_favori&favori=sil&ilanId=<?php echo $emlak["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>", function(data){
                                                        $("#gosterx").html(data);
                                                    }); 
                                                     
                                                    $('#favEkle2<?php echo $emlak["id"] ?>').css({ 'display': 'block' }); 
                                                    $('#favCikar2<?php echo $emlak["id"] ?>').css({ 'display': 'none' });  
                                                    
                                                }); 
                                                </script>
                                                
                                                
                                                
                                                            <div class="d-md-flex">
                                                                <div class="item-card9-img">
                                                                    <div class="item-card9-imgs kategori-list-img">
                                                                        <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"></a>
                                                                        <?php if ($emlak_resim["emlakno"]) { ?>
                                                                            <img src="uploads/resim/<?php echo $emlak_resim["resimad"] ?>" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
                                                                        <?php } else { ?>
                                                                            <img src="uploads/resim/resim.png" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                                <div class="card border-0 m-lg-2 mb-0 pl-lg-2 box-shadow-0">
                                                                    <div class="card-body pl-1 pb-0">
                                                                        <?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
                                                                            <div class="bg-warning tag-option float-right p-1 pl-3 pr-3">ÖNE ÇIKAN</div>
                                                                        <?php endif; ?>
                                                                        <h4 style="font-size: 22px;" class="mb-3"><strong><?php echo rakam($emlak["fiyat"]); ?></strong> <?php echo $emlak["fiyatkur"]; ?></h4>
                                                                        <h4 class="mb-3">
                                                        
                                                                            <span><?php echo $emlak_ilan_tipi["ad"]; ?> <?php echo $emlak_kategori["kat_adi"]; ?></span> 
                                                                                     
                                                                            <?php
                                                                                $ilandetay=$vt->query("SELECT emlak_form.*, emlak_ilandetay.eformdetay AS dbaslik, emlak_form.ad AS eformad, emlak_form.ikon AS ikon FROM emlak_form, emlak_ilandetay WHERE emlak_ilandetay.emlakno = '{$emlak["emlakno"]}' AND emlak_form.id = emlak_ilandetay.formid AND emlak_form.durum = 0 AND emlak_form.ozet = 1 ORDER BY emlak_form.sira ASC LIMIT 3")->fetchAll(); 
                                                                                foreach($ilandetay as $detay): 
                                                                            ?>                
                                                                            <span class="m-2 text-muted">|</span>
                                                                            <span><i class="<?php echo $detay["ikon"]; ?> "></i> <?php echo $detay["dbaslik"]; ?></span> 
                                                                                 
                                                                            <?php endforeach; ?>   
                                                                            
                                                                        </h4>
                                                                        <h5 class="mb-1 liste-baslik"><a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"><?php echo $emlak["baslik"]; ?></a></h5>
                                                                        <?php
                                                                        $bilgi = "																
																					<div class='text-center'>
																						<h3 class='font-weight-bold'><a class='p-3 pl-5 pr-5 h5 btn ' href='tel:".$ekleyen["tel"]."'><i class='fa fa-phone fa-lg text-light mr-3'></i> ".$ekleyen["tel"]."</a></h3>
																					</div>
																				";
                                                                        ?>
                                                                        <div id="telefon-go ster" style="position: absolute; right: 8px; top: 8px; height: 100%; width: 200px; z-index:7;">
                                                                            <p data-container="body" data-toggle="popover" data-placement="top" title="<?php echo $ekleyen["adsoyad"]; ?>" data-content="<?php echo $bilgi; ?>" class="btn btn-dark btn-block h6 pl-4 pr-4 pt-3 pb-3" style="cursor:pointer;">
                                                                                <i class="fa fa-phone fa-lg float-left mr-3"></i>
                                                                                Telefonu Göster
                                                                            </p>
                                                                            <a href="tel:<?php echo $ekleyen["tel"]; ?>" class="btn btn-success btn-block h6 pl-4 pr-4 pt-3 pb-3">
                                                                                <strong>
                                                                                    <i class="fa fa-mobile-phone fa-lg float-left mr-3 ml-1" style="font-size:24px;"></i>
                                                                                    Telefonu Ara
                                                                                </strong>
                                                                            </a>
                                                                            <!--
                                                                            <button type="button" class="btn btn-dark btn-block h6 pl-4 pr-4 pt-3 pb-3 mr-3" data-toggle="modal" data-target="#mesajGonder">
                                                                                <i class="fa fa-envelope-o fa-lg float-left mr-3"></i> Mesaj Gönder
                                                                            </button>
                                                                            -->
                                                                        </div>
                                                                        <a href="/ilanara/?il=<?php echo $emlak_sehir["sehir_key"]; ?>" class="btn mb-3 box-shadow-0 float-left pl-0"><i class="fa fa-map-marker mr-1 text-danger"></i>
                                                                            <?php echo $emlak_sehir["adi"]; ?>
                                                                        </a>
                                                                        <a href="/ilanara/?il=<?php echo $emlak_sehir["sehir_key"]; ?>&ilce=<?php echo $emlak_ilce["ilce_key"]; ?>" class="btn mb-3 box-shadow-0 float-left pl-0">
                                                                            <?php echo $emlak_ilce["ilce_title"]; ?>
                                                                        </a>
                                                                        <a href="/ilanara/?il=<?php echo $emlak_sehir["sehir_key"]; ?>&ilce=<?php echo $emlak_ilce["ilce_key"]; ?>&mahalle=<?php echo $emlak_mahalle["mahalle_id"]; ?>" class="btn mb-3 box-shadow-0 float-left pl-0">
                                                                            <?php echo $emlak_mahalle["mahalle_title"]; ?>
                                                                        </a>
                                                                        <div class="item-card9">
                                                                            <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>" class="text-dark"></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div style="display:block; height:13px;"></div>
                                                        <?php
                                                    }
                                                }
                                            }
                                        }
                                        // YENİ ALAN
                                        if ($io["toplusecim"] == 1 && $post != "") {
                                            foreach ($post as $key) {
                                                $emlaknoverlist = $vt->query("SELECT * FROM emlak_ilandetay where seo = '".$key."' && formid = '".$io["id"]."'");
                                                foreach($emlaknoverlist AS $emlaknover) {
                                                    $emlakver = $vt->query("SELECT * FROM emlak_ilan where emlakno = '".$emlaknover["emlakno"]."' AND onay = 1 AND durum = 0");
                                                    foreach($emlakver AS $emlak) {
                                                        $emlak_kategori = $vt->query("SELECT * FROM emlak_kategori WHERE kat_id like '%".$_GET["kategori"]."%' AND kat_id = '".$emlak["katid"]."'")->fetch();
                                                        $emlak_ilan_tipi = $vt->query("SELECT * FROM emlak_ilantipi WHERE id = '".$emlak["ilantipi"]."'")->fetch();
                                                        $emlak_ilan_sekli = $vt->query("SELECT * FROM emlak_ilansekli WHERE id = '".$emlak["ilansekli"]."'")->fetch();
                                                        $emlak_resim = $vt->query("SELECT * FROM emlak_resim WHERE emlakno = '".$emlak["emlakno"]."' AND kapak = 1")->fetch();
                                                        $emlak_sehir = $vt->query("SELECT * FROM sehir WHERE sehir_key = '".$emlak["il"]."'")->fetch();
                                                        $emlak_ilce = $vt->query("SELECT * FROM ilce WHERE ilce_key = '".$emlak["ilce"]."'")->fetch();
                                                        $emlak_mahalle = $vt->query("SELECT * FROM mahalle WHERE mahalle_id = '".$emlak["mahalle"]."'")->fetch();
                                                        $ekleyen = $vt->query("SELECT * FROM yonetici WHERE id = '".$emlak["yonetici_id"]."'")->fetch();
                                                        ?>
                                                        <div class="card overflow-hidden kategori-ilan-liste">
                                        
                                                
                                                
                                                
                                                            <?php $favori = $vt->query("SELECT * FROM favoriler WHERE uye_id = '{$_SESSION["id"]}' AND ilan_id = '{$emlak["id"]}' ")->fetch(); ?>
                                                            <?php if(!$_SESSION["uyelogin"]) { ?>
                                                            <a href="#" data-toggle="modal" id="girisKontrol3<?php echo $emlak["id"] ?>" class="favori-ekle" style="">
                                                                <i class="fa fa-heart-o fa-lg"></i>
                                                            </a>
                                                            <?php } else { ?>
                                                            <a href="#" id="favEkle3<?php echo $emlak["id"] ?>" data-toggle="modal" class="favori-ekle" style="display:<?php if ($favori) { ?>none<?php } ?>">
                                                                <i class="fa fa-heart-o fa-lg"></i>
                                                            </a>
                                                            <?php } ?>
                                                            <a href="#" id="favCikar3<?php echo $emlak["id"] ?>" data-toggle="modal" class="favori-cikar" style="display:<?php if (!$favori) { ?>none<?php } ?>">
                                                                <i class="fa fa-heart fa-lg"></i>
                                                            </a> 
                                                            <script> 
                                                            $('#girisKontrol3<?php echo $emlak["id"] ?>').click(function ilanId(e){  
                                                                alert('Favorilere ekleyebilmeniz için lütfen üye girişi yapınız.');
                                                                window.location.href = '<?php echo $ayar["site_url"] ?>giris-yap';
                                                            });
                                                            $('#favEkle3<?php echo $emlak["id"] ?>').click(function ilanId(e){  
                                                                
                                                                $.post("index.php?do=ajax_favori&favori=ekle&ilanId=<?php echo $emlak["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>",function(data){
                                                                    $('#gosterx').html(data);
                                                                }); 
                                                                
                                                                
                                                                $('#favEkle3<?php echo $emlak["id"] ?>').css({ 'display': 'none' }); 
                                                                $('#favCikar3<?php echo $emlak["id"] ?>').css({ 'display': 'block' }); 
                                                    			
                                                            });
                                                            $('#favCikar3<?php echo $emlak["id"] ?>').click(function(){ 
                                                                
                                                                $.post("index.php?do=ajax_favori&favori=sil&ilanId=<?php echo $emlak["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>", function(data){
                                                                    $("#gosterx").html(data);
                                                                }); 
                                                                 
                                                                $('#favEkle3<?php echo $emlak["id"] ?>').css({ 'display': 'block' }); 
                                                                $('#favCikar3<?php echo $emlak["id"] ?>').css({ 'display': 'none' });  
                                                                
                                                            }); 
                                                            </script>
                                                            
                                                            
                                                            
                                                            <div class="d-md-flex">
                                                                <div class="item-card9-img">
                                                                    <div class="item-card9-imgs kategori-list-img">
                                                                        <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"></a>
                                                                        <?php if ($emlak_resim["emlakno"]) { ?>
                                                                            <img src="uploads/resim/<?php echo $emlak_resim["resimad"] ?>" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
                                                                        <?php } else { ?>
                                                                            <img src="uploads/resim/resim.png" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                                <div class="card border-0 m-lg-2 mb-0 pl-lg-2 box-shadow-0">
                                                                    <div class="card-body pl-1 pb-0">
                                                                        <?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
                                                                            <div class="bg-warning tag-option float-right p-1 pl-3 pr-3">ÖNE ÇIKAN</div>
                                                                        <?php endif; ?>
                                                                        <h4 style="font-size: 22px;" class="mb-3"><strong><?php echo rakam($emlak["fiyat"]); ?></strong> <?php echo $emlak["fiyatkur"]; ?></h4>
                                                                        <h4 class="mb-3">
                                                        
                                                                            <span><?php echo $emlak_ilan_tipi["ad"]; ?> <?php echo $emlak_kategori["kat_adi"]; ?></span> 
                                                                                     
                                                                            <?php
                                                                                $ilandetay=$vt->query("SELECT emlak_form.*, emlak_ilandetay.eformdetay AS dbaslik, emlak_form.ad AS eformad, emlak_form.ikon AS ikon FROM emlak_form, emlak_ilandetay WHERE emlak_ilandetay.emlakno = '{$emlak["emlakno"]}' AND emlak_form.id = emlak_ilandetay.formid AND emlak_form.durum = 0 AND emlak_form.ozet = 1 ORDER BY emlak_form.sira ASC LIMIT 3")->fetchAll(); 
                                                                                foreach($ilandetay as $detay): 
                                                                            ?>                
                                                                            <span class="m-2 text-muted">|</span>
                                                                            <span><i class="<?php echo $detay["ikon"]; ?> "></i> <?php echo $detay["dbaslik"]; ?></span> 
                                                                                 
                                                                            <?php endforeach; ?>   
                                                                            
                                                                        </h4>
                                                                        <h5 class="mb-1 liste-baslik"><a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"><?php echo $emlak["baslik"]; ?></a></h5>
                                                                        <p class="ekleme-tarihi-1 btn mb-3 box-shadow-0 font-weight-light float-right pl-0"><i class="fa fa-calendar-o mr-1"></i> <?php echo $emlak["eklemetarihi"]; ?></p>
                                                                        <?php
                                                                        $bilgi = "																
																			<div class='text-center'>
																				<h3 class='font-weight-bold'><a class='p-3 pl-5 pr-5 h5 btn ' href='tel:".$ekleyen["tel"]."'><i class='fa fa-phone fa-lg text-light mr-3'></i> ".$ekleyen["tel"]."</a></h3>
																			</div>
																		";
                                                                        ?>
                                                                        <div id="telefon-go ster" style="position: absolute; right: 8px; top: 8px; height: 100%; width: 200px; z-index:7;">
                                                                            <p data-container="body" data-toggle="popover" data-placement="top" title="<?php echo $ekleyen["adsoyad"]; ?>" data-content="<?php echo $bilgi; ?>" class="btn btn-dark btn-block h6 pl-4 pr-4 pt-3 pb-3" style="cursor:pointer;">
                                                                                <i class="fa fa-phone fa-lg float-left mr-3"></i>
                                                                                Telefonu Göster
                                                                            </p>
                                                                            <a href="tel:<?php echo $ekleyen["tel"]; ?>" class="btn btn-success btn-block h6 pl-4 pr-4 pt-3 pb-3">
                                                                                <strong>
                                                                                    <i class="fa fa-mobile-phone fa-lg float-left mr-3 ml-1" style="font-size:24px;"></i>
                                                                                    Telefonu Ara
                                                                                </strong>
                                                                            </a>
                                                                            <!--
                                                                            <button type="button" class="btn btn-dark btn-block h6 pl-4 pr-4 pt-3 pb-3 mr-3" data-toggle="modal" data-target="#mesajGonder">
                                                                                <i class="fa fa-envelope-o fa-lg float-left mr-3"></i> Mesaj Gönder
                                                                            </button>
                                                                            -->
                                                                        </div>
                                                                        <a href="/ilanara/?il=<?php echo $emlak_sehir["sehir_key"]; ?>" class="btn mb-3 box-shadow-0 float-left pl-0"><i class="fa fa-map-marker mr-1 text-danger"></i>
                                                                            <?php echo $emlak_sehir["adi"]; ?>
                                                                        </a>
                                                                        <a href="/ilanara/?il=<?php echo $emlak_sehir["sehir_key"]; ?>&ilce=<?php echo $emlak_ilce["ilce_key"]; ?>" class="btn mb-3 box-shadow-0 float-left pl-0">
                                                                            <?php echo $emlak_ilce["ilce_title"]; ?>
                                                                        </a>
                                                                        <a href="/ilanara/?il=<?php echo $emlak_sehir["sehir_key"]; ?>&ilce=<?php echo $emlak_ilce["ilce_key"]; ?>&mahalle=<?php echo $emlak_mahalle["mahalle_id"]; ?>" class="btn mb-3 box-shadow-0 float-left pl-0">
                                                                            <?php echo $emlak_mahalle["mahalle_title"]; ?>
                                                                        </a>
                                                                        <div class="item-card9">
                                                                            <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>" class="text-dark"></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div style="display:block; height:13px;"></div>
                                                        <?php
                                                    }
                                                }
                                            }
                                        }
                                        // YENİ ALAN
                                        if ($io["toplusecim"] != 1 && $post != "") {
                                            $emlaknoverlist = $vt->query("SELECT * FROM emlak_ilandetay where seo = '".$post."' && formid = '".$io["id"]."'");
                                            foreach($emlaknoverlist AS $emlaknover) {
                                                if (is_numeric($emlaknover["seo"]))  {
                                                    $emlakver = $vt->query("SELECT * FROM emlak_ilan where emlakno = '".$emlaknover["emlakno"]."' AND onay = 1 AND durum = 0");
                                                    foreach($emlakver AS $emlak) {
                                                        $emlak_kategori = $vt->query("SELECT * FROM emlak_kategori WHERE kat_id like '%".$_GET["kategori"]."%' AND kat_id = '".$emlak["katid"]."'")->fetch();
                                                        $emlak_ilan_tipi = $vt->query("SELECT * FROM emlak_ilantipi WHERE id = '".$emlak["ilantipi"]."'")->fetch();
                                                        $emlak_ilan_sekli = $vt->query("SELECT * FROM emlak_ilansekli WHERE id = '".$emlak["ilansekli"]."'")->fetch();
                                                        $emlak_resim = $vt->query("SELECT * FROM emlak_resim WHERE emlakno = '".$emlak["emlakno"]."' AND kapak = 1")->fetch();
                                                        $emlak_sehir = $vt->query("SELECT * FROM sehir WHERE sehir_key = '".$emlak["il"]."'")->fetch();
                                                        $emlak_ilce = $vt->query("SELECT * FROM ilce WHERE ilce_key = '".$emlak["ilce"]."'")->fetch();
                                                        $emlak_mahalle = $vt->query("SELECT * FROM mahalle WHERE mahalle_id = '".$emlak["mahalle"]."'")->fetch();
                                                        $ekleyen = $vt->query("SELECT * FROM yonetici WHERE id = '".$emlak["yonetici_id"]."'")->fetch();
                                                        ?>
                                                        <div class="card overflow-hidden kategori-ilan-liste">
                                        
                                                
                                                
                                                
                                                            <?php $favori = $vt->query("SELECT * FROM favoriler WHERE uye_id = '{$_SESSION["id"]}' AND ilan_id = '{$emlak["id"]}' ")->fetch(); ?>
                                                            <?php if(!$_SESSION["uyelogin"]) { ?>
                                                            <a href="#" data-toggle="modal" id="girisKontrol4<?php echo $emlak["id"] ?>" class="favori-ekle" style="">
                                                                <i class="fa fa-heart-o fa-lg"></i>
                                                            </a>
                                                            <?php } else { ?>
                                                            <a href="#" id="favEkle4<?php echo $emlak["id"] ?>" data-toggle="modal" class="favori-ekle" style="display:<?php if ($favori) { ?>none<?php } ?>">
                                                                <i class="fa fa-heart-o fa-lg"></i>
                                                            </a>
                                                            <?php } ?>
                                                            <a href="#" id="favCikar4<?php echo $emlak["id"] ?>" data-toggle="modal" class="favori-cikar" style="display:<?php if (!$favori) { ?>none<?php } ?>">
                                                                <i class="fa fa-heart fa-lg"></i>
                                                            </a> 
                                                            <script> 
                                                            $('#girisKontrol4<?php echo $emlak["id"] ?>').click(function ilanId(e){  
                                                                alert('Favorilere ekleyebilmeniz için lütfen üye girişi yapınız.');
                                                                window.location.href = '<?php echo $ayar["site_url"] ?>giris-yap';
                                                            });
                                                            $('#favEkle4<?php echo $emlak["id"] ?>').click(function ilanId(e){  
                                                                
                                                                $.post("index.php?do=ajax_favori&favori=ekle&ilanId=<?php echo $emlak["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>",function(data){
                                                                    $('#gosterx').html(data);
                                                                }); 
                                                                
                                                                
                                                                $('#favEkle4<?php echo $emlak["id"] ?>').css({ 'display': 'none' }); 
                                                                $('#favCikar4<?php echo $emlak["id"] ?>').css({ 'display': 'block' }); 
                                                    			
                                                            });
                                                            $('#favCikar4<?php echo $emlak["id"] ?>').click(function(){ 
                                                                
                                                                $.post("index.php?do=ajax_favori&favori=sil&ilanId=<?php echo $emlak["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>", function(data){
                                                                    $("#gosterx").html(data);
                                                                }); 
                                                                 
                                                                $('#favEkle4<?php echo $emlak["id"] ?>').css({ 'display': 'block' }); 
                                                                $('#favCikar4<?php echo $emlak["id"] ?>').css({ 'display': 'none' });  
                                                                
                                                            }); 
                                                            </script>
                                                            
                                                            
                                                            
                                                            <div class="d-md-flex">
                                                                <div class="item-card9-img">
                                                                    <div class="item-card9-imgs kategori-list-img">
                                                                        <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"></a>
                                                                        <?php if ($emlak_resim["emlakno"]) { ?>
                                                                            <img src="uploads/resim/<?php echo $emlak_resim["resimad"] ?>" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
                                                                        <?php } else { ?>
                                                                            <img src="uploads/resim/resim.png" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                                <div class="card border-0 m-lg-2 mb-0 pl-lg-2 box-shadow-0">
                                                                    <div class="card-body pl-1 pb-0">
                                                                        <?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
                                                                            <div class="bg-warning tag-option float-right p-1 pl-3 pr-3">ÖNE ÇIKAN</div>
                                                                        <?php endif; ?>
                                                                        <h4 style="font-size: 22px;" class="mb-3"><strong><?php echo rakam($emlak["fiyat"]); ?></strong> <?php echo $emlak["fiyatkur"]; ?></h4>
                                                                        <h4 class="mb-3">
                                                        
                                                                            <span><?php echo $emlak_ilan_tipi["ad"]; ?> <?php echo $emlak_kategori["kat_adi"]; ?></span> 
                                                                                     
                                                                            <?php
                                                                                $ilandetay=$vt->query("SELECT emlak_form.*, emlak_ilandetay.eformdetay AS dbaslik, emlak_form.ad AS eformad, emlak_form.ikon AS ikon FROM emlak_form, emlak_ilandetay WHERE emlak_ilandetay.emlakno = '{$emlak["emlakno"]}' AND emlak_form.id = emlak_ilandetay.formid AND emlak_form.durum = 0 AND emlak_form.ozet = 1 ORDER BY emlak_form.sira ASC LIMIT 3")->fetchAll(); 
                                                                                foreach($ilandetay as $detay): 
                                                                            ?>                
                                                                            <span class="m-2 text-muted">|</span>
                                                                            <span><i class="<?php echo $detay["ikon"]; ?> "></i> <?php echo $detay["dbaslik"]; ?></span> 
                                                                                 
                                                                            <?php endforeach; ?>   
                                                                            
                                                                        </h4>
                                                                        <h5 class="mb-1 liste-baslik"><a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"><?php echo $emlak["baslik"]; ?></a></h5>
                                                                        <p class="ekleme-tarihi-1 btn mb-3 box-shadow-0 font-weight-light float-right pl-0"><i class="fa fa-calendar-o mr-1"></i> <?php echo $emlak["eklemetarihi"]; ?></p>
                                                                        <?php
                                                                        $bilgi = "																
																					<div class='text-center'>
																						<h3 class='font-weight-bold'><a class='p-3 pl-5 pr-5 h5 btn ' href='tel:".$ekleyen["tel"]."'><i class='fa fa-phone fa-lg text-light mr-3'></i> ".$ekleyen["tel"]."</a></h3>
																					</div>
																				";
                                                                        ?>
                                                                        <div id="telefon-go ster" style="position: absolute; right: 8px; top: 8px; height: 100%; width: 200px; z-index:7;">
                                                                            <p data-container="body" data-toggle="popover" data-placement="top" title="<?php echo $ekleyen["adsoyad"]; ?>" data-content="<?php echo $bilgi; ?>" class="btn btn-dark btn-block h6 pl-4 pr-4 pt-3 pb-3" style="cursor:pointer;">
                                                                                <i class="fa fa-phone fa-lg float-left mr-3"></i>
                                                                                Telefonu Göster
                                                                            </p>
                                                                            <a href="tel:<?php echo $ekleyen["tel"]; ?>" class="btn btn-success btn-block h6 pl-4 pr-4 pt-3 pb-3">
                                                                                <strong>
                                                                                    <i class="fa fa-mobile-phone fa-lg float-left mr-3 ml-1" style="font-size:24px;"></i>
                                                                                    Telefonu Ara
                                                                                </strong>
                                                                            </a>
                                                                            <!--
                                                                            <button type="button" class="btn btn-dark btn-block h6 pl-4 pr-4 pt-3 pb-3 mr-3" data-toggle="modal" data-target="#mesajGonder">
                                                                                <i class="fa fa-envelope-o fa-lg float-left mr-3"></i> Mesaj Gönder
                                                                            </button>
                                                                            -->
                                                                        </div>
                                                                        <a href="/ilanara/?il=<?php echo $emlak_sehir["sehir_key"]; ?>" class="btn mb-3 box-shadow-0 float-left pl-0"><i class="fa fa-map-marker mr-1 text-danger"></i>
                                                                            <?php echo $emlak_sehir["adi"]; ?>
                                                                        </a>
                                                                        <a href="/ilanara/?il=<?php echo $emlak_sehir["sehir_key"]; ?>&ilce=<?php echo $emlak_ilce["ilce_key"]; ?>" class="btn mb-3 box-shadow-0 float-left pl-0">
                                                                            <?php echo $emlak_ilce["ilce_title"]; ?>
                                                                        </a>
                                                                        <a href="/ilanara/?il=<?php echo $emlak_sehir["sehir_key"]; ?>&ilce=<?php echo $emlak_ilce["ilce_key"]; ?>&mahalle=<?php echo $emlak_mahalle["mahalle_id"]; ?>" class="btn mb-3 box-shadow-0 float-left pl-0">
                                                                            <?php echo $emlak_mahalle["mahalle_title"]; ?>
                                                                        </a>
                                                                        <div class="item-card9">
                                                                            <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>" class="text-dark"></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div style="display:block; height:13px;"></div>
                                                        <?php
                                                    }
                                                }
                                            }
                                        }
                                        // YENİ ALAN
                                    }
                                    if ($GET_minfiyat == "" AND $GET_maxfiyat == "") {
                                        $emlak_ilanlar = $vt->query("SELECT * FROM emlak_ilan WHERE
			                    				katid 			like '%".$GET_kategori."%' AND
			                    				il 				like '%".$GET_il."%' AND
			                    				ilce 			like '%".$GET_ilce."%' AND
			                    				mahalle 		like '%".$GET_mahalle."%' AND
			                    				ilantipi 		like '%".$GET_emlak_tipi."%' AND
			                    				ilansekli 		like '%".$GET_emlak_sekli."%' AND
			                    				fiyatkur 		like '%".$GET_fiyatkur."%' AND
			                    				(seo 			like '%".$GET_baslik."%' OR emlakno like '%".$GET_baslik."%')
			                    				AND onay = 1 AND durum = 0
			                    				ORDER BY fiyat $fiyat;
			                    		");
                                    } else if ($GET_minfiyat != "" || $GET_maxfiyat != "") {
                                        $emlak_ilanlar = $vt->query("SELECT * FROM emlak_ilan WHERE
			                    				katid 			like '%".$GET_kategori."%' AND
			                    				il 				like '%".$GET_il."%' AND
			                    				ilce 			like '%".$GET_ilce."%' AND
			                    				mahalle 		like '%".$GET_mahalle."%' AND
			                    				ilantipi 		like '%".$GET_emlak_tipi."%' AND
			                    				ilansekli 		like '%".$GET_emlak_sekli."%' AND
			                    				fiyatkur 		like '%".$GET_fiyatkur."%' AND
			                    				(seo 			like '%".$GET_baslik."%' OR emlakno like '%".$GET_baslik."%')
			                    				AND onay = 1 AND durum = 0 AND
			                    				fiyat 			between '".$GET_minfiyat."' AND '".$GET_maxfiyat."' 
			                    				ORDER BY fiyat $fiyat;
			                    		");
                                    } else {
                                        $emlak_ilanlar = $vt->query("SELECT * FROM emlak_ilan WHERE onay = 1 AND durum = 0 AND ORDER BY fiyat $fiyat");
                                    }
                                }
                                foreach ($emlak_ilanlar as $emlak) {
                                    $emlak_kategori = $vt->query("SELECT * FROM emlak_kategori WHERE kat_id like '%".$_GET["kategori"]."%' AND kat_id = '".$emlak["katid"]."'")->fetch();
                                    $emlak_ilan_tipi = $vt->query("SELECT * FROM emlak_ilantipi WHERE id = '".$emlak["ilantipi"]."'")->fetch();
                                    $emlak_ilan_sekli = $vt->query("SELECT * FROM emlak_ilansekli WHERE id = '".$emlak["ilansekli"]."'")->fetch();
                                    $emlak_resim = $vt->query("SELECT * FROM emlak_resim WHERE emlakno = '".$emlak["emlakno"]."' AND kapak = 1")->fetch();
                                    $emlak_sehir = $vt->query("SELECT * FROM sehir WHERE sehir_key = '".$emlak["il"]."'")->fetch();
                                    $emlak_ilce = $vt->query("SELECT * FROM ilce WHERE ilce_key = '".$emlak["ilce"]."'")->fetch();
                                    $emlak_mahalle = $vt->query("SELECT * FROM mahalle WHERE mahalle_id = '".$emlak["mahalle"]."'")->fetch();
                                    $ekleyen = $vt->query("SELECT * FROM yonetici WHERE id = '".$emlak["yonetici_id"]."'")->fetch();
                                    $doping_ilan = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '".$emlak["id"]."'AND odeme_durumu = 'Ödendi' AND bitis_tarihi > '".date('Y-m-d')."'")->fetch();
                                    $ilan_id = $emlak["id"];
                                    $uye_id = $ekleyen["id"];
                                    ?>
                                    <?php if (ilanYayinSuresi($uye_id)>tarihFarki($emlak["eklemetarihi"], date("Y-m-d"))): ?>
                                    <div class="card overflow-hidden kategori-ilan-liste mb-3">
                                        
                                                
                                                
                                                
                                                <?php $favori = $vt->query("SELECT * FROM favoriler WHERE uye_id = '{$_SESSION["id"]}' AND ilan_id = '{$emlak["id"]}' ")->fetch(); ?>
                                                <?php if(!$_SESSION["uyelogin"]) { ?>
                                                <a href="#" data-toggle="modal" id="girisKontrol5<?php echo $emlak["id"] ?>" class="favori-ekle" style="">
                                                    <i class="fa fa-heart-o fa-lg"></i>
                                                </a>
                                                <?php } else { ?>
                                                <a href="#" id="favEkle5<?php echo $emlak["id"] ?>" data-toggle="modal" class="favori-ekle" style="display:<?php if ($favori) { ?>none<?php } ?>">
                                                    <i class="fa fa-heart-o fa-lg"></i>
                                                </a>
                                                <?php } ?>
                                                <a href="#" id="favCikar5<?php echo $emlak["id"] ?>" data-toggle="modal" class="favori-cikar" style="display:<?php if (!$favori) { ?>none<?php } ?>">
                                                    <i class="fa fa-heart fa-lg"></i>
                                                </a> 
                                                <script> 
                                                $('#girisKontrol5<?php echo $emlak["id"] ?>').click(function ilanId(e){  
                                                    alert('Favorilere ekleyebilmeniz için lütfen üye girişi yapınız.');
                                                    window.location.href = '<?php echo $ayar["site_url"] ?>giris-yap';
                                                });
                                                $('#favEkle5<?php echo $emlak["id"] ?>').click(function ilanId(e){  
                                                    
                                                    $.post("index.php?do=ajax_favori&favori=ekle&ilanId=<?php echo $emlak["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>",function(data){
                                                        $('#gosterx').html(data);
                                                    }); 
                                                    
                                                    
                                                    $('#favEkle5<?php echo $emlak["id"] ?>').css({ 'display': 'none' }); 
                                                    $('#favCikar5<?php echo $emlak["id"] ?>').css({ 'display': 'block' }); 
                                        			
                                                });
                                                $('#favCikar5<?php echo $emlak["id"] ?>').click(function(){ 
                                                    
                                                    $.post("index.php?do=ajax_favori&favori=sil&ilanId=<?php echo $emlak["id"] ?>&uyeId=<?php echo $_SESSION["id"] ?>", function(data){
                                                        $("#gosterx").html(data);
                                                    }); 
                                                     
                                                    $('#favEkle5<?php echo $emlak["id"] ?>').css({ 'display': 'block' }); 
                                                    $('#favCikar5<?php echo $emlak["id"] ?>').css({ 'display': 'none' });  
                                                    
                                                }); 
                                                </script>
                                                
                                                
                                                
                                        <div class="d-md-flex">
                                            <div class="item-card9-img">
                                                <div class="item-card9-imgs kategori-list-img">
                                                    <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"></a>
                                                    <?php if ($emlak_resim["emlakno"]) { ?>
                                                        <img src="uploads/resim/<?php echo $emlak_resim["resimad"] ?>" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
                                                    <?php } else { ?>
                                                        <img src="uploads/resim/resim.png" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="card border-0 m-lg-2 mb-0 pl-lg-2 box-shadow-0 <?php if (dopingAdi($ilan_id, "renkli_bold")>0 AND $emlak["doping_onay"] == 1): ?> badge-success <?php endif; ?>">
                                                <div class="card-body pl-1 pb-0">
                                                    <?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
                                                        <div class="btn btn-warning btn-sm tag-option float-right p-1 pl-3 pr-3"><small><strong>ÖNE ÇIKAN</strong></small></div>
                                                    <?php endif; ?>
                                                    <h3 class="mb-4 font-weight-light"><strong class="font-weight-bold"><?php echo rakam($emlak["fiyat"]); ?></strong> <?php echo $emlak["fiyatkur"]; ?> </h3>
                                                    <h4 class="mb-3">
                                                        
                                                        <span><?php echo $emlak_ilan_tipi["ad"]; ?> <?php echo $emlak_kategori["kat_adi"]; ?></span> 
                                                                 
                                                        <?php
                                                            $ilandetay=$vt->query("SELECT emlak_form.*, emlak_ilandetay.eformdetay AS dbaslik, emlak_form.ad AS eformad, emlak_form.ikon AS ikon FROM emlak_form, emlak_ilandetay WHERE emlak_ilandetay.emlakno = '{$emlak["emlakno"]}' AND emlak_form.id = emlak_ilandetay.formid AND emlak_form.durum = 0 AND emlak_form.ozet = 1 ORDER BY emlak_form.sira ASC LIMIT 3")->fetchAll(); 
                                                            foreach($ilandetay as $detay): 
                                                        ?>                
                                                        <span class="m-2 text-muted">|</span>
                                                        <span><i class="<?php echo $detay["ikon"]; ?> "></i> <?php echo $detay["dbaslik"]; ?></span> 
                                                             
                                                        <?php endforeach; ?>   
                                                        
                                                    </h4>
                                                    <h4 class="mb-1 liste-baslik"><strong><a class="<?php if (dopingAdi($ilan_id, "renkli_bold")>0 AND $emlak["doping_onay"] == 1): ?> text-danger <?php endif; ?>" href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"><?php echo $emlak["baslik"]; ?></a></strong></h4>
                                                    <p class="ekleme-tarihi-1 d-none d-md-block btn mb-3 box-shadow-0 font-weight-light float-right pl-0"><i class="fa fa-calendar-o mr-1"></i> <?php echo $emlak["eklemetarihi"]; ?></p>
                                                    <?php
                                                        $bilgi = "																
                                                        <div class='text-center'>
                                                            <h3 class='font-weight-bold'><a class='p-3 pl-5 pr-5 h5 btn ' href='tel:".$ekleyen["tel"]."'><i class='fa fa-phone fa-lg text-light mr-3'></i> ".$ekleyen["tel"]."</a></h3>
                                                        </div>
                                                    ";
                                                        ?>
                                                        <div id="telefon-go ster" class="d-none d-md-block" style="position: absolute; right: 8px; top: 8px; height: 100%; z-index:7;">
                                                            <p data-container="body" data-toggle="popover" data-placement="top" title="<?php echo $ekleyen["adsoyad"]; ?>" data-content="<?php echo $bilgi; ?>" class="btn btn-light btn-block h6 pl-4 pr-4 pt-3 pb-3" style="cursor:pointer;">
                                                                <i class="fa fa-phone fa-lg float-left mr-3"></i>
                                                                <strong>Telefonu Göster</strong>
                                                            </p>
                                                            <a href="tel:<?php echo $ekleyen["tel"]; ?>" class="btn btn-light btn-block h6 pl-4 pr-4 pt-3 pb-3">
                                                                <strong>
                                                                    <i class="fa fa-mobile-phone fa-lg float-left mr-3 ml-1" style="font-size:24px;"></i>
                                                                    Telefonu Ara
                                                                </strong>
                                                            </a>
                                                            <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>" class="btn btn-light btn-block h6 pl-4 pr-4 pt-3 pb-3 mr-3">
                                                                <i class="fa fa-envelope-open fa-lg float-left mr-3"></i> <strong>Mesaj Gönder</strong>
                                                            </a>
                                                            <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>" class="btn btn-light btn-block h6 pl-4 pr-4 pt-3 pb-3 mr-3">
                                                                <i class="fa fa-external-link fa-lg float-left mr-3"></i> <strong>İnceleyin</strong>
                                                            </a>
                                                        </div>
                                                        <a href="/ilanara/?il=<?php echo $emlak_sehir["sehir_key"]; ?>" class="btn box-shadow-0 text-light float-left pl-0"><i class="fa fa-map-marker mr-1 text-danger"></i>
                                                            <strong><?php echo $emlak_sehir["adi"]; ?></strong>
                                                        </a>
                                                        <a href="/ilanara/?il=<?php echo $emlak_sehir["sehir_key"]; ?>&ilce=<?php echo $emlak_ilce["ilce_key"]; ?>" class="btn box-shadow-0 text-light float-left pl-0">
                                                            <strong><?php echo $emlak_ilce["ilce_title"]; ?></strong>
                                                        </a>
                                                        <a href="/ilanara/?il=<?php echo $emlak_sehir["sehir_key"]; ?>&ilce=<?php echo $emlak_ilce["ilce_key"]; ?>&mahalle=<?php echo $emlak_mahalle["mahalle_id"]; ?>" class="btn box-shadow-0 text-light float-left pl-0">
                                                            <strong><?php echo $emlak_mahalle["mahalle_title"]; ?></strong>
                                                        </a>
                                                    <div class="item-card9">
                                                        <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>" class="text-dark"></a>
                                                    </div>
                                                </div>
                                                        <div class="row" style="position: relative; top: -12px;">
                                                            <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 d-none d-xl-inline-block d-lg-inline-block">                                                                
                                                                <a href="tel:<?php echo $ekleyen["tel"]; ?>" class="btn btn-outline-danger btn-block "><strong>Telefon</strong></a>
                                                            </div>
                                                            <div class="col-xl-2 col-lg-5 col-md-5 col-sm-5 d-none d-xl-inline-block d-lg-inline-block">                                                                
                                                                <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>" class="btn btn-outline-danger btn-block "><strong>Mesaj</strong></a>
                                                            </div>
                                                        </div>
                                            </div>
                                        </div>
                                        <div class="d-block d-md-none d-sm-none d-xl-none">
                                            <div class="row pl-3 pr-3 pt-3 pb-3">
                                                <div class="col-12">
                                                    <a class="btn btn-success btn-lg btn-block" href="tel:<?php echo $ekleyen["tel"]; ?>"><i class="fa fa-phone fa-lg"></i> <strong>TELEFONU ARA</strong></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                <?php } ?>
                            </div>
                            <div class="pt-8 pb-3 m-auto">
                                <!-- REKLAM -->
                                <?php echo $reklam["kategori_alt"]; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/Add lists-->
            </div>
			<div class="col-xl-3 col-lg-4 col-md-12">
					<?php
					$tek = $_GET[$io["id"]]; 
					?>
					<?php include('blok-hizliara.php'); ?>
					<div class="card mt-5 d-none">
						<div class="card-header">
							<h3 class="card-title">En Son Eklenen İlanlar</h3> </div>
						<div class="card-body pb-3">
							<ul class="vertical-scroll">
								<?php
								$getir_ilan = $vt->query("SELECT * FROM emlak_ilan WHERE id order by id desc limit 5");
								while($veri = $getir_ilan->fetch(PDO::FETCH_OBJ)) {
									$emlak_no = $veri->emlakno;
									$ilan_resim = $vt->query("SELECT * FROM emlak_resim WHERE emlakno = '$emlak_no' and kapak = 1");
									$resim = $ilan_resim->fetch(PDO::FETCH_OBJ);
									$resim_ad = $resim->resimad;
									$baslik = $veri->baslik;
									$fiyat_liste = $veri->fiyat;
									$fiyat_kur = $veri->fiyatkur;
									$seo = $veri->seo;
									$ilan_id = $veri->id;
									?>
									<li style="" class="item">
										<div class="media p-5 mt-0">
											<a href="/<?=$seo;?>-ilan-<?=$ilan_id;?>">
												<img class=" mr-4" src="<?=RESIM;?>/<?php echo $resim_ad; ?>" alt="img">
											</a>
											<div class="media-body">
												<h4 class="mt-2 mb-1"><a href="/<?=$seo;?>-ilan-<?=$ilan_id;?>"><?php echo $baslik; ?></a></h4>
												<div class="h5 mb-0 font-weight-bold text-success mt-2"><?php echo $fiyat_liste; ?> <?php echo $fiyat_kur; ?></div>
											</div>
										</div>
									</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>


            
            
        </div>
    </div>
</section>
<section>
    <?php include("footer.php"); ?>
</section>
<?php include("alt.php"); ?>
</body>
<!-- Mirrored from www.spruko.com/demo/reallist/htm/Reallist-LTR/Html/ by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 05 Apr 2020 15:27:18 GMT -->
</html>