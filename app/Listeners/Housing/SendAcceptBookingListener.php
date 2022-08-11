<?php

namespace App\Listeners\Housing;

use App\Events\BookingAccepted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Housing\BookingAcceptedNotification;

class SendAcceptBookingListener
{
    public function handle(BookingAccepted $event)
    {
        $user = $event->booking->author();

        $user->notify(new BookingAcceptedNotification($event->booking));

    }
}