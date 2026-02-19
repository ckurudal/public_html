<?php
    $do = "kredi-hesap";
?>
<!doctype html>
<html class="no-js" lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kredi Hesaplama - <?=$ayar["site_adi"];?></title>
    <meta name="description" content="Konut kredisi hesaplama aracı ile aylık taksitinizi, toplam ödemenizi ve faiz tutarınızı hesaplayın.">
    <?php include('header.php'); ?>
    <link rel="stylesheet" href="<?=TEMA_URL?>/assets/css/ai-features.css">
</head>
<body>
<?php include('ust.php'); ?>

<section class="sptb pt-6 pb-6" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 mx-auto">
                <div class="kredi-hesap-card">
                    <h4 class="text-center">
                        <i class="fa fa-calculator mr-2"></i> Konut Kredisi Hesaplayıcı
                    </h4>
                    <p class="text-center text-muted mb-4">Hayalinizdeki evi satın almak için aylık taksitinizi hesaplayın.</p>
                    
                    <div class="form-group">
                        <label class="font-weight-bold">Kredi Tutarı (₺)</label>
                        <input type="text" id="kredi-tutar" class="form-control form-control-lg fiyat-input" placeholder="Örn: 1.500.000">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Yıllık Faiz Oranı (%)</label>
                                <input type="number" id="kredi-faiz" class="form-control form-control-lg" placeholder="Örn: 2.99" step="0.01" min="0.1" max="50">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Vade (Yıl)</label>
                                <select id="kredi-vade" class="form-control form-control-lg">
                                    <option value="">Seçiniz</option>
                                    <?php for($y = 1; $y <= 30; $y++): ?>
                                    <option value="<?=$y?>"><?=$y?> Yıl (<?=$y*12?> Ay)</option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <button id="kredi-hesapla-btn" class="btn btn-danger btn-lg btn-block font-weight-bold">
                        <i class="fa fa-calculator mr-2"></i> Hesapla
                    </button>
                    
                    <div id="kredi-sonuc" style="display:none;" class="mt-4">
                        <hr>
                        <h6 class="text-center font-weight-bold text-muted mb-3">HESAPLAMA SONUCU</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="kredi-sonuc-item">
                                    <div class="kredi-label">Aylık Taksit</div>
                                    <div class="kredi-deger" id="kredi-aylik">-</div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="kredi-sonuc-item">
                                    <div class="kredi-label">Toplam Ödeme</div>
                                    <div class="kredi-deger" id="kredi-toplam">-</div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="kredi-sonuc-item">
                                    <div class="kredi-label">Toplam Faiz</div>
                                    <div class="kredi-deger" id="kredi-faiz-toplam">-</div>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-info mt-3" style="font-size:12px;">
                            <i class="fa fa-info-circle mr-1"></i> Bu hesaplama tahmini olup bankaların sunduğu gerçek oranlardan farklılık gösterebilir. Kesin bilgi için bankanızla iletişime geçiniz.
                        </div>
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
