<?php

namespace App\Mail\Messaging;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message, $subject, $email, $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Request $request, User $user)
    {
        //
        $dom = new \domdocument();
        $dom->loadHtml($request->message, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $dom->savehtml();
        $this->message = $dom;//$request->message;
        $this->subject = $request->subject;
        $this->email = $user->email;
        $this->name = $user->name();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(application('email').'', ucwords($this->name))
                    ->subject($this->subject)
                    ->with([
                        'message' => $this->message,
                      ])
                      ->replyTo($this->email)
                    ->markdown('emails.messaging.send_mail');
    }
}