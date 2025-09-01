<?php

namespace App\Jobs;

use App\Mail\SendMidtermMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class NotifyParentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $student;
    protected $body;
    protected $subject;
    protected $path;
    protected $eventId;

    /**
     * Create a new job instance.
     */
    public function __construct($student, $body, $subject, $path = null, $eventId = null)
    {
        $this->student = $student;
        $this->body = $body;
        $this->subject = $subject;
        $this->path = $path;
        $this->eventId = $eventId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Father
        if (get_settings('father_notification') === 1 && isset($this->student->father) && !empty($this->student->father->email)) {
            $email = strtolower(trim($this->student->father->email));
            if ($this->shouldSend('email', $email)) {
                Mail::to($this->student->father->email)
                    ->send(new SendMidtermMail($this->body, $this->subject, $this->path));
            }
        }

        // Mother
        if (get_settings('mother_notification') === 1 && isset($this->student->mother) && !empty($this->student->mother->email)) {
            $email = strtolower(trim($this->student->mother->email));
            if ($this->shouldSend('email', $email)) {
                Mail::to($this->student->mother->email)
                    ->send(new SendMidtermMail($this->body, $this->subject, $this->path));
            }
        }

        // Guardian
        if (get_settings('guardian_notification') === 1 && isset($this->student->guardian) && !empty($this->student->guardian->email)) {
            $email = strtolower(trim($this->student->guardian->email));
            if ($this->shouldSend('email', $email)) {
                Mail::to($this->student->guardian->email)
                    ->send(new SendMidtermMail($this->body, $this->subject, $this->path));
            }
        }
    }

    /**
     * Decide whether to send based on dedupe cache keyed by event and channel+contact.
     */
    protected function shouldSend(string $channel, string $contact): bool
    {
        if (! $this->eventId) {
            return true; // no event context, send normally
        }

        $key = sprintf('event_notify:%s:%s:%s', $this->eventId, $channel, md5($contact));
        // Try to add cache key; if it already exists, skip sending. TTL 1 day.
        return Cache::add($key, true, 86400);
    }
}
