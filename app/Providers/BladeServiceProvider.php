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

        Blade::if('teacher', function () {
            $user = auth()->user();
            return ($user->isTeacher() || $user->isSuperAdmin());
        });

        Blade::if('bursal', function () {
            $user = auth()->user();
            return ($user->isBursal() || $user->isSuperAdmin());
        });

        Blade::if('student', function () {
            $user = auth()->user();
            return ($user->isStudent());
        });

        Blade::if('registrationLinkEnabled', function () {
            return get_settings('registration_link') === 1;
        });
    }
}