<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Lesson;
use App\Models\Comment;
use App\Models\Assignment;
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
            Comment::TABLE    => Comment::class,
            Lesson::TABLE    => Lesson::class,
            Assignment::TABLE    => Assignment::class,
        ]);
    }
}