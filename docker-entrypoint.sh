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

# Clear all caches (ignore errors on first boot)
php artisan config:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true

# Rebuild optimized caches (skip view:cache — it's unreliable in Docker)
php artisan config:cache
php artisan route:cache

# Start Apache in foreground
exec apache2-foreground
