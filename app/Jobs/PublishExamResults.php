<?php

namespace App\Jobs;

use App\Http\Controllers\ResultController;
use App\Jobs\NotifyParentsJob;
use App\Jobs\SendWhatsappJob;
use App\Models\Student;
use App\Models\PrimaryResult;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Term;
use App\Models\Cognitive;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class PublishExamResults implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $studentId;
    public $periodId;
    public $termId;
    public $gradeId;

    public function __construct(string $studentId, int $periodId, int $termId, int $gradeId)
    {
        $this->studentId = $studentId;
        $this->periodId = $periodId;
        $this->termId = $termId;
        $this->gradeId = $gradeId;
    }

    public function handle()
    {
        $lockKey = "publish_student_{$this->studentId}_{$this->periodId}_{$this->termId}";
        $lock = Cache::lock($lockKey, 300);

        if (! $lock->get()) {
            // Another worker is processing this student/term/period - skip
            return;
        }

        try {
            $student = Student::findOrFail($this->studentId);
            $grade = Grade::find($this->gradeId);

            $pending = PrimaryResult::where('student_id', $this->studentId)
                ->where('term_id', $this->termId)
                ->where('period_id', $this->periodId)
                ->where('grade_id', $this->gradeId)
                ->where('published', false)
                ->get();

            if ($pending->isEmpty()) {
                return;
            }

            // Eager load only relevant results
            $student->load(['primaryResults' => function ($q) {
                $q->where('period_id', $this->periodId)->where('term_id', $this->termId);
            }]);

            $results = $student->primaryResults;
            $resultTemplate = (int) get_settings('result_template');

            // Per-subject positions
            foreach ($results as $result) {
                try {
                    $posClass = studentSubjectPositionInGrade($student->id(), $this->periodId, $this->termId, $grade->id(), $result->subject_id);
                    $posGrade = null;
                    if ($resultTemplate !== 1) {
                        $posGrade = generateStudentGradeSubjectPosition($student->id(), $this->periodId, $this->termId, $result->subject_id, $grade->title());
                    }

                    $result->update([
                        'position_in_class_subject' => $posClass,
                        'position_in_grade_subject' => $posGrade,
                    ]);
                } catch (\Throwable $ex) {
                    Log::warning('Per-subject position update failed for student ' . $this->studentId . ': ' . $ex->getMessage());
                }
            }

            // Overall positions (Cognitive)
            try {
                $cognitive = Cognitive::where('student_uuid', $student->id())->where('period_id', $this->periodId)->where('term_id', $this->termId)->first();
                $cogUpdate = [
                    'position_in_class' => calculateStudentPosition($student->id(), $this->periodId, $this->termId, $grade->id()),
                    'position_in_grade' => ($resultTemplate !== 1) ? calculateStudentGradePosition($student->id(), $this->periodId, $this->termId, $grade->title()) : null,
                ];

                if ($cognitive) {
                    $cognitive->update($cogUpdate);
                } else {
                    Cognitive::create(array_merge([
                        'student_uuid' => $student->id(),
                        'period_id' => $this->periodId,
                        'term_id' => $this->termId,
                    ], $cogUpdate));
                }
            } catch (\Throwable $ex) {
                Log::warning('Cognitive update failed for student ' . $this->studentId . ': ' . $ex->getMessage());
            }

            // Generate PDF (controller handles AI comments persistence before generating)
            $controller = app(ResultController::class);
            $path = $controller->generateExamResultLink($student, $this->periodId, $this->termId, $grade);

            $publicUrl = null;
            if ($path && file_exists($path)) {
                $publicUrl = asset('storage/results/' . basename($path));
            }

            $period = Period::find($this->periodId);
            $term = Term::find($this->termId);
            $name = trim($student->fullname());

            $message = "<p>Dear Parent/Guardian,</p><p>The examination result for <strong>{$name}</strong> is now available.</p>";
            $subject = 'Examination Report Sheet';
            $watMessage = "*" . ($term->title ?? '') . " " . ($period->title ?? '') . " {$subject}*\n{$name}'s result is now available. Please click the link below to view the result\n {$publicUrl}";

            $emailJob = new NotifyParentsJob($student, $message, $subject, storage_path('app/public/' . ($path ? basename($path) : '')));
            $whatsappJob = new SendWhatsappJob($student, $watMessage, 'parent');

            // Dispatch notifications in a chain; only mark as published after successful dispatch
            try {
                Bus::chain([$emailJob, $whatsappJob])->dispatch();

                // Mark published atomically
                DB::transaction(function () use ($pending) {
                    $ids = $pending->pluck('uuid')->toArray();
                    PrimaryResult::whereIn('uuid', $ids)->update(['published' => true]);
                });
            } catch (\Throwable $notifyEx) {
                Log::error('Notification dispatch/mark published failed for student ' . $this->studentId . ': ' . $notifyEx->getMessage());
                // leave unpublished so it can be retried
                return;
            }

        } catch (\Throwable $e) {
            Log::error('PublishExamResults job failed for student ' . $this->studentId . ': ' . $e->getMessage());
        } finally {
            try {
                $lock->release();
            } catch (\Throwable $releaseEx) {
                Log::warning('Failed to release publish lock for student ' . $this->studentId . ': ' . $releaseEx->getMessage());
            }
        }
    }
}
