<?php

namespace App\Listeners\Housing;

use App\Events\BookingCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Housing\SendNewBookingNotification;

class SendNewBookingListener
{
    public function handle(BookingCreated $event)
    {
        $admins = User::where('type', User::ADMIN)->get();

        foreach ($admins as $admin) {
            $admin->notify(new SendNewBookingNotification($event->booking));
        }

    }
}