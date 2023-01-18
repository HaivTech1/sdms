<?php

namespace App\Providers;

use App\Models\Fee;
use App\Models\User;
use App\Models\Payment;
use App\Events\ResultEvent;
use App\Observers\FeeObserver;
use App\Observers\UserObserver;
use App\Events\SendNewTaskEvent;
use App\Observers\PaymentObserver;
use App\Events\Student\PaymentEvent;
use Illuminate\Support\Facades\Event;
use App\Listeners\SendNewTaskListener;
use Illuminate\Auth\Events\Registered;
use App\Listeners\SendMidTermResultListener;
use App\Listeners\Student\SendNewPaymentListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SendNewTaskEvent::class => [
            SendNewTaskListener::class
        ],
        PaymentEvent::class => [
            SendNewPaymentListener::class,
        ],
        ResultEvent::class => [
            SendMidTermResultListener::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        // User::observe(UserObserver::class);
        // Fee::observe(FeeObserver::class);
        // Payment::observe(PaymentObserver::class);
    }
}