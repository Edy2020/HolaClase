#!/bin/bash
set -e

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run migrations automatically on startup
php artisan migrate --force

# Create storage symlink (public disk)
php artisan storage:link --force 2>/dev/null || true

# Clear all caches first
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Rebuild optimized caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache in foreground
exec apache2-foreground
