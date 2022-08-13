<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class GradeSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = Subject::all(); 
        $students = Student::all();
         
        foreach ($students as $student) {
            $student->subjects()->sync($subjects->pluck('id'));
        }
    }
}