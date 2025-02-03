<?php 
	echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null; 
	uyeYasak(yetki());
	$islem =  @$_GET["islem"];
	$hareket =  @$_GET["hareket"];  
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <i class="fa fa-user-o fa-2x pull-left"></i> Üyelik Sözleşmesi
    <p> <small> Üyelik Sözleşmesi </small> </p>
</section>
<section class="content">
    <?php 
	if (isset($_POST["kaydet"])) { 
		$uyelik_sozlesmesi = addslashes($_POST["uyelik_sozlesmesi"]);
		$gizlilik = mysql_real_escape_string($_POST["gizlilik"]);
		$ilan_verme_kurallari= mysql_real_escape_string($_POST["ilan_verme_kurallari"]);
		$mailayarkaydet = mysql_query("UPDATE ayar_site SET uyelik_sozlesmesi = '$uyelik_sozlesmesi', gizlilik = '$gizlilik', ilan_verme_kurallari = '$ilan_verme_kurallari' where id = '1'");
		go("index.php?do=islem&webmaster=uyelik_sozlesmesi&hareket=onay",0);		
	}
?>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                <?php 
					if ($hareket == "onay") {
						onay();
					} 
				?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-check"></i> Üyelik Sözleşmesi </h3>
                    </div>
                    <div class="box-body pad" style="">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Sözleşme Metni:</label>
                                <div class="col-sm-12">
                                    <textarea id="uyelik_sozlesmesi" name="uyelik_sozlesmesi" rows="15" cols="80"><?php echo $site["uyelik_sozlesmesi"]; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="kaydet" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Kaydet </button>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-check"></i> Gizlilik Politikası </h3>
                    </div>
                    <div class="box-body pad" style="">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Politika Metni:</label>
                                <div class="col-sm-12">
                                    <textarea id="gizlilik" name="gizlilik" rows="15" cols="80"><?php echo $site["gizlilik"]; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="kaydet" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Kaydet </button>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-check"></i> İlan Verme Kuralları </h3>
                    </div>
                    <div class="box-body pad" style="">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Kurallar:</label>
                                <div class="col-sm-12">
                                    <textarea id="ilan_verme_kurallari" name="ilan_verme_kurallari" rows="15" cols="80"><?php echo $site["ilan_verme_kurallari"]; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="kaydet" class="btn btn-primary btn-lg pull-right"> <i class="fa fa-check"></i> Kaydet </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>