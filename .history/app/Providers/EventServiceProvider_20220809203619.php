<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use App\Models\Product;
use App\Models\Property;
use App\Models\PostCategory;
use App\Events\BookingCreated;
use App\Observers\PostObserver;
use App\Observers\UserObserver;
use App\Events\SendNewTaskEvent;
use App\Observers\ProductObserver;
use App\Observers\PropertyObserver;
use Illuminate\Support\Facades\Event;
use App\Listeners\SendNewTaskListener;
use Illuminate\Auth\Events\Registered;
use App\Observers\PostCategoryObserber;
use App\Listeners\Housing\SendNewBookingListener;
use App\Listeners\Housing\SendAcceptBookingListener;
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
        BookingCreated::class => [
            SendNewBookingListener::class,
        ],
        BookingAccepted::class => [
            SendAcceptBookingListener::class,
        ],
        SendNewTaskEvent::class => [
            SendNewTaskListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Property::observe(PropertyObserver::class);
        Product::observe(ProductObserver::class);
        Post::observe(PostObserver::class);
        PostCategory::observe(PostCategoryObserber::class);
    }
}