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
                'First Term',
            ),
            $this->createGrade(
                'Second Term',
            ),
            $this->createGrade(
                'Third Term',
            ),
        ]);
    }

    private function createGrade(string $title)
    {
        return Term::factory()->create(compact('title'));
    }
}