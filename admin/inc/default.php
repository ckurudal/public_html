<?php echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; ?>
<div class="wrapper"> 
  <?php include('inc/header.php'); ?>
  <!-- Left side column. contains the logo and sidebar -->
  
  <?php
  	if ($kullanici["yetki"] != 0) {
  		include('inc/left-menu-uye.php');
  	} else if ($kullanici["yetki"] == 0) {
  		include('inc/left-menu-yonetici.php');

  	}
  ?>  


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
	
	<?php 
		
		$do = g("do");
		
		if (file_exists("inc/{$do}.php")) {
			require_once "inc/{$do}.php";
		} else {
			if ($kullanici["yetki"] != 0) {
				require_once "inc/uye-ana-sayfa.php";
			} else if ($kullanici["yetki"] == 0) {
				require_once "inc/genel-bakis.php";

			}
			
		}	 
		
	?>	
  </div> 
 <?php if(yetki() != 0): ?>
<?php  include('footer.php'); ?>
<?php endif; ?>
</div> 