#!/usr/bin/env bash
set -e
: "${PORT:?PORT env not set}"
if [ ! -f .env ]; then cp .env.example .env; fi
# If APP_KEY provided via env, enforce it
if [ -n "$APP_KEY" ]; then sed -i "s/^APP_KEY=.*/APP_KEY=${APP_KEY}/" .env || true; fi
# Ensure .env has a non-empty APP_KEY; generate if empty
CURRENT_KEY=$(grep -E '^APP_KEY=' .env | cut -d= -f2- || true)
if [ -z "$CURRENT_KEY" ]; then php artisan key:generate --force || true; fi
if [ ! -L public/storage ]; then php artisan storage:link || true; fi
php artisan config:clear || true
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
echo "Starting PHP server on PORT=${PORT} with router server.php"
php -S 0.0.0.0:${PORT} -t public server.php
