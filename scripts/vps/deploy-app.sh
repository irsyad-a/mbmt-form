#!/usr/bin/env bash
set -euo pipefail

APP_DIR="${APP_DIR:-/var/www/mbmt}"
PHP_BIN="${PHP_BIN:-php}"
COMPOSER_BIN="${COMPOSER_BIN:-composer}"
NPM_BIN="${NPM_BIN:-npm}"

if [ ! -f "${APP_DIR}/artisan" ]; then
  echo "[ERROR] File artisan tidak ditemukan di ${APP_DIR}" >&2
  echo "[INFO] Set APP_DIR terlebih dahulu jika lokasi aplikasi berbeda." >&2
  exit 1
fi

if command -v sudo >/dev/null 2>&1 && [ "$(id -u)" -ne 0 ]; then
  SUDO="sudo"
else
  SUDO=""
fi

cd "${APP_DIR}"

echo "[1/7] Pull update dari repository"
git pull --ff-only

echo "[2/7] Install dependency PHP production"
"${COMPOSER_BIN}" install --no-dev --optimize-autoloader --no-interaction

echo "[3/7] Install dependency JS production"
"${NPM_BIN}" ci --no-audit --no-fund

echo "[4/7] Build asset Vite"
"${NPM_BIN}" run build

echo "[5/7] Jalankan migration"
"${PHP_BIN}" artisan migrate --force

echo "[6/7] Optimasi cache Laravel"
"${PHP_BIN}" artisan storage:link || true
"${PHP_BIN}" artisan optimize:clear
"${PHP_BIN}" artisan config:cache
"${PHP_BIN}" artisan route:cache
"${PHP_BIN}" artisan view:cache

echo "[7/7] Set permission folder runtime"
${SUDO} chown -R www-data:www-data storage bootstrap/cache
${SUDO} chmod -R ug+rwx storage bootstrap/cache

echo "Deploy selesai."
