#!/bin/bash

# Post-deployment script for Laravel Cloud
# This script ensures the database is properly configured

echo "🚀 Starting post-deployment script..."

# Check if we're in a cloud environment and configure accordingly
if [ -n "$DATABASE_URL" ]; then
    echo "🔧 Using DATABASE_URL for MySQL connection..."
    export DB_CONNECTION=mysql
elif [ -n "$DB_HOST" ] && [ -n "$DB_DATABASE" ]; then
    echo "🔧 Using individual DB environment variables..."
    export DB_CONNECTION=mysql
else
    echo "⚠️  No database configuration found, falling back to SQLite..."
    # Ensure the database directory exists
    mkdir -p /var/www/html/database
    # Create SQLite database if it doesn't exist
    if [ ! -f "/var/www/html/database/database.sqlite" ]; then
        touch /var/www/html/database/database.sqlite
        chmod 664 /var/www/html/database/database.sqlite
    fi
    export DB_CONNECTION=sqlite
fi

# Wait a moment for database to be ready
sleep 2

# Run migrations with error handling
echo "🔄 Running migrations..."
if php artisan migrate --force; then
    echo "✅ Migrations completed successfully"
else
    echo "❌ Migration failed, retrying in 5 seconds..."
    sleep 5
    php artisan migrate --force
fi

# Clear and cache configurations
echo "🧹 Clearing and caching configurations..."
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Post-deployment script completed!"