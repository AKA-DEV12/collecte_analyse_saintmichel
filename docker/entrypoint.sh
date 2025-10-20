#!/usr/bin/env sh
set -e

# Ensure storage and cache are writable
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

# Generate app key if missing
if [ -z "${APP_KEY}" ]; then
  php artisan key:generate --force || true
fi

# Clear config first to ensure fresh env is read
php artisan config:clear || true

# Ensure required export packages are installed in runtime (as a fallback)
if [ ! -d "vendor/maatwebsite/excel" ] || [ ! -d "vendor/barryvdh/laravel-dompdf" ]; then
  echo "[entrypoint] Installing export packages..."
  composer require maatwebsite/excel barryvdh/laravel-dompdf --no-interaction || true
fi

# Publish vendor assets/config for Excel and DomPDF
php artisan vendor:publish --provider="Maatwebsite\\Excel\\ExcelServiceProvider" --force || true
php artisan vendor:publish --provider="Barryvdh\\DomPDF\\ServiceProvider" --force || true

# Run migrations in production if requested (with retry)
if [ "${RUN_MIGRATIONS}" = "true" ]; then
  echo "[entrypoint] Running migrations with retry..."
  set +e
  ATTEMPTS=0
  MAX_ATTEMPTS=20
  until php artisan migrate --force; do
    ATTEMPTS=$((ATTEMPTS+1))
    if [ $ATTEMPTS -ge $MAX_ATTEMPTS ]; then
      echo "[entrypoint] Migrations failed after ${ATTEMPTS} attempts. Continuing startup."
      break
    fi
    echo "[entrypoint] Migration failed. Retrying in 5s... (${ATTEMPTS}/${MAX_ATTEMPTS})"
    sleep 5
  done
  set -e
fi

# Ensure storage symlink exists (prevents 500 on assets)
php artisan storage:link || true

# Optimize caches
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Start the application server
exec php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
