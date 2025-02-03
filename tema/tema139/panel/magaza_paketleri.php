<?php	
	if ($_SESSION["uyelogin"] == false) {go("index.php?do=hesabim&islem=girisyap",0);}
	$uyelik = mysql_query("SELECT * FROM yonetici where id = '".$_SESSION["id"]."'");
	$uye = mysql_fetch_array($uyelik);

?>

    <section class="">
        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><strong>Mağaza Paketleri</strong></h3>
                    </div>
                </div>
                <div class="row">

                    <?php 
                    
                        $magaza_paketleri = $vt->query("SELECT * FROM magaza_paket WHERE id ORDER BY sira ASC")->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($magaza_paketleri as $paket) {

                    ?>

                    <div class="col-md-3 col-lg-3">
                        <div class="card text-center mb-md-0">
                            <div class="card-header text-center mx-auto">
                                <h3 class="card-title font-weight-bold" style="font-size:26px; padding:15px 0;">
                                    <?php echo $paket["paket_adi"]; ?>
                                </h3>
                            </div>
                            <div class="card-body">

                                <h1 class="pricing-card-title mb-5">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">12 $ </font>
                                    </font><small class="text-muted fs-20"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">/ aylık</font></font></small>
                                </h1>

                                <hr>

                                <div class="box-body">
                                    <h6>İlan Ekleme Limiti: <strong><?php echo $paket["aylik_limit"]; ?> Adet (Aylık)</strong></h6>
                                    <hr>
                                    <h5>İlan Başına Resim: <strong><?php echo $paket["resim_limit"]; ?> Adet</strong></h5>
                                    <hr>
                                    <h5>İlan Yayın Süresi: <strong><?php echo $paket["ilan_sure"]; ?> <?php echo $paket["ilan_sure_zaman"]; ?></strong></h5>
                                    <hr>
                                    <h5>Danışman: <strong><?php echo $paket["danisman_limit"]; ?> Adet</strong></h5>
                                    <hr>
                                    <h5>Özel Firma Profil Sayfası</h5>
                                    <hr>
                                    <h5>İlanlara Danışman Atama</h5>
                                </div>

                                <hr>

                                <a href="#" class="btn btn-block btn-lg btn-primary"><strong>SATIN AL</strong></a>

                            </div>
                        </div>
                    </div>

                    <?php } ?>

                    <div class="col-md-3 col-lg-3">
                        <div class="card text-center mb-md-0 overflow-hidden">
                            <div class="card-status bg-primary"></div>
                            <div class="ribbon ribbon-top-left text-danger"> <span class="bg-danger"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Yeni</font></font></span> </div>
                            <div class="card-header text-center mx-auto">
                                <h3 class="card-title font-weight-bold">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">profesyonel</font>
                                    </font>
                                </h3>
                            </div>
                            <div class="card-body">
                                <h1 class="pricing-card-title mb-5">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">25 $ </font>
                                    </font><small class="text-muted fs-20"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">/ aylık</font></font></small></h1>
                                <p class="mb-5">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">Sed ut perspiciatis unde omnis iste natus hata oturmak voluptatem accusantium doloremque laudantium</font>
                                    </font>
                                </p><button class="btn btn-secondary" type="button"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Şimdi üye Ol</font></font></button> </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>