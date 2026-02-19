<div class="pt-0 mb-0 text-white" style="background: #888c8d;">

    <div class="header-text mb-0">

        <div class="container"> 

            <div class="row">
                
                <div class="col-xl-5 col-lg-12 col-sm-6 col-md-6 d-block pt-8 pb-8">
                    
                    <h2 class="font-weight-light h2">Emlakbudur Ailesine Katılın Birikte Kazanalım!</h2>
                    <p>Bilgi almak için bizi arayabilirsiniz.</p>
                    <a href="kurumsal-uyelik" class="btn btn-success p-2 pl-5 pr-5">Danışman Ol</a>
                    <a href="tel:<?php echo $site["sabittel"]; ?>" class="btn btn-outline-light p-2 pl-5 pr-5"><strong><?php echo $site["sabittel"]; ?></strong></a>

                </div>

                <div class="col-xl-5 col-lg-12 col-sm-6 col-md-6 offset-lg-2 d-block pt-8 pb-8">

                    <h2 class="font-weight-light">Bilgilerinizi girin, sizi arayalım!</h2>

                    <form action="" method="POST" class="form-beni-ara form-horizontal">
                        <div class="form-group">
                            <input class="input--style-4" type="text" placeholder="Ad Soyad" name="ad_soyad">
                        </div>  
                        <div class="form-group">
                            <input class="input--style-4" type="text" placeholder="Cep Numarası" name="cep">
                        </div>
                        
                        <button name="beni_ara" type="submit" class="btn btn-success pull-right pl-7 pr-7"><strong>Gönder</strong></button>

                        <div class="clearfix"></div>
                    </form>

                    <?php 

                        if (isset($_POST["beni_ara"])) {
                            
                            $ad_soyad   = $_POST["ad_soyad"];

                            $cep        = $_POST["cep"];

                            $mesaj = "Merhaba, ".$cep." numaralı kullanıcı yönetimden telefon araması için dönüş beklemetektedir.";

                            $tarih = date('d/m/Y');

                            if (empty($ad_soyad)) {
                                hata_alert("Ad soyad alanının doldurulması zorunludur.");
                            } else  if (empty($cep)) {
                                hata_alert("Cep alanının doldurulması zorunludur.");
                            } else {
                                
                                $ekle=$vt->prepare("INSERT INTO emlak_mesajemlaktalep (adsoyad, tel, tarih, taleptur, mesaj, emlaktipi, adres, email) VALUES (?,?,?,?,?,?,?,?)");
                                $deger=$ekle->execute(array($ad_soyad, $cep, $tarih, 'Beni Arayın', $mesaj, '-', '0','-'));

                                onay_alert("Teşekkürler, bilgileriniz alındı. Kısa süre içerisinde ekibimiz dönüş yapacaktır.");

                                if ($beni_ara_insert) {
                                    echo "string";
                                }

                            }

                        }

                    ?>

                </div>

            </div> 

        </div>

    </div>

</div>
<div class="bg-footer-map d-none d-lg-block">
    <div class="container">
        <div class="card">
            
            <div class="card-body pb-5">
                
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <!-- AKTIF KATEGORI -->
                    <?php
        				$emlak_tipleri = $vt->query("SELECT * FROM emlak_ilantipi WHERE durum = 0 LIMIT 0,1")->fetchAll();
        				foreach ($emlak_tipleri AS $tip):
        			?>
                    <li class="nav-item">
                        <a class="nav-link active" title="<?php echo $tip["ad"]; ?>" id="home-tab" data-toggle="tab" href="#<?php echo $tip["seo"]; ?>" role="tab" aria-controls="home" aria-selected="true"><?php echo $tip["ad"]; ?></a>
                    </li>
                    <?php endforeach; ?>
                    
                    <!-- ALT KATEGORI -->
                    <?php
        				$emlak_tipleri = $vt->query("SELECT * FROM emlak_ilantipi WHERE durum = 0 LIMIT 1,100")->fetchAll();
        				foreach ($emlak_tipleri AS $tip):
        			?>
                    <li class="nav-item">
                        <a class="nav-link" title="<?php echo $tip["ad"]; ?>" id="home-tab" data-toggle="tab" href="#<?php echo $tip["seo"]; ?>" role="tab" aria-controls="home" aria-selected="true"><?php echo $tip["ad"]; ?></a>
                    </li>
                    <?php endforeach; ?>
                </ul> 
                
                <div class="tab-content" id="myTabContent">
                    
                    <!-- AKTIF KATEGORI -->
                    <?php
        				$emlak_tipleri = $vt->query("SELECT * FROM emlak_ilantipi WHERE durum = 0 LIMIT 0,1")->fetchAll();
        				foreach ($emlak_tipleri AS $tip):
        			?>
                    <div class="tab-pane fade show active" id="<?php echo $tip["seo"]; ?>" role="tabpanel" aria-labelledby="<?php echo $tip["seo"]; ?>-tab">
                        
                        <div class="row">
                            <div class="col-lg-2">
                                <ul class="nav-navbar">
                                    <?php
                        				$emlak_sekilleri = $vt->query("SELECT * FROM emlak_ilansekli WHERE durum = 0")->fetchAll();
                        				foreach ($emlak_sekilleri AS $sekilad):
                        			?>
                                    <li class="nav-item">
                                        <a href="/ilanara/?emlaksekli=<?php echo $sekilad["id"]; ?>&emlaktipi=<?php echo $tip["id"]; ?>" title="<?php echo $tip["ad"]; ?> <?php echo $sekilad["baslik"]; ?>" class="nav-link">
                                           <?php echo $tip["ad"]; ?> <?php echo $sekilad["baslik"]; ?>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            
                            <?php
                                $s=0;
                                for ($i=0; $i<5; $i++): 
                            ?>
                            
                            <div class="col-lg">
                                <ul class="nav-navbar">
                                    <?php
                        			    	    
                            				$sekiller = $vt->query("SELECT * FROM emlak_ilansekli WHERE durum = 0")->fetchAll(); 
                			    	        foreach ($sekiller AS $sekil):
                        				   
                            				    $il = $vt->query("SELECT * FROM sehir WHERE ozet = 1 LIMIT ".$i.",1")->fetch(); 
                        				    
                        				    
                        			?>
                                    <li class="nav-item">
                                        <a href="/ilanara/?&il=<?php echo $il["sehir_key"]; ?>&emlaksekli=<?php echo $sekil["id"]; ?>&emlaktipi=<?php echo $tip["id"]; ?>" title="<?php echo $il["adi"]; ?> <?php echo $tip["ad"]; ?> <?php echo $sekil["baslik"]; ?>" class="nav-link">
                                           <?php echo $il["adi"]; ?> <?php echo $tip["ad"]; ?> <?php echo $sekil["baslik"]; ?>
                                        </a>
                                    </li> 
                                    <?php endforeach; ?> 
                                </ul>
                            </div>
                            
                            <?php endfor; ?>
                            
                        </div>
                        
                    </div>
                    <?php endforeach; ?>
                    
                    <!-- ALT KATEGORI -->
                    
                    <?php
        				$emlak_tipleri = $vt->query("SELECT * FROM emlak_ilantipi WHERE durum = 0 LIMIT 1,100")->fetchAll();
        				foreach ($emlak_tipleri AS $tip):
        			?>
                    <!-- AKTIF KATEGORI -->
                    <div class="tab-pane fade show" id="<?php echo $tip["seo"]; ?>" role="tabpanel" aria-labelledby="<?php echo $tip["seo"]; ?>-tab">
                    <div class="row">
                            <div class="col-lg-2">
                                <ul class="nav-navbar">
                                    <?php
                        				$emlak_sekilleri = $vt->query("SELECT * FROM emlak_ilansekli WHERE durum = 0")->fetchAll();
                        				foreach ($emlak_sekilleri AS $sekilad):
                        			?>
                                    <li class="nav-item">
                                        <a href="/ilanara/?emlaksekli=<?php echo $sekilad["id"]; ?>&emlaktipi=<?php echo $tip["id"]; ?>" title="<?php echo $tip["ad"]; ?> <?php echo $sekilad["baslik"]; ?>" class="nav-link">
                                           <?php echo $tip["ad"]; ?> <?php echo $sekilad["baslik"]; ?>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            
                            <?php
                                $s=0;
                                for ($i=0; $i<5; $i++): 
                            ?>
                            
                            <div class="col-lg">
                                <ul class="nav-navbar">
                                    <?php
                        			    	    
                            				$sekiller = $vt->query("SELECT * FROM emlak_ilansekli WHERE durum = 0")->fetchAll(); 
                			    	        foreach ($sekiller AS $sekil):
                        				   
                            				    $il = $vt->query("SELECT * FROM sehir WHERE ozet = 1 LIMIT ".$i.",1")->fetch(); 
                        				    
                        				    
                        			?>
                                    <li class="nav-item">
                                        <a href="/ilanara/?&il=<?php echo $il["sehir_key"]; ?>&emlaksekli=<?php echo $sekil["id"]; ?>&emlaktipi=<?php echo $tip["id"]; ?>"  title="<?php echo $il["adi"]; ?> <?php echo $tip["ad"]; ?> <?php echo $sekil["baslik"]; ?>" class="nav-link">
                                           <?php echo $il["adi"]; ?> <?php echo $tip["ad"]; ?> <?php echo $sekil["baslik"]; ?>
                                        </a>
                                    </li> 
                                    <?php endforeach; ?> 
                                </ul>
                            </div>
                            
                            <?php endfor; ?>
                            
                        </div>
                    </div>
                    <?php endforeach; ?>
                     
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="bg-light">
        <div class="footer-main">
            <div class="container">
                <div class="row">
					<div class="col-lg-4 col-md-6">
                        <p><strong><?=$site["firmadi"];?></strong></p>
						<p><?=$site["adres"];?></p>
                        <ul class="list-unstyled mb-0">
                            <li> <a href="mailto:<?=$site["email"];?>"><i class="fa fa-envelope mr-3"></i> <?=$site["email"];?></a></li>
                            <li> <a href="tel:<?=$site["sabittel"];?>"><i class="fa fa-phone mr-3"></i> <?=$site["sabittel"];?></a> </li> 
                        </ul>
                        <ul class="list-unstyled list-inline mt-3 mb-5">
							<?php 
								$ayarsitesosyal_stmt = $vt->query("SELECT ayar_sitesosyal.sosyallink, ayar_sosyal.icon FROM ayar_sitesosyal INNER JOIN ayar_sosyal ON ayar_sitesosyal.sosyalid=ayar_sosyal.id AND ayar_sitesosyal.siteid = '1' AND ayar_sosyal.durum = 0 AND ayar_sitesosyal.sosyallink != '' ORDER BY ayar_sosyal.sira ASC");
								while ($ayars=$ayarsitesosyal_stmt->fetch()) {
							?>
							<?php if ($ayars["sosyallink"] != "") { ?>
                            <li class="list-inline-item">
                                <a href="<?=$ayars["sosyallink"];?>" class="btn-floating btn-sm rgba-white-slight mx-1 waves-effect waves-light" target="_blank"> <i class="<?=$ayars["icon"];?>"></i> </a>
                            </li> 
							<?php } ?>
							<?php } ?>
                        </ul>
                    </div>
					<?php 
						$footerlink_stmt = $vt->query("SELECT * FROM altmenu where ustid = '0' order by sira asc");
						while ($footer = $footerlink_stmt->fetch()) { 
					?>
                    <div class="col-lg-2 col-md-6 col-6 mb-5">
                        <p><strong><?=$footer["baslik"];?></strong></p>
                        <ul class="list-unstyled mb-0">
							<?php 
								$footlink_stmt = $vt->prepare("SELECT * FROM altmenu where ustid = ?");
								$footlink_stmt->execute([$footer["id"]]);
								while ($link = $footlink_stmt->fetch()) { 
							?>
                            <?php if ($link["url"] != "") { ?>
                            <li><a href="<?=$link["url"];?>"><i class="fa fa-angle-right"></i> <?=$link["baslik"];?></a></li>
							<?php } else { ?>
                            <li><a href="<?=$link["seo"];?>"><i class="fa fa-angle-right"></i> <?=$link["baslik"];?></a></li>
                            <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>                    
                    <?php } ?>
					
					<div class="container">
						<div class="top-bar-right">
							
							<ul class="contact pull-right">
								<li class="dropdown mr-5"> <a href="#" class="text-dark" data-toggle="dropdown"><span> Dil Seçiniz <i class="fa fa-caret-down text-muted"></i></span> </a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										<a href="/#" onclick="doGTranslate('tr|tr');return false;" title="Turkish" class="gflag nturl" style="background-position: -100px -500px;">
											<i class="fa fa-angle-right"></i> Turkish
										</a>
										<a href="/#" onclick="doGTranslate('tr|en');return false;" title="English" class="gflag nturl" style="background-position: -0px -0px;">
											<i class="fa fa-angle-right"></i> English
										</a>
										<a href="/#" onclick="doGTranslate('tr|de');return false;" title="German" class="gflag nturl" style="background-position: -300px -100px;">
											<i class="fa fa-angle-right"></i> German
										</a>
										<a href="/#" onclick="doGTranslate('tr|fr');return false;" title="French" class="gflag nturl" style="background-position: -200px -100px;">
											<i class="fa fa-angle-right"></i> French
										</a>
										<a href="/#" onclick="doGTranslate('tr|ar');return false;" title="Arabic" class="gflag nturl" style="background-position: -100px -0px;">
											<i class="fa fa-angle-right"></i> Arabic
										</a>
										<a href="/#" onclick="doGTranslate('tr|hy');return false;" title="Armenian" class="gflag nturl" style="background-position: -400px -600px;">
											<i class="fa fa-angle-right"></i> Armenian
										</a>
										<a href="/#" onclick="doGTranslate('tr|az');return false;" title="Azerbaijani" class="gflag nturl" style="background-position: -500px -600px;">
											<i class="fa fa-angle-right"></i> Azerbaijani
										</a>
										<a href="/#" onclick="doGTranslate('tr|bg');return false;" title="Bulgarian" class="gflag nturl" style="background-position: -200px -0px;">
											<i class="fa fa-angle-right"></i> Bulgarian
										</a>
										<a href="/#" onclick="doGTranslate('tr|zh-CN');return false;" title="Chinese (Simplified)" class="gflag nturl" style="background-position: -300px -0px;">
											<i class="fa fa-angle-right"></i> Chinese
										</a>
										<a href="/#" onclick="doGTranslate('tr|cs');return false;" title="Czech" class="gflag nturl" style="background-position: -600px -0px;">
											<i class="fa fa-angle-right"></i> Czech
										</a>
										<a href="/#" onclick="doGTranslate('tr|el');return false;" title="Greek" class="gflag nturl" style="background-position: -400px -100px;">
											<i class="fa fa-angle-right"></i> Greek
										</a>
										<a href="/#" onclick="doGTranslate('tr|it');return false;" title="Italian" class="gflag nturl" style="background-position: -600px -100px;">
											<i class="fa fa-angle-right"></i> Italian
										</a>
										<a href="/#" onclick="doGTranslate('tr|ja');return false;" title="Japanese" class="gflag nturl" style="background-position: -700px -100px;">
											<i class="fa fa-angle-right"></i> Japanese
										</a>
										<a href="/#" onclick="doGTranslate('tr|fa');return false;" title="Persian" class="gflag nturl" style="background-position: -200px -500px;">
											<i class="fa fa-angle-right"></i> Persian
										</a>
										<a href="/#" onclick="doGTranslate('tr|pt');return false;" title="Portuguese" class="gflag nturl" style="background-position: -300px -200px;">
											<i class="fa fa-angle-right"></i> Portuguese
										</a>
										<a href="/#" onclick="doGTranslate('tr|ru');return false;" title="Russian" class="gflag nturl" style="background-position: -500px -200px;">
											<i class="fa fa-angle-right"></i> Russian
										</a>
										<a href="/#" onclick="doGTranslate('tr|es');return false;" title="Spanish" class="gflag nturl" style="background-position: -600px -200px;">
											<i class="fa fa-angle-right"></i> Spanish
										</a>
										<a href="/#" onclick="doGTranslate('tr|sv');return false;" title="Swedish" class="gflag nturl" style="background-position: -700px -200px;">
											<i class="fa fa-angle-right"></i> Swedish
										</a>
									</div>
								</li>
							</ul>
							
						</div>
					</div>
                </div>
            </div>
        </div>
        <div class="p-0">
            <div class="container">
                <div class="row d-flex">
                    <div class="col-lg-12 col-sm-12 mt-3 mb-3 text-center "> <?=$site["firmadi"];?> - Tüm hakları saklıdır. </div>
                </div>
            </div>
        </div>
    </footer>
	<script type="text/javascript">
	    function googleTranslateElementInit2() { new google.translate.TranslateElement({ pageLanguage: 'tr', autoDisplay: false }, 'google_translate_element2'); }
	</script>
	<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"></script>
	<script type="text/javascript">
	    /* <![CDATA[ */
	    eval(function (p, a, c, k, e, r) { e = function (c) { return (c < a ? '' : e(parseInt(c / a))) + ((c = c % a) > 35 ? String.fromCharCode(c + 29) : c.toString(36)) }; if (!''.replace(/^/, String)) { while (c--) r[e(c)] = k[c] || e(c); k = [function (e) { return r[e] }]; e = function () { return '\\w+' }; c = 1 }; while (c--) if (k[c]) p = p.replace(new RegExp('\\b' + e(c) + '\\b', 'g'), k[c]); return p }('6 7(a,b){n{4(2.9){3 c=2.9("o");c.p(b,f,f);a.q(c)}g{3 c=2.r();a.s(\'t\'+b,c)}}u(e){}}6 h(a){4(a.8)a=a.8;4(a==\'\')v;3 b=a.w(\'|\')[1];3 c;3 d=2.x(\'y\');z(3 i=0;i<d.5;i++)4(d[i].A==\'B-C-D\')c=d[i];4(2.j(\'k\')==E||2.j(\'k\').l.5==0||c.5==0||c.l.5==0){F(6(){h(a)},G)}g{c.8=b;7(c,\'m\');7(c,\'m\')}}', 43, 43, '||document|var|if|length|function|GTranslateFireEvent|value|createEvent||||||true|else|doGTranslate||getElementById|google_translate_element2|innerHTML|change|try|HTMLEvents|initEvent|dispatchEvent|createEventObject|fireEvent|on|catch|return|split|getElementsByTagName|select|for|className|goog|te|combo|null|setTimeout|500'.split('|'), 0, {}))
	    /* ]]> */
	</script>
<!-- AI Features JS -->
<script src="<?=TEMA_URL?>/assets/js/ai-features.js"></script>
