<?php

namespace App\Listeners;

use App\Events\SendNewTaskEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\SendNewTaskingNotification;

class SendNewTaskListener
{
    public function handle(SendNewTaskEvent $event)
    {
        
        foreach (Auth::user()->currentTeam->users as $user) {
            $user->notify(new SendNewTaskingNotification($event->task));
        }

    }
   
}