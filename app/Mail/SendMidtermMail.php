<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMidtermMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $body, $subject, $attachment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($body, $subject, $attachment = null)
    {
        $this->body = $body;
        $this->subject = $subject;
        $this->attachment = $attachment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->from(application('email') . '', ucwords(application('name')))
            ->subject($this->subject)
            ->with([
                'body' => $this->body,
            ])
            ->replyTo(application('email'))
            ->markdown('emails.messaging.mid_term_mail');

        if (!empty($this->attachment)){ 
            $email->attach($this->attachment); 
        }

        return $email;
    }
}