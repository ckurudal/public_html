FROM php:8.3-apache

# Gerekli PHP eklentilerini yükle
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libcurl4-openssl-dev \
    libonig-dev \
    libxml2-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mysqli \
        gd \
        mbstring \
        zip \
        curl \
        xml \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Apache mod_rewrite etkinleştir (.htaccess kuralları için)
RUN a2enmod rewrite

# Apache yapılandırması - AllowOverride etkinleştir
RUN sed -i 's|AllowOverride None|AllowOverride All|g' /etc/apache2/apache2.conf

# Uploads klasörüne yazma izni ver
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

WORKDIR /var/www/html

EXPOSE 80
