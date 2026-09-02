#!/bin/bash
set -e

echo "=== Setting up Laravel on cPanel ==="

# Fix permissions
chmod -R 775 storage bootstrap/cache

# Clear & rebuild caches
php artisan optimize:clear
php artisan storage:link || true
php artisan migrate --force
php artisan db:seed --force || true
php artisan optimize:clear

echo "=== cPanel Setup Complete ==="
