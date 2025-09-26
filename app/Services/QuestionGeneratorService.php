<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class QuestionGeneratorService
{
    /**
     * Generate questions for a topic using OpenAI Chat API.
     *
     * @param string $topicTitle
     * @param string $topicObjectives
     * @param int $count
     * @param array $options Additional options like 'difficulty' or 'bloom_levels'
     * @return array An array of question objects: [ ['question' => '', 'options'=>[], 'correct_index' => 0, 'difficulty'=>'', 'bloom_level' => ''] ... ]
     * @throws \RuntimeException on failure
     */

    public function generateForTopic(string $topicTitle, string $topicObjectives = '', int $count = 5, array $options = []): array
    {
        $apiKey = get_settings('openai_api_key');
        if (empty($apiKey)) {
            throw new \RuntimeException('OpenAI API key not configured (OPENAI_API_KEY).');
        }

        if($options['openai_key'] ?? false) {
            $apiKey = $options['openai_key'];
        }

        $model = get_settings('openai_model');

        if($options['model'] ?? false) {
            $model = $options['model'];
        }


        // Construct prompt asking for strict JSON array output using SYSTEM/USER pattern required by the product
        $system = "You are an expert K-12 assessment writer. Produce objective, grade-appropriate multiple-choice questions when asked.";

        // Accept optional parameters from $options
        $grade = $options['grade'] ?? null;
        $subject = $options['subject'] ?? null;
        $week = $options['week'] ?? null;
        $types = $options['types'] ?? 'MCQ';
        $difficultyMix = $options['difficulty_mix'] ?? 'balanced';

        // JSON schema the model must follow
        $jsonSchema = '{"question": "string", "options": ["string"], "correct_index": 0, "difficulty": "easy|medium|hard", "bloom_level": "Remember|Understand|Apply|Analyze|Evaluate|Create", "explanation": "short string"}';

    $userPrompt = "Create objective questions for";
        if ($grade) $userPrompt .= " Grade {$grade},";
        if ($subject) $userPrompt .= " Subject {$subject},";
        if ($week) $userPrompt .= " Week {$week},";
        $userPrompt .= " using these objectives:\n";
        $userPrompt .= $topicObjectives ? $topicObjectives . "\n\n" : "\n\n";

    $userPrompt .= "Constraints:\n";
    $userPrompt .= "- Types: {$types} (use multiple-choice questions by default unless teacher requests otherwise)\n";
    $userPrompt .= "- Count: {$count} total; difficulty mix = {$difficultyMix} (sum 100%)\n";
    $userPrompt .= "- Use clear, age-appropriate language suitable for primary and secondary school students (short sentences, simple vocabulary).\n";
    $userPrompt .= "- Exactly one correct option per question. Provide exactly 4 options per question unless impossible for the content.\n";
    $userPrompt .= "- Randomize the order of the answer options for each question. Distribute the correct-option positions across the set of questions so the correct answer is not always at the same index (avoid repeated index patterns).\n";
    $userPrompt .= "- Keep stems 1–2 sentences; avoid trick wording and culturally specific references.\n";
    $userPrompt .= "- Provide a short explanation for the correct answer (1-2 sentences).\n\n";
    $userPrompt .= "Return STRICT JSON only, an array of objects following this schema exactly: \n{$jsonSchema}\nDo not include any markdown, commentary, or extra text.\n";

        $payload = [
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => $system],
                ['role' => 'user', 'content' => $userPrompt],
            ],
            'temperature' => $options['temperature'] ?? 0.2,
            'max_tokens' => $options['max_tokens'] ?? 800,
        ];

        $response = Http::withToken($apiKey)
            ->acceptJson()
            ->timeout(30)
            ->post('https://api.openai.com/v1/chat/completions', $payload);

        if (!$response->successful()) {
            throw new \RuntimeException('OpenAI request failed: ' . $response->status() . ' ' . $response->body());
        }

        $body = $response->json();
        $text = '';
        if (isset($body['choices'][0]['message']['content'])) {
            $text = $body['choices'][0]['message']['content'];
        } elseif (isset($body['choices'][0]['text'])) {
            $text = $body['choices'][0]['text'];
        } else {
            throw new \RuntimeException('OpenAI response did not contain expected content.');
        }

        // Attempt to extract JSON from text
        $json = $this->extractJson($text);
        if ($json === null) {
            // try to decode raw text as JSON
            $decoded = json_decode($text, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \RuntimeException('Failed to parse JSON from OpenAI response: ' . json_last_error_msg());
            }
            $json = $decoded;
        }

        // Validate structure
        if (!is_array($json)) {
            throw new \RuntimeException('OpenAI returned data is not an array.');
        }
    $validated = [];
    $prevCorrectIndex = null;
    // Track how often each index is used for a given option count to balance distribution
    $indexUsage = []; // [optionCount => [index => count]]
    foreach ($json as $item) {
            if (!isset($item['question']) || !isset($item['options']) || !isset($item['correct_index'])) {
                continue; // skip invalid entries
            }

            $questionText = trim($item['question']);
            $optionsList = array_values(array_map('trim', (array) $item['options']));
            $origCorrect = (int) $item['correct_index'];

            // Skip entries with too few options
            if (count($optionsList) < 2) continue;

            // Normalize difficulty/bloom
            $difficulty = $item['difficulty'] ?? 'medium';
            $bloom = $item['bloom_level'] ?? 'Understand';

            // Shuffle options and adjust correct index; attempt to avoid repeating the same correct index as previous
            $optionCount = count($optionsList);
            if (!isset($indexUsage[$optionCount])) {
                $indexUsage[$optionCount] = array_fill(0, $optionCount, 0);
            }

            [$shuffledOptions, $newCorrectIndex] = $this->shuffleOptionsAvoidRepeat($optionsList, $origCorrect, $prevCorrectIndex, $indexUsage[$optionCount]);

            $validated[] = [
                'question' => $questionText,
                'options' => $shuffledOptions,
                'correct_index' => $newCorrectIndex,
                'difficulty' => $difficulty,
                'bloom_level' => $bloom,
            ];

            $prevCorrectIndex = $newCorrectIndex;
            // record usage
            if (isset($indexUsage[$optionCount][$newCorrectIndex])) {
                $indexUsage[$optionCount][$newCorrectIndex]++;
            }
        }

        return $validated;
    }

    /**
     * Shuffle options and return updated correct index. Try multiple times to avoid repeating the same
     * correct index as the previous question when possible.
     *
     * @param array $options
     * @param int $origCorrectIndex
     * @param int|null $prevCorrectIndex
     * @return array [shuffledOptions, newCorrectIndex]
     */
    protected function shuffleOptionsAvoidRepeat(array $options, int $origCorrectIndex, ?int $prevCorrectIndex = null, array $usage = []): array
    {
        $count = count($options);
        // Bound the original correct index
        if ($origCorrectIndex < 0 || $origCorrectIndex >= $count) {
            $origCorrectIndex = 0;
        }

        $correctOption = $options[$origCorrectIndex];

        // If there are only 1 or 2 options, just shuffle once
        $attempts = 0;
        $maxAttempts = 24;
        $best = null;

        // If usage information provided, prefer indices with lower usage
        $preferIndex = null;
        if (!empty($usage) && count($usage) === $count) {
            // pick the least-used index(s)
            $min = min($usage);
            $least = array_keys($usage, $min, true);
            // prefer one of the least used indices that is not prevCorrectIndex
            foreach ($least as $idx) {
                if ($prevCorrectIndex === null || $idx !== $prevCorrectIndex) { $preferIndex = $idx; break; }
            }
            if ($preferIndex === null) {
                // fallback to any least-used index
                $preferIndex = $least[array_rand($least)];
            }
        }

        while ($attempts < $maxAttempts) {
            $shuffled = $options;
            shuffle($shuffled);
            $newIndex = array_search($correctOption, $shuffled, true);
            if ($newIndex === false) {
                array_unshift($shuffled, $correctOption);
                $shuffled = array_values(array_unique($shuffled, SORT_REGULAR));
                $newIndex = array_search($correctOption, $shuffled, true);
            }

            // If we have a preferred index, try to place the correct option there by swapping
            if ($preferIndex !== null && $newIndex !== $preferIndex) {
                // swap positions
                $tmp = $shuffled[$preferIndex];
                $shuffled[$preferIndex] = $correctOption;
                $shuffled[$newIndex] = $tmp;
                $newIndex = $preferIndex;
            }

            // Avoid repeating the same index as previous when possible
            if ($prevCorrectIndex === null || $newIndex !== $prevCorrectIndex) {
                return [array_values($shuffled), (int)$newIndex];
            }

            $best = [array_values($shuffled), (int)$newIndex];
            $attempts++;
        }

        return $best ?? [array_values($options), $origCorrectIndex];
    }

    /**
     * Attempt to extract first JSON array/object from a text blob.
     * Returns decoded value or null when none found.
     */
    protected function extractJson(string $text)
    {
        // Find first { or [ and last matching bracket using simple heuristics
        $start = strpos($text, '{');
        $start2 = strpos($text, '[');
        if ($start2 !== false && ($start === false || $start2 < $start)) {
            $start = $start2;
        }
        if ($start === false) return null;

        $sub = substr($text, $start);
        // Try to balance brackets
        $stack = [];
        $len = strlen($sub);
        $end = null;
        for ($i = 0; $i < $len; $i++) {
            $ch = $sub[$i];
            if ($ch === '{' || $ch === '[') {
                $stack[] = $ch;
            } elseif ($ch === '}' || $ch === ']') {
                if (empty($stack)) break;
                $last = array_pop($stack);
                if (($ch === '}' && $last !== '{') || ($ch === ']' && $last !== '[')) {
                    // mismatched
                    break;
                }
                if (empty($stack)) { $end = $i; break; }
            }
        }

        if ($end === null) return null;
        $jsonText = substr($sub, 0, $end + 1);
        $decoded = json_decode($jsonText, true);
        if (json_last_error() === JSON_ERROR_NONE) return $decoded;
        return null;
    }
}
