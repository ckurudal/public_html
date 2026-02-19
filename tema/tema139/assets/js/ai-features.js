/**
 * AI-Powered Real Estate Features
 * Emlakbudur - Next Generation Real Estate Platform
 */

// ============================================================
// LAZY LOADING FOR PROPERTY IMAGES
// ============================================================
(function() {
    'use strict';
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        img.classList.add('lazy-loaded');
                        imageObserver.unobserve(img);
                    }
                }
            });
        }, { rootMargin: '50px 0px' });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('img[data-src]').forEach(function(img) {
                imageObserver.observe(img);
            });
        });
    }
})();

// ============================================================
// AI MORTGAGE CALCULATOR
// ============================================================
var EmlakAI = EmlakAI || {};

EmlakAI.KrediHesap = {
    hesapla: function(tutar, faiz, vade) {
        if (!tutar || !faiz || !vade) return null;
        var aylikFaiz = (faiz / 100) / 12;
        var taksitSayisi = vade * 12;
        var aylikTaksit = tutar * (aylikFaiz * Math.pow(1 + aylikFaiz, taksitSayisi)) / (Math.pow(1 + aylikFaiz, taksitSayisi) - 1);
        var toplamOdeme = aylikTaksit * taksitSayisi;
        var toplamFaiz = toplamOdeme - tutar;
        return {
            aylikTaksit: Math.round(aylikTaksit),
            toplamOdeme: Math.round(toplamOdeme),
            toplamFaiz: Math.round(toplamFaiz),
            taksitSayisi: taksitSayisi
        };
    },
    formatPara: function(sayi) {
        return sayi.toLocaleString('tr-TR') + ' ₺';
    }
};

// ============================================================
// PROPERTY COMPARISON TOOL
// ============================================================
EmlakAI.Karsilastir = {
    liste: JSON.parse(localStorage.getItem('karsilastir_listesi') || '[]'),
    maxAdet: 3,
    
    ekle: function(ilanId, baslik, fiyat, resim) {
        if (this.liste.length >= this.maxAdet) {
            this.bildirim('En fazla ' + this.maxAdet + ' ilan karşılaştırabilirsiniz.', 'warning');
            return false;
        }
        if (this.liste.find(function(i) { return i.id == ilanId; })) {
            this.bildirim('Bu ilan zaten karşılaştırma listenizde.', 'info');
            return false;
        }
        this.liste.push({ id: ilanId, baslik: baslik, fiyat: fiyat, resim: resim });
        this.kaydet();
        this.guncelle();
        this.bildirim('"' + baslik + '" karşılaştırma listesine eklendi.', 'success');
        return true;
    },
    
    sil: function(ilanId) {
        this.liste = this.liste.filter(function(i) { return i.id != ilanId; });
        this.kaydet();
        this.guncelle();
    },
    
    kaydet: function() {
        localStorage.setItem('karsilastir_listesi', JSON.stringify(this.liste));
    },
    
    guncelle: function() {
        var bar = document.getElementById('karsilastir-bar');
        if (!bar) return;
        var sayac = document.getElementById('karsilastir-sayac');
        if (sayac) sayac.textContent = this.liste.length;
        bar.style.display = this.liste.length > 0 ? 'flex' : 'none';
    },
    
    bildirim: function(mesaj, tip) {
        var div = document.createElement('div');
        div.className = 'ai-bildirim ai-bildirim-' + tip;
        div.textContent = mesaj;
        document.body.appendChild(div);
        setTimeout(function() { 
            div.classList.add('ai-bildirim-gizle');
            setTimeout(function() { div.remove(); }, 400);
        }, 3000);
    }
};

// ============================================================
// AI CHATBOT WIDGET
// ============================================================
EmlakAI.Chatbot = {
    acik: false,
    mesajlar: [],
    
    yanitlar: {
        'merhaba': 'Merhaba! Ben Emlakbudur AI Asistanı\'yım. Size nasıl yardımcı olabilirim?',
        'fiyat': 'Emlak fiyatları bölge, m², kat ve yaşa göre değişir. Detaylı fiyat bilgisi için ilgili ilanı inceleyebilir ya da danışmanlarımıza ulaşabilirsiniz.',
        'kredi': 'Konut kredisi için aylık taksit hesaplamak ister misiniz? Sayfamızdaki Kredi Hesaplama aracını kullanabilirsiniz.',
        'kiralık': 'Kiralık mülklerimizi görmek için "İlanlar" menüsünden "Kiralık" seçeneğini kullanabilirsiniz.',
        'satılık': 'Satılık mülklerimizi görmek için "İlanlar" menüsünden "Satılık" seçeneğini kullanabilirsiniz.',
        'franchise': 'Emlakbudur franchise ağına katılmak için Franchise sayfamızı ziyaret edebilir ya da bize ulaşabilirsiniz.',
        'iletişim': 'Bize telefon, e-posta veya WhatsApp üzerinden ulaşabilirsiniz. İletişim bilgilerimiz sayfanın üst ve alt kısımlarında yer almaktadır.',
        'default': 'Anlaşıldı! Bu konuda size daha fazla yardımcı olabilmem için danışmanlarımızdan biriyle bağlantı kurmanızı öneririm.'
    },
    
    yanit: function(soru) {
        soru = soru.toLowerCase();
        for (var kelime in this.yanitlar) {
            if (kelime !== 'default' && soru.includes(kelime)) {
                return this.yanitlar[kelime];
            }
        }
        return this.yanitlar['default'];
    },
    
    mesajEkle: function(metin, tip) {
        var kutu = document.getElementById('chatbot-mesajlar');
        if (!kutu) return;
        var div = document.createElement('div');
        div.className = 'chatbot-mesaj chatbot-mesaj-' + tip;
        div.innerHTML = '<span>' + metin + '</span>';
        kutu.appendChild(div);
        kutu.scrollTop = kutu.scrollHeight;
    },
    
    gonder: function() {
        var input = document.getElementById('chatbot-input');
        if (!input || !input.value.trim()) return;
        var soru = input.value.trim();
        input.value = '';
        this.mesajEkle(soru, 'kullanici');
        var self = this;
        setTimeout(function() {
            self.mesajEkle(self.yanit(soru), 'bot');
        }, 600);
    },
    
    toggle: function() {
        this.acik = !this.acik;
        var pencere = document.getElementById('chatbot-pencere');
        if (pencere) {
            pencere.style.display = this.acik ? 'flex' : 'none';
            if (this.acik && this.mesajlar.length === 0) {
                this.mesajEkle('Merhaba! Size nasıl yardımcı olabilirim? 🏠', 'bot');
            }
        }
        var badge = document.getElementById('chatbot-badge');
        if (badge) badge.style.display = 'none';
    }
};

// ============================================================
// SMART SEARCH MEMORY (save last search in localStorage)
// ============================================================
EmlakAI.AramaHafiza = {
    kaydet: function() {
        var form = document.querySelector('form[action="/ilanara/"]');
        if (!form) return;
        var veri = {};
        form.querySelectorAll('select, input[type=text]').forEach(function(el) {
            if (el.name && el.value) veri[el.name] = el.value;
        });
        localStorage.setItem('son_arama', JSON.stringify(veri));
    },
    
    yukle: function() {
        var kayitli = localStorage.getItem('son_arama');
        if (!kayitli) return;
        try {
            var veri = JSON.parse(kayitli);
            var form = document.querySelector('form[action="/ilanara/"]');
            if (!form) return;
        } catch(e) {}
    }
};

// ============================================================
// PRICE FORMATTER (auto format price input fields)
// ============================================================
EmlakAI.FiyatFormat = {
    init: function() {
        document.querySelectorAll('.fiyat-input').forEach(function(el) {
            el.addEventListener('input', function() {
                var val = this.value.replace(/\D/g, '');
                this.value = parseInt(val || 0).toLocaleString('tr-TR');
            });
        });
    }
};

// ============================================================
// INIT ON DOM READY
// ============================================================
document.addEventListener('DOMContentLoaded', function() {
    EmlakAI.Karsilastir.guncelle();
    EmlakAI.FiyatFormat.init();
    
    // Chatbot enter key handler
    var chatInput = document.getElementById('chatbot-input');
    if (chatInput) {
        chatInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') EmlakAI.Chatbot.gonder();
        });
    }
    
    // Chatbot send button
    var sendBtn = document.getElementById('chatbot-gonder');
    if (sendBtn) {
        sendBtn.addEventListener('click', function() { EmlakAI.Chatbot.gonder(); });
    }
    
    // Chatbot toggle button
    var toggleBtn = document.getElementById('chatbot-toggle');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() { EmlakAI.Chatbot.toggle(); });
    }
    
    // Comparison bar
    document.querySelectorAll('.karsilastir-ekle-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            EmlakAI.Karsilastir.ekle(
                this.dataset.id,
                this.dataset.baslik,
                this.dataset.fiyat,
                this.dataset.resim
            );
        });
    });
    
    // Mortgage calculator
    var hesaplaBtn = document.getElementById('kredi-hesapla-btn');
    if (hesaplaBtn) {
        hesaplaBtn.addEventListener('click', function() {
            var tutar = parseInt((document.getElementById('kredi-tutar').value || '0').replace(/\D/g,''));
            var faiz = parseFloat(document.getElementById('kredi-faiz').value || '0');
            var vade = parseInt(document.getElementById('kredi-vade').value || '0');
            var sonuc = EmlakAI.KrediHesap.hesapla(tutar, faiz, vade);
            if (!sonuc) {
                alert('Lütfen tüm alanları doldurunuz.');
                return;
            }
            document.getElementById('kredi-aylik').textContent = EmlakAI.KrediHesap.formatPara(sonuc.aylikTaksit);
            document.getElementById('kredi-toplam').textContent = EmlakAI.KrediHesap.formatPara(sonuc.toplamOdeme);
            document.getElementById('kredi-faiz-toplam').textContent = EmlakAI.KrediHesap.formatPara(sonuc.toplamFaiz);
            document.getElementById('kredi-sonuc').style.display = 'block';
        });
    }
    
    // Smooth scroll to anchor links
    document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
        anchor.addEventListener('click', function(e) {
            var target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
    
    // Back to top button
    var backTop = document.getElementById('back-to-top');
    if (backTop) {
        window.addEventListener('scroll', function() {
            backTop.style.display = window.pageYOffset > 300 ? 'flex' : 'none';
        });
        backTop.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // Comparison bar buttons
    var listeleBtn = document.getElementById('karsilastir-listele-btn');
    if (listeleBtn) {
        listeleBtn.addEventListener('click', function() {
            EmlakAI.Karsilastir.goster();
        });
    }
    var temizleBtn = document.getElementById('karsilastir-temizle-btn');
    if (temizleBtn) {
        temizleBtn.addEventListener('click', function() {
            EmlakAI.Karsilastir.liste = [];
            EmlakAI.Karsilastir.kaydet();
            EmlakAI.Karsilastir.guncelle();
        });
    }
});
