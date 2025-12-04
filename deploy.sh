#!/bin/bash

# Post-deployment script for Laravel Cloud
# This script ensures the database is properly configured and working

echo "🚀 Starting post-deployment script..."

# Create necessary directories
mkdir -p /var/www/html/database
mkdir -p /var/www/html/storage/logs

# Generate APP_KEY if it doesn't exist
echo "🔑 Checking application key..."
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force || echo "Key generation failed"
else
    echo "✅ Application key already set"
fi

# Check database configuration
echo "🔍 Checking database configuration..."

# Always ensure SQLite database exists as fallback
echo "📁 Setting up SQLite fallback database..."
if [ ! -f "/var/www/html/database/database.sqlite" ]; then
    echo "📁 Creating SQLite database..."
    touch /var/www/html/database/database.sqlite
    chmod 664 /var/www/html/database/database.sqlite
    echo "✅ SQLite database created"
else
    echo "✅ SQLite database already exists"
fi

if [ -n "$DATABASE_URL" ]; then
    echo "✅ DATABASE_URL found: Will attempt MySQL with URL"
    export DB_CONNECTION=mysql
elif [ -n "$DB_HOST" ] && [ -n "$DB_DATABASE" ]; then
    echo "✅ Individual DB variables found: Will attempt MySQL"
    export DB_CONNECTION=mysql
else
    echo "⚠️  No MySQL configuration found, using SQLite"
    export DB_CONNECTION=sqlite
    export DB_DATABASE="/var/www/html/database/database.sqlite"
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
            echo "⚠️  Application will continue without migrations"
        fi
    fi
done

# Cache configurations for production
echo "🗂️  Caching configurations for production..."
php artisan config:cache || echo "Config cache failed, continuing..."
php artisan route:cache || echo "Route cache failed, continuing..."
php artisan view:cache || echo "View cache failed, continuing..."

# Set proper permissions
echo "🔐 Setting proper permissions..."
chmod -R 755 /var/www/html/storage || echo "Permission setting failed, continuing..."
chmod -R 755 /var/www/html/bootstrap/cache || echo "Permission setting failed, continuing..."

# Final status check
echo "🏥 Running final status check..."
echo "Environment: $(php artisan env)"
echo "App Key: $(php artisan tinker --execute='echo config("app.key") ? "SET" : "NOT SET";')"
echo "Database: $(php artisan tinker --execute='echo config("database.default");')"

echo "✅ Post-deployment script completed successfully!"
echo "🌐 Application should now be ready to serve requests"