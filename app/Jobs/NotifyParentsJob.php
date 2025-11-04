<?php

namespace App\Jobs;

use App\Mail\SendMidtermMail;
use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class NotifyParentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $studentId;
    protected $body;
    protected $subject;
    protected $filename;
    protected $eventId;

    /**
     * Create a new job instance.
     */
    public function __construct($studentId, $body, $subject, $filename = null, $eventId = null)
    {
        // Handle both student model and student ID for backward compatibility
        $this->studentId = is_object($studentId) ? $studentId->id() : $studentId;
        $this->body = $body;
        $this->subject = $subject;
        $this->filename = $filename;
        $this->eventId = $eventId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Fetch the student model from the database
        $student = Student::where("uuid",$this->studentId)->first();
        
        if (!$student) {
            Log::warning("NotifyParentsJob: Student not found with ID: {$this->studentId}");
            return;
        }

        // Reconstruct the full file path from filename
        $filePath = null;
        if ($this->filename) {
            $filePath = storage_path('app/public/results/' . $this->filename);
        }

        // Father
        if (get_settings('father_notification') === 1 && isset($student->father) && !empty($student->father->email)) {
            $email = strtolower(trim($student->father->email));
            if ($this->shouldSend('email', $email)) {
                try {
                    Mail::to($student->father->email)
                        ->send(new SendMidtermMail($this->body, $this->subject, $filePath));
                } catch (\Exception $e) {
                    Log::error("Failed to send email to father: " . $e->getMessage(), [
                        'student_id' => $this->studentId,
                        'email' => $student->father->email,
                        'exception' => $e
                    ]);
                }
            }
        }

        // Mother
        if (get_settings('mother_notification') === 1 && isset($student->mother) && !empty($student->mother->email)) {
            $email = strtolower(trim($student->mother->email));
            if ($this->shouldSend('email', $email)) {
                try {
                    Mail::to($student->mother->email)
                        ->send(new SendMidtermMail($this->body, $this->subject, $filePath));
                } catch (\Exception $e) {
                    Log::error("Failed to send email to mother: " . $e->getMessage(), [
                        'student_id' => $this->studentId,
                        'email' => $student->mother->email,
                        'exception' => $e
                    ]);
                }
            }
        }

        // Guardian
        if (get_settings('guardian_notification') === 1 && isset($student->guardian) && !empty($student->guardian->email)) {
            $email = strtolower(trim($student->guardian->email));
            if ($this->shouldSend('email', $email)) {
                try {
                    Mail::to($student->guardian->email)
                        ->send(new SendMidtermMail($this->body, $this->subject, $filePath));
                } catch (\Exception $e) {
                    Log::error("Failed to send email to guardian: " . $e->getMessage(), [
                        'student_id' => $this->studentId,
                        'email' => $student->guardian->email,
                        'exception' => $e
                    ]);
                }
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
