<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $term = collect([
            $this->createTerm(
                'Mathematics',
            ),
            $this->createTerm(
                'English Language',
            ),
            $this->createTerm(
                'Civic Education',
            ),
            $this->createTerm(
                'Economics',
            ),
            $this->createTerm(
                'Economics',
            ),
        ]);
    }

    private function createTerm(string $title)
    {
        return Term::factory()->create(compact('title'));
    }
}