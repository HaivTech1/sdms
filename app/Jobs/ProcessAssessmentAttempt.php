<?php

namespace App\Jobs;

use App\Models\AssessmentAttempt;
use App\Models\AttemptAnswer;
use App\Models\Question;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessAssessmentAttempt implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $attemptId;

    public function __construct(int $attemptId)
    {
        $this->attemptId = $attemptId;
    }

    public function handle()
    {
        $attempt = AssessmentAttempt::find($this->attemptId);
        if (!$attempt) return;

        $answers = AttemptAnswer::where('attempt_id', $attempt->id)->get();
        $questionIds = $answers->pluck('question_id')->unique()->values()->all();

        $questions = Question::whereIn('id', $questionIds)->get()->keyBy('id');

        foreach ($answers as $ans) {
            $question = $questions->get($ans->question_id);
            $isCorrect = null;
            if ($question) {
                $correctIndex = $question->correct_index ?? null;
                $isCorrect = $correctIndex !== null && intval($correctIndex) === intval($ans->answer_index);
            }

            $ans->is_correct = $isCorrect;
            $ans->save();
        }

        // Optionally compute aggregate stats on the attempt
        $total = $answers->count();
        $correctCount = AttemptAnswer::where('attempt_id', $attempt->id)->where('is_correct', true)->count();
        $attempt->meta = array_merge(is_array($attempt->meta ?? []) ? $attempt->meta : (array) $attempt->meta, [
            'scored_at' => now()->toDateTimeString(),
            'total_questions' => $total,
            'correct' => $correctCount,
        ]);
        $attempt->save();
    }
}
