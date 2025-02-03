<style type=""text/css"">
    hr {
        margin:1rem 0;
    }
</style>
<?php   
    if ($_SESSION["uyelogin"] == false) {go("index.php?do=hesabim&islem=girisyap",0);}
    $uyelik = mysql_query("SELECT * FROM yonetici where id = '".$_SESSION["id"]."'");
    $uye = mysql_fetch_array($uyelik);

    $uye_id = $_SESSION["id"];

?>

<section class="">
    <div class="row"> 
        <div class="col-md-3">
            <div class="card">
                <?php include 'uye-menu.php'; ?>
            </div>
        </div>
        <div class="col-md-9">
            
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><strong>Mağaza Paketim</strong></h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive border-top">
                        <table class="table table-bordered table-hover text-nowrap">
                            <tbody>

                                <?php 
                                    $magaza_uye_paket = $vt->query("SELECT * FROM magaza_uye_paket WHERE uye_id = '$uye_id'")->fetchAll();
                                    foreach ($magaza_uye_paket as $paket) {
                                ?>
                                <tr>
                                    <th colspan="2">Paket Detayları</th>
                                    <th class="text-center">Periyot</th>
                                    <th class="text-center">Durum</th>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white" colspan="4"><i class="fa fa-dropbox"></i> <?php echo $paket["paket_adi"]; ?></th>
                                </tr>
                                <tr>
                                    <td class="text-right">                                        
                                        İlan Ekleme Limiti (Aylık):
                                        <hr>
                                        İlan Başına Resim:
                                        <hr>
                                        İlan Yayın Süresi:
                                        <hr>
                                        Danışman Limiti:
                                        <hr>
                                        Özel Firma Profil Sayfası:
                                        <hr>
                                        İlanlara Danışman Atama:

                                    </td>
                                    <td>                                        
                                        <strong><?php echo $paket["aylik_limit"]; ?> Adet</strong>
                                        <hr>
                                        <p><strong><?php echo $paket["resim_limit"]; ?> Adet</strong> </p>
                                        <hr>
                                        <p><strong><?php echo $paket["ilan_sure"]; ?> <?php echo $paket["ilan_sure_zaman"]; ?></strong> </p>
                                        <hr>
                                        <p><strong><?php echo $paket["danisman_limit"]; ?> Adet</strong> </p>
                                        <hr>
                                        <p><strong>Aktif</strong> </p>
                                        <hr>
                                        <p><strong>Aktif</strong> </p>

                                    </td>
                                    <td class="text-center">
                                        
                                        <p><?php echo $paket["periyot_sure"]; ?> <?php echo $paket["periyot_sure_zaman"]; ?></p>

                                        <hr>

                                        <p><strong>BAŞLANGIÇ TARİHİ: <?php echo $paket["baslangic_tarihi"]; ?></strong></p>

                                        <hr>

                                        <p><strong>BİTİŞ TARİHİ: <?php echo $paket["bitis_tarihi"]; ?></strong></p>

                                        <hr>

                                        <p>SİPARİŞ NO: <strong><?php echo $paket["siparis_no"]; ?></strong></p>

                                        <hr>
                                        
                                    </td>
                                    <td class="text-center">

                                        <?php if ($paket["onay"] == 1) { ?>

                                        <a href="#" class="badge badge-danger btn-block"><strong>AKTİF</strong></a>

                                        <br>

                                        <br>

                                        <p class="badge badge-danger btn-block"><strong><?php echo kalan_sure(date("Y-m-d"), $paket["bitis_tarihi"]); ?> Gün Kaldı.</strong></p>

                                        <?php } else { ?>

                                        <a href="#" class="badge badge-danger btn-block"><strong>PASİF</strong></a>

                                        <?php } ?>


                                    </td>
                                </tr>
                                <tr>
                                    
                                    <th colspan="1">
                                        <small>Sipariş Tarihi: <strong><?php echo $paket["siparis_tarihi"]; ?></strong></small>
                                    </th>
                                    
                                    <th colspan="1">
                                        <small>Ödeme Yöntemi: <strong><?php echo $paket["odeme_tipi"]; ?></strong></small>
                                    </th>
                                    
                                    <th colspan="1">
                                        <small>
                                            
                                            Ödeme Durumu: 

                                            <?php if ($paket["onay"] == 1) { ?>

                                            <strong>Ödendi</strong>

                                            <?php } else { ?>

                                            <strong>Ödeme Bekliyor</strong>

                                            <?php } ?>

                                        </small>
                                    </th>
                                    
                                    <th class="text-center" colspan="1">
                                        <small>FİYAT</small>: <small><?php echo $paket["fiyat"]; ?> <?php echo $paket["fiyat_kur"]; ?> </small>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="bg-light" colspan="4"><strong></strong></th>                                    
                                </tr>
                                <?php } ?>
                                <tr>
                                    <th colspan="3">

                                        <strong>TOPLAM ÖDEME</strong>

                                    </th>
                                    <th class="text-center bg-danger text-white" colspan="1">
                                        <strong>

                                        <?php 

                                            $toplam_fiyat = $vt->query("SELECT * FROM magaza_uye_paket WHERE uye_id = '$uye_id'")->fetchAll();
                                             
                                            $tutar = 0;

                                            foreach ($toplam_fiyat as $toplam) {
                                                $tutar = $tutar + $toplam["fiyat"];
                                            }
                                             
                                            echo $tutar." TL";

                                        ?>

                                        </strong>
                                    </th>                                    
                                </tr>
                            </tbody>
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
</section>