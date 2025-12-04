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
        //
    }
}
