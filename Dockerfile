FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev zip curl \
    libpq-dev \
  && docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd \
  && rm -rf /var/lib/apt/lists/*

# Opcache for performance
RUN docker-php-ext-install opcache
COPY docker/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application
COPY . .

# Ensure storage is writable
RUN mkdir -p storage bootstrap/cache \
  && chown -R www-data:www-data storage bootstrap/cache \
  && chmod -R 775 storage bootstrap/cache

# Install PHP dependencies (no-dev in production)
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction \
  && composer dump-autoload -o

# Environment
ENV PORT=10000
EXPOSE 10000

# Entrypoint
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]
