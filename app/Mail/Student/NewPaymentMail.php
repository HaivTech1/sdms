<?php

namespace App\Mail\Student;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewPaymentMail extends Mailable
{
    use Queueable;
   
    public $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function build()
    {
        return $this->subject("New Fees payment: {$this->payment->transactionId()}")
            ->markdown('emails.new_payment');
    }
}
