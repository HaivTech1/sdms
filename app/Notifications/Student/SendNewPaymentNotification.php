<?php

namespace App\Notifications\Student;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use App\Events\Student\PaymentEvent;
use App\Mail\Student\NewPaymentMail;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendNewPaymentNotification extends Notification 
{
    use Queueable;

    public $payment;

    public function __construct(Payment $payment)
   {
       $this->payment = $payment;
   }

   public function via($notifiable)
   {
       return ['mail'];
   }

   public function toMail(User $user)
   {
       return (new NewPaymentMail($this->payment))
           ->to($user->email(), $user->name());
   }
}
