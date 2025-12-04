#!/bin/bash

# Post-deployment script for Laravel Cloud
# This script ensures the database is properly configured

echo "🚀 Starting post-deployment script..."

# Ensure the database directory exists
mkdir -p /var/www/html/database

# If using SQLite and the database doesn't exist, create it
if [ "$DB_CONNECTION" = "sqlite" ] && [ ! -f "/var/www/html/database/database.sqlite" ]; then
    echo "📁 Creating SQLite database file..."
    touch /var/www/html/database/database.sqlite
    chmod 664 /var/www/html/database/database.sqlite
fi

# Run migrations
echo "🔄 Running migrations..."
php artisan migrate --force

# Clear and cache configurations
echo "🧹 Clearing and caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Post-deployment script completed!"