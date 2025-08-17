<?php

namespace App\Services;

use App\Models\PrimaryResult; // your exam model
use App\Models\MidTerm;       // your midterm model (ensure correct class name)
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;

class ExamService
{
    /**
     * Create or update ONE student's exam result for a subject.
     * Merges midterm components (from MidTerm) with provided exam components.
     *
     * @param int $periodId
     * @param int $termId
     * @param int $gradeId
     * @param int $subjectId
     * @param int $studentId
     * @param array $examScores  // e.g. ['exam' => 70, 'practical' => 10] (keys must exist in exam_format)
     * @param Authenticatable|null $author
     * @param bool $requireMidterm  If true, throws when MidTerm is missing
     * @return \App\Models\PrimaryResult
     */
    public function createOrUpdateExamResult(
        int $periodId,
        int $termId,
        int $gradeId,
        int $subjectId,
        $studentId,
        array $examScores,
        ?Authenticatable $author = null,
        bool $requireMidterm = true
    ): PrimaryResult {
        $midtermFormat = get_settings('midterm_format') ?? []; 
        $examFormat    = get_settings('exam_format') ?? []; 

        $unique = [
            'period_id'  => $periodId,
            'term_id'    => $termId,
            'grade_id'   => $gradeId,
            'subject_id' => $subjectId,
            'student_id' => $studentId,
        ];

        // Fetch midterm row (if exists)
        $midterm = MidTerm::where($unique)->first();
        if ($requireMidterm && !$midterm) {
            throw new \RuntimeException("Please upload midterm score for student ID {$studentId}");
        }

        // Build payload: copy allowed midterm keys, then apply allowed exam keys (clamped)
        $payload = [];

        foreach ($midtermFormat as $key => $max) {
            if ($midterm && $midterm->{$key} !== null) {
                $payload[$key] = (int) $midterm->{$key};
            }
        }

        foreach ($examFormat as $key => $config) {
            if (array_key_exists($key, $examScores)) {
                $num = (int) $examScores[$key];

                $max = is_array($config) 
                    ? (int) ($config['mark'] ?? 0) 
                    : (int) $config;

                $payload[$key] = max(0, min($num, $max));
            }
        }


        return DB::transaction(function () use ($unique, $payload, $author) {
            /** @var PrimaryResult $model */
            $model = PrimaryResult::firstOrNew($unique);
            $model->fill($payload);

            if (!$model->exists && $author && method_exists($model, 'authoredBy')) {
                $model->authoredBy($author);
            }

            $model->save();
            return $model;
        });
    }

    /**
     * Optional batch helper for many students at once.
     * $rows = [
     *   ['student_id' => 1, 'scores' => ['exam' => 70]],
     *   ['student_id' => 2, 'scores' => ['exam' => 55]],
     * ];
     */
    public function createOrUpdateExamResultsBatch(
        int $periodId,
        int $termId,
        int $gradeId,
        int $subjectId,
        array $rows,
        ?Authenticatable $author = null,
        bool $requireMidterm = true
    ): int {
        return DB::transaction(function () use ($periodId, $termId, $gradeId, $subjectId, $rows, $author, $requireMidterm) {
            $count = 0;
            foreach ($rows as $row) {
                $studentId = $row['student_id'];
                $scores    = (array) ($row['scores'] ?? []);
                if ($studentId) {
                    $this->createOrUpdateExamResult(
                        $periodId, $termId, $gradeId, $subjectId,
                        $studentId, $scores, $author, $requireMidterm
                    );
                    $count++;
                }
            }
            return $count;
        });
    }
}
