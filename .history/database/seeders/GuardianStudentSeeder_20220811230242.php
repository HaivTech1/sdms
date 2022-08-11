<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class GuardianStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = Student::all();
         
        foreach ($subjects as $subject) {
            $subject->grades()->sync($grades->pluck('id'));
        }
    }
}