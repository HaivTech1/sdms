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
            return ($user->isTeacher());
        });

        Blade::if('bursal', function () {
            $user = auth()->user();
            return ($user->isBursal() || $user->isSuperAdmin() || $user->isAdmin());
        });

        Blade::if('student', function () {
            $user = auth()->user();
            return ($user->isStudent());
        });

        Blade::if('registrationLinkEnabled', function () {
            return get_settings('registration_link') === 1;
        });

        Blade::if('midUploadEnabled', function () {
            return get_settings('mid_upload') === 1;
        });

        Blade::if('examUploadEnabled', function () {
            return get_settings('exam_upload') === 1;
        });

        Blade::if('classTeacher', function () {
            $user = auth()->user();
            return (auth()->check() && $user->gradeClassTeacher()->exists() && $user->isTeacher());
        });

        Blade::if('hasPaid', function () {
            if (get_settings('check_payment') === 1) {
                $user = auth()->user();
                $gradeId = $user->student->grade_id;
                $result = hasPaidFullFee($user, $gradeId)['status'];
                return $result;
            }

            return true;
        });
    }
}