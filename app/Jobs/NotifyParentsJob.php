<?php

namespace App\Jobs;

use App\Mail\SendMidtermMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyParentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $student;
    protected $body;
    protected $subject;
    protected $path;

    /**
     * Create a new job instance.
     */
    public function __construct($student, $body, $subject, $path = null)
    {
        $this->student = $student;
        $this->body = $body;
        $this->subject = $subject;
        $this->path = $path;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (get_settings('father_notification') === 1 && isset($this->student->father) && !empty($this->student->father->email)) {
            Mail::to($this->student->father->email)
                ->send(new SendMidtermMail($this->body, $this->subject, $this->path));
        }

        if (get_settings('mother_notification') === 1 && isset($this->student->mother) && !empty($this->student->mother->email)) {
            Mail::to($this->student->mother->email)
                ->send(new SendMidtermMail($this->body, $this->subject, $this->path));
        }

        if (get_settings('guardian_notification') === 1 && isset($this->student->guardian) && !empty($this->student->guardian->email)) {
            Mail::to($this->student->guardian->email)
                ->send(new SendMidtermMail($this->body, $this->subject, $this->path));
        }
    }
}
