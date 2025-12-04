<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\FacultyResearch;
use App\Models\StudentResearch;
use App\Models\Thesis;
use App\Models\Dissertation;
use App\Policies\UserPolicy;
use App\Policies\FacultyResearchPolicy;
use App\Policies\StudentResearchPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        FacultyResearch::class => FacultyResearchPolicy::class,
        StudentResearch::class => StudentResearchPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configure database for production environment
        if ($this->app->environment('production')) {
            // Force MySQL as the database connection
            config(['database.default' => 'mysql']);
            
            // If DATABASE_URL is available (common in cloud environments), use it
            if ($databaseUrl = env('DATABASE_URL')) {
                $parsed = parse_url($databaseUrl);
                config([
                    'database.connections.mysql.host' => $parsed['host'] ?? 'localhost',
                    'database.connections.mysql.port' => $parsed['port'] ?? 3306,
                    'database.connections.mysql.database' => ltrim($parsed['path'] ?? '', '/'),
                    'database.connections.mysql.username' => $parsed['user'] ?? '',
                    'database.connections.mysql.password' => $parsed['pass'] ?? '',
                ]);
            }
        }
    }
}
