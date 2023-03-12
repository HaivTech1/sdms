<?php

namespace App\Jobs;

use App\Models\Student;
use App\Mail\SendMidtermMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class MidTermResultJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $student;
    public $message;
    public $subject;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Student $student, $message, $subject)
    {
        $this->student = $student;
        $this->message = $message;
        $this->subject = $subject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->student->mother->email())->send(new SendMidtermMail($message, $subject));
    }
}
