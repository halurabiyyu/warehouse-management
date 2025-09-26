FROM php:8.4-fpm

# Install extensions
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev libzip-dev \
    zip unzip git curl \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:2.8.8 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

# Install sebagai root untuk avoid permission issues
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction --no-cache

# Set permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache 2>/dev/null || mkdir -p /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]