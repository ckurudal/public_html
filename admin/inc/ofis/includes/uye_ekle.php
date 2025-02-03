<?php

    $uye_standart_ayar = $vt->prepare("SELECT * FROM  uye_standart_ayar WHERE yetki = 'kurumsal'");
    $uye_standart_ayar->execute();
    $standart_limit = $uye_standart_ayar->fetch(PDO::FETCH_ASSOC);

    $yoneticiler = $vt->prepare("SELECT * FROM  yonetici WHERE yetki = 0");
    $yoneticiler->execute();
    $yonetici = $yoneticiler->fetch(PDO::FETCH_ASSOC);

?>
<form action="" method="post" enctype="multipart/form-data">
    <?php if (yetki() != 0): ?>
        <section class="content">
            <?php if (yetki() == 2): ?>
                <div class="box">
                    <div class="alert alert-primary text-center">
                        <h6>Toplam
                            <?php if (uyePaketSuresi($_SESSION["id"])>0): ?>
                                <strong class="badge"><?php echo m_danisman_say($sube_bul["id"]); ?> / <?php echo danismanLimit($_SESSION["id"]); ?></strong>
                            <?php else: ?>
                                <strong class="badge"><?php echo m_danisman_say($sube_bul["id"]); ?> / <?php echo $standart_limit["danisman_limit"]; ?></strong>
                            <?php endif; ?>
                            adet danışman ekleyebilirsiniz. Daha fazla eklemek için üyelik paketi satın alabilirsiniz.
                        </h6>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (yetki() == 2 AND uyePaketSuresi($_SESSION["id"])>0): ?>
                <?php if (m_danisman_say($sube_bul["id"])>=danismanLimit($_SESSION["id"])): ?>
                    <div class="alert alert-danger text-center">
                        <h5> <i class="fa fa-warning fa-3x"></i> </h5>
                        <h3>Uyarı(!) <br></h3>
                        <h5>Danışman liminiti aştınız. Ekleyebilmeniz için üyelik paketi satın almanız gerekmektedir.</h5>
                        <br>
                        <a href="index.php?do=siparisler/siparisler&paket=magaza" class="btn btn-inverse btn-lg"> <i class="fa fa-arrow-left"></i> <strong;> ÜYELİK PAKETLERİ </a>
                        <br>
                        <br>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><i class="fa fa-check"></i> Yeni Ekle </h3>
                                    <!-- tools box -->
                                    <div class="pull-right box-tools">
                                        <a href="#" class="btn btn-  btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Daralt">
                                            <i class="fa fa-minus"></i></a>
                                        <a type="button" class="btn btn-  btn-sm" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Kapat">
                                            <i class="fa fa-times"></i></a>
                                    </div>
                                    <!-- /. tools -->
                                </div>
                                <div class="box-body" style="">
                                    <div class="form-horizontal">
                                        <div class="col-sm-4">
                                            <label class="control-label"><?php if ($uyeekle == "kurumsal") {echo "Yetkili ";} ?>Adı Soyadı:</label>
                                            <input type="text" class="form-control" name="adsoyad">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="control-label">Üyelik Tipi:</label>
                                            <?php if ($uyeekle=="bireysel") { ?>
                                                <label for="yetki" class="hidden">
                                                    <input type="radio" name="yetki" checked value="1" class="minimal">
                                                    Bireysel Üye
                                                </label>
                                                <input type="text" name="uyelik_tipi" disabled="" placeholder="Bireysel" class="form-control">
                                            <?php } ?>
                                            <?php if ($uyeekle=="kurumsal") { ?>
                                                <label for="yetki" class="hidden">
                                                    <input type="radio" name="yetki" checked value="2" class="minimal">
                                                    Kurumsal Üye
                                                </label>
                                                <input type="text" name="uyelik_tipi" disabled="" placeholder="Kurumsal" class="form-control">
                                            <?php } ?>
                                            <?php if ($uyeekle=="danisman") { ?>
                                                <label for="yetki" class="hidden">
                                                    <input type="radio" name="yetki" checked value="3" class="minimal">
                                                    Danışman
                                                </label>
                                                <input type="text" name="uyelik_tipi" disabled="" placeholder="Danışman" class="form-control">
                                            <?php } ?>
                                            <?php if ($uyeekle=="yonetici") { ?>
                                                <label for="yetki" class="hidden">
                                                    <input type="radio" name="yetki" checked value="0" class="minimal">
                                                    Yönetici
                                                </label>
                                                <input type="text" name="uyelik_tipi" disabled="" placeholder="Yönetici" class="form-control">
                                            <?php } ?>
                                        </div>
                                        <?php if ($uyeekle == "kurumsal") { ?>
                                            <div class="col-sm-4">
                                                <label class="control-label">Firma Adı (Emlak Ofisi):</label>
                                                <input type="text" class="form-control" name="firmadi">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label">Firma Ünvan:</label>
                                                <input type="text" name="firmaunvan" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label">Vergi No:</label>
                                                <input type="text" name="vergino" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label">Vergi Dairesi:</label>
                                                <input type="text" name="vergidairesi" class="form-control">
                                            </div>
                                        <?php } ?>
                                        <!--
							<div class="form-group">
							  <label class="col-sm-2 control-label">Çalıştığı Şube:</label>
							  <div class="col-sm-10">
								<select class="form-control select2" name="ofis">
									<option value="">Seçiniz</option>
									<?php
                                        $subeler = mysql_query("SELECT * FROM subeler where id");
                                        while ($sube=mysql_fetch_array($subeler)) {
                                            ?>
									<?php
                                            if ($sube["durum"] == 0) {
                                                ?>
									<option value="<?=$sube["id"];?>"><?=$sube["adi"];?></option>
									<?php } ?>
									<?php } ?>
								</select>
							  </div>
							</div>
							-->
                                        <div class="col-sm-4">
                                            <label class="control-label">Üye Ünvan:</label>
                                            <select class="form-control selec t2" name="unvan">
                                                <option value="">Seçiniz</option>
                                                <?php
                                                $unvanlar = mysql_query("SELECT * FROM yonetici_unvan where id");
                                                while ($unvan=mysql_fetch_array($unvanlar)) {
                                                    ?>
                                                    <?php
                                                    if ($unvan["durum"] == 0) {
                                                        ?>
                                                        <option value="<?=$unvan["baslik"];?>"><?=$unvan["baslik"];?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div><div class="col-sm-4">
                                            <label class="control-label">Email:</label>
                                            <input type="text" class="form-control" name="email">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="control-label">Şifre:</label>
                                            <input type="password" name="pass" class="form-control">
                                        </div>
                                        <div class="col-sm-8">
                                            <label class="control-label">Profil Resmi Seç:</label>
                                            <input type="file" class="form-control" name="resim[]"/>
                                        </div>
                                        <?php if(yetki() == 0): ?>
                                            <div class="col-sm-4">
                                                <label class="control-label">Sıra:</label>
                                                <input type="text" class="form-control" name="sira">
                                            </div>
                                        <?php endif; ?>
                                        <!--
                                        <div class="col-sm-4">
                                            <label class="control-label">Aylık İlan Ekleme Limiti:</label>
                                              <input type="text" class="form-control" name="aylik_limit">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="control-label">Aylık Resim Ekleme Limiti:</label>
                                              <input type="text" class="form-control" name="resim_limit">
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="control-label">İlan Yayın Süresi:</label>
                                              <input type="text" class="form-control" name="ilan_sure">
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="control-label"> &nbsp; </label>
                                              <select class="form-control" name="ilan_sure_zaman">
                                                  <option value="Gün"> Gün </option>
                                                  <option value="Ay"> Ay </option>
                                                  <option value="Yıl"> Yıl </option>
                                              </select>
                                        </div>
                                        -->
                                        <div class="col-sm-4">
                                            <label class="control-label">Tel:</label>
                                            <input type="text" name="tel" class="form-control">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="control-label">Telefon 2:</label>
                                            <input type="text" name="gsm" class="form-control">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="control-label">Fax (Varsa):</label>
                                            <input type="text" name="fax" class="form-control">
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="control-label">Hakkında:</label>
                                            <textarea id="editor1" name="aciklama" rows="15" cols="80"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title"> Sosyal Medya Hesapları </h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body pad">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <?php
                                            $sosyalmedya = mysql_query("SELECT * FROM ayar_sosyal order by sira asc");
                                            while ($sosyal=mysql_fetch_array($sosyalmedya)) {
                                                ?>
                                                <div class="col-sm-12">
                                                    <label class="control-label"><?=$sosyal["baslik"];?>:</label>
                                                    <input type="text" class="form-control hidden" name="sosyalbaslik[]" value="<?=$sosyal["baslik"];?>">
                                                    <input type="text" class="form-control hidden" name="sosyalid[]" value="<?=$sosyal["id"];?>">
                                                    <input type="text" class="form-control" name="sosyallink[]" value="">
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <?php if ($uyeekle == "kurumsal") { ?>
                                        <button type="submit" class="btn btn-success btn-lg btn-block" name="yoneticieklekurumsal"> <i class="fa fa-check"></i> Yeni Ekle </button>
                                    <?php } else { ?>
                                        <button type="submit" class="btn btn-success btn-lg btn-block" name="yoneticiekle"> <i class="fa fa-check"></i> Yeni Ekle </button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <?php if (m_danisman_say($sube_bul["id"])>=$standart_limit["danisman_limit"]): ?>
                    <div class="alert alert-danger text-center">
                        <h5> <i class="fa fa-warning fa-3x"></i> </h5>
                        <h3>Uyarı(!) <br></h3>
                        <h5>Danışman liminiti aştınız. Ekleyebilmeniz için üyelik paketi satın almanız gerekmektedir.</h5>
                        <br>
                        <a href="index.php?do=siparisler/siparisler&paket=magaza" class="btn btn-inverse btn-lg"> <i class="fa fa-arrow-left"></i> <strong;> ÜYELİK PAKETLERİ </a>
                        <br>
                        <br>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><i class="fa fa-check"></i> Yeni Ekle </h3>
                                    <!-- tools box -->
                                    <div class="pull-right box-tools">
                                        <a href="#" class="btn btn-  btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Daralt">
                                            <i class="fa fa-minus"></i></a>
                                        <a type="button" class="btn btn-  btn-sm" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Kapat">
                                            <i class="fa fa-times"></i></a>
                                    </div>
                                    <!-- /. tools -->
                                </div>
                                <div class="box-body" style="">
                                    <div class="form-horizontal">
                                        <div class="col-sm-4">
                                            <label class="control-label"><?php if ($uyeekle == "kurumsal") {echo "Yetkili ";} ?>Adı Soyadı:</label>
                                            <input type="text" class="form-control" name="adsoyad">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="control-label">Üyelik Tipi:</label>
                                            <?php if ($uyeekle=="bireysel") { ?>
                                                <label for="yetki" class="hidden">
                                                    <input type="radio" name="yetki" checked value="1" class="minimal">
                                                    Bireysel Üye
                                                </label>
                                                <input type="text" name="uyelik_tipi" disabled="" placeholder="Bireysel" class="form-control">
                                            <?php } ?>
                                            <?php if ($uyeekle=="kurumsal") { ?>
                                                <label for="yetki" class="hidden">
                                                    <input type="radio" name="yetki" checked value="2" class="minimal">
                                                    Kurumsal Üye
                                                </label>
                                                <input type="text" name="uyelik_tipi" disabled="" placeholder="Kurumsal" class="form-control">
                                            <?php } ?>
                                            <?php if ($uyeekle=="danisman") { ?>
                                                <label for="yetki" class="hidden">
                                                    <input type="radio" name="yetki" checked value="3" class="minimal">
                                                    Danışman
                                                </label>
                                                <input type="text" name="uyelik_tipi" disabled="" placeholder="Danışman" class="form-control">
                                            <?php } ?>
                                            <?php if ($uyeekle=="yonetici") { ?>
                                                <label for="yetki" class="hidden">
                                                    <input type="radio" name="yetki" checked value="0" class="minimal">
                                                    Yönetici
                                                </label>
                                                <input type="text" name="uyelik_tipi" disabled="" placeholder="Yönetici" class="form-control">
                                            <?php } ?>
                                        </div>
                                        <?php if ($uyeekle == "kurumsal") { ?>
                                            <div class="col-sm-4">
                                                <label class="control-label">Firma Adı (Emlak Ofisi):</label>
                                                <input type="text" class="form-control" name="firmadi">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label">Firma Ünvan:</label>
                                                <input type="text" name="firmaunvan" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label">Vergi No:</label>
                                                <input type="text" name="vergino" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label">Vergi Dairesi:</label>
                                                <input type="text" name="vergidairesi" class="form-control">
                                            </div>
                                        <?php } ?>
                                        <!--
							<div class="form-group">
							  <label class="col-sm-2 control-label">Çalıştığı Şube:</label>
							  <div class="col-sm-10">
								<select class="form-control select2" name="ofis">
									<option value="">Seçiniz</option>
									<?php
                                        $subeler = mysql_query("SELECT * FROM subeler where id");
                                        while ($sube=mysql_fetch_array($subeler)) {
                                            ?>
									<?php
                                            if ($sube["durum"] == 0) {
                                                ?>
									<option value="<?=$sube["id"];?>"><?=$sube["adi"];?></option>
									<?php } ?>
									<?php } ?>
								</select>
							  </div>
							</div>
							-->
                                        <div class="col-sm-4">
                                            <label class="control-label">Üye Ünvan:</label>
                                            <select class="form-control selec t2" name="unvan">
                                                <option value="">Seçiniz</option>
                                                <?php
                                                $unvanlar = mysql_query("SELECT * FROM yonetici_unvan where id");
                                                while ($unvan=mysql_fetch_array($unvanlar)) {
                                                    ?>
                                                    <?php
                                                    if ($unvan["durum"] == 0) {
                                                        ?>
                                                        <option value="<?=$unvan["baslik"];?>"><?=$unvan["baslik"];?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div><div class="col-sm-4">
                                            <label class="control-label">Email:</label>
                                            <input type="text" class="form-control" name="email">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="control-label">Şifre:</label>
                                            <input type="password" name="pass" class="form-control">
                                        </div>
                                        <div class="col-sm-8">
                                            <label class="control-label">Profil Resmi Seç:</label>
                                            <input type="file" class="form-control" name="resim[]"/>
                                        </div>
                                        <?php if(yetki() == 0): ?>
                                            <div class="col-sm-4">
                                                <label class="control-label">Sıra:</label>
                                                <input type="text" class="form-control" name="sira">
                                            </div>
                                        <?php endif; ?>
                                        <!--
                                        <div class="col-sm-4">
                                            <label class="control-label">Aylık İlan Ekleme Limiti:</label>
                                              <input type="text" class="form-control" name="aylik_limit">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="control-label">Aylık Resim Ekleme Limiti:</label>
                                              <input type="text" class="form-control" name="resim_limit">
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="control-label">İlan Yayın Süresi:</label>
                                              <input type="text" class="form-control" name="ilan_sure">
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="control-label"> &nbsp; </label>
                                              <select class="form-control" name="ilan_sure_zaman">
                                                  <option value="Gün"> Gün </option>
                                                  <option value="Ay"> Ay </option>
                                                  <option value="Yıl"> Yıl </option>
                                              </select>
                                        </div>
                                        -->
                                        <div class="col-sm-4">
                                            <label class="control-label">Tel:</label>
                                            <input type="text" name="tel" class="form-control">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="control-label">Telefon 2:</label>
                                            <input type="text" name="gsm" class="form-control">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="control-label">Fax (Varsa):</label>
                                            <input type="text" name="fax" class="form-control">
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="control-label">Hakkında:</label>
                                            <textarea id="editor1" name="aciklama" rows="15" cols="80"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title"> Sosyal Medya Hesapları </h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body pad">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <?php
                                            $sosyalmedya = mysql_query("SELECT * FROM ayar_sosyal order by sira asc");
                                            while ($sosyal=mysql_fetch_array($sosyalmedya)) {
                                                ?>
                                                <div class="col-sm-12">
                                                    <label class="control-label"><?=$sosyal["baslik"];?>:</label>
                                                    <input type="text" class="form-control hidden" name="sosyalbaslik[]" value="<?=$sosyal["baslik"];?>">
                                                    <input type="text" class="form-control hidden" name="sosyalid[]" value="<?=$sosyal["id"];?>">
                                                    <input type="text" class="form-control" name="sosyallink[]" value="">
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <?php if ($uyeekle == "kurumsal") { ?>
                                        <button type="submit" class="btn btn-success btn-lg btn-block" name="yoneticieklekurumsal"> <i class="fa fa-check"></i> Yeni Ekle </button>
                                    <?php } else { ?>
                                        <button type="submit" class="btn btn-success btn-lg btn-block" name="yoneticiekle"> <i class="fa fa-check"></i> Yeni Ekle </button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </section>
    <?php else: ?>
        <div class="row">
            <div class="col-md-9">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-check"></i> Yeni Ekle </h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <a href="#" class="btn btn-  btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Daralt">
                                <i class="fa fa-minus"></i></a>
                            <a type="button" class="btn btn-  btn-sm" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Kapat">
                                <i class="fa fa-times"></i></a>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <div class="box-body" style="">
                        <div class="form-horizontal">
                            <div class="col-sm-4">
                                <label class="control-label"><?php if ($uyeekle == "kurumsal") {echo "Yetkili ";} ?>Adı Soyadı:</label>
                                <input type="text" class="form-control" name="adsoyad">
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label">Üyelik Tipi:</label>
                                <?php if ($uyeekle=="bireysel") { ?>
                                    <label for="yetki" class="hidden">
                                        <input type="radio" name="yetki" checked value="1" class="minimal">
                                        Bireysel Üye
                                    </label>
                                    <input type="text" name="uyelik_tipi" disabled="" placeholder="Bireysel" class="form-control">
                                <?php } ?>
                                <?php if ($uyeekle=="kurumsal") { ?>
                                    <label for="yetki" class="hidden">
                                        <input type="radio" name="yetki" checked value="2" class="minimal">
                                        Kurumsal Üye
                                    </label>
                                    <input type="text" name="uyelik_tipi" disabled="" placeholder="Kurumsal" class="form-control">
                                <?php } ?>
                                <?php if ($uyeekle=="danisman") { ?>
                                    <label for="yetki" class="hidden">
                                        <input type="radio" name="yetki" checked value="3" class="minimal">
                                        Danışman
                                    </label>
                                    <input type="text" name="uyelik_tipi" disabled="" placeholder="Danışman" class="form-control">
                                <?php } ?>
                                <?php if ($uyeekle=="yonetici") { ?>
                                    <label for="yetki" class="hidden">
                                        <input type="radio" name="yetki" checked value="0" class="minimal">
                                        Yönetici
                                    </label>
                                    <input type="text" name="uyelik_tipi" disabled="" placeholder="Yönetici" class="form-control">
                                <?php } ?>
                            </div>
                            <?php if ($uyeekle == "kurumsal") { ?>
                                <div class="col-sm-4">
                                    <label class="control-label">Firma Adı (Emlak Ofisi):</label>
                                    <input type="text" class="form-control" name="firmadi">
                                </div>
                                <div class="col-sm-4">
                                    <label class="control-label">Firma Ünvan:</label>
                                    <input type="text" name="firmaunvan" class="form-control">
                                </div>
                                <div class="col-sm-4">
                                    <label class="control-label">Vergi No:</label>
                                    <input type="text" name="vergino" class="form-control">
                                </div>
                                <div class="col-sm-4">
                                    <label class="control-label">Vergi Dairesi:</label>
                                    <input type="text" name="vergidairesi" class="form-control">
                                </div>
                            <?php } ?>
                            <!--
							<div class="form-group">
							  <label class="col-sm-2 control-label">Çalıştığı Şube:</label>
							  <div class="col-sm-10">
								<select class="form-control select2" name="ofis">
									<option value="">Seçiniz</option>
									<?php
                            $subeler = mysql_query("SELECT * FROM subeler where id");
                            while ($sube=mysql_fetch_array($subeler)) {
                                ?>
									<?php
                                if ($sube["durum"] == 0) {
                                    ?>
									<option value="<?=$sube["id"];?>"><?=$sube["adi"];?></option>
									<?php } ?>
									<?php } ?>
								</select>
							  </div>
							</div>
							-->
                            <div class="col-sm-4">
                                <label class="control-label">Üye Ünvan:</label>
                                <select class="form-control selec t2" name="unvan">
                                    <option value="">Seçiniz</option>
                                    <?php
                                    $unvanlar = mysql_query("SELECT * FROM yonetici_unvan where id");
                                    while ($unvan=mysql_fetch_array($unvanlar)) {
                                        ?>
                                        <?php
                                        if ($unvan["durum"] == 0) {
                                            ?>
                                            <option value="<?=$unvan["baslik"];?>"><?=$unvan["baslik"];?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div><div class="col-sm-4">
                                <label class="control-label">Email:</label>
                                <input type="text" class="form-control" name="email">
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label">Şifre:</label>
                                <input type="password" name="pass" class="form-control">
                            </div>
                            <div class="col-sm-8">
                                <label class="control-label">Profil Resmi Seç:</label>
                                <input type="file" class="form-control" name="resim[]"/>
                            </div>
                            <?php if(yetki() == 0): ?>
                                <div class="col-sm-4">
                                    <label class="control-label">Sıra:</label>
                                    <input type="text" class="form-control" name="sira">
                                </div>
                            <?php endif; ?>
                            <!--
                            <div class="col-sm-4">
                                <label class="control-label">Aylık İlan Ekleme Limiti:</label>
                                  <input type="text" class="form-control" name="aylik_limit">
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label">Aylık Resim Ekleme Limiti:</label>
                                  <input type="text" class="form-control" name="resim_limit">
                            </div>
                            <div class="col-sm-2">
                                <label class="control-label">İlan Yayın Süresi:</label>
                                  <input type="text" class="form-control" name="ilan_sure">
                            </div>
                            <div class="col-sm-2">
                                <label class="control-label"> &nbsp; </label>
                                  <select class="form-control" name="ilan_sure_zaman">
                                      <option value="Gün"> Gün </option>
                                      <option value="Ay"> Ay </option>
                                      <option value="Yıl"> Yıl </option>
                                  </select>
                            </div>
                            -->
                            <div class="col-sm-4">
                                <label class="control-label">Tel:</label>
                                <input type="text" name="tel" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label">Telefon 2:</label>
                                <input type="text" name="gsm" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label">Fax (Varsa):</label>
                                <input type="text" name="fax" class="form-control">
                            </div>
                            <div class="col-sm-12">
                                <label class="control-label">Hakkında:</label>
                                <textarea id="editor1" name="aciklama" rows="15" cols="80"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"> Sosyal Medya Hesapları </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <?php
                                $sosyalmedya = mysql_query("SELECT * FROM ayar_sosyal order by sira asc");
                                while ($sosyal=mysql_fetch_array($sosyalmedya)) {
                                    ?>
                                    <div class="col-sm-12">
                                        <label class="control-label"><?=$sosyal["baslik"];?>:</label>
                                        <input type="text" class="form-control hidden" name="sosyalbaslik[]" value="<?=$sosyal["baslik"];?>">
                                        <input type="text" class="form-control hidden" name="sosyalid[]" value="<?=$sosyal["id"];?>">
                                        <input type="text" class="form-control" name="sosyallink[]" value="">
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <?php if ($uyeekle == "kurumsal") { ?>
                            <button type="submit" class="btn btn-success btn-lg btn-block" name="yoneticieklekurumsal"> <i class="fa fa-check"></i> Yeni Ekle </button>
                        <?php } else { ?>
                            <button type="submit" class="btn btn-success btn-lg btn-block" name="yoneticiekle"> <i class="fa fa-check"></i> Yeni Ekle </button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</form>