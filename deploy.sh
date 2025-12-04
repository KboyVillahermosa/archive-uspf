#!/bin/bash

# Post-deployment script for Laravel Cloud
# This script ensures the database is properly configured

echo "🚀 Starting post-deployment script..."

# Force MySQL as the database connection for production
echo "🔧 Setting database connection to MySQL..."
export DB_CONNECTION=mysql

# Ensure the database directory exists (for logs and cache)
mkdir -p /var/www/html/database

# Run migrations
echo "🔄 Running migrations..."
php artisan migrate --force

# Clear and cache configurations
echo "🧹 Clearing and caching configurations..."
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Post-deployment script completed!"