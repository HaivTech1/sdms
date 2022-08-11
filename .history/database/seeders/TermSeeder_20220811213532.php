<?php

namespace Database\Seeders;

use App\Models\Term;
use Illuminate\Database\Seeder;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grade = collect([
            $this->createGrade(
                'Basic 1',
            ),
            $this->createGrade(
                'Basic 2',
            ),
            $this->createGrade(
                'Basic 3',
            ),
            $this->createGrade(
                'Basic 4',
            ),
            $this->createGrade(
                'Basic 5',
            ),
            $this->createGrade(
                'JSS 1',
            ),
            $this->createGrade(
                'JSS 2',
            ),
            $this->createGrade(
                'JSS 3',
            ),
            $this->createGrade(
                'SSS 1',
            ),
            $this->createGrade(
                'SSS 2',
            ),
            $this->createGrade(
                'SSS 3',
            ),
        ]);
    }

    private function createGrade(string $title)
    {
        return Term::factory()->create(compact('title'));
    }
}