<?php

namespace Database\Seeders;

use App\Models\Psychomotor;
use Illuminate\Database\Seeder;

class PsychomotorSeeder extends Seeder
{
    public function run()
    {
        $grade = collect([
            $this->createGrade(
                'Attentiveness',
            ),
            $this->createGrade(
                'Honesty',
            ),
            $this->createGrade(
                'Neatness',
            ),
            $this->createGrade(
                'Politeness',
            ),
            $this->createGrade(
                'Punctuality',
            ),
            $this->createGrade(
                'Confidence',
            ),
            $this->createGrade(
                'Attitude',
            ),
        ]);
    }

    private function createGrade(string $title)
    {
        return Psychomotor::factory()->create(compact('title'));
    }
}
