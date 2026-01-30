<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        //
        Gate::define('admin', function($user) {
            //function($user) - a closure, automatically passed by Larvale, represents authenticated user
            return $user->role_id === User::ADMIN_ROLE_ID;
        });
        Gate::define('hotel', function($user) {
            //function($user) - a closure, automatically passed by Larvale, represents authenticated user
            return $user->role_id === User::HOTEL_ROLE_ID;
        });
        Gate::define('restaurant', function($user) {
            //function($user) - a closure, automatically passed by Larvale, represents authenticated user
            return $user->role_id === User::RESTAURANT_ROLE_ID;
        });
    }
}
