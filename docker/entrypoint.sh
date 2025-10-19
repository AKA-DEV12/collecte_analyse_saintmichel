#!/usr/bin/env sh
set -e

# Ensure storage and cache are writable
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

# Generate app key if missing
if [ -z "${APP_KEY}" ]; then
  php artisan key:generate --force || true
fi

# Run migrations in production if requested
if [ "${RUN_MIGRATIONS}" = "true" ]; then
  php artisan migrate --force || true
fi

# Optimize caches
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Start the application server
exec php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
