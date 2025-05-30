<?php

namespace App\Providers;
//use Illuminate\Auth\Access\Gate;
use Illuminate\Support\ServiceProvider;
//use illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Gate;
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
        Gate::before(function ($user,$ability){
            return $user->hasRole('superadmin') ? true :null;
        });
    }
}
