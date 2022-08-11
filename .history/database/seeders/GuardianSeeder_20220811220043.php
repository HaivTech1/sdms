<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Guardian;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class GuardianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = Student::all();

        $students->each(function ($students) {
            Guardian::factory()
                ->count(1)
                ->state(new Sequence(
                    fn () => [
                        'student_id'         => $students->random()->id,
                    ],
                ))
                ->create();
        });
    }
}