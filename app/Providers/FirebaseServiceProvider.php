<?php

namespace App\Providers;

use App\Services\FirebaseService;
use App\Repositories\FirebaseProjectRepository;
use App\Repositories\FirebaseSkillRepository;
use App\Repositories\FirebaseEducationRepository;
use Illuminate\Support\ServiceProvider;

class FirebaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(FirebaseService::class, function ($app) {
            try {
                return new FirebaseService();
            } catch (\Exception $e) {
                // Log the error but don't crash the application
                \Log::warning('Firebase service initialization failed: ' . $e->getMessage());
                return new FirebaseService(); // Return a non-initialized instance
            }
        });

        // Register Firebase Repositories
        $this->app->singleton(FirebaseProjectRepository::class, function ($app) {
            return new FirebaseProjectRepository($app->make(FirebaseService::class));
        });

        $this->app->singleton(FirebaseSkillRepository::class, function ($app) {
            return new FirebaseSkillRepository($app->make(FirebaseService::class));
        });

        $this->app->singleton(FirebaseEducationRepository::class, function ($app) {
            return new FirebaseEducationRepository($app->make(FirebaseService::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
} 