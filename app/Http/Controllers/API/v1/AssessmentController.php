<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use App\Models\CurriculumTopic;
use App\Models\Question;
use App\Models\Week;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\AssessmentAttempt;
use App\Models\AttemptAnswer;
use App\Jobs\ProcessAssessmentAttempt;
use App\Models\Subject;

class AssessmentController extends Controller
{
    public function weeks(Request $request)
    {
        $user = auth()->user();
        $gradeId = optional($user)->student->grade_id ?? null;
        $termId = term('id');
        $periodId = period('id');

        $date = $request->query('date') ? Carbon::parse($request->query('date')) : Carbon::today();

        $weeks = Week::select('id', 'start_date', 'end_date')
            ->where('term_id', $termId)
            ->where('period_id', $periodId)
            ->orderBy('start_date')
            ->with(['topics' => function ($q) use ($gradeId, $termId) {
                $q->select('id', 'title', 'curriculum_id', 'week_id', 'test_duration')
                    ->whereHas('curriculum', function ($cq) use ($gradeId, $termId) {
                        $cq->where('grade_id', $gradeId)
                            ->where('term_id', $termId);
                    })
                    ->with(['curriculum' => function ($cq) {
                        $cq->select('id', 'name', 'grade_id', 'subject_id', 'term_id');
                    }]);
            }, 'hairstyle' => function($q){
                $q->select('id', 'title', 'description', 'front_view', 'back_view', 'side_view');
            }])->get();

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
        foreach ($weeks as $index => $week) {
            $weekTopics = [];
            $topics = $week->topics ?? [];
            foreach ($topics as $t) {
                $topicArray = [
                    'id' => $t->id,
                    'title' => $t->title,
                    'curriculum_id' => $t->curriculum_id,
                    'subject' => $t->curriculum->subject->title ?? null,
                    'week_id' => $t->week_id,
                    'duration' => $t->test_duration,
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
                'id' => $index,
                'week_id' => $week->id,
                'start_date' => $week->start_date,
                'end_date' => $week->end_date,
                'topics' => array_values($weekTopics),
                'active' => (bool) $isActive,
            ];
        }

        return response()->json(['status' => true, 'data' => $payload]);
    }

    public function gradeQuestions($week_id)
    {
        // eager load topics with their curriculum (to get subject) and questions
        $week = Week::with(['topics.curriculum', 'topics.questions'])->find($week_id);

        if (!$week) {
            return response()->json(['status' => false, 'message' => 'Week not found'], 404);
        }

        $groups = [];

        foreach ($week->topics as $topic) {
            $curriculum = $topic->curriculum;
            $subjectId = $curriculum->subject_id ?? null;
            $subjectName = null;
            if (!empty($curriculum) && isset($curriculum->subject_id)) {
                // try to get subject name if relation loaded on curriculum
                $subjectName = $curriculum->subject->title ?? null;
            }

            foreach ($topic->questions as $q) {
                $item = [
                    'id' => $q->id,
                    'question' => $q->question,
                    'options' => $q->options,
                    'curriculum_id' => $q->curriculum_id,
                    'curriculum_topic_id' => $q->curriculum_topic_id,
                    'topic_id' => $topic->id,
                    'topic_title' => $topic->title,
                    'topic_duration' => $topic->test_duration,
                ];

                $key = $subjectId ?? 'ungrouped';
                if (!isset($groups[$key])) {
                    $groups[$key] = [
                        'subject_id' => $subjectId,
                        'subject_name' => $subjectName,
                        'questions' => [],
                    ];
                }

                $groups[$key]['questions'][] = $item;
            }
        }

        // reindex groups as numeric array
        $grouped = array_values($groups);
        // info($grouped);

        return response()->json(['status' => true, 'data' => $grouped]);
    }

    /**
     * Submit answers payload from client and persist attempt + answers
     * Expected payload: week_id, subjects:[{subject_id, answers:[{question_id, answer_index}]}], meta
     */
    public function submit(Request $request)
    {
        $payload = $request->validate([
            'week_id' => 'required|integer',
            'subjects' => 'required|array',
            'meta' => 'sometimes|array',
        ]);

        $user = auth()->user();

        // idempotency: if attempt_id provided and exists, return existing record
        $attemptIdStr = $request->input('meta.attempt_id') ?? null;
        if ($attemptIdStr) {
            $existing = AssessmentAttempt::where('attempt_id', $attemptIdStr)->first();
            if ($existing) {
                return response()->json(['status' => true, 'data' => ['attempt_id' => $existing->attempt_id, 'id' => $existing->id, 'message' => 'Attempt already submitted']]);
            }
        }

        // determine subject context when only one subject is submitted
        $subjectContext = null;
        if (isset($payload['subjects']) && is_array($payload['subjects']) && count($payload['subjects']) === 1) {
            $subjectContext = $payload['subjects'][0]['subject_id'] ?? null;
        }

        // create attempt record (student_id maps to authenticated user's student id when available)
        $attempt = AssessmentAttempt::create([
            'attempt_id' => $attemptIdStr ?? 'a_'.uniqid(),
            'user_id' => $user->id,
            'subject_id' => $subjectContext,
            'week_id' => $payload['week_id'],
            'client' => $request->input('meta.client') ?? null,
            'submitted_at' => $request->input('meta.submitted_at') ? Carbon::parse($request->input('meta.submitted_at')) : Carbon::now(),
            'meta' => $request->input('meta') ?? null,
        ]);

        // collect all question ids to pre-load them
        $questionIds = [];
        foreach ($payload['subjects'] as $sub) {
            if (!empty($sub['answers']) && is_array($sub['answers'])) {
                foreach ($sub['answers'] as $a) {
                    $questionIds[] = intval($a['question_id']);
                }
            }
        }

        $questionIds = array_values(array_unique($questionIds));
        $questions = Question::whereIn('id', $questionIds)->get()->keyBy('id');

        // validate that these questions belong to the provided week via their curriculum_topic.week_id
        $topicIds = $questions->pluck('curriculum_topic_id')->filter()->unique()->values()->all();
        if (!empty($topicIds)) {
            $topics = CurriculumTopic::whereIn('id', $topicIds)->where('week_id', $payload['week_id'])->pluck('id')->all();
            $invalid = array_diff($topicIds, $topics);
            if (!empty($invalid)) {
                return response()->json(['status' => false, 'message' => 'One or more questions do not belong to the specified week'], 422);
            }
        }

        $summary = [];

        foreach ($payload['subjects'] as $sub) {
            $subjectId = isset($sub['subject_id']) ? $sub['subject_id'] : null;
            $answers = $sub['answers'] ?? [];
            $total = count($answers);
            $correct = 0;

            foreach ($answers as $ans) {
                $qId = intval($ans['question_id']);
                $answerIndex = isset($ans['answer_index']) ? intval($ans['answer_index']) : null;

                $question = $questions->get($qId);
                $isCorrect = false;
                $snapshot = null;

                if ($question) {
                    $correctIndex = $question->correct_index ?? null;
                    $isCorrect = $correctIndex !== null && intval($correctIndex) === $answerIndex;

                    // capture a snapshot of the question (minimal)
                    $snapshot = [
                        'id' => $question->id,
                        'question' => $question->question,
                        'options' => $question->options,
                        'correct_index' => $question->correct_index,
                        'curriculum_id' => $question->curriculum_id,
                        'curriculum_topic_id' => $question->curriculum_topic_id,
                    ];
                }

                // persist answers immediately. store an optimistic correctness (0/1)
                // so inserts don't fail if the DB column is non-nullable in the current environment.
                AttemptAnswer::create([
                    'attempt_id' => $attempt->id,
                    'question_id' => $qId,
                    'answer_index' => $answerIndex,
                    'is_correct' => $isCorrect ? 1 : 0,
                    'question_snapshot' => $snapshot,
                ]);
            }

            $percent = $total > 0 ? round(($correct / $total) * 100, 2) : 0;

            $summary[] = [
                'subject_id' => $subjectId,
                'total' => $total,
                'correct' => $correct,
                'percent' => $percent,
            ];
        }

        // dispatch async job to compute correctness and update attempt
        ProcessAssessmentAttempt::dispatch($attempt->id);

        return response()->json([
            'status' => true,
            'data' => [
                'attempt_id' => $attempt->attempt_id,
                'id' => $attempt->id,
                'submitted_at' => $attempt->submitted_at,
                'summary' => $summary, // this is pre-computed optimistic summary (based on immediate compare) but final authoritative scoring will be processed async
            ]
        ]);
    }

    /**
     * Return assessment result in the requested shape.
     * Accepts numeric id or attempt_id string.
     */
    public function result($key)
    {
        // load attempt and answers
        $attemptQuery = AssessmentAttempt::with(['answers']);

        if (is_numeric($key)) {
            $attempt = $attemptQuery->find(intval($key));
        } else {
            $attempt = $attemptQuery->where('attempt_id', $key)->first();
        }

        if (!$attempt) {
            return response()->json(['status' => false, 'message' => 'Attempt not found'], 404);
        }

        // determine status: 'ready' if scored (meta.scored_at exists), else 'processing'
        $meta = is_array($attempt->meta) ? $attempt->meta : (is_string($attempt->meta) ? json_decode($attempt->meta, true) : (array) $attempt->meta);
        $status = isset($meta['scored_at']) ? 'ready' : 'processing';

        // compute per-question and per-subject aggregates
        $subjects = []; // keyed by subject_id
        $questionsOut = [];
        $totalQuestions = 0;
        $totalCorrect = 0;

        // preload subject names via curriculum lookup if available
        $subjectNames = [];

        foreach ($attempt->answers as $ans) {
            $snapshot = is_array($ans->question_snapshot) ? $ans->question_snapshot : (is_string($ans->question_snapshot) ? json_decode($ans->question_snapshot, true) : (array) $ans->question_snapshot);

            $qId = $ans->question_id;
            $selected = $ans->answer_index !== null ? intval($ans->answer_index) : null;
            $correctIndex = isset($snapshot['correct_index']) ? intval($snapshot['correct_index']) : null;
            $isCorrect = $ans->is_correct === 1 || $ans->is_correct === true || ($ans->is_correct === '1');

            // Only include questions the user got wrong
            if (!$isCorrect) {
                $correctAnswer = null;
                if (isset($snapshot['options']) && is_array($snapshot['options']) && $correctIndex !== null) {
                    $correctAnswer = $snapshot['options'][$correctIndex] ?? null;
                }

                $questionsOut[] = [
                    'id' => $qId,
                    'q' => $snapshot['question'] ?? null,
                    'correct' => false,
                    'selected_index' => $selected,
                    'correct_index' => $correctIndex,
                    'correct_answer' => $correctAnswer,
                ];
            }

            $totalQuestions++;
            if ($isCorrect) {
                $totalCorrect++;
            }

            $subjectId = $snapshot['curriculum_id'] ?? $snapshot['curriculum_topic_id'] ?? null;
            // try to use curriculum->subject mapping if snapshot has curriculum_id
            if (!empty($snapshot['curriculum_id'])) {
                try {
                    $curr = Curriculum::select('id', 'subject_id')->find($snapshot['curriculum_id']);
                    if ($curr && $curr->subject_id) {
                        $subjectId = $curr->subject_id;
                    }
                } catch (\Exception $e) {
                    // ignore
                }
            }

            if (!isset($subjects[$subjectId])) {
                // try to find subject name
                $name = null;
                try {
                    if ($subjectId) {
                        $subj = Subject::select('id', 'title')->find($subjectId);
                        $name = $subj->title ?? null;
                    }
                } catch (\Exception $e) {
                    $name = null;
                }

                $subjects[$subjectId] = [
                    'id' => $subjectId,
                    'name' => $name,
                    'correct' => 0,
                    'total' => 0,
                ];
            }

            $subjects[$subjectId]['total'] += 1;
            if ($isCorrect) {
                $subjects[$subjectId]['correct'] += 1;
            }
        }

        // compute percent and format subjects
        $subjectsOut = [];
        foreach ($subjects as $s) {
            $percent = $s['total'] > 0 ? round(($s['correct'] / $s['total']) * 100, 2) : 0;
            $subjectsOut[] = [
                'id' => $s['id'],
                'name' => $s['name'],
                'correct' => $s['correct'],
                'total' => $s['total'],
                'percent' => $percent,
            ];
        }

        $scorePercent = $totalQuestions > 0 ? round(($totalCorrect / $totalQuestions) * 100, 2) : 0;

        $result = [
            'result_id' => 'res_' . now()->format('Ymd') . '_' . $attempt->id,
            'attempt_id' => $attempt->attempt_id,
            'week_id' => $attempt->week_id,
            'score' => (int) $scorePercent,
            'raw_score' => (int) $totalCorrect,
            'total' => (int) $totalQuestions,
            'submitted_at' => optional($attempt->submitted_at)->toISOString(),
            'status' => $status,
            'subjects' => $subjectsOut,
            'questions' => $questionsOut,
        ];

        return response()->json($result);
    }

    /**
     * Return all assessment attempts for the authenticated user.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $perPage = (int) $request->query('per_page', 20);
        $page = (int) $request->query('page', 1);

        // ensure the paginator uses the requested page
        \Illuminate\Pagination\Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        // use withCount to avoid loading all answers; compute correct via conditional count
        $attempts = AssessmentAttempt::where('user_id', $user->id)
            ->withCount([
                'answers as total_questions',
                'answers as correct' => function ($q) {
                    $q->where('is_correct', 1);
                }
            ])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        // transform the paginated items
        $attempts->getCollection()->transform(function ($a) {
            $meta = is_array($a->meta) ? $a->meta : (is_string($a->meta) ? json_decode($a->meta, true) : (array) $a->meta);
            $status = isset($meta['scored_at']) ? 'ready' : 'processing';

            $total = intval($a->total_questions ?? 0);
            $correct = intval($a->correct ?? 0);
            $percent = $total > 0 ? round(($correct / $total) * 100, 2) : 0;

            return [
                'id' => $a->id,
                'attempt_id' => $a->attempt_id,
                'week_id' => $a->week_id,
                'submitted_at' => optional($a->submitted_at)->toISOString(),
                'status' => $status,
                'total_questions' => $total,
                'correct' => $correct,
                'percent' => $percent,
            ];
        });

        return response()->json(['status' => true, 'data' => $attempts]);
    }
}
