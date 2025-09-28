<?php
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\AssessmentAttempt;

class AssessmentSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    protected AssessmentAttempt $attempt;

    public function __construct(AssessmentAttempt $attempt)
    {
        $this->attempt = $attempt;
    }

    public function via($notifiable)
    {
        // database for persistence, broadcast for real-time push (e.g., pusher/laravel-echo)
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'assessment_submitted',
            'attempt_id' => $this->attempt->attempt_id,
            'attempt_db_id' => $this->attempt->id,
            'week_id' => $this->attempt->week_id,
            'user_id' => $this->attempt->user_id,
            'submitted_at' => optional($this->attempt->submitted_at)->toISOString(),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}