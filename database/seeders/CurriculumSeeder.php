<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Curriculum;
use App\Models\CurriculumTopic;
use App\Models\Week;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Period;
use App\Models\Term;

class CurriculumSeeder extends Seeder
{
    public function run()
    {
        // pick first grade/subject/period/term as sample targets
        $grade = Grade::first();
        $subject = Subject::first();
        $period = Period::first();
        $term = Term::first();

        if (! $grade || ! $subject || ! $period || ! $term) {
            // nothing to seed against
            return;
        }

        $curriculum = Curriculum::create([
            'name' => $subject->title . ' Curriculum',
            'grade_id' => $grade->id,
            'subject_id' => $subject->id,
            'period_id' => $period->id,
            'term_id' => $term->id,
            'description' => 'Auto-generated curriculum for seeding',
            'author_id' => 1,
        ]);

        // Ensure there are 13 weeks for the given period/term
        $weeks = [];
        for ($i = 1; $i <= 13; $i++) {
            $week = Week::create([
                'start_date' => now()->addWeeks($i - 1)->startOfWeek(),
                'end_date' => now()->addWeeks($i - 1)->endOfWeek(),
                'period_id' => $period->id,
                'term_id' => $term->id,
                'author_id' => 1,
            ]);
            $weeks[] = $week;
        }

        // create one topic per week
        foreach ($weeks as $idx => $week) {
            CurriculumTopic::create([
                'curriculum_id' => $curriculum->id,
                'week_id' => $week->id,
                'title' => sprintf('Week %d: Topic for %s', $idx + 1, $subject->title),
                'objectives' => 'Understand the basics',
                'bloom_level' => 'Knowledge',
                'resources' => null,
                'author_id' => 1,
            ]);
        }
    }
}
