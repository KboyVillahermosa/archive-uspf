# REQUIRED Laravel Cloud Environment Variables
# Add these to your Laravel Cloud project environment settings

# Application Configuration (REQUIRED)
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:REPLACE_WITH_GENERATED_KEY

# Application URL (set to your Laravel Cloud URL)
APP_URL=https://archive-uspf-main-7vwnix.laravel.cloud

# Database Configuration
# Laravel Cloud will provide these automatically when you create a database
# If you create a MySQL database in Laravel Cloud, these will be set automatically:
# DB_CONNECTION=mysql
# DB_HOST=
# DB_PORT=3306
# DB_DATABASE=
# DB_USERNAME=
# DB_PASSWORD=

# OR use DATABASE_URL (Laravel Cloud format)
# DATABASE_URL=mysql://username:password@host:port/database

# Session and Cache
SESSION_DRIVER=file
CACHE_STORE=file

# Mail Configuration (optional)
MAIL_MAILER=log

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error

# Important Notes:
# 1. The APP_KEY will be generated automatically by the deployment script if not set
# 2. Database settings will be provided by Laravel Cloud when you create a database
# 3. If no database is configured, the app will fall back to SQLite automatically