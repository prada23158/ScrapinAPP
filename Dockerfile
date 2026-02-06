FROM php:8.4-cli

RUN apt-get update && apt-get install -y --no-install-recommends \
    git curl unzip zip \
    libpng-dev libonig-dev libxml2-dev libzip-dev libsodium-dev \
    libpq-dev default-mysql-client default-libmysqlclient-dev \
    libfreetype6-dev libjpeg62-turbo-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j$(nproc) pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd zip sodium \
  && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
  && apt-get update && apt-get install -y --no-install-recommends nodejs \
  && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Copie TOUT d'abord (artisan présent)
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress
RUN npm ci --no-audit --no-fund && npm run build

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
