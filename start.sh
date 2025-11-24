#!/usr/bin/env bash
set -e

if [ ! -f .env ]; then cp .env.example .env; fi
if [ ! -L public/storage ]; then php artisan storage:link || true; fi

php artisan config:clear || true
php artisan migrate --force || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

php -S 0.0.0.0:${PORT} -t public
