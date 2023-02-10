<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
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
                'Kindergertin ',
                1
            ),
            $this->createGrade(
                'Creche',
                1
            ),
            $this->createGrade(
                'Nursery 1',
                1
            ),
            $this->createGrade(
                'Nursery 2',
                1
            ),
            $this->createGrade(
                'Primary 1',
                1
            ),
            $this->createGrade(
                'Primary 2',
                1
            ),
            $this->createGrade(
                'Primary 3',
                1
            ),
            $this->createGrade(
                'Primary 4',
                1
            ),
            $this->createGrade(
                'Primary 5',
                1
            ),
            $this->createGrade(
                'JSS 1',
                1
            ),
            $this->createGrade(
                'JSS 2',
                1
            ),
            $this->createGrade(
                'JSS 3',
                1
            ),
            $this->createGrade(
                'SSS 1',
                1
            ),
            $this->createGrade(
                'SSS 2',
                1
            ),
            $this->createGrade(
                'SSS 3',
                1
            ),
        ]);
    }

    private function createGrade(string $title, bool $status)
    {
        return Grade::factory()->create(compact('title', 'status'));
    }
}