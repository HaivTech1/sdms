<?php

namespace Database\Seeders;

use App\Models\Club;
use Illuminate\Database\Seeder;

class ClubSeeder extends Seeder
{
    public function run()
    {
        $grade = collect([
            $this->createGrade(
                'STREAM',
            ),
            $this->createGrade(
                'Jet Club',
            ),
            $this->createGrade(
                'Press Club',
            ),
            $this->createGrade(
                'Red Cross Club',
            ),
            $this->createGrade(
                'Readers Club',
            ),
            $this->createGrade(
                'Rotaract Club',
            ),
            $this->createGrade(
                'Boys Scout',
            ),
            $this->createGrade(
                'Girls Guide',
            ),
        ]);
    }

    private function createGrade(string $title)
    {
        return Club::factory()->create(compact('title'));
    }
}
