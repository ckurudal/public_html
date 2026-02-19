<?php
    $do = "franchise";
?>
<!doctype html>
<html class="no-js" lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Franchise Fırsatı - <?=$ayar["site_adi"];?></title>
    <meta name="description" content="Emlak sektöründe franchise ile kendi işinizi kurun. Güçlü marka, teknoloji ve destek ile kazanmaya başlayın.">
    <?php include('header.php'); ?>
    <link rel="stylesheet" href="<?=TEMA_URL?>/assets/css/ai-features.css">
</head>
<body>
<?php include('ust.php'); ?>

<!-- HERO -->
<section class="franchise-hero">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <p class="mb-3" style="opacity:0.7; letter-spacing:2px; font-size:13px; text-transform:uppercase;">Emlak Sektöründe Geleceğinizi Şekillendirin</p>
                <h1><?=$site["firmadi"];?> Franchise Ağına Katılın</h1>
                <p>Türkiye'nin büyüyen emlak sektöründe güçlü bir marka, kanıtlanmış iş modeli ve teknoloji altyapısı ile kendi ofisinizi açın.</p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="#franchise-basvuru" class="btn btn-danger btn-lg px-5 font-weight-bold">
                        <i class="fa fa-rocket mr-2"></i> Hemen Başvur
                    </a>
                    <a href="tel:<?=htmlspecialchars($site["sabittel"]);?>" class="btn btn-outline-light btn-lg px-5">
                        <i class="fa fa-phone mr-2"></i> Bilgi Al
                    </a>
                </div>
            </div>
        </div>
        <!-- Stats -->
        <div class="row mt-5">
            <div class="col-6 col-md-3 mb-3">
                <div class="franchise-stat-card">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Aktif Danışman</div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="franchise-stat-card">
                    <div class="stat-number">81</div>
                    <div class="stat-label">İl Kapsamı</div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="franchise-stat-card">
                    <div class="stat-number">10K+</div>
                    <div class="stat-label">Satılan Mülk</div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <div class="franchise-stat-card">
                    <div class="stat-number">%98</div>
                    <div class="stat-label">Müşteri Memnuniyeti</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- BENEFITS -->
<section class="pt-7 pb-6">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="font-weight-bold">Neden <?=htmlspecialchars($site["firmadi"]);?> Franchise?</h2>
            <p class="text-muted">Size sağladığımız avantajlar ve destek paketleri</p>
        </div>
        <div class="row">
            <?php
            $benefits = [
                ['fa fa-laptop', 'Teknoloji Altyapısı', 'AI destekli CRM, website ve mobil uygulama ile tam donanımlı dijital ofis.'],
                ['fa fa-graduation-cap', 'Eğitim & Sertifika', 'Kapsamlı başlangıç eğitimi, sürekli gelişim programları ve sertifika desteği.'],
                ['fa fa-bullhorn', 'Ulusal Reklam', 'Marka bilinirliğini artıran ulusal reklam kampanyaları ve dijital pazarlama.'],
                ['fa fa-users', 'Güçlü Topluluk', 'Binlerce franchisee ile deneyim paylaşımı ve network avantajı.'],
                ['fa fa-map-marker', 'Bölge Garantisi', 'Seçtiğiniz bölgede münhasır faaliyet hakkı ve rekabet koruması.'],
                ['fa fa-bar-chart', 'Kanıtlanmış Model', 'Yıllara dayanan tecrübe ile optimize edilmiş iş modeli ve yüksek kâr marjı.'],
            ];
            foreach($benefits as $b):
            ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100" style="border-radius:16px; border:1px solid #f0f0f0;">
                    <div class="card-body text-center p-4">
                        <div class="franchise-benefit-icon">
                            <i class="<?=htmlspecialchars($b[0])?>"></i>
                        </div>
                        <h5 class="font-weight-bold"><?=htmlspecialchars($b[1])?></h5>
                        <p class="text-muted mb-0"><?=htmlspecialchars($b[2])?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- APPLICATION FORM -->
<section id="franchise-basvuru" class="pt-6 pb-6" style="background: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card" style="border-radius:16px; border:none; box-shadow:0 8px 40px rgba(0,0,0,0.1);">
                    <div class="card-body p-5">
                        <h4 class="font-weight-bold text-center mb-1">Franchise Başvuru Formu</h4>
                        <p class="text-center text-muted mb-4">Bilgilerinizi bırakın, uzmanlarımız sizi arasın.</p>
                        
                        <?php if (isset($_POST["franchise_basvuru"])): 
                            $f_ad    = htmlspecialchars(trim($_POST["f_ad"] ?? ''));
                            $f_tel   = htmlspecialchars(trim($_POST["f_tel"] ?? ''));
                            $f_email = htmlspecialchars(trim($_POST["f_email"] ?? ''));
                            $f_sehir = htmlspecialchars(trim($_POST["f_sehir"] ?? ''));
                            $f_mesaj = htmlspecialchars(trim($_POST["f_mesaj"] ?? ''));
                            $tarih   = date('d/m/Y H:i');
                            if ($f_ad && $f_tel && $f_email):
                                $mesaj_icerik = "Franchise Başvurusu\n\nAd Soyad: $f_ad\nTelefon: $f_tel\nE-posta: $f_email\nŞehir: $f_sehir\nMesaj: $f_mesaj\nTarih: $tarih";
                                try {
                                    $stmt = $vt->prepare("INSERT INTO emlak_mesajemlaktalep (adsoyad, tel, tarih, taleptur, mesaj, emlaktipi, adres, email) VALUES (?,?,?,?,?,?,?,?)");
                                    $stmt->execute([$f_ad, $f_tel, $tarih, 'Franchise Başvurusu', $mesaj_icerik, 'Franchise', $f_sehir, $f_email]);
                                    echo '<div class="alert alert-success"><i class="fa fa-check-circle mr-2"></i> Başvurunuz alındı! En kısa sürede sizinle iletişime geçeceğiz.</div>';
                                } catch(Exception $e) {
                                    echo '<div class="alert alert-danger"><i class="fa fa-times-circle mr-2"></i> Başvurunuz iletilirken bir hata oluştu. Lütfen tekrar deneyiniz.</div>';
                                }
                            else:
                                echo '<div class="alert alert-warning">Lütfen zorunlu alanları doldurunuz.</div>';
                            endif;
                        endif; ?>
                        
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Ad Soyad *</label>
                                        <input type="text" name="f_ad" class="form-control" required placeholder="Ad Soyad">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Telefon *</label>
                                        <input type="tel" name="f_tel" class="form-control" required placeholder="05XX XXX XX XX">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">E-posta *</label>
                                        <input type="email" name="f_email" class="form-control" required placeholder="ornek@email.com">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Hedef Şehir</label>
                                        <input type="text" name="f_sehir" class="form-control" placeholder="Hangi şehirde?">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Mesajınız</label>
                                <textarea name="f_mesaj" class="form-control" rows="3" placeholder="Ek bilgi veya sorularınızı yazabilirsiniz..."></textarea>
                            </div>
                            <button type="submit" name="franchise_basvuru" class="btn btn-danger btn-lg btn-block font-weight-bold">
                                <i class="fa fa-paper-plane mr-2"></i> Başvur - Ücretsiz Bilgi Al
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('footer.php'); ?>
<script src="<?=TEMA_URL?>/assets/js/ai-features.js"></script>
</body>
</html>
