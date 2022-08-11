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
                'Basic 1',
            ),
        ]);
    }

    private function createGrade(string $title)
    {
        return Grade::factory()->create(compact('title'));
    }
}