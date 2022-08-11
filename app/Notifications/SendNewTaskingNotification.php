<?php

namespace App\Notifications;

use App\Models\Task;
use App\Models\User;
use App\Mail\NewTaskEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendNewTaskingNotification extends Notification
{
    use Queueable;
    
    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }


    public function toMail(User $user)
    {
        return (new NewTaskEmail($this->task))
            ->to($user->email(), $user->name());
    }

}