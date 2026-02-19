# 🏠 Emlakbudur - Franchise Emlak Ofisi Yönetim Sistemi

PHP 8.3 + MySQL tabanlı, yapay zeka destekli franchise emlak ofisi yazılımı.

---

## 📋 İçindekiler

1. [Gereksinimler](#gereksinimler)
2. [Yöntem A – Docker ile Hızlı Kurulum](#yöntem-a--docker-ile-hızlı-kurulum-önerilen) ⭐ Önerilen
3. [Yöntem B – Manuel Kurulum (XAMPP/WAMP)](#yöntem-b--manuel-kurulum-xamppwamp)
4. [VSCode Yapılandırması](#vscode-yapılandırması)
5. [Admin Paneli](#admin-paneli)
6. [Sık Sorulan Sorular](#sık-sorulan-sorular)

---

## Gereksinimler

| Araç | Sürüm | İndirme |
|------|-------|---------|
| [Git](https://git-scm.com/) | Herhangi | https://git-scm.com/downloads |
| [VSCode](https://code.visualstudio.com/) | Herhangi | https://code.visualstudio.com/ |
| [Docker Desktop](https://www.docker.com/products/docker-desktop/) | 4.x+ | https://www.docker.com/products/docker-desktop/ |
| **veya** XAMPP | 8.3+ | https://www.apachefriends.org/tr/ |

---

## Yöntem A – Docker ile Hızlı Kurulum (Önerilen)

Bu yöntemde PHP, Apache ve MySQL otomatik olarak kurulur.  
**Tek ön koşul:** Docker Desktop yüklü ve çalışıyor olması.

### 1. Projeyi İndirin

```bash
# VSCode terminali açın: Ctrl+` (backtick)
git clone https://github.com/ckurudal/public_html.git
cd public_html
```

### 2. Yerel Veritabanı Yapılandırması

```bash
# Şablon dosyayı kopyalayın
cp sistem/baglan.local.php.example sistem/baglan.local.php
```

`sistem/baglan.local.php` dosyasını açın — Docker için varsayılan değerler zaten doğru:

```php
$dbhost = "db";               // Docker servisi adı
$dbuser = "emlak_user";
$dbname = "emlakbudur_joker";
$dbpass = "emlak_pass";
define("LOCAL_SITE_URL", "http://localhost:8080");
```

> ⚠️ `$dbhost = "db"` olmalı — Docker ağındaki MySQL servisi adı budur.

### 3. Konteynerleri Başlatın

```bash
docker compose up -d --build
```

İlk başlatmada Docker şunları yapar:
- PHP 8.3 + Apache imajı oluşturur
- MySQL 8 veritabanını başlatır
- `emlakbudur_joker.sql` dosyasını otomatik içe aktarır

> ⏳ İlk kez çalıştırmak 2-5 dakika sürebilir.

### 4. Tarayıcıda Açın

| Adres | Açıklama |
|-------|----------|
| http://localhost:8080 | 🌐 Ana site |
| http://localhost:8080/admin | 🔧 Yönetim paneli |
| http://localhost:8081 | 🗄️ phpMyAdmin |

### 5. Konteynerleri Durdurun

```bash
docker compose down          # Durdur (veriler korunur)
docker compose down -v       # Durdur + veritabanını sil
```

---

## Yöntem B – Manuel Kurulum (XAMPP/WAMP)

### 1. XAMPP İndirip Kurun

https://www.apachefriends.org/tr/ adresinden **PHP 8.3** içeren sürümü indirin.

### 2. Projeyi Doğru Konuma Yerleştirin

```
Windows : C:\xampp\htdocs\emlakbudur\
macOS   : /Applications/XAMPP/htdocs/emlakbudur/
Linux   : /opt/lampp/htdocs/emlakbudur/
```

```bash
# htdocs klasöründe terminal açın ve:
git clone https://github.com/ckurudal/public_html.git emlakbudur
```

### 3. XAMPP'ta Apache ve MySQL'i Başlatın

XAMPP Control Panel → Apache **Start** → MySQL **Start**

### 4. Veritabanı Oluşturun

1. http://localhost/phpmyadmin adresini açın
2. Sol üstte **"Yeni"** → Veritabanı adı: `emlakbudur_joker` → **Oluştur**
3. Oluşturulan veritabanına tıklayın → **İçe Aktar** sekmesi
4. `emlakbudur_joker.sql` dosyasını seçin → **Git** butonuna basın

### 5. Yerel Veritabanı Yapılandırması

```bash
cp sistem/baglan.local.php.example sistem/baglan.local.php
```

`sistem/baglan.local.php` dosyasını XAMPP ayarlarına göre düzenleyin:

```php
$dbhost = "localhost";
$dbuser = "root";        // XAMPP varsayılan kullanıcısı
$dbname = "emlakbudur_joker";
$dbpass = "";            // XAMPP'ta varsayılan şifre boştur
define("LOCAL_SITE_URL", "http://localhost/emlakbudur");
```

### 6. Tarayıcıda Açın

http://localhost/emlakbudur

---

## VSCode Yapılandırması

### Önerilen Eklentileri Yükleyin

Projeyi VSCode'da açtığınızda sağ altta  
**"Bu çalışma alanı için eklenti önerileri var"** bildirimi çıkar.  
**"Tümünü Yükle"** tıklayarak şunları kurabilirsiniz:

| Eklenti | Açıklama |
|---------|----------|
| **PHP Intelephense** | PHP otomatik tamamlama, hata kontrolü |
| **PHP Debug** | Xdebug ile satır satır hata ayıklama |
| **Docker** | Konteynerleri VSCode içinden yönetme |
| **Dev Containers** | Doğrudan konteyner içinde geliştirme |
| **MySQL Client** | VSCode'dan veritabanına bağlanma |
| **Thunder Client** | API testi (Postman alternatifi) |
| **Apache Config** | .htaccess söz dizimi renklendirme |

### Xdebug ile Hata Ayıklama

1. VSCode'da `F5` tuşuna basın  
2. **"Xdebug ile PHP Hata Ayıkla (Docker)"** seçin  
3. PHP koduna kırmızı nokta (breakpoint) koyun  
4. Tarayıcıda sayfayı yükleyin — kod o satırda duracak

---

## Admin Paneli

| Bilgi | Değer |
|-------|-------|
| URL | http://localhost:8080/admin |
| Varsayılan e-posta | `admin@emlakbudur.com` |
| Varsayılan şifre | `123456` |

> ⚠️ Canlı ortamda şifreyi mutlaka değiştirin!

---

## Klasör Yapısı

```
public_html/
├── admin/              # Yönetim paneli
├── sistem/             # Veritabanı bağlantısı, fonksiyonlar
│   ├── baglan.php              # Ana DB bağlantısı
│   ├── baglan.local.php        # Yerel ayarlar (commit edilmez)
│   └── baglan.local.php.example # Şablon
├── tema/
│   └── tema139/        # Aktif tema dosyaları
│       ├── home.php    # Ana sayfa
│       ├── header.php  # Ortak başlık
│       ├── footer.php  # Ortak altbilgi
│       └── assets/     # CSS, JS, resimler
├── uploads/            # Kullanıcı yüklemeleri
├── .htaccess           # Apache URL yönlendirme kuralları
├── docker-compose.yml  # Docker ortam tanımı
├── Dockerfile          # PHP+Apache imaj tarifi
└── emlakbudur_joker.sql # Veritabanı dökümü
```

---

## Sık Sorulan Sorular

### ❓ "Veritabanına bağlanamadı" hatası alıyorum

- `sistem/baglan.local.php` dosyasının mevcut olduğundan emin olun.  
- Docker kullanıyorsanız `$dbhost = "db"` olmalı.  
- XAMPP kullanıyorsanız `$dbhost = "localhost"` olmalı.  
- `docker compose up -d` komutunun çalıştığını doğrulayın.

### ❓ Sayfalar açılıyor ama resimler gelmiyor

`uploads/resim/` klasörüne yazma izni verin:

```bash
# Linux/macOS
chmod -R 777 uploads/

# Docker
docker exec emlakbudur_web chown -R www-data:www-data /var/www/html/uploads
```

### ❓ Admin paneline giremiyor

`emlakbudur_joker.sql` dosyasının eksiksiz içe aktarıldığını kontrol edin.  
phpMyAdmin'de `yonetici` tablosunu açıp kayıt olduğunu doğrulayın.

### ❓ .htaccess çalışmıyor (404 hataları)

XAMPP'ta `httpd.conf` dosyasında `AllowOverride None` → `AllowOverride All` yapın.  
Docker otomatik olarak ayarlanmıştır.

### ❓ Docker konteynerleri nasıl görürüm?

```bash
docker compose ps          # Çalışan konteynerler
docker compose logs web    # Web sunucu logları
docker compose logs db     # Veritabanı logları
```

---

## Geliştirme İpuçları

```bash
# PHP hata loglarını canlı takip etmek için
docker compose logs -f web

# Konteyner içinde komut çalıştırmak için
docker exec -it emlakbudur_web bash

# Veritabanı dökümü almak için
docker exec emlakbudur_db mysqldump -uemlak_user -pemlak_pass emlakbudur_joker > yedek.sql
```

---

## Lisans

Bu proje özel lisanslıdır. Tüm hakları saklıdır.
