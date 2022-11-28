<?php

namespace App\Listeners\Student;

use App\Models\User;
use App\Events\Student\PaymentEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Student\SendNewPaymentNotification;

class SendNewPaymentListener implements ShouldQueue
{
    public function handle(PaymentEvent $event)
    {
        $admins = User::whereType(2)->get();

        foreach ($admins as $admin) {
            $admin->notify(new SendNewPaymentNotification($event->payment));
        }
    }
}
