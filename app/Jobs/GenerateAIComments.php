<?php

namespace App\Jobs;

use App\Models\AIResultComment;
use App\Services\OpenAICommentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateAIComments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $studentUuid;
    public int $periodId;
    public int $termId;
    public string $resultType; // e.g., 'midterm' or 'exam'
    public ?int $authorId;
    public array $options;

    /**
     * Create a new job instance.
     *
     * @param string $studentUuid
     * @param int $periodId
     * @param int $termId
     * @param string $resultType
     * @param int|null $authorId
     * @param array $options
     */
    public function __construct(string $studentUuid, int $periodId, int $termId, string $resultType, ?int $authorId = null, array $options = [])
    {
        $this->studentUuid = $studentUuid;
        $this->periodId = $periodId;
        $this->termId = $termId;
        $this->resultType = $resultType;
        $this->authorId = $authorId;
        $this->options = $options;
    }

    /**
     * Execute the job.
     *
     * This job will load any existing AIResultComment record in status 'pending' for the
     * given student/period/term/result_type, mark it as processing, call the OpenAI service
     * to generate the comment, and then persist the generated comment.
     *
     * If no pending record exists we create one (best-effort) so callers that want to show
     * a placeholder can use the record.
     */
    public function handle(OpenAICommentService $service)
    {
        try {
            $record = AIResultComment::firstOrCreate([
                'student_uuid' => $this->studentUuid,
                'period_id' => $this->periodId,
                'term_id' => $this->termId,
                'result_type' => $this->resultType,
            ], [
                'author_id' => $this->authorId,
                'status' => 'pending',
            ]);

            // If already generated, skip
            if ($record->status === 'ready' && !empty($record->comment)) {
                return;
            }

            $record->update(['status' => 'processing', 'author_id' => $this->authorId]);

            // Load result data required by the generator. We expect callers to have stored
            // a snapshot or the system has a way to assemble student + subjects data.
            // For a minimal implementation we'll attempt to read a JSON payload from notes
            // if present (notes can contain a small payload), otherwise callers should
            // ensure notes contains necessary data before dispatching.

            $payload = [];
            if (!empty($record->notes)) {
                try {
                    $payload = is_string($record->notes) ? json_decode($record->notes, true) : (array) $record->notes;
                } catch (\Throwable $e) {
                    Log::warning('GenerateAIComments: failed to parse notes payload: '.$e->getMessage());
                    $payload = [];
                }
            }

            // Expect payload keys: student, subjects
            $student = $payload['student'] ?? null;
            $subjects = $payload['subjects'] ?? [];

            if (empty($student) || empty($subjects)) {
                // Not enough data to generate; mark failed and attach a note
                $record->update(['status' => 'failed', 'notes' => json_encode(['reason' => 'missing_payload'])]);
                return;
            }

            $generated = $service->generateComment($student, $subjects, $this->options);

            // The service now returns an array of comment variants. For backward
            // compatibility we store the first variant in `comment` and save all
            // variants into `notes.variants` as JSON.
            if (is_array($generated)) {
                $primary = $generated[0] ?? null;
                $notes = (array) ($record->notes ? json_decode($record->notes, true) : []);
                $notes['variants'] = $generated;

                $record->update([
                    'comment' => $primary,
                    'generated_at' => now(),
                    'status' => 'ready',
                    'notes' => json_encode($notes),
                ]);
            } else {
                $record->update([
                    'comment' => $generated,
                    'generated_at' => now(),
                    'status' => 'ready',
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('GenerateAIComments failed: '.$e->getMessage());
            if (!empty($record)) {
                $record->update(['status' => 'failed', 'notes' => json_encode(['error' => $e->getMessage()])]);
            }
        }
    }
}
