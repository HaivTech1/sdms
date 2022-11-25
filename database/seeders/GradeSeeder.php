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
            ),
            $this->createGrade(
                'Creche',
            ),
            $this->createGrade(
                'Nursery 1',
            ),
            $this->createGrade(
                'Nursery 2',
            ),
            $this->createGrade(
                'Primary 1',
            ),
            $this->createGrade(
                'Primary 2',
            ),
            $this->createGrade(
                'Primary 3',
            ),
            $this->createGrade(
                'Primary 4',
            ),
            $this->createGrade(
                'Primary 5',
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
        return Grade::factory()->create(compact('title'));
    }
}