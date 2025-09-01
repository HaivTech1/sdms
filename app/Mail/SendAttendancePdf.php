<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendAttendancePdf extends Mailable
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
            ->with(['body' => $this->body, 'subject' => $this->subject])
            ->replyTo(application('email'))
            ->markdown('emails.messaging.send_mail');

        if (!empty($this->attachment)) {
            // If attachment is a filesystem path, attach by path to avoid serializing binary into the queue payload
            if (is_string($this->attachment) && file_exists($this->attachment)) {
                info('SendAttendancePdf Mailable: attaching file path', ['path' => $this->attachment, 'filename' => $this->filename, 'size' => filesize($this->attachment)]);
                $email->attach($this->attachment, ['as' => $this->filename, 'mime' => 'application/pdf']);
            } else {
                // fallback: attach raw data
                info('SendAttendancePdf Mailable: attaching raw data, bytes length: ' . strlen($this->attachment));
                $email->attachData($this->attachment, $this->filename, [
                    'mime' => 'application/pdf',
                ]);
            }
        }

        return $email;
    }
}
