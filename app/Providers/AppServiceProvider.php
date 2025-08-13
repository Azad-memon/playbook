<?php

namespace App\Providers;

use App\Repositories\CompanyRepository;
use App\Repositories\Interfaces\CompanyInterface;
use App\Repositories\Interfaces\UserManagementInterface;
use App\Repositories\UserManagementRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CompanyInterface::class, CompanyRepository::class);
        $this->app->bind(UserManagementInterface::class, UserManagementRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       Schema::defaultStringLength(191);
    }
}
