<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAttendancePdf extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $body, $subject, $attachment, $filename;

    public function __construct($body, $subject, $attachment = null, $filename = 'attendance.pdf')
    {
        $this->body = $body;
        $this->subject = $subject;
        $this->attachment = $attachment;
        $this->filename = $filename;
    }

    public function build()
    {
        $email = $this->from(application('email') . '', ucwords(application('name')))
            ->subject($this->subject)
            ->with(['body' => $this->body])
            ->replyTo(application('email'))
            ->markdown('emails.messaging.send_mail');

        if (!empty($this->attachment)) {
            $email->attachData($this->attachment, $this->filename, [
                'mime' => 'application/pdf',
            ]);
        }

        return $email;
    }
}
