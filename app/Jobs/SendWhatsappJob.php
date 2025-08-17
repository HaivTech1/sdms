<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWhatsappJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $student;
    protected $message;
    protected $mediaFilePath;
    protected $type;

    /**
     * Create a new job instance.
     */
    public function __construct($student = null, string $message, string $type = 'parent')
    {
        $this->student = $student;
        $this->message = $message;
        $this->type = $type;
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

            if ($this->type === 'parent' && $this->student) {
                if (get_settings('whatsapp_result_notification') === 1) {

                    if (get_settings('whatsapp_father_notification') === 1 && isset($this->student->father) && !empty($this->student->father->phone)) {
                        sendWaMessage($this->student->father->phone, $this->message);
                    }

                    if (get_settings('whatsapp_mother_notification') === 1 && isset($this->student->mother) && !empty($this->student->mother->phone)) {
                        sendWaMessage($this->student->mother->phone, $this->message);
                    }

                    if (get_settings('whatsapp_guardian_notification') === 1 && isset($this->student->guardian) && !empty($this->student->guardian->phone)) {
                        sendWaMessage($this->student->guardian->phone, $this->message);
                    }
                }
            }
        } catch (\Exception $e) {
            info("WhatsApp send failed: " . $e->getMessage());
        }
    }
}
