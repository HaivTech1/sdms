<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class OpenAICommentService
{
    protected string $apiKey;
    protected string $model;
    protected string $endpoint = 'https://api.openai.com/v1/chat/completions';

    public function __construct(?string $apiKey = null, ?string $model = null)
    {
        $this->apiKey = $apiKey ?? config('services.openai.key') ?? env('OPENAI_API_KEY');
        $this->model  = $model ?? config('services.openai.model') ?? env('OPENAI_MODEL', 'gpt-4o-mini');
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
     * @return string generated comment (fallback local comment on failure)
     */
    public function generateComment(array $student, array $subjects, array $options = []): string
    {
        // Basic local fallback generator which also considers prev_score if provided
        $localFallback = function () use ($student, $subjects, $options) {
            $coll = collect($subjects)->map(function ($s) {
                $s['score'] = isset($s['score']) ? (float) $s['score'] : 0;
                $s['prev_score'] = array_key_exists('prev_score', $s) && $s['prev_score'] !== null ? (float) $s['prev_score'] : null;
                $s['delta'] = $s['prev_score'] !== null ? round($s['score'] - $s['prev_score'], 2) : null;
                return $s;
            });

            $top = $coll->sortByDesc('score')->slice(0, 2)->pluck('title')->join(', ');
            $weak = $coll->sortBy('score')->slice(0, 2)->pluck('title')->join(', ');
            $improved = $coll->filter(fn($s) => $s['delta'] !== null && $s['delta'] > 0)->sortByDesc('delta')->take(2)->pluck('title')->join(', ');
            $declined = $coll->filter(fn($s) => $s['delta'] !== null && $s['delta'] < 0)->sortBy('delta')->take(2)->pluck('title')->join(', ');

            $pos = isset($student['position']) ? " and is currently placed {$student['position']}" : '';
            $sentences = [];

            $sentences[] = "{$student['name']} has shown good effort this {$student['term']} term{$pos}.";
            if ($top) $sentences[] = "Strengths: {$top}.";
            if ($weak) $sentences[] = "Areas for improvement: {$weak}.";
            if ($improved) $sentences[] = "Notable improvement seen in: {$improved}.";
            if ($declined) $sentences[] = "Decline observed in: {$declined}.";
            $sentences[] = "Recommended: regular revision, targeted practice in weak subjects and reading for comprehension.";
            return implode(' ', $sentences);
        };

        if (empty($this->apiKey)) {
            return $localFallback();
        }

        // Build prompt
        $maxSentences = (int) ($options['max_sentences'] ?? 6);
        $tone = $options['tone'] ?? 'positive, encouraging and professional';

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

        $userContent = "Generate a concise report comment for a primary school student's term result.\n\n"
            . "Constraints:\n"
            . "- Tone: {$tone}.\n"
            . "- Keep the comment to at most {$maxSentences} sentences.\n"
            . "- Start with the student's name.\n"
            . "- Mention 1-2 specific strengths and 1-2 specific areas for improvement (use subject names).\n"
            . "- Suggest 2 practical, actionable tips for the parent/guardian or student.\n"
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
            . "If a subject score is below 50%, treat it as a weak area.\n"
            . "Where previous term score is provided for a subject, compare current vs previous: state whether the student improved or declined and by how many points (absolute), but keep it concise.\n"
            . "If a subject shows a large drop (>10 points) call it out gently and recommend targeted support.\n"
            . "Return the comment in English and keep it to plain text only (no JSON or metadata).";

        $messages = [
            ['role' => 'system', 'content' => 'You are an experienced and kind primary school teacher who writes concise, constructive report comments.'],
            ['role' => 'user', 'content' => $userContent],
        ];

        try {
            $payload = [
                'model' => $this->model,
                'messages' => $messages,
                'temperature' => $options['temperature'] ?? 0.4,
                'max_tokens' => $options['max_tokens'] ?? 300,
            ];

            $response = Http::withToken($this->apiKey)
                ->timeout(20)
                ->post($this->endpoint, $payload);

            if ($response->failed()) {
                return $localFallback();
            }

            $json = $response->json();
            $text = data_get($json, 'choices.0.message.content') ?? data_get($json, 'choices.0.text');

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

            return $comment ?: $localFallback();
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
     * @return array mapping student identifier => comment
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
}