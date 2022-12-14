<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Guardian;
use Illuminate\Database\Seeder;

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

        $students->each(function ($student) {
            Guardian::factory()->count(1)->create(['student_id' => $student->id()]);
        });
    }
}