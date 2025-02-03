<?php

	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
	$tip = @$_GET["tip"];

?>

<section class="content-header">

		<i class="fa fa-credit-card fa-2x pull-left"></i>

		<?php if ($tip == "magaza") { ?> Mağaza Paketi Siparişleri <?php } ?>
		<?php if ($tip == "doping") { ?> İlan Doping Siparişleri <?php } ?>
		<!-- <?php if ($tip == "danisman") { ?> Danışman Dopingi Siparişleri <?php } ?>	-->
		<?php if ($tip == "") { ?> Yeni Sipariş Ekle <?php } ?>

		<p> <small> Sipariş Yönetimi </small> </p>

</section>

<?php	if ($islem == "onay") { ?>
	<section class="content">
		<?php onay(); ?>
	</section>
<?php } ?>

<section class="content">
	<?php if ($tip != "") { ?>
	<div class="row">

     	<div class="col-md-6">

            <a href="index.php?do=siparisler/siparisler" class="btn btn-lg bt-xs btn-warning">
                <i class="fa fa-chevron-right"></i> Sipariş Ekle
            </a>

     	</div>
     	<div class="col-md-6 text-right hidden-xs">

            <a href="index.php?do=siparisler/siparisler&tip=magaza" class="btn btn-lg bt-xs btn-info">
                <i class="fa fa-chevron-right"></i> Mağaza Paketi Siparişleri
            </a>
            <a href="index.php?do=siparisler/siparisler&tip=doping" class="btn btn-lg bt-xs btn-info">
                <i class="fa fa-chevron-right"></i> İlan Doping Siparişleri
            </a>
            <!--
            <a href="index.php?do=siparisler/siparisler&tip=danisman" class="btn btn-lg bt-xs btn-info">
                <i class="fa fa-chevron-right"></i> Danışman Doping Siparişleri
            </a>
          -->

     	</div>
	</div>
	<?php } ?>

	<?php if ($tip == "") { include ("siparis_ekle.php"); } ?>
	<?php if ($tip == "magaza") { include ("siparis_magaza.php"); } ?>
	<?php if ($tip == "doping") { include ("siparis_doping.php"); } ?>
	<?php if ($tip == "danisman") { include ("siparis_danisman.php"); } ?>

</section>

<style media="screen">
	.control-label {
		padding-top: 15px !important;
	}
</style>


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
