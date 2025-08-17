<?php

namespace App\Services;

use App\Models\MidTerm;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;

class MidtermService
{
    /**
     * Create or update ONE student's midterm score for a subject.
     *
     * @param int $periodId
     * @param int $termId
     * @param int $gradeId
     * @param int $subjectId
     * @param string $studentId
     * @param array $scores  // e.g. ['ca1' => 8, 'ca2' => 10]
     * @param Authenticatable|null $author
     * @return \App\Models\MidTerm
     */
    public function createOrUpdateMidtermScore(
        int $periodId,
        int $termId,
        int $gradeId,
        int $subjectId,
        string $studentId,
        array $scores,
        ?Authenticatable $author = null
    ): MidTerm {
        $format = get_settings('midterm_format') ?? [];

        $payloadScores = [];
        foreach ($format as $key => $config) {
            if (array_key_exists($key, $scores)) {
                $num  = (int) $scores[$key];
                $max  = isset($config['mark']) ? (int) $config['mark'] : (int) $config;
                $payloadScores[$key] = max(0, min($num, $max));
            }
        }


        // Base identifiers
        $unique = [
            'period_id'  => $periodId,
            'term_id'    => $termId,
            'grade_id'   => $gradeId,
            'subject_id' => $subjectId,
            'student_id' => $studentId,
        ];

        // Upsert (update if exists, else create)
        return DB::transaction(function () use ($unique, $payloadScores, $author) {
            /** @var MidTerm $model */
            $model = MidTerm::firstOrNew($unique);
            $model->fill($payloadScores);

            if (!$model->exists && $author && method_exists($model, 'authoredBy')) {
                $model->authoredBy($author);
            }

            $model->save();
            return $model;
        });
    }

    /**
     * Optional: batch helper using the single-function above.
     * $rows is an array like:
     * [
     *   ['student_id' => 12, 'scores' => ['ca1' => 8, 'ca2' => 10]],
     *   ...
     * ]
     */
    public function createOrUpdateMidtermScoresBatch(
        int $periodId,
        int $termId,
        int $gradeId,
        int $subjectId,
        array $rows,
        ?Authenticatable $author = null
    ): int {
        return DB::transaction(function () use ($periodId, $termId, $gradeId, $subjectId, $rows, $author) {
            $count = 0;
            foreach ($rows as $row) {
                $studentId = $row['student_id'] ?? null;
                $scores    = (array) ($row['scores'] ?? []);
                if ($studentId) {
                    $this->createOrUpdateMidtermScore($periodId, $termId, $gradeId, $subjectId, $studentId, $scores, $author);
                    $count++;
                }
            }
            return $count;
        });
    }
}
