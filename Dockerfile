FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev libpng-dev libonig-dev libxml2-dev \
    sqlite3 libsqlite3-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Aktifkan mod_rewrite
RUN a2enmod rewrite

# Atasi warning ServerName (pastikan apache-custom.conf disediakan)
COPY apache-custom.conf /etc/apache2/conf-available/servername.conf
RUN a2enconf servername

# Set document root ke public/
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Pindah ke folder aplikasi
WORKDIR /var/www/html

# Copy source code
COPY . .

# Copy composer dari image resmi
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install dependencies Laravel
RUN composer install --no-dev --optimize-autoloader

# Copy .env
RUN cp .env.example .env

# Generate app key
RUN php artisan key:generate

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]
