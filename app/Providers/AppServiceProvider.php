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
            return $user->nivel === 'SuperAdmin';
        });

        // Gate para verificar se Administrador
        Gate::define('admin-access', function ($user) {
            return $user->nivel === 'Administrador';
        });

        //Gate para apenas Administrador ou SuperAdmin
        Gate::define('admin-or-super-admin', function ($user) {
            return $user->nivel === 'SuperAdmin' || $user->nivel === 'Administrador';
        });

        //Gate para que o administrador tenha acesso ao perfil dos usuarios do seu departamento
        Gate::define('user-access', function ($target) {
            $user = auth()->user();

            if ($user->nivel === 'SuperAdmin') {
                return true;
            }

            if ($user->nivel === 'Administrador' && $user->departamento_id === $target->departamento_id) {
                return $target->nivel !== 'SuperAdmin';
            }

            return $user->id === $target->id;
        });
    }
}
