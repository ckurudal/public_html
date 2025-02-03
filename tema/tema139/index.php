 <?php  
    
    $do = $_GET["do"]; 

    $temaurl = $pdoAyar["tema_url"];

    if (file_exists("tema/{$temaurl}/{$do}.php")) {
        require_once "tema/{$temaurl}/{$do}.php";
    } else {
        require_once "home.php";
    } 

?>  
<!-- LIGHTBOX GALLERY -->
	<script src='https://cdn.rawgit.com/sachinchoolur/lightgallery.js/master/dist/js/lightgallery.js'></script>
	<script src='https://cdn.rawgit.com/sachinchoolur/lg-pager.js/master/dist/lg-pager.js'></script>
	<script src='https://cdn.rawgit.com/sachinchoolur/lg-autoplay.js/master/dist/lg-autoplay.js'></script>
	<script src='https://cdn.rawgit.com/sachinchoolur/lg-share.js/master/dist/lg-share.js'></script>
	<script src='https://cdn.rawgit.com/sachinchoolur/lg-fullscreen.js/master/dist/lg-fullscreen.js'></script>
	<script src='https://cdn.rawgit.com/sachinchoolur/lg-zoom.js/master/dist/lg-zoom.js'></script>
	<script src='https://cdn.rawgit.com/sachinchoolur/lg-hash.js/master/dist/lg-hash.js'></script>
	<script src='https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js'></script>
	<script  src="<?=TEMA_URL;?>/lightgallery-js/js/index.js"></script>
	
	
	
	
	
	<script type="text/javascript">
		$(document).ready(function() {

			$("#il").change(function() {

				var ilid = $(this).val();
				$.ajax({
					type:"POST",
					url:"index.php?do=ajax_harita_arama",
					data: {
					   "il": ilid
					},
					success: function(e) {
						$("#ilce").html(e);
					}
				});
			});

			$("#ilce").change(function() {

				var ilceid = $(this).val();
				$.ajax({
					type:"POST",
					url:"index.php?do=ajax_harita_arama",
					data: {
					   "ilce": ilceid
					},
					success: function(e) {
						$("#mahalle").html(e);
					}
				});
			});
		});
		
		
		$(document).ready(function() {

			$("#ilSidebar").change(function() {

				var ilid = $(this).val();
				$.ajax({
					type:"POST",
					url:"index.php?do=ajax_harita_arama_sidebar",
					data: {
					   "ilSidebar": ilid
					},
					success: function(e) {
						$("#ilceSidebar").html(e);
					}
				});
			});

			$("#ilceSidebar").change(function() {

				var ilceid = $(this).val();
				$.ajax({
					type:"POST",
					url:"index.php?do=ajax_harita_arama_sidebar",
					data: {
					   "ilceSidebar": ilceid
					},
					success: function(e) {
						$("#mahalleSidebar").html(e);
					}
				});
			});
		});	
		
		
	</script>