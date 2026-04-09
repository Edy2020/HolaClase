# ---- Base image ----
FROM php:8.2-apache

# ---- System dependencies ----
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# ---- Composer ----
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ---- Apache config: point to Laravel's /public ----
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable mod_rewrite (needed for Laravel routes)
RUN a2enmod rewrite

# ---- Copy project files ----
WORKDIR /var/www/html
COPY . .

# ---- Install PHP dependencies (no dev) ----
RUN composer install --no-dev --optimize-autoloader --no-interaction

# ---- Storage & bootstrap permissions ----
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# ---- Expose port 80 ----
EXPOSE 80

# ---- Entrypoint: generate key, run migrations, start Apache ----
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]
