#!/usr/bin/env bash
# exit on error
set -o errexit

echo "🚀 Iniciando build en Render..."

echo "📦 Instalando dependencias de Composer..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "📦 Instalando dependencias de NPM..."
npm ci

echo "🎨 Compilando assets..."
npm run build

echo "⚡ Optimizando caché de Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo "🗄️ Ejecutando migraciones de base de datos..."
php artisan migrate --force

echo "🔗 Verificando storage link..."
php artisan storage:link || true

echo "✅ Build terminado correctamente."
