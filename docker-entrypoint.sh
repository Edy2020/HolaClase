#!/bin/bash
set -e

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run migrations automatically on startup
php artisan migrate --force

# Clear caches first, then rebuild (avoids "view path not found" on fresh deploy)
php artisan config:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache

# Start Apache in foreground
exec apache2-foreground
