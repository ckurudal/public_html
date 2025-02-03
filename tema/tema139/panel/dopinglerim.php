<style type="text/css">
    hr {
        margin:1rem 0;
    }
</style>
<?php   
    if ($_SESSION["uyelogin"] == false) {go("index.php?do=hesabim&islem=girisyap",0);}
    $uyelik = mysql_query("SELECT * FROM yonetici where id = '".$_SESSION["id"]."'");
    $uye = mysql_fetch_array($uyelik);

    $uye_id = $_SESSION["id"];

    $tarih = date('Y-m-d');

?>

<div class="row"> 
    <div class="col-md-3">
        <div class="card">
            <?php include 'uye-menu.php'; ?>
        </div>
    </div>
    <div class="col-md-9">
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><strong>Dopinglerim</strong></h3>
            </div>
            <div class="card-body">
               
                <div class="panel-group1" id="accordion2">
                    <?php 

                        $ilan_doping = $vt->query("SELECT * FROM emlak_ilan WHERE doping = 'var' AND yonetici_id = '".$_SESSION["id"]."'")->fetchAll();
                        foreach ($ilan_doping as $ilan) {
                    ?>
                    <div class="panel panel-default mb-4 border p-0">
                        <div class="panel-heading1 bg-light">
                            <h4 class="panel-title1">
                                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo $ilan["id"]; ?>" aria-expanded="false">
                                    <i class="fa fa-plus"></i> <?php echo $ilan["baslik"]; ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse<?php echo $ilan["id"]; ?>" class="panel-collapse active collapse" role="tabpanel" aria-expanded="false" style="">
                            <div class="panel-body bg-white">
                                <table class="table table-bordered table-hover table-striped text-nowrap">
                                    <tr>
                                        <th>Doping</th>
                                        <th class="text-center">Tutar</th>
                                        <th class="text-center">Durum</th>
                                    </tr>

                                    <?php 

                                        $tutar_tek = 0;

                                        $doping_getir = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '".$ilan["id"]."'")->fetchAll();

                                        foreach ($doping_getir as $doping) {

                                    ?>

                                    <tr>
                                        <td>
                                            <?php 
                                                $doping_adi = $doping['doping_adi'];

                                                if ($doping_adi=="sicak_firsat") {$adi = "Sıcak Fırsatlarda Göster";}
                                                if ($doping_adi=="vitrin_ilan") {$adi = "Vitrin İlanlarında Göster";}
                                                if ($doping_adi=="one_cikan") {$adi = "Öne Çıkan İlanlarda Göster";}
                                                if ($doping_adi=="ust_sira") {$adi = "Üst Sıralarda Listele";}
                                                if ($doping_adi=="renkli_bold") {$adi = "Listelerde Renli Yazı Göster";}
                                                if ($doping_adi=="acil_ilan") {$adi = "Anasayfa Acil İlanlarda Göster";}
                                                
                                                echo "<strong>".$adi."</strong>";
                                            ?>

                                            
                                        </td>
                                        <td class="text-center">
                                            <p>(<?php echo $doping["sure"]; ?> <?php echo $doping["sure_zaman"]; ?>)</p>                                            
                                            <p><strong><?php echo $doping["fiyat"]; ?> TL</strong></p>
                                        </td>
                                        <td class="text-center">

                                            <?php if ($ilan["doping_onay"] == 1) { ?>
                                                <p><span class="badge badge-danger">Aktif</span></p>
                                                <p><strong><?php kalan_sure($tarih, $doping["bitis_tarihi"]); ?> Gün Kaldı</strong></p>
                                            <?php } else { ?>
                                                <p><span class="badge badge-danger">Pasif</span></p>
                                            <?php } ?>

                                        </td>
                                    </tr>

                                    <?php $tutar_tek = $tutar_tek + $doping["fiyat"]; ?>

                                    <?php } ?>

                                    <tr>
                                        
                                        <td colspan="1">
                                            <br>
                                            <p>İŞLEM TARİHİ: <strong><?php echo $doping["tarih"]; ?></strong></p>
                                            <br>
                                        </td>
                                        <td colspan="1" class="text-center">
                                            <br>
                                            <p>ÖDEME TİPİ: <strong><?php echo $doping["odeme_tipi"]; ?></strong></p>
                                            <br>
                                        </td>
                                        <td colspan="1" class="text-center">
                                            <br>
                                            <p>ÖDEME DURUMU: <strong><?php echo $doping["odeme_durumu"]; ?></strong></p>
                                            <br>
                                        </td>

                                    </tr>

                                    <tr>
                                        
                                        <th colspan="2">

                                            İlan Doping Tutarı: 

                                        </th>
                                        <th colspan="1" class="text-right bg-light">

                                            <?php echo $tutar_tek; ?> TL

                                        </th>

                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>

                    <?php } ?>

                    <?php 
                         
                        $tutar = 0;
                        $ilan_doping_topla = $vt->query("SELECT * FROM emlak_ilan WHERE doping = 'var' AND yonetici_id = '".$_SESSION["id"]."'")->fetchAll();
                        foreach ($ilan_doping_topla as $ilan) { 

                        $doping_topla = $vt->query("SELECT * FROM doping_ilanlari WHERE ilan_id = '".$ilan["id"]."'")->fetchAll();
                        foreach ($doping_topla as $doping) { 

                        $tutar = $tutar + $doping["fiyat"]; 

                    } } ?>                    


                    <table class="table table-bordered table-hover table-striped text-nowrap">
                        <tr>
                            <th><strong>TOPLAM DOPİNG TUTARI</strong></th>
                            <th class="text-right bg-light"><?php echo $tutar; ?> TL</th>
                        </tr>
                    </table>

                </div>

                <ul class="pagination d-none">
                    <li class="page-item page-prev disabled"><a class="page-link" href="#" tabindex="-1">Prev</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item page-next"><a class="page-link" href="#">Next</a></li>
                </ul>
            </div>
        </div>

    </div> 
</div>