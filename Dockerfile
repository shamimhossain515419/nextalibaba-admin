# Base image
FROM php:8.2-cli

# System dependencies
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev curl nodejs npm \
    && docker-php-ext-install pdo pdo_mysql zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies and build Vite assets
RUN npm install
RUN npm run build

# Laravel permissions
RUN chmod -R 777 storage bootstrap/cache

# Storage link
RUN php artisan storage:link || true

# Expose port
EXPOSE 10000

# Start Laravel built-in server
CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]
