# Étape 1 : image PHP avec extensions nécessaires
FROM php:8.2-fpm

# Installer les dépendances système et PHP
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev zip curl \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier le code source
COPY . .

# Installer les dépendances PHP via Composer
RUN composer install --optimize-autoloader --no-dev

# Optimiser les caches Laravel
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Exposer le port
EXPOSE 10000

# Commande de démarrage (Render utilise $PORT)
CMD php artisan serve --host=0.0.0.0 --port=10000
