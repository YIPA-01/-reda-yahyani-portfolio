#!/usr/bin/env bash
# build.sh - Render Build Script

set -o errexit  # Exit on error

echo "🚀 Starting build process..."

# Install PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

# Install Node.js dependencies
echo "📦 Installing Node.js dependencies..."
npm ci

# Build Vue.js assets with Vite
echo "🔨 Building Vue.js assets..."
npm run build

# Laravel optimizations for production
echo "⚡ Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Build completed successfully!" 