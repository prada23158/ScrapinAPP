FROM php:8.3-fpm

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip

# Installer les extensions PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www

# Copier les fichiers
COPY . .

# Installer les dépendances
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Supprimer les fichiers de cache
RUN rm -rf bootstrap/cache/*.php \
    && rm -rf storage/framework/cache/data/* \
    && rm -rf storage/framework/views/*

# Permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache
    
EXPOSE 8080

# Script de démarrage avec debug
CMD echo "=== DEBUG DATABASE CONNECTION ===" && \
    echo "DB_HOST: $DB_HOST" && \
    echo "DB_PORT: $DB_PORT" && \
    echo "DB_DATABASE: $DB_DATABASE" && \
    echo "DB_USERNAME: $DB_USERNAME" && \
    echo "Testing connection..." && \
    nc -zv $DB_HOST $DB_PORT && \
    echo "=== END DEBUG ===" && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=8080
