<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use App\Models\Question;
use App\Models\Week;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class AssessmentController extends Controller
{
    public function weeks(Request $request)
    {
        $user = auth()->user();
        $gradeId = optional($user)->student->grade_id ?? null;
        $termId = term('id');

        $date = $request->query('date') ? Carbon::parse($request->query('date')) : Carbon::today();
        $dateStr = $date->toDateString();


        $cacheKey = "assessment:weeks:grade:{$gradeId}:term:{$termId}:date:{$dateStr}";

        $weeks = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($gradeId, $termId) {
            return Week::select('id', 'start_date', 'end_date')
                ->where('term_id', $termId)
                ->orderBy('start_date')
                ->with(['topics' => function ($q) use ($gradeId, $termId) {
                    $q->select('id', 'title', 'curriculum_id', 'week_id')
                        ->whereHas('curriculum', function ($cq) use ($gradeId, $termId) {
                            $cq->where('grade_id', $gradeId)
                                ->where('term_id', $termId);
                        })
                        ->with(['curriculum' => function ($cq) {
                            $cq->select('id', 'name', 'grade_id', 'term_id');
                        }]);
                }])->get();
        });

        $activeWeek = null;
        try {
            $dateStart = $date->copy()->startOfDay();
            $dateEnd = $date->copy()->endOfDay();

            $activeWeek = $weeks->first(function ($w) use ($dateStart, $dateEnd) {
                $start = Carbon::parse($w->start_date)->startOfDay();
                $end = Carbon::parse($w->end_date)->endOfDay();
                return $start <= $dateEnd && $end >= $dateStart;
            });

            if (empty($activeWeek)) {
                $activeWeek = $weeks->first(function ($w) use ($dateStart) {
                    return Carbon::parse($w->start_date)->startOfDay() >= $dateStart;
                });
            }
        } catch (\Exception $e) {
            $activeWeek = null;
        }

        $payload = [];
        foreach ($weeks as $week) {
            $weekTopics = [];
            $topics = $week->topics ?? [];
            foreach ($topics as $t) {
                $topicArray = [
                    'id' => $t->id,
                    'title' => $t->title,
                    'curriculum_id' => $t->curriculum_id,
                    'week_id' => $t->week_id,
                ];

                if (!empty($t->curriculum)) {
                    $topicArray['curriculum'] = [
                        'id' => $t->curriculum->id,
                        'name' => $t->curriculum->name ?? null,
                    ];
                }

                $weekTopics[] = $topicArray;
            }

            $isActive = $week->id === ($activeWeek->id ?? null);

            $payload[] = [
                'id' => $week->id,
                'start_date' => $week->start_date,
                'end_date' => $week->end_date,
                'topics' => array_values($weekTopics),
                'active' => (bool) $isActive,
            ];
        }

        return response()->json(['status' => true, 'data' => $payload]);
    }

    public function gradeQuestions($grade_id)
    {
        $termId = term('id');
        $cacheKey = "assessment:questions:grade:{$grade_id}:term:{$termId}";

        $questions = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($grade_id, $termId) {
            $curriculumIds = Curriculum::where('grade_id', $grade_id)
                ->where('term_id', $termId)
                ->pluck('id')
                ->all();

            if (empty($curriculumIds)) {
                return [];
            }

            return Question::whereIn('curriculum_id', $curriculumIds)
                ->orderBy('id', 'desc')
                ->get(['id', 'question', 'options', 'curriculum_id', 'curriculum_topic_id'])
                ->map(function ($q) {
                    return [
                        'id' => $q->id,
                        'question' => $q->question,
                        'options' => $q->options,
                    ];
                })->values();
        });

        return response()->json(['status' => true, 'data' => $questions]);
    }
}
