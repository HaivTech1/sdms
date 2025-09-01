<?php

namespace App\Jobs;

use App\Models\Event;
use App\Models\Student;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Jobs\NotifyParentsJob;
use App\Jobs\SendWhatsappJob;

class SendEventNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    protected $eventId;

    /**
     * Create a new job instance.
     */
    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $event = Event::find($this->eventId);

        if (! $event) {
            Log::warning("SendEventNotificationJob: event not found: {$this->eventId}");
            return;
        }

        // Build subject and body for the notification
        $subject = "Event: " . ($event->title ?? 'School Event');
        $body = $event->description ?? '';

        // Determine students to notify. For now notify all active students.
        // If events have target scopes in future, adapt this query.
        $query = Student::query();

        // Chunk through students to avoid memory spikes and dispatch per-student jobs
        $query->chunk(100, function ($students) use ($subject, $body) {
            foreach ($students as $student) {
                try {
                    // Dispatch email notifications to parents for this student
                    dispatch(new NotifyParentsJob($student, $body, $subject, null, $this->eventId));

                    // Dispatch WhatsApp notification job for this student
                    $watMessage = $subject . "\n" . strip_tags($body);
                    dispatch(new SendWhatsappJob($student, $watMessage, 'parent', $this->eventId));
                } catch (\Exception $e) {
                    Log::error('SendEventNotificationJob error: ' . $e->getMessage());
                }
            }
        });
    }
}
