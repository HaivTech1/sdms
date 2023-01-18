<?php

namespace App\Listeners;

use App\Events\ResultEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMidTermResultListener
{
    public function handle(ResultEvent $event)
    {
        
        $student = Student::find($event->result->student_id);
        $student->guardian->notify(new SendNewPaymentNotification($event->result));

    }
}
