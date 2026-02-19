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
<style type="text/css">
	.card {
		margin-bottom: 0 !important;
	}
</style>

<?php include('ust.php'); ?>

<section class="sptb mt-7">
    <div class="container">
        <div class="row">
            <!--Right Side Content-->
            <div class="col-xl-3 col-lg-4 col-md-12"> 
            	<?php 
            		$tek = $_GET[$io["id"]];
            		echo $mintoplu;     
            		echo $io["id"];       		
            	?>
                <?php include('blok-hizliara.php'); ?>      

            </div>
            <!--/Right Side Content-->
            <div class="col-xl-9 col-lg-8 col-md-12">
                <!--Add lists-->
                <div class=" mb-lg-0"> 
                    <div class="">
                        <div class="item2-gl"> 

							<div class="mb-1">

			                    <div class="">

			                        <div class="p-2 pl-5 bg-white item2-gl-nav d-flex">										
										
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

			                        <div class="p-2 pl-5 bg-white item2-gl-nav d-flex mt-2 pt-4 pb-4">

			                        	<a href="/ilanara/" class="btn btn-sm btn-dark mr-3 pl-3 pr-3">Filtreyi temizle <i class="fa fa-close"></i></a>

										<div class="pt-1">
											
											<?php if ($GET_il != ""): ?>
			                            
				                            	<span> <strong class="mr-2">İl</strong> <span class="badge badge-light"> <strong><?php echo $il_getir->adi; ?></strong> </span> </span>
				                        	
				                        	<?php endif; ?>


											
											<?php if ($GET_ilce != ""): ?>
				                            
				                            	<span> <strong class="mr-2 ml-2">İlçe</strong> <span class="badge badge-light"> <strong><?php echo $ilce_getir->ilce_title; ?></strong> </span> </span>
				                        	
				                        	<?php endif; ?>


											
											<?php if ($GET_mahalle != ""): ?>
				                            
				                            	<span> <strong class="mr-2 ml-2">Mahalle</strong> <span class="badge badge-light"> <strong><?php echo $mahalle_getir->mahalle_title; ?></strong> </span> </span>
				                        	
				                        	<?php endif; ?>


											
											<?php if ($emlak_kategori_getir != ""): ?>
				                            
				                            	<span> <strong class="mr-2 ml-2">Kategori</strong> <span class="badge badge-light"> <strong><?php echo $emlak_kategori_getir->kat_adi; ?></strong> </span> </span>
				                        	
				                        	<?php endif; ?>


											
											<?php if ($emlak_tipi_getir != ""): ?>
				                            
				                            	<span> <strong class="mr-2 ml-2">Emlak Tipi</strong> <span class="badge badge-light"> <strong><?php echo $emlak_tipi_getir->ad; ?></strong> </span> </span>
				                        	
				                        	<?php endif; ?>


											
											<?php if ($emlak_sekli_getir != ""): ?>
				                            
				                            	<span> <strong class="mr-2 ml-2">Emlak Şekli</strong> <span class="badge badge-light"> <strong><?php echo $emlak_sekli_getir->baslik; ?></strong> </span> </span>
				                        	
				                        	<?php endif; ?>


											
											<?php if ($GET_minfiyat != "" || $GET_maxfiyat != ""): ?>
				                            
				                            	<span>

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

                            	<?php 

										if (isset($_GET["ilanara"])) {
											
										// emlak formlarina gore arama
			
										$stmt_ilanformara = $vt->query("SELECT * FROM emlak_form where arama = '1' order by sira asc");
										while($io = $stmt_ilanformara->fetch()) {

											$mintoplu = $_GET["mintoplu{$io['id']}"];
											$maxtoplu = $_GET["maxtoplu{$io['id']}"];
											$minmaxtoplu = $_GET["minmaxtoplu{$io['id']}"];

											$post = $_GET["{$io['id']}"];

											// min max sorgusu arama

											$minpost = $_GET["min{$io['id']}"];
											$maxpost = $_GET["max{$io['id']}"];
											$minmaxid = $_GET["minmaxid{$io['id']}"];

											if ($minpost != "" || $maxpost != "") {

												$stmt_emlaknover1 = $vt->prepare("SELECT * FROM emlak_ilandetay where seo BETWEEN ? AND ? AND formid = ?");
												$stmt_emlaknover1->execute([$minpost, $maxpost, $minmaxid]);
												while($emlaknover = $stmt_emlaknover1->fetch()) {
													if (is_numeric($emlaknover["seo"]))  {

														$stmt_emlakver = $vt->prepare("SELECT * FROM emlak_ilan where emlakno = ?");
														$stmt_emlakver->execute([$emlaknover["emlakno"]]);
														while($emlak = $stmt_emlakver->fetch()) { 

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
																<?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
																<div class="power-ribbon power-ribbon-top-left text-warning"><span class="bg-warning"><i class="fa fa-star"></i> </span></div>
																<?php endif; ?>
									                            <div class="d-md-flex">
									                                <div class="item-card9-img">		
																	
									                                    <div class="item-card9-imgs kategori-list-img">
									                                        <a target="_blank" href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"></a>
									                                        <?php if ($emlak_resim["emlakno"]) { ?>
									                                        <img src="uploads/resim/<?php echo $emlak_resim["resimad"] ?>" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
									                                    	<?php } else { ?>
									                                        <img src="uploads/resim/resim.png" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />			                                    		
									                                    	<?php } ?>
									                                    </div>
																		
									                                </div>
									                                <div class="card border-0 mb-0 pl-2 box-shadow-0">
									                                    <div class="card-body pl-1 pb-0">															
																		
																			
																			<?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
																			
																			<div class="bg-warning tag-option float-right p-1 pl-3 pr-3">ÖNE ÇIKAN</div>
																			
																			<?php endif; ?>
																			
																			<h4 style="font-size: 22px;" class="mb-3"><strong><?php echo $emlak["fiyat"]; ?></strong> <?php echo $emlak["fiyatkur"]; ?></h4>

																			<h4 style="font-size: 15px;" class="mb-3">

																				<strong>

																					<a href="/ilanara/?emlaktipi=<?php echo $emlak_ilan_tipi["id"]; ?>"><?php echo $emlak_ilan_tipi["ad"]; ?></a>
																					
																					<span class="m-2 text-muted">|</span> 

																					<a href="/ilanara/?emlaksekli=<?php echo $emlak_ilan_sekli["id"]; ?>"><?php echo $emlak_ilan_sekli["baslik"]; ?></a>

																					<span class="m-2 text-muted">|</span>

																					<a href="/ilanara/?kategori=<?php echo $emlak_kategori["kat_id"]; ?>"><?php echo $emlak_kategori["kat_adi"]; ?> </a>

																				</strong>

																			</h4>

																			<h5 class="mb-1"><?php echo $emlak["baslik"]; ?></h5>
																																
																			<p class="btn mb-3 box-shadow-0 font-weight-light float-right pl-0"><i class="fa fa-calendar-o mr-1"></i> <?php echo $emlak["eklemetarihi"]; ?></p>
																			
																			<?php
																			
																				$bilgi = "																
																					<div class='text-center'>
																						
																						<h3 class='font-weight-bold'><a class='p-3 pl-5 pr-5 h5 btn btn-light box-shadow-0 border' href='tel:".$ekleyen["tel"]."'><i class='fa fa-phone fa-lg text-danger mr-3'></i> ".$ekleyen["tel"]."</a></h3>
																						
																					</div>
																				";
																			
																			?>		
																			
																			<div id="telefon-goster" style="position: absolute; right: 8px; top: 8px; height: 100%; width: 200px;">
																				
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
																			
																				<button type="button" class="btn btn-dark btn-block h6 pl-4 pr-4 pt-3 pb-3 mr-3" data-toggle="modal" data-target="#mesajGonder">
																					<i class="fa fa-envelope-o fa-lg float-left mr-3"></i> Mesaj Gönder
																				</button>
																				
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

																			<!-- Modal -->
																			<div class="modal fade" id="mesajGonder" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="mesajGonderLabel" aria-hidden="true">
																			  <div class="modal-dialog modal-xl">
																				<div class="modal-content">
																				  <div class="modal-header">
																					<h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																					  <span aria-hidden="true">&times;</span>
																					</button>
																				  </div>
																				  <div class="modal-body">
																					...
																				  </div>
																				  <div class="modal-footer">
																					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																					<button type="button" class="btn btn-primary">Understood</button>
																				  </div>
																				</div>
																			  </div>
																			</div>
																			
									                                        
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
											
											if ($mintoplu != "" || $maxtoplu != "") {

												$stmt_emlaknover2 = $vt->prepare("SELECT * FROM emlak_ilandetay where seo BETWEEN ? AND ? AND formid = ?");
												$stmt_emlaknover2->execute([$mintoplu, $maxtoplu, $minmaxtoplu]);
												while($emlaknover = $stmt_emlaknover2->fetch()) {
													if (is_numeric($emlaknover["seo"]))  {

														$stmt_emlakver = $vt->prepare("SELECT * FROM emlak_ilan where emlakno = ?");
														$stmt_emlakver->execute([$emlaknover["emlakno"]]);
														while($emlak = $stmt_emlakver->fetch()) { 

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
																<?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
																<div class="power-ribbon power-ribbon-top-left text-warning"><span class="bg-warning"><i class="fa fa-star"></i> </span></div>
																<?php endif; ?>
									                            <div class="d-md-flex">
									                                <div class="item-card9-img">		
																	
									                                    <div class="item-card9-imgs kategori-list-img">
									                                        <a target="_blank" href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"></a>
									                                        <?php if ($emlak_resim["emlakno"]) { ?>
									                                        <img src="uploads/resim/<?php echo $emlak_resim["resimad"] ?>" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
									                                    	<?php } else { ?>
									                                        <img src="uploads/resim/resim.png" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />			                                    		
									                                    	<?php } ?>
									                                    </div>
																		
									                                </div>
									                                <div class="card border-0 mb-0 pl-2 box-shadow-0">
									                                    <div class="card-body pl-1 pb-0">															
																		
																			
																			<?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
																			
																			<div class="bg-warning tag-option float-right p-1 pl-3 pr-3">ÖNE ÇIKAN</div>
																			
																			<?php endif; ?>
																			
																			<h4 style="font-size: 22px;" class="mb-3"><strong><?php echo $emlak["fiyat"]; ?></strong> <?php echo $emlak["fiyatkur"]; ?></h4>

																			<h4 style="font-size: 15px;" class="mb-3">

																				<strong>

																					<a href="/ilanara/?emlaktipi=<?php echo $emlak_ilan_tipi["id"]; ?>"><?php echo $emlak_ilan_tipi["ad"]; ?></a>
																					
																					<span class="m-2 text-muted">|</span> 

																					<a href="/ilanara/?emlaksekli=<?php echo $emlak_ilan_sekli["id"]; ?>"><?php echo $emlak_ilan_sekli["baslik"]; ?></a>

																					<span class="m-2 text-muted">|</span>

																					<a href="/ilanara/?kategori=<?php echo $emlak_kategori["kat_id"]; ?>"><?php echo $emlak_kategori["kat_adi"]; ?> </a>

																				</strong>

																			</h4>

																			<h5 class="mb-1"><?php echo $emlak["baslik"]; ?></h5>
																																
																			<p class="btn mb-3 box-shadow-0 font-weight-light float-right pl-0"><i class="fa fa-calendar-o mr-1"></i> <?php echo $emlak["eklemetarihi"]; ?></p>
																			
																			<?php
																			
																				$bilgi = "																
																					<div class='text-center'>
																						
																						<h3 class='font-weight-bold'><a class='p-3 pl-5 pr-5 h5 btn btn-light box-shadow-0 border' href='tel:".$ekleyen["tel"]."'><i class='fa fa-phone fa-lg text-danger mr-3'></i> ".$ekleyen["tel"]."</a></h3>
																						
																					</div>
																				";
																			
																			?>		
																			
																			<div id="telefon-goster" style="position: absolute; right: 8px; top: 8px; height: 100%; width: 200px;">
																				
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
																			
																				<button type="button" class="btn btn-dark btn-block h6 pl-4 pr-4 pt-3 pb-3 mr-3" data-toggle="modal" data-target="#mesajGonder">
																					<i class="fa fa-envelope-o fa-lg float-left mr-3"></i> Mesaj Gönder
																				</button>
																				
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

																			<!-- Modal -->
																			<div class="modal fade" id="mesajGonder" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="mesajGonderLabel" aria-hidden="true">
																			  <div class="modal-dialog modal-xl">
																				<div class="modal-content">
																				  <div class="modal-header">
																					<h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																					  <span aria-hidden="true">&times;</span>
																					</button>
																				  </div>
																				  <div class="modal-body">
																					...
																				  </div>
																				  <div class="modal-footer">
																					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																					<button type="button" class="btn btn-primary">Understood</button>
																				  </div>
																				</div>
																			  </div>
																			</div>
																			
									                                        
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

											if ($io["toplusecim"] == 1 && $post != "") {
												foreach ($post as $key) {
													$stmt_emlaknover3 = $vt->prepare("SELECT * FROM emlak_ilandetay where seo = ? AND formid = ?");
													$stmt_emlaknover3->execute([$key, $io["id"]]);
													while($emlaknover = $stmt_emlaknover3->fetch()) {

														$stmt_emlakver = $vt->prepare("SELECT * FROM emlak_ilan where emlakno = ?");
														$stmt_emlakver->execute([$emlaknover["emlakno"]]);
														while($emlak = $stmt_emlakver->fetch()) { 

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
																<?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
																<div class="power-ribbon power-ribbon-top-left text-warning"><span class="bg-warning"><i class="fa fa-star"></i> </span></div>
																<?php endif; ?>
									                            <div class="d-md-flex">
									                                <div class="item-card9-img">		
																	
									                                    <div class="item-card9-imgs kategori-list-img">
									                                        <a target="_blank" href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"></a>
									                                        <?php if ($emlak_resim["emlakno"]) { ?>
									                                        <img src="uploads/resim/<?php echo $emlak_resim["resimad"] ?>" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
									                                    	<?php } else { ?>
									                                        <img src="uploads/resim/resim.png" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />			                                    		
									                                    	<?php } ?>
									                                    </div>
																		
									                                </div>
									                                <div class="card border-0 mb-0 pl-2 box-shadow-0">
									                                    <div class="card-body pl-1 pb-0">															
																		
																			
																			<?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
																			
																			<div class="bg-warning tag-option float-right p-1 pl-3 pr-3">ÖNE ÇIKAN</div>
																			
																			<?php endif; ?>
																			
																			<h4 style="font-size: 22px;" class="mb-3"><strong><?php echo $emlak["fiyat"]; ?></strong> <?php echo $emlak["fiyatkur"]; ?></h4>

																			<h4 style="font-size: 15px;" class="mb-3">

																				<strong>

																					<a href="/ilanara/?emlaktipi=<?php echo $emlak_ilan_tipi["id"]; ?>"><?php echo $emlak_ilan_tipi["ad"]; ?></a>
																					
																					<span class="m-2 text-muted">|</span> 

																					<a href="/ilanara/?emlaksekli=<?php echo $emlak_ilan_sekli["id"]; ?>"><?php echo $emlak_ilan_sekli["baslik"]; ?></a>

																					<span class="m-2 text-muted">|</span>

																					<a href="/ilanara/?kategori=<?php echo $emlak_kategori["kat_id"]; ?>"><?php echo $emlak_kategori["kat_adi"]; ?> </a>

																				</strong>

																			</h4>

																			<h5 class="mb-1"><?php echo $emlak["baslik"]; ?></h5>
																																
																			<p class="btn mb-3 box-shadow-0 font-weight-light float-right pl-0"><i class="fa fa-calendar-o mr-1"></i> <?php echo $emlak["eklemetarihi"]; ?></p>
																			
																			<?php
																			
																				$bilgi = "																
																					<div class='text-center'>
																						
																						<h3 class='font-weight-bold'><a class='p-3 pl-5 pr-5 h5 btn btn-light box-shadow-0 border' href='tel:".$ekleyen["tel"]."'><i class='fa fa-phone fa-lg text-danger mr-3'></i> ".$ekleyen["tel"]."</a></h3>
																						
																					</div>
																				";
																			
																			?>		
																			
																			<div id="telefon-goster" style="position: absolute; right: 8px; top: 8px; height: 100%; width: 200px;">
																				
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
																			
																				<button type="button" class="btn btn-dark btn-block h6 pl-4 pr-4 pt-3 pb-3 mr-3" data-toggle="modal" data-target="#mesajGonder">
																					<i class="fa fa-envelope-o fa-lg float-left mr-3"></i> Mesaj Gönder
																				</button>
																				
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

																			<!-- Modal -->
																			<div class="modal fade" id="mesajGonder" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="mesajGonderLabel" aria-hidden="true">
																			  <div class="modal-dialog modal-xl">
																				<div class="modal-content">
																				  <div class="modal-header">
																					<h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																					  <span aria-hidden="true">&times;</span>
																					</button>
																				  </div>
																				  <div class="modal-body">
																					...
																				  </div>
																				  <div class="modal-footer">
																					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																					<button type="button" class="btn btn-primary">Understood</button>
																				  </div>
																				</div>
																			  </div>
																			</div>
																			
									                                        
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

											if ($io["toplusecim"] != 1 && $post != "") {
												
												$stmt_emlaknover4 = $vt->prepare("SELECT * FROM emlak_ilandetay where seo = ? AND formid = ?");
												$stmt_emlaknover4->execute([$post, $io["id"]]);
												while($emlaknover = $stmt_emlaknover4->fetch()) {
											

														$stmt_emlakver = $vt->prepare("SELECT * FROM emlak_ilan where emlakno = ?");
														$stmt_emlakver->execute([$emlaknover["emlakno"]]);
														while($emlak = $stmt_emlakver->fetch()) { 

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
																<?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
																<div class="power-ribbon power-ribbon-top-left text-warning"><span class="bg-warning"><i class="fa fa-star"></i> </span></div>
																<?php endif; ?>
									                            <div class="d-md-flex">
									                                <div class="item-card9-img">		
																	
									                                    <div class="item-card9-imgs kategori-list-img">
									                                        <a target="_blank" href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"></a>
									                                        <?php if ($emlak_resim["emlakno"]) { ?>
									                                        <img src="uploads/resim/<?php echo $emlak_resim["resimad"] ?>" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
									                                    	<?php } else { ?>
									                                        <img src="uploads/resim/resim.png" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />			                                    		
									                                    	<?php } ?>
									                                    </div>
																		
									                                </div>
									                                <div class="card border-0 mb-0 pl-2 box-shadow-0">
									                                    <div class="card-body pl-1 pb-0">															
																		
																			
																			<?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
																			
																			<div class="bg-warning tag-option float-right p-1 pl-3 pr-3">ÖNE ÇIKAN</div>
																			
																			<?php endif; ?>
																			
																			<h4 style="font-size: 22px;" class="mb-3"><strong><?php echo $emlak["fiyat"]; ?></strong> <?php echo $emlak["fiyatkur"]; ?></h4>

																			<h4 style="font-size: 15px;" class="mb-3">

																				<strong>

																					<a href="/ilanara/?emlaktipi=<?php echo $emlak_ilan_tipi["id"]; ?>"><?php echo $emlak_ilan_tipi["ad"]; ?></a>
																					
																					<span class="m-2 text-muted">|</span> 

																					<a href="/ilanara/?emlaksekli=<?php echo $emlak_ilan_sekli["id"]; ?>"><?php echo $emlak_ilan_sekli["baslik"]; ?></a>

																					<span class="m-2 text-muted">|</span>

																					<a href="/ilanara/?kategori=<?php echo $emlak_kategori["kat_id"]; ?>"><?php echo $emlak_kategori["kat_adi"]; ?> </a>

																				</strong>

																			</h4>

																			<h5 class="mb-1"><?php echo $emlak["baslik"]; ?></h5>
																																
																			<p class="btn mb-3 box-shadow-0 font-weight-light float-right pl-0"><i class="fa fa-calendar-o mr-1"></i> <?php echo $emlak["eklemetarihi"]; ?></p>
																			
																			<?php
																			
																				$bilgi = "																
																					<div class='text-center'>
																						
																						<h3 class='font-weight-bold'><a class='p-3 pl-5 pr-5 h5 btn btn-light box-shadow-0 border' href='tel:".$ekleyen["tel"]."'><i class='fa fa-phone fa-lg text-danger mr-3'></i> ".$ekleyen["tel"]."</a></h3>
																						
																					</div>
																				";
																			
																			?>		
																			
																			<div id="telefon-goster" style="position: absolute; right: 8px; top: 8px; height: 100%; width: 200px;">
																				
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
																			
																				<button type="button" class="btn btn-dark btn-block h6 pl-4 pr-4 pt-3 pb-3 mr-3" data-toggle="modal" data-target="#mesajGonder">
																					<i class="fa fa-envelope-o fa-lg float-left mr-3"></i> Mesaj Gönder
																				</button>
																				
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

																			<!-- Modal -->
																			<div class="modal fade" id="mesajGonder" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="mesajGonderLabel" aria-hidden="true">
																			  <div class="modal-dialog modal-xl">
																				<div class="modal-content">
																				  <div class="modal-header">
																					<h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																					  <span aria-hidden="true">&times;</span>
																					</button>
																				  </div>
																				  <div class="modal-body">
																					...
																				  </div>
																				  <div class="modal-footer">
																					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																					<button type="button" class="btn btn-primary">Understood</button>
																				  </div>
																				</div>
																			  </div>
																			</div>
																			
									                                        
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

										// il ilce mahalleye gore arama

										$il 		= $_GET["il"];
										$ilce 		= $_GET["ilce"];
										$mahalle 	= $_GET["mahalle"];

										if ($ilce == "" && $mahalle == "") {

											$stmt_ilanbul = $vt->prepare("SELECT * FROM emlak_ilan where il = ? AND durum = 0 AND onay = 1");
											$stmt_ilanbul->execute([$il]);
											while($ilanver = $stmt_ilanbul->fetch()) {
											
											
												$stmt_emlakver = $vt->prepare("SELECT * FROM emlak_ilan where emlakno = ?");
												$stmt_emlakver->execute([$ilanver["emlakno"]]);
												while($emlak = $stmt_emlakver->fetch()) { 

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
																<?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
																<div class="power-ribbon power-ribbon-top-left text-warning"><span class="bg-warning"><i class="fa fa-star"></i> </span></div>
																<?php endif; ?>
									                            <div class="d-md-flex">
									                                <div class="item-card9-img">		
																	
									                                    <div class="item-card9-imgs kategori-list-img">
									                                        <a target="_blank" href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"></a>
									                                        <?php if ($emlak_resim["emlakno"]) { ?>
									                                        <img src="uploads/resim/<?php echo $emlak_resim["resimad"] ?>" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
									                                    	<?php } else { ?>
									                                        <img src="uploads/resim/resim.png" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />			                                    		
									                                    	<?php } ?>
									                                    </div>
																		
									                                </div>
									                                <div class="card border-0 mb-0 pl-2 box-shadow-0">
									                                    <div class="card-body pl-1 pb-0">															
																		
																			
																			<?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
																			
																			<div class="bg-warning tag-option float-right p-1 pl-3 pr-3">ÖNE ÇIKAN</div>
																			
																			<?php endif; ?>
																			
																			<h4 style="font-size: 22px;" class="mb-3"><strong><?php echo $emlak["fiyat"]; ?></strong> <?php echo $emlak["fiyatkur"]; ?></h4>

																			<h4 style="font-size: 15px;" class="mb-3">

																				<strong>

																					<a href="/ilanara/?emlaktipi=<?php echo $emlak_ilan_tipi["id"]; ?>"><?php echo $emlak_ilan_tipi["ad"]; ?></a>
																					
																					<span class="m-2 text-muted">|</span> 

																					<a href="/ilanara/?emlaksekli=<?php echo $emlak_ilan_sekli["id"]; ?>"><?php echo $emlak_ilan_sekli["baslik"]; ?></a>

																					<span class="m-2 text-muted">|</span>

																					<a href="/ilanara/?kategori=<?php echo $emlak_kategori["kat_id"]; ?>"><?php echo $emlak_kategori["kat_adi"]; ?> </a>

																				</strong>

																			</h4>

																			<h5 class="mb-1"><?php echo $emlak["baslik"]; ?></h5>
																																
																			<p class="btn mb-3 box-shadow-0 font-weight-light float-right pl-0"><i class="fa fa-calendar-o mr-1"></i> <?php echo $emlak["eklemetarihi"]; ?></p>
																			
																			<?php
																			
																				$bilgi = "																
																					<div class='text-center'>
																						
																						<h3 class='font-weight-bold'><a class='p-3 pl-5 pr-5 h5 btn btn-light box-shadow-0 border' href='tel:".$ekleyen["tel"]."'><i class='fa fa-phone fa-lg text-danger mr-3'></i> ".$ekleyen["tel"]."</a></h3>
																						
																					</div>
																				";
																			
																			?>		
																			
																			<div id="telefon-goster" style="position: absolute; right: 8px; top: 8px; height: 100%; width: 200px;">
																				
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
																			
																				<button type="button" class="btn btn-dark btn-block h6 pl-4 pr-4 pt-3 pb-3 mr-3" data-toggle="modal" data-target="#mesajGonder">
																					<i class="fa fa-envelope-o fa-lg float-left mr-3"></i> Mesaj Gönder
																				</button>
																				
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

																			<!-- Modal -->
																			<div class="modal fade" id="mesajGonder" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="mesajGonderLabel" aria-hidden="true">
																			  <div class="modal-dialog modal-xl">
																				<div class="modal-content">
																				  <div class="modal-header">
																					<h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																					  <span aria-hidden="true">&times;</span>
																					</button>
																				  </div>
																				  <div class="modal-body">
																					...
																				  </div>
																				  <div class="modal-footer">
																					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																					<button type="button" class="btn btn-primary">Understood</button>
																				  </div>
																				</div>
																			  </div>
																			</div>
																			
									                                        
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

										} else if ($mahalle == "") {

											$stmt_ilanbul = $vt->prepare("SELECT * FROM emlak_ilan where ilce = ? AND durum = 0 AND onay = 1");
											$stmt_ilanbul->execute([$ilce]);
											while($ilanver = $stmt_ilanbul->fetch()) {

												$stmt_emlakver = $vt->prepare("SELECT * FROM emlak_ilan where emlakno = ?");
												$stmt_emlakver->execute([$ilanver["emlakno"]]);
												while($emlak = $stmt_emlakver->fetch()) { 

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
																<?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
																<div class="power-ribbon power-ribbon-top-left text-warning"><span class="bg-warning"><i class="fa fa-star"></i> </span></div>
																<?php endif; ?>
									                            <div class="d-md-flex">
									                                <div class="item-card9-img">		
																	
									                                    <div class="item-card9-imgs kategori-list-img">
									                                        <a target="_blank" href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"></a>
									                                        <?php if ($emlak_resim["emlakno"]) { ?>
									                                        <img src="uploads/resim/<?php echo $emlak_resim["resimad"] ?>" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
									                                    	<?php } else { ?>
									                                        <img src="uploads/resim/resim.png" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />			                                    		
									                                    	<?php } ?>
									                                    </div>
																		
									                                </div>
									                                <div class="card border-0 mb-0 pl-2 box-shadow-0">
									                                    <div class="card-body pl-1 pb-0">															
																		
																			
																			<?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
																			
																			<div class="bg-warning tag-option float-right p-1 pl-3 pr-3">ÖNE ÇIKAN</div>
																			
																			<?php endif; ?>
																			
																			<h4 style="font-size: 22px;" class="mb-3"><strong><?php echo $emlak["fiyat"]; ?></strong> <?php echo $emlak["fiyatkur"]; ?></h4>

																			<h4 style="font-size: 15px;" class="mb-3">

																				<strong>

																					<a href="/ilanara/?emlaktipi=<?php echo $emlak_ilan_tipi["id"]; ?>"><?php echo $emlak_ilan_tipi["ad"]; ?></a>
																					
																					<span class="m-2 text-muted">|</span> 

																					<a href="/ilanara/?emlaksekli=<?php echo $emlak_ilan_sekli["id"]; ?>"><?php echo $emlak_ilan_sekli["baslik"]; ?></a>

																					<span class="m-2 text-muted">|</span>

																					<a href="/ilanara/?kategori=<?php echo $emlak_kategori["kat_id"]; ?>"><?php echo $emlak_kategori["kat_adi"]; ?> </a>

																				</strong>

																			</h4>

																			<h5 class="mb-1"><?php echo $emlak["baslik"]; ?></h5>
																																
																			<p class="btn mb-3 box-shadow-0 font-weight-light float-right pl-0"><i class="fa fa-calendar-o mr-1"></i> <?php echo $emlak["eklemetarihi"]; ?></p>
																			
																			<?php
																			
																				$bilgi = "																
																					<div class='text-center'>
																						
																						<h3 class='font-weight-bold'><a class='p-3 pl-5 pr-5 h5 btn btn-light box-shadow-0 border' href='tel:".$ekleyen["tel"]."'><i class='fa fa-phone fa-lg text-danger mr-3'></i> ".$ekleyen["tel"]."</a></h3>
																						
																					</div>
																				";
																			
																			?>		
																			
																			<div id="telefon-goster" style="position: absolute; right: 8px; top: 8px; height: 100%; width: 200px;">
																				
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
																			
																				<button type="button" class="btn btn-dark btn-block h6 pl-4 pr-4 pt-3 pb-3 mr-3" data-toggle="modal" data-target="#mesajGonder">
																					<i class="fa fa-envelope-o fa-lg float-left mr-3"></i> Mesaj Gönder
																				</button>
																				
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

																			<!-- Modal -->
																			<div class="modal fade" id="mesajGonder" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="mesajGonderLabel" aria-hidden="true">
																			  <div class="modal-dialog modal-xl">
																				<div class="modal-content">
																				  <div class="modal-header">
																					<h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																					  <span aria-hidden="true">&times;</span>
																					</button>
																				  </div>
																				  <div class="modal-body">
																					...
																				  </div>
																				  <div class="modal-footer">
																					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																					<button type="button" class="btn btn-primary">Understood</button>
																				  </div>
																				</div>
																			  </div>
																			</div>
																			
									                                        
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

										} else if ($mahalle != "") {

											foreach ($mahalle as $mah) {
												$stmt_ilanbul = $vt->prepare("SELECT * FROM emlak_ilan where mahalle = ? AND durum = 0 AND onay = 1");
												$stmt_ilanbul->execute([$mah]);
												while($ilanver = $stmt_ilanbul->fetch()) {

													$stmt_emlakver = $vt->prepare("SELECT * FROM emlak_ilan where emlakno = ?");
													$stmt_emlakver->execute([$ilanver["emlakno"]]);
													while($emlak = $stmt_emlakver->fetch()) { 

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
																<?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
																<div class="power-ribbon power-ribbon-top-left text-warning"><span class="bg-warning"><i class="fa fa-star"></i> </span></div>
																<?php endif; ?>
									                            <div class="d-md-flex">
									                                <div class="item-card9-img">		
																	
									                                    <div class="item-card9-imgs kategori-list-img">
									                                        <a target="_blank" href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"></a>
									                                        <?php if ($emlak_resim["emlakno"]) { ?>
									                                        <img src="uploads/resim/<?php echo $emlak_resim["resimad"] ?>" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
									                                    	<?php } else { ?>
									                                        <img src="uploads/resim/resim.png" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />			                                    		
									                                    	<?php } ?>
									                                    </div>
																		
									                                </div>
									                                <div class="card border-0 mb-0 pl-2 box-shadow-0">
									                                    <div class="card-body pl-1 pb-0">															
																		
																			
																			<?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
																			
																			<div class="bg-warning tag-option float-right p-1 pl-3 pr-3">ÖNE ÇIKAN</div>
																			
																			<?php endif; ?>
																			
																			<h4 style="font-size: 22px;" class="mb-3"><strong><?php echo $emlak["fiyat"]; ?></strong> <?php echo $emlak["fiyatkur"]; ?></h4>

																			<h4 style="font-size: 15px;" class="mb-3">

																				<strong>

																					<a href="/ilanara/?emlaktipi=<?php echo $emlak_ilan_tipi["id"]; ?>"><?php echo $emlak_ilan_tipi["ad"]; ?></a>
																					
																					<span class="m-2 text-muted">|</span> 

																					<a href="/ilanara/?emlaksekli=<?php echo $emlak_ilan_sekli["id"]; ?>"><?php echo $emlak_ilan_sekli["baslik"]; ?></a>

																					<span class="m-2 text-muted">|</span>

																					<a href="/ilanara/?kategori=<?php echo $emlak_kategori["kat_id"]; ?>"><?php echo $emlak_kategori["kat_adi"]; ?> </a>

																				</strong>

																			</h4>

																			<h5 class="mb-1"><?php echo $emlak["baslik"]; ?></h5>
																																
																			<p class="btn mb-3 box-shadow-0 font-weight-light float-right pl-0"><i class="fa fa-calendar-o mr-1"></i> <?php echo $emlak["eklemetarihi"]; ?></p>
																			
																			<?php
																			
																				$bilgi = "																
																					<div class='text-center'>
																						
																						<h3 class='font-weight-bold'><a class='p-3 pl-5 pr-5 h5 btn btn-light box-shadow-0 border' href='tel:".$ekleyen["tel"]."'><i class='fa fa-phone fa-lg text-danger mr-3'></i> ".$ekleyen["tel"]."</a></h3>
																						
																					</div>
																				";
																			
																			?>		
																			
																			<div id="telefon-goster" style="position: absolute; right: 8px; top: 8px; height: 100%; width: 200px;">
																				
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
																			
																				<button type="button" class="btn btn-dark btn-block h6 pl-4 pr-4 pt-3 pb-3 mr-3" data-toggle="modal" data-target="#mesajGonder">
																					<i class="fa fa-envelope-o fa-lg float-left mr-3"></i> Mesaj Gönder
																				</button>
																				
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

																			<!-- Modal -->
																			<div class="modal fade" id="mesajGonder" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="mesajGonderLabel" aria-hidden="true">
																			  <div class="modal-dialog modal-xl">
																				<div class="modal-content">
																				  <div class="modal-header">
																					<h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																					  <span aria-hidden="true">&times;</span>
																					</button>
																				  </div>
																				  <div class="modal-body">
																					...
																				  </div>
																				  <div class="modal-footer">
																					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																					<button type="button" class="btn btn-primary">Understood</button>
																				  </div>
																				</div>
																			  </div>
																			</div>
																			
									                                        
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
										
										// kategoriye gore arama

										$kategori = $_GET["kategori"];

										$stmt_katara = $vt->prepare("SELECT * FROM emlak_ilan where katid = ? AND durum = 0 AND onay = 1");
										$stmt_katara->execute([$kategori]);
										while ($kategoriarama = $stmt_katara->fetch()) {

												$stmt_emlakver = $vt->prepare("SELECT * FROM emlak_ilan where emlakno = ?");
												$stmt_emlakver->execute([$kategoriarama["emlakno"]]);
												while($emlak = $stmt_emlakver->fetch()) { 

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
																<?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
																<div class="power-ribbon power-ribbon-top-left text-warning"><span class="bg-warning"><i class="fa fa-star"></i> </span></div>
																<?php endif; ?>
									                            <div class="d-md-flex">
									                                <div class="item-card9-img">		
																	
									                                    <div class="item-card9-imgs kategori-list-img">
									                                        <a target="_blank" href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"></a>
									                                        <?php if ($emlak_resim["emlakno"]) { ?>
									                                        <img src="uploads/resim/<?php echo $emlak_resim["resimad"] ?>" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
									                                    	<?php } else { ?>
									                                        <img src="uploads/resim/resim.png" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />			                                    		
									                                    	<?php } ?>
									                                    </div>
																		
									                                </div>
									                                <div class="card border-0 mb-0 pl-2 box-shadow-0">
									                                    <div class="card-body pl-1 pb-0">															
																		
																			
																			<?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
																			
																			<div class="bg-warning tag-option float-right p-1 pl-3 pr-3">ÖNE ÇIKAN</div>
																			
																			<?php endif; ?>
																			
																			<h4 style="font-size: 22px;" class="mb-3"><strong><?php echo $emlak["fiyat"]; ?></strong> <?php echo $emlak["fiyatkur"]; ?></h4>

																			<h4 style="font-size: 15px;" class="mb-3">

																				<strong>

																					<a href="/ilanara/?emlaktipi=<?php echo $emlak_ilan_tipi["id"]; ?>"><?php echo $emlak_ilan_tipi["ad"]; ?></a>
																					
																					<span class="m-2 text-muted">|</span> 

																					<a href="/ilanara/?emlaksekli=<?php echo $emlak_ilan_sekli["id"]; ?>"><?php echo $emlak_ilan_sekli["baslik"]; ?></a>

																					<span class="m-2 text-muted">|</span>

																					<a href="/ilanara/?kategori=<?php echo $emlak_kategori["kat_id"]; ?>"><?php echo $emlak_kategori["kat_adi"]; ?> </a>

																				</strong>

																			</h4>

																			<h5 class="mb-1"><?php echo $emlak["baslik"]; ?></h5>
																																
																			<p class="btn mb-3 box-shadow-0 font-weight-light float-right pl-0"><i class="fa fa-calendar-o mr-1"></i> <?php echo $emlak["eklemetarihi"]; ?></p>
																			
																			<?php
																			
																				$bilgi = "																
																					<div class='text-center'>
																						
																						<h3 class='font-weight-bold'><a class='p-3 pl-5 pr-5 h5 btn btn-light box-shadow-0 border' href='tel:".$ekleyen["tel"]."'><i class='fa fa-phone fa-lg text-danger mr-3'></i> ".$ekleyen["tel"]."</a></h3>
																						
																					</div>
																				";
																			
																			?>		
																			
																			<div id="telefon-goster" style="position: absolute; right: 8px; top: 8px; height: 100%; width: 200px;">
																				
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
																			
																				<button type="button" class="btn btn-dark btn-block h6 pl-4 pr-4 pt-3 pb-3 mr-3" data-toggle="modal" data-target="#mesajGonder">
																					<i class="fa fa-envelope-o fa-lg float-left mr-3"></i> Mesaj Gönder
																				</button>
																				
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

																			<!-- Modal -->
																			<div class="modal fade" id="mesajGonder" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="mesajGonderLabel" aria-hidden="true">
																			  <div class="modal-dialog modal-xl">
																				<div class="modal-content">
																				  <div class="modal-header">
																					<h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																					  <span aria-hidden="true">&times;</span>
																					</button>
																				  </div>
																				  <div class="modal-body">
																					...
																				  </div>
																				  <div class="modal-footer">
																					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																					<button type="button" class="btn btn-primary">Understood</button>
																				  </div>
																				</div>
																			  </div>
																			</div>
																			
									                                        
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
										
										
										// emlak tipine gore arama

										$emlaktipipost = $_GET["emlaktipi"];																				

										if ($emlaktipipost != "") {
											$stmt_tipiara = $vt->prepare("SELECT * FROM emlak_ilan where ilantipi = ? AND durum = 0 AND onay = 1");
											$stmt_tipiara->execute([$emlaktipipost]);
											while ($emlaktipiarama = $stmt_tipiara->fetch()) {

												$stmt_emlakver = $vt->prepare("SELECT * FROM emlak_ilan where emlakno = ?");
												$stmt_emlakver->execute([$emlaktipiarama["emlakno"]]);
												while($emlak = $stmt_emlakver->fetch()) { 

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
																<?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
																<div class="power-ribbon power-ribbon-top-left text-warning"><span class="bg-warning"><i class="fa fa-star"></i> </span></div>
																<?php endif; ?>
									                            <div class="d-md-flex">
									                                <div class="item-card9-img">		
																	
									                                    <div class="item-card9-imgs kategori-list-img">
									                                        <a target="_blank" href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"></a>
									                                        <?php if ($emlak_resim["emlakno"]) { ?>
									                                        <img src="uploads/resim/<?php echo $emlak_resim["resimad"] ?>" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
									                                    	<?php } else { ?>
									                                        <img src="uploads/resim/resim.png" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />			                                    		
									                                    	<?php } ?>
									                                    </div>
																		
									                                </div>
									                                <div class="card border-0 mb-0 pl-2 box-shadow-0">
									                                    <div class="card-body pl-1 pb-0">															
																		
																			
																			<?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
																			
																			<div class="bg-warning tag-option float-right p-1 pl-3 pr-3">ÖNE ÇIKAN</div>
																			
																			<?php endif; ?>
																			
																			<h4 style="font-size: 22px;" class="mb-3"><strong><?php echo $emlak["fiyat"]; ?></strong> <?php echo $emlak["fiyatkur"]; ?></h4>

																			<h4 style="font-size: 15px;" class="mb-3">

																				<strong>

																					<a href="/ilanara/?emlaktipi=<?php echo $emlak_ilan_tipi["id"]; ?>"><?php echo $emlak_ilan_tipi["ad"]; ?></a>
																					
																					<span class="m-2 text-muted">|</span> 

																					<a href="/ilanara/?emlaksekli=<?php echo $emlak_ilan_sekli["id"]; ?>"><?php echo $emlak_ilan_sekli["baslik"]; ?></a>

																					<span class="m-2 text-muted">|</span>

																					<a href="/ilanara/?kategori=<?php echo $emlak_kategori["kat_id"]; ?>"><?php echo $emlak_kategori["kat_adi"]; ?> </a>

																				</strong>

																			</h4>

																			<h5 class="mb-1"><?php echo $emlak["baslik"]; ?></h5>
																																
																			<p class="btn mb-3 box-shadow-0 font-weight-light float-right pl-0"><i class="fa fa-calendar-o mr-1"></i> <?php echo $emlak["eklemetarihi"]; ?></p>
																			
																			<?php
																			
																				$bilgi = "																
																					<div class='text-center'>
																						
																						<h3 class='font-weight-bold'><a class='p-3 pl-5 pr-5 h5 btn btn-light box-shadow-0 border' href='tel:".$ekleyen["tel"]."'><i class='fa fa-phone fa-lg text-danger mr-3'></i> ".$ekleyen["tel"]."</a></h3>
																						
																					</div>
																				";
																			
																			?>		
																			
																			<div id="telefon-goster" style="position: absolute; right: 8px; top: 8px; height: 100%; width: 200px;">
																				
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
																			
																				<button type="button" class="btn btn-dark btn-block h6 pl-4 pr-4 pt-3 pb-3 mr-3" data-toggle="modal" data-target="#mesajGonder">
																					<i class="fa fa-envelope-o fa-lg float-left mr-3"></i> Mesaj Gönder
																				</button>
																				
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

																			<!-- Modal -->
																			<div class="modal fade" id="mesajGonder" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="mesajGonderLabel" aria-hidden="true">
																			  <div class="modal-dialog modal-xl">
																				<div class="modal-content">
																				  <div class="modal-header">
																					<h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																					  <span aria-hidden="true">&times;</span>
																					</button>
																				  </div>
																				  <div class="modal-body">
																					...
																				  </div>
																				  <div class="modal-footer">
																					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																					<button type="button" class="btn btn-primary">Understood</button>
																				  </div>
																				</div>
																			  </div>
																			</div>
																			
									                                        
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

										// emlak sekline gore arama

										$emlaksekli = $_GET["emlaksekli"];

										$stmt_sekliara = $vt->prepare("SELECT * FROM emlak_ilan where ilansekli = ? AND durum = 0 AND onay = 1");
										$stmt_sekliara->execute([$emlaksekli]);
										while ($emlaksekliarama = $stmt_sekliara->fetch()) {

												$stmt_emlakver = $vt->prepare("SELECT * FROM emlak_ilan where emlakno = ?");
												$stmt_emlakver->execute([$emlaksekliarama["emlakno"]]);
												while($emlak = $stmt_emlakver->fetch()) { 

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
																<?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
																<div class="power-ribbon power-ribbon-top-left text-warning"><span class="bg-warning"><i class="fa fa-star"></i> </span></div>
																<?php endif; ?>
									                            <div class="d-md-flex">
									                                <div class="item-card9-img">		
																	
									                                    <div class="item-card9-imgs kategori-list-img">
									                                        <a target="_blank" href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"></a>
									                                        <?php if ($emlak_resim["emlakno"]) { ?>
									                                        <img src="uploads/resim/<?php echo $emlak_resim["resimad"] ?>" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
									                                    	<?php } else { ?>
									                                        <img src="uploads/resim/resim.png" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />			                                    		
									                                    	<?php } ?>
									                                    </div>
																		
									                                </div>
									                                <div class="card border-0 mb-0 pl-2 box-shadow-0">
									                                    <div class="card-body pl-1 pb-0">															
																		
																			
																			<?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
																			
																			<div class="bg-warning tag-option float-right p-1 pl-3 pr-3">ÖNE ÇIKAN</div>
																			
																			<?php endif; ?>
																			
																			<h4 style="font-size: 22px;" class="mb-3"><strong><?php echo $emlak["fiyat"]; ?></strong> <?php echo $emlak["fiyatkur"]; ?></h4>

																			<h4 style="font-size: 15px;" class="mb-3">

																				<strong>

																					<a href="/ilanara/?emlaktipi=<?php echo $emlak_ilan_tipi["id"]; ?>"><?php echo $emlak_ilan_tipi["ad"]; ?></a>
																					
																					<span class="m-2 text-muted">|</span> 

																					<a href="/ilanara/?emlaksekli=<?php echo $emlak_ilan_sekli["id"]; ?>"><?php echo $emlak_ilan_sekli["baslik"]; ?></a>

																					<span class="m-2 text-muted">|</span>

																					<a href="/ilanara/?kategori=<?php echo $emlak_kategori["kat_id"]; ?>"><?php echo $emlak_kategori["kat_adi"]; ?> </a>

																				</strong>

																			</h4>

																			<h5 class="mb-1"><?php echo $emlak["baslik"]; ?></h5>
																																
																			<p class="btn mb-3 box-shadow-0 font-weight-light float-right pl-0"><i class="fa fa-calendar-o mr-1"></i> <?php echo $emlak["eklemetarihi"]; ?></p>
																			
																			<?php
																			
																				$bilgi = "																
																					<div class='text-center'>
																						
																						<h3 class='font-weight-bold'><a class='p-3 pl-5 pr-5 h5 btn btn-light box-shadow-0 border' href='tel:".$ekleyen["tel"]."'><i class='fa fa-phone fa-lg text-danger mr-3'></i> ".$ekleyen["tel"]."</a></h3>
																						
																					</div>
																				";
																			
																			?>		
																			
																			<div id="telefon-goster" style="position: absolute; right: 8px; top: 8px; height: 100%; width: 200px;">
																				
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
																			
																				<button type="button" class="btn btn-dark btn-block h6 pl-4 pr-4 pt-3 pb-3 mr-3" data-toggle="modal" data-target="#mesajGonder">
																					<i class="fa fa-envelope-o fa-lg float-left mr-3"></i> Mesaj Gönder
																				</button>
																				
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

																			<!-- Modal -->
																			<div class="modal fade" id="mesajGonder" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="mesajGonderLabel" aria-hidden="true">
																			  <div class="modal-dialog modal-xl">
																				<div class="modal-content">
																				  <div class="modal-header">
																					<h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																					  <span aria-hidden="true">&times;</span>
																					</button>
																				  </div>
																				  <div class="modal-body">
																					...
																				  </div>
																				  <div class="modal-footer">
																					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																					<button type="button" class="btn btn-primary">Understood</button>
																				  </div>
																				</div>
																			  </div>
																			</div>
																			
									                                        
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
										
										// fiyata gore arama

										$minfiyat = $_GET["minfiyat"];
										$maxfiyat = $_GET["maxfiyat"];

										$fiyatkur = $_GET["fiyatkur"];

										$stmt_fiyatara2 = $vt->prepare("SELECT * FROM emlak_ilan where fiyat BETWEEN ? AND ? AND fiyatkur LIKE ?");
										$stmt_fiyatara2->execute([$minfiyat, $maxfiyat, '%'.$fiyatkur.'%']);
										while($fiyatara = $stmt_fiyatara2->fetch()) {

												$stmt_emlakver = $vt->prepare("SELECT * FROM emlak_ilan where emlakno = ?");
												$stmt_emlakver->execute([$fiyatara["emlakno"]]);
												while($emlak = $stmt_emlakver->fetch()) { 

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
																<?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
																<div class="power-ribbon power-ribbon-top-left text-warning"><span class="bg-warning"><i class="fa fa-star"></i> </span></div>
																<?php endif; ?>
									                            <div class="d-md-flex">
									                                <div class="item-card9-img">		
																	
									                                    <div class="item-card9-imgs kategori-list-img">
									                                        <a target="_blank" href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"></a>
									                                        <?php if ($emlak_resim["emlakno"]) { ?>
									                                        <img src="uploads/resim/<?php echo $emlak_resim["resimad"] ?>" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
									                                    	<?php } else { ?>
									                                        <img src="uploads/resim/resim.png" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />			                                    		
									                                    	<?php } ?>
									                                    </div>
																		
									                                </div>
									                                <div class="card border-0 mb-0 pl-2 box-shadow-0">
									                                    <div class="card-body pl-1 pb-0">															
																		
																			
																			<?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
																			
																			<div class="bg-warning tag-option float-right p-1 pl-3 pr-3">ÖNE ÇIKAN</div>
																			
																			<?php endif; ?>
																			
																			<h4 style="font-size: 22px;" class="mb-3"><strong><?php echo $emlak["fiyat"]; ?></strong> <?php echo $emlak["fiyatkur"]; ?></h4>

																			<h4 style="font-size: 15px;" class="mb-3">

																				<strong>

																					<a href="/ilanara/?emlaktipi=<?php echo $emlak_ilan_tipi["id"]; ?>"><?php echo $emlak_ilan_tipi["ad"]; ?></a>
																					
																					<span class="m-2 text-muted">|</span> 

																					<a href="/ilanara/?emlaksekli=<?php echo $emlak_ilan_sekli["id"]; ?>"><?php echo $emlak_ilan_sekli["baslik"]; ?></a>

																					<span class="m-2 text-muted">|</span>

																					<a href="/ilanara/?kategori=<?php echo $emlak_kategori["kat_id"]; ?>"><?php echo $emlak_kategori["kat_adi"]; ?> </a>

																				</strong>

																			</h4>

																			<h5 class="mb-1"><?php echo $emlak["baslik"]; ?></h5>
																																
																			<p class="btn mb-3 box-shadow-0 font-weight-light float-right pl-0"><i class="fa fa-calendar-o mr-1"></i> <?php echo $emlak["eklemetarihi"]; ?></p>
																			
																			<?php
																			
																				$bilgi = "																
																					<div class='text-center'>
																						
																						<h3 class='font-weight-bold'><a class='p-3 pl-5 pr-5 h5 btn btn-light box-shadow-0 border' href='tel:".$ekleyen["tel"]."'><i class='fa fa-phone fa-lg text-danger mr-3'></i> ".$ekleyen["tel"]."</a></h3>
																						
																					</div>
																				";
																			
																			?>		
																			
																			<div id="telefon-goster" style="position: absolute; right: 8px; top: 8px; height: 100%; width: 200px;">
																				
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
																			
																				<button type="button" class="btn btn-dark btn-block h6 pl-4 pr-4 pt-3 pb-3 mr-3" data-toggle="modal" data-target="#mesajGonder">
																					<i class="fa fa-envelope-o fa-lg float-left mr-3"></i> Mesaj Gönder
																				</button>
																				
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

																			<!-- Modal -->
																			<div class="modal fade" id="mesajGonder" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="mesajGonderLabel" aria-hidden="true">
																			  <div class="modal-dialog modal-xl">
																				<div class="modal-content">
																				  <div class="modal-header">
																					<h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																					  <span aria-hidden="true">&times;</span>
																					</button>
																				  </div>
																				  <div class="modal-body">
																					...
																				  </div>
																				  <div class="modal-footer">
																					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																					<button type="button" class="btn btn-primary">Understood</button>
																				  </div>
																				</div>
																			  </div>
																			</div>
																			
									                                        
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
									
									// arama formuna gore arama
									
									$aramaformu = $_GET["aramaformu"];
									
									if (isset($aramaformu)) {


										$stmt_aramabul = $vt->prepare("SELECT * FROM emlak_ilan where emlakno LIKE ? OR baslik LIKE ?");
										$stmt_aramabul->execute(['%'.$aramaformu.'%', '%'.$aramaformu.'%']);
										while($emlak = $stmt_aramabul->fetch()) {

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
																<?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
																<div class="power-ribbon power-ribbon-top-left text-warning"><span class="bg-warning"><i class="fa fa-star"></i> </span></div>
																<?php endif; ?>
									                            <div class="d-md-flex">
									                                <div class="item-card9-img">		
																	
									                                    <div class="item-card9-imgs kategori-list-img">
									                                        <a target="_blank" href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>"></a>
									                                        <?php if ($emlak_resim["emlakno"]) { ?>
									                                        <img src="uploads/resim/<?php echo $emlak_resim["resimad"] ?>" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />
									                                    	<?php } else { ?>
									                                        <img src="uploads/resim/resim.png" width="100%" alt="<?php echo $emlak["baslik"]; ?>" class="cover-image" />			                                    		
									                                    	<?php } ?>
									                                    </div>
																		
									                                </div>
									                                <div class="card border-0 mb-0 pl-2 box-shadow-0">
									                                    <div class="card-body pl-1 pb-0">															
																		
																			
																			<?php if ($emlak["doping"] == "var" && $emlak["doping_onay"] == 1): ?>
																			
																			<div class="bg-warning tag-option float-right p-1 pl-3 pr-3">ÖNE ÇIKAN</div>
																			
																			<?php endif; ?>
																			
																			<h4 style="font-size: 22px;" class="mb-3"><strong><?php echo $emlak["fiyat"]; ?></strong> <?php echo $emlak["fiyatkur"]; ?></h4>

																			<h4 style="font-size: 15px;" class="mb-3">

																				<strong>

																					<a href="/ilanara/?emlaktipi=<?php echo $emlak_ilan_tipi["id"]; ?>"><?php echo $emlak_ilan_tipi["ad"]; ?></a>
																					
																					<span class="m-2 text-muted">|</span> 

																					<a href="/ilanara/?emlaksekli=<?php echo $emlak_ilan_sekli["id"]; ?>"><?php echo $emlak_ilan_sekli["baslik"]; ?></a>

																					<span class="m-2 text-muted">|</span>

																					<a href="/ilanara/?kategori=<?php echo $emlak_kategori["kat_id"]; ?>"><?php echo $emlak_kategori["kat_adi"]; ?> </a>

																				</strong>

																			</h4>

																			<h5 class="mb-1"><?php echo $emlak["baslik"]; ?></h5>
																																
																			<p class="btn mb-3 box-shadow-0 font-weight-light float-right pl-0"><i class="fa fa-calendar-o mr-1"></i> <?php echo $emlak["eklemetarihi"]; ?></p>
																			
																			<?php
																			
																				$bilgi = "																
																					<div class='text-center'>
																						
																						<h3 class='font-weight-bold'><a class='p-3 pl-5 pr-5 h5 btn btn-light box-shadow-0 border' href='tel:".$ekleyen["tel"]."'><i class='fa fa-phone fa-lg text-danger mr-3'></i> ".$ekleyen["tel"]."</a></h3>
																						
																					</div>
																				";
																			
																			?>		
																			
																			<div id="telefon-goster" style="position: absolute; right: 8px; top: 8px; height: 100%; width: 200px;">
																				
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
																			
																				<button type="button" class="btn btn-dark btn-block h6 pl-4 pr-4 pt-3 pb-3 mr-3" data-toggle="modal" data-target="#mesajGonder">
																					<i class="fa fa-envelope-o fa-lg float-left mr-3"></i> Mesaj Gönder
																				</button>
																				
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

																			<!-- Modal -->
																			<div class="modal fade" id="mesajGonder" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="mesajGonderLabel" aria-hidden="true">
																			  <div class="modal-dialog modal-xl">
																				<div class="modal-content">
																				  <div class="modal-header">
																					<h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																					  <span aria-hidden="true">&times;</span>
																					</button>
																				  </div>
																				  <div class="modal-body">
																					...
																				  </div>
																				  <div class="modal-footer">
																					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																					<button type="button" class="btn btn-primary">Understood</button>
																				  </div>
																				</div>
																			  </div>
																			</div>
																			
									                                        
																			<div class="item-card9">			                                            			                                            
									                                            <a href="<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?>" class="text-dark"></a>
									                                        </div>
																			
									                                    </div>
									                                </div>
									                            </div>
									                        </div> 
															
															<div style="display:block; height:13px;"></div>
									<?php } ?>									
								<?php } ?>

                            </div>
                        </div>
                    </div> 
                </div>
                <!--/Add lists-->
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