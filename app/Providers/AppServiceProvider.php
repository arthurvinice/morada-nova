<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
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
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();

        // Gate para verificar se é SuperAdmin
        Gate::define('super-admin-access', function ($user) {
            return $user->role === 'SuperAdmin';
        });

        // Gate para verificar se é Aluno
        Gate::define('aluno-access', function ($user) {
            return $user->role === 'Aluno' || $user->role === 'SuperAdmin';
        });
    }
}
