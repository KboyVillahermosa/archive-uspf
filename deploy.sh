#!/bin/bash

# Laravel Cloud Deployment Script
echo "🚀 Starting Laravel Cloud deployment..."

# Set proper permissions
echo "🔐 Setting file permissions..."
chmod -R 755 /var/www/html/storage
chmod -R 755 /var/www/html/bootstrap/cache

# Generate APP_KEY if missing
echo "🔑 Checking application key..."
if [ -z "$APP_KEY" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Clear caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Run package discovery
echo "📦 Running package discovery..."
php artisan package:discover --ansi

# Wait for database connection
echo "⏳ Waiting for database connection..."
sleep 5

# Test database connection with retry logic
echo "🔄 Testing database connection..."
for i in {1..5}; do
    if php artisan migrate:status >/dev/null 2>&1; then
        echo "✅ Database connection successful"
        break
    else
        echo "❌ Database connection attempt $i failed, retrying in 10 seconds..."
        sleep 10
        if [ $i -eq 5 ]; then
            echo "💥 Database connection failed after 5 attempts"
            exit 1
        fi
    fi
done

# Run database setup (migrations and seeders)
echo "🗄️ Setting up database..."
php artisan app:setup-database

# Cache everything for production
echo "🗂️ Caching for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Deployment completed successfully!"