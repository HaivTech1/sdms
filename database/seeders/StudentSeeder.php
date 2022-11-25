<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::factory()->count(5)->create(['author_id' => 1, 'grade_id' => 1, 'house_id' => 1]);
        Student::factory()->count(5)->create(['author_id' => 1, 'grade_id' => 2, 'house_id' => 2]);
        Student::factory()->count(5)->create(['author_id' => 1, 'grade_id' => 3, 'house_id' => 3]);
        Student::factory()->count(5)->create(['author_id' => 1, 'grade_id' => 4, 'house_id' => 4]);
        Student::factory()->count(5)->create(['author_id' => 1, 'grade_id' => 5, 'house_id' => 1]);
        Student::factory()->count(5)->create(['author_id' => 1, 'grade_id' => 6, 'house_id' => 2]);
        Student::factory()->count(5)->create(['author_id' => 1, 'grade_id' => 7, 'house_id' => 3]);
    }
}