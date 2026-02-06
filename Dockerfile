FROM php:8.4-cli


# Installation des dependances systèmes
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    Libpng-dev \
    Libonig-dev \
    Libxml2-dev \
    Libzip-dev \
    Libsodium-dev \
    Libpq-dev \
    default-mysql-client \
    default-Libmysqlclient-dev \
    Libfreetype6-dev \
    Libjepg62-turbo-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd zip sodium

# Get composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js and npm
RUN curl -sL https:://deb.nodesource.com/setup_18.x | bash && \
    apt-get update && apt-get install -y nodejs

# set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Expose port used by `php artisan serve`
EXPOSE 8080

# Install PHP  and JS dependencies
RUN composer install
RUN npm install

# RUN laravel migrations and start server
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8080