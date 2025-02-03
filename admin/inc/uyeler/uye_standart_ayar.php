<?php
echo !defined("ADMIN") ? die("Güvenlik Duvarı...") : null;
$islem = $_GET["islem"];
$dan = $vt->query("SELECT * FROM uye_standart_ayar WHERE yetki = 'danisman'")->fetch(PDO::FETCH_OBJ);
$bir = $vt->query("SELECT * FROM uye_standart_ayar WHERE yetki = 'bireysel'")->fetch(PDO::FETCH_OBJ);
$kur = $vt->query("SELECT * FROM uye_standart_ayar WHERE yetki = 'kurumsal'")->fetch(PDO::FETCH_OBJ);
?>
<section class="content-header">
    <i class="fa fa-user-circle-o fa-2x pull-left"></i>
    Standart Üyelik Ayarları
    <p> <small> Üye Standart Ayarlar </small> </p>
</section>
<?php
if (isset($_POST["kaydet"])) { ?>
    <section class="content">
        <?php
        $dan_aylik_limit 		    = $_POST["dan_aylik_limit"];
        $dan_resim_limit 		    = $_POST["dan_resim_limit"];
        $dan_ilan_sure 			    = $_POST["dan_ilan_sure"];
        $dan_ilan_sure_zaman 	    = $_POST["dan_ilan_sure_zaman"];
        $bireysel_aylik_limit 	    = $_POST["bireysel_aylik_limit"];
        $bireysel_resim_limit 	    = $_POST["bireysel_resim_limit"];
        $bireysel_ilan_sure 	    = $_POST["bireysel_ilan_sure"];
        $bireysel_ilan_sure_zaman	= $_POST["bireysel_ilan_sure_zaman"];
        $kurumsal_aylik_limit	 	= $_POST["kurumsal_aylik_limit"];
        $kurumsal_resim_limit	 	= $_POST["kurumsal_resim_limit"];
        $kurumsal_ilan_sure	 		= $_POST["kurumsal_ilan_sure"];
        $kurumsal_ilan_sure_zaman	= $_POST["kurumsal_ilan_sure_zaman"];
        $danisman_limit							= $_POST["danisman_limit"];
        // DANISMAN AYARI TABLO -> ID 1 = DANISMAN
        $kaydet_danisman = $vt->query("UPDATE uye_standart_ayar SET aylik_limit = '$dan_aylik_limit', resim_limit = '$dan_resim_limit', ilan_sure = '$dan_ilan_sure', ilan_sure_zaman = '$dan_ilan_sure_zaman', danisman_limit = '0' WHERE yetki = 'danisman'");
        $kaydet_bireysel = $vt->query("UPDATE uye_standart_ayar SET aylik_limit = '$bireysel_aylik_limit', resim_limit = '$bireysel_resim_limit', ilan_sure = '$bireysel_ilan_sure', ilan_sure_zaman = '$bireysel_ilan_sure_zaman', danisman_limit = '0' WHERE yetki = 'bireysel'");
        $kaydet_kurumsal = $vt->query("UPDATE uye_standart_ayar SET aylik_limit = '$kurumsal_aylik_limit', resim_limit = '$kurumsal_resim_limit', ilan_sure = '$kurumsal_ilan_sure', ilan_sure_zaman = '$kurumsal_ilan_sure_zaman', danisman_limit = '$danisman_limit' WHERE yetki = 'kurumsal'");
        go("index.php?do=uyeler/uye_standart_ayar&islem=onay",0);
        ?>
    </section>
<?php } ?>
<?php	if ($islem == "onay") { ?>
    <section class="content">
        <?php onay(); ?>
    </section>
<?php } ?>
<section class="content">
    <h6 class="alert alert-primary text-center"> <i class="fa fa-warning fa-lg"></i> Ücretsiz üyeler için olması gereken standart limitleri tanımlayabilirsiniz. Bu limitleri dolduran üyeler, hiçbir şekilde kullanım yapmaya devam edemezler. </h4>
        <br>
        <form class="form" action="" method="post">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"> Üyelik Ayarları </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label"> &nbsp; </label>
                            </div>
                            <div class="form-group">
                                <label class="control-label"> Aylık İlan Ekleme Limiti </label>
                            </div>
                            <div class="form-group">
                                <label class="control-label"> İlan Resim Ekleme Limiti </label>
                            </div>
                            <div class="form-group">
                                <label class="control-label"> İlan Yayın Süresi </label>
                            </div>
                            <div class="form-group">
                                <label class="control-label"> Danışman Ekleme Limiti </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label"> Danışman </label>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="dan_aylik_limit" value="<?php echo $dan->aylik_limit; ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="dan_resim_limit" value="<?php echo $dan->resim_limit; ?>">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" name="dan_ilan_sure" value="<?php echo $dan->ilan_sure; ?>">
                                    </div>
                                    <div class="col-md-5">
                                        <select class="form-control" name="dan_ilan_sure_zaman">
                                            <option selected="selected"> <?php echo $dan->ilan_sure_zaman; ?> </option>
                                            <option value="Gün"> Gün </option>
                                            <option value="Ay"> Ay </option>
                                            <option value="Yıl"> Yıl </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Danışman Ekleyemez" disabled class="form-control" name="" value="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label"> Bireysel </label>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="bireysel_aylik_limit" value="<?php echo $bir->aylik_limit; ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="bireysel_resim_limit" value="<?php echo $bir->resim_limit; ?>">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" name="bireysel_ilan_sure" value="<?php echo $bir->ilan_sure; ?>">
                                    </div>
                                    <div class="col-md-5">
                                        <select class="form-control" name="bireysel_ilan_sure_zaman">
                                            <option selected="selected"> <?php echo $bir->ilan_sure_zaman; ?> </option>
                                            <option value="Gün"> Gün </option>
                                            <option value="Ay"> Ay </option>
                                            <option value="Yıl"> Yıl </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Danışman Ekleyemez" disabled class="form-control" name="" value="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label"> Kurumsal </label>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="kurumsal_aylik_limit" value="<?php echo $kur->aylik_limit; ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="kurumsal_resim_limit" value="<?php echo $kur->resim_limit; ?>">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" name="kurumsal_ilan_sure" value="<?php echo $kur->ilan_sure; ?>">
                                    </div>
                                    <div class="col-md-5">
                                        <select class="form-control" name="kurumsal_ilan_sure_zaman">
                                            <option selected="selected"> <?php echo $kur->ilan_sure_zaman; ?> </option>
                                            <option value="Gün"> Gün </option>
                                            <option value="Ay"> Ay </option>
                                            <option value="Yıl"> Yıl </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="danisman_limit" value="<?php echo $kur->danisman_limit; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer text-right">
                    <button type="submit" class="btn btn-primary btn-lg" name="kaydet"> <i class="fa fa-save fa-lg"></i> <strong> Kaydet </strong> </button>
                </div>
            </div>
        </form>
</section>
<script>
    $(function () {
        $('#example1').DataTable()
        $('#example2').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false
        })
    })
</script>
<style media="screen">
    .control-label {
        padding-top: 15px !important;
    }
</style>