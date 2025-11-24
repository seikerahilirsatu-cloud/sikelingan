#!/usr/bin/env bash
set -e
: "${PORT:?PORT env not set}"
if [ ! -f .env ]; then cp .env.example .env; fi
if [ -n "$APP_KEY" ]; then sed -i "s/^APP_KEY=.*/APP_KEY=${APP_KEY}/" .env || true; fi
if [ -z "$APP_KEY" ]; then if ! grep -q "^APP_KEY=" .env 2>/dev/null; then php artisan key:generate || true; fi; fi
if [ ! -L public/storage ]; then php artisan storage:link || true; fi
php artisan config:clear || true
php artisan migrate --force || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true
echo "Starting PHP server on PORT=${PORT}"
php -S 0.0.0.0:${PORT} -t public public/index.php
