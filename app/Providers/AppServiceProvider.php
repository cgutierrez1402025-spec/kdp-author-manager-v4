<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::before(function ($user, string $ability): ?bool {
            if ($user->hasRole('admin')) {
                return true;
            }

            return $user->hasPermission($ability) ? true : null;
        });

    }
}
