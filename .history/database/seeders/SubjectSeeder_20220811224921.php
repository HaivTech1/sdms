<?php

namespace Database\Seeders;

use App\Models\Subject;
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
        $subject = collect([
            $this->createSubject(
                'Mathematics',
            ),
            $this->createSubject(
                'English Language',
            ),
            $this->createSubject(
                'Civic Education',
            ),
            $this->createSubject(
                'Economics',
            ),
            $this->createSubject(
                'History',
            ),
        ]);
    }

    private function createSubject(string $title)
    {
        return Subject::factory()->create(compact('title'));
    }
}