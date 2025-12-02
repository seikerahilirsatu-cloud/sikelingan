#!/usr/bin/env bash
set -e
: "${PORT:?PORT env not set}"
if [ ! -f .env ]; then cp .env.example .env; fi
# If APP_KEY provided via env, enforce it
if [ -n "$APP_KEY" ]; then sed -i "s/^APP_KEY=.*/APP_KEY=${APP_KEY}/" .env || true; fi
# Ensure .env has a non-empty APP_KEY; generate if empty
CURRENT_KEY=$(grep -E '^APP_KEY=' .env | cut -d= -f2- || true)
if [ -z "$CURRENT_KEY" ]; then php artisan key:generate --force || true; fi
# Ensure storage directories for sessions/cache/views exist and are writable
mkdir -p storage/framework/sessions storage/framework/cache storage/framework/views || true
chown -R $(id -u):$(id -g) storage bootstrap/cache || true
chmod -R 775 storage bootstrap/cache || true
if [ -d public/storage ] && [ ! -L public/storage ]; then rm -rf public/storage || true; fi
if [ ! -L public/storage ]; then php artisan storage:link || true; fi
ls -ld public/storage || true
ls -ld storage/app/public || true
php artisan config:clear || true
php artisan view:clear || true
php artisan migrate --force || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Ensure Vite assets exist; build if manifest missing
if [ ! -f public/build/manifest.json ]; then
  if command -v npm >/dev/null 2>&1; then
    npm ci && npm run build || true
  fi
fi
echo "Starting PHP server on PORT=${PORT} with router public/server.php"
php -S 0.0.0.0:${PORT} -t public public/server.php
