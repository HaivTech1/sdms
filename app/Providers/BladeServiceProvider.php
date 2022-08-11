<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('superadmin', function () {
            $user = auth()->user();
            return ($user->isSuperAdmin());
        });

        Blade::if('admin', function () {
            $user = auth()->user();
            return ($user->isAdmin() || $user->isSuperAdmin());
        });

        Blade::if('staff', function () {
            $user = auth()->user();
            return ($user->isStaff() || $user->isAdmin() || $user->isSuperAdmin());
        });

        Blade::if('student', function () {
            $user = auth()->user();
            return ($user->isStudent() || $user->isAdmin() || $user->isSuperAdmin());
        });

    }
}