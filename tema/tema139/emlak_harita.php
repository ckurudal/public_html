<!-- YAZILIM KOBI EMLAK SCRIPTI V9 -->
<?php
$goster 				= 	$_GET["goster"];
$kat_seo	 			= 	$_GET["kat_seo"];
$ilan_gosterim			= 	$ayar["kategori_ilan_adet"];
$kat_ilan_kategori		= 	explode("/", $kat_seo);
$kat_ilan_sekli			= 	array_filter(explode("-ilanlari", $kat_seo));
$kat_ilan_tipi_sekli	= 	array_filter(explode("-ilanlari", $kat_ilan_kategori[1]));
$kat_tip_sekil 			= 	explode("/", $kat_seo);
$ilan_tipi 				= 	$vt->query("SELECT * FROM emlak_ilantipi WHERE seo = '$kat_seo'")->fetch();
$ilan_tip_sekil 		= 	$vt->query("SELECT * FROM emlak_ilantipi WHERE seo = '".$kat_tip_sekil[0]."'")->fetch();
$ilan_sekli				= 	$vt->query("SELECT * FROM emlak_ilansekli WHERE seo = '".$kat_ilan_sekli[0]."'")->fetch();
$tip_sekil 				= 	$vt->query("SELECT * FROM emlak_ilansekli WHERE seo = '".$kat_ilan_tipi_sekli[0]."'")->fetch();
$kategori 				= 	$vt->query("SELECT * FROM emlak_kategori WHERE seo = '".$kat_ilan_kategori[1]."'")->fetch();
$kategori_ilantipi		= 	$vt->query("SELECT * FROM emlak_ilantipi WHERE seo = '".$kat_ilan_kategori[0]."'")->fetch();
$reklam 				= 	$vt->query("SELECT * FROM reklam where id = 1")->fetch();
$bugun                  =   date("Y-m-d");
?>
<!doctype html>
<html class="no-js" lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- set the page title -->
    <title>
        <?=$ayar["site_adi"];?>
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
    <!--
        Set your own API-key. Testing key is not valid for other web-sites and services.
        Get your API-key on the Developer Dashboard: https://developer.tech.yandex.ru/keys/
    -->
    <script src="https://api-maps.yandex.ru/2.1/?lang=tr_TR&amp;apikey=bb6cd8e6-99ec-4495-8f64-92e4ece2d2ac" type="text/javascript"></script>
    <script src="placemark.js" type="text/javascript"></script>
</head>
<body>
<?php include('ust.php'); ?>
<section class="mt-8 mb-8">
    <div class="container-fluid">
        <div class="page-header bg-transparent pt-2 pb-2">
            <div class="float-left d-none">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home fa-2x" style="margin-top:-5px; color:#767676;"></i></a></li>
                    <li class="breadcrumb-item"><a href="kategori/<?php echo $kat_tip_sekil[0]; ?>"><?php echo $kat_tip_sekil[0]; ?></a></li>
                    <li class="breadcrumb-item"><?php echo $kat_tip_sekil[1]; ?></li>
                </ol>
            </div>
        </div>
        <div class="row flex-row-reverse">
            <div class="col-xl-3 col-lg-3 col-md-12">
                <?php include('blok-hizliara.php'); ?>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-12">
				<style>
					html, body, #map {
						width: 100%; height: 768px; padding: 0; margin: 0;
					}
				</style>
				<script>
					ymaps.ready(init);

					function init() {
						var myMap = new ymaps.Map("map", {
							center: [38.47079371120379, 35.606689453125],
							zoom: 6
						}, {
							searchControlProvider: 'yandex#search'
						}),

						// Creating a geo object with the "Point" geometry type.
							myGeoObject = new ymaps.GeoObject({
								// The geometry description.
								geometry: {
									type: "Point",
									coordinates: [55.8, 37.8]
								},
								// Properties.
								properties: {
									// The placemark content.
									iconContent: 'I\'m draggable',
									hintContent: 'Come on, drag already!'
								}
							}, {
								/**
								 * Options.
								 * The placemark's icon will stretch to fit its contents.
								 */
								preset: 'islands#blackStretchyIcon',
								// The placemark can be dragged.
								draggable: true
							}),
							myPieChart = new ymaps.Placemark([
								55.847, 37.6
							], {
								// Data for generating a diagram.
								data: [
									{weight: 8, color: '#0E4779'},
									{weight: 6, color: '#1E98FF'},
									{weight: 4, color: '#82CDFF'}
								],
								iconCaption: "Diagram"
							}, {
								// Defining a custom placemark layout.
								iconLayout: 'default#pieChart',
								// Radius of the diagram, in pixels.
								iconPieChartRadius: 30,
								// The radius of the central part of the layout.
								iconPieChartCoreRadius: 10,
								// Fill style for the core.
								iconPieChartCoreFillStyle: '#ffffff',
								// The style for lines between sectors and the outline of the diagram.
								iconPieChartStrokeStyle: '#ffffff',
								// Width of the sector dividing lines and diagram outline.
								iconPieChartStrokeWidth: 3,
								// Maximum width of the placemark caption.
								iconPieChartCaptionMaxWidth: 200
							});

						myMap.geoObjects
							.add(myGeoObject)
							.add(myPieChart)
							.add(new ymaps.Placemark([41.0813357, 31.1096905],  {
								balloonContent: 'the color of <strong>the water on Bondi Beach</strong>'
							}, {
								preset: 'islands#icon',
								iconColor: '#0095b6'
							}))
							.add(new ymaps.Placemark([55.833436, 37.715175], {
								balloonContent: '<strong>greyish-brownish-maroon</strong> color'
							}, {
								preset: 'islands#dotIcon',
								iconColor: '#735184'
							}));
					}
				</script>
				
				<div id="map"></div>
				
            </div>
            <!--/Right Side Content-->
        </div>
    </div>
</section>
<section>
    <?php include("footer.php"); ?>
</section>
<?php include("alt.php"); ?>
</body>
</html>