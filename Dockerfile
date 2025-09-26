FROM php:8.4-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    libpq-dev \
    libzip-dev \
    libbz2-dev \
    libssl-dev \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Set PHP configuration
RUN echo "memory_limit = 512M" >> /usr/local/etc/php/php.ini \
    && echo "upload_max_filesize = 50M" >> /usr/local/etc/php/php.ini \
    && echo "post_max_size = 50M" >> /usr/local/etc/php/php.ini

# Install Composer
COPY --from=composer:2.8.8 /usr/bin/composer /usr/bin/composer

# Create application user
ARG user=warehouse_management_user
ARG uid=1000
RUN useradd -G www-data,root -u $uid -d /home/$user $user \
    && mkdir -p /home/$user/.composer \
    && chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

# Copy composer files first (for better caching)
COPY --chown=$user:$user composer.json ./

# Switch to application user for composer install
USER $user
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Switch back to root for file operations
USER root

# Copy application code
COPY --chown=$user:$user . .

# Set proper permissions
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache \
    && chown -R $user:www-data /var/www/storage /var/www/bootstrap/cache

# Switch to application user
USER $user

EXPOSE 9000

CMD ["php-fpm"]