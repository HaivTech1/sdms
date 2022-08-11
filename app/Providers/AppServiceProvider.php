<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use App\Models\Property;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ResetPassword::createUrlUsing(
            function ($notifiable, $token) {
                return "http://localhost:8000/reset-password/{$token}?email={$notifiable->getEmailForPasswordReset()}";
            }
        );
        $this->bootEloquentMorphsRelations();
    }

    public function bootEloquentMorphsRelations()
    {
        Relation::morphMap([
            User::TABLE => User::class,
            Property::TABLE => Property::class,
            User::TABLE       => User::class,
            Post::TABLE       => Post::class,
        ]);
    }
}