<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    
    public function run()
    {
        Student::factory()->count(5)->create(['author_id' => 1, 'grade_id' => 10, 'house_id' => 1]);
        // Student::factory()->count(5)->create(['author_id' => 1, 'grade_id' => 11, 'house_id' => 2]);
        // Student::factory()->count(5)->create(['author_id' => 1, 'grade_id' => 12, 'house_id' => 3]);
        // Student::factory()->count(5)->create(['author_id' => 1, 'grade_id' => 13, 'house_id' => 4]);
        // Student::factory()->count(5)->create(['author_id' => 1, 'grade_id' => 14, 'house_id' => 1]);
        // Student::factory()->count(5)->create(['author_id' => 1, 'grade_id' => 15, 'house_id' => 2]);
    }
}