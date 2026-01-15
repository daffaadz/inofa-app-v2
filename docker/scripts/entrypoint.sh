#!/bin/bash
set -e

echo "🚀 Starting Laravel Application Setup..."

# Wait for MySQL to be ready
echo "⏳ Waiting for MySQL to be ready..."
while ! nc -z mysql 3306; do
    sleep 1
done
echo "✅ MySQL is ready!"

# Wait for Redis to be ready
echo "⏳ Waiting for Redis to be ready..."
while ! nc -z redis 6379; do
    sleep 1
done
echo "✅ Redis is ready!"

# Install composer dependencies if vendor folder doesn't exist
if [ ! -d "vendor" ]; then
    echo "📦 Installing Composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Generate app key if not exists
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force
fi

# Run migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# Clear and cache configuration
echo "🧹 Clearing and caching configuration..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Create storage link
echo "🔗 Creating storage link..."
php artisan storage:link --force || true

echo "✅ Laravel Application is ready!"

# Execute the main container command
exec "$@"
