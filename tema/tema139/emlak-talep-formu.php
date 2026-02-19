<?php
    $talep = $_GET["talep"];
?>
<!doctype html>
<html class="no-js" lang="tr"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- set the page title -->
    <title>Emlak Talep Formu</title>
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
<?php include('ust.php'); ?> 

<div class="container sptb mb-8">
    <div class="pt-5 pb-5">
        <?php

            if (isset($_POST["talep1"])) {

                $adsoyad = $_POST["adsoyad"];
                $email = $_POST["email"];
                $tel = $_POST["tel"];
                $mesaj = $_POST["mesaj"];
                $tarih = date("d.m.Y");

                $minfiyat = $_POST["minfiyat"];
                $maxfiyat = $_POST["maxfiyat"];
                $fiyatkur = $_POST["fiyatkur"];                 

                $emlaktipi = $_POST["emlaktipi"];
                $kategori = $_POST["kategori"];
                $adres = $_POST["il"] ."," . $_POST["ilce"] ."," . $_POST["mahalle"];
                

                $stmt_talep1 = $vt->prepare("INSERT INTO emlak_mesajemlaktalep (adsoyad, tel, email, mesaj, tarih, taleptur, adres, emlaktipi, kategori, minfiyat, maxfiyat, fiyatkur) values (?,?,?,?,?,?,?,?,?,?,?,?)");
                $talep1 = $stmt_talep1->execute([$adsoyad, $tel, $email, $mesaj, $tarih, 'Gayrimenkul arıyorum', $adres, $emlaktipi, $kategori, $minfiyat, $maxfiyat, $fiyatkur]);

                if ($talep1 == true) {
                    echo '<h5 class="alert alert-success"><i class="fa fa-check fa-lg pull-left"></i> Talebiniz başarıyla gönderildi. En kısa sürede tarafınıza dönüş yapılacaktır.</h5>';
                }

            }
            
            if (isset($_POST["talep2"])) {

                $adsoyad = $_POST["adsoyad"];
                $email = $_POST["email"];
                $tel = $_POST["tel"];
                $mesaj = $_POST["mesaj"];
                $tarih = date("d.m.Y");             

                $emlaktipi = $_POST["emlaktipi"];
                $kategori = $_POST["kategori"];
                $adres = $_POST["il"] ."," . $_POST["ilce"] ."," . $_POST["mahalle"];
                
                $talepturu = $_POST["talepturu"];

                $stmt_talep2 = $vt->prepare("INSERT INTO emlak_mesajemlaktalep (adsoyad, tel, email, mesaj, tarih, taleptur, adres, emlaktipi, kategori) values (?,?,?,?,?,?,?,?,?)");
                $talep2 = $stmt_talep2->execute([$adsoyad, $tel, $email, $mesaj, $tarih, $talepturu, $adres, $emlaktipi, $kategori]);

                if ($talep2 == true) {
                    echo '<h5 class="alert alert-success"><i class="fa fa-check fa-lg pull-left"></i> Talebiniz başarıyla gönderildi. En kısa sürede tarafınıza dönüş yapılacaktır.</h5>';
                }

            }
            

        ?>
        <div class="row">
            <div class="col-md-6 mb-5">                  
                <div class="card">
                    <div class="card-body text-center p-8">
                        <div class="we ll alert alert-light">
                            <i class="fa fa-search fa-5x"></i>                              
                        </div>                          
                        <br>
                        <h5> Satılık veya kiralık gayrimenkul arıyorum.</h5>
                        <br>
                        <br>
                        <a class="btn btn-outline-danger btn-lg" href="/emlak-talep-formu/?talep=1"> <i class="fa fa-check"></i> <small>Talep Oluştur</small> </a>
                        <br>
                        <br>
                    </div>
                </div>
            </div>  
            <div class="col-md-6 mb-5">                  
                <div class="card">
                    <div class="card-body text-center p-8">
                        <div class="alert alert-light">
                            <i class="fa fa-plus fa-5x"></i>
                        </div>
                        <br>
                        <h5> Gayrimenkulümü satmak veya kiralamak istiyorum.</h5>
                        <br>
                        <br>
                        <a class="btn btn-outline-danger btn-lg" href="/emlak-talep-formu/?talep=2"> <i class="fa fa-check"></i> <small>Talep Oluştur</small> </a>
                        <br>
                        <br>
                    </div>
                </div>
            </div>
            <?php if ($talep == "1") { ?>
            <div class="col-md-12">                 
                <div class="card">
                    <div class="card-body">
                        <h5 class="alert alert-danger"><i class="fa fa-search fa-lg pull-left"></i> Satılık veya kiralık gayrimenkul arıyorum.</h5>
                        <form action="" method="POST" class="form-horizontal">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><i class="fa fa-list"></i> Kişisel Bilgiler</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="" method="POST" class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="control-label col-md-12 col-md-2">Ad Soyad</label>
                                                    <div class="col-md-12">
                                                        <input class="form-control" type="text" name="adsoyad">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-12 col-md-2">Telefon</label>
                                                    <div class="col-md-12">
                                                        <input class="form-control" type="text" name="tel">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-12 col-md-2">Email</label>
                                                    <div class="col-md-12">
                                                        <input class="form-control" type="text" name="email">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-12 col-md-2">Mesaj</label>
                                                    <div class="col-md-12">
                                                        <textarea class="form-control" name="mesaj" rows="4"></textarea>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>                                  
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><i class="fa fa-home"></i> Kriterler</h5>
                                        </div>
                                        <div class="card-body">
                                                <div class="form-group">
                                                    <label class="control-label col-md-12 col-md-2">İlan Tipi</label>
                                                    <div class="col-md-12">
                                                        <select name="emlaktipi" class="form-control">
                                                            <option>Seçiniz</option>
                                                            <?php
                                                                $stmt_ilantipi = $vt->query("SELECT * FROM emlak_ilantipi where durum = 0");
                                                                while($tip = $stmt_ilantipi->fetch()) {
                                                            ?>
                                                            <option value="<?=$tip["ad"];?>"><?=$tip["ad"];?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-12 col-md-2">Kategori</label>
                                                    <div class="col-md-12">
                                                        <select name="kategori" class="form-control">
                                                            <option>Seçiniz</option>
                                                            <?php
                                                                $stmt_katler = $vt->query("SELECT * FROM emlak_kategori where kat_ustid = 0 AND kat_durum = 1");
                                                                while($kat = $stmt_katler->fetch()) {
                                                            ?>
                                                                <optgroup label="<?=$kat["kat_adi"];?>">
                                                                <?php
                                                                    $stmt_katler2 = $vt->prepare("SELECT * FROM emlak_kategori where kat_ustid = ? AND kat_durum = 1");
                                                                    $stmt_katler2->execute([$kat["kat_id"]]);
                                                                    while($kat2 = $stmt_katler2->fetch()) {
                                                                ?>
                                                                <option value="<?=$kat2["kat_adi"];?>"><?=$kat2["kat_adi"];?></option>                                                              
                                                                <?php } ?>
                                                            </optgroup>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-12 col-md-2">Fiyat</label>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <input type="text" name="minfiyat" class="form-control" placeholder="Min Fiyat">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" name="maxfiyat" class="form-control" placeholder="Max Fiyat">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select name="fiyatkur" class="form-control">
                                                                    <?php
                                                                        $stmt_kur = $vt->query("SELECT * FROM para_birimi");
                                                                        while($kur = $stmt_kur->fetch()) {
                                                                    ?>
                                                                    <option value="<?=$kur["ad"];?>"><?=$kur["ad"];?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                  <label class="col-sm-2 control-label col-md-12">Bölge:</label> 
                                                  <div class="col-sm-12">
                                                      <div class="row">
                                                        <div class="col-sm-4"> 
                                                            <select name="il" id="il" class="form-control select2">
                                                                <option selected="selected"> İl Seçiniz </option> 
                                                                <?php 
                                                                    $stmt_iller = $vt->query("select * from sehir order by sehir_key asc");
                                                                    while($il=$stmt_iller->fetch()) {
                                                                ?>
                                                                <option value="<?=$il['sehir_key'];?>"> <?=$il['adi'];?> </option>
                                                                <?php } ?>
                                                            </select>
                                                          </div>
                                                          <div class="col-sm-4">  
                                                            <select name="ilce" id="ilce" class="form-control select2">
                                                                <option selected="selected"> İlçe </option>  
                                                            </select>
                                                          </div>
                                                          <div class="col-sm-4">
                                                            <select name="mahalle" id="mahalle" class="form-control select2">
                                                                <option selected="selected"> Mahalle </option>
                                                            </select>
                                                          </div>                          
                                                      </div>
                                                  </div>
                                                    <script type="text/javascript">
                                                        $(document).ready(function(){ 

                                                            $("#il").change(function(){
                                                            
                                                                var ilid = $(this).val();
                                                                $.ajax({
                                                                    type:"POST",
                                                                    url:"index.php?do=ajax_harita_talep",
                                                                    data:{"il":ilid},
                                                                    success:function(e){ 
                                                                        $("#ilce").html(e);
                                                                    }
                                                                }); 
                                                            });

                                                            $("#ilce").change(function(){
                                                            
                                                                var ilceid = $(this).val();
                                                                $.ajax({
                                                                    type:"POST",
                                                                    url:"index.php?do=ajax_harita_talep",
                                                                    data:{"ilce":ilceid},
                                                                    success:function(e){ 
                                                                        $("#mahalle").html(e);
                                                                    }
                                                                }); 
                                                            });
                                                        });
                                                    </script>
                                                </div>   
                                                <hr>
                                                <button name="talep1" type="submit" class="btn btn-success btn-lg pull-right"><i class="fa fa-send"></i> Talep Gönder</button>                                              
                                                <div class="clearfix"></div>
                                        </div>
                                    </div>                                  
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>      
            <?php } ?>
            <?php if ($talep == "2") { ?>
            <div class="col-md-12">                 
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST" class="form-horizontal">
                            <div class="row">
                                <div class="col-md-6 offset-md-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><i class="fa fa-list"></i> Satmak ya da Kiralamak İstiyorum</h5>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="alert alert-info"><i class="fa fa-plus fa-lg pull-left"></i> Gayrimenkulümü satmak veya kiralamak istiyorum.</h5>
                                            <form action="" method="POST" class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="control-label col-md-12">Ad Soyad</label>
                                                    <div class="col-md-12">
                                                        <input class="form-control" type="text" name="adsoyad">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-12">Telefon</label>
                                                    <div class="col-md-12">
                                                        <input class="form-control" type="text" name="tel">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-12">Email</label>
                                                    <div class="col-md-12">
                                                        <input class="form-control" type="text" name="email">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-12">İlan Tipi</label>
                                                    <div class="col-md-12">
                                                        <select name="emlaktipi" class="form-control">
                                                            <option>Seçiniz</option>
                                                            <?php
                                                                $stmt_ilantipi = $vt->query("SELECT * FROM emlak_ilantipi where durum = 0");
                                                                while($tip = $stmt_ilantipi->fetch()) {
                                                            ?>
                                                            <option value="<?=$tip["ad"];?>"><?=$tip["ad"];?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-12">Kategori</label>
                                                    <div class="col-md-12">
                                                        <select name="kategori" class="form-control">
                                                            <option>Seçiniz</option>
                                                            <?php
                                                                $stmt_katler = $vt->query("SELECT * FROM emlak_kategori where kat_ustid = 0 AND kat_durum = 1");
                                                                while($kat = $stmt_katler->fetch()) {
                                                            ?>
                                                                <optgroup label="<?=$kat["kat_adi"];?>">
                                                                <?php
                                                                    $stmt_katler2 = $vt->prepare("SELECT * FROM emlak_kategori where kat_ustid = ? AND kat_durum = 1");
                                                                    $stmt_katler2->execute([$kat["kat_id"]]);
                                                                    while($kat2 = $stmt_katler2->fetch()) {
                                                                ?>
                                                                <option value="<?=$kat2["kat_adi"];?>"><?=$kat2["kat_adi"];?></option>                                                              
                                                                <?php } ?>
                                                            </optgroup>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-12">Talep Türü</label>
                                                    <div class="col-md-12">
                                                        <select name="talepturu" class="form-control">
                                                            <option>Seçiniz</option>                                                                
                                                            <option value="Gayrimenkul Satmak İstiyorum">Gayrimenkul Satmak İstiyorum</option>
                                                            <option value="Gayrimenkul Kiralamak İstiyorum">Gayrimenkul Kiralamak İstiyorum</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                  <label class="col-md-3 control-label col-md-12">Bölge:</label> 
                                                  <div class="col-md-12">
                                                      <div class="row">
                                                        <div class="col-sm-4"> 
                                                            <select name="il" id="il" class="form-control select2">
                                                                <option selected="selected"> İl Seçiniz </option> 
                                                                <?php 
                                                                    $stmt_iller = $vt->query("select * from sehir order by sehir_key asc");
                                                                    while($il=$stmt_iller->fetch()) {
                                                                ?>
                                                                <option value="<?=$il['sehir_key'];?>"> <?=$il['adi'];?> </option>
                                                                <?php } ?>
                                                            </select>
                                                          </div>
                                                          <div class="col-sm-4">  
                                                            <select name="ilce" id="ilce" class="form-control select2">
                                                                <option selected="selected"> İlçe </option>  
                                                            </select>
                                                          </div>
                                                          <div class="col-sm-4">
                                                            <select name="mahalle" id="mahalle" class="form-control select2">
                                                                <option selected="selected"> Mahalle </option>
                                                            </select>
                                                          </div>                          
                                                      </div>
                                                  </div>
                                                    <script type="text/javascript">
                                                        $(document).ready(function(){ 

                                                            $("#il").change(function(){
                                                            
                                                                var ilid = $(this).val();
                                                                $.ajax({
                                                                    type:"POST",
                                                                    url:"index.php?do=ajax_harita_talep",
                                                                    data:{"il":ilid},
                                                                    success:function(e){ 
                                                                        $("#ilce").html(e);
                                                                    }
                                                                }); 
                                                            });

                                                            $("#ilce").change(function(){
                                                            
                                                                var ilceid = $(this).val();
                                                                $.ajax({
                                                                    type:"POST",
                                                                    url:"index.php?do=ajax_harita_talep",
                                                                    data:{"ilce":ilceid},
                                                                    success:function(e){ 
                                                                        $("#mahalle").html(e);
                                                                    }
                                                                }); 
                                                            });
                                                        });
                                                    </script>
                                                </div> 
                                                <div class="form-group">
                                                    <label class="control-label col-md-12">Talep Mesajı</label>
                                                    <div class="col-md-12">
                                                        <textarea class="form-control" name="mesaj" rows="4"></textarea>
                                                    </div>
                                                </div>  
                                                <hr>
                                                <button name="talep2" type="submit" class="btn btn-success btn-lg pull-right"><i class="fa fa-send"></i> Talep Gönder</button>                                              
                                                <div class="clearfix"></div>
                                            </form>
                                        </div>
                                    </div>                                  
                                </div> 
                            </div>
                        </div>
                    </form>
                </div>
            </div>      
            <?php } ?>
        </div>
    </div>
</div>



<section>
<?php include("footer.php"); ?>    
</section>
<?php include("alt.php"); ?>
</body>
<!-- Mirrored from www.spruko.com/demo/reallist/htm/Reallist-LTR/Html/ by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 05 Apr 2020 15:27:18 GMT -->
</html>