<?php

    echo !defined("ADMIN") ? die ("Güvenlik Duvarı...") : null;

    $emlak             = $_GET["emlak"];
    $ofis              = $_GET["ofis"];
    $do                = $_GET["do"];
    $ayarlar           = $_GET["ayarlar"];
    $uyeler            = $_GET["uyeler"];
    $uyeekle           = $_GET["uyeekle"];
    $icerik            = $_GET["icerik"];
    $webmaster         = $_GET["webmaster"];
    $ofistip           = $_GET["ofistip"];
    $uyetip            = $_GET["uyetip"];
    $yetki             = $_GET["yetki"];
    $sifre             = $_GET["sifre"];
    $uyelikayar        = $_GET["uyelikayar"];
    $uye               = $_GET["uye"];
    $reklam            = $_GET["reklam"];
    $magaza            = $_GET["magaza"];

    $emlak_ofisim = $vt->query("SELECT * FROM subeler WHERE yetkiliuye = '".$_SESSION["id"]."' ")->fetch();    

 ?>

 
 <aside class="main-sidebar">
    <div class="user-panel">
        <div class="image hidden-xs">
          <?php 
                $yoneticibilgi = $vt->query("SELECT * FROM yonetici where id = '".$_SESSION['id']."'");
                $yoneticiver = $yoneticibilgi->fetch();
            ?>
            <?php if ($yoneticiver["resim"] == "") { ?>
                <img src="/uploads/resim/resim.png" class="user-image img-circle" alt="<?=$yoneticiver["adsoyad"];?>" width="200">
            <?php } else { ?>
                <img src="/<?=$yoneticiver["resim"];?>" class="user-image" alt="<?=$yoneticiver["adsoyad"];?>" width="200">
            <?php } ?>
        </div>
        <div class="pull-left info">
          Hoşgeldin,  <span class=""><?=$yoneticiver['adsoyad'];?></span>
        </div>
      </div>
        <?php if (isMobile()): ?>
		<div class="text-center">
			<a href="#" class="btn btn-success sidebar-toggle" style="color:#fff;" data-toggle="push-menu" role="button">
				<span class="sr-only">Toggle navigation</span>
				MENÜYÜ KAPAT
			</a>
		</div>	
		<?php endif; ?>
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li>
                <a href="<?php echo $ayar["site_yonetim_url"] ?>">
                    <i class="fa fa-home"></i>
                    <span> Anasayfa </span>
                </a>
            </li>

            <li class="menu-open aktif">
                <a href="index.php?do=islem&emlak=emlak_ilanlar">
                    <i class="fa fa-tasks"></i>
                    <span> İlanlarım </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="index.php?do=islem&emlak=emlak_ekle&islem=sec">
                            <i class="fa fa-plus"></i> Yeni İlan Ekle
                        </a>
                    </li>

                    <li class="<?php if ($emlak == "emlak_ilanlar") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=emlak_ilanlar">
                            <i class="fa fa-stop"></i> Tüm İlanlar <span class="label pull-right"><?=$ilan[0];?></span></a>
                    </li>

					<!--

                    <li class=" <?php if ($emlak == "kategori" || $emlak == "kategori_ekle" || $emlak == "kategori_duzenle") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=emlak_ilanlar&uyeonay=satildi">
                            <i class="fa fa-check" <?php if ($satildisay[0]>0) {echo 'style="color:red;"';} ?>></i> Satılanlar <span class="label pull-right"><?=$satildisay[0];?></span></a>
                    </li>
                    <li class=" <?php if ($emlak == "kategori" || $emlak == "kategori_ekle" || $emlak == "kategori_duzenle") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=emlak_ilanlar&uyeonay=kiralandi">
                            <i class="fa fa-check" <?php if ($kiralandisay[0]>0) {echo 'style="color:red;"';} ?>></i> Kiralananlar <span class="label pull-right"><?=$kiralandisay[0];?></span></a>
                    </li>
					
					-->
					
                    <li class=" <?php if ($emlak == "kategori" || $emlak == "kategori_ekle" || $emlak == "kategori_duzenle") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=emlak_ilanlar&uyeonay=yayindaolmayan">
                            <i class="fa fa-clock-o" <?php if ($pasifsay[0]>0) {echo 'style="color:red;"';} ?>></i> Taslaklar <span class="label pull-right"><?=$pasifsay[0];?></span></a>
                    </li>
                    <li class=" <?php if ($emlak == "kategori" || $emlak == "kategori_ekle" || $emlak == "kategori_duzenle") { echo "aktifAlt";}?>">
                        <a href="index.php?do=islem&emlak=emlak_ilanlar&uyeonay=onaybekleyen">
                            <i class="fa fa-refresh" <?php if ($onaysay[0]>0) {echo 'style="color:red;"';} ?>></i> Onay Bekleyen <span class="label pull-right"><?=$onaysay[0];?></span></a>
                    </li>
                </ul>
            </li>
			
            <li class="menu-open aktif">
                <a href="index.php?do=islem&emlak=emlak_favoriler">
                    <i class="fa fa-heart"></i>
                    <span> Favori Listem </span> 
                </a> 
            </li>
			
            <li class="menu-open aktif">
                <a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>&tab_goster=dopingleri">
                    <i class="fa fa-rocket"></i>
                    <span> Dopinglerim </span> 
                </a> 
            </li>
			
			<?php if (yetki() == 2): ?>
									
            <li class="menu-open aktif">
                <a href="index.php?do=islem&emlak=emlak_ilanlar&magaza=<?php echo $emlak_ofisim["id"]; ?>">
                    <i class="fa fa-archive"></i>
                    <span> Mağaza İlanları </span>
                </a>
            </li>
			
			<?php endif; ?>

			<?php if (yetki() == 2): ?>
			
            <li class="menu-open aktif">
                <a href="index.php?do=islem&ofis=subeekle&islem=duzenle&id=<?php echo $emlak_ofisim["id"]; ?>">
                    <i class="fa fa-archive"></i>
                    <span> Mağazam </span>
                </a>
            </li>
			
			<?php endif; ?>			

            <li class="menu-open aktif">
                <a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>&tab_goster=magaza_paketleri">
                    <i class="fa fa-dropbox"></i>
                    <span> Üyelik Paketim </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>&tab_goster=magaza_paketleri">
                            <i class="fa fa-plus"></i> Üyelik Paketlerim
                        </a>
                    </li>
                    <li>
                        <a href="index.php?do=siparisler/siparisler&paket=magaza">
                            <i class="fa fa-plus"></i> Paket Satın Al
                        </a>
                    </li>
                </ul>
            </li>
			
			<?php if (yetki() == 2): ?>

            <li class="menu-open aktif">
                <a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>&tab_goster=danismanlari">
                    <i class="fa fa-user-o"></i>
                    <span> Danışmanlarım </span>
					<span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>					
                </a> 
                <ul class="treeview-menu">
                    <li>
                        <a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>&tab_goster=danismanlari">
                            <i class="fa fa-plus"></i> Tüm Danışmanlar
                        </a>
                    </li>
                    <li>
                        <a href="index.php?do=islem&ofis=yonetici&islem=ekle&uyeekle=danisman">
                            <i class="fa fa-plus"></i> Danışman Ekle
                        </a>
                    </li>
                </ul>
            </li>
			
			<?php endif; ?>
            
            <li class="menu-open aktif">
                <a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>&tab_goster=mesajlari">
                    <i class="fa fa-inbox"></i>
                    <span> Mesajlarım (<?php echo gelen_mesaj($_SESSION["id"]); ?> )</span> 
                </a> 
            </li>
            <li class="menu-open aktif">
                <a href="index.php?do=islem&ofis=yonetici&islem=duzenle&id=<?php echo $_SESSION["id"]; ?>">
                    <i class="fa fa-cogs"></i>
                    <span> Üyeliğim </span>
                </a>
            </li>
        </ul>
    </section>
</aside>