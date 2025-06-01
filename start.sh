#!/usr/bin/env bash
# start.sh - Render Start Script

set -o errexit  # Exit on error

echo "🚀 Starting Laravel application..."

# Run database migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# Seed database if needed (optional)
# php artisan db:seed --force

# Clear and optimize for production
echo "⚡ Final optimizations..."
php artisan optimize

# Start the Laravel server
echo "🌐 Starting web server on port $PORT..."
php artisan serve --host=0.0.0.0 --port=$PORT 