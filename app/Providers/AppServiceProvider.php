<?php

namespace App\Providers;

use App\Repositories\RoleAndPermissionRepository;
use App\Repositories\RoleAndPermissionRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            RoleAndPermissionRepositoryInterface::class,
            RoleAndPermissionRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
