<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use PDOException;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Skip if we're in console during build/install process
        if ($this->app->runningInConsole() && !$this->app->runningUnitTests()) {
            return;
        }

        // Only run in production
        if (!$this->app->environment('production')) {
            return;
        }

        // Try to configure the database connection intelligently
        try {
            $this->configureDatabaseConnection();
        } catch (\Throwable $e) {
            // Silently fail during build process - this will be retried during runtime
            return;
        }
    }

    private function configureDatabaseConnection(): void
    {
        try {
            // Ensure env function is available
            if (!function_exists('env')) {
                return;
            }

            // First, try to use DATABASE_URL if available
            if ($databaseUrl = env('DATABASE_URL')) {
                $this->configureDatabaseFromUrl($databaseUrl);
                return;
            }

            // Check if MySQL environment variables are available
            if (env('DB_HOST') && env('DB_DATABASE')) {
                Config::set('database.default', 'mysql');
                return;
            }

            // If no MySQL config is available, fall back to SQLite
            $this->configureSQLiteFallback();

        } catch (\Exception $e) {
            // Log the error but continue with SQLite fallback if possible
            if (function_exists('logger')) {
                logger()->warning('Database configuration failed, falling back to SQLite', [
                    'error' => $e->getMessage()
                ]);
            }
            
            try {
                $this->configureSQLiteFallback();
            } catch (\Throwable $fallbackError) {
                // If even SQLite fails, just return silently
                return;
            }
        }
    }

    private function configureDatabaseFromUrl(string $databaseUrl): void
    {
        $parsed = parse_url($databaseUrl);
        
        Config::set([
            'database.default' => 'mysql',
            'database.connections.mysql.host' => $parsed['host'] ?? 'localhost',
            'database.connections.mysql.port' => $parsed['port'] ?? 3306,
            'database.connections.mysql.database' => ltrim($parsed['path'] ?? '', '/'),
            'database.connections.mysql.username' => $parsed['user'] ?? '',
            'database.connections.mysql.password' => $parsed['pass'] ?? '',
        ]);
    }

    private function configureSQLiteFallback(): void
    {
        $sqlitePath = database_path('database.sqlite');
        
        // Create SQLite database if it doesn't exist
        if (!file_exists($sqlitePath)) {
            touch($sqlitePath);
            chmod($sqlitePath, 0664);
        }

        Config::set('database.default', 'sqlite');
        Config::set('database.connections.sqlite.database', $sqlitePath);
    }
}