#!/bin/bash

# Post-deployment script for Laravel Cloud
# This script ensures the database is properly configured and working

echo "🚀 Starting post-deployment script..."

# Create necessary directories
mkdir -p /var/www/html/database
mkdir -p /var/www/html/storage/logs

# Check database configuration
echo "🔍 Checking database configuration..."

if [ -n "$DATABASE_URL" ]; then
    echo "✅ DATABASE_URL found: Using MySQL with URL"
    export DB_CONNECTION=mysql
elif [ -n "$DB_HOST" ] && [ -n "$DB_DATABASE" ]; then
    echo "✅ Individual DB variables found: Using MySQL"
    export DB_CONNECTION=mysql
else
    echo "⚠️  No MySQL configuration found, setting up SQLite..."
    # Create SQLite database if it doesn't exist
    if [ ! -f "/var/www/html/database/database.sqlite" ]; then
        echo "📁 Creating SQLite database..."
        touch /var/www/html/database/database.sqlite
        chmod 664 /var/www/html/database/database.sqlite
        echo "✅ SQLite database created"
    fi
    export DB_CONNECTION=sqlite
fi

# Clear any cached configuration that might interfere
echo "🧹 Clearing cached configurations..."
php artisan config:clear || echo "Config clear failed, continuing..."
php artisan route:clear || echo "Route clear failed, continuing..."
php artisan view:clear || echo "View clear failed, continuing..."

# Run package discovery now that environment is ready
echo "📦 Discovering packages..."
php artisan package:discover --ansi || echo "Package discovery failed, continuing..."

# Wait for database to be ready (for cloud environments)
echo "⏳ Waiting for database to be ready..."
sleep 3

# Test database connection
echo "🔄 Testing database connection..."
if php artisan tinker --execute="DB::connection()->getPdo(); echo 'Database connection successful';" 2>/dev/null; then
    echo "✅ Database connection test passed"
else
    echo "❌ Database connection test failed, will retry during migration"
fi

# Run migrations with retries
echo "🔄 Running migrations..."
RETRY_COUNT=0
MAX_RETRIES=3

while [ $RETRY_COUNT -lt $MAX_RETRIES ]; do
    if php artisan migrate --force; then
        echo "✅ Migrations completed successfully"
        break
    else
        RETRY_COUNT=$((RETRY_COUNT + 1))
        echo "❌ Migration attempt $RETRY_COUNT failed"
        if [ $RETRY_COUNT -lt $MAX_RETRIES ]; then
            echo "⏳ Retrying in 10 seconds..."
            sleep 10
        else
            echo "❌ All migration attempts failed"
            exit 1
        fi
    fi
done

# Cache configurations for production
echo "🗂️  Caching configurations for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Final health check
echo "🏥 Running final health check..."
if curl -f -s "http://localhost/health" >/dev/null 2>&1; then
    echo "✅ Application health check passed"
else
    echo "⚠️  Health check endpoint not accessible (this might be normal)"
fi

echo "✅ Post-deployment script completed successfully!"
echo "🌐 Application should now be ready to serve requests"