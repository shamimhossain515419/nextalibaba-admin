# Base image
FROM php:8.2-cli

# System dependencies
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev curl nodejs npm \
    libcurl4-openssl-dev pkg-config libssl-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# MongoDB PHP Extension install
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node and BUILD Vite assets
# এটি খুবই গুরুত্বপূর্ণ, কারণ এটিই CSS/JS ফাইল তৈরি করে
RUN npm install && npm run build

# Permissions
RUN chmod -R 777 storage bootstrap/cache

# Storage link
RUN php artisan storage:link || true

EXPOSE 10000

# Start Server
CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]