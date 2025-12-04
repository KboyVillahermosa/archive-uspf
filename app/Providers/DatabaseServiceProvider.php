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
            // If anything fails, just use SQLite
            $this->configureSQLiteFallback();
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
                if ($this->testMySQLConnection($databaseUrl)) {
                    $this->configureDatabaseFromUrl($databaseUrl);
                    return;
                }
            }

            // Check if MySQL environment variables are available and working
            if (env('DB_HOST') && env('DB_DATABASE')) {
                if ($this->testMySQLConnection()) {
                    Config::set('database.default', 'mysql');
                    return;
                }
            }

            // If MySQL doesn't work, fall back to SQLite
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

    private function testMySQLConnection($databaseUrl = null): bool
    {
        try {
            if ($databaseUrl) {
                $parsed = parse_url($databaseUrl);
                $host = $parsed['host'] ?? 'localhost';
                $port = $parsed['port'] ?? 3306;
                $database = ltrim($parsed['path'] ?? '', '/');
                $username = $parsed['user'] ?? '';
                $password = $parsed['pass'] ?? '';
            } else {
                $host = env('DB_HOST', '127.0.0.1');
                $port = env('DB_PORT', '3306');
                $database = env('DB_DATABASE', '');
                $username = env('DB_USERNAME', '');
                $password = env('DB_PASSWORD', '');
            }

            // Try to create a PDO connection to test
            $dsn = "mysql:host={$host};port={$port};dbname={$database}";
            $pdo = new \PDO($dsn, $username, $password, [
                \PDO::ATTR_TIMEOUT => 3,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]);
            
            // Test with a simple query
            $pdo->query('SELECT 1');
            return true;
            
        } catch (\Exception $e) {
            return false;
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