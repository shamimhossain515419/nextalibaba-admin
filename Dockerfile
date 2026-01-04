# Use official PHP CLI image
FROM php:8.2-cli

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev curl nodejs npm \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions for Laravel storage
RUN chmod -R 777 storage bootstrap/cache

# Install Node dependencies
RUN npm install

# Build Vite assets for production
RUN npm run build -- --mode production

# Create storage link (optional if already exists)
RUN php artisan storage:link || true

# Expose port
EXPOSE 10000

# Start Laravel built-in server
CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]
