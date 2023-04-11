<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestEmailSender extends Mailable
{
    use Queueable, SerializesModels;

    
    public function build()
    {
        return $this->view('emails.mail-tester');
    }
}
