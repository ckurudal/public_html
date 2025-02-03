<style type="text/css">
	.alert {
		margin-bottom: inherit;
	}
</style>
<?php 
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
	
	uyeYasak(yetki());
	

	$islem =  @$_GET["islem"];
	$hareket =  @$_GET["hareket"];  
	$id =  @$_GET["id"];      

	$temalar = mysql_query("SELECT * FROM ayar_tema order by id DESC");
	$temalarid = mysql_query("SELECT * FROM ayar_tema where id = '$id'");

?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<i class="fa fa-edit"></i> Görünüm Ayarları
  <ol class="breadcrumb">
	<li><a href="index.php"><i class="fa fa-dashboard"></i> Anasayfa </a></li>
	<li> <a href="index.php?do=tumilanlar"> Tüm İlanlar </a> </li>
	<li class="active"> İlan Yönetimi </li>
  </ol>
</section>
<section class="content">
	<?php 
		if (isset($_POST["kaydet"])) {

			$katlimit = $_POST["katlimit"];
			$anasidebar = $_POST["anasidebar"];
			$katsidebar = $_POST["katsidebar"];
			$sayfasidebar = $_POST["sayfasidebar"];

			$kaydet = mysql_query("UPDATE ayar_tema SET katlimit = '$katlimit', anasidebar = '$anasidebar', katsidebar = '$katsidebar', sayfasidebar = '$sayfasidebar' where id = '$id'");

			go("index.php?do=ayar/gorunumayar&id=$id&hareket=onay",0);


		} 
	?>
</section>
<section class="content" style="margin-top:15px;">
	<div class="row" style="margin:0;">
		<div class="col-md-9">  
			<form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
				<?php 

					if ($hareket == "onay") {
						onay();
					} 

				?>  

					<div class="row">
						<div class="col-md-3">					    		
							<div class="box">
								<div class="box-body">							
									<ul class="nav nav-pil ls">
								      <li class="active"><a href="#anasayfa" data-toggle="tab" aria-expanded="false"><i class="fa fa-caret-right"></i> Anasayfa</a></li>							      
								      <li class=""><a href="#kategori" data-toggle="tab" aria-expanded="true"><i class="fa fa-caret-right"></i> Kategori Sayfası</a></li>      
								      <li class=""><a href="#arkaplan" data-toggle="tab" aria-expanded="true"><i class="fa fa-caret-right"></i> Site Arkaplan</a></li>      
								      <li class=""><a href="#header" data-toggle="tab" aria-expanded="true"><i class="fa fa-caret-right"></i> Header Arkaplan</a></li>    
								      <li class=""><a href="#header" data-toggle="tab" aria-expanded="true"><i class="fa fa-caret-right"></i> Blog Sayfası</a></li>    
								      <li class=""><a href="#header" data-toggle="tab" aria-expanded="true"><i class="fa fa-caret-right"></i> Haber Sayfası</a></li>    
								      <li class=""><a href="#sayfa" data-toggle="tab" aria-expanded="true"><i class="fa fa-caret-right"></i> Sayfa Ayarları</a></li>    								      
								      <li class=""><a href="#header" data-toggle="tab" aria-expanded="true"><i class="fa fa-caret-right"></i> İlan Detay Sayfası</a></li>    
								    </ul>
						    	</div>
							</div>	
						</div>
					    <div class="col-md-9">					    		
							<div class="box">
							<!-- /.box-header -->
								<div class="box-body" style="padding: 0 10px;">						
								<div class="form-horizontal"> 		
									<div class="tab-content">
										<div class="tab-pane active" id="anasayfa"> 
											<div class="form-group">								
												<div class="alert alert-warning">
													<i class="fa fa-list"></i> <span><strong>Anasayfa</strong> Ayarları</span>
												</div>
											</div>
											<div class="form-group">
											  <label class="col-sm-3 control-label">Kenar Çubuğu:</label>
											  <div class="col-sm-4">  
												<label for="anasidebar">
												  <input type="radio" <?php if ($tema["anasidebar"] == 0) {echo 'checked="checked"';} ?> name="anasidebar" value="0" class="minimal">
												  Solda
												</label>
												<label for="anasidebar">
												  <input type="radio" <?php if ($tema["anasidebar"] == 1) {echo 'checked="checked"';} ?> name="anasidebar" value="1" class="minimal">
												  Sağda
												</label>
											  </div> 
											</div> 
											<hr>
											<div class="form-group">
											  <label class="col-sm-3 control-label">Vitrin İlanları :</label>
											  <div class="col-sm-4">  
												<label for="anasid ebar">
												  <input type="radio" <?php if ($tema["anasidebar"] == 0) {echo 'checked="checked"';} ?> name="anasi debar" value="0" class="minimal">
												  Göster
												</label>
												<label for="anasid ebar">
												  <input type="radio" <?php if ($tema["anasidebar"] == 1) {echo 'checked="checked"';} ?> name="anas idebar" value="1" class="minimal">
												  Gizle
												</label>
											  </div> 
											</div>  
											<div class="form-group">
											  <label class="col-sm-3 control-label">Vitrin İlan Limiti:</label>
											  <div class="col-sm-2">
												</label> 
												  <input type="text" name="anasi debar" value="0" class="form-control">
											  </div> 
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label">Vitrin İlan Görünüm:</label>
												<div class="col-md-9">
													<label for="gorunum">
													  <input type="radio" name="gorunum" <?php if ($row["gorunum"] == 4) { ?> checked <?php } ?> value="4" class="minimal">
													  <span class="btn btn-default btn-xs"><i class="fa fa-table"></i> Tablo 4 'lü</span>
													</label>
													<label for="gorunum">
													  <input type="radio" name="gorunum" <?php if ($row["gorunum"] == 3) { ?> checked <?php } ?> value="3" class="minimal">
													  <span class="btn btn-default btn-xs"><i class="fa fa-th"></i> Tablo 3 'lü</span>
													</label>
													<label for="gorunum">
													  <input type="radio" name="gorunum" <?php if ($row["gorunum"] == 2) { ?> checked <?php } ?> value="2" class="minimal">
													  <span class="btn btn-default btn-xs"><i class="fa fa-th-large"></i> Tablo 2 'lü</span>
													</label> 
												</div>
											  </div> 
											<hr>
											<div class="form-group">
											  <label class="col-sm-3 control-label">Acil İlanları :</label>
											  <div class="col-sm-4">  
												<label for="anasid ebar">
												  <input type="radio" <?php if ($tema["anasidebar"] == 0) {echo 'checked="checked"';} ?> name="anas idebar" value="0" class="minimal">
												  Göster
												</label>
												<label for="anasid ebar">
												  <input type="radio" <?php if ($tema["anasidebar"] == 1) {echo 'checked="checked"';} ?> name="anasi debar" value="1" class="minimal">
												  Gizle
												</label>
											  </div> 
											</div> 
											<div class="form-group">
											  <label class="col-sm-3 control-label">Acil İlan Limiti:</label>
											  <div class="col-sm-2">
												</label> 
												  <input type="text" name="anas debar" value="0" class="form-control">
											  </div> 
											</div> 
											<div class="form-group">
												<label class="col-sm-3 control-label">Acil İlan Görünüm:</label>
												<div class="col-md-9">
													<label for="gorunum">
													  <input type="radio" name="gorunum" <?php if ($row["gorunum"] == 4) { ?> checked <?php } ?> value="4" class="minimal">
													  <span class="btn btn-default btn-xs"><i class="fa fa-table"></i> Tablo 4 'lü</span>
													</label>
													<label for="gorunum">
													  <input type="radio" name="gorunum" <?php if ($row["gorunum"] == 3) { ?> checked <?php } ?> value="3" class="minimal">
													  <span class="btn btn-default btn-xs"><i class="fa fa-th"></i> Tablo 3 'lü</span>
													</label>
													<label for="gorunum">
													  <input type="radio" name="gorunum" <?php if ($row["gorunum"] == 2) { ?> checked <?php } ?> value="2" class="minimal">
													  <span class="btn btn-default btn-xs"><i class="fa fa-th-large"></i> Tablo 2 'lü</span>
													</label> 
												</div>
											  </div> 
											<hr>
										</div>
										<div class="tab-pane" id="kategori"> 
											<div class="form-group">								
												<div class="alert alert-warning">
													<i class="fa fa-list"></i> <span><strong>Kategori</strong> Sayfası Ayarları</span>
												</div>
											</div>
											<div class="form-group">
											  <label class="col-sm-3 control-label">Kenar Çubuğu:</label>
											  <div class="col-sm-4">  
												<label for="katsidebar">
												  <input type="radio" <?php if ($tema["katsidebar"] == 0) {echo 'checked="checked"';} ?> name="katsidebar" value="0" class="minimal">
												  Solda
												</label>
												<label for="katsidebar">
												  <input type="radio" <?php if ($tema["katsidebar"] == 1) {echo 'checked="checked"';} ?> name="katsidebar" value="1" class="minimal">
												  Sağda
												</label>
											  </div>  
											 </div>  
											<div class="form-group">
											  <label class="col-sm-3 control-label">Kategori İlan Limiti:</label>
											  <div class="col-sm-2"> 
													<input type="text" name="katlimit" class="form-control" value="<?=$tema["katlimit"];?>">
											  </div>
											  <div class="col-sm-6"> 
													<h6>Her sayfada gösterilecek ilan sayısı</h6>
											  </div>
											</div> 
										</div>
										<div class="tab-pane" id="arkaplan">
											<div class="form-group">								
												<div class="alert alert-warning">
													<i class="fa fa-list"></i> <span>Site <strong>Arkaplan</strong> Ayarları</span>
												</div>
											</div> 
											<div class="form-group">
											  <label class="col-sm-3 control-label">Arkaplan Tipi:</label>
											  <div class="col-sm-4">  
												<label for="gorunum">
												  <input type="radio" name="gorunum" value="4" class="minimal">
												  Resim
												</label>
												<label for="gorunum">
												  <input type="radio" name="gorunum" value="3" class="minimal">
												  Renk
												</label>
											  </div> 
											</div> 
											<div class="form-group">
											  <label class="col-sm-3 control-label">Arkaplan Resmi Seç:</label>
											  <div class="col-sm-8">  
												<label for="gorunum">
												  <input type="radio" name="gorunum" value="4" class="minimal">
												  <img src="http://localhost/tema/tema131/images/bg.jpg" width="100" height="100">
												</label>
												<label for="gorunum">
												  <input type="radio" name="gorunum" value="4" class="minimal">
												  <img src="http://demo4.hazir-emlaksiteleri.com/images/bg4.jpg" width="100" height="100">
												</label>
												<label for="gorunum">
												  <input type="radio" name="gorunum" value="4" class="minimal">
												  <img src="http://demo21.hazir-emlaksiteleri.com/images/bgh-min.jpg" width="100" height="100">
												</label>
												<label for="gorunum">
												  <input type="radio" name="gorunum" value="4" class="minimal">
												  <img src="http://localhost/tema/tema131/images/bg.jpg" width="100" height="100">
												</label>
												<label for="gorunum">
												  <input type="radio" name="gorunum" value="4" class="minimal">
												  <img src="http://demo4.hazir-emlaksiteleri.com/images/bg4.jpg" width="100" height="100">
												</label>
												<label for="gorunum">
												  <input type="radio" name="gorunum" value="4" class="minimal">
												  <img src="http://demo21.hazir-emlaksiteleri.com/images/bgh-min.jpg" width="100" height="100">
												</label>
												<label for="gorunum">
												  <input type="radio" name="gorunum" value="4" class="minimal">
												  <img src="http://localhost/tema/tema131/images/bg.jpg" width="100" height="100">
												</label>
												<label for="gorunum">
												  <input type="radio" name="gorunum" value="4" class="minimal">
												  <img src="http://demo4.hazir-emlaksiteleri.com/images/bg4.jpg" width="100" height="100">
												</label> 
											  </div> 
											</div>
											<div class="form-group">
											  <label class="col-sm-3 control-label">Yeni Arkaplan Yükle:</label>
											  <div class="col-sm-4"> 
													<input type="file" name="katlimit" class="form-control" value="<?=$tema["katlimit"];?>">
											  </div> 
											</div> 
											<div class="form-group">
											  <label class="col-sm-3 control-label">Arkaplan Rengi:</label>
											  <div class="col-sm-2"> 
												<div class="input-group my-colorpicker2 colorpicker-element">
								                  <input type="text" name="yazirenk" class="form-control" value="<?=$d["yazirenk"];?>" placeholder="Renk Seçiniz">

								                  <div class="input-group-addon">
								                    <i style="background-color: rgb(139, 38, 38);"></i>
								                  </div>
								                </div>
											  </div>
											</div>	
										</div>
										<div class="tab-pane" id="header"> 																			
											<div class="form-group">								
												<div class="alert alert-warning">
													<i class="fa fa-list"></i> <span><strong>Header</strong> Arkaplan Ayarları</span>
												</div>
											</div> 
											<div class="form-group">
											  <label class="col-sm-3 control-label">Header Arkaplan Tipi:</label>
											  <div class="col-sm-4">  
												<label for="gorunum">
												  <input type="radio" name="gorunum" value="4" class="minimal">
												  Resim
												</label>
												<label for="gorunum">
												  <input type="radio" name="gorunum" value="3" class="minimal">
												  Renk
												</label>
											  </div> 
											</div> 
											<div class="form-group">
											  <label class="col-sm-3 control-label">Arkaplan Resmi Seç:</label>
											  <div class="col-sm-8">  
												<label for="gorunum">
												  <input type="radio" name="gorunum" value="4" class="minimal">
												  <img src="http://localhost/tema/tema131/images/bg.jpg" width="100" height="100">
												</label>
												<label for="gorunum">
												  <input type="radio" name="gorunum" value="4" class="minimal">
												  <img src="http://demo4.hazir-emlaksiteleri.com/images/bg4.jpg" width="100" height="100">
												</label>
												<label for="gorunum">
												  <input type="radio" name="gorunum" value="4" class="minimal">
												  <img src="http://demo21.hazir-emlaksiteleri.com/images/bgh-min.jpg" width="100" height="100">
												</label>
												<label for="gorunum">
												  <input type="radio" name="gorunum" value="4" class="minimal">
												  <img src="http://localhost/tema/tema131/images/bg.jpg" width="100" height="100">
												</label>
												<label for="gorunum">
												  <input type="radio" name="gorunum" value="4" class="minimal">
												  <img src="http://demo4.hazir-emlaksiteleri.com/images/bg4.jpg" width="100" height="100">
												</label>
												<label for="gorunum">
												  <input type="radio" name="gorunum" value="4" class="minimal">
												  <img src="http://demo21.hazir-emlaksiteleri.com/images/bgh-min.jpg" width="100" height="100">
												</label>
												<label for="gorunum">
												  <input type="radio" name="gorunum" value="4" class="minimal">
												  <img src="http://localhost/tema/tema131/images/bg.jpg" width="100" height="100">
												</label>
												<label for="gorunum">
												  <input type="radio" name="gorunum" value="4" class="minimal">
												  <img src="http://demo4.hazir-emlaksiteleri.com/images/bg4.jpg" width="100" height="100">
												</label> 
											  </div> 
											</div>
											<div class="form-group">
											  <label class="col-sm-3 control-label">Yeni Arkaplan Yükle:</label>
											  <div class="col-sm-4"> 
													<input type="file" name="katlimit" class="form-control" value="<?=$tema["katlimit"];?>">
											  </div> 
											</div> 
											<div class="form-group">
											  <label class="col-sm-3 control-label">Arkaplan Rengi:</label>
											  <div class="col-sm-2"> 
												<div class="input-group my-colorpicker2 colorpicker-element">
								                  <input type="text" name="yazirenk" class="form-control" value="<?=$d["yazirenk"];?>" placeholder="Renk Seçiniz">

								                  <div class="input-group-addon">
								                    <i style="background-color: rgb(139, 38, 38);"></i>
								                  </div>
								                </div>
											  </div>
											</div> 
										</div>
										<div class="tab-pane" id="sayfa"> 															
											<div class="form-group">								
												<div class="alert alert-warning">
													<i class="fa fa-list"></i> <span><strong>Sayfa</strong> Ayarları</span>
												</div>
											</div> 
											<div class="form-group">
											  <label class="col-sm-3 control-label">Kenar Çubuğu:</label>
											  <div class="col-sm-9">  
												<label for="sayfasidebar">
												  <input type="radio" name="sayfasidebar" <?php if ($tema["sayfasidebar"] == 0) {echo 'checked="checked"';} ?>  value="0" class="minimal">
												  Solda
												</label>
												<label for="sayfasidebar">
												  <input type="radio" name="sayfasidebar" <?php if ($tema["sayfasidebar"] == 1) {echo 'checked="checked"';} ?>  value="1" class="minimal">
												  Sağda
												</label>
												<label for="sayfasidebar">
												  <input type="radio" name="sayfasidebar" <?php if ($tema["sayfasidebar"] == 2) {echo 'checked="checked"';} ?>  value="2" class="minimal">
												  Kenarlıksız
												</label>
											  </div> 
											</div> 
										</div>
									</div>
								</div>
					    	</div>
							<div class="box-footer">						
								<button type="submit" name="kaydet" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Kaydet </button>
							</div>
					    </div>
						</div>
				</div>
			</form>
		</div>
		<div class="col-md-3">
			<div class="box"> 
				<div class="form-horizontal">  
					<div class="form-group">					  
				  		<h4><span class="btn btn-default btn-block" style="text-transform: uppercase;"><strong>Aktif Tema: [ <?=$tema["temaadi"];?> ]</strong></span></h4>							  		
				  		<div class="aktiftema">
				  			<div class="sec">
								<div class="temalist">												
									<img class="img-thumbnail" src="<?=$tema["resim"];?>"/>
								</div> 
							</div>
				  		</div> 
				  		<h4><a href="index.php?do=ayar/temaayar"> <span class="btn btn-danger btn-block"><i class="fa fa-code"></i> Temayı Değiştir </span></a></h4>							  		
				  		<h4><a href="/index.php" target="_blank"> <span class="btn btn-primary btn-block"><i class="fa fa-eye"></i> Siteyi Göster </span></a></h4>
					</div> 
				</div>
			</div>
		</div>
	</div>
</section>