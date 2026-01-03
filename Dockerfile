FROM php:8.2-cli

# System dependencies
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel permissions
RUN chmod -R 777 storage bootstrap/cache

# Storage link (after project exists)
RUN php artisan storage:link || true

EXPOSE 10000

CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]
