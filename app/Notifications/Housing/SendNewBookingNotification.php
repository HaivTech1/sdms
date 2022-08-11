<?php

namespace App\Notifications\Housing;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use App\Mail\Housing\NewBookingEmail;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendNewBookingNotification extends Notification
{
    use Queueable;

    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }


    public function toMail(User $user)
    {
        return (new NewBookingEmail($this->booking))
            ->to($user->email(), $user->name());
    }
}