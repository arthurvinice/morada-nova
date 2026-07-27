<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Gate para verificar se é SuperAdmin
        Gate::define('super-admin-access', function ($user) {
            return $user->isSuperAdmin();
        });

        // Gate para verificar se é Admin ou SuperAdmin
        Gate::define('admin-access', function ($user) {
            return $user->isAdmin() || $user->isSuperAdmin();
        });

        // Gate para qualquer usuário autenticado (standard, admin ou superadmin)
        Gate::define('standard-access', function ($user) {
            return in_array($user->role, ['standard', 'admin', 'superadmin']);
        });
    }
}