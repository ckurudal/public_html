<?php
	error_reporting(0);
	$temagetir = $_GET["temagetir"];
	$temagetir = stripslashes(strip_tags(htmlspecialchars($temagetir, ENT_QUOTES, 'UTF-8')));
	$temagetir = str_replace(array('..', '/', '\\'), '', $temagetir);
	$temagetir = trim($temagetir);
	include('sistem/baglan.php'); 
	include('sistem/sistem.php'); 
	if ($ayar['site_durum'] == 1) {
		if ($temagetir) {
			@define("TEMA_URL", rtrim($ayar["site_url"], '/')."/tema/".$temagetir); 
			@define("TEMA", PATH."/tema/".$temagetir);
			$ayartemaVt=$vt->query("SELECT * FROM ayar_tema where temaurl = '".$temagetir."'");
			if ($ayartemaVt->rowCount() > 0)
			{
				$ayarlartema	= $vt->query("UPDATE ayarlar SET tema_url = '".$temagetir."', site_tema = '".$temagetir."' where id = 1");
				$temaduzen 		= $vt->query("UPDATE ayar_tema SET aktif = 0 where aktif = 1");
				$temaduzengetir = $vt->query("UPDATE ayar_tema SET aktif = 1 where temaurl = '".$temagetir."'");?>
				<style>
						body {
							margin:0 !important;  
							overflow: hidden;
							margin-top: -20px !important;
						}
						.nav>li>a:hover {
							color: initial !important;
						}
						.nav>li>a {
							text-transform: uppercase;
						}
						.btn-default:hover, .btn:hover {
							color: #fff !important;
						}
					</style>	
  					<meta charset="utf-8">
					  <meta http-equiv="X-UA-Compatible" content="IE=edge">
					  <title> <?php echo $ayar['site_adi']; ?> </title>
					  <!-- Tell the browser to be responsive to screen width -->
					  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
					  <!-- Bootstrap 3.3.7 -->
					  <link rel="stylesheet" href="admin/bower_components/bootstrap/dist/css/bootstrap.min.css">
					  <!-- Font Awesome -->
					  <link rel="stylesheet" href="admin/bower_components/font-awesome/css/font-awesome.min.css">
					  <!-- Ionicons -->
					  <link rel="stylesheet" href="admin/bower_components/Ionicons/css/ionicons.min.css">
					  <!-- daterange picker -->
					  <link rel="stylesheet" href="admin/bower_components/bootstrap-daterangepicker/daterangepicker.css">
					  <!-- bootstrap datepicker -->
					  <link rel="stylesheet" href="admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
					  <!-- iCheck for checkboxes and radio inputs -->
					  <link rel="stylesheet" href="plugins/iCheck/all.css">
					  <!-- Bootstrap Color Picker -->
					  <link rel="stylesheet" href="admin/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
					  <!-- Bootstrap time Picker -->
					  <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
					  <!-- Select2 -->
					  <link rel="stylesheet" href="admin/bower_components/select2/dist/css/select2.min.css">
					  <!-- Theme style -->
					  <link rel="stylesheet" href="dist/css/AdminLTE.min.css"> 
					  <!-- AdminLTE Skins. Choose a skin from the css/skins
					       folder instead of downloading all of them to reduce the load. -->
					  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
					  <!-- plupload css -->
					  <link rel="stylesheet" href="plugins/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css" type="text/css" media="screen" />
					  <link href="https://fonts.googleapis.com/css?family=Titillium+Web:200,200i,300,300i,400,400i,600,600i,700,700i,900" rel="stylesheet">
					  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
					  <link rel="stylesheet" href="admin/bower_components/froalaeditor/css/froala_editor.css"> 
					  <link rel="stylesheet" href="admin/bower_components/froalaeditor/css/plugins/code_view.css"> 
					  <link rel="stylesheet" href="admin/bower_components/froalaeditor/css/plugins/video.css"> 
					  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>  
					  <!-- Data Table -->
					  <link rel="stylesheet" href="admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> 
					  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
					  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
					  <!--[if lt IE 9]>
					  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
					  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
					  <![endif]-->
					  <!-- Google Font -->
					  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
					  <!-- Global site tag (gtag.js) - Google Analytics -->
					<script async src="https://www.googletagmanager.com/gtag/js?id=UA-100549436-1"></script>
					<!-- Global site tag (gtag.js) - Google Analytics -->
					<script async src="https://www.googletagmanager.com/gtag/js?id=UA-100549436-1"></script>
					<?php $adtema=$vt->query("SELECT * FROM ayar_tema where temaurl = '".$temagetir."'")->fetch(); ?>
					<div style="background: #333; color: #fff; line-height: 65px; height: 65px; padding: 13px 0;" class="hidden-xs">  
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-6">
									<ul class="nav nav-pills">
			                            <li class="dropdown">
						                    <a href="#" target="_blank" class="dropdown-toggle btn btn-primary" style="padding:8px 15px;" data-toggle="dropdown">
						                        <strong>Seçili Tema: <span class="label label-danger"><?=$adtema["temaadi"];?></span></strong>
						                    </a> 
						                </li> 
			                            <li class="dropdown">
						                    <a href="https://wa.me/905339754681" target="_blank" class="dropdown-toggle btn btn-danger" style="padding:8px 15px;">
						                        <i class="fa fa-arrow-right"></i> Satın Al
						                    </a> 
						                </li> 
			                            <li class="dropdown">
						                    <a href="index.php?do=bildirimler" class="dropdown-toggle btn btn-default" style="padding:8px 15px;" data-toggle="dropdown">
						                         <i class="fa fa-desktop"></i> Emlak Teması Seçiniz <i class="fa fa-angle-down"></i>
						                    </a>
						                    <ul class="dropdown-menu" role="menu" style="max-height: 500px; overflow: auto;">
						                    	<?php 
						                    		$temacek = $vt->query("SELECT * FROM ayar_tema order by id", PDO::FETCH_ASSOC);
						                    		foreach($temacek as $t){
						                    	?>
						                        <li>
						                            <a href="index.php?temagetir=<?=$t["temaurl"];?>">
						                                <img style="background: #000; padding:15px; " src="<?=$t["resim"];?>" width="300"> 
						                                <br>
						                                <p class="btn btn-success btn-block"><?=$t["temaadi"];?></p>
						                            </a>
						                        </li>
						                        <?php } ?> 
						                    </ul>
						                </li>  
						            </ul>
								</div>
								<div class="col-md-6">
									<ul class="nav nav-pills navbar-right" style="padding-right: 15px;">
			                            <li class="dropdown">
						                    <a href="/admin" target="_blank" class="dropdown-toggle btn btn-primary" style="padding:8px 15px;">
						                        <i class="fa fa-send"></i> Yönetim Paneli Demosu
						                    </a>
						                </li>  
			                            <li class="dropdown">
						                    <a href="/index.php" target="_blank" class="dropdown-toggle btn btn-danger" style="padding:8px 15px;" data-toggle="dropdown">
						                        <i class="fa fa-list"></i> Yazılım Kobi Emlak Scripti
						                    </a> 
						                </li> 
			                            <li class="dropdown">
						                    <a href="/index.php" class="dropdown-toggle btn" style="padding:8px 15px; color:#fff;">
						                        <i class="fa fa-close"></i> Çerçeveyi Kaldır
						                    </a>
						                </li>  
						            </ul>
								</div>
							</div>
						</div>
					</div>
					<iframe src="<?=URL;?>" style="width: 100%; height: 97%; border: 0; padding: 0;">
					</iframe>
					<!-- jQuery 3 -->
					<script src="admin/bower_components/jquery/dist/jquery.min.js"></script>
					<!-- production -->
					<script type="text/javascript" src="plugins/plupload/js/plupload.full.min.js"></script>
					<script type="text/javascript" src="plugins/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
					<script type="text/javascript" src="plugins/plupload/js/i18n/tr.js"></script>
					<!-- Bootstrap 3.3.7 -->
					<script src="admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
					<!-- Select2 -->
					<script src="admin/bower_components/select2/dist/js/select2.full.min.js"></script>
					<!-- InputMask -->
					<script src="plugins/input-mask/jquery.inputmask.js"></script>
					<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
					<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
					<!-- date-range-picker -->
					<script src="admin/bower_components/moment/min/moment.min.js"></script>
					<script src="admin/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
					<!-- Data Tables -->
					<script src="admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
					<script src="admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
					<!-- bootstrap datepicker -->
					<script src="admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
					<!-- bootstrap color picker -->
					<script src="admin/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
					<!-- bootstrap time picker -->
					<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
					<!-- SlimScroll -->
					<script src="admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
					<!-- iCheck 1.0.1 -->
					<script src="plugins/iCheck/icheck.min.js"></script>
					<!-- FastClick -->
					<script src="admin/bower_components/fastclick/lib/fastclick.js"></script>
					<!-- AdminLTE App -->
					<script src="dist/js/adminlte.min.js"></script>
					<!-- AdminLTE for demo purposes -->
					<script src="dist/js/demo.js"></script>
					<!-- CK Editor -->
					<script src="admin/bower_components/ckeditor/ckeditor.js"></script>   
				  <script type="text/javascript" src="admin/bower_components/froalaeditor/js/froala_editor.min.js"></script> 
				  <script type="text/javascript" src="admin/bower_components/froalaeditor/js/plugins/code_view.min.js"></script> 
				  <script type="text/javascript" src="admin/bower_components/froalaeditor/js/plugins/video.min.js"></script> 
				  <script type="text/javascript" src="admin/bower_components/froalaeditor/js/languages/tr.js"></script> 
			<?php
						}
							else
						{
							// Site Acik
							require(TEMA.'/index.php'); 
						}
					} 
						else 
					{
						@define("TEMA_URL", $ayar["site_url"]."/tema/".$ayar["tema_url"]); 
						@define("TEMA", PATH."/tema/".$ayar["tema_url"]);
						// Site Acik
						require(TEMA.'/index.php');
					}
				} else {
					// Site Kapali
					echo $ayar['kapali_mesaj'];
				}
			?>