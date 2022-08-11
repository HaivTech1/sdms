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
                'First Term',
            ),
            $this->createTerm(
                'Second Term',
            ),
            $this->createTerm(
                'Third Term',
            ),
        ]);
    }

    private function createTerm(string $title)
    {
        return Term::factory()->create(compact('title'));
    }
}