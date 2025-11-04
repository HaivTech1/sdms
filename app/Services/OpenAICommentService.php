<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\AIResultComment;
use App\Jobs\GenerateAIComments;
use Illuminate\Support\Facades\Log;

class OpenAICommentService
{
    protected string $apiKey;
    protected string $model;
    protected string $endpoint = 'https://api.openai.com/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = get_settings('openai_api_key');
        $this->model =  get_settings('openai_model');
    }

    /**
     * Generate a single comment for a student's results.
     *
     * @param array $student [
     *   'name' => string,
     *   'grade' => string,
     *   'term' => string,
     *   'period' => string,
     *   'total' => int|float,
     *   'average' => int|float,
     *   'position' => string|int|null
     * ]
    * @param array $subjects [
    *   ['title' => 'Mathematics', 'score' => 78, 'out_of' => 100, 'prev_score' => 72], ...
    * ]
     * @param array $options optional keys: tone, max_sentences, include_parent_note (bool)
     *
     * @return array generated comments (one or more variants). Each entry is a plain text comment.
     */
    public function generateComment(array $student, array $subjects, array $options = []): array
    {
        // Enhanced local fallback generator with cognitive and professional language
        $localFallback = function () use ($student, $subjects, $options) {
            $coll = collect($subjects)->map(function ($s) {
                $s['score'] = isset($s['score']) ? (float) $s['score'] : 0;
                $s['prev_score'] = array_key_exists('prev_score', $s) && $s['prev_score'] !== null ? (float) $s['prev_score'] : null;
                $s['delta'] = $s['prev_score'] !== null ? round($s['score'] - $s['prev_score'], 2) : null;
                $s['percentage'] = $s['out_of'] ? round(($s['score'] / $s['out_of']) * 100, 1) : 0;
                return $s;
            });

            // Analyze performance levels
            $excellent = $coll->filter(fn($s) => $s['percentage'] >= 85)->sortByDesc('score');
            $strong = $coll->filter(fn($s) => $s['percentage'] >= 70 && $s['percentage'] < 85)->sortByDesc('score');
            $developing = $coll->filter(fn($s) => $s['percentage'] >= 50 && $s['percentage'] < 70)->sortByDesc('score');
            $needsSupport = $coll->filter(fn($s) => $s['percentage'] < 50)->sortBy('score');
            
            $improved = $coll->filter(fn($s) => $s['delta'] !== null && $s['delta'] > 5)->sortByDesc('delta');
            $declined = $coll->filter(fn($s) => $s['delta'] !== null && $s['delta'] < -5)->sortBy('delta');

            $studentName = $student['name'] ?? 'The student';
            $term = $student['term'] ?? 'term';
            $average = $student['average'] ?? null;
            $position = $student['position'] ?? null;
            
            $sentences = [];

            // Opening statement with clear insight
            if ($average >= 80) {
                $sentences[] = "{$studentName} has performed excellently and shows great understanding in most subjects this {$term}.";
            } elseif ($average >= 70) {
                $sentences[] = "{$studentName} has made good progress and shows solid understanding of important topics this {$term}.";
            } elseif ($average >= 60) {
                $sentences[] = "{$studentName} is making steady progress and shows growing understanding of key subjects this {$term}.";
            } else {
                $sentences[] = "{$studentName} is working hard to learn new topics and needs extra support to improve this {$term}.";
            }

            // Subject strengths
            if ($excellent->count() > 0) {
                $excellentSubjects = $excellent->take(2)->pluck('title')->join(' and ');
                $sentences[] = "Shows excellent understanding and thinking skills in {$excellentSubjects}.";
            } elseif ($strong->count() > 0) {
                $strongSubjects = $strong->take(2)->pluck('title')->join(' and ');
                $sentences[] = "Shows good understanding and steady improvement in {$strongSubjects}.";
            }

            // Areas for development with simple language
            if ($needsSupport->count() > 0) {
                $supportSubjects = $needsSupport->take(2)->pluck('title')->join(' and ');
                $sentences[] = "Needs more practice and help with basic skills in {$supportSubjects}.";
            } elseif ($developing->count() > 0) {
                $developingSubjects = $developing->take(2)->pluck('title')->join(' and ');
                $sentences[] = "Is getting better at {$developingSubjects} but needs more practice.";
            }

            // Learning progression analysis
            if ($improved->count() > 0) {
                $improvedSubject = $improved->first()['title'];
                $delta = $improved->first()['delta'];
                $sentences[] = "Has improved a lot in {$improvedSubject}, showing good learning and effort.";
            }

            if ($declined->count() > 0) {
                $declinedSubject = $declined->first()['title'];
                $sentences[] = "Needs to focus more on {$declinedSubject} to get back to previous good scores.";
            }

            // Simple recommendations
            if ($average >= 75) {
                $sentences[] = "Keep up the good work! Try harder activities and extra reading to learn even more.";
            } elseif ($average >= 60) {
                $sentences[] = "Keep practicing with different activities to get better and feel more confident.";
            } else {
                $sentences[] = "Needs extra help and practice with different ways of learning to improve faster.";
            }

            // Position acknowledgment if available
            if ($position && is_numeric($position)) {
                $ordinal = match((int)$position) {
                    1 => '1st',
                    2 => '2nd', 
                    3 => '3rd',
                    default => $position . 'th'
                };
                $sentences[] = "Is in {$ordinal} position in class, showing good work and effort.";
            }

            return [implode(' ', $sentences)];
        };

        if (empty($this->apiKey)) {
            return $localFallback();
        }

        // Build prompt
        $maxSentences = (int) ($options['max_sentences'] ?? 6);
        $tone = $options['tone'] ?? 'positive, encouraging and professional';
        $variants = max(1, (int) ($options['variants'] ?? 1));

        // Build subject lines including previous score and delta when available for term comparison
        $subjectLines = collect($subjects)
            ->map(function ($s) {
                $title = $s['title'] ?? $s['name'] ?? 'Subject';
                $score = isset($s['score']) ? $s['score'] : 0;
                $outOf = $s['out_of'] ?? 100;
                $line = "- {$title}: {$score}/{$outOf}";
                if (array_key_exists('prev_score', $s) && $s['prev_score'] !== null) {
                    $prev = $s['prev_score'];
                    $delta = round($score - $prev, 2);
                    $sign = $delta > 0 ? '+' : ($delta < 0 ? '' : '');
                    $line .= " (prev: {$prev}, {$sign}{$delta})";
                }
                return $line;
            })
            ->implode("\n");

        $studentName = $student['name'] ?? 'The student';
        $grade = $student['grade'] ?? '';
        $term = $student['term'] ?? '';
        $period = $student['period'] ?? '';
        $total = $student['total'] ?? null;
        $average = $student['average'] ?? null;
        $position = $student['position'] ?? null;

        $userContent = "Generate a friendly, professional report comment for a primary/secondary school student's term result.\n\n"
            . "Constraints:\n"
            . "- Tone: {$tone}, encouraging, and easy to understand.\n"
            . "- Keep the comment to at most {$maxSentences} sentences.\n"
            . "- Start with the student's name and show understanding of their learning journey.\n"
            . "- Use simple, clear language that parents and students can easily understand.\n"
            . "- Focus on what the student does well and what they need to work on (e.g., 'shows good thinking skills' rather than complex terms).\n"
            . "- Mention specific strengths (e.g., good at solving problems, remembers well, understands ideas clearly).\n"
            . "- Give practical, helpful suggestions that parents can understand and help with.\n"
            . "- Use school-friendly language (e.g., 'practice more', 'work on basics', 'keep trying', 'getting better').\n"
            . "- Keep sentences short and clear - avoid long, complex words.\n"
            . "- Do not include any private meta text (timestamps, API keys).\n"
            . "- Output only the comment text (no JSON wrapper, no extra headings).\n\n"
            . "Student details:\n"
            . "Name: {$studentName}\n"
            . "Grade: {$grade}\n"
            . "Term: {$term}\n"
            . "Session/Period: {$period}\n"
            . ($total !== null ? "Total: {$total}\n" : '')
            . ($average !== null ? "Average: {$average}\n" : '')
            . ($position !== null ? "Position: {$position}\n" : '')
            . "\nSubject scores:\n"
            . "{$subjectLines}\n\n"
            . "Analysis Guidelines:\n"
            . "- If a subject score is below 50%, explain what the student needs to work on (e.g., 'needs to practice basic skills more' instead of complex terms).\n"
            . "- For good subjects (>75%), mention what the student does well (e.g., 'great at solving math problems', 'reads and understands stories well').\n"
            . "- When comparing with previous terms, explain simply (e.g., 'getting better at' or 'needs to work harder to get back to good scores').\n"
            . "- For big improvements (>10 points), celebrate the progress and hard work.\n"
            . "- For declines (>10 points), give helpful suggestions without making the student feel bad.\n"
            . "- Give advice that parents can help with at home.\n"
            . "- Use simple, encouraging language that makes sense to families.\n"
            . "Return the comment in English as plain text only (no JSON or metadata).";

        $messages = [
            ['role' => 'system', 'content' => 'You are a friendly, experienced teacher who writes clear, encouraging report comments for primary and secondary school students. Use simple language that students, parents, and families can easily understand.'],
            ['role' => 'user', 'content' => $userContent],
        ];

        try {
            $payload = [
                'model' => $this->model,
                'messages' => $messages,
                'temperature' => $options['temperature'] ?? 0.3,
                'max_tokens' => $options['max_tokens'] ?? 400,
            ];

            if ($variants > 1) {
                // request multiple variants where supported
                $payload['n'] = $variants;
            }

            $response = Http::withToken($this->apiKey)
                ->timeout(20)
                ->post($this->endpoint, $payload);

            if ($response->failed()) {
                return $localFallback();
            }

            $json = $response->json();
            $choices = data_get($json, 'choices', []);

            $comments = [];
            foreach ($choices as $choice) {
                $text = data_get($choice, 'message.content') ?? data_get($choice, 'text');
                if (is_array($text)) {
                    $text = implode("\n", $text);
                }

                // Trim and sanitize whitespace
                $comment = Str::of($text)->trim()->replaceMatches('/\s+/', ' ')->__toString();

                // Ensure short output: truncate to maxSentences if model returns long text
                $sentences = preg_split('/(?<=[.?!])\s+/', $comment, -1, PREG_SPLIT_NO_EMPTY);
                if (count($sentences) > $maxSentences) {
                    $comment = implode(' ', array_slice($sentences, 0, $maxSentences));
                }

                if (!empty($comment)) {
                    $comments[] = $comment;
                }
            }

            // If API returned nothing useful, fall back
            if (empty($comments)) {
                return $localFallback();
            }

            return $comments;
        } catch (\Throwable $e) {
            // on any error fall back to local generator
            return $localFallback();
        }
    }

    /**
     * Generate comments for multiple students (throttled).
     *
     * @param array $students array of ['student' => [...], 'subjects' => [...]]
     * @param array $options passed to generateComment
     * @return array mapping student identifier => array of comments
     */
    public function generateBulkComments(array $students, array $options = []): array
    {
        $results = [];
        foreach ($students as $key => $item) {
            $student = $item['student'] ?? [];
            $subjects = $item['subjects'] ?? [];
            $results[$key] = $this->generateComment($student, $subjects, $options);
            // small pause to be polite with API; adjust as needed
            usleep(150_000); // 150ms
        }
        return $results;
    }

    /**
     * Create a pending AIResultComment record and dispatch a queued job to generate it.
     *
     * @param string $studentUuid
     * @param int $periodId
     * @param int $termId
     * @param string $resultType
     * @param array $payload minimal payload containing 'student' and 'subjects' used by the job
     * @param int|null $authorId
     * @param array $options passed to the generator
     * @return AIResultComment the placeholder record
     */
    public function createAndDispatch(string $studentUuid, int $periodId, int $termId, string $resultType, array $payload = [], ?int $authorId = null, array $options = []): AIResultComment
    {
        // Create a placeholder record with status 'pending' and store the payload in notes
        $record = AIResultComment::create([
            'student_uuid' => $studentUuid,
            'period_id' => $periodId,
            'term_id' => $termId,
            'result_type' => $resultType,
            'author_id' => $authorId,
            'status' => 'pending',
            'notes' => is_array($payload) ? json_encode($payload) : $payload,
        ]);

        // Dispatch the queued job to generate the comment asynchronously
        GenerateAIComments::dispatch($studentUuid, $periodId, $termId, $resultType, $authorId, $options);

        return $record;
    }

    /**
     * Convenience wrapper for teachers to generate a preview comment synchronously
     * without persisting it. Returns an array with the comment and some metadata.
     *
     * @param array $student
     * @param array $subjects
     * @param array $options
     * @return array ['comments' => array, 'model' => string, 'generated_at' => string]
     */
    public function previewComment(array $student, array $subjects, array $options = []): array
    {
        $comments = $this->generateComment($student, $subjects, $options);

        return [
            'comments' => $comments,
            'generated_at' => now()->toDateTimeString(),
        ];
    }
}