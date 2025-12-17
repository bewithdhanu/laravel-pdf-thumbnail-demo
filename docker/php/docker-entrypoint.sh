#!/usr/bin/env sh
set -eu

cd /var/www/html

if [ ! -f artisan ]; then
  # Allow the repo to keep an empty ./src folder in git.
  # Composer refuses to create a project into a non-empty directory.
  rm -f .gitkeep .DS_Store || true

  # If something else exists in ./src, avoid clobbering it.
  if find . -mindepth 1 -maxdepth 1 -print -quit | grep -q .; then
    echo "[entrypoint] ./src is not empty but no artisan file exists. Refusing to overwrite."
    echo "[entrypoint] Please empty ./src (or point the volume somewhere else) and retry."
    exit 1
  fi

  echo "[entrypoint] No Laravel app found in ./src — creating a fresh Laravel project..."
  # Laravel's default composer scripts may create a SQLite DB + run migrations.
  # The user requested "without any database", so we skip scripts and do minimal setup ourselves.
  composer create-project laravel/laravel . --no-interaction --prefer-dist --no-scripts --no-install
fi

if [ ! -d vendor ]; then
  echo "[entrypoint] Installing Composer dependencies..."
  composer install --no-interaction --prefer-dist --no-scripts
fi

# Minimal Laravel initialization (without touching any DB)
if [ ! -f .env ] && [ -f .env.example ]; then
  cp .env.example .env
fi

if [ -f artisan ]; then
  php artisan key:generate --force --ansi || true
  php artisan package:discover --ansi || true
  php artisan storage:link --force --ansi || true
fi

# Ensure we don't leave behind a SQLite database file (the user requested no DB).
rm -f database/database.sqlite || true

# Ensure writable dirs (especially helpful on Linux; usually fine on macOS/Windows)
mkdir -p storage bootstrap/cache
chmod -R a+rwX storage bootstrap/cache || true

exec "$@"


