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
    protected $eventId;

    /**
     * Create a new job instance.
     */
    public function __construct($student = null, string $message, string $type = 'parent', $eventId = null)
    {
        $this->student = $student;
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

            if ($this->type === 'parent' && $this->student) {
                if (get_settings('whatsapp_result_notification') === 1) {

                            if (get_settings('whatsapp_father_notification') === 1 && isset($this->student->father) && !empty($this->student->father->phone)) {
                                $phone = preg_replace('/\D+/', '', $this->student->father->phone);
                                if ($this->shouldSend('phone', $phone)) {
                                    sendWaMessage($this->student->father->phone, $this->message);
                                }
                            }

                    if (get_settings('whatsapp_mother_notification') === 1 && isset($this->student->mother) && !empty($this->student->mother->phone)) {
                        $phone = preg_replace('/\D+/', '', $this->student->mother->phone);
                        if ($this->shouldSend('phone', $phone)) {
                            sendWaMessage($this->student->mother->phone, $this->message);
                        }
                    }

                    if (get_settings('whatsapp_guardian_notification') === 1 && isset($this->student->guardian) && !empty($this->student->guardian->phone)) {
                        $phone = preg_replace('/\D+/', '', $this->student->guardian->phone);
                        if ($this->shouldSend('phone', $phone)) {
                            sendWaMessage($this->student->guardian->phone, $this->message);
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
