<?php

namespace App\Jobs;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWhatsappJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $studentId;
    protected $message;
    protected $mediaFilePath;
    protected $type;
    protected $eventId;

    /**
     * Create a new job instance.
     */
    public function __construct($studentId = null, string $message, string $type = 'parent', $eventId = null)
    {
        // Handle both student model and student ID for backward compatibility
        $this->studentId = is_object($studentId) ? $studentId->id() : $studentId;
        $this->message = $message;
        $this->type = $type;
        $this->eventId = $eventId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            if ($this->type === 'staff') {
                sendWaMessage($this->message, 'staff');
                return;
            }

            if ($this->type === 'parent' && $this->studentId) {
                // Fetch the student model from the database
                $student = Student::where("uuid",$this->studentId)->first();
                
                if (!$student) {
                    Log::warning("SendWhatsappJob: Student not found with ID: {$this->studentId}");
                    return;
                }

                if (get_settings('whatsapp_result_notification') === 1) {

                            if (get_settings('whatsapp_father_notification') === 1 && isset($student->father) && !empty($student->father->phone)) {
                                $phone = preg_replace('/\D+/', '', $student->father->phone);
                                if ($this->shouldSend('phone', $phone)) {
                                    sendWaMessage($student->father->phone, $this->message);
                                }
                            }

                    if (get_settings('whatsapp_mother_notification') === 1 && isset($student->mother) && !empty($student->mother->phone)) {
                        $phone = preg_replace('/\D+/', '', $student->mother->phone);
                        if ($this->shouldSend('phone', $phone)) {
                            sendWaMessage($student->mother->phone, $this->message);
                        }
                    }

                    if (get_settings('whatsapp_guardian_notification') === 1 && isset($student->guardian) && !empty($student->guardian->phone)) {
                        $phone = preg_replace('/\D+/', '', $student->guardian->phone);
                        if ($this->shouldSend('phone', $phone)) {
                            sendWaMessage($student->guardian->phone, $this->message);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            info("WhatsApp send failed: " . $e->getMessage());
        }
    }

    protected function shouldSend(string $channel, string $contact): bool
    {
        if (! $this->eventId) {
            return true;
        }

        $key = sprintf('event_notify:%s:%s:%s', $this->eventId, $channel, md5($contact));
        return \Illuminate\Support\Facades\Cache::add($key, true, 86400);
    }
}
