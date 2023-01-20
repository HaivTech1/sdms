<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAdmissionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message, $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message, $subject)
    {
        //
        $dom = new \domdocument();
        $dom->loadHtml($message, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $dom->savehtml();
        $this->message = $dom;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(application('email').'', ucwords(application('name')))
                    ->subject($this->subject)
                    ->with([
                        'message' => $this->message,
                      ])
                      ->replyTo(application('email'))
                    ->markdown('emails.messaging.admission_mail');
    }
}
